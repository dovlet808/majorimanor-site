<?php
/**
 * RESIDENCES — the sixth page cut from the film, and the first that stays the
 * night.
 *
 * IT IS THE ESTATE'S STRUCTURE AND NOT A NEW ONE, exactly as THE CLUB's,
 * PADEL's and EVENTS' are: the hero is the Main Page's hero, the acts are THE
 * ESTATE's acts, and the bands, chapters, plates, detail track, dialogue,
 * world, invitation, navigation and footer are all components the five approved
 * pages already carry. This page adds no component — it is the third of the six
 * that did not need to — and it is the first to leave one out: there is no
 * film-ledger here, because there are no settled facts to put in one
 * (ARCHITECTURE §21). See the note at the top of content/en/residences.php.
 *
 * THE ORDER OF THE ACTS, THEIR TEMPERATURES AND EVERY SENTENCE ON THE PAGE ARE
 * CONTENT DECISIONS and live in content/en/residences.php. Nothing about what
 * RESIDENCES says or shows can be changed in this file.
 *
 * THE ACT LOOP IS THE PARTIAL AND NOT A FOURTH COPY OF ITSELF.
 * partials/film-acts.php arrived with THE CLUB for this exact reason;
 * templates/pages/estate.php still carries its own copy of those fifteen lines
 * and that stays true here, because THE ESTATE is approved and the cheapest way
 * to keep its output byte-identical is not to open the file.
 *
 * THE CHROME IS RENDERED HERE, as on the five pages before it and for the same
 * reason: the content file sets 'own_chrome' => true, layout.php leaves the
 * site header and footer off, and the page renders the film's own. What that
 * chrome SAYS is still the site's — film-nav.php builds itself from routes.php
 * and common.php, so this page names the same places in the same words as every
 * other, and marks itself as the one the reader is standing on.
 *
 * @var array $c
 */

declare(strict_types=1);

require TEMPLATES_PATH . '/partials/film-nav.php';

component(['type' => 'film-hero'] + (array) ($c['hero'] ?? []), $c);

require TEMPLATES_PATH . '/partials/film-acts.php';

require TEMPLATES_PATH . '/partials/film-footer.php';
