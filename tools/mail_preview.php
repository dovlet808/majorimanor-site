<?php
/**
 * Render — and optionally send — the mails a form submission produces.
 *
 *     php tools/mail_preview.php                        render every case of both
 *                                                       forms, check them
 *     php tools/mail_preview.php --case=markup          also print that case
 *     php tools/mail_preview.php --form=membership --case=markup
 *     php tools/mail_preview.php --form=membership --send=you@example.com
 *
 * WHY THIS EXISTS. The only other way to see one of these mails is to fill in
 * the form on a running site and send two real messages to a real inbox, which
 * is a slow loop, leaves litter in info@, and cannot show the cases that matter
 * most: a name with markup in it, a name that is not there at all. Those are
 * not things anybody can be expected to type into a live form on purpose, and
 * they are exactly the two the mail has to survive.
 *
 * WHAT IT CHECKS, and every one of these has failed somewhere before:
 *
 *   the preheader is 40–90 characters for EVERY subject the enquiry form
 *     offers, and for the membership letter's fixed one
 *   a name holding < > & " is escaped in the HTML part
 *   the same name is NOT escaped in the plain-text part, where &amp; is a
 *     mistake rather than a safeguard
 *   an empty name produces a greeting and not "Dear ,"
 *   neither part of either letter promises a response time, checked against a
 *     word list
 *   nothing in the membership letter implies the application was accepted,
 *     checked against a second word list
 *   the membership letter quotes back none of the free text it was sent
 *   the membership letter carries /membership's own opening paragraph and the
 *     enquiry letter carries the /estate lede — the two have not merged back
 *     into one shared paragraph
 *   "reviewed individually" sits ABOVE that paragraph in both parts, which is
 *     what stops it reading as a description of what the applicant will get
 *   no string the membership form shows, and neither part of its letter, says
 *     "enquiry" — swept over the whole string tree, not a list of keys
 *   the contact form still does say it, because an enquiry is an enquiry
 *   both letters open with one short line of thanks, above the receipt
 *   both parts exist and the text part is a letter rather than a stub
 *   both letters are set to one measure and come out of one shell
 *
 * The checks are assertions with an exit code, so this is runnable before a
 * deploy and not only readable by somebody who remembers it is here.
 *
 * IT IS A TOOL AND NOT PART OF THE SITE. tools/ is excluded from both deploy
 * archives (deploy/_common.sh), so nothing here ever reaches a webroot.
 */

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    exit("This is a command-line tool.\n");
}

require dirname(__DIR__) . '/public_html/app/bootstrap.php';

/*
   The request state the mails read their strings through. index.php builds
   this from the resolved route; there is no route here, so it is built by
   hand. The page id only has to be a real one — url() reads routes.php, not
   the current page — and 'contact' is where the enquiry form lives.
*/
ctx([
    'lang'    => 'en',
    'page_id' => 'contact',
    't'       => require CONTENT_PATH . '/en/common.php',
    'c'       => [],
]);

require_once APP_PATH . '/forms/handler.php';
require_once APP_PATH . '/forms/mail/notify_enquiry.php';
require_once APP_PATH . '/forms/mail/autoreply_enquiry.php';
require_once APP_PATH . '/forms/mail/notify_membership.php';
require_once APP_PATH . '/forms/mail/autoreply_membership.php';

// ---------------------------------------------------------------------------
// The cases
// ---------------------------------------------------------------------------

/**
 * THE SUBMISSIONS WORTH RENDERING, THREE PER FORM.
 *
 * 'normal' is the mail as almost everybody will receive it. The other two are
 * the acceptance criteria: a name that is markup, and a name that is missing.
 *
 * THE MEMBERSHIP VALUES ARE CHOSEN SO THAT NOTHING IN THEM COULD APPEAR IN THE
 * LETTER BY COINCIDENCE — the country is not Latvia, because the signature
 * says "Jūrmala · Latvia" and a check that the letter does not quote the
 * country back would pass for the wrong reason.
 */
