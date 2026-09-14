<?php
/**
 * Not found. Rendered through the ordinary layout, with a real 404 status set
 * by index.php before a byte of this is produced.
 *
 * THE CREST IS HERE FOR THE SAME REASON IT IS ON THE MEMBERSHIP PAGE AND FOR NO
 * OTHER (ARCHITECTURE §8.5): it is the subject of the band it stands in, not a
 * mark on something else. This is one of the few pages with nothing above the
 * fold but type, and the seal is what makes it the estate's page rather than a
 * server's. It is decorative in the strict sense — the wordmark is in the
 * header above it, in text — so it is aria-hidden and says nothing twice.
 *
 * The four links are the content file's, by page id, with their words from the
 * navigation strings. Nothing here is written in English.
 *
 * @var array $c
 */

declare(strict_types=1);

require_once TEMPLATES_PATH . '/partials/seal.php';

$links = array_values(array_filter(
    (array) ($c['links'] ?? []),
    static fn ($pageId): bool => is_string($pageId) && isset(routes()[$pageId])
));
?>
<section class="section p-404">
    <div class="wrap stack" style="--stack-space: var(--space-6)">

        <?php seal('auto', 'md'); ?>

        <h1 class="p-404__title"><?= e((string) ($c['title'] ?? '')) ?></h1>

        <p class="p-404__lede measure"><?= e((string) ($c['lede'] ?? '')) ?></p>

<?php if ($links !== []): ?>
<?php if (!empty($c['ways'])): ?>
        <p class="u-eyebrow p-404__ways"><?= e((string) $c['ways']) ?></p>
<?php endif; ?>

        <ul class="p-404__links">
<?php foreach ($links as $pageId): ?>
            <li><a class="c-more" href="<?= e(url($pageId)) ?>"><?= e(t('nav.' . $pageId)) ?></a></li>
<?php endforeach; ?>
        </ul>
<?php endif; ?>

    </div>
</section>
