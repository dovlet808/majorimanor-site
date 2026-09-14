<?php
/**
 * The branded wrapper every HTML mail from this site is poured into.
 *
 * A LETTERHEAD, NOT A NEWSLETTER. Cream ground, the crest at the top, one
 * column, a hairline, and the wordmark under it. No hero image, no buttons, no
 * columns, no social row, no unsubscribe — this is a transactional mail
 * answering something a person just did, and the register is the site's
 * (ARCHITECTURE §12.4).
 *
 * WHY IT IS WRITTEN LIKE 2005. Tables, inline styles, no shorthand and no
 * modern CSS: mail clients are not browsers. Outlook renders through Word,
 * Gmail strips a <style> block in some contexts and keeps it in others, and
 * flexbox exists in roughly none of them. Every rule that has to hold is on
 * the element that needs it.
 *
 * THE CREST IS EMBEDDED, NOT LINKED. A remote image is blocked by default in
 * most clients, and the first thing an applicant receives from the estate
 * should not be a broken-image box where the seal is. send.php attaches
 * assets/img/brand/crest-green.png and hands its content id in here.
 *
 * Green on cream rather than gold on wine, which is the temperature the
 * membership page runs: a mail is read in a client whose own ground is white,
 * often forced light, and the cream-and-green pairing is the one that survives
 * that. The site's night palette is a page effect and does not travel.
 *
 * -------------------------------------------------------------------------
 * EVERY PART BELOW IS OPTIONAL AND EVERY DEFAULT IS "RENDER NOTHING".
 *
 * THIS FILE IS NOT CALLED DIRECTLY BY A MAIL ANY MORE. Both autoreplies are
 * built through mail_letter() in letter.php, which fixes the crest, the alt
 * text, the measure and the signature so that neither letter can drift from
 * the other. What is left here is the drawing: how a paragraph, a receipt row
 * and a link are set, and how the whole thing survives a mail client.
 *
 * The two opt-ins this file used to carry — one for the styled alt text, one
 * for the dark-mode declaration — are gone. They existed for exactly as long
 * as one mail had been rebuilt and the other had not, so that a shared wrapper
 * could not quietly restyle a letter nobody had asked to have touched. Both
 * letters now ask for both, and a flag with one branch is a flag.
 *
 * NO CALLER EVER PASSES MARKUP. Every part is plain text or a small array of
 * plain text, escaped here on the way in. The signature's links are the reason
 * that rule needed defending: the obvious way to put an <a> in a letter is to
 * let the caller write one, and then the one file that must never interpolate
 * an unescaped value is the one file that does. Links arrive as label and href
 * and the anchor is built below, where the escaping is not optional.
 * -------------------------------------------------------------------------
 */

declare(strict_types=1);

/** The crest, at the size it is legible and no larger (ARCHITECTURE §8.5). */
const MAIL_CREST_PX = 96;

/**
 * The content id the crest is embedded under.
 *
 * Fixed rather than generated, and declared here rather than beside either
 * autoreply: this file writes the cid: reference and send.php attaches the
 * file, so the two have to agree, and there is exactly one image in any mail
 * this site sends.
 */
const MAIL_CREST_CID = 'crest';

/**
 * The measure a letter is set to, in pixels.
 *
 * 600 IS THE ONE NUMBER EVERY MAIL CLIENT AGREES ON. It is the width the
 * preview panes of Outlook and the desktop clients were built around, and the
 * point past which a table starts being scaled down on a phone rather than
 * shown.
 *
 * IT IS NOW THE ONLY MEASURE. The membership autoreply was built at 560 and
 * kept there while it was the mail that had not been rebuilt; two letters from
 * one estate arriving at two widths is the sort of difference nobody can name
 * and everybody can see, and there was never a reason for the narrower one
 * beyond the order the two mails happened to be written in.
 */
const MAIL_WIDTH = 600;

/**
 * The stack of blocks between the crest and the hairline, spaced as one column.
 *
 * WHY THIS IS A FUNCTION AND NOT FOUR ROWS WRITTEN OUT. Each block is
 * optional, and the gap belongs between two of them rather than under any one
 * — so written out, every block would need to know what follows it, and the
 * enquiry letter (no privacy line) has to end in exactly the same 32px of
 * cream as the membership one (which has). Here the rule is stated once: 24px
 * between blocks, 32px under the last one, and an empty block is not a row at
 * all rather than a row of nothing.
 *
 * @param string[] $blocks rendered HTML, in order; empties are dropped
 */
