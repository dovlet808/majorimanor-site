/**
 * Majori Manor — main.js
 *
 * Five behaviours, and the page is complete without any of them:
 *
 *   1. the header's ground: transparent over a hero, solid once it is gone
 *   2. the mobile drawer: open, trap, close
 *   3. the lightbox: a gallery image, opened
 *   4. the forms: inline validation, and the conditional referral field
 *   5. the map: Leaflet, fetched only once somebody scrolls to it
 *
 * Nothing here is required to read the site or to follow a link. The script is
 * deferred, no library is loaded, and every element it touches is already in
 * the markup — see the .has-js note in templates/partials/head.php.
 *
 * NO ENGLISH IN THIS FILE. Every word the lightbox says comes off a data-
 * attribute printed by templates/components/gallery.php out of common.php,
 * because this file is served as written and has no way to reach t().
 *
 * Vanilla, no build step. It is served to the browser exactly as it is written
 * here, so it is written to be read.
 */

(function () {
    'use strict';

    // -----------------------------------------------------------------------
    // 0. Shared: focus, and the scroll lock
    // -----------------------------------------------------------------------

    /** Everything that can take focus, in document order. */
    var FOCUSABLE = [
        'a[href]',
        'button:not([disabled])',
        'input:not([disabled]):not([type="hidden"])',
        'select:not([disabled])',
        'textarea:not([disabled])',
        '[tabindex]:not([tabindex="-1"])'
    ].join(',');

    /**
     * The page, held still behind a panel.
     *
     * Two things lock it now — the drawer and the lightbox — so the position
     * is remembered here rather than in either of them. Nesting is counted:
     * opening the lightbox from inside the drawer and closing it again must
     * not hand the page back while the drawer is still open.
     */
    var scrollLock = (function () {
        var depth = 0;
        var scrollY = 0;

        return {
            on: function () {
                if (depth++ > 0) {
                    return;
                }

                scrollY = window.scrollY;
                document.body.style.top = -scrollY + 'px';
                document.body.classList.add('is-scroll-locked');
            },

            off: function () {
                if (depth === 0 || --depth > 0) {
                    return;
                }

                document.body.classList.remove('is-scroll-locked');
                document.body.style.top = '';

                // Instant, not smooth. html has scroll-behavior: smooth, and
                // putting the page back where it was is not a journey the
                // reader should watch — they never left.
                window.scrollTo({ top: scrollY, left: 0, behavior: 'instant' });
            }
        };
    }());

    /**
     * Keep Tab inside a container, wrapping at both ends.
     *
     * Focus that has escaped it entirely — the browser's own UI, a click
     * elsewhere — comes back to the first item rather than being left outside.
     */
    function trapTab(event, container, items) {
        if (event.key !== 'Tab' || items.length === 0) {
            return;
        }

        var first = items[0];
        var last = items[items.length - 1];

        if (event.shiftKey && (document.activeElement === first || !container.contains(document.activeElement))) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    }

    // -----------------------------------------------------------------------
    // 1. The header's ground
    // -----------------------------------------------------------------------

    /**
     * Over a hero the header is transparent; once roughly four fifths of the
     * hero has gone past the top of the window it takes the page's ground and
     * a hairline, and it gives them back on the way up.
     *
     * Four fifths rather than all of it: the change has to have happened by
     * the time the section below the hero arrives under the bar, not at the
     * moment it arrives.
     *
     * A page with no hero renders .is-solid in the markup and is not touched
     * here at all.
     */
    function headerGround() {
        var header = document.querySelector('.c-header[data-hero]');

        if (!header) {
            return;
        }

        // The hero is the first block inside <main>. Asking the element rather
        // than assuming 80vh keeps this correct for a hero that is not exactly
        // one screen tall.
        var hero = document.querySelector('main > *');
        var threshold = 0;
        var pending = false;

        function measure() {
            var height = (hero ? hero.offsetHeight : 0) || window.innerHeight;

            /*
               Four fifths of the hero — but only if the page is long enough to
               get there.

               Until the chapter blocks are built the home page is a hero and a
               footer, which is less than two screens: four fifths of the hero
               is further than the document can scroll, and the bar would still
               be transparent sitting over the footer. So the threshold is
               capped at the distance the page can actually travel, less the
               height of the bar itself, and the change always has somewhere to
               happen. Once there is content under the hero the first number is
               the smaller one and the cap stops mattering.
            */
            var travel = document.documentElement.scrollHeight
                - window.innerHeight
                - header.offsetHeight;

            threshold = Math.max(0, Math.min(0.8 * height, travel));
        }

        function apply() {
            pending = false;
            header.classList.toggle('is-solid', window.scrollY > threshold);
        }

        function onScroll() {
            if (!pending) {
                pending = true;
                window.requestAnimationFrame(apply);
            }
        }

        function onResize() {
            measure();
            apply();
        }

        measure();
        apply();

        window.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('resize', onResize);
    }

    // -----------------------------------------------------------------------
    // 2. The mobile drawer
    // -----------------------------------------------------------------------

    function drawer() {
        var toggle = document.querySelector('[data-drawer-toggle]');
        var panel = document.querySelector('[data-drawer]');
        var header = document.querySelector('.c-header');

        if (!toggle || !panel || !header) {
            return;
        }

        var isOpen = false;

        /*
           The trap is the whole <header>, not the panel.

           The button that closes the drawer is the button that opened it, and
           it sits in the header bar above the panel rather than inside it.
           Trapping inside the panel alone would put the close button out of
           reach of the Tab key, which is the one key that has to reach it.
        */
        function focusable() {
            return Array.prototype.filter.call(
                header.querySelectorAll(FOCUSABLE),
                function (element) {
                    // Skip what is hidden at this width — the horizontal
                    // navigation and the header's own MEMBERSHIP link are
                    // display: none below 1180px and must not be tabbed into.
                    return element.getClientRects().length > 0;
                }
            );
        }

        function onKeydown(event) {
            if (event.key === 'Escape') {
                event.preventDefault();
                close();

                return;
            }

            trapTab(event, header, focusable());
        }

        function open() {
            if (isOpen) {
                return;
            }

            isOpen = true;

            scrollLock.on();
            document.body.classList.add('is-drawer-open');

            panel.classList.add('is-open');
            toggle.setAttribute('aria-expanded', 'true');

            // Belt and braces for readers that navigate by swipe rather than
            // by Tab: the page behind the panel is not there while it is open.
            setInert(true);

            document.addEventListener('keydown', onKeydown);
        }

        function close(returnFocus) {
            if (!isOpen) {
                return;
            }

            isOpen = false;

            panel.classList.remove('is-open');
            toggle.setAttribute('aria-expanded', 'false');
            setInert(false);

            document.removeEventListener('keydown', onKeydown);

            document.body.classList.remove('is-drawer-open');
            scrollLock.off();

            // Focus goes back to the button that opened it, unless the drawer
            // is closing because the window grew and the button has gone.
            if (returnFocus !== false) {
                toggle.focus();
            }
        }

        /** Hide the rest of the page from assistive technology while open. */
        function setInert(on) {
            var regions = [document.getElementById('main'), document.querySelector('.c-footer')];

            regions.forEach(function (region) {
                if (!region) {
                    return;
                }

                if (on) {
                    region.setAttribute('inert', '');
                } else {
                    region.removeAttribute('inert');
                }
            });
        }

        toggle.addEventListener('click', function () {
            if (isOpen) {
                close();
            } else {
                open();
            }
        });

        /*
           Above 1180px the drawer and its button are display: none. A drawer
           left open across that line would take the whole page with it: the
           panel invisible, the body still fixed, the scroll still locked.

           This number is the twin of the max-width: 1179.98px block in
           main.css. Change one and you change both.
        */
        var wide = window.matchMedia('(min-width: 1180px)');
        var onWide = function (event) {
            if (event.matches) {
                close(false);
            }
        };

        if (typeof wide.addEventListener === 'function') {
            wide.addEventListener('change', onWide);
        } else if (typeof wide.addListener === 'function') {
            wide.addListener(onWide);   // Safari before 14
        }
    }

    // -----------------------------------------------------------------------
    // 3. The lightbox
    // -----------------------------------------------------------------------

    /**
     * A gallery image, opened.
     *
     * NOTHING IS IN THE MARKUP UNTIL SOMEBODY ASKS. The dialog is built on the
     * first open and reused after that, and the picture inside it is built
     * fresh each time an image is shown — so a gallery of twelve costs twelve
     * thumbnails and not one byte of full-size photography until a reader
     * clicks. That is the reason the sources are on the trigger as data-
     * attributes rather than in a hidden <img> waiting to be revealed.
     *
     * Without this script a gallery is still a grid of pictures. The trigger
     * is a <button>, so it does nothing rather than going somewhere broken.
     *
     * Keyboard, end to end: Enter or Space on the trigger opens it (a button
     * does that on its own), Left and Right move, Escape closes, Tab cannot
     * leave, and focus goes back to the exact thumbnail it came from.
     */
    function lightbox() {
        var galleries = document.querySelectorAll('[data-gallery]');

        if (galleries.length === 0) {
            return;
        }

        var root = null;      // the dialog, once it has been built
        var parts = null;     // its inner elements
        var items = [];       // the triggers of the gallery currently open
        var index = 0;
        var opener = null;    // the trigger to give focus back to
        var words = {};       // the labels of the gallery currently open

        // --- Building -------------------------------------------------------

        function build() {
            root = document.createElement('div');
            root.className = 'c-lightbox';
            root.setAttribute('role', 'dialog');
            root.setAttribute('aria-modal', 'true');
            root.hidden = true;

            /*
               data-part, not data-lb-*: the gallery already carries data-lb-
               attributes for the words it hands over, and one document holding
               both would mean [data-lb-close] matching a <ul> that has a label
               on it as well as the button that does the closing. These are the
               dialog's own internals and they are named as such.
            */
            root.innerHTML =
                '<div class="c-lightbox__bar">'
                + '<p class="c-lightbox__counter" data-part="counter"></p>'
                + '<button class="c-lightbox__button c-lightbox__close" type="button" data-part="close"></button>'
                + '</div>'
                + '<div class="c-lightbox__stage">'
                + '<button class="c-lightbox__button c-lightbox__prev" type="button" data-part="prev"></button>'
                + '<div class="c-lightbox__media">'
                + '<div class="c-lightbox__frame" data-part="frame"></div>'
                + '<p class="c-lightbox__caption" data-part="caption"></p>'
                + '</div>'
                + '<button class="c-lightbox__button c-lightbox__next" type="button" data-part="next"></button>'
                + '</div>';

            parts = {
                counter: root.querySelector('[data-part="counter"]'),
                caption: root.querySelector('[data-part="caption"]'),
                frame:   root.querySelector('[data-part="frame"]'),
                close:   root.querySelector('[data-part="close"]'),
                prev:    root.querySelector('[data-part="prev"]'),
                next:    root.querySelector('[data-part="next"]')
            };

            parts.close.addEventListener('click', close);
            parts.prev.addEventListener('click', function () { move(-1); });
            parts.next.addEventListener('click', function () { move(1); });

            // The backdrop is the ground the picture is standing on: a click
            // that lands on the dialog itself, or on the space around the
            // image, and not on any of the controls.
            root.addEventListener('click', function (event) {
                if (event.target === root || event.target === parts.frame
                    || event.target.classList.contains('c-lightbox__stage')
                    || event.target.classList.contains('c-lightbox__media')) {
                    close();
                }
            });

            addSwipe(root);

            document.body.appendChild(root);
        }

        /**
         * The picture, made now.
         *
         * With no file on disk this draws the same hatched box the page is
         * showing — a lightbox that opened onto nothing at all would read as a
         * broken lightbox rather than as missing photography.
         */
        function render() {
            var item = items[index];
            var ratio = item.getAttribute('data-lb-ratio') || '3/2';
            var srcset = item.getAttribute('data-lb-srcset') || '';
            var src = item.getAttribute('data-lb-src') || '';
            var webp = item.getAttribute('data-lb-webp') || '';
            var sizes = item.getAttribute('data-lb-sizes') || '92vw';
            var alt = item.getAttribute('data-lb-alt') || '';
            var note = item.getAttribute('data-lb-note') || '';

            var box = document.createElement('div');
            box.className = 'c-img';
            box.style.setProperty('--img-ratio', ratio.replace('/', ' / '));

            // The same ratio as a number, for the width calculation in the
            // stylesheet — see the note beside --img-ratio-n in helpers.php.
            var pair = ratio.split(/[/:]/);
            var number = parseFloat(pair[0]) / parseFloat(pair[1]);
            box.style.setProperty('--img-ratio-n', isFinite(number) && number > 0 ? String(number) : '1.5');

            if (src === '') {
                box.setAttribute('data-empty', '');
                box.setAttribute('aria-hidden', 'true');

                if (note !== '') {
                    box.innerHTML = '<span class="c-img__note"><span class="c-img__name"></span></span>';
                    box.querySelector('.c-img__name').textContent = note;
                }
            } else {
                var picture = document.createElement('picture');

                if (webp !== '') {
                    var source = document.createElement('source');
                    source.type = 'image/webp';
                    source.srcset = webp;
                    source.sizes = sizes;
                    picture.appendChild(source);
                }

                var image = document.createElement('img');
                image.src = src;

                if (srcset !== '') {
                    image.srcset = srcset;
                    image.sizes = sizes;
                }

                image.alt = alt;
                image.decoding = 'async';

                picture.appendChild(image);
                box.appendChild(picture);
            }

            parts.frame.innerHTML = '';
            parts.frame.appendChild(box);

            var caption = item.getAttribute('data-lb-caption') || '';
            parts.caption.textContent = caption;
            parts.caption.hidden = caption === '';

            parts.counter.textContent = (words.counter || '')
                .replace('{n}', String(index + 1))
                .replace('{total}', String(items.length));

            // One image: the arrows have nowhere to go, so they are not there.
            var many = items.length > 1;
            parts.prev.hidden = !many;
            parts.next.hidden = !many;

            // The dialog's accessible name follows the picture, so a reader
            // arriving in it is told what they have opened and not only that
            // a gallery is open. The gallery's own label is the fallback, and
            // gallery.php will not let a trigger exist with neither.
            root.setAttribute('aria-label', alt || caption || words.label);
        }

        // --- Moving ---------------------------------------------------------

        function move(step) {
            if (items.length < 2) {
                return;
            }

            index = (index + step + items.length) % items.length;
            render();
        }

        // --- Opening and closing ---------------------------------------------

        function focusables() {
            return Array.prototype.filter.call(
                root.querySelectorAll(FOCUSABLE),
                function (element) {
                    return element.getClientRects().length > 0;
                }
            );
        }

        function onKeydown(event) {
            if (event.key === 'Escape') {
                event.preventDefault();
                close();

                return;
            }

            if (event.key === 'ArrowLeft') {
                event.preventDefault();
                move(-1);

                return;
            }

            if (event.key === 'ArrowRight') {
                event.preventDefault();
                move(1);

                return;
            }

            trapTab(event, root, focusables());
        }

        function open(gallery, trigger) {
            if (!root) {
                build();
            }

            items = Array.prototype.slice.call(gallery.querySelectorAll('[data-lb-item]'));
            index = items.indexOf(trigger);
            opener = trigger;

            if (index < 0) {
                index = 0;
            }

            words = {
                label:   gallery.getAttribute('data-lb-label') || '',
                close:   gallery.getAttribute('data-lb-close') || '',
                prev:    gallery.getAttribute('data-lb-previous') || '',
                next:    gallery.getAttribute('data-lb-next') || '',
                counter: gallery.getAttribute('data-lb-counter') || ''
            };

            parts.close.setAttribute('aria-label', words.close);
            parts.prev.setAttribute('aria-label', words.prev);
            parts.next.setAttribute('aria-label', words.next);

            /*
               The ground. A section that sets its own temperature says so in
               a class, and the dialog takes the same one — so an image opened
               out of a night gallery opens into a wine room and one opened
               out of a day gallery into a cream one. §3 of main.css does the
               rest, and nothing here knows what colour any of that is.
            */
            var section = gallery.closest('.section--day, .section--dusk, .section--night');
            root.classList.remove('section--day', 'section--dusk', 'section--night');

            if (section) {
                ['section--day', 'section--dusk', 'section--night'].forEach(function (name) {
                    if (section.classList.contains(name)) {
                        root.classList.add(name);
                    }
                });
            }

            render();

            root.hidden = false;
            scrollLock.on();
            setInert(true);

            document.addEventListener('keydown', onKeydown);

            parts.close.focus();
        }

        function close() {
            if (!root || root.hidden) {
                return;
            }

            root.hidden = true;

            // Let go of the picture: an image element kept in a hidden dialog
            // is an image the browser is still holding on to.
            parts.frame.replaceChildren();

            document.removeEventListener('keydown', onKeydown);

            setInert(false);
            scrollLock.off();

            if (opener) {
                opener.focus();
                opener = null;
            }
        }

        /** Hide the rest of the page from assistive technology while open. */
        function setInert(on) {
            var regions = [
                document.getElementById('main'),
                document.querySelector('.c-header'),
                document.querySelector('.c-footer')
            ];

            regions.forEach(function (region) {
                if (!region) {
                    return;
                }

                if (on) {
                    region.setAttribute('inert', '');
                } else {
                    region.removeAttribute('inert');
                }
            });
        }

        // --- Swipe -----------------------------------------------------------

        /**
         * A horizontal drag moves between images.
         *
         * Horizontal by a clear margin, or it is a scroll and not a swipe:
         * a reader dragging up out of a tall picture should not find
         * themselves two images along.
         */
        function addSwipe(element) {
            var startX = 0;
            var startY = 0;
            var tracking = false;

            element.addEventListener('touchstart', function (event) {
                if (event.touches.length !== 1) {
                    tracking = false;

                    return;
                }

                tracking = true;
                startX = event.touches[0].clientX;
                startY = event.touches[0].clientY;
            }, { passive: true });

            element.addEventListener('touchend', function (event) {
                if (!tracking || event.changedTouches.length !== 1) {
                    return;
                }

                tracking = false;

                var dx = event.changedTouches[0].clientX - startX;
                var dy = event.changedTouches[0].clientY - startY;

                if (Math.abs(dx) < 44 || Math.abs(dx) < Math.abs(dy) * 1.5) {
                    return;
                }

                move(dx < 0 ? 1 : -1);
            }, { passive: true });
        }

        // --- Wiring ----------------------------------------------------------

        /*
           One listener per gallery rather than one per thumbnail, and the
           trigger is found from the event. A gallery rendered later — the
           components page renders several — needs no second pass.
        */
        Array.prototype.forEach.call(galleries, function (gallery) {
            gallery.addEventListener('click', function (event) {
                var trigger = event.target.closest('[data-lb-item]');

                if (trigger && gallery.contains(trigger)) {
                    open(gallery, trigger);
                }
            });
        });
    }

    // -----------------------------------------------------------------------
    // 4. Forms: inline validation, and the conditional field
    // -----------------------------------------------------------------------

    /**
     * THE FORM IS COMPLETE BEFORE THIS RUNS.
     *
     * It posts to its own page, the server validates it, and the server
     * renders the errors and the thank-you (see templates/components/
     * form-membership.php). Everything here is a second, earlier copy of a
     * check that has already been written on the other side of the wire, and
     * removing this function costs an applicant a round trip and nothing else.
     *
     * WHAT IT ADDS, AND THE LIST IS SHORT:
     *
     *   1. errors as you go, instead of after a page load
     *   2. the referral name field, collapsed until it is relevant
     *   3. focus onto the summary or the thank-you, for the browsers that
     *      ignore autofocus on a container
     *
     * NO ENGLISH, like the rest of this file. The two messages it can print
     * are on the form as data- attributes, put there by common.php through the
     * component, so this stays a script and never becomes a place copy lives.
     */
    function forms() {
        var form = document.querySelector('[data-form]');

        if (!form) {
            return;
        }

        var messages = {
            required: form.getAttribute('data-msg-required') || '',
            email: form.getAttribute('data-msg-email') || '',
            summary: form.getAttribute('data-msg-summary') || ''
        };

        /*
           The browser's own validation is switched off HERE and not in the
           markup, which means it is only off when this script is running. With
           no script the attributes in the markup do their ordinary job and the
           browser shows its own bubbles; with one, the same rules are checked
           below and the message is a sentence tied to the field instead of a
           tooltip that vanishes. Turning it off in the HTML would leave a
           no-script page with no client-side validation at all.
        */
        form.noValidate = true;

        // --- The conditional field -------------------------------------------

        /**
         * The referral name, and the control that reveals it.
         *
         * Rendered VISIBLE by the server, because without this script there is
         * nothing to open it and somebody referred by a member has to be able
         * to say who. So the first thing that happens here is closing it —
         * which is why the markup ships with aria-expanded="true": it is true
         * until this line runs.
         */
        function reveals() {
            var targets = form.querySelectorAll('[data-reveal-target]');

            Array.prototype.forEach.call(targets, function (target) {
                var controller = form.querySelector('[aria-controls="' + target.id + '"]');

                if (!controller) {
                    return;
                }

                // Every radio of that group, so a change to any of them is seen.
                var group = form.querySelectorAll('[name="' + controller.name + '"]');

                function sync() {
                    var open = controller.checked;

                    /*
                       hidden, not a class. It takes the field out of the
                       accessibility tree and out of the tab order in one
                       attribute; display:none by class does the same for a
                       sighted keyboard user only if somebody remembers to
                       write both rules, and a field that is invisible but
                       still tabbable is the worst of the three states.
                    */
                    target.hidden = !open;
                    controller.setAttribute('aria-expanded', open ? 'true' : 'false');

                    // A field nobody can see is not a field anybody can fix.
                    if (!open) {
                        clearError(target.querySelector('.c-form__control'));
                    }
                }

                Array.prototype.forEach.call(group, function (radio) {
                    radio.addEventListener('change', sync);
                });

                sync();
            });
        }

        // --- Errors on one field ---------------------------------------------

        /** The message element for a control, made only when there is one to say. */
        function errorFor(control, create) {
            var id = control.id + '-error';
            var node = document.getElementById(id);

            if (!node && create) {
                node = document.createElement('p');
                node.className = 'c-form__error';
                node.id = id;
                control.parentNode.appendChild(node);
            }

            return node;
        }

        /**
         * aria-describedby, with the error id added or removed and anything
         * else on it left alone.
         *
         * The textarea's hint is also on that attribute, and a field that
         * announced its error by dropping its hint would have traded one for
         * the other.
         */
        function describedBy(control, id, on) {
            var ids = (control.getAttribute('aria-describedby') || '')
                .split(/\s+/)
                .filter(function (value) { return value && value !== id; });

            if (on) {
                ids.push(id);
            }

            if (ids.length) {
                control.setAttribute('aria-describedby', ids.join(' '));
            } else {
                control.removeAttribute('aria-describedby');
            }
        }

        function clearError(control) {
            if (!control) {
                return;
            }

            var node = errorFor(control, false);

            if (node) {
                node.parentNode.removeChild(node);
            }

            control.removeAttribute('aria-invalid');
            describedBy(control, control.id + '-error', false);
        }

        function showError(control, message) {
            var node = errorFor(control, true);

            node.textContent = message;
            control.setAttribute('aria-invalid', 'true');
            describedBy(control, node.id, true);
        }

        // --- What counts as wrong --------------------------------------------

        /**
         * The same three rules the server applies, in the same order, and
         * deliberately no more than that. Length is left to maxlength, which
         * the browser enforces as somebody types; the server still measures it,
         * because maxlength is a suggestion to anything that is not a browser.
         *
         * Returns the message, or '' when the field is fine.
         */
        function problem(control) {
            var value = (control.value || '').trim();

            // A field inside a collapsed reveal is not on the form right now.
            if (control.closest('[hidden]')) {
                return '';
            }

            /*
               Required by the markup, or required by the answer above it: the
               member's name is only asked for once Yes has been chosen, which
               is a rule about two fields and cannot be an attribute on one.
            */
            var required = control.required
                || (control.closest('[data-reveal-target]') !== null && !control.closest('[hidden]'));

            if (required && value === '') {
                return messages.required;
            }

            if (value !== '' && control.type === 'email' && !isEmail(value)) {
                return messages.email;
            }

            return '';
        }

        /*
           Deliberately loose, and the server's filter_var is the one that
           decides. Something with an @ in the middle and a dot after it is as
           far as a browser-side check should go: every stricter regular
           expression anybody writes rejects a real address somebody owns.
        */
        function isEmail(value) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
        }

        function check(control) {
            var message = problem(control);

            if (message) {
                showError(control, message);
            } else {
                clearError(control);
            }

            return !message;
        }

        // --- The summary ------------------------------------------------------

        /**
         * Built here only when the server has not already put one on the page,
         * and to the same shape, so the two are one component and not two.
         *
         * No role="alert", exactly as the server's own summary carries none:
         * it is focused a few lines below, focus is what makes a screen reader
         * read it, and an alert role on the same element asks several readers
         * to announce the whole block twice. See the note beside $hasSummary
         * in templates/partials/form.php.
         */
        function summaryFor(fields) {
            var summary = form.parentNode.querySelector('.c-form__summary');

            if (!summary) {
                summary = document.createElement('div');
                summary.className = 'c-form__summary';
                summary.setAttribute('tabindex', '-1');
                form.parentNode.insertBefore(summary, form);
            }

            summary.textContent = '';

            var title = document.createElement('p');
            title.className = 'c-form__summary-title';
            title.textContent = messages.summary;
            summary.appendChild(title);

            var list = document.createElement('ul');
            list.className = 'c-form__summary-list';

            fields.forEach(function (control) {
                var item = document.createElement('li');
                var link = document.createElement('a');

                link.href = '#' + control.id;

                /*
                   The field's own label, read off the page. Taking it from the
                   DOM rather than from a table in here is what keeps this file
                   free of English and correct in Latvian the day it arrives.
                */
                var label = form.querySelector('label[for="' + control.id + '"]');
                var legend = control.closest('fieldset')
                    ? control.closest('fieldset').querySelector('legend')
                    : null;
                var source = label || legend;

                link.textContent = source ? source.textContent.replace('*', '').trim() : control.name;

                var note = document.createElement('span');
                var node = errorFor(control, false);
                note.textContent = node ? node.textContent : '';

                item.appendChild(link);
                item.appendChild(note);
                list.appendChild(item);
            });

            summary.appendChild(list);

            return summary;
        }

        // --- Wiring -----------------------------------------------------------

        var controls = form.querySelectorAll('.c-form__control');

        Array.prototype.forEach.call(controls, function (control) {
            /*
               Checked when the field is left, not while it is being typed in:
               telling somebody their email address is invalid at "i" is an
               argument with a person halfway through answering.

               Once a field IS marked wrong it is re-checked on every keystroke,
               so the message goes the moment it stops being true rather than
               waiting for them to leave the field again.
            */
            control.addEventListener('blur', function () {
                check(control);
            });

            control.addEventListener('input', function () {
                if (control.getAttribute('aria-invalid') === 'true') {
                    check(control);
                }
            });
        });

        form.addEventListener('submit', function (event) {
            var failed = [];

            Array.prototype.forEach.call(controls, function (control) {
                if (!check(control)) {
                    failed.push(control);
                }
            });

            if (!failed.length) {
                return;   // let it post, exactly as it would with no script
            }

            event.preventDefault();

            var summary = summaryFor(failed);

            summary.focus();
            summary.scrollIntoView({ block: 'start', behavior: 'smooth' });
        });

        reveals();
    }

    /**
     * Focus what the server has just rendered — the error summary, or the
     * thank-you standing where the form was.
     *
     * Both carry autofocus in the markup, which is what does this job with no
     * script at all. Not every browser honours autofocus on a container rather
     * than on a control, so it is done again here; focusing something that is
     * already focused costs nothing.
     */
    function formFocus() {
        var target = document.querySelector('[data-form-focus]');

        if (target) {
            target.focus();
        }
    }

    // -----------------------------------------------------------------------
    // 5. The map
    // -----------------------------------------------------------------------

    /**
     * Leaflet, loaded when the reader arrives at the frame and not before.
     *
     * WHAT IS ON THE PAGE BEFORE THIS RUNS IS THE ADDRESS, set inside the
     * frame — see templates/components/map.php. This function replaces it with
     * a map; it does not create the answer to the question, it upgrades it. So
     * every failure below is silent on purpose: no script, a blocked CDN-less
     * asset, a tile host that is down, a browser without IntersectionObserver
     * that never reaches boot() — in each case the placeholder stays, and the
     * page still says where Majori Manor is.
     *
     * ABOUT 160 KB OF LIBRARY AND A DOZEN TILE REQUESTS, AND NONE OF IT IS
     * FETCHED UNTIL IT IS WANTED. On a contact page the map is most of the
     * weight and the least of the reason anybody came, and the tiles are the
     * one request this site makes to a third party. A reader who does not
     * scroll that far makes none.
     *
     * NO URL, NO COORDINATE AND NO WORD OF ENGLISH IN HERE. All of it is read
     * off the frame's data- attributes, which the component printed out of the
     * content file — the same arrangement the lightbox uses for its labels.
     */
    function map() {
        var frame = document.querySelector('[data-map]');

        if (!frame) {
            return;
        }

        var canvas = frame.querySelector('[data-map-canvas]');

        if (!canvas) {
            return;
        }

        var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        function attr(name) {
            return frame.getAttribute('data-map-' + name) || '';
        }

        function build() {
            if (!window.L) {
                return;   // the placeholder is still standing; leave it there
            }

            var lat = parseFloat(attr('lat'));
            var lng = parseFloat(attr('lng'));
            var zoom = parseInt(attr('zoom'), 10);

            if (!isFinite(lat) || !isFinite(lng)) {
                return;
            }

            var view = window.L.map(canvas, {
                center: [lat, lng],
                zoom: isFinite(zoom) ? zoom : 16,

                /*
                   A page scroll must never turn into a map zoom. The wheel is
                   armed by clicking or focusing the map and disarmed on the
                   way out; dragging and the +/- control work throughout, so
                   the wheel is never the only way to zoom.
                */
                scrollWheelZoom: false,

                zoomAnimation: !reduced,
                fadeAnimation: !reduced,
                markerZoomAnimation: !reduced,

                /*
                   NO ATTRIBUTION CONTROL INSIDE THE CANVAS, AND THE CREDIT IS
                   NOT BEING DROPPED. OpenStreetMap's data is ODbL and CARTO's
                   terms require theirs; both are printed under the frame by
                   templates/components/map.php, on the line that carries the
                   coordinates, and revealed by the stylesheet the moment
                   data-map-ready is set below. Leaflet's own prefix goes with
                   the control — that one is the library crediting itself and
                   is not a licence condition.

                   What this buys is a map that reads as a figure on the page
                   rather than an embedded widget, which is the whole of the
                   argument: the plate in the corner is the thing that makes it
                   look like somebody else's software.
                */
                attributionControl: false
            });

            view.on('click focus', function () { view.scrollWheelZoom.enable(); });
            view.on('mouseout blur', function () { view.scrollWheelZoom.disable(); });

            // No 'attribution' option: there is no control to put it in, and
            // the credit is in the markup under the frame. See above.
            window.L.tileLayer(attr('tiles'), {
                subdomains: attr('subdomains') || 'abc',
                maxZoom: 20
            }).addTo(view);

            /*
               A divIcon, not the default PNG pin: the colour is the brand's
               and it costs no request. keyboard: false keeps it out of the tab
               order — it opens nothing, and the address it would repeat is
               already on the page as text.
            */
            window.L.marker([lat, lng], {
                icon: window.L.divIcon({
                    className: 'c-map__pin',
                    iconSize: [16, 16],
                    iconAnchor: [8, 8]
                }),
                keyboard: false
            }).addTo(view);

            /*
               The frame said role="img" while it was a picture of an address.
               It is now a live map with its own controls inside it, so the
               label and the role come off rather than describing something
               that is no longer there.
            */
            frame.removeAttribute('role');
            frame.removeAttribute('aria-label');
            frame.setAttribute('data-map-ready', '');

            // The frame was laid out before the map existed; make Leaflet
            // measure it now that there is something in it.
            view.whenReady(function () { view.invalidateSize(); });
        }

        /** Stylesheet and script together; build once both have landed. */
        var booted = false;

        function boot() {
            if (booted) {
                return;
            }

            booted = true;

            var pending = 2;

            function ready() {
                if (--pending === 0) {
                    build();
                }
            }

            var link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = attr('css');
            link.onload = ready;
            link.onerror = function () { pending = -1; };   // placeholder stays
            document.head.appendChild(link);

            var script = document.createElement('script');
            script.src = attr('js');
            script.defer = true;
            script.onload = ready;
            script.onerror = function () { pending = -1; };
            document.head.appendChild(script);
        }

        if (!('IntersectionObserver' in window)) {
            boot();

            return;
        }

        var observer = new IntersectionObserver(function (entries, self) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) {
                    return;
                }

                self.unobserve(entry.target);
                boot();
            });
        }, {
            // Start just before the frame arrives, so it is warm on entry and
            // the reader does not watch it assemble.
            rootMargin: '200px 0px'
        });

        observer.observe(frame);
    }

    // -----------------------------------------------------------------------

    headerGround();
    drawer();
    lightbox();
    forms();
    formFocus();
    map();
}());
