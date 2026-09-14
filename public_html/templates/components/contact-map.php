<?php
/**
 * contact-map — a scene built around the map this site already had.
 *
 * IT DRAWS NO MAP. components/map.php does all of that and is not touched by
 * this file or by this page: the coordinates, the geo: hand-off, the printed
 * address that stands in the frame until Leaflet arrives, the CARTO and
 * OpenStreetMap credit, the gold divIcon, and the IntersectionObserver in
 * main.js that means a reader who never scrolls this far makes no request to
 * any third party at all. All of that is the approved behaviour and all of it
 * still runs.
 *
 * WHAT THIS ADDS IS THE SCENE AROUND IT — a number, an eyebrow, one sentence
 * and a frame — and that is the whole difference between a map on a page and a
 * map embedded in a page. The approved contact page put the map in the right
 * column of components/split.php, which is a layout for a picture beside some
 * prose; on a film page that reads as a widget parked in a column. Here it is a
 * figure with a caption above it, held to the film's own shell.
 *
 * WHY NOT split.php WITH A 'map', WHICH ALREADY EXISTS. Because that component
 * is main.css's and this page is the film's: .c-split reads --bg, --fg and
 * --rule through [data-mood] and draws .wrap, .section and .stack around
 * itself, none of which the film uses. Restyling it for one page would mean
 * either editing main.css — which asset_url() cache-busts on filemtime, so it
 * re-versions the stylesheet in the markup of all eleven pages — or overriding
 * a dozen rules from contact.css against a component the other pages still
 * draw. Twenty lines here is cheaper and does not reach anything else.
 * split.php is untouched and /privacy still uses it.
 *
 * THE MAP IS NOT AN ANCHOR TARGET AND THE SECTION IS. The id goes on the
 * <section> rather than on the frame, because the frame's id belongs to the
 * map's own 'id' field and pointing two anchors at one element is how a
 * skip-link silently stops working.
 *
 * Fields
 *   id       anchor for the section
 *   index    the scene number, e.g. '02'
 *   eyebrow  the tracked line above the sentence
 *   lede     one sentence, set as display type
 *   map      the map section — see components/map.php for its fields
 *
 * @var array $s this section
 * @var array $c the page content
 */

declare(strict_types=1);

$id  = (string) ($s['id'] ?? '');
$map = (array) ($s['map'] ?? []);

if ($map === []) {
    if (DEV) {
        trigger_error('contact-map: no map', E_USER_WARNING);
    }

    return;
}
?>
<section class="c-contact-map"<?= $id !== '' ? ' id="' . e($id) . '"' : '' ?>>
    <div class="c-contact-map__inner">

<?php if (!empty($s['index']) || !empty($s['eyebrow']) || !empty($s['lede'])): ?>
        <div class="c-contact-map__head">
<?php if (!empty($s['index'])): ?>
            <span class="c-contact-map__index"><?= e($s['index']) ?></span>
<?php endif; ?>
<?php if (!empty($s['eyebrow'])): ?>
            <p class="c-contact-map__eyebrow" data-reveal><?= e($s['eyebrow']) ?></p>
<?php endif; ?>
<?php if (!empty($s['lede'])): ?>
            <p class="c-contact-map__lede" data-reveal-lines><?= e($s['lede']) ?></p>
<?php endif; ?>
        </div>
<?php endif; ?>

        <?php component(['type' => 'map'] + $map, $c); ?>
    </div>
</section>
