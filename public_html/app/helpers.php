<?php
/**
 * Helpers available to every template.
 *
 * Templates must never contain a human-readable string or a hardcoded URL:
 * text comes from content/<lang>/ through $c and t(), addresses from url().
 */

declare(strict_types=1);

/** Pages that never appear in the main navigation. */
const NAV_EXCLUDE = ['home', 'membership', 'privacy', 'terms', 'styleguide', 'components'];

/**
 * Pages that exist only while DEV is on. index.php drops them before any
 * content is loaded, so with DEV = false the address is a real 404 and the
 * page is not merely hidden. head.php also marks them noindex, and their
 * templates send X-Robots-Tag, for the case where DEV is left on somewhere
 * it should not be.
 */
const DEV_ONLY_PAGES = ['styleguide', 'components'];

/** The single accent action in the header. */
const NAV_ACCENT = 'membership';

/**
 * The footer's one row of links, in this order.
 * Not only the legal pages: Contact and Membership are the two things a
 * reader who has got that far is looking for.
 */
const FOOTER_LINKS = ['contact', 'membership', 'privacy', 'terms'];

/** Page colour temperatures; anything else falls back to the first. */
const MOODS = ['day', 'dusk', 'night'];

// ---------------------------------------------------------------------------
// Request state
// ---------------------------------------------------------------------------

/**
 * Holds what the current request resolved to. index.php writes it once,
 * the helpers below read it.
 *
 * @param array|null $set ['lang' => …, 'page_id' => …, 't' => […], 'c' => […]]
 */
function ctx(?array $set = null): array
{
    static $ctx = ['lang' => null, 'page_id' => null, 't' => [], 'c' => []];

    if ($set !== null) {
        $ctx = $set + $ctx;
    }

    return $ctx;
}

function current_lang(): string
{
    return ctx()['lang'] ?? DEFAULT_LANG;
}

function current_page(): string
{
    return ctx()['page_id'] ?? 'home';
}

// ---------------------------------------------------------------------------
// Routes
// ---------------------------------------------------------------------------

/** @return array<string, array<string, string>> */
function routes(): array
{
    static $routes = null;

    if ($routes === null) {
        $routes = require APP_PATH . '/routes.php';
    }

    return $routes;
}

/**
 * Every language the routing table knows about, active or not.
 * Used to tell a language prefix apart from a page slug.
 *
 * @return string[]
 */
function known_langs(): array
{
    static $langs = null;

    if ($langs === null) {
        $seen = [];
        foreach (routes() as $slugs) {
            foreach (array_keys($slugs) as $lang) {
                $seen[$lang] = true;
            }
        }
        $langs = array_keys($seen);
    }

    return $langs;
}

/** Reverse lookup: slug ('' for home) → page id, or null when unknown. */
function page_id_for_slug(string $slug, string $lang): ?string
{
    foreach (routes() as $pageId => $slugs) {
        if (isset($slugs[$lang]) && $slugs[$lang] === $slug) {
            return $pageId;
        }
    }

    return null;
}

/**
 * Main navigation, in routing-table order minus the pages that do not belong.
 *
 * @return string[]
 */
function nav_pages(): array
{
    return array_values(array_diff(array_keys(routes()), NAV_EXCLUDE));
}

// ---------------------------------------------------------------------------
// Output
// ---------------------------------------------------------------------------

/** Escape for HTML. Called on every single echo of a dynamic value. */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Build a path from routes.php. Never hardcode an address anywhere else.
 *
 *   url('home')            → /
 *   url('estate')          → /the-estate
 *   url('estate', 'lv')    → /lv/muiza
 *
 * The default language lives at the root and gets no prefix.
 */
function url(string $pageId, ?string $lang = null): string
{
    $lang   = $lang ?? current_lang();
    $routes = routes();

    if (!isset($routes[$pageId][$lang])) {
        if (DEV) {
            trigger_error("url(): no route for page '{$pageId}' in '{$lang}'", E_USER_WARNING);
        }

        return '/';
    }

    $prefix = $lang === DEFAULT_LANG ? '' : '/' . $lang;
    $slug   = $routes[$pageId][$lang];

    if ($slug === '') {
        return $prefix === '' ? '/' : $prefix . '/';
    }

    return $prefix . '/' . $slug;
}

/**
 * An interface string from content/<lang>/common.php. Dot notation walks the
 * array: t('nav.estate') reads $t['nav']['estate'].
 *
 * In DEV a missing key renders as "[[missing: key]]" so gaps are visible;
 * in production it renders as nothing.
 */
