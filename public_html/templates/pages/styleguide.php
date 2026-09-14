<?php
/**
 * Development styleguide. Rendered only while DEV is true — index.php drops
 * the page id when it is not, and the address 404s like any other unknown one.
 *
 * Its own styles are inline, in the block below, and deliberately NOT in
 * main.css: a swatch grid is scaffolding, it would ship to every visitor, and
 * the whole page has to disappear by deleting two files and one line in
 * routes.php. A <style> element inside <main> is not what the HTML spec
 * prefers, but this markup never reaches a visitor and never reaches a
 * validator that matters. Everything it styles is prefixed .sg-.
 *
 * The page itself uses the real classes — .section, .section--dusk, .wrap,
 * .grid, .stack, .measure, .u-eyebrow, .seam — so what is on screen is the
 * stylesheet's actual behaviour and not a drawing of it.
 *
 * @var array $c
 */

declare(strict_types=1);

header('X-Robots-Tag: noindex');

require_once TEMPLATES_PATH . '/partials/seal.php';
?>
<style>
/* Development scaffolding. Not part of the design system. */
.sg-h            { margin-block-end: var(--space-6); }
.sg-note         { max-width: var(--measure); color: var(--fg); opacity: .75; font-size: var(--fs-sm); }
.sg-group        { margin-block-start: var(--space-9); }
.sg-group-label  { font-family: var(--font-body); font-size: var(--fs-xs); font-weight: 500;
                   text-transform: uppercase; letter-spacing: var(--tracking-eyebrow);
                   opacity: .6; margin-block-end: var(--space-4); }

.sg-swatches     { display: grid; gap: var(--space-4);
                   grid-template-columns: repeat(auto-fill, minmax(min(220px, 100%), 1fr)); }
.sg-swatch       { border: 1px solid var(--rule); }
.sg-swatch__chip { height: 84px; }
.sg-swatch__body { padding: var(--space-3); font-size: var(--fs-xs); line-height: 1.5; }
.sg-swatch__var  { font-family: ui-monospace, "SFMono-Regular", Menlo, Consolas, monospace; }
.sg-swatch__hex  { font-family: ui-monospace, "SFMono-Regular", Menlo, Consolas, monospace;
                   text-transform: uppercase; opacity: .7; }
.sg-swatch__note { opacity: .7; margin-block-start: var(--space-1); }

.sg-type         { border-block-start: 1px solid var(--rule); padding-block: var(--space-6); }
.sg-type__meta   { font-family: ui-monospace, "SFMono-Regular", Menlo, Consolas, monospace;
                   font-size: var(--fs-xs); opacity: .6; margin-block-end: var(--space-2); }
.sg-type__sample--display { font-family: var(--font-display); font-weight: 500; line-height: 1.1; }
.sg-type__sample--body    { font-family: var(--font-body); line-height: 1.65; max-width: var(--measure); }

.sg-font         { border-block-start: 1px solid var(--rule); padding-block: var(--space-6); }
.sg-font__stack  { font-family: ui-monospace, "SFMono-Regular", Menlo, Consolas, monospace;
                   font-size: var(--fs-xs); opacity: .6; margin-block-start: var(--space-2); }
.sg-font__sample { font-size: var(--fs-xl); line-height: 1.3; }

.sg-rows         { display: grid; gap: var(--space-2); }
.sg-row          { display: grid; grid-template-columns: 10rem 1fr; gap: var(--space-4);
                   align-items: center; font-size: var(--fs-xs); }
.sg-row__var     { font-family: ui-monospace, "SFMono-Regular", Menlo, Consolas, monospace; }
.sg-bar          { height: 12px; background-color: var(--accent); }

.sg-defs         { display: grid; gap: var(--space-3); font-size: var(--fs-sm); }
.sg-defs__var    { font-family: ui-monospace, "SFMono-Regular", Menlo, Consolas, monospace; }
.sg-defs__note   { opacity: .7; }

.sg-measure-rule { border-block-end: 1px solid var(--accent); max-width: var(--measure);
                   margin-block-end: var(--space-4); }

.sg-grid-cell    { background-color: var(--rule); text-align: center; font-size: var(--fs-xs);
                   padding-block: var(--space-3); }

.sg-seam-label   { font-size: var(--fs-xs); opacity: .6; padding-block: var(--space-2); }

.sg-seals        { display: flex; flex-wrap: wrap; align-items: flex-end;
                   gap: var(--space-7); }
.sg-seal         { display: grid; justify-items: center; gap: var(--space-2); }
.sg-seal__label  { font-family: ui-monospace, "SFMono-Regular", Menlo, Consolas, monospace;
                   font-size: var(--fs-xs); opacity: .6; }
