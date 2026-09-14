<?php
/**
 * Document head.
 *
 * Titles and descriptions come from $c['meta'], with the defaults in
 * common.php covering pages whose content is not written yet.
 * The canonical URL is built from routes.php — never written by hand.
 *
 * No hreflang while only one language is active; it goes in when LANGS grows.
 *
 * Nothing here is fetched from a third party: the stylesheet, the fonts it
 * declares and the one script are all served from assets/. No Google Fonts,
 * no CDN, no analytics.
 *
 * @var array $c
 */

declare(strict_types=1);

$title       = $c['meta']['title']       ?? t('meta.default_title');
$description = $c['meta']['description'] ?? t('meta.default_description');

// The 404 and the DEV-only pages are never offered to a crawler.
$noIndex = current_page() === '404' || in_array(current_page(), DEV_ONLY_PAGES, true);

// Structured data, from $c['jsonld'] — see jsonld() in helpers.php. Empty on
// every page that has not declared any, and on every page a crawler is being
// told to leave alone: describing a page in a graph and asking for it not to
// be indexed are two instructions that contradict each other.
$jsonld = $noIndex ? '' : jsonld();

// Cache-busted by each file's own mtime, so a deploy invalidates it and nothing
// else has to be remembered.
$cssHref = asset_url('/assets/css/main.css');
$jsHref  = asset_url('/assets/js/main.js');

/**
 * The two variable faces, preloaded.
 *
 * The href has to match the URL main.css asks for character for character or
 * the browser downloads the file twice. main.css uses ../fonts/<name> from
 * /assets/css/, which resolves to exactly these paths.
 *
 * No ?v= here on purpose: a preload and the @font-face src must agree, and a
 * font file is replaced by name, not edited.
 */
$fonts = [
    '/assets/fonts/playfairdisplay-var-latinext.woff2',
    '/assets/fonts/inter-var-latinext.woff2',
];
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php /*
        The one piece of script that cannot be deferred.

        Two things in the chrome are only correct when JavaScript is going to
        run: the header is transparent over a hero because something will make
        it solid again on scroll, and the navigation collapses into a drawer
        because something can open it. Both are wrong on a page where the
        script never arrives.

        Setting the flag here, synchronously and before the stylesheet is
        applied, means CSS decides once and the page never flashes from one
        state into the other. Without JS the class is absent, the header is
        solid everywhere and the navigation stays on screen at every width.
    */ ?>
    <script>document.documentElement.classList.add('has-js');</script>

    <title><?= e($title) ?></title>
    <meta name="description" content="<?= e($description) ?>">

<?php if ($noIndex): ?>
    <meta name="robots" content="noindex, follow">
<?php else: ?>
    <link rel="canonical" href="<?= e(SITE_URL . url(current_page())) ?>">
<?php endif; ?>

    <?php /*
        Icons, in the order browsers are documented to resolve them.

        Four entries cover everything current, and the order matters because a
        browser takes the LAST declaration it understands:

          1. favicon.ico   the legacy fallback, and the only one some feed
                           readers and old Safari builds will look at. It sits
                           at the document root as well as being declared here,
                           because a browser asks for /favicon.ico on its own
                           before it has parsed any markup. 16, 32 and 48 in
                           the one file — and not the same drawing in all
                           three, see below.
          2. favicon.svg   what every current browser actually uses, at the
                           size of a tab.
          3. apple-touch   iOS home screen, 180x180 and deliberately opaque.
          4. manifest      Android / installed-PWA icons, including the
                           maskable one.

        TWO MARKS, AND THE SIZES ARE SPLIT BETWEEN THEM. The club seal is
        legible from 48px up; below that its rings close and it reads as a grey
        disc. So the small sizes carry the monogram instead — the 16 and 32
        layers of the .ico, and favicon.svg, which a browser draws in a tab at
        around 16px and therefore follows the same rule. 48 and up, and every
        icon in the manifest, are the seal. Neither is a placeholder for the
        other: tools/brand/README.md has the measurements.

        theme-color paints the browser chrome around the page — the Android
        address bar, the iOS status area in a standalone window. It is the
        brand green, which is also background_color's opposite number in the
        manifest: green chrome, cream page.
    */ ?>
    <link rel="icon" href="<?= e(asset_url('/favicon.ico')) ?>" sizes="32x32">
    <link rel="icon" href="<?= e(asset_url('/assets/img/brand/favicon.svg')) ?>" type="image/svg+xml">
    <link rel="apple-touch-icon" href="<?= e(asset_url('/assets/img/brand/apple-touch-icon.png')) ?>">
    <link rel="manifest" href="<?= e(asset_url('/site.webmanifest')) ?>">
    <meta name="theme-color" content="#1A4438">

