<?php
/**
 * The lateral track: a row of close frames, panned by scroll.
 *
 * THE SECOND MOTION VERB ON THE SITE, AND IT IS DELIBERATELY NOT THE FIRST.
 * film-walk.php dissolves one full-screen room into the next — a camera moving
 * THROUGH a house. This one holds the camera at one distance and slides it
 * SIDEWAYS along a wall of details. Two sections built on the same dissolve,
 * one after the other, would read as one long section that had lost its way;
 * a pan after a dolly reads as the next shot.
 *
 * IT IS A GALLERY FIRST AND A TRACK SECOND, which is the rule film-walk.php
 * holds and the reason club.js sets html.is-tracking rather than the stylesheet
 * hiding anything. With no JavaScript, with a blocked CDN, under
 * prefers-reduced-motion, or on a phone, every frame below is a captioned
 * figure in a plain grid, in content order, at full opacity. The class is
 * added only when club.js has taken responsibility for driving the stage, and
 * only above 900px — see §3 of club.css for why the narrow pass keeps the grid.
 *
 * NOTHING HERE IS A HOVER. A frame does not lift, tilt or brighten under a
 * pointer: the movement in this section belongs to the camera, and a plate that
 * reacts to the mouse is a UI control pretending to be a photograph. The only
 * thing that moves is the track, and scroll is what moves it.
 *
 * THE MARK IS NOT OPTIONAL. Whatever a frame claims about itself —
 * 'photo', 'render', 'generated' — mark_for() decides what has to be printed
 * beside its caption, and a content file cannot switch it off. Every frame on
 * THE CLUB's track is a crop of the supplied photography, so none of them
 * prints anything; the branch is here so that the first one that is not does.
 *
 * @var array $s
 * @var array $c
 */

declare(strict_types=1);

$frames = array_values(array_filter(
    (array) ($s['frames'] ?? []),
    'is_array'
));

if ($frames === []) {
    return;
}

$id = !empty($s['id']) ? ' id="' . e($s['id']) . '"' : '';
?>
<section class="c-detail"<?= $id ?> data-detail style="--frames: <?= count($frames) ?>">

<?php if (!empty($s['eyebrow']) || !empty($s['title'])): ?>
    <div class="c-detail__head">
<?php if (!empty($s['index'])): ?>
        <span class="c-detail__index"><?= e($s['index']) ?></span>
<?php endif; ?>
<?php if (!empty($s['eyebrow'])): ?>
        <p class="c-detail__eyebrow" data-reveal><?= e($s['eyebrow']) ?></p>
<?php endif; ?>
<?php if (!empty($s['title'])): ?>
        <h2 class="c-detail__title" data-reveal-lines><?= e($s['title']) ?></h2>
<?php endif; ?>
<?php if (!empty($s['note'])): ?>
        <p class="c-detail__lede" data-reveal><?= e($s['note']) ?></p>
<?php endif; ?>
    </div>
<?php endif; ?>

    <div class="c-detail__stage" data-detail-stage>
        <ol class="c-detail__track" data-detail-track>
<?php foreach ($frames as $i => $frame):
    $source = (string) ($frame['source'] ?? 'photo');
    $mark   = mark_for($source);
?>
            <li class="c-detail__frame" data-detail-frame style="--i: <?= (int) $i ?>">
                <?= img(
                    (string) ($frame['name'] ?? ''),
                    (string) ($frame['sizes'] ?? '(min-width: 900px) 30vw, 46vw'),
                    (string) ($frame['alt'] ?? ''),
                    [
                        'widths' => (array) ($frame['widths'] ?? [640, 960]),
                        'ratio'  => (string) ($frame['ratio'] ?? '3/4'),
                        'source' => $source,
                        'class'  => 'c-detail__img',
                    ]
                ) ?>

                <p class="c-detail__cap">
                    <span class="c-detail__n"><?= e(str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)) ?></span>
                    <span class="c-detail__label"><?= e($frame['caption'] ?? '') ?></span><?php if ($mark !== ''): ?><span class="c-detail__mark"><?= e($mark) ?></span><?php endif; ?>
                </p>
            </li>
<?php endforeach; ?>
        </ol>
    </div>
</section>
