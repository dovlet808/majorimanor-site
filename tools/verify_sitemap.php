<?php
/**
 * Checks a sitemap against the site it claims to describe, by rendering it.
 *
 *     php tools/verify_sitemap.php [path/to/sitemap.xml]
 *
 * Exit 0 and one summary line when the sitemap is right; exit 1 and a report
 * naming every disagreement when it is not. deploy/_common.sh runs this on
 * every build — see mm_sitemap() there for where it sits in the sequence.
 *
 * WHAT IS ACTUALLY COMPARED. Not the sitemap against build_sitemap.php, which
 * would only prove that a script agrees with itself. Every <loc> is REQUESTED
 * through public_html/index.php exactly as a crawler would request it, and the
 * canonical the page renders has to come back character for character equal to
 * the address that was asked for.
 *
 * That is the pair a crawler compares. A sitemap entry whose page names a
 * different canonical is not a formatting problem: the crawler follows the
 * canonical, drops the address it was given, and the entry has cost a crawl and
 * bought nothing. Everything that can cause it — a stale sitemap left behind
 * after SITE_URL changed, a trailing slash on SITE_URL that the generator trims
 * and head.php does not, a route whose slug moved — shows up as the same
 * mismatch here, without this file needing to know which one happened.
 *
 * THE COMPARISON IS ON THE DECODED URL, and that is not a loosening. The two
 * strings are escaped for different documents: the sitemap holds XML, so
 * build_sitemap.php runs the address through htmlspecialchars with ENT_XML1,
 * and the canonical sits in an HTML attribute escaped by e(). Comparing the
 * raw bytes would call &amp; and &#38; a mismatch when both are one ampersand
 * in the address. Each is decoded by the rules of its own document and the
 * addresses themselves are then compared byte for byte.
 *
 * THE SET IS CHECKED TOO. Every route that answers 200 must be in the file
 * once, and nothing else may be — DEV_ONLY_PAGES is read from helpers.php,
 * which is where the site itself reads it, so a page that becomes public
 * without the sitemap following is a refusal rather than a page nobody finds.
 *
 * EACH PAGE IS RENDERED IN ITS OWN PROCESS. bootstrap.php defines its paths
 * with define(), so a second include in the same process is a fatal error.
 * This file re-invokes itself with --render to do it; that mode is not for
 * anyone to call by hand.
 */

declare(strict_types=1);

$root = dirname(__DIR__);

// ---------------------------------------------------------------------------
// Child mode: render one address and print the page. Nothing else may run
// before index.php here — bootstrap.php owns the constants.
// ---------------------------------------------------------------------------

if (($argv[1] ?? '') === '--render') {
    $_SERVER['REQUEST_URI']    = (string) ($argv[2] ?? '/');
    $_SERVER['REQUEST_METHOD'] = 'GET';

    require $root . '/public_html/index.php';
    exit(0);
}

// ---------------------------------------------------------------------------
// Parent
// ---------------------------------------------------------------------------

require $root . '/private/config.php';

define('PUBLIC_PATH', $root . '/public_html');
define('APP_PATH', PUBLIC_PATH . '/app');

/* For DEV_ONLY_PAGES, routes() and url() — the same definitions the site uses,
   rather than a second copy of them kept in step by hand. */
require APP_PATH . '/helpers.php';

$sitemapFile = $argv[1] ?? (PUBLIC_PATH . '/sitemap.xml');

$problems = [];   // lines of the report, printed only when there are any
$lines    = [];   // the per-address table, printed under the problems

/**
 * Request $path through index.php and return the canonical it rendered.
 *
 * @return array{canonical: ?string, output: string}
 *         canonical is null when the page rendered none — which is what a
 *         noindex page does, and is a finding rather than an accident.
 */
function render_canonical(string $path): array
{
    $command = escapeshellarg(PHP_BINARY)
        . ' ' . escapeshellarg(__FILE__)
        . ' --render ' . escapeshellarg($path)
        . ' 2>&1';

    $output = (string) shell_exec($command);

    if (!preg_match('#<link\s+rel="canonical"\s+href="([^"]*)"\s*/?>#i', $output, $match)) {
        return ['canonical' => null, 'output' => $output];
    }

    return [
        'canonical' => html_entity_decode($match[1], ENT_QUOTES | ENT_HTML5, 'UTF-8'),
        'output'    => $output,
    ];
}

// ---- read the sitemap -----------------------------------------------------

if (!is_file($sitemapFile)) {
    fwrite(STDERR, "no sitemap at {$sitemapFile}\n");
    exit(1);
}

$document = (string) file_get_contents($sitemapFile);

