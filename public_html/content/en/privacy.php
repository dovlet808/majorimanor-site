<?php
/**
 * English content of the privacy policy. Arrays only, no markup.
 *
 * THIS DOCUMENT DESCRIBES WHAT THIS SITE ACTUALLY DOES, and every sentence in
 * it was checked against the code rather than against a template:
 *
 *   the two forms          the field lists below are form_fields() in
 *                          app/forms/validate.php, label for label
 *   where it goes          app/forms/mail/send.php — SMTP to the estate's own
 *                          mailbox, and nowhere else
 *   what is logged         app/forms/handler.php's form_log(), which writes an
 *                          event and a hashed address and never a submitted
 *                          value, and app/forms/rate_limit.php, which stores
 *                          hashed addresses with timestamps for one hour
 *   no cookies             nothing on this site calls session_start() or
 *                          setcookie(); the response carries no Set-Cookie
 *   no analytics           there is no analytics script, because there is no
 *                          third-party script at all
 *   the map                templates/components/map.php — CARTO tiles, fetched
 *                          only if a reader scrolls to the map
 *
 * A PRIVACY POLICY THAT DESCRIBES A SITE THAT DOES NOT EXIST IS WORSE THAN
 * NONE. The usual template mentions cookies this site does not set, analytics
 * it does not run, and "trusted partners" it does not have — and every one of
 * those sentences is a false statement about the processing of personal data,
 * which is the one document where that is a legal problem and not a stylistic
 * one. So this file states the small true thing in each case, including the two
 * places where the answer is "nothing".
 *
 * THE CONTROLLER IS A GAP AND IT IS PRINTED AS ONE. The owner has not supplied
 * the company's legal name or registration number (ARCHITECTURE §21, open
 * question 4). Under Article 13 those are the first thing a policy must give,
 * so the clause exists, says so, and shows a TODO where they go. Filling it
 * with something plausible would be a false statement about a legal entity.
 *
 * IF THE SITE CHANGES, THIS FILE CHANGES WITH IT. Adding analytics, a cookie,
 * an embedded video, a booking widget or a CRM makes at least one sentence
 * below untrue — and the cookie-banner clause is the one that goes first.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * THE PAGE WAS REDRAWN ON 8 SEPTEMBER 2026 AND NOT ONE WORD OF THE POLICY WAS.
 *
 * /privacy was rebuilt as an editorial legal document inside the film's design
 * system — a clamped cinematic hero, a warm cream reading surface, a numbered
 * contents index, and the controller gap set as a notice rather than as an
 * error. The brief for that work said it in four places: "The existing
 * privacy-policy content is the SOURCE OF TRUTH… Do NOT rewrite… Do NOT
 * paraphrase… Do NOT shorten… Visual redesign only."
 *
 * SO 'title', 'links', 'updated', 'meta' AND EVERY ONE OF THE TWELVE SECTIONS
 * BELOW ARE BYTE FOR BYTE WHAT THEY WERE. The whole diff against the approved
 * file is one line changed — 'mood', from 'day' to 'night', because the page
 * now paints its own two grounds — and four keys added, none of which is legal
 * text: 'own_chrome', 'nav', 'footer', 'hero' and 'document'. Verified two
 * ways in docs/PRIVACY.md §6: the arrays diffed against a copy taken before
 * the work started, and the rendered page's 54 text nodes compared, in order,
 * against the strings in this file.
 *
 * THE PLACE TO CHANGE A CLAUSE IS STILL HERE, and the page still has no idea
 * what any of them say. templates/pages/privacy.php reads 'id', 'title' and
 * 'level' to number and order them, and passes everything else through.
 */

declare(strict_types=1);

