<?php
/**
 * quote — one line of the brand, large and alone.
 *
 * Display face at --fs-2xl, centred, with a great deal of air around it and
 * NO QUOTATION MARKS. The line is the brand speaking, not somebody being
 * quoted, and a pair of inverted commas would turn a statement into a report
 * of one. That holds even when an attribution is given.
 *
 * Two shapes, because the semantics differ and the look does not:
 *   with an attribution     <figure><blockquote> … <figcaption>
 *   without one             a paragraph — there is nobody to cite
 *
 * THE EYEBROW IS NOT AN ATTRIBUTION AND THE TWO ARE NOT INTERCHANGEABLE. An
 * attribution says who said the line and belongs in a <figcaption> under a
 * <blockquote>; an eyebrow says what the line is about and stands above it, the
 * way it does on every other component here. THE MEMBERS' ROOM on /the-club is
 * the case it exists for: a block that has to name a room and then say two
 * short things about it, and must not be allowed to say a third.
 *
 * Fields
 *   eyebrow      optional tracked line above it — a subject, never a speaker
 *   line         the line
 *   attribution  optional, printed under it
 *   mood         day | dusk | night
 *
 * @var array $s this section
 * @var array $c the page content
 */

declare(strict_types=1);

$eyebrow     = (string) ($s['eyebrow'] ?? '');
$line        = (string) ($s['line'] ?? '');
$attribution = (string) ($s['attribution'] ?? '');

$mood = in_array($s['mood'] ?? null, MOODS, true) ? $s['mood'] : null;

if ($line === '') {
    return;
}
?>
<section class="section c-quote<?= $mood ? ' section--' . e($mood) : '' ?>">
    <div class="wrap">

<?php if ($eyebrow !== ''): ?>
        <p class="u-eyebrow c-quote__eyebrow"><?= e($eyebrow) ?></p>
<?php endif; ?>

<?php if ($attribution !== ''): ?>
        <figure class="c-quote__figure">
            <blockquote class="c-quote__line"><p><?= e($line) ?></p></blockquote>
            <figcaption class="c-quote__attribution"><?= e($attribution) ?></figcaption>
        </figure>
<?php else: ?>
        <p class="c-quote__line"><?= e($line) ?></p>
<?php endif; ?>

    </div>
</section>
