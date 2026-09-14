<?php
/**
 * pagetitle — the opening of a page that has no photograph.
 *
 * An eyebrow, the h1, and one line under it, in a band of their own. It is the
 * hero's counterpart for the three pages where a picture would be a lie: the
 * contact page, which has no photograph worth the top of the screen, and the
 * two legal pages, where one would be decoration on a document.
 *
 * IT IS NOT A SHORT HERO. The hero stands on a full-bleed image with a scrim
 * over it and a transparent header on top of the same picture; this is type on
 * the page's own ground, and the header above it is the ordinary solid bar. A
 * page has one or the other and never both — this component prints the h1, and
 * so does the hero.
 *
 * THE GROUND IS THE BAND'S OWN. 'mood' sets it, which is how the contact page
 * gets its green plate — a title band on --green-800 under a cream header —
 * while the legal pages take the page's own cream and read as documents rather
 * than as announcements.
 *
 * Fields
 *   eyebrow  optional tracked line above the title
 *   title    the <h1> — one per page, and this is it
 *   lede     one line under it
 *   id       anchor for the section
 *   mood     day | dusk | night
 *
 * @var array $s this section
 * @var array $c the page content
 */

declare(strict_types=1);

$eyebrow = (string) ($s['eyebrow'] ?? '');
$title   = (string) ($s['title'] ?? '');
$lede    = (string) ($s['lede'] ?? '');
$anchor  = (string) ($s['id'] ?? '');

$mood = in_array($s['mood'] ?? null, MOODS, true) ? $s['mood'] : null;
?>
<section class="section c-pagetitle<?= $mood ? ' section--' . e($mood) : '' ?>"<?= $anchor !== '' ? ' id="' . e($anchor) . '"' : '' ?>>
    <div class="wrap stack" style="--stack-space: var(--space-5)">

<?php if ($eyebrow !== ''): ?>
        <p class="u-eyebrow"><?= e($eyebrow) ?></p>
<?php endif; ?>

        <h1 class="c-pagetitle__title"><?= e($title) ?></h1>

<?php if ($lede !== ''): ?>
        <p class="c-pagetitle__lede measure"><?= e($lede) ?></p>
<?php endif; ?>

    </div>
</section>
