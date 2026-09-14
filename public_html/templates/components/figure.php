<?php
/**
 * figure — one image with an archival caption.
 *
 * THIS COMPONENT ENFORCES IMAGE HONESTY (ARCHITECTURE §11), AND IT IS NOT
 * OPTIONAL. The brochure holds two kinds of material and mixing them is a
 * guest arriving into a room that does not exist. So the caption is not
 * written by the content file alone — it is decided here, from 'source':
 *
 *   photo    the caption prints as written. Real photography of the estate.
 *
 *   render   the caption prints, and "Visualisation" is appended to it
 *            automatically. The content file does not have to ask and cannot
 *            forget; the label comes from t('media.visualisation') so it
 *            translates with everything else.
 *
 *   mood     THE FACTUAL CAPTION IS DROPPED ENTIRELY. A reference image gets
 *            the atmospheric line and nothing that could be read as a claim
 *            about a room we have. If a content file supplies a caption for a
 *            mood image it is not printed, and DEV says so — that combination
 *            is a content mistake, not a rendering one.
 *
 *   generated  the caption prints, and "Generated image" is appended to it, on
 *            exactly the terms 'render' is labelled: automatically, from
 *            t('media.generated'), with no way for a content file to suppress
 *            it. A synthesised picture is the one kind of material on this site
 *            that no reader can tell apart from a photograph by looking, which
 *            is precisely why the label is not optional.
 *
 * The consequence worth stating plainly: to caption a picture as our own room,
 * somebody has to write 'source' => 'photo' next to it. That is a sentence a
 * person has to mean.
 *
 * Fields
 *   image       ['name' => …, 'alt' => …, 'ratio' => …, 'source' => …]
 *   caption     the factual caption — printed for photo and render, never for mood
 *   atmosphere  the atmospheric line — the only caption a mood image gets
 *   width       'measure' to hold the figure to the prose column
 *   mood        day | dusk | night
 *
 * @var array $s this section
 * @var array $c the page content
 */

declare(strict_types=1);

$image  = (array) ($s['image'] ?? []);
$source = (string) ($image['source'] ?? 'photo');

$mood = in_array($s['mood'] ?? null, MOODS, true) ? $s['mood'] : null;

$caption    = trim((string) ($s['caption'] ?? ''));
$atmosphere = trim((string) ($s['atmosphere'] ?? ''));

// --- The caption rule -------------------------------------------------------

if ($source === 'mood') {
    if ($caption !== '' && DEV) {
        trigger_error(
            "figure: source 'mood' cannot carry a factual caption — dropped: \"{$caption}\"",
            E_USER_WARNING
        );
    }

    $caption = '';
} elseif ($source === 'render' || $source === 'generated') {
    /*
       Appended, not substituted: the caption still says what the picture is
       of, and the label says what the picture is. An em dash rather than a
       parenthesis because the label is a statement about the image and not an
       aside — and it is the same mark the archival caption style uses.

       THE LABEL IS NOW EMPTY FOR EVERY SOURCE and this branch therefore appends
       nothing — see mark_for() in app/helpers.php, which is where the decision
       lives and the one place it has to be undone. This component used to build
       the label itself, from t('media.visualisation') or t('media.generated')
       chosen inline, which meant the site had two implementations of one rule
       and the film components' was already the better one: it asks mark_for()
       and prints only what comes back. That is what this does now, so switching
       the labels on again switches them on here too instead of leaving the one
       component that predates the helper still silent.

       Two sources share this branch and they are not the same claim — a
       visualisation is somebody's drawing of an intention, a generated image is
       a synthesis of nothing in particular — which is why the distinction stays
       in mark_for() rather than being flattened away here.
    */
    $label = mark_for($source);

    if ($label !== '') {
        $caption = $caption === '' ? $label : $caption . ' — ' . $label;
    }
}

$narrow = ($s['width'] ?? '') === 'measure';
$sizes  = $narrow ? '(min-width: 768px) 34rem, 100vw' : '(min-width: 1440px) 1280px, 100vw';
?>
<section class="section c-figure<?= $narrow ? ' c-figure--measure' : '' ?><?= $mood ? ' section--' . e($mood) : '' ?>">
    <div class="wrap">
        <figure class="c-figure__figure">

<?php if (!empty($image['name'])): ?>
            <?= img(
                (string) $image['name'],
                $sizes,
                (string) ($image['alt'] ?? ''),
                [
                    'ratio'  => (string) ($image['ratio'] ?? '3/2'),
                    'source' => $source,
                ]
            ) ?>
<?php endif; ?>

<?php if ($caption !== '' || $atmosphere !== ''): ?>
            <figcaption class="c-figure__caption">
<?php if ($caption !== ''): ?>
                <span class="c-figure__fact"><?= e($caption) ?></span>
<?php endif; ?>
<?php if ($atmosphere !== ''): ?>
                <span class="c-figure__atmosphere"><?= e($atmosphere) ?></span>
<?php endif; ?>
            </figcaption>
<?php endif; ?>

        </figure>
    </div>
</section>
