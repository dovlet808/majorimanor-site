<?php
/**
 * The Main Page — one continuous film.
 *
 * Six lines, and that is the whole page. The order of the scenes, the ratio of
 * every plate and which of them move are decisions made in
 * content/en/home.php, because they are content decisions: this file knows
 * that the navigation comes before the hero, that the hero comes before
 * everything else, and that the footer comes last.
 *
 * THE CHROME IS RENDERED HERE RATHER THAN BY layout.php. The content file sets
 * 'own_chrome' => true and layout.php leaves the site header and footer off —
 * see the note there. The navigation below addresses the scenes of this page,
 * so it lives with the page.
 *
 * @var array $c
 */

declare(strict_types=1);

require TEMPLATES_PATH . '/partials/film-nav.php';

component(['type' => 'film-hero'] + (array) ($c['hero'] ?? []), $c);

sections($c);

require TEMPLATES_PATH . '/partials/film-footer.php';
