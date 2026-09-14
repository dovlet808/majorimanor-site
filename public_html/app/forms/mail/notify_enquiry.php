<?php
/**
 * The notification: a general enquiry, as it lands in info@.
 *
 * The body is mail_notify_body() in notify.php, the same shape as the
 * membership notification. What is this file's own is the subject line, and it
 * is the reason the form has a subject field at all.
 *
 * THE SUBJECT LINE CARRIES THE CHOSEN SUBJECT, SO THE INBOX SORTS ITSELF:
 *
 *     Enquiry — Private event — Anna Bērziņa
 *     Enquiry — Padel — Jonas Kazlauskas
 *
 * One mailbox takes everything the site sends, and whoever opens it can see
 * from the list which of these is a wedding and which is a court booking,
 * without opening any of them. That is worth more than a second address per
 * subject, which is a second address to forward, watch and eventually forget.
 *
 * The printed subject is t('form.enquiry.fields.subject.options.<value>') —
 * the same line the sender chose off the select, not the stored value. A
 * subject line reading "Enquiry — private-event —" is a slug that escaped.
 *
 * THE SENDER IS ON REPLY-TO, exactly as on the membership notification: the
 * mail is from no-reply@ because that is the authenticated sender, and hitting
 * reply has to reach the person who asked.
 */

declare(strict_types=1);

require_once __DIR__ . '/notify.php';

/**
 * Build the notification.
 *
 * @param  array<string, string> $values cleaned, validated
 * @return array{to: string, subject: string, text: string, reply_to: string, reply_to_name: string}
 */
function mail_notify_enquiry(array $values): array
{
    $name    = (string) ($values['name'] ?? '');
    $subject = (string) ($values['subject'] ?? '');

    /*
       The value has been through form_validate(), which only lets one of the
       schema's own options past — so this lookup cannot miss on a submission
       that reached the mailer. The guard is for the day somebody calls this
       from somewhere else.
    */
    $subjectLabel = $subject !== ''
        ? t('form.enquiry.fields.subject.options.' . $subject)
        : '';

    $line = str_replace(
        ['{subject}', '{name}'],
        [$subjectLabel, $name],
        t('mail.enquiry.notify_subject')
    );

    return [
        'to'            => mail_notify_to(),
        'subject'       => $line,
        'text'          => mail_notify_body('enquiry', $values),
        'reply_to'      => (string) ($values['email'] ?? ''),
        'reply_to_name' => $name,
    ];
}