<?php foreach ($fonts as $font): ?>
    <link rel="preload" as="font" type="font/woff2" href="<?= e($font) ?>" crossorigin>
<?php endforeach; ?>

    <link rel="stylesheet" href="<?= e($cssHref) ?>">

    <?php /*
        Deferred: the page is readable and every link works before it runs.
        Its whole job is the header's scroll state and the mobile drawer.
    */ ?>
    <script src="<?= e($jsHref) ?>" defer></script>
<?php
/*
   THE PAGES THAT RUN THE CINEMATIC LAYER, AND WHAT EACH ADDS TO IT.

   home.css and home.js are the design system of the film — the tokens, the
   type, the navigation, the hero, the bands, the plates, the invitation, the
   footer and the seven motion jobs. THE ESTATE is the second page cut from it
   and it loads exactly the same two files, so the two pages cannot drift: a
   token edited in home.css moves both, which is the point of the table below
   rather than of a copy.

   A PAGE MAY ADD TO THE SYSTEM AND MAY NOT FORK IT. What /the-estate adds is
   estate.css and estate.js, and all they contain is the two components the
   Main Page has no use for — the walk and the ledger — plus the grounds of its
   six acts. Everything else it draws, it draws with home.css.

   THE HOME PAGE'S MARKUP IS UNCHANGED BY THIS. Its row adds no file, so the
   stylesheet link and the four sources below are byte for byte what they were
   when this block read current_page() === 'home'.
*/
$filmPages = [
    'home'   => ['css' => [],                        'js' => []],
    'estate' => ['css' => ['/assets/css/estate.css'], 'js' => ['/assets/js/estate.js']],

    /*
       THE CLUB LOADS THE ESTATE'S FILES AND THEN ITS OWN, and the order is the
       whole design. estate.css is not "the estate page's stylesheet"; it is the
       second layer of the film — the acts, the sticky walk and the ledger — and
       THE CLUB is a page of acts with a walk in it. Copying those three into a
       third file is how two pages that are meant to be the same house start
       drifting apart, and a rename is not available: asset_url() cache-busts on
       filemtime, so touching either estate file at all would re-version the
       stylesheet in the approved page's markup.

       club.css and club.js hold only what neither page before it needed: the
       lateral track, the dialogue, and this page's own crops.
    */
    'club'   => [
        'css' => ['/assets/css/estate.css', '/assets/css/club.css'],
        'js'  => ['/assets/js/estate.js',   '/assets/js/club.js'],
    ],

    /*
       PADEL LOADS THE ESTATE'S FILES AND THEN ITS OWN, for THE CLUB's reason
       and one of its own. It is a page of acts, so it needs estate.css §1; it
       is the second page to set the ledger, so it needs §3 and estate.js's
       ledger job; and it is the first page whose bar can point at itself
       without also being the page that introduced that rule, which lives in
       estate.css §1c.

       IT DOES NOT USE THE WALK, and estate.css §2 is therefore about three
       hundred lines this page never draws. That is the price of not forking a
       shared file — asset_url() cache-busts on filemtime, so splitting the acts
       out of estate.css would re-version the stylesheet in two approved pages'
       markup to save bytes that are already in the reader's cache from them.
       estate.js's walk job returns on its first line when there is no
       [data-walk] on the page, so nothing runs either.

       padel.css and padel.js hold only what no page before it needed: the plan
       lit for a dark ground, and the one line of it drawn as the reader
       arrives.
    */
    'padel'  => [
        'css' => ['/assets/css/estate.css', '/assets/css/padel.css'],
        'js'  => ['/assets/js/estate.js',   '/assets/js/padel.js'],
    ],

    /*
       EVENTS LOADS THREE LAYERS AND THEN ITS OWN, AND IT IS THE FIRST PAGE TO
       NEED THE THIRD.

       estate.css/js for the acts and the ledger, exactly as THE CLUB and PADEL
       take them. club.css/js for THE DIALOGUE — the six evenings on this page
       are six rooms standing behind one list of names, and that component,
       that stylesheet section and that motion job are THE CLUB's. Copying any
       of the three into a fifth file is how two pages meant to be the same
       house start drifting apart, and a rename is not available: asset_url()
       cache-busts on filemtime, so touching either shared file at all would
       re-version the stylesheet in two approved pages' markup.

       WHAT THAT COSTS, STATED RATHER THAN HIDDEN. This page draws no walk and
       no lateral track, so estate.css §2 and club.css §2 — about five hundred
       lines between them — match nothing here, and both jobs return on their
       first line because neither [data-walk] nor [data-detail] is in the DOM.
       That is the price of not forking a shared file and it is still the right
       price, for the reason PADEL's row gives: the bytes are already in the
       reader's cache from the pages that do use them. docs/EVENTS.md §8 carries
       the number.

       events.css and events.js hold only what no page before it needed: the
       hero's own scrim over a lit dome, the dialogue lit for six rooms rather
       than four, this page's mobile crops, and one motion job — the camera on
       the two bands that are photographs.
    */
    'events' => [
        'css' => ['/assets/css/estate.css', '/assets/css/club.css', '/assets/css/events.css'],
        'js'  => ['/assets/js/estate.js',   '/assets/js/club.js',   '/assets/js/events.js'],
    ],

    /*
       RESIDENCES TAKES THE SAME THREE LAYERS EVENTS TAKES, AND FOR THE SAME
       REASONS PLUS ONE MORE.

       estate.css/js for the acts, exactly as THE CLUB, PADEL and EVENTS take
       them. club.css/js for TWO of its components rather than one: this is the
       second page to set the lateral DETAIL TRACK — six close frames of the
       real house, panned by scroll — and the third to set the DIALOGUE, which
       here carries the three kinds of residence. Both of those, their
       stylesheet sections and their motion jobs are THE CLUB's, and copying any
       of them into a sixth file is how two pages meant to be the same house
       start drifting apart. A rename is not available either: asset_url()
       cache-busts on filemtime, so touching any shared file at all would
       re-version the stylesheet in three approved pages' markup.

       WHAT THAT COSTS, STATED RATHER THAN HIDDEN. This page draws no walk and
       no ledger, so estate.css §2 and §3 — about three hundred and fifty lines
       — match nothing here, and both of those jobs return on their first line
       because neither [data-walk] nor [data-ledger-row] is in the DOM. That is
       the price of not forking a shared file and it is still the right price,
       for the reason PADEL's row gives: the bytes are already in the reader's
       cache from the pages that do use them. docs/RESIDENCES.md §8 carries the
       number.

       residences.css and residences.js hold only what no page before it needed:
       one new act ground for the morning, this page's own hero scrim over a
       lit corridor, the dialogue lit for three rooms rather than four or six,
       this page's mobile crops, and one motion job — the camera on the two
       bands that are photographs.
    */
    'residences' => [
        'css' => ['/assets/css/estate.css', '/assets/css/club.css', '/assets/css/residences.css'],
        'js'  => ['/assets/js/estate.js',   '/assets/js/club.js',   '/assets/js/residences.js'],
    ],

    /*
       AFTER DARK TAKES THE SAME THREE LAYERS RESIDENCES TAKES, AND FOR TWO OF
       THE SAME REASONS.

       estate.css/js for the acts, exactly as THE CLUB, PADEL, EVENTS and
       RESIDENCES take them — and this page moves through more of them than any
       other, six or seven depending on one flag. club.css/js for ONE of its two
       components: the lateral DETAIL TRACK, six close frames of the room panned
       by scroll, which is THE CLUB's and is this page's scene 03. It does NOT
       take the dialogue, and it is the first page since THE CLUB to load that
       file for one job rather than two.

       WHAT THAT COSTS, STATED RATHER THAN HIDDEN. This page draws no walk, no
       ledger and no dialogue, so estate.css §2 and §3 and club.css §3 — about
       six hundred lines between them — match nothing here, and all three motion
       jobs return on their first line because none of [data-walk],
       [data-ledger-row] or [data-dialogue] is in the DOM. That is the price of
       not forking a shared file and it is still the right price, for the reason
       PADEL's row gives: the bytes are already in the reader's cache from the
       pages that do use them. docs/AFTER_DARK.md §8 carries the number.

       after-dark.css and after-dark.js hold only what no page before it needed:
       one new act ground for the last two screens — the darkest on the site —
       this page's own hero scrim over a lit facade, the detail track lit for a
       room rather than for a hall, the standalone clause on a ground it has
       never stood on, this page's mobile crops, and one motion job.
    */
    'after_dark' => [
        'css' => ['/assets/css/estate.css', '/assets/css/club.css', '/assets/css/after-dark.css'],
        'js'  => ['/assets/js/estate.js',   '/assets/js/club.js',   '/assets/js/after-dark.js'],
    ],

    /*
       CONTACT TAKES TWO LAYERS AND IT IS THE FIRST FILM PAGE SINCE THE ESTATE
       TO TAKE ONLY TWO.

       estate.css/js for the acts — five of them, all of them estate.css §1's
       own grounds, and this is the first film page to add none. It does NOT
       take club.css/js: there is no lateral detail track and no dialogue on
       this page, so the file that carries those two would be five hundred lines
       and two motion jobs matching nothing.

       WHAT THAT LEAVES UNUSED, STATED RATHER THAN HIDDEN. This page draws no
       walk and no ledger, so estate.css §2 and §3 — about three hundred and
       fifty lines — match nothing here, and both of estate.js's jobs return on
       their first line because neither [data-walk] nor [data-ledger-row] is in
       the DOM. That is the price of not forking a shared file and it is still
       the right price, for the reason PADEL's row gives: the bytes are already
       in the reader's cache from the pages that do use them. docs/CONTACT.md §8
       carries the number.

       contact.css and contact.js hold only what no page before it needed: the
       address set as display type, the scene around the map, the map's own
       border on a film ground, the enquiry form lit for a dark page rather than
       for cream, this page's hero clamp and scrim, its mobile crops, and one
       motion job — the camera on the two bands that are photographs.

       IT IS THE ONLY FILM PAGE WITH A FORM ON IT, which is why contact.css is
       the only page stylesheet in this table that reaches into a component
       main.css owns. The reasoning, and why the form's markup is untouched, is
       in contact.css §6.
    */
    'contact' => [
        'css' => ['/assets/css/estate.css', '/assets/css/contact.css'],
        'js'  => ['/assets/js/estate.js',   '/assets/js/contact.js'],
    ],

    /*
       MEMBERSHIP TAKES THREE LAYERS, WHICH IS EVENTS' AND RESIDENCES' AND AFTER
       DARK'S ROW, AND IT TAKES THEM FOR TWO OF THE SAME REASONS.

       estate.css/js for the acts — five of them, all of them estate.css §1's own
       grounds, and this is the second film page after CONTACT to add none.
       club.css/js for ONE of its two components: THE DIALOGUE, which on this
       page carries the five parts of the estate that one membership covers.
       That component, that stylesheet section and that motion job are THE
       CLUB's, and copying any of the three into a tenth file is how two pages
       meant to be the same house start drifting apart. A rename is not available
       either: asset_url() cache-busts on filemtime, so touching any shared file
       at all would re-version the stylesheet in four approved pages' markup.

       WHAT THAT LEAVES UNUSED, STATED RATHER THAN HIDDEN. This page draws no
       walk, no ledger and no lateral detail track, so estate.css §2 and §3 and
       club.css §2 — about six hundred and fifty lines between them — match
       nothing here, and all three of those motion jobs return on their first
       line because none of [data-walk], [data-ledger-row] or [data-detail] is in
       the DOM. That is the price of not forking a shared file and it is still
       the right price, for the reason PADEL's row gives: the bytes are already
       in the reader's cache from the pages that do use them.
       docs/MEMBERSHIP.md §8 carries the number.

       membership.css and membership.js hold only what no page before it needed:
       the letterhead, the dialogue set at 21:9 rather than 16:9, the hero's own
       scrim over a lit facade, the application form on the wine ground, this
       page's mobile crops, and one motion job — the camera on the two bands
       that are stills rather than sequences.

       IT IS THE SECOND FILM PAGE WITH A FORM ON IT, which is why membership.css
       is the second page stylesheet in this table that reaches into a component
       main.css owns. The reasoning, and why the form's markup is untouched, is
       in membership.css §7.
    */
    'membership' => [
        'css' => ['/assets/css/estate.css', '/assets/css/club.css', '/assets/css/membership.css'],
        'js'  => ['/assets/js/estate.js',   '/assets/js/club.js',   '/assets/js/membership.js'],
    ],

    /*
       PRIVACY TAKES ONE LAYER, AND IT IS THE ONLY ROW IN THIS TABLE THAT LOADS
       NO MOTION AT ALL.

       home.css for the chrome and the hero — the bar, the sheet, the footer,
       the first screen and the grain — which is everything this page borrows
       from the film. It takes no estate.css: there are no acts on it, no walk,
       no ledger, and loading three hundred lines of act grounds for a page with
       one ground would be three hundred lines matching nothing. It is the first
       page since THE ESTATE to take a single layer.

       'motion' => false IS THE NEW KEY AND IT IS WHAT KEEPS GSAP, ScrollTrigger,
       Lenis AND home.js OFF THIS PAGE. The brief asks for a lightweight reading
       experience and for legal text that never waits on a script; a privacy
       policy that downloads 50 KB of scroll choreography in order to animate
       nothing is neither. privacy.js does the four things the chrome actually
       needs — the compact bar, the sheet, the hero's one video, and the mark on
       the clause being read — in a fifth of the bytes.

       'defer' IS WHY THAT SCRIPT IS LOADED AT ALL RATHER THAN BEHIND THE MOTION
       CHECK, AND IT FIXES SOMETHING AS WELL AS SAVING SOMETHING. The block below
       returns before it loads anything when a reader has asked for reduced
       motion — which on a film page means no home.js, and below 900px that
       means a menu button that does nothing. A deferred, unconditional script
       gives this page a working navigation at every width and every motion
       setting, and the one thing in it that IS motion, the hero sequence,
       checks prefers-reduced-motion for itself.

       THE OTHER NINE ROWS DECLARE NEITHER KEY, so both fall back below and
       their markup is byte for byte what it was. Proved with
       tools/snapshot_pages.sh, not assumed — docs/PRIVACY.md §7.
    */
    'privacy' => [
        'css'    => ['/assets/css/privacy.css'],
        'js'     => [],
        'motion' => false,
        'defer'  => ['/assets/js/privacy.js'],
    ],

    /*
       TERMS TAKES /privacy's TWO FILES AND THEN ITS OWN, AND IT IS THE SECOND
       ROW IN THIS TABLE THAT LOADS NO MOTION AT ALL.

       home.css for the chrome and the hero. privacy.css FOR THE DOCUMENT — and
       that is this row's whole argument, so it is worth saying plainly:
       privacy.css is not "the privacy page's stylesheet" any more than
       estate.css is "the estate page's". It is THE LEGAL DOCUMENT LAYER — the
       cream reading surface, the two-column frame, the green index, the clause,
       the notice and the foot — and TERMS is a legal document. THE CLUB, PADEL,
       EVENTS, RESIDENCES, AFTER DARK, CONTACT and MEMBERSHIP all take
       estate.css for exactly this reason; this is the same move on the other
       half of the site.

       COPYING THOSE SEVEN SECTIONS INTO terms.css IS HOW TWO PAGES MEANT TO BE
       THE SAME DOCUMENT START DRIFTING APART, and a rename is not available
       either: asset_url() cache-busts on filemtime, so touching privacy.css or
       privacy.js at all — even to rename them legal.css and legal.js, which is
       what they are — would re-version the stylesheet in an approved page's
       markup. The names are the pages that introduced them. That is the same
       trade estate.css made and it is recorded in the same place.

       privacy.js IS LOADED RATHER THAN COPIED FOR THE SAME REASON AND ONE MORE:
       there is nothing in it to change. Its four jobs are the compact bar, the
       navigation sheet, the hero's one video and the mark on the clause being
       read, and all four are addressed by data attribute — [data-film-nav],
       [data-hero-scene], [data-hero-video], [data-legal-index] — every one of
       which this page has. There is no terms.js and there is nothing for one to
       do.

       'motion' => false KEEPS GSAP, ScrollTrigger, Lenis AND home.js OFF THIS
       PAGE, exactly as on /privacy: the brief asks for a lightweight page and
       for legal text that never waits on a script, and a page of clauses that
       downloads 50 KB of scroll choreography in order to animate nothing is
       neither.

       WHAT terms.css HOLDS, AND IT IS SHORT BY DESIGN: this page's hero clamp
       and its own scrim over a room lit by a fire, the two chapter breaks the
       brief allows and /privacy has no use for, the impressum's four notices set
       as a schedule rather than as four boxes, and this page's narrow pass.
       Nothing in it re-states a rule privacy.css already makes.
    */
    'terms' => [
        'css'    => ['/assets/css/privacy.css', '/assets/css/terms.css'],
        'js'     => [],
        'motion' => false,
        'defer'  => ['/assets/js/privacy.js'],
    ],
];