const PREVIEW_CASES = [

    'enquiry' => [
        'normal' => [
            'name'    => 'Anna Bērziņa',
            'email'   => 'anna@example.com',
            'phone'   => '+371 20 000 000',
            'subject' => 'private-event',
            'message' => "We are considering the manor for a small wedding next summer.\n\nWould it be possible to visit?",
        ],

        /*
           THE HOSTILE NAME. Every character that means something in HTML, plus
           a tag that would run if anything on the path forgot to escape it. It
           is not a realistic name and it is not meant to be: the form accepts
           120 characters of anything, and this is what "anything" looks like
           when somebody is trying.
        */
        'markup' => [
            'name'    => 'Tom <script>alert("x")</script> & "Sons" <b>Ltd</b>',
            'email'   => 'tom@example.com',
            'phone'   => '',
            'subject' => 'press',
            'message' => 'Testing.',
        ],

        /*
           THE EMPTY NAME. form_validate() requires the field, so this cannot
           arrive through the form — it is here because "cannot happen" is a
           property of today's schema and not of the mail builder, and the
           letter must not open "Dear ," the day somebody makes the field
           optional.
        */
        'noname' => [
            'name'    => '',
            'email'   => 'someone@example.com',
            'phone'   => '',
            'subject' => 'general',
            'message' => 'Hello.',
        ],
    ],

    'membership' => [
        'normal' => [
            'name'          => 'Anna',
            'surname'       => 'Bērziņa',
            'country'       => 'Estonia',
            'city'          => 'Tallinn',
            'occupation'    => 'Architect at Kask & Partners',
            'email'         => 'anna@example.com',
            'phone'         => '+372 5000 0000',
            'heard'         => 'Through a friend who plays padel',
            'referred'      => 'yes',
            'referral_name' => 'Jānis Ozoliņš',
            'reason'        => "I have spent every summer of my life a few streets from the house, and watched it stand empty for most of them.\n\nI would like to be part of what it becomes.",
        ],

        'markup' => [
            'name'          => 'Tom <script>alert("x")</script> & "Sons" <b>Ltd</b>',
            'surname'       => 'O\'Brien & <em>Co</em>',
            'country'       => 'Estonia',
            'city'          => '',
            'occupation'    => '',
            'email'         => 'tom@example.com',
            'phone'         => '',
            'heard'         => '',
            'referred'      => 'no',
            'referral_name' => '',
            'reason'        => 'Testing.',
        ],

        /*
           BOTH NAME FIELDS EMPTY, not just the first. The greeting uses the
           given name and the envelope uses both, so a case with only one of
           them missing would leave the envelope looking fine and prove
           nothing about it.
        */
        'noname' => [
            'name'          => '',
            'surname'       => '',
            'country'       => 'Estonia',
            'city'          => '',
            'occupation'    => '',
            'email'         => 'someone@example.com',
            'phone'         => '',
            'heard'         => '',
            'referred'      => '',
            'referral_name' => '',
            'reason'        => '',
        ],
    ],
];

/** Which builder answers for which form. */
const PREVIEW_BUILDERS = [
    'enquiry'    => ['autoreply' => 'mail_autoreply_enquiry',    'notify' => 'mail_notify_enquiry'],
    'membership' => ['autoreply' => 'mail_autoreply_membership', 'notify' => 'mail_notify_membership'],
];

// ---------------------------------------------------------------------------
// Checks
// ---------------------------------------------------------------------------

$failures = [];
$checks   = 0;

function check(string $what, bool $passed): void
{
    global $failures, $checks;

    $checks++;

    if (!$passed) {
        $failures[] = $what;
    }

    printf("  %s  %s\n", $passed ? 'ok  ' : 'FAIL', $what);
}

/**
 * The words a receipt must not contain.
 *
 * A RESPONSE TIME IS THE ONE PROMISE THESE MAILS ARE FORBIDDEN TO MAKE, so it
 * is checked mechanically rather than by reading the letters again. The list is
 * the phrasings that have to be caught, not every phrasing that exists — but a
 * new one has to get past somebody writing it AND this list, which is two
 * chances more than the letters had before.
 */
const FORBIDDEN = [
    'shortly', 'within 24', 'within 48', '24 hours', '48 hours', 'business day',
    'working day', 'as soon as possible', 'asap', 'promptly', 'immediately',
    'in a few days', 'next 24', 'turnaround', 'in due course', 'get back to you',
];

/**
 * The words an application receipt must not contain either.
 *
 * THE SECOND PROMISE THIS LETTER COULD MAKE BY ACCIDENT IS A YES. Nothing has
 * been decided at the moment it is sent — it is sent by the form, four seconds
 * after the button — and every phrase below is one an applicant would keep and
 * read as a decision. "We look forward to welcoming you" is the one that gets
 * written, because it is what a polite person types without thinking.
 *
 * Checked against the membership letter only. The enquiry letter is allowed to
 * say somebody will reply, because somebody will.
 */
