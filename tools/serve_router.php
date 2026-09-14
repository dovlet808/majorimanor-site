<?php
/**
 * Router for PHP's built-in server, standing in for the .htaccess rewrite.
 *
 *     php -S 127.0.0.1:8321 -t public_html tools/serve_router.php
 *
 * Real files under public_html/ are served as they are; everything else goes
 * to index.php, which is exactly what the production rewrite does. A local
 * harness only — nothing under public_html/ knows it exists.
 */

declare(strict_types=1);

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$file = __DIR__ . '/../public_html' . $path;

// app/, content/, templates/ and private/ are closed to the web in production
// by their own .htaccess; the built-in server honours none of them, so the
// closure is repeated here or the harness would be more permissive than the site.
foreach (['/app/', '/content/', '/templates/'] as $closed) {
    if (str_starts_with($path, $closed)) {
        http_response_code(403);

        return true;
    }
}

if ($path !== '/' && is_file($file)) {
    return false;   // let the built-in server send it
}

require __DIR__ . '/../public_html/index.php';
