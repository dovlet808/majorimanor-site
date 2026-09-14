/**
 * Majori Manor — RESIDENCES' motion layer.
 *
 * It runs after home.js, estate.js and club.js, in the same ordered injection,
 * on the same GSAP and the same Lenis. home.js has already taken the
 * navigation, the anchors, the reveals, the hero and the bands; estate.js has
 * taken the walk and the ledger, neither of which is on this page; club.js has
 * taken the lateral track and the dialogue, both of which are. Everything on
 * this page those jobs already cover is covered by them and is not repeated
 * here.
 *
 * ONE JOB AND NO MORE:
 *
 *   1. still bands   the two bands on this page that are photographs rather
 *                    than sequences, given a camera — one very slow scale,
 *                    scrubbed to the scroll
 *
 * IT IS events.js's JOB, COPIED, AND THE COPY IS THE CHEAPEST OF THREE
 * OPTIONS — which is the argument events.js itself makes about copying it from
 * padel.js, and it has not changed. The alternative to twenty lines here is
 * loading events.css and events.js for one of their two jobs, and events.css
 * §1 and §3 are page-local overrides written against a lit geodesic dome, which
 * on this page would be a wash over the wrong picture and a crop of the wrong
 * frame. The other alternative is moving the job into home.js, which
 * re-versions the approved Main Page's script for a rule the Main Page cannot
 * use. So: twenty lines, with the two files they came from named in this
 * paragraph.
 *
 * WHICH BANDS THEY ARE IS NOT WRITTEN DOWN. A band with no [data-band-video]
 * has no encode on disk, which is film-band.php's own test — so "the bands that
 * do not already move" is a query rather than a list, and the day either of
 * them becomes a sequence this job stops touching it without being edited. On
 * this page the query finds two: the house at blue hour in act one, and the
 * silent stair hall in act five.
 *
 * THE SILENT ONE IS INCLUDED DELIBERATELY. Act five is the page's pause: one
 * photograph with no scene number, no eyebrow, no title and no caption, and one
 * sentence on the ground under it. The temptation is to let it be the one
 * screen that is completely still. It is not, and the reason is the argument
 * events.js makes for its own two: on a page where every other full screen has
 * a camera in it, a photograph that does not move reads as a picture that
 * failed to load. Seven percent across the whole travel is not motion a reader
 * notices; it is the difference between a held frame and a broken one.
 *
 * IT NEVER HIDES SOMETHING IT CANNOT SHOW AGAIN, which is the rule home.js
 * holds and estate.js, club.js, padel.js and events.js hold after it. Nothing
 * in residences.css hides any part of any band: the transform below is set by
 * this file, on an element it is about to animate, at the moment it takes
 * responsibility for it. If this file never arrives, if the libraries are
 * blocked, or if the reader has asked for reduced motion — in which case
 * head.php fetches no library at all — both bands are simply photographs, which
 * is what they are.
 *
 * NOTHING HERE CHANGES THE HEIGHT OF THE DOCUMENT, which is why there is no
 * ScrollTrigger.refresh() at the end of it: club.js ends with one, after its
 * own two classes have changed the layout, and this file runs after club.js.
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
                console.warn('residences.js: ' + name + ' did not start', error);
            }
        }
    }


    // -----------------------------------------------------------------------
    // 1. The bands that do not move
    //
    // A VERY SLOW SCALE IS THE ONLY CAMERA A STILL CAN HONESTLY HAVE. Seven
    // percent across the band's whole travel, scrubbed, which is the walk's own
    // vocabulary and padel.js's and events.js's own number.
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
