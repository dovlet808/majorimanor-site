<?php
/**
 * The first screen: the estate at blue hour, full bleed, moving.
 *
 * THE STILL IS THE LCP ELEMENT AND THE VIDEO IS NOT. The <video> ships with no
 * src at all — the two encodes are on data- attributes and home.js attaches one
 * only after the load event, only when motion is welcome, only when the reader
 * is not on a metered connection. Until then, and forever on a reader who has
 * asked for reduced motion, the poster is the hero and it is a complete first
 * screen on its own.
 *
 * THE STILL IS THE VIDEO'S OWN FIRST FRAME, which is why the fade from one to
 * the other cannot re-frame: they are the same photograph at the same crop. See
 * tools/photos/build_home_media.py.
 *
 * THERE IS NO poster ATTRIBUTE, AND ITS ABSENCE IS THE POINT. A <video poster>
 * is fetched eagerly whatever preload says — putting six JPEGs the reader has
 * not scrolled to into the critical path, which measured at 470 KB. The still
 * underneath is the same frame, is a real <picture> with a srcset, and is
 * lazy-loaded by the browser at the right moment. The video sits at opacity 0
 * over it until its first frame is decoded, so there is nothing for a poster
 * to do.
 *
 * TWO ENCODES, NOT ONE. The wide one is 1280 and the narrow one is 854, and the
 * choice is made against the viewport rather than against the device: a phone
 * showing a 1280-wide film is paying three times the bytes to fill a 390px
 * screen. Both are the same shot.
 *
 * THE SEAL IS THE SUPPLIED ARTWORK. It is an <img> rather than img() because it
 * is a mark and not a photograph: it wants transparency, three fixed sizes and
 * no ratio wrapper, and img() gives none of those. It carries the estate's name
 * as its alt text, which is why the <h1> below is not read twice.
 *
 * @var array $s the hero block from content/en/home.php
 * @var array $c
 */

declare(strict_types=1);

$film   = (array) ($s['film'] ?? []);
$seal   = (array) ($s['seal'] ?? []);
$poster = $film['poster'] ?? '';

$videoName = (string) ($film['name'] ?? '');
$wide      = $videoName !== '' ? '/assets/video/' . $videoName . '.mp4' : '';
$narrow    = $videoName !== '' ? '/assets/video/' . $videoName . '-sm.mp4' : '';

$hasWide   = $wide !== '' && is_file(PUBLIC_PATH . $wide);
$hasNarrow = $narrow !== '' && is_file(PUBLIC_PATH . $narrow);

/*
   WHERE THE CUE LANDS, AND WHY IT IS NOT WRITTEN DOWN HERE ANY MORE.

   It used to be href="#arrival" — the id of the Main Page's first scene — which
   was correct on the one page this component had, and silently wrong on the
   second: THE ESTATE has no #arrival, so the cue pointed at nothing and the
   only thing that happened when a reader pressed it was that the address bar
   changed. A hero that says "enter" and does not is worse than a hero with no
   cue at all.

   The default is still 'arrival', so the Main Page's markup is unchanged and
   its content file does not have to say anything. A page whose first scene is
   called something else declares 'cue_target'.
*/
$cueTarget = trim((string) ($s['cue_target'] ?? 'arrival'), '#');
?>
<section class="c-film-hero" data-hero-scene>

    <div class="c-film-hero__film" data-hero-film>
        <?= img($poster, '100vw', (string) ($film['alt'] ?? ''), [
            'widths'   => [768, 1280],
            'ratio'    => (string) ($film['ratio'] ?? '16/9'),
            'priority' => true,
            'source'   => (string) ($film['source'] ?? 'render'),
            'class'    => 'c-film-hero__still',
        ]) ?>

<?php if ($hasWide): ?>
        <video class="c-film-hero__video" data-hero-video
               muted loop playsinline disablepictureinpicture
               preload="none" aria-hidden="true" tabindex="-1"
               data-src-wide="<?= e(asset_url($wide)) ?>"
<?php if ($hasNarrow): ?>
               data-src-narrow="<?= e(asset_url($narrow)) ?>"
<?php endif; ?>
               ></video>
<?php endif; ?>

        <span class="c-film-hero__scrim" aria-hidden="true"></span>
    </div>

    <div class="c-film-hero__copy">

<?php if (!empty($seal['name'])): ?>
        <img class="c-film-hero__seal"
             src="<?= e(asset_url(IMG_ROOT . '/' . $seal['name'] . '-160.png')) ?>"
             srcset="<?= e(asset_url(IMG_ROOT . '/' . $seal['name'] . '-96.png')) ?> 96w, <?= e(asset_url(IMG_ROOT . '/' . $seal['name'] . '-160.png')) ?> 160w, <?= e(asset_url(IMG_ROOT . '/' . $seal['name'] . '-320.png')) ?> 320w"
             sizes="(min-width: 900px) 118px, 84px"
             width="160" height="160"
             alt="<?= e($seal['alt'] ?? '') ?>"
             fetchpriority="high" decoding="async">
<?php endif; ?>

<?php if (!empty($s['eyebrow'])): ?>
        <p class="c-film-hero__eyebrow" data-reveal><?= e($s['eyebrow']) ?></p>
<?php endif; ?>

        <h1 class="c-film-hero__title" data-reveal><?= e($s['title'] ?? '') ?></h1>

<?php if (!empty($s['subtitle'])): ?>
        <p class="c-film-hero__subtitle" data-reveal><?= e($s['subtitle']) ?></p>
<?php endif; ?>

<?php if (!empty($s['statement'])): ?>
        <p class="c-film-hero__statement" data-reveal><?= e($s['statement']) ?></p>
<?php endif; ?>
    </div>

<?php if (!empty($s['cue'])): ?>
    <a class="c-film-hero__cue" href="#<?= e($cueTarget) ?>">
        <span><?= e($s['cue']) ?></span>
        <span class="c-film-hero__cue-line" aria-hidden="true"></span>
    </a>
<?php endif; ?>
</section>
