<?php
/**
 * The mobile navigation: the button that opens it, and the full-screen panel
 * it opens. Included from header.php, so both live inside <header> and the
 * button sits in the header's layout without being positioned by hand.
 *
 * Below 1024px the horizontal navigation is hidden and this takes over. Above
 * it, both the button and the panel are display: none and nothing here is
 * reachable — including by keyboard, which is why it is display and not
 * opacity.
 *
 * WITHOUT JAVASCRIPT the button is hidden and the horizontal navigation stays
 * on screen at every width instead, wrapping onto two lines. A button that
 * opens nothing is worse than a navigation that looks cramped, and a mobile
 * reader without JS still has every link. See .has-js in main.css.
 *
 * The panel repeats the same nav_pages() loop as the header rather than being
 * handed a copy of it: one routing table, two renderings, and adding a page
 * still means editing one line in routes.php.
 *
 * Behaviour — focus trap, Escape, scroll lock — is in assets/js/main.js. The
 * hooks it looks for are the data- attributes; the classes are for CSS only.
 */

declare(strict_types=1);

require_once TEMPLATES_PATH . '/partials/seal.php';

/** The panel's id, referenced by aria-controls on the button. */
$drawerId = 'site-drawer';
?>

<button
    class="c-drawer__toggle"
    type="button"
    aria-expanded="false"
    aria-controls="<?= e($drawerId) ?>"
    data-drawer-toggle
>
    <?php /* Two bars, drawn in CSS, that cross into a close icon when open. */ ?>
    <span class="c-drawer__bars" aria-hidden="true"></span>
    <span class="u-visually-hidden"><?= e(t('nav.menu')) ?></span>
</button>

<?php /*
    data-mood="dusk" rather than a colour in the component: the panel stands on
    --green-800 with cream text and gold, which is exactly the dusk
    temperature. It is the page's own mechanism (§3 of main.css) applied to one
    element, so the drawer looks the same over a cream page as over a wine one.
*/ ?>
<div class="c-drawer" id="<?= e($drawerId) ?>" data-mood="dusk" data-drawer>
    <div class="c-drawer__inner">

        <?php seal('auto', 'md'); ?>

        <nav class="c-drawer__nav" aria-label="<?= e(t('nav.drawer_label')) ?>">
            <ul class="c-drawer__list">
<?php foreach (nav_pages() as $pageId): ?>
                <li>
                    <a class="c-drawer__link" href="<?= e(url($pageId)) ?>"<?= is_current($pageId) ? ' aria-current="page"' : '' ?>><?= e(t('nav.' . $pageId)) ?></a>
                </li>
<?php endforeach; ?>
            </ul>
        </nav>

        <a class="c-btn c-btn--primary c-drawer__action" href="<?= e(url(NAV_ACCENT)) ?>"<?= is_current(NAV_ACCENT) ? ' aria-current="page"' : '' ?>><?= e(t('nav.' . NAV_ACCENT)) ?></a>

    </div>
</div>