const NOT_A_YES = [
    'welcome', 'congratul', 'accepted', 'approved', 'successful',
    'look forward', 'delighted', 'pleased to', 'your place', 'your membership',
    'next step', 'once you are', 'when you join',
];

/** The free text the membership letter is not allowed to quote back. */
const NOT_ECHOED = ['country', 'city', 'occupation', 'heard', 'referral_name', 'reason'];

$rendered = [];

foreach (PREVIEW_CASES as $form => $cases) {
    foreach ($cases as $case => $values) {
        $rendered[$form][$case] = PREVIEW_BUILDERS[$form]['autoreply']($values);
    }
}

// ---------------------------------------------------------------------------

echo "\n=== preheader length, every line a message list will print ===\n\n";

/*
   The window is 40–90 characters. Below forty the client fills the rest of the
   line from the letter; above ninety it is cut in the narrow list panes.
*/
$preheaders = [];

foreach (form_fields('enquiry')['subject']['options'] as $option) {
    $preheaders['enquiry: ' . $option] = mail_autoreply_enquiry_preheader(
        t('form.enquiry.fields.subject.options.' . $option)
    );
}

$preheaders['enquiry: (none)'] = mail_autoreply_enquiry_preheader('');
$preheaders['membership']      = t('mail.membership.autoreply_preheader');

foreach ($preheaders as $label => $preheader) {
    $length = mb_strlen($preheader, 'UTF-8');

    check(
        sprintf('%-22s %2d chars  "%s"', $label, $length, $preheader),
        $length >= 40 && $length <= 90
    );
}

// ---------------------------------------------------------------------------

foreach ($rendered as $form => $cases) {
    echo "\n=== {$form}: the three cases ===\n\n";

    foreach ($cases as $case => $mail) {
        echo "-- {$form}/{$case} --\n";

        check("{$case}: an HTML part is present",      $mail['html'] !== '');
        check("{$case}: a plain-text part is present", $mail['text'] !== '');

        /*
           A REAL LETTER AND NOT A STUB. Four hundred characters is well under
           what the text part actually is and well over what a stripped-tags
           afterthought would be, which is what this is guarding against.
        */
        check("{$case}: the text part is a letter, not a stub", mb_strlen($mail['text'], 'UTF-8') > 400);

        /*
           Both parts carry the same sentences.

           COMPARED WITH THE LINE BREAKS COLLAPSED, because the text part is
           wrapped at MAIL_TEXT_WIDTH and a sentence longer than that is not
           one string in it any more. Comparing raw would fail on a mail that
           is perfectly correct, which is worse than not checking: it trains
           whoever runs this to ignore a red line.
        */
        $flat = static fn (string $s): string => (string) preg_replace('/\s+/u', ' ', $s);

        $sentences = $form === 'enquiry'
            ? [
                'thanks'       => t('mail.enquiry.autoreply_thanks'),
                'confirmation' => t('mail.enquiry.autoreply_confirm'),
                'paragraph'    => t('mail.about'),
                'closing'      => t('mail.enquiry.autoreply_disregard'),
            ]
            : [
                'thanks'       => t('mail.membership.autoreply_thanks'),
                'confirmation' => t('mail.membership.autoreply_confirm'),
                'second line'  => t('mail.membership.autoreply_reviewed'),

                /*
                   THE MEMBERSHIP PARAGRAPH IS /membership's OWN OPENING AND
                   NOT t('mail.about'). The two letters carry different
                   paragraphs on purpose — the enquiry letter the /estate lede,
                   this one the page the applicant applied from — and this is
                   the line that would go red if somebody put the shared one
                   back.
                */
                'paragraph'    => t('mail.membership.autoreply_about'),

                'closing'      => t('mail.membership.autoreply_disregard'),
            ];

        foreach ($sentences as $part => $string) {
            check(
                "{$case}: the text part carries the {$part}",
                str_contains($flat($mail['text']), $flat($string))
            );
            check(
                "{$case}: the HTML part carries the {$part}",
                str_contains($flat($mail['html']), $flat(e($string)))
            );
        }

        /*
           THE TWO BLOCKLISTS, AND THEY REPORT WHEN THEY PASS.

           Both used to call check() only on a hit, so a clean letter printed
           nothing at all and a run that scanned neither list — a typo'd
           constant, a loop left inside a branch that no longer executes —
           looked exactly like a run that scanned both and found nothing. A
           check that is invisible when it passes is a check nobody can tell is
           still running. One line per list per case, naming how many words were
           scanned, and the words themselves when there are any to name.
        */
        $hits = static function (array $words) use ($mail): array {
            return array_values(array_filter(
                $words,
                static fn (string $word): bool => stripos($mail['html'], $word) !== false
                    || stripos($mail['text'], $word) !== false
            ));
        };

        // No response-time promise, in either part, in any case, on either form.
        $found = $hits(FORBIDDEN);

        check(
            "{$case}: no response-time promise (" . count(FORBIDDEN) . ' phrases checked)'
                . ($found === [] ? '' : ' — found: ' . implode(', ', $found)),
            $found === []
        );

        // And nothing that reads as a yes, on the letter that could imply one.
        if ($form === 'membership') {
            $found = $hits(NOT_A_YES);

            check(
                "{$case}: nothing implying acceptance (" . count(NOT_A_YES) . ' phrases checked)'
                    . ($found === [] ? '' : ' — found: ' . implode(', ', $found)),
                $found === []
            );
        }

        echo "\n";
    }
}

