/**
 * Majori Manor — MEMBERSHIP's motion layer.
 *
 * It runs after home.js and club.js, in the same ordered injection, on the same
 * GSAP and the same Lenis. home.js has already taken the navigation, the
 * anchors, the reveals, the hero and the bands; club.js has taken the dialogue,
 * which on this page is scene 02; estate.js has taken the walk and the ledger,
 * neither of which is on this page and both of whose jobs return on their first
 * line. Everything those three already cover is covered by them and is not
 * repeated here.
 *
 * ONE JOB AND NO MORE:
 *
 *   1. still bands   the band on this page that is a photograph rather than a
 *                    sequence — the park in scene 03 — given a camera: one very
 *                    slow scale, scrubbed to the scroll
 *
 * IT IS contact.js's JOB, COPIED, which is residences.js's job copied, which is
 * events.js's copied from padel.js. The argument for copying twenty lines rather
 * than sharing them has not changed and is worth restating because this is the
 * fifth time: the alternative is loading events.css and events.js for one of
 * their two jobs, and events.css §1 and §3 are page-local overrides written
 * against a lit geodesic dome, which on this page would be a wash over the wrong
 * picture and a crop of the wrong frame. The other alternative is moving the job
 * into home.js, which re-versions the approved Main Page's script for a rule the
 * Main Page cannot use.
 *
 * WHICH BAND IT IS IS NOT WRITTEN DOWN. A band with no [data-band-video] has no
 * encode on disk, which is film-band.php's own test — so "the bands that do not
 * already move" is a query rather than a list, and the day scene 03 becomes a
 * sequence this job stops touching it without being edited. On this page the
 * query finds one: the park in act three. Scene 08 has an encode and is skipped.
 *
 * THIS IS THE SHORTEST PAGE LAYER ON THE SITE, and the reason is the brief:
 * MEMBERSHIP is asked to feel cinematic rather than to be a film, and the
 * ceremony is meant to be in the pacing rather than in the number of things
 * moving. Two sequences, one scrubbed scale, and everything else still.
 *
 * THERE IS NO JOB FOR THE FORM AND THAT IS DELIBERATE, AND IT IS THE ONE
 * DECISION ON THIS PAGE THE BRIEF NAMES TWICE. main.js already gives the form
 * inline validation, the conditional referral field and an error summary that
 * takes focus; nothing here touches any of it. A field that slides in as it is
 * approached is a field somebody is trying to type into, and a stagger down
 * eleven controls is the application process turned into a game. The brief asks
 * for motion that communicates ceremony and not entertainment, and on the one
 * screen where a reader is doing work rather than reading, ceremony is holding
 * still.
 *
 * THERE IS NO JOB FOR THE LETTERHEAD EITHER. The brief allows a subtle seal
 * animation and this file does not spend it: the seal is 140px of gold on wine
 * at the head of a document, it is the only crest on the page, and a crest that
 * draws itself in is a crest performing. Its only motion is the [data-reveal]
 * home.js applies to the block around it.
 *
 * IT NEVER HIDES SOMETHING IT CANNOT SHOW AGAIN, which is the rule home.js holds
 * and the seven page layers before this one hold after it. Nothing in
 * membership.css hides any part of any band: the transform below is set by this
 * file, on an element it is about to animate, at the moment it takes
 * responsibility for it. If this file never arrives, if the libraries are
 * blocked, or if the reader has asked for reduced motion — in which case
 * head.php fetches no library at all — the band is simply a photograph, which is
 * what it is.
 *
 * NOTHING HERE CHANGES THE HEIGHT OF THE DOCUMENT, which is why there is no
 * ScrollTrigger.refresh() at the end of it.
 */
(function () {
    'use strict';

    if (!window.gsap || !window.ScrollTrigger) {
        // The libraries did not arrive, so home.js and club.js have already
        // returned and there is nothing here to add to. The page is its
        // stylesheet: the dialogue is five captioned pictures and the band in
        // scene 03 is the photograph it is in the markup.
        return;
    }

    /** Run one job; a failure in it must not cost the others. */
    function job(name, fn) {
        try {
            fn();
        } catch (error) {
            if (window.console && console.warn) {
                console.warn('membership.js: ' + name + ' did not start', error);
            }
        }
    }


    // -----------------------------------------------------------------------
    // 1. The band that does not move
    //
    // A VERY SLOW SCALE IS THE ONLY CAMERA A STILL CAN HONESTLY HAVE. Seven
    // percent across the band's whole travel, scrubbed, which is the walk's own
    // vocabulary and padel.js's, events.js's, residences.js's and contact.js's
    // own number.
    //
    // COVER, NOT CONTAIN, which is what makes this safe: the still is
    // object-fit: cover inside a frame with overflow: clip, so scaling it up can
    // only ever crop and can never show an edge. On this page that is doing more
    // work than usual, because membership.css §8 crops this same frame to 4:3
    // below 900px — the scale runs on top of a crop, and the frame still only
    // ever shows less of the file, never more.
    // -----------------------------------------------------------------------

    job('still bands', function () {
        gsap.utils.toArray('[data-band]').forEach(function (band) {
            if (band.querySelector('[data-band-video]')) {
                return;
            }

            var image = band.querySelector('.c-film-band__still img');

            if (!image) {
                return;
            }

            gsap.fromTo(image, { scale: 1 }, {
                scale: 1.07,
                ease: 'none',
                scrollTrigger: {
                    trigger: band,
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: true
                }
            });
        });
    });
}());