function t(string $key): string
{
    $node = ctx()['t'];

    foreach (explode('.', $key) as $part) {
        if (!is_array($node) || !array_key_exists($part, $node)) {
            return DEV ? "[[missing: {$key}]]" : '';
        }
        $node = $node[$part];
    }

    return is_string($node) ? $node : (DEV ? "[[missing: {$key}]]" : '');
}

/** Is this the page currently being rendered? Drives aria-current in the nav. */
function is_current(string $pageId): bool
{
    return current_page() === $pageId;
}

/** The colour temperature of the current page; 'day' unless the content says otherwise. */
function mood(): string
{
    $mood = ctx()['c']['mood'] ?? null;

    return in_array($mood, MOODS, true) ? $mood : MOODS[0];
}

/**
 * Does this page open with a full-height hero?
 *
 * The content file answers by having a 'hero' block, so a page decides for
 * itself and no template holds a list of which ones do. The header uses it to
 * decide whether it starts transparent — see .c-header in main.css.
 */
function has_hero(): bool
{
    return !empty(ctx()['c']['hero']);
}

// ---------------------------------------------------------------------------
// Forms
// ---------------------------------------------------------------------------

/**
 * What happened to this form on this request.
 *
 * index.php puts the handler's result into ctx() after a POST; a form
 * component asks here and gets a shape it can rely on whether or not anything
 * was submitted, so it never has to test for the absence of a result.
 *
 * IT IS ASKED FOR BY TYPE, and that is not ceremony. A page may carry two
 * forms one day — the enquiry form appears on three pages (ARCHITECTURE §12.1)
 * — and a component that read "the result" rather than "my result" would draw
 * the other form's errors against its own fields.
 *
 * @return array{submitted: bool, ok: bool, values: array, errors: array, notice: string}
 *         submitted  a submission of THIS form was processed on this request
 *         ok         it was accepted — the component shows the thank-you
 *         values     what the applicant typed, for putting back into the fields
 *         errors     field name => the sentence to print against it
 *         notice     a message about the form as a whole, not about one field
 */
function form_state(string $formType): array
{
    $empty = ['submitted' => false, 'ok' => false, 'values' => [], 'errors' => [], 'notice' => ''];

    $form = ctx()['form'] ?? null;

    if (!is_array($form) || ($form['type'] ?? '') !== $formType) {
        return $empty;
    }

    return [
        'submitted' => true,
        'ok'        => !empty($form['ok']),
        'values'    => (array) ($form['values'] ?? []),
        'errors'    => (array) ($form['errors'] ?? []),
        'notice'    => (string) ($form['notice'] ?? ''),
    ];
}

// ---------------------------------------------------------------------------
// Images
// ---------------------------------------------------------------------------

/**
 * Where the photography lives, and how it is named (ARCHITECTURE §11):
 *
 *     assets/img/<page>/<slug>-<width>.<ext>
 *     assets/img/estate/staircase-1280.webp
 *
 * img() is handed the stem — "estate/staircase" — and finds the rest itself.
 */
const IMG_ROOT = '/assets/img';

/** The chapter / split ladder. Gallery and hero pass their own. */
const IMG_WIDTHS = [960, 1280, 1920];

/** 3:2 unless a caller says otherwise. */
const IMG_RATIO = '3/2';

/**
 * What a picture is, and it is never a matter of taste (ARCHITECTURE §11).
 *
 *   photo      real photography of the estate
 *   render     a visualisation of the project — figure() labels it as one
 *   mood       a reference image — atmosphere only, never captioned as our room
 *   generated  a synthesised image — figure() labels it as one
 *
 * The rule is enforced in templates/components/figure.php, not here: img()
 * prints the value onto the wrapper as data-source so the honesty of a page
 * can be read off the markup, and figure.php decides what the caption may say.
 *
 * 'generated' IS THE FOURTH AND IT IS DECLARED BEFORE ANYTHING USES IT. Nothing
 * on the site carries it today. It is here because the alternative — the first
 * synthesised image arriving and being declared 'render' because that is the
 * closest existing value — is exactly the failure this list exists to prevent:
 * a render is a studio's drawing of a building somebody intends to build, and a
 * synthesised image is neither a drawing of that nor a photograph of anything.
 * Two different claims want two different words, and the word has to exist
 * before the picture does or it will not get written.
 *
 * It is appended rather than inserted. IMG_SOURCES[0] is the fallback img()
 * uses for an unknown value, and that has to stay 'photo'.
 */
