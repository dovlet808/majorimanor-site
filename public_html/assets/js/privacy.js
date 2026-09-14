/**
 * Majori Manor — /privacy
 *
 * THE ONLY PAGE ON THIS SITE THAT LOADS NO MOTION LIBRARY, AND THAT IS THE
 * BRIEF RATHER THAN AN OMISSION. "Keep the page lightweight… lightweight JS."
 * "The privacy page is primarily a reading experience." The nine film pages
 * fetch GSAP, ScrollTrigger, Lenis and home.js — about 50 KB of animation — to
 * drive scroll choreography that this page has none of. So this file replaces
 * all four of them and comes to a fifth of the size, and it does it by doing
 * only the four things the chrome actually needs:
 *
 *   1. compact     the bar goes solid once the hero has gone
 *   2. menu        the sheet below 900px opens and closes
 *   3. hero        the sequence is attached, once, if it is welcome
 *   4. index       the clause the reader is in is marked in the contents
 *
 * IT IS LOADED UNCONDITIONALLY AND head.php's MOTION BLOCK IS NOT RUN FOR THIS
 * PAGE, WHICH FIXES SOMETHING AS WELL AS SAVING SOMETHING. On a film page the
 * whole script layer sits behind a prefers-reduced-motion check, so a reader
 * who has asked for less motion gets no home.js — and therefore, below 900px,
 * a menu button that does nothing. On a legal page that is not a trade worth
 * making: this file is a plain deferred <script> that always runs, and the one
 * thing inside it that is motion — the hero sequence — checks for itself.
 *
 * NOTHING HERE IS REQUIRED FOR THE PAGE TO WORK. With this file blocked or
 * switched off: the bar renders solid (privacy.css §10 has a rule for exactly
 * that, because cream links on a cream document would otherwise be cream links
 * on a cream document), the navigation is a wrapped row rather than a sheet,
 * every link in it still works, the hero is its
 * poster, the index is a table of contents and every anchor in it still works,
 * and the whole policy is on the page. The brief's rule — "All legal text must
 * remain visible with JavaScript OFF" — is met by not asking this file to
 * reveal anything, ever.
 */
