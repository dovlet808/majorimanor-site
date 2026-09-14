<?php
/**
 * walk — three frames as one movement inward, and not a gallery.
 *
 * THE DIFFERENCE BETWEEN THIS AND gallery.php IS WHAT THE READER IS ASKED TO
 * DO. A gallery lays pictures side by side and invites a comparison: this
 * room, then that room, then the other one. A walk puts them one behind
 * another and takes the reader through. Each frame arrives from further away
 * than the one before it and the one before it keeps going, so what the eye
 * reads at the join is passing through a doorway rather than a slide being
 * replaced.
 *
 * The three frames of scene 04 are the route rather than a set: the rooms, the
 * stair between them, and the detail you only notice once you have stopped
 * walking. That is why they are declared in order and why the component has no
 * facility for more or fewer than the content file gives it — the order is the
 * movement.
 *
 * WITH NO SCRIPT IT IS THREE PHOTOGRAPHS AND A COLUMN OF TEXT, in document
 * order, every one of them full width and none of them hidden. There is no
 * control to press and nothing behind an interaction: the film's contribution
 * is that the three are stacked into one pinned frame and passed through on
 * scroll, and every rule that does it is inside home.css's motion query.
 *
 * THE FRAMES ARE PORTRAIT AND THAT IS A DECISION ABOUT DOORWAYS. A landscape
 * frame is a view; a tall one is an opening you go through, and this scene is
 * about going through. The ratio is still the content file's to declare —
 * every frame carries its own — so a photograph that arrives in another shape
 * changes one line rather than the component.
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
   Half the window on a wide screen, because that is what the stage below is:
   the frames are pinned into a column that never runs the full width, so the
   browser is told the real measurement rather than 100vw.
*/
$sizes = '(min-width: 1024px) 46vw, 86vw';
?>
<section class="section c-walk<?= $mood ? ' section--' . e($mood) : '' ?>" data-frames="<?= count($frames) ?>">

    <div class="wrap c-walk__inner">

        <div class="c-walk__text">
<?php if ($number !== ''): ?>
            <p class="c-walk__number" aria-hidden="true"><?= e($number) ?></p>
<?php endif; ?>

<?php if ($eyebrow !== ''): ?>
            <p class="u-eyebrow"><?= e($eyebrow) ?></p>
<?php endif; ?>

<?php if ($title !== ''): ?>
            <h2 class="c-walk__title"><?= e($title) ?></h2>
<?php endif; ?>

<?php if ($lede !== ''): ?>
            <p class="c-walk__lede measure"><?= e($lede) ?></p>
<?php endif; ?>

<?php if (!empty($link['page_id']) && !empty($link['label'])): ?>
            <p class="c-walk__more">
                <a class="c-more" href="<?= e(url((string) $link['page_id'])) ?>"><?= e((string) $link['label']) ?></a>
            </p>
<?php endif; ?>
        </div>

<?php if ($frames !== []): ?>
        <?php /*
            The stage. One box, three frames in it, and an index on each so the
            stylesheet and home.js can address them by position without either
            of them counting children.
        */ ?>
        <div class="c-walk__stage">
<?php foreach ($frames as $i => $frame): ?>
            <div class="c-walk__frame" style="--frame-index: <?= (int) $i ?>">
                <?= img(
                    (string) $frame['name'],
                    $sizes,
                    (string) ($frame['alt'] ?? ''),
                    [
                        'ratio'  => (string) ($frame['ratio'] ?? '4/5'),
                        'source' => (string) ($frame['source'] ?? 'photo'),
                    ]
                ) ?>
            </div>
<?php endforeach; ?>
        </div>
<?php endif; ?>

    </div>

</section>
