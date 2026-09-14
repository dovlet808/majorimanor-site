<?php
/**
 * The world of Majori Manor — the index of the estate, as eight plates.
 *
 * IT IS A LIST OF LINKS AND IT IS BUILT AS ONE. Every item is an <a> around a
 * picture, a label and a line of description, so the whole section works from
 * the keyboard in the order it reads, and so a reader with no pointer — and
 * therefore no hover — has the description in front of them rather than behind
 * a state they cannot enter. Nothing here is revealed by hovering; hover only
 * lifts the plate and warms its rule.
 *
 * The eight are the eight the brief names, and each one now leaves the page.
 * They used to be anchors into the film's own scenes, which made this section
 * an index of itself: eight ways in that led back to where the reader already
 * was. An item declares a 'page_id' and url() resolves it, so the addresses
 * come from routes.php like every other address on the site and none of them
 * is written down here.
 *
 * EIGHT ITEMS, SIX PAGES. The estate has more rooms than the site has pages,
 * so Dining and Private Club both land on The Club, and Wellness lands beside
 * Padel — those are the pages that hold them. It is not a fault to be tidied
 * away by inventing pages: the tile names the room, the page names where the
 * room is.
 *
 * @var array $s
 * @var array $c
 */

declare(strict_types=1);

$items = (array) ($s['items'] ?? []);
$id    = !empty($s['id']) ? ' id="' . e($s['id']) . '"' : '';
?>
<section class="c-film-world"<?= $id ?>>
    <div class="c-film-world__head">
<?php if (!empty($s['index'])): ?>
        <span class="c-film-world__index"><?= e($s['index']) ?></span>
<?php endif; ?>
<?php if (!empty($s['eyebrow'])): ?>
        <p class="c-film-world__eyebrow" data-reveal><?= e($s['eyebrow']) ?></p>
<?php endif; ?>
<?php if (!empty($s['title'])): ?>
        <h2 class="c-film-world__title" data-reveal-lines><?= e($s['title']) ?></h2>
<?php endif; ?>
    </div>

    <ul class="c-film-world__list">
<?php foreach ($items as $index => $item): ?>
        <li class="c-film-world__item" data-plate>
            <a class="c-film-world__link" href="<?= e(url((string) ($item['page_id'] ?? 'home'))) ?>">
                <span class="c-film-world__plate">
                    <?= img(
                        (string) ($item['name'] ?? ''),
                        '(min-width: 1240px) 22vw, (min-width: 900px) 30vw, (min-width: 620px) 44vw, 84vw',
                        (string) ($item['alt'] ?? ''),
                        [
                            'widths' => [640, 960],
                            'ratio'  => '4/5',
                            'source' => (string) ($item['source'] ?? 'render'),
                            'class'  => 'c-film-world__img',
                        ]
                    ) ?>
                </span>

                <span class="c-film-world__meta">
                    <span class="c-film-world__n"><?= e(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)) ?></span>
                    <span class="c-film-world__label"><?= e($item['label'] ?? '') ?></span>
                </span>

<?php if (!empty($item['note'])): ?>
                <span class="c-film-world__note"><?= e($item['note']) ?></span>
<?php endif; ?>
            </a>
        </li>
<?php endforeach; ?>
    </ul>
</section>
