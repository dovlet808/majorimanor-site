<?php
/**
 * Site header: wordmark, main navigation, and MEMBERSHIP as the single accent
 * action. Fixed to the top of the viewport on every page.
 *
 * The navigation loops over routes.php, so a new page is a line in the routing
 * table and nothing else. Order = routing-table order; the pages that do not
 * belong in the bar are listed in NAV_EXCLUDE, and MEMBERSHIP is pulled out of
 * it by NAV_ACCENT.
 *
 * TWO GROUNDS.
 *
 * Over a hero the header is transparent with cream text — the hero is a
 * photograph and the bar has no business drawing a box on it. Everywhere else,
 * and over a hero once it has scrolled away, it stands on the page's own
 * ground with a hairline under it. That second state is .is-solid, and which
 * one applies is decided in three places:
 *
 *   - PHP    a page with no hero renders .is-solid and never changes
 *   - JS     a page with a hero gets .is-solid added and removed on scroll
 *   - CSS    the <noscript> block in head.php makes every header solid
 *
 * So the order of trust runs: markup first, script last. With JavaScript off
 * the header is solid on every page and every link in it still works.
 *
 * Below 1024px the navigation is not here at all — it is the drawer in
 * nav-mobile.php, which also owns the button that opens it.
 */

declare(strict_types=1);

require_once TEMPLATES_PATH . '/partials/seal.php';

$hasHero = has_hero();
?>
<header class="c-header<?= $hasHero ? '' : ' is-solid' ?>"<?= $hasHero ? ' data-hero' : '' ?>>
    <div class="c-header__inner">

        <?php /*
            A text lockup, not an image. The vector wordmark is not drawn yet,
            and text is what should be there anyway: it is selectable, it
            scales, it costs no request, and it is the site's name in the
            accessibility tree without an alt attribute standing in for it.

            <!-- TODO: the designer's wordmark goes here, as inline <svg> with
                 currentColor, exactly like the seal. Keep the text as the
                 accessible name (.u-visually-hidden) when it does. -->
        */ ?>
        <a class="c-header__wordmark" href="<?= e(url('home')) ?>"<?= is_current('home') ? ' aria-current="page"' : '' ?>><?= e(t('site.name')) ?></a>

        <nav class="c-nav" aria-label="<?= e(t('nav.aria_label')) ?>">
            <ul class="c-nav__list">
<?php foreach (nav_pages() as $pageId): ?>
                <li>
                    <a class="c-nav__link" href="<?= e(url($pageId)) ?>"<?= is_current($pageId) ? ' aria-current="page"' : '' ?>><?= e(t('nav.' . $pageId)) ?></a>
                </li>
<?php endforeach; ?>
            </ul>
        </nav>

        <?php /*
            The single accent action, set apart from the navigation on purpose:
            it is the site's one conversion path (ARCHITECTURE §3.3) and it is
            not one more page among seven.
        */ ?>
        <a class="c-btn c-btn--outline c-header__action" href="<?= e(url(NAV_ACCENT)) ?>"<?= is_current(NAV_ACCENT) ? ' aria-current="page"' : '' ?>><?= e(t('nav.' . NAV_ACCENT)) ?></a>

<?php require TEMPLATES_PATH . '/partials/nav-mobile.php'; ?>

<?php
        // Language switcher slot. Renders itself as soon as a second language
        // is switched on in LANGS and templates/partials/lang-switcher.php
        // exists.
        $langSwitcher = TEMPLATES_PATH . '/partials/lang-switcher.php';
        if (count(LANGS) > 1 && is_file($langSwitcher)) {
            require $langSwitcher;
        }
?>
    </div>
</header>
