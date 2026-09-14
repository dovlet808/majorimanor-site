<?php
/**
 * English content of Residences. Arrays only, no markup.
 *
 * THE SIXTH PAGE CUT FROM THE FILM, AND THE FIRST WHOSE SUBJECT IS A DAY.
 * The Main Page holds blue hour, THE ESTATE an afternoon, THE CLUB and EVENTS
 * an evening, PADEL the hour after sunset. This one starts at a door at night,
 * goes back to a morning, crosses an afternoon and ends at a fire — because a
 * stay is not an hour, and a page about staying that holds one hour is a page
 * about visiting.
 *
 * NO FACT LIST, FOR THE SAME REASON AS /the-club, AND THE REBUILD SETTLED
 * NOTHING. There are no confirmed facts about the residences at all. Not how
 * many there are, not how big, not what a night costs, not when they open, not
 * what is in one. Nothing (ARCHITECTURE §21). THE ESTATE, PADEL and EVENTS all
 * close on a film-ledger of five settled facts; this page has no ledger,
 * because it has no five. That absence is the one structural difference
 * between this page and the four film pages before it, and it is deliberate.
 *
 * NOTHING BELOW MAY EVER ACQUIRE, WITHOUT THE OWNER SAYING SO IN WRITING:
 *
 *     a number of residences, of rooms, of beds, or of anything else
 *     a size, a floor, an aspect or a view described as a particular one
 *     a rate, a minimum stay, a season or an opening date
 *     AMENITIES OF ANY KIND — and this is the specific trap on this page.
 *       Every hotel page ever written is a list of what is in the room, and
 *       the moment one appears here this stops being a residence on an estate
 *       and becomes a room in a hotel. The brief says so outright: register
 *       from the brochure, not a description of what you get.
 *     housekeeping, service, check-in, keys, or anybody who works here
 *
 * THE LAST LINE OF THAT LIST IS WHY SCENE 09 IS WRITTEN AS A NEGATION. The
 * brief for the rebuild asks for a hospitality scene whose message is "you are
 * staying inside a private estate, not checking into a hotel". That message is
 * available without breaking the rule, because it is entirely a statement about
 * what does NOT happen: nobody checks in, there is no counter, and the rest of
 * the house is not a list of amenities but a building the room is inside. Not
 * one sentence in scene 09 says what anybody does for you. See docs/RESIDENCES.md §1.
 *
 * SIX SENTENCES SURVIVED THE REBUILD WORD FOR WORD because they are the
 * approved ones: "The residences are inside the estate rather than beside it",
 * the hotel-room-versus-part-of-the-house distinction after it, "An evening at
 * the estate has a point at which going home is the least interesting thing
 * left to do", "The rooms look onto the park" and the sentence that finishes
 * it, "Dark wood, and light kept warm and low enough that a room is a room
 * after dark rather than a lit box", and the English-private-club register
 * paragraph. The page this replaces was 480 words of prose beside five
 * photographs; this one is about 330 words across eleven screens, and the six
 * that survived are the six that were already true.
 *
 * THE THREE KINDS OF RESIDENCE ARE THE MAIN PAGE'S OWN SENTENCE, SPLIT.
 * content/en/home.php scene 06 says: "The main suite is in the house. The guest
 * suites are in the second building, across the cobbles. The cottages are in
 * the trees." That is approved copy about a confirmed shape, and scene 08 below
 * is those three clauses standing under three pictures and nothing added to
 * them — no count, no size, no difference in what is provided, because none of
 * those is settled.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * THE PAGE IS ONE STAY AND THE ORDER IS THE ARGUMENT:
 *
 *     00  the arrival    a landing at night and a door standing open
 *     01  within         where the rooms are, and why they are not a hotel
 *     02  the room       the suite, at the end of an evening
 *     03  the detail     six things the house is made of, panned
 *     04  the morning    the same room, eight hours later — the page's one lift
 *     05  the park       the window, and what is on the other side of it
 *     06  the quiet      one picture, one line, and nothing else
 *     07  the evening    the fire downstairs, and the hour nobody drives home in
 *     08  three ways     the suite, the guest suites, the cottages
 *     09  the house      nobody checks in
 *     10  the estate     four places, four pages
 *         the invitation the seal, and two ways to write
 *
 * THE HERO IS NIGHT AND THE FOURTH SCENE IS SUNRISE, which is EVENTS' own
 * structure turned inside out: that page opens where its evening ends and walks
 * back to the beginning of the day. This one opens where a stay begins — at a
 * door, late — and then does the thing a visit cannot, which is to still be
 * there in the morning.
 *
 * THE PAGE MOVES THROUGH SIX GROUNDS AND IT IS THE ONLY ONE THAT GOES UP
 * BEFORE IT GOES DOWN. Mahogany for the house at blue hour; the pause ground
 * for the room and the details; DAWN — the one ground this page adds, declared
 * in residences.css §1 and nowhere else — for the morning; the park's green for
 * the afternoon; near-black for the quiet; wine for the evening and the last
 * four screens. Five of the six are estate.css §1's and are used unchanged. The
 * sixth is new, it is still a dark ground, and the argument for adding it is in
 * residences.css §1: EVENTS and PADEL both refused the brief's warm cream
 * because cream is this system's ink and not a ground, and that refusal was
 * right for two pages that never see daylight. This page has a sunrise in it.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * 'source' IS A CLAIM ABOUT THE PICTURE AND IT IS MADE HERE (ARCHITECTURE
 * §11). This page carries three of the four values and NOT 'mood', which is the
 * biggest single change from the page it replaces.
 *
 *   photo      the supplied photography of the real house: the landing, the
 *              stair hall, the window bay, the stove, the chimneypiece, the
 *              hall floor, the glazed doors, the house and its park. Eight
 *              frames, all of this building.
 *   render     the project's own visualisations — the main suite, the
 *              guest-suite building, the cottages, the desk in the hall, the
 *              dining room, and three of the four world tiles.
 *   generated  the five Seedance 2.0 sequences and their posters. Two of them
 *              descend through a GPT Image 2 still that changed the hour of a
 *              photograph of this house and nothing else.
 *
 * THE PAGE THIS REPLACES DECLARED ALL FIVE OF ITS PICTURES 'mood', and its own
 * header argued that this was permanent: the rooms in the brochure are
 * reference material, the residences do not exist to be photographed, and no
 * frame may be captioned as a room of ours. THAT RULE IS KEPT AND THE VALUE IS
 * GONE, which is not a contradiction. 'mood' is the licence to stand a
 * reference image in a slot and say nothing about it; what this page does
 * instead is say what every picture actually is. A photograph of the real
 * landing is a photograph of the real landing — that is 'photo', and its
 * caption says "the landing", not "your room". A visualisation of the main
 * suite is 'render'. Every caption on this page was written against the same
 * test the old header set: it may describe the frame that arrived, and it may
 * not promise a room. Nothing here is captioned as a residence of ours, because
 * there is not one yet.
 *
 * THIS PAGE OWNS ITS OWN CHROME, as the five film pages before it do and for
 * the same reason: the film needs a bar that can be transparent over its hero
 * and a last screen that can close it. What that chrome says is still the
 * site's — film-nav.php builds itself from routes.php and common.php, so this
 * page names the same places in the same words as every other, and marks itself
 * as the one the reader is standing on.
 */

