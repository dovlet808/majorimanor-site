<?php
/**
 * English content of the not-found page. Arrays only, no markup.
 *
 * A 404 IS STILL A PAGE OF THIS SITE. The reader has mistyped something or
 * followed a link that has rotted, and what they meet should be the estate
 * rather than a server apologising. So: the crest, one line, and the four
 * addresses worth having — not a wall of navigation, and not "Oops!".
 *
 * dusk, and it is the only page whose temperature is chosen for a reason that
 * is not the descent (ARCHITECTURE §8.2). A cream page with three sentences on
 * it looks like a page that failed to load; the green ground makes a short page
 * look intended.
 *
 * THE FOUR LINKS ARE NAMED AS PAGE IDS AND NOT AS LABELS, exactly as the
 * footer names its four (see FOOTER_LINKS in helpers.php). The words come from
 * the navigation strings in common.php, so a page that is renamed is renamed
 * here too, and Latvian arrives without this file being touched.
 *
 * Home is deliberately not among them. The wordmark in the header goes there
 * from every page of the site, and a fifth link to it would be the one link
 * the reader already has.
 */

declare(strict_types=1);

return [

    'meta' => [
        'title'       => 'Page not found — Majori Manor',
        'description' => 'This address does not exist on majorimanor.com.',
    ],

    'mood' => 'dusk',

    'title' => 'Nothing at this address',
    'lede'  => 'The page you were looking for is not here. It may have moved, or it may not be written yet.',

    // The line above the links. Short, and not an apology.
    'ways'  => 'The ways in',

    'links' => ['estate', 'padel', 'events', 'membership'],

];
