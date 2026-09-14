<?php
/**
 * split — a text column and an image, side by side.
 *
 * Fifty-fifty above 1024px, stacked below it, and the image always comes
 * second in the markup so that a stacked reader gets the words first. 'flip'
 * swaps the two columns visually and changes nothing about that order.
 *
 * This is the inside-page workhorse the way chapter is the home page's: the
 * same pair of columns carries a room, a court, a service. What it is not is
 * a chapter — no number, no bleed, and the image is held to the ratio the
 * content asks for rather than to the page's edge.
 *
 * THE SECOND COLUMN IS A PICTURE OR A MAP, AND NEVER BOTH. 'map' hands the
 * column to components/map.php — which is how the contact page puts the
 * address on the left and the map on the right without a layout of its own,
 * and without a second component that is this one with a different thing in
 * it. A block that carries both declares its own ambiguity; the image wins and
 * DEV says so.
 *
 * 'details' is the other half of that page: the postal address and the mailbox,
 * in an <address> element, which is the element that means exactly this and is
 * what a screen reader announces as contact details. It sits under the prose
 * because the sentence about how enquiries are handled belongs above the
 * address, not after it.
 *
 * Fields
 *   eyebrow  optional tracked line
 *   title    optional h2
 *   body     string or string[]
 *   image    ['name' => …, 'alt' => …, 'ratio' => '4/5', 'source' => 'photo']
 *   map      the map section — see components/map.php for its fields
 *   details  ['address' => string[], 'email' => 'info@…']
 *   link     ['page_id' => …, 'label' => …] — the same restrained line as chapter
 *   flip     true puts the image on the left
 *   mood     day | dusk | night
 *
 * @var array $s this section
 * @var array $c the page content
 */

declare(strict_types=1);

$eyebrow = (string) ($s['eyebrow'] ?? '');
$title   = (string) ($s['title'] ?? '');
$body    = (array)  ($s['body'] ?? []);
$image   = (array)  ($s['image'] ?? []);
$map     = (array)  ($s['map'] ?? []);
$details = (array)  ($s['details'] ?? []);
$link    = (array)  ($s['link'] ?? []);
$flip    = !empty($s['flip']);

if (!empty($image['name']) && $map !== []) {
    if (DEV) {
        trigger_error('split: a block has both an image and a map — the map is dropped', E_USER_WARNING);
    }

    $map = [];
}

$mood = in_array($s['mood'] ?? null, MOODS, true) ? $s['mood'] : null;

// Half the page above 1024, the whole of it below — which is what the CSS does.
$sizes = '(min-width: 1024px) 46vw, 100vw';
?>
<section class="section c-split<?= $flip ? ' c-split--flip' : '' ?><?= $mood ? ' section--' . e($mood) : '' ?>">
    <div class="wrap c-split__inner">

        <div class="c-split__text stack">
<?php if ($eyebrow !== ''): ?>
            <p class="u-eyebrow"><?= e($eyebrow) ?></p>
<?php endif; ?>

<?php if ($title !== ''): ?>
            <h2><?= e($title) ?></h2>
<?php endif; ?>

<?php foreach ($body as $paragraph): ?>
            <p><?= e((string) $paragraph) ?></p>
<?php endforeach; ?>

<?php if ($details !== []): ?>
            <?php /*
                <address> rather than a couple of paragraphs: it is the element
                that means "how to reach the thing this page is about", and it
                is announced as such. The italics browsers give it are undone
                in the stylesheet — the meaning is wanted, the default styling
                is not.

                The mailbox is printed in full and linked. It exists, SPF, DKIM
                and DMARC are configured, and an address a reader cannot copy
                or click is worse than the spam it avoids.
            */ ?>
            <address class="c-split__details">
<?php foreach ((array) ($details['address'] ?? []) as $index => $line): ?>
                <?= $index > 0 ? '<br>' : '' ?><?= e((string) $line) ?>
<?php endforeach; ?>
<?php if (!empty($details['email'])): ?>
                <span class="c-split__email">
                    <a href="mailto:<?= e((string) $details['email']) ?>"><?= e((string) $details['email']) ?></a>
                </span>
<?php endif; ?>
            </address>
<?php endif; ?>

<?php if (!empty($link['page_id']) && !empty($link['label'])): ?>
            <p>
                <a class="c-more" href="<?= e(url((string) $link['page_id'])) ?>"><?= e((string) $link['label']) ?></a>
            </p>
<?php endif; ?>
        </div>

<?php if (!empty($image['name'])): ?>
        <div class="c-split__figure">
            <?= img(
                (string) $image['name'],
                $sizes,
                (string) ($image['alt'] ?? ''),
                [
                    'ratio'  => (string) ($image['ratio'] ?? '3/2'),
                    'source' => (string) ($image['source'] ?? 'photo'),
                ]
            ) ?>
        </div>
<?php elseif ($map !== []): ?>
        <div class="c-split__figure">
            <?php component(['type' => 'map'] + $map, $c); ?>
        </div>
<?php endif; ?>

    </div>
</section>
