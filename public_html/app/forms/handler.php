<?php
/**
 * The one place a form submission is processed.
 *
 * HOW A SUBMISSION GETS HERE, because it is not the obvious way.
 *
 * app/ is closed to the web — Require all denied, see app/.htaccess and
 * ARCHITECTURE §17 — so a browser cannot POST to this file and is not meant
 * to. A form posts to its own page instead, the front controller resolves that
 * page as it would for a GET, and then calls form_handle() before rendering.
 * The result goes into ctx(), the form component reads it, and the page comes
 * back with errors against the fields or with the thank-you in place of the
 * form.
 *
 * That is not a workaround for the closed directory. It is what makes the form
 * work with JavaScript switched off (ARCHITECTURE §12.2): one address, an
 * ordinary POST, and a server-rendered answer at the same URL. A separate
 * endpoint would have to redirect back and carry the errors and every value
 * the applicant typed through a session or a query string to do the same job.
 *
 * THE ORDER OF THE CHECKS IS DELIBERATE AND IT IS CHEAPEST-FIRST:
 *
 *   1. method      POST only; a GET renders the page and never reaches here
 *   2. form type   a type with no schema is refused outright
 *   3. rate limit  twenty POSTs and five accepted submissions per address per
 *                  hour, both checked before any work is done
 *   4. honeypot    a filled trap gets the success page and no mail
 *   5. time-trap   a signed timestamp; under three seconds is not a person
 *   6. validation  required, format, length, and the cap on the free text
 *   7. mail        two of them, and a failure never reaches the applicant
 *
 * NO CAPTCHA, by the brief. The four layers above are what stands in for one,
 * and between them they cost a real applicant nothing: no puzzle, no third-party
 * script, and no image of a bus.
 */

declare(strict_types=1);

require_once __DIR__ . '/validate.php';
require_once __DIR__ . '/rate_limit.php';

/** The forms this handler knows. Anything else is refused. */
const FORM_TYPES = ['membership', 'enquiry'];

/**
 * The floor, in seconds, under which a submission was not typed by a person
 * (ARCHITECTURE §12.3). Three seconds is not enough time to read the first
 * label, let alone answer the form under it.
 */
const FORM_MIN_SECONDS = 3;

/**
 * The ceiling. A form left open in a tab overnight is still a real applicant,
 * so this is generous; what it stops is a signed token being reused for weeks.
 * Past it the submission comes back with the ordinary "send it again" error
 * and a fresh token, so nothing is lost but a click.
 */
const FORM_MAX_AGE = 86400;

/** Where rejections and SMTP failures are written. */
const FORM_LOG_FILE = PRIVATE_PATH . '/logs/form_errors.log';

// ---------------------------------------------------------------------------
// Logging
// ---------------------------------------------------------------------------

/**
 * One line per event, in private/logs/form_errors.log.
 *
 * NOTHING AN APPLICANT TYPED IS EVER WRITTEN HERE, and that is not tidiness.
 * The form collects an occupation and free text about a person (ARCHITECTURE
 * §12.3), a log file is a copy of it that nobody agreed to and nobody prunes,
 * and the privacy notice beside the form does not offer one. What is recorded
 * is what happened, to which form, and a hashed address — enough to tell a bot
 * from a bad afternoon, and not enough to be a second copy of the application.
 *
 * The one exception is the SMTP error text, which is the mail server talking
 * about itself.
 *
 * FILE_APPEND with a single write is atomic enough for line-sized records on
 * every filesystem this site will meet, so the lock the rate limiter needs is
 * not needed here.
 */
function form_log(string $event, string $note = ''): void
{
    $line = sprintf(
        "%s  %-16s ip=%s  %s\n",
        date('c'),
        $event,
        rate_limit_key(rate_limit_address()),
        $note
    );

    @file_put_contents(FORM_LOG_FILE, $line, FILE_APPEND);
}

// ---------------------------------------------------------------------------
// The time-trap
// ---------------------------------------------------------------------------

/**
 * A signed "this form was drawn now", for the hidden field.
 *
 * SIGNING IS WHAT MAKES IT WORTH HAVING. An unsigned timestamp is a number the
 * sender chose: a bot that is willing to post a form in half a second is
 * willing to post one that claims to be a minute old. Under an HMAC the value
 * cannot be written by anyone without FORM_SECRET, only replayed — and replay
 * is what the rate limiter and FORM_MAX_AGE are for.
 *
 * The form type is signed with the timestamp so a token issued for one form is
 * not accepted by another.
 */
function form_token(string $formType): string
{
    $issued = time();

    return $issued . '.' . hash_hmac('sha256', $formType . '|' . $issued, FORM_SECRET);
}

/**
 * Check a token. Returns '' when it is good, or the t() key of what was wrong.
 *
 * The two failures are told apart on purpose. A forged or stale token is a
 * "send it again" and the form comes back with everything the applicant typed;
 * three seconds is the trap proper. Neither says which one it was in so many
 * words on the page — see the messages in common.php.
 */
function form_token_check(string $formType, string $token): string
{
    $parts = explode('.', $token, 2);

    if (count($parts) !== 2 || !ctype_digit($parts[0])) {
        return 'form.errors.token';
    }

    [$issued, $signature] = $parts;

    $expected = hash_hmac('sha256', $formType . '|' . $issued, FORM_SECRET);

    // hash_equals rather than ===, so the comparison does not leak where the
    // two strings first differ through how long it took to say no.
    if (!hash_equals($expected, $signature)) {
        return 'form.errors.token';
    }

    $age = time() - (int) $issued;

    // A token from the future is a clock that moved, and it is treated as
    // stale rather than as a very slow submission.
    if ($age < 0 || $age > FORM_MAX_AGE) {
        return 'form.errors.token';
    }

    if ($age < FORM_MIN_SECONDS) {
        return 'form.errors.too_fast';
    }

    return '';
}

