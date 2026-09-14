<?php
/**
 * English content of the terms and the impressum. Arrays only, no markup.
 *
 * TWO DOCUMENTS IN ONE PAGE, and the second is the reason the first exists at
 * this stage. The terms proper are short because the site is short: it
 * publishes descriptions of an estate under restoration and it takes two kinds
 * of message. It sells nothing, holds no account, stores no payment and makes
 * no booking, so a page of e-commerce clauses would describe somebody else's
 * website.
 *
 * The impressum is the part that is legally required and the part that cannot
 * be finished: the owner has not supplied the company's legal name, its
 * registration number or its registered address (ARCHITECTURE §21, open
 * question 4).
 *
 * THOSE THREE GAPS ARE PRINTED AS GAPS. Publishing a plausible registration
 * number is a false statement about a legal entity, and publishing an
 * impressum with the entity quietly missing is the same omission with the
 * evidence removed. The TODO blocks are visible on the live page on purpose:
 * they are honest, they are one line each to remove, and they are the kind of
 * embarrassment that gets a detail supplied.
 *
 * THE GOVERNING-LAW CLAUSE IS ONE OF THOSE GAPS AND NOT AN OVERSIGHT. Which
 * law applies and which court is competent follows from the entity that
 * operates the site, and until there is an entity there is nothing to write
 * that would be true. "Latvian law" is the obvious guess, it is probably
 * right, and a guess is not what belongs in a clause somebody may one day rely
 * on.
 *
 * ───────────────────────────────────────────────────────────────────────────
 * THE PAGE WAS REDRAWN ON 10 SEPTEMBER 2026 AND NOT ONE WORD OF EITHER
 * DOCUMENT WAS.
 *
 * /terms was rebuilt as an editorial legal document inside the film's design
 * system — a clamped cinematic hero, a warm cream reading surface, a numbered
 * contents index, two chapter marks, and the four impressum gaps set as
 * notices rather than as errors. The brief for that work said it in six
 * places: "The existing TERMS content is the source of truth… DO NOT rewrite
 * legal clauses… paraphrase… shorten… Do NOT remove existing TODO
 * placeholders… Do not fabricate the company's legal identity."
 *
 * SO 'title', 'links', 'updated', 'meta' AND EVERY ONE OF THE SEVEN SECTIONS
 * BELOW ARE BYTE FOR BYTE WHAT THEY WERE, THE FOUR TODO LINES INCLUDED. The
 * whole diff against the approved file is one line changed — 'mood', from
 * 'day' to 'night', because the page now paints its own two grounds, which is
 * the same edit /privacy and CONTACT each made for the same reason — and six
 * keys added, none of which is legal text: 'own_chrome', 'nav', 'footer',
 * 'hero', 'document' and 'chapters'. Verified two ways in docs/TERMS.md §6.
 *
 * THE PLACE TO CHANGE A CLAUSE IS STILL HERE, and the page still has no idea
 * what any of them say. templates/pages/terms.php reads 'id' and 'title' to
 * number and order them, and passes everything else through.
 */

declare(strict_types=1);

