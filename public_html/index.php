<?php
/**
 * The only entry point. Every request that is not an existing file or
 * directory is rewritten here by .htaccess.
 *
 *   1. resolve the request into a language and a page id
 *   2. load the interface strings into $t and the page content into $c
 *   3. render templates/pages/<page_id>.php into a buffer
 *   4. wrap the buffer in templates/layout.php
 *
 * An unknown address goes through exactly the same steps, with a 404 status.
 */

declare(strict_types=1);

require __DIR__ . '/app/bootstrap.php';

[$lang, $pageId] = resolve_request($_SERVER['REQUEST_URI'] ?? '/');

// A DEV-only address (the styleguide) exists only while DEV is on. Dropping the
// page id here rather than rendering something means it takes the ordinary 404
// path below: same status, same page, no hint that the address is special.
if ($pageId !== null && !DEV && in_array($pageId, DEV_ONLY_PAGES, true)) {
    $pageId = null;
}

/*
   EVERY ROUTE HAS A TEMPLATE OF ITS OWN NOW, so _placeholder.php is gone and
   there is nothing left to stand in with. A page id without a template is
   therefore a broken deploy rather than an unfinished page, and the honest
   answer to an address that leads nowhere is the one the site already gives.
   In DEV it says so out loud, because locally it means a file was not saved.
*/
if ($pageId !== null && !is_file(TEMPLATES_PATH . '/pages/' . $pageId . '.php')) {
    if (DEV) {
        trigger_error("index: no template for page '{$pageId}'", E_USER_WARNING);
    }

    $pageId = null;
}

if ($pageId === null) {
    http_response_code(404);
    $lang   = DEFAULT_LANG;   // the 404 is served in the default language
    $pageId = '404';
}

/** @var array $t interface strings shared by every page */
$t = require CONTENT_PATH . '/' . $lang . '/common.php';

/** @var array $c content of this page */
$contentFile = CONTENT_PATH . '/' . $lang . '/' . $pageId . '.php';
$c = is_file($contentFile) ? require $contentFile : [];

/** Checked above, so this is a file. */
$pageTemplate = TEMPLATES_PATH . '/pages/' . $pageId . '.php';

ctx(['lang' => $lang, 'page_id' => $pageId, 't' => $t, 'c' => $c]);

/*
   A FORM POSTS TO ITS OWN PAGE, AND THIS IS WHERE IT IS PROCESSED.

   app/ is closed to the web (Require all denied), so there is no endpoint to
   post to and no endpoint wanted: an ordinary POST to the same address, an
   answer rendered at that address, and a form that works with JavaScript
   switched off (ARCHITECTURE §12.2). The result goes into ctx() and the form
   component reads it through form_state() — errors against the fields, or the
   thank-you in place of the form.

   After ctx(), because the handler and the mails read their strings through
   t(). Before the page is rendered, because the page renders the outcome.

   A POST to a page with no form falls through: form_handle() returns null for
   anything that is not a submission it recognises.
*/
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    require_once APP_PATH . '/forms/handler.php';

    ctx(['form' => form_handle($_POST)]);
}

ob_start();
require $pageTemplate;
/** @var string $content */
$content = (string) ob_get_clean();

require TEMPLATES_PATH . '/layout.php';
