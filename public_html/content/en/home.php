<?php
/**
 * English content of the Main Page. Arrays only, no markup.
 *
 * THE MAIN PAGE IS ONE CONTINUOUS FILM, and it is cut from the material in
 * media_src/ and nothing else. Six of its moments move. Five of them are
 * Seedance 2.5 sequences made FROM the photographs that sit beside them, which
 * is why the poster of every band is that band's own first frame and the fade
 * between the two is invisible. Nothing was drawn, painted or invented to fill
 * a slot.
 *
 * THE HERO IS THE SIXTH AND IT IS DELIVERED, NOT DESCENDED. Its master arrives
 * finished as media_src/MOTION/HERO/main-hero.mp4 and is not a generation from
 * any still on disk, so the sentence above does not cover it: there is no
 * photograph beside the hero that it was made from. The poster rule is the
 * same all the same — home/hero-manor is that video's own frame 0 — and so is
 * the marking below, which stays 'render' because the master is a
 * visualisation of the estate and not a photograph of the house.
 *
 *     00  HERO          the estate at blue hour — the sequence, full screen
 *     01  ARRIVAL       the reception, and the crest on its wall
 *     02  OVERTURE      where heritage becomes a way of life
 *     03  THE WORLD     eight ways in, as an index
 *     04  DINING        the salon, the private room, the chef's room
 *     05  PRIVATE CLUB  the bar, the cigar house, the courts, the dome
 *     06  STAY          the suite, the guest house, the cottages
 *     07  THE HOUSE     the building as it actually stands, photographed,
 *                       and a coda: the century it came through, and the
 *                       restoration under way now
 *     08  INVITATION    an invitation to belong
 *
 * IT NEVER BRIGHTENS. The ground is near-black from the first screen to the
 * last and the only daylight on the page is in scene 07, where it is the
 * point: everything above 07 is a visualisation of what the estate is becoming
 * and 07 is the building it is being made from. Putting the real photographs
 * last, in daylight, after an hour of warm interiors, is the page's one hard
 * cut and it is deliberate.
 *
 * 'source' IS A CLAIM ABOUT THE PICTURE AND IT IS MADE HERE (ARCHITECTURE §11).
 * photo is real photography of this building; render is a visualisation of the
 * project, which the components label as one. The material divides cleanly:
 * media_src/estate, /interiors, /grand-staircase, /heritage-details and
 * /pavilion are photographs, and everything in /ESTATE_and_HOSPITALITY,
 * /RESTAURANT, /CIGAR_HOUSE, /PRIVATE_CLUB_ECOSYSTEM and /HOUSE_OF_DIALOGUE is
 * a visualisation. The five sequences inherit the marking of the still each was
 * made from, because a moving visualisation is still a visualisation, and the
 * hero — which inherits nothing, having no still behind it — is marked on the
 * same test applied directly to the master: it shows the estate as it is
 * becoming, so it is a render.
 *
 * NO SENTENCE ON THIS PAGE CARRIES A FACT THAT IS NOT SETTLED (§21) — and the
 * rule is the settling, not the silence. Nothing below says how the estate will
 * operate: no room count, no court count, no opening hour, no menu, no price,
 * no membership term. None of that is decided, so none of it is written.
 *
 * THE PAST IS DECIDED, AND IT IS NOW ON THE PAGE. The sixteenth century and the
 * von Fircks family, about 1910 and Wilhelm Bockslaff, the agrarian reform of
 * 1920, 2.4 hectares of park, 2024 and Ināra Caunīte: all of it is the record
 * the owner supplied, and all of it is already carried by /the-estate in nearly
 * these words. This page held no digit at all until it did, which read as
 * caution and was closer to an absence — a house of this age has a history, and
 * declining to say so is not the same as being careful with it.
 *
 * THIS PAGE OWNS ITS OWN CHROME. 'own_chrome' tells layout.php to leave the
 * site header and footer off and let the page render its own, because the film
 * needs a bar that can be transparent over its hero and a last screen that can
 * close it. What that chrome SAYS is the site's, not the film's: both the
 * navigation and the footer are built from routes.php and common.php, so the
 * Main Page names the same places, in the same order, in the same words as
 * every other page. Every other page is untouched.
 */

declare(strict_types=1);

