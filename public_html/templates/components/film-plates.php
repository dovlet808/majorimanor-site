<?php
/**
 * A grid of photographs, laid out editorially rather than evenly.
 *
 * TWELVE COLUMNS AND NOTHING ELSE. Each plate declares 'span' (how many of the
 * twelve it takes), an optional 'offset' (how many it starts past the left
 * edge) and an optional 'raise' (whether it hangs lower than its neighbour).
 * That is the whole layout language, and it is deliberately small: three
 * numbers per plate is a layout somebody can read off the content file, and a
 * grid area string is not.
 *
 * Below 900px every plate is full width and in content order, because a
 * twelve-column asymmetry inside a 390px screen is six columns of nothing.
 * 'offset' and 'raise' are dropped there rather than scaled — a 1-column
 * offset on a phone is four pixels, which is not a composition, it is a
 * mistake that survived.
 *
 *   variant  overture  the first plates of the film — the widest measure
 *            act       inside a scene, tighter
 *            house     the real photographs; a paler caption and no scrim
 *
 * A PLATE MAY CARRY AN id, and two of them do: #wellness and #events. The
 * navigation no longer points at them — it addresses the site's pages now, not
 * this page's scenes — but they stay, because an anchor on a picture rather
 * than on a heading is the honest target when the picture is what the label
 * names, and an address that has been linkable should not stop being one.
 *
 * THE CAPTION SAYS WHAT THE PICTURE IS. Where the plate is a visualisation the
 * label is appended here, automatically, from t('media.visualisation') — the
 * same rule figure.php enforces, for the same reason: it is the one kind of
 * picture a reader cannot tell from a photograph by looking. A synthesised
 * frame takes t('media.generated') by the same mechanism and for the same
 * reason; neither can be switched off from the content file.
 *
 * @var array $s
 * @var array $c
 */

declare(strict_types=1);

$variant = (string) ($s['variant'] ?? 'act');
$plates  = (array) ($s['plates'] ?? []);
$id      = !empty($s['id']) ? ' id="' . e($s['id']) . '"' : '';
?>
<section class="c-film-plates c-film-plates--<?= e($variant) ?>"<?= $id ?>>
    <div class="c-film-plates__grid">
<?php foreach ($plates as $plate):
    $span   = max(1, min(12, (int) ($plate['span'] ?? 6)));
    $offset = max(0, min(11, (int) ($plate['offset'] ?? 0)));
    $source = (string) ($plate['source'] ?? 'render');
    $mark   = mark_for($source);
    $style  = '--span: ' . $span . '; --offset: ' . $offset . ';';
    $classes = 'c-film-plates__item'
        . (!empty($plate['raise']) ? ' is-raised' : '')
        . ($span >= 12 ? ' is-full' : '');
    $plateId = !empty($plate['id']) ? ' id="' . e($plate['id']) . '"' : '';
?>
        <figure class="<?= e($classes) ?>"<?= $plateId ?> style="<?= e($style) ?>" data-plate>
            <?= img(
                (string) ($plate['name'] ?? ''),
                (string) ($plate['sizes'] ?? '(min-width: 1080px) 40vw, 92vw'),
                (string) ($plate['alt'] ?? ''),
                [
                    'widths' => (array) ($plate['widths'] ?? [640, 960, 1280, 1920]),
                    'ratio'  => (string) ($plate['ratio'] ?? '3/2'),
                    'source' => $source,
                    'class'  => 'c-film-plates__img',
                ]
            ) ?>
<?php if (!empty($plate['caption'])): ?>
            <figcaption class="c-film-plates__caption">
                <?= e($plate['caption']) ?><?php if ($mark !== ''): ?><span class="c-film-plates__mark"><?= e($mark) ?></span><?php endif; ?>
            </figcaption>
<?php endif; ?>
        </figure>
<?php endforeach; ?>
    </div>
</section>
