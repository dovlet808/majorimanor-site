<?php
/**
 * English content of Contact. Arrays only, no markup.
 *
 * THE EIGHTH PAGE CUT FROM THE FILM, AND THE ONLY ONE THAT IS NOT A STORY.
 * THE ESTATE, THE CLUB, PADEL, EVENTS, RESIDENCES and AFTER DARK each hold one
 * subject for eight or ten screens. This one holds four facts for six, and the
 * facts are the whole of it:
 *
 *     Konkordijas iela 66, Jūrmala, LV-2015, Latvia
 *     info@majorimanor.com
 *     that an enquiry is answered by a person
 *     that there is no published telephone number
 *
 * That list is the page the CEO approved, word for word, and NOT ONE ITEM HAS
 * BEEN ADDED TO IT. What changed is everything around it: the page that carried
 * those four things opened on a green band with a title in it, put the address
 * beside a map in a two-column split, and ended on a form. This one opens on
 * the house at dusk and walks a reader to the door.
 *
 * IT IS STILL THE SHORTEST PAGE ON THE SITE AND THAT IS THE INSTRUCTION RATHER
 * THAN A CONSEQUENCE. Six scenes against AFTER DARK's ten, three pictures
 * against its fifteen, one sequence against its five, and about 190 words of
 * prose. The brief is explicit that CONTACT is not another content-heavy
 * cinematic story page, and every screen below had to answer "does a reader
 * need this in order to write to us" before it was allowed to exist.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * THE PAGE IS AN ARRIVAL AND THE ORDER IS THE ARGUMENT:
 *
 *     00  the approach   the house at dusk, the portico, the door — moving
 *     01  the address    what to write on an envelope, and the mailbox
 *     02  the map        where that address is
 *     03  the gate       what to look for when you get there
 *     04  the desk       who reads what you send
 *     05  the enquiry    the form
 *     06  the invitation one line, and two ways on
 *
 * THE PAGE MOVES THROUGH FIVE GROUNDS AND THEY ALTERNATE ON PURPOSE — warm,
 * dark, warm, dark — which is the one place this page departs from the film's
 * monotonic descent (ARCHITECTURE §3.4) and it departs from it deliberately.
 * The six story pages go one way only, from light into dark, because each of
 * them is a journey inward. This page is not a journey; it is a threshold, and
 * it has two registers that take turns: THE ESTATE (the hero, the gate, the
 * last screen — near-black and near-green, the film's own grounds) and THE
 * LETTER (the address, the form — the warm mahogany ground, which is where a
 * reader is asked to write something down).
 *
 *     hero   estate      near-black
 *     01/02  heritage    warm mahogany — the address and the map
 *     03     estate      near-black — the gate
 *     04     park        the seal's green — the desk
 *     05     heritage    warm mahogany — the form
 *     06     estate      near-black — the last screen
 *
 * All five are estate.css §1's own grounds and NOT ONE IS NEW. This is the
 * first film page to add no ground at all, which is the right outcome for the
 * page that is meant to look most like the rest of the site.
 *
 * THE BRIEF ASKED FOR TWO OF THOSE FIVE TO BE WARM CREAM — a light ground under
 * the address and again under the form — and they are the film's warm ground
 * instead, with the film's warm cream as the ink on it. The reasoning is in
 * contact.css §1 and it is the brief's own first instruction: the seven
 * approved pages are one dark visual universe, a cream ground exists nowhere in
 * it, and a light band dropped into the middle of a film page is a second UI
 * language on the one page whose whole job is to look like it belongs. The
 * warmth the brief is asking for is real and it is delivered — --mm-heritage is
 * mahogany over black and it is visibly warmer than the screens on either side
 * of it — but as a temperature rather than as an inversion.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * WHAT IS NOT ON THIS PAGE, AND THE LIST IS THE APPROVED PAGE'S OWN, UNCHANGED:
 *
 *     A TELEPHONE NUMBER. There is no confirmed one (ARCHITECTURE §21), and a
 *       plausible number on a contact page is the single worst thing this site
 *       could invent — it would be answered by a stranger.
 *     opening hours, a reception desk that is staffed, "visits by appointment",
 *       parking, an airport, a station, a transfer, or anything whatever about
 *       arriving in person. The estate is under restoration and nobody has said
 *       what a visitor may do. THE PICTURES ARE HELD TO THE SAME RULE: scene 03
 *       is captioned as the gate and never as "your entrance", and scene 04 is
 *       captioned as a desk and never as a reception that is open.
 *     how long an answer takes.
 *     a company name or registration number — those are TODO on /terms and
 *       they are TODO here too, which is why they are simply absent.
 *
 * THE COORDINATES ARE THE ONE NUMBER ON THIS PAGE THAT WAS NOT SUPPLIED BY THE
 * OWNER, so here is where they came from, unchanged from the approved page.
 * OpenStreetMap holds this address as a `historic=manor` object at 56.9653548,
 * 23.8125328; searching the address returns that point and reverse-geocoding
 * the point returns "66, Konkordijas iela, Majori, Jūrmala, LV-2015", so the
 * two agree in both directions. Four decimal places is about eleven metres,
 * which is a building rather than a doorway.
 *
 * Worth confirming all the same: what a pin should mark on a park of 2.4
 * hectares is where a car is supposed to arrive, and only the owner knows which
 * gate that is. The two numbers appear here and nowhere else — the map, the
 * geo: link and the JSON-LD all read them from this file.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * 'source' IS A CLAIM ABOUT THE PICTURE AND IT IS MADE HERE (ARCHITECTURE §11).
 * Three pictures, three values, and none of them is 'mood':
 *
 *   generated  the hero sequence and its poster. It descends through a GPT
 *              Image 2 still that changed the hour of a photograph of this
 *              house and nothing else.
 *   photo      the gate, the drive and the north front — a crop of the supplied
 *              photography of the real building.
 *   render     the desk — the project's own visualisation, captioned as a desk
 *              and not as a service that is running.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * THE FORM IS THE APPROVED FORM AND NOTHING ABOUT IT HAS BEEN TOUCHED. Same
 * component, same schema, same five fields, same validation, same honeypot,
 * same signed time-trap, same rate limiter, same error summary, same privacy
 * sentence, same thank-you, same handler. The block below declares an id, an
 * eyebrow and a title, which is exactly what the approved page's block
 * declared. Everything that changed about the form on this page is in
 * contact.css and is a matter of the ground it stands on.
 *
 * NO 'subject_default' HERE, AND THAT IS THE DECISION RATHER THAN AN OMISSION.
 * This is the general form: it rests on General, which is the honest first
 * answer to "what is this about" for somebody who arrived at a contact page. A
 * reader who came from the foot of /events arrives with ?subject=private-event
 * on the address and finds the select already on Private event — and can change
 * it, because the field is on screen like every other. See
 * components/form-enquiry.php.
 *
 * THIS PAGE OWNS ITS OWN CHROME, as the seven film pages before it do and for
 * the same reason: the film needs a bar that can be transparent over its hero
 * and a last screen that can close it. What that chrome says is still the
 * site's — film-nav.php builds itself from routes.php and common.php, so this
 * page names the same places in the same words as every other, and marks itself
 * as the one the reader is standing on.
 */

