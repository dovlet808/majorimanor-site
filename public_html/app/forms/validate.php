<?php
/**
 * What a form's fields are, and what makes them valid.
 *
 * THE SCHEMA IS HERE AND NOWHERE ELSE, and three layers read it:
 *
 *   templates/partials/form.php                to draw the fields, in order
 *   app/forms/handler.php                      to validate what came back
 *   app/forms/mail/notify_*.php                to print every field in the mail
 *
 * A field added to the list below therefore appears on the page, is validated,
 * and turns up in the notification, without a second edit anywhere. The three
 * of them drifting apart is the failure this file exists to prevent: a field
 * the form draws but the handler does not validate is an unchecked string in
 * an email, and one the mail does not print is an application silently missing
 * an answer the applicant gave.
 *
 * NO ENGLISH IN THIS FILE. A label is a t() key into content/<lang>/common.php,
 * because a form is translated the same way the rest of the site is
 * (ARCHITECTURE §6.3). What lives here is structure: order, type, whether an
 * answer is required, and how long it may be.
 */

declare(strict_types=1);

/** The free-text field's hard cap, in characters (ARCHITECTURE §12.3). */
const FORM_TEXTAREA_MAX = 2000;

/**
 * An email address may be 254 characters — 64 for the local part, 255 for the
 * domain, and the practical limit of the whole is 254 (RFC 5321 §4.5.3.1).
 * Anything longer is not an address somebody typed.
 */
const FORM_EMAIL_MAX = 254;

/**
 * The fields of a form, in the order they are asked.
 *
 * Keys per field:
 *   type      text | email | tel | textarea | radio | select — what the control
 *             is, and for text-ish fields what the browser's keyboard should be
 *   required  an answer is not optional. Marked in the markup, not only in ink
 *   max       the longest value accepted, in characters
 *   options   radio and select: the value list, in order
 *   pair      lays this field beside the one before it on a wide screen
 *   reveal    this field belongs to a radio and appears when it has this value
 *   autocomplete  the browser's own hint, so an applicant fills it once
 *
 * MEMBERSHIP IS ONE MEMBERSHIP AND THE FORM SAYS SO. There is no tier field,
 * no budget field and no "how did you hear" dropdown of marketing channels:
 * the brief's list is the whole list, in the brief's order (ARCHITECTURE §12.2).
 *
 * @return array<string, array<string, mixed>>
 */
