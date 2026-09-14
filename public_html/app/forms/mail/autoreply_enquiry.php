<?php
/**
 * The autoreply to a general enquiry: the receipt, in the estate's own hand.
 *
 * THE LETTER IS BUILT BY mail_letter() IN letter.php, which is where the crest,
 * the measure, the plain-text alternative, the signature and the manor's clock
 * live — the parts that are the same message whichever form was filled in. What
 * is decided here is what this letter says, and the list is closed:
 *
 *   a preheader naming the subject they chose, for the message list
 *   a greeting with their name in it
 *   a line of thanks
 *   the confirmation that it arrived and that a person will answer
 *   a receipt: the subject, and when it reached us
 *   one paragraph about the house, lifted word for word from /estate
 *   the line for somebody who did not write to us
 *
 * WHAT IS NOT, AND WHY EACH ONE STAYED OUT:
 *
 *   NO TIMELINE. Not a number of hours, not a number of days, not "shortly",
 *     not "as soon as possible". "Someone will reply personally" is a promise
 *     the estate keeps by answering; every other phrasing is a clock somebody
 *     else started, and an email is kept and quoted back.
 *   NO COPY OF THEIR MESSAGE. The free text runs to two thousand characters
 *     and they wrote it four seconds ago. Quoting it back pushes the letter
 *     below the fold, and tells them nothing they did not just type. The
 *     subject and the time are the parts of a receipt worth having, because
 *     they are the parts that answer "did the right thing arrive".
 *   NO PRIVACY LINE. The membership letter carries one because that form asks
 *     for an occupation and for free text about the applicant; this form asks
 *     for a way to answer and a question, and its own notice above the button
 *     says exactly that. A pointer that overstates what was collected is as
 *     inaccurate as one that understates it.
 *   NO MARKETING, NO "WE ARE EXCITED", NO UNSUBSCRIBE. This is transactional,
 *     sent once, in answer to something the person just did.
 *
 * THE ONE PARAGRAPH ABOUT THE MANOR IS NOT NEW COPY AND MUST NOT BECOME NEW
 * COPY. It is t('mail.about'), which is word for word the hero lede of
 * content/en/estate.php — the page that carries the estate's approved facts
 * (ARCHITECTURE §11). An email is the easiest place on this project to write a
 * sentence nobody approved, and the hardest to take back: it is not a page that
 * can be edited after the fact. If this paragraph is ever changed, it is
 * changed on /estate first and copied there second.
 *
 * ESCAPING. Nothing is escaped in this file, and that is deliberate: every
 * value handed to mail_letter() is plain text and is escaped in the HTML part
 * by mail_template(), so there is exactly one place where it can be got wrong.
 * The name arrives from a public form and may hold < > & " — see
 * mail_letter_text() for why the plain-text part does NOT escape it.
 */

declare(strict_types=1);

require_once __DIR__ . '/letter.php';

/**
 * The line the message list prints beside the subject.
 *
 * Held to the 40–90 characters a client will show; the strings in common.php
 * are written so every one of the five subjects lands inside it, and
 * tools/mail_preview.php asserts that they do.
 */
function mail_autoreply_enquiry_preheader(string $subjectLabel): string
{
    if (trim($subjectLabel) === '') {
        return t('mail.enquiry.autoreply_preheader_plain');
    }

    return str_replace('{subject}', trim($subjectLabel), t('mail.enquiry.autoreply_preheader'));
}

/**
 * Build the autoreply.
 *
 * @param  array<string, string> $values cleaned, validated
 * @return array{to: string, to_name: string, subject: string, html: string,
 *               text: string, reply_to: string, embed: array{path: string, cid: string}}
 */
function mail_autoreply_enquiry(array $values): array
{
    $name    = (string) ($values['name'] ?? '');
    $subject = (string) ($values['subject'] ?? '');

    /*
       The reader's own words off the select, never the stored value — the
       same rule the notification's subject line follows. A receipt that says
       "Subject: private-event" is a slug that escaped.

       The value has been through form_validate(), which only lets one of the
       schema's own options past, so this lookup cannot miss on a submission
       that reached the mailer. The guard is for the day somebody calls this
       from somewhere else.
    */
    $subjectLabel = $subject !== ''
        ? t('form.enquiry.fields.subject.options.' . $subject)
        : '';

    $letter = mail_letter([
        'preheader'  => mail_autoreply_enquiry_preheader($subjectLabel),
        'salutation' => mail_letter_salutation($name),

        /*
           THANKS FIRST, THEN THE CONFIRMATION. The same shape as the
           membership letter and for the same reason: the first thing under the
           greeting should be the thing a person would say, not the thing a
           mailer would. The line under it is the one that makes the promise —
           somebody will read it and answer — and it is still the only promise
           in this letter.
        */
        'lines' => [
            t('mail.enquiry.autoreply_thanks'),
            t('mail.enquiry.autoreply_confirm'),
        ],

        'detail' => [
            ['label' => t('mail.enquiry.autoreply_subject_label'), 'value' => $subjectLabel],
            ['label' => t('mail.received_label'),                  'value' => mail_letter_received()],
        ],

        /*
           The paragraph about the house sits under the receipt rather than
           above it. The reader came for the confirmation; the house is what
           they read once they have it.
        */
        'after' => [
            t('mail.about'),
        ],

        'closing' => t('mail.enquiry.autoreply_disregard'),
    ]);

    return [
        'to'      => (string) ($values['email'] ?? ''),
        'to_name' => $name,
        'subject' => t('mail.enquiry.autoreply_subject'),
        'html'    => $letter['html'],
        'text'    => $letter['text'],

        /*
           REPLY-TO IS THE REAL MAILBOX, not the no-reply@ this is sent from.
           Somebody who replies to a receipt should reach a person rather than
           a bounce, and on this form they are more likely to than on the other
           one: an enquiry is a conversation that has just started.
        */
        'reply_to' => defined('MAIL_TO') ? (string) MAIL_TO : '',

        'embed' => [
            'path' => PUBLIC_PATH . '/assets/img/brand/crest-green.png',
            'cid'  => MAIL_CREST_CID,
        ],
    ];
}
