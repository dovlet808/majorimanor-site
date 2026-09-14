<?php
/**
 * The walk through the house: one sticky viewport, seven stations, scrubbed.
 *
 * THIS IS THE ONE PLACE ON THE SITE WHERE SCROLL DRIVES A CAMERA. The section
 * is as tall as its stations; inside it a viewport-height stage is stuck to the
 * top, and estate.js maps scroll position onto a cross-fade between the
 * stations plus a slow scale on the one in front. What the reader does is
 * scroll; what it reads as is a camera moving through the rooms.
 *
 * IT IS A GALLERY FIRST AND A SEQUENCE SECOND, and the order matters because
 * the sequence is the part that can fail. Nothing below is hidden by the
 * stylesheet: with no JavaScript, with a blocked CDN, or under
 * prefers-reduced-motion, every station is a full-width captioned figure in
 * content order and the section is simply a long, quiet gallery — which is a
 * complete way to see seven rooms. estate.js adds html.is-walking at the
 * moment it takes responsibility for the sticky stage, and only that class
 * turns the stack into a stage. See §13 of home.css for the rule this follows.
 *
 * A STATION IS A PICTURE OR A FILM, and two of the seven are films: the
 * chandelier and the staircase, both Seedance sequences made from the very
 * photograph the station beside them is cut from. A film station ships with no
 * src — estate.js attaches one only when that station is the one in front or
 * next in line, and releases it again afterwards, so the walk costs one film at
 * a time and not two. The poster underneath is the film's own first frame and
 * is a complete station on its own, which is what a reader on a slow line and
 * every reader under reduced motion actually gets.
 *
 * A STATION MAY DECLARE A FOCUS, AND ON A PHONE IT IS THE WHOLE DIFFERENCE.
 * The stage is the viewport, so a 16:9 frame in a 390x844 window is cropped to
 * about a third of its width — and the middle third of a room is very often
 * the one wall nothing is happening on. 'focus' is the object-position that
 * crop is taken around, chosen per station by looking at the portrait result,
 * which is what a real mobile pass means here. It defaults to the centre and
 * costs nothing on a desktop, where the same frame is barely cropped at all.
 *
 * THE CAPTIONS ARE A LIST AND THEY STAY ONE. Each station's label sits in an
 * <ol> that is in the markup on the first byte, in reading order, so the walk
 * has a table of contents whether or not it ever becomes a stage.
 *
 * @var array $s
 * @var array $c
 */

declare(strict_types=1);

$stations = array_values(array_filter(
    (array) ($s['stations'] ?? []),
    'is_array'
));

if ($stations === []) {
    return;
}

$id = !empty($s['id']) ? ' id="' . e($s['id']) . '"' : '';
?>
<section class="c-walk"<?= $id ?> data-walk style="--stations: <?= count($stations) ?>">

<?php if (!empty($s['eyebrow']) || !empty($s['title'])): ?>
    <div class="c-walk__head">
<?php if (!empty($s['index'])): ?>
        <span class="c-walk__index"><?= e($s['index']) ?></span>
<?php endif; ?>
<?php if (!empty($s['eyebrow'])): ?>
        <p class="c-walk__eyebrow" data-reveal><?= e($s['eyebrow']) ?></p>
<?php endif; ?>
<?php if (!empty($s['title'])): ?>
        <h2 class="c-walk__title" data-reveal-lines><?= e($s['title']) ?></h2>
<?php endif; ?>
    </div>
<?php endif; ?>

    <div class="c-walk__stage" data-walk-stage>
        <div class="c-walk__frames">
<?php foreach ($stations as $i => $station):
    $film    = (array) ($station['film'] ?? []);
    $poster  = (string) ($film['poster'] ?? ($station['name'] ?? ''));
    $source  = (string) ($station['source'] ?? 'photo');
    $mark    = mark_for($source);
    $videoName = (string) ($film['name'] ?? '');
    $src       = $videoName !== '' ? '/assets/video/' . $videoName . '.mp4' : '';
    $hasFilm   = $src !== '' && is_file(PUBLIC_PATH . $src);

    /*
       The value reaches a style attribute, so it is matched rather than
       trusted: two space-separated percentages and nothing else. Anything
       that is not that is dropped and the picture stays centred.
    */
    $focus = (string) ($station['focus'] ?? '');
    $focus = preg_match('/^\d{1,3}% \d{1,3}%$/', $focus) ? $focus : '';
?>
            <figure class="c-walk__frame" data-walk-frame style="--i: <?= (int) $i ?><?= $focus !== '' ? '; --focus: ' . e($focus) : '' ?>">
                <?= img($poster, '100vw', (string) ($station['alt'] ?? ''), [
                    'widths' => (array) ($station['widths'] ?? [768, 1280, 1920]),
                    'ratio'  => (string) ($station['ratio'] ?? '16/9'),
                    'source' => $source,
                    'class'  => 'c-walk__img',
                ]) ?>

<?php if ($hasFilm): ?>
                <video class="c-walk__video" data-walk-video
                       muted loop playsinline disablepictureinpicture
                       preload="none" aria-hidden="true" tabindex="-1"
                       data-src="<?= e(asset_url($src)) ?>"></video>
<?php endif; ?>

                <figcaption class="c-walk__figcaption">
                    <span class="c-walk__fign"><?= e(str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)) ?></span>
                    <?= e($station['label'] ?? '') ?><?php if ($mark !== ''): ?><span class="c-walk__mark"><?= e($mark) ?></span><?php endif; ?>
                </figcaption>
            </figure>
<?php endforeach; ?>
        </div>

        <span class="c-walk__scrim" aria-hidden="true"></span>

        <ol class="c-walk__legend" data-walk-legend>
<?php foreach ($stations as $i => $station): ?>
            <li class="c-walk__station" data-walk-station style="--i: <?= (int) $i ?>">
                <span class="c-walk__n">
                    <?= e(str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)) ?><?php
                    /*
                       THE LABEL FOLLOWS THE PICTURE ONTO THE STAGE. The
                       figcaption below each frame carries it in the gallery,
                       but the stage hides those and shows this list instead —
                       so without it here, the two stations that are Seedance
                       sequences would be the only unlabelled synthesised
                       frames on the page, in the one view nearly every reader
                       actually gets.
                    */
                    $stationMark = mark_for((string) ($station['source'] ?? 'photo'));
                    if ($stationMark !== ''): ?><span class="c-walk__mark"><?= e($stationMark) ?></span><?php endif; ?>
                </span>
                <span class="c-walk__label"><?= e($station['label'] ?? '') ?></span>
<?php if (!empty($station['note'])): ?>
                <span class="c-walk__note"><?= e($station['note']) ?></span>
<?php endif; ?>
            </li>
<?php endforeach; ?>
        </ol>

        <span class="c-walk__rule" aria-hidden="true"><i data-walk-bar></i></span>
    </div>
</section>
