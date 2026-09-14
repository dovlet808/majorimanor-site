/**
 * Majori Manor — PADEL's motion layer.
 *
 * It runs after home.js and after estate.js, in the same ordered injection, on
 * the same GSAP and the same Lenis. home.js has already taken the navigation,
 * the anchors, the reveals, the hero and the bands; estate.js has taken the
 * ledger. Everything on this page those eight jobs already cover is covered by
 * them and is not repeated here.
 *
 * TWO JOBS AND NO MORE:
 *
 *   1. the plan   the schematic drawing itself as the reader arrives at it:
 *                 every built edge drawn from nothing, every annotation
 *                 arriving after the thing it annotates
 *   2. still bands  the two bands on the page that are photographs rather than
 *                 sequences, given a camera — one very slow scale, scrubbed
 *
 * IT NEVER HIDES SOMETHING IT CANNOT SHOW AGAIN, which is the rule home.js
 * holds and estate.js and club.js hold after it. Nothing in padel.css hides any
 * part of the drawing: the dash offsets and the opacities below are set by this
 * file, on the elements it is about to animate, at the moment it takes
 * responsibility for them. If this file never arrives, if the CDN is blocked,
 * or if the reader has asked for reduced motion — in which case head.php
 * fetches no library at all — the plan is simply a finished drawing on the
 * first paint, which is what a plan is.
 *
 * AND IT CHECKS THAT IT CAN MEASURE BEFORE IT HIDES ANYTHING. getTotalLength()
 * on a <rect> is a modern-browser guarantee and not an ancient one; if not one
 * element in the drawing answers it, this file leaves the drawing alone rather
 * than emptying it and having nothing to draw it back with.
 *
 * NOTHING HERE CHANGES THE HEIGHT OF THE DOCUMENT, which is why there is no
 * ScrollTrigger.refresh() at the end of it: the two files before this one both
 * end with one, and estate.js's runs again when the faces land.
 */
