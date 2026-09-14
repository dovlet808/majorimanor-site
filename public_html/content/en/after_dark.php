<?php
/**
 * English content of After Dark. Arrays only, no markup.
 *
 * THE SEVENTH PAGE CUT FROM THE FILM, AND THE ONLY ONE WHOSE SUBJECT IS THE
 * HOUR ITSELF. The Main Page holds blue hour, THE ESTATE an afternoon, THE CLUB
 * and EVENTS an evening, PADEL the hour after sunset, RESIDENCES a whole day.
 * This one is what happens when all of those have finished, and it is built as
 * one continuous descent: the reader arrives on a lawn with the last of the
 * light in the sky and leaves on the darkest ground the site has.
 *
 * IT IS STILL THE SHORTEST PAGE ON THE SITE AND THAT IS THE INSTRUCTION RATHER
 * THAN A CONSEQUENCE. The page this replaces ran to about 260 words across six
 * blocks; this one runs to about 300 across ten screens, which is a third of
 * what THE ESTATE says and rather less per screen than anything else. The brief
 * asks for minimum text on the grounds that atmosphere is the one thing that
 * gets worse the more of it is written down, and the rebuild kept that rule
 * while adding six screens.
 *
 * FIVE SENTENCES SURVIVED WORD FOR WORD, because they are the approved ones:
 * the title of the page, "In the evening the estate does not close so much as
 * turn inward", "The light comes down and the colour goes deeper with it",
 * "There is nothing to announce about it, which is most of the recommendation",
 * and "Some evenings are not events." The last of those has been promoted: on
 * the page this replaces it was a pull quote near the end; here it is the title
 * of a scene, which is where it was always trying to get to.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * THE PAGE IS ONE EVENING AND THE ORDER IS THE ARGUMENT:
 *
 *     00  the night begins  the manor from the lawn, after sunset
 *     01  the salon         the first room, and how little is going on in it
 *     02  whisky & cigar    the room nobody is hurrying you out of
 *     03  what it is made   six close frames, panned — materials, not stock
 *     --  private gaming    GATED. See the long note below.
 *     04  the quieter side  one photograph with nothing written on it
 *     05  the table         dinner, at the hour dinner stops being a booking
 *     06  the conversation  "Some evenings are not events."
 *     07  the house         outside again, and the park with the lamps on
 *     08  the estate        four places, four pages, one line each
 *         the invitation    the seal, and two ways to write
 *
 * THE PAGE MOVES THROUGH SIX GROUNDS AND EVERY ONE IS DARKER THAN THE LAST.
 * Wine for the salon; mahogany for the smoking room and the detail track;
 * the park's green for the gated scene; the pause ground for the silence;
 * wine again for the table and the conversation; near-black for the walk
 * outside; and MIDNIGHT — the one ground this page adds, declared in
 * after-dark.css §1 and nowhere else — for the last two screens. Five of the
 * six are estate.css §1's and are used unchanged. The sixth is new, it is the
 * darkest ground on the site, and the argument for adding it is in that file:
 * this is the only page whose last screen has to be further down than its
 * first, and --mm-estate is the Main Page's floor rather than this page's.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * THE PRIVATE GAMING SECTION IS HERE AND IT IS STILL SWITCHED OFF.
 *
 * It is the deferred module of ARCHITECTURE §14.2, built so that the layout can
 * be reviewed, and it is behind ENABLE_GAMING in private/config.php, which is
 * false — false locally, false in the sample, false in production. The gate is
 * the spread below rather than a template or a rule in the stylesheet, so with
 * the flag off the act never enters this array: there is no markup, no comment,
 * no empty container and nothing whatever in view-source. The section does not
 * exist on the page, as against existing and not being shown, and the
 * difference between those two is the whole of why the gate is here.
 *
 * THE GATE IS NOW A WHOLE ACT RATHER THAN TWO BLOCKS, and that is the one
 * structural thing the rebuild changed about it. On the page this replaces the
 * two blocks sat in a flat list of sections and the flag simply removed them.
 * Here the page is acts, and an act is a ground: putting the gated scene inside
 * the run of scenes that stand on wine would mean the flag changed which
 * colours the page passes through. So it is an act of its own, on the park's
 * green — a colour nothing else on this page uses — and with the flag off the
 * page simply goes mahogany to the pause ground, which is a descent either way.
 * Nothing above it or below it moves.
 *
 * IT IS THE ONE SCENE ON THE PAGE WITHOUT A NUMBER, and that is the same
 * decision seen from the other side. Every other scene here carries an index —
 * 01 through 08 — and those are literal strings in this file. A gated scene
 * with a number in that run would either leave a hole in the sequence when the
 * flag is off or renumber six scenes when it is on. It has no index, which is
 * also the honest treatment: it is the one room on this page that may turn out
 * not to exist.
 *
 * WHAT THE SECTION MAY NEVER ACQUIRE, and this is not a matter of taste:
 *
 *     NO GAME IS NAMED. Not one, not as a list, not in passing.
 *     NO COUNT OF TABLES, NO STAKES, NO ODDS, NO JACKPOT, NO BONUS, NO SLOTS.
 *     NO HOURS, NO NIGHTS, NO SEASON, NO OPERATOR, NO LICENCE NUMBER.
 *     NO MEMBERSHIP REQUIREMENT — that is a term, and no term is settled.
 *     NOTHING OF VEGAS: no neon, no floor, no bank of machines, no crowd.
 *     NOTHING THAT READS AS AN INVITATION TO PLAY.
 *
 * The copy describes a room in a house that is being restored, and it stops
 * there. THE PICTURE DOES THE SAME AND IT WAS CHOSEN FOR THAT REASON: the frame
 * is CIGAR_HOUSE/vip_room.png at 3:2, which is a small panelled room with four
 * leather armchairs, a low table, portraits and a chandelier in it — and no
 * gaming table, no felt, no cards, no chips and nobody playing anything. It is
 * the only picture in the library that is a private room without being a
 * picture of an activity. A material is true of a room. An activity is a
 * promise about a business that does not exist yet, and this one would be a
 * regulated promise.
 *
 * THE LICENSING LINE UNDER IT IS THE OWNER'S WORDING AND IS FIXED. It is set as
 * fine print because that is what it is — a statement of fact under a section,
 * in the treatment the legal pages give a statement of fact — and not because
 * anybody wants it out of the way. It is not to be reworded, softened,
 * shortened, or moved to a page of its own.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * NO FACTS EXIST FOR THIS PAGE. No hours, no nights of the week, no seasons,
 * no dates, no dress, no rules, no prices, no capacities, no staff. There is no
 * film-ledger here for the same reason there is none on /the-club and none on
 * /residences: there are no five settled facts to put in one (ARCHITECTURE
 * §21). And two lists that would be the obvious thing to write are the specific
 * danger on this page and remain forbidden:
 *
 *     NO DRINKS LIST, NO BRANDS, NO BOTTLES, NO VINTAGES, NO AGES. A named
 *       whisky is a promise that a particular bottle is on a particular shelf
 *       in a room that is not finished, and it is the easiest false statement
 *       on this site to make by accident. THAT RULE NOW BINDS THE PICTURES AS
 *       WELL AS THE WORDS, which is new: one frame in the library has two
 *       labelled bottles standing in the middle of it with the expression and
 *       the age legible at the rung this page ships, and the crop was moved off
 *       them rather than the frame dropped. See detail-whisky in
 *       tools/photos/build_after_dark_media.py.
 *     NO CIGARS BY NAME, NO HUMIDOR STOCK, NO COUNTRY, NO SUPPLIER.
 *
 * So scene 02 describes a room and not its contents, and scene 03 — six close
 * frames of the things in it — is captioned in nouns that are true of any
 * evening in any century: a drawer, a counter, a glass, a chair, a cabinet, a
 * staircase. Materials and light are true of a room; a list is true of a stock.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * 'source' IS A CLAIM ABOUT THE PICTURE AND IT IS MADE HERE (ARCHITECTURE §11).
 * This page carries three of the four values and NOT 'mood', which is the
 * biggest single change from the page it replaces.
 *
 *   photo      two frames of the real house: the first-floor landing, and the
 *              garden front that the hero was generated from.
 *   render     the project's own visualisations — the whisky lounge, the cigar
 *              lounge, the manor bar, the humidor, the private room, the great
 *              hall, the library, the stair, the dining room, the dome.
 *   generated  the five Seedance 2.0 sequences and their posters. One of them
 *              descends through a GPT Image 2 still that changed the hour of a
 *              photograph of this house and nothing else.
 *
 * THE PAGE THIS REPLACES DECLARED ALL THREE OF ITS PICTURES 'mood', and its own
 * header argued that this was permanent. THAT RULE IS KEPT AND THE VALUE IS
 * GONE, which is not a contradiction — it is RESIDENCES' own finding applied
 * here. 'mood' is the licence to stand a reference image in a slot and say
 * nothing about it; what this page does instead is say what every picture
 * actually is. A visualisation of a lounge is a visualisation of a lounge —
 * that is 'render', and its caption says what is in the frame rather than
 * naming a room the estate has open.
 *
 * AND THE ONE RULE THE OLD HEADER SET IS KEPT WORD FOR WORD: no caption on this
 * page names a room of ours, an hour, a service, a bottle, a cigar or a game.
 * Every caption was written against that test.
 *
 * THIS PAGE OWNS ITS OWN CHROME, as the six film pages before it do and for the
 * same reason: the film needs a bar that can be transparent over its hero and a
 * last screen that can close it. What that chrome says is still the site's —
 * film-nav.php builds itself from routes.php and common.php, so this page names
 * the same places in the same words as every other, and marks itself as the one
 * the reader is standing on.
 */