const IMG_SOURCES = ['photo', 'render', 'mood', 'generated'];

/**
 * The words a picture has to carry, from the claim it makes about itself.
 *
 *     photo      nothing  — a photograph of this building needs no note
 *     mood       nothing  — a reference image, never captioned as our room;
 *                           figure.php is what keeps that promise, not a label
 *     render     nothing  — was "Visualisation"
 *     generated  nothing  — was "Generated image"
 *
 * NO PICTURE CARRIES A WORD ANY MORE, ON THE OWNER'S INSTRUCTION. Every source
 * now returns the empty string, so every caller's `!== ''` check falls through
 * and no label reaches any page. This function is kept rather than deleted, and
 * kept as the only place the decision lives, because it is the switch: the
 * labels come back by restoring the two lines below and nothing else, and they
 * come back everywhere at once, which is the property that made the rule worth
 * centralising in the first place.
 *
 * WHAT WENT WITH THEM, so that a reader of this file is not misled about what
 * the site now claims. The captions themselves are untouched — every picture
 * still says what it is OF. What is gone is the second half, which said what it
 * WAS: the "Visualisation" on the Main Page's plates and bands, the "Generated
 * image" on THE ESTATE, THE CLUB and PADEL, the em-dashed label figure.php
 * appended, the Main Page's "Photographed, not visualised" chapter heading and
 * its closing note, and the paragraph in /terms that promised the labels would
 * be there. That last one is the reason this is written down: a promise to
 * label, left standing over pages that no longer label, is worse than either
 * choice made cleanly, so it was withdrawn in the same pass rather than left to
 * be found later.
 *
 * WHAT DID NOT CHANGE. 'source' is still declared on every picture in the
 * content files, is still validated against IMG_SOURCES, and is still what
 * figure.php reads to refuse a factual caption on a 'mood' image — that rule is
 * about what a caption may CLAIM and it is untouched. THE MAIN PAGE'S ONE HARD
 * CUT ALSO STANDS: scene 07 is still the real photographs of the real house and
 * still says so in its own words. The marking survives; only the printed word
 * is gone.
 *
 * THREE COMPONENTS WERE WRITING THIS RULE OUT SEPARATELY and one of them had
 * only half of it: film-band.php and film-plates.php label render and
 * generated, film-walk.php labelled generated alone, so the first walk station
 * that was a visualisation would have gone out unmarked. The rule belongs in
 * one place beside the list it reads — and now that the answer is "nothing",
 * having one place to say it is what makes the removal complete.
 *
 * IT RETURNS THE EMPTY STRING RATHER THAN NULL because every caller writes it
 * straight into markup behind a `!== ''` check, and a component is not the
 * place to decide what an unknown source means.
 */
function mark_for(string $source): string
{
    return match ($source) {
        // 'render'    => t('media.visualisation'),
        // 'generated' => t('media.generated'),
        default => '',
    };
}

/**
 * The widths of $name that are actually on disk, per format.
 *
 * Nothing is assumed to exist. A ladder is declared once in the content file
 * and this reports what was really exported, so a page that has only the 960
 * gets a one-entry srcset instead of two broken URLs.
 *
 * @param  string $name   path stem under assets/img, no width, no extension
 * @param  int[]  $widths the ladder to look for
 * @return array{webp: array<int, string>, jpeg: array<int, string>}
 *         width => URL, ascending, cache-busted by the file's own mtime
 */
function img_files(string $name, array $widths): array
{
    /*
       The stem comes out of a content file rather than off the wire, but it
       is interpolated into a filesystem path, and "../../private/config" is
       a stem too. Lowercase, digits, dash, underscore and a single slash
       between segments — which is exactly what the naming convention allows.
    */
    if (!preg_match('#^[a-z0-9][a-z0-9_-]*(/[a-z0-9][a-z0-9_-]*)*$#', $name)) {
        if (DEV) {
            trigger_error("img(): bad image name '{$name}'", E_USER_WARNING);
        }

        return ['webp' => [], 'jpeg' => []];
    }

    $found = ['webp' => [], 'jpeg' => []];

    // jpeg last in each list: the first extension found wins, and .jpg is the
    // one build_assets writes. .jpeg is here only so a hand-dropped file works.
    $formats = ['webp' => ['webp'], 'jpeg' => ['jpg', 'jpeg']];

    foreach ($widths as $width) {
        $width = (int) $width;

        if ($width <= 0) {
            continue;
        }

        foreach ($formats as $format => $extensions) {
            foreach ($extensions as $extension) {
                $path = IMG_ROOT . '/' . $name . '-' . $width . '.' . $extension;
                $file = PUBLIC_PATH . $path;

                if (is_file($file)) {
                    $found[$format][$width] = $path . '?v=' . filemtime($file);
                    break;
                }
            }
        }
    }

    ksort($found['webp']);
    ksort($found['jpeg']);

    return $found;
}

