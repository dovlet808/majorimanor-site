<?php
/**
 * The single source of truth for addresses.
 *
 *     page_id => [ lang => slug ]
 *
 * Rules:
 *   - page_id is snake_case                     ('after_dark')
 *   - slug is kebab-case and ASCII only         ('muiza', never 'muiža')
 *   - no trailing slash anywhere except the root
 *   - the home page has an empty slug in every language
 *
 * Latvian is not active yet (see LANGS in private/config.php), but its slugs
 * live here from day one so they never have to be invented later.
 *
 * The order of this array is the order of the main navigation; the pages that
 * do not belong there are listed in NAV_EXCLUDE in helpers.php.
 *
 * '404' deliberately has no route — it is unreachable by URL.
 *
 * 'styleguide' and 'components' are routed but listed in DEV_ONLY_PAGES: with
 * DEV = false index.php drops them before anything is loaded and the address
 * answers a real 404, like any other address that does not exist.
 */

declare(strict_types=1);

return [
    'home'       => ['en' => '',           'lv' => ''],
    'estate'     => ['en' => 'the-estate', 'lv' => 'muiza'],
    'club'       => ['en' => 'the-club',   'lv' => 'klubs'],
    'padel'      => ['en' => 'padel',      'lv' => 'padels'],
    'events'     => ['en' => 'events',     'lv' => 'pasakumi'],
    'residences' => ['en' => 'residences', 'lv' => 'rezidences'],
    'after_dark' => ['en' => 'after-dark', 'lv' => 'vakars'],
    'membership' => ['en' => 'membership', 'lv' => 'biedriba'],
    'contact'    => ['en' => 'contact',    'lv' => 'kontakti'],
    'privacy'    => ['en' => 'privacy',    'lv' => 'privatuma-politika'],
    'terms'      => ['en' => 'terms',      'lv' => 'noteikumi'],

    // Development only — see DEV_ONLY_PAGES in helpers.php.
    'styleguide' => ['en' => 'styleguide', 'lv' => 'stila-rokasgramata'],
    'components' => ['en' => 'components', 'lv' => 'komponentes'],
];
