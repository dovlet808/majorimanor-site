<?php
/**
 * chapter — the workhorse of the home page.
 *
 * The eight blocks of immersion (ARCHITECTURE §3.4) are eight calls to this
 * one component with different data and different temperatures. Inside: the
 * section number, an eyebrow, a display heading, a lede at --measure, a
 * photograph that runs past the text column to the edge of the page, and one
 * restrained link onward.
 *
 * NO CARDS, NO BUTTONS, NO TILES. This is a narrative and not a catalogue: a
 * reader is being walked into a house, one room per screen, and a row of
 * tiles would turn that into a menu. The link at the bottom is a line of text
 * with a hairline under it, and that is deliberately as loud as it gets.
 *
 * ODD AND EVEN MIRROR. The number decides — 01 puts the text left and the
 * image right, 02 swaps them — so eight chapters alternate without the content
 * file having to say so. 'flip' overrides it for a chapter that has to break
 * the rhythm.
 *
 * The image bleeds to the page margin on its outer side, and edge to edge
 * below 1024px where the two stack. It stops at the band rather than the
 * viewport past 1440px, which is where the page itself stops.
 *
 * Fields
 *   number   '01' — printed as given, so the content decides 01 or I or 1
 *   eyebrow  the small tracked line above the heading
 *   title    the heading
 *   lede     one paragraph, held to --measure
 *   image    ['name' => 'home/estate', 'alt' => …, 'ratio' => '3/2',
 *             'source' => 'photo']
 *   link     ['page_id' => 'estate', 'label' => 'Enter the estate']
 *   mood     day | dusk | night — this chapter's own temperature
 *   flip     true to mirror against what the number would do
 *
 * @var array $s this section
 * @var array $c the page content
 */

declare(strict_types=1);

$number  = (string) ($s['number'] ?? '');
$eyebrow = (string) ($s['eyebrow'] ?? '');
$title   = (string) ($s['title'] ?? '');
$lede    = (string) ($s['lede'] ?? '');
$image   = (array)  ($s['image'] ?? []);
$link    = (array)  ($s['link'] ?? []);

$mood = in_array($s['mood'] ?? null, MOODS, true) ? $s['mood'] : null;

/*
   Even numbers mirror. (int) on '01' is 1 and on '' is 0, so a chapter with
   no number simply takes the unmirrored layout rather than needing a rule of
   its own.
*/
$flip = $s['flip'] ?? ((int) $number % 2 === 0 && $number !== '');

/*
   The image is half the page above 1180px and the whole of it below, which is
   what the CSS does — so the browser is told exactly that and picks its rung
   off the real layout rather than off a guess.
*/
$sizes = '(min-width: 1180px) 52vw, 100vw';
?>
<section class="section c-chapter<?= $flip ? ' c-chapter--flip' : '' ?><?= $mood ? ' section--' . e($mood) : '' ?>">
    <div class="wrap c-chapter__inner">

        <div class="c-chapter__text">
<?php if ($number !== ''): ?>
            <?php /* Ornament: it numbers the walk through the house and says
                     nothing the document order does not already carry, so it
                     is not read out ahead of every heading on the page. */ ?>
            <p class="c-chapter__number" aria-hidden="true"><?= e($number) ?></p>
<?php endif; ?>

<?php if ($eyebrow !== ''): ?>
            <p class="u-eyebrow"><?= e($eyebrow) ?></p>
<?php endif; ?>

            <h2 class="c-chapter__title"><?= e($title) ?></h2>

<?php if ($lede !== ''): ?>
            <p class="c-chapter__lede measure"><?= e($lede) ?></p>
<?php endif; ?>

<?php if (!empty($link['page_id']) && !empty($link['label'])): ?>
            <p class="c-chapter__more">
                <a class="c-more" href="<?= e(url((string) $link['page_id'])) ?>"><?= e((string) $link['label']) ?></a>
            </p>
<?php endif; ?>
        </div>

<?php if (!empty($image['name'])): ?>
        <div class="c-chapter__figure">
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
<?php endif; ?>

    </div>
</section>