/**
 * "url 960w, url 1280w" from a width => url map.
 *
 * Unescaped: it is escaped once, by whoever writes it into an attribute. The
 * gallery puts the same string on a data- attribute for the lightbox to read,
 * and escaping here would leave one of the two callers doing it twice.
 *
 * @param array<int, string> $files
 */
function img_srcset(array $files): string
{
    $parts = [];

    foreach ($files as $width => $url) {
        $parts[] = $url . ' ' . $width . 'w';
    }

    return implode(', ', $parts);
}

/**
 * A ratio as a number, for working out a height. '3/2' and '3:2' both parse.
 * Anything else falls back to the default rather than emitting a broken
 * aspect-ratio, because a wrong ratio is a layout shift and a missing one is
 * a collapsed box.
 */
function img_ratio(string $ratio): array
{
    if (!preg_match('#^\s*(\d{1,4})\s*[/:]\s*(\d{1,4})\s*$#', $ratio, $match)) {
        if (DEV) {
            trigger_error("img(): bad ratio '{$ratio}'", E_USER_WARNING);
        }

        return img_ratio(IMG_RATIO);
    }

    $w = (int) $match[1];
    $h = (int) $match[2];

    if ($w < 1 || $h < 1) {
        return img_ratio(IMG_RATIO);
    }

    return ['w' => $w, 'h' => $h, 'css' => $w . ' / ' . $h, 'value' => $w / $h];
}

/**
 * A <picture> — or, when there is no photograph yet, a box exactly its shape.
 *
 *     <?= img('estate/staircase', '(min-width: 1180px) 50vw, 100vw',
 *             'The staircase, before restoration',
 *             ['ratio' => '3/2', 'source' => 'photo']) ?>
 *
 * @param string $name  stem under assets/img — "estate/staircase"
 * @param string $sizes the sizes attribute, e.g. "(min-width: 1180px) 50vw, 100vw"
 * @param string $alt   alt text; '' for a decorative image
 * @param array  $opts  widths        int[]   the ladder, default IMG_WIDTHS
 *                      ratio         string  '3/2'
 *                      priority      bool    true for the LCP image — see below
 *                      loading       string  'lazy' | 'eager'
 *                      fetchpriority string  'high' above the fold
 *                      source        string  photo | render | mood
 *                      class         string  extra classes on the wrapper
 *
 * ONE IMAGE PER PAGE IS THE ONE THAT HAS TO ARRIVE, and it is always the one
 * the reader is already looking at. 'priority' => true is that image: it loads
 * eagerly and asks for a high fetch priority, which are the two halves of the
 * same instruction and are wrong apart — eager without the priority queues
 * behind the stylesheet and the fonts, and a high priority on a lazy image is
 * a contradiction the browser resolves by ignoring one of them. The two
 * separate options are still there for the rare case that wants one and not
 * the other. More than one priority image on a page means none of them is.
 *
 * THE WRAPPER HOLDS THE SHAPE, NOT THE FILE.
 *
 * width and height are on the <img> as well, and they are the honest thing to
 * do, but they only prevent a shift if the exported file has the ratio the
 * page was built against. The wrapper carries aspect-ratio and the image fills
 * it, so a 4:3 export dropped into a 3:2 slot is cropped rather than allowed
 * to move the page. It is also what lets the placeholder below be the same
 * shape as the photograph that will replace it, which is the whole point.
 *
 * MISSING IMAGES ARE THE NORMAL CASE TODAY.
 *
 * There is no photography yet. A <picture> pointing at a file that is not
 * there is a broken icon and a collapsed box, and a page full of them cannot
 * be reviewed. So when no width of $name exists this returns a box of exactly
 * the right shape, hatched in --rule over --bg, with the stem printed in it
 * while DEV is on and nothing at all when it is off.
 *
 * The placeholder is aria-hidden: it stands in for a photograph that does not
 * exist, and reading a filename to somebody is worse than saying nothing.
 */
