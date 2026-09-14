<?php
/**
 * THE CLUB — the third page cut from the film, and the first one inside the
 * house.
 *
 * IT IS THE ESTATE'S STRUCTURE AND NOT A NEW ONE. The hero is the Main Page's
 * hero, the acts are THE ESTATE's acts, the bands, chapters, plates, walk,
 * invitation, navigation and footer are all components those two pages already
 * approved. What this page adds is two components neither of them has a use
 * for — the lateral track and the dialogue — and they are declared in the
 * content file like every other block, so this template stays four statements
 * long.
 *
 * THE ORDER OF THE ACTS, THEIR TEMPERATURES AND EVERY SENTENCE ON THE PAGE ARE
 * CONTENT DECISIONS and live in content/en/club.php. Nothing about what THE
 * CLUB says or shows can be changed in this file.
 *
 * THE CHROME IS RENDERED HERE, as on the two pages before it and for the same
 * reason: the content file sets 'own_chrome' => true, layout.php leaves the
 * site header and footer off, and the page renders the film's own. What that
 * chrome SAYS is still the site's — film-nav.php builds itself from routes.php
 * and common.php, so this page names the same places in the same words as
 * every other, and marks itself as the one the reader is standing on.
 *
 * @var array $c
 */

declare(strict_types=1);

require TEMPLATES_PATH . '/partials/film-nav.php';

component(['type' => 'film-hero'] + (array) ($c['hero'] ?? []), $c);

require TEMPLATES_PATH . '/partials/film-acts.php';

require TEMPLATES_PATH . '/partials/film-footer.php';
