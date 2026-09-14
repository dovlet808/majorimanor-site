<?php
/**
 * plan-padel — the schematic of the padel complex, as a site graphic.
 *
 * DRAWN HERE, NOT TRACED. The owner's infographic is a project document: a
 * technical drawing with Russian annotations, dimension chains and a legend
 * that belongs to a builder. This is the same geometry set out again in the
 * site's own hand — flat shapes, --fg at two weights, and --accent spent on
 * exactly two things, the overall width and the crest in the middle of each
 * court. The original stays in assets/docs/ for the investor material and
 * nothing on this page is a photograph of it.
 *
 * THE GEOMETRY, FROM THE OWNER'S PLAN:
 *
 *     53.0 m overall width, and it is the one dimension the drawing annotates
 *     four courts in the centre, two rows of two
 *     a social zone 6.5 m wide down the right edge
 *     a sanitary zone 37.5 m long down the left edge
 *     a clipped yew hedge around the whole perimeter
 *     the main entrance at the bottom, on the centre line
 *
 * The user unit IS the metre, so every coordinate below can be read against
 * the plan. Nothing else is dimensioned: the courts are drawn to a true 2:1
 * so that they read as padel courts, but no court dimension is stated
 * anywhere on this page and none may be inferred from a schematic.
 *
 * NOT A WORD OF TEXT IN THIS FILE. Every label, the legend, and the two
 * strings a screen reader is given come out of the content file, keyed by id —
 * which is what lets Latvian arrive without the drawing being touched. The
 * geometry is here because it is not language; the words are there because
 * they are.
 *
 * THE NUMBERS ARE THE CONTENT'S ORDER. Item 1 in the content file is disc 1 in
 * the drawing and line 1 in the legend, because all three are the same loop.
 * An item whose id this file has no place for is dropped before the numbering
 * is worked out, so the discs and the legend can never disagree.
 *
 * BELOW 768px THE FINE TEXT LEAVES THE DRAWING. A plan 53 m wide inside a
 * 360px phone puts its annotations at six or seven pixels, which is a drawing
 * with unreadable writing on it. So the labels are hidden in CSS, the numbered
 * discs grow, and the <ol> under the drawing carries what the labels said. The
 * drawing itself never changes, and neither does its aspect ratio — this
 * component reserves its own height at every width and shifts nothing.
 *
 * THE LEGEND IS NOT THE ACCESSIBLE NAME. It is only there below 768px, and a
 * list of six lines does not say what is next to what in any case. The layout
 * is described once, properly, in <desc> — see the a11y block in the content
 * file — and the drawing carries role="img" so that a reader is given the
 * description instead of sixty numbers read out of a diagram.
 *
 * Fields
 *   eyebrow  optional tracked line
 *   title    optional h2
 *   a11y     ['title' => …, 'desc' => …] — the accessible name and description
 *   items    [['id' => 'width', 'label' => '53.0 m', 'legend' => …], …]
 *            id is one of the keys of $marks below; label is what is printed
 *            in the drawing, legend what is printed under it on a phone
 *   mood     day | dusk | night
 *
 * @var array $s this section
 * @var array $c the page content
 */

declare(strict_types=1);

$eyebrow = (string) ($s['eyebrow'] ?? '');
$title   = (string) ($s['title'] ?? '');
$items   = (array)  ($s['items'] ?? []);
$a11y    = (array)  ($s['a11y'] ?? []);

$mood = in_array($s['mood'] ?? null, MOODS, true) ? $s['mood'] : null;

/**
 * A coordinate, printed short. 8.5 + 4.25 is 12.75 and not 12.750000001, but
 * only because the numbers below were chosen to be exact in binary; this keeps
 * the markup readable whatever arithmetic ends up being done to them.
 */
$n = static function (float $value): string {
    return rtrim(rtrim(number_format($value, 4, '.', ''), '0'), '.');
};

// ---------------------------------------------------------------------------
// The plan, in metres
// ---------------------------------------------------------------------------