// ---------------------------------------------------------------------------

echo "-- the receipt quotes back nothing it should not --\n";

/*
   THE APPLICATION IS NOT SENT BACK TO THE APPLICANT. The receipt names when it
   arrived and nothing else; the answers are on their way to info@, and a
   mailbox is not the place to keep somebody's occupation and their paragraph
   about themselves. Checked on the whole value, so a field whose answer happens
   to contain a word the letter also uses does not pass for the wrong reason.
*/
foreach (NOT_ECHOED as $field) {
    $value = (string) (PREVIEW_CASES['membership']['normal'][$field] ?? '');

    if (mb_strlen($value, 'UTF-8') < 4) {
        continue;
    }

    $mail  = $rendered['membership']['normal'];
    $short = mb_strlen($value, 'UTF-8') > 34 ? mb_substr($value, 0, 34, 'UTF-8') . '…' : $value;

    check(
        sprintf('membership: %-14s is not quoted back  ("%s")', $field, str_replace("\n", ' ', $short)),
        !str_contains($mail['html'], e($value)) && !str_contains($mail['text'], $value)
    );
}

/*
   The referral answer is a closed option rather than free text, so the check
   above would not have caught it being echoed. It is named separately because
   leaving it out was a decision: who introduced somebody to a private club is
   the last thing that belongs in an unencrypted mail to an address nobody has
   confirmed.
*/
$referral = t('form.membership.fields.referred.options.yes');
$mail     = $rendered['membership']['normal'];

check(
    'membership: the referral answer is not quoted back either',
    !str_contains($mail['html'], '>' . e($referral) . '<') && !str_contains($mail['text'], "  {$referral}")
);

echo "\n-- what the receipt does say --\n";

$mail = $rendered['membership']['normal'];

check(
    'membership: the receipt carries the time it arrived, and one row only',
    substr_count($mail['html'], 'text-transform: uppercase; color: #1A4438;">' . e(t('mail.received_label'))) === 1
        && substr_count($mail['text'], '  ' . t('mail.received_label')) === 1
);

check(
    'membership: the time is named as the manor\'s own',
    str_contains($mail['text'], '(' . t('mail.received_zone') . ')')
);

echo "\n-- the membership paragraph, and where it sits --\n";

/*
   THE PARAGRAPH THIS LETTER CARRIES IS /membership's OWN OPENING.

   Both letters used to carry t('mail.about'), the /estate lede. The membership
   one now carries the first paragraph of the "One membership" section instead,
   because an applicant has read about the house and what the letter they keep
   should hold is the page they applied from. The enquiry letter still carries
   the /estate lede, and the first two checks are what stops the two swapping
   back into one shared paragraph.
*/
/*
   COMPARED WITH THE LINE BREAKS COLLAPSED, for the reason the sentence checks
   above are: the text part is wrapped at MAIL_TEXT_WIDTH, so a paragraph longer
   than seventy-two characters is not one string in it any more and a raw
   comparison would fail on a letter that is perfectly correct.
*/
$flatten = static fn (string $s): string => (string) preg_replace('/\s+/u', ' ', $s);

check(
    'membership: carries the /membership opening, not the /estate lede',
    str_contains($flatten($rendered['membership']['normal']['text']), $flatten(t('mail.membership.autoreply_about')))
        && !str_contains($flatten($rendered['membership']['normal']['text']), $flatten(t('mail.about')))
);

