<?php
/**
 * blueprint — the courts, drawn, then resolving into the real thing.
 *
 * STRUCTURE AND PLACEHOLDER ONLY IN THIS PASS, WHICH IS THE BRIEF. The lines
 * that draw themselves are a later piece of work. What is built here is the
 * frame that work will live in: the stage, at the ratio the drawing will be
 * drawn at, the geometry it will animate, and the photograph it resolves into.
 * Everything is measurable and scrollable today and nothing is faked.
 *
 * THE SCAFFOLD IS AN INLINE <svg> AND NOT A FILE, and that is the difference
 * between structure and an asset. Four rectangles laid out from a number in the
 * content file is the SHAPE of the claim the scene above it makes — "four
 * courts, under one roof" — and it costs nothing, needs no request and can be
 * measured this afternoon. The drawing itself, the one with a hand in it, is a
 * file and it is on the manifest.
 *
 * IT IS DRAWN IN currentColor AND HAS NO COLOUR OF ITS OWN. The stage takes
 * the scene's --accent through the mood system like everything else, so the
 * scaffold is gold on the dusk ground and would be gold-ink on cream without
 * one line changing here.
 *
 * EVERY STROKE CARRIES pathLength="1". That is the hook the later prompt
 * needs and the reason to write it now: with the geometry normalised to a
 * length of 1, a drawing animation is stroke-dasharray: 1 and a dashoffset
 * scrubbed from 1 to 0, identically for every element whatever its real size.
 * Adding it later would mean touching every node in this file again.
 *
 * THE SCAFFOLD SAYS NOTHING AND IS HIDDEN FROM ASSISTIVE TECHNOLOGY. It is a
 * diagram of a claim already made in words one scene above — a screen reader
 * that announced "four rectangles" here would be repeating the lede badly.
 *
 * TWO SLOTS AND NEITHER IS ON DISK TODAY, so both render as the hatched frame
 * at the ratio declared for them. That is the true state of the courts: they
 * are not built, there is no photograph of them anywhere in the material, and
 * home/padel has been a placeholder on this page from the first day for
 * exactly that reason.
 *
 * Fields
 *   mood      day | dusk | night
 *   courts    how many courts the scaffold draws. 4, the number the club has.
 *   drawing   the architectural drawing slot — ['name', 'alt', 'ratio', 'source']
 *   resolve   the photograph it resolves into — same shape
 *
 * @var array $s this section
 * @var array $c the page content
 */

declare(strict_types=1);

$mood = in_array($s['mood'] ?? null, MOODS, true) ? $s['mood'] : null;

/*
   Clamped rather than trusted. The scaffold is laid out arithmetically from
   this number and a content file that wrote 0 would emit an empty <svg> while
   one that wrote 400 would emit four hundred nodes into the document.
*/
$courts = (int) ($s['courts'] ?? 4);

if ($courts < 1 || $courts > 12) {
    if (DEV) {
        trigger_error("blueprint(): {$courts} courts is not a plan — using 4", E_USER_WARNING);
    }

    $courts = 4;
}

$drawing = (array) ($s['drawing'] ?? []);
$resolve = (array) ($s['resolve'] ?? []);

/*
   THE COURT'S PROPORTION IS THE SPORT'S AND NOT A DESIGN CHOICE. A padel court
   is 20m by 10m, so the rectangle is 2:1 and the scaffold is a true plan
   rather than a decorative grid. Two across and two down is the arrangement of
   four, and the columns are worked out rather than fixed so that any count the
   clamp allows still lands on two rows — which is the only depth that keeps a
   2:1 court inside a 16:9 frame at a legible size.
*/
$columns = $courts <= 2 ? $courts : (int) ceil($courts / 2);
$rows    = (int) ceil($courts / $columns);

// The viewBox is the declared ratio in hundredths, so every number below is
// readable as a percentage of the frame.
$viewW = 1600;
$viewH = 900;

$margin = 120;
$gap    = 56;

$cellW = ($viewW - ($margin * 2) - ($gap * ($columns - 1))) / $columns;
$cellH = $cellW / 2;

// Centred vertically in what is left, so the plan sits in the frame rather
// than on its top edge whatever the row count works out to be.
$blockH  = ($cellH * $rows) + ($gap * ($rows - 1));
$originY = ($viewH - $blockH) / 2;

$slot = static function (array $image, string $fallbackRatio): array {
    return [
        'widths' => [960, 1280, 1920, 2560],
        'ratio'  => (string) ($image['ratio'] ?? $fallbackRatio),
        'source' => (string) ($image['source'] ?? 'render'),
    ];
};
?>
<section class="section c-blueprint<?= $mood ? ' section--' . e($mood) : '' ?>" data-courts="<?= $courts ?>">

    <div class="c-blueprint__stage">

        <?php /* The drawing slot — the hand-drawn plan, when it exists. */ ?>
        <div class="c-blueprint__layer c-blueprint__layer--drawing">
<?php if (!empty($drawing['name'])): ?>
            <?= img(
                (string) $drawing['name'],
                '100vw',
                (string) ($drawing['alt'] ?? ''),
                $slot($drawing, '16/9')
            ) ?>
<?php endif; ?>
        </div>

        <?php /*
            The scaffold. Laid over the drawing slot, because the two are the
            same plan at two levels of finish and the later prompt animates
            this one onto that one.
        */ ?>
        <svg class="c-blueprint__scaffold" viewBox="0 0 <?= $viewW ?> <?= $viewH ?>"
             preserveAspectRatio="xMidYMid meet" aria-hidden="true" focusable="false">
<?php
for ($i = 0; $i < $courts; $i++) {
    $column = $i % $columns;
    $row    = intdiv($i, $columns);

    $x = $margin + ($column * ($cellW + $gap));
    $y = $originY + ($row * ($cellH + $gap));

    // Rounded to whole units: the viewBox is 1600 wide, so a fraction of a
    // unit is a fraction of a pixel nobody can see and four more bytes.
    $x = (int) round($x);
    $y = (int) round($y);
    $w = (int) round($cellW);
    $h = (int) round($cellH);

    // The service line, at the court's own proportion — a third of the way in
    // from each end, which is where a padel court's is.
    $service = (int) round($w / 3);
?>
            <g class="c-blueprint__court" style="--court-index: <?= $i ?>">
                <rect x="<?= $x ?>" y="<?= $y ?>" width="<?= $w ?>" height="<?= $h ?>" pathLength="1"></rect>
                <line x1="<?= $x + ($w / 2) ?>" y1="<?= $y ?>" x2="<?= $x + ($w / 2) ?>" y2="<?= $y + $h ?>" pathLength="1"></line>
                <line x1="<?= $x + $service ?>" y1="<?= $y ?>" x2="<?= $x + $service ?>" y2="<?= $y + $h ?>" pathLength="1"></line>
                <line x1="<?= $x + $w - $service ?>" y1="<?= $y ?>" x2="<?= $x + $w - $service ?>" y2="<?= $y + $h ?>" pathLength="1"></line>
            </g>
<?php } ?>
        </svg>

        <?php /*
            What it resolves into. Last in the markup so it paints over the
            drawing and the scaffold; home.js scrubs its opacity from nothing
            to everything across the scene, and with no script it is simply the
            photograph on top, which is the right thing to be looking at.
        */ ?>
        <div class="c-blueprint__layer c-blueprint__layer--resolve">
<?php if (!empty($resolve['name'])): ?>
            <?= img(
                (string) $resolve['name'],
                '100vw',
                (string) ($resolve['alt'] ?? ''),
                $slot($resolve, '16/9')
            ) ?>
<?php endif; ?>
        </div>

    </div>

</section>
