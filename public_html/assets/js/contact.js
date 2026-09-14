/**
 * Majori Manor — CONTACT's motion layer.
 *
 * It runs after home.js, in the same ordered injection, on the same GSAP and
 * the same Lenis. home.js has already taken the navigation, the anchors, the
 * reveals, the hero and the bands; estate.js has taken the walk and the ledger,
 * neither of which is on this page and both of whose jobs return on their first
 * line. Everything on this page those jobs already cover is covered by them and
 * is not repeated here.
 *
 * ONE JOB AND NO MORE:
 *
 *   1. still bands   the two bands on this page that are photographs rather
 *                    than sequences — the gate and the desk — given a camera:
 *                    one very slow scale, scrubbed to the scroll
 *
 * IT IS residences.js's JOB, COPIED, AND THE COPY IS THE CHEAPEST OF THREE
 * OPTIONS — which is the argument residences.js itself makes about copying it
 * from events.js, and events.js about copying it from padel.js. It has not
 * changed. The alternative to twenty lines here is loading events.css and
 * events.js for one of their two jobs, and events.css §1 and §3 are page-local
 * overrides written against a lit geodesic dome, which on this page would be a
 * wash over the wrong picture and a crop of the wrong frame. The other
 * alternative is moving the job into home.js, which re-versions the approved
 * Main Page's script for a rule the Main Page cannot use. So: twenty lines,
 * with the three files they came from named in this paragraph.
 *
 * WHICH BANDS THEY ARE IS NOT WRITTEN DOWN. A band with no [data-band-video]
 * has no encode on disk, which is film-band.php's own test — so "the bands that
 * do not already move" is a query rather than a list, and the day either of
 * them becomes a sequence this job stops touching it without being edited. On
 * this page the query finds two: the gate in act two and the desk in act three.
 *
 * THE PAGE HAS ONE SEQUENCE AND IT IS THE HERO, which is why this file is
 * shorter than any page layer before it. The brief asks for one primary
 * cinematic visual and for the rest of CONTACT to be calm; two still
 * photographs with seven percent of scale on them across a whole screen of
 * travel is the quietest camera this site has.
 *
 * THERE IS NO JOB FOR THE MAP AND THAT IS DELIBERATE. main.js holds Leaflet
 * behind an IntersectionObserver and builds it when the frame arrives; nothing
 * here touches it, animates it, or scrubs anything to it. The brief asks for
 * the map not to be animated and the cheapest way to honour that was to write
 * nothing.
 *
 * THERE IS NO JOB FOR THE FORM EITHER. main.js already gives it inline
 * validation and an error summary, and a field that slides in as it is
 * approached is a field somebody is trying to type into. Its only motion is the
 * [data-reveal] home.js applies to the heading above it.
 *
 * IT NEVER HIDES SOMETHING IT CANNOT SHOW AGAIN, which is the rule home.js
 * holds and estate.js, club.js, padel.js, events.js, residences.js and
 * after-dark.js hold after it. Nothing in contact.css hides any part of any
 * band: the transform below is set by this file, on an element it is about to
 * animate, at the moment it takes responsibility for it. If this file never
 * arrives, if the libraries are blocked, or if the reader has asked for reduced
 * motion — in which case head.php fetches no library at all — both bands are
 * simply photographs, which is what they are.
 *
 * NOTHING HERE CHANGES THE HEIGHT OF THE DOCUMENT, which is why there is no
 * ScrollTrigger.refresh() at the end of it.
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
                console.warn('contact.js: ' + name + ' did not start', error);
            }
        }
    }


    // -----------------------------------------------------------------------
    // 1. The bands that do not move
    //
    // A VERY SLOW SCALE IS THE ONLY CAMERA A STILL CAN HONESTLY HAVE. Seven
    // percent across the band's whole travel, scrubbed, which is the walk's own
    // vocabulary and padel.js's, events.js's and residences.js's own number.
    //
    // COVER, NOT CONTAIN, which is what makes this safe: the still is
    // object-fit: cover inside a frame with overflow: clip, so scaling it up can
    // only ever crop and can never show an edge. That matters more here than on
    // the pages before it, because one of these two frames is deliberately cut
    // short of its own photograph — see the gate's plate in
    // tools/photos/build_contact_media.py — and a scale that could reveal an
    // edge would be revealing the thing the crop exists to leave out. It cannot:
    // the frame only ever shows less of the file, never more.
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