check(
    'enquiry: still carries the /estate lede',
    str_contains($flatten($rendered['enquiry']['normal']['text']), $flatten(t('mail.about')))
);

/*
   AND IT SITS BELOW "reviewed individually", WHICH IS THE CONDITION ON USING
   IT AT ALL.

   "There is one membership. It covers the estate." read on its own, or read
   before anybody has been told that applications are reviewed individually, is
   a sentence about what THIS applicant is getting. Read under that line it is a
   sentence about what they have applied to. The order is the whole difference
   and it is one array away from being lost, so it is checked in both parts
   rather than trusted to the file that sets it.
*/
foreach ($rendered['membership'] as $case => $mail) {
    $flatText = $flatten($mail['text']);

    $reviewed  = mb_strpos($flatText, $flatten(t('mail.membership.autoreply_reviewed')), 0, 'UTF-8');
    $paragraph = mb_strpos($flatText, $flatten(t('mail.membership.autoreply_about')), 0, 'UTF-8');

    check(
        "membership/{$case}: \"reviewed individually\" comes above the paragraph (text)",
        $reviewed !== false && $paragraph !== false && $reviewed < $paragraph
    );

    $reviewedHtml  = mb_strpos($mail['html'], e(t('mail.membership.autoreply_reviewed')), 0, 'UTF-8');
    $paragraphHtml = mb_strpos($mail['html'], e(t('mail.membership.autoreply_about')), 0, 'UTF-8');

    check(
        "membership/{$case}: \"reviewed individually\" comes above the paragraph (HTML)",
        $reviewedHtml !== false && $paragraphHtml !== false && $reviewedHtml < $paragraphHtml
    );
}

echo "\n-- one word for one thing: the membership form is an application --\n";

/**
 * "ENQUIRY" APPEARS NOWHERE AN APPLICANT CAN SEE IT.
 *
 * The page says application, the thank-you says application and ARCHITECTURE
 * §12.2 says application; the schema, the button and both subject lines said
 * enquiry, so somebody filled in an application and got two mails about their
 * enquiry. That is fixed in strings, and strings drift back — this is the check
 * that says so out loud.
 *
 * IT SWEEPS THE WHOLE TREE RATHER THAN NAMING THE STRINGS THAT WERE WRONG. A
 * list of five keys is a list that a sixth key added next year is not on. Every
 * string under 'form.membership' and 'mail.membership' is user-visible by
 * construction — that is what those blocks are for — so every one of them is
 * checked, and a new one arrives already covered.
 *
 * WHAT IT DOES NOT REACH is the CTA labels on other pages, which live in their
 * own content files and are not loaded here. Those are 'Apply for membership'
 * and 'Membership application'; this file has no business opening
 * content/en/home.php to find out.
 */
$walk = static function (array $node, string $prefix) use (&$walk): array {
    $out = [];

    foreach ($node as $key => $value) {
        $path = $prefix === '' ? (string) $key : $prefix . '.' . $key;

        if (is_array($value)) {
            $out += $walk($value, $path);
        } elseif (is_string($value)) {
            $out[$path] = $value;
        }
    }

    return $out;
};

$membershipStrings = $walk((array) (ctx()['t']['form']['membership'] ?? []), 'form.membership')
    + $walk((array) (ctx()['t']['mail']['membership'] ?? []), 'mail.membership');

$offenders = [];

foreach ($membershipStrings as $path => $string) {
    if (stripos($string, 'enquir') !== false) {
        $offenders[] = $path;
    }
}

check(
    sprintf('%d membership strings, none of them says "enquiry"', count($membershipStrings))
        . ($offenders === [] ? '' : ' — found in: ' . implode(', ', $offenders)),
    $offenders === []
);

/*
   AND NOT IN THE LETTERS THEMSELVES EITHER, which is the same fact approached
   from the other end: a string could be clean and the builder could still put
   the word in by hand, or reach for one of the enquiry form's keys.
*/
foreach ($rendered['membership'] as $case => $mail) {
    check(
        "membership/{$case}: neither part of the letter says \"enquiry\"",
        stripos($mail['html'], 'enquir') === false && stripos($mail['text'], 'enquir') === false
    );

    check(
        "membership/{$case}: the subject line does not say \"enquiry\"",
        stripos($mail['subject'], 'enquir') === false
    );
}

$notify = mail_notify_membership(PREVIEW_CASES['membership']['normal']);