(function () {
    'use strict';

    var root = document.documentElement;

    if (!window.gsap || !window.ScrollTrigger) {
        // The libraries did not arrive, so home.js has already returned and
        // there is nothing here to add to. The page is its stylesheet, and the
        // plan is a drawing, which is the state it is written to fail into.
        return;
    }

    var EASE = 'power2.out';

    /** Run one job; a failure in it must not cost the other. */
    function job(name, fn) {
        try {
            fn();
        } catch (error) {
            if (window.console && console.warn) {
                console.warn('padel.js: ' + name + ' did not start', error);
            }
        }
    }

    /** Is this element far enough down that hiding it cannot be seen? */
    function belowFold(el) {
        return el.getBoundingClientRect().top > innerHeight * 0.85;
    }

    /** The drawn length of one SVG shape, or 0 if this browser will not say. */
    function lengthOf(el) {
        try {
            return typeof el.getTotalLength === 'function' ? el.getTotalLength() : 0;
        } catch (error) {
            return 0;
        }
    }


    // -----------------------------------------------------------------------
    // 1. The plan
    //
    // A SHEET OF DRAWINGS ASSEMBLING ITSELF, and the phrase is estate.css §3's
    // own — it is what the ledger's hairlines are for. The ledger stands
    // directly above this drawing in act two, so the drawing finishing what the
    // ledger started is the one place on the site where that ornament is
    // literal rather than a figure of speech.
    //
    // THE ORDER IS THE ORDER SOMEBODY WOULD DRAW IT IN, and that is the whole
    // design: the boundary, then the two strips inside it, then the four courts,
    // then what is marked on a court, then the dimension across the top, and
    // only then the numbers and the labels. An annotation cannot arrive before
    // the thing it annotates, and a plan whose parts appear in a random order
    // is a loading animation.
    //
    // WHAT IS DRAWN AND WHAT ARRIVES. A stroke with a length is drawn — its
    // dash offset runs to zero, so the line grows from one end. Everything
    // else fades: the hedge, because it is a dashed stroke and a dash pattern
    // animated by another dash pattern is not a hedge; the crests, the
    // arrowheads and the type, because none of them is a line.
    //
    // NOTHING MOVES. No part of this drawing slides, scales or rotates into
    // place. A plan whose parts travel is a diagram of itself; a plan that is
    // drawn is a plan.
    // -----------------------------------------------------------------------

    job('the plan', function () {
        var svg = document.querySelector('.c-plan-padel__svg');

        if (!svg) {
            return;
        }

        var figure = svg.closest('.c-plan-padel__figure') || svg;

        // A reader who arrives with the drawing already on screen — a #hash, a
        // restored scroll position — is left with a finished drawing.
        if (!belowFold(figure)) {
            return;
        }

        var pick = function (selector) {
            return Array.prototype.slice.call(svg.querySelectorAll(selector));
        };

        /*
           Six steps, in drawing order. 'draw' is stroked geometry and 'fade' is
           everything else; a step may carry either or both, and the two halves
           of one step start together.
        */
        var steps = [
            {   // the boundary, and the planting on it
                draw: pick('.c-plan-padel__enclosure'),
                fade: pick('.c-plan-padel__hedge')
            },
            {   // the two strips
                draw: pick('.c-plan-padel__zone'),
                fill: pick('.c-plan-padel__zone')
            },
            {   // four courts
                draw: pick('.c-plan-padel__court rect')
            },
            {   // what is marked on a court
                draw: pick('.c-plan-padel__line'),
                fade: pick('.c-plan-padel__crest-ground, .c-plan-padel__crest')
            },
            {   // the one dimension, and the leaders
                draw: pick('.c-plan-padel__dim path, .c-plan-padel__lead'),
                fade: pick('.c-plan-padel__dim polygon, .c-plan-padel__arrow')
            },
            {   // the numbers and the words
                fade: pick('.c-plan-padel__mark, .c-plan-padel__label')
            }
        ];

        // Measure first, and only hide what came back with a length.
        var measurable = 0;

        steps.forEach(function (step) {
            step.draw = (step.draw || []).filter(function (el) {
                el.__len = lengthOf(el);
                return el.__len > 0;
            });

            measurable += step.draw.length;
        });

        if (!measurable) {
            // This browser will not measure a path. Leave the finished drawing
            // exactly where it is rather than empty something that cannot be
            // put back.
            return;
        }

        root.classList.add('is-drawing');

        steps.forEach(function (step) {
            step.draw.forEach(function (el) {
                gsap.set(el, { strokeDasharray: el.__len, strokeDashoffset: el.__len });
            });

            if (step.fill && step.fill.length) {
                gsap.set(step.fill, { fillOpacity: 0 });
            }

            if (step.fade && step.fade.length) {
                gsap.set(step.fade, { opacity: 0 });
            }
        });

        ScrollTrigger.create({
            trigger: figure,
            start: 'top 82%',
            once: true,
            onEnter: function () {
                var tl = gsap.timeline();

                steps.forEach(function (step, i) {
                    // 0.22 of a second between steps: slow enough that the six
                    // are read as an order and quick enough that the whole
                    // sheet is standing inside two and a half seconds.
                    var at = i * 0.22;

                    if (step.draw.length) {
                        tl.to(step.draw, {
                            strokeDashoffset: 0,
                            duration: 1.1,
                            ease: 'power1.inOut',
                            stagger: 0.05
                        }, at);
                    }

                    if (step.fill && step.fill.length) {
                        tl.to(step.fill, {
                            fillOpacity: 0.06,
                            duration: 1.2,
                            ease: EASE
                        }, at + 0.3);
                    }

                    if (step.fade && step.fade.length) {
                        tl.to(step.fade, {
                            opacity: 1,
                            duration: 0.9,
                            ease: EASE,
                            stagger: 0.04
                        }, at + 0.25);
                    }
                });

                tl.add(function () {
                    // The dash pattern has done its work; leaving it on a
                    // hairline is a rounding error waiting to show up on a
                    // retina display, and will-change on forty elements is a
                    // layer nobody is using any more.
                    steps.forEach(function (step) {
                        step.draw.forEach(function (el) {
                            gsap.set(el, { clearProps: 'strokeDasharray,strokeDashoffset' });
                        });
                    });

                    root.classList.remove('is-drawing');
                });
            }
        });
    });


    // -----------------------------------------------------------------------
    // 2. The bands that are photographs
    //
    // FOUR OF THE SIX BANDS ON THIS PAGE ARE SEQUENCES AND TWO ARE STILLS, and
    // the two are the ones that carry the argument rather than the atmosphere:
    // the whole complex seen from the park, and the park itself at night. On a
    // page where every other full screen has a camera in it, a photograph that
    // does not move reads as a picture that failed to load.
    //
    // So the two get the only camera move a still can honestly have: a very
    // slow scale, scrubbed to the scroll, seven percent across the entire
    // travel of the band. It is the walk's own vocabulary — estate.js scales
    // the station in front by about this much — and it is scrubbed rather than
    // timed so that it is the reader moving the camera and not the page.
    //
    // WHICH BANDS THEY ARE IS NOT WRITTEN DOWN HERE. A band with no
    // [data-band-video] has no encode on disk, which is film-band.php's own
    // test, so "the bands that do not already move" is a query rather than a
    // list — and the day one of them becomes a sequence, this job stops
    // touching it without being edited.
    //
    // COVER, NOT CONTAIN, which is what makes this safe: the still is
    // object-fit: cover inside a frame with overflow: clip, so scaling it up
    // can only ever crop and can never show an edge.
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
