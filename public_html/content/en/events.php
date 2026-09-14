<?php
/**
 * English content of Events & the Pavilion. Arrays only, no markup.
 *
 * THE PAVILION IS THE PAGE. EVENTS and PAVILION were merged into one navigation
 * item deliberately (ARCHITECTURE §3.2): somebody planning a wedding is looking
 * for where to hold it, not for a dome to hire, and two menu items about one
 * building would make them choose between two words for the same thing.
 *
 * EVERYTHING THIS PAGE IS ALLOWED TO SAY ABOUT THE PAVILION IS ON THIS LIST:
 *
 *     a geodesic glass pavilion, 18 m in diameter
 *     approximately 250 m²
 *     100–120 guests seated for dinner
 *     set in the private park
 *     glass by day, a lit object in the park by night
 *
 * AND NONE OF THESE APPEARS ANYWHERE, IN ANY FORM:
 *
 *     a price, a package, a minimum spend, a deposit
 *     catering, a kitchen, a menu, a bar, a supplier list, or anything about
 *       who cooks
 *     availability, a season, an opening date, "from May", "year-round"
 *     what is included, what is extra, how long a booking runs
 *     heating, air conditioning, a dance floor, a stage, parking, or any
 *       equipment at all
 *     a standing capacity, a ceremony capacity, or any number other than the
 *       three above
 *
 * The second list is not caution. None of it is settled by the owner
 * (ARCHITECTURE §21), and the specific failure to avoid here is worse than on
 * any other page: a number quoted for an event is a number somebody plans a
 * wedding around. Where a sentence needed one of them, the sentence was
 * rewritten rather than the number estimated. THE REBUILD SETTLED NOTHING, so
 * both lists are the ones that were already here.
 *
 * REGISTER: THE ESTATE DESCRIBING AN EVENING IN A BUILDING IT OWNS, not a venue
 * selling dates. No "unforgettable", no "your special day", no "bespoke", no
 * second person plural at all. This is why the closing call is not either of
 * the two headlines the brief proposed — "an evening worth remembering" and
 * "make the estate your occasion" are the two registers this file's own header
 * has always forbidden. What ships says the same thing in the house's grammar.
 * See docs/EVENTS.md §8.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * WHAT CHANGED IN THE REBUILD. The page this replaces was an informational
 * page about a venue: a hero, three paragraphs, a facts table, a four-picture
 * gallery with two hatched boxes in it, another three paragraphs, a split, a
 * pull-quote and a call to action. It ran to about 480 words of body copy and
 * it described a building. This one runs to about 300 and it describes an
 * evening.
 *
 * THE PAGE IS ONE CONTINUOUS EVENING AND THE ORDER IS THE ARGUMENT:
 *
 *     00  the arrival      the pavilion lit at night, from the air — the film
 *     01  the pavilion     the same place in the afternoon, before anything
 *     02  day into dusk    the light going, in one shot, and the five facts
 *     03  the gathering    the lawn, the strung lights, the first half hour
 *     04  the table        dinner, in the house's own rooms
 *     05  the estate       what an evening here actually takes in
 *     06  the celebration  inside the dome, later
 *     07  six evenings     what people hold here, as six rooms and six lines
 *     08  the estate       four places, four pages
 *         the invitation   the seal, and two ways to write
 *
 * THE HERO IS NIGHT AND SCENE 01 IS THE AFTERNOON, and that is not an
 * accident: the first screen is where the evening ends up, and the film then
 * goes back to the beginning of the day and walks forward to it. PADEL opens
 * after sunset and puts its one daylight picture in act three for the same
 * reason. Scene 05 is the frame the hero film arrives at, which is where the
 * loop closes.
 *
 * FOUR SENTENCES SURVIVED WORD FOR WORD because they are the approved ones:
 * "A glass pavilion standing in the private park, with the estate around it for
 * the rest of the evening", "It is one room. Nothing is partitioned off", the
 * argument for a round building and against a hall with a door at each end, and
 * "A glass dome can be put up anywhere; a glass dome in the park of a 1910
 * manor house in the middle of Jūrmala cannot."
 *
 * ─────────────────────────────────────────────────────────────────────────
 * 'source' IS A CLAIM ABOUT THE PICTURE AND IT IS MADE HERE (ARCHITECTURE
 * §11). This page carries three of the four values:
 *
 *   photo      the two supplied photographs of the pavilion that ship as
 *              pictures, the supplied film of it, and the one external shot of
 *              the house. THIS IS THE ONLY FILM PAGE WHOSE HERO IS A
 *              PHOTOGRAPH: the hero is media_src/MOTION/HERO/pavilion.mp4, real
 *              footage of the real building, and it is declared as such.
 *   render     the project's own visualisations — the dining rooms, the lobby,
 *              the lounge, the bar, the concierge desk, the courts.
 *   generated  the four Seedance 2.0 sequences and their posters, and the one
 *              GPT Image 2 still that is scene 07's first room.
 *
 * NO PICTURE IS MARKED 'mood'. The page this replaces had two, and both were
 * the same admission: no photograph existed of a ceremony in this park or of a
 * dinner laid in this pavilion. Both are now answered by pictures that descend
 * from photographs of this place — the ceremony chairs are in scene 01's own
 * frame and in the sequence made from it, and scene 07's first room is a still
 * made from the one photograph of the dome's interior. There is nothing left
 * for that value to do.
 *
 * THE PAGE MOVES THROUGH FIVE GROUNDS AND DESCENDS. The park's green while it
 * is still afternoon; mahogany as the light goes; the deepest ground for the
 * lawn at night, because the gathering sequence is the brightest picture on the
 * page and wants the quietest surround; mahogany again for the dining rooms,
 * which are made of it; near-black for the estate seen whole; and wine for the
 * celebration and the last three screens. Every one of the five is declared in
 * estate.css §1 and none of them is new. The brief's rhythm asks for a warm
 * cream in the middle of that; on this system cream is the ink and not a
 * ground, and inventing a sixth ground to hold it would be the one thing the
 * rebuild was told not to do — the same answer PADEL gave.
 *
 * THIS PAGE OWNS ITS OWN CHROME, as the four film pages before it do and for
 * the same reason: the film needs a bar that can be transparent over its hero
 * and a last screen that can close it. What that chrome says is still the
 * site's — film-nav.php builds itself from routes.php and common.php, so this
 * page names the same places in the same words as every other, and marks itself
 * as the one the reader is standing on.
 */

