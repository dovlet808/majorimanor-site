<?php
/**
 * TERMS & IMPRESSUM — the eleventh page, the last one, and the second document.
 *
 * IT IS /privacy's TEMPLATE WITH TWO THINGS ADDED, AND THAT IS DELIBERATE DOWN
 * TO THE VARIABLE NAMES. templates/pages/privacy.php ends with a note that says
 * so: "WHEN /terms IS REBRIEFED it should be rebuilt from templates/pages/
 * privacy.php and components/legal-clause.php." So the hero, the numbering, the
 * two-column frame, the index, the clause component and the foot are that
 * file's, unchanged, and what this one adds is the chapter breaks and the plan
 * that places them.
 *
 * THE OLD SHARED FRAME IS GONE. Both legal pages used to render through
 * templates/pages/legal.php — a title band, a column of clauses and a date.
 * /privacy left it in September and this page was the only thing still holding
 * it up; with this file it is unreachable and it has been deleted.
 * components/clause.php has NOT been touched, because AFTER DARK still prints
 * one standalone clause through it.
 *
 * THE HERO SAYS NOTHING THE DOCUMENTS DO NOT. Its eyebrow, its h1 and the line
 * under it are $c['title'] — the approved wording, in the one place it has
 * always lived — and the content file's 'hero' block carries the picture and
 * nothing else. No cue, no seal, no subtitle: this is a legal page, and a legal
 * page that opens on five stacked lines of display type is a poster.
 *
 * IT IS CLAMPED TO ABOUT 56svh by terms.css §2 — the brief asks for 45–65vh and
 * asks that the reading begin before the hero has eaten the screen. On a 900px
 * laptop the head of the index is above the fold.
 *
 * THE NUMBERING IS COMPUTED HERE AND NOWHERE ELSE. The content file lists seven
 * clauses and no sub-clauses; this file counts them, hands each its 01..07, and
 * keeps /privacy's sub-clause grouping so the two pages cannot drift apart the
 * day a term grows one. NOTHING BELOW READS OR CHANGES A WORD OF EITHER
 * DOCUMENT: it reads 'id', 'title' and 'level', and passes the rest of each
 * section through untouched.
 *
 * THE CHROME IS THE SITE'S. The content file sets 'own_chrome' => true,
 * layout.php leaves the site header and footer off, and this page renders the
 * film's own — film-nav.php builds itself from routes.php, so TERMS is still
 * absent from the bar (NAV_EXCLUDE) and still present in the footer
 * (FOOTER_LINKS), exactly as on the ten pages before it, and the bar cannot
 * point at this page because it never names it.
 *
 * @var array $c
 */

declare(strict_types=1);

require TEMPLATES_PATH . '/partials/film-nav.php';

/*
   The target of "Return to the top" at the foot of the document.

   It is an element rather than the bare '#' for two reasons: an anchor job
   ignores '#' and '#main' and would leave the browser to jump, and a focusable
   target is what moves the keyboard as well as the viewport. This page runs no
   motion layer, so the browser's own smooth scrolling — privacy.css §9 — is
   what eases it. Either way it is one link and it needs no script.
*/
?>
<span class="u-anchor" id="top" tabindex="-1"></span>
<?php

$title = (array) ($c['title'] ?? []);

component([
    'type'      => 'film-hero',
    'eyebrow'   => (string) ($title['eyebrow'] ?? ''),
    'title'     => (string) ($title['title'] ?? ''),
    'statement' => (string) ($title['lede'] ?? ''),
] + (array) ($c['hero'] ?? []), $c);

/* ---------------------------------------------------------------------------
   The plan: the sections, numbered, grouped, and with their breaks attached.

   in    content/en/terms.php's flat 'sections' list, and its 'chapters' map
   out   one entry per level-2 clause, each carrying its own 'index', its
         'subs', its 'chapter' if a break stands before it — and every other
         key of the section exactly as it was

   THE BREAK IS ATTACHED TO THE CLAUSE IT STANDS BEFORE rather than inserted
   into the list as an item of its own, and the reason is the index: a break in
   the 'sections' array would have to be skipped by the numbering, skipped by
   the contents, skipped by the observer that marks the clause being read, and
   remembered by whoever next touches any of the three. Hung off the clause it
   precedes, it is one key that two loops know about and nothing else has to.
   --------------------------------------------------------------------------- */

$chapters = (array) ($c['chapters'] ?? []);
$plan     = [];
$number   = 0;

foreach ((array) ($c['sections'] ?? []) as $section) {
    if (!is_array($section)) {
        continue;
    }

    $level = (int) ($section['level'] ?? 2) === 3 ? 3 : 2;

    if ($level === 3 && $plan !== []) {
        $plan[array_key_last($plan)]['subs'][] = $section;
        continue;
    }

    $number++;

    $id = (string) ($section['id'] ?? '');

    $plan[] = $section + [
        'index'   => str_pad((string) $number, 2, '0', STR_PAD_LEFT),
        'subs'    => [],
        'chapter' => $chapters[$id] ?? null,
    ];
}

/*
   The date the document last changed, from the content file. ISO in the
   content and in the datetime attribute, because that is the form a machine
   reads; spelled out on the page, because that is the form a person reads.
   The two lines pages/legal.php used to print, unchanged, so /terms and
   /privacy still print the same date the same way.
*/
$updated = (string) ($c['updated'] ?? '');
$stamp   = $updated !== '' ? strtotime($updated) : false;

$doc = (array) ($c['document'] ?? []);
?>
<section class="c-legal" id="document">
    <div class="c-legal__inner">

        <?php component(['type' => 'legal-index', 'plan' => $plan, 'updated' => $stamp], $c); ?>

        <div class="c-legal__doc">

<?php foreach ($plan as $clause): ?>
<?php if (!empty($clause['chapter'])): ?>
            <?php component(['type' => 'legal-break'] + (array) $clause['chapter'], $c); ?>
<?php endif; ?>
            <?php component(['type' => 'legal-clause'] + $clause, $c); ?>
<?php endforeach; ?>

            <div class="c-legal__foot">
<?php if ($stamp !== false): ?>
                <p class="c-legal__updated">
                    <?= e(t('legal.updated')) ?>
                    <time datetime="<?= e(date('Y-m-d', $stamp)) ?>"><?= e(date('j F Y', $stamp)) ?></time>
                </p>
<?php endif; ?>

<?php if (!empty($doc['top'])): ?>
                <a class="c-legal__top" href="#top"><?= e((string) $doc['top']) ?></a>
<?php endif; ?>
            </div>

        </div>
    </div>
</section>
<?php

require TEMPLATES_PATH . '/partials/film-footer.php';
