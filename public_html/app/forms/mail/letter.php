<?php
/**
 * THE SPINE BOTH AUTOREPLIES ARE BUILT ON.
 *
 * template.php is the letterhead — the tables, the cream, the crest, the rules
 * that survive Outlook. This file is the letter: the parts that are the same
 * message whichever form was filled in, and which were, until the membership
 * mail was rebuilt, written out twice.
 *
 * WHAT IS FIXED HERE AND IS NOT A CALLER'S DECISION:
 *
 *   the crest, and the alt text that stands in for it when images are blocked
 *   the measure — MAIL_WIDTH, 600px, one number for both letters
 *   the plain-text alternative, in full, built from the same strings as the HTML
 *   the signature: the lockup, the location, the mailbox and the site
 *   the manor's own clock, named in words
 *   the greeting, and what happens when there is no name to put in it
 *
 * WHAT A CALLER DECIDES is what its letter says: a preheader, a salutation, the
 * lines above the receipt, the receipt's rows, the paragraphs below it, one
 * optional line with a link in it, and the closing line. Nothing else.
 *
 * THIS IS THE POINT OF THE FILE. Two mails that share a shell in principle and
 * are edited separately in practice do not stay the same mail: the enquiry
 * autoreply gained a plain-text part, a considered alt text and a dark-mode
 * declaration, and for as long as the membership mail was built beside it
 * rather than through it, none of that reached an applicant. A change made here
 * now lands in both, and a change that should only land in one has to be made
 * where that one is built — which is the distinction the old arrangement could
 * not express.
 *
 * NOTHING IS ESCAPED IN THIS FILE. Every value is plain text: the HTML part is
 * escaped in mail_template(), the plain-text part is served as text/plain where
 * < > & " are the characters themselves. See mail_letter_text() for why running
 * the second one through e() would be a bug rather than a precaution.
 */

declare(strict_types=1);

require_once __DIR__ . '/template.php';

/**
 * The zone the estate keeps time in.
 *
 * NAMED RATHER THAN INHERITED. date() on shared hosting reports whatever zone
 * the host was built with — UTC on one box, America/Chicago on another — and a
 * receipt that states a time is a receipt that has to mean one. The
 * notifications to info@ solve the same problem by printing UTC and saying so;
 * these mails are read by a person rather than filed, so they use the manor's
 * own clock and name it in words.
 */
const MAIL_TZ = 'Europe/Riga';

/** Where the plain-text part wraps, in characters. */
const MAIL_TEXT_WIDTH = 72;

/** The column the plain-text receipt's values line up on, inside its indent. */
const MAIL_TEXT_LABEL = 14;

/**
 * The greeting, with a fallback that is a greeting and not a bug.
 *
 * The name field is required on both forms and form_validate() enforces it, so
 * an empty name should never reach here. This is what happens if one ever does:
 * a neutral opening, rather than "Dear ," — which is the sort of thing that
 * gets screenshotted.
 */
function mail_letter_salutation(string $name): string
{
    if (trim($name) === '') {
        return t('mail.hello');
    }

    return str_replace('{name}', trim($name), t('mail.salutation'));
}

/**
 * When it arrived, in the manor's time zone, spelled out for a person.
 *
 * "13 August 2026 at 15:42 (Latvian time)" and not an ISO timestamp: this is a
 * letter, and 2026-08-13T15:42:00+03:00 is a log line.
 */
function mail_letter_received(): string
{
    $now = new DateTimeImmutable('now', new DateTimeZone(MAIL_TZ));

    return $now->format(t('mail.received_format'))
        . ' (' . t('mail.received_zone') . ')';
}

/**
 * The site's address without its scheme, for the visible half of a link.
 *
 * "majorimanor.com" is what belongs in a letter; https:// belongs in the href,
 * where the client needs it. Derived from SITE_URL rather than written out, so
 * a test sent from dev says dev.
 */
function mail_letter_host(): string
{
    return defined('SITE_URL') ? (string) parse_url((string) SITE_URL, PHP_URL_HOST) : '';
}

/**
 * An absolute address for one of this site's pages.
 *
 * url() alone returns a path, which is all a page ever needs and is useless in
 * a mail — a letter is read outside the site, where "/privacy" is nothing. The
 * path still comes from routes.php, so the one rule about addresses holds here
 * too (helpers.php): they are built, never written out.
 */
