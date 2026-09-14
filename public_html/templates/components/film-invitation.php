<?php
/**
 * The last screen: the seal, one line, and two ways to write.
 *
 * IT IS NOT A BOOKING FORM AND IT DOES NOT PRETEND TO BE ONE. Both actions
 * lead to a page that already exists and already works — membership and
 * contact — and neither of them says "book". The house has not opened; there
 * is nothing to book, and a date picker on this page would be the first
 * dishonest thing on it.
 *
 * TWO ACTIONS, ONE ACCENT. The first is the site's single conversion path
 * (ARCHITECTURE §3.3) and carries the gold; the second is a quieter way to say
 * the same thing and carries a rule. A third would make neither of them the
 * one to press.
 *
 * The seal here is the gold master, not the cream one — this is the only place
 * on the page where the mark is an ornament rather than an identifier, and its
 * alt is empty for exactly that reason: the estate's name is already in the
 * heading beside it.
 *
 * AN ACTION MAY CARRY A QUERY, AND EVENTS IS THE FIRST TO USE ONE.
 *
 * components/cta.php — the block the non-film pages close on — has always let a
 * content file put ?subject=private-event on the address, and
 * components/form-enquiry.php reads that, checks it against the schema's own
 * option list and starts the select on it. So a reader who spent a page
 * thinking about a wedding lands on a form that is already about private
 * events, with no script, no session, and a link they can bookmark or forward.
 * The old /events did that; this component could not, and rebuilding that page
 * on the film would have quietly dropped it.
 *
 * IT IS THE SAME FOUR LINES cta.php ALREADY CARRIES, and it is additive: an
 * action with no 'query' produces exactly the href it produced before, which is
 * why the Main Page, THE ESTATE, THE CLUB and PADEL are byte-identical after
 * this change. Proved, not assumed — tools/compare_pages.sh.
 *
 * AN ACTION MAY ALSO CARRY AN ANCHOR, AND CONTACT IS THE FIRST TO USE ONE.
 *
 * 'anchor' => 'enquiry' appends '#enquiry' to the address the action already
 * resolved to. It exists because /contact closes on this component and the
 * thing it has to send a reader back to is a scene on the page they are
 * standing on: the form. Every other page's last screen points somewhere else,
 * which is why nothing needed it until now.
 *
 * IT IS FOUR MORE LINES, IN THE SAME PLACE, ADDITIVE IN THE SAME WAY. An action
 * with no 'anchor' produces exactly the href it produced before, so the six
 * approved pages that close on this component are byte-identical after it.
 * Proved, not assumed — tools/compare_pages.sh.
 *
 * A PAGE THAT POINTS AT ITSELF IS STILL A LINK AND NOT A BUTTON, deliberately:
 * it is an address a reader can middle-click, bookmark or send to somebody, and
 * with JavaScript off the browser jumps to the form the same as it always has.
 * home.js's 'anchors' job is what makes it a smooth scroll when the libraries
 * are there, and it is an enhancement rather than the mechanism.
 *
 * @var array $s
 * @var array $c
 */

declare(strict_types=1);

$seal    = (array) ($s['seal'] ?? []);
$actions = (array) ($s['actions'] ?? []);
$id      = !empty($s['id']) ? ' id="' . e($s['id']) . '"' : '';

/** The href of one action, with its query string and its fragment if it has them. */
$action_href = static function (array $action): string {
    $href = url((string) ($action['page_id'] ?? 'home'));

    $query = array_filter((array) ($action['query'] ?? []), 'is_scalar');

    if ($query !== []) {
        // http_build_query encodes the pair; e() escapes the result for the
        // attribute. Both, because they are two different jobs.
        $href .= '?' . http_build_query($query);
    }

    $anchor = trim((string) ($action['anchor'] ?? ''), '#');

    if ($anchor !== '') {
        $href .= '#' . rawurlencode($anchor);
    }

    return $href;
};
?>
<section class="c-film-invite"<?= $id ?>>
    <div class="c-film-invite__inner">

<?php if (!empty($seal['name'])): ?>
        <img class="c-film-invite__seal"
             src="<?= e(asset_url(IMG_ROOT . '/' . $seal['name'] . '-160.png')) ?>"
             srcset="<?= e(asset_url(IMG_ROOT . '/' . $seal['name'] . '-96.png')) ?> 96w, <?= e(asset_url(IMG_ROOT . '/' . $seal['name'] . '-160.png')) ?> 160w, <?= e(asset_url(IMG_ROOT . '/' . $seal['name'] . '-320.png')) ?> 320w"
             sizes="(min-width: 900px) 132px, 96px"
             width="160" height="160" alt="<?= e($seal['alt'] ?? '') ?>"
             loading="lazy" decoding="async">
<?php endif; ?>

<?php if (!empty($s['eyebrow'])): ?>
        <p class="c-film-invite__eyebrow" data-reveal><?= e($s['eyebrow']) ?></p>
<?php endif; ?>

        <h2 class="c-film-invite__title" data-reveal-lines><?= e($s['title'] ?? '') ?></h2>

<?php if (!empty($s['body'])): ?>
        <p class="c-film-invite__body" data-reveal><?= e($s['body']) ?></p>
<?php endif; ?>

<?php if ($actions !== []): ?>
        <div class="c-film-invite__actions">
<?php foreach ($actions as $action): ?>
            <a class="c-film-invite__action c-film-invite__action--<?= e($action['variant'] ?? 'quiet') ?>"
               href="<?= e($action_href($action)) ?>"><?= e($action['label']) ?></a>
<?php endforeach; ?>
        </div>
<?php endif; ?>
    </div>
</section>
