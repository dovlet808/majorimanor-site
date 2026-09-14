<?php
/**
 * The autoreply to a membership application: the first thing an applicant ever
 * receives from the estate.
 *
 * THE LETTER IS BUILT BY mail_letter() IN letter.php — the crest, the 600px
 * measure, the plain-text alternative, the signature and the manor's clock are
 * shared with the enquiry autoreply and are not this file's to decide. What is
 * decided here is what this letter says, and the list is closed:
 *
 *   a preheader saying the application arrived, for the message list
 *   a greeting with their name in it
 *   three lines: thanks, that it reached the manor, and that applications are
 *     read individually
 *   a receipt: when it reached us
 *   one paragraph about what membership is, lifted word for word from the
 *     opening of /membership
 *   one line pointing at /privacy
 *   the line for somebody who did not apply
 *
 * IT SAYS "APPLICATION" AND NEVER "ENQUIRY", and neither does anything else
 * this form touches — the subject line, the notification to info@, the button
 * and the form's accessible name were all settled on the one word. /membership
 * calls it an application, the thank-you on the page calls it an application
 * and ARCHITECTURE §12.2 calls it an application; the mail layer was the last
 * place still calling it something else. The contact form's enquiry is
 * untouched and stays an enquiry, because that is what it is.
 *
 * WHAT IS NOT, AND EACH OF THESE WAS CONSIDERED AND LEFT OUT:
 *
 *   NO TIMELINE. Not a number of days, not "shortly", not "in due course".
 *     /membership states plainly that no time is quoted against an application,
 *     and this letter is the one artefact of the whole exchange that the
 *     applicant keeps, can re-read, and can quote back.
 *   NOTHING THAT SOUNDS LIKE A YES. No "we look forward to welcoming you", no
 *     "your place", no "the next step is". The estate has not decided anything
 *     at the moment this mail is sent — it is sent by the form, four seconds
 *     after the button — and a courtesy that reads as an acceptance is the one
 *     mistake in this letter that would be read as a promise and remembered as
 *     a broken one.
 *   NO ECHO OF WHAT THEY WROTE. The receipt names when the application arrived
 *     and nothing else. Their country, their occupation, the member who
 *     referred them and the paragraph about why they want to join are on their
 *     way to info@; a mailbox is not the place to store somebody's answers back
 *     at them, and an application quoted back in full is a document that can be
 *     forwarded, screenshotted or read over a shoulder.
 *   NO MEMBERSHIP CATEGORY, BECAUSE THERE IS NONE. The form collects no tier,
 *     no plan and no level — see form_fields('membership') in validate.php and
 *     the list in ARCHITECTURE §12.2. /membership says it in words: there is
 *     one membership and there are no tiers. A receipt naming a category would
 *     be inventing one.
 *   NO UNSUBSCRIBE. This is transactional, sent once, in answer to something
 *     the person just did. There is no list to leave.
 *
 * The tone rule from ARCHITECTURE §1: if the line could stand on a travel
 * agency's banner, it does not go in. Restraint is the message — an applicant
 * who has just asked to join a private estate learns more about it from a
 * receipt and two quiet lines than from a page of welcome.
 *
 * ESCAPING. Nothing is escaped in this file, and that is deliberate: every
 * value handed to mail_letter() is plain text and is escaped in the HTML part
 * by mail_template(). The name arrives from a public form and may hold < > & "
 * — see mail_letter_text() for why the plain-text part does NOT escape it.
 */

declare(strict_types=1);

require_once __DIR__ . '/letter.php';

/**
 * Build the autoreply.
 *
 * @param  array<string, string> $values cleaned, validated
 * @return array{to: string, to_name: string, subject: string, html: string,
 *               text: string, reply_to: string, embed: array{path: string, cid: string}}
 */