declare(strict_types=1);

return [

    'meta' => [
        'title'       => 'Events & the Pavilion — Majori Manor, Jūrmala',
        'description' => 'A geodesic glass pavilion of about 250 m² in the private park of Majori Manor in Jūrmala, seating 100–120 guests for dinner, with the estate around it for the rest of the evening.',
    ],

    /*
       EventVenue, with the estate's own address (ARCHITECTURE §13). No
       openingHours, no priceRange and no capacity: the first two describe a
       business that is running and the third would put a number into a graph
       that is quoted back without the sentence around it. '@context' and the
       canonical 'url' are added by jsonld() in helpers.php.

       UNCHANGED BY THE REBUILD, because the rebuild settled no fact a crawler
       could be told about.
    */
    'jsonld' => [
        '@type'       => 'EventVenue',
        'name'        => 'The Pavilion at Majori Manor',
        'description' => 'A geodesic glass pavilion in the private park of Majori Manor in Jūrmala, Latvia, used for weddings, private dinners and gatherings.',
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
    // THE ONE HERO ON THE SITE THAT IS NOT A GENERATION. The four film pages
    // before this one open on a Seedance sequence made from a still; this one
    // opens on media_src/MOTION/HERO/pavilion.mp4 — eight seconds of real
    // aerial footage of the real pavilion, descending slowly toward the lit
    // dome with the long event building at the right, the festoon-lit lawn
    // under it and the pines black behind. The brief for this page names that
    // file and forbids replacing it. Nothing replaced it: it is cropped to
    // nothing, graded for the copy that stands on it, made into a palindrome
    // loop and encoded twice. See tools/photos/build_events_media.py.
    //
    // ONE SENTENCE UNDER THE TITLE AND NO SUBTITLE, which is PADEL's rule and
    // for PADEL's reason: a fifth element in this stack is what makes a first
    // frame into a page. The sentence is the approved page's own lede, kept.
    //
    // THE TITLE IS TWO WORDS AND SETS ON TWO LINES. The brief proposes
    // PRIVATE CELEBRATIONS / BENEATH THE TREES; at the hero's own type size
    // the second half cannot be set on this screen without either shrinking
    // the first or running four lines deep. The first half sets exactly as the
    // brief draws it — one word over another — and the trees are in the
    // picture behind it, which is where the second half was always doing its
    // work.
    // =======================================================================

    'hero' => [
        'eyebrow'   => 'Events & the Pavilion',
        'title'     => 'Private Celebrations',
        'statement' => 'A glass pavilion standing in the private park, with the estate around it for the rest of the evening.',
        'cue'       => 'Begin the evening',
        // The first scene of THIS page; the component defaults to the Main
        // Page's #arrival, which does not exist here. See film-hero.php.
        'cue_target' => 'pavilion',

        'seal' => ['name' => 'brand/seal-cream', 'alt' => 'Majori Manor'],

        'film' => [
            'name'   => 'ev-arrival',
            'poster' => 'events/ev-arrival',
            'ratio'  => '16/9',
            'alt'    => 'The pavilion at night from the air: a geodesic glass dome lit from within, the long event building beside it, and a lawn strung with lights',
            // Real footage of the real building. The only 'photo' hero on the
            // site, and the reason is in the note above.
            'source' => 'photo',
        ],
    ],

    'acts' => [

        // ===================================================================
        // ACT ONE — the pavilion, on the seal's green, and still afternoon.
        //
        // THE FILM GOES BACK TO THE BEGINNING OF THE DAY. The hero is the end
        // of the evening; this is the first hour of it, and it is the only
        // daylight screen on the page.
        //
        // THE ONE PICTURE THAT SAYS WHERE THE PAVILION STANDS. pavilion_2 is
        // an aerial of the dome at the edge of the pines with the brick path
        // crossing the lawn and the chairs set out at the left, and until this
        // page it had never been used anywhere. It is graded deep — see
        // DAYLIGHT in the build script — because a white dome on a mown lawn
        // is, measured, the brightest object in the library and this is a
        // near-black film.
        // ===================================================================

        [
            'tone'   => 'park',
            'blocks' => [

                [
                    'type'    => 'film-chapter',
                    'id'      => 'pavilion',
                    'index'   => '01',
                    'eyebrow' => 'The pavilion',
                    'title'   => 'A glass room in the park.',
                    'body'    => [
                        'Eighteen metres of glass standing on its own ground inside the private '
                        . 'park, with the trees around the whole circumference. By day what is in '
                        . 'it is the park: the light arrives through the pines rather than through '
                        . 'a window.',

                        'It is one room. Nothing is partitioned off, and an evening held here '
                        . 'happens in front of everybody who came to it.',
                    ],
                ],

                [
                    'type'    => 'film-band',
                    'variant' => 'full',
                    'film'    => [
                        'poster' => 'events/pavilion-day',
                        'ratio'  => '16/9',
                        'alt'    => 'The glass pavilion on the lawn at the edge of a pine wood, a brick path crossing to it and rows of chairs set out on the grass',
                        'source' => 'photo',
                    ],
                    'caption' => 'The park, late in the afternoon',
                ],
            ],
        ],

        // ===================================================================
        // ACT TWO — the light goes. Mahogany over black.
        //
        // THE PAGE'S ONE PIECE OF TIME-LAPSE, AND IT IS THE SAME PICTURE AS
        // THE SCENE ABOVE IT. ev-dusk starts from the exact crop scene 01
        // prints as a still, and takes it from late afternoon through blue
        // hour to a dome glowing from inside with the path lit — one shot, no
        // cut, the camera almost still. That the reader has just been looking
        // at frame 0 as a photograph is the whole effect: the picture they
        // were shown gets dark in front of them.
        //
        // THE FIVE FACTS ARE UNDER IT AND HAVE NO SCENE NUMBER OF THEIR OWN.
        // The ledger is THE ESTATE's component and this is the third page to
        // set it; here it is the specification of the room the light just went
        // out of, so it belongs to scene 02 rather than being scene 03.
        // ===================================================================

        [
            'tone'   => 'heritage',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'variant' => 'full',
                    'id'      => 'dusk',
                    'film'    => [
                        'name'   => 'ev-dusk',
                        'poster' => 'events/ev-dusk',
                        'ratio'  => '16/9',
                        'alt'    => 'The pavilion and its lawn as the afternoon goes over into night, the dome slowly lighting from within and small lights coming up along the path',
                        'source' => 'generated',
                    ],
                    'overlay' => [
                        'index'   => '02',
                        'eyebrow' => 'Day into dusk',
                        'title'   => 'And then the light goes.',
                    ],
                    'caption' => 'The same lawn, an hour later',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'By night it reverses.',
                    'body'  => [
                        'From anywhere in the grounds the pavilion is a lit object among dark '
                        . 'trees; from inside it, the park is the dark it is lit against. Nothing '
                        . 'is done to the building to make that happen. It is what a glass room '
                        . 'does at the end of an afternoon.',
                    ],
                ],

                /*
                   Five lines and no sixth, and every one of them is in the
                   confirmed list at the top of this file. What is not here is
                   as deliberate: no standing capacity, no dimension beyond the
                   diameter, and nothing about what an evening in it involves.
                */
                [
                    'type'    => 'film-ledger',
                    'id'      => 'room',
                    'eyebrow' => 'The room',
                    'title'   => 'One room, and what is in it.',
                    'items'   => [
                        ['label' => 'Structure',     'value' => 'Geodesic glass, 18 m across'],
                        ['label' => 'Floor area',    'value' => 'Approximately 250 m²'],
                        ['label' => 'Seated',        'value' => '100–120 guests for dinner'],
                        ['label' => 'Setting',       'value' => 'The private park'],
                        ['label' => 'Day and night', 'value' => 'Glass by day; a lit object in the park by night'],
                    ],
                    'note'    => 'The trees stand around the whole circumference.',
                ],
            ],
        ],

        // ===================================================================
        // ACT THREE — the gathering, at the darkest ground on the page.
        //
        // THE BRIGHTEST PICTURE ON THE PAGE WANTS THE QUIETEST SURROUND, which
        // is PADEL's argument for its own act three and holds here: the lawn
        // under its strung lights is a wall of warm gold, and mahogany behind
        // it would make the screen hum.
        //
        // THE PEOPLE ARE THE POINT OF THIS SCENE AND THEY ARE ALL AT A
        // DISTANCE. The brief asks for silhouettes, groups from behind and
        // distant conversation, and for the environment to stay the
        // protagonist. Every figure in ev-gather is in dark evening dress,
        // turned away or in profile, at the far side of a cocktail table. Not
        // one face is in focus anywhere on this page.
        //
        // TWO PLATES, AND BOTH ARE ROOMS THE LAWN LEADS TO — the desk an
        // arriving guest speaks to first, and the chairs the evening ends up
        // in. Neither file had ever been cut as a still before this page.
        // ===================================================================

        [
            'tone'   => 'interior',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'variant' => 'full',
                    'id'      => 'gathering',
                    'film'    => [
                        'name'   => 'ev-gather',
                        'poster' => 'events/ev-gather',
                        'ratio'  => '16/9',
                        'alt'    => 'Guests in evening dress standing in small groups among linen-covered tables on a lawn strung with lights, the lit pavilion at the left and the event building at the right',
                        'source' => 'generated',
                    ],
                    'overlay' => [
                        'index'   => '03',
                        'eyebrow' => 'The gathering',
                        'title'   => 'Where the evening begins.',
                    ],
                    'caption' => 'On the lawn, before dinner',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'An evening here does not begin in the room it is held in.',
                    'body'  => [
                        'It begins on the grass between the pavilion and the long building beside '
                        . 'it, with the lights strung overhead and nothing yet settled about where '
                        . 'anybody is sitting.',

                        'That half hour is most of what people remember afterwards, and it is the '
                        . 'part a room with a door at each end cannot give them.',
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
                            'name'    => 'events/arrival-desk',
                            'alt'     => 'A panelled reception desk under a brass lamp, the estate\'s crest and wordmark on the wall behind it',
                            'caption' => 'Arrival',
                            'ratio'   => '4/5',
                            'widths'  => [640, 960],
                            'sizes'   => '(min-width: 1080px) 38vw, 92vw',
                            'span'    => 5,
                            'raise'   => true,
                            'source'  => 'render',
                        ],
                        [
                            'name'    => 'events/detail-lamp',
                            'alt'     => 'Two buttoned leather armchairs drawn up either side of a lamp under a portrait in a panelled room',
                            'caption' => 'And later, indoors',
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
        // ACT FOUR — the table. Mahogany, because the rooms are made of it.
        //
        // THE ROOM IS EMPTY AND THAT IS THE SCENE. The brief asks for
        // conversation in the background here; the reference has nobody in it,
        // and putting people into a dining room by prompt is the one thing
        // this model reliably gets wrong. The scene either side of this is
        // full of guests, so this one can be the room itself: a table laid and
        // waiting, between the gathering that comes to it and the celebration
        // that leaves it.
        //
        // WHAT IS NOT CLAIMED HERE. Not who cooks, not what is served, not
        // whether a kitchen is running. The sentences are about rooms the
        // estate owns.
        // ===================================================================

        [
            'tone'   => 'heritage',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'variant' => 'full',
                    'id'      => 'dining',
                    'film'    => [
                        'name'   => 'ev-table',
                        'poster' => 'events/ev-table',
                        'ratio'  => '16/9',
                        'alt'    => 'A panelled dining room by candlelight: round tables laid with cream linen and glassware under a candle chandelier',
                        'source' => 'generated',
                    ],
                    'overlay' => [
                        'index'   => '04',
                        'eyebrow' => 'Dining',
                        'title'   => 'A table that runs long.',
                    ],
                    'caption' => 'The house\'s own rooms, laid',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'Dinner is not a course of the evening. It is the middle of it.',
                    'body'  => [
                        'The house keeps its own dining rooms, and an evening in the park can move '
                        . 'into one of them — the whole of a room, or a single table in it, for as '
                        . 'long as the conversation lasts.',

                        'Which of them, and for how long, is a conversation rather than a page.',
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT FIVE — the estate, seen whole. Near-black.
        //
        // THE FRAME THE HERO FILM ARRIVES AT, HELD BACK FIVE SCENES. The hero
        // is a descent toward the dome; this is the picture that descent is
        // heading for, standing still — the pavilion, the long building, the
        // lit lawn between them. It is a photograph and it does not move, so
        // events.js gives it the only camera a still can honestly have: a very
        // slow scale scrubbed to the scroll, which is padel.js's own job.
        //
        // THE SENTENCE THE WHOLE PAGE IS FOR is the lede of the chapter under
        // it, and the second paragraph is the approved page's own closing
        // argument, kept word for word.
        // ===================================================================

        [
            'tone'   => 'estate',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'variant' => 'full',
                    'id'      => 'estate',
                    'film'    => [
                        'poster' => 'events/pavilion-air',
                        'ratio'  => '16/9',
                        'alt'    => 'The pavilion and the long event building from the air at night, the lawn between them strung with lights and set with tables',
                        'source' => 'photo',
                    ],
                    'overlay' => [
                        'index'   => '05',
                        'eyebrow' => 'The estate',
                        'title'   => 'The estate is part of it.',
                    ],
                    'caption' => 'The pavilion, and the building beside it',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'An evening at Majori Manor is never just one room.',
                    'body'  => [
                        'The pavilion stands in a private park of 2.4 hectares, with the manor '
                        . 'house at the other end of it and the courts behind the hedge. What an '
                        . 'evening here takes in is a decision rather than a floor plan.',

                        'Which is what the address is really for. A glass dome can be put up '
                        . 'anywhere; a glass dome in the park of a 1910 manor house in the middle '
                        . 'of Jūrmala cannot.',
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT SIX — the celebration, and everything after it. Wine.
        //
        // THE LAST SEQUENCE AND THE ONLY ONE INSIDE THE DOME AT FULL EVENING.
        // It descends from the project's own visualisation of exactly that —
        // the lit geodesic frame, the chandelier, the candles, the guests in
        // dark evening dress — and it was trimmed rather than regenerated when
        // the last second of the move brought two of them too close. See the
        // note above SEQUENCES in the build script.
        //
        // NOT A NIGHTCLUB. No dancing, no confetti, no coloured light, no
        // stage, no crowd. The brief rules all five out by name and the prompt
        // rules them out in the same words.
        //
        // THEN THE SIX EVENINGS, AND THEY ARE SIX ROOMS RATHER THAN SIX CARDS.
        // The component is THE CLUB's dialogue: the names stand in a list and
        // the room behind them changes to the one the reader is on, by scroll
        // and — on a fine pointer only — by hover. A grid of service cards is
        // what the page this replaces had, and it is what the brief for this
        // one rules out in as many words.
        // ===================================================================

        [
            'tone'   => 'evening',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'variant' => 'full',
                    'id'      => 'celebration',
                    'film'    => [
                        'name'   => 'ev-celebrate',
                        'poster' => 'events/ev-celebrate',
                        'ratio'  => '16/9',
                        'alt'    => 'An evening inside the lit pavilion: guests in dark evening dress around candlelit tables under the glass dome and its strings of lights',
                        'source' => 'generated',
                    ],
                    'overlay' => [
                        'index'   => '06',
                        'eyebrow' => 'The celebration',
                        'title'   => 'And the evening keeps going.',
                    ],
                    'caption' => 'Inside the pavilion, later',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'The dinner, the speeches and the part nobody planned happen in the same eighteen metres.',
                    'body'  => [
                        'Which is the argument for a round building and against a hall with a door '
                        . 'at each end. There is no back of the room here. There is only the room.',
                    ],
                ],

                /*
                   SIX EVENINGS, SIX ROOMS, AND NOT ONE OF THEM IS A PACKAGE.
                   The first five are the brief's own categories and the sixth
                   is the approved page's own last line — "dinners that belong
                   to a season rather than to an occasion". Each note says what
                   the evening is like rather than what the estate would do for
                   it, because the second is the part nobody has settled.

                   THE FIRST ROOM IS THE INSIDE OF THIS PAVILION LAID FOR A
                   DINNER, and it is the one picture on the page that was
                   generated because a grade could not save the photograph it
                   came from. The audit found media_src/pavilion/pavilion_3.jpg
                   unused — it has been in the library since the beginning and
                   no page had ever cut a frame from it — and it is the only
                   photograph in existence of this pavilion in use. It is also
                   an overcast midday interior with white chairs, pale blue
                   sashes and a mirror ball in it, which is three of the things
                   the brief for this page rules out by name, and those are
                   properties of the objects rather than of the exposure: three
                   curves were tried and every one produced a murky pale-blue
                   banquet rather than an evening. So the photograph is the
                   reference and the tile is a GPT Image 2 still made from it
                   that changed the hour and the dressing and nothing else —
                   same dome, same frame, same camera, same tables, same floral
                   arch. It is declared 'generated' for exactly that reason.
                   See docs/EVENTS.md §3.
                */
                [
                    'type'    => 'film-dialogue',
                    'id'      => 'evenings',
                    'index'   => '07',
                    'eyebrow' => 'What happens here',
                    'title'   => 'Six kinds of evening.',
                    'items'   => [
                        [
                            'name'   => 'events/kind-wedding',
                            'label'  => 'Weddings',
                            'note'   => 'And the dinner that follows, which is usually the longer half.',
                            'alt'    => 'The inside of the glass pavilion after dark, laid for a dinner: candlelit round tables and a long table under the triangulated roof',
                            'source' => 'generated',
                        ],
                        [
                            'name'   => 'events/kind-dining',
                            'label'  => 'Private dinners',
                            'note'   => 'A room with a fire in it, three tables, and the door shut.',
                            'alt'    => 'A small green panelled dining room with a lit fire, round tables laid and portraits on the walls',
                            'source' => 'render',
                        ],
                        [
                            'name'   => 'events/kind-corporate',
                            'label'  => 'Corporate gatherings',
                            'note'   => 'The park keeps a room a good deal quieter than a room in town.',
                            'alt'    => 'A panelled salon under a chandelier, round tables laid the length of it',
                            'source' => 'render',
                        ],
                        [
                            'name'   => 'events/kind-culture',
                            'label'  => 'Cultural evenings',
                            'note'   => 'Books, music, and the people who make them.',
                            'alt'    => 'A small panelled room with leather armchairs drawn round a low table under portraits',
                            'source' => 'render',
                        ],
                        [
                            'name'   => 'events/kind-members',
                            'label'  => 'Members\' celebrations',
                            'note'   => 'The house\'s own occasions, and the ones its members bring to it.',
                            'alt'    => 'People in evening dress standing at a bar at the far side of a panelled room',
                            'source' => 'render',
                        ],
                        [
                            'name'   => 'events/kind-seasonal',
                            'label'  => 'Seasonal dinners',
                            'note'   => 'Dinners that belong to a season rather than to an occasion.',
                            'alt'    => 'A pale hall with a marble floor, a crystal chandelier and flowers on a round centre table',
                            'source' => 'render',
                        ],
                    ],
                ],

                /*
                   FOUR TILES, FOUR PAGES, AND NOT ONE OF THEM IS EVENTS. Each
                   tile is a place the reader can go and the line under it says
                   what is there rather than what is offered.

                   TWO OF THE FOUR PICTURES HAD NEVER BEEN USED ANYWHERE — the
                   bar and the cigar room — and the other two are crops no page
                   has cut. The estate's tile is the one photograph of the real
                   house in the library, and it is the only daylight picture
                   after scene 01.
                */
                [
                    'type'    => 'film-world',
                    'id'      => 'world',
                    'index'   => '08',
                    'eyebrow' => 'The estate',
                    'title'   => 'The rest of the private world.',
                    'items'   => [
                        [
                            'page_id' => 'estate',
                            'name'    => 'events/world-estate',
                            'label'   => 'The Estate',
                            'note'    => 'The house at the other end of the park.',
                            'alt'     => 'The manor house from the lawn, its roof and chimneys above the trees',
                            'source'  => 'photo',
                        ],
                        [
                            'page_id' => 'club',
                            'name'    => 'events/world-club',
                            'label'   => 'The Club',
                            'note'    => 'The rooms, and the bar at the end of them.',
                            'alt'     => 'A timber bar under lamps, ranked bottles on the shelves behind it',
                            'source'  => 'render',
                        ],
                        [
                            'page_id' => 'padel',
                            'name'    => 'events/world-padel',
                            'label'   => 'Padel',
                            'note'    => 'Four courts, behind the hedge.',
                            'alt'     => 'A glazed padel court lit from within at night',
                            'source'  => 'render',
                        ],
                        [
                            'page_id' => 'after_dark',
                            'name'    => 'events/world-dark',
                            'label'   => 'After Dark',
                            'note'    => 'Where an evening goes when it will not end.',
                            'alt'     => 'A dark panelled room with leather armchairs drawn up to a lit hearth',
                            'source'  => 'render',
                        ],
                    ],
                ],

                /*
                   THE LAST SCREEN, AND IT ARRIVES AT THE FORM WITH THE SUBJECT
                   ALREADY CHOSEN.

                   'query' puts ?subject=private-event on the address, and
                   components/form-enquiry.php reads it, checks it against the
                   schema's own option list and starts the select on it. So a
                   reader who spent this page thinking about a wedding lands on
                   a form that is already about private events — without a
                   script, without a session, and on a link they can bookmark
                   or send to somebody else. The page this replaces did the
                   same thing through components/cta.php; film-invitation.php
                   gained the same four lines so that nothing was lost in the
                   rebuild. See the note in that file.

                   TWO WAYS ON, AND THE FIRST IS THE SITE'S SINGLE CONVERSION
                   PATH (ARCHITECTURE §3.3). The gold button is the brief's own
                   words, and it goes to Contact because an evening here is
                   arranged by a person and there is nothing else for it to go
                   to.
                */
                [
                    'type'    => 'film-invitation',
                    'id'      => 'invitation',
                    'eyebrow' => 'Events & the Pavilion',
                    'title'   => 'An evening worth staying for.',
                    'body'    => 'The estate has not opened. An evening here is arranged in conversation, and every enquiry is read by a person.',
                    'seal'    => ['name' => 'brand/seal-gold', 'alt' => ''],
                    'actions' => [
                        [
                            'page_id' => 'contact',
                            'label'   => 'Plan a private event',
                            'variant' => 'primary',
                            'query'   => ['subject' => 'private-event'],
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