return [

    'meta' => [
        'title'       => 'Terms & impressum — Majori Manor',
        'description' => 'Terms of use for majorimanor.com, and the impressum of the site.',
    ],

    /*
       The page paints its own two grounds — a dark first screen and a cream
       document — and this keeps the chrome tokens honest for anything that
       still reads mood(). It was 'day' while the whole page was cream; it is
       'night' now that the hero and the footer are not, which is the value
       every film page resolves to through home.css §2. It is the same edit
       CONTACT and /privacy each made for the same reason, and it changes no
       word of either document below.
    */
    'mood' => 'night',

    // The film's chrome — see the note at the top of this file.
    'own_chrome' => true,

    // Only the wording of the sheet that opens below 900px: the links
    // themselves come from routes.php through nav_pages(), so TERMS is still
    // absent from the bar (NAV_EXCLUDE) and still present in the footer
    // (FOOTER_LINKS), exactly as on the ten pages before it.
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
       the picture and nothing else, so the hero cannot say anything the two
       documents do not.

       It is a clamped hero and not a full screen: templates/pages/terms.php
       renders the film's hero component and terms.css §2 holds it to about
       56svh, because the brief asks for 45–65vh and asks that the reading
       begin before the hero has eaten the screen.

       THE PICTURE IS THE LIBRARY AND IT IS DECLARED AS A VISUALISATION. The
       room is HOUSE_OF_DIALOGUE/2.png, which the Main Page and THE CLUB both
       already print as a plate; 'source' => 'render' is what it is on those
       pages and it is what it is here. Nothing on this page claims it is a
       photograph of a room that stands today.
    */
    'hero' => [
        'film' => [
            'name'   => 'ter-library',
            'poster' => 'terms/ter-library',
            'ratio'  => '16/9',
            'alt'    => 'The library of the manor at evening, its fire lit, bound volumes to the ceiling on every wall and a portrait in a gilt frame above the chimneypiece',
            'source' => 'render',
        ],
    ],

    /*
       THE DOCUMENT'S FURNITURE, AND NOT ONE WORD OF IT IS A CLAUSE.

       Three interface strings: what the index is called, what a screen reader
       is told it is, and the label on the control at the foot. "Last updated"
       is not among them — it is t('legal.updated') in common.php, where
       /privacy reads it from too, and a second copy here is a second thing to
       translate.

       The numbers beside the sections are computed from 'sections' below and
       are deliberately not written here: a number typed into a content file is
       a number that goes wrong the first time a clause moves.
    */
    'document' => [
        'contents'      => 'Contents',
        'contents_aria' => 'Sections of this document',
        'top'           => 'Return to the top',
    ],

    /*
       THE TWO VISUAL BREAKS, AND NEITHER OF THEM SAYS ANYTHING.

       The brief allows a break "after approximately every 2–3 major sections"
       and names what one may be: a thin rule, a small Majori Manor seal, a
       muted deep-green chapter field. There are seven sections and there are
       two breaks. Both are keyed to the id of the clause they stand BEFORE, so
       neither can drift when a clause moves and neither is a number typed
       twice.

       THE KEY IS 'break' AND NOT 'type', WHICH LOOKS LIKE A STYLE CHOICE AND IS
       NOT ONE. component() dispatches on 'type', and the page template hands a
       chapter to it as ['type' => 'legal-break'] + the chapter — where PHP's +
       keeps the LEFT value for a duplicate key. A chapter that named its own
       shape 'type' would have that name silently eaten by the dispatch and
       every break on the page would draw as the default. It did, once.

       'seal'    a hairline with the estate's crest standing on it. It is an
                 ornament, it is aria-hidden, and it carries no text at all.

       'field'   the green chapter mark, and it is the one break on this page
                 that means something. THIS FILE HAS SAID SINCE IT WAS WRITTEN
                 THAT IT HOLDS TWO DOCUMENTS — see the head of it — and until
                 now a reader had no way to see the seam. The label is a
                 numeral and one word, and the word is the second half of the
                 approved h1 below: 'Terms & impressum'. Nothing is invented,
                 nothing is summarised, and no clause is introduced, retitled
                 or explained by it.
    */
    'chapters' => [
        'property'  => ['break' => 'seal'],
        'impressum' => ['break' => 'field', 'numeral' => 'II', 'label' => 'Impressum'],
    ],

    'updated' => '2026-08-12',

    'links' => [
        'email'      => ['email' => 'info@majorimanor.com'],
        'privacy'    => ['page_id' => 'privacy',    'label' => 'privacy policy'],
        'membership' => ['page_id' => 'membership', 'label' => 'membership page'],
        'contact'    => ['page_id' => 'contact',    'label' => 'contact page'],
    ],

    'title' => [
        'eyebrow' => 'Legal',
        'title'   => 'Terms & impressum',
        'lede'    => 'What this site is, what it is not, and who publishes it.',
    ],

    'sections' => [

        [
            'type'  => 'clause',
            'id'    => 'site',
            'title' => 'What this site is',
            'body'  => [
                'majorimanor.com describes Majori Manor — a historic estate in Jūrmala, its park, and the club being built around them. The estate is under restoration and nothing described here is open to the public.',
                'The site sells nothing. There is no shop, no basket, no account, no payment and no booking on it. Nothing published here is an offer, and nothing on it can be accepted so as to form a contract.',
            ],
        ],

        [
            'type'  => 'clause',
            'id'    => 'accuracy',
            'title' => 'Accuracy, and what is still being decided',
            'body'  => [
                'What is published here is stated as accurately as it can be at this stage of a restoration. Descriptions, measurements and plans may change as the work goes on, and pages are corrected when they do.',
                'Anything not stated on the site is not settled. In particular the site quotes no price, no fee, no opening date and no availability, and none should be inferred from anything on it.',
            ],
        ],

        /*
           THE 'Photographs and visualisations' CLAUSE WAS REMOVED HERE, AND IT
           IS THE ONE REMOVAL IN THIS PASS THAT WAS NOT OPTIONAL.

           It promised, in the site's own terms, that every image says which of
           three things it is and that a visualisation is captioned as one
           wherever it appears. The captions it promised have been taken off
           every page on the owner's instruction — see mark_for() in
           app/helpers.php. A term that undertakes to label, standing over pages
           that no longer label, is not a stale sentence; it is the site
           promising something it does not do, in the document where that costs
           the most. It goes with them or it becomes false.

           IT WAS NOT REWRITTEN INTO A WEAKER VERSION. There is a true clause
           that could be written about images without using the word — the
           reference-image rule it also carried is still enforced, by the
           'mood' branch of templates/components/figure.php, which refuses a
           factual caption on an atmosphere image. Writing that alone would
           leave a clause headed with what is no longer done and quietly
           narrowed to what still is, which reads as an attempt to keep the
           credit for a promise that was withdrawn. If a new image clause is
           wanted it should be written deliberately and approved as new text,
           not left behind as the residue of this one. Nothing links to
           #images, so no anchor breaks.

           Nothing else in this file mentioned the labels.
        */

        [
            'type'  => 'clause',
            'id'    => 'forms',
            'title' => 'The two forms',
            'body'  => [
                'The membership application on the {membership} is a request to be considered. Sending it creates no membership, no obligation on either side, and no entitlement to a place; applications are reviewed individually and an application may be declined without a reason being given.',
                'The enquiry form on the {contact} is a way to write to the estate. Sending it starts a conversation and nothing more.',
                'Both forms ask for personal data, and what happens to it is set out in the {privacy}. Please do not send confidential information, documents or anything of value through either of them.',
            ],
        ],

        [
            'type'  => 'clause',
            'id'    => 'property',
            'title' => 'Text, photographs and marks',
            'body'  => [
                'The text, the photographs, the drawings, the crest and the wordmark on this site belong to the estate or to the people who made them for it. Quoting a sentence with a link back is fine and welcome; republishing the photography, the crest or the wordmark is not, and needs permission first — ask at {email}.',
            ],
        ],

        [
            'type'  => 'clause',
            'id'    => 'availability',
            'title' => 'Availability',
            'body'  => [
                'The site is published as it is. It may be unavailable while it is being worked on or when the hosting is not, and no undertaking is given that it will be reachable at any particular moment.',
                'Nothing here is professional advice of any kind.',
            ],
        ],

        [
            'type'  => 'clause',
            'id'    => 'changes',
            'title' => 'Changes to these terms',
            'body'  => [
                'These terms may be amended as the estate and the site develop. The date at the foot of this page is the date of the version being read, and it moves only when the text does.',
            ],
        ],

        // -------------------------------------------------------------------
        // The impressum
        // -------------------------------------------------------------------

        [
            'type'  => 'clause',
            'id'    => 'impressum',
            'title' => 'Impressum',
            'body'  => [
                'The site is published for Majori Manor, Konkordijas iela 66, Jūrmala, LV-2015, Latvia. Correspondence, including anything to do with these terms or with the {privacy}, goes to {email}.',
                'There is no published telephone number.',
            ],
            'todo'  => [
                'The legal name of the company operating the site — to be supplied by the owner.',
                'The registration number of that company — to be supplied by the owner.',
                'Its registered address, where that is not the address above — to be supplied by the owner.',
                'The governing law and the competent court, which follow from the entity above and cannot be written until it is known.',
            ],
        ],
    ],

];
