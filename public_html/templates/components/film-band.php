<?php
/**
 * A cinematic band: one of the five section sequences, at the width the scene
 * asks for.
 *
 *   variant  full   edge to edge, and the scene's title stands on it
 *            wide   edge to edge with a margin, for the 21:9 courts
 *            inset  held inside the measure, captioned under it
 *
 * NOTHING HERE LOADS ON SIGHT. Like the hero, the <video> ships with no src;
 * home.js attaches one when the band comes within a screen of the viewport and
 * removes it again when the band is a long way behind, so a reader who stops
 * halfway down has fetched two films and not six. The poster carries the band
 * until then, and carries it permanently under reduced motion.
 *
 * THE STILL IS THE SEQUENCE'S OWN FIRST FRAME, and there is no poster
 * attribute — see film-hero.php for why that matters.
 *
 * A CAPTION SAYS WHAT THE FRAME IS. 'render' appends "Visualisation" and
 * 'generated' appends "Generated image", both from common.php and neither
 * suppressible from the content layer — the same rule figure.php enforces, for
 * the same reason. A photograph appends nothing, because it is one. The second
 * of the two arrived with /the-estate, whose six sequences are Seedance
 * reframes of real photographs and are therefore neither.
 *
 * A BAND WITHOUT A FILM STILL RENDERS. If the encode is not on disk the poster
 * is the band — which is what a reader on a slow connection sees anyway, and
 * what every reader sees under prefers-reduced-motion.
 *
 * @var array $s
 * @var array $c
 */

declare(strict_types=1);

$film    = (array) ($s['film'] ?? []);
$overlay = (array) ($s['overlay'] ?? []);
$variant = (string) ($s['variant'] ?? 'full');
$ratio   = (string) ($film['ratio'] ?? '16/9');
$poster  = (string) ($film['poster'] ?? '');

$widths = $ratio === '21/9' ? [768, 1152] : [768, 1152];

$sizes = $variant === 'inset' ? '(min-width: 1080px) 76vw, 92vw' : '100vw';

/*
   A BAND MAY DECLARE ITS OWN LADDER AND ITS OWN sizes, AND CONTACT IS THE FIRST
   TO NEED EITHER.

   The two lines above are the film's defaults and they assume a plate that
   reaches 1152. /contact's gate does not: the crop stops at 985px of a 1628px
   photograph so that the old enamel sign on the right-hand pier falls outside
   the frame — the reasoning is on the plate in build_contact_media.py — and
   1152 would be an upscale, which nothing on this site ships. Asked for a rung
   that was never exported, img_files() simply does not find it, and the band
   would have gone out at 768 on every screen.

   'sizes' is the same problem seen from the other end: a 'wide' band is held
   inside var(--shell) with a gutter either side, so 100vw over-states it by
   about a fifth and a phone at 2x fetches a rung it does not need. The default
   is left alone because three approved pages depend on it.

   BOTH ARE ADDITIVE. A film with neither key produces exactly the markup it
   produced before, which is why the Main Page, THE ESTATE, THE CLUB, PADEL,
   EVENTS, RESIDENCES and AFTER DARK are byte-identical after this change.
   Proved, not assumed — tools/compare_pages.sh.
*/
if (!empty($film['widths'])) {
    $widths = array_map('intval', (array) $film['widths']);
}

if (!empty($film['sizes'])) {
    $sizes = (string) $film['sizes'];
}

$videoName = (string) ($film['name'] ?? '');
$src       = $videoName !== '' ? '/assets/video/' . $videoName . '.mp4' : '';
$hasFilm   = $src !== '' && is_file(PUBLIC_PATH . $src);

$id = !empty($s['id']) ? ' id="' . e($s['id']) . '"' : '';

// "Visualisation" or "Generated image", from the claim the picture makes about
// itself; the content file cannot switch it off. See mark_for() in helpers.php.
$mark = mark_for((string) ($film['source'] ?? 'render'));
?>
<section class="c-film-band c-film-band--<?= e($variant) ?>"<?= $id ?> data-band>
    <div class="c-film-band__frame" style="--band-ratio: <?= e(str_replace('/', ' / ', $ratio)) ?>">

        <?= img($poster, $sizes, (string) ($film['alt'] ?? ''), [
            'widths' => $widths,
            'ratio'  => $ratio,
            'source' => (string) ($film['source'] ?? 'render'),
            'class'  => 'c-film-band__still',
        ]) ?>

<?php if ($hasFilm): ?>
        <video class="c-film-band__video" data-band-video
               muted loop playsinline disablepictureinpicture
               preload="none" aria-hidden="true" tabindex="-1"
               data-src="<?= e(asset_url($src)) ?>"></video>
<?php endif; ?>

        <span class="c-film-band__scrim" aria-hidden="true"></span>

<?php if ($overlay !== []): ?>
        <div class="c-film-band__overlay">
<?php if (!empty($overlay['index'])): ?>
            <span class="c-film-band__index"><?= e($overlay['index']) ?></span>
<?php endif; ?>
<?php if (!empty($overlay['eyebrow'])): ?>
            <p class="c-film-band__eyebrow" data-reveal><?= e($overlay['eyebrow']) ?></p>
<?php endif; ?>
            <h2 class="c-film-band__title" data-reveal><?= e($overlay['title'] ?? '') ?></h2>
        </div>
<?php endif; ?>
    </div>

<?php if (!empty($s['caption']) || !empty($s['eyebrow']) || !empty($s['title'])): ?>
    <div class="c-film-band__foot">
<?php if (!empty($s['index'])): ?>
        <span class="c-film-band__foot-index"><?= e($s['index']) ?></span>
<?php endif; ?>
<?php if (!empty($s['eyebrow'])): ?>
        <p class="c-film-band__foot-eyebrow"><?= e($s['eyebrow']) ?></p>
<?php endif; ?>
<?php if (!empty($s['title'])): ?>
        <p class="c-film-band__foot-title" data-reveal><?= e($s['title']) ?></p>
<?php endif; ?>
<?php if (!empty($s['caption'])): ?>
        <p class="c-film-band__caption"><?= e($s['caption']) ?><?= $mark !== '' ? ' · ' . e($mark) : '' ?></p>
<?php endif; ?>
    </div>
<?php endif; ?>
</section>
