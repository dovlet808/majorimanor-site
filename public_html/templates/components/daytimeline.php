<?php
/**
 * daytimeline — A DAY AT MAJORI MANOR.
 *
 * Six hours down a hairline, from the first game of padel to the end of the
 * evening, closing on the line the whole block exists to earn:
 * *One estate. One membership. An entire day.*
 *
 * IT IS THE ARGUMENT FOR MEMBERSHIP, MADE AS A TIMETABLE. Everything above it
 * on the home page is a room; this is the day those rooms add up to, and it is
 * why it sits at the bottom of the walk rather than among the chapters.
 *
 * An ordered list, because the order is the content — these are hours and they
 * only mean anything in sequence. The rule down the left is drawn on the items
 * rather than on the list, so it runs continuously inside each column when the
 * six split into two, and stops where the last one does.
 *
 * The times are printed as given. A content file writes '09:00' and that is
 * what appears: no formatter, no locale, no chance of a 9 AM turning up in the
 * middle of the estate.
 *
 * Fields
 *   eyebrow  optional tracked line above the heading
 *   title    the heading
 *   rows     [['time' => '09:00', 'label' => 'Morning padel'], …]
 *   close    the closing line, centred and larger. A string, or an array of
 *            parts — see below
 *   mood     day | dusk | night
 *
 * WHY THE CLOSING LINE MAY ARRIVE IN PIECES.
 *
 * It is a brand formula (ARCHITECTURE §1) and it is three sentences long, so
 * on a narrow screen it has to wrap. Left to the browser it wraps wherever the
 * words run out — "One estate. One / membership." — and an orphaned "One" in
 * the middle of the line the whole block is building towards is the one break
 * that is worth spending markup on. No amount of measure or text-wrap fixes
 * it: every cap that keeps "One estate." alone also splits "One membership.".
 *
 * So the parts are given as an array and each is printed inline-block, which
 * makes the space between them the break the browser reaches for first. It is
 * a preference and not a rule: a part too wide for the screen still wraps
 * inside itself rather than pushing the page sideways.
 *
 * A plain string still works and simply wraps wherever it likes.
 *
 * @var array $s this section
 * @var array $c the page content
 */

declare(strict_types=1);

$eyebrow = (string) ($s['eyebrow'] ?? '');
$title   = (string) ($s['title'] ?? '');
$rows    = (array)  ($s['rows'] ?? []);

/** The closing line, as its parts — one part when the content gave a string. */
$close = array_values(array_filter(
    array_map('trim', array_map('strval', (array) ($s['close'] ?? []))),
    static fn (string $part): bool => $part !== ''
));

$mood = in_array($s['mood'] ?? null, MOODS, true) ? $s['mood'] : null;

/*
   THE BLOCK MAY CARRY THE DAY ACROSS ITS OWN LENGTH, AND IT IS OPT-IN.

   The home page's film asks this block to do the one thing it has always been
   describing: run morning into night behind itself, so the timetable is not
   read against a fixed ground but watched from one end of a day to the other.

   It is declared as two temperatures the block travels BETWEEN — 'from' and
   'to' — and printed as data attributes rather than as a class, because they
   are the ends of a passage rather than a state the block is in. home.js reads
   them and interpolates between the SAME three grounds §3 of main.css already
   defines. No new colour is introduced anywhere: 'day' is --cream, 'dusk' is
   --green-800, 'night' is --wine-900, exactly as everywhere else on the site.

   BOTH OR NEITHER, AND THEY MUST DIFFER. One end of a passage is not a
   passage, and a passage from a temperature to itself is a fixed ground with
   extra machinery behind it — so a content file that declares either of those
   gets the block it already had.

   A page that declares nothing here — /components does, and it is the only
   other page that uses this block — renders exactly the markup it rendered
   before this field existed. That is the requirement, not a courtesy.
*/
$from = (string) ($s['from'] ?? '');
$to   = (string) ($s['to'] ?? '');

$carries = in_array($from, MOODS, true) && in_array($to, MOODS, true) && $from !== $to;

if (!$carries && ($from !== '' || $to !== '') && DEV) {
    trigger_error("daytimeline(): '{$from}' to '{$to}' is not a passage — the ground stays fixed", E_USER_WARNING);
}
?>
<section class="section c-daytimeline<?= $mood ? ' section--' . e($mood) : '' ?>"<?= $carries ? ' data-from="' . e($from) . '" data-to="' . e($to) . '"' : '' ?>>
    <div class="wrap">

        <div class="c-daytimeline__head">
<?php if ($eyebrow !== ''): ?>
            <p class="u-eyebrow"><?= e($eyebrow) ?></p>
<?php endif; ?>

<?php if ($title !== ''): ?>
            <h2 class="c-daytimeline__title"><?= e($title) ?></h2>
<?php endif; ?>
        </div>

<?php if ($rows !== []): ?>
        <ol class="c-daytimeline__list" role="list">
<?php foreach ($rows as $row): ?>
<?php if (empty($row['time']) && empty($row['label'])) { continue; } ?>
            <li class="c-daytimeline__row">
                <p class="c-daytimeline__time"><?= e((string) ($row['time'] ?? '')) ?></p>
                <p class="c-daytimeline__label"><?= e((string) ($row['label'] ?? '')) ?></p>
            </li>
<?php endforeach; ?>
        </ol>
<?php endif; ?>

<?php if ($close !== []): ?>
        <p class="c-daytimeline__close"><?php foreach ($close as $i => $part): ?><?= $i > 0 ? ' ' : '' ?><span><?= e($part) ?></span><?php endforeach; ?></p>
<?php endif; ?>

    </div>
</section>
