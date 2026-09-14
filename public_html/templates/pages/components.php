<?php
/**
 * Development component library. Rendered only while DEV is true — index.php
 * drops the page id when it is not, and the address 404s like any other
 * unknown one.
 *
 * Its own styles are inline and deliberately NOT in main.css, for the same
 * reason the styleguide's are: labelling scaffolding would ship to every
 * visitor, and the whole page has to disappear by deleting two files and one
 * line in routes.php. Everything it styles is prefixed .cl-. Nothing here
 * styles a component — if a block looks wrong on this page it looks wrong on
 * the real one, which is the only reason the page is worth having.
 *
 * TWICE, FROM ONE LIST. $c['blocks'] is rendered on day and again on night,
 * with the temperature forced onto each section as it goes. Any block that
 * needs a second version to survive the second ground is a block that has
 * named a colour somewhere it should not have.
 *
 * @var array $c
 */

declare(strict_types=1);

header('X-Robots-Tag: noindex');
?>
<style>
/* Development scaffolding. Not part of the design system. */
.cl-head        { border-block-end: 1px solid var(--rule); }
.cl-note        { max-width: var(--measure); font-size: var(--fs-sm); opacity: .75; }
.cl-ground      { padding-block: var(--space-9) 0; }
.cl-ground__label {
    font-family: ui-monospace, "SFMono-Regular", Menlo, Consolas, monospace;
    font-size: var(--fs-xs); text-transform: uppercase;
    letter-spacing: var(--tracking-eyebrow); opacity: .6;
}
.cl-block       { border-block-start: 1px solid var(--rule); }
.cl-block__label {
    font-family: ui-monospace, "SFMono-Regular", Menlo, Consolas, monospace;
    font-size: var(--fs-xs); opacity: .6;
    padding-block: var(--space-4);
}
</style>

<section class="section section--day">
    <div class="wrap stack">
        <p class="u-eyebrow"><?= e(t('nav.components')) ?></p>
        <h1><?= e($c['title']) ?></h1>
        <p class="measure"><?= e($c['lede']) ?></p>
        <p class="cl-note"><?= e($c['note']) ?></p>
    </div>
</section>

<?php
/*
   The two grounds. 'day' and 'night' are what the brief asks to see; 'dusk'
   is the third temperature and it is exercised on the styleguide, where the
   moods themselves are the subject.
*/
foreach (['day', 'night'] as $ground):
?>
<section class="section section--<?= e($ground) ?> cl-ground">
    <div class="wrap">
        <p class="cl-ground__label"><?= e($c['ground_label']) ?> · <?= e($ground) ?></p>
    </div>
</section>

<?php foreach ($c['blocks'] as $block): ?>
<?php
    /*
       The forced temperature. A block that carries its own 'mood' — a chapter
       on the real home page does — has it overridden here, because the point
       of this page is the ground and not the block's own preference.
    */
    $block['mood'] = $ground;
?>
    <div class="section--<?= e($ground) ?> cl-block">
        <div class="wrap">
            <p class="cl-block__label"><?= e($block['type']) ?><?= !empty($block['variant']) ? ' · ' . e((string) $block['variant']) : '' ?><?= !empty($block['flip']) ? ' · flip' : '' ?><?= !empty($block['from']) && !empty($block['to']) ? ' · ' . e((string) $block['from']) . ' → ' . e((string) $block['to']) : '' ?><?= !empty($block['image']['source']) ? ' · source: ' . e($block['image']['source']) : '' ?></p>
        </div>
        <?php component($block, $c); ?>
    </div>
<?php endforeach; ?>
<?php endforeach; ?>
