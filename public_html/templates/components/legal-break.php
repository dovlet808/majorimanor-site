<?php
/**
 * legal-break — the seam between two chapters of a legal document.
 *
 * THE BRIEF FOR /terms ALLOWS WHAT THE BRIEF FOR /privacy DID NOT: "Unlike the
 * Privacy page, TERMS may contain subtle visual breaks between major legal
 * chapters… thin horizontal rules… a small Majori Manor seal… a muted
 * deep-green chapter field", followed immediately by the limit — "Do NOT insert
 * visuals so frequently that reading becomes annoying. One visual break after
 * approximately every 2–3 major sections is sufficient."
 *
 * THERE ARE SEVEN SECTIONS AND THERE ARE TWO BREAKS, and this file draws both.
 * They are declared in content/en/terms.php's 'chapters', keyed by the id of
 * the clause they stand BEFORE, so a break cannot drift when a clause moves and
 * no ordinal is written down twice.
 *
 * NEITHER OF THEM CARRIES A CLAUSE, A SUMMARY OR AN EXPLANATION, and that is
 * the rule this component exists to hold. A break on a legal page is furniture.
 * The moment one starts saying what the section under it means, the page has
 * grown a second, unapproved, unreviewed layer of legal text set in larger type
 * than the real one — which is exactly the failure the brief's "Do not invent a
 * new legal summary" is about. So the shapes below take an ornament, a numeral
 * and one label, and there is nowhere to put a sentence.
 *
 *   seal    a hairline with the estate's crest standing in the middle of it.
 *           Pure ornament: aria-hidden, no text, nothing to read. It is the
 *           site's own seam — components/seam.php does the same thing between
 *           two temperatures on the Main Page — at a document's scale.
 *
 *           IT IS GREEN AND NOT 'auto'. The page's mood is 'night', so the
 *           ground rules in main.css §3 resolve --seal-src to the gold crest;
 *           gold artwork on cream paper measures about 1.6:1 and reads as a
 *           smudge. Green is the estate's daylight colourway and the one this
 *           ground was drawn for. See terms.css §7.
 *
 *   field   the green chapter mark, and it is the only break on this page that
 *           means anything. content/en/terms.php has said since it was written
 *           that it holds TWO DOCUMENTS — the terms, and the impressum that is
 *           the legally required part — and until this page was rebuilt a
 *           reader had no way to see the seam between them. It prints a numeral
 *           and one word, and the word is the second half of the approved h1.
 *
 * THERE IS EXACTLY ONE CREST ON THIS PAGE AND THE SEAL BREAK HAS IT.
 * ARCHITECTURE §8.5 says the mark appears rarely and in places that mean
 * something, and film-letterhead.php puts the rule in one line — "There is
 * exactly one on this page; a second would spend it." So the field carries a
 * numeral, a word and a gold hairline, and no mark: the ornament was already
 * spent three clauses higher up.
 *
 * BOTH BREAKS ARE aria-hidden, AND THE SECOND ONE ONLY BECAME SO AFTER THE
 * ACCESSIBILITY TREE WAS READ.
 *
 * The seal was decorative from the first line: it is a crest between two rules
 * and it has no text in it.
 *
 * The field was not. It began as a <p> label — never an <h2>, because an <h2>
 * would have put "Impressum" into the document outline twice in a row, once as
 * furniture and once as the clause — inside a role="group" named by that label,
 * on the theory that a chapter is a region and a region should be announced.
 * Dumped, the tree read:
 *
 *     StaticText "IMPRESSUM"
 *     heading    "Impressum"
 *
 * which is the same word twice with nothing between them, and the second one is
 * the real heading of the real clause. The region added nothing a reader could
 * use and cost them a repetition at the one seam of the document where they
 * most want to know where they are.
 *
 * SO THE FIELD SAYS NOTHING NOW, AND NOTHING IS LOST BY IT. A chapter mark
 * whose entire content is the name of the single clause underneath it is, for
 * anybody not looking at the page, that clause's heading printed early. The
 * <h2> is two lines below and says it properly. This is the same call
 * legal-index.php makes about the same chapter for the same reason, and the
 * clause headings stay the only <h2>s on the page.
 *
 * IT IS NOT A GENERAL RULE ABOUT CHAPTER MARKS. A field whose label named a
 * chapter of several clauses would be carrying information the outline does not
 * have, and it should be announced. This one does not, and it should not.
 *
 * THE SHAPE IS 'break' AND NOT 'type', AND THAT IS A TRAP RATHER THAN A TASTE.
 * component() dispatches on 'type', and pages/terms.php hands a chapter to it
 * as ['type' => 'legal-break'] + the chapter — where PHP's + keeps the LEFT
 * value for a duplicate key. A chapter declaring 'type' => 'field' would have
 * that eaten by the dispatch and every break on the page would fall through to
 * the default. It did, on the first render.
 *
 * Fields
 *   break    'seal' | 'field'
 *   numeral  'II' — the chapter, printed for a field, ignored by a seal
 *   label    'Impressum' — one word, same
 *   id       optional anchor. Nothing links to one today.
 *
 * @var array $s this break
 * @var array $c the page content
 */

declare(strict_types=1);

require_once TEMPLATES_PATH . '/partials/seal.php';

$shape = (string) ($s['break'] ?? 'seal') === 'field' ? 'field' : 'seal';

if ($shape === 'seal') {
?>
<div class="c-legal-break c-legal-break--seal" aria-hidden="true">
    <span class="c-legal-break__rule"></span>
    <?php seal('green', 'md'); ?>
    <span class="c-legal-break__rule"></span>
</div>
<?php
    return;
}

$numeral = (string) ($s['numeral'] ?? '');
$label   = (string) ($s['label'] ?? '');
$id      = (string) ($s['id'] ?? '');
?>
<div class="c-legal-break c-legal-break--field"<?= $id !== '' ? ' id="' . e($id) . '"' : '' ?> aria-hidden="true">

<?php if ($numeral !== ''): ?>
    <p class="c-legal-break__numeral"><?= e($numeral) ?></p>
<?php endif; ?>

<?php if ($label !== ''): ?>
    <p class="c-legal-break__label"><?= e($label) ?></p>
<?php endif; ?>
</div>