/*
   The enclosure. The hedge is drawn as a band 1.1 wide on the inside of the
   boundary, so the plan's own extent is 0 → 53 across and 0 → 41 down, and the
   53.0 m annotation measures the thing it says it measures.

   The band is one path with one gap in it, at the bottom, because that gap is
   the main entrance and a hedge with a doorway drawn over it is a hedge with a
   doorway drawn over it. The path starts at the right-hand side of the opening
   and runs the whole way round to the left-hand side.

   THE OPENING IS 9.0 WIDE BECAUSE OF THE DOTS, NOT BECAUSE OF THE GATE. The
   planting is a dashed stroke, so the dots are spaced from wherever the path
   begins and the last one lands wherever the path happens to end — leave that
   to chance and the opening comes out lopsided, with a full space on one side
   of the entrance and a stub on the other. At this width the run measures
   174.6, which is 79 dots at the 2.21 spacing to within a hundredth, so the
   pattern closes exactly where it started and the gap is symmetrical about the
   centre line the entrance arrow stands on. Move an edge of this rectangle and
   that arithmetic has to be done again.
*/
$hedgePath = 'M 31 40.45 H 52.45 V 0.55 H 0.55 V 40.45 H 22';

/* The same shape one band in, as a hairline: the inside face of the hedge. */
$enclosurePath = 'M 31 39.9 H 51.9 V 1.1 H 1.1 V 39.9 H 22';

/*
   The two strips. Only the dimensions in the confirmed list are drawn to a
   number: the social zone is 6.5 wide because that is the figure, and the
   sanitary zone is 37.5 long for the same reason. The other side of each — how
   deep the social strip runs, how wide the sanitary one is — is not settled,
   so it is drawn to fit and never annotated.
*/
$zones = [
    'sanitary' => ['x' => 1.5,  'y' => 1.4, 'w' => 4.8, 'h' => 37.5],
    'social'   => ['x' => 45.0, 'y' => 3.0, 'w' => 6.5, 'h' => 34.0],
];

/*
   Four courts, two rows of two, centred in what is left between the strips.

   A padel court is twice as long as it is wide, and that is the whole of what
   this drawing knows about a court's size: 17 × 8.5 here is a proportion and
   not a measurement. Inside each one, the net across the middle, the two
   service lines, and the centre line that divides the boxes behind them —
   which is the least a rectangle needs before it reads as a court.

   THE ROWS ARE CENTRED RATHER THAN HUNG FROM THE TOP, because the depth of
   the enclosure is set by the sanitary zone's 37.5 m and not by the courts.
   Two rows fill less of that depth than three did, and a block held to the
   old top edge would leave fifteen metres of nothing between the last court
   and the entrance. Centred, the clear ground falls on both sides of the
   courts — 8.9 above and 9.9 below — which is circulation and reads as it.
*/
$courtW = 17.0;
$courtH = 8.5;
$courtX = [7.4, 26.8];
$courtY = [10.0, 21.5];

/* Distance from each end to the service line, on this court's proportions. */
$service = 5.9;

