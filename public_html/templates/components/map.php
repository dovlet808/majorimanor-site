<?php
/**
 * map — where the estate is, on a map that costs nothing until it is looked at.
 *
 * THREE STATES, AND THE FIRST TWO ARE THE SAME MARKUP.
 *
 *   no script          the placeholder below: the address, set on the map's own
 *                      ground, and a link that hands the coordinates to
 *                      whatever the reader uses for maps
 *   script, not yet
 *   scrolled to        the same placeholder — nothing has been fetched
 *   scrolled to        Leaflet and the tiles arrive, the map is built inside
 *                      the frame, and the placeholder is taken out of the way
 *
 * NOTHING IS FETCHED UNTIL THE READER ARRIVES AT IT. Leaflet is about 160 KB of
 * script and stylesheet and the tiles are a dozen requests to somebody else's
 * server; on a contact page that is most of the page's weight, spent on the one
 * element most readers scroll past. An IntersectionObserver in main.js holds
 * all of it until the frame is near the window — and the address, which is what
 * they actually came for, is in the markup and on the screen the whole time.
 *
 * LEAFLET IS SERVED FROM assets/js/leaflet/ AND NEVER FROM A CDN (see the
 * README beside it). The tiles are the one exception on this site and they
 * cannot be anything else: a tile server is a server, and CARTO's is the one
 * the brief names. Which is the second reason for the observer — a reader who
 * never scrolls to the map makes no request to any third party from this site
 * at all, and that is a statement the privacy page is able to make because of
 * this component.
 *
 * THE PLACEHOLDER IS NOT A LOADING SPINNER. It is the answer to the question,
 * printed: an address somebody can read, select and copy. If the script never
 * runs, if Leaflet fails to load, if the tile host is unreachable or blocked —
 * the page still says where Majori Manor is. That is the whole design.
 *
 * THE LINK HANDS OFF, IT DOES NOT SEND ANYBODY ANYWHERE. A geo: URI is the
 * coordinates and nothing else, so it opens in whatever the reader's device
 * uses for maps and makes no request to Google, Apple or anyone. The trade is
 * that a desktop with nothing registered for geo: does nothing when it is
 * clicked, which is why the coordinates are also printed as text beside it —
 * legible, selectable, and the one form of them that works everywhere.
 *
 * Fields
 *   id       anchor for the section
 *   label    the accessible name of the map region
 *   address  string[] — one line each, printed as written
 *   open     the text of the hand-off link
 *   lat lng  decimal degrees
 *   zoom     the starting zoom
 *   mood     day | dusk | night
 *
 * @var array $s this section
 * @var array $c the page content
 */

declare(strict_types=1);

/**
 * The tiles. CARTO's dark basemap, the same one the GP IMPEX site runs.
 *
 * THIS IS THE ONLY EXTERNAL HOST ANY PAGE OF THIS SITE TALKS TO, and it is
 * reached only after a reader has scrolled to the map. Nothing else on the
 * site — no font, no script, no stylesheet, no image, no analytics — comes
 * from anywhere but this server.
 */
const MAP_TILES = 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png';
const MAP_TILE_SUBDOMAINS = 'abcd';

/**
 * THE TILES NOW WANT A KEY, AND AS OF THIS WRITING WE DO NOT HAVE ONE.
 *
 * CARTO changed the terms of their raster basemaps: the URL above still answers
 * 200 and still draws Jūrmala, but every tile now comes back with "API KEY
 * REQUIRED / carto.com/basemaps/apikey" written diagonally across it. Nothing
 * on this site broke — the component, the observer, the pin, the placeholder,
 * the coordinates, the geo: hand-off, the pan and the zoom all work exactly as
 * they did — but the pictures underneath them are watermarked.
 *
 * THE FIX IS A KEY AND IT IS ONE LINE IN private/config.php:
 *
 *     define('MAP_API_KEY', '…');   // from a CARTO account
 *
 * With that defined the key is appended to the template below and the tiles
 * come back clean. With it undefined — which is the state today, and the state
 * of the sample config — the URL printed onto the frame is byte for byte the
 * one this component has always printed, so nothing about the page changes.
 *
 * THE PROVIDER IS NOT CHANGED HERE AND THAT IS DELIBERATE. /privacy carries an
 * approved clause that names CARTO by name and tells a reader that opening the
 * map makes a request to their servers and to nobody else's. Swapping the tile
 * host would make that sentence false, and /privacy is not this page's to edit.
 * Which company receives a visitor's IP address is the owner's decision, not a
 * detail of a stylesheet — see docs/CONTACT.md §9.
 */
$mapKey = defined('MAP_API_KEY') ? trim((string) MAP_API_KEY) : '';

$mapTiles = $mapKey !== ''
    ? MAP_TILES . '?api_key=' . rawurlencode($mapKey)
    : MAP_TILES;

