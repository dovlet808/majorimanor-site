<?php
/**
 * The Main Page's footer.
 *
 * IT NOW CLOSES THE PAGE THE WAY THE SITE CLOSES EVERY OTHER PAGE — the seven
 * lines of partials/footer.php, in the same order, from the same strings in
 * common.php: the mark, what the place is, where it is, the row of links, the
 * address, and MEMBERS & GUESTS at the bottom. It used to carry four of them,
 * which made the last screen of the film quieter than the last screen of the
 * club page. Anything else added here has to earn its line.
 *
 * THE MARK IS THE SUPPLIED LOCKUP AND NOT TYPE. The house over the wordmark,
 * cut out of media_src/Majori_logo/Footer/2.jpeg and re-inked to the footer's
 * own cream by tools/brand/build_footer_lockup.py — the reasoning, including
 * why there is no rung above 480, is in that script. It carries the estate's
 * name as its alt because that is what the picture says; the wordmark beside
 * it is gone rather than repeated.
 *
 * THE ADDRESSES COME FROM routes.php through url(), so nothing here is written
 * down twice. The footer is the one place on this page that leaves it.
 *
 * The email is printed in full rather than obfuscated, for the reason given in
 * partials/footer.php: the mailbox exists and is configured, and an address a
 * reader cannot copy is worse than the spam it avoids.
 *
 * @var array $c
 */

declare(strict_types=1);

$footer = (array) ($c['footer'] ?? []);
$links  = (array) ($footer['links'] ?? []);
$email  = (string) t('footer.email');
?>
<footer class="c-film-foot">
    <div class="c-film-foot__inner">

        <img class="c-film-foot__lockup"
             src="<?= e(asset_url(IMG_ROOT . '/brand/lockup-cream-240.png')) ?>"
             srcset="<?= e(asset_url(IMG_ROOT . '/brand/lockup-cream-240.png')) ?> 240w, <?= e(asset_url(IMG_ROOT . '/brand/lockup-cream-360.png')) ?> 360w, <?= e(asset_url(IMG_ROOT . '/brand/lockup-cream-480.png')) ?> 480w"
             sizes="240px"
             width="240" height="115" alt="<?= e(t('site.name')) ?>"
             loading="lazy" decoding="async">

        <p class="c-film-foot__tagline"><?= e(t('footer.tagline')) ?></p>

        <p class="c-film-foot__place"><?= e(t('footer.location')) ?></p>

<?php if ($links !== []): ?>
        <nav class="c-film-foot__links" aria-label="<?= e(t('footer.links_aria_label')) ?>">
            <ul>
<?php foreach ($links as $pageId): ?>
                <li><a href="<?= e(url($pageId)) ?>"><?= e(t('nav.' . $pageId)) ?></a></li>
<?php endforeach; ?>
            </ul>
        </nav>
<?php endif; ?>

<?php if ($email !== ''): ?>
        <p class="c-film-foot__contact">
            <a href="mailto:<?= e($email) ?>"><?= e($email) ?></a>
        </p>
<?php endif; ?>

        <p class="c-film-foot__members"><?= e(t('footer.members')) ?></p>

<?php if (!empty($footer['note'])): ?>
        <p class="c-film-foot__note"><?= e($footer['note']) ?></p>
<?php endif; ?>
    </div>
</footer>
