<?php
/**
 * The club seal.
 *
 * Defines seal() and renders nothing on its own. Include it with require_once
 * — it declares a function, so a plain require twice in one request is a fatal
 * error:
 *
 *     require_once TEMPLATES_PATH . '/partials/seal.php';
 *     seal('auto', 'lg');
 *
 * THE MARK IS ARTWORK, NOT A VECTOR, AND THAT IS WHY THIS IS NOT INLINE SVG.
 *
 * The club seal is a fine-line engraving: twenty letters around two rings, four
 * fleur-de-lis, a facade with its own reflection. It was supplied as artwork in
 * three colourings — green, bordeaux and gold — each with white detail cut into
 * the ink. There is no single-colour vector of it, and flattening it into one
 * would throw away the white windows and the keylines that make the facade read
 * as a building rather than a blot. So the three colourings ship as three files
 * and the mark is printed as a background image.
 *
 * WHICH LEAVES THE PROBLEM THE INLINE SVG WAS SOLVING: the seal has to be green
 * in the footer of a cream page and gold on a dark one, and a component is not
 * allowed to know which ground it is standing on. currentColor did that for the
 * old placeholder. Here it is --seal-src, set beside --accent in §3 of main.css
 * by the same ground rules — so seal('auto') follows the temperature exactly as
 * the old accent variant did, and the drawer's data-mood="dusk" gets the gold
 * mark over a cream page without being told.
 *
 * A background image rather than an <img> for the same reason: <img src> is
 * fixed at print time and cannot be swapped by the ground. §8.5 of ARCHITECTURE
 * covers the trade.
 *
 * Replacing a colourway is one file in assets/img/brand/ and nothing else.
 */

declare(strict_types=1);

/**
 * Wrapper colourings.
 *
 * 'auto' takes the ground's own colourway and is what almost every call should
 * use. The three named ones force a colourway and exist for the styleguide and
 * for the rare place that has to name the mark rather than inherit it.
 */
const SEAL_VARIANTS = ['auto', 'green', 'wine', 'gold'];

/** Rendered sizes. The pixel values live on the modifiers in main.css. */
const SEAL_SIZES = ['sm', 'md', 'lg'];

/**
 * Print the seal.
 *
 * @param string $variant    'auto' — follows the ground it lands on, green on
 *                           cream and gold on the dark temperatures
 *                           'green' | 'wine' | 'gold' — a named colourway
 * @param string $size       'sm' 32px | 'md' 64px | 'lg' 140px
 * @param bool   $decorative true  — aria-hidden, the seal says nothing a
 *                                   reader is missing (the wordmark is next
 *                                   to it, in text)
 *                           false — role="img" with a label, for the rare
 *                                   place where the mark stands alone
 */
function seal(string $variant = 'auto', string $size = 'md', bool $decorative = true): void
{
    if (!in_array($variant, SEAL_VARIANTS, true)) {
        if (DEV) {
            trigger_error("seal(): unknown variant '{$variant}'", E_USER_WARNING);
        }
        $variant = SEAL_VARIANTS[0];
    }

    if (!in_array($size, SEAL_SIZES, true)) {
        if (DEV) {
            trigger_error("seal(): unknown size '{$size}'", E_USER_WARNING);
        }
        $size = SEAL_SIZES[1];
    }

    /*
       An empty element carrying a background image, so the decorative case —
       which is nearly every case — costs a reader nothing. When the mark does
       stand alone, role="img" with aria-label names it; no id is minted and
       nothing has to stay unique across the eight seals a page might print.
    */
    $attributes = $decorative
        ? ' aria-hidden="true"'
        : ' role="img" aria-label="' . e(t('a11y.crest')) . '"';
    ?>
<span class="c-seal c-seal--<?= e($variant) ?> c-seal--<?= e($size) ?>"<?= $attributes ?>></span>
<?php
}