// ---------------------------------------------------------------------------
// The handler
// ---------------------------------------------------------------------------

/**
 * The shape every outcome comes back in, so the component has one thing to read.
 *
 * @param array<string, string> $values
 * @param array<string, string> $errors
 * @return array{type: string, ok: bool, values: array, errors: array, notice: string}
 */
function form_result(string $type, bool $ok, array $values = [], array $errors = [], string $notice = ''): array
{
    return [
        'type'   => $type,
        'ok'     => $ok,
        'values' => $values,
        'errors' => $errors,
        'notice' => $notice,
    ];
}

/**
 * Process a submission, if this request is one.
 *
 * @param  array<string, mixed> $input $_POST
 * @return array|null  null when the request is not a form submission at all,
 *                     in which case the page renders as it would for a GET
 */
function form_handle(array $input): ?array
{
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
        return null;
    }

    $type = form_clean($input['form_type'] ?? '');

    if ($type === '' || !in_array($type, FORM_TYPES, true)) {
        if ($type !== '') {
            form_log('refused', 'unknown form type');
        }

        return null;
    }

    /*
       BOTH FORMS TAKE THE SAME PATH FROM HERE, and there is no branch on the
       type again until the mail is built.

       That is the schema doing its job rather than a coincidence: the fields,
       their order and their rules are form_fields($type) in validate.php, the
       words are the 'form.<type>' block in common.php, the markup is one
       renderer in templates/partials/form.php, and the two mails are named in
       one match() in mail/send.php. A third form is a schema, a block of
       strings, a component of four lines, and two mail builders — and not a
       line in here.

       A type with no schema is already refused above: it is not in FORM_TYPES.
    */

    // ---- 3. Rate limit ----------------------------------------------------

    $limit = rate_limit_hit();

    if (!$limit['allowed']) {
        form_log(
            'rate_limit',
            'refused, ' . $limit['posts'] . ' posts and ' . $limit['sends']
                . ' sent this hour, retry in ' . $limit['retry_after'] . 's'
        );

        /*
           The values are handed back even though nothing was accepted. A
           genuine applicant who has hit the limit is looking at an hour's wait
           and should not also be looking at an empty form.

           THE MESSAGE IS THE FORM'S OWN AND THIS IS THE ONLY ERROR THAT IS. It
           is the one that names what was sent, and the membership form does not
           call what was sent an enquiry — see the note on 'errors' in
           content/en/common.php. Keyed by type rather than branched on it, the
           way partials/form.php reads every other string a form says, so the
           day a third form arrives it brings its own sentence and this line
           does not change.
        */
        return form_result($type, false, form_values($type, $input), [], t('form.' . $type . '.errors.rate'));
    }

    // ---- 4. The honeypot --------------------------------------------------

    /*
       A field called 'website', placed off-screen and left empty by anybody
       using the page as a page. Something that fills every input it finds
       fills this one too.

       IT IS ANSWERED WITH SUCCESS AND NO MAIL. Telling a bot it was caught is
       telling whoever wrote it what to change; the thank-you is what a
       submission looks like from the outside, so there is nothing to learn
       from the response. The event is logged, so the trap can be shown to be
       working without anything being visible on the page.
    */
    if (form_clean($input['website'] ?? '') !== '') {
        form_log('honeypot', 'trap filled, no mail sent');

        return form_result($type, true);
    }

    // ---- 5. The time-trap -------------------------------------------------

    $tokenError = form_token_check($type, form_clean($input['form_time'] ?? ''));

    if ($tokenError !== '') {
        form_log('time_trap', $tokenError === 'form.errors.too_fast' ? 'under ' . FORM_MIN_SECONDS . 's' : 'bad or stale token');

        return form_result($type, false, form_values($type, $input), [], t($tokenError));
    }

    // ---- 6. Validation ----------------------------------------------------

    $values = form_values($type, $input);
    $errors = form_validate($type, $values);

    if ($errors !== []) {
        form_log('invalid', count($errors) . ' field(s): ' . implode(', ', array_keys($errors)));

        return form_result($type, false, $values, $errors, t('form.errors.summary'));
    }

    // ---- 7. The mail ------------------------------------------------------

    /*
       A MAIL SERVER PROBLEM IS NOT THE APPLICANT'S PROBLEM.

       Both mails are attempted; whatever happens, the applicant is shown the
       thank-you. An SMTP failure is logged with the server's own error text
       for whoever is looking after the box, and never printed, never shown and
       never hinted at on the page — an applicant cannot fix a mail server, and
       a form that says "SMTP connect() failed" has told a stranger the name of
       a host and taught them nothing they can act on.

       The application is not lost silently either: the failure is in
       form_errors.log with a timestamp, which is what makes it findable.
    */
    require_once __DIR__ . '/mail/send.php';

    /*
       RECORDED AS ACCEPTED BEFORE THE MAILER IS CALLED, not after.

       This is the counter that allows five an hour per address, and what it is
       counting is submissions the site agreed to act on. Whether SMTP was
       reachable in the second that followed is the estate's problem and not the
       sender's allowance — a mail server that is down must not quietly hand
       somebody unlimited attempts, and a submission that has already been
       written into form_errors.log as failed mail is one that happened.
    */
    rate_limit_sent();

    form_send($type, $values);

    return form_result($type, true);
}
