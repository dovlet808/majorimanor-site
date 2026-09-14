<?php
/**
 * frames — three pictures uncovered through an aperture.
 *
 * A MASK AND NOT A CAROUSEL, AND THE DIFFERENCE IS WHO IS DRIVING.
 *
 * A carousel moves on its own clock, hides two thirds of itself behind a
 * control nobody presses, and takes three photographs the estate paid for and
 * shows one. Everything here is in the document, everything is visible without
 * a script, and there is no control to find. What the film adds is the
 * aperture the three are uncovered through as the scene passes: the mask opens
 * on scroll and closes again on the way back up, because it is scrubbed to
 * position like everything else on this page.
 *
 * THE MASK IS A clip-path ON A WRAPPER AND NOT AN overflow ON THE FIGURE, and
 * that is a decision about what may still be selected. A clipped box still
 * lays out at full size, so the caption under it, the focus ring on anything
 * inside it and the text a reader copies are all unaffected by how far open
 * the aperture happens to be at that moment. It also composites on the GPU,
 * which overflow with a moving box does not.
 *
 * WITH NO SCRIPT THE APERTURE IS OPEN. The from-state lives in home.css inside
 * (prefers-reduced-motion: no-preference) and under .has-js, so a reader with
 * no JavaScript never meets a clip-path at all and a reader who asked for less
 * motion gets three photographs standing still. A mask declared closed in CSS
 * and opened by script is the failure progressive enhancement exists to
 * prevent — three invisible pictures if the file does not arrive.
 *
 * THE COPY COMES FIRST IN THE DOCUMENT AND THE PICTURES FOLLOW, which is the
 * order they are read in and the order they are looked at. The stylesheet may
 * lay them out however the scene needs; it does not get to decide what a
 * screen reader hears first.
 *
 * Fields
 *   mood      day | dusk | night
 *   number    the ornamental scene number
 *   eyebrow   the small tracked line
 *   title     the heading
 *   lede      one paragraph
 *   link      ['page_id' => …, 'label' => …]
 *   frames    [['name' => …, 'alt' => …, 'ratio' => …, 'source' => …], …]
 *
 * @var array $s this section
 * @var array $c the page content
 */

declare(strict_types=1);

$mood = in_array($s['mood'] ?? null, MOODS, true) ? $s['mood'] : null;

$number  = (string) ($s['number'] ?? '');
$eyebrow = (string) ($s['eyebrow'] ?? '');
$title   = (string) ($s['title'] ?? '');
$lede    = (string) ($s['lede'] ?? '');
$link    = (array)  ($s['link'] ?? []);

$frames = array_values(array_filter(
    (array) ($s['frames'] ?? []),
    static fn ($frame): bool => is_array($frame) && !empty($frame['name'])
));

/*
   The three sit in one row from 768px up and stack below it, which is what the
   stylesheet does — so the browser is told a third of the band and then the
   band, rather than a guess that is wrong at one of the two.
*/
$sizes = '(min-width: 768px) 30vw, 88vw';
?>
<section class="section c-frames<?= $mood ? ' section--' . e($mood) : '' ?>" data-frames="<?= count($frames) ?>">

    <div class="wrap">

        <div class="c-frames__text">
<?php if ($number !== ''): ?>
            <p class="c-frames__number" aria-hidden="true"><?= e($number) ?></p>
<?php endif; ?>

<?php if ($eyebrow !== ''): ?>
            <p class="u-eyebrow"><?= e($eyebrow) ?></p>
<?php endif; ?>

<?php if ($title !== ''): ?>
            <h2 class="c-frames__title"><?= e($title) ?></h2>
<?php endif; ?>

<?php if ($lede !== ''): ?>
            <p class="c-frames__lede measure"><?= e($lede) ?></p>
<?php endif; ?>

<?php if (!empty($link['page_id']) && !empty($link['label'])): ?>
            <p class="c-frames__more">
                <a class="c-more" href="<?= e(url((string) $link['page_id'])) ?>"><?= e((string) $link['label']) ?></a>
            </p>
<?php endif; ?>
        </div>

<?php if ($frames !== []): ?>
        <div class="c-frames__set">
<?php foreach ($frames as $i => $frame): ?>
            <?php /*
                Two elements per frame and both are load-bearing: the outer one
                is the aperture that clips, the inner one is what moves inside
                it. One element doing both would have its own clip-path
                animating against its own transform, and the two would fight.
            */ ?>
            <div class="c-frames__aperture" style="--frame-index: <?= (int) $i ?>">
                <div class="c-frames__inner">
                    <?= img(
                        (string) $frame['name'],
                        $sizes,
                        (string) ($frame['alt'] ?? ''),
                        [
                            'ratio'  => (string) ($frame['ratio'] ?? '3/2'),
                            'source' => (string) ($frame['source'] ?? 'photo'),
                        ]
                    ) ?>
                </div>
            </div>
<?php endforeach; ?>
        </div>
<?php endif; ?>

    </div>

</section>
