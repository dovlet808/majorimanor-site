<?php
/**
 * seam — the door between two temperatures.
 *
 * A band of gradient from the ground above it to the ground below, with the
 * crest standing in the middle. ARCHITECTURE §8.2: the home page darkens as it
 * goes, and a temperature change is not a border but a threshold you are
 * walked through.
 *
 * THERE ARE THREE OF THESE ON THE HOME PAGE AND THERE SHOULD NEVER BE MORE.
 * The seam is what makes the descent legible — daylight, then evening, then
 * night — and a seam between every block would make it a striped page instead
 * of a walk. Two blocks of the same temperature simply follow one another.
 *
 * It is decoration in the strict sense: aria-hidden, no text, nothing that a
 * reader who cannot see it is missing. The crest inside it is the same, and
 * seal() is asked for the decorative form for exactly that reason — the page
 * does not stop to announce a graphic three times on the way down.
 *
 * Fields
 *   from  the temperature above — day | dusk | night
 *   to    the temperature below
 *
 * The pair becomes .seam--from-to, which is where the two grounds are named
 * (§3 of main.css). A pair with no rule of its own renders a band of the
 * current ground rather than a stripe of the wrong colour, and says so in DEV.
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
    trigger_error("seam(): no gradient for '{$from}' to '{$to}'", E_USER_WARNING);
}
?>
<div class="seam<?= $known ? ' seam--' . e($from) . '-' . e($to) : '' ?>" aria-hidden="true">
    <?php seal('auto', 'md'); ?>
</div>
