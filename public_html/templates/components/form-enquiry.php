<?php
/**
 * form-enquiry — the general enquiry form.
 *
 * Five fields — name, email, phone, subject, message — and the same everything
 * else as the membership form: the honeypot, the signed time-trap, the rate
 * limiter, server-side validation, the error summary that takes focus, and the
 * thank-you rendered in place of the form with no redirect and no script. All
 * of that lives once, in templates/partials/form.php; this file is the schema
 * key, the page's options, and nothing besides.
 *
 * Its thank-you is not the membership form's, and the difference is the point:
 *
 *     Thank you.
 *     We will be in touch.
 *
 * An enquiry gets an answer. An application gets read. The two forms say
 * exactly as much as is true of each, and neither borrows the other's promise.
 *
 * THE SUBJECT FIELD IS WHAT MAKES ONE FORM ENOUGH. It carries the chosen line
 * into the notification's subject — "Enquiry — Private event — Anna Bērziņa" —
 * so a single mailbox sorts itself, and /events, /residences and /contact do
 * not need a form each (ARCHITECTURE §12.1).
 *
 * WHICH SUBJECT IT STARTS ON, in order of precedence:
 *
 *   1. what was submitted, when this is a form coming back with errors — the
 *      renderer sees to that, and nothing here can override what somebody typed
 *   2. ?subject=<value> on the address. This is how a link preselects: the CTA
 *      at the foot of /events points at /contact?subject=private-event, and
 *      the reader arrives on the form already looking at the right line. A
 *      query parameter rather than script or a session, because it has to work
 *      with JavaScript switched off and survive being bookmarked
 *   3. 'subject_default' in the content file, for a page whose form is always
 *      about one thing
 *   4. otherwise the schema's first option, which is 'general'
 *
 * Both 2 and 3 are checked against the schema's own option list and ignored
 * when they do not match, so an address with a made-up subject on it renders
 * the ordinary form rather than an empty select — and nothing off the wire is
 * ever printed.
 *
 * THE FIELD IS NEVER HIDDEN, PRESELECTED OR NOT. A sender who followed the
 * events CTA but actually wants to ask about padel has to be able to say so —
 * and a hidden field carrying a value somebody cannot see is the shape of a
 * form that files enquiries in the wrong place and never tells anybody why.
 *
 * Fields
 *   eyebrow          optional tracked line above the heading
 *   title            optional h2 — also the form's accessible name when present
 *   body             optional string[] — a paragraph each, above the fields
 *   id               anchor for the section
 *   mood             day | dusk | night
 *   subject_default  one of the subject values in form_fields('enquiry')
 *
 * @var array $s this section
 * @var array $c the page content
 */

declare(strict_types=1);

require_once TEMPLATES_PATH . '/partials/form.php';

$enquirySubjects = (array) (form_fields('enquiry')['subject']['options'] ?? []);

/*
   The query parameter first, then the content file's default. A reader who
   followed a link asking about one thing is making a later and more specific
   statement than the page is, and either way the select is on screen and can
   be changed.
*/
$enquirySubject = (string) ($_GET['subject'] ?? '');

if (!in_array($enquirySubject, $enquirySubjects, true)) {
    $enquirySubject = (string) ($s['subject_default'] ?? '');
}

if ($enquirySubject !== '' && !in_array($enquirySubject, $enquirySubjects, true)) {
    if (DEV) {
        trigger_error("form-enquiry: unknown subject_default '{$enquirySubject}'", E_USER_WARNING);
    }

    $enquirySubject = '';
}

form_render('enquiry', $s, $enquirySubject !== '' ? ['defaults' => ['subject' => $enquirySubject]] : []);
