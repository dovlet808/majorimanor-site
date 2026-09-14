<?php
/**
 * hero — the first screen.
 *
 * A photograph the height of the window, a scrim over it, and four lines
 * standing in the middle of it: what this is, what it is called, where it is,
 * and the two ways in. ARCHITECTURE §10.
 *
 * TWO VARIANTS, AND THE SECOND IS A MODIFIER RATHER THAN A SECOND COMPONENT.
 *
 *   full   the home page, and only the home page: min(100svh, 900px), the
 *          location line, the two ways in, the scroll cue.
 *   page   the first screen of an internal page: min(62svh, 620px), a
 *          one-sentence lede in place of the actions, no cue.
 *
 * What differs is a height, one line of text and two things left out. What
 * does not differ is everything that makes a hero a hero and everything that
 * would drift the day somebody copied it: the full-bleed photograph, the scrim
 * over it, the transparent header standing on the same image, and the poster
 * as the LCP element. A page hero is still the first thing a reader looks at,
 * so it keeps priority => true and there is still only one of them per page.
 *
 * The page variant is shorter because it is an opening and not an arrival: the
 * reader has already chosen this page, and the first paragraph of it should be
 * visible without scrolling. 62svh puts it there on a phone and 620px stops
 * the band from becoming a wall on a tall desktop window.
 *
 * NO "BOOK NOW" ON THIS SCREEN, and there is nowhere in this component to put
 * one. Atmosphere and access first, service later: a reader arriving here is
 * being told what the place is, not sold a night in it. The two actions are
 * DISCOVER THE ESTATE, which goes further in, and MEMBERSHIP ENQUIRY, which is
 * the site's one conversion path — and the second is a line of text rather than
 * a second button, because two buttons side by side make a reader choose
 * instead of read. The page variant has neither: an internal page makes its
 * case first and asks at the bottom, which is what the closing cta is for.
 *
 * IT STANDS ON A PHOTOGRAPH, NOT ON THE PAGE. Hence a temperature in the markup
 * rather than one taken from the page: the ground here is a dark image under a
 * scrim, and the text on it is cream with a gold accent whatever the page below
 * is doing. The header does exactly the same thing over exactly this element —
 * see .c-header[data-hero] in §3 of main.css.
 *
 * WHICH DARK, THOUGH, IS A CONTENT DECISION ON EXACTLY ONE PAGE. dusk is the
 * default and every page built before this one takes it. /after-dark does not:
 * it is night from the first pixel to the last, and a green band at the top of
 * a wine page is the one thing that page may not have. So 'mood' is a field
 * here as it is on every other component — opt-in, so nothing that does not ask
 * for it moves — and the scrim follows it (.c-hero.section--night in §7).
 *
 * ONLY dusk AND night. A hero is a photograph with cream text standing on it,
 * and day is cream: the scrim would be a wash of cream over a picture and the
 * words would go with it. A content file that asks for day gets dusk and a
 * warning in DEV.
 *
 * The poster is the LCP element on every page that has one, in both the poster
 * and the video scenarios (§10), which is what 'priority' => true says.
 *
 * Fields
 *   variant   'full' (default) | 'page'
 *   eyebrow   the small tracked line above the title
 *   title     the <h1> — one per page, and this is it
 *   location  the tracked line under it — the full variant's
 *   lede      one sentence under the title — the page variant's
 *   image     ['name' => 'home/hero-pavilion-night', 'alt' => …,
 *              'ratio' => '16/9', 'source' => 'photo' | 'render' | 'mood']
 *   actions   [['page_id' => …, 'label' => …, 'variant' => 'primary' | 'quiet'], …]
 *             full only — the page variant drops them and says so in DEV
 *   mood      'dusk' (default) | 'night' — the ground under the photograph
 *
 * @var array $s this section
 * @var array $c the page content
 */

declare(strict_types=1);

$isPage = ($s['variant'] ?? 'full') === 'page';