$film = $filmPages[current_page()] ?? null;
?>
<?php if ($film !== null): ?>
    <?php /*
        THE FILM'S MOTION LAYER, AND ONLY THE FILM PAGES'.

        Everything in this block is inside the check above because the other
        nine pages must render byte for byte as they did before it existed —
        which is also why main.css and main.js are not touched anywhere in this
        work: asset_url() cache-busts on filemtime, so editing either of them
        would change the ?v= in the markup of all eleven pages.

        THE STYLESHEET IS A SECOND FILE AND NOT AN ADDITION TO main.css. The
        shared 40 KB ceiling belongs to main.css and this is not in it; the
        film pays for the film.

        NOTHING BELOW IS IN THE CRITICAL PATH. The script is not deferred — it
        is inline, tiny, and its whole job is to decide whether to fetch a
        motion layer at all and then to wait. The libraries are injected at the
        load event, so the text and the photography are painted, and read,
        before GSAP is so much as parsed.

        UNDER prefers-reduced-motion IT LOADS NOTHING. Not a smaller animation,
        not a disabled library: the fetch never happens, so a reader who has
        asked for less motion is also spared 50-odd KB of it.

        html.motion IS SET HERE AND MEANS ONE THING: the libraries are on their
        way. home.css keys the hero's own entrance to it — a keyframe that runs
        on the stylesheet alone, so the first screen composes itself whether or
        not GSAP ever arrives. Nothing else on the page is hidden by CSS at any
        point; home.js hides an element only when it takes responsibility for
        revealing it. See §13 of home.css, which is where the reasoning is.
    */ ?>
    <link rel="stylesheet" href="<?= e(asset_url('/assets/css/home.css')) ?>">
