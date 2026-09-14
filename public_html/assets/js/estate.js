/**
 * Majori Manor — THE ESTATE's motion layer.
 *
 * It runs after home.js, in the same ordered injection, on the same GSAP and
 * the same Lenis. home.js has already taken the navigation, the anchors, the
 * reveals, the hero and the bands; everything on this page that those seven
 * jobs already cover is covered by them and is not repeated here.
 *
 * TWO JOBS AND NO MORE:
 *
 *   1. the walk    the sticky sequence through the rooms: a scrubbed
 *                  cross-fade between seven stations, the one in front
 *                  settling to its true size, its caption changing with it,
 *                  and at most two films attached at a time
 *   2. the ledger  the five facts, each rule drawn from nothing as its row
 *                  arrives
 *
 * IT NEVER HIDES SOMETHING IT CANNOT SHOW AGAIN, which is the rule home.js
 * holds and the reason html.is-walking exists. estate.css draws the walk as an
 * ordinary gallery of seven captioned photographs; the class below is what
 * turns that gallery into a stage, and it is added at the moment this file
 * takes responsibility for driving it. If this file never arrives, or throws
 * before it reaches the walk, the reader gets the gallery — which is a
 * complete way to see seven rooms, and not a column of blank boxes.
 *
 * ADDING THE CLASS CHANGES THE HEIGHT OF THE PAGE, because a stack of seven
 * photographs and a seven-screen sticky section are not the same document. So
 * it is added first and ScrollTrigger.refresh() is called once at the end,
 * after both jobs have built their triggers — otherwise every trigger home.js
 * made below the walk is measured against a layout that no longer exists.
 */
