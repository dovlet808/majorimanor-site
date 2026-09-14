<?php
/**
 * clause — one clause of a legal document.
 *
 * A heading, some paragraphs, an optional list, and an optional gap marked as
 * a gap. Privacy and Terms are built entirely out of these, in the order the
 * content file lists them, inside the one measure column that pages/legal.php
 * puts round the lot.
 *
 * IT IS NOT A .section, AND IT IS THE ONE COMPONENT ON THIS SITE THAT IS NOT.
 * Every other block is a band across the page with a section's worth of air
 * above and below it; a legal page is a single document, and 180px between
 * "What the forms collect" and "Where it goes" would turn twelve clauses into
 * twelve pages. The document is one .section, provided by the page template,
 * and the rhythm inside it is .stack's — which is the same division of labour
 * as everywhere else, applied one level down.
 *
 * 'standalone' IS THE EXCEPTION, AND IT IS ONE CLAUSE ON A PAGE OF BANDS.
 *
 * A legal sentence sometimes has to stand under a section of an ordinary page
 * rather than inside a document — /after-dark carries the licensing line under
 * the private gaming section (ARCHITECTURE §14.2). There is no document round
 * it there, so there is no .section, no .wrap and no measure round it either,
 * and without them the clause runs the full width of the window with the words
 * against the glass. 'standalone' => true prints the frame pages/legal.php
 * would have printed, and takes the fine-print treatment that page gives its
 * own closing line: --fs-sm under a hairline, softened on whatever ground it
 * lands on. See .c-clause--standalone in §7 of main.css.
 *
 * FINE PRINT IS A TREATMENT AND NOT A PLACE TO PUT SOMETHING. The line is set
 * small because a statement of fact under a section is set small, and the rule
 * above it attaches it to the block it belongs to. It is not there to be
 * missed, it is not collapsed, and it is not two clicks away.
 *
 * The band is tight at the top and full at the bottom: the clause belongs to
 * the section above it and not to the one below, so it opens on the hairline
 * rather than on a second section's worth of air.
 *
 * LINKS ARE NAMED, NOT WRITTEN. A content file may not contain markup, and a
 * legal document without a link in it is a document that tells somebody to
 * exercise a right and does not give them the address. So a paragraph writes
 * {email} or {privacy}, and the page declares what those mean:
 *
 *     'links' => [
 *         'email'   => ['email' => 'info@majorimanor.com'],
 *         'privacy' => ['page_id' => 'privacy', 'label' => 'privacy policy'],
 *     ],
 *
 * The text is escaped first and the anchor put in afterwards, which is the
 * same order the form's privacy notice uses and the only order that is safe:
 * escaping after the replacement would print the markup, and not escaping at
 * all would publish whatever a translator wrote. A token nobody declared is
 * left as it is and reported in DEV, so a typo shows up as a typo rather than
 * as a missing sentence.
 *
 * Fields
 *   id          anchor — every clause has one, so a paragraph can be linked to
 *   level       2 (default) or 3 — a sub-clause
 *   title       the heading
 *   body        string[] — a paragraph each
 *   list        string[] — an unordered list, printed after the body
 *   after       string[] — paragraphs printed after the list
 *   todo        string|string[] — a gap, marked as one. See below.
 *   standalone  true — print the band and the measure, and set it as fine
 *               print. For a clause outside a document. See above.
 *
 * THE TODO BLOCK IS DELIBERATELY VISIBLE IN PRODUCTION. The owner has not
 * supplied the company's legal name, its registration number or its registered
 * address (ARCHITECTURE §21, open question 4). The alternative to printing the
 * gap is filling it with something plausible, and a plausible registration
 * number on an impressum is a false statement about a legal entity. A visible
 * TODO is honest, it is embarrassing in exactly the way that gets it filled in,
 * and it is one line to remove.
 *
 * @var array $s this section
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

/** No document round this one: it prints its own band. See the note above. */
$standalone = !empty($s['standalone']);

/** The page's link vocabulary — see the note above. */
$clauseLinks = (array) ($c['links'] ?? []);

/**
 * One string of body text, escaped, with its {tokens} turned into anchors.
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
        trigger_error("clause: no link declared for '{$match[0]}'", E_USER_WARNING);
    }

    return $out;
};
?>
<?php if ($standalone): ?>
<section class="section c-clause-band">
    <div class="wrap">
<?php endif; ?>
<div class="c-clause<?= $standalone ? ' c-clause--standalone measure' : '' ?> stack"<?= $id !== '' ? ' id="' . e($id) . '"' : '' ?>>

<?php if ($title !== ''): ?>
<?php if ($level === 3): ?>
    <h3 class="c-clause__title"><?= e($title) ?></h3>
<?php else: ?>
    <h2 class="c-clause__title"><?= e($title) ?></h2>
<?php endif; ?>
<?php endif; ?>

<?php foreach ($body as $paragraph): ?>
    <p><?= $text((string) $paragraph) ?></p>
<?php endforeach; ?>

<?php if ($list !== []): ?>
    <ul class="c-clause__list">
<?php foreach ($list as $item): ?>
        <li><?= $text((string) $item) ?></li>
<?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php foreach ($after as $paragraph): ?>
    <p><?= $text((string) $paragraph) ?></p>
<?php endforeach; ?>

<?php foreach ($todo as $gap): ?>
    <p class="c-clause__todo">
        <span class="u-eyebrow c-clause__todo-label"><?= e(t('legal.todo')) ?></span>
        <?= $text((string) $gap) ?>
    </p>
<?php endforeach; ?>

</div>
<?php if ($standalone): ?>
    </div>
</section>
<?php endif; ?>