/*
   WHERE EACH NUMBER SITS, AND WHERE ITS LABEL SITS BESIDE IT.
   Keyed by the id a content item declares. A content file can reorder these,
   rename them or leave one out; it cannot move one, because a position on a
   drawing is not a translation.

   label: 'anchor' is the SVG text-anchor; 'rotate' turns the label up the page
   for the two strips, which are far too narrow to take a horizontal line.
   Rotated text stands to the left of its own baseline, so the baseline of a
   vertical label is set half a cap-height right of the strip's centre.
*/
$marks = [
    // On the dimension line, which it breaks — the one accented annotation.
    'width' => [
        'x' => 26.5, 'y' => -4.5, 'accent' => true,
        'label' => ['x' => 26.5, 'y' => -6.5, 'anchor' => 'middle'],
    ],
    // In the clear band above the courts, with a leader down onto the first.
    'courts' => [
        'x' => 9.0, 'y' => 3.3,
        'label' => ['x' => 11.2, 'y' => 3.3, 'anchor' => 'start'],
        'lead'  => ['x1' => 9.0, 'y1' => 4.45, 'x2' => 9.0, 'y2' => 10.0],
    ],
    /*
       Inside its own strip, near the top, with the label running up the strip
       below it. The two are on the same line as each other rather than each
       one at the top of its own strip: the strips start at different heights,
       and two discs an inch out of line read as a mistake in the drawing.
    */
    'social' => [
        'x' => 48.25, 'y' => 5.2,
        'label' => ['x' => 48.65, 'y' => 35.4, 'anchor' => 'start', 'rotate' => -90],
    ],
    'sanitary' => [
        'x' => 3.9, 'y' => 5.2,
        'label' => ['x' => 4.3, 'y' => 36.9, 'anchor' => 'start', 'rotate' => -90],
    ],
    // Pinned on the hedge itself, in the band it names. Left of centre on
    // purpose: a label sitting over the middle of a drawing is read as its
    // title, whatever it is attached to.
    'hedge' => [
        'x' => 14.0, 'y' => 0.55,
        'label' => ['x' => 16.2, 'y' => -1.2, 'anchor' => 'start'],
    ],
    // Below the plan, under the gap, with an arrow through it and inward.
    'entrance' => [
        'x' => 26.5, 'y' => 44.4,
        'label' => ['x' => 26.5, 'y' => 47.4, 'anchor' => 'middle'],
        'lead'  => ['x1' => 26.5, 'y1' => 43.25, 'x2' => 26.5, 'y2' => 40.6],
        'arrow' => '26.5,39.4 25.95,40.75 27.05,40.75',
    ],
];

/*
   The items that have somewhere to go, in content order, numbered from one.
   Resolved before anything is drawn so that the drawing and the legend are
   numbered by the same list — see the note at the top of this file.
*/
$drawn = [];

foreach ($items as $item) {
    $id = (string) ($item['id'] ?? '');

    if (!isset($marks[$id])) {
        if (DEV) {
            trigger_error("plan-padel(): no place on the plan for '{$id}'", E_USER_WARNING);
        }

        continue;
    }

    $drawn[] = [
        'number' => count($drawn) + 1,
        'item'   => $item,
        'mark'   => $marks[$id],
    ];
}

/*
   THE CREST, REDUCED TO THE SIZE IT IS ACTUALLY BEING PRINTED AT.

   The small mark is the monogram inside a double circle (assets/img/brand/
   mark.svg). At the centre of a court on this plan it is 2.6 units across —
   about 33px where the drawing is widest and 17px on a phone — and at 17px the
   two rings of the original merge into one thick donut, which is the failure
   that file's own comment warns about. So the reduction keeps one ring and the
   M, at the geometry and the weights of the original scaled down, and drops
   the inner ring rather than printing a smudge where it used to be.

   The M is mark.svg's own path, so the letter is the letter and not a redraw:
   its 100-unit box is scaled to the ring here, 1.3 / 46.
*/
$crestScale = 1.3 / 46;
$crestPath  = 'M33 66 V37 L50 59 L67 37 V66';

/*
   A PAGE CAN HOLD MORE THAN ONE OF THESE, AND ONE PAGE ALREADY DOES.

   /components renders the whole library twice, once on each ground, which is
   the one claim that page exists to test. Two drawings with the same ids there
   would leave the second one's aria-labelledby pointing at the first one's
   title — a mistake that is invisible on screen and wrong in every screen
   reader. So the first plan on a page keeps the plain ids and any after it are
   numbered.
*/
$GLOBALS['plan_padel_instances'] = ($GLOBALS['plan_padel_instances'] ?? 0) + 1;

$uid = 'plan-padel' . ($GLOBALS['plan_padel_instances'] > 1 ? '-' . $GLOBALS['plan_padel_instances'] : '');
?>
<section class="section c-plan-padel<?= $mood ? ' section--' . e($mood) : '' ?>">
    <div class="wrap">

<?php if ($eyebrow !== '' || $title !== ''): ?>
        <div class="c-plan-padel__head stack" style="--stack-space: var(--space-3)">