declare(strict_types=1);

return [

    'meta' => [
        'title'       => 'After Dark — Majori Manor, Jūrmala',
        'description' => 'The evening at Majori Manor in Jūrmala: lower light, deeper colour, private dinners and evenings by invitation.',
    ],

    /*
       NO JSON-LD. §13 assigns none to this page, and there is nothing here a
       crawler could be given that would not be an unbuilt service marked up as
       running: no hours, no venue that is open, no event that is scheduled.
       UNCHANGED BY THE REBUILD, because the rebuild settled no fact.
    */

    // The page paints its own grounds; this keeps the chrome tokens honest for
    // anything that still reads mood(). It has always been 'night' and it is the
    // only page on the site that sets it.
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
    // 00  THE NIGHT BEGINS
    //
    // THE MANOR AFTER DARK, AND IT IS THE PICTURE THIS SITE HAS NEVER HAD.
    // tools/photos/build_images.py has carried the absence as a comment since
    // the first build — "after-dark/hero wants the manor at night and NO NIGHT
    // FRAME OF THE HOUSE EXISTS" — and the slot has stood as a hatched box on
    // this page ever since. The two night frames in the whole library are the
    // pavilion, which is EVENTS' subject and already opens two pages, and one
    // interior that is 1178px wide against a hero rung of 1280.
    //
    // SO THE HOUR WAS MOVED ON THE ONE WIDE PHOTOGRAPH OF THE GARDEN FRONT.
    // media_src/estate/estate_4.jpg is the real Majori Manor photographed from
    // the lawn in daylight: the slate roof and its five chimneys, the dormer,
    // the brown-framed windows, the balcony on its curved bay, the columned
    // portico with its oculus, the granite plinth. A GPT Image 2 still put the
    // light in the windows and took the sun out of the sky and left every one of
    // those exactly where it was; Seedance walked a camera a few metres up the
    // lawn. The prompts are in tools/photos/build_after_dark_media.py and
    // docs/AFTER_DARK.md §3.
    //
    // THE TITLE AND THE SENTENCE UNDER IT ARE THE APPROVED PAGE'S OWN, kept
    // word for word. The title is six words where every other film hero has two
    // or four, and after-dark.css §2 is the one clamp that exists to hold it.
    //
    // ONE SENTENCE UNDER THE TITLE AND NO SUBTITLE, which is PADEL's rule and
    // EVENTS' rule and RESIDENCES' rule, for their reason: a fifth element in
    // this stack is what makes a first frame into a page.
    // =======================================================================

    'hero' => [
        'eyebrow'   => 'After Dark',
        'title'     => 'The hours the estate keeps for itself',
        'statement' => 'In the evening the estate does not close so much as turn inward.',
        'cue'       => 'Come in',
        // The first scene of THIS page; the component defaults to the Main
        // Page's #arrival, which does not exist here. See film-hero.php.
        'cue_target' => 'salon',

        'seal' => ['name' => 'brand/seal-cream', 'alt' => 'Majori Manor'],

        'film' => [
            'name'   => 'ad-nightfall',
            'poster' => 'after-dark/ad-nightfall',
            'ratio'  => '16/9',
            'alt'    => 'The garden front of the manor house after sunset, seen across the lawn: warm lamplight in the windows, the columns of the portico lit from below, and a deep blue sky above the dark roof',
            'source' => 'generated',
        ],
    ],

    'acts' => [

        // ===================================================================
        // ACT ONE — the first room. Wine.
        //
        // THE PAGE OPENS INSIDE ON ITS SECOND SCREEN AND STAYS THERE FOR SIX,
        // which is the structure the brief asks for in one word: inward. The
        // hero is the only exterior until scene 07, and scene 07 is the reader
        // being let back out.
        //
        // THE FIRST ROOM IS THE WHISKY LOUNGE AND NOT THE HALL, deliberately.
        // Every other page on this site opens indoors on a hall, a staircase or
        // a threshold, because every other page is about arriving. This one is
        // not: by the time it starts, everybody who is coming has come. So the
        // first interior is a room with the lamps already on and nothing
        // whatever happening in it.
        //
        // NOTHING HAS EVER MOVED THIS ROOM. media_src/CIGAR_HOUSE/
        // whisky_lounge.png is on the Main Page at 3:2 and on /residences at
        // 4:5, and six pages have gone past without cutting it wide or putting
        // a camera in it. See docs/AFTER_DARK.md §2.
        // ===================================================================

        [
            'tone'   => 'evening',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'variant' => 'full',
                    'id'      => 'salon',
                    'film'    => [
                        'name'   => 'ad-salon',
                        'poster' => 'after-dark/ad-salon',
                        'ratio'  => '16/9',
                        'alt'    => 'A panelled lounge by lamplight: buttoned leather chesterfields round a low table, a portrait over the chimneypiece, and a wall of lit shelves behind a bar counter',
                        'source' => 'generated',
                    ],
                    'overlay' => [
                        'index'   => '01',
                        'eyebrow' => 'The salon',
                        'title'   => 'The first room is the quiet one.',
                    ],
                    'caption' => 'Dark wood, brass, and the light kept low',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'When the last of dinner has been cleared the estate does not close so much as quieten.',
                    'body'  => [
                        'The doors are the same doors. There are simply fewer people behind them '
                        . 'and less reason to be anywhere in particular.',

                        'The light comes down and the colour goes deeper with it. Rooms that were '
                        . 'green all afternoon are something closer to red by the end of the '
                        . 'night, and it is the same house.',
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT TWO — the room nobody is hurrying you out of. Mahogany.
        //
        // THE SEQUENCE IN THIS SCENE IS THE ONE ON THE SITE WHOSE SUBJECT IS
        // NOT THE CAMERA. Every other film on these seven pages is a room and a
        // move through it. This one is a room that is not moved through: the
        // camera is nearly locked off and the only thing that happens in five
        // seconds is that smoke rises off a cigar somebody put down and a fire
        // breathes in the grate. It is the single most literal answer this site
        // has given to the word "atmosphere".
        //
        // AND IT IS THREE SENTENCES, WHICH IS THE CEILING AND THE RIGHT NUMBER.
        // Materials and light, then what the room is for, and then the
        // restraint. Not one of them is about what is drunk or smoked in it,
        // and the two forbidden lists at the top of this file are the reason.
        //
        // THE DETAIL TRACK AFTER IT IS THE CLUB'S COMPONENT AND THE BRIEF ASKS
        // FOR THE MATERIALS BY NAME. Six close frames panned sideways by
        // scroll, five of them out of the cigar house and the sixth the stair
        // that gets you there — and every caption is a noun that is true of a
        // room rather than of a stock.
        // ===================================================================

        [
            'tone'   => 'heritage',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'variant' => 'full',
                    'id'      => 'smoking',
                    'film'    => [
                        'name'   => 'ad-cigar',
                        'poster' => 'after-dark/ad-cigar',
                        'ratio'  => '16/9',
                        'alt'    => 'A panelled room with three portraits under picture lights, leather armchairs drawn up to a lit fire, and a glass and a lit cigar left on a marble table with smoke rising from it',
                        'source' => 'generated',
                    ],
                    'overlay' => [
                        'index'   => '02',
                        'eyebrow' => 'Whisky & cigar',
                        'title'   => 'Nobody is waiting for you to finish.',
                    ],
                    'caption' => 'Later, and the fire is still lit',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'Dark wood and leather, crystal and brass, and the light kept low.',
                    'body'  => [
                        'It is the quietest room the estate has, and it is built to be sat in for '
                        . 'a long time. Conversation runs at the pace of the room rather than at '
                        . 'the pace of an evening that has somewhere to be.',

                        'There is nothing to announce about it, which is most of the '
                        . 'recommendation.',
                    ],
                ],

                /*
                   SIX FRAMES, AND EVERY CAPTION IS A NOUN RATHER THAN A NAME.
                   "A drawer." "A counter." "A glass." Not a marque, not an age,
                   not a country, not a supplier — see the forbidden lists at
                   the top of this file. The rule bound the crops as well as the
                   captions: the third frame was moved off two labelled bottles
                   rather than the frame dropped, and the reason is written into
                   tools/photos/build_after_dark_media.py beside the bias.

                   FOUR OF THE SIX CARRY A SECOND RUNG THAT IS NOT ON THE SITE'S
                   LADDER, and the number is the crop's own width. Four of these
                   are cut out of panoramas only 1152px tall, so a 3:4 frame is
                   864 across and the 960 rung would be an upscale. The ladder is
                   [640, native] instead, which is the honest pair; the argument
                   is in the build script beside the entries.
                */
                [
                    'type'    => 'film-detail',
                    'id'      => 'made',
                    'index'   => '03',
                    'eyebrow' => 'What the room is made of',
                    'title'   => 'Old, close, and quiet.',
                    'note'    => 'Six things that are true of a room rather than of an evening.',
                    'frames'  => [
                        [
                            'name'    => 'after-dark/detail-humidor',
                            'widths'  => [640, 864],
                            'caption' => 'A drawer',
                            'alt'     => 'An open drawer of cigars in a timber cabinet, lit from within',
                            'source'  => 'render',
                        ],
                        [
                            'name'    => 'after-dark/detail-bar',
                            'widths'  => [640, 842],
                            'caption' => 'A counter',
                            'alt'     => 'A long mahogany bar with turned stools along it and lit shelves of bottles behind',
                            'source'  => 'render',
                        ],
                        [
                            'name'    => 'after-dark/detail-whisky',
                            'widths'  => [640, 864],
                            'caption' => 'A glass, put down',
                            'alt'     => 'A single cut-glass tumbler standing on a dark polished counter, the shelves behind it out of focus',
                            'source'  => 'render',
                        ],
                        [
                            'name'    => 'after-dark/detail-chair',
                            'widths'  => [640, 864],
                            'caption' => 'A chair, and what is over it',
                            'alt'     => 'A buttoned leather armchair under an oil portrait in a gilt frame, a lamp beside it',
                            'source'  => 'render',
                        ],
                        [
                            'name'    => 'after-dark/detail-cabinet',
                            'widths'  => [640, 960],
                            'caption' => 'A cabinet, and a fire',
                            'alt'     => 'A glazed cabinet beside a lit chimneypiece in a panelled room, framed pictures above',
                            'source'  => 'render',
                        ],
                        [
                            'name'    => 'after-dark/detail-stair',
                            'widths'  => [640, 960],
                            'caption' => 'The way up',
                            'alt'     => 'A dark timber staircase turning under portraits hung up the wall beside it',
                            'source'  => 'render',
                        ],
                    ],
                ],
            ],
        ],

        // ===================================================================
        // PRIVATE GAMING — AN ACT OF ITS OWN, ON THE PARK'S GREEN, AND GATED.
        //
        // THE GATE. Spreading an empty array adds nothing, so with the flag off
        // the act below is not skipped at render time — it is never in the array
        // to begin with, and there is nothing on the page for a template to skip
        // or for a stylesheet to hide.
        //
        // defined() before the constant, for the same reason social_links()
        // does it: a private/config.php uploaded before this key existed is
        // still a valid config.php, and the answer for one that has never heard
        // of the flag is the same as the answer for one that sets it false. Off
        // is the default in every sense including this one.
        //
        // WHY IT IS AN ACT AND WHY IT IS GREEN — see the long note at the top
        // of this file. The short version: an act is a ground, and a gated
        // scene inside somebody else's act would mean the flag changed which
        // colours the page passes through. On its own ground it can be removed
        // without the page noticing.
        //
        // NO INDEX ON THE SCENE. Every other scene here is numbered 01 to 08 as
        // a literal string; a gated scene inside that run would leave a hole or
        // renumber six others. It is also the honest treatment for the one room
        // on this page that may turn out not to exist.
        // ===================================================================

        ...((defined('ENABLE_GAMING') && ENABLE_GAMING) ? [[
            'tone'   => 'park',
            'blocks' => [

                /*
                   THREE SENTENCES, WHICH IS THE CEILING AND ALSO THE RIGHT
                   NUMBER. Materials, then what the room is, then the restraint —
                   the same shape as the scene above it and deliberately in the
                   same register, because they are the same kind of room written
                   by the same hand.

                   Every sentence here is about a room. Not one of them is about
                   what is done in it, and the list at the top of this file is
                   the reason. There is no game, no table count, no stake, no
                   hour and no operator in these two paragraphs, and none may be
                   added without the owner writing it down first.
                */
                [
                    'type'    => 'film-chapter',
                    'id'      => 'gaming',
                    'eyebrow' => 'Private gaming',
                    'title'   => 'The green room.',
                    'body'    => [
                        'Green felt and dark wood, brass and crystal, a deep red on the walls and '
                        . 'the light kept low. It is a room in a house, and it is being restored '
                        . 'as one.',

                        'Nothing about it has been hurried.',
                    ],
                ],

                /*
                   ONE PICTURE, FULL WIDTH, AND WHAT IS NOT IN IT IS THE REASON
                   IT IS THIS ONE. Four armchairs, a low table, portraits, a
                   chandelier and panelling — and no gaming table, no felt, no
                   cards, no chips and nobody playing anything.
                */
                [
                    'type'    => 'film-plates',
                    'variant' => 'act',
                    'plates'  => [
                        [
                            'name'    => 'after-dark/gaming-room',
                            'alt'     => 'A small panelled room with four leather armchairs drawn round one low table, oil portraits on the walls and a chandelier over them',
                            'caption' => 'A room, being restored as one',
                            'ratio'   => '3/2',
                            'widths'  => [640, 960, 1280],
                            'sizes'   => '(min-width: 1080px) 76vw, 92vw',
                            'span'    => 12,
                            'source'  => 'render',
                        ],
                    ],
                ],

                /*
                   THE OWNER'S WORDING, VERBATIM, AND IT IS FIXED. One sentence,
                   no heading, no anchor: a heading would make it a document and
                   it is a line under a section.

                   'standalone' is the clause component's one opt-in field — see
                   the note at the top of components/clause.php, which names this
                   page as the reason that field exists. It gives the clause the
                   band and the measure that pages/legal.php gives the legal
                   documents, and the fine-print treatment those pages give their
                   own closing line: --fs-sm under a hairline, softened by
                   opacity rather than by a colour, so the one rule serves any
                   ground it lands on — including this page's green, which is a
                   ground it has never stood on before.

                   Fine print is the treatment for a statement of fact under a
                   section. It is not a way of burying one, and the rule above it
                   is there to attach the sentence to the room rather than to
                   fence it off.
                */
                [
                    'type'       => 'clause',
                    'standalone' => true,
                    'body'       => [
                        'Private gaming experiences at Majori Manor are subject to applicable licensing and regulation.',
                    ],
                ],
            ],
        ]] : []),

        // ===================================================================
        // ACT THREE — the quieter side. The pause ground, and the page's one
        // silence.
        //
        // ONE PICTURE WITH NOTHING WRITTEN ON IT, AND ONE SENTENCE UNDER IT.
        // This is RESIDENCES' act five, and it is here for the reason the brief
        // gives in its own words: the purpose of this scene is atmosphere. The
        // band carries no overlay, no scene number, no eyebrow, no title and no
        // caption — the only band on the page that carries none of those — and
        // after-dark.js gives it the one camera a still can honestly have, a
        // very slow scale scrubbed to the scroll.
        //
        // THE HEADING IS THE APPROVED PAGE'S OWN, kept word for word and
        // promoted: on the page this replaces it was the title of a split block
        // with two paragraphs under it. Here it is a screen with nothing under
        // it at all, which is what the sentence was always describing.
        // ===================================================================

        [
            'tone'   => 'interior',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'variant' => 'full',
                    'id'      => 'quiet',
                    'film'    => [
                        'poster' => 'after-dark/quiet',
                        'ratio'  => '16/9',
                        'alt'    => 'A panelled lounge with a fire burning in the chimneypiece, leather sofas drawn up either side of it and a glazed cabinet at the far end',
                        'source' => 'render',
                    ],
                ],

                [
                    'type'    => 'film-chapter',
                    'index'   => '04',
                    'eyebrow' => 'The quieter side',
                    'title'   => 'The quieter side of Majori Manor.',
                ],
            ],
        ],

        // ===================================================================
        // ACT FOUR — the table, and what gets said at it. Wine.
        //
        // THE THIRD DINING ROOM IN THE MATERIAL AND THE ONLY ONE WITH A FIRE
        // LIT IN IT. THE CLUB moves dining_salon.png and EVENTS moves
        // Restaurant_1.png; media_src/RESTAURANT/dining_salon2.png is on
        // /padel at 4:5 and has never been cut wide or moved by anything. What
        // makes it this page's is the chimneypiece: two rooms laid for dinner
        // and one room laid for dinner with a fire going are different hours.
        //
        // AND THE SCENE IS NOT ABOUT DINNER. The estate has a dining ecosystem
        // and it has two pages — /the-club and /events — and both of them say
        // what is served and where. This one says what is different about the
        // same table four hours later, which is that nothing after it is
        // arranged.
        //
        // THEN THE CONVERSATION, AND THE LINE THAT WAS ALWAYS TRYING TO BE A
        // HEADING. "Some evenings are not events" was a pull quote near the end
        // of the page this replaces, and its own comment argued for keeping it
        // on the grounds that /events is a real page of this site and a reader
        // may well have come from it. That argument is unchanged and the line is
        // unchanged; what has changed is that it now has a scene under it
        // instead of standing between two others.
        // ===================================================================

        [
            'tone'   => 'evening',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'variant' => 'full',
                    'id'      => 'table',
                    'film'    => [
                        'name'   => 'ad-table',
                        'poster' => 'after-dark/ad-table',
                        'ratio'  => '16/9',
                        'alt'    => 'A panelled dining room by candlelight: a crystal chandelier with lit candles, a fire in the stone chimneypiece, and round tables laid with white cloths and glass',
                        'source' => 'generated',
                    ],
                    'overlay' => [
                        'index'   => '05',
                        'eyebrow' => 'The table',
                        'title'   => 'A table that runs long.',
                    ],
                    'caption' => 'The same room, four hours later',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'Private dinners. Members\' evenings. Evenings that happen because somebody was asked.',
                    'body'  => [
                        'None of it is on a calendar, and none of it is arranged in advance of the '
                        . 'people it is for.',

                        'What is different about a table here after dark is not the room and not '
                        . 'the cooking. It is that nothing has been put after it.',
                    ],
                ],

                [
                    'type'    => 'film-chapter',
                    'id'      => 'conversation',
                    'index'   => '06',
                    'eyebrow' => 'The conversation',
                    'title'   => 'Some evenings are not events.',
                    'body'    => [
                        'An occasion is booked. An evening simply happens, and the difference '
                        . 'between the two is the whole of what this part of the house is for.',
                    ],
                ],

                /*
                   TWO PLATES ON ONE ROW, AND THE SPANS DO NOT OVERLAP: 6 and 5
                   with the air between them, the second raised so the two feet
                   do not line up. The twelve columns are the Main Page's and so
                   is the rule that makes them work — within a row, spans and
                   offsets must not overlap or the grid drops the second plate
                   onto a row of its own.

                   THE PEOPLE IN THE FIRST ONE ARE AT A DISTANCE AND NONE OF
                   THEM IS LOOKING AT THE CAMERA, which is the standing rule for
                   figures on this site and the brief's own instruction for this
                   page: silhouettes, backs, small groups, distant activity.
                */
                [
                    'type'    => 'film-plates',
                    'variant' => 'act',
                    'plates'  => [
                        [
                            'name'    => 'after-dark/talk-hall',
                            'alt'     => 'A great hall at night under a lit chandelier, small groups of people standing in evening dress on a chequered floor with a carved staircase behind them',
                            'caption' => 'The hall, after dinner',
                            'ratio'   => '3/2',
                            'widths'  => [640, 960, 1280],
                            'sizes'   => '(min-width: 1080px) 46vw, 92vw',
                            'span'    => 6,
                            'source'  => 'render',
                        ],
                        [
                            'name'    => 'after-dark/talk-library',
                            'alt'     => 'A library with a fire burning in a dark chimneypiece, leather chesterfields drawn up to it and bookcases running the height of the walls',
                            'caption' => 'And the room people end up in',
                            'ratio'   => '3/2',
                            'widths'  => [640, 960],
                            'sizes'   => '(min-width: 1080px) 40vw, 92vw',
                            'span'    => 5,
                            'offset'  => 7,
                            'raise'   => true,
                            'source'  => 'render',
                        ],
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT FIVE — outside again. Near-black.
        //
        // THE READER IS LET OUT, AND IT IS THE ONLY TIME THE PAGE GOES BACK
        // OUTSIDE AFTER THE HERO. The brief asks for this scene to reconnect
        // AFTER DARK with the whole estate, and it does that by being the same
        // walk the hero was, in the opposite direction: the hero comes across
        // the lawn toward a lit house, and this one drifts along a lit path away
        // from it.
        //
        // THE ONE FRAME ON THIS PAGE THAT SHARES A COMPOSITION WITH AN APPROVED
        // PAGE, AND IT IS SAID HERE RATHER THAN LEFT TO BE NOTICED. /padel
        // prints media_src/PRIVATE_CLUB_ECOSYSTEM/3.png at 16:9 as a still, and
        // a 2048x1360 frame cut to 16:9 has only 208px of vertical travel in it,
        // so no bias makes a second picture out of it. What is different is that
        // this one moves and that it is graded a stop and a half under PADEL's.
        // It is also the only photograph of the estate's own park at night in
        // the entire library, and inventing a second garden would have been the
        // one thing the brief forbids. See docs/AFTER_DARK.md §8.
        // ===================================================================

        [
            'tone'   => 'estate',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'variant' => 'full',
                    'id'      => 'house',
                    'film'    => [
                        'name'   => 'ad-garden',
                        'poster' => 'after-dark/ad-garden',
                        'ratio'  => '16/9',
                        'alt'    => 'A private park at night: a wet stone path curving between clipped hedges, a cast-iron lamp standard burning warm, and a domed stone rotunda under the trees',
                        'source' => 'generated',
                    ],
                    'overlay' => [
                        'index'   => '07',
                        'eyebrow' => 'The house after dark',
                        'title'   => 'And then the house is outside as well.',
                    ],
                    'caption' => 'The park, with the lamps on',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'The park does not close either.',
                    'body'  => [
                        'Two and a half hectares of it, with the manor at one end and the courts '
                        . 'behind the hedge, and at this hour the whole of it belongs to whoever '
                        . 'is still awake.',

                        'It is a short walk and it is the reason the evening does not have to end '
                        . 'in a room.',
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT SIX — the rest of it, and the way in. MIDNIGHT.
        //
        // THE ONE GROUND THIS PAGE ADDS, AND IT IS HERE RATHER THAN ANYWHERE
        // ELSE. after-dark.css §1 declares --mm-midnight, which is darker than
        // --mm-estate — the Main Page's black and, until now, the floor of the
        // site. The argument is in that file: this is the only page whose last
        // screen has to be further down than its first, and a page that ends on
        // the same ground the Main Page starts on has not gone anywhere.
        //
        // FOUR TILES, FOUR PAGES, AND NOT ONE OF THEM IS AFTER DARK. Each tile
        // is a place the reader can go and the line under it says what is there
        // rather than what is offered. Three of the four carry a curve, because
        // three of the four were photographed with the lights on somewhere other
        // than this hour — see docs/AFTER_DARK.md §5.
        // ===================================================================

        [
            'tone'   => 'midnight',
            'blocks' => [

                [
                    'type'    => 'film-world',
                    'id'      => 'world',
                    'index'   => '08',
                    'eyebrow' => 'The estate',
                    'title'   => 'The rest of it, from here.',
                    'items'   => [
                        [
                            'page_id' => 'estate',
                            'name'    => 'after-dark/world-estate',
                            'label'   => 'The Estate',
                            'note'    => 'The house all of this is inside.',
                            'alt'     => 'The garden front of the manor house above its lawn at dusk',
                            'source'  => 'photo',
                        ],
                        [
                            'page_id' => 'club',
                            'name'    => 'after-dark/world-club',
                            'label'   => 'The Club',
                            'note'    => 'The rooms these ones are at the end of.',
                            'alt'     => 'A long mahogany bar under low lamps, ranked bottles on the shelves behind it',
                            'source'  => 'render',
                        ],
                        [
                            'page_id' => 'events',
                            'name'    => 'after-dark/world-events',
                            'label'   => 'Events & the Pavilion',
                            'note'    => 'The glass room at the other end of the park.',
                            'alt'     => 'The inside of a lit glass dome at night, tables laid below its structure',
                            'source'  => 'render',
                        ],
                        [
                            'page_id' => 'residences',
                            'name'    => 'after-dark/world-stay',
                            'label'   => 'Residences',
                            'note'    => 'The reason nobody has to drive.',
                            'alt'     => 'A first-floor landing with a carved balustrade and an arch onto a lit corridor',
                            'source'  => 'photo',
                        ],
                    ],
                ],

                /*
                   THE LAST SCREEN, AND THE BRIEF NAMES BOTH HALVES OF IT.

                   THE HEADLINE IS THE BRIEF'S OWN. "The night belongs inside"
                   is the sentence it asks for and it is the sentence the page
                   has been making for nine screens: this is not a place that
                   shuts, it is a place that turns in.

                   TWO WAYS ON, AND THE FIRST IS THE SITE'S SINGLE CONVERSION
                   PATH (ARCHITECTURE §3.3). Membership carries the gold, which
                   is the approved page's own choice — the block it replaces
                   ended on exactly that button — and it is the right one here
                   for a reason the other film pages do not have: everything this
                   page describes is behind a membership rather than behind a
                   booking, and a gold button that said "book" would be the first
                   dishonest thing on it.

                   NO QUERY ON THE SECOND ACTION, and that is deliberate.
                   components/form-enquiry.php starts its select on ?subject= and
                   the schema's option list has no entry for an evening; sending
                   ?subject=after-dark would fail that check silently and land
                   the reader on an unset form. /events sends private-event and
                   /residences sends residences because both of those are real
                   options. This one is a private enquiry, which is what the
                   quiet link on the Main Page and THE ESTATE says.
                */
                [
                    'type'    => 'film-invitation',
                    'id'      => 'invitation',
                    'eyebrow' => 'After Dark',
                    'title'   => 'The night belongs inside.',
                    'body'    => 'The estate has not opened. An evening here is arranged in conversation, and every enquiry is read by a person.',
                    'seal'    => ['name' => 'brand/seal-gold', 'alt' => ''],
                    'actions' => [
                        [
                            'page_id' => 'membership',
                            'label'   => 'Apply for membership',
                            'variant' => 'primary',
                        ],
                        [
                            'page_id' => 'contact',
                            'label'   => 'Private enquiry',
                            'variant' => 'quiet',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
