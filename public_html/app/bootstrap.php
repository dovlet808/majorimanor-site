<?php
/**
 * Wiring: paths, configuration, error handling, helpers, request resolution.
 * Included by index.php and by nothing else.
 */

declare(strict_types=1);

// ---------------------------------------------------------------------------
// Paths
// ---------------------------------------------------------------------------

define('PUBLIC_PATH',    dirname(__DIR__));        // …/public_html
define('ROOT_PATH',      dirname(PUBLIC_PATH));    // project root, above the webroot
define('PRIVATE_PATH',   ROOT_PATH . '/private');
define('APP_PATH',       PUBLIC_PATH . '/app');
define('CONTENT_PATH',   PUBLIC_PATH . '/content');
define('TEMPLATES_PATH', PUBLIC_PATH . '/templates');
define('COMPONENTS_PATH', TEMPLATES_PATH . '/components');

// ---------------------------------------------------------------------------
// Configuration
// ---------------------------------------------------------------------------

$configFile = PRIVATE_PATH . '/config.php';

if (!is_file($configFile)) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=UTF-8');
    exit("Configuration missing.\n\nCopy private/config.example.php to private/config.php and try again.\n");
}

require $configFile;

// ---------------------------------------------------------------------------
// Errors
// ---------------------------------------------------------------------------

error_reporting(E_ALL);
ini_set('display_errors', DEV ? '1' : '0');
ini_set('log_errors', '1');
ini_set('error_log', PRIVATE_PATH . '/logs/php-error.log');

// Everything on this site is UTF-8; say so before any output.
header('Content-Type: text/html; charset=UTF-8');

// ---------------------------------------------------------------------------
// Helpers
// ---------------------------------------------------------------------------

require APP_PATH . '/helpers.php';

// ---------------------------------------------------------------------------
// Request resolution
// ---------------------------------------------------------------------------

/**
 * Turn a request URI into [language, page id].
 *
 * English lives at the root with no prefix; Latvian will live under /lv/.
 * So segment 0 is a language only when it is a known language code other than
 * the default — otherwise it is a page slug and the default language applies.
 * A known but inactive language (/lv/… while LANGS is ['en']) is a real 404.
 *
 * @return array{0: string, 1: ?string} page id is null when nothing matched
 */
function resolve_request(string $uri): array
{
    $path = parse_url($uri, PHP_URL_PATH);
    $path = is_string($path) ? rawurldecode($path) : '/';

    $segments = array_values(array_filter(
        explode('/', trim($path, '/')),
        static fn (string $segment): bool => $segment !== ''
    ));

    $lang = DEFAULT_LANG;

    if ($segments !== [] && $segments[0] !== DEFAULT_LANG && in_array($segments[0], known_langs(), true)) {
        $prefix = array_shift($segments);

        if (!in_array($prefix, LANGS, true)) {
            return [DEFAULT_LANG, null];   // the language exists on paper but is not switched on
        }

        $lang = $prefix;
    }

    if (count($segments) > 1) {
        return [$lang, null];              // no nested pages
    }

    return [$lang, page_id_for_slug($segments[0] ?? '', $lang)];
}
