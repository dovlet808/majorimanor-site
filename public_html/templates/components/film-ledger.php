<?php
/**
 * The house, as a drawing sheet: the five settled facts, set out like a
 * title block rather than like a card grid.
 *
 * IT IS A DEFINITION LIST BECAUSE THAT IS WHAT IT IS. Five labels and five
 * values, each pair belonging to the other — <dl> says so to a screen reader
 * and a grid of <div>s does not. The visual arrangement is entirely CSS, so
 * the meaning survives the stylesheet failing to arrive.
 *
 * THE RULES ARE DRAWN, NOT DECORATED. Each row carries a hairline that
 * estate.js draws from zero width as the row enters, which is the one piece of
 * ornament on the page that is about architecture rather than about
 * photography: a sheet of drawings assembling itself. Under reduced motion the
 * rules are simply there, at full width, on the first paint — they are painted
 * by the stylesheet and only their scaleX is animated.
 *
 * NOT ONE FACT HERE IS NEW. Built, architect, park, restoration and location
 * are the five the estate's own content file has always carried, in the same
 * words, from the owner's material. This component changed how they are set;
 * it did not add a sixth (ARCHITECTURE §21).
 *
 * @var array $s
 * @var array $c
 */

declare(strict_types=1);

$items = array_values(array_filter(
    (array) ($s['items'] ?? []),
    static fn ($item): bool => is_array($item) && !empty($item['label'])
));

if ($items === []) {
    return;
}

$id = !empty($s['id']) ? ' id="' . e($s['id']) . '"' : '';
?>
<section class="c-ledger"<?= $id ?>>
    <div class="c-ledger__inner">

        <div class="c-ledger__head">
<?php if (!empty($s['index'])): ?>
            <span class="c-ledger__index"><?= e($s['index']) ?></span>
<?php endif; ?>
<?php if (!empty($s['eyebrow'])): ?>
            <p class="c-ledger__eyebrow" data-reveal><?= e($s['eyebrow']) ?></p>
<?php endif; ?>
<?php if (!empty($s['title'])): ?>
            <h2 class="c-ledger__title" data-reveal-lines><?= e($s['title']) ?></h2>
<?php endif; ?>
        </div>

        <dl class="c-ledger__sheet">
<?php foreach ($items as $i => $item): ?>
            <div class="c-ledger__row" data-ledger-row style="--i: <?= (int) $i ?>">
                <dt class="c-ledger__label"><?= e($item['label']) ?></dt>
                <dd class="c-ledger__value"><?= e($item['value'] ?? '') ?></dd>
                <span class="c-ledger__rule" aria-hidden="true"><i data-ledger-rule></i></span>
            </div>
<?php endforeach; ?>
        </dl>

<?php if (!empty($s['note'])): ?>
        <p class="c-ledger__note" data-reveal><?= e($s['note']) ?></p>
<?php endif; ?>
    </div>
</section>
