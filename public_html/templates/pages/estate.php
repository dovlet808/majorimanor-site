<?php
/**
 * THE ESTATE — the second page cut from the film.
 *
 * It is the Main Page's structure with one addition, and the addition is the
 * reason this file is not the four lines home.php is: the page moves through
 * six grounds rather than holding one. So the scenes are grouped into acts, an
 * act is a run of scenes at one temperature, and this file renders the wrapper
 * that carries it. Everything else — which scenes, in what order, at what
 * ratio, with what copy — is a content decision and lives in
 * content/en/estate.php, exactly as on the home page.
 *
 * WHY THE ACT IS A WRAPPER AND NOT A KEY ON EACH BLOCK. Putting a 'ground' on
 * every section would mean teaching film-band, film-chapter and film-plates
 * about it — three components the Main Page renders, and the Main Page is
 * approved. A wrapper this page draws around blocks those components know
 * nothing about leaves all three byte for byte as they are, and the ground
 * still reaches them, because they read --ground through the cascade like
 * everything else. See §1 of estate.css.
 *
 * THE CHROME IS RENDERED HERE, as on the home page and for the same reason:
 * the content file sets 'own_chrome' => true, layout.php leaves the site
 * header and footer off, and the page renders the film's own. What that chrome
 * SAYS is still the site's — film-nav.php builds itself from routes.php and
 * common.php, so this page names the same places in the same words as every
 * other, and names itself as the one the reader is standing on.
 *
 * A CONTENT FILE THAT DECLARES 'sections' AND NO 'acts' STILL RENDERS. The
 * fallback below is the home page's own line, so the two pages cannot get out
 * of step over something as small as a key that was not written yet.
 *
 * @var array $c
 */

declare(strict_types=1);

require TEMPLATES_PATH . '/partials/film-nav.php';

component(['type' => 'film-hero'] + (array) ($c['hero'] ?? []), $c);

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

require TEMPLATES_PATH . '/partials/film-footer.php';