$eyebrow  = (string) ($s['eyebrow'] ?? '');
$title    = (string) ($s['title'] ?? '');
$location = (string) ($s['location'] ?? '');
$lede     = (string) ($s['lede'] ?? '');
$image    = (array)  ($s['image'] ?? []);
$actions  = (array)  ($s['actions'] ?? []);

/** The ground under the photograph. See the note above: dusk or night, no day. */
$mood = (string) ($s['mood'] ?? 'dusk');

if (!in_array($mood, ['dusk', 'night'], true)) {
    if (DEV) {
        trigger_error("hero(): mood '{$mood}' is not a hero ground — using dusk", E_USER_WARNING);
    }

    $mood = 'dusk';
}

/*
   The page variant has no CTAs by definition, so a content file that supplies
   them has made a decision this component is not going to carry out quietly.
*/
if ($isPage && $actions !== []) {
    if (DEV) {
        trigger_error("hero(): the 'page' variant takes no actions — " . count($actions) . ' dropped', E_USER_WARNING);
    }

    $actions = [];
}

/*
   Built rather than written inline at the call, because 'ratio' is the one
   option here that may be absent: passing an empty one would be a DEV warning
   out of img_ratio() and a default nobody asked for. See the note beside the
   call below for what a ratio does and does not do in a hero.
*/
$imageOptions = [
    'widths'   => [1280, 1920, 2560],
    'priority' => true,
    'source'   => (string) ($image['source'] ?? 'photo'),
];

if (!empty($image['ratio'])) {
    $imageOptions['ratio'] = (string) $image['ratio'];
}
?>
<section class="c-hero<?= $isPage ? ' c-hero--page' : '' ?> section--<?= e($mood) ?>">

    <div class="c-hero__media">
<?php if (!empty($image['name'])): ?>
        <?php /*
            Full bleed, so the browser is told 100vw and nothing else. The
            ladder is the poster one from §11 — 1280 / 1920 / 2560 — rather
            than the chapter ladder, because this image is as wide as the
            window on a desktop and the top of the chapter ladder is not.

            THE RATIO HERE RESERVES NOTHING, which is the opposite of what it
            does everywhere else on the site. A hero's box is the window's
            height and the wrapper is stretched to fill it in CSS, so whatever
            arrives is cropped to the band: this is the one img() call where
            aspect-ratio is switched off again by the stylesheet. A content
            file may still declare one — 16/9 on the estate — and it is passed
            through because it is a true statement about the file being
            commissioned, not because the page is holding room for it. The
            shape that matters here is the band's, and the band is a height.
        */ ?>
        <?= img(
            (string) $image['name'],
            '100vw',
            (string) ($image['alt'] ?? ''),
            $imageOptions
        ) ?>
<?php endif; ?>

