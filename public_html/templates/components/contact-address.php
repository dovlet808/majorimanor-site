<?php
/**
 * contact-address — the postal address, set as the thing the page is about.
 *
 * THE STREET AND THE NUMBER ARE THE HEADING. On every other page of this site
 * an address is a line of small type at the bottom of a footer; on this one it
 * is the answer to the question the reader arrived with, so "Konkordijas iela
 * 66" is the <h2> of the scene, at the size the film gives a chapter heading,
 * and the town, the postcode and the country stand under it in the film's
 * muted ink.
 *
 * IT IS AN <address> ELEMENT AND THAT IS NOT DECORATION. It is the element that
 * means "how to reach the thing this page is about" and it is what a screen
 * reader announces as contact details — the same reasoning components/split.php
 * carries, kept, because it was right there and this component replaces that
 * one on this page. The italics browsers give it are undone in contact.css: the
 * meaning is wanted, the default styling is not.
 *
 * THE HEADING IS INSIDE THE <address>, WHICH IS DELIBERATE AND IS WHY THE
 * MARKUP LOOKS UNUSUAL. A heading that reads "Konkordijas iela 66" and an
 * <address> underneath holding the rest of the same address are one address cut
 * in half: a reader selecting it gets two lines out of four, and a screen
 * reader announcing the contact block leaves the street out of it. So the whole
 * address is one element, and the first line of it happens to be a heading.
 *
 * THE MAILBOX IS PRINTED IN FULL AND LINKED, for the reason partials/footer.php
 * gives: it exists, SPF, DKIM and DMARC are configured, and an address a reader
 * cannot copy or click is worse than the spam it avoids.
 *
 * THE PROSE SITS BESIDE THE ADDRESS ABOVE 1080px AND UNDER IT BELOW, and the
 * address comes first in the markup either way, so a reader on a phone gets
 * what they came for before the sentence about how post is handled.
 *
 * NOTHING HERE IS REVEALED BY SCRIPT. Every line is in the DOM on the first
 * byte; [data-reveal] is a transform home.js applies to an element that already
 * carries its text. A crawler, a reader with JavaScript off and a reader who
 * has asked for reduced motion all get the whole address.
 *
 * Fields
 *   id       anchor for the section — the hero's cue points at it
 *   index    the scene number, e.g. '01'
 *   eyebrow  the tracked line above the heading
 *   title    the first line of the address, set as display type
 *   address  string[] — the remaining lines, printed as written
 *   email    the mailbox, printed and linked
 *   email_label  the tracked line above it
 *   body     string[] — a paragraph each, beside or under the address
 *
 * @var array $s this section
 * @var array $c the page content
 */

declare(strict_types=1);

$id      = (string) ($s['id'] ?? '');
$title   = (string) ($s['title'] ?? '');
$lines   = array_values(array_filter((array) ($s['address'] ?? []), 'strlen'));
$email   = (string) ($s['email'] ?? '');
$body    = (array) ($s['body'] ?? []);
?>
<section class="c-contact-place"<?= $id !== '' ? ' id="' . e($id) . '"' : '' ?>>
    <div class="c-contact-place__inner">

        <address class="c-contact-place__address">
<?php if (!empty($s['index'])): ?>
            <span class="c-contact-place__index"><?= e($s['index']) ?></span>
<?php endif; ?>
<?php if (!empty($s['eyebrow'])): ?>
            <span class="c-contact-place__eyebrow" data-reveal><?= e($s['eyebrow']) ?></span>
<?php endif; ?>

<?php if ($title !== ''): ?>
            <h2 class="c-contact-place__street" data-reveal-lines><?= e($title) ?></h2>
<?php endif; ?>

<?php if ($lines !== []): ?>
            <span class="c-contact-place__lines" data-reveal>
<?php foreach ($lines as $index => $line): ?>
                <?= $index > 0 ? '<br>' : '' ?><?= e((string) $line) ?>
<?php endforeach; ?>
            </span>
<?php endif; ?>

<?php if ($email !== ''): ?>
            <span class="c-contact-place__mailbox" data-reveal>
<?php if (!empty($s['email_label'])): ?>
                <span class="c-contact-place__eyebrow"><?= e($s['email_label']) ?></span>
<?php endif; ?>
                <a class="c-contact-place__email" href="mailto:<?= e($email) ?>"><?= e($email) ?></a>
            </span>
<?php endif; ?>
        </address>

<?php if ($body !== []): ?>
        <div class="c-contact-place__body">
<?php foreach ($body as $paragraph): ?>
            <p data-reveal><?= e((string) $paragraph) ?></p>
<?php endforeach; ?>
        </div>
<?php endif; ?>
    </div>
</section>