function form_fields(string $formType): array
{
    if ($formType === 'membership') {
        return [
            'name' => [
                'type'         => 'text',
                'required'     => true,
                'max'          => 80,
                'autocomplete' => 'given-name',
            ],
            'surname' => [
                'type'         => 'text',
                'required'     => true,
                'max'          => 80,
                'pair'         => true,
                'autocomplete' => 'family-name',
            ],
            'country' => [
                'type'         => 'text',
                'required'     => true,
                'max'          => 80,
                'autocomplete' => 'country-name',
            ],
            'city' => [
                'type'         => 'text',
                'required'     => false,
                'max'          => 80,
                'pair'         => true,
                'autocomplete' => 'address-level2',
            ],
            'occupation' => [
                'type'         => 'text',
                'required'     => false,
                'max'          => 160,
                'autocomplete' => 'organization',
            ],
            'email' => [
                'type'         => 'email',
                'required'     => true,
                'max'          => FORM_EMAIL_MAX,
                'autocomplete' => 'email',
            ],
            'phone' => [
                'type'         => 'tel',
                'required'     => false,
                'max'          => 40,
                'pair'         => true,
                'autocomplete' => 'tel',
            ],
            'heard' => [
                'type'     => 'text',
                'required' => false,
                'max'      => 200,
            ],

            /*
               The referral pair. The radio carries the answer and the name
               field belongs to it — which is why 'reveal' names a value rather
               than the component holding a list of what hides what.

               'referral_name' is not required in the schema because whether it
               is depends on the radio, and a rule that reads one field to judge
               another is not something a per-field flag can express. It is
               applied in form_validate() below, where both values are in hand.
            */
            /*
               No 'max' on the radio: the options list is already the complete
               statement of what it may hold, and a length beside it would be a
               second rule saying less. See the radio branch in form_validate().
            */
            'referred' => [
                'type'     => 'radio',
                'required' => false,
                'options'  => ['yes', 'no'],
            ],
            'referral_name' => [
                'type'     => 'text',
                'required' => false,
                'max'      => 120,
                'reveal'   => ['field' => 'referred', 'value' => 'yes'],
            ],

            'reason' => [
                'type'     => 'textarea',
                'required' => false,
                'max'      => FORM_TEXTAREA_MAX,
            ],
        ];
    }

    /*
       THE GENERAL ENQUIRY FORM. Five fields, and it is short on purpose: it is
       the form somebody fills in to ask a question, not to apply for anything,
       and every field past the fifth is a reason not to bother.

       It appears on /contact today and is built to appear on /events and
       /residences too (ARCHITECTURE §12.1), which is what the subject field is
       for: one inbox, one form, and a line in the subject that sorts it.

       WHAT IS NOT HERE. No company, no country, no "how did you hear", no
       preferred date and no number of guests. The membership form asks eleven
       questions because it is an application that will be read individually;
       this one is answered by a person writing back, and everything else they
       need they can ask in the reply.
    */
    if ($formType === 'enquiry') {
        return [
            'name' => [
                'type'         => 'text',
                'required'     => true,
                'max'          => 120,
                'autocomplete' => 'name',
            ],

            /*
               Email and phone are the brief's pair, laid out the way the
               membership form lays out its own: two boxes on one line where
               there is room for two. Name keeps a line to itself — it is the
               longest answer of the three and the first thing anybody types.
            */
            'email' => [
                'type'         => 'email',
                'required'     => true,
                'max'          => FORM_EMAIL_MAX,
                'autocomplete' => 'email',
            ],
            'phone' => [
                'type'         => 'tel',
                'required'     => false,
                'max'          => 40,
                'pair'         => true,
                'autocomplete' => 'tel',
            ],

            /*
               THE SUBJECT, AND IT IS A SELECT RATHER THAN A TEXT BOX BECAUSE
               THE INBOX HAS TO SORT ITSELF. The chosen line goes into the
               notification's subject — "Enquiry — Private event — …" — so a
               free-text field here would produce five hundred different
               subject lines and no sorting at all.

               The five options are the five things the estate is asked about,
               in the brief's order. 'general' is first because it is where the
               field rests when nobody has chosen: a select with no empty
               option always shows its first, and the honest first answer to
               "what is this about" on a contact page is "general". There is
               deliberately no "Choose…" placeholder — a required field with a
               sensible default should not be able to fail.

               The values are stored, not shown. What a reader sees comes from
               t('form.enquiry.fields.subject.options.<value>'), so the wording
               translates and the value in the mail and in the ?subject= link
               stays the same string in every language.
            */
            'subject' => [
                'type'     => 'select',
                'required' => true,
                'options'  => ['general', 'private-event', 'padel', 'residences', 'press'],
            ],

            'message' => [
                'type'     => 'textarea',
                'required' => true,
                'max'      => FORM_TEXTAREA_MAX,
            ],
        ];
    }

    return [];
}

// ---------------------------------------------------------------------------
// Cleaning
// ---------------------------------------------------------------------------

/**
 * A submitted value, reduced to something safe to store, print and mail.
 *
 * FOUR THINGS HAPPEN HERE AND ALL FOUR MATTER.
 *
 * 1. Anything that is not a string becomes one. PHP will hand you an array for
 *    name[]=a&name[]=b, and every function downstream expects a string.
 * 2. Invalid UTF-8 is dropped. A byte sequence that is not UTF-8 breaks
 *    json_encode() in the rate limiter's neighbour, breaks the mail encoder,
 *    and is not something a keyboard produces.
 * 3. Control characters go, including CR and LF for single-line fields. This
 *    is the header-injection defence: a newline inside a value that reaches a
 *    Subject: or a To: is how a form becomes an open relay. PHPMailer refuses
 *    these itself, but the value is stripped before it gets there rather than
 *    relying on the library to be the only thing standing in the way.
 * 4. Outer whitespace goes, so "  " is empty and a required field says so.
 *
 * The textarea keeps its newlines — it is a paragraph and it is never a header
 * — but loses every other control character.
 *
 * @param bool $multiline true for the textarea: keep CR/LF, drop the rest
 */
function form_clean(mixed $value, bool $multiline = false): string
{
    if (is_array($value) || is_object($value) || $value === null) {
        return '';
    }

    $value = (string) $value;

    // Drop anything that is not valid UTF-8 rather than letting it travel.
    $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');

    /*
       C0 and C1 controls, and the DEL. \p{Cc} covers both ranges in one class.
       Newlines are put back into the allowed set for the textarea only; a tab
       is dropped everywhere, because nothing on this form is tabular and a tab
       in a plain-text mail body is a column that does not line up.
    */
    $pattern = $multiline ? '/[^\P{Cc}\n]/u' : '/\p{Cc}/u';
    $value   = (string) preg_replace($pattern, '', $value);

    if ($multiline) {
        // Normalise the three line endings a browser may send to one.
        $value = (string) preg_replace('/\r\n?/', "\n", $value);

        // Three or more blank lines is a scroll bar in the notification mail.
        $value = (string) preg_replace('/\n{3,}/', "\n\n", $value);
    }

    return trim($value);
}