function mail_letter_url(string $pageId): string
{
    return (defined('SITE_URL') ? (string) SITE_URL : '') . url($pageId);
}

/**
 * The plain-text part: the same letter, unwrapped.
 *
 * IT IS THE WHOLE LETTER AND NOT THE HTML WITH ITS TAGS PULLED OFF — the same
 * salutation, the same lines, the same receipt set as aligned text, the same
 * paragraphs, the same signature. It is what a text-only client shows, what a
 * screen reader in a mail app is happiest with, and part of what keeps the
 * message out of the spam folder: an HTML part with a token text part beside it
 * is a shape bulk senders use and filters score.
 *
 * NOTHING IS ESCAPED HERE AND NOTHING SHOULD BE. This part is served as
 * text/plain, where < > & " are the characters themselves and nothing is
 * parsed — running it through e() would deliver a sender called Anna & Co. a
 * letter addressed to Anna &amp; Co. The escaping that matters happens in the
 * HTML part, and the injection that matters — a newline near a header — was
 * dealt with by form_clean() before any of this ran.
 *
 * @param array{preheader?: string, salutation?: string, lines?: string[],
 *              detail?: array<int, array{label: string, value: string}>,
 *              after?: string[],
 *              note?: array{text: string, label: string, href: string}|null,
 *              closing?: string} $letter
 */
function mail_letter_text(array $letter): string
{
    $wrap = static fn (string $text): string => wordwrap($text, MAIL_TEXT_WIDTH, "\n", false);

    /*
       THE LETTERHEAD GOES AT THE TOP IN THIS PART, and it is the one place the
       plain text is laid out differently from the HTML. A text mail has no
       crest, so the first thing a reader sees has to say who is writing; in the
       HTML the picture already did that, and the wordmark can sit at the foot
       where a signature belongs.

       mb_strtoupper rather than a hand-typed capital: the lockup is stored in
       natural case in common.php and this is what turns "Muiža" into "MUIŽA"
       with the ž intact. strtoupper would leave it alone and produce
       "MAJORI MUIžA".
    */
    $text  = mb_strtoupper(t('site.name_lockup'), 'UTF-8') . "\n";
    $text .= t('footer.location') . "\n";
    $text .= str_repeat('-', MAIL_TEXT_WIDTH) . "\n\n";

    $salutation = trim((string) ($letter['salutation'] ?? ''));

    if ($salutation !== '') {
        $text .= $salutation . "\n\n";
    }

    foreach ((array) ($letter['lines'] ?? []) as $line) {
        $line = trim((string) $line);

        if ($line !== '') {
            $text .= $wrap($line) . "\n\n";
        }
    }

    /*
       The receipt block, as the only thing plain text has for a box: labelled
       lines, indented so they read as a block and not as more sentences. The
       column is the label column of the notification mail, cut to fit an
       indent, and padded with mb_strlen rather than str_pad because str_pad
       counts bytes — a label with a diacritic in it would sit a column short.
    */
    $detail = array_values(array_filter(
        (array) ($letter['detail'] ?? []),
        static fn ($row): bool => is_array($row)
            && (trim((string) ($row['label'] ?? '')) !== '' || trim((string) ($row['value'] ?? '')) !== '')
    ));

    if ($detail !== []) {
        foreach ($detail as $row) {
            $label = trim((string) ($row['label'] ?? ''));

            $text .= '  ' . $label
                . str_repeat(' ', max(1, MAIL_TEXT_LABEL - mb_strlen($label, 'UTF-8')))
                . trim((string) ($row['value'] ?? ''))
                . "\n";
        }

        $text .= "\n";
    }

    foreach ((array) ($letter['after'] ?? []) as $line) {
        $line = trim((string) $line);

        if ($line !== '') {
            $text .= $wrap($line) . "\n\n";
        }
    }

    /*
       THE LINE WITH A LINK IN IT, AND HERE THE LINK HAS TO BE WRITTEN OUT. In
       the HTML part the address hides behind its words; in a text part there is
       nowhere for it to hide, and "see our privacy policy" with no address is a
       sentence pointing at nothing. So the sentence keeps its own words and the
       address goes on the line under it, whole and with its scheme, because a
       text part is read in clients that only linkify what looks like a URL.
    */
    $note = $letter['note'] ?? null;

    if (is_array($note)) {
        $sentence = str_replace(
            '{link}',
            (string) ($note['label'] ?? ''),
            (string) ($note['text'] ?? '')
        );

        if (trim($sentence) !== '' && trim((string) ($note['href'] ?? '')) !== '') {
            $text .= $wrap(trim($sentence)) . "\n";
            $text .= trim((string) $note['href']) . "\n\n";
        }
    }

    $text .= str_repeat('-', MAIL_TEXT_WIDTH) . "\n";
    $text .= mb_strtoupper(t('site.name_lockup'), 'UTF-8') . "\n";
    $text .= t('footer.location') . "\n";
    $text .= t('footer.email') . "\n";

    /*
       The site's address written out with its scheme, for the same reason the
       note's is. SITE_URL rather than a literal: on dev.majorimanor.com this
       mail should say where it actually came from.
    */
    $text .= (defined('SITE_URL') ? (string) SITE_URL : '') . "\n\n";

    $closing = trim((string) ($letter['closing'] ?? ''));

    if ($closing !== '') {
        $text .= $wrap($closing) . "\n";
    }

    return $text;
}

