<?php
/**
 * The first element in <body>, before the header, so that the first thing a
 * keyboard reader reaches on any page is the way past the navigation.
 *
 * .u-visually-hidden keeps it out of the way and :focus-visible brings it back
 * — see §8 of main.css, where the focused state is pinned to the top-left
 * corner above everything else. .skip-link carries no styles of its own; it is
 * the hook for the day one is wanted.
 *
 * The target is <main id="main" tabindex="-1"> in layout.php. The tabindex is
 * what makes the jump actually move focus rather than only the scroll
 * position, and main draws a focus ring when it lands — deliberately, because
 * a reader who has just jumped needs to see where they are.
 */

declare(strict_types=1);
?>
<a class="skip-link u-visually-hidden" href="#main"><?= e(t('a11y.skip_to_content')) ?></a>
