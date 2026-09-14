/**
 * Majori Manor — the Main Page's motion layer.
 *
 * It runs only on the Main Page, only after the load event, and only when the
 * reader has not asked for reduced motion — all three decisions are made in
 * the inline block in templates/partials/head.php, which is also the only
 * place that knows this file exists.
 *
 * SEVEN JOBS AND NO MORE:
 *
 *   1. smooth scroll        Lenis, driven by GSAP's ticker so there is one
 *                           clock on the page instead of two
 *   2. the navigation       compact past the hero; the sheet below 900px
 *   3. anchors              every in-page link eased rather than jumped
 *   4. reveals              everything below the fold, once, on the way up
 *   5. the hero             the film attached when it is safe to; a slow
 *                           parallax as the first screen leaves
 *   6. the bands            each sequence attached a screen before it is
 *                           needed and released a long way behind
 *   7. the plates           a photograph settling from 1.06 to 1 as it enters
 *
 * IT NEVER HIDES SOMETHING IT CANNOT SHOW AGAIN. An element is hidden here at
 * the moment a ScrollTrigger is created for it, and only if it is below the
 * fold; anything already on screen when this file runs is left exactly as the
 * stylesheet painted it. That is what makes a failed download a page with no
 * animation rather than a page with no content. See §13 of home.css.
 *
 * IT ALSO NEVER ASSUMES IT ARRIVED. Every one of the seven is wrapped so that
 * a throw inside it cannot stop the six after it: a broken reveal must not
 * take the navigation with it.
 */
