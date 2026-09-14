/**
 * Majori Manor — EVENTS' motion layer.
 *
 * It runs after home.js, estate.js and club.js, in the same ordered injection,
 * on the same GSAP and the same Lenis. home.js has already taken the
 * navigation, the anchors, the reveals, the hero and the bands; estate.js has
 * taken the ledger; club.js has taken the dialogue. Everything on this page
 * those ten jobs already cover is covered by them and is not repeated here.
 *
 * ONE JOB AND NO MORE:
 *
 *   1. still bands   the two bands on this page that are photographs rather
 *                    than sequences, given a camera — one very slow scale,
 *                    scrubbed to the scroll
 *
 * IT IS padel.js's JOB, COPIED, AND THE COPY IS THE CHEAPEST OF THREE OPTIONS.
 * The alternative to twenty lines here is loading padel.css and padel.js for
 * one of their two jobs — and padel.css §3 and §4 are page-local legibility
 * overrides written against PADEL's own hero photograph and its own band
 * titles, which on this page would be a wash over the wrong picture. The other
 * alternative is moving the job into home.js, which re-versions the approved
 * Main Page's script for a rule the Main Page cannot use. So: twenty lines,
 * with the file they came from named in this paragraph.
 *
 * WHICH BANDS THEY ARE IS NOT WRITTEN DOWN. A band with no [data-band-video]
 * has no encode on disk, which is film-band.php's own test — so "the bands that
 * do not already move" is a query rather than a list, and the day either of
 * them becomes a sequence this job stops touching it without being edited.
 *
 * IT NEVER HIDES SOMETHING IT CANNOT SHOW AGAIN, which is the rule home.js
 * holds and estate.js, club.js and padel.js hold after it. Nothing in
 * events.css hides any part of any band: the transform below is set by this
 * file, on an element it is about to animate, at the moment it takes
 * responsibility for it. If this file never arrives, if the libraries are
 * blocked, or if the reader has asked for reduced motion — in which case
 * head.php fetches no library at all — both bands are simply photographs, which
 * is what they are.
 *
 * NOTHING HERE CHANGES THE HEIGHT OF THE DOCUMENT, which is why there is no
 * ScrollTrigger.refresh() at the end of it: club.js ends with one, after its
 * own two classes have changed the layout, and estate.js's runs again when the
 * faces land.
 */
(function () {
    'use strict';

    if (!window.gsap || !window.ScrollTrigger) {
        // The libraries did not arrive, so home.js has already returned and
        // there is nothing here to add to. The page is its stylesheet, and both
        // bands are the photographs they are in the markup.
        return;
    }

    /** Run one job; a failure in it must not cost the others. */
    function job(name, fn) {
        try {
            fn();
        } catch (error) {
            if (window.console && console.warn) {
                console.warn('events.js: ' + name + ' did not start', error);
            }
        }
    }


    // -----------------------------------------------------------------------
    // 1. The bands that do not move
    //
    // Two of this page's seven bands are photographs: the pavilion in the
    // afternoon, which opens the film, and the pavilion from the air at night,
    // which is the frame the hero was descending toward. On a page where every
    // other full screen has a camera in it, a photograph that does not move
    // reads as a picture that failed to load.
    //
    // A VERY SLOW SCALE IS THE ONLY CAMERA A STILL CAN HONESTLY HAVE. Seven
    // percent across the band's whole travel, scrubbed, which is the walk's own
    // vocabulary and padel.js's own number.
    //
    // COVER, NOT CONTAIN, which is what makes this safe: the still is
    // object-fit: cover inside a frame with overflow: clip, so scaling it up can
    // only ever crop and can never show an edge.
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
