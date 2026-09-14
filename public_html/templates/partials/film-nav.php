<?php
/**
 * The Main Page's navigation.
 *
 * THE LINKS ARE THE SITE'S LINKS, not this page's scenes. They are derived
 * from routes.php through nav_pages(), exactly as the site header derives its
 * own, so the Main Page and every other page name the same places in the same
 * order and a new page is still a line in the routing table and nothing else.
 * MEMBERSHIP is pulled out of that list by NAV_ACCENT and set apart as the one
 * accent action, again exactly as in the header — it is the site's single
 * conversion path (ARCHITECTURE §3.3), not one more label among seven.
 *
 * Labels come from t('nav.<page_id>') in content/<lang>/common.php and the
 * addresses from url(), so neither is written down twice and the Latvian
 * version needs nothing here.
 *
 * THE ACCENT ACTION MARKS ITSELF ON THE ONE PAGE IT POINTS AT, AND MEMBERSHIP
 * IS THAT PAGE. NAV_ACCENT lifts membership out of the link list, so it is the
 * only address in this bar that the loop below never sees and therefore the only
 * one is_current() was never asked about. On the eight other pages that is
 * invisible — the action is a way somewhere else. On /membership it was a gold
 * button pointing at the page the reader was already standing on, saying nothing
 * about it, while every other link in the bar knew how to say "you are here".
 *
 * IT IS FOUR LINES, IN TWO PLACES, AND IT IS ADDITIVE. is_current(NAV_ACCENT) is
 * false on every page but one, so the attribute and the class are printed on
 * /membership and nowhere else, and the Main Page, THE ESTATE, THE CLUB, PADEL,
 * EVENTS, RESIDENCES, AFTER DARK and CONTACT are byte-identical after this
 * change. Proved, not assumed — tools/compare_pages.sh.
 *
 * QUIET FIRST. Over the hero it is a hairline of cream type on the photograph
 * and nothing else: no bar, no ground, no rule. Past the hero it becomes
 * .is-compact — shorter, on a near-black ground, with one gold hairline under
 * it. Which state applies is decided in three places, in this order of trust:
 *
 *   PHP    with no JavaScript the bar renders in its quiet state and stays
 *          there; every link in it still works, because they are plain
 *          addresses and nothing here depends on script to resolve them
 *   JS     home.js adds and removes .is-compact against the hero's edge
 *   CSS    .has-js is what allows the transparent state at all — see the
 *          synchronous flag set in head.php
 *
 * BELOW 900px THE LINKS ARE NOT HERE, they are in the panel at the bottom of
 * this file: the same list, in a full-screen sheet, opened by one button. The
 * panel is in the markup on the first byte and is hidden with [hidden], so a
 * reader with no JavaScript is never shown a button that cannot do anything.
 * The footer of this page carries its own row of addresses for that reader.
 *
 * THE SHEET IS TALLER THAN A PHONE AND HAS TO BE ABLE TO SAY SO. Seven links
 * set as display type, the membership action and the place line come to about
 * 870px; a 667px handset is short of that by the height of the action, which
 * is the one link on the sheet the site is built to be clicked. So the panel
 * scrolls — and data-lenis-prevent is what allows it to. home.js stops Lenis
 * while the sheet is open, to hold the page still behind it, and a stopped
 * Lenis cancels every wheel and every touchmove on the document. That
 * attribute is the library's own way of being told that gestures inside this
 * element are not the page's: Lenis leaves them alone, the browser scrolls the
 * sheet natively, and overscroll-behavior: contain in home.css keeps the stop
 * at the end of it from reaching the page underneath.
 *
 * @var array $c
 */

declare(strict_types=1);

$nav = (array) ($c['nav'] ?? []);

/** @var string[] the main navigation, in routing-table order */
$items = nav_pages();
?>
<header class="c-film-nav" data-film-nav>
    <div class="c-film-nav__inner">

        <a class="c-film-nav__mark" href="<?= e(url('home')) ?>"<?= is_current('home') ? ' aria-current="page"' : '' ?>>
            <span class="c-film-nav__mark-name">Majori Manor</span>
        </a>

        <nav class="c-film-nav__links" aria-label="<?= e($nav['aria_label'] ?? t('nav.aria_label')) ?>">
            <ul>
<?php foreach ($items as $pageId): ?>
                <li><a<?= is_current($pageId) ? ' class="is-current" aria-current="page"' : '' ?> href="<?= e(url($pageId)) ?>"><?= e(t('nav.' . $pageId)) ?></a></li>
<?php endforeach; ?>
            </ul>
        </nav>

        <a class="c-film-nav__action<?= is_current(NAV_ACCENT) ? ' is-current' : '' ?>" href="<?= e(url(NAV_ACCENT)) ?>"<?= is_current(NAV_ACCENT) ? ' aria-current="page"' : '' ?>><?= e(t('nav.' . NAV_ACCENT)) ?></a>

        <button class="c-film-nav__toggle" type="button"
                aria-expanded="false" aria-controls="film-menu"
                data-film-nav-toggle>
            <span class="u-visually-hidden" data-film-nav-label><?= e($nav['open_label'] ?? t('nav.menu')) ?></span>
            <span class="c-film-nav__bars" aria-hidden="true"><i></i><i></i></span>
        </button>
    </div>
</header>

<div class="c-film-menu" id="film-menu" data-film-menu data-lenis-prevent hidden>
    <nav class="c-film-menu__inner" aria-label="<?= e($nav['aria_label'] ?? t('nav.aria_label')) ?>">
        <ul class="c-film-menu__list">
<?php foreach ($items as $index => $pageId): ?>
            <li style="--i: <?= (int) $index ?>">
                <a<?= is_current($pageId) ? ' class="is-current" aria-current="page"' : '' ?> href="<?= e(url($pageId)) ?>" data-film-menu-link>
                    <span class="c-film-menu__n"><?= e(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)) ?></span>
                    <span><?= e(t('nav.' . $pageId)) ?></span>
                </a>
            </li>
<?php endforeach; ?>
        </ul>

        <a class="c-film-menu__action<?= is_current(NAV_ACCENT) ? ' is-current' : '' ?>" href="<?= e(url(NAV_ACCENT)) ?>"<?= is_current(NAV_ACCENT) ? ' aria-current="page"' : '' ?> data-film-menu-link><?= e(t('nav.' . NAV_ACCENT)) ?></a>

        <p class="c-film-menu__place"><?= e($c['footer']['place'] ?? '') ?></p>
    </nav>
</div>
