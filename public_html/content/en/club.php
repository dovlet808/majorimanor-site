<?php
/**
 * English content of THE CLUB. Arrays only, no markup.
 *
 * THERE IS NO FACT LIST AT THE TOP OF THIS FILE BECAUSE THERE ARE STILL NO
 * FACTS. Every other page opens with the short list of things the owner has
 * confirmed and every sentence is checked against it. This page has nothing to
 * check against: no room count, no floor area, no opening date, no hours, no
 * menu, no prices, no membership terms, no names of the people who work here.
 * Not "not yet supplied" — not settled at all (ARCHITECTURE §21).
 *
 * SO THE ABSENCE IS STILL THE PAGE RATHER THAN A GAP IN IT, and that has not
 * changed in the rebuild. What changed is that the pictures arrived, so the
 * page can now do with photography what it was previously trying to do with
 * paragraphs. THERE IS LESS PROSE HERE THAN THERE WAS: the version this
 * replaces ran to about 640 words of body copy, this one to about 380, and
 * every sentence that was describing a room a picture now shows was cut rather
 * than kept beside it.
 *
 * NOTHING BELOW MAY EVER ACQUIRE, WITHOUT THE OWNER SAYING SO IN WRITING:
 *
 *     how many rooms there are, or how big any of them is
 *     when the house opens, which rooms are open now, or when the rest will be
 *     what is on the table, who cooks it, or what kind of food it is
 *     a drinks list of any kind
 *     what membership costs or requires
 *     a member of staff, by name or by role
 *     a supplier, a designer, an architect or a restorer
 *
 * THE ROOMS ARE NAMED BY WHAT THEY ARE AND NOT BY WHAT IS PROMISED IN THEM.
 * The walk in scene 03 gives each of six rooms a line, which is a change from
 * the version this replaces — that one named them in a sentence and stopped,
 * on the argument that a list of rooms with descriptions is a list of promises
 * about rooms nobody has seen. Nobody had seen them. They can be seen now:
 * five of the six are on the page, and the line under each says what is in the
 * picture rather than what will happen in the room. That is the difference
 * between a caption and a promise, and it is the only reason the lines exist.
 *
 * TWO CHAPTERS OF THE HOME PAGE STILL ARRIVE HERE (ARCHITECTURE §3.2).
 * Chapter 02, "Inside the club", and chapter 04, "Dining at the club", are two
 * links to this one address, because the table is not a separate place from the
 * house it is laid in. Both land at the top, so the hero and the first chapter
 * are about the house AND its table, and the dining scene carries its own
 * eyebrow so a reader who came for it can see where it is on the way down.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * 'source' IS A CLAIM ABOUT THE PICTURE AND IT IS MADE HERE (§11). THIS IS
 * THE FIRST PAGE ON THE SITE TO CARRY THREE OF THE FOUR VALUES AT ONCE, and
 * that is the honest description of a members' club inside a house that is
 * standing but has not opened:
 *
 *   photo      the supplied photography of this building, cropped, graded and
 *              nothing else. Eleven frames of it, and they are the eleven
 *              THE ESTATE does not use — media_src/interiors/ grew from four
 *              files to fifteen after that page was built.
 *   render     the project's own visualisations: the library, the private
 *              dining room, the terrace, the rooms with people in them. Every
 *              one prints "Visualisation".
 *   generated  the four Seedance 2.0 sequences and their posters. Every one
 *              prints "Generated image".
 *
 * The components print the label themselves and a content file cannot switch
 * it off — see mark_for() in app/helpers.php, which is where the rule lives
 * now that four components read it.
 *
 * WHAT IS NOT ON THIS PAGE. No picture is marked 'mood'. The version this
 * replaces was eight hatched boxes and every one of them was going to be a
 * reference image — atmosphere standing in for a room we could not show. There
 * is nothing left for that value to do here: the rooms can be shown, the ones
 * that cannot be photographed are visualised and say so, and a reference image
 * on a page this specific would be the only picture on it making no claim at
 * all.
 *
 * THE PAGE MOVES THROUGH FIVE GROUNDS AND OPENS ON THE GREEN. THE ESTATE opens
 * near-black at the gates; this one begins where that page ended — already
 * inside, with the park on the other side of the glass — so it opens on the
 * seal's green, goes to mahogany where the woodwork is, to the darkest ground
 * for the details, back to green for the table, to wine for the members' room
 * and the dialogue, and closes on near-black. Every one of the five is
 * declared in estate.css §1 and none of them is new.
 *
 * THIS PAGE OWNS ITS OWN CHROME, as the two before it do and for the same
 * reason: the film needs a bar that can be transparent over its hero and a last
 * screen that can close it. What that chrome says is still the site's.
 */

