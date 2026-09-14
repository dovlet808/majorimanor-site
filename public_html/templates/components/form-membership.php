<?php
/**
 * form-membership — the application to join, and the site's one conversion
 * path (ARCHITECTURE §3.3).
 *
 * Eleven fields in the brief's own order, the referral pair that opens when
 * the answer is Yes, and a thank-you whose two lines are fixed by the concept:
 *
 *     Thank you.
 *     Membership applications are reviewed individually.
 *
 * All of it is schema and strings. The fields are form_fields('membership') in
 * app/forms/validate.php, the words are the 'form.membership' block in
 * content/en/common.php, and the markup that turns the one into the other is
 * templates/partials/form.php — shared with the enquiry form, so that the
 * honeypot, the time-trap, the error summary and the no-script behaviour are
 * one implementation and not two that drift.
 *
 * Fields
 *   eyebrow  optional tracked line above the heading
 *   title    optional h2 — also the form's accessible name when present
 *   body     optional string[] — a paragraph each, above the fields
 *   id       anchor for the section
 *   mood     day | dusk | night
 *
 * @var array $s this section
 * @var array $c the page content
 */

declare(strict_types=1);

require_once TEMPLATES_PATH . '/partials/form.php';

form_render('membership', $s);
