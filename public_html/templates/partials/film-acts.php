<?php
/**
 * The acts of a film page, rendered.
 *
 * An ACT is a run of scenes that share one ground. THE ESTATE introduced them
 * and THE CLUB is the second page to move through temperatures rather than
 * hold one, so the loop that draws the wrapper is here rather than copied a
 * second time into a page template.
 *
 * WHY THE ACT IS A WRAPPER AND NOT A KEY ON EACH BLOCK — the reasoning is THE
 * ESTATE's and it has not changed: putting a 'ground' on every section would
 * mean teaching film-band, film-chapter and film-plates about it, and those
 * three are the approved Main Page's. A wrapper drawn around blocks that know
 * nothing about it leaves all of them byte for byte as they are, and the
 * ground still reaches them, because they read --ground through the cascade
 * like everything else. See §1 of estate.css, which is where .c-act is drawn
 * and which both film pages load.
 *
 * templates/pages/estate.php STILL CARRIES ITS OWN COPY OF THIS LOOP, and that
 * is a decision rather than an oversight: THE ESTATE is approved, its output is
 * proved byte-identical after this work, and the cheapest way to keep that true
 * was not to open the file. The two copies are the same fifteen lines; when a
 * third film page arrives, estate.php should require this partial and the
 * snapshot harness will prove nothing moved.
 *
 * A CONTENT FILE THAT DECLARES 'sections' AND NO 'acts' STILL RENDERS — the
 * fallback is the home page's own line, so a page cannot break over a key that
 * has not been written yet.
 *
 * @var array $c
 */

declare(strict_types=1);

/** @var array $acts runs of scenes, each at one temperature */
$acts = (array) ($c['acts'] ?? []);

if ($acts === []) {
    sections($c);
} else {
    foreach ($acts as $act) {
        if (!is_array($act)) {
            continue;
        }

        $tone   = (string) ($act['tone'] ?? 'estate');
        $blocks = (array) ($act['blocks'] ?? []);

        if ($blocks === []) {
            continue;
        }

        echo '<div class="c-act c-act--' . e($tone) . '">' . "\n";

        foreach ($blocks as $block) {
            if (is_array($block)) {
                component($block, $c);
            }
        }

        echo "</div>\n";
    }
}