declare(strict_types=1);

return [

    'meta' => [
        'title'       => 'The Club — Majori Manor, Jūrmala',
        'description' => 'The manor house at Majori Manor in Jūrmala, used as a house by the people who belong to it: a hall, a drawing room, a library, a private dining room, and a table that runs long.',
    ],

    /*
       NO JSON-LD, ON THE SAME GROUND AS /membership AND FOR THE SAME REASON.

       ARCHITECTURE §13 assigns a type to every page that has something a
       crawler can describe and assigns none to this one. What is here is a
       private club that has not opened. The vocabulary would be an
       Organization with openingHours, or a Restaurant, and both are the
       "unbuilt service marked up as running" that §13 forbids in as many
       words. The estate itself is already described on /the-estate and
       /contact, which are the pages that can stand behind it.

       Rebuilding the page did not settle a single fact, so this stays exactly
       as it was: when the house opens and the owner settles the terms, this is
       where that goes — and not before.
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
    // 00  THE ARRIVAL INSIDE
    //
    // The same hero component the two pages before it open on, at the same
    // full viewport, with the same cream seal over it. What differs is where
    // the camera is standing: the Main Page arrives at a house and THE ESTATE
    // comes through its gates, and this one is already indoors, moving across
    // the hall toward the glazed doors with the lit rooms behind them.
    //
    // OUTSIDE -> THRESHOLD -> INSIDE, and the picture does all three: the
    // windows at the left are night, the doors at the centre are lit from the
    // far side, and the camera is on the warm end of both.
    //
    // Made from interiors_6 — the one photograph of the hall that has the
    // doors, the staircase and the chimneypiece in one frame — through a GPT
    // Image 2 still that changed the hour and nothing else.
    // =======================================================================

    'hero' => [
        'eyebrow'   => 'Members & guests',
        'title'     => 'The Club',
        'subtitle'  => 'The house, once you are inside it',
        'statement' => 'Past the front door the estate stops being something to look at and becomes a set of rooms.',
        'cue'       => 'Come in',
        // The first scene of THIS page; the component defaults to the Main
        // Page's #arrival, which does not exist here. See film-hero.php.
        'cue_target' => 'house',

        'seal' => ['name' => 'brand/seal-cream', 'alt' => 'Majori Manor'],

        'film' => [
            'name'   => 'club-arrival',
            'poster' => 'club/club-arrival',
            'ratio'  => '16/9',
            'alt'    => 'The entrance hall at night: glazed timber doors lit from the far side, the staircase beyond them, a chequered marble floor',
            'source' => 'generated',
        ],
    ],

    'acts' => [

        // ===================================================================
        // ACT ONE — the first words, on the seal's green.
        // ===================================================================

        [
            'tone'   => 'park',
            'blocks' => [

                [
                    'type'    => 'film-chapter',
                    'id'      => 'house',
                    'index'   => '01',
                    'eyebrow' => 'The Club',
                    'title'   => 'A house, used as a house.',
                    'body'    => [
                        'The club is not a room inside the manor house. It is the house: the '
                        . 'same doors, the same floors, the same windows onto the park, kept as '
                        . 'rooms to sit in rather than as rooms to be shown.',

                        'Nothing here is arranged around a service. A member arrives and is in '
                        . 'the house rather than seated in it, and which room is for what tends '
                        . 'to be settled by the hour and the company.',
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT TWO — the woodwork. Mahogany over black.
        //
        // The band is the plainest argument the page makes: two open doors,
        // a glazed stove portal between them, and a chair and a table showing
        // through the right-hand one. A house is a set of rooms you can see
        // out of into the next.
        //
        // The walk is estate.css's and estate.js's, unchanged. It is the one
        // place on the site where scroll drives a camera, and putting THE
        // CLUB's rooms through it rather than building a second sequence
        // component is the whole point of the two pages sharing a file.
        // ===================================================================

        [
            'tone'   => 'heritage',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'variant' => 'inset',
                    'id'      => 'inside',
                    'index'   => '02',
                    'eyebrow' => 'Inside',
                    'title'   => 'One room leads to the next',
                    'film'    => [
                        'poster' => 'club/house-enfilade',
                        'ratio'  => '16/9',
                        'alt'    => 'Two open doors either side of a white glazed stove portal, a further room visible through the right-hand one',
                        'source' => 'photo',
                    ],
                    'caption' => 'The enfilade',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'It is a private house before it is anything else, and the people in it belong to it.',
                    'body'  => [
                        'Not every room is open at once. The house is being brought back one at '
                        . 'a time, in the order the building allows rather than the order a plan '
                        . 'would prefer, and a room opens when it is finished and not before.',
                    ],
                ],

                /*
                   SIX ROOMS, IN THE ORDER SOMEBODY ACTUALLY MOVES THROUGH
                   THEM: in at the hall, through the drawing room, into the
                   library, down to the table, and then the two rooms an
                   evening ends in.

                   FOUR OF THE SIX ARE THIS HOUSE, PHOTOGRAPHED. The hall is
                   the fourth, at night, through a still — and it is the one
                   station with a film on it, because the hall is where the
                   fire is and a fire is the one thing on this page that
                   cannot be photographed still. Two are visualisations and say
                   so: there is no library in the supplied photography and no
                   laid table, and inventing either would have been the first
                   dishonest thing on the page.

                   EVERY STATION CARRIES A FOCUS. The stage is the viewport, so
                   a 16:9 frame in a 390x844 window is cropped to about a third
                   of its width — and the middle third of a room is very often
                   the wall nothing is happening on. Each value below was
                   chosen by looking at the portrait result. See film-walk.php.
                */
                [
                    'type'     => 'film-walk',
                    'id'       => 'rooms',
                    'index'    => '03',
                    'eyebrow'  => 'The rooms',
                    'title'    => 'Opened one at a time.',
                    'stations' => [
                        [
                            'label'  => 'The hall',
                            'note'   => 'Marble underfoot, walnut to shoulder height, and the staircase standing in the mirror over the chimneypiece.',
                            'alt'    => 'The hall at night, a fire lit in the marble chimneypiece and the staircase reflected in the mirror above it',
                            'ratio'  => '16/9',
                            'widths' => [768, 1152],
                            'source' => 'generated',
                            'film'   => [
                                'name'   => 'club-hall',
                                'poster' => 'club/club-hall',
                            ],
                        ],
                        [
                            'name'   => 'club/room-drawing',
                            'focus'  => '62% 50%',
                            'label'  => 'The drawing room',
                            'note'   => 'A settee, four chairs and a door left open onto the landing.',
                            'alt'    => 'A drawing room with a gilt-framed settee and armchairs under a lit chandelier, a glazed door standing open',
                            'ratio'  => '16/9',
                            'widths' => [768, 1152],
                            'source' => 'photo',
                        ],
                        [
                            'name'   => 'club/room-library',
                            'label'  => 'The library',
                            'note'   => 'Shelves to the ceiling on three walls, and the fourth given to the fire.',
                            'alt'    => 'A library lined to the ceiling with books, a fire lit under a portrait, leather chairs drawn up to it',
                            'ratio'  => '16/9',
                            'widths' => [768, 1152],
                            'source' => 'render',
                        ],
                        [
                            'name'   => 'club/room-dining',
                            'focus'  => '45% 50%',
                            'label'  => 'The private dining room',
                            'note'   => 'One table the length of the room, and the door shut behind it.',
                            'alt'    => 'A long table laid for a private dinner in a dark panelled room, a fire at the far end',
                            'ratio'  => '16/9',
                            'widths' => [768, 1152],
                            'source' => 'render',
                        ],
                        [
                            'name'   => 'club/room-lounge',
                            'focus'  => '40% 50%',
                            'label'  => 'The window room',
                            'note'   => 'A banquette under the bay, and the park on the other side of the glass.',
                            'alt'    => 'A room with a bay window, fitted timber banquette seating beneath it and an oval table on the parquet',
                            'ratio'  => '16/9',
                            'widths' => [768, 1152],
                            'source' => 'photo',
                        ],
                        [
                            'name'   => 'club/room-fire',
                            'focus'  => '45% 50%',
                            'label'  => 'The stove room',
                            'note'   => 'One of the historical tiled stoves, and the room built around it.',
                            'alt'    => 'A white tiled corner stove with a moulded crown, between two dark timber doors',
                            'ratio'  => '16/9',
                            'widths' => [768, 1152],
                            'source' => 'photo',
                        ],
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT THREE — the details, at the darkest ground on the page.
        //
        // A LATERAL TRACK RATHER THAN A SECOND DISSOLVE. The walk above is a
        // camera moving through the house; this is the same camera held at one
        // distance and slid sideways along a wall. Two dissolves in a row read
        // as one section that has lost its way. See film-detail.php.
        //
        // All six are crops of the supplied photography and none of them is a
        // whole room: the walk shows the room, this shows the thing in it.
        // ===================================================================

        [
            'tone'   => 'interior',
            'blocks' => [
                [
                    'type'    => 'film-detail',
                    'id'      => 'detail',
                    'index'   => '04',
                    'eyebrow' => 'Detail',
                    'title'   => 'What the house was made with.',
                    'note'    => 'Six things you only notice once you have stopped walking.',
                    'frames'  => [
                        [
                            'name'    => 'club/detail-chimney',
                            'alt'     => 'A white marble chimneypiece with a mirror above it, the staircase reflected in the glass',
                            'caption' => 'The chimneypiece',
                            'source'  => 'photo',
                        ],
                        [
                            'name'    => 'club/detail-ceiling',
                            'alt'     => 'A moulded plaster ceiling and the brass chandelier hanging from its rose',
                            'caption' => 'The ceiling',
                            'source'  => 'photo',
                        ],
                        [
                            'name'    => 'club/detail-carving',
                            'alt'     => 'The carved apron of a timber oriel bay under a coffered ceiling',
                            'caption' => 'Carved oak',
                            'source'  => 'photo',
                        ],
                        [
                            'name'    => 'club/detail-portal',
                            'alt'     => 'The fluted pilasters and carved crown of a white glazed stove portal',
                            'caption' => 'A stove portal',
                            'source'  => 'photo',
                        ],
                        [
                            'name'    => 'club/detail-glass',
                            'alt'     => 'The glazed doors of the hall and the leaded transom above them',
                            'caption' => 'Leaded glass',
                            'source'  => 'photo',
                        ],
                        [
                            'name'    => 'club/detail-stair',
                            'alt'     => 'The staircase seen from above: turned balusters, winder treads and a tall leaded window',
                            'caption' => 'The stair',
                            'source'  => 'photo',
                        ],
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT FOUR — the table. Back to the seal's green, and the one place
        // on the page where the copy is allowed to run to two paragraphs.
        //
        // NO MENU, NO CHEF, NO CUISINE AND NO HOURS. All four are on the
        // forbidden list at the top of this file and all four are what a
        // dining section normally consists of, so this one is about the table
        // rather than about the food on it. "What is on the table follows the
        // season and the people around it" is the home page's own line
        // (chapter 04) and it is the furthest this site goes towards
        // describing a meal.
        // ===================================================================

        [
            'tone'   => 'park',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'variant' => 'full',
                    'id'      => 'dining',
                    'film'    => [
                        'name'   => 'club-dining',
                        'poster' => 'club/club-dining',
                        'ratio'  => '16/9',
                        'alt'    => 'A dining salon under a crystal chandelier, round tables laid in white linen, candles alight',
                        'source' => 'generated',
                    ],
                    'overlay' => [
                        'index'   => '05',
                        'eyebrow' => 'Dining & gatherings',
                        'title'   => 'A table that runs long',
                    ],
                    'caption' => 'The dining salon',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'The house keeps a table, and it is the same table all day.',
                    'body'  => [
                        'Coffee in the morning, in whichever room has the light. Lunch that is '
                        . 'still sitting well after it has stopped being lunch. Dinner that '
                        . 'nobody is asked to give back.',

                        'What is on the table follows the season and the people around it, and '
                        . 'it is settled in conversation rather than printed.',
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT FIVE — after dark inside the house. Wine.
        //
        // THE MEMBERS' ROOM IS THE SHORTEST SCENE ON THE PAGE AND THAT IS THE
        // WHOLE OF IT. A name, a picture and two lines. A reader who wants to
        // know what is in the members' room has to be a member, which is the
        // point being made rather than an omission.
        //
        // It is an INSET band and not a full-bleed one, deliberately: the
        // scene before it is edge to edge, and a smaller frame standing in a
        // lot of dark reads as a door left ajar rather than as a wall.
        // ===================================================================

        [
            'tone'   => 'evening',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'variant' => 'inset',
                    'id'      => 'members',
                    'film'    => [
                        'name'   => 'club-members',
                        'poster' => 'club/club-members',
                        'ratio'  => '16/9',
                        'alt'    => 'A dark panelled room with buttoned leather armchairs drawn up to a lit hearth, portraits on the walls',
                        'source' => 'generated',
                    ],
                    'overlay' => [
                        'index'   => '06',
                        'eyebrow' => 'The Members\' Room',
                        'title'   => 'A quieter room.',
                    ],
                    // NOT "the members' room": the overlay above the frame
                    // already says that, and film-band appends the honesty mark
                    // to the caption, so repeating it would set the room's name
                    // twice and hang "Generated image" off the second one.
                    'caption' => 'The hearth',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'For members and their guests.',
                    'body'  => [
                        'Which door it is behind is something to ask about rather than to read.',
                    ],
                ],

                /*
                   THE HOUSE OF DIALOGUE, TRANSLATED AND NOT REPRODUCED.

                   The four labels are the CEO's own and they are kept; the
                   concept boards they came from are not, because a board is a
                   pitch and this is the house speaking. Each carries one line,
                   and the line says what the idea is doing in a private house
                   rather than what the club will do about it.

                   ALL FOUR PICTURES ARE VISUALISATIONS AND ALL FOUR SAY SO.
                   Three of them have people in them, which is the only reason
                   they can carry these words at all — and the only reason they
                   are not photographs.
                */
                [
                    'type'    => 'film-dialogue',
                    'id'      => 'dialogue',
                    'index'   => '07',
                    'eyebrow' => 'A house of dialogue',
                    'title'   => 'What the rooms are for.',
                    'items'   => [
                        [
                            'name'   => 'club/dialogue-capital',
                            'label'  => 'Capital & conscience',
                            'note'   => 'Two things usually discussed in separate rooms, and here in one.',
                            'alt'    => 'A tall dining room under a chandelier, round tables laid the length of it',
                            'source' => 'render',
                        ],
                        [
                            'name'   => 'club/dialogue-social',
                            'label'  => 'Social opportunity',
                            'note'   => 'A club is a set of introductions that happens to have a building around it.',
                            'alt'    => 'A lit terrace at dusk, seating arranged in small groups, the house behind it',
                            'source' => 'render',
                        ],
                        [
                            'name'   => 'club/dialogue-diplomacy',
                            'label'  => 'Diplomacy',
                            'note'   => 'Nothing here is on the record. That is most of what a private house is for.',
                            'alt'    => 'People in evening dress standing in conversation across a chequered marble hall',
                            'source' => 'render',
                        ],
                        [
                            'name'   => 'club/dialogue-culture',
                            'label'  => 'Culture',
                            'note'   => 'Books, music and the people who make them. The house was built with somewhere to put them.',
                            'alt'    => 'A timber staircase hung with portraits, a lamp lit on the half-landing',
                            'source' => 'render',
                        ],
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT SIX — the people, and the way in. Near-black.
        //
        // THREE FRAMES AND NOT ONE FACE. A gloved hand on a car door, four
        // people at a distance with their backs half turned, and a bar with
        // one figure behind it. The brief for this scene asks for silhouettes,
        // small groups and hands, and against the register of the whole site —
        // discreet, quiet, not reported — that is also the only way a page can
        // show the people in a private house without pretending to have
        // photographed them.
        // ===================================================================

        [
            'tone'   => 'estate',
            'blocks' => [

                [
                    'type'    => 'film-chapter',
                    'id'      => 'people',
                    'index'   => '08',
                    'eyebrow' => 'The people',
                    'title'   => 'Quietly, and in small numbers.',
                    'body'    => [
                        'The house is private, which means that what happens in it is not '
                        . 'reported anywhere, including here.',

                        'What can be said is the shape of it: a small number of people, most of '
                        . 'whom know one another, and the guests they bring.',
                    ],
                ],

                /*
                   THREE PLATES ON TWO ROWS, AND THE ROWS DO NOT OVERLAP: 5 and
                   6 above with the air between them, 7 below and offset, so
                   the column the portrait stands in is empty underneath it.
                   The twelve columns are the Main Page's and so is the rule
                   that makes them work — within a row, spans and offsets must
                   not overlap or the grid drops the second plate onto a row of
                   its own and the composition becomes a column.
                */
                [
                    'type'    => 'film-plates',
                    'variant' => 'house',
                    'plates'  => [
                        [
                            'name'    => 'club/people-arrival',
                            'alt'     => 'A gloved hand on the open door of a dark car at night',
                            'caption' => 'Arriving',
                            'ratio'   => '4/5',
                            'widths'  => [640, 960, 1280],
                            'sizes'   => '(min-width: 1080px) 38vw, 92vw',
                            'span'    => 5,
                            'source'  => 'render',
                        ],
                        [
                            'name'    => 'club/people-room',
                            'alt'     => 'Four people in evening dress standing apart in a panelled room, none of them facing the camera',
                            'caption' => 'A small number of people',
                            'ratio'   => '3/2',
                            'widths'  => [640, 960, 1280],
                            'sizes'   => '(min-width: 1080px) 46vw, 92vw',
                            'span'    => 6,
                            'offset'  => 6,
                            'raise'   => true,
                            'source'  => 'render',
                        ],
                        [
                            'name'    => 'club/people-bar',
                            'alt'     => 'A long bar of dark timber, one figure behind it, bottles lit on the shelves',
                            'caption' => 'And whoever is behind the bar',
                            'ratio'   => '3/2',
                            'widths'  => [640, 960, 1280],
                            'sizes'   => '(min-width: 1080px) 54vw, 92vw',
                            'span'    => 7,
                            'offset'  => 4,
                            'source'  => 'render',
                        ],
                    ],
                ],

                /*
                   THE LAST SCREEN, AND IT IS THE LINE THIS PAGE HAS CARRIED
                   SINCE IT WAS WRITTEN. "The house, and the people in it" was
                   the closing call of the version this replaces and it is the
                   closing call of this one; what changed is that eight scenes
                   now stand behind it.

                   TWO WAYS ON, AND THE FIRST IS THE SITE'S SINGLE CONVERSION
                   PATH (ARCHITECTURE §3.3). The second is a private enquiry,
                   because a reader who is not ready to apply is not a reader
                   to be sent away.
                */
                [
                    'type'    => 'film-invitation',
                    'id'      => 'belonging',
                    'eyebrow' => 'Majori Manor',
                    'title'   => 'The house, and the people in it.',
                    'body'    => 'The house has not opened. Every application to join it is read individually.',
                    'seal'    => ['name' => 'brand/seal-gold', 'alt' => ''],
                    'actions' => [
                        ['page_id' => 'membership', 'label' => 'Apply for membership', 'variant' => 'primary'],
                        ['page_id' => 'contact',    'label' => 'Private enquiry',      'variant' => 'quiet'],
                    ],
                ],
            ],
        ],
    ],
];
