<?php
/**
 * CONTACT — the eighth page cut from the film, and the only one that is not a
 * story.
 *
 * IT IS THE ESTATE'S STRUCTURE AND NOT A NEW ONE, exactly as THE CLUB's,
 * PADEL's, EVENTS', RESIDENCES' and AFTER DARK's are: the hero is the Main
 * Page's hero, the acts are THE ESTATE's acts, and the bands, chapters,
 * invitation, navigation and footer are all components the seven approved pages
 * already carry. This file is the sixth copy of the same five lines and that is
 * the point of them.
 *
 * IT ADDS TWO COMPONENTS AND LEAVES SIX OUT, which is the widest either number
 * has been. The two are components/contact-address.php and
 * components/contact-map.php — the address set as display type, and a scene
 * built around the map this site already had. Neither exists anywhere else and
 * neither is a variant of something that does: nothing in the film draws a
 * postal address, and nothing in the film draws a figure that is a live map.
 * The six it leaves out are the walk, the ledger, the lateral detail track, the
 * dialogue, the plates and the world — this page is six screens long and every
 * one of them would have been a screen it did not need.
 *
 * THE FORM IS THE SITE'S FORM AND IT IS RENDERED BY THE SITE'S RENDERER.
 * components/form-enquiry.php and partials/form.php are what draw scene 05,
 * unchanged — same schema, same validation, same honeypot, same time-trap, same
 * rate limiter, same error summary, same privacy sentence, same handler. A film
 * page that reimplemented a working, accessible, no-JavaScript form in order to
 * restyle it would be the worst trade on this site. What changed is the ground
 * under it and the type on it, and both of those are in contact.css §6.
 *
 * THE ORDER OF THE ACTS, THEIR TEMPERATURES AND EVERY SENTENCE ON THE PAGE ARE
 * CONTENT DECISIONS and live in content/en/contact.php. Nothing about what
 * CONTACT says or shows can be changed in this file.
 *
 * THE ACT LOOP IS THE PARTIAL AND NOT A SIXTH COPY OF ITSELF.
 * partials/film-acts.php arrived with THE CLUB for this exact reason;
 * templates/pages/estate.php still carries its own copy of those fifteen lines
 * and that stays true here, because THE ESTATE is approved and the cheapest way
 * to keep its output byte-identical is not to open the file.
 *
 * THE CHROME IS RENDERED HERE, as on the seven pages before it and for the same
 * reason: the content file sets 'own_chrome' => true, layout.php leaves the
 * site header and footer off, and the page renders the film's own. What that
 * chrome SAYS is still the site's — film-nav.php builds itself from routes.php
 * and common.php, so this page names the same places in the same words as every
 * other, and marks itself as the one the reader is standing on, which on this
 * page means CONTACT carries .is-current and aria-current="page".
 *
 * @var array $c
 */

declare(strict_types=1);

require TEMPLATES_PATH . '/partials/film-nav.php';

component(['type' => 'film-hero'] + (array) ($c['hero'] ?? []), $c);

require TEMPLATES_PATH . '/partials/film-acts.php';

require TEMPLATES_PATH . '/partials/film-footer.php';