.sg-variant      { border-block-start: 1px solid var(--rule); padding-block: var(--space-6); }
.sg-variant__note { font-size: var(--fs-xs); opacity: .7; margin-block-start: var(--space-1); }

.sg-buttons      { display: flex; flex-wrap: wrap; align-items: center; gap: var(--space-6); }
.sg-button       { display: grid; justify-items: start; gap: var(--space-2); }
</style>

<section class="section section--day">
    <div class="wrap stack">
        <p class="u-eyebrow"><?= e(t('nav.styleguide')) ?></p>
        <h1><?= e($c['title']) ?></h1>
        <p class="measure"><?= e($c['lede']) ?></p>
    </div>
</section>


<!-- Colour tokens ------------------------------------------------------- -->
<section class="section section--day">
    <div class="wrap">
        <h2 class="sg-h"><?= e($c['headings']['colour']) ?></h2>
        <p class="sg-note"><?= e($c['colour_note']) ?></p>

<?php foreach ($c['colour_groups'] as $group): ?>
        <div class="sg-group">
            <p class="sg-group-label"><?= e($group['label']) ?></p>
            <div class="sg-swatches">
<?php foreach ($group['swatches'] as $swatch): ?>
                <div class="sg-swatch">
                    <div class="sg-swatch__chip" style="background-color: var(<?= e($swatch['var']) ?>)"></div>
                    <div class="sg-swatch__body">
                        <div class="sg-swatch__var"><?= e($swatch['var']) ?></div>
                        <div class="sg-swatch__hex"><?= e($swatch['hex']) ?></div>
                        <div class="sg-swatch__note"><?= e($swatch['note']) ?></div>
                    </div>
                </div>
<?php endforeach; ?>
            </div>
        </div>
<?php endforeach; ?>
    </div>
</section>


<!-- Colour temperatures ------------------------------------------------- -->
<section class="section section--day">
    <div class="wrap">
        <h2 class="sg-h"><?= e($c['headings']['moods']) ?></h2>
        <p class="sg-note"><?= e($c['moods_note']) ?></p>
    </div>
</section>

<?php foreach ($c['moods'] as $mood): ?>
<section class="section section--<?= e($mood['id']) ?>">
    <div class="wrap stack">
        <p class="u-eyebrow"><?= e($mood['label']) ?></p>
        <h3><?= e($mood['sample']) ?></h3>
        <p class="measure"><?= e($mood['where']) ?></p>
        <p class="sg-note"><?= e($mood['accent']) ?></p>
        <hr>
        <p><a href="#main"><?= e($mood['label']) ?></a></p>
    </div>
</section>
<?php endforeach; ?>

<section class="section section--day">
    <div class="wrap">
        <h3 class="sg-h"><?= e($c['seams_label']) ?></h3>
        <p class="sg-note"><?= e($c['seams_note']) ?></p>
    </div>
<?php foreach ($c['seams'] as $seam): ?>
    <div class="wrap"><p class="sg-seam-label"><?= e($seam['label']) ?></p></div>
    <div class="seam <?= e($seam['class']) ?>" aria-hidden="true"></div>
<?php endforeach; ?>
</section>


<!-- Type scale ---------------------------------------------------------- -->
<section class="section section--day">
    <div class="wrap">
        <h2 class="sg-h"><?= e($c['headings']['type']) ?></h2>
        <p class="sg-note"><?= e($c['type_note']) ?></p>

        <div class="sg-group">
<?php foreach ($c['type'] as $step): ?>
            <div class="sg-type">
                <p class="sg-type__meta"><?= e($step['var']) ?> · <?= e($step['role']) ?></p>
                <p class="sg-type__sample--<?= e($step['face']) ?>" style="font-size: var(<?= e($step['var']) ?>)"><?= e($step['sample']) ?></p>
            </div>
<?php endforeach; ?>
        </div>
    </div>
</section>


<!-- The eyebrow --------------------------------------------------------- -->
<section class="section section--day">
    <div class="wrap">
        <h2 class="sg-h"><?= e($c['headings']['eyebrow']) ?></h2>
        <p class="sg-note"><?= e($c['eyebrow_note']) ?></p>
    </div>
</section>

<?php foreach (MOODS as $moodId): ?>
<section class="section section--<?= e($moodId) ?>">
    <div class="wrap stack" style="--stack-space: var(--space-4)">
<?php foreach ($c['eyebrows'] as $eyebrow): ?>
        <p class="u-eyebrow"><?= e($eyebrow) ?></p>
<?php endforeach; ?>
    </div>
</section>
<?php endforeach; ?>


<!-- Diacritic coverage -------------------------------------------------- -->
<section class="section section--day">
    <div class="wrap">
        <h2 class="sg-h"><?= e($c['headings']['fonts']) ?></h2>
        <p class="sg-note"><?= e($c['fonts_note']) ?></p>

        <div class="sg-group">
