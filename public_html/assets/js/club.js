/**
 * Majori Manor — THE CLUB's motion layer.
 *
 * It runs after home.js and after estate.js, in the same ordered injection, on
 * the same GSAP and the same Lenis. home.js has already taken the navigation,
 * the anchors, the reveals, the hero and the bands; estate.js has taken the
 * walk. Everything on this page those nine jobs already cover is covered by
 * them and is not repeated here.
 *
 * THREE JOBS AND NO MORE:
 *
 *   1. the track      the lateral pan along the six detail frames, scrubbed
 *   2. the dialogue   four ideas over one room, the room changing to the one
 *                     the reader is on
 *   3. the walk's films  held off the first screen until the walk is near
 *
 * IT NEVER HIDES SOMETHING IT CANNOT SHOW AGAIN, which is the rule home.js
 * holds and the reason html.is-tracking and html.is-dialogue exist. club.css
 * draws both sections as ordinary captioned grids; those two classes are what
 * turn a grid into a stage, and each is added at the moment this file takes
 * responsibility for driving it. If this file never arrives, or throws before
 * it reaches a section, the reader gets the grid — which is a complete way to
 * see six details and four ideas, and not a column of blank boxes.
 *
 * BOTH CLASSES CHANGE THE HEIGHT OF THE PAGE, because a grid of six frames and
 * a pinned lateral pan are not the same document. So they are added first and
 * ScrollTrigger.refresh() is called once at the end, after both jobs have
 * built their triggers — otherwise every trigger the two files before this one
 * made below these sections is measured against a layout that no longer exists.
 */