function img(string $name, string $sizes, string $alt = '', array $opts = []): string
{
    $widths = $opts['widths'] ?? IMG_WIDTHS;
    $ratio  = img_ratio((string) ($opts['ratio'] ?? IMG_RATIO));
    $class  = trim('c-img ' . (string) ($opts['class'] ?? ''));
    $source = (string) ($opts['source'] ?? 'photo');

    if (!in_array($source, IMG_SOURCES, true)) {
        if (DEV) {
            trigger_error("img(): unknown source '{$source}' for '{$name}'", E_USER_WARNING);
        }
        $source = IMG_SOURCES[0];
    }

    $files = img_files($name, is_array($widths) ? $widths : IMG_WIDTHS);

    /*
       Two forms of the same ratio. --img-ratio is what aspect-ratio takes;
       --img-ratio-n is the same thing as a bare number, which is the only
       form arithmetic can use — the lightbox needs calc(70vh * n) to work out
       how wide a box of this shape may be before it is taller than the
       window, and CSS cannot divide "3 / 2" into 1.5.
    */
    $attributes = ' class="' . e($class) . '"'
        . ' style="--img-ratio: ' . e($ratio['css'])
        . '; --img-ratio-n: ' . e(rtrim(rtrim(number_format($ratio['value'], 4, '.', ''), '0'), '.')) . '"'
        . ' data-source="' . e($source) . '"';

    // ---- Nothing on disk: the placeholder ---------------------------------

    if ($files['jpeg'] === [] && $files['webp'] === []) {
        $body = '';

        if (DEV) {
            $ladder = implode(' · ', array_map('intval', (array) $widths));

            $body = '<span class="c-img__note">'
                . '<span class="c-img__name">' . e($name) . '</span>'
                . '<span class="c-img__widths">' . e($ladder) . '</span>'
                . '</span>';
        }

        return '<div' . $attributes . ' data-empty aria-hidden="true">' . $body . '</div>';
    }

    // ---- The real thing ---------------------------------------------------

    /*
       The JPEG is the fallback and the <img> has to have a src, so if only
       WebP was exported the WebP carries both jobs. A browser old enough to
       refuse WebP is older than the site's floor; a page with no <img> at all
       has no image in any browser.
    */
    $fallback = $files['jpeg'] !== [] ? $files['jpeg'] : $files['webp'];

    /*
       src is read only by a browser that ignores srcset entirely. The middle
       rung is the one that is least wrong for that reader: the top of the
       ladder is a 1920 sent to something that cannot ask for less, and the
       bottom is a 960 stretched across a desktop.
    */
    $rungs = array_keys($fallback);
    $src   = $fallback[$rungs[intdiv(count($rungs) - 1, 2)]];

    // The largest rung is the intrinsic size the ratio is declared against.
    $width  = (int) end($rungs);
    $height = (int) round($width / $ratio['value']);

    $isPriority = !empty($opts['priority']);

    $loading = ($isPriority || ($opts['loading'] ?? 'lazy') === 'eager') ? 'eager' : 'lazy';

    // Only ever 'high' — the attribute's other values are the browser's default
    // by another name, and 'low' on an image in the page is not something the
    // content layer should be able to ask for by accident.
    $priority = ($isPriority || ($opts['fetchpriority'] ?? '') === 'high')
        ? ' fetchpriority="high"'
        : '';

    $webp = $files['webp'] !== []
        ? '<source type="image/webp" srcset="' . e(img_srcset($files['webp'])) . '" sizes="' . e($sizes) . '">'
        : '';

    return '<div' . $attributes . '>'
        . '<picture>'
        . $webp
        . '<img src="' . e($src) . '"'
        . ' srcset="' . e(img_srcset($fallback)) . '"'
        . ' sizes="' . e($sizes) . '"'
        . ' alt="' . e($alt) . '"'
        . ' width="' . $width . '" height="' . $height . '"'
        . ' loading="' . $loading . '" decoding="async"' . $priority
        . '>'
        . '</picture>'
        . '</div>';
}

// ---------------------------------------------------------------------------
// Components
// ---------------------------------------------------------------------------

/**
 * Render one content section through its component (ARCHITECTURE §7).
 *
 *     'sections' => [
 *         ['type' => 'chapter', 'number' => '01', …],
 *     ]
 *
 * The component file sees exactly two variables, $s and $c, because that is
 * all an include inside a function can see. A component that needs anything
 * else is a component that knows what page it is on.
 *
 * A type with no file renders nothing and says so in DEV. A page is not worth
 * taking down over a typo in a content file, and a silent gap in production is
 * better than a fatal.
 */