return [

    'meta' => [
        'title'       => 'Privacy policy — Majori Manor',
        'description' => 'What majorimanor.com collects through its two forms, why, where it goes, how long it is kept, and how to exercise your rights.',
    ],

    /*
       The page paints its own two grounds — a dark first screen and a cream
       document — and this keeps the chrome tokens honest for anything that
       still reads mood(). It was 'day' while the whole page was cream; it is
       'night' now that the hero and the footer are not, which is the value
       every film page resolves to through home.css §2. It is the same edit
       CONTACT made for the same reason, and it changes no word of the policy.
    */
    'mood' => 'night',

    // The film's chrome — see the note at the top of this file.
    'own_chrome' => true,

    // Only the wording of the sheet that opens below 900px: the links
    // themselves come from routes.php through nav_pages(), so PRIVACY is
    // still absent from the bar (NAV_EXCLUDE) and present in the footer.
    'nav' => [
        'open_label'  => 'Open the menu',
        'close_label' => 'Close the menu',
        'aria_label'  => 'Main',
    ],

    'footer' => [
        'place' => 'Konkordijas iela 66, Jūrmala',
        'links' => FOOTER_LINKS,
    ],

    /*
       THE FIRST SCREEN, AND IT CARRIES NO WORDS OF ITS OWN.

       The eyebrow, the h1 and the line under them are 'title' below — the
       approved wording, in the one place it has always lived. This block is
       the picture and nothing else, so the hero cannot say anything the
       document does not.

       It is a clamped hero and not a full screen: templates/pages/privacy.php
       renders the film's hero component and privacy.css §2 holds it to about
       62svh, because the document has to begin before the fold on a laptop.
    */
    'hero' => [
        'film' => [
            'name'   => 'pri-doors',
            'poster' => 'privacy/pri-doors',
            'ratio'  => '16/9',
            'alt'    => 'A glazed mahogany screen inside the manor at first light, one tall door leaf standing open on the room beyond, with the stair balustrade in the foreground and daylight in the windows',
            'source' => 'generated',
        ],
    ],

    /*
       THE DOCUMENT'S FURNITURE, AND NOT ONE WORD OF IT IS THE POLICY.

       Three interface strings: what the index is called, what a screen reader
       is told it is, and the label on the control at the foot. "Last updated"
       is not among them — it is t('legal.updated') in common.php, where /terms
       reads it from too, and a second copy here is a second thing to translate.

       The numbers beside the sections are computed from 'sections' below and
       are deliberately not written here: a number typed into a content file is
       a number that goes wrong the first time a clause moves.
    */
    'document' => [
        'contents'      => 'Contents',
        'contents_aria' => 'Sections of this policy',
        'top'           => 'Return to the top',
    ],

    /*
       The date at the foot of the page, printed by templates/pages/legal.php.
       ISO here; spelled out there. Change it whenever a clause changes, and
       not otherwise — a policy whose date moves without its text is a policy
       nobody can diff.
    */
    'updated' => '2026-08-12',

    /*
       The document's link vocabulary. A clause writes {email}; this is what it
       means. See templates/components/clause.php — a content file names a
       link and never writes one.
    */
    'links' => [
        'email'      => ['email' => 'info@majorimanor.com'],
        'terms'      => ['page_id' => 'terms',      'label' => 'terms'],
        'membership' => ['page_id' => 'membership', 'label' => 'membership page'],
        'contact'    => ['page_id' => 'contact',    'label' => 'contact page'],
    ],

    'title' => [
        'eyebrow' => 'Legal',
        'title'   => 'Privacy policy',
        'lede'    => 'What this site collects, why, where it goes, and how to have it removed.',
    ],

    'sections' => [

        [
            'type'  => 'clause',
            'id'    => 'scope',
            'title' => 'What this covers',
            'body'  => [
                'This policy covers majorimanor.com and the two forms on it: the membership application on the {membership}, and the general enquiry form on the {contact} and elsewhere on the site.',
                'It describes what this website does. It is not a description of what happens at the estate itself.',
            ],
        ],

        [
            'type'  => 'clause',
            'id'    => 'controller',
            'title' => 'Who is responsible',
            'body'  => [
                'The estate at Konkordijas iela 66, Jūrmala, LV-2015, Latvia is the controller of the personal data described below. Questions about it go to {email}.',
            ],
            'todo'  => [
                'The controller\'s legal name, registration number and registered address are to be supplied by the owner and printed here and in the impressum on the {terms}. They are left blank rather than guessed.',
            ],
        ],

        [
            'type'  => 'clause',
            'id'    => 'collected',
            'title' => 'What the site collects',
            'body'  => [
                'Only what somebody types into one of the two forms and sends. Nothing is collected from a visitor who reads the site and does not write to it.',
            ],
        ],

        [
            'type'  => 'clause',
            'level' => 3,
            'id'    => 'collected-membership',
            'title' => 'The membership application',
            'body'  => [
                'The form on the {membership} asks for:',
            ],
            'list'  => [
                'Name and surname',
                'Country and city',
                'Occupation or company',
                'Email address and telephone number',
                'How you heard about Majori Manor',
                'Whether a member referred you, and if so their name',
                'Why you would like to join',
            ],
            'after' => [
                'Name, surname, country and email address are required. Everything else on that list may be left blank and the application is still accepted.',
                'The last two answers are free text: whatever is written in them is what is collected. Nothing is inferred from them and nothing is added to them.',
            ],
        ],

        [
            'type'  => 'clause',
            'level' => 3,
            'id'    => 'collected-enquiry',
            'title' => 'The enquiry form',
            'body'  => [
                'The general enquiry form asks for:',
            ],
            'list'  => [
                'Name',
                'Email address',
                'Telephone number',
                'A subject, chosen from a list',
                'A message',
            ],
            'after' => [
                'Name, email address, subject and message are required; the telephone number may be left blank.',
            ],
        ],

        [
            'type'  => 'clause',
            'id'    => 'basis',
            'title' => 'The legal basis',
            'body'  => [
                'A membership application is processed on the basis of consent: it is sent by somebody asking to be considered for membership, and sending it is the consent. It can be withdrawn at any time by writing to {email}, and withdrawing it means the application is deleted and not considered.',
                'A general enquiry is processed on the basis of legitimate interest — answering somebody who has written to ask a question. Nobody is asked to consent to being replied to.',
                'Neither form is a basis for anything else. Sending one does not put anybody on a list.',
            ],
        ],

        [
            'type'  => 'clause',
            'id'    => 'where',
            'title' => 'Where it goes',
            'body'  => [
                'A submitted form becomes an email. It is sent over an authenticated connection to a mailbox on the estate\'s own mail server and it is read by the people who run the estate.',
                'There is no CRM, no marketing platform, no mailing list, no third-party form service and no processor of any kind between the form and that mailbox. Nothing submitted here is sold, shared, published, or used to advertise anything.',
                'The sender is also sent a short confirmation from a no-reply address, which contains no copy of what they submitted.',
            ],
        ],

        [
            'type'  => 'clause',
            'id'    => 'retention',
            'title' => 'How long it is kept',
            'body'  => [
                'Applications and enquiries are kept only as long as they are needed to deal with them — to consider an application, or to answer a question and see the conversation through. After that they are deleted from the mailbox.',
                'No fixed period is quoted here, because none has been set and a number invented for a policy is a promise nobody is keeping. Anybody may ask for their message to be deleted sooner: see below.',
            ],
        ],

        [
            'type'  => 'clause',
            'id'    => 'technical',
            'title' => 'What the server itself records',
            'body'  => [
                'Two small things, and both exist to keep the forms working rather than to know anything about anybody.',
            ],
            'list'  => [
                'A counter of submissions per connection, so that one address cannot flood the mailbox. It holds a one-way hash of the IP address and the times of recent submissions, nothing else, and every entry older than an hour is deleted the next time the file is written.',
                'A log of what happened to submissions that failed — rejected as automated, refused by the counter, or not sent because the mail server was unreachable. It records the event, the time and the same one-way hash. It never records anything anybody typed.',
            ],
            'after' => [
                'Neither of them is linked to a submitted form, and neither can be turned back into an IP address.',
            ],
        ],

        [
            'type'  => 'clause',
            'id'    => 'cookies',
            'title' => 'Cookies and analytics',
            'body'  => [
                'This site sets no cookies. It has no analytics, no tracking pixel, no advertising tag, no social plug-in and no embedded video. Nothing here counts visitors or follows them anywhere.',
                'That is why there is no cookie banner. A banner asks permission to do something; there is nothing here to ask permission for, and a banner shown anyway would be a consent dialogue for consent nobody needs to give.',
                'The typefaces and every script and stylesheet the site uses are served from this server, not from anybody\'s content delivery network.',
            ],
        ],

        [
            'type'  => 'clause',
            'id'    => 'map',
            'title' => 'The map, and the one exception',
            'body'  => [
                'The {contact} shows a map. The map images come from CARTO, which means that opening the map makes a request to their servers and that request carries an IP address, as any request to any server does.',
                'It is the only thing on this site that is loaded from anywhere else, and it is not loaded until a reader scrolls down to the map. Anybody who does not is not in touch with CARTO or with anyone else through this site. The address is printed on the page as text either way, so the map can be ignored entirely.',
            ],
        ],

        [
            'type'  => 'clause',
            'id'    => 'rights',
            'title' => 'Your rights, and how to use them',
            'body'  => [
                'Under the GDPR anybody whose data is here may ask for a copy of it, ask for it to be corrected, ask for it to be deleted, ask for its use to be restricted, object to its use, or ask for it in a portable form. Consent, where it is the basis, may be withdrawn at any time.',
                'All of it is one email: write to {email} and say which of those you want. No form and no account is needed, and there is no charge. An answer comes from a person, within a month at the outside.',
                'Anybody who is not satisfied with the answer may complain to the Data State Inspectorate — Datu valsts inspekcija — which is the supervisory authority for Latvia.',
            ],
        ],
    ],

];