return [

    'meta' => [
        'title'       => 'Majori Manor — private club & estate, Jūrmala',
        'description' => 'A historic manor house, private park and members\' club in Jūrmala, Latvia. '
                       . 'An estate kept private, and a company kept small.',
    ],

    // The page paints its own ground; this keeps the chrome tokens honest for
    // anything that still reads mood().
    'mood' => 'night',

    // See the note at the top of this file.
    'own_chrome' => true,

    // =======================================================================
    // The navigation
    //
    // THE LINKS ARE NOT LISTED HERE ANY MORE. The bar used to address the
    // scenes of this page, which meant the Main Page named six things no other
    // page named and the site had two different navigations depending on where
    // a reader stood. It now carries the site's own: partials/film-nav.php
    // derives it from routes.php through nav_pages(), takes MEMBERSHIP out of
    // it as the accent action through NAV_ACCENT, and reads every label from
    // t('nav.<page_id>') in common.php. A page is still a line in the routing
    // table and nothing else.
    //
    // The scenes below keep their ids — #overture, #dining, #club, #stay,
    // #wellness, #events are still anchors, still linkable, and still what the
    // page is built out of. Nothing in the bar points at them.
    //
    // What is left here is the wording of the sheet that opens below 900px,
    // because it belongs to this page's chrome rather than to the site's.
    // =======================================================================

    'nav' => [
        'open_label'  => 'Open the menu',
        'close_label' => 'Close the menu',
        'aria_label'  => 'Main',
    ],

    // =======================================================================
    // 00  HERO
    // =======================================================================

    'hero' => [
        'eyebrow'   => 'Jūrmala · Latvia',
        'title'     => 'Majori Manor',
        /*
           THE BRIEF FIXES THIS LINE AND IT IS NOW THE BRIEF'S. It read
           'Private Club & Estate', which is the same three words in the wrong
           order and one word short: the formula is PRIVATE ESTATE & MEMBERS'
           CLUB, the estate first and the club named as a members' one. It is
           the same string the footer has always carried through
           t('footer.tagline'), so the first screen and the last one now say
           the same thing.
        */
        'subtitle'  => 'Private Estate & Members\' Club',
        'statement' => 'An estate kept private, and a company kept small.',
        'cue'       => 'Enter',

        /*
           The seal is the supplied artwork and nothing stands in for it. Two
           marks exist as masters — the cream Logo-05 and the gold Logo-07 —
           and the cream one is what carries a near-black ground. See
           tools/photos/build_home_media.py for the export.
        */
        'seal' => ['name' => 'brand/seal-cream', 'alt' => 'Majori Manor'],

        'film' => [
            'name'   => 'hero-manor',
            'poster' => 'home/hero-manor',
            'ratio'  => '16/9',
            'alt'    => 'The manor at blue hour, its windows lit, seen across the cobbled forecourt',
            'source' => 'render',
        ],
    ],

    'sections' => [

        // ===================================================================
        // 01  ARRIVAL
        // ===================================================================

        [
            'type'    => 'film-band',
            'id'      => 'arrival',
            'variant' => 'inset',
            'index'   => '01',
            'eyebrow' => 'The arrival',
            'title'   => 'You are expected',
            'film'    => [
                'name'   => 'seq-arrival',
                'poster' => 'home/seq-arrival',
                'ratio'  => '16/9',
                'alt'    => 'The reception hall, panelled in dark wood, the house crest on the wall behind the desk',
                'source' => 'render',
            ],
            'caption' => 'Reception',
        ],

        // ===================================================================
        // 02  OVERTURE
        // ===================================================================

        [
            'type'    => 'film-chapter',
            'id'      => 'overture',
            'index'   => '02',
            'eyebrow' => 'The manor',
            'title'   => 'Where heritage becomes a way of life.',
            'body'    => [
                'The earliest records of these lands are from the sixteenth century, when '
                . 'they belonged to the von Fircks family of Kurzeme — who came for the '
                . 'summer, and left a steward to keep the place through the rest of the '
                . 'year.',

                'The house came first. Timber and stone, a staircase that has carried a '
                . 'hundred years of footsteps, rooms built for long evenings rather than '
                . 'short stays.',

                'It was built around 1910, to a design by Wilhelm Bockslaff, and it has '
                . 'stood in the same private park ever since — 2.4 hectares of it, keeping '
                . 'its old layout and its old trees, in the middle of a resort city. What '
                . 'they make between them is quiet, and a climate of its own.',

                'What has been added to it is not a hotel. It is a club — a dining room, '
                . 'a bar, a cigar house, courts among the pines, and rooms for the '
                . 'evenings that run long.',

                'One gate. One company. Nothing here is advertised; it is introduced.',
            ],
        ],

        [
            'type'    => 'film-plates',
            'variant' => 'overture',
            'plates'  => [
                [
                    'name'    => 'home/story-hall',
                    'ratio'   => '16/9',
                    'span'    => 12,
                    'sizes'   => '(min-width: 1080px) 76vw, 92vw',
                    'alt'     => 'The great hall on an evening, guests in black tie beneath the chandelier',
                    'source'  => 'render',
                    'caption' => 'The hall',
                ],
                [
                    'name'    => 'home/story-library',
                    'ratio'   => '4/5',
                    'span'    => 6,
                    'sizes'   => '(min-width: 1080px) 37vw, 92vw',
                    'alt'     => 'The library, its fire lit, a portrait above the chimneypiece',
                    'source'  => 'render',
                    'caption' => 'The library',
                ],
                [
                    'name'    => 'home/story-stair',
                    'ratio'   => '4/5',
                    'span'    => 6,
                    'offset'  => 6,
                    'sizes'   => '(min-width: 1080px) 37vw, 92vw',
                    'alt'     => 'The carved newel post of the main staircase, portraits climbing the wall beside it',
                    'source'  => 'render',
                    'caption' => 'The stair',
                ],
            ],
        ],

        // ===================================================================
        // 03  THE WORLD OF MAJORI MANOR
        // ===================================================================

        [
            'type'    => 'film-world',
            'id'      => 'world',
            'index'   => '03',
            'eyebrow' => 'The world of Majori Manor',
            'title'   => 'Eight ways in.',

            /*
               EIGHT WAYS IN, AND THEY NOW LEAD OUT OF THE PAGE. Each tile
               carries a 'page_id' and components/film-world.php resolves it
               through url(), so the addresses come from routes.php and none of
               them is written down here. They used to be anchors into this
               page's own scenes, which made an index of eight ways in that led
               back to where the reader already stood.

               THREE OF THE EIGHT HAD NO OBVIOUS PAGE and were settled by
               reading the pages rather than the labels:

                 Dining      → The Club. Its section 'A table that runs long'
                               is the estate's dining copy — coffee, lunch,
                               private dinners, and a menu 'settled in
                               conversation rather than printed', which is this
                               tile's note almost word for word.
                 Cigar House → After Dark, whose second section is titled
                               Cigar & Whisky. Nothing else on the site
                               mentions a humidor.
                 Wellness    → Padel, and this is the weak one of the three.
                               No page on the site describes a gym, a sauna or
                               water; padel is the only page about the body at
                               all, and the only one that documents changing
                               and showering. The tile promises a room the site
                               does not yet have — worth raising with the
                               owner rather than quietly relabelling.

               So eight tiles reach six pages: Private Club and Dining both
               land on The Club, Padel and Wellness both on Padel. The estate
               has more rooms than the site has pages, and naming the room is
               the tile's job whether or not the room has a page of its own.
            */
            'items'   => [
                [
                    'label'   => 'The Manor',
                    'note'    => 'The house itself, and the hall you arrive in.',
                    'page_id' => 'estate',
                    'name'    => 'home/world-manor',
                    'alt'     => 'The entrance hall, chequered marble underfoot, flowers on a round table',
                    'source'  => 'render',
                ],
                [
                    'label'   => 'Private Club',
                    'note'    => 'Members\' rooms, behind the same door as always.',
                    'page_id' => 'club',
                    'name'    => 'home/world-club',
                    'alt'     => 'Members standing at the panelled club bar beneath a chandelier',
                    'source'  => 'render',
                ],
                [
                    'label'   => 'Dining',
                    'note'    => 'Three rooms, one kitchen, no published menu.',
                    'page_id' => 'club',
                    'name'    => 'home/world-dining',
                    'alt'     => 'The grand dining room laid for service under its chandeliers',
                    'source'  => 'render',
                ],
                [
                    'label'   => 'Cigar House',
                    'note'    => 'A humidor, a hearth, and the discretion both ask for.',
                    'page_id' => 'after_dark',
                    'name'    => 'home/world-cigar',
                    'alt'     => 'The cigar room, leather chairs drawn up to a low table',
                    'source'  => 'render',
                ],
                [
                    'label'   => 'Padel',
                    'note'    => 'Courts under floodlight, and the pines behind them.',
                    'page_id' => 'padel',
                    'name'    => 'home/world-padel',
                    'alt'     => 'A padel racquet carrying the club mark, mounted at the courts',
                    'source'  => 'render',
                ],
                [
                    'label'   => 'Wellness',
                    'note'    => 'Iron, water, and the hour before dinner.',
                    'page_id' => 'padel',
                    'name'    => 'home/world-wellness',
                    'alt'     => 'The gym, lit low along a glazed wall',
                    'source'  => 'render',
                ],
                [
                    'label'   => 'Suites',
                    'note'    => 'Rooms above the rooms you spent the evening in.',
                    'page_id' => 'residences',
                    'name'    => 'home/world-suites',
                    'alt'     => 'The main manor suite, its bedside lamps lit',
                    'source'  => 'render',
                ],
                [
                    'label'   => 'Private Events',
                    'note'    => 'The dome in the park, and the hall when the hall is yours.',
                    'page_id' => 'events',
                    'name'    => 'home/world-events',
                    'alt'     => 'A dinner under the lit dome in the park',
                    'source'  => 'render',
                ],
            ],
        ],

        // ===================================================================
        // 04  DINING
        // ===================================================================

        [
            'type'    => 'film-band',
            'id'      => 'dining',
            'variant' => 'full',
            'film'    => [
                'name'   => 'seq-dining',
                'poster' => 'home/seq-dining',
                'ratio'  => '16/9',
                'alt'    => 'The dining salon by candlelight, its chandelier lit and a fire in the chimneypiece',
                'source' => 'render',
            ],
            'overlay' => [
                'index'   => '04',
                'eyebrow' => 'The table',
                'title'   => 'Dining',
            ],
        ],

        [
            'type'  => 'film-chapter',
            'align' => 'split',
            'lede'  => 'Candlelight, and a kitchen that answers to the room.',
            'body'  => [
                'The salon seats the house. The private room seats a table that would '
                . 'rather not be overheard. The chef\'s room seats whoever the chef is '
                . 'cooking for that evening.',

                'There is no published menu, and there is not going to be one.',
            ],
        ],

        [
            'type'    => 'film-plates',
            'variant' => 'act',
            'plates'  => [
                [
                    'name'    => 'home/dining-salon',
                    'ratio'   => '4/5',
                    'span'    => 5,
                    'sizes'   => '(min-width: 1080px) 31vw, 92vw',
                    'alt'     => 'The dining salon, tables laid in white linen beneath the chandelier',
                    'source'  => 'render',
                    'caption' => 'The salon',
                ],
                [
                    'name'    => 'home/dining-private',
                    'ratio'   => '4/5',
                    'span'    => 4,
                    'offset'  => 7,
                    'raise'   => true,
                    'sizes'   => '(min-width: 1080px) 25vw, 92vw',
                    'alt'     => 'The private dining room, one long table set for a closed party',
                    'source'  => 'render',
                    'caption' => 'The private room',
                ],
                [
                    'name'    => 'home/dining-chefs',
                    'ratio'   => '3/2',
                    'span'    => 7,
                    'offset'  => 5,
                    'sizes'   => '(min-width: 1080px) 43vw, 92vw',
                    'alt'     => 'The chef\'s room, two tables before a lit fire and a wall of pictures',
                    'source'  => 'render',
                    'caption' => 'The chef\'s room',
                ],
            ],
        ],

        // ===================================================================
        // 05  THE PRIVATE CLUB
        // ===================================================================

        [
            'type'    => 'film-band',
            'id'      => 'club',
            'variant' => 'full',
            'film'    => [
                'name'   => 'seq-club',
                'poster' => 'home/seq-club',
                'ratio'  => '16/9',
                'alt'    => 'The cigar lounge, firelight across leather and dark panelling',
                'source' => 'render',
            ],
            'overlay' => [
                'index'   => '05',
                'eyebrow' => 'The club',
                'title'   => 'The Private Club',
            ],
        ],

        [
            'type'  => 'film-chapter',
            'align' => 'split',
            'lede'  => 'The heart of it, and the part that is not open.',
            'body'  => [
                'The bar keeps the hours the room keeps. The cigar house has a humidor '
                . 'and a hearth and asks nothing of anyone. The whisky lounge is where '
                . 'the evening goes when it is not ready to end.',

                'Outside, the courts stay lit long after the light has gone. Everything '
                . 'is behind one gate, and the gate is the whole idea.',
            ],
        ],

        [
            'type'    => 'film-plates',
            'variant' => 'act',
            'plates'  => [
                [
                    'name'    => 'home/club-bar',
                    'ratio'   => '3/2',
                    'span'    => 7,
                    'sizes'   => '(min-width: 1080px) 43vw, 92vw',
                    'alt'     => 'The manor bar, its back wall stacked with bottles under low lamps',
                    'source'  => 'render',
                    'caption' => 'Manor Bar',
                ],
                [
                    'name'    => 'home/club-arrival',
                    'ratio'   => '4/5',
                    'span'    => 4,
                    'offset'  => 8,
                    'raise'   => true,
                    'sizes'   => '(min-width: 1080px) 25vw, 92vw',
                    'alt'     => 'A gloved hand at the door of a car drawn up under the portico',
                    'source'  => 'render',
                    'caption' => 'Arrival',
                ],
                [
                    'id'      => 'cigar',
                    'name'    => 'home/club-humidor',
                    'ratio'   => '21/9',
                    'span'    => 12,
                    'sizes'   => '(min-width: 1080px) 76vw, 92vw',
                    'alt'     => 'The humidor, its drawers open along the wall of the cigar house',
                    'source'  => 'render',
                    'caption' => 'Cigar House · the humidor',
                ],
                [
                    'name'    => 'home/club-whisky',
                    'ratio'   => '3/2',
                    'span'    => 6,
                    'sizes'   => '(min-width: 1080px) 37vw, 92vw',
                    'alt'     => 'The whisky lounge, chesterfields drawn up to a wall of bottles',
                    'source'  => 'render',
                    'caption' => 'Whisky Lounge',
                ],
                [
                    'id'      => 'wellness',
                    'name'    => 'home/world-wellness',
                    'ratio'   => '4/5',
                    'span'    => 6,
                    'offset'  => 6,
                    'sizes'   => '(min-width: 1080px) 37vw, 92vw',
                    'alt'     => 'The gym, lit low along a glazed wall',
                    'source'  => 'render',
                    'caption' => 'Wellness',
                ],
            ],
        ],

        // -- the courts, as their own screen --------------------------------

        [
            'type'    => 'film-band',
            'id'      => 'padel',
            'variant' => 'wide',
            'film'    => [
                'name'   => 'seq-padel',
                'poster' => 'home/seq-padel',
                'ratio'  => '21/9',
                'alt'    => 'The padel courts at night, floodlit behind a clipped hedge, a rally in progress',
                'source' => 'render',
            ],
            'caption' => 'Padel Club',
        ],

        [
            'type'    => 'film-plates',
            'variant' => 'act',
            'plates'  => [
                [
                    'id'      => 'events',
                    'name'    => 'home/world-events',
                    'ratio'   => '4/5',
                    'span'    => 5,
                    'sizes'   => '(min-width: 1080px) 31vw, 92vw',
                    'alt'     => 'A dinner under the lit dome in the park',
                    'source'  => 'render',
                    'caption' => 'Private Events · the dome',
                ],
                [
                    'name'    => 'home/club-terrace',
                    'ratio'   => '3/2',
                    'span'    => 6,
                    'offset'  => 6,
                    'raise'   => true,
                    'sizes'   => '(min-width: 1080px) 37vw, 92vw',
                    'alt'     => 'The terrace of the cigar house after dark, heaters lit between the sofas',
                    'source'  => 'render',
                    'caption' => 'The terrace',
                ],
            ],
        ],

        // ===================================================================
        // 06  STAY
        // ===================================================================

        [
            'type'    => 'film-band',
            'id'      => 'stay',
            'variant' => 'full',
            'film'    => [
                'name'   => 'seq-suite',
                'poster' => 'home/seq-suite',
                'ratio'  => '16/9',
                'alt'    => 'The main manor suite by lamplight, the curtains stirring at the window',
                'source' => 'render',
            ],
            'overlay' => [
                'index'   => '06',
                'eyebrow' => 'The rooms',
                'title'   => 'Stay',
            ],
        ],

        [
            'type'  => 'film-chapter',
            'align' => 'split',
            'lede'  => 'A short walk from the last conversation of the evening.',
            'body'  => [
                'The main suite is in the house. The guest suites are in the second '
                . 'building, across the cobbles. The cottages are in the trees.',

                'All three are a walk, not a drive.',
            ],
        ],

        [
            'type'    => 'film-plates',
            'variant' => 'act',
            'plates'  => [
                [
                    'name'    => 'home/stay-guest-house',
                    'ratio'   => '4/5',
                    'span'    => 5,
                    'sizes'   => '(min-width: 1080px) 31vw, 92vw',
                    'alt'     => 'The guest house at dusk, its windows lit above the cobbled forecourt',
                    'source'  => 'render',
                    'caption' => 'Guest suites',
                ],
                [
                    'name'    => 'home/stay-cottages',
                    'ratio'   => '3/2',
                    'span'    => 6,
                    'offset'  => 6,
                    'raise'   => true,
                    'sizes'   => '(min-width: 1080px) 37vw, 92vw',
                    'alt'     => 'The cottages among the trees, their paths lit for the evening',
                    'source'  => 'render',
                    'caption' => 'The cottages',
                ],
            ],
        ],

        // ===================================================================
        // 07  THE HOUSE AS IT STANDS
        //
        // The page's one hard cut, and the only daylight on it. See the note
        // at the top of this file.
        // ===================================================================

        [
            'type'    => 'film-chapter',
            'id'      => 'house',
            'index'   => '07',
            /*
               THE EYEBROW AND THE FIRST LINE BOTH NAMED THE DISTINCTION IN THE
               WORD THAT HAS BEEN TAKEN OFF THE SITE — 'Photographed, not
               visualised' over a paragraph beginning 'Everything above this
               line is a visualisation'. Both are rewritten rather than cut: the
               hard cut into daylight is the page's one structural gesture and
               it needs a line that says what the reader has just crossed. What
               is gone is the vocabulary, not the meaning — 'as it is becoming'
               against 'the building it is being made from' draws the same
               line in the page's own words.
            */
            'eyebrow' => 'Photographed',
            'title'   => 'The house as it stands.',
            'body'    => [
                'Everything above this line is Majori Manor as it is becoming. '
                . 'Below it is the building it is being made from: the '
                . 'staircase, the hall, the stove and the piano.',

                'The staircases are wooden, with curved balusters. The decorative columns '
                . 'were made by hand and the marble ones are original to the house. There '
                . 'are oak parquet floors and marble ones, authentic fireplace portals, '
                . 'several of the historical tiled stoves, and the artistic metal fittings '
                . 'still on the doors. None of that is reconstruction. It is what was '
                . 'still here.',

                'It has been standing a great deal longer than any of this, and it is '
                . 'the reason for all of it.',
            ],
        ],

        [
            'type'    => 'film-plates',
            'variant' => 'house',
            /*
               THE FAÇADE PLATE WAS TAKEN OUT OF THIS SECTION on the owner's
               instruction. The three interiors are what carries the chapter
               now, and the paragraph above was cut to match: it named the
               façade and no longer does.

               ONE THING TO PUT TO THE OWNER BEFORE IT COMES BACK. The plate
               was cropped from media_src/estate/estate_1.jpg — a white,
               black-roofed house with a name plate legible on its gate pier.
               estate_2…4, in the same folder, are cream-walled under old slate
               with a columned portico. To the eye they are not the same
               building. content/en/estate.php records the opposite — that the
               owner confirmed estate_1's provenance, name plate included — and
               that note is evidence, not a mistake to be overruled from here.
               Two readings, one of them documented; the question is worth
               asking again rather than being settled in a comment.

               Nothing on this page turns on the answer any more, which is the
               comfortable position to be in. /the-estate still leads with the
               same frame and does turn on it.

               THE LAYOUT IS A HANGING PAIR AND A CLOSING PLATE rather than an
               even row of three, because an even row of three is a contact
               sheet, and this section is the one place on the page where the
               photographs have to look like they were chosen.
            */
            'plates'  => [
                [
                    'name'    => 'home/house-stair',
                    'ratio'   => '4/5',
                    'span'    => 6,
                    'sizes'   => '(min-width: 1080px) 37vw, 92vw',
                    'alt'     => 'The turn of the main staircase, its stained glass window above',
                    'source'  => 'photo',
                    'caption' => 'The staircase',
                ],
                [
                    'name'    => 'home/house-hall',
                    'ratio'   => '4/5',
                    'span'    => 5,
                    'offset'  => 7,
                    'raise'   => true,
                    'sizes'   => '(min-width: 1080px) 31vw, 92vw',
                    'alt'     => 'The hall, its chandelier over a chequered marble floor',
                    'source'  => 'photo',
                    'caption' => 'The hall',
                ],
                [
                    'name'    => 'home/house-piano',
                    'ratio'   => '4/5',
                    'span'    => 6,
                    'offset'  => 3,
                    'sizes'   => '(min-width: 1080px) 37vw, 92vw',
                    'alt'     => 'The tiled stove and the grand piano in the corner room',
                    'source'  => 'photo',
                    'caption' => 'The stove, and the piano',
                ],
            ],
        ],

        /*
           THE CODA TO 07, AND DELIBERATELY NOT A SCENE 08.

           It carries no index and no display line, which is what 'split' is
           for: the chapter above has already named itself and this is the rest
           of the same thought — what the century did to the house, and what is
           being done about it now. Giving it a number would have renumbered
           the invitation, and it is not a new place. It is the last thing said
           about the old one, and it puts the reader in front of the seal
           already knowing what they would be belonging to.
        */
        [
            'type'  => 'film-chapter',
            'align' => 'split',
            'lede'  => 'The twentieth century used the house, and did not take it apart.',
            'body'  => [
                'After the agrarian reform of 1920 the manor became state property, and it '
                . 'spent the rest of the century in a succession of public functions. '
                . 'Robust construction and good materials are the dull reason the '
                . 'architecture came through that largely intact — which is not the usual '
                . 'outcome, and it is why there is something here to restore rather than '
                . 'to reproduce.',

                'In 2024 it returned to private ownership and a comprehensive restoration '
                . 'began, under the architect Ināra Caunīte. It is phased, it is under way '
                . 'now, and it is a repair rather than a rebuild.',

                'It is one of the last estate complexes of this scale left inside the '
                . 'modern boundaries of Jūrmala. That is the plain reason for the care.',
            ],
        ],

        // ===================================================================
        // 08  INVITATION
        // ===================================================================

        [
            'type'      => 'film-invitation',
            'id'        => 'invitation',
            'index'     => '08',
            'eyebrow'   => 'Membership',
            'title'     => 'An invitation to belong.',
            'body'      => 'Membership is by introduction. Write and say who introduced you — '
                         . 'or, if no one did, say why you are writing.',
            'seal'      => ['name' => 'brand/seal-gold', 'alt' => ''],
            'actions'   => [
                ['page_id' => 'membership', 'label' => 'Request membership', 'variant' => 'primary'],
                ['page_id' => 'contact',    'label' => 'Private enquiry',    'variant' => 'quiet'],
            ],
        ],
    ],

    // =======================================================================
    // The footer this page renders for itself
    // =======================================================================

    /*
       THE FOOTER NOTE IS GONE RATHER THAN REWORDED. It read 'Interiors and
       grounds shown as visualisations of the project. Photographs of the house
       are marked as such.' — two sentences, both of them about the labelling
       that has been taken off the site, and the second one a claim that the
       marks are there to be found. Rewording it would have meant keeping a
       note whose entire subject no longer exists; leaving it would have meant
       pointing a reader at marks that are not on the page. film-footer.php
       prints the note only when there is one, so dropping the key is the whole
       edit and the footer closes on the place line.
    */
    'footer' => [
        'place' => 'Majori Manor · Jūrmala · Latvia',
        'links' => ['membership', 'contact', 'privacy', 'terms'],
    ],

    'jsonld' => [
        '@type'       => 'LandmarksOrHistoricalBuildings',
        'name'        => 'Majori Manor',
        'description' => 'A historic manor house, private park and members\' club in Jūrmala, Latvia.',
        'address'     => [
            '@type'           => 'PostalAddress',
            'addressLocality' => 'Jūrmala',
            'addressCountry'  => 'LV',
        ],
    ],
];