/*
   READ WITH A REGEX AND NOT WITH SIMPLEXML, on purpose. This PHP build has
   libxml but neither the dom nor the simplexml extension, and a build that
   refuses to run unless an optional extension happens to be compiled in is a
   build that stops working on the next machine. The shape being read is not
   arbitrary XML off the wire: it is what build_sitemap.php wrote, forty lines
   up, with one <loc> per line and no namespaces, comments or CDATA in it.

   The structural counts below are the floor that costs nothing: <url> opens
   and closes have to balance and each one has to carry exactly one <loc>. It
   is not a validator, and it does not need to be — the addresses themselves
   are checked against the running site, which is a far stronger statement than
   any schema makes.
*/
preg_match_all('#<loc>(.*?)</loc>#s', $document, $matches);

$locs = array_map(
    static fn (string $raw): string => html_entity_decode($raw, ENT_QUOTES | ENT_XML1, 'UTF-8'),
    $matches[1]
);

$opens  = preg_match_all('#<url>#', $document);
$closes = preg_match_all('#</url>#', $document);

if (!str_contains($document, '<urlset') || !str_contains($document, '</urlset>')) {
    fwrite(STDERR, "{$sitemapFile} has no <urlset> element — this is not a sitemap.\n");
    exit(1);
}

if ($opens !== $closes || $opens !== count($locs)) {
    fwrite(STDERR, "{$sitemapFile} is malformed:\n");
    fwrite(STDERR, "  <url> opened {$opens} times, closed {$closes} times, " . count($locs) . " <loc> found\n");
    exit(1);
}

if ($locs === []) {
    fwrite(STDERR, "{$sitemapFile} contains no <loc> elements.\n");
    exit(1);
}

// ---- what the routing table says should be in there -----------------------

$expected = [];   // page_id => the path the site would build for it

foreach (routes() as $pageId => $slugs) {
    if (in_array($pageId, DEV_ONLY_PAGES, true) || !isset($slugs[DEFAULT_LANG])) {
        continue;
    }

    $expected[$pageId] = url($pageId, DEFAULT_LANG);
}

/** The address each <loc> points at, reduced to its path. */
$paths = [];

foreach ($locs as $loc) {
    $path = parse_url($loc, PHP_URL_PATH);

    $paths[] = is_string($path) && $path !== '' ? $path : '/';
}

/*
   THE SET IS CHECKED ON PATHS AND THE ADDRESSES ARE CHECKED BELOW, and keeping
   the two apart is what makes the report readable. Comparing whole addresses
   here as well would mean a single wrong host — the commonest failure there is
   — reported three times over as eleven missing routes, eleven unknown
   addresses and eleven mismatches. Which pages are listed is one question;
   whether each address is right is another; each is answered once.
*/

// ---- the set: nothing missing, nothing extra, nothing twice ---------------

foreach (array_count_values($paths) as $path => $count) {
    if ($count > 1) {
        $problems[] = "DUPLICATE  {$path}  (listed {$count} times)";
    }
}

foreach ($expected as $pageId => $path) {
    if (!in_array($path, $paths, true)) {
        $problems[] = "MISSING    {$path}  (route '{$pageId}' answers 200 and is not in the sitemap)";
    }
}

foreach (array_unique($paths) as $path) {
    if (!in_array($path, $expected, true)) {
        $problems[] = "UNKNOWN    {$path}  (no route in routes.php builds this path)";
    }
}

// ---- the addresses: each one rendered, canonical compared -----------------

foreach ($locs as $index => $loc) {
    $path     = $paths[$index];
    $rendered = render_canonical($path);

    if ($rendered['canonical'] === null) {
        $problems[] = "NO CANONICAL  {$loc}";
        $problems[] = "      requested  {$path}";
        $problems[] = '      the page rendered no <link rel="canonical"> — a 404 or a noindex page';
        $lines[]    = ['status' => 'NO CANON', 'loc' => $loc];
        continue;
    }

    if ($rendered['canonical'] !== $loc) {
        $problems[] = "MISMATCH   {$path}";
        $problems[] = "      <loc>      {$loc}";
        $problems[] = "      canonical  {$rendered['canonical']}";
        $lines[]    = ['status' => 'MISMATCH', 'loc' => $loc];
        continue;
    }

    $lines[] = ['status' => 'ok', 'loc' => $loc];
}

// ---- report ---------------------------------------------------------------

if ($problems !== []) {
    fwrite(STDERR, 'sitemap:   ' . $sitemapFile . "\n");
    fwrite(STDERR, 'SITE_URL:  ' . SITE_URL . "\n");
    fwrite(STDERR, "\n");

    foreach ($problems as $problem) {
        fwrite(STDERR, '  ' . $problem . "\n");
    }

    /* The full table only when some addresses came back right: it is there to
       show what was checked and passed, and when nothing passed it is the list
       above a second time. */
    if (in_array('ok', array_column($lines, 'status'), true)) {
        fwrite(STDERR, "\n");

        foreach ($lines as $line) {
            fwrite(STDERR, sprintf('  %-10s %s', $line['status'], $line['loc']) . "\n");
        }
    }

    exit(1);
}

echo count($locs), " urls, every <loc> equal to the canonical its page renders\n";
exit(0);