function mail_template_rows(array $blocks): string
{
    $blocks = array_values(array_filter($blocks, static fn (string $b): bool => $b !== ''));
    $last   = count($blocks) - 1;
    $rows   = '';

    foreach ($blocks as $index => $block) {
        $bottom = $index === $last ? '32px' : '24px';

        $rows .= '<tr><td style="padding: 0 32px ' . $bottom . ' 32px;">' . $block . '</td></tr>';
    }

    return $rows;
}

/**
 * Wrap the parts of a letter in the letterhead.
 *
 * @param array{
 *     crest_cid?: string,
 *     crest_alt?: string,
 *     preheader?: string,
 *     salutation?: string,
 *     lines?: string[],
 *     detail?: array<int, array{label: string, value: string}>,
 *     after?: string[],
 *     note?: array{text: string, label: string, href: string}|null,
 *     wordmark?: string,
 *     location?: string,
 *     links?: array<int, array{label: string, href: string}>,
 *     closing?: string,
 *     width?: int
 * } $parts
 *        Everything is PLAIN TEXT and is escaped here, so a caller never has
 *        to remember to and cannot forget.
 *
 *        lines       one paragraph each, above the receipt block
 *        detail      the bordered receipt block, label and value per row
 *        after       one paragraph each, below the receipt block
 *        note        one small line with a single link in it, below those
 *        links       the signature's addresses, label and href per link
 */