function mail_autoreply_membership(array $values): array
{
    $name    = (string) ($values['name'] ?? '');
    $surname = (string) ($values['surname'] ?? '');

    $letter = mail_letter([
        'preheader' => t('mail.membership.autoreply_preheader'),

        /*
           THE GIVEN NAME ALONE, AND THIS FORM IS THE ONE THAT CAN. It asks for
           a name and a surname in two fields, where the enquiry form asks for
           one line and gets whatever the sender considers their name. "Dear
           Anna," is a person writing to a person; "Dear Anna Bērziņa," is a
           record being addressed, which is the register of a letter about an
           application rather than a letter to an applicant.

           The To: header below still carries both, because that is a name on
           an envelope and not a greeting.
        */
        'salutation' => mail_letter_salutation($name),

        /*
           THREE LINES, AND THE ORDER OF THEM IS LOAD-BEARING.

           THANKS, then the receipt, then how applications are handled. The
           thanks is first because that is where a person writing back would put
           it and because everything under it is colder — a letter that opens on
           a timestamp is a machine answering. It says nothing about outcome or
           timing; see the note on the string in common.php.

           THE THIRD LINE IS THE PAGE'S OWN SENTENCE, WORD FOR WORD.
           ARCHITECTURE §12.2 fixes the thank-you on /membership and forbids
           editing it; an applicant who reads the screen and then the email
           should be told one thing, once, in the same words.

           IT ALSO HAS TO STAY ABOVE THE PARAGRAPH IN 'after'. That paragraph
           is about what membership is, and "Membership applications are
           reviewed individually" is the sentence that stops it being read as a
           description of what this applicant is about to get. Move the
           paragraph up here and the letter starts making an offer.
        */
        'lines' => [
            t('mail.membership.autoreply_thanks'),
            t('mail.membership.autoreply_confirm'),
            t('mail.membership.autoreply_reviewed'),
        ],

        /*
           ONE ROW, AND IT IS THE WHOLE RECEIPT.

           The enquiry letter's block has two rows because that form has a
           subject: a closed list of five, chosen from a select, and worth
           showing back because it is the part that answers "did the right
           thing arrive". This form has no equivalent. Every other answer it
           collects is free text somebody typed about themselves, and the one
           closed-option field on it — whether a member referred them, and who
           — is the last thing that belongs in an unencrypted mail sent to an
           address that has not been confirmed.

           So the receipt is the time, which is the part of any receipt that
           cannot be got from the sent-items folder.
        */
        'detail' => [
            ['label' => t('mail.received_label'), 'value' => mail_letter_received()],
        ],

        /*
           THE PARAGRAPH, AND IT IS /membership's OWN OPENING AND NOT /estate's
           LEDE.

           This letter carried t('mail.about') — the hero lede of The Estate —
           until this pass, for no better reason than that the enquiry letter
           carries it and the two were built from the same list. It is the
           wrong paragraph here. Somebody who has just filled in the form at the
           bottom of /membership has read about the house; what the letter they
           keep should hold is the page they applied from, which opens on what
           membership actually is: one membership, no tiers, the estate.

           IT IS APPROVED COPY AND IS NOT REWRITTEN FOR THE MAIL. Word for word
           the first paragraph of the "One membership" section on
           content/en/membership.php, held in common.php as
           mail.membership.autoreply_about with the same rule 'about' has —
           changed on the page first and in the mail second.

           IT IS BELOW THE RECEIPT AND BELOW "reviewed individually", which is
           the condition on using it at all. See the note on 'lines' above.
        */
        'after' => [
            t('mail.membership.autoreply_about'),
        ],

        /*
           THE POINTER TO /privacy, AND IT IS ON THIS LETTER AND NOT THE OTHER.
           This form collects an occupation and free text somebody has written
           about themselves; the notice on the form itself is what informs the
           consent (ARCHITECTURE §12.3), and this is the address of that page
           in the copy they keep. The href is built from routes.php through
           mail_letter_url(), so on dev it points at dev.
        */
        'note' => [
            'text'  => t('mail.membership.autoreply_privacy'),
            'label' => t('mail.privacy_link'),
            'href'  => mail_letter_url('privacy'),
        ],

        'closing' => t('mail.membership.autoreply_disregard'),
    ]);

    return [
        'to'      => (string) ($values['email'] ?? ''),
        'to_name' => trim($name . ' ' . $surname),
        'subject' => t('mail.membership.autoreply_subject'),
        'html'    => $letter['html'],
        'text'    => $letter['text'],

        /*
           REPLY-TO IS THE REAL MAILBOX, not the no-reply@ this is sent from.

           The sender has to be the authenticated address, and it has to be one
           nobody watches. But an applicant who replies to it — and some will,
           because replying to a message is what people do — should reach a
           person rather than a bounce. This costs nothing and is the
           difference between a courtesy and a wall.
        */
        'reply_to' => defined('MAIL_TO') ? (string) MAIL_TO : '',

        'embed' => [
            'path' => PUBLIC_PATH . '/assets/img/brand/crest-green.png',
            'cid'  => MAIL_CREST_CID,
        ],
    ];
}
