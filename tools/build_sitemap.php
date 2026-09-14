<?php
/**
 * Generates public_html/sitemap.xml from routes.php and SITE_URL.
 *
 * THE SITEMAP IS NOT WRITTEN BY HAND AND NO ADDRESS IN IT IS TYPED. Every
 * <loc> is SITE_URL + url(), which is the same pair that produces the
 * canonical link in head.php — so a sitemap entry and the canonical tag on the
 * page it points at cannot disagree, and pointing the site at another host is
 * one edit in private/config.php followed by a re-run of this script.
 *
 *     php tools/build_sitemap.php
 *
 * WHICH PAGES. Everything in routes.php except:
 *
 *   - DEV_ONLY_PAGES  styleguide, components — with DEV = false these answer
 *                     404, so listing them would be advertising a dead address
 *   - 404             has no route at all and is unreachable by URL
 *
 * EVERYTHING ELSE IS IN, /privacy AND /terms INCLUDED. They are public,
 * indexable and carry canonical tags like any other page, so leaving them out
 * made the sitemap disagree with the site about what is indexable. Eleven
 * addresses, which is every route that answers 200 in production.
 *
 * lastmod is the content file's own mtime, which is the only honest date
 * available: it is when the page's text last changed. No changefreq and no
 * priority — both are hints every major crawler has said it ignores, and a
 * number nobody reads is a number that goes stale without anybody noticing.
 */

declare(strict_types=1);

$root = dirname(__DIR__);

require $root . '/private/config.php';

define('PUBLIC_PATH', $root . '/public_html');
define('CONTENT_PATH', PUBLIC_PATH . '/content');

$routes = require PUBLIC_PATH . '/app/routes.php';

/** Routed but answering 404 in production — see DEV_ONLY_PAGES in helpers.php. */
const DEV_ONLY = ['styleguide', 'components'];

$lang = DEFAULT_LANG;
$base = rtrim(SITE_URL, '/');

$entries = [];

foreach ($routes as $pageId => $slugs) {
    if (in_array($pageId, DEV_ONLY, true)) {
        continue;
    }

    if (!isset($slugs[$lang])) {
        continue;
    }

    $slug = (string) $slugs[$lang];
    $loc  = $base . '/' . $slug;          // home has an empty slug, so this is $base . '/'

    $contentFile = CONTENT_PATH . '/' . $lang . '/' . $pageId . '.php';
    $lastmod     = is_file($contentFile) ? date('Y-m-d', (int) filemtime($contentFile)) : null;

    $entries[] = ['loc' => $loc, 'lastmod' => $lastmod, 'page_id' => $pageId];
}

$xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

foreach ($entries as $entry) {
    $xml .= "    <url>\n";
    $xml .= '        <loc>' . htmlspecialchars($entry['loc'], ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</loc>\n";

    if ($entry['lastmod'] !== null) {
        $xml .= '        <lastmod>' . $entry['lastmod'] . "</lastmod>\n";
    }

    $xml .= "    </url>\n";
}

$xml .= '</urlset>' . "\n";

$target = PUBLIC_PATH . '/sitemap.xml';
file_put_contents($target, $xml);

fwrite(STDERR, "wrote {$target}\n");
fwrite(STDERR, 'SITE_URL: ' . SITE_URL . "\n");
fwrite(STDERR, count($entries) . " urls:\n");

foreach ($entries as $entry) {
    fwrite(STDERR, '  ' . str_pad($entry['page_id'], 12) . $entry['loc'] . "\n");
}