check(
    'membership: the notification to info@ does not say "enquiry" either  ("' . $notify['subject'] . '")',
    stripos($notify['subject'], 'enquir') === false && stripos($notify['text'], 'enquir') === false
);

/*
   THE CONTACT FORM IS LEFT ALONE, AND THIS IS THE CHECK THAT SAYS SO. An
   enquiry is an enquiry; a sweep that renamed every "enquiry" on the site
   because the membership form needed one word would have taken this with it.
*/
check(
    'enquiry: still calls itself an enquiry  ("' . t('form.enquiry.submit') . '")',
    stripos(t('form.enquiry.submit'), 'enquir') !== false
        && stripos($rendered['enquiry']['normal']['subject'], 'enquir') !== false
);

/*
   EVERY FORM HAS ITS OWN RATE-LIMIT SENTENCE, AND THIS IS WHY THAT IS CHECKED
   RATHER THAN ASSUMED.

   handler.php reads t('form.<type>.errors.rate'). A missing key there does not
   raise — t() returns an empty string in production — so the failure mode is a
   refused submission whose error summary is blank, on the one code path that
   only runs for somebody who has already sent five things and is the least
   likely to be exercised by hand. A third form arriving without its own
   sentence fails here instead.
*/
foreach (FORM_TYPES as $type) {
    check(
        sprintf('%-11s has its own rate-limit sentence', $type),
        trim(t('form.' . $type . '.errors.rate')) !== ''
            && !str_contains(t('form.' . $type . '.errors.rate'), 'missing')
    );
}

check(
    'membership: the rate-limit sentence does not say "enquiry" either',
    stripos(t('form.membership.errors.rate'), 'enquir') === false
);

echo "\n-- the line of thanks --\n";

/*
   ONE SHORT LINE OF THANKS NEAR THE TOP OF BOTH LETTERS, ABOVE THE RECEIPT.

   Its presence in both parts is already covered by the sentence checks above.
   What is checked here is the two things it is not allowed to become: a
   response-time promise or an acceptance, both of which are covered by the
   blocklists — and its POSITION, because a line of thanks that drifts below the
   receipt block is a postscript, not a greeting.
*/
foreach ($rendered as $form => $cases) {
    $thanks = t("mail.{$form}.autoreply_thanks");
    $mail   = $cases['normal'];

    check("{$form}: the thanks is one short line  (\"{$thanks}\")", mb_strlen($thanks, 'UTF-8') <= 40);
    check("{$form}: the thanks carries no exclamation mark",        !str_contains($thanks, '!'));

    $thanksAt  = mb_strpos($mail['text'], $thanks, 0, 'UTF-8');
    $receiptAt = mb_strpos($mail['text'], '  ' . t('mail.received_label'), 0, 'UTF-8');

    check(
        "{$form}: the thanks sits above the receipt block",
        $thanksAt !== false && $receiptAt !== false && $thanksAt < $receiptAt
    );
}

echo "\n-- the pointer to /privacy --\n";

/*
   ON THE MEMBERSHIP LETTER AND NOT ON THE ENQUIRY ONE. That form asks for an
   occupation and for free text about the applicant; this one asks for a way to
   answer and a question, and its own notice above the button says exactly that.
*/
$privacy = SITE_URL . url('privacy');

check('membership: the HTML part links to ' . $privacy, str_contains($rendered['membership']['normal']['html'], 'href="' . e($privacy) . '"'));
check('membership: the link reads "' . t('mail.privacy_link') . '"', str_contains($rendered['membership']['normal']['html'], '>' . e(t('mail.privacy_link')) . '</a>'));
check('membership: the text part writes the address out in full', str_contains($rendered['membership']['normal']['text'], $privacy));
check('enquiry: carries no privacy line',                          !str_contains($rendered['enquiry']['normal']['html'], $privacy));

echo "\n-- escaping --\n";