declare(strict_types=1);

return [

    'meta' => [
        'title'       => 'Contact — Majori Manor, Jūrmala',
        'description' => 'Majori Manor, Konkordijas iela 66, Jūrmala, LV-2015, Latvia. Enquiries by email or through the form.',
    ],

    /*
       Place, with the postal address and the coordinates (ARCHITECTURE §13).
       UNCHANGED BY THE REBUILD, because the rebuild settled no fact. No
       openingHours, no telephone and no priceRange: the first is a business
       that is running, the second does not exist, and the third has nothing to
       describe. '@context' and the canonical 'url' are added by jsonld() in
       helpers.php.
    */
    'jsonld' => [
        '@type'       => 'Place',
        'name'        => 'Majori Manor',
        'description' => 'A historic manor house and private park in Jūrmala, Latvia, under restoration.',
        'email'       => 'info@majorimanor.com',
        'address'     => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => 'Konkordijas iela 66',
            'addressLocality' => 'Jūrmala',
            'postalCode'      => 'LV-2015',
            'addressCountry'  => 'LV',
        ],
        'geo' => [
            '@type'     => 'GeoCoordinates',
            'latitude'  => 56.9653,
            'longitude' => 23.8125,
        ],
    ],

    // The page paints its own grounds; this keeps the chrome tokens honest for
    // anything that still reads mood(). It was 'day' while the page was a cream
    // one and is 'night' now that it is not — the same value THE ESTATE, THE
    // CLUB, PADEL, EVENTS and RESIDENCES all resolve to through home.css §2.
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
    // 00  THE APPROACH
    //
    // THE LAST FEW METRES, AND IT IS THE ONE PICTURE THIS PAGE HAD TO GENERATE.
    // The library holds this facade in flat summer daylight — estate/estate_2.
    // jpg, the garden front with its portico under a mature tree — and holds it
    // after dark nowhere. A GPT Image 2 still put the light in the windows,
    // washed the columns from below and took the sun out of the sky, and left
    // every column, the pediment, the oculus, the timber door, the bench, the
    // steps and the tree exactly where they were; Seedance walked a camera a
    // few metres up the lawn. The prompts are in
    // tools/photos/build_contact_media.py and docs/CONTACT.md §3.
    //
    // IT IS NOT THE ESTATE'S HERO AND IT IS NOT THE ESTATE'S PARK. est-arrival
    // is the GATE at blue hour, dollying through the piers; est-park is the
    // whole elevation at golden hour, drifting sideways at 21:9. This is the
    // PORTICO at dusk, walking in. Different hour, different subject, different
    // ratio, different move — see the long note in the build script.
    //
    // THE TITLE IS THE APPROVED PAGE'S OWN, kept word for word, and so is the
    // sentence under it. The brief offered "The way in." as an alternative and
    // it was not taken: "How to reach Majori Manor" is what the CEO approved,
    // it is the one line on the page that says plainly what the page is for,
    // and the shorter line would have been a slogan where a label was wanted.
    // It is five words where most film heroes have two or four, which is why
    // contact.css §2 carries a clamp for it — the same arrangement AFTER DARK
    // needed for its six.
    //
    // ONE SENTENCE UNDER THE TITLE AND NO SUBTITLE, which is PADEL's rule and
    // EVENTS' and RESIDENCES' and AFTER DARK's, for their reason: a fifth
    // element in this stack is what makes a first frame into a page.
    // =======================================================================

    'hero' => [
        'eyebrow'   => 'Contact',
        'title'     => 'How to reach Majori Manor',
        'statement' => 'One address, one mailbox, and an answer from a person.',
        'cue'       => 'Find the estate',

        // The first scene of THIS page; the component defaults to the Main
        // Page's #arrival, which does not exist here. See film-hero.php.
        'cue_target' => 'address',

        'seal' => ['name' => 'brand/seal-cream', 'alt' => 'Majori Manor'],

        'film' => [
            'name'   => 'con-arrival',
            'poster' => 'contact/con-arrival',
            'ratio'  => '16/9',
            'alt'    => 'The manor house at dusk seen from the lawn: four white columns under a pediment, warm lamplight in every window, the front door lit under the portico, and mature trees standing either side against a deep blue sky',
            'source' => 'generated',
        ],
    ],

    'acts' => [

        // ===================================================================
        // ACT ONE — the letter. Mahogany.
        //
        // WHAT SOMEBODY CAME HERE FOR IS IN THE FIRST SCREEN AFTER THE HERO,
        // and that is the one hard rule this page has. Everything below scene
        // 02 is atmosphere; scenes 01 and 02 are the answer. A reader who
        // presses the cue lands on the address, and a reader who never scrolls
        // past it has still got what they came for.
        //
        // THE ADDRESS IS SET AS DISPLAY TYPE AND NOT AS A LABELLED FIELD.
        // "Konkordijas iela 66" is the h2 of this scene, at the size the film
        // gives a chapter heading, because on this page the street and the
        // number ARE the heading. The rest of the address, the mailbox and the
        // two sentences about how post is handled sit under and beside it. See
        // components/contact-address.php.
        // ===================================================================

        [
            'tone'   => 'heritage',
            'blocks' => [

                [
                    'type'    => 'contact-address',
                    'id'      => 'address',
                    'index'   => '01',
                    'eyebrow' => 'The address',
                    'title'   => 'Konkordijas iela 66',

                    'address' => [
                        'Jūrmala, LV-2015',
                        'Latvia',
                    ],

                    // The same mailbox the footer links to, stated here because
                    // this is the page that is about it.
                    'email'       => 'info@majorimanor.com',
                    'email_label' => 'The mailbox',

                    'body' => [
                        'Enquiries arrive in one mailbox and are read at the estate. There is no '
                        . 'switchboard and no published telephone number: the address here, and the '
                        . 'form further down, are the way in.',
                    ],
                ],

                /*
                   THE MAP IS THE APPROVED MAP AND THE COMPONENT UNDER IT HAS
                   NOT BEEN TOUCHED. components/map.php still holds the
                   coordinates, the geo: hand-off, the CARTO and OpenStreetMap
                   credit, the printed-address placeholder and the
                   IntersectionObserver that means no reader who does not scroll
                   here makes a request to any third party. What
                   components/contact-map.php adds is a scene around it: a
                   number, an eyebrow, a sentence and a frame.

                   THE MAP WAS ALREADY DARK, WHICH IS WORTH SAYING because the
                   brief asks for a dark map with a gold pin and it is not a
                   change: the basemap has been CARTO's dark_all since the
                   component was written, the pin has been a gold divIcon, the
                   attribution plate is off and the zoom control is the only
                   chrome inside the canvas. The one thing this page changes is
                   the border — see contact.css §5.

                   'label' AND 'open' ARE THE APPROVED PAGE'S STRINGS, unchanged.
                */
                [
                    'type'    => 'contact-map',
                    'id'      => 'map',
                    'index'   => '02',
                    'eyebrow' => 'On the map',
                    'lede'    => 'Majori Manor is in Majori, in the middle of Jūrmala, and the whole of '
                               . 'the estate is inside its own park.',

                    'map' => [
                        'label' => 'Map of Majori Manor, Konkordijas iela 66, Jūrmala',
                        'open'  => 'Open in your map application',

                        // See the note at the top of this file: approximate,
                        // worth confirming, and written down in exactly one
                        // place.
                        'lat'  => 56.9653,
                        'lng'  => 23.8125,
                        'zoom' => 16,

                        'address' => [
                            'Konkordijas iela 66',
                            'Jūrmala, LV-2015',
                            'Latvia',
                        ],
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT TWO — the gate. Near-black.
        //
        // THE ONE PICTURE ON THIS PAGE A READER MIGHT ACTUALLY NEED, and the
        // reason it is here rather than in the hero. A photograph of the
        // entrance answers a question the address cannot: what does it look
        // like when you get there. So it comes AFTER the address, where that
        // question is asked, and not before it.
        //
        // THE CROP STOPS SHORT OF THE OLD ENAMEL SIGN ON THE RIGHT-HAND PIER,
        // and on this page that is not a nicety — see the long note on the
        // plate in tools/photos/build_contact_media.py. It is why the band is
        // 'wide' rather than 'full': the window is 985px of a 1628px frame, and
        // inside the shell it is asked to stretch about as far as the site's
        // own 1152 plates already are.
        //
        // NOTHING IS CLAIMED ABOUT ARRIVING. The caption says what the frame is
        // and the two sentences say what is behind the gate. Not which gate to
        // use, not where to leave a car, not whether anybody may come — none of
        // that is settled (ARCHITECTURE §21) and none of it is here.
        // ===================================================================

        [
            'tone'   => 'estate',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'variant' => 'wide',
                    'id'      => 'gate',
                    'film'    => [
                        'name'   => '',
                        'poster' => 'contact/con-gate',
                        'ratio'  => '21/9',

                        // The crop is 985px wide and stops there — see the
                        // plate in tools/photos/build_contact_media.py. The
                        // band's default ladder asks for 1152, which was never
                        // exported because it would be an upscale, so this
                        // block names the two rungs that exist. 'sizes' is the
                        // 'wide' variant's real width: the shell, less a
                        // gutter either side.
                        'widths' => [768, 985],
                        'sizes'  => '(min-width: 1560px) 1313px, (min-width: 900px) 92vw, 100vw',

                        'alt'    => 'The stone gate pier and open timber gate of the estate at the end of the afternoon, with the paved drive running in and the north front of the manor house behind it',
                        'source' => 'photo',
                    ],
                    'overlay' => [
                        'index'   => '03',
                        'eyebrow' => 'The approach',
                        'title'   => 'And this is what to look for.',
                    ],
                    'caption' => 'The gate, the drive, and the house behind it',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'The house stands back from the road, behind its own gate.',
                    'body'  => [
                        'The park is inside the gate with it — two and a half hectares of it, with '
                        . 'the manor at one end — so the address is the whole of the estate rather '
                        . 'than a door on a street.',
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT THREE — the desk. The park's green.
        //
        // THE BRIEF ASKS FOR ONE THING FROM THIS SCREEN — that contact feels
        // human and discreet — AND FOR TWO THINGS NOT TO HAPPEN: no staff
        // profiles and no unnecessary portraits. The picture is the answer to
        // all three: cut at 16:9 out of a square render, the frame is a room
        // rather than a person. The panelling, the flowers, the brass lamp, the
        // desk and the estate's own wordmark are all in it, and the person at
        // the desk is one thing among six.
        //
        // THE CAPTION NAMES THE ROOM AND NEVER THE PERSON, and the two
        // sentences under it say what happens to an enquiry and stop. There is
        // no name, no title, no department, no photograph of anybody's face at
        // a size that would make it one, and no promise about when.
        // ===================================================================

        [
            'tone'   => 'park',
            'blocks' => [

                [
                    'type'    => 'film-band',
                    'variant' => 'full',
                    'id'      => 'desk',
                    'film'    => [
                        'name'   => '',
                        'poster' => 'contact/con-desk',
                        'ratio'  => '16/9',
                        'alt'    => 'A panelled reception room by lamplight: a long mahogany desk with a brass table lamp and a vase of flowers on it, and the Majori Manor crest and wordmark in gold on the dark wall behind',
                        'source' => 'render',
                    ],
                    'overlay' => [
                        'index'   => '04',
                        'eyebrow' => 'The answer',
                        'title'   => 'An answer from a person.',
                    ],
                    'caption' => 'A desk, and the estate\'s name behind it',
                ],

                [
                    'type'  => 'film-chapter',
                    'align' => 'split',
                    'lede'  => 'An enquiry is read at the estate and answered by a person.',
                    'body'  => [
                        'It is one mailbox, and it is the same one whether the question is about an '
                        . 'evening, a residence, a court or the house itself. The line you choose '
                        . 'below is what sorts it.',
                    ],
                ],
            ],
        ],

        // ===================================================================
        // ACT FOUR — the letter, again. Mahogany.
        //
        // THE SAME GROUND SCENE 01 STANDS ON, AND THAT IS THE STRUCTURE RATHER
        // THAN A REPEAT. The two screens on this page where a reader is asked
        // to write something down — the address they would put on an envelope,
        // and the form — are the same colour, and everything between them is
        // the estate. It is the one thing on this page a reader is meant to
        // notice without being told.
        //
        // THE FORM ITSELF IS UNTOUCHED. See the note at the top of this file.
        // ===================================================================

        [
            'tone'   => 'heritage',
            'blocks' => [

                [
                    'type'    => 'form-enquiry',
                    'id'      => 'enquiry',
                    'index'   => '05',
                    'eyebrow' => 'Enquiries',
                    'title'   => 'Send an enquiry',
                ],
            ],
        ],

        // ===================================================================
        // ACT FIVE — the last screen. Near-black.
        //
        // THE HEADLINE IS THE BRIEF'S OWN. "One address. One invitation." is
        // the first of the two lines it offers and it is the right one: it is
        // built like the estate's other formulas — "One estate. One membership.
        // An entire day." — where the alternative it offered, "Some places are
        // found. Others are entered.", is a second draft of the brand line that
        // already exists and would have read as one.
        //
        // THE GOLD IS ON THE ENQUIRY AND NOT ON MEMBERSHIP, WHICH IS THE ONE
        // PLACE THIS PAGE OVERRULES film-invitation.php's OWN HEADER. That file
        // says the first action is the site's single conversion path
        // (ARCHITECTURE §3.3) and carries the accent, and on the six pages
        // before this one it is right. Here it is not: this page's conversion
        // is the form four hundred pixels above, a reader who has scrolled past
        // it and wants to go back needs the obvious button to be that one, and
        // sending somebody who came to ask a question to a different and longer
        // form instead is the worst answer available. Membership keeps the
        // rule, and it keeps the gold everywhere else.
        //
        // THE FIRST ACTION IS THE FIRST ANCHORED ONE ON THE SITE. It points at
        // #enquiry on this page — see the note in film-invitation.php, where
        // 'anchor' is four lines added beside the 'query' that /events already
        // uses, and additive in exactly the same way.
        // ===================================================================

        [
            'tone'   => 'estate',
            'blocks' => [

                [
                    'type'    => 'film-invitation',
                    'id'      => 'invitation',
                    'eyebrow' => 'Contact',
                    'title'   => 'One address. One invitation.',
                    'body'    => 'The estate has not opened. Until it does, an enquiry is the whole of the way in — and it is read by a person.',
                    'seal'    => ['name' => 'brand/seal-gold', 'alt' => ''],
                    'actions' => [
                        [
                            'page_id' => 'contact',
                            'anchor'  => 'enquiry',
                            'label'   => 'Send an enquiry',
                            'variant' => 'primary',
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
