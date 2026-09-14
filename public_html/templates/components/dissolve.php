<?php
/**
 * dissolve — the transition out of the hero, and the page's first promise.
 *
 * IT IS A SEAM WITH A JOB, AND IT RENDERS AS ONE.
 *
 * The markup below is deliberately the seam's own: the same element, the same
 * class, the same gradient, the same crest inside it. Everything that makes
 * this a dissolve rather than a border is a modifier class and one custom
 * property, both of which only mean anything inside home.css's motion query.
 * So the three gates come out right without a second code path:
 *
 *   no JavaScript    the ordinary ~120px seam main.css draws between two
 *                    temperatures. The hero above it has already resolved in
 *                    CSS, the estate below it is a full-bleed photograph, and
 *                    the page reads as the document it always was.
 *
 *   reduced motion   identical to the above. Nothing here is animated by this
 *                    file, and home.css's dissolve rules are all inside
 *                    (prefers-reduced-motion: no-preference).
 *
 *   the film         --dissolve-length becomes the scroll distance the hero is
 *                    given to leave over, and home.js scrubs the hero's three
 *                    planes and the estate's arrival against it.
 *
 * WHY IT CARRIES NO COPY. The brief's requirement is that the hero does not
 * cut away — that the camera pulls back, the type dissolves and the frame
 * becomes the estate. A line of text standing in the middle of that is a
 * fourth thing competing with the three that are already moving, and it would
 * also be new copy, which this page does not have. The scene is travel.
 *
 * THE LENGTH IS CONTENT AND NOT STYLE, WHICH IS WHY IT IS A FIELD. How long
 * the hero takes to leave is a decision about the film's pacing, and the
 * pacing is the content file's — the same place the order of the scenes and
 * the temperatures on them are decided. It is printed into a style attribute
 * rather than into a class because it is a distance and not a state.
 *
 * Fields
 *   from    the temperature above  — day | dusk | night
 *   to      the temperature below  — day | dusk | night
 *   length  the scroll distance the dissolve is given, as a CSS length.
 *           Default 110svh. Anything main.css would not accept is dropped.
 *
 * @var array $s this section
 * @var array $c the page content
 */

declare(strict_types=1);

require_once TEMPLATES_PATH . '/partials/seal.php';

$from = (string) ($s['from'] ?? '');
$to   = (string) ($s['to'] ?? '');

$known = in_array($from, MOODS, true) && in_array($to, MOODS, true) && $from !== $to;

if (!$known && DEV) {
    trigger_error("dissolve(): no gradient for '{$from}' to '{$to}'", E_USER_WARNING);
}

/*
   A length and nothing else. It is interpolated into a style attribute, so it
   is matched against the shape of a CSS length rather than escaped and hoped
   for: a number, a decimal point if it wants one, and one of the units this
   page has any use for. A content file that writes anything else gets the
   default and a warning, and never gets a declaration into the document.
*/
$length = trim((string) ($s['length'] ?? ''));

if ($length !== '' && !preg_match('#^[0-9]+(\.[0-9]+)?(svh|dvh|lvh|vh|vmin|px|rem)$#', $length)) {
    if (DEV) {
        trigger_error("dissolve(): '{$length}' is not a length — using the default", E_USER_WARNING);
    }

    $length = '';
}
?>
<div class="seam c-dissolve<?= $known ? ' seam--' . e($from) . '-' . e($to) : '' ?>"<?= $length !== '' ? ' style="--dissolve-length: ' . e($length) . '"' : '' ?> aria-hidden="true">
    <?php seal('auto', 'md'); ?>
</div>
