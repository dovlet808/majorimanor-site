<?php
/**
 * What a notification looks like, for either form.
 *
 * PLAIN TEXT, AND THAT IS THE RIGHT FORMAT FOR IT. This mail is read once, by
 * somebody deciding what to do about it, and possibly forwarded. It wants to
 * be legible in a preview pane, quotable in a reply, and searchable — none of
 * which a branded HTML table does better than aligned text. The letterhead is
 * for the sender's copy; this one is a form landing on a desk.
 *
 * EVERY FIELD, IN THE FORM'S OWN ORDER, and it is read from form_fields() so
 * that a field added to the schema turns up here without anybody remembering
 * to add it (see the note at the top of validate.php). An enquiry that is
 * silently missing an answer somebody gave is the failure this prevents.
 *
 * ESCAPING. The values arrive cleaned by form_clean() — no control characters,
 * so no CR or LF anywhere near a header, which is the injection this is
 * actually about (ARCHITECTURE §12.3). There is no markup in a plain-text body
 * to escape into, and the one field that keeps its newlines, the free text, is
 * printed in a block of its own where newlines are what it is made of.
 */

declare(strict_types=1);

/** The column the values line up on, in characters. */
const MAIL_LABEL_COLUMN = 24;

/**
 * One "Label            value" line, or two lines when the label is a question
 * too long to sit in the column.
 *
 * Padded with mb_strlen rather than str_pad, because str_pad counts bytes: a
 * label with a Latvian diacritic in it would be padded short by one column per
 * accented character, and the values would stop lining up on exactly the pages
 * where the site is meant to look most at home.
 */
function mail_field_line(string $label, string $value): string
{
    $width = mb_strlen($label, 'UTF-8');

    if ($width >= MAIL_LABEL_COLUMN - 1) {
        return $label . "\n    " . $value . "\n";
    }

    return $label . str_repeat(' ', MAIL_LABEL_COLUMN - $width) . $value . "\n";
}

/**
 * The body of a notification: a heading, every field in schema order, the free
 * text underneath, and when it arrived.
 *
 * @param  string                $formType 'membership' | 'enquiry'
 * @param  array<string, string> $values   cleaned, validated
 */
function mail_notify_body(string $formType, array $values): string
{
    $heading = t('mail.' . $formType . '.notify_heading');

    $body  = $heading . "\n";
    $body .= str_repeat('=', mb_strlen($heading, 'UTF-8')) . "\n\n";

    /*
       The free text is held back from the aligned block and printed under it,
       because it is the only answer that is a paragraph. Lining a paragraph up
       in a 24-character column produces a shape nobody can read, and it is the
       part of the enquiry most worth reading.
    */
    $freeText = [];

    foreach (form_fields($formType) as $field => $spec) {
        $value = (string) ($values[$field] ?? '');
        $label = t('form.' . $formType . '.fields.' . $field . '.label');
        $type  = (string) ($spec['type'] ?? 'text');

        // A radio or a select stores a value like 'private-event'; what belongs
        // in a mail to a person is the line that was on the control they used.
        if (($type === 'radio' || $type === 'select') && $value !== '') {
            $value = t('form.' . $formType . '.fields.' . $field . '.options.' . $value);
        }

        if ($type === 'textarea') {
            if ($value !== '') {
                $freeText[$label] = $value;
            }

            continue;
        }

        /*
           An unanswered optional field is printed as a dash rather than
           skipped. A reader of this mail should be able to see that the
           question was asked and left blank, which is not the same thing as
           the question not being on the form.
        */
        $body .= mail_field_line($label, $value !== '' ? $value : '—');
    }

    foreach ($freeText as $label => $value) {
        $body .= "\n" . $label . "\n";
        $body .= str_repeat('-', mb_strlen($label, 'UTF-8')) . "\n";
        $body .= $value . "\n";
    }

    /*
       When it arrived, in UTC and spelled out. The server's local time zone on
       shared hosting is whatever the host decided, so the zone is named rather
       than assumed — an enquiry timestamped 14:20 with no zone is an enquiry
       nobody can place against a phone call.
    */
    $body .= "\n" . str_repeat('-', MAIL_LABEL_COLUMN + 24) . "\n";
    $body .= mail_field_line(
        t('mail.' . $formType . '.notify_received'),
        gmdate('Y-m-d H:i') . ' UTC'
    );

    return $body;
}

/** The estate's own mailbox. MAIL_TO in private/config.php. */
function mail_notify_to(): string
{
    return defined('MAIL_TO') ? (string) MAIL_TO : (string) SMTP_FROM;
}