/**
 * Every field of a form, cleaned, in schema order.
 *
 * Reading from the schema rather than from $_POST is what keeps a submission
 * to the fields the form actually has: an extra parameter posted by hand is
 * not in the list, so it is never read, never validated and never mailed.
 *
 * @param  array<string, mixed> $input   $_POST
 * @return array<string, string>
 */
function form_values(string $formType, array $input): array
{
    $values = [];

    foreach (form_fields($formType) as $name => $field) {
        $values[$name] = form_clean(
            $input[$name] ?? '',
            ($field['type'] ?? '') === 'textarea'
        );
    }

    return $values;
}

// ---------------------------------------------------------------------------
// Validation
// ---------------------------------------------------------------------------

/**
 * Check the cleaned values against the schema.
 *
 * Returns field name => error message, empty when the submission is good. The
 * message is already the reader's sentence — the caller puts it beside the
 * field and into the summary at the top, and neither has to look anything up.
 *
 * ONE ERROR PER FIELD. A field that is both empty and too long is empty, and
 * telling somebody two things about one box is how a form starts feeling like
 * an argument.
 *
 * THIS IS THE ONLY VALIDATION THAT COUNTS. The browser does some of it too and
 * main.js does a little more, and neither is trusted here: both run on the far
 * side of the wire (ARCHITECTURE §12.3).
 *
 * @param  array<string, string> $values from form_values()
 * @return array<string, string> field => message
 */
function form_validate(string $formType, array $values): array
{
    $errors = [];
    $fields = form_fields($formType);

    foreach ($fields as $name => $field) {
        $value    = $values[$name] ?? '';
        $type     = (string) ($field['type'] ?? 'text');
        $required = !empty($field['required']);
        $max      = (int) ($field['max'] ?? 0);

        if ($value === '') {
            if ($required) {
                $errors[$name] = t('form.errors.required');
            }

            // An empty optional field is not measured, not parsed, and not an
            // error. Nothing below this applies to it.
            continue;
        }

        /*
           A radio or a select may only hold one of its own options. The
           browser sees to that; a POST by hand does not, and the value is
           printed in the notification mail — and, in the enquiry form's case,
           in its subject line.

           IT IS CHECKED BEFORE THE LENGTH, and the order is the whole reason
           this is not further down. A radio's options are already a complete
           statement of what it may contain, so any wrong value — three
           characters or three thousand — is the same mistake and deserves the
           same sentence. Measured first, "maybe" comes back as "longer than 3
           characters", which is true, useless, and describes a text box the
           reader is not looking at.
        */
        if ($type === 'radio' || $type === 'select') {
            if (!in_array($value, (array) ($field['options'] ?? []), true)) {
                $errors[$name] = t('form.errors.choice');
            }

            continue;
        }

        /*
           Length in characters, not bytes. "Jūrmala" is seven characters and
           eight bytes, and a cap counted in bytes would quietly shorten every
           applicant whose name is not ASCII — which, on a Latvian estate, is
           most of them.
        */
        if ($max > 0 && mb_strlen($value, 'UTF-8') > $max) {
            $errors[$name] = str_replace('{max}', (string) $max, t('form.errors.max'));
            continue;
        }

        if ($type === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $errors[$name] = t('form.errors.email');
            continue;
        }
    }

    /*
       THE ONE RULE THAT READS TWO FIELDS.

       Saying a member referred you and not saying which member is an answer
       with its own question left in it. The name is therefore required by the
       Yes, and by nothing else: leaving the radio alone, or answering No, asks
       for nothing — which is why this is not a 'required' flag in the schema.

       It is checked after the loop so that a name which is also too long has
       already been caught for the reason it was actually wrong.
    */
    foreach ($fields as $name => $field) {
        $reveal = $field['reveal'] ?? null;

        if (!is_array($reveal) || isset($errors[$name])) {
            continue;
        }

        $parent = (string) ($reveal['field'] ?? '');

        if (($values[$parent] ?? '') === (string) ($reveal['value'] ?? '') && ($values[$name] ?? '') === '') {
            $errors[$name] = t('form.errors.required');
        }
    }

    return $errors;
}
