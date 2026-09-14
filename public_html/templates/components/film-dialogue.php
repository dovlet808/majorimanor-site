<?php
/**
 * The house of dialogue: four ideas over one changing room.
 *
 * WHAT IT IS. Four things the house is for — the CEO's HOUSE OF DIALOGUE
 * material, translated rather than reproduced — set as a list on a dark ground,
 * with the room behind them changing to the one the reader is on. The names and
 * the lines stay put; only the picture moves. That is the whole interaction,
 * and its restraint is the point: a members' club that animates its own values
 * is a members' club advertising them.
 *
 * IT IS A GRID FIRST AND A STAGE SECOND, the same rule film-walk.php and
 * film-detail.php hold. Nothing below is hidden by the stylesheet: with no
 * JavaScript, a blocked CDN, or under prefers-reduced-motion this is four
 * captioned pictures in a plain grid, each with its name and its line under it,
 * in content order, at full opacity. club.js adds html.is-dialogue at the
 * moment it takes responsibility for the stage, and only that class stacks the
 * pictures behind the type.
 *
 * THE FIRST ITEM IS MARKED CURRENT IN THE MARKUP, and that is a completeness
 * guarantee rather than a default. In stage mode club.css prints the line under
 * the current name only; if that class arrived from JavaScript there would be a
 * frame — or, if the script died between adding html.is-dialogue and marking
 * anything, forever — in which the stage showed four names and no line at all.
 * The class costs nothing in the grid, where .is-current styles nothing.
 *
 * WHY THERE ARE NO BUTTONS. Every name and every line is in the markup and on
 * the screen at all times — what changes is which one is set in cream rather
 * than grey, and which photograph is behind it. Nothing is revealed by
 * pointing at it, so there is nothing to operate: making these <button>s would
 * announce four controls to a screen reader that do not lead anywhere and do
 * not disclose anything. The pointer is an accelerant on the scroll, not a
 * requirement, and §4 of club.js drops it on a coarse pointer.
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
<section class="c-dialogue"<?= $id ?> data-dialogue style="--items: <?= count($items) ?>">
    <div class="c-dialogue__stage" data-dialogue-stage>

        <span class="c-dialogue__scrim" aria-hidden="true"></span>

        <div class="c-dialogue__inner">

            <div class="c-dialogue__head">
<?php if (!empty($s['index'])): ?>
                <span class="c-dialogue__index"><?= e($s['index']) ?></span>
<?php endif; ?>
<?php if (!empty($s['eyebrow'])): ?>
                <p class="c-dialogue__eyebrow" data-reveal><?= e($s['eyebrow']) ?></p>
<?php endif; ?>
<?php if (!empty($s['title'])): ?>
                <h2 class="c-dialogue__title" data-reveal-lines><?= e($s['title']) ?></h2>
<?php endif; ?>
            </div>

            <ol class="c-dialogue__list">
<?php foreach ($items as $i => $item):
    $source = (string) ($item['source'] ?? 'render');
    $mark   = mark_for($source);
?>
                <li class="c-dialogue__item<?= $i === 0 ? ' is-current' : '' ?>" data-dialogue-item style="--i: <?= (int) $i ?>">
                    <?= img(
                        (string) ($item['name'] ?? ''),
                        (string) ($item['sizes'] ?? '(min-width: 900px) 100vw, 92vw'),
                        (string) ($item['alt'] ?? ''),
                        [
                            'widths' => (array) ($item['widths'] ?? [768, 1152]),
                            'ratio'  => (string) ($item['ratio'] ?? '16/9'),
                            'source' => $source,
                            'class'  => 'c-dialogue__img',
                        ]
                    ) ?>

                    <p class="c-dialogue__n"><?= e(str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)) ?><?php if ($mark !== ''): ?><span class="c-dialogue__mark"><?= e($mark) ?></span><?php endif; ?></p>
                    <p class="c-dialogue__label"><?= e($item['label']) ?></p>
<?php if (!empty($item['note'])): ?>
                    <p class="c-dialogue__note"><?= e($item['note']) ?></p>
<?php endif; ?>
                </li>
<?php endforeach; ?>
            </ol>
        </div>
    </div>
</section>
