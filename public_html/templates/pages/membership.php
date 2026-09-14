<?php
/**
 * MEMBERSHIP — the ninth page cut from the film, and the last gate on the site.
 *
 * IT IS THE ESTATE'S STRUCTURE AND NOT A NEW ONE, exactly as THE CLUB's,
 * PADEL's, EVENTS', RESIDENCES', AFTER DARK's and CONTACT's are: the hero is the
 * Main Page's hero, the acts are THE ESTATE's acts, and the bands, chapters,
 * dialogue, plates, invitation, navigation and footer are all components the
 * eight approved pages already carry. This file is the seventh copy of the same
 * five lines and that is the point of them.
 *
 * IT ADDS ONE COMPONENT, WHICH IS THE FEWEST ANY REBUILT PAGE HAS ADDED BAR
 * PADEL'S. components/film-letterhead.php is the seal, two rules and the
 * estate's address, standing between the paragraph about how applications are
 * handled and the application itself. Nothing in the film draws a document, and
 * the four blocks that came closest are each rejected by name at the top of that
 * file. What this page LEAVES OUT is wider than what it adds: no walk, no
 * ledger, no lateral detail track, no seam — four components it could have had
 * and did not need, on a page whose job is to ask one question.
 *
 * THE FORM IS THE SITE'S FORM AND IT IS RENDERED BY THE SITE'S RENDERER.
 * components/form-membership.php and partials/form.php are what draw scene 07,
 * unchanged — same schema, same eleven fields, same validation, same honeypot,
 * same time-trap, same rate limiter, same error summary, same privacy sentence,
 * same handler. A film page that reimplemented a working, accessible,
 * no-JavaScript form in order to restyle it would be the worst trade on this
 * site. What changed is the ground under it and the type on it, and both of
 * those are in membership.css §7.
 *
 * THE CREST IS NO LONGER RENDERED HERE, AND THAT IS THE ONE STRUCTURAL THING
 * THIS FILE LOST. The approved page carried five lines instead of three, and the
 * two extra printed the crest at 140px in its own .c-pageseal band between the
 * hero and the first paragraph — because a crest standing alone is not a block
 * and the site had no component for one. It has one now. The crest is in exactly
 * the same role it held before, at exactly the same size, still the only one on
 * the page and still the one place on this site where it is the subject rather
 * than a mark on something (ARCHITECTURE §8.5) — it is simply four screens
 * further down, at the head of the document, which is where a seal on an
 * application belongs. So this file is back to the site's three lines, and
 * .c-pageseal is gone from it.
 *
 * THE ORDER OF THE ACTS, THEIR TEMPERATURES AND EVERY SENTENCE ON THE PAGE ARE
 * CONTENT DECISIONS and live in content/en/membership.php. Nothing about what
 * MEMBERSHIP says or shows can be changed in this file.
 *
 * THE ACT LOOP IS THE PARTIAL AND NOT AN EIGHTH COPY OF ITSELF.
 * partials/film-acts.php arrived with THE CLUB for this exact reason;
 * templates/pages/estate.php still carries its own copy of those fifteen lines
 * and that stays true here, because THE ESTATE is approved and the cheapest way
 * to keep its output byte-identical is not to open the file.
 *
 * THE CHROME IS RENDERED HERE, as on the eight pages before it and for the same
 * reason: the content file sets 'own_chrome' => true, layout.php leaves the site
 * header and footer off, and the page renders the film's own. What that chrome
 * SAYS is still the site's — film-nav.php builds itself from routes.php and
 * common.php, so this page names the same places in the same words as every
 * other. THIS IS THE PAGE THE BAR'S ACCENT ACTION POINTS AT, and it is the only
 * one: MEMBERSHIP is pulled out of the link list by NAV_ACCENT and set apart as
 * the single conversion path, so on every other page the action is a way here
 * and on this one it is a way to where the reader already stands. It is marked
 * with .is-current and aria-current="page" — see the note in film-nav.php, which
 * is four lines and additive, and leaves the eight approved pages byte-identical.
 *
 * @var array $c
 */

declare(strict_types=1);

require TEMPLATES_PATH . '/partials/film-nav.php';

component(['type' => 'film-hero'] + (array) ($c['hero'] ?? []), $c);

require TEMPLATES_PATH . '/partials/film-acts.php';

require TEMPLATES_PATH . '/partials/film-footer.php';
