<?php
/**
 * English content of the Padel & Social Club. Arrays only, no markup.
 *
 * EVERY NUMBER ON THIS PAGE COMES OUT OF THIS LIST AND THERE IS NOTHING ELSE:
 *
 *     four panoramic courts
 *     53.0 m — the width of the complex
 *     6.5 m — the social zone: open bar, lounge, padel shop
 *     37.5 m — the sanitary zone: 19 shower cabins and 2 WC modules
 *     a clipped yew hedge of 1.8–2.2 m around the perimeter
 *     landscape lighting along the hedge
 *     the club crest at the centre of each court
 *
 * AND THESE ARE NOT SAID ANYWHERE, IN ANY FORM:
 *
 *     court dimensions
 *     roofs, automatic or retractable
 *     a total area in square metres
 *     an opening date
 *     prices
 *     any requirement of membership in order to play
 *
 * The first three come from an earlier version of the plan that has been
 * superseded; the rest are not settled. A sentence that needs one of them
 * is a sentence to rewrite, not a number to estimate — which is why the copy
 * below describes what is where rather than how big it is. THE REBUILD SETTLED
 * NOTHING, so both lists are the ones that were already here.
 *
 * THE FIVE WAYS THE COURTS ARE USED ARE THE OWNER'S OWN WORDS and are the only
 * programme named anywhere on the page: private tournaments, members' matches,
 * coaching, guest access, events. They are §10 of the brief, verbatim. No
 * schedule, no season, no hour, no coach and no tournament has a name.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * WHAT CHANGED IN THE REBUILD. The page this replaces was a specification
 * sheet with pictures missing from it: a hatched hero, a floor plan as the
 * centrepiece, a facts table, four blocks of prose and one more hatched box.
 * It ran to about 430 words of body copy. This one runs to about 250, and
 * every sentence that was describing something a picture now shows was cut
 * rather than kept beside it.
 *
 * FOUR SENTENCES SURVIVED WORD FOR WORD because they are the approved ones:
 * "Play. Meet. Stay.", "A club that happens to have courts", "The side of it
 * nobody plays on", and "Padel is where the day begins, not where the
 * experience ends." The last is the CEO's line and it is the argument of the
 * whole page; it is set as a display lede rather than as a pull-quote, because
 * on this page it is a conclusion and not an ornament.
 *
 * THE PLAN IS STILL HERE AND IS NO LONGER THE CENTREPIECE. It sits in act two
 * behind the five settled facts, drawn on the mahogany ground, as a supporting
 * architectural document. plan-padel.php is the same component the old page
 * rendered, with the same six labels and the same accessible description, and
 * the only thing this page does to it is light it for a dark ground. The court
 * block itself was redrawn when the count settled at four — two rows of two
 * instead of three, centred in the enclosure. See §4 of docs/PADEL.md.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * 'source' IS A CLAIM ABOUT THE PICTURE AND IT IS MADE HERE (ARCHITECTURE
 * §11). This page carries three of the four values:
 *
 *   render     the project's own visualisations of the complex — the courts,
 *              the sign, the terrace, the padel shop, the park. Every one
 *              prints "Visualisation".
 *   generated  the four Seedance 2.0 sequences and their posters. Every one
 *              prints "Generated image".
 *   photo      exactly one picture, and it is not of the padel club: the
 *              pavilion, in the index of the estate at the foot of the page.
 *
 * THERE IS NO PHOTOGRAPH OF THESE COURTS AND THERE CANNOT BE ONE. The complex
 * is drawn, not built. When it is standing and a photographer has been, the
 * 'render' values in this file become 'photo' — one word each, here, and
 * nowhere else.
 *
 * NO PICTURE IS MARKED 'mood'. The page this replaces had two hatched boxes
 * waiting to become reference images; there is nothing left for that value to
 * do, because every slot on the page is now filled by a picture of this
 * project that says what it is.
 *
 * THE PAGE MOVES THROUGH FIVE GROUNDS AND OPENS ON THE GREEN. The park first,
 * because the club is in the park; mahogany where the drawing is; the darkest
 * ground for the courts, because the late-afternoon sequence is the brightest
 * picture on the site and wants the quietest surround; green again for the
 * terrace; near-black for the park at night; and wine for the last three
 * scenes. Every one of the five is declared in estate.css §1 and none of them
 * is new. The brief's rhythm asks for a warm cream somewhere in the middle of
 * that; on this system cream is the ink and not a ground, and inventing a
 * sixth ground to hold it would be the one thing the rebuild was told not to
 * do.
 *
 * THIS PAGE OWNS ITS OWN CHROME, as the three film pages before it do and for
 * the same reason: the film needs a bar that can be transparent over its hero
 * and a last screen that can close it. What that chrome says is still the
 * site's — film-nav.php builds itself from routes.php and common.php.
 */

