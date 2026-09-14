<?php
/**
 * English content of the development styleguide. Arrays only, no markup.
 *
 * The page renders only while DEV is true (see DEV_ONLY_PAGES in helpers.php),
 * so nothing here is ever read by a visitor. It exists so that the design
 * system can be checked with the eye rather than with a colour picker: every
 * token on one screen, the type scale as live text, the three temperatures as
 * full-width bands, and the Latvian diacritics in both stacks.
 *
 * The hex values are repeated here on purpose. The swatch shows what the
 * stylesheet actually resolves; the label shows what main.css is supposed to
 * say. If the two ever disagree, one of them is stale — which is the point.
 */

declare(strict_types=1);

return [

    'meta' => [
        'title'       => 'Styleguide — Majori Manor',
        'description' => 'Development styleguide. Not part of the public site.',
    ],

    'mood' => 'day',

    'title' => 'Design system',
    'lede'  => 'Every token in main.css, rendered. Development only — this address does not exist when DEV is off.',

    'headings' => [
        'colour'     => 'Colour tokens',
        'moods'      => 'Colour temperatures',
        'type'       => 'Type scale',
        'eyebrow'    => 'The eyebrow',
        'fonts'      => 'Diacritic coverage',
        'space'      => 'Space and layout',
        'seal'       => 'The seal',
        'buttons'    => 'Buttons',
    ],

    // --- Colour ------------------------------------------------------------

    'colour_note' => 'Brand colours are provisional and await the designer\'s confirmation. They sit in one contiguous block at the top of main.css so that confirming them is a single edit.',

    'colour_groups' => [
        [
            'label'   => 'Majori Green',
            'swatches' => [
                ['var' => '--green-900', 'hex' => '#123328', 'note' => 'darkest grounds'],
                ['var' => '--green-800', 'hex' => '#1A4438', 'note' => 'the primary brand green — dusk ground'],
                ['var' => '--green-700', 'hex' => '#24523F', 'note' => 'rules and hovers on dark'],
            ],
        ],
        [
            'label'    => 'Wine Bordeaux',
            'swatches' => [
                ['var' => '--wine-900', 'hex' => '#56151E', 'note' => 'large night grounds — gold on it is 6.19:1'],
                ['var' => '--wine-800', 'hex' => '#7B1E2B', 'note' => 'brand bordeaux — buttons, seals, plates, rules on night. Gold on it is 4.57:1, which passes AA but only just'],
            ],
        ],
        [
            'label'    => 'Gold',
            'swatches' => [
                ['var' => '--gold',      'hex' => '#CBA96A', 'note' => 'display type, rules, crest — dark grounds only. 1.91:1 on cream, 4.89:1 on green-800, 6.19:1 on wine-900'],
                ['var' => '--gold-ink',  'hex' => '#7A5C24', 'note' => 'the only gold allowed for small text on cream — 5.3:1'],
                ['var' => '--gold-soft', 'hex' => '#E0C894', 'note' => 'the lighter gold, dark grounds only'],
            ],
        ],
        [
            'label'    => 'Cream',
            'swatches' => [
                ['var' => '--cream',      'hex' => '#F2EDE4', 'note' => 'day ground'],
                ['var' => '--cream-deep', 'hex' => '#E6DFD2', 'note' => 'rules on day'],
            ],
        ],
        [
            'label'    => 'Ink',
            'swatches' => [
                ['var' => '--ink',      'hex' => '#101511', 'note' => 'near-black with a green undertone — 15.8:1 on cream'],
                ['var' => '--ink-soft', 'hex' => '#4A5148', 'note' => 'secondary text — 7.0:1 on cream'],
            ],
        ],
    ],

    // --- Temperatures ------------------------------------------------------

    'moods_note' => 'Each temperature defines four variables and nothing else: --bg, --fg, --rule, --accent. Every rule in the stylesheet reads those four, so a component never knows which ground it is standing on. The accent is not the same in all three — that is the contrast fix, not an oversight.',

    'moods' => [
        [
            'id'      => 'day',
            'label'   => 'Day',
            'where'   => 'Estate, Padel, Events, Residences',
            'accent'  => 'accent: --gold-ink, because --gold on cream is 1.91:1',
            'sample'  => 'A house that has been standing since 1878.',
        ],
        [
            'id'      => 'dusk',
            'label'   => 'Dusk',
            'where'   => 'Hero, The Club',
            'accent'  => 'accent: --gold — 4.89:1 on this ground',
            'sample'  => 'A house that has been standing since 1878.',
        ],
        [
            'id'      => 'night',
            'label'   => 'Night',
            'where'   => 'After Dark, Membership',
            'accent'  => 'accent: --gold — 6.19:1 on this ground',
            'sample'  => 'A house that has been standing since 1878.',
        ],
    ],

    'seams_label' => 'Seams',
    'seams_note'  => 'A ~120px band carrying the gradient from one ground into the next. The crest goes in the middle of it; that is a component and arrives later.',

    'seams' => [
        ['class' => 'seam--day-dusk',   'label' => 'day → dusk'],
        ['class' => 'seam--dusk-night', 'label' => 'dusk → night'],
        ['class' => 'seam--night-day',  'label' => 'night → day'],
    ],

    // --- Type --------------------------------------------------------------

    'type_note' => 'Base 17px, ratio 1.28, fluid with clamp(). Resize the window: every step moves. The sample is set in the face that step actually uses.',

    'type' => [
        ['var' => '--fs-3xl',  'role' => 'Display — h1',        'face' => 'display', 'sample' => 'A private world in Jūrmala'],
        ['var' => '--fs-2xl',  'role' => 'Display — h2',        'face' => 'display', 'sample' => 'The Estate'],
        ['var' => '--fs-xl',   'role' => 'Display — h3',        'face' => 'display', 'sample' => 'A day at Majori Muiža'],
        ['var' => '--fs-lg',   'role' => 'Display — h4, lede',  'face' => 'display', 'sample' => 'Four courts under one roof'],
        ['var' => '--fs-base', 'role' => 'Body copy',           'face' => 'body',    'sample' => 'The manor house sits at the centre of a private park, ten minutes from the sea and forty from Rīga. Restoration began in the spring.'],
        ['var' => '--fs-sm',   'role' => 'Secondary, captions', 'face' => 'body',    'sample' => 'Photographed before restoration, March 2026.'],
        ['var' => '--fs-xs',   'role' => 'Eyebrow, meta',       'face' => 'body',    'sample' => 'Members & guests'],
    ],

    // --- Eyebrow -----------------------------------------------------------

    'eyebrow_note' => '.u-eyebrow — uppercase, .18em tracking, --fs-xs, colour --accent. The brand voice from the brochure. Shown here on all three grounds so the per-mood accent is visible.',

    'eyebrows' => [
        'PRIVATE ESTATE & MEMBERS\' CLUB',
        'JŪRMALA · LATVIA',
        'MEMBERS & GUESTS',
    ],

    // --- Fonts -------------------------------------------------------------

    'fonts_note' => 'Latin Extended-A has to be complete before the fonts are fixed, because Latvian arrives in phase 3 and changing the face on a finished site means re-setting all of it. Check this line by rendering, not by reading a specification. While assets/fonts/ is empty both stacks fall back — display to Georgia, body to the system UI face — and this line still has to be correct.',

    'fonts_sample' => 'Jūrmala · Majori Muiža — ĀČĒĢĪĶĻŅŠŪŽ',

    'fonts' => [
        [
            'label' => 'Display — var(--font-display)',
            'stack' => '"Playfair Display", "Prata", Georgia, serif',
            'face'  => 'display',
        ],
        [
            'label' => 'Body — var(--font-body)',
            'stack' => '"Inter", system-ui, -apple-system, "Segoe UI", Roboto, sans-serif',
            'face'  => 'body',
        ],
    ],

    // --- Space -------------------------------------------------------------

    'space_note' => 'Every step is a multiple of 4. The bar is the real computed width. Space between blocks comes from .section and nowhere else; space inside a block comes from .stack.',

    'space' => [
        ['var' => '--space-1',  'value' => '4px'],
        ['var' => '--space-2',  'value' => '8px'],
        ['var' => '--space-3',  'value' => '12px'],
        ['var' => '--space-4',  'value' => '16px'],
        ['var' => '--space-5',  'value' => '20px'],
        ['var' => '--space-6',  'value' => '24px'],
        ['var' => '--space-7',  'value' => '32px'],
        ['var' => '--space-8',  'value' => '40px'],
        ['var' => '--space-9',  'value' => '48px'],
        ['var' => '--space-10', 'value' => '64px'],
        ['var' => '--space-11', 'value' => '80px'],
        ['var' => '--space-12', 'value' => '96px'],
    ],

    'layout' => [
        ['var' => '--space-section', 'value' => 'clamp(80px, 12vh, 180px)', 'note' => 'the rhythm between sections'],
        ['var' => '--wrap-max',      'value' => '1440px',                   'note' => 'the widest the page ever gets'],
        ['var' => '--measure',       'value' => '34rem',                    'note' => 'prose column, 62–72 characters'],
        ['var' => '--gutter',        'value' => 'clamp(16px, 2.4vw, 32px)', 'note' => 'grid gutter'],
        ['var' => '--pad-x',         'value' => 'clamp(20px, 5vw, 80px)',   'note' => 'page margin, left and right'],
    ],

    'measure_label' => 'The prose column',
    'measure_note'  => 'The rule below marks --measure. A line of prose should break at or before it.',
    'measure_sample' => 'The manor stands where it has stood since 1878, at the centre of a park that was laid out before the town around it existed. What is being restored is not a building alone but the way a day passes inside it — slowly, and mostly out of sight.',

    'grid_label' => 'The grid',
    'grid_note'  => 'Twelve columns from 768px up, one column below it. Resize past the breakpoint.',

    // --- The seal ----------------------------------------------------------

    'seal_note' => 'The club seal, printed by seal($variant, $size, $decorative) as a background image on an empty span. It is artwork rather than a vector — a fine-line engraving with white detail cut into the ink — so it cannot inherit a colour the way a shape can, and it ships as three files, one per colouring. What replaces currentColor is --seal-src, set by the ground in §3 of main.css: auto follows the temperature it lands on, and the three named colourways force one. Four rows on three grounds below, which is the whole matrix.',

    'seal_two_marks_note' => 'The sm column is a different drawing, and that is the identity rather than a substitution. Majori Manor has two marks: the crest, which is legible from 48px up, and the monogram in mark.svg, which carries everything below it — 32px on the page, and the 16 and 32 layers of the favicon. The crest at 32px is a grey disc, so the small size is where it stops. The monogram is a real vector, so it takes a colour from the ground through --seal-ink instead of naming a file, which is the same rule arriving at the same answer by the shorter route.',

    'seal_variants' => [
        [
            'id'    => 'auto',
            'label' => 'auto',
            'note'  => 'follows the ground — the green mark on cream, the gold one on dusk and night. Nearly every call should be this one.',
        ],
        [
            'id'    => 'green',
            'label' => 'green',
            'note'  => 'the brand green — cream grounds only, and invisible on dusk, which is what the ground rule is for',
        ],
        [
            'id'    => 'wine',
            'label' => 'wine',
            'note'  => 'the bordeaux colouring — cream grounds only, and it disappears on night for the same reason',
        ],
        [
            'id'    => 'gold',
            'label' => 'gold',
            'note'  => 'dark grounds only — on cream it drops to 1.91:1 and goes to mush',
        ],
    ],

    'seal_sizes' => [
        ['id' => 'sm', 'label' => 'sm · 32px'],
        ['id' => 'md', 'label' => 'md · 64px'],
        ['id' => 'lg', 'label' => 'lg · 140px'],
    ],

    // --- Buttons -----------------------------------------------------------

    'buttons_note' => '.c-btn, in the only two states there are. Primary fills with --accent and takes --bg as its text colour, which is what keeps it legible on all three temperatures; outlined is the same accent as a hairline. They trade places on hover, so the pair reads as one control. MEMBERSHIP in the header is the outlined one, and the same link at the bottom of the mobile drawer is the primary.',

    'buttons' => [
        ['class' => 'c-btn--primary', 'label' => 'Membership', 'note' => '.c-btn--primary'],
        ['class' => 'c-btn--outline', 'label' => 'Membership', 'note' => '.c-btn--outline'],
    ],

];