(function () {
    'use strict';

    var root = document.documentElement;

    if (!window.gsap || !window.ScrollTrigger) {
        // The libraries did not arrive, so home.js has already returned and
        // there is nothing here to add to. The page is its stylesheet, and both
        // sections are the grids they are in the markup.
        return;
    }

    var EASE = 'power2.out';

    /** The width below which the track is not a track. See §2. */
    var WIDE = 900;

    /**
     * Attach a source and play. The still under it stays visible until the
     * first real frame is decoded — 'playing', not 'canplay', for the reason
     * home.js gives: fading on canplay shows one black frame on a slow decoder.
     *
     * home.js and estate.js each carry their own copy of this pair and so does
     * this file, which is the codebase's existing shape rather than an
     * oversight: the three are injected as separate scripts with no module
     * boundary between them, and a shared helper would mean one of them owning
     * a global the other two read.
     */
    function play(video, src) {
        if (!video || video.dataset.attached === src) {
            return;
        }

        video.dataset.attached = src;
        video.src = src;
        video.load();

        video.addEventListener('playing', function () {
            video.classList.add('is-playing');
        }, { once: true });

        var attempt = video.play();

        if (attempt && attempt.catch) {
            attempt.catch(function () {});
        }
    }

    function release(video) {
        if (!video || !video.dataset.attached) {
            return;
        }

        video.pause();
        video.classList.remove('is-playing');
        video.removeAttribute('src');
        delete video.dataset.attached;
        video.load();
    }

    /** Run one job; a failure in it must not cost the other. */
    function job(name, fn) {
        try {
            fn();
        } catch (error) {
            if (window.console && console.warn) {
                console.warn('club.js: ' + name + ' did not start', error);
            }
        }
    }


    // -----------------------------------------------------------------------
    // 1. The track
    //
    // A row of close frames, wider than the window, slid sideways by scroll.
    // The whole move is one number: ScrollTrigger reports progress 0..1 over
    // the pinned range and that is multiplied by the travel — the distance
    // between the right edge of the last frame and the right edge of the
    // stage, measured from the real element rather than assumed from the CSS.
    //
    // IT IS MEASURED ON EVERY REFRESH AND NOT ONCE. The frames are sized in vw,
    // the gap is a clamp, and the fonts land after this file runs; a travel
    // computed once at boot is a pan that stops short of the last frame on
    // every screen except the one it was measured on.
    //
    // BELOW 900px THERE IS NO TRACK AT ALL, and that is the mobile design
    // rather than its fallback: a horizontal pan driven by vertical scroll
    // wants a landscape window. On a phone the six frames are two columns of
    // captioned figures, which is the vertical form of the same story. See §5
    // of club.css.
    // -----------------------------------------------------------------------

    job('track', function () {
        var section = document.querySelector('[data-detail]');

        if (!section || innerWidth < WIDE) {
            return;
        }

        var stage = section.querySelector('[data-detail-stage]');
        var track = section.querySelector('[data-detail-track]');
        var frames = Array.prototype.slice.call(section.querySelectorAll('[data-detail-frame]'));

        if (!stage || !track || frames.length < 2) {
            return;                       // one frame is not a pan
        }

        // From here the grid is a stage, and this file owns what is visible.
        root.classList.add('is-tracking');

        var setX = gsap.quickSetter(track, 'x', 'px');
        var travel = 0;
        var standing = true;

        /*
           THE GRID HAS TO STAY REACHABLE, and from the line above it is only
           reachable through here. is-tracking is a promise to the stylesheet:
           it may pin the section and lay the frames in a row that overflows
           the window because this file has undertaken to slide that row. The
           moment it cannot keep that promise the promise is withdrawn — the
           class comes off, every inline style written since goes with it, and
           the section is the plain captioned grid it is in the markup again.
        */
        function standDown() {
            standing = false;
            root.classList.remove('is-tracking');
            gsap.set(track, { clearProps: 'all' });
        }

        function measure() {
            var last = frames[frames.length - 1];
            var pad = parseFloat(getComputedStyle(track).paddingLeft) || 0;

            // offsetLeft is relative to the stage: the frames sit in a static
            // track inside a sticky — and therefore positioned — stage.
            travel = Math.max(
                0,
                (last.offsetLeft + last.offsetWidth + pad) - stage.clientWidth
            );
        }

        function draw(progress) {
            if (!standing) {
                return;
            }

            try {
                setX(-travel * progress);
            } catch (error) {
                standDown();

                if (window.console && console.warn) {
                    console.warn('club.js: the track stood down', error);
                }
            }
        }

        measure();

        /*
           A ROW THAT ALREADY FITS IS NOT A PAN. Pinning a section for three
           screens and moving nothing is the worst outcome this component has,
           and it is the one a wide window or a large text size can produce. It
           is discovered here, before any trigger exists, so standing down is a
           matter of removing a class.
        */
        if (travel <= 1) {
            standDown();
            return;
        }

        draw(0);

        if (!standing) {
            return;
        }

        /*
           THE SCRUB IS THE PINNED RANGE AND NOTHING ELSE. The section opens
           with a heading in normal flow, so its top edge reaches the top of the
           window a screenful before the stage does; triggering on the section
           would spend the first frames scrolling the heading away. The stage is
           what sticks, so the stage starts it; the section is what releases it,
           so the section ends it. Same shape as the walk — estate.js §1.
        */
        ScrollTrigger.create({
            trigger: stage,
            start: 'top top',
            endTrigger: section,
            end: 'bottom bottom',
            scrub: true,
            onUpdate: function (self) { draw(self.progress); },
            onRefresh: function (self) {
                if (!standing) {
                    return;
                }

                // A window dragged narrower than the track's own breakpoint is
                // a window the mobile grid is the right answer for.
                if (innerWidth < WIDE) {
                    standDown();
                    return;
                }

                measure();

                if (travel <= 1) {
                    standDown();
                    return;
                }

                draw(self.progress);
            }
        });
    });


    // -----------------------------------------------------------------------
    // 2. The dialogue
    //
    // Four ideas over one room. The scroll range is divided into four equal
    // slices and the room behind the type is the one the reader's slice names;
    // on a fine pointer, pointing at an idea selects it as well, and letting go
    // hands it back to the scroll.
    //
    // THE FADE IS OPAQUE FROM UNDERNEATH, not a cross-dissolve, and the reason
    // is the reason estate.js gives for the walk: fading two rooms at half
    // opacity each lets the ground through between them and ghosts one room
    // over another, which on architecture reads as a printing error. So the
    // arriving picture is lifted above the stack and faded in ON TOP of
    // whatever is under it, and the ones underneath are only zeroed once it has
    // fully arrived. Interrupt it as fast as you like and the worst state is
    // two opaque pictures with the right one on top.
    // -----------------------------------------------------------------------

    job('dialogue', function () {
        var section = document.querySelector('[data-dialogue]');

        if (!section) {
            return;
        }

        var stage = section.querySelector('[data-dialogue-stage]');
        var items = Array.prototype.slice.call(section.querySelectorAll('[data-dialogue-item]'));

        if (!stage || items.length < 2) {
            return;
        }

        var plates = items.map(function (item) {
            return item.querySelector('.c-dialogue__img');
        });

        if (plates.indexOf(null) !== -1) {
            return;                       // an item with no picture has no stage
        }

        root.classList.add('is-dialogue');

        var count = items.length;
        var shown = -1;
        var fromScroll = 0;
        var fromPointer = -1;
        var standing = true;

        /*
           THE GRID HAS TO STAY REACHABLE. is-dialogue is a promise that this
           file will keep one room painted behind the type and one line printed
           under the current name; withdrawing it puts every picture and every
           line back. .is-current is left on the first item because that is
           where the markup has it and it styles nothing in the grid.
        */
        function standDown() {
            standing = false;
            root.classList.remove('is-dialogue');
            gsap.set(plates, { clearProps: 'all' });

            items.forEach(function (item, i) {
                item.classList.toggle('is-current', i === 0);
            });
        }

        function show(index) {
            if (!standing || index === shown) {
                return;
            }

            shown = index;

            items.forEach(function (item, i) {
                item.classList.toggle('is-current', i === index);
            });

            gsap.set(plates, { zIndex: 0 });
            gsap.set(plates[index], { zIndex: 1 });

            gsap.to(plates[index], {
                opacity: 1,
                duration: 0.95,
                ease: EASE,
                overwrite: true,
                onComplete: function () {
                    if (shown !== index) {
                        return;           // something else arrived meanwhile
                    }

                    plates.forEach(function (plate, i) {
                        if (i !== index) {
                            gsap.set(plate, { opacity: 0 });
                        }
                    });
                }
            });
        }

        function settle() {
            show(fromPointer >= 0 ? fromPointer : fromScroll);
        }

        /*
           The first room is already painted by the stylesheet and the first
           item already carries .is-current from the markup — see
           film-dialogue.php. All this does is tell show() where it is starting
           from, and give plate 0 the inline opacity every other plate will get
           when its turn comes, so the two are never compared unequally.
        */
        shown = 0;
        gsap.set(plates[0], { opacity: 1, zIndex: 1 });

        ScrollTrigger.create({
            trigger: stage,
            start: 'top top',
            endTrigger: section,
            end: 'bottom bottom',
            scrub: true,
            onUpdate: function (self) {
                fromScroll = Math.min(count - 1, Math.floor(self.progress * count));
                settle();
            }
        });

        /*
           THE POINTER IS AN ACCELERANT, NOT A CONTROL. Nothing is disclosed by
           pointing at an idea — every name and every line is already on the
           screen — so there is nothing here to reach by keyboard and nothing
           to announce. On a coarse pointer none of it is bound at all: a tap
           that changes a background and nothing else is a tap that reads as a
           broken link.
        */
        if (window.matchMedia && matchMedia('(hover: hover) and (pointer: fine)').matches) {
            items.forEach(function (item, i) {
                item.addEventListener('pointerenter', function () {
                    fromPointer = i;
                    settle();
                });
            });

            stage.addEventListener('pointerleave', function () {
                fromPointer = -1;
                settle();
            });
        }
    });


    // -----------------------------------------------------------------------
    // 3. Holding the walk's films back
    //
    // ESTATE.JS ATTACHES THE FIRST TWO STATIONS' FILMS THE MOMENT IT PAINTS THE
    // STAGE, and it paints the stage at boot — before any trigger exists, so
    // that a reader whose setters do not work is looking at a room rather than
    // at a black rectangle. That is the right call and it has a cost this page
    // is the first to pay: THE ESTATE's first station is a photograph and its
    // second is a 645 KB film, and THE CLUB's FIRST station is a 1.5 MB one.
    // Measured on the first screen, club-hall.mp4 was arriving beside the hero
    // — three megabytes of video for a reader who had not scrolled.
    //
    // SO THE SOURCES ARE TAKEN OFF THE STATIONS AND GIVEN BACK. estate.js skips
    // any station whose video has no data-src, in both directions — it neither
    // attaches nor releases one — so removing the attribute is a complete and
    // side-effect-free way to say "not yet". Half a screen before the walk they
    // go back on, and the two stations estate.js would have chosen are attached
    // here, because its own land() only ever re-attaches on a CHANGE of station
    // and the station it is standing on has not changed.
    //
    // A READER WHO ARRIVES ALREADY AT THE WALK — a #hash, a restored scroll
    // position — is left alone: this job returns before it touches anything.
    //
    // THE ESTATE WANTS THE SAME HOLD and has not been given it; see
    // docs/THE_CLUB.md §8. It is a smaller file on a shorter page and the
    // approved page was left alone.
    // -----------------------------------------------------------------------

    job('walk films', function () {
        var walk = document.querySelector('[data-walk]');

        if (!walk) {
            return;
        }

        var frames = Array.prototype.slice.call(walk.querySelectorAll('[data-walk-frame]'));
        var videos = Array.prototype.slice.call(walk.querySelectorAll('[data-walk-video]'));

        if (!videos.length || walk.getBoundingClientRect().top < innerHeight * 1.5) {
            return;
        }

        videos.forEach(function (video) {
            video.dataset.held = video.dataset.src || '';
            delete video.dataset.src;
            release(video);
        });

        ScrollTrigger.create({
            trigger: walk,
            start: 'top bottom+=50%',
            once: true,
            onEnter: function () {
                videos.forEach(function (video) {
                    if (video.dataset.held) {
                        video.dataset.src = video.dataset.held;
                    }

                    delete video.dataset.held;
                });

                // The pair estate.js would have chosen: the station in front
                // and the one after it, which at the top of the walk is the
                // first two — and only the ones that are films.
                frames.slice(0, 2).forEach(function (frame) {
                    var video = frame.querySelector('[data-walk-video]');

                    if (video && video.dataset.src) {
                        play(video, video.dataset.src);
                    }
                });
            }
        });
    });


    // -----------------------------------------------------------------------
    // 4. Settling
    //
    // Both jobs above changed the height of the document, so every trigger the
    // two files before this one measured below them is measuring against a
    // layout that has been replaced. One refresh, once, after both have built
    // theirs — and one more when the faces land, because a display line that
    // reflows moves every trigger under it.
    // -----------------------------------------------------------------------

    job('settling', function () {
        ScrollTrigger.refresh();

        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(function () { ScrollTrigger.refresh(); });
        }
    });
}());
