<?php
/**
 * The letterhead: the seal, two rules, and the estate's address.
 *
 * THE ONE COMPONENT MEMBERSHIP ADDS, AND IT EXISTS BECAUSE NOTHING ON THIS SITE
 * DRAWS A DOCUMENT. The brief asks for an editorial, document-inspired moment
 * around the application — the estate's seal, thin rules, serif type, very
 * subtle texture — and explicitly asks that it read as private correspondence
 * rather than as government paperwork. Every existing block was tried against
 * that first:
 *
 *   film-chapter    a heading and paragraphs. It cannot centre a mark, and the
 *                   thing this scene is mostly made of is a mark.
 *   film-band       a picture with type over it. There is no picture here, and
 *                   a band with an empty frame is a band that failed to load.
 *   film-invitation the seal, a line and two actions — the closest of the four,
 *                   and wrong in the one way that matters: it is the LAST
 *                   screen of a page and it ends on buttons. This scene is the
 *                   HEAD of the screen below it and must not offer a way out of
 *                   it. Adding an "actions are optional" branch to the block
 *                   that closes six approved pages, to serve one that isn't
 *                   closing anything, is how a component starts meaning two
 *                   things.
 *   seam            a rule with a crest on it, between two temperatures. It is
 *                   the non-film pages' block, it is decorative by definition,
 *                   and it carries no type at all.
 *
 * IT IS THIRTY LINES AND IT IS THE WHOLE OF THE NEW SURFACE ON THIS PAGE.
 *
 * THE CREST IS THE SUBJECT HERE AND IT IS RENDERED THROUGH THE PARTIAL, which
 * is the arrangement the approved /membership already had and this inherits.
 * ARCHITECTURE §8.5 says the crest appears rarely and in places that mean
 * something, and that in four places on the site it is a mark ON something —
 * a seam, a footer, a drawer, a hero — printed aria-hidden because the wordmark
 * is beside it in text. This is the fifth place and the only one where it
 * stands alone with no wordmark next to it, so it is printed with
 * decorative: false and names itself to a screen reader through t('a11y.crest').
 * There is exactly one on this page; a second would spend it.
 *
 * THE TEXTURE IS THE SITE'S GRAIN AND NOT A NEW ONE. home.css §3 already mixes
 * a grain over the film's grounds; membership.css §6 lifts its opacity inside
 * this block and adds nothing. A second noise layer on one component is a
 * second answer to a question the design system already answered.
 *
 * WHAT IT WILL NOT PRINT. No date, no reference number, no clause, no signature
 * rule, no "Form MM-1". Each of those is what the brief means by government
 * paperwork, and each would also be a fact the estate has not settled. The
 * component takes an eyebrow, some address lines and one note, and it has
 * nowhere to put anything else.
 *
 * Fields
 *   id       anchor for the section
 *   index    optional scene number
 *   eyebrow  the name at the head of the sheet
 *   lines    string[] — the address, a line each
 *   note     one line under the lower rule: what the sheet is
 *
 * @var array $s this section
 * @var array $c the page content
 */

declare(strict_types=1);

require_once TEMPLATES_PATH . '/partials/seal.php';

$lines = array_values(array_filter(
    (array) ($s['lines'] ?? []),
    static fn ($line): bool => is_string($line) && $line !== ''
));

$id = !empty($s['id']) ? ' id="' . e($s['id']) . '"' : '';
?>
<section class="c-letterhead"<?= $id ?>>
    <div class="c-letterhead__sheet">

        <?php seal('auto', 'lg', decorative: false); ?>

<?php if (!empty($s['eyebrow'])): ?>
        <p class="c-letterhead__name"><?= e($s['eyebrow']) ?></p>
<?php endif; ?>

        <span class="c-letterhead__rule" aria-hidden="true"></span>

<?php if ($lines !== []): ?>
        <?php /*
            An <address> because it is one — the estate's own postal address,
            which is what <address> is for when it belongs to the page's owner.
            The same four lines are on /contact, where they are the subject; here
            they are the head of a sheet, and neither page invents them: both
            read Konkordijas iela 66 out of the content layer.
        */ ?>
        <address class="c-letterhead__address">
<?php foreach ($lines as $index => $line): ?>
            <?= e($line) ?><?= $index < count($lines) - 1 ? '<br>' : '' ?>
<?php endforeach; ?>
        </address>
<?php endif; ?>

<?php if (!empty($s['note'])): ?>
        <span class="c-letterhead__rule" aria-hidden="true"></span>

        <?php /*
            NOT A HEADING. It names the sheet, and the heading of this scene is
            the form's own <h2> on the screen below — which is also the form's
            accessible name (see partials/form.php). A second h2 here would put
            two headings on one document and make the outline say the form is a
            subsection of a letterhead.
        */ ?>
        <p class="c-letterhead__note"><?= e($s['note']) ?></p>
<?php endif; ?>

<?php if (!empty($s['index'])): ?>
        <span class="c-letterhead__index"><?= e($s['index']) ?></span>
<?php endif; ?>
    </div>
</section>
