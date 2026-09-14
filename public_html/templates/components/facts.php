<?php
/**
 * facts — label and value pairs, as a definition list.
 *
 * Four courts, four metres of ceiling, a hall that seats ninety. The kind of
 * thing a reader goes looking for once atmosphere has done its work, so it is
 * set plainly: a hairline between rows, the label in the brand's small tracked
 * voice, the value in the display face.
 *
 * A <dl> rather than a table because these are pairs and not a grid — nothing
 * here has a second column of values, and a table would promise one.
 *
 * Fields
 *   eyebrow  optional tracked line
 *   title    optional h2
 *   items    [['label' => 'Courts', 'value' => 'Four'], …]
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
?>
<section class="section c-facts<?= $mood ? ' section--' . e($mood) : '' ?>">
    <div class="wrap">

<?php if ($eyebrow !== '' || $title !== ''): ?>
        <div class="c-facts__head stack" style="--stack-space: var(--space-3)">
<?php if ($eyebrow !== ''): ?>
            <p class="u-eyebrow"><?= e($eyebrow) ?></p>
<?php endif; ?>
<?php if ($title !== ''): ?>
            <h2><?= e($title) ?></h2>
<?php endif; ?>
        </div>
<?php endif; ?>

        <dl class="c-facts__list">
<?php foreach ($items as $item): ?>
            <?php /* The pair is wrapped so that the hairline belongs to the
                     row and not to one of the two halves of it. */ ?>
            <div class="c-facts__row">
                <dt class="u-eyebrow c-facts__label"><?= e((string) ($item['label'] ?? '')) ?></dt>
                <dd class="c-facts__value"><?= e((string) ($item['value'] ?? '')) ?></dd>
            </div>
<?php endforeach; ?>
        </dl>

    </div>
</section>
