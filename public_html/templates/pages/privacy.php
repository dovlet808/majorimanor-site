<?php
/**
 * PRIVACY — the tenth page cut from the film, and the only one that is a
 * document.
 *
 * THE QUIET SIDE OF THE ESTATE. The nine approved pages are a film; this one is
 * a policy, and the two have exactly two things in common — the chrome and the
 * first screen. Everything under the hero is a reading surface: warm cream,
 * one column, a numbered index beside it, and about two and a half thousand
 * words of legal text that no script is allowed to be responsible for.
 *
 * IT NO LONGER SHARES A TEMPLATE WITH /terms, AND THAT IS THE SCOPE RULE RATHER
 * THAN A PREFERENCE. This file used to be two lines that required
 * pages/legal.php, which draws both legal pages out of one frame. The brief is
 * "Modify ONLY /privacy", so the shared frame is left exactly as it is —
 * /terms still renders through it, byte for byte — and this page grew its own.
 * When /terms is rebuilt it should be rebuilt from here.
 *
 * THE HERO SAYS NOTHING THE DOCUMENT DOES NOT. Its eyebrow, its h1 and the line
 * under it are $c['title'] — the approved wording, in the one place it has
 * always lived — and the content file's 'hero' block carries the picture and
 * nothing else. There is no cue, no seal and no subtitle: this is a policy, and
 * a policy that opens on five stacked lines of display type is a poster.
 *
 * IT IS CLAMPED TO ABOUT 62svh by privacy.css §2 — the brief asks for 50-70vh
 * and asks that the document begin before the hero has eaten the screen. On a
 * 900px laptop the head of the index is above the fold.
 *
 * THE NUMBERING IS COMPUTED HERE AND NOWHERE ELSE. The content file lists
 * twelve sections, ten of them level 2 and two of them sub-clauses of the
 * third. This file counts the level-2 clauses, hands each its 01..10, and hangs
 * the two sub-clauses inside the clause they belong to, so the index and the
 * document cannot disagree about either. NOTHING BELOW READS OR CHANGES A WORD
 * OF THE POLICY: it reads 'id', 'title' and 'level', and passes the rest of
 * each section through untouched.
 *
 * THE CHROME IS THE SITE'S. The content file sets 'own_chrome' => true,
 * layout.php leaves the site header and footer off, and this page renders the
 * film's own — film-nav.php builds itself from routes.php, so PRIVACY is still
 * absent from the bar (NAV_EXCLUDE) and still present in the footer
 * (FOOTER_LINKS), exactly as on the nine approved pages, and the bar cannot
 * point at this page because it never names it.
 *
 * @var array $c
 */

declare(strict_types=1);

require TEMPLATES_PATH . '/partials/film-nav.php';

/*
   The target of "Return to the top" at the foot of the document.

   It is an element rather than the bare '#' for two reasons: home.js's anchor
   job ignores '#' and '#main' and would leave the browser to jump, and a
   focusable target is what moves the keyboard as well as the viewport. With
   the motion layer it is eased by Lenis; without it the browser jumps. Either
   way it is one link and it needs no script.
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
   The plan: the sections, numbered and grouped.

   in    content/en/privacy.php's flat 'sections' list
   out   one entry per level-2 clause, each carrying its own 'index' and its
         'subs' — and every other key of the section exactly as it was
   --------------------------------------------------------------------------- */

$plan   = [];
$number = 0;

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

    $plan[] = $section + [
        'index' => str_pad((string) $number, 2, '0', STR_PAD_LEFT),
        'subs'  => [],
    ];
}

/*
   The date the document last changed, from the content file. ISO in the
   content and in the datetime attribute, because that is the form a machine
   reads; spelled out on the page, because that is the form a person reads.
   pages/legal.php's two lines, unchanged, so /terms and /privacy still print
   the same date the same way.
*/
$updated = (string) ($c['updated'] ?? '');
$stamp   = $updated !== '' ? strtotime($updated) : false;

$doc = (array) ($c['document'] ?? []);
?>
<section class="c-legal" id="policy">
    <div class="c-legal__inner">

        <?php component(['type' => 'legal-index', 'plan' => $plan, 'updated' => $stamp], $c); ?>

        <div class="c-legal__doc">

<?php foreach ($plan as $clause): ?>
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
