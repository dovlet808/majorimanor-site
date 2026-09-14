<?php
/**
 * The notification: a membership application, as it lands in info@.
 *
 * The shape of it — plain text, every field in the form's own order, the free
 * text underneath — is mail_notify_body() in notify.php, shared with the
 * enquiry notification. What is decided here is the subject line and who a
 * reply goes to.
 *
 * THE APPLICANT IS ON REPLY-TO. The mail is from no-reply@ because that is the
 * authenticated sender, but hitting reply has to reach the person who wrote
 * it, so their address goes on Reply-To with their name beside it.
 */

declare(strict_types=1);

require_once __DIR__ . '/notify.php';

/**
 * Build the notification.
 *
 * @param  array<string, string> $values cleaned, validated
 * @return array{to: string, subject: string, text: string, reply_to: string, reply_to_name: string}
 */
function mail_notify_membership(array $values): array
{
    $name = trim(($values['name'] ?? '') . ' ' . ($values['surname'] ?? ''));

    return [
        'to'            => mail_notify_to(),
        'subject'       => str_replace('{name}', $name, t('mail.membership.notify_subject')),
        'text'          => mail_notify_body('membership', $values),
        'reply_to'      => (string) ($values['email'] ?? ''),
        'reply_to_name' => $name,
    ];
}