(function () {
    'use strict';

    var root = document.documentElement;

    if (!window.gsap || !window.ScrollTrigger) {
        // The libraries did not arrive, so home.js has already returned and
        // there is nothing here to add to. The page is its stylesheet, and the
        // walk is a gallery, which is the state it is written to fail into.
        return;
    }

    var EASE = 'power2.out';

    /** Run one job; a failure in it must not cost the other. */
    function job(name, fn) {
        try {
            fn();
        } catch (error) {
            if (window.console && console.warn) {
                console.warn('estate.js: ' + name + ' did not start', error);
            }
        }
    }

    /** Is this element far enough down that hiding it cannot be seen? */
    function belowFold(el) {
        return el.getBoundingClientRect().top > innerHeight * 0.85;
    }

    /** A metered connection is one that does not get films sent to it. */
    function saveData() {
        var connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;

        return !!(connection && (connection.saveData ||
            /^(slow-)?2g$/.test(connection.effectiveType || '')));
    }

    /**
     * Attach a source and play. The still stays under it until the first real
     * frame is decoded — 'playing', not 'canplay', for the reason home.js
     * gives: fading on canplay shows one black frame on a slow decoder.
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


    // -----------------------------------------------------------------------
    // 1. The walk
    //
    // THE WHOLE SEQUENCE IS ONE NUMBER. ScrollTrigger reports progress 0..1
    // over the pinned range; that becomes a position t along the stations, and
    // every frame's opacity is a function of t alone. Nothing is a switch, so
    // scrubbing back and forth walks the camera back and forth, which is the
    // point of scrubbing it at all. How the fade itself is shaped — opaque
    // from the bottom up rather than a dip through the ground — is in draw().
    //
    // THE STATION IN FRONT IS THE ONE AT ITS TRUE SIZE. Every other station is
    // very slightly larger, so a picture arrives by settling rather than by
    // appearing — the same 1.06-to-1 language the plates use on the Main Page,
    // driven by scroll here instead of by a trigger.
    //
    // quickSetter, not gsap.set: this runs on every scroll frame and a setter
    // resolved once is the difference between a scrub that holds 60fps on a
    // laptop and one that does not.
    // -----------------------------------------------------------------------

    job('walk', function () {
        var walk = document.querySelector('[data-walk]');

        if (!walk) {
            return;
        }

        var stage = walk.querySelector('[data-walk-stage]');
        var frames = Array.prototype.slice.call(walk.querySelectorAll('[data-walk-frame]'));
        var stations = Array.prototype.slice.call(walk.querySelectorAll('[data-walk-station]'));
        var bar = walk.querySelector('[data-walk-bar]');
        var count = frames.length;

        if (!stage || count < 2) {
            return;                       // one station is not a sequence
        }

        // From here the gallery is a stage, and this file owns what is visible.
        root.classList.add('is-walking');

        var cells = frames.map(function (frame) {
            var picture = frame.querySelector('img');

            return {
                opacity: gsap.quickSetter(frame, 'opacity'),
                visible: gsap.quickSetter(frame, 'visibility'),
                /*
                   TWO SETTERS FOR ONE SCALE, AND THE REASON IS AN ALIAS.
                   quickSetter resolves a property through GSAP's alias map
                   before it looks for a setter, and that map turns 'scale'
                   into the literal string "scaleX,scaleY" — a name no setter
                   matches, so it falls through to
                   style.setProperty("scaleX,scaleY", …). Blink drops that
                   silently and the settle simply never happens; WebKit throws
                   InvalidCharacterError, which is every browser on iOS, and
                   the throw came out of the scrub callback in the middle of
                   ScrollTrigger's refresh — so the walk died, ScrollTrigger
                   stopped refreshing, and every reveal further down the page
                   stayed at the opacity home.js had set it to. One aliased
                   property name cost the page its text.

                   scaleX and scaleY carry no alias and resolve straight to
                   GSAP's transform setter, on both engines.
                */
                scaleX: picture ? gsap.quickSetter(picture, 'scaleX') : null,
                scaleY: picture ? gsap.quickSetter(picture, 'scaleY') : null,
                video: frame.querySelector('[data-walk-video]')
            };
        });

        var setBar = bar ? gsap.quickSetter(bar, 'scaleX') : null;
        var shown = -1;

        /** Which caption is on screen, and which films are worth having. */
        function land(index) {
            if (index === shown) {
                return;
            }

            /*
               THE TWO CAPTIONS OCCUPY THE SAME LINE, so they are swapped in
               sequence and never cross-faded: the outgoing one is gone before
               the incoming one starts to arrive. Fading both at once puts two
               display lines on top of each other, which on a serif at 3.6rem
               is not a transition, it is an unreadable smear.

               Killing whatever is already tweening on the pair first is what
               keeps a fast scrub from stacking half-finished swaps and leaving
               a caption stranded at 0.4.
            */
            gsap.killTweensOf(stations);

            var arriving = stations[index];
            var leaving = stations[shown];

            if (leaving) {
                gsap.to(leaving, { opacity: 0, y: -12, duration: 0.28, ease: 'power2.in' });
            }

            if (arriving) {
                gsap.fromTo(arriving,
                    { opacity: 0, y: 16 },
                    {
                        opacity: 1, y: 0, duration: 0.55, ease: EASE,
                        delay: leaving ? 0.3 : 0
                    });
            }

            // Anything that is neither arriving nor leaving is off, flatly:
            // a scrub that jumps several stations at once must not leave one
            // behind at whatever opacity its tween had reached.
            stations.forEach(function (station, i) {
                if (i !== index && i !== shown) {
                    gsap.set(station, { opacity: 0 });
                }
            });

            shown = index;

            if (saveData()) {
                return;
            }

            // The one in front and the one after it, and nothing else: a walk
            // of seven films costs two, wherever the reader stops.
            cells.forEach(function (cell, i) {
                if (!cell.video || !cell.video.dataset.src) {
                    return;
                }

                if (i === index || i === index + 1) {
                    play(cell.video, cell.video.dataset.src);
                } else {
                    release(cell.video);
                }
            });
        }

        /*
           A DISSOLVE, NOT A DIP. Cross-fading two frames at half opacity each
           lets the ground through between them and ghosts one room over
           another — on architecture, which is all straight lines, that reads
           as a printing error rather than as a cut. So the stack is opaque
           from the bottom up: every frame stays at 1 once it has arrived, and
           the next one fades in ON TOP of it. Only one pair is ever mixing,
           nothing shows through to the ground, and the frame underneath is
           already the right picture if the fade is interrupted.

           BAND is how much of a station's travel the fade occupies. At 0.26 a
           reader spends about three quarters of every station looking at one
           clean photograph and the last quarter watching it become the next
           one. Wider than this and the walk reads as permanently half-way
           between two rooms; much narrower and the dissolve becomes a cut.
        */
        var BAND = 0.26;

        function ease(x) {
            return x <= 0 ? 0 : x >= 1 ? 1 : x * x * (3 - 2 * x);
        }

        function paint(progress) {
            var t = progress * (count - 1);
            var front = 0;
            var opacities = [];
            var i;

            for (i = 0; i < count; i++) {
                // The first frame is the ground of the stack and never fades.
                var opacity = i === 0
                    ? 1
                    : ease((t - (i - (0.5 + BAND / 2))) / BAND);

                opacities[i] = opacity;

                if (opacity >= 1) {
                    front = i;            // the topmost fully opaque frame
                }
            }

            for (i = 0; i < count; i++) {
                cells[i].opacity(opacities[i]);

                /*
                   COMPOSITING SEVEN FULL-SCREEN LAYERS EVERY FRAME IS THE ONE
                   THING THAT WOULD COST THE SCRUB ITS FRAME RATE. A frame that
                   is completely covered by an opaque one above it, or that has
                   not begun to arrive, is taken out of the compositor rather
                   than drawn at an opacity nobody can see.
                */
                cells[i].visible(
                    (opacities[i] > 0 && i >= front) ? 'visible' : 'hidden'
                );

                if (cells[i].scaleX) {
                    // The station in front sits at its true size; the ones
                    // either side of it are very slightly larger, so a picture
                    // arrives by settling. Same language as the Main Page's
                    // plates, driven by scroll instead of by a trigger.
                    var settle = 1 + 0.06 * Math.min(1, Math.abs(t - i));

                    cells[i].scaleX(settle);
                    cells[i].scaleY(settle);
                }
            }

            if (setBar) {
                setBar(progress);
            }

            land(Math.min(count - 1, Math.max(0, Math.round(t))));
        }

        /*
           THE GALLERY HAS TO STAY REACHABLE, and from the line that added
           is-walking it is only reachable through here. That class is a
           promise to the stylesheet: it may hide six of the seven frames and
           all seven captions because this file has undertaken to show them
           again on every scroll frame. The moment this file cannot keep that
           promise the promise has to be withdrawn — the class comes off, every
           inline style written since goes with it, and the section is the long
           quiet gallery it is in the markup again.

           A reader who sees this sees seven captioned photographs instead of a
           camera move. A reader without it sees one photograph, no captions
           and five screens of nothing, which is what an unguarded throw in
           here actually cost.
        */
        function standDown() {
            root.classList.remove('is-walking');

            gsap.set(frames.concat(stations), { clearProps: 'all' });
            gsap.set(walk.querySelectorAll('.c-walk__img img'), { clearProps: 'all' });

            if (bar) {
                gsap.set(bar, { clearProps: 'all' });
            }
        }

        var standing = true;

        /*
           THE SCRUB CALLBACK IS INSIDE SCROLLTRIGGER'S OWN LOOP, so a throw
           from it does not merely lose the walk: it comes out in the middle of
           ScrollTrigger.refresh(), which leaves the library mid-refresh and
           stops every other trigger on the page from ever updating again. That
           is one component taking the whole motion layer with it, which is
           precisely what job() above exists to prevent and cannot, because by
           then the callback is not being called by this file.

           So the painter is fenced here rather than trusted. It fails once, at
           most, and what follows is the gallery.
        */
        function draw(progress) {
            if (!standing) {
                return;
            }

            try {
                paint(progress);
            } catch (error) {
                standing = false;
                standDown();

                if (window.console && console.warn) {
                    console.warn('estate.js: the walk stood down', error);
                }
            }
        }

        gsap.set(stations, { opacity: 0 });

        /*
           PAINTED ONCE BEFORE ANY TRIGGER EXISTS. If the setters above cannot
           drive this stage, this is where that is discovered — with nothing
           registered against ScrollTrigger yet, so standing down is a matter
           of removing a class rather than of unpicking a live scrub.
        */
        draw(0);

        if (!standing) {
            return;
        }

        /*
           THE SCRUB IS THE PINNED RANGE AND NOTHING ELSE. The section starts
           with a heading in normal flow, so its top edge reaches the top of
           the window a screenful before the stage does — triggering on the
           section would spend the first station scrolling the heading away
           and land the reader in the middle of the walk on arrival. The stage
           is what sticks, so the stage is what starts it; the section is what
           releases it, so the section is what ends it.
        */
        ScrollTrigger.create({
            trigger: stage,
            start: 'top top',
            endTrigger: walk,
            end: 'bottom bottom',
            scrub: true,
            onUpdate: function (self) { draw(self.progress); },
            onRefresh: function (self) { draw(self.progress); }
        });

        // Off the sequence entirely: nothing decoding behind the reader.
        ScrollTrigger.create({
            trigger: walk,
            start: 'top bottom',
            end: 'bottom top',
            onLeave: function () { cells.forEach(function (c) { release(c.video); }); },
            onLeaveBack: function () { cells.forEach(function (c) { release(c.video); }); }
        });
    });


    // -----------------------------------------------------------------------
    // 2. The ledger
    //
    // The rule under each row is painted at full width by the stylesheet and
    // only its scaleX is animated, so a reader with no motion layer gets a
    // finished sheet rather than five rows with nothing under them.
    // -----------------------------------------------------------------------

    job('ledger', function () {
        gsap.utils.toArray('[data-ledger-row]').forEach(function (row) {
            if (!belowFold(row)) {
                return;
            }

            var type = row.querySelectorAll('.c-ledger__label, .c-ledger__value');
            var rule = row.querySelector('[data-ledger-rule]');

            gsap.set(type, { opacity: 0, y: 18 });

            if (rule) {
                gsap.set(rule, { scaleX: 0 });
            }

            ScrollTrigger.create({
                trigger: row,
                start: 'top 88%',
                once: true,
                onEnter: function () {
                    gsap.to(type, {
                        opacity: 1, y: 0, duration: 1, ease: EASE, stagger: 0.08
                    });

                    if (rule) {
                        gsap.to(rule, { scaleX: 1, duration: 1.4, ease: 'power3.out' });
                    }
                }
            });
        });
    });


    // -----------------------------------------------------------------------
    // 3. Settling
    //
    // The walk changed the height of the document, so every trigger home.js
    // measured below it is measuring against a layout that has been replaced.
    // One refresh, once, after both jobs have built theirs.
    // -----------------------------------------------------------------------

    job('settling', function () {
        ScrollTrigger.refresh();

        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(function () { ScrollTrigger.refresh(); });
        }
    });
}());