/**
 * The HTML part: the caller's letter, poured into the letterhead.
 *
 * EVERYTHING THIS FUNCTION ADDS IS THE PART THAT MUST NOT DIFFER between the
 * two mails — the crest and its alt text, the measure, the signature and its
 * two addresses. A caller cannot pass any of them, which is the point: they are
 * not decisions a letter gets to make.
 *
 * @param array $letter see mail_letter_text()
 */
function mail_letter_html(array $letter): string
{
    return mail_template([
        'crest_cid' => MAIL_CREST_CID,

        /*
           THE ALT TEXT IS THE LETTERHEAD WHEN THE PICTURE IS BLOCKED, which in
           Outlook and most corporate mail is the default rather than the
           exception.

           IT IS THE LOCKUP BECAUSE THAT IS WHAT THE CREST SAYS. The artwork is
           a ring of type reading MAJORI MANOR ✦ MAJORI MUIŽA round the house,
           so the alt is not a description of a picture, it is the words in the
           picture — which is the rule for a logo, and the reason this is not
           t('a11y.crest'). That string, "The Majori Manor crest", is right on a
           page where the wordmark is already in the markup beside it and the
           mark is decoration; here the mark IS the letterhead, and "the crest"
           tells a reader with images off nothing they can use.
        */
        'crest_alt' => t('site.name_lockup'),

        'preheader'  => (string) ($letter['preheader'] ?? ''),
        'salutation' => (string) ($letter['salutation'] ?? ''),
        'lines'      => (array)  ($letter['lines'] ?? []),
        'detail'     => (array)  ($letter['detail'] ?? []),
        'after'      => (array)  ($letter['after'] ?? []),
        'note'       => $letter['note'] ?? null,

        /*
           THE SIGNATURE. The lockup and the location exactly as the site's own
           footer carries them, and the two ways to reach the estate. Still no
           social row, no address book and no "follow us": two links, both to
           the estate, both spelled out in full so they read as themselves with
           the styling stripped.
        */
        'wordmark' => t('site.name_lockup'),
        'location' => t('footer.location'),

        'links' => [
            ['label' => t('footer.email'), 'href' => 'mailto:' . t('footer.email')],
            ['label' => mail_letter_host(), 'href' => defined('SITE_URL') ? (string) SITE_URL : ''],
        ],

        'closing' => (string) ($letter['closing'] ?? ''),
        'width'   => MAIL_WIDTH,
    ]);
}

/**
 * Both parts of a letter, from one set of strings.
 *
 * ONE SET OF STRINGS, BOTH PARTS, AND THIS IS WHY THE FUNCTION EXISTS RATHER
 * THAN THE TWO ABOVE BEING CALLED SEPARATELY. The failure being prevented is
 * the ordinary one where a line is reworded in the letter and not in the
 * alternative, and the two parts of the same message start saying different
 * things to different readers.
 *
 * @param  array $letter see mail_letter_text()
 * @return array{html: string, text: string}
 */
function mail_letter(array $letter): array
{
    return [
        'html' => mail_letter_html($letter),
        'text' => mail_letter_text($letter),
    ];
}
