<?php
/**
 * scene — one photograph the size of the window, with the type standing on it.
 *
 * The film's workhorse. Four of the ten scenes are this component under three
 * variants, and what differs between them is a scrim and a place to stand:
 *
 *   plate       the frame is the photograph and the type sits low in it, out
 *               of the way of the picture. Scene 03 (the estate) and both
 *               halves of scene 10 (the finale).
 *
 *   contrast    the frame darkens almost to black and the type is the only
 *               thing left in it, centred. Scene 05.
 *
 *   membership  a large image with the type standing over the middle of it
 *               rather than under it. Scene 07.
 *
 * WHY THIS IS NOT chapter.php. A chapter is a picture beside a column of text
 * — two objects on a page, and the reader's eye chooses one. A scene is one
 * object: the photograph IS the page for as long as it lasts, and the words
 * are on it. Both are correct, for different pages; the ten other pages of
 * this site are read and keep their chapters, and the home page is watched.
 *
 * THE PHOTOGRAPH IS IN THE DOCUMENT AND IN FLOW, WHICH IS THE WHOLE FLOOR.
 * Everything that makes this cinematic — the stage being pinned while the copy
 * rides over it, the cross-dissolve into the scene below — is a sticky
 * position and a scrubbed opacity applied by home.css inside its motion query.
 * With no script, or under prefers-reduced-motion, this is a full-bleed
 * photograph with a caption under it, which is a complete and readable thing.
 *
 * A SLOT WITH NO FILE IS THE HATCHED FRAME AT THE DECLARED RATIO, because that
 * is what img() does when nothing is on disk. It is why every scene declares
 * the ratio it is finally meant to hold: the film's rhythm can be scrolled,
 * timed and reviewed before one photograph has been taken.
 *
 * Fields
 *   variant   'plate' (default) | 'contrast' | 'membership'
 *   act       an optional run this scene belongs to — 'finale' groups the
 *             night scenes so home.css can stop putting rhythm between them
 *   mood      day | dusk | night — the temperature of this scene
 *   number    the ornamental scene number, e.g. '01'
 *   eyebrow   the small tracked line
 *   title     the heading
 *   lede      one paragraph
 *   caption   a low line under the type — the archival note on the frame
 *   close     string[] — a closing line, one <span> per part so it breaks at
 *             the full stops on a phone and never inside one
 *   image     ['name' => …, 'alt' => …, 'ratio' => …, 'source' => …]
 *   link      ['page_id' => …, 'label' => …]
 *
 * @var array $s this section
 * @var array $c the page content
 */

declare(strict_types=1);

$variants = ['plate', 'contrast', 'membership'];

$variant = (string) ($s['variant'] ?? 'plate');

if (!in_array($variant, $variants, true)) {
    if (DEV) {
        trigger_error("scene(): unknown variant '{$variant}' — using plate", E_USER_WARNING);
    }

    $variant = 'plate';
}

$mood = in_array($s['mood'] ?? null, MOODS, true) ? $s['mood'] : null;

$number  = (string) ($s['number'] ?? '');
$eyebrow = (string) ($s['eyebrow'] ?? '');
$title   = (string) ($s['title'] ?? '');
$lede    = (string) ($s['lede'] ?? '');
$caption = trim((string) ($s['caption'] ?? ''));
$image   = (array)  ($s['image'] ?? []);
$link    = (array)  ($s['link'] ?? []);

/*
   The closing line, in parts. Empty parts are dropped rather than printed as
   empty spans — the same filter daytimeline.php applies to the same shape,
   because it is the same line and it moved here.
*/
$close = array_values(array_filter(
    array_map('trim', array_map('strval', (array) ($s['close'] ?? []))),
    static fn (string $part): bool => $part !== ''
));

/*
   An optional run. Only ever printed as a data attribute, never as a class:
   it groups scenes for the stylesheet and says nothing about how one looks.
*/
$act = preg_match('#^[a-z][a-z0-9-]*$#', (string) ($s['act'] ?? '')) ? (string) $s['act'] : '';

/*
   Full bleed at every width, so the browser is told the window and nothing
   else. The poster ladder rather than the chapter one, for the same reason
   hero.php uses it: this image is as wide as the screen on a desktop and the
   top of the chapter ladder is not.

   960 IS ON THE BOTTOM OF IT AND THAT IS NOT DECORATION. img_files() reports
   what is actually on disk and nothing else, so a rung nobody exported costs a
   stat and no markup — but a rung that EXISTS and is not asked for is a
   photograph that silently becomes a hatched box. Three of this page's slots
   were exported at 960 only, and asking for the poster ladder alone turned all
   three of them into placeholders. The ladder is therefore the union of what
   the film wants and what the brochure gave us, and it stays that way until
   every slot has been re-exported at the widths in docs/ASSET_MANIFEST.md.
*/
$imageOptions = [
    'widths' => [960, 1280, 1920, 2560],
    'ratio'  => (string) ($image['ratio'] ?? '16/9'),
    'source' => (string) ($image['source'] ?? 'photo'),
];
?>
<section class="section c-scene c-scene--<?= e($variant) ?><?= $mood ? ' section--' . e($mood) : '' ?>"<?= $act !== '' ? ' data-act="' . e($act) . '"' : '' ?>>

    <?php /*
        The stage. It is what gets pinned while the body rides over it, and it
        is a separate element from the media so that the scrim, the media and
        anything a later pass hangs on the frame all move as one.
    */ ?>
    <div class="c-scene__stage">
        <div class="c-scene__media">
<?php if (!empty($image['name'])): ?>
            <?= img(
                (string) $image['name'],
                '100vw',
                (string) ($image['alt'] ?? ''),
                $imageOptions
            ) ?>
<?php endif; ?>
        </div>
    </div>

    <div class="wrap c-scene__body">

<?php if ($close !== []): ?>
        <?php /* It opens the run it belongs to rather than closing the one
                 above, which is why it is the first thing in the body. */ ?>
        <p class="c-scene__close"><?php foreach ($close as $i => $part): ?><?= $i > 0 ? ' ' : '' ?><span><?= e($part) ?></span><?php endforeach; ?></p>
<?php endif; ?>

<?php if ($number !== ''): ?>
        <?php /* Ornament: it numbers the walk through the house and says
                 nothing the document order does not already carry, so it is
                 not read out ahead of every heading on the page. */ ?>
        <p class="c-scene__number" aria-hidden="true"><?= e($number) ?></p>
<?php endif; ?>

<?php if ($eyebrow !== ''): ?>
        <p class="u-eyebrow"><?= e($eyebrow) ?></p>
<?php endif; ?>

<?php if ($title !== ''): ?>
        <h2 class="c-scene__title"><?= e($title) ?></h2>
<?php endif; ?>

<?php if ($lede !== ''): ?>
        <p class="c-scene__lede measure"><?= e($lede) ?></p>
<?php endif; ?>

<?php if ($caption !== ''): ?>
        <p class="c-scene__caption"><?= e($caption) ?></p>
<?php endif; ?>

<?php if (!empty($link['page_id']) && !empty($link['label'])): ?>
        <p class="c-scene__more">
            <a class="c-more" href="<?= e(url((string) $link['page_id'])) ?>"><?= e((string) $link['label']) ?></a>
        </p>
<?php endif; ?>

    </div>

</section>
