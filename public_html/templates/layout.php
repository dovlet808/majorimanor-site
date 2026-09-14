<?php
/**
 * The page frame. Included by index.php after the page has been rendered.
 *
 * Everything a page has in common is here and only here: the skip link first
 * inside <body>, the fixed header, the content, the footer. A page template
 * renders what is between them and never the frame itself.
 *
 * data-mood on <body> is the page's colour temperature, from its content file
 * through mood(). It is what the whole stylesheet reads — see §3 of main.css —
 * so the frame carries it and nothing below has to know about it.
 *
 * data-hero says the page opens on a full-height hero. The header uses it to
 * start transparent; main.css uses it to let the hero run under the header
 * instead of below it.
 *
 * A PAGE MAY OWN ITS OWN CHROME, and exactly one does. 'own_chrome' => true in
 * a content file leaves the site header and footer off and lets the page render
 * its own. It exists for the Main Page, whose navigation addresses the scenes
 * of that page rather than the eleven pages of the site — a bar that says
 * DINING and lands on a section is not the same object as a bar that says THE
 * ESTATE and lands on a page, and making one bar do both would have meant
 * putting the film's anchors into routes.php, where they do not belong.
 *
 * The skip link is rendered either way and always points at #main, so the
 * first thing a keyboard reaches is the same on every page of the site.
 *
 * @var string $content rendered page markup
 * @var array  $c       page content
 * @var array  $t       interface strings
 */

declare(strict_types=1);

$ownChrome = !empty($c['own_chrome']);
?>
<!doctype html>
<html lang="<?= e(current_lang()) ?>">
<?php require TEMPLATES_PATH . '/partials/head.php'; ?>
<body data-mood="<?= e(mood()) ?>"<?= has_hero() ? ' data-hero' : '' ?>>

<?php require TEMPLATES_PATH . '/partials/skip-link.php'; ?>
<?php if (!$ownChrome) { require TEMPLATES_PATH . '/partials/header.php'; } ?>

<main id="main" tabindex="-1">
<?= $content ?>
</main>

<?php if (!$ownChrome) { require TEMPLATES_PATH . '/partials/footer.php'; } ?>

</body>
</html>