function component(array $s, array $c = []): void
{
    $type = (string) ($s['type'] ?? '');
    $file = COMPONENTS_PATH . '/' . $type . '.php';

    if (!preg_match('#^[a-z][a-z0-9-]*$#', $type) || !is_file($file)) {
        if (DEV) {
            trigger_error("component(): no component '{$type}'", E_USER_WARNING);
        }

        return;
    }

    include $file;
}

/**
 * The whole of a page, in content order.
 *
 * Which is why a page template is four lines: the order of the blocks is a
 * content decision, and adding one is an edit to content/<lang>/<page>.php.
 */
function sections(array $c): void
{
    foreach ((array) ($c['sections'] ?? []) as $s) {
        if (is_array($s)) {
            component($s, $c);
        }
    }
}

// ---------------------------------------------------------------------------
// SEO
// ---------------------------------------------------------------------------

/**
 * The page's JSON-LD, encoded and ready to print — or '' when it has none.
 *
 * The graph is declared in the content file, as data, under 'jsonld':
 *
 *     'jsonld' => [
 *         '@type'       => 'LandmarksOrHistoricalBuildings',
 *         'name'        => 'Majori Manor',
 *         'description' => …,
 *         'address'     => ['@type' => 'PostalAddress', …],
 *     ],
 *
 * TWO KEYS ARE ADDED HERE AND NEITHER MAY BE WRITTEN IN A CONTENT FILE.
 * '@context', because it is the same on every page and a page that forgets it
 * is a page whose markup is silently ignored; and 'url', because an address is
 * built from routes.php and nowhere else — a content file that wrote its own
 * canonical would be the second place a URL lives, which is the one rule the
 * routing table exists to keep. A content file may still set 'url' itself for
 * the case that is not this page's own address; it is not overwritten.
 *
 * NOTHING UNBUILT IS MARKED UP AS RUNNING (ARCHITECTURE §13). openingHours and
 * priceRange do not appear anywhere on this site until there is something open
 * to describe, and that is a content decision — this function only encodes
 * what it is handed.
 *
 * JSON_HEX_TAG is what keeps a stray "</script>" inside a description from
 * ending the element early; JSON_UNESCAPED_UNICODE is what keeps Jūrmala
 * spelled the way it is spelled, in a document that is UTF-8 throughout.
 */
function jsonld(): string
{
    $data = ctx()['c']['jsonld'] ?? null;

    if (!is_array($data) || $data === []) {
        return '';
    }

    $data = ['@context' => 'https://schema.org'] + $data;

    if (!isset($data['url'])) {
        $data['url'] = SITE_URL . url(current_page());
    }

    $json = json_encode(
        $data,
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP
    );

    if ($json === false) {
        if (DEV) {
            trigger_error('jsonld(): ' . json_last_error_msg(), E_USER_WARNING);
        }

        return '';
    }

    return $json;
}

// ---------------------------------------------------------------------------
// Assets and configuration
// ---------------------------------------------------------------------------

/**
 * A path under /assets with the file's own mtime appended, so a deploy
 * invalidates the cache and nothing has to be remembered.
 *
 *     asset_url('/assets/css/main.css')  →  /assets/css/main.css?v=1754660000
 */
function asset_url(string $path): string
{
    $file = PUBLIC_PATH . $path;

    return $path . '?v=' . (is_file($file) ? (string) filemtime($file) : '0');
}

/**
 * Social profiles for the footer, from SOCIAL in private/config.php.
 *
 * Empty until the owner supplies real addresses — see the open questions in
 * ARCHITECTURE §14. Nothing is invented here: an empty list renders nothing,
 * and a wrong Instagram link is worse than no Instagram link.
 *
 * defined() rather than SOCIAL directly, because a config.php uploaded before
 * this key existed is still a valid config.php.
 *
 * @return array<int, array{label: string, url: string}>
 */
function social_links(): array
{
    if (!defined('SOCIAL') || !is_array(SOCIAL)) {
        return [];
    }

    $links = [];

    foreach (SOCIAL as $link) {
        if (!empty($link['label']) && !empty($link['url'])) {
            $links[] = ['label' => (string) $link['label'], 'url' => (string) $link['url']];
        }
    }

    return $links;
}
