<?php
/**
 * English content of the development component library. Arrays only, no markup.
 *
 * The page renders only while DEV is true (see DEV_ONLY_PAGES in helpers.php),
 * so nothing here is ever read by a visitor.
 *
 * ONE LIST, RENDERED TWICE. 'blocks' below is the whole library in content
 * order, and templates/pages/components.php runs it once on day and once on
 * night, forcing the temperature as it goes. That is the claim the page exists
 * to test: the same component on two grounds with no modifier and no second
 * version of anything. Two lists would let the two runs drift apart, and the
 * day one would be the one anybody remembered to update.
 *
 * THE COPY IS PLACEHOLDER AND IT IS STILL WRITTEN IN THE BRAND'S VOICE.
 * Lorem ipsum has no measure, no rhythm and no register, so it cannot show
 * whether a lede is too long or a heading balances onto two lines — which is
 * most of what this page is for. Every line here is disposable and none of it
 * is a fact: no dates, no dimensions and no claims about rooms, because a
 * sentence written to fill a box has a way of ending up on the real page.
 */

declare(strict_types=1);

return [

    'meta' => [
        'title'       => 'Components — Majori Manor',
        'description' => 'Development component library. Not part of the public site.',
    ],

    'mood' => 'day',

    'title' => 'Component library',
    'lede'  => 'Every block on the site, on both grounds, with the photography still to come. Development only — this address does not exist when DEV is off.',

    'ground_label' => 'Ground',

    'note' => 'Each block below is one entry in a content file, rendered by one component. The list is written once and rendered twice: what follows on cream and what follows on wine are the same eleven components with the same copy, and no modifier passes between them. Two of them answer to their own ground rather than to the page\'s — the hero, which stands on a photograph, and the seam, which is the gradient between two temperatures — and both therefore render identically in the second run. Every image is missing on purpose: the hatched boxes are holding the exact shape the photography will take.',

    // -----------------------------------------------------------------------
    // The library, in the order a reader would meet it
    // -----------------------------------------------------------------------

    'blocks' => [

        // --- hero, the full variant -------------------------------------------
        //
        // THE HERO IS THE ONE BLOCK THAT DOES NOT TAKE THE PAGE'S GROUND. It
        // stands on a photograph under a green scrim and carries section--dusk
        // itself, so the second run of this list renders it identically — that
        // is the component being right, not the page being broken.
        //
        // Both variants are here because there are two and only one of them is
        // on a page that can be looked at today: 'full' is the home page's
        // first screen, 'page' opens every internal page from The Estate on.
        // They are one component and a modifier, and this is where that claim
        // is checked.
        [
            'type'     => 'hero',
            'variant'  => 'full',
            'eyebrow'  => 'Private estate & members\' club',
            'title'    => 'A house at the end of an avenue',
            'location' => 'Jūrmala · Latvia',
            /*
               Re-pointed when the Main Page was rebuilt. This showcase used
               home/hero-pavilion-night, which the Main Page no longer declares
               and build_home_media.py therefore sweeps — a slot that is not on
               the ladder is a hatched box, and a hatched box in the one place
               that exists to show a finished component is the wrong lesson.
               The Main Page's own hero still is the honest stand-in, and the
               marking follows the picture: it is a visualisation.
            */
            'image'    => [
                'name'   => 'home/hero-manor',
                'widths' => [768, 1280],
                'alt'    => 'The manor at blue hour, its windows lit',
                'source' => 'render',
            ],
            'actions' => [
                ['page_id' => 'estate',     'label' => 'Discover the estate', 'variant' => 'primary'],
                ['page_id' => 'membership', 'label' => 'Membership application', 'variant' => 'quiet'],
            ],
        ],

        // --- hero, the page variant -------------------------------------------
        //
        // Shorter, a lede in place of the two actions, and no scroll cue.
        // Passing 'actions' to this one is a DEV warning and an empty row of
        // buttons, which is the check that the variant is a variant.
        [
            'type'    => 'hero',
            'variant' => 'page',
            'eyebrow' => 'The manor house',
            'title'   => 'A house at the end of an avenue',
            'lede'    => 'One sentence, quiet, and long enough to find the second line on a phone.',
            'image'   => [
                'name'   => 'estate/hero-facade',
                'alt'    => 'The facade of the manor house',
                'ratio'  => '16/9',
                'source' => 'photo',
            ],
        ],

        // --- seam ---------------------------------------------------------------
        //
        // The other block that names its own grounds, and it has to: a seam is
        // the gradient between two temperatures and nothing else. It takes no
        // copy at all. On the night run below it renders the same day → dusk
        // band against wine, which looks like a stripe and is exactly what the
        // comment in seam.php means by "a seam between every block". The three
        // seams in their proper pairs are on /styleguide.
        ['type' => 'seam', 'from' => 'day', 'to' => 'dusk'],

        // --- chapter, unflipped ---------------------------------------------
        [
            'type'    => 'chapter',
            'number'  => '01',
            'eyebrow' => 'The estate',
            'title'   => 'A house at the centre of its own park',
            'lede'    => 'The manor stands where it has stood for longer than the town around it, at the end of an avenue that was planted before anybody thought to name the street. What is being restored is not the building alone but the way a day passes inside it.',
            'image'   => [
                'name'   => 'home/estate-avenue',
                'alt'    => 'The avenue of limes leading to the manor house',
                'ratio'  => '3/2',
                'source' => 'photo',
            ],
            'link' => ['page_id' => 'estate', 'label' => 'Enter the estate'],
        ],

        // --- chapter, mirrored ----------------------------------------------
        [
            'type'    => 'chapter',
            'number'  => '02',
            'eyebrow' => 'The club',
            'title'   => 'Members and their guests, and nobody else',
            'lede'    => 'A small house within the house: a room for dinner, a room for cards, a room where the fire is lit from October. Membership is by introduction, and the list is deliberately shorter than the building could hold.',
            'image'   => [
                'name'   => 'home/club-fireside',
                'alt'    => 'The fireside room at dusk',
                'ratio'  => '3/2',
                'source' => 'photo',
            ],
            'link' => ['page_id' => 'club', 'label' => 'The club'],
        ],

        // --- prose -----------------------------------------------------------
        [
            'type'    => 'prose',
            'eyebrow' => 'On restoration',
            'title'   => 'Slowly, and mostly out of sight',
            'body'    => [
                'Restoration is not decoration. The floors are being lifted board by board and put back in the order they were laid, the stove is being rebuilt around the tiles that survived, and the windows are being made to open the way they were made to open.',
                'None of this is visible from the avenue, which is rather the point. A house that has stood this long is not in a hurry, and the work that lasts is the work nobody sees being done.',
            ],
        ],

        // --- split -----------------------------------------------------------
        [
            'type'    => 'split',
            'eyebrow' => 'Padel',
            'title'   => 'Four courts, and a room to sit down in afterwards',
            'body'    => [
                'Under one roof, with light from three sides and a gallery above the far end. The courts are the reason most members come the first time and the room beside them is the reason they come back.',
            ],
            'image' => [
                'name'   => 'padel/courts-evening',
                'alt'    => 'The courts from the gallery, early evening',
                'ratio'  => '4/5',
                'source' => 'photo',
            ],
            'link' => ['page_id' => 'padel', 'label' => 'Padel at the manor'],
        ],

        // --- split, flipped ---------------------------------------------------
        [
            'type'    => 'split',
            'flip'    => true,
            'eyebrow' => 'Residences',
            'title'   => 'Eleven apartments in the old service wing',
            'body'    => [
                'The wing that fed the house is being turned into the part of it people stay in. Each apartment keeps its own windows and its own view of the park, and none of them has been made to match another.',
            ],
            'image' => [
                'name'   => 'residences/window-park',
                'alt'    => 'A window in the service wing, looking onto the park',
                'ratio'  => '4/5',
                'source' => 'photo',
            ],
            'link' => ['page_id' => 'residences', 'label' => 'The residences'],
        ],

        // --- figure, a photograph ---------------------------------------------
        [
            'type'  => 'figure',
            'width' => 'measure',
            'image' => [
                'name'   => 'estate/staircase',
                'alt'    => 'The main staircase, before restoration',
                'ratio'  => '4/5',
                'source' => 'photo',
            ],
            'caption'    => 'The main staircase, before restoration',
            'atmosphere' => 'The balusters are original; the carpet is not.',
        ],

        // --- figure, a visualisation ------------------------------------------
        //
        // 'source' => 'render' is the ONLY thing this entry does differently,
        // and figure.php appends the Visualisation label to the caption on its
        // own. Nothing here asks for it. That is the rule being demonstrated.
        [
            'type'  => 'figure',
            'image' => [
                'name'   => 'events/pavilion-night',
                'alt'    => 'The pavilion at night',
                'ratio'  => '16/9',
                'source' => 'render',
            ],
            'caption'    => 'The pavilion, from the lower lawn',
            'atmosphere' => 'The dome is lit from within, and from the avenue it reads as a lantern.',
        ],

        // --- figure, a mood reference -----------------------------------------
        //
        // A caption IS supplied and figure.php will not print it, because
        // 'source' => 'mood' means this is somebody else's room. Only the
        // atmospheric line survives. See the DEV warning in figure.php.
        [
            'type'  => 'figure',
            'image' => [
                'name'   => 'after-dark/lounge-reference',
                'alt'    => 'Low light, deep colour, a room at the end of an evening',
                'ratio'  => '16/9',
                'source' => 'mood',
            ],
            'atmosphere' => 'Somewhere in the register of the evening we are after.',
        ],

        // --- facts --------------------------------------------------------------
        [
            'type'    => 'facts',
            'eyebrow' => 'The pavilion',
            'title'   => 'What the room will hold',
            'items'   => [
                ['label' => 'Seated',        'value' => 'Ninety'],
                ['label' => 'Standing',      'value' => 'A hundred and forty'],
                ['label' => 'Ceiling',       'value' => 'Seven metres to the dome'],
                ['label' => 'Terrace',       'value' => 'South, onto the lower lawn'],
                ['label' => 'Kitchen',       'value' => 'Full, on the same floor'],
                ['label' => 'Approach',      'value' => 'Separate, from the east gate'],
            ],
        ],

        // --- quote ---------------------------------------------------------------
        [
            'type' => 'quote',
            'line' => 'One estate. One membership. An entire day.',
        ],

        // --- quote, attributed ---------------------------------------------------
        [
            'type'        => 'quote',
            'line'        => 'A private world in Jūrmala.',
            'attribution' => 'Majori Manor',
        ],

        // --- gallery -------------------------------------------------------------
        [
            'type'    => 'gallery',
            'eyebrow' => 'The house',
            'title'   => 'Six rooms, before the work began',
            'items'   => [
                [
                    'name'    => 'estate/hall-chess-floor',
                    'alt'     => 'The marble chess floor in the entrance hall',
                    'caption' => 'The entrance hall',
                    'ratio'   => '3/2',
                    'span'    => 2,
                ],
                [
                    'name'    => 'estate/stove-tiles',
                    'alt'     => 'The tiled stove in the green room',
                    'caption' => 'The green room',
                    'ratio'   => '3/4',
                ],
                [
                    'name'    => 'estate/window-stained',
                    'alt'     => 'The stained glass on the half landing',
                    'caption' => 'The half landing',
                    'ratio'   => '3/4',
                ],
                [
                    'name'    => 'estate/balusters',
                    'alt'     => 'Carved balusters on the main staircase',
                    'caption' => 'The main staircase',
                    'ratio'   => '3/2',
                ],
                [
                    'name'    => 'estate/facade-south',
                    'alt'     => 'The south facade from the lower lawn',
                    'caption' => 'The south facade',
                    'ratio'   => '3/2',
                ],
                [
                    'name'    => 'estate/library-shelves',
                    'alt'     => 'Empty shelves in the library',
                    'caption' => 'The library',
                    'ratio'   => '3/2',
                    'span'    => 2,
                ],
            ],
        ],

        // --- daytimeline ---------------------------------------------------------
        //
        // Three hours rather than the home page's six: the component's shape is
        // in the rule down the left and in the closing line, and both are
        // legible at three. The close is given as parts, which is how the real
        // one avoids breaking "One estate. One / membership." on a phone.
        [
            'type'    => 'daytimeline',
            'eyebrow' => 'From morning to the end of the evening',
            'title'   => 'A day at Majori Manor',
            'rows'    => [
                ['time' => '09:00', 'label' => 'Morning padel'],
                ['time' => '13:00', 'label' => 'Lunch & park'],
                ['time' => '20:00', 'label' => 'Dinner'],
            ],
            'close' => ['One estate.', 'One membership.', 'An entire day.'],
        ],

        // --- cta -------------------------------------------------------------------
        [
            'type'    => 'cta',
            'eyebrow' => 'Members & guests',
            'title'   => 'Membership is by introduction',
            'button'  => [
                'page_id' => 'membership',
                'label'   => 'Membership application',
                'variant' => 'primary',
            ],
        ],
    ],
];
