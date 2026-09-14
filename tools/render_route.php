<?php
/**
 * Render one route through index.php and print the HTML to stdout.
 *
 *     php tools/render_route.php /the-estate > estate.html
 *
 * A CLI harness for the byte-identity check: every page is rendered before and
 * after a change and the two are compared with cmp. It is not part of the site
 * and nothing under public_html/ knows it exists.
 *
 * REQUEST_URI is the only thing index.php reads off the request, so setting it
 * and including the file is a faithful render. One process per route, because
 * ctx() and the routes table are static and a second render in the same process
 * would see the first one's state.
 */

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    exit(1);
}

$uri = $argv[1] ?? '/';

$_SERVER['REQUEST_URI']    = $uri;
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['HTTP_HOST']      = 'dev.majorimanor.com';
$_SERVER['REMOTE_ADDR']    = '127.0.0.1';

chdir(__DIR__ . '/../public_html');

require __DIR__ . '/../public_html/index.php';