declare(strict_types=1);

return [

    'meta' => [
        'title'       => 'Residences — Majori Manor, Jūrmala',
        'description' => 'Private residences within the estate at Majori Manor in Jūrmala — a room inside the house rather than beside it, with the park outside the window.',
    ],

    /*
       NO JSON-LD. §13 assigns none to this page, and the type that would fit —
       LodgingBusiness — is a business that takes bookings. This one does not
       take bookings, has no rates and has not opened, so marking it up as one
       is exactly what §13 forbids. /contact and /the-estate already describe
       the place itself. UNCHANGED BY THE REBUILD, because the rebuild settled
       no fact a crawler could be told about.
    */

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
    // A LANDING AT NIGHT, WITH A DOOR STANDING OPEN AT THE END OF IT — and
    // that is the whole argument of the page in one frame. Every other hero on
    // this site is a building seen from outside it: the manor at blue hour,
    // the manor at night, the courts through the trees, the pavilion from the
    // air. This one is already indoors, upstairs, and three metres from a door
    // that is not locked. A reader who has not read a word yet has been told
    // that they are staying rather than visiting.
    //
    // THE PICTURE IS THE REAL HOUSE AND THE HOUR IS NOT.
    // media_src/interiors/interiors_9.png is the first-floor landing of Majori
    // Manor, photographed in daylight, and until this page no page had used it
    // for anything. The two arches, the corridor, the open door, the
    // barley-twist balusters, the diamond-inlaid newel panel, the coffered
    // ceiling and the herringbone parquet are all in that photograph. What is
    // not in it is the night, so a GPT Image 2 still moved the sun and left
    // everything else exactly where it was, and Seedance walked a camera four
    // metres down the landing. The prompts are in
    // tools/photos/build_residences_media.py and docs/RESIDENCES.md §3.
    //
    // THE TITLE IS THE APPROVED PAGE'S OWN AND IT IS FOUR WORDS. The brief
    // draws it on two lines and it sets on two lines: "Staying," over "rather
    // than visiting." at every width down to 375, which is the one number
    // residences.css §2 exists to hold.
    //
    // ONE SENTENCE UNDER THE TITLE AND NO SUBTITLE, which is PADEL's rule and
    // EVENTS' rule and for their reason: a fifth element in this stack is what
    // makes a first frame into a page. The sentence is the approved page's own
    // lede, kept word for word.
    // =======================================================================

    'hero' => [
        'eyebrow'   => 'Private Residences',
        'title'     => 'Staying, rather than visiting',
        'statement' => 'A few rooms inside the estate, for the evenings that are not worth ending.',
        'cue'       => 'Come in',
        // The first scene of THIS page; the component defaults to the Main
        // Page's #arrival, which does not exist here. See film-hero.php.
        'cue_target' => 'within',

        'seal' => ['name' => 'brand/seal-cream', 'alt' => 'Majori Manor'],

        'film' => [
            'name'   => 'res-arrival',
            'poster' => 'residences/res-arrival',
            'ratio'  => '16/9',
            'alt'    => 'A first-floor landing at night: two round arches, a corridor beyond them, and a door standing open at the far end with warm light coming out of it',
            'source' => 'generated',
        ],
    ],

    'acts' => [

        // ===================================================================
        // ACT ONE — where the rooms are. Mahogany over black.
        //
        // THE DISTINCTION THE WHOLE PAGE RESTS ON, MADE IN THE FIRST SENTENCE
        // AND THEN NOT ARGUED ABOUT. "Not accommodation" is a claim about what
        // kind of thing this is; every sentence that follows has to be capable
        // of being true of a private house and false of a hotel, which is the
        // test each of these was written against and the reason all three
        // survived the rebuild unedited.
        //
        // THE ONE PICTURE THAT ANSWERS "WHERE". The second building at blue
        // hour with every window lit, cut wide out of a 2880-square
        // visualisation the Main Page uses tall. It puts the reader outside for
        // exactly one screen, which is what "within the estate" needs in order
        // to be within something.
        // ===================================================================

        [
            'tone'   => 'heritage',
            'blocks' => [

                [
                    'type'    => 'film-chapter',
                    'id'      => 'within',
                    'index'   => '01',
                    'eyebrow' => 'Within the estate',
                    'title'   => 'The rooms are in the house.',
                    'body'    => [
                        'The residences are inside the estate rather than beside it. They are not '
                        . 'accommodation, and the difference is not a matter of standard: a room in '
                        . 'a hotel is somewhere you have been put, and a residence at Majori Manor '
                        . 'is a part of the house you are already in.',

                        'They exist for the simplest reason there is. An evening at the estate has '
                        . 'a point at which going home is the least interesting thing left to do, '
                        . 'and a member who would rather not drive should not have to.',
                    ],
                ],

                [
                    'type'    => 'film-band',
                    'variant' => 'full',
                    'film'    => [
                        'poster' => 'residences/res-house',
                        'ratio'  => '16/9',
                        'alt'    => 'A white two-storey house at blue hour, its pediment and columns lit and every window warm, standing on a cobbled forecourt among clipped trees',
                        'source' => 'render',
                    ],
                    'caption' => 'The second building, at the end of the cobbles',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'The rooms look onto the park.',
                    'body'  => [
                        'That is the whole of what they face and the whole of what there is to hear '
                        . 'from them, which on an estate in the middle of Jūrmala is the thing '
                        . 'worth saying about a window.',
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT TWO — the room, and what it is made of. The pause ground.
        //
        // THE MAIN PAGE ALREADY HAS A SEQUENCE OF THIS ROOM AND IT WAS CHECKED
        // FIRST. assets/video/seq-suite.mp4 is a Seedance push-in on the main
        // suite, made for home scene 06; reusing it here would have cost
        // nothing and shown the reader the identical twelve seconds they have
        // already seen on the page that sent them. So the camera was turned
        // ninety degrees instead: res-room drifts sideways, from the bed toward
        // the window and the glazed doors, which is also the direction of the
        // page's argument. Same room, different shot. See the note above
        // SEQUENCES in the build script.
        //
        // THE DETAIL TRACK IS THE CLUB'S COMPONENT AND THE BRIEF ASKS FOR IT BY
        // NAME. Six close frames panned sideways by scroll, and every one of
        // them is a photograph of this building rather than a visualisation of
        // a room in it — which is the point of putting it here. What a
        // residence at Majori Manor is made of is not a specification; it is a
        // house that already exists, and these are six pieces of it.
        //
        // NOT ONE OF THE SIX IS ONE OF THE CLUB'S SIX. That page's track is
        // interiors_5, _14, _7, _11, _6 and _10; this one is interiors_9, _12,
        // _15, _2, GrandStaircase_4 and heritage_2, and three of those six had
        // never been cut at 3:4 by anything.
        // ===================================================================

        [
            'tone'   => 'interior',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'variant' => 'full',
                    'id'      => 'room',
                    'film'    => [
                        'name'   => 'res-room',
                        'poster' => 'residences/res-room',
                        'ratio'  => '16/9',
                        'alt'    => 'A panelled bedroom by lamplight at blue hour: bedside lamps lit either side of a buttoned headboard, a chandelier overhead, and a tall window and glazed doors onto the dark park',
                        'source' => 'generated',
                    ],
                    'overlay' => [
                        'index'   => '02',
                        'eyebrow' => 'The room',
                        'title'   => 'And then the door shuts.',
                    ],
                    'caption' => 'The main suite, at the end of an evening',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'Dark wood, and light kept warm and low enough that a room is a room after dark rather than a lit box.',
                    'body'  => [
                        'Pictures on the walls, hung as a house hangs them. The register is an '
                        . 'English private club rather than a hotel interior: the detail is old, '
                        . 'close and quiet, and the pleasure of it is in things that were made '
                        . 'rather than specified.',

                        'It is a house with a history of its own, and the rooms are meant to read '
                        . 'as part of that history rather than as an arrangement laid over it.',
                    ],
                ],

                [
                    'type'    => 'film-detail',
                    'id'      => 'detail',
                    'index'   => '03',
                    'eyebrow' => 'The house it is in',
                    'title'   => 'Made, rather than specified.',
                    'note'    => 'Six things that were already here.',
                    'frames'  => [
                        [
                            'name'    => 'residences/detail-arch',
                            'caption' => 'The landing',
                            'alt'     => 'A round arch on a carved oak pier, a corridor beyond it and a door standing open at the end, over herringbone parquet',
                            'source'  => 'photo',
                        ],
                        [
                            'name'    => 'residences/detail-window',
                            'caption' => 'A window in a wall',
                            'alt'     => 'A glazed timber window set into an interior wall above the stair, its casement standing open',
                            'source'  => 'photo',
                        ],
                        [
                            'name'    => 'residences/detail-stove',
                            'caption' => 'The stove',
                            'alt'     => 'A white tiled stove standing full height in the corner of a room, its firebox open below a moulded crown',
                            'source'  => 'photo',
                        ],
                        [
                            'name'    => 'residences/detail-doors',
                            'caption' => 'Doors that are also windows',
                            'alt'     => 'Tall glazed double doors standing open between two rooms, their glazing bars set in a pattern above',
                            'source'  => 'photo',
                        ],
                        [
                            'name'    => 'residences/detail-hearth',
                            'caption' => 'The chimneypiece',
                            'alt'     => 'A carved marble chimneypiece under a mirror, between panelled walls, on a chequered marble floor',
                            'source'  => 'photo',
                        ],
                        [
                            'name'    => 'residences/detail-floor',
                            'caption' => 'The floor of the hall',
                            'alt'     => 'A chequered black and white marble floor seen from above, beside the glazed timber enclosure of the stair',
                            'source'  => 'photo',
                        ],
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT THREE — the morning. THE ONE GROUND THIS PAGE ADDS, and the one
        // screen on the site in full daylight.
        //
        // THIS IS THE SCENE THE PAGE EXISTS FOR. Everything a visitor gets ends
        // at the door; the morning is the part only somebody who stayed is
        // there for, and there was no picture of it anywhere in the library —
        // every visualisation in the brochure is a made bed in a lit room at
        // night, which is what a property brochure photographs. So the
        // brochure's own room was taken, the sun was moved, the lamps were
        // switched off and the cover was turned back on one side of the bed.
        // Nothing else about the room changed. See docs/RESIDENCES.md §3.
        //
        // AND THE GROUND COMES UP UNDER IT. Five acts on this page stand on
        // estate.css's own grounds; this one stands on DAWN, which is
        // residences.css §1's single addition to the system — a warm dark that
        // is measurably lighter than the mahogany above it and still 15:1 on
        // the body text. A film that never brightens cannot have a morning in
        // it, and this page has one.
        // ===================================================================

        [
            'tone'   => 'dawn',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'variant' => 'full',
                    'id'      => 'morning',
                    'film'    => [
                        'name'   => 'res-morning',
                        'poster' => 'residences/res-morning',
                        'ratio'  => '16/9',
                        'alt'    => 'The same bedroom in early morning light: the lamps unlit, the curtains drawn back, long shapes of daylight lying across the parquet and the park visible through the glass',
                        'source' => 'generated',
                    ],
                    'overlay' => [
                        'index'   => '04',
                        'eyebrow' => 'The morning',
                        'title'   => 'And then it is simply morning.',
                    ],
                    'caption' => 'The same room, eight hours later',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'The part nobody plans for is the part that decides it.',
                    'body'  => [
                        'An evening is why you did not drive. A morning is why you would do it '
                        . 'again — a room with the light coming into it, and nowhere in particular '
                        . 'to be for an hour.',

                        'The park is awake a good deal earlier than the house.',
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT FOUR — the park, just outside. The seal's green.
        //
        // ROOM, WINDOW, PARK, ESTATE — IN THAT ORDER, AND THE ORDER IS THE
        // SCENE. The band is a window seen from inside a room; the two plates
        // under it are what is on the other side of it. Neither half works
        // alone: a photograph of a garden is a photograph of a garden, and a
        // photograph of a window is a photograph of a window. Together they are
        // the sentence this scene is for.
        //
        // THE SEASONS DO NOT MATCH AND NOTHING PRETENDS THEY DO. The window bay
        // was photographed in early spring and the park through that glass is
        // bare; the two plates were photographed in leaf. The sequence's prompt
        // forbids putting leaves on those branches — see the note in the build
        // script — and the plates are graded to a late afternoon rather than
        // graded into the same afternoon as the window. An estate has seasons;
        // a page that hides them is claiming a view nobody has photographed.
        // ===================================================================

        [
            'tone'   => 'park',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'variant' => 'full',
                    'id'      => 'park',
                    'film'    => [
                        'name'   => 'res-window',
                        'poster' => 'residences/res-window',
                        'ratio'  => '16/9',
                        'alt'    => 'A window bay in a panelled room: two tall windows over a fitted timber seat, sconces lit either side, and the bare trees of the park beyond the glass',
                        'source' => 'generated',
                    ],
                    'overlay' => [
                        'index'   => '05',
                        'eyebrow' => 'The park',
                        'title'   => 'The park, just outside.',
                    ],
                    'caption' => 'A window on the ground floor',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'A window here is not a view. It is the next room.',
                    'body'  => [
                        'Two and a half hectares of private park, with the manor at one end of it '
                        . 'and the courts behind the hedge. None of it is arranged to be looked at '
                        . 'from a window. It is simply what is there, and the window happens to be '
                        . 'on it.',

                        'Which is the difference between an address and a location.',
                    ],
                ],

                /*
                   TWO PLATES ON ONE ROW, AND THE SPANS DO NOT OVERLAP: 6 and 5
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
                            'name'    => 'residences/park-lawn',
                            'alt'     => 'The manor house seen from the mown lawn, a great tree standing over its portico',
                            'caption' => 'The house, from the lawn',
                            'ratio'   => '3/2',
                            'widths'  => [640, 960],
                            'sizes'   => '(min-width: 1080px) 46vw, 92vw',
                            'span'    => 6,
                            'source'  => 'photo',
                        ],
                        [
                            'name'    => 'residences/park-front',
                            'alt'     => 'The columned portico of the manor with the tree beside it and the grass in front',
                            'caption' => 'And the walk back to it',
                            'ratio'   => '4/5',
                            'widths'  => [640],
                            'sizes'   => '(min-width: 1080px) 38vw, 92vw',
                            'span'    => 5,
                            'offset'  => 7,
                            'raise'   => true,
                            'source'  => 'photo',
                        ],
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT FIVE — the quiet. Near-black, and the page's one silence.
        //
        // ONE PICTURE AND ONE SENTENCE, AND THE PICTURE DOES NOT MOVE. Every
        // other full screen on this page has a camera in it; this one is a
        // photograph with no overlay, no caption, no scene number and nothing
        // written on it at all — the only band on the site that carries none of
        // those. residences.js gives it the one camera a still can honestly
        // have, a very slow scale scrubbed to the scroll, and that is the whole
        // of the motion on this screen.
        //
        // THE LINE IS THE HOUSE'S OWN AND THE BRIEF ASKS FOR IT BY NAME. It is
        // set as a chapter heading on the ground rather than over the picture,
        // so the picture is silent and the sentence is alone: two screens, one
        // of which says nothing.
        //
        // WHAT HOUR IT IS, STATED, because a dark corridor is dark at any hour
        // and the page's clock has to keep running. This is the middle of the
        // afternoon in an empty house — between the park and the fire, which is
        // exactly where a stay has nothing scheduled.
        // ===================================================================

        [
            'tone'   => 'estate',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'variant' => 'full',
                    'id'      => 'quiet',
                    'film'    => [
                        'poster' => 'residences/res-quiet',
                        'ratio'  => '16/9',
                        'alt'    => 'A dark stair hall lit only by three wall sconces, the carved balustrade turning above and a lamp burning in a room through an open door',
                        'source' => 'photo',
                    ],
                ],

                [
                    'type'    => 'film-chapter',
                    'index'   => '06',
                    'eyebrow' => 'The quiet',
                    'title'   => 'Some places are visited. Others, you belong to.',
                ],
            ],
        ],

        // ===================================================================
        // ACT SIX — the evening, and everything after it. Wine.
        //
        // THE FIRE IS REAL. media_src/interiors/interiors_1.jpg is the only
        // photograph in the library of a lit fire in this house; THE ESTATE
        // prints it as a heritage detail and the Main Page as a plate, and
        // neither of them moves. This is the same fire, at 16:9, burning — and
        // it is the one screen where this page and THE CLUB, EVENTS and AFTER
        // DARK are unmistakably the same building at the same hour.
        //
        // NOT AN AFTER-DARK PAGE. The brief is explicit that the evening here
        // should connect to those three without becoming them, and the
        // difference is the sentence rather than the picture: this scene is
        // about not having to leave, which is a fact about the room upstairs
        // and not about the drink downstairs.
        //
        // THEN THE THREE KINDS, AND THEY ARE THREE ROOMS RATHER THAN THREE
        // CARDS. The component is THE CLUB's dialogue: the names stand in a
        // list and the picture behind them changes to the one the reader is on,
        // by scroll and — on a fine pointer only — by hover. A grid of room
        // cards is what the brief for this page rules out in as many words.
        // ===================================================================

        [
            'tone'   => 'evening',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'variant' => 'full',
                    'id'      => 'evening',
                    'film'    => [
                        'name'   => 'res-evening',
                        'poster' => 'residences/res-evening',
                        'ratio'  => '16/9',
                        'alt'    => 'A fire burning in a carved stone chimneypiece in a panelled room, a grand piano beside it and two armchairs drawn up to a chess table',
                        'source' => 'generated',
                    ],
                    'overlay' => [
                        'index'   => '07',
                        'eyebrow' => 'The evening',
                        'title'   => 'The evening does not end at the door.',
                    ],
                    'caption' => 'Downstairs, later',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'The advantage of staying is that nothing has to be timed.',
                    'body'  => [
                        'A conversation that would have ended at the car ends when it ends. A fire '
                        . 'that would have been left is sat in front of.',

                        'The last hour of an evening at Majori Manor is the one normally given up '
                        . 'to the drive home, and a residence is simply the decision not to give '
                        . 'it up.',
                    ],
                ],

                /*
                   THREE KINDS, THREE PICTURES, AND THE LINES ARE THE MAIN
                   PAGE'S OWN SENTENCE SPLIT INTO THREE. Nothing is added to
                   them: not a count, not a size, not a difference in what is in
                   one, because none of that is settled (ARCHITECTURE §21). What
                   IS settled is where the three are, and that is what each line
                   says.
                */
                [
                    'type'    => 'film-dialogue',
                    'id'      => 'ways',
                    'index'   => '08',
                    'eyebrow' => 'Where you stay',
                    'title'   => 'Three ways to be in the same estate.',
                    'items'   => [
                        [
                            'name'   => 'residences/kind-suite',
                            'label'  => 'The main suite',
                            'note'   => 'In the house itself.',
                            'alt'    => 'A panelled bedroom under a chandelier, its bedside lamps lit and the tall windows dark',
                            'source' => 'render',
                        ],
                        [
                            'name'   => 'residences/kind-guest',
                            'label'  => 'The guest suites',
                            'note'   => 'In the second building, across the cobbles.',
                            'alt'    => 'The lit ground floor of a white house at blue hour, its door open under a columned portico above a cobbled forecourt',
                            'source' => 'render',
                        ],
                        [
                            'name'   => 'residences/kind-cottage',
                            'label'  => 'The cottages',
                            'note'   => 'In the trees.',
                            'alt'    => 'Two timber cottages among trees at night, their windows warm and a lit path running between them',
                            'source' => 'render',
                        ],
                    ],
                ],

                /*
                   SCENE 09, AND EVERY SENTENCE IN IT IS A NEGATION.

                   The brief asks for the message "you are staying inside a
                   private estate, not checking into a hotel", and the rule at
                   the top of this file forbids housekeeping, service, check-in,
                   keys or anybody who works here. Both are satisfiable at once,
                   because the message is entirely about what does NOT happen.
                   Nothing below says what anybody does for you. The pictures
                   are the project's own visualisations of a desk in a hall and
                   a dining room, and their captions name the rooms rather than
                   the service.
                */
                [
                    'type'    => 'film-chapter',
                    'id'      => 'house',
                    'index'   => '09',
                    'eyebrow' => 'The house around it',
                    'title'   => 'Nobody checks in.',
                    'body'    => [
                        'Arriving at a house is not the same transaction as arriving at a hotel, '
                        . 'and the estate has no intention of making it one. What that comes to in '
                        . 'practice is a conversation rather than a counter.',

                        'And the rest of the house is downstairs. The rooms, the table, the fire '
                        . 'and the park are not amenities of the residence — the residence is a '
                        . 'room inside the building they are already in.',
                    ],
                ],

                [
                    'type'    => 'film-plates',
                    'variant' => 'act',
                    'plates'  => [
                        [
                            'name'    => 'residences/host-dining',
                            'alt'     => 'A panelled dining room under a candle chandelier, its tables laid and a mirrored overmantel at the far end',
                            'caption' => 'The table, downstairs',
                            'ratio'   => '4/5',
                            'widths'  => [640],
                            'sizes'   => '(min-width: 1080px) 38vw, 92vw',
                            'span'    => 5,
                            'raise'   => true,
                            'source'  => 'render',
                        ],
                        [
                            'name'    => 'residences/host-desk',
                            'alt'     => 'A panelled desk in a dark hall under a brass lamp, with flowers standing on it',
                            'caption' => 'And the hall you came through',
                            'ratio'   => '3/2',
                            'widths'  => [640, 960],
                            'sizes'   => '(min-width: 1080px) 46vw, 92vw',
                            'span'    => 6,
                            'offset'  => 6,
                            'source'  => 'render',
                        ],
                    ],
                ],

                /*
                   FOUR TILES, FOUR PAGES, AND NOT ONE OF THEM IS RESIDENCES.
                   Each tile is a place the reader can go and the line under it
                   says what is there rather than what is offered.

                   TWO OF THE FOUR PICTURES HAD NEVER BEEN CUT AS STILLS AT ALL
                   — estate_3, which is the reference THE ESTATE's own house
                   sequence was generated from, and whisky_collection, which no
                   page has ever used. The other two are crops no page has cut.
                */
                [
                    'type'    => 'film-world',
                    'id'      => 'world',
                    'index'   => '10',
                    'eyebrow' => 'The estate',
                    'title'   => 'The rest of the private world.',
                    'items'   => [
                        [
                            'page_id' => 'estate',
                            'name'    => 'residences/world-estate',
                            'label'   => 'The Estate',
                            'note'    => 'The house the rooms are in.',
                            'alt'     => 'The garden front of the manor house above its lawn',
                            'source'  => 'photo',
                        ],
                        [
                            'page_id' => 'club',
                            'name'    => 'residences/world-club',
                            'label'   => 'The Club',
                            'note'    => 'The rooms downstairs, and the bar at the end of them.',
                            'alt'     => 'A panelled lounge under low lamps, ranked bottles on the shelves behind it',
                            'source'  => 'render',
                        ],
                        [
                            'page_id' => 'events',
                            'name'    => 'residences/world-events',
                            'label'   => 'Events & the Pavilion',
                            'note'    => 'The glass room at the other end of the park.',
                            'alt'     => 'A geodesic glass pavilion on a lawn at the edge of a pine wood, a brick path crossing to it',
                            'source'  => 'photo',
                        ],
                        [
                            'page_id' => 'after_dark',
                            'name'    => 'residences/world-dark',
                            'label'   => 'After Dark',
                            'note'    => 'Where an evening goes when it will not end.',
                            'alt'     => 'Ranked bottles on a lit shelf in a dark panelled room',
                            'source'  => 'render',
                        ],
                    ],
                ],

                /*
                   THE LAST SCREEN, AND IT ARRIVES AT THE FORM WITH THE SUBJECT
                   ALREADY CHOSEN.

                   'query' puts ?subject=residences on the address, and
                   components/form-enquiry.php reads it, checks it against the
                   schema's own option list and starts the select on it. So a
                   reader who spent this page thinking about a stay lands on a
                   form that is already about residences — without a script,
                   without a session, and on a link they can bookmark or send to
                   somebody else. The page this replaces did the same thing
                   through components/cta.php; film-invitation.php gained the
                   same four lines with EVENTS so that nothing was lost here.

                   TWO WAYS ON, AND THE FIRST IS THE SITE'S SINGLE CONVERSION
                   PATH (ARCHITECTURE §3.3). The gold button is the brief's own
                   words and the brochure's, and it goes to Contact because a
                   stay here is arranged by a person and there is nothing else
                   for it to go to.
                */
                [
                    'type'    => 'film-invitation',
                    'id'      => 'invitation',
                    'eyebrow' => 'Private Residences',
                    'title'   => 'Stay within the estate.',
                    'body'    => 'The estate has not opened. A residence here is arranged in conversation, and every enquiry is read by a person.',
                    'seal'    => ['name' => 'brand/seal-gold', 'alt' => ''],
                    'actions' => [
                        [
                            'page_id' => 'contact',
                            'label'   => 'Enquire about residences',
                            'variant' => 'primary',
                            'query'   => ['subject' => 'residences'],
                        ],
                        [
                            'page_id' => 'membership',
                            'label'   => 'Apply for membership',
                            'variant' => 'quiet',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