<?php if ($eyebrow !== ''): ?>
            <p class="u-eyebrow"><?= e($eyebrow) ?></p>
<?php endif; ?>
<?php if ($title !== ''): ?>
            <h2><?= e($title) ?></h2>
<?php endif; ?>
        </div>
<?php endif; ?>

        <figure class="c-plan-padel__figure">

            <?php /*
                width and height are the drawing's own proportions and are here
                so the box is the right shape before the stylesheet has been
                read; the CSS scales it to the column. The viewBox opens out
                past the plan on all four sides to hold the annotations: the
                dimension above it, the entrance below.

                THE TITLE IS THE NAME AND THE DESC IS THE DESCRIPTION, WHICH IS
                WHY ONLY ONE OF THEM IS IN aria-labelledby. The usual recipe
                names both there, and it works, but it makes the whole layout
                paragraph the element's name and a reader hears it twice —
                once as the name and again as the description, which the
                browser resolves from <desc> on its own. Verified in the
                accessibility tree: name "Plan of the padel and social club",
                description the paragraph. role="img" is what makes the pair
                the whole of what is announced, instead of every stray number
                inside the drawing.
            */ ?>
            <svg class="c-plan-padel__svg"
                 xmlns="http://www.w3.org/2000/svg"
                 viewBox="-1 -8 55 56.4" width="550" height="564"
                 role="img" aria-labelledby="<?= e($uid) ?>-title">

                <title id="<?= e($uid) ?>-title"><?= e((string) ($a11y['title'] ?? '')) ?></title>
                <desc id="<?= e($uid) ?>-desc"><?= e((string) ($a11y['desc'] ?? '')) ?></desc>

                <?php /* The hedge: a band of clipped planting, and the face of
                         it on the inside. The gap at the bottom is the way in. */ ?>
                <path class="c-plan-padel__hedge" d="<?= $hedgePath ?>"/>
                <path class="c-plan-padel__enclosure" d="<?= $enclosurePath ?>"/>

<?php foreach ($zones as $zone): ?>
                <rect class="c-plan-padel__zone" x="<?= $n($zone['x']) ?>" y="<?= $n($zone['y']) ?>" width="<?= $n($zone['w']) ?>" height="<?= $n($zone['h']) ?>" rx="0.4"/>
<?php endforeach; ?>

<?php foreach ($courtY as $y): ?>
<?php foreach ($courtX as $x): ?>
<?php
    $cx = $x + $courtW / 2;
    $cy = $y + $courtH / 2;

    /*
       The net down the middle, the two service lines, and the centre line
       running from each end of the court to the service line in front of it —
       which is what divides the two boxes, and the one thing that stops the
       drawing from reading as a tennis court cut in half.
    */
    $lines = 'M ' . $n($cx) . ' ' . $n($y) . ' V ' . $n($y + $courtH)
        . ' M ' . $n($x + $service) . ' ' . $n($y) . ' V ' . $n($y + $courtH)
        . ' M ' . $n($x + $courtW - $service) . ' ' . $n($y) . ' V ' . $n($y + $courtH)
        . ' M ' . $n($x) . ' ' . $n($cy) . ' H ' . $n($x + $service)
        . ' M ' . $n($x + $courtW - $service) . ' ' . $n($cy) . ' H ' . $n($x + $courtW);
?>
                <g class="c-plan-padel__court">
                    <rect x="<?= $n($x) ?>" y="<?= $n($y) ?>" width="<?= $n($courtW) ?>" height="<?= $n($courtH) ?>" rx="0.5"/>
                    <path class="c-plan-padel__line" d="<?= $lines ?>"/>
                    <?php /* The crest, standing on a disc of the ground so the
                             net does not run through the middle of it. */ ?>
                    <circle class="c-plan-padel__crest-ground" cx="<?= $n($cx) ?>" cy="<?= $n($cy) ?>" r="1.45"/>
                    <g class="c-plan-padel__crest" transform="translate(<?= $n($cx) ?> <?= $n($cy) ?>) scale(<?= $n($crestScale) ?>)">
                        <circle cx="0" cy="0" r="46"/>
                        <?php /* The M is lifted out of mark.svg unaltered, so
                                 it arrives in that file's own 100-unit box and
                                 has to be moved onto the centre it is being
                                 drawn around. */ ?>
                        <path d="<?= $crestPath ?>" transform="translate(-50 -50)" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                </g>