foreach ($rendered as $form => $cases) {
    $markup = $cases['markup'];

    /*
       THE HTML PART. The tag must be present as text and absent as a tag: it
       is not enough that &lt;script&gt; appears somewhere, because it could
       appear escaped in one place and raw in another.
    */
    check("{$form}: the HTML part contains no raw <script",   !str_contains($markup['html'], '<script'));
    check("{$form}: the HTML part contains no raw <b>Ltd",    !str_contains($markup['html'], '<b>Ltd'));
    check("{$form}: the HTML part escapes the angle brackets", str_contains($markup['html'], '&lt;script&gt;'));
    check("{$form}: the HTML part escapes the ampersand",      str_contains($markup['html'], '&amp;'));
    check("{$form}: the HTML part escapes the quotes",         str_contains($markup['html'], '&quot;'));

    /*
       THE PLAIN-TEXT PART, AND THE CHECK RUNS THE OTHER WAY. text/plain is not
       parsed, so the characters belong in it as themselves — an escaped entity
       here is a letter addressed to Tom &amp; "Sons", which is a bug that
       looks like caution.
    */
    check("{$form}: the text part keeps the name as typed",    str_contains($markup['text'], 'Tom <script>alert("x")</script> & "Sons" <b>Ltd</b>'));
    check("{$form}: the text part has no HTML entities in it", !str_contains($markup['text'], '&amp;') && !str_contains($markup['text'], '&lt;'));
}

echo "\n-- style attributes are not truncated --\n";

/**
 * THE BUG THIS CATCHES HAS ALREADY HAPPENED ONCE.
 *
 * Every rule in these letters is inline, so every rule lives in a style="…"
 * delimited by double quotes — and a font stack written "Segoe UI" rather than
 * 'Segoe UI' closes that attribute early. What follows is not a broken font
 * name: it is the end of the declaration list. The size, the leading and the
 * colour after it are never delivered, and the paragraph renders in the
 * client's default. The letter still looks like a letter, which is why it went
 * unnoticed.
 *
 * The check is structural rather than a search for the two names that were
 * wrong: a style attribute is well-formed only if the character after its
 * closing quote ends the attribute. Anything else means the quote that closed
 * it was inside the value.
 */
foreach ($rendered as $form => $cases) {
    foreach ($cases as $case => $mail) {
        preg_match_all('/style="([^"]*)"(.)/', $mail['html'], $matches, PREG_SET_ORDER);

        $truncated = [];

        foreach ($matches as $match) {
            if (!in_array($match[2], [' ', '>'], true)) {
                $truncated[] = mb_substr($match[1], -40, null, 'UTF-8') . '␃' . $match[2];
            }
        }

        check(
            "{$form}/{$case}: all " . count($matches) . ' style attributes close cleanly'
                . ($truncated === [] ? '' : ' — truncated: ' . implode(' | ', $truncated)),
            $truncated === []
        );
    }
}

echo "\n-- the empty name --\n";

foreach ($rendered as $form => $cases) {
    $noname = $cases['noname'];

    check("{$form}: the letter does not open \"Dear ,\"", !str_contains($noname['text'], 'Dear ,') && !str_contains($noname['html'], 'Dear ,'));
    check("{$form}: the neutral greeting is used instead", str_contains($noname['text'], t('mail.hello')));
    check("{$form}: the To header carries no name",        $noname['to_name'] === '');
}

echo "\n-- one shell, one measure --\n";

/*
   BOTH LETTERS COME OUT OF mail_letter_html(), WHICH IS ONE FUNCTION WITH NO
   BRANCHES IN IT. That is the reason they cannot drift; this is the evidence
   that they have not. Each fragment below is a literal string built here and
   found in both letters — the measure, the crest with the alt text that stands
   in for it, the dark-mode declaration, and the signature with its two
   addresses.
*/
$shared = [
    'the measure'      => 'width="' . MAIL_WIDTH . '" cellpadding="0" cellspacing="0" border="0" style="width: 100%; max-width: ' . MAIL_WIDTH . 'px;',
    'the crest'        => '<img src="cid:' . MAIL_CREST_CID . '" width="' . MAIL_CREST_PX . '" height="' . MAIL_CREST_PX . '" alt="' . e(t('site.name_lockup')) . '"',
    'the light-only declaration' => '<style>:root { color-scheme: light; supported-color-schemes: light; }</style>',
    'the signature'    => e(t('site.name_lockup')) . '<br>' . e(t('footer.location')),
    'the mailbox link' => '<a href="mailto:' . e(t('footer.email')) . '"',
    'the site link'    => '>' . e(mail_letter_host()) . '</a>',
];

foreach ($shared as $what => $fragment) {
    check(
        sprintf('%-28s is identical in both letters', $what),
        str_contains($rendered['enquiry']['normal']['html'], $fragment)
            && str_contains($rendered['membership']['normal']['html'], $fragment)
    );
}

foreach ($rendered as $form => $cases) {
    check("{$form}: no trace of the old 560px measure", !str_contains($cases['normal']['html'], '560'));
}

echo "\n-- the notifications to info@ --\n";