<?php foreach ($film['css'] as $filmCss): ?>
    <link rel="stylesheet" href="<?= e(asset_url($filmCss)) ?>">
<?php endforeach; ?>
<?php /*
        'motion' => false SKIPS EVERYTHING BELOW, AND ONE ROW DECLARES IT.
        /privacy is a document rather than a film: it has no scrubbed scenes,
        no pinned walk and no reveals, so GSAP, ScrollTrigger, Lenis and
        home.js would be 50-odd KB fetched to animate nothing. It loads
        privacy.js through 'defer' instead. Every other row is silent about
        this key, `?? true` is what they get, and their markup is unchanged.
     */ ?>
<?php if ($film['motion'] ?? true): ?>
    <script>
    (function () {
        if (!window.matchMedia || matchMedia('(prefers-reduced-motion: reduce)').matches) {
            return;
        }

        document.documentElement.classList.add('motion');

        var sources = <?= json_encode(
            array_merge(
                [
                    asset_url('/assets/js/vendor/gsap.min.js'),
                    asset_url('/assets/js/vendor/ScrollTrigger.min.js'),
                    asset_url('/assets/js/vendor/lenis.min.js'),
                    asset_url('/assets/js/home.js'),
                ],
                array_map('asset_url', $film['js'])
            ),
            JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
        ) ?>;

        function boot() {
            /*
               async = false on a script created in JavaScript is what keeps
               the four of them in order: they download in parallel and execute
               in the order they were appended. ScrollTrigger registers itself
               against a gsap that has to exist already, and home.js needs all
               three. Appending them without it is the race that works on a
               fast machine and fails on a slow one.
            */
            for (var i = 0; i < sources.length; i++) {
                var tag = document.createElement('script');

                tag.src = sources[i];
                tag.async = false;
                document.head.appendChild(tag);
            }
        }

        if (document.readyState === 'complete') {
            boot();
        } else {
            addEventListener('load', boot, { once: true });
        }
    }());
    </script>
<?php endif; ?>
<?php /*
        A PAGE MAY ALSO ASK FOR AN ORDINARY DEFERRED SCRIPT, and exactly one
        does. 'defer' is loaded whatever the reader's motion setting is, which
        is the point of it: on /privacy the script that opens the navigation
        sheet cannot be the script that would have animated the page, or a
        reader who has asked for less motion is handed a button that does
        nothing. The nine film rows declare no 'defer' and this loop runs zero
        times for them.
     */ ?>
<?php foreach ($film['defer'] ?? [] as $deferred): ?>
    <script src="<?= e(asset_url($deferred)) ?>" defer></script>
<?php endforeach; ?>
<?php endif; ?>

<?php if ($jsonld !== ''): ?>
    <?php /* Escaped inside jsonld(), which is where the encoder is — printing
             it through e() would encode the JSON a second time and hand the
             crawler &quot; where it expects a quotation mark. */ ?>
    <script type="application/ld+json"><?= $jsonld ?></script>
<?php endif; ?>
</head>