<?php endforeach; ?>
<?php endforeach; ?>

                <?php /* The one dimension on the drawing. Extension lines off
                         the two outside corners, arrowheads turned inward so
                         nothing reaches past the width being measured, and the
                         line broken in the middle by its own number. */ ?>
                <g class="c-plan-padel__dim">
                    <path d="M 0 -0.4 V -5.6 M 53 -0.4 V -5.6 M 0 -4.5 H 53"/>
                    <polygon points="0,-4.5 1.8,-4.9 1.8,-4.1"/>
                    <polygon points="53,-4.5 51.2,-4.9 51.2,-4.1"/>
                </g>

<?php foreach ($drawn as $mark): ?>
<?php if (isset($mark['mark']['lead'])): $lead = $mark['mark']['lead']; ?>
                <line class="c-plan-padel__lead" x1="<?= $n($lead['x1']) ?>" y1="<?= $n($lead['y1']) ?>" x2="<?= $n($lead['x2']) ?>" y2="<?= $n($lead['y2']) ?>"/>
<?php endif; ?>
<?php if (isset($mark['mark']['arrow'])): ?>
                <polygon class="c-plan-padel__arrow" points="<?= $mark['mark']['arrow'] ?>"/>
<?php endif; ?>
<?php endforeach; ?>

                <?php /* The numbers, last, so each one sits on top of whatever
                         it is pinned to. Their discs are filled with the ground
                         and knock a hole in the line underneath. */ ?>
<?php foreach ($drawn as $mark): ?>
                <g class="c-plan-padel__mark<?= !empty($mark['mark']['accent']) ? ' c-plan-padel__mark--accent' : '' ?>">
                    <circle class="c-plan-padel__disc" cx="<?= $n($mark['mark']['x']) ?>" cy="<?= $n($mark['mark']['y']) ?>" r="1.15"/>
                    <text class="c-plan-padel__key" x="<?= $n($mark['mark']['x']) ?>" y="<?= $n($mark['mark']['y']) ?>" dy="0.34em" text-anchor="middle"><?= e((string) $mark['number']) ?></text>
                </g>
<?php endforeach; ?>

                <?php /* The labels. Hidden below 768px, where the <ol> under
                         the drawing takes over — see main.css §7. */ ?>
<?php foreach ($drawn as $mark): ?>
<?php
    $label = $mark['mark']['label'];
    $class = 'c-plan-padel__label' . (!empty($mark['mark']['accent']) ? ' c-plan-padel__label--accent' : '');

    $transform = isset($label['rotate'])
        ? ' transform="rotate(' . $n((float) $label['rotate']) . ' ' . $n($label['x']) . ' ' . $n($label['y']) . ')"'
        : '';

    // A horizontal label lines up with the middle of its disc; a vertical one
    // sits on its own baseline, which is where the strip's centre already is.
    $shift = isset($label['rotate']) ? '' : ' dy="0.34em"';
?>
                <text class="<?= $class ?>" x="<?= $n($label['x']) ?>" y="<?= $n($label['y']) ?>"<?= $shift ?> text-anchor="<?= e((string) $label['anchor']) ?>"<?= $transform ?>><?= e((string) ($mark['item']['label'] ?? '')) ?></text>
<?php endforeach; ?>

            </svg>

<?php if ($drawn !== []): ?>
            <?php /* Numbered by the browser, from the same order the discs
                     were drawn in. Below 768px only, and it is a real <ol>
                     because it is a real list. */ ?>
            <ol class="c-plan-padel__legend">
<?php foreach ($drawn as $mark): ?>
                <li><?= e((string) ($mark['item']['legend'] ?? '')) ?></li>
<?php endforeach; ?>
            </ol>
<?php endif; ?>

        </figure>

    </div>
</section>