<?php foreach ($c['fonts'] as $font): ?>
            <div class="sg-font">
                <p class="sg-type__meta"><?= e($font['label']) ?></p>
                <p class="sg-font__sample sg-type__sample--<?= e($font['face']) ?>"><?= e($c['fonts_sample']) ?></p>
                <p class="sg-font__stack"><?= e($font['stack']) ?></p>
            </div>
<?php endforeach; ?>
        </div>
    </div>
</section>


<!-- Space and layout ---------------------------------------------------- -->
<section class="section section--day">
    <div class="wrap">
        <h2 class="sg-h"><?= e($c['headings']['space']) ?></h2>
        <p class="sg-note"><?= e($c['space_note']) ?></p>

        <div class="sg-group sg-rows">
<?php foreach ($c['space'] as $step): ?>
            <div class="sg-row">
                <span class="sg-row__var"><?= e($step['var']) ?> · <?= e($step['value']) ?></span>
                <span class="sg-bar" style="width: var(<?= e($step['var']) ?>)"></span>
            </div>
<?php endforeach; ?>
        </div>

        <div class="sg-group sg-defs">
<?php foreach ($c['layout'] as $item): ?>
            <div>
                <span class="sg-defs__var"><?= e($item['var']) ?>: <?= e($item['value']) ?></span>
                <span class="sg-defs__note">— <?= e($item['note']) ?></span>
            </div>
<?php endforeach; ?>
        </div>

        <div class="sg-group">
            <p class="sg-group-label"><?= e($c['measure_label']) ?></p>
            <p class="sg-note"><?= e($c['measure_note']) ?></p>
            <div class="sg-measure-rule"></div>
            <p class="measure"><?= e($c['measure_sample']) ?></p>
        </div>

        <div class="sg-group">
            <p class="sg-group-label"><?= e($c['grid_label']) ?></p>
            <p class="sg-note"><?= e($c['grid_note']) ?></p>
        </div>
    </div>

    <div class="wrap">
        <div class="grid">
<?php for ($column = 1; $column <= 12; $column++): ?>
            <div class="sg-grid-cell"><?= $column ?></div>
<?php endfor; ?>
        </div>
    </div>
</section>


<!-- The seal ------------------------------------------------------------ -->
<section class="section section--day">
    <div class="wrap">
        <h2 class="sg-h"><?= e($c['headings']['seal']) ?></h2>
        <p class="sg-note"><?= e($c['seal_note']) ?></p>
        <p class="sg-note"><?= e($c['seal_two_marks_note']) ?></p>
    </div>
</section>

<?php
    /*
       Every variant at every size, on every ground. Three grounds because one
       variant is defined by the ground it stands on and the other three are
       defined by refusing to be — which only shows if you can watch the gold
       one go to mush on cream and the green one vanish on dusk.
    */
?>
<?php foreach (MOODS as $moodId): ?>
<section class="section section--<?= e($moodId) ?>">
    <div class="wrap">
        <p class="u-eyebrow"><?= e($moodId) ?></p>

<?php foreach ($c['seal_variants'] as $variant): ?>
        <div class="sg-variant">
            <p class="sg-type__meta">seal('<?= e($variant['id']) ?>', …)</p>
            <div class="sg-seals">
<?php foreach ($c['seal_sizes'] as $size): ?>
                <div class="sg-seal">
                    <?php seal($variant['id'], $size['id']); ?>
                    <span class="sg-seal__label"><?= e($size['label']) ?></span>
                </div>
<?php endforeach; ?>
            </div>
            <p class="sg-variant__note"><?= e($variant['note']) ?></p>
        </div>
<?php endforeach; ?>
    </div>
</section>
<?php endforeach; ?>


<!-- Buttons -------------------------------------------------------------- -->
<section class="section section--day">
    <div class="wrap">
        <h2 class="sg-h"><?= e($c['headings']['buttons']) ?></h2>
        <p class="sg-note"><?= e($c['buttons_note']) ?></p>
    </div>
</section>

<?php foreach (MOODS as $moodId): ?>
<section class="section section--<?= e($moodId) ?>">
    <div class="wrap stack" style="--stack-space: var(--space-6)">
        <p class="u-eyebrow"><?= e($moodId) ?></p>

        <div class="sg-buttons">
<?php foreach ($c['buttons'] as $button): ?>
            <div class="sg-button">
                <?php /* A button that goes nowhere: the styleguide shows the
                         control, and every real one of these is a link. */ ?>
                <button class="c-btn <?= e($button['class']) ?>" type="button"><?= e($button['label']) ?></button>
                <span class="sg-seal__label"><?= e($button['note']) ?></span>
            </div>
<?php endforeach; ?>
        </div>
    </div>
</section>
<?php endforeach; ?>