/**
 * Attribution, which is a licence condition and not copy.
 *
 * It lives here rather than in content/en/ on purpose: these are two
 * organisations' names and two of their URLs, they are identical in every
 * language, and a translator given them as strings would eventually translate
 * one. OpenStreetMap's data is ODbL and the credit is a condition of using it;
 * CARTO's terms require theirs. NEITHER IS OPTIONAL AND NEITHER MAY BE REMOVED.
 *
 * WHAT IS OPTIONAL IS WHERE IT SITS, AND IT IS NOT INSIDE THE MAP.
 *
 * Leaflet's default is a small plate in the bottom corner of the canvas, and
 * that plate is the thing that makes a map read as an embedded widget rather
 * than as a figure on a page. So the credit is printed here instead, in the
 * thin line under the frame that already carries the coordinates — smaller
 * than the body text, in the page's own ink, and not on a plate of its own.
 * The control inside the canvas is switched off in main.js.
 *
 * IT IS IN THE MARKUP BUT NOT ON SCREEN UNTIL THE TILES ARE. Nothing is
 * credited while the frame is still standing in as a printed address: there is
 * no map yet to credit. The stylesheet reveals it on [data-map-ready], which
 * the same script sets when Leaflet has built — so the credit and the tiles it
 * is for appear together, and neither can appear without the other.
 *
 * LEAFLET IS NOT ON THIS LIST, AND ITS OWN PREFIX IS TURNED OFF IN main.js.
 * That part is the library's credit for itself and not a licence condition.
 */
const MAP_ATTRIBUTION = [
    ['label' => 'CARTO',         'url' => 'https://carto.com/attributions'],
    ['label' => 'OpenStreetMap', 'url' => 'https://www.openstreetmap.org/copyright'],
];

$anchor  = (string) ($s['id'] ?? '');
$label   = (string) ($s['label'] ?? '');
$open    = (string) ($s['open'] ?? '');
$address = array_values(array_filter((array) ($s['address'] ?? []), 'strlen'));

$mood = in_array($s['mood'] ?? null, MOODS, true) ? $s['mood'] : null;

/*
   The pin. Printed to four decimal places, which is about eleven metres and is
   as precise as a building needs; more digits would be a claim about a doorway.
   Cast through float so a content file cannot put anything but a number into an
   attribute the script parses.
*/
$lat  = round((float) ($s['lat'] ?? 0), 4);
$lng  = round((float) ($s['lng'] ?? 0), 4);
$zoom = (int) ($s['zoom'] ?? 16);

$coordinates = $lat . ', ' . $lng;

/*
   geo:lat,lng?q=lat,lng(Name) — the query is what puts a named pin on the map
   rather than merely centring it, and it is understood by the handlers that
   understand geo: at all. The name is escaped for a URI here and for HTML by
   e() below, because they are two different jobs and the attribute needs both.
*/
$geo = 'geo:' . $lat . ',' . $lng
    . '?q=' . $lat . ',' . $lng
    . '(' . rawurlencode(t('site.name')) . ')';

$attribution = implode(' · ', array_map(
    static fn (array $link): string =>
        '<a href="' . e($link['url']) . '" rel="noopener">' . e($link['label']) . '</a>',
    MAP_ATTRIBUTION
));

if ($lat === 0.0 && $lng === 0.0) {
    if (DEV) {
        trigger_error('map(): no coordinates', E_USER_WARNING);
    }

    return;
}
?>
<div class="c-map"<?= $anchor !== '' ? ' id="' . e($anchor) . '"' : '' ?><?= $mood ? ' data-mood-block="' . e($mood) . '"' : '' ?>>

    <?php /*
        The frame carries everything the script needs and the script reads
        nothing else: two asset paths with their cache-busting stamps, the tile
        template, the attribution, the pin and the zoom. main.js therefore
        contains no URL, no coordinate and no word of English — the same
        arrangement the gallery uses for the lightbox's labels.

        role="img" with a label, and not role="application": until the script
        runs this is a picture of an address, and afterwards Leaflet manages
        its own keyboard interaction inside it.
    */ ?>
    <?php /*
        data-ground="deep" is the footer's ground — green-900, cream, gold —
        and it is what lets everything inside the frame read --bg, --fg and
        --accent instead of naming a colour: the placeholder, the pin and
        Leaflet's own controls all sit on a dark plate on a cream page without
        a single brand colour in the map's stylesheet (§3 of main.css).
    */ ?>
    <div class="c-map__frame"
         data-ground="deep"
         role="img"
         aria-label="<?= e($label) ?>"
         data-map
         data-map-css="<?= e(asset_url('/assets/js/leaflet/leaflet.css')) ?>"
         data-map-js="<?= e(asset_url('/assets/js/leaflet/leaflet.js')) ?>"
         data-map-tiles="<?= e($mapTiles) ?>"
         data-map-subdomains="<?= e(MAP_TILE_SUBDOMAINS) ?>"
         data-map-lat="<?= e((string) $lat) ?>"
         data-map-lng="<?= e((string) $lng) ?>"
         data-map-zoom="<?= e((string) $zoom) ?>">

        <?php /* Leaflet builds into this and nothing else is ever put in it. */ ?>
        <div class="c-map__canvas" data-map-canvas></div>

        <div class="c-map__placeholder" data-map-placeholder>
            <p class="u-eyebrow c-map__name"><?= e(t('site.name')) ?></p>
            <p class="c-map__address">
<?php foreach ($address as $index => $line): ?>
                <?= $index > 0 ? '<br>' : '' ?><?= e((string) $line) ?>
<?php endforeach; ?>
            </p>
        </div>

    </div>

    <p class="c-map__note">
<?php if ($open !== ''): ?>
        <a class="c-map__open" href="<?= e($geo) ?>"><?= e($open) ?></a>
<?php endif; ?>
        <span class="c-map__coordinates"><?= e($coordinates) ?></span>

        <?php /* Already escaped: $attribution is two <a> elements built above
                 out of the constant, and e() was applied to each label and URL
                 as it went in. Escaping the assembled string here would print
                 the markup instead of rendering it. */ ?>
        <span class="c-map__credit"><?= $attribution ?></span>
    </p>

</div>
