<?php
/**
 * cta — eyebrow, a short line, one button.
 *
 * ONE button. The moment there are two, a reader has to choose between them
 * instead of doing the thing, and this site has exactly one conversion path
 * (ARCHITECTURE §3.3). The button is .c-btn from the chrome — the same control
 * as MEMBERSHIP in the header, which is the point of having one button.
 *
 * Fields
 *   eyebrow  optional tracked line
 *   title    the short line
 *   button   ['page_id' => 'membership', 'label' => 'Membership enquiry',
 *             'variant' => 'primary' | 'outline',
 *             'query'   => ['subject' => 'private-event']]
 *   mood     day | dusk | night
 *
 * 'query' IS THE ONE THING THAT MAY BE ADDED TO AN ADDRESS HERE, and it exists
 * for a single case: the call at the foot of /events sends a reader to the
 * enquiry form with the subject already chosen. The path still comes from
 * url() and routes.php — a content file names a page id and a parameter, never
 * an address — and the parameter is read by the component at the other end,
 * which checks it against its own schema before believing a word of it (see
 * components/form-enquiry.php).
 *
 * @var array $s this section
 * @var array $c the page content
 */

declare(strict_types=1);

$eyebrow = (string) ($s['eyebrow'] ?? '');
$title   = (string) ($s['title'] ?? '');
$button  = (array)  ($s['button'] ?? []);

$mood = in_array($s['mood'] ?? null, MOODS, true) ? $s['mood'] : null;

$variant = ($button['variant'] ?? 'primary') === 'outline' ? 'outline' : 'primary';

$href = !empty($button['page_id']) ? url((string) $button['page_id']) : '';

$query = array_filter((array) ($button['query'] ?? []), 'is_scalar');

if ($href !== '' && $query !== []) {
    // http_build_query encodes the pair; e() escapes the result for the
    // attribute. Both, because they are two different jobs.
    $href .= '?' . http_build_query($query);
}
?>
<section class="section c-cta<?= $mood ? ' section--' . e($mood) : '' ?>">
    <div class="wrap c-cta__inner stack" style="--stack-space: var(--space-5)">

<?php if ($eyebrow !== ''): ?>
        <p class="u-eyebrow"><?= e($eyebrow) ?></p>
<?php endif; ?>

<?php if ($title !== ''): ?>
        <h2 class="c-cta__title"><?= e($title) ?></h2>
<?php endif; ?>

<?php if ($href !== '' && !empty($button['label'])): ?>
        <p>
            <a class="c-btn c-btn--<?= e($variant) ?>" href="<?= e($href) ?>"><?= e((string) $button['label']) ?></a>
        </p>
<?php endif; ?>

<?php
/*
   THE BOOKING WIDGET, WHEN THERE IS ONE.

   Padel is the page this is waiting for: BOOK PADEL goes to Contact today
   because the booking system is undecided, and an enquiry answered by a person
   is a real answer rather than a dead button. When a system is chosen, this is
   where it lands — a slot on the one component that already owns the site's
   single conversion path, so that a widget arrives inside the existing block
   instead of becoming a second call to action next to it.

   The block replaces the button above it; it does not join it. ONE action, and
   the rule is in the note at the top of this file: a reader with a booking
   widget and a link to Contact in front of them has to choose between them
   instead of booking.

   Which means the content file decides, and the shape it will decide with is
   already here — 'button' for the link, 'booking' for the widget:

   <?php if (!empty($s['booking'])): ?>
   <div class="c-cta__booking" data-booking="<?= e((string) $s['booking']) ?>"></div>
   <?php endif; ?>

   Three things this component may not do when that day comes, all of them
   things the rest of the site already refuses:

     - no third-party script tag in the markup. The widget is loaded by
       main.js, on the same terms as the hero video: after load, and never as
       part of the first screen. A booking iframe in the document head is a
       third-party request on a page in the EU.
     - no English in here. The provider's own strings are configuration and
       come through data- attributes off the content file, the way the lightbox
       takes its labels from common.php.
     - no opening hours or prices in JSON-LD because a widget can be seen on
       the page. What is bookable is a content decision (ARCHITECTURE §13), and
       it stays one.
*/
?>
    </div>
</section>