declare(strict_types=1);

return [

    'meta' => [
        'title'       => 'Padel & Social Club — Majori Manor, Jūrmala',
        'description' => 'Four panoramic courts inside the park of a private estate in Jūrmala, and a social world built around them: an open bar, a lounge and a padel shop along one edge of the complex.',
    ],

    /*
       SportsActivityLocation, with the estate's own address. No openingHours
       and no priceRange (ARCHITECTURE §13): there is nothing open to describe
       and no price settled, and marking an unbuilt service as a running one is
       what that rule exists to prevent. '@context' and the canonical 'url' are
       added by jsonld() in helpers.php.

       UNCHANGED BY THE REBUILD, because the rebuild settled no fact a crawler
       could be told about.
    */
    'jsonld' => [
        '@type'       => 'SportsActivityLocation',
        'name'        => 'Majori Manor — Padel & Social Club',
        'description' => 'Four panoramic padel courts inside the private park of Majori Manor in Jūrmala, Latvia, with an open bar, a lounge and a padel shop alongside them.',
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
    // The same hero component the three pages before it open on, at the same
    // full viewport, with the same cream seal over it. What differs is where
    // the camera is standing: the Main Page arrives at a house, THE ESTATE
    // comes through its gates, THE CLUB is already indoors — and this one is
    // out in the park after sunset, walking down the lit path toward the club.
    //
    // NOTHING IN THE FRAME SAYS SPORT UNTIL THE COURTS DO. A paved walk, a
    // clipped hedge uplit along its whole length, a low dark pavilion with its
    // windows warm — and then, filling the right of the shot, the courts
    // glowing behind glass. That is the point the brief makes in one line —
    // arriving at a private club, not at a sports centre — and it is made by
    // the picture before a word of the copy is read.
    //
    // THE SIGN PANEL WAS THE FIRST CHOICE AND IS NOW SCENE FIVE'S. It is the
    // best single picture in the padel material and it was the wrong plate for
    // this hero: the crest cut into that panel is the same crest the hero
    // stands in cream at the top of the copy, so the first screen carried it
    // twice, and the panel's own lettering ran under the statement. See the
    // note above SEQUENCES in tools/photos/build_padel_media.py.
    //
    // ONE SENTENCE UNDER THE TITLE AND NO SUBTITLE. THE CLUB carries both;
    // this hero is asked for eyebrow, title, one line, cue, and a fifth
    // element in that stack would be the thing that makes it a page rather
    // than a first frame.
    // =======================================================================

    'hero' => [
        'eyebrow'   => 'Padel & Social Club',
        'title'     => 'Play. Meet. Stay.',
        'statement' => 'Four panoramic courts inside the park walls, and a social world built around them.',
        'cue'       => 'Step inside',
        // The first scene of THIS page; the component defaults to the Main
        // Page's #arrival, which does not exist here. See film-hero.php.
        'cue_target' => 'club',

        'seal' => ['name' => 'brand/seal-cream', 'alt' => 'Majori Manor'],

        'film' => [
            'name'   => 'pad-arrival',
            'poster' => 'padel/pad-arrival',
            'ratio'  => '16/9',
            'alt'    => 'The lit path to the padel club after sunset: a clipped hedge uplit along it, the clubhouse at the end, glazed courts glowing to the right',
            'source' => 'generated',
        ],
    ],

    'acts' => [

        // ===================================================================
        // ACT ONE — the club, on the seal's green.
        //
        // The scene the brief calls "a club that happens to have courts", and
        // the instruction attached to it is that the image should carry more
        // of the message than the paragraphs do. So: three short sentences,
        // and then the one frame in the library that holds the whole complex
        // at its own 21:9, edge to edge inside the shell.
        // ===================================================================

        [
            'tone'   => 'park',
            'blocks' => [

                [
                    'type'    => 'film-chapter',
                    'id'      => 'club',
                    'index'   => '01',
                    'eyebrow' => 'The club',
                    'title'   => 'A club that happens to have courts.',
                    'body'    => [
                        'The complex sits at the daylight end of the estate, inside the park. '
                        . 'Four panoramic courts fill the middle of it, and both edges are given '
                        . 'over to everything that happens around a game rather than during one.',

                        'A clipped yew hedge runs the whole way round, lit low along its length '
                        . 'once the evening comes. From the park it is a green wall with one way '
                        . 'in; inside it the complex is its own place.',
                    ],
                ],

                [
                    'type'    => 'film-band',
                    'variant' => 'wide',
                    'film'    => [
                        'poster' => 'padel/club-park',
                        'ratio'  => '21/9',
                        'alt'    => 'The whole complex at night: the clubhouse and its sign at the left, the lit path and hedge across the foreground, glazed courts running away to the right',
                        'source' => 'render',
                    ],
                    'caption' => 'The club, from the park',
                ],
            ],
        ],

        // ===================================================================
        // ACT TWO — the complex. Mahogany over black.
        //
        // THE FACTS FIRST AND THE DRAWING SECOND, which is the change the
        // brief asks for in as many words: the plan is not the centrepiece any
        // more. The ledger is THE ESTATE's own component — five labels, five
        // values, a hairline drawn under each as it arrives — and it is the
        // right one here because these five ARE the settled facts of the
        // complex and there is no sixth.
        //
        // The drawing then stands under them with an eyebrow and no heading of
        // its own, which is what makes it read as the sheet the title block
        // belongs to rather than as a second section.
        // ===================================================================

        [
            'tone'   => 'heritage',
            'blocks' => [

                /*
                   Five lines and no sixth, and every one of them is in the
                   confirmed list at the top of this file. What is not here is
                   as deliberate: no court size, no area, no roof.
                */
                [
                    'type'    => 'film-ledger',
                    'id'      => 'complex',
                    'index'   => '02',
                    'eyebrow' => 'The complex',
                    'title'   => 'Four courts, and two edges.',
                    'items'   => [
                        ['label' => 'Courts',        'value' => 'Four panoramic'],
                        ['label' => 'Complex width', 'value' => '53.0 m'],
                        ['label' => 'Social zone',   'value' => '6.5 m · open bar, lounge, padel shop'],
                        ['label' => 'Sanitary zone', 'value' => '37.5 m · 19 shower cabins, 2 WC modules'],
                        ['label' => 'Enclosure',     'value' => 'Clipped yew hedge, 1.8–2.2 m'],
                    ],
                    'note'    => 'The club crest is set at the centre of each court.',
                ],

                /*
                   THE LABELS BELONG HERE AND THE GEOMETRY BELONGS TO THE
                   COMPONENT.

                   'label' is what is printed on the drawing; 'legend' is the
                   line that replaces it under the drawing on a phone, where a
                   label at seven pixels would be texture rather than text.
                   Both are ordinary strings in an ordinary content file, so
                   the day Latvian arrives the SVG is not touched — the
                   numbering, the discs and the legend all follow the order of
                   this list.

                   'a11y' is the accessible name and description of the
                   drawing. The legend is not either of those: it is only on
                   the page below 768px, and a list of six lines does not say
                   what is beside what in any case. The description does, at
                   every width.

                   NOT ONE STRING BELOW CHANGED IN THE REBUILD. There is no
                   title: the ledger above has already named this scene, and a
                   second display line here would make the drawing a section
                   rather than the sheet the facts were read off.
                */
                [
                    'type'    => 'plan-padel',
                    'eyebrow' => 'The plan',

                    'a11y' => [
                        'title' => 'Plan of the padel and social club',
                        'desc'  => 'A schematic plan of the complex, 53 metres wide. Four courts fill the centre in two rows of two. A social zone runs the length of the right-hand edge — open bar, lounge and padel shop — and a sanitary zone the length of the left. A clipped yew hedge encloses the whole perimeter, and the main entrance is at the foot of the plan, on the centre line.',
                    ],

                    'items' => [
                        [
                            'id'     => 'width',
                            'label'  => '53.0 m',
                            'legend' => 'The complex is 53.0 metres across.',
                        ],
                        [
                            'id'     => 'courts',
                            'label'  => 'Four courts',
                            'legend' => 'Four panoramic courts, in two rows of two, filling the centre.',
                        ],
                        [
                            'id'     => 'social',
                            'label'  => 'Social zone · 6.5 m',
                            'legend' => 'The social zone, 6.5 metres along the right-hand edge: open bar, lounge, padel shop.',
                        ],
                        [
                            'id'     => 'sanitary',
                            'label'  => 'Sanitary zone · 37.5 m',
                            'legend' => 'The sanitary zone, 37.5 metres along the left-hand edge: 19 shower cabins and two WC modules.',
                        ],
                        [
                            'id'     => 'hedge',
                            'label'  => 'Clipped yew hedge',
                            'legend' => 'A clipped yew hedge, 1.8 to 2.2 metres, around the whole perimeter.',
                        ],
                        [
                            'id'     => 'entrance',
                            'label'  => 'Main entrance',
                            'legend' => 'The main entrance, on the centre line at the foot of the plan.',
                        ],
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT THREE — playing here, at the darkest ground on the page.
        //
        // THE ONE DAYLIGHT PICTURE ON THE SITE, and it is here because a page
        // arguing that a member can spend a whole day at the club has to be
        // able to show one. The library holds no daytime padel reference at
        // all; this sequence descends from a GPT Image 2 still that moved the
        // sun on the project's own courts and changed nothing else. It is
        // marked "Generated image" for exactly that reason.
        //
        // THE FIVE USES ARE THE BRIEF'S OWN AND THERE IS NO SIXTH. Named in
        // one sentence rather than set as a grid of cards, because a padel
        // page with a feature grid on it is the page this one replaces.
        // ===================================================================

        [
            'tone'   => 'interior',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'variant' => 'full',
                    'id'      => 'courts',
                    'film'    => [
                        'name'   => 'pad-courts',
                        'poster' => 'padel/pad-courts',
                        'ratio'  => '16/9',
                        'alt'    => 'The courts late in the afternoon, seen along the hedge: glass and steel walls, blue-grey surfaces, players between them',
                        'source' => 'generated',
                    ],
                    'overlay' => [
                        'index'   => '03',
                        'eyebrow' => 'Playing here',
                        'title'   => 'The courts.',
                    ],
                    'caption' => 'An hour before sunset',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'Four panoramic courts, and the crest of the club at the centre of each one.',
                    'body'  => [
                        'Private tournaments, members\' matches, coaching, guests playing here for '
                        . 'the first time, and the club\'s own events: the courts carry all of it, '
                        . 'and the complex is arranged so that none of it has to happen in a hurry.',

                        'An event can take the whole of it — four courts, the bar and the lounge '
                        . 'together — or one court and a table for afterwards. Both happen here.',
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT FOUR — the social side. Back to the seal's green.
        //
        // THE SCENE THE PAGE EXISTS FOR. "The side of it nobody plays on" is
        // the approved line and it is kept; what is new is that it now has
        // something under it. The sequence is the terrace at dusk — the bar,
        // the lounge, the guests, the court on the other side of the planting
        // — and the two plates after it are the padel shop and the terrace
        // itself, which are the two things the old page had a hatched box for.
        //
        // PLAY -> MEET, and the whole argument is that the second is not a
        // facility attached to the first.
        // ===================================================================

        [
            'tone'   => 'park',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'variant' => 'full',
                    'id'      => 'social',
                    'film'    => [
                        'name'   => 'pad-social',
                        'poster' => 'padel/pad-social',
                        'ratio'  => '16/9',
                        'alt'    => 'The terrace at dusk: a long bar under a timber canopy, low seating with candle lanterns, the illuminated club racket, and a lit court beyond the planting',
                        'source' => 'generated',
                    ],
                    'overlay' => [
                        'index'   => '04',
                        'eyebrow' => 'The social zone',
                        'title'   => 'The side of it nobody plays on.',
                    ],
                    'caption' => 'The terrace',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'Six and a half metres down one edge, carrying three things.',
                    'body'  => [
                        'The open bar, the lounge and the padel shop. The bar looks onto the '
                        . 'courts, so a match is watched from a chair as easily as from the side '
                        . 'of it.',

                        'The lounge is the part that stays busy after the courts have gone quiet '
                        . '— people who came to play and stayed for the afternoon, and people who '
                        . 'never went on court at all.',
                    ],
                ],

                /*
                   TWO PLATES ON ONE ROW, AND THE SPANS DO NOT OVERLAP: 5 and 6
                   with the air between them, the portrait raised so the two
                   feet do not line up. The twelve columns are the Main Page's
                   and so is the rule that makes them work — within a row,
                   spans and offsets must not overlap or the grid drops the
                   second plate onto a row of its own.
                */
                [
                    'type'    => 'film-plates',
                    'variant' => 'act',
                    'plates'  => [
                        [
                            'name'    => 'padel/shop-lockers',
                            'alt'     => 'A lit cabinet of club rackets above a row of ball lockers, a court visible through the glass beyond',
                            'caption' => 'The padel shop',
                            'ratio'   => '4/5',
                            'widths'  => [640, 960],
                            'sizes'   => '(min-width: 1080px) 38vw, 92vw',
                            'span'    => 5,
                            'raise'   => true,
                            'source'  => 'render',
                        ],
                        [
                            'name'    => 'padel/social-terrace',
                            'alt'     => 'The bar under its canopy at dusk, the club racket standing on the deck, a lit court to the right',
                            'caption' => 'The bar, and the court beyond it',
                            'ratio'   => '3/2',
                            'widths'  => [640, 960],
                            'sizes'   => '(min-width: 1080px) 46vw, 92vw',
                            'span'    => 6,
                            'offset'  => 6,
                            'source'  => 'render',
                        ],
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT FIVE — the park. Near-black.
        //
        // THE SCENE THAT STOPS THE CLUB BEING A FACILITY, and the picture is
        // the argument in one frame: the club's own sign standing on the grass
        // at blue hour, the hedge running away behind it — and at the end of
        // the path, lit, the manor house. Nothing has to be claimed in the copy
        // because the two buildings are in the same shot.
        //
        // "Inside the park walls" IS THE HERO'S OWN LINE, held back six scenes
        // and given to the picture that proves it.
        // ===================================================================

        [
            'tone'   => 'estate',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'variant' => 'full',
                    'id'      => 'park',
                    'film'    => [
                        'name'   => 'pad-gates',
                        'poster' => 'padel/pad-gates',
                        'ratio'  => '16/9',
                        'alt'    => 'The lit club sign on the grass at blue hour, the clipped hedge running away behind it and the manor house lit at the end of the path',
                        'source' => 'generated',
                    ],
                    'overlay' => [
                        'index'   => '05',
                        'eyebrow' => 'The park',
                        'title'   => 'Inside the park walls.',
                    ],
                    'caption' => 'The way in, and the house behind it',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'The courts are not a facility beside the estate. They are inside it.',
                    'body'  => [
                        'The same gates, the same walk, the same trees. What is on the other side '
                        . 'of the hedge is the park, and what is on the other side of the park is '
                        . 'the house.',
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT SIX — the evening, and the way on. Wine.
        //
        // "Padel is where the day begins, not where the experience ends" is
        // the CEO's line and the argument of the page. It is set as the lede
        // of the chapter under the last sequence — a display line in the
        // reader's way, immediately after the picture of the club going quiet
        // — rather than as a pull-quote between two sections, which is where
        // the old page had it and where a line stops being a conclusion.
        //
        // THEN THE ESTATE, AS FOUR TILES AND NOT AS A LIST OF AMENITIES. The
        // component is the Main Page's index of the estate, at half its
        // length: four places, four pages, one line each.
        // ===================================================================

        [
            'tone'   => 'evening',
            'blocks' => [

                /*
                   THE ONE BAND ON THE PAGE WITH NO COURTS AND NO CLUB IN IT,
                   and that is the scene. The day has ended on this side of the
                   hedge; what the picture shows is the walk back up through the
                   park, which is where the rest of the evening is. padel.js
                   gives it the same very slow scale it gives the panorama in
                   act one — the two stills on a page of sequences.
                */
                [
                    'type'    => 'film-band',
                    'variant' => 'full',
                    'id'      => 'evening',
                    'film'    => [
                        'poster' => 'padel/park-night',
                        'ratio'  => '16/9',
                        'alt'    => 'The park at night: a lit gravel path between clipped box and lamp posts, a stone rotunda under the trees',
                        'source' => 'render',
                    ],
                    'overlay' => [
                        'index'   => '06',
                        'eyebrow' => 'Day into evening',
                        'title'   => 'The courts go quiet.',
                    ],
                    'caption' => 'The park, on the way back up',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'Padel is where the day begins, not where the experience ends.',
                    'body'  => [
                        'Whatever the day has been, it tends to end on the same side of the hedge '
                        . '— and then, more often than not, further up the park.',
                    ],
                ],

                /*
                   FOUR TILES, FOUR PAGES, AND NOT ONE OF THEM IS PADEL. The
                   brief asks for a restrained transition toward the rest of
                   the estate rather than a list of what is on it, so each tile
                   is a place the reader can go and the line under it says what
                   is there rather than what is offered.

                   THE PICTURES ARE FOUR NO OTHER PAGE HAS CUT A STILL FROM.
                   Two of them are the sources of the Main Page's own
                   sequences, which is not the same thing as its pictures.
                */
                [
                    'type'    => 'film-world',
                    'id'      => 'estate',
                    'index'   => '07',
                    'eyebrow' => 'The estate',
                    'title'   => 'One part of a private world.',
                    'items'   => [
                        [
                            'page_id' => 'club',
                            'name'    => 'padel/world-club',
                            'label'   => 'The Club',
                            'note'    => 'The house, and the table laid in it.',
                            'alt'     => 'A laid table under a chandelier in a panelled dining room',
                            'source'  => 'render',
                        ],
                        [
                            'page_id' => 'events',
                            'name'    => 'padel/world-events',
                            'label'   => 'Events',
                            'note'    => 'The pavilion on the lawn, lit from within.',
                            'alt'     => 'A glass dome lit from inside on a lawn at night, a long building beside it',
                            'source'  => 'photo',
                        ],
                        [
                            'page_id' => 'after_dark',
                            'name'    => 'padel/world-dark',
                            'label'   => 'After Dark',
                            'note'    => 'The rooms an evening ends in.',
                            'alt'     => 'A dark panelled room with leather armchairs drawn up to a lit hearth',
                            'source'  => 'render',
                        ],
                        [
                            'page_id' => 'residences',
                            'name'    => 'padel/world-stay',
                            'label'   => 'Residences',
                            'note'    => 'And somewhere in the park to stay.',
                            'alt'     => 'Timber cottages at night, a lit path running between them',
                            'source'  => 'render',
                        ],
                    ],
                ],

                /*
                   THE LAST SCREEN, AND THE HEADING IS THE OLD PAGE'S OWN. "A
                   court, and the rest of the day" was the closing call of the
                   version this replaces; what changed is that six scenes now
                   stand behind it.

                   TWO WAYS ON, AND THE FIRST IS THE SITE'S SINGLE CONVERSION
                   PATH (ARCHITECTURE §3.3). 'Book padel' goes to Contact, and
                   that is not a stand-in for a link that exists somewhere
                   else: there is no booking system yet and which one it will be
                   is undecided. An enquiry is answered by a person today, so
                   the button says what it does.
                */
                [
                    'type'    => 'film-invitation',
                    'id'      => 'belonging',
                    'eyebrow' => 'Padel & Social Club',
                    'title'   => 'A court, and the rest of the day.',
                    'body'    => 'The club has not opened. Every application to join it is read individually.',
                    'seal'    => ['name' => 'brand/seal-gold', 'alt' => ''],
                    'actions' => [
                        ['page_id' => 'membership', 'label' => 'Apply for membership', 'variant' => 'primary'],
                        ['page_id' => 'contact',    'label' => 'Book padel',           'variant' => 'quiet'],
                    ],
                ],
            ],
        ],
    ],
];
