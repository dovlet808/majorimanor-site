<?php
/**
 * legal-index — the contents of the privacy policy.
 *
 * ONE LIST, TWO BEHAVIOURS, AND NO SECOND COPY OF IT. Below 1080px it is what
 * the brief asks for on a phone — "small top-level legal navigation" — a green
 * band of anchors standing between the hero and the document. Above 1080px the
 * same element becomes the sticky index in the left column. Rendering the list
 * twice and hiding one of them would put every clause of this policy into the
 * accessibility tree twice, which is the one thing a document navigator must
 * not do.
 *
 * THE GREEN IS THE BRIEF'S OWN RHYTHM. "DARK CINEMATIC HERO -> WARM CREAM LEGAL
 * DOCUMENT -> SUBTLE GREEN / LEGAL NAV -> WARM CREAM -> DARK FOOTER." This is
 * the green: a --green-900 panel standing on the cream, which is the estate's
 * daylight colour and the one ground on this site that has always meant
 * "official". The document around it stays light, because the readable legal
 * surface is not allowed to go dark.
 *
 * IT IS A CONVENIENCE AND NOT THE INTERACTION. Every link is an ordinary
 * in-page anchor and works with no JavaScript at all; privacy.js adds the
 * active mark and nothing else, and its failure costs a reader nothing they
 * cannot get by scrolling. See privacy.js.
 *
 * THE NUMBERS ARE THE PAGE TEMPLATE'S, computed from 'sections'. A sub-clause
 * takes no number and is indented under the clause it belongs to — the same
 * shape the document itself has.
 *
 * ONE THING WAS ADDED FOR /terms AND IT IS ADDITIVE IN THE STRICT SENSE. That
 * page is two documents rather than one — the terms, and the impressum that is
 * the legally required part — and it marks the seam between them in the
 * document with a green chapter field. An index that showed seven flat rows
 * where the page shows two chapters would be a contents that disagrees with its
 * own document, which on a legal page is the one thing a contents may not do.
 *
 * SO AN ENTRY MAY CARRY A 'chapter', AND ONLY /terms' PLAN EVER DOES.
 * templates/pages/privacy.php builds its plan out of 'index' and 'subs' and
 * sets no such key, so the branch below is false twelve times out of twelve on
 * that page and its markup is byte for byte what it was. Proved rather than
 * assumed — tools/compare_pages.sh, in docs/TERMS.md §7.
 *
 * THE MARK IS INSIDE THE <li>, WHICH IS WHY IT IS DRAWN WHERE IT IS. An <ol>
 * may contain nothing but <li>, so a divider between two rows has to live
 * inside the row it introduces; it is aria-hidden, because the chapter is
 * already announced in the document by the field itself and a contents that
 * reads out "two, impressum, seven, impressum" is a contents nobody can use.
 *
 * THE DATE IS AT THE HEAD OF THE PANEL AND AGAIN AT THE FOOT OF THE DOCUMENT,
 * and that is deliberate rather than a duplicate: when a policy last changed is
 * the second thing anybody wants from one, and the foot of a long document is
 * a long way to scroll to find it. Both print the same t('legal.updated') and
 * the same <time>, from the same 'updated' in the content file.
 *
 * @var array $s   ['plan' => the numbered sections, 'updated' => unix time|false]
 * @var array $c   the page content
 */

declare(strict_types=1);

/** @var array $plan one entry per clause: ['id', 'title', 'index', 'level'] */
$plan = (array) ($s['plan'] ?? []);

if ($plan === []) {
    return;
}

$doc     = (array) ($c['document'] ?? []);
$label   = (string) ($doc['contents'] ?? 'Contents');
$aria    = (string) ($doc['contents_aria'] ?? $label);
$updated = $s['updated'] ?? false;
?>
<nav class="c-legal-index" aria-labelledby="contents-label" data-legal-index>
    <div class="c-legal-index__inner">

        <p class="c-legal-index__label" id="contents-label"><?= e($label) ?></p>

<?php if ($updated !== false): ?>
        <p class="c-legal-index__updated">
            <?= e(t('legal.updated')) ?>
            <time datetime="<?= e(date('Y-m-d', $updated)) ?>"><?= e(date('j F Y', $updated)) ?></time>
        </p>
<?php endif; ?>

<?php
        /*
           NESTED, BECAUSE THE DOCUMENT IS. The two sub-clauses belong inside
           clause 03 and a flat list would announce them as items four and five
           of ten. The inner <ol> is what makes a screen reader say "list of
           two" in the right place, and it is also what the indent is drawn
           from rather than a margin on a class.
        */
?>
        <ol class="c-legal-index__list">
<?php foreach ($plan as $entry): ?>
            <li class="c-legal-index__item">
<?php if (!empty($entry['chapter']['label'])): ?>
                <p class="c-legal-index__chapter" aria-hidden="true">
<?php if (!empty($entry['chapter']['numeral'])): ?>
                    <span class="c-legal-index__chapter-n"><?= e((string) $entry['chapter']['numeral']) ?></span>
<?php endif; ?>
                    <?= e((string) $entry['chapter']['label']) ?>
                </p>
<?php endif; ?>
                <a class="c-legal-index__link" href="#<?= e((string) $entry['id']) ?>" data-legal-index-link>
                    <span class="c-legal-index__n" aria-hidden="true"><?= e((string) ($entry['index'] ?? '')) ?></span>
                    <span class="c-legal-index__title"><?= e((string) $entry['title']) ?></span>
                </a>

<?php if (!empty($entry['subs'])): ?>
                <ol class="c-legal-index__list c-legal-index__list--sub">
<?php foreach ((array) $entry['subs'] as $sub): ?>
                    <li class="c-legal-index__item">
                        <a class="c-legal-index__link" href="#<?= e((string) $sub['id']) ?>" data-legal-index-link>
                            <span class="c-legal-index__title"><?= e((string) $sub['title']) ?></span>
                        </a>
                    </li>
<?php endforeach; ?>
                </ol>
<?php endif; ?>
            </li>
<?php endforeach; ?>
        </ol>

    </div>
</nav>