(function () {
    'use strict';

    var root = document.documentElement;

    if (!window.gsap || !window.ScrollTrigger) {
        // The libraries did not arrive. html.motion only ever drove the hero's
        // CSS entrance, which has already played, so there is nothing to undo.
        return;
    }

    gsap.registerPlugin(ScrollTrigger);

    var EASE = 'power2.out';

    /** Run one job; a failure in it must not cost the others. */
    function job(name, fn) {
        try {
            fn();
        } catch (error) {
            if (window.console && console.warn) {
                console.warn('home.js: ' + name + ' did not start', error);
            }
        }
    }

    /** Is this element far enough down that hiding it cannot be seen? */
    function belowFold(el) {
        return el.getBoundingClientRect().top > innerHeight * 0.85;
    }

    var lenis = null;


    // -----------------------------------------------------------------------
    // 1. Smooth scroll
    //
    // ONE CLOCK. Lenis' own rAF loop and GSAP's ticker would otherwise run
    // independently and ScrollTrigger would sample a scroll position Lenis had
    // already moved past — which reads as a half-frame of lag on every pinned
    // element and is the usual reason a smooth-scrolled page feels loose.
    // lagSmoothing(0) stops GSAP from silently skipping time after a long
    // frame, which on this page would jump the film rather than catch up.
    // -----------------------------------------------------------------------

    job('smooth scroll', function () {
        if (!window.Lenis) {
            return;
        }

        lenis = new Lenis({
            duration: 1.15,
            easing: function (t) { return Math.min(1, 1.001 - Math.pow(2, -10 * t)); },
            smoothWheel: true,
            // Touch is left alone deliberately: a phone's native scroll is
            // already smooth, already interruptible, and already the one the
            // reader's thumb expects.
            syncTouch: false
        });

        lenis.on('scroll', ScrollTrigger.update);

        gsap.ticker.add(function (time) {
            lenis.raf(time * 1000);
        });

        gsap.ticker.lagSmoothing(0);
    });


    // -----------------------------------------------------------------------
    // 2. The navigation
    // -----------------------------------------------------------------------

    job('navigation', function () {
        var nav = document.querySelector('[data-film-nav]');
        var hero = document.querySelector('[data-hero-scene]');

        if (nav && hero) {
            ScrollTrigger.create({
                trigger: hero,
                start: 'bottom top+=80',
                onEnter: function () { nav.classList.add('is-compact'); },
                onLeaveBack: function () { nav.classList.remove('is-compact'); }
            });
        }

        var toggle = document.querySelector('[data-film-nav-toggle]');
        var menu = document.querySelector('[data-film-menu]');

        if (!toggle || !menu) {
            return;
        }

        var label = toggle.querySelector('[data-film-nav-label]');
        var openLabel = label ? label.textContent : '';
        var closeLabel = 'Close the menu';
        var open = false;

        function setMenu(next) {
            open = next;

            toggle.setAttribute('aria-expanded', String(open));
            root.classList.toggle('is-menu-open', open);

            if (label) {
                label.textContent = open ? closeLabel : openLabel;
            }

            if (open) {
                menu.hidden = false;
                gsap.fromTo(menu, { opacity: 0 }, { opacity: 1, duration: 0.4, ease: EASE });
                gsap.fromTo(menu.querySelectorAll('.c-film-menu__list li, .c-film-menu__action'),
                    { opacity: 0, y: 14 },
                    { opacity: 1, y: 0, duration: 0.6, stagger: 0.045, delay: 0.08, ease: EASE });

                if (lenis) { lenis.stop(); }
            } else {
                gsap.to(menu, {
                    opacity: 0,
                    duration: 0.3,
                    ease: EASE,
                    onComplete: function () { menu.hidden = true; }
                });

                if (lenis) { lenis.start(); }
            }
        }

        toggle.addEventListener('click', function () { setMenu(!open); });

        menu.addEventListener('click', function (event) {
            if (event.target.closest('[data-film-menu-link]')) {
                setMenu(false);
            }
        });

        // Escape closes it and puts the focus back on the control that opened
        // it, which is the only place a keyboard reader can sensibly be left.
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && open) {
                setMenu(false);
                toggle.focus();
            }
        });

        // A width change while the sheet is open would otherwise leave the
        // scroll locked behind a menu that is no longer displayed.
        matchMedia('(min-width: 900px)').addEventListener('change', function (event) {
            if (event.matches && open) {
                setMenu(false);
            }
        });
    });


    // -----------------------------------------------------------------------
    // 3. Anchors
    //
    // The film's navigation is a set of in-page anchors and Lenis owns the
    // scroll, so the browser's own jump would fight it. offset clears the
    // compact bar; without it every section lands with its first line under
    // the navigation.
    // -----------------------------------------------------------------------

    job('anchors', function () {
        if (!lenis) {
            return;
        }

        document.addEventListener('click', function (event) {
            var link = event.target.closest('a[href^="#"]');

            if (!link) {
                return;
            }

            var id = link.getAttribute('href');

            if (id === '#' || id === '#main') {
                return;
            }

            var target = document.querySelector(id);

            if (!target) {
                return;
            }

            event.preventDefault();
            lenis.scrollTo(target, { offset: -72, duration: 1.5 });

            // The address bar still has to say where the reader is.
            if (history.replaceState) {
                history.replaceState(null, '', id);
            }
        });
    });


    // -----------------------------------------------------------------------
    // 4. Reveals
    //
    // [data-reveal]        one line or one block, lifted and faded
    // [data-reveal-lines]  a display line, revealed from under its own mask —
    //                      the type does not fade, it rises out of a clipped
    //                      box, which is what makes a heading read as printed
    //                      rather than as loaded
    // [data-plate]         a photograph: the frame rises, the picture inside
    //                      it settles from 1.06 to 1
    //
    // ONCE, AND ONLY ON THE WAY DOWN. once: true means nothing re-animates on
    // the way back up; a page that replays itself every time the reader
    // scrolls past is a page that will not let them re-read a sentence.
    // -----------------------------------------------------------------------

    job('reveals', function () {
        root.classList.add('is-revealing');

        gsap.utils.toArray('[data-reveal]').forEach(function (el) {
            if (!belowFold(el)) {
                return;
            }

            gsap.set(el, { opacity: 0, y: 22 });

            ScrollTrigger.create({
                trigger: el,
                start: 'top 88%',
                once: true,
                onEnter: function () {
                    gsap.to(el, { opacity: 1, y: 0, duration: 1.1, ease: EASE });
                }
            });
        });

        gsap.utils.toArray('[data-reveal-lines]').forEach(function (el) {
            if (!belowFold(el)) {
                return;
            }

            gsap.set(el, {
                opacity: 0,
                y: '30%',
                clipPath: 'inset(0% 0% 100% 0%)'
            });

            ScrollTrigger.create({
                trigger: el,
                start: 'top 86%',
                once: true,
                onEnter: function () {
                    gsap.to(el, {
                        opacity: 1,
                        y: '0%',
                        clipPath: 'inset(0% 0% 0% 0%)',
                        duration: 1.4,
                        ease: 'power3.out'
                    });
                }
            });
        });

        gsap.utils.toArray('[data-plate]').forEach(function (el) {
            if (!belowFold(el)) {
                return;
            }

            var picture = el.querySelector('img');

            gsap.set(el, { opacity: 0, y: 40 });

            if (picture) {
                gsap.set(picture, { scale: 1.06 });
            }

            ScrollTrigger.create({
                trigger: el,
                start: 'top 90%',
                once: true,
                onEnter: function () {
                    gsap.to(el, { opacity: 1, y: 0, duration: 1.25, ease: EASE });

                    if (picture) {
                        gsap.to(picture, { scale: 1, duration: 2.2, ease: 'power2.out' });
                    }
                }
            });
        });
    });


    // -----------------------------------------------------------------------
    // 5. The hero
    //
    // THE FILM IS FETCHED ONLY WHEN ALL THREE GATES OPEN: the viewport is wide
    // enough to be worth 3 MB, the connection is not metered, and the reader
    // has not asked for reduced motion — the third is already true or this
    // file would not be running. Below 900px the narrow encode is used, which
    // is a third of the bytes for a screen a third of the width.
    //
    // THE PARALLAX IS THE FILM MOVING SLOWER THAN THE PAGE, and nothing else.
    // The copy fades as it goes; the picture never scales, because scaling a
    // video on scroll is the effect that gives a cheap site away.
    // -----------------------------------------------------------------------

    job('hero', function () {
        var scene = document.querySelector('[data-hero-scene]');

        if (!scene) {
            return;
        }

        var film = scene.querySelector('[data-hero-film]');
        var copy = scene.querySelector('.c-film-hero__copy');

        if (film) {
            gsap.to(film, {
                yPercent: 14,
                ease: 'none',
                scrollTrigger: {
                    trigger: scene,
                    start: 'top top',
                    end: 'bottom top',
                    scrub: true
                }
            });
        }

        if (copy) {
            gsap.to(copy, {
                opacity: 0,
                y: -40,
                ease: 'none',
                scrollTrigger: {
                    trigger: scene,
                    start: 'top top',
                    end: '60% top',
                    scrub: true
                }
            });
        }

        attachHeroFilm(scene.querySelector('[data-hero-video]'));
    });

    function saveData() {
        var connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;

        return !!(connection && (connection.saveData ||
            /^(slow-)?2g$/.test(connection.effectiveType || '')));
    }

    function attachHeroFilm(video) {
        if (!video || saveData()) {
            return;
        }

        var wide = video.dataset.srcWide;
        var narrow = video.dataset.srcNarrow;
        var src = (innerWidth < 900 && narrow) ? narrow : wide;

        if (!src) {
            return;
        }

        play(video, src);
    }

    /**
     * Attach a source and play. The poster stays under it until the first real
     * frame is decoded, which is what 'playing' means and 'canplay' does not:
     * fading on canplay shows one black frame on a slow decoder.
     */
    function play(video, src) {
        if (video.dataset.attached === src) {
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
            // A browser that refuses to autoplay a muted video is a browser
            // whose reader keeps the poster. That is a complete first screen,
            // so there is nothing to report and nothing to retry.
            attempt.catch(function () {});
        }
    }

    function release(video) {
        if (!video.dataset.attached) {
            return;
        }

        video.pause();
        video.classList.remove('is-playing');
        video.removeAttribute('src');
        delete video.dataset.attached;
        video.load();
    }


    // -----------------------------------------------------------------------
    // 6. The bands
    //
    // FIVE SEQUENCES, AND A READER WHO STOPS HALFWAY HAS FETCHED TWO. Each
    // band's film is attached when the band is within a screen of the viewport
    // and released once it is two screens behind, so the page's video weight
    // is what is being looked at plus one, rather than all of it. The poster
    // is a complete band on its own the whole time.
    // -----------------------------------------------------------------------

    job('bands', function () {
        if (saveData()) {
            return;
        }

        gsap.utils.toArray('[data-band]').forEach(function (band) {
            var video = band.querySelector('[data-band-video]');

            if (!video || !video.dataset.src) {
                return;
            }

            ScrollTrigger.create({
                trigger: band,
                start: 'top bottom+=100%',
                end: 'bottom top-=100%',
                onEnter: function () { play(video, video.dataset.src); },
                onEnterBack: function () { play(video, video.dataset.src); },
                onLeave: function () { release(video); },
                onLeaveBack: function () { release(video); }
            });

            // A band that is off screen has no business decoding frames, even
            // while it is still attached.
            ScrollTrigger.create({
                trigger: band,
                start: 'top bottom',
                end: 'bottom top',
                onEnter: function () { if (video.dataset.attached) { video.play().catch(function () {}); } },
                onEnterBack: function () { if (video.dataset.attached) { video.play().catch(function () {}); } },
                onLeave: function () { video.pause(); },
                onLeaveBack: function () { video.pause(); }
            });
        });
    });


    // -----------------------------------------------------------------------
    // 7. Settling
    //
    // Fonts land after this file runs and a heading that reflows moves every
    // trigger below it. One refresh once the faces are ready is cheaper than
    // ScrollTrigger.refresh() on a resize observer, and it is the only refresh
    // this page needs.
    // -----------------------------------------------------------------------

    job('settling', function () {
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(function () { ScrollTrigger.refresh(); });
        }

        addEventListener('orientationchange', function () {
            setTimeout(function () { ScrollTrigger.refresh(); }, 200);
        });
    });
}());