<?php
/*
   THE VIDEO. ARCHITECTURE §10 — the slot is live and the flag is off.

   IT IS NOW REAL MARKUP BEHIND TWO CONDITIONS RATHER THAN A COMMENT, and the
   difference matters: a commented block is a plan, and a plan cannot be
   reviewed, cannot be measured and cannot be switched on by anybody who was
   not in the room when it was written. This renders when ENABLE_VIDEO is true
   AND the content file has declared a name, so today — flag false in
   private/config.php, and no footage anywhere — it renders nothing at all and
   every page on this site is byte for byte what it was.

   THE POSTER STAYS THE LCP ELEMENT IN BOTH SCENARIOS. The video is decoration
   over an image that is already there; if it never loads, nobody notices, and
   that is the requirement rather than a fallback. Which is also why there is
   no `poster` attribute: the still above is a real <picture> with a srcset,
   already painted, already the LCP candidate, and a poster attribute would put
   a second copy of the same frame in front of it at one fixed width.

   Format:      WebM (VP9) with an MP4 (H.264) fallback
   Length:      8-12 seconds, seamless loop
   Weight:      <= 4 MB per file
   Attributes:  muted playsinline autoplay loop preload="none"

   Conditions, ALL OF THEM REQUIRED before a byte is fetched:

     - viewport >= 1024px wide — phones get the poster, always
     - prefers-reduced-motion: no-preference
     - navigator.connection.saveData !== true
     - after the window load event, so it never competes with the first screen

   None of those can be expressed in markup, so the element ships with its
   sources on data- attributes and NO src at all. Nothing is downloaded by the
   browser on its own; the loader in assets/js/home.js attaches the source only
   when all four hold, which is why `autoplay` here is not a promise to play on
   arrival — there is nothing to play until something decides there should be.
*/
?>
<?php if (ENABLE_VIDEO && !empty($s['video']['name'])): ?>
<?php
    /*
       The name is interpolated into a path, so it is checked the way img()
       checks an image stem and for the same reason: a content file is not the
       wire, but "../../private/config" is a name too.
    */
    $videoName = (string) $s['video']['name'];

    if (!preg_match('#^[a-z0-9][a-z0-9_-]*(/[a-z0-9][a-z0-9_-]*)*$#', $videoName)) {
        if (DEV) {
            trigger_error("hero(): bad video name '{$videoName}'", E_USER_WARNING);
        }

        $videoName = '';
    }
?>
<?php if ($videoName !== ''): ?>
        <video class="c-hero__video" muted playsinline autoplay loop preload="none"
               data-hero-video
               data-webm="<?= e('/assets/video/' . $videoName . '.webm') ?>"
               data-mp4="<?= e('/assets/video/' . $videoName . '.mp4') ?>"
               aria-hidden="true" tabindex="-1"></video>
<?php endif; ?>
<?php endif; ?>
    </div>

    <div class="wrap c-hero__inner">

<?php if ($eyebrow !== ''): ?>
        <p class="u-eyebrow"><?= e($eyebrow) ?></p>
<?php endif; ?>

        <h1 class="c-hero__title"><?= e($title) ?></h1>

<?php if ($location !== ''): ?>
        <p class="u-eyebrow c-hero__location"><?= e($location) ?></p>
<?php endif; ?>

<?php if ($lede !== ''): ?>
        <?php /* One sentence, and the component does not enforce that — a
                 measure narrow enough to break a second one over four lines
                 does the arguing. */ ?>
        <p class="c-hero__lede"><?= e($lede) ?></p>
<?php endif; ?>

<?php if ($actions !== []): ?>
        <p class="c-hero__actions">
<?php foreach ($actions as $action): ?>
<?php
            if (empty($action['page_id']) || empty($action['label'])) {
                continue;
            }

            // Two shapes and no third: the filled button, and the line of text
            // beside it. Anything else in a content file is one of these two.
            $quiet = ($action['variant'] ?? 'primary') === 'quiet';
            $class = $quiet ? 'c-hero__quiet' : 'c-btn c-btn--primary';
?>
            <a class="<?= $class ?>" href="<?= e(url((string) $action['page_id'])) ?>"><?= e((string) $action['label']) ?></a>
<?php endforeach; ?>
        </p>
<?php endif; ?>

    </div>

<?php if (!$isPage): ?>
    <?php /*
        The scroll cue. A hairline that draws itself down and leaves, once
        every two and a half seconds — the one piece of motion on a screen that
        ARCHITECTURE §8.6 otherwise requires to be still, and it is here
        because the page below this one is the whole point of it.

        It says nothing: a reader who cannot see it has the same page under the
        same scroll. Hidden outright under prefers-reduced-motion rather than
        left standing still, because a static line under a hero is a mark
        nobody can explain.

        The page variant has none. A cue answers "is there more below this?",
        and on a screen 62svh tall the first paragraph is already answering it.
    */ ?>
    <span class="c-hero__cue" aria-hidden="true"></span>
<?php endif; ?>

</section>