function mail_template(array $parts): string
{
    $crestCid   = (string) ($parts['crest_cid'] ?? '');
    $crestAlt   = (string) ($parts['crest_alt'] ?? t('a11y.crest'));
    $preheader  = trim((string) ($parts['preheader'] ?? ''));
    $salutation = trim((string) ($parts['salutation'] ?? ''));
    $lines      = (array)  ($parts['lines'] ?? []);
    $detail     = (array)  ($parts['detail'] ?? []);
    $after      = (array)  ($parts['after'] ?? []);
    $note       = $parts['note'] ?? null;
    $links      = (array)  ($parts['links'] ?? []);
    $closing    = trim((string) ($parts['closing'] ?? ''));
    $width      = (int)    ($parts['width'] ?? MAIL_WIDTH);

    $wordmark = trim((string) ($parts['wordmark'] ?? t('site.name')));
    $location = trim((string) ($parts['location'] ?? t('footer.location')));

    $cream     = '#F2EDE4';
    $creamDeep = '#E6DFD2';
    $ink       = '#101511';
    $green     = '#1A4438';

    /*
       SINGLE QUOTES ROUND THE FONT NAMES, AND IT IS NOT A STYLE PREFERENCE.

       These stacks are interpolated into style="…", so a double quote inside
       one ENDS THE ATTRIBUTE. The markup this file used to emit read

           style="… font-family: -apple-system, "Segoe UI", Roboto, …;
                   font-size: 15px; line-height: 24px; color: #101511;"

       and a parser takes the style to be "… font-family: -apple-system, ",
       then reads Segoe, UI", Roboto, … as thirteen more attributes on the
       paragraph. The size, the leading and the colour are not overridden —
       they are never delivered, and the letter renders in the client's
       default 16px black with normal leading.

       Checked in Chrome rather than assumed: the truncated attribute and the
       thirteen stray ones are what the DOM actually contains.

       CSS accepts single-quoted family names exactly as it accepts double, so
       this costs nothing. The foot of this letter has always used single
       quotes and has always been right; the body did not, and was not.
    */
    $serif = "'Playfair Display', Georgia, 'Times New Roman', serif";
    $sans  = "-apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif";

    // -----------------------------------------------------------------------
    // The preheader
    // -----------------------------------------------------------------------

    /*
       THE LINE THE MESSAGE LIST PRINTS, AND NOWHERE ELSE.

       Hidden six ways because no single one of them holds everywhere: display
       none is ignored by some clients, zero height by others, and mso-hide is
       the only one Outlook reads. What follows it is a run of zero-width
       characters, and they are not decoration — without them a client that has
       run out of preheader keeps going into the letter and prints "Dear Anna,
       Your enquiry has reach…" after it. The run is what it hits instead.
    */
    $preheaderBlock = '';

    if ($preheader !== '') {
        $preheaderBlock = '<div style="display: none; font-size: 1px; line-height: 1px;'
            . ' max-height: 0; max-width: 0; opacity: 0; overflow: hidden;'
            . ' mso-hide: all; color: ' . $cream . ';">'
            . e($preheader)
            . str_repeat('&#847;&zwnj;&nbsp;&#8199;&shy;', 30)
            . '</div>';
    }

    // -----------------------------------------------------------------------
    // The body
    // -----------------------------------------------------------------------

    /*
       One paragraph of body text, at the measure the rest of the letter is
       set in. Shared by 'lines' and by 'after' — the two differ only in which
       side of the receipt block they fall on, and a paragraph that changed
       size when it moved would be a bug nobody would think to look for.
    */
    $paragraph = static function (string $line, string $top) use ($sans, $ink): string {
        return '<p style="margin: ' . $top . ' 0 0 0; padding: 0;'
            . ' font-family: ' . $sans . ';'
            . ' font-size: 15px; line-height: 24px;'
            . ' color: ' . $ink . ';">'
            . e($line)
            . '</p>';
    };

    $body = '';

    if ($salutation !== '') {
        $body .= '<p style="margin: 0 0 0 0; padding: 0; font-family: ' . $serif . ';'
            . ' font-size: 22px; line-height: 30px; color: ' . $ink . ';">'
            . e($salutation)
            . '</p>';
    }

    foreach ($lines as $index => $line) {
        $line = trim((string) $line);

        if ($line === '') {
            continue;
        }

        /*
           WITHOUT A SALUTATION the first line is the one that carries the
           message and it is set in the display face; the rest are text. That
           is the membership mail, unchanged.

           WITH ONE the salutation above is already the display line, and a
           second paragraph at 22px would be two openings and no letter — so
           every line is body text and the greeting keeps the weight.

           Playfair is not installed on anybody's mail client, so the stack
           falls to Georgia and then to any serif, which is the point of
           naming three.
        */
        $isLead = $salutation === '' && $index === 0;

        $font   = $isLead ? $serif : $sans;
        $size   = $isLead ? '22px' : '15px';
        $height = $isLead ? '30px' : '24px';
        $top    = $isLead ? '0' : '16px';

        $body .= '<p style="margin: ' . $top . ' 0 0 0; padding: 0;'
            . ' font-family: ' . $font . ';'
            . ' font-size: ' . $size . '; line-height: ' . $height . ';'
            . ' color: ' . $ink . ';">'
            . e($line)
            . '</p>';
    }

    // -----------------------------------------------------------------------
    // The receipt block
    // -----------------------------------------------------------------------

    /*
       WHAT THEY SENT, SHOWN BACK AS A BLOCK RATHER THAN A SENTENCE.

       A bordered table, because this is the part of the letter a reader
       checks rather than reads, and a thing to be checked wants an edge round
       it. The green rule down the left is what makes it read as a block in a
       client that has decided a 1px cream border is not worth drawing.

       The label column is fixed and the value column takes the rest, so two
       rows line up. Values are escaped like everything else — the subject is
       chosen from a list, but the block is built to hold anything, and the
       day it holds something typed is not the day to discover that.
    */
    $detailBlock = '';

    if ($detail !== []) {
        $rows = '';

        foreach ($detail as $row) {
            $label = trim((string) ($row['label'] ?? ''));
            $value = trim((string) ($row['value'] ?? ''));

            if ($label === '' && $value === '') {
                continue;
            }

            // The gap between rows is padding on the cells and not a margin,
            // which Outlook would drop, and not an empty row, which it would
            // give a height of its own choosing.
            $pad = $rows === '' ? '0' : '10px';

            $rows .= '<tr>'
                . '<td width="104" style="width: 104px; padding: ' . $pad . ' 12px 0 0;'
                . ' vertical-align: top; font-family: ' . $sans . ';'
                . ' font-size: 11px; line-height: 18px; letter-spacing: 1px;'
                . ' text-transform: uppercase; color: ' . $green . ';">'
                . e($label)
                . '</td>'
                . '<td style="padding: ' . $pad . ' 0 0 0; vertical-align: top;'
                . ' font-family: ' . $sans . ';'
                . ' font-size: 15px; line-height: 18px; color: ' . $ink . ';">'
                . e($value)
                . '</td>'
                . '</tr>';
        }

        if ($rows !== '') {
            $detailBlock = '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"'
                . ' style="width: 100%; border: 1px solid ' . $creamDeep . ';'
                . ' border-left: 3px solid ' . $green . ';">'
                . '<tr><td style="padding: 16px 20px;">'
                . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">'
                . $rows
                . '</table>'
                . '</td></tr>'
                . '</table>';
        }
    }

    // -----------------------------------------------------------------------
    // What comes after the receipt
    // -----------------------------------------------------------------------

    /*
       The paragraph about the house, and anything else that belongs below the
       block rather than above it. A reader opened this mail to find out that
       their enquiry arrived; they get that first, and the estate talks about
       itself once they have it.
    */
    $afterBlock = '';

    foreach ($after as $line) {
        $line = trim((string) $line);

        if ($line === '') {
            continue;
        }

        $afterBlock .= $paragraph($line, $afterBlock === '' ? '0' : '16px');
    }

    // -----------------------------------------------------------------------
    // The line with a link in it
    // -----------------------------------------------------------------------

    /*
       ONE LINE, ONE LINK, AND NO SECOND NOTICE.

       The membership letter carries a pointer to /privacy, because that form
       asks for an occupation and for free text somebody wrote about
       themselves, and the copy they keep should hold the address of the page
       that explains what happens to it. The form itself carries the full
       notice above its button (ARCHITECTURE §12.3); this is a pointer, and a
       paragraph of legal prose in a receipt would be neither read nor
       sufficient.

       SET SMALLER THAN THE LETTER AND ABOVE THE HAIRLINE. It is not part of
       what the estate is saying, and it is not housekeeping like the closing
       line either — it belongs to the letter, one step quieter.

       THE ANCHOR IS BUILT HERE AND THE SENTENCE IS ESCAPED BEFORE IT GOES IN,
       in that order, which is the same order templates/partials/form.php uses
       for the notice on the form itself. Escaping after the replacement would
       print the markup; not escaping at all would publish whatever a
       translator wrote. e() leaves the braces of {link} alone, which is what
       makes the two steps commute in the one direction that is safe.

       A SENTENCE WITH NO {link} IN IT STILL GETS THE LINK. The placeholder is
       in a content file and a translation is a file somebody else writes; a
       privacy pointer that silently loses its address because a brace did not
       survive the trip is worse than one with the link on the end.
    */
    $noteBlock = '';

    if (is_array($note)) {
        $noteText  = trim((string) ($note['text'] ?? ''));
        $noteLabel = trim((string) ($note['label'] ?? ''));
        $noteHref  = trim((string) ($note['href'] ?? ''));

        if ($noteText !== '' && $noteLabel !== '' && $noteHref !== '') {
            $anchor = '<a href="' . e($noteHref) . '"'
                . ' style="color: ' . $green . '; text-decoration: underline;">'
                . e($noteLabel)
                . '</a>';

            $noteBody = str_contains($noteText, '{link}')
                ? str_replace('{link}', $anchor, e($noteText))
                : e($noteText) . ' ' . $anchor;

            $noteBlock = '<p style="margin: 0; padding: 0;'
                . ' font-family: ' . $sans . ';'
                . ' font-size: 13px; line-height: 20px;'
                . ' color: ' . $ink . ';">'
                . $noteBody
                . '</p>';
        }
    }

    // -----------------------------------------------------------------------
    // The crest
    // -----------------------------------------------------------------------

    /*
       THE ALT TEXT IS STYLED, AND THAT IS NOT FUSSINESS. With images off —
       which is the default in Outlook and in a good deal of corporate mail —
       the alt string is what stands at the top of the letter, and unstyled it
       arrives as small blue underlined Times. These rules are the ones a
       client applies to the replacement text, so the letterhead still opens in
       the estate's own green whether the picture loaded or not.
    */
    /*
       WHAT THE ALT TEXT IS SET IN, and it is not the letterspaced small caps
       the foot uses. The replacement text has to wrap inside the image's own
       96px box — the width attribute is not optional, the crest is a 320px
       asset drawn down for a high-density screen — so every extra pixel of
       tracking is another broken line under a missing-image icon. No
       letter-spacing, and 12px over 16px, is what fits the lockup in three
       clean lines instead of five ragged ones.
    */
    $altStyle = ' font-family: ' . $sans . '; font-size: 12px; line-height: 16px; color: ' . $green . ';';

    $crest = $crestCid !== ''
        ? '<img src="cid:' . e($crestCid) . '" width="' . MAIL_CREST_PX . '" height="' . MAIL_CREST_PX . '"'
            . ' alt="' . e($crestAlt) . '"'
            . ' style="display: block; margin: 0 auto; border: 0; outline: none; text-decoration: none;'
            . $altStyle . '">'
        : '';

    // -----------------------------------------------------------------------
    // The foot
    // -----------------------------------------------------------------------

    /*
       THE FOOT IS THE LETTERHEAD AND NOT A SIGN-OFF.

       The wordmark and the location line, exactly as the site's own footer
       carries them, so the mail is identifiably from the estate rather than
       from a form.

       THE TWO ADDRESSES ARE THE ONE THING THAT WAS ADDED TO IT, and only for
       the mail that asks for them. A letter that answers an enquiry is a
       letter somebody may want to reply to or look up, and the reply-to on
       this one is a mailbox they cannot see. Still no social row, no address
       book and no "follow us": two links, both to the estate, both spelled out
       in full so they read as themselves with the styling stripped.
    */
    $foot = '<p style="margin: 0; padding: 0; font-family: ' . $sans . ';'
        . ' font-size: 11px; line-height: 18px; letter-spacing: 2px; text-transform: uppercase;'
        . ' color: ' . $green . ';">'
        . e($wordmark)
        . '<br>'
        . e($location)
        . '</p>';

    if ($links !== []) {
        $rendered = [];

        foreach ($links as $link) {
            $label = trim((string) ($link['label'] ?? ''));
            $href  = trim((string) ($link['href'] ?? ''));

            if ($label === '' || $href === '') {
                continue;
            }

            $rendered[] = '<a href="' . e($href) . '"'
                . ' style="color: ' . $green . '; text-decoration: underline;">'
                . e($label)
                . '</a>';
        }

        if ($rendered !== []) {
            $foot .= '<p style="margin: 12px 0 0 0; padding: 0; font-family: ' . $sans . ';'
                . ' font-size: 13px; line-height: 20px; color: ' . $green . ';">'
                . implode('<br>', $rendered)
                . '</p>';
        }
    }

    /*
       The last line, under the letterhead and smaller than it. It is
       housekeeping rather than part of the letter — the person who needs it is
       the one who did not write to us — so it sits where housekeeping sits and
       does not interrupt the mail for everybody else.
    */
    if ($closing !== '') {
        $foot .= '<p style="margin: 20px 0 0 0; padding: 0; font-family: ' . $sans . ';'
            . ' font-size: 12px; line-height: 18px; color: ' . $ink . ';">'
            . e($closing)
            . '</p>';
    }

    // -----------------------------------------------------------------------
    // The document
    // -----------------------------------------------------------------------

    /*
       DARK MODE IS DECLINED IN THREE PLACES AND IT TAKES ALL THREE. The two
       meta tags are what Apple Mail and Outlook read; the :root rule is what
       the webmail clients read, and it is in a <style> block because there is
       no element to hang it on. Without them a client that inverts everything
       it is not told about turns a cream panel into a muddy olive and the
       green type into something that fails its own contrast — a letterhead
       does not have a dark variant, so the mail says so rather than hoping.

       Gmail strips the block in some contexts and keeps it in others, which is
       survivable here: everything in it is a preference, and every colour that
       has to hold is already inline on the element that needs it.
    */
    return '<!doctype html>'
        . '<html lang="' . e(current_lang()) . '">'
        . '<head>'
        . '<meta charset="utf-8">'
        . '<meta name="viewport" content="width=device-width, initial-scale=1">'
        . '<meta name="color-scheme" content="light">'
        . '<meta name="supported-color-schemes" content="light">'
        . '<title>' . e(t('site.name')) . '</title>'
        . '<style>:root { color-scheme: light; supported-color-schemes: light; }</style>'
        . '</head>'
        . '<body style="margin: 0; padding: 0; width: 100%; background-color: ' . $creamDeep . ';">'

        . $preheaderBlock

        . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"'
        . ' style="background-color: ' . $creamDeep . ';">'
        . '<tr>'
        . '<td align="center" style="padding: 32px 16px;">'

        // The letter itself, held to a readable measure.
        . '<table role="presentation" width="' . $width . '" cellpadding="0" cellspacing="0" border="0"'
        . ' style="width: 100%; max-width: ' . $width . 'px; background-color: ' . $cream . ';">'

        . '<tr><td align="center" style="padding: 40px 32px 24px 32px;">' . $crest . '</td></tr>'

        . mail_template_rows([$body, $detailBlock, $afterBlock, $noteBlock])

        // The hairline, drawn as a table cell because a border on a <hr> is
        // the sort of thing Outlook renders at a height of its own choosing.
        . '<tr><td style="padding: 0 32px;">'
        . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"><tr>'
        . '<td height="1" style="height: 1px; line-height: 1px; font-size: 0;'
        . ' background-color: ' . $creamDeep . ';">&nbsp;</td>'
        . '</tr></table>'
        . '</td></tr>'

        . '<tr><td align="center" style="padding: 24px 32px 40px 32px;">' . $foot . '</td></tr>'

        . '</table>'

        . '</td>'
        . '</tr>'
        . '</table>'

        . '</body></html>';
}
