<?php
/**
 * English interface strings — everything that is not page content.
 * Reached from templates through t('nav.estate'), t('footer.copyright'), …
 *
 * Arrays only, no markup. Labels are stored in natural case; the uppercase
 * look of the navigation is presentation and belongs to CSS (text-transform),
 * which also keeps Latvian diacritics intact when they arrive.
 */

declare(strict_types=1);

return [

    'site' => [
        'name' => 'Majori Manor',

        /*
           The bilingual lockup, for the one place the estate signs its own
           name in full: the foot of a letter. Stored in natural case like
           every other label on this site — the uppercase look is
           text-transform in the mail template and mb_strtoupper() in the
           plain-text part, and both of those keep the ž of Muiža intact
           where a hand-typed MUIŽA in a content file would eventually not.
        */
        'name_lockup' => 'Majori Manor / Majori Muiža',
    ],

    'a11y' => [
        'skip_to_content' => 'Skip to content',

        // Read out only where the seal stands alone — seal(…, decorative: false).
        // Everywhere else the mark sits beside the wordmark in text and is
        // hidden from readers instead of repeating it.
        'crest' => 'The Majori Manor crest',
    ],

    // One label per page id in routes.php, plus the navigation's own labels.
    'nav' => [
        'aria_label' => 'Main',

        // The mobile drawer. The button keeps one name in both states —
        // aria-expanded carries open and closed, so the label does not have to.
        'menu'         => 'Menu',
        'menu_close'   => 'Close menu',
        'drawer_label' => 'Site',

        'home'       => 'Home',
        'estate'     => 'The Estate',
        'club'       => 'The Club',
        'padel'      => 'Padel',
        'events'     => 'Events',
        'residences' => 'Residences',
        'after_dark' => 'After Dark',
        'membership' => 'Membership',
        'contact'    => 'Contact',
        'privacy'    => 'Privacy',
        'terms'      => 'Terms',
        'styleguide' => 'Styleguide',   // development only
        'components' => 'Components',   // development only
    ],

    /*
       IMAGE HONESTY (ARCHITECTURE §11).

       NEITHER OF THESE IS PRINTED ANYWHERE TODAY. On the owner's instruction
       the picture labels were taken off every page: mark_for() in
       app/helpers.php returns the empty string for every source and the two
       lines that read these keys are commented out there. Nothing reaches t()
       for 'media.*' any more.

       THEY ARE KEPT, AND KEPT HERE, ON PURPOSE. mark_for() is written as a
       switch — uncommenting its two lines restores the labels across the whole
       site in one edit — and a switch whose strings have been deleted is not a
       switch. Keeping them also keeps the wording a decision that was made
       once, in English, in the place translations live, rather than something
       to be re-invented under pressure the day the labels are wanted back.

       WHAT THEY MEANT, WHILE THEY WERE PRINTED. 'visualisation' was appended to
       the caption of every figure whose content declares source: 'render', by
       templates/components/figure.php and not by the person writing the content
       file: a visualisation that reaches the page labelled as a photograph is a
       guest arriving into a room that does not exist, so the label was not
       something a content file could forget. 'generated' carried the same
       obligation for a synthesised image, and took a separate word because it
       is a separate claim — see IMG_SOURCES in app/helpers.php.
    */
    'media' => [
        'visualisation' => 'Visualisation',
        'generated'     => 'Generated image',
    ],

    /*
       The lightbox. Every string it says is here rather than in main.js: the
       script is served as written and has no way to reach t(), so the gallery
       prints these onto the element as data- attributes and the script reads
       them from there. It never contains a word of English.

       'counter' takes {n} and {total}.
    */
    'lightbox' => [
        'label'    => 'Gallery',
        'close'    => 'Close',
        'previous' => 'Previous image',
        'next'     => 'Next image',
        'counter'  => '{n} of {total}',
    ],

    /*
       The footer is deliberately short — seal, wordmark, two eyebrows, one row
       of links, one address. Anything else added here has to earn its line.

       'tagline' and 'members' are stored in natural case like every other
       label: .u-eyebrow uppercases them, and an uppercased string in content
       would lose its diacritics the day Latvian arrives.
    */
    'footer' => [
        'tagline'           => 'Private estate & members\' club',
        'location'          => 'Jūrmala · Latvia',
        'email'             => 'info@majorimanor.com',
        'members'           => 'Members & guests',
        'links_aria_label'  => 'Footer',
        'social_aria_label' => 'Social',

        // Not printed today: the footer holds the brief's seven lines and no
        // more. Kept because the year is not the hard part of putting it back.
        'copyright' => '© %s Majori Manor',
    ],

    /*
       FORMS. Labels, hints, errors and the thank-you (ARCHITECTURE §12).

       All of it is here rather than in the component for the usual reason —
       templates hold no human-readable strings — and for one specific to
       forms: an error message is read at the worst moment somebody has on a
       page, and the wording of it is a content decision, not a detail of the
       validator that noticed.

       THE REGISTER IS THE SITE'S. No exclamation marks, nothing apologetic,
       nothing that scolds. "Some of these answers need checking" is the same
       voice as the rest of the estate; "Oops! Something went wrong!" is not.
    */
    'form' => [

        // Marks the required fields, and the note that explains the mark.
        // The mark itself is decorative — the <input> carries `required`, so a
        // screen reader is told by the markup and not by an asterisk.
        'required_mark' => '*',
        'required_note' => 'Fields marked * are required.',

        'errors' => [
            /*
               The heading of the summary at the top of the form. It is a
               statement of where things stand, not a telling-off, and it never
               names a number: "3 errors" is a score.
            */
            'summary'  => 'Some of these answers need checking.',

            'required' => 'This answer is required.',
            'email'    => 'Enter an email address in the form name@example.com.',
            'max'      => 'This answer is longer than {max} characters.',
            'choice'   => 'Choose one of the options.',

            /*
               The time-trap and the token, and neither says what it caught.

               A message that explains the rule — "forms sent in under three
               seconds are rejected" — is a message that tells whoever is
               probing the form exactly what to change. Both are therefore the
               same kind of sentence: something did not go through, send it
               again. A person reads that and sends it again, which works,
               because the form comes back with a fresh token and everything
               they typed still in it.
            */
            'token'    => 'This form has been open a while and could not be sent. Please send it again.',
            'too_fast' => 'This could not be sent. Please take a moment and send it again.',

            /*
               THE RATE-LIMIT MESSAGE IS NOT IN THIS BLOCK. It is the one error
               on the site that names what was sent, so it is the one that
               cannot be one string for two forms: this block is shared, and a
               membership applicant who hits the limit was told "Several
               enquiries have already been sent" on the page that calls
               everything else an application.

               It lives under each form as 'errors.rate' — see 'membership'
               below and 'enquiry' below that. handler.php reads
               t('form.<type>.errors.rate'), which is the same
               one-key-per-form-per-string rule partials/form.php already
               follows, so nothing branches on the form type in PHP.
            */
        ],

        'membership' => [

            // The form's own accessible name, for the rare case where the
            // content file gives the section no heading of its own. It is
            // announced — "Membership application, form" — so it counts as
            // user-visible and says "application" like everything else here.
            'aria_label' => 'Membership application',

            /*
               THE RATE-LIMIT MESSAGE, THIS FORM'S OWN — see the note in
               'errors' above for why it is not shared.

               IT SAYS "messages" AND NOT "applications", WHICH IS THE ACCURATE
               WORD AND NOT THE TIDY ONE. rate_limit_hit() counts posts from a
               connection, not posts to a form, so somebody who has just sent
               five enquiries from the contact page and then opens this one is
               refused here — and telling them several applications have
               already been sent would be a false statement about what they
               did. "Messages" is true whichever form spent the allowance.
            */
            'errors' => [
                'rate' => 'Several messages have already been sent from this connection. Please try again later.',
            ],

            'fields' => [
                'name'          => ['label' => 'Name'],
                'surname'       => ['label' => 'Surname'],
                'country'       => ['label' => 'Country'],
                'city'          => ['label' => 'City'],
                'occupation'    => ['label' => 'Occupation / Company'],
                'email'         => ['label' => 'Email'],
                'phone'         => ['label' => 'Phone'],
                'heard'         => ['label' => 'How did you hear about Majori Manor?'],

                'referred' => [
                    'label'   => 'Were you referred by a member?',
                    'options' => [
                        'yes' => 'Yes',
                        'no'  => 'No',
                    ],
                ],

                'referral_name' => ['label' => 'The member\'s name'],

                'reason' => [
                    'label' => 'Why would you like to join Majori Manor?',

                    // Printed under the field and tied to it with
                    // aria-describedby, so the cap is known before it is hit
                    // rather than reported afterwards as an error. {max} is
                    // filled from the schema in validate.php — one number, one
                    // place, and the hint cannot drift from the rule.
                    'hint'  => 'Up to {max} characters.',
                ],
            ],

            /*
               THE PRIVACY NOTICE, AND IT SITS ON THE FORM RATHER THAN IN THE
               FOOTER (ARCHITECTURE §12.3).

               This form collects an occupation and free text somebody has
               written about themselves. That is personal data, the GDPR
               applies, and consent has to be informed at the moment it is
               given — which means one sentence where the person is looking,
               directly above the button, and not a link three screens down.

               {link} is replaced with an anchor to /privacy, built from
               routes.php like every other address on this site.
            */
            'privacy' => [
                'text' => 'The details you give here, including your occupation and anything you write about yourself, are used only to consider your application — see our {link}.',
                'link' => 'privacy policy',
            ],

            /*
               THE BUTTON NAMES THE ACT, AND IT NAMES IT THE WAY THE REST OF
               THE PAGE DOES. It said "Submit membership enquiry" while the
               heading above it said "The application" and the thank-you under
               it said "Membership applications are reviewed individually".

               "membership" STAYS IN IT rather than shrinking to "Submit
               application": a button is read out of context by a screen reader
               working through a list of controls, and on a page with a second
               form on it one day, "Submit application" is a button that could
               belong to either.
            */
            'submit' => 'Submit membership application',

            /*
               THE THANK-YOU, AND THE WORDING IS PART OF THE CONCEPT.

               ARCHITECTURE §12.2 fixes these two lines and they are not to be
               edited: no timeline, no "we will be in touch", no next step.
               Applications are reviewed individually, and that is the whole of
               what the estate is willing to say at this point — which is the
               selection concept in one sentence.
            */
            'success' => [
                'title' => 'Thank you.',
                'body'  => 'Membership applications are reviewed individually.',
            ],
        ],

        /*
           THE GENERAL ENQUIRY FORM. Five fields, one of which decides how the
           inbox files it (ARCHITECTURE §12.1).

           The block has the same shape as the membership one above, because
           both are read by one renderer through one schema — see
           templates/partials/form.php. A field named in validate.php looks for
           its label here and nowhere else.
        */
        'enquiry' => [

            'aria_label' => 'Enquiry',

            /*
               THE RATE-LIMIT MESSAGE, WORD FOR WORD WHAT THE SHARED STRING
               SAID BEFORE IT WAS SPLIT. This form's wording was not the problem
               and has not been touched — an enquiry is an enquiry. It is here
               rather than in 'errors' only because its opposite number under
               'membership' had to be, and a key that exists for one form and
               falls back for the other is the arrangement that goes wrong
               silently.
            */
            'errors' => [
                'rate' => 'Several enquiries have already been sent from this connection. Please try again later.',
            ],

            'fields' => [
                'name'  => ['label' => 'Name'],
                'email' => ['label' => 'Email'],
                'phone' => ['label' => 'Phone'],

                /*
                   The five subjects, in the brief's order. 'General' is first
                   because it is where the field rests when nobody has chosen
                   and when no link has preselected anything — see the note on
                   the schema in validate.php.

                   These are the words that end up in the notification's
                   subject line: "Enquiry — Private event — …". Keep them
                   short, in title case, and readable at a glance in a list of
                   forty unopened messages.
                */
                'subject' => [
                    'label'   => 'Subject',
                    'options' => [
                        'general'       => 'General',
                        'private-event' => 'Private event',
                        'padel'         => 'Padel',
                        'residences'    => 'Residences',
                        'press'         => 'Press',
                    ],
                ],

                'message' => [
                    'label' => 'Message',
                    'hint'  => 'Up to {max} characters.',
                ],
            ],

            /*
               ITS OWN PRIVACY SENTENCE, AND NOT THE MEMBERSHIP FORM'S.

               That one names an occupation and free text somebody has written
               about themselves, because that is what it asks for. This form
               asks for a way to answer and a question, and says so. A notice
               that overstates what is collected is as inaccurate as one that
               understates it, and the privacy page has to be able to stand
               behind both sentences (ARCHITECTURE §12.3).
            */
            'privacy' => [
                'text' => 'Your name, your contact details and your message are used only to answer this enquiry — see our {link}.',
                'link' => 'privacy policy',
            ],

            'submit' => 'Send enquiry',

            /*
               THE THANK-YOU, AND IT IS NOT THE MEMBERSHIP ONE.

               An enquiry gets an answer, so this says so. An application gets
               read, so that one says only that. Two sentences, both true, and
               neither borrowing the other's promise — no timeline, because
               nobody has agreed to one.
            */
            'success' => [
                'title' => 'Thank you.',
                'body'  => 'We will be in touch.',
            ],
        ],
    ],

    /*
       MAIL. The two messages a form submission produces (ARCHITECTURE §12.4),
       built in app/forms/mail/.

       They are strings on this site like any other, so the day Latvian arrives
       the mails are translated with the pages and no PHP is touched.

       THE FIRST GROUP OF KEYS IS SHARED BY BOTH LETTERS and is read through
       app/forms/mail/letter.php, the spine the two autoreplies are built on. A
       greeting, a timestamp and the words on a link are the same sentence
       whichever form was filled in, and one copy per form is two strings that
       drift — the enquiry mail saying "Latvian time" while the membership mail
       says "Riga time" is the failure this prevents, and it is the kind nobody
       notices until both are quoted side by side.

       WHAT STAYS PER FORM IS WHAT GENUINELY DIFFERS: the subject line, the
       preheader, what the letter confirms, the paragraph it carries, and what
       it says to somebody who did not send it. An enquiry is answered; an
       application is read. Those are not the same sentence and are not shared.

       'notify_subject' takes {name}.
    */
    'mail' => [

        /*
           THE GREETING, FOR BOTH LETTERS. {name} is what the sender typed,
           escaped by the template — these are public forms and the field
           accepts anything a keyboard can produce.

           'hello' IS NOT A POLITE EXTRA. The name field is required on both
           forms, so an empty one should not arrive; if one ever does, this is
           what stands between the estate and a letter that opens "Dear ,". A
           neutral opening is a letter; a dangling comma is a broken mail merge.
        */
        'salutation' => 'Dear {name},',
        'hello'      => 'Hello,',

        /*
           THE RECEIPT'S TIMESTAMP, AND THE TIME IS THE MANOR'S OWN, NAMED.

           date() on shared hosting reports whatever zone the host was built
           with — UTC on one box, America/Chicago on another — so both letters
           fix it to Europe/Riga rather than inheriting one; see
           mail_letter_received() in app/forms/mail/letter.php. The zone is
           spelled out in words because "15:42 EEST" is an abbreviation a reader
           in London has no reason to know.

           The format is a letter's and not a log's: "13 August 2026 at 15:42".
           The notification to info@ keeps the machine-readable form, which is
           where it belongs.
        */
        'received_label'  => 'Received',
        'received_format' => 'j F Y \a\t H:i',
        'received_zone'   => 'Latvian time',

        /*
           THE PARAGRAPH THE ENQUIRY LETTER CARRIES, AND IT IS NOT NEW COPY.
           Word for word the lede of the hero on content/en/estate.php — the
           page that carries the estate's approved facts (ARCHITECTURE §11). It
           states an approximate year and work in progress, and it states
           nothing about opening, prices, membership or facilities, which is the
           whole reason it and not a fresh sentence written for an email is the
           paragraph that travels.

           IT SITS HERE, IN THE SHARED BLOCK, RATHER THAN UNDER 'enquiry', AND
           THAT IS DELIBERATE. It stopped being the membership letter's
           paragraph when that letter took the /membership opening instead — see
           'membership.autoreply_about' below — but it is the estate's one approved
           paragraph about the house and the next letter that needs one should
           find it here rather than write a second. What is per-letter is which
           paragraph a letter carries, not where the approved paragraphs live.

           An email is the easiest place on this project to write a sentence
           nobody approved and the hardest to take back — it is not a page that
           can be edited afterwards. One key means one place to change it, and
           it is changed on /estate first and here second.
        */
        'about' => 'A house of about 1910 at the centre of its own park in Jūrmala, and the work of bringing it back is under way.',

        /*
           The visible half of a link to /privacy. The address itself is built
           from routes.php by the letter and is never written in a content file.
        */
        'privacy_link' => 'privacy policy',

        /*
           THE MEMBERSHIP PAIR, AND THE WORD IS "APPLICATION" IN EVERY ONE OF
           THEM.

           The page calls it an application, the thank-you calls it an
           application, ARCHITECTURE §12.2 calls it an application, and until
           this pass the schema, the button and both subject lines called it an
           enquiry — so an applicant filled in an application, was thanked for
           an application, and then received two mails about their enquiry. One
           word, everywhere it is visible.

           THE CONTACT FORM KEEPS "ENQUIRY" AND THAT IS NOT AN OVERSIGHT. An
           enquiry is a question somebody asks; an application is a request to
           be admitted. They are different acts and the site names them
           differently — see the 'enquiry' block below, which was not touched.
        */
        'membership' => [
            'notify_subject'  => 'Membership application — {name}',
            'notify_heading'  => 'Membership application',
            'notify_received' => 'Received',

            'autoreply_subject' => 'Majori Manor — membership application',

            /*
               THE PREHEADER. The line a client prints in the message list
               beside the subject, and hidden everywhere else. It says the
               application arrived, so the list entry is a receipt before
               anybody opens it.

               HELD BETWEEN 40 AND 90 CHARACTERS, the window the enquiry
               preheaders are held to and for the same reasons: under forty a
               client pads the line out with the first words of the letter, and
               past ninety it is cut mid-word in the narrow list panes.
               tools/mail_preview.php asserts it.
            */
            'autoreply_preheader' => 'Your application has reached Majori Manor in Jūrmala',

            /*
               THE CONFIRMATION, IN TWO LINES, AND NEITHER IS A PROMISE.

               The first is the receipt: it arrived, and it arrived here. The
               second is the sentence ARCHITECTURE §12.2 fixes and forbids
               editing, printed word for word as the page prints it — an
               applicant who reads the screen and then the email is told one
               thing, once, in the same words, and a mail that elaborates on
               the page has started making promises the page did not.

               WHAT IS NOT SAID, AND EVERY ONE OF THESE WAS CONSIDERED: no
               number of days and no "shortly" — no time is quoted against an
               application anywhere on this site, and an email is kept and
               quoted back; nothing about the outcome, because "we look forward
               to welcoming you" is an acceptance the estate has not decided;
               and no next step, because there is none — /membership says
               plainly that there is nothing further to send.
            */
            /*
               THE LINE OF THANKS, AND IT IS THE FIRST THING UNDER THE
               GREETING.

               A letter that opens with a receipt and no thanks is a machine
               answering; one line of thanks is what a person writing back
               would put there, and it costs the letter nothing it is trying to
               protect.

               WHAT IT IS NOT ALLOWED TO BE. No exclamation mark. No "we
               appreciate", which is the register of a support desk. Nothing
               about how glad the estate is, because "delighted" and "we look
               forward" are the two phrases that turn a receipt into an
               acceptance and both are on the blocklist in
               tools/mail_preview.php. It thanks somebody for an act they have
               completed and says nothing about what follows from it — which is
               the whole of what the estate can honestly say at this moment.
            */
            'autoreply_thanks' => 'Thank you for your application.',

            'autoreply_confirm'  => 'Your application has reached the manor.',
            'autoreply_reviewed' => 'Membership applications are reviewed individually.',

            /*
               THE PARAGRAPH THIS LETTER CARRIES, AND IT IS THE MEMBERSHIP
               PAGE'S OWN OPENING PARAGRAPH, WORD FOR WORD.

               It is the first paragraph of the "One membership" section on
               content/en/membership.php — the page the applicant has just read
               and just filled in the bottom of. It replaced 'about' above, the
               /estate lede, which was the right paragraph for the enquiry
               letter and the wrong one here: somebody who has just applied to
               join has been told about the house already, and telling them
               again is the letter changing the subject.

               THE SAME RULE APPLIES TO IT AS TO 'about'. It is approved copy on
               a page, it is copied here and not written here, and if it is ever
               changed it is changed on /membership first and here second.

               IT IS BELOW THE RECEIPT AND BELOW "reviewed individually", AND
               THE ORDER IS THE POINT. Read after those two lines it is what
               the applicant has applied to; read before them — or on its own —
               "There is one membership. It covers the estate." is a sentence
               about what this applicant is getting. Nothing in this letter is
               allowed to say that. autoreply_membership.php fixes the order and
               says so.

               It states no price, no tier, no benefit and no timeline, which is
               why this paragraph and not one of the later ones on that page.
            */
            'autoreply_about' => 'Majori Manor is private, and membership is the arrangement by which it is used. There is one membership. It covers the estate.',

            /*
               THE PRIVACY LINE, AND IT IS ON THIS LETTER AND NOT THE OTHER ONE.

               This form asks for an occupation and for free text somebody has
               written about themselves; the enquiry form asks for a way to
               answer and a question. The form itself carries the full notice
               above its button (ARCHITECTURE §12.3) — this is one line and a
               link, so that the copy the applicant keeps also holds the address
               of the page that explains what happens to what they sent. It is a
               pointer, not a second notice: no basis, no retention period, no
               legal prose. {link} becomes the anchor.
            */
            'autoreply_privacy' => 'How these details are used is set out in our {link}.',

            /*
               The last line. Somebody's address can be typed into a public form
               by somebody else, and the person who receives this ought to be
               told plainly that they need do nothing about it — which matters
               more here than on an enquiry, because what was sent in their name
               is an application to join.
            */
            'autoreply_disregard' => 'If you did not send this application, you can disregard this message.',
        ],

        /*
           The general enquiry's pair.

           'notify_subject' takes {subject} and {name}, and the order of them
           is the whole reason the subject field exists: the chosen line comes
           before the sender's name, so a mailbox sorted by subject groups the
           weddings together and the padel enquiries together
           (app/forms/mail/notify_enquiry.php).

           {subject} is filled with the reader's own words from the options
           above, never with the stored value — "Enquiry — private-event —" is
           a slug that escaped.
        */
        'enquiry' => [
            'notify_subject'  => 'Enquiry — {subject} — {name}',
            'notify_heading'  => 'Enquiry',
            'notify_received' => 'Received',

            'autoreply_subject' => 'Majori Manor — enquiry',

            /*
               THE PREHEADER. The line a client prints in the message list
               beside the subject, and hidden everywhere else. It confirms
               receipt and names the chosen subject, so the list entry says
               what the mail is before anybody opens it.

               HELD BETWEEN 40 AND 90 CHARACTERS AFTER {subject} IS FILLED,
               which is the window every option below lands in. Under forty a
               client pads the line out with the first words of the letter,
               which is how a preheader ends up reading "…Dear Anna, Your
               enquiry has"; past ninety it is cut mid-word in the narrow
               list panes. tools/mail_preview.php asserts the range for all
               five subjects, so a sixth option cannot quietly break it.

               'autoreply_preheader_plain' is the fallback for a submission
               with no subject, which validation does not allow and this file
               does not rely on.
            */
            'autoreply_preheader'       => 'Your enquiry has reached Majori Manor — {subject}',
            'autoreply_preheader_plain' => 'Your enquiry has reached Majori Manor in Jūrmala',

            /*
               THE CONFIRMATION, AND IT PROMISES ONLY WHAT THE ESTATE
               CONTROLS. Somebody will read it and answer it — no number of
               hours, no number of days, no "shortly" and no "as soon as
               possible". An email is kept and quoted back, and a timeline
               nobody in the house has agreed to is the one line in this mail
               that could later be wrong.
            */
            /*
               THE LINE OF THANKS, THE MEMBERSHIP LETTER'S OPPOSITE NUMBER, AND
               IT IS NOT THE SAME SENTENCE.

               "Thank you for your enquiry." would put the word twice in two
               consecutive lines — the thanks and then "Your enquiry has reached
               the manor" — which is how a template reads rather than a letter.
               So this one thanks somebody for the act instead of naming the
               object, and the line under it does the naming.

               THE SAME RESTRICTIONS AS THE OTHER ONE: no exclamation mark, no
               "we appreciate", and nothing about when or whether. The line
               below it already makes the only promise this letter makes.
            */
            'autoreply_thanks' => 'Thank you for writing to us.',

            'autoreply_confirm' => 'Your enquiry has reached the manor. Someone will read it and reply to you personally.',

            /*
               The receipt block's first label; the second is the shared
               'received_label' above. What the sender chose and when it
               arrived — not a copy of their message, which they wrote and
               already have, and which is up to two thousand characters of
               their own words quoted back at them for no reason.
            */
            'autoreply_subject_label' => 'Subject',

            /*
               The last line. Somebody's address can be typed into a public
               form by somebody else, and the person who receives this ought
               to be told plainly that they need do nothing about it.
            */
            'autoreply_disregard' => 'If you did not send this enquiry, you can disregard this message.',
        ],
    ],

    /*
       The two legal documents (ARCHITECTURE §14.1). Both are built from
       clauses in content/en/privacy.php and content/en/terms.php; these are
       the two words the template itself has to say.

       'todo' IS PRINTED ON THE LIVE PAGES AND THAT IS THE POINT. The owner has
       not supplied the company's legal name, its registration number or its
       registered address, and an impressum with a plausible number in it is a
       false statement about a legal entity. The gap is shown instead — see
       templates/components/clause.php.
    */
    'legal' => [
        // The word itself, and not a polite substitute. "To be supplied" reads
        // as a decision; TODO reads as unfinished work, which is what it is.
        'todo'    => 'TODO',
        'updated' => 'Last updated',
    ],

    // Used for pages whose own content file has no meta block yet.
    'meta' => [
        'default_title'       => 'Majori Manor — a private estate in Jūrmala',
        'default_description' => 'A historic manor house and private park in Jūrmala, Latvia, under restoration.',
    ],

];
