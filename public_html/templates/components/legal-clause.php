<?php
/**
 * legal-clause — one clause of the privacy policy, set as an editorial
 * document rather than as a run of paragraphs.
 *
 * IT IS components/clause.php's TEXT PIPELINE AND components/clause.php's
 * FIELDS, AND THAT IS THE POINT OF IT. Every string it prints comes out of
 * content/en/privacy.php through the same $text() closure, escaped first and
 * linked second, in the same order, with the same DEV warning for a token
 * nobody declared. What is different is the frame around the words: a number,
 * a rule, a head that can put that number in the margin, and a body held to a
 * reading measure. NOT ONE WORD OF THE POLICY IS TOUCHED BY THIS FILE.
 *
 * WHY IT IS NOT clause.php WITH A MODIFIER. clause.php draws /terms as well,
 * and /terms is outside this brief — "Modify ONLY /privacy". A class added
 * there would have to be proved inert on a second legal page; a second
 * component cannot reach one. The two files will diverge the day /terms is
 * rebuilt from this one, and until then the duplication is the cheaper risk.
 *
 * THE NUMBER IS COMPUTED AND NEVER WRITTEN DOWN. templates/pages/privacy.php
 * counts the level-2 clauses and hands each one its 'index'; a number typed
 * into the content file is a number that goes wrong the first time a clause
 * moves. Sub-clauses take no number at all — they are part of the clause above
 * them, and 03.1 on a two-item list is a filing system, not a document.
 *
 * IT IS NOT A .section AND IT CARRIES NO REVEAL. The document band is the
 * page template's, and nothing in here is hidden by CSS or by script at any
 * point: the brief's rule is that the legal text must be readable with
 * JavaScript off, so no element below has an opacity that anything has to put
 * back. See privacy.css §9.
 *
 * Fields
 *   id      anchor — the content file's own, unchanged, so every link that
 *           already points at #rights still lands on the same clause
 *   level   2 (default) or 3 — a sub-clause
 *   index   '01'…'10' — printed for a level-2 clause, absent on a sub-clause
 *   title   the heading
 *   body    string[] — a paragraph each
 *   list    string[] — an unordered list, printed after the body
 *   after   string[] — paragraphs printed after the list
 *   todo    string|string[] — a gap, marked as one. See below.
 *   subs    array[] — sub-clauses, rendered inside this one
 *
 * THE TODO BLOCK IS STILL DELIBERATELY VISIBLE IN PRODUCTION, and the brief
 * for this page says so twice: "Preserve the existing notice exactly" and "Do
 * NOT visually hide or de-emphasize legally important information." The owner
 * has not supplied the company's legal name, its registration number or its
 * registered address (ARCHITECTURE §21, open question 4). What changed is only
 * the treatment: it was a dashed --danger box and it is now a warm paper panel
 * with a wine edge and a wine label — a notice on the page rather than an
 * error in it. The word is still TODO and it is still t('legal.todo'), because
 * "to be supplied" reads as a decision and TODO reads as unfinished work.
 *
 * @var array $s this clause
 * @var array $c the page content
 */

declare(strict_types=1);

$level = (int) ($s['level'] ?? 2) === 3 ? 3 : 2;
$title = (string) ($s['title'] ?? '');
$body  = (array)  ($s['body'] ?? []);
$list  = (array)  ($s['list'] ?? []);
$after = (array)  ($s['after'] ?? []);
$todo  = (array)  ((array) ($s['todo'] ?? []));
$id    = (string) ($s['id'] ?? '');
$index = (string) ($s['index'] ?? '');
$subs  = (array)  ($s['subs'] ?? []);

/** The page's link vocabulary — 'links' in the content file. */
$clauseLinks = (array) ($c['links'] ?? []);

/**
 * One string of body text, escaped, with its {tokens} turned into anchors.
 *
 * components/clause.php's closure, character for character. The order is the
 * only safe one: escaping after the replacement would print the markup, and
 * not escaping at all would publish whatever a translator wrote.
 */
$text = static function (string $value) use ($clauseLinks): string {
    $out = e($value);

    foreach ($clauseLinks as $token => $link) {
        $needle = '{' . $token . '}';

        if (!str_contains($out, $needle)) {
            continue;
        }

        if (!empty($link['email'])) {
            $href  = 'mailto:' . (string) $link['email'];
            $label = (string) ($link['label'] ?? $link['email']);
        } elseif (!empty($link['page_id'])) {
            $href  = url((string) $link['page_id']);
            $label = (string) ($link['label'] ?? $link['page_id']);
        } else {
            continue;
        }

        $out = str_replace($needle, '<a href="' . e($href) . '">' . e($label) . '</a>', $out);
    }

    if (DEV && preg_match('/\{[a-z0-9_]+\}/', $out, $match)) {
        trigger_error("legal-clause: no link declared for '{$match[0]}'", E_USER_WARNING);
    }

    return $out;
};

/*
   The heading is labelled by its own id so a screen reader announcing the
   section says the clause's name rather than "section". Belt and braces on a
   document a reader may well be navigating by landmark.
*/
$headingId = $id !== '' ? $id . '-title' : '';
?>
<section class="c-legal-clause<?= $level === 3 ? ' c-legal-clause--sub' : '' ?>"<?= $id !== '' ? ' id="' . e($id) . '"' : '' ?><?= $headingId !== '' ? ' aria-labelledby="' . e($headingId) . '"' : '' ?>>

<?php if ($title !== ''): ?>
    <div class="c-legal-clause__head">
<?php if ($level === 3): ?>
        <h3 class="c-legal-clause__title"<?= $headingId !== '' ? ' id="' . e($headingId) . '"' : '' ?>><?= e($title) ?></h3>
<?php else: ?>
        <h2 class="c-legal-clause__title"<?= $headingId !== '' ? ' id="' . e($headingId) . '"' : '' ?>><?= e($title) ?></h2>
<?php endif; ?>

<?php
        /*
           The number is decoration for a reader who can see the index beside
           it, and noise for one who cannot: aria-hidden keeps "zero one" out
           of the announcement of every heading on the page. The index in the
           left column is the navigable copy of the same information.
        */
?>
<?php if ($index !== ''): ?>
        <p class="c-legal-clause__index" aria-hidden="true"><?= e($index) ?></p>
<?php endif; ?>
    </div>
<?php endif; ?>

    <div class="c-legal-clause__body">

<?php foreach ($body as $paragraph): ?>
        <p><?= $text((string) $paragraph) ?></p>
<?php endforeach; ?>

<?php if ($list !== []): ?>
        <ul class="c-legal-clause__list">
<?php foreach ($list as $item): ?>
            <li><?= $text((string) $item) ?></li>
<?php endforeach; ?>
        </ul>
<?php endif; ?>

<?php foreach ($after as $paragraph): ?>
        <p><?= $text((string) $paragraph) ?></p>
<?php endforeach; ?>

<?php foreach ($todo as $gap): ?>
        <aside class="c-legal-note">
            <p class="c-legal-note__label"><?= e(t('legal.todo')) ?></p>
            <p class="c-legal-note__body"><?= $text((string) $gap) ?></p>
        </aside>
<?php endforeach; ?>

    </div>

<?php
    /*
       The sub-clauses, inside the clause they belong to rather than beside it.
       The content file lists them flat and in order; pages/privacy.php groups
       them, so the nesting a reader sees is the nesting the document has.
    */
?>
<?php foreach ($subs as $sub): ?>
<?php if (is_array($sub)): ?>
    <?php component(['type' => 'legal-clause'] + $sub, $c); ?>
<?php endif; ?>
<?php endforeach; ?>

</section>