(function () {
    'use strict';

    var root = document.documentElement;

    var reduced = window.matchMedia
        ? matchMedia('(prefers-reduced-motion: reduce)')
        : { matches: false };


    // -----------------------------------------------------------------------
    // 1. The bar
    //
    // Over the hero it is a hairline of cream type on a photograph; past it,
    // a solid bar with a rule under it. home.js does this with a ScrollTrigger
    // at 'bottom top+=80'; an IntersectionObserver with the same 80px margin
    // is the same boundary and costs no library — and, unlike a scroll
    // handler, it runs when the edge is crossed rather than on every frame.
    // -----------------------------------------------------------------------

    (function bar() {
        var nav = document.querySelector('[data-film-nav]');
        var hero = document.querySelector('[data-hero-scene]');

        if (!nav || !hero || !('IntersectionObserver' in window)) {
            return;
        }

        new IntersectionObserver(function (entries) {
            nav.classList.toggle('is-compact', !entries[0].isIntersecting);
        }, { rootMargin: '-80px 0px 0px 0px', threshold: 0 }).observe(hero);
    }());


    // -----------------------------------------------------------------------
    // 2. The sheet
    //
    // home.js's navigation job with the GSAP taken out. The sheet opens
    // instantly rather than fading and staggering its seven links in, which is
    // one fewer thing to switch off for a reader who has asked for less motion
    // and is not a loss on a page whose navigation is not the subject.
    //
    // Escape closes it and returns the focus to the button that opened it,
    // because that is the only place a keyboard reader can sensibly be left.
    // -----------------------------------------------------------------------

    (function sheet() {
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

            menu.hidden = !open;
        }

        toggle.addEventListener('click', function () { setMenu(!open); });

        menu.addEventListener('click', function (event) {
            if (event.target.closest('[data-film-menu-link]')) {
                setMenu(false);
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && open) {
                setMenu(false);
                toggle.focus();
            }
        });

        // A width change while the sheet is open would otherwise leave the
        // scroll locked behind a menu that is no longer displayed.
        if (window.matchMedia) {
            matchMedia('(min-width: 900px)').addEventListener('change', function (event) {
                if (event.matches && open) {
                    setMenu(false);
                }
            });
        }
    }());


    // -----------------------------------------------------------------------
    // 3. The hero sequence
    //
    // THE POSTER IS THE HERO AND THE FILM IS AN ADDITION TO IT. The <video>
    // ships with no src at all; this attaches one after the load event, so the
    // document, the type and the photograph are painted and readable before a
    // byte of video is asked for.
    //
    // THREE GATES, AND THEY ARE home.js's OWN. Reduced motion — checked here
    // rather than in head.php, because on this page the rest of the script
    // still has work to do. A metered or 2G connection. And the width, which
    // decides which of the two encodes is worth fetching: 279 KB below 900px
    // against 748 KB above it.
    // -----------------------------------------------------------------------

    (function hero() {
        var video = document.querySelector('[data-hero-video]');

        if (!video || reduced.matches) {
            return;
        }

        var connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;

        if (connection && (connection.saveData ||
            /^(slow-)?2g$/.test(connection.effectiveType || ''))) {
            return;
        }

        function attach() {
            var narrow = video.dataset.srcNarrow;
            var src = (innerWidth < 900 && narrow) ? narrow : video.dataset.srcWide;

            if (!src) {
                return;
            }

            video.src = src;
            video.load();

            // 'playing' and not 'canplay': fading on canplay shows one black
            // frame on a slow decoder.
            video.addEventListener('playing', function () {
                video.classList.add('is-playing');
            }, { once: true });

            var attempt = video.play();

            if (attempt && attempt.catch) {
                // A browser that refuses to autoplay a muted video is a
                // browser whose reader keeps the poster, which is a complete
                // first screen. Nothing to report and nothing to retry.
                attempt.catch(function () {});
            }
        }

        if (document.readyState === 'complete') {
            attach();
        } else {
            addEventListener('load', attach, { once: true });
        }
    }());


    // -----------------------------------------------------------------------
    // 4. The clause the reader is in
    //
    // The one enhancement that belongs to the document rather than to the
    // chrome, and the page is finished without it. It never sets a style,
    // never adds a class to a clause and never touches the policy at all: it
    // adds .is-current to a link in the contents and takes it off again.
    //
    // THE BAND IS A LINE AND NOT A WINDOW, AND THE FIRST VERSION WAS A WINDOW.
    // With a band 15% of the viewport tall, clicking a short clause marked the
    // NEXT one: land on "What this covers", and "Who is responsible" — which
    // begins 180px lower — is inside the band too and, being later in document
    // order, takes the mark. Measured, on two of the twelve.
    //
    // So the band is 2% tall and sits a quarter of the way down the window,
    // which is a line rather than a region: the current clause is the one that
    // line is standing in. The clauses tile continuously (each one's space is
    // its own top padding), so the line is always inside exactly one of them,
    // and the mark changes when a heading's rule passes a quarter of the way
    // up the screen — which is where a reader has moved on to it.
    // -----------------------------------------------------------------------

    (function contents() {
        var nav = document.querySelector('[data-legal-index]');

        if (!nav || !('IntersectionObserver' in window)) {
            return;
        }

        var links = {};
        var order = [];

        Array.prototype.forEach.call(
            nav.querySelectorAll('[data-legal-index-link]'),
            function (link) {
                var id = (link.getAttribute('href') || '').slice(1);

                if (!id || !document.getElementById(id)) {
                    return;
                }

                links[id] = link;
                order.push(id);
            }
        );

        if (order.length === 0) {
            return;
        }

        var current = '';
        var visible = {};

        function mark(id) {
            if (id === current) {
                return;
            }

            if (current && links[current]) {
                links[current].classList.remove('is-current');
                links[current].removeAttribute('aria-current');
            }

            current = id;

            if (id && links[id]) {
                links[id].classList.add('is-current');

                // 'true' and not 'page': the reader is not on a different
                // page, they are in a different part of this one.
                // aria-current="page" is the site navigation's word, and
                // film-nav.php owns it.
                links[id].setAttribute('aria-current', 'true');
            }
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                visible[entry.target.id] = entry.isIntersecting;
            });

            // THE LAST ONE IN DOCUMENT ORDER, NOT THE FIRST, AND THE REASON IS
            // THE NESTING. A sub-clause lives inside its parent <section>, so
            // whenever "The membership application" is in the band so is "What
            // the site collects" — and taking the first match would mark the
            // parent for the whole of both sub-clauses. Taking the last one
            // marks the deepest thing the reader is actually inside, and on
            // the boundary between two ordinary clauses it hands the mark to
            // the one arriving, which is the one being read.
            for (var i = order.length - 1; i >= 0; i--) {
                if (visible[order[i]]) {
                    mark(order[i]);
                    return;
                }
            }
        }, {
            rootMargin: '-24% 0px -74% 0px',
            threshold: 0
        });

        order.forEach(function (id) {
            observer.observe(document.getElementById(id));
        });
    }());
}());
