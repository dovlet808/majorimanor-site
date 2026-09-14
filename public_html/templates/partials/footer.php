<?php
/**
 * Site footer.
 *
 * Seal, wordmark, what the place is, where it is, four links, one address, and
 * MEMBERS & GUESTS at the bottom. Nothing else — a footer full of columns is a
 * sitemap, and this site has seven pages.
 *
 * It stands on --green-900 on every page, whatever temperature the page above
 * it is running. The page ends here and the estate closes for the night; a
 * footer that changed colour with the page would read as one more section.
 * data-ground="deep" is what does it, and it lives with the other grounds in
 * §3 of main.css rather than in the component, so nothing here names a brand
 * colour.
 *
 * The address is printed in full rather than obfuscated: the mailbox exists,
 * SPF, DKIM and DMARC are configured, and a contact address a reader cannot
 * copy is worse than the spam it avoids.
 */

declare(strict_types=1);

require_once TEMPLATES_PATH . '/partials/seal.php';

$email  = t('footer.email');
$social = social_links();
?>
<footer class="c-footer" data-ground="deep">
    <div class="wrap c-footer__inner">

        <?php seal('auto', 'sm'); ?>

        <p class="c-footer__wordmark"><?= e(t('site.name')) ?></p>
        <p class="u-eyebrow c-footer__tagline"><?= e(t('footer.tagline')) ?></p>
        <p class="c-footer__location"><?= e(t('footer.location')) ?></p>

        <nav class="c-footer__nav" aria-label="<?= e(t('footer.links_aria_label')) ?>">
            <ul class="c-footer__links">
<?php foreach (FOOTER_LINKS as $pageId): ?>
                <li>
                    <a href="<?= e(url($pageId)) ?>"<?= is_current($pageId) ? ' aria-current="page"' : '' ?>><?= e(t('nav.' . $pageId)) ?></a>
                </li>
<?php endforeach; ?>
            </ul>
        </nav>

<?php if ($email !== ''): ?>
        <p class="c-footer__contact">
            <a href="mailto:<?= e($email) ?>"><?= e($email) ?></a>
        </p>
<?php endif; ?>

<?php
    /*
       Social. SOCIAL is empty until the owner supplies the real addresses
       (ARCHITECTURE §14, open question 8), and an empty list renders nothing
       at all — no heading, no row, no gap where one will be. An invented
       Instagram link would be a link to somebody else's account.
    */
?>
<?php if ($social !== []): ?>
        <nav class="c-footer__nav" aria-label="<?= e(t('footer.social_aria_label')) ?>">
            <ul class="c-footer__links">
<?php foreach ($social as $link): ?>
                <li>
                    <a href="<?= e($link['url']) ?>" rel="noopener"><?= e($link['label']) ?></a>
                </li>
<?php endforeach; ?>
            </ul>
        </nav>
<?php endif; ?>

        <p class="u-eyebrow c-footer__members"><?= e(t('footer.members')) ?></p>

    </div>
</footer>