foreach (PREVIEW_BUILDERS as $form => $builders) {
    $values = PREVIEW_CASES[$form]['normal'];
    $notify = $builders['notify']($values);

    $name = $form === 'membership'
        ? trim($values['name'] . ' ' . $values['surname'])
        : $values['name'];

    check("{$form}: Reply-To is the sender, not the estate", $notify['reply_to'] === $values['email']);
    check("{$form}: Reply-To carries the sender's name",     $notify['reply_to_name'] === $name);
    check("{$form}: it is addressed to MAIL_TO",             $notify['to'] === MAIL_TO);
}

// ---------------------------------------------------------------------------
// Output
// ---------------------------------------------------------------------------

$out = dirname(__DIR__) . '/private/logs';

foreach ($rendered as $form => $cases) {
    foreach ($cases as $case => $mail) {
        /*
           The crest is embedded under cid: in the real mail, which a browser
           cannot resolve. For the file on disk it is rewritten to the asset it
           is attached from, so the preview shows the letter as a client with
           images ON would draw it — and the images-OFF reading is done by
           blocking them in the browser, which is the honest way to see it.
        */
        $html = str_replace(
            'src="cid:' . MAIL_CREST_CID . '"',
            'src="../../public_html/assets/img/brand/crest-green.png"',
            $mail['html']
        );

        file_put_contents($out . "/preview-{$form}-{$case}.html", $html);
        file_put_contents($out . "/preview-{$form}-{$case}.txt",  $mail['text']);
    }
}

echo "\nWritten to private/logs/preview-<form>-<case>.html and .txt\n";

// ---------------------------------------------------------------------------

$form = 'enquiry';
$case = null;
$send = null;

foreach ($argv as $arg) {
    if (str_starts_with($arg, '--form=')) {
        $form = substr($arg, 7);
    }
    if (str_starts_with($arg, '--case=')) {
        $case = substr($arg, 7);
    }
    if (str_starts_with($arg, '--send=')) {
        $send = substr($arg, 7);
    }
}

if (!isset(PREVIEW_CASES[$form])) {
    exit("\n--form must be one of: " . implode(', ', array_keys(PREVIEW_CASES)) . "\n");
}

if ($case !== null && isset($rendered[$form][$case])) {
    echo "\n=== {$form}/{$case}: plain-text part ===\n\n";
    echo $rendered[$form][$case]['text'];
    echo "\n=== {$form}/{$case}: HTML part ===\n\n";
    echo $rendered[$form][$case]['html'] . "\n";
}

// ---------------------------------------------------------------------------
// The live send
// ---------------------------------------------------------------------------

/**
 * --send=address puts a real submission through the real mailer.
 *
 * It goes through form_send() rather than through a copy of it, so what lands
 * in the mailbox is what the site sends and not what this file thinks the site
 * sends. The notification goes wherever MAIL_TO points; the autoreply goes to
 * the address given here, which is what makes it testable without borrowing
 * somebody's inbox.
 */
if ($send !== null) {
    if (!filter_var($send, FILTER_VALIDATE_EMAIL)) {
        exit("\n--send needs a valid address.\n");
    }

    /*
       PULLED IN HERE AND NOT AT THE TOP. handler.php requires this file only
       at the point it has a valid submission to mail (handler.php:295), and it
       drags in the vendored PHPMailer with it — three files a render-and-check
       run has no use for. The rendering path stays free of it, which is also
       what keeps a broken vendor directory from failing the checks.
    */
    require_once APP_PATH . '/forms/mail/send.php';

    $values          = PREVIEW_CASES[$form][$case ?? 'normal'];
    $values['email'] = $send;

    echo "\n=== sending ===\n\n";
    echo '  form      ' . $form . ' / ' . ($case ?? 'normal') . "\n";
    echo '  from      ' . SMTP_FROM . ' via ' . SMTP_HOST . ':' . SMTP_PORT . "\n";
    echo '  site      ' . SITE_URL . "\n";
    echo '  notify    → ' . MAIL_TO . "\n";
    echo '  autoreply → ' . $send . "\n\n";

    form_send($form, $values);

    echo "  form_send() returned; see private/logs/form_errors.log for any SMTP failure.\n";
}

// ---------------------------------------------------------------------------

printf("\n%d checks, %d failed\n", $checks, count($failures));

if ($failures !== []) {
    echo "\nFAILED:\n";

    foreach ($failures as $failure) {
        echo "  - {$failure}\n";
    }

    exit(1);
}

echo "\nAll checks passed.\n";
