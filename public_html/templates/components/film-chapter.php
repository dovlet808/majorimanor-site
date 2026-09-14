<?php
/**
 * A block of type. The film's spoken parts.
 *
 *   default  the scene opens: index, eyebrow, a display line, then the prose
 *            in one column set well inside the measure
 *   split    the scene has already been named by the band above it, so there
 *            is no display line — a lede on the left, the prose on the right
 *
 * EVERY LINE IS IN THE DOM ON THE FIRST BYTE. The reveal is a transform and an
 * opacity applied by home.js to elements that already carry their text, so a
 * crawler and a reader with JavaScript off get the whole page, and always the
 * whole page. Nothing below is written by script.
 *
 * The prose is split into <p> by the content file rather than by a parser
 * here: content/ contains no markup (ARCHITECTURE §6) and a paragraph is a
 * decision about where a thought ends.
 *
 * @var array $s
 * @var array $c
 */

declare(strict_types=1);

$align = (string) ($s['align'] ?? 'open');
$body  = (array) ($s['body'] ?? []);
$id    = !empty($s['id']) ? ' id="' . e($s['id']) . '"' : '';
?>
<section class="c-film-chapter c-film-chapter--<?= e($align) ?>"<?= $id ?>>
    <div class="c-film-chapter__inner">

<?php if ($align === 'open'): ?>
        <div class="c-film-chapter__head">
<?php if (!empty($s['index'])): ?>
            <span class="c-film-chapter__index"><?= e($s['index']) ?></span>
<?php endif; ?>
<?php if (!empty($s['eyebrow'])): ?>
            <p class="c-film-chapter__eyebrow" data-reveal><?= e($s['eyebrow']) ?></p>
<?php endif; ?>
<?php if (!empty($s['title'])): ?>
            <h2 class="c-film-chapter__title" data-reveal-lines><?= e($s['title']) ?></h2>
<?php endif; ?>
        </div>
<?php endif; ?>

<?php if (!empty($s['lede'])): ?>
        <p class="c-film-chapter__lede" data-reveal-lines><?= e($s['lede']) ?></p>
<?php endif; ?>

<?php if ($body !== []): ?>
        <div class="c-film-chapter__body">
<?php foreach ($body as $paragraph): ?>
            <p data-reveal><?= e($paragraph) ?></p>
<?php endforeach; ?>
        </div>
<?php endif; ?>
    </div>
</section>
