<?php
/**
 * English content of THE ESTATE. Arrays only, no markup.
 *
 * THIS IS THE PAGE THAT CARRIES THE HERITAGE OF THE WHOLE SITE, and it is the
 * one page where the copy is allowed to state facts, because for once there
 * are some. Everything asserted below comes from the owner's own material:
 *
 *     the main residence, built around 1910
 *     Wilhelm Bockslaff, a leading figure of Latvian Art Nouveau and
 *       Historicism
 *     a private park of 2.4 hectares — 24,000 m² — in the centre of Jūrmala
 *     the earliest records of the Majori lands, in the sixteenth century
 *     the von Fircks family of Kurzeme, summers at the manor and a steward
 *       through the rest of the year
 *     the agrarian reform of 1920, state property, a succession of public
 *       functions, and an architectural identity that survived largely intact
 *     the return to private ownership in 2024 and the restoration that began
 *       with it, led by the architect Ināra Caunīte
 *     the original elements that survived: wooden staircases with curved
 *       balusters, handcrafted decorative columns, authentic fireplace
 *       portals, several historical tiled stoves, oak parquet, marble floors,
 *       original marble columns, artistic metal door fittings
 *     Konkordijas iela 66, Jūrmala, LV-2015
 *
 * NOT ONE SENTENCE OF THAT IS NEW. The page was rebuilt in the Main Page's
 * visual language and the copy came with it, nearly word for word: the same
 * facts, the same headings — What the house has kept, The lands and the
 * century that followed, Ground of its own, A period of renewal — and the same
 * five-line inventory of the house. What changed is how it is set, not what it
 * says. No opening date, no price, no count of rooms, no visiting hours, and
 * nowhere any suggestion that the house is open (ARCHITECTURE §21).
 *
 * THE REGISTER IS A PRIVATE HOUSE DESCRIBING ITSELF TO SOMEBODY WHO HAS BEEN
 * INVITED IN. Not a museum label and not a brochure: specific, unhurried,
 * understated. Where a line could be carried either by a fact or by an
 * adjective, it is carried by the fact — and there is less of it here than
 * there was, because the photography and the six sequences are now doing the
 * telling and a paragraph that repeats a picture has been cut rather than kept.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * THE PAGE IS SIX ACTS AND IT CHANGES TEMPERATURE THROUGH THEM.
 *
 *     00  THE ARRIVAL   estate     the manor at blue hour — full screen
 *     01  THE HOUSE     estate     the facade, tracked; what it has kept
 *     02  THE WALK      heritage   seven rooms, one sticky viewport
 *     03  THE DETAILS   heritage   six things the house did not lose
 *     04  THE HOUSE     interior   the five settled facts, as a sheet
 *     05  THE LANDS     park       the century that followed
 *     06  THE PARK      park       ground of its own — 21:9, full width
 *     07  RENEWAL       evening    the hearth, and the work under way
 *     08  BELONGING     estate     the line, and the way through to the club
 *
 * The Main Page never brightens and holds one ground from first screen to
 * last, which is right for a film. This one is a walk through a house, so it
 * moves: near-black at the gates, mahogany where the woodwork is, green out in
 * the park, wine at the hearth, near-black again at the end. Every act is
 * still a dark ground — the difference between them is a few percent of hue,
 * and each is washed into the next rather than cut to. See §1 of estate.css.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * 'source' IS A CLAIM ABOUT THE PICTURE AND IT IS MADE HERE (§11), AND THIS
 * PAGE IS THE FIRST ON THE SITE TO USE THE FOURTH VALUE.
 *
 *   photo      the supplied photography of this building, cropped and nothing
 *              else. Every still in the walk and every detail plate.
 *   generated  the six Seedance 2.0 sequences and their posters. Each one was
 *              started from a photograph in media_src/ and every prompt was
 *              written as a preservation instruction — but Seedance reframes a
 *              portrait source to a landscape output, and what fills the new
 *              width is synthesised from the vocabulary of the photograph
 *              rather than photographed. That is not a visualisation of an
 *              unbuilt room, so it is not 'render'; and it is not a
 *              photograph. IMG_SOURCES has carried 'generated' unused since
 *              before this page existed, for exactly this.
 *
 * The components print the label themselves and a content file cannot switch
 * it off — see film-band.php and film-plates.php.
 *
 * THIS PAGE OWNS ITS OWN CHROME, as the Main Page does, and for the same
 * reason: the film needs a bar that can be transparent over its hero and a
 * last screen that can close it. What that chrome says is still the site's.
 */

declare(strict_types=1);

