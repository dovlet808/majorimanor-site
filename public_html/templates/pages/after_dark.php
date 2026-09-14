<?php
/**
 * AFTER DARK — the seventh page cut from the film, and the only one whose
 * subject is the hour itself.
 *
 * IT IS THE ESTATE'S STRUCTURE AND NOT A NEW ONE, exactly as THE CLUB's,
 * PADEL's, EVENTS' and RESIDENCES' are: the hero is the Main Page's hero, the
 * acts are THE ESTATE's acts, and the bands, chapters, plates, detail track,
 * world, invitation, navigation and footer are all components the six approved
 * pages already carry. This page adds no component — it is the fourth of the
 * seven that did not need to — and it leaves two out: there is no film-ledger,
 * because there are no settled facts to put in one (ARCHITECTURE §21), and no
 * film-dialogue, because that component is THE CLUB's house of dialogue and
 * three pages already carry it.
 *
 * IT DOES CARRY ONE COMPONENT NO OTHER FILM PAGE DOES, and only behind a flag:
 * components/clause.php, in its 'standalone' form, holds the owner's licensing
 * sentence under the private gaming scene. That field exists for this page and
 * names it in its own header; the scene it belongs to is behind ENABLE_GAMING
 * and is not in the array at all when the flag is false.
 *
 * THE ORDER OF THE ACTS, THEIR TEMPERATURES AND EVERY SENTENCE ON THE PAGE ARE
 * CONTENT DECISIONS and live in content/en/after_dark.php. Nothing about what
 * AFTER DARK says or shows can be changed in this file — including whether the
 * private gaming scene exists, which is a spread in that array and not a branch
 * here.
 *
 * THE ACT LOOP IS THE PARTIAL AND NOT A FIFTH COPY OF ITSELF.
 * partials/film-acts.php arrived with THE CLUB for this exact reason;
 * templates/pages/estate.php still carries its own copy of those fifteen lines
 * and that stays true here, because THE ESTATE is approved and the cheapest way
 * to keep its output byte-identical is not to open the file.
 *
 * THE CHROME IS RENDERED HERE, as on the six pages before it and for the same
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
