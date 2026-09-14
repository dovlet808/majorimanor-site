<?php
/**
 * prose — a column of text and nothing else.
 *
 * An optional heading and one or more paragraphs, held to --measure and
 * centred on the page. The column is centred; the text inside it is not,
 * because 34rem of centred prose is a poster and not something anybody reads.
 * 'align' => 'center' is there for the short introductory paragraph where
 * centring is the point.
 *
 * Fields
 *   eyebrow  optional tracked line above the heading
 *   title    optional h2
 *   body     string or string[] — one paragraph each
 *   align    'center' to centre the text as well as the column
 *   mood     day | dusk | night
 *
 * @var array $s this section
 * @var array $c the page content
 */

declare(strict_types=1);

$eyebrow = (string) ($s['eyebrow'] ?? '');
$title   = (string) ($s['title'] ?? '');
$body    = (array) ($s['body'] ?? []);
$centred = ($s['align'] ?? '') === 'center';

$mood = in_array($s['mood'] ?? null, MOODS, true) ? $s['mood'] : null;
?>
<section class="section c-prose<?= $centred ? ' c-prose--center' : '' ?><?= $mood ? ' section--' . e($mood) : '' ?>">
    <div class="wrap">
        <div class="c-prose__column measure stack">

<?php if ($eyebrow !== ''): ?>
            <p class="u-eyebrow"><?= e($eyebrow) ?></p>
<?php endif; ?>

<?php if ($title !== ''): ?>
            <h2><?= e($title) ?></h2>
<?php endif; ?>

<?php foreach ($body as $paragraph): ?>
            <p><?= e((string) $paragraph) ?></p>
<?php endforeach; ?>

        </div>
    </div>
</section>