return [

    'meta' => [
        'title'       => 'The Estate — Majori Manor, Jūrmala',
        'description' => 'A manor house of about 1910 by Wilhelm Bockslaff, in a private park of 2.4 hectares in the centre of Jūrmala. Under restoration since 2024.',
    ],

    /*
       LandmarksOrHistoricalBuildings and nothing more (ARCHITECTURE §13): no
       openingHours and no priceRange, because there is nothing open to
       describe and marking an unbuilt service as a running one is the exact
       failure that section exists to prevent.
    */
    'jsonld' => [
        '@type'       => 'LandmarksOrHistoricalBuildings',
        'name'        => 'Majori Manor',
        'description' => 'A manor house built around 1910 to a design by Wilhelm Bockslaff, standing in a private park of 2.4 hectares in the centre of Jūrmala, Latvia. Under restoration since 2024.',
        'address'     => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => 'Konkordijas iela 66',
            'addressLocality' => 'Jūrmala',
            'postalCode'      => 'LV-2015',
            'addressCountry'  => 'LV',
        ],
    ],

    // The page paints its own grounds; this keeps the chrome tokens honest for
    // anything that still reads mood().
    'mood' => 'night',

    // See the note at the top of this file.
    'own_chrome' => true,

    // Only the wording of the sheet that opens below 900px: the links
    // themselves come from routes.php through nav_pages().
    'nav' => [
        'open_label'  => 'Open the menu',
        'close_label' => 'Close the menu',
        'aria_label'  => 'Main',
    ],

    'footer' => [
        'place' => 'Konkordijas iela 66, Jūrmala',
        'links' => FOOTER_LINKS,
    ],

    // =======================================================================
    // 00  THE ARRIVAL
    //
    // The same hero component the Main Page opens on, at the same full
    // viewport, with the same cream seal over it — that screen is approved and
    // this page is a continuation of it, not a variation on it. What differs
    // is the film and the line under it.
    //
    // The sequence is a slow dolly through the gate piers at blue hour, made
    // from estate_1 — the one exterior photograph that reaches a hero rung —
    // through a GPT Image 2 still that changed the time of day and nothing
    // else. The Estonian name plate legible on the gate pier in the original
    // is not in it; nothing was put in its place.
    // =======================================================================

    'hero' => [
        'eyebrow'   => 'Jūrmala · Latvia',
        'title'     => 'The Estate',
        'subtitle'  => 'The historic heart of Majori Manor',
        'statement' => 'A house of about 1910 at the centre of its own park, and the work of bringing it back is under way.',
        'cue'       => 'Enter the house',
        // The first scene of THIS page; the component defaults to the Main
        // Page's #arrival, which does not exist here. See film-hero.php.
        'cue_target' => 'house',

        'seal' => ['name' => 'brand/seal-cream', 'alt' => 'Majori Manor'],

        'film' => [
            'name'   => 'est-arrival',
            'poster' => 'estate/est-arrival',
            'ratio'  => '16/9',
            'alt'    => 'The manor at blue hour, its windows lit, seen from the gates across the forecourt',
            'source' => 'generated',
        ],
    ],

    'acts' => [

        // ===================================================================
        // ACT ONE — the gates and the house. Near-black.
        // ===================================================================

        [
            'tone'   => 'estate',
            'blocks' => [

                [
                    'type'    => 'film-chapter',
                    'id'      => 'house',
                    'index'   => '01',
                    'eyebrow' => 'The manor',
                    'title'   => 'A house, and the ground it stands on.',
                    'body'    => [
                        'Majori Manor stands at the centre of a private park of 2.4 hectares, '
                        . 'in the middle of Jūrmala. The main residence dates from around 1910. '
                        . 'The ground under it has been on record since the sixteenth century.',

                        'The house is under restoration. What follows is what is standing, '
                        . 'what has survived, and what is known about how it came to be here.',
                    ],
                ],

                [
                    'type'    => 'film-band',
                    'variant' => 'inset',
                    'index'   => '02',
                    'eyebrow' => 'Architecture',
                    'title'   => 'What the house has kept',
                    'film'    => [
                        'name'   => 'est-house',
                        'poster' => 'estate/est-house',
                        'ratio'  => '16/9',
                        'alt'    => 'The rendered facade under its slate roof, the barrel-vaulted bay and its round window at the centre',
                        'source' => 'generated',
                    ],
                    'caption' => 'The facade',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'None of it is reconstruction. It is what was still here when the house came back into private hands.',
                    'body'  => [
                        'The residence was designed by Wilhelm Bockslaff, a leading figure of '
                        . 'Latvian Art Nouveau and Historicism, and built around 1910. The '
                        . 'staircases are wooden, with curved balusters. The decorative columns '
                        . 'were made by hand, and the marble ones are original to the house. '
                        . 'The floors are oak parquet in some rooms and marble in others.',

                        'Which is why the work now is a repair and not a rebuild.',
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT TWO — inside. Mahogany over black.
        //
        // The walk is the one place on the site where scroll drives a camera,
        // and it is seven rooms in the order somebody actually moves through
        // them: in at the hall, up under the chandelier, across the marble, up
        // the stair, past the glass, along the landing, out through the doors.
        // Five of the seven are photographs. Two are sequences, each made from
        // the photograph of the very room it stands in.
        // ===================================================================

        [
            'tone'   => 'heritage',
            'blocks' => [

                [
                    'type'     => 'film-walk',
                    'id'       => 'walk',
                    'index'    => '03',
                    'eyebrow'  => 'Inside',
                    'title'    => 'Walk through the manor.',
                    'stations' => [
                        [
                            'name'   => 'estate/walk-hall',
                            'focus'  => '80% 50%',
                            'label'  => 'The hall',
                            'note'   => 'Marble underfoot, walnut to shoulder height, and a chimneypiece that was here before the century turned.',
                            'alt'    => 'The entrance hall: a white marble chimneypiece, panelled walls and a chequered marble floor',
                            'ratio'  => '16/9',
                            'widths' => [768, 1152],
                            'source' => 'photo',
                        ],
                        [
                            'label'  => 'The chandelier',
                            'note'   => 'Forty-odd candles in gilt brass, under a coffered ceiling that has never been painted over.',
                            'alt'    => 'The great hall, its gilt-brass candle chandelier hanging under a dark coffered ceiling',
                            'ratio'  => '16/9',
                            'widths' => [768, 1152],
                            'source' => 'generated',
                            'film'   => [
                                'name'   => 'est-hall',
                                'poster' => 'estate/est-hall',
                            ],
                        ],
                        [
                            'name'   => 'estate/walk-marble',
                            'label'  => 'The marble',
                            'note'   => 'The chequerboard runs from the doors to the foot of the stair, unbroken.',
                            'alt'    => 'The chequered marble floor of the hall, seen from the landing above it',
                            'ratio'  => '16/9',
                            'widths' => [768, 1152],
                            'source' => 'photo',
                        ],
                        [
                            'focus'  => '35% 50%',
                            'label'  => 'The staircase',
                            'note'   => 'Wooden, with curved balusters and a carved column at its foot. It is the piece the house is known by.',
                            'alt'    => 'The main staircase turning up out of the hall past its carved spiral column',
                            'ratio'  => '16/9',
                            'widths' => [768, 1152],
                            'source' => 'generated',
                            'film'   => [
                                'name'   => 'est-stair',
                                'poster' => 'estate/est-stair',
                            ],
                        ],
                        [
                            'name'   => 'estate/walk-glass',
                            'focus'  => '30% 50%',
                            'label'  => 'The glass',
                            'note'   => 'A stained window on the half-landing, and the only colour the stairwell has.',
                            'alt'    => 'A stained-glass window above the staircase',
                            'ratio'  => '16/9',
                            'widths' => [768, 1152],
                            'source' => 'photo',
                        ],
                        [
                            'name'   => 'estate/walk-landing',
                            'focus'  => '26% 50%',
                            'label'  => 'The landing',
                            'note'   => 'Coffers overhead, an arch through to the next room, and the balusters turning with the stair.',
                            'alt'    => 'The first-floor landing under its coffered ceiling, the arch through to the next room beside it',
                            'ratio'  => '16/9',
                            'widths' => [768, 1152],
                            'source' => 'photo',
                        ],
                        [
                            'name'   => 'estate/walk-doors',
                            'label'  => 'The doors',
                            'note'   => 'Glazed, hung on their original fittings, and standing open onto the park.',
                            'alt'    => 'Glazed doors between two rooms, one leaf standing open',
                            'ratio'  => '16/9',
                            'widths' => [768, 1152],
                            'source' => 'photo',
                        ],
                    ],
                ],

                [
                    'type'    => 'film-chapter',
                    'id'      => 'details',
                    'index'   => '04',
                    'eyebrow' => 'Detail',
                    'title'   => 'What a century of other uses usually takes.',
                    'body'    => [
                        'The fireplace portals are authentic and several of the historical '
                        . 'tiled stoves are still in place; the artistic metal fittings are '
                        . 'still on the doors. These are the first things to go, and the work '
                        . 'is being planned around keeping them.',
                    ],
                ],

                /*
                   SIX PLATES ON THREE ROWS, AND NO ROW IS THE SAME SHAPE.

                   The twelve columns are the Main Page's and so is the rule
                   that makes them work: within a row, spans and offsets must
                   not overlap, or the grid drops the second plate onto a row
                   of its own and the composition becomes a column. The three
                   rows here are 5+5, 6+4 and 7+4, each with its air in a
                   different place, and the second of each pair hangs.

                   EVERY ONE IS A DIFFERENT PHOTOGRAPH FROM THE SAME NEGATIVES
                   THE WALK USES, and that is what a detail plate is: the walk
                   shows the room, this shows the thing in it. Balusters,
                   column, glass, fittings, coffers, stove — which is the
                   confirmed inventory of what survived, almost line for line.
                */
                [
                    'type'    => 'film-plates',
                    'variant' => 'house',
                    'plates'  => [
                        [
                            'name'    => 'estate/detail-baluster',
                            'alt'     => 'Turned balusters and the curve of the handrail on the main staircase',
                            'caption' => 'Curved balusters',
                            'ratio'   => '3/4',
                            'widths'  => [640],
                            'sizes'   => '(min-width: 1080px) 34vw, 92vw',
                            'span'    => 5,
                            'source'  => 'photo',
                        ],
                        [
                            'name'    => 'estate/detail-capital',
                            'alt'     => 'The carved capital of a spiral column beside the staircase',
                            'caption' => 'A column made by hand',
                            'ratio'   => '3/4',
                            'widths'  => [640],
                            'sizes'   => '(min-width: 1080px) 34vw, 92vw',
                            'span'    => 5,
                            'offset'  => 7,
                            'raise'   => true,
                            'source'  => 'photo',
                        ],
                        [
                            'name'    => 'estate/detail-glass',
                            'alt'     => 'Leaded amber glazing in a moulded timber frame under the coffered ceiling',
                            'caption' => 'Leaded glass',
                            'ratio'   => '3/2',
                            'widths'  => [640, 960],
                            'sizes'   => '(min-width: 1080px) 40vw, 92vw',
                            'span'    => 6,
                            'offset'  => 1,
                            'source'  => 'photo',
                        ],
                        [
                            'name'    => 'estate/detail-fittings',
                            'alt'     => 'A brass espagnolette bolt and hinges on the open leaf of a glazed door',
                            'caption' => 'Metal fittings',
                            'ratio'   => '3/4',
                            'widths'  => [640],
                            'sizes'   => '(min-width: 1080px) 26vw, 92vw',
                            'span'    => 4,
                            'offset'  => 8,
                            'raise'   => true,
                            'source'  => 'photo',
                        ],
                        [
                            'name'    => 'estate/detail-coffers',
                            'alt'     => 'The coffered ceiling above the landing',
                            'caption' => 'A coffered ceiling',
                            'ratio'   => '3/2',
                            'widths'  => [640, 960],
                            'sizes'   => '(min-width: 1080px) 46vw, 92vw',
                            'span'    => 7,
                            'source'  => 'photo',
                        ],
                        [
                            'name'    => 'estate/detail-stove',
                            'alt'     => 'The relief panel and moulded crown of a historical tiled stove, its firebox alight',
                            'caption' => 'A tiled stove',
                            'ratio'   => '3/2',
                            'widths'  => [640, 960],
                            'sizes'   => '(min-width: 1080px) 26vw, 92vw',
                            'span'    => 4,
                            'offset'  => 8,
                            'raise'   => true,
                            'source'  => 'photo',
                        ],
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT THREE — the sheet. A pause, and the darkest ground on the page.
        //
        // Five lines and no sixth. Everything here is in the confirmed list at
        // the top of this file, in the plainest form it can be put in: a date
        // with "c." in front of it because around 1910 is what is known, a
        // park in hectares because that is the unit the measurement came in,
        // and a restoration with a start and no end, because it has one and
        // not the other.
        // ===================================================================

        [
            'tone'   => 'interior',
            'blocks' => [
                [
                    'type'    => 'film-ledger',
                    'id'      => 'facts',
                    'index'   => '05',
                    'eyebrow' => 'The record',
                    'title'   => 'The house, in five lines.',
                    'items'   => [
                        ['label' => 'Built',       'value' => 'c. 1910'],
                        ['label' => 'Architect',   'value' => 'Wilhelm Bockslaff'],
                        ['label' => 'Park',        'value' => '2.4 hectares'],
                        ['label' => 'Restoration', 'value' => 'Since 2024'],
                        ['label' => 'Location',    'value' => 'Jūrmala, Latvia'],
                    ],
                    'note' => 'The restoration is led by the architect Ināra Caunīte, and it is under way now.',
                ],
            ],
        ],

        // ===================================================================
        // ACT FOUR — out of doors. The seal's green, grounded.
        // ===================================================================

        [
            'tone'   => 'park',
            'blocks' => [

                [
                    'type'    => 'film-chapter',
                    'id'      => 'lands',
                    'index'   => '06',
                    'eyebrow' => 'Origins',
                    'title'   => 'The lands, and the century that followed.',
                    'body'    => [
                        'The earliest records of the Majori lands date to the sixteenth '
                        . 'century. For centuries the territory belonged to the von Fircks '
                        . 'family of Kurzeme, who spent their summers at the manor and left a '
                        . 'steward to keep it through the rest of the year.',

                        'After the agrarian reform of 1920 the manor became state property, '
                        . 'and through the twentieth century it served a succession of public '
                        . 'functions. The architectural identity survived that century largely '
                        . 'intact — which is not the usual outcome, and it is the reason there '
                        . 'is something here to restore rather than to reproduce.',
                    ],
                ],

                [
                    'type'    => 'film-band',
                    'id'      => 'park',
                    'variant' => 'wide',
                    'film'    => [
                        'name'   => 'est-park',
                        'poster' => 'estate/est-park',
                        'ratio'  => '21/9',
                        'alt'    => 'The park side of the manor at golden hour, its portico seen past a mature tree on the lawn',
                        'source' => 'generated',
                    ],
                    'index'   => '07',
                    'eyebrow' => 'The park',
                    'title'   => 'Ground of its own',
                    'caption' => 'The park front',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'It is the boundary of the estate in the plainest sense. Everything the manor is, is inside it.',
                    'body'  => [
                        'The park is 2.4 hectares — twenty-four thousand square metres — and '
                        . 'it is private ground rather than a garden the house happens to have. '
                        . 'What is unusual about it is not the size but the address: this much '
                        . 'of it, in one piece, in the centre of Jūrmala.',
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT FIVE — the hearth. The seal's wine, grounded.
        // ===================================================================

        [
            'tone'   => 'evening',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'id'      => 'renewal',
                    'variant' => 'full',
                    'film'    => [
                        'name'   => 'est-hearth',
                        'poster' => 'estate/est-hearth',
                        'ratio'  => '16/9',
                        'alt'    => 'A room with a white tiled stove alight, a grand piano beside it',
                        'source' => 'generated',
                    ],
                    'overlay' => [
                        'index'   => '08',
                        'eyebrow' => 'Restoration',
                        'title'   => 'A period of renewal',
                    ],
                    /*
                       A CAPTION ON A BAND THAT DOES NOT NEED ONE, because the
                       label rides on it: film-band.php appends "Generated
                       image" to the caption and nowhere else, so a band with
                       an overlay and no caption is a synthesised frame with
                       nothing saying so. Two words is the price of the label.
                    */
                    'caption' => 'The tiled stove',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'In 2024 the manor returned to private ownership, and a comprehensive restoration began.',
                    'body'  => [
                        'What the house is being restored for is a private estate and a '
                        . 'members\' club — the same rooms, kept, and put back to the use a '
                        . 'house like this was built for.',

                        'There is no date on that, and there will not be one here until there '
                        . 'is one.',
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT SIX — the last screen. Near-black, where the page began.
        //
        // The line is the brand's and it has been on this page since it was
        // written; it now closes the page instead of sitting in the middle of
        // it. Two ways on, and the first of them is the site's single
        // conversion path (ARCHITECTURE §3.3).
        // ===================================================================

        [
            'tone'   => 'estate',
            'blocks' => [
                [
                    'type'    => 'film-invitation',
                    'id'      => 'belonging',
                    'eyebrow' => 'Majori Manor',
                    'title'   => 'Some places are visited. Others, you belong to.',
                    'body'    => 'The house has not opened. When it does, it opens to a company kept small.',
                    'seal'    => ['name' => 'brand/seal-gold', 'alt' => ''],
                    'actions' => [
                        ['page_id' => 'club',    'label' => 'Discover the club', 'variant' => 'primary'],
                        ['page_id' => 'contact', 'label' => 'Private enquiry',   'variant' => 'quiet'],
                    ],
                ],
            ],
        ],
    ],
];
