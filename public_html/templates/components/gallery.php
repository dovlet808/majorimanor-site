<?php
/**
 * gallery — a grid of images that open into the lightbox.
 *
 * One column below 768px, two to 1180px, three above it. An item may take
 * more than one track with 'span', which is what stops six identical
 * rectangles reading as a contact sheet — but the span only applies where
 * there are tracks to spare, so nothing overflows at 360px.
 *
 * EVERY ITEM IS A <button>. It has to be operable from the keyboard, and a
 * button is the element that already is: click, Enter and Space, focus ring,
 * and the right role in the accessibility tree. No tabindex is set by hand
 * anywhere in this component.
 *
 * THE THUMBNAIL IS DECORATIVE AND THE BUTTON CARRIES THE NAME. The obvious
 * arrangement — alt text on the thumbnail, nothing on the button — breaks in
 * the case this site is in today: with no photography on disk, img() returns
 * a placeholder with no alt to borrow, and every trigger on the page would be
 * a nameless button. So the description is printed inside the button, hidden
 * visually, and the thumbnail takes alt="".
 *
 * WHAT THE LIGHTBOX IS HANDED. The full-size sources are written onto each
 * trigger as data- attributes and the script builds the <picture> when the
 * image is opened, never before — so a gallery of twelve costs one thumbnail
 * ladder and nothing else until somebody asks. The lightbox's own words are
 * on the list element, from common.php, because main.js may not contain a
 * word of English.
 *
 * Fields
 *   eyebrow  optional tracked line
 *   title    optional h2
 *   items    [['name' => 'estate/hall', 'alt' => …, 'caption' => …,
 *              'ratio' => '3/2', 'span' => 2, 'source' => 'photo'], …]
 *   mood     day | dusk | night
 *
 * @var array $s this section
 * @var array $c the page content
 */

declare(strict_types=1);

$eyebrow = (string) ($s['eyebrow'] ?? '');
$title   = (string) ($s['title'] ?? '');
$items   = (array)  ($s['items'] ?? []);

$mood = in_array($s['mood'] ?? null, MOODS, true) ? $s['mood'] : null;

/** The thumbnail ladder — a cell is never more than about half the page. */
$thumbWidths = [640, 960, 1280];
$thumbSizes  = '(min-width: 1180px) 33vw, (min-width: 768px) 50vw, 100vw';

/** The opened image is the whole window, less its margin. */
$fullWidths = [960, 1280, 1920];
$fullSizes  = '92vw';

if ($items === []) {
    return;
}
?>
<section class="section c-gallery<?= $mood ? ' section--' . e($mood) : '' ?>">
    <div class="wrap">

<?php if ($eyebrow !== '' || $title !== ''): ?>
        <div class="c-gallery__head stack" style="--stack-space: var(--space-3)">
<?php if ($eyebrow !== ''): ?>
            <p class="u-eyebrow"><?= e($eyebrow) ?></p>
<?php endif; ?>
<?php if ($title !== ''): ?>
            <h2><?= e($title) ?></h2>
<?php endif; ?>
        </div>
<?php endif; ?>

        <?php /* role="list" because .c-gallery__grid removes the markers and
                 Safari stops announcing a list that has none — see §4 of
                 main.css. */ ?>
        <ul class="c-gallery__grid" role="list"
            data-gallery
            data-lb-label="<?= e(t('lightbox.label')) ?>"
            data-lb-close="<?= e(t('lightbox.close')) ?>"
            data-lb-previous="<?= e(t('lightbox.previous')) ?>"
            data-lb-next="<?= e(t('lightbox.next')) ?>"
            data-lb-counter="<?= e(t('lightbox.counter')) ?>"
        >
<?php foreach ($items as $item): ?>
<?php
            $name    = (string) ($item['name'] ?? '');
            $alt     = (string) ($item['alt'] ?? '');
            $caption = (string) ($item['caption'] ?? '');
            $ratio   = (string) ($item['ratio'] ?? '3/2');
            $source  = (string) ($item['source'] ?? 'photo');
            $span    = (int) ($item['span'] ?? 1);
            $span    = $span >= 3 ? 3 : ($span === 2 ? 2 : 1);

            if ($name === '') {
                continue;
            }

            /*
               The full-size ladder, resolved once here so the trigger can
               carry it. Empty on both counts is the normal case today, and
               the script draws the same hatched box the thumbnail is showing.
            */
            $full     = img_files($name, $fullWidths);
            $fallback = $full['jpeg'] !== [] ? $full['jpeg'] : $full['webp'];

            // Nameless buttons are the one thing this component must not
            // produce; the caption stands in when there is no alt.
            $label = $alt !== '' ? $alt : $caption;

            if ($label === '' && DEV) {
                trigger_error("gallery: '{$name}' has neither alt nor caption to name its button", E_USER_WARNING);
            }
?>
            <li class="c-gallery__cell<?= $span > 1 ? ' c-gallery__cell--span-' . $span : '' ?>">
                <button
                    class="c-gallery__item"
                    type="button"
                    data-lb-item
                    data-lb-webp="<?= e(img_srcset($full['webp'])) ?>"
                    data-lb-srcset="<?= e(img_srcset($fallback)) ?>"
                    data-lb-src="<?= e($fallback === [] ? '' : (string) end($fallback)) ?>"
                    data-lb-sizes="<?= e($fullSizes) ?>"
                    data-lb-ratio="<?= e($ratio) ?>"
                    data-lb-alt="<?= e($alt) ?>"
                    data-lb-caption="<?= e($caption) ?>"
<?php if (DEV): ?>
                    data-lb-note="<?= e($name) ?>"
<?php endif; ?>
                >
                    <?= img($name, $thumbSizes, '', [
                        'widths' => $thumbWidths,
                        'ratio'  => $ratio,
                        'source' => $source,
                        'class'  => 'c-gallery__image',
                    ]) ?>
                    <span class="u-visually-hidden"><?= e($label) ?></span>
                </button>
            </li>
<?php endforeach; ?>
        </ul>

    </div>
</section>
