<?php
/**
 * The form, drawn from its schema.
 *
 * Defines form_render() and renders nothing on its own. The two form
 * components are what a content file asks for, and each is four lines over
 * this:
 *
 *     require_once TEMPLATES_PATH . '/partials/form.php';
 *     form_render('membership', $s);
 *
 * ONE RENDERER, TWO FORMS, AND THAT IS THE POINT OF THE SCHEMA.
 *
 * This file was the body of components/form-membership.php until the enquiry
 * form arrived. Copying four hundred lines to change three of them would have
 * produced two forms that agree today and drift by the second edit: a honeypot
 * fixed in one, an aria-describedby fixed in the other, and an accessibility
 * pass that has to be done twice and will not be. Everything below reads the
 * field list from form_fields() and its words from t(), so the difference
 * between the two forms is entirely the difference between their schemas and
 * their strings — which is where it belongs (see validate.php).
 *
 * IT WORKS WITH JAVASCRIPT SWITCHED OFF, AND THAT IS THE FIRST REQUIREMENT
 * RATHER THAN A FALLBACK. An ordinary POST to this page's own address, an
 * answer rendered by the server at that address, errors printed against the
 * fields with every value the sender typed still in them, and the thank-you
 * put in place of the form. main.js adds inline validation and collapses the
 * conditional field; it is not required for a single one of those things, and
 * nothing below is drawn by script.
 *
 * THE SUCCESS STATE REPLACES THE FORM IN PLACE. No redirect (ARCHITECTURE
 * §12.2) — the sender stays where they are and the form is simply not there
 * any more, with the thank-you standing in the space it occupied.
 *
 * THE ONE COST OF NOT REDIRECTING is that a reload re-posts, and the browser
 * asks before it does. Post/Redirect/Get would remove the question, and it
 * would also mean either a query string on the address — /membership?sent=1,
 * which is a state anybody can link to and a URL that outlives the thing it
 * describes — or a session cookie set on a page that currently sets none. The
 * brief chooses the replacement in place, and a re-post is caught by the
 * time-trap's token and the rate limiter rather than by a fresh application.
 *
 * ACCESSIBILITY IS NOT A LAYER OVER THIS FORM, IT IS HOW IT IS BUILT:
 *
 *   - a real <label>, with `for`, on every single control. No placeholders
 *     doing a label's job: a placeholder disappears exactly when somebody
 *     starts typing and needs it, and it is not an accessible name
 *   - required is in the markup — the `required` attribute, which a screen
 *     reader announces — and the asterisk is decoration on top of it
 *   - an error is tied to its field with aria-describedby and the field is
 *     marked aria-invalid, so the message is read out as part of the control
 *     rather than being a red sentence somebody has to go looking for
 *   - a summary at the top that takes focus, listing every problem as a link
 *     straight to the field it belongs to
 *   - the conditional field is managed with aria-expanded on the control that
 *     reveals it and the `hidden` attribute on the field, not by moving it
 *     off-screen in CSS. hidden takes it out of the accessibility tree and out
 *     of the tab order together, which display:none-by-class does for sighted
 *     keyboard users only if somebody remembers both
 */

declare(strict_types=1);

/*
   The schema, the token and the field list all come from the form layer, so
   the page and the handler cannot disagree about what a form is. require_once
   because index.php has already loaded it on a POST.
*/
require_once APP_PATH . '/forms/handler.php';

/**
 * Print one form.
 *
 * @param string $formType 'membership' | 'enquiry' — the key into form_fields()
 *                         and into the 'form.<type>' strings in common.php
 * @param array  $s        the content section:
 *                           eyebrow  optional tracked line above the heading
 *                           title    optional h2 — also the form's accessible
 *                                    name when present
 *                           body     optional string[] — a paragraph each
 *                           id       anchor for the section
 *                           index    optional scene number, for a film page
 *                                    that counts its scenes — /contact is the
 *                                    only one that does
 *                           mood     day | dusk | night
 * @param array  $opts     defaults  field => value, the answer a field starts
 *                                   on when nothing has been submitted. Only
 *                                   ever an option the schema knows; see
 *                                   components/form-enquiry.php
 */
function form_render(string $formType, array $s, array $opts = []): void
{
    $eyebrow = (string) ($s['eyebrow'] ?? '');
    $title   = (string) ($s['title'] ?? '');
    $body    = (array)  ($s['body'] ?? []);
    $anchor  = (string) ($s['id'] ?? '');
    $index   = (string) ($s['index'] ?? '');

    $mood = in_array($s['mood'] ?? null, MOODS, true) ? $s['mood'] : null;

    $state  = form_state($formType);
    $fields = form_fields($formType);

    $defaults = (array) ($opts['defaults'] ?? []);

    /** Ids are prefixed so two forms on one page never collide. */
    $idFor = static fn (string $name): string => $formType . '-' . $name;

    /** Every string this form says lives under one key in common.php. */
    $key = static fn (string $path): string => 'form.' . $formType . '.' . $path;

    /*
       The heading names the form. A form with an accessible name is announced
       as "Membership enquiry, form" when a screen reader enters it, which is
       the difference between knowing where you are and hearing "form". The
       heading is used when the content file gives one and a label from
       common.php stands in when it does not.
    */
    $titleId = $title !== '' ? $formType . '-form-title' : '';

    /*
       ROWS, NOT A GRID.

       'pair' in the schema means "sit beside the field before you where there
       is room" — Name/Surname, Country/City, Email/Phone, which is the brief's
       own pairing. Working the rows out here rather than in CSS keeps the
       markup one wrapper per row, so a row is a row on a phone too, where it
       is simply two fields stacked.
    */
    $rows = [];

    foreach ($fields as $name => $spec) {
        if (!empty($spec['pair']) && $rows !== []) {
            $rows[array_key_last($rows)][$name] = $spec;
        } else {
            $rows[] = [$name => $spec];
        }
    }
    ?>
<section class="section c-form<?= $mood ? ' section--' . e($mood) : '' ?>"<?= $anchor !== '' ? ' id="' . e($anchor) . '"' : '' ?>>
    <div class="wrap">
        <div class="c-form__column">

<?php if ($state['submitted'] && $state['ok']): ?>

            <?php /*
                THE FORM IS GONE. Not hidden, not disabled, not scrolled past —
                the markup below is the whole of what is rendered in its place,
                because the server rendered this branch instead of the form.
                That is what makes the replacement work without a line of
                script.

                role="status" rather than role="alert": this is the expected
                outcome of something the reader just did, and alert is for
                interrupting. tabindex="-1" and autofocus put the reader on it,
                so the announcement happens whether the reader is on a screen
                reader, a keyboard, or a phone that has just scrolled somewhere
                unhelpful. autofocus is the no-script half of that and main.js
                does the same thing for browsers that ignore autofocus on a
                container.
            */ ?>
            <div class="c-form__done stack" role="status" tabindex="-1" autofocus data-form-focus>
                <p class="c-form__done-title"><?= e(t($key('success.title'))) ?></p>
                <p class="c-form__done-body"><?= e(t($key('success.body'))) ?></p>
            </div>

<?php else: ?>

<?php if ($index !== '' || $eyebrow !== '' || $title !== '' || $body !== []): ?>
            <div class="c-form__head stack" style="--stack-space: var(--space-4)">
<?php if ($index !== ''): ?>
                <?php /*
                    THE SCENE NUMBER, AND ONLY A PAGE THAT COUNTS ITS SCENES
                    EVER SETS ONE. It is a span rather than part of the eyebrow
                    because it is not read as part of it — the same separation
                    film-band.php and film-chapter.php make, for the same
                    reason. /membership declares no 'index', so its markup is
                    byte for byte what it was before this line existed; proved,
                    not assumed, in tools/compare_pages.sh.
                */ ?>
                <span class="c-form__index"><?= e($index) ?></span>
<?php endif; ?>
<?php if ($eyebrow !== ''): ?>
                <p class="u-eyebrow"><?= e($eyebrow) ?></p>
<?php endif; ?>
<?php if ($title !== ''): ?>
                <h2 id="<?= e($titleId) ?>"><?= e($title) ?></h2>
<?php endif; ?>
<?php foreach ($body as $paragraph): ?>
                <p class="c-form__intro"><?= e((string) $paragraph) ?></p>
<?php endforeach; ?>
            </div>
<?php endif; ?>

<?php
/*
   THE SUMMARY, AND IT IS THE FIRST THING IN THE FORM AND THE FIRST THING
   FOCUSED.

   Somebody who cannot see the page has no way to find three red sentences
   scattered down a form. The summary collects them, says how many there are by
   listing them, and every line is a link to the field — which is why the ids
   here and on the inputs have to be the same ones, and why they are both built
   from $idFor.

   IT DOES NOT CARRY role="alert", AND IT USED TO. Moving focus to an element
   makes a screen reader read it: that is what focus does, and it is the whole
   reason the summary is focused rather than merely scrolled to. An alert role
   on the same element asks for it to be announced a second time, and several
   readers oblige — the reader hears the heading and the list twice, in a
   fifty-word block, at the moment they are least able to spare the patience.
   One announcement, from the focus, which is also the one that leaves the
   reader standing in the summary rather than wherever they were.

   It also carries the form-level messages that belong to no field: the rate
   limit, and a token that has gone stale. Those arrive as 'notice' with no
   errors beside them, and the block still appears, because a form that
   silently does nothing when the button is pressed is the worst outcome
   available here.
*/
$hasSummary = $state['submitted'] && !$state['ok'] && ($state['errors'] !== [] || $state['notice'] !== '');
?>
<?php if ($hasSummary): ?>
            <div class="c-form__summary" tabindex="-1" autofocus data-form-focus>
                <p class="c-form__summary-title"><?= e($state['notice'] !== '' ? $state['notice'] : t('form.errors.summary')) ?></p>

<?php if ($state['errors'] !== []): ?>
                <ul class="c-form__summary-list">
<?php foreach ($state['errors'] as $field => $message): ?>
<?php if (!isset($fields[$field])) { continue; } ?>
                    <li>
                        <a href="#<?= e($idFor($field)) ?>"><?= e(t($key('fields.' . $field . '.label'))) ?></a>
                        <span><?= e((string) $message) ?></span>
                    </li>
<?php endforeach; ?>
                </ul>
<?php endif; ?>
            </div>
<?php endif; ?>

            <form class="c-form__form stack"
                  method="post"
                  action="<?= e(url(current_page())) ?>"
                  <?= $titleId !== '' ? 'aria-labelledby="' . e($titleId) . '"' : 'aria-label="' . e(t($key('aria_label'))) . '"' ?>
                  data-form="<?= e($formType) ?>"
                  <?php /*
                      THE SCRIPT'S VOCABULARY, PRINTED ONTO THE FORM.

                      main.js contains no English (see the note at the top of
                      it): it is served as written and has no way to reach t().
                      So the two sentences its inline validation can produce,
                      and the summary's heading, are put here out of
                      common.php — the same arrangement the lightbox uses for
                      its labels.

                      Only these three. Length is enforced by maxlength as
                      somebody types, and every other rule on this form belongs
                      to the server.
                  */ ?>
                  data-msg-required="<?= e(t('form.errors.required')) ?>"
                  data-msg-email="<?= e(t('form.errors.email')) ?>"
                  data-msg-summary="<?= e(t('form.errors.summary')) ?>">

                <?php /*
                    Which form this is. The handler dispatches on it, and it is
                    what lets one address carry more than one form later on.
                */ ?>
                <input type="hidden" name="form_type" value="<?= e($formType) ?>">

                <?php /*
                    THE TIME-TRAP. A timestamp, signed with FORM_SECRET so it
                    cannot be written by whoever is posting — see form_token()
                    in the handler. Under three seconds between this being
                    printed and the form coming back is not somebody reading
                    the labels.

                    Re-issued on every render, which is what makes the errors
                    above recoverable: a form that comes back with a stale
                    token and reprints the same stale token can never be sent.
                */ ?>
                <input type="hidden" name="form_time" value="<?= e(form_token($formType)) ?>">

                <?php /*
                    THE HONEYPOT.

                    Hidden by moving it out of the viewport, NOT by display:none
                    on the input — the crude scrapers this catches skip inputs
                    that are display:none, and a trap that announces itself is
                    not a trap. The wrapper is what is positioned, so the input
                    itself carries no suspicious styling at all.

                    Three things keep a real person out of it: it is off-screen,
                    it is aria-hidden so no screen reader meets it, and
                    tabindex="-1" keeps it out of the tab order. autocomplete
                    is off so no browser helpfully fills it in — which is the
                    one way a genuine sender could ever trip this, and it would
                    silently bin their enquiry, so it matters.

                    It has a real <label> anyway: something reading the DOM
                    should find an ordinary labelled field, because that is the
                    bait.
                */ ?>
                <div class="c-form__trap" aria-hidden="true">
                    <label for="<?= e($idFor('website')) ?>">Website</label>
                    <input type="text"
                           id="<?= e($idFor('website')) ?>"
                           name="website"
                           value=""
                           tabindex="-1"
                           autocomplete="off">
                </div>

<?php foreach ($rows as $row): ?>
<?php
    $isPair = count($row) > 1;
?>
                <div class="c-form__row<?= $isPair ? ' c-form__row--pair' : '' ?>">
<?php foreach ($row as $name => $spec):

    $type     = (string) ($spec['type'] ?? 'text');
    $required = !empty($spec['required']);
    $max      = (int) ($spec['max'] ?? 0);
    $id       = $idFor($name);
    $label    = t($key('fields.' . $name . '.label'));
    $error    = (string) ($state['errors'][$name] ?? '');

    /*
       What is in the field. What was submitted, when something was; otherwise
       the default the page asked for, and otherwise nothing. The submitted
       value wins outright — a form coming back with errors must come back
       with what the sender typed, not with what the page would have suggested.
    */
    $value = $state['submitted']
        ? (string) ($state['values'][$name] ?? '')
        : (string) ($defaults[$name] ?? '');

    $hintKey  = $key('fields.' . $name . '.hint');
    $hint     = str_replace('{max}', (string) $max, t($hintKey));
    $hasHint  = $hint !== '' && !str_starts_with($hint, '[[missing');

    /*
       aria-describedby points at the hint and the error together, in that
       order, because that is the order they are read and the order they are
       on the page. A field with neither gets no attribute at all rather than
       an empty one pointing at nothing.
    */
    $describedBy = [];

    if ($hasHint) {
        $describedBy[] = $id . '-hint';
    }

    if ($error !== '') {
        $describedBy[] = $id . '-error';
    }

    $describedByAttr = $describedBy !== []
        ? ' aria-describedby="' . e(implode(' ', $describedBy)) . '"'
        : '';

    // Only ever printed as "true". aria-invalid="false" on every untouched
    // field is noise in the accessibility tree.
    $invalidAttr = $error !== '' ? ' aria-invalid="true"' : '';

    /*
       The conditional field. It is rendered VISIBLE and not hidden, and that
       is the progressive-enhancement decision: without a script there is
       nothing to reveal it, so somebody who was referred by a member must be
       able to say so. main.js collapses it on load when Yes is not the
       answer, and from then on it opens and closes with the radio.
    */
    $reveal   = $spec['reveal'] ?? null;
    $revealed = is_array($reveal) ? ' data-reveal-target' : '';
?>
<?php if ($type === 'radio'): ?>
                    <?php /*
                        A radio group is a <fieldset> with a <legend>, which is
                        the one construction that makes a screen reader read
                        the question before each of the answers. A <p> above
                        two labelled radios reads as "Yes" and "No" with no
                        idea what was asked.
                    */ ?>
                    <fieldset class="c-form__field c-form__fieldset"<?= $invalidAttr ?>>
                        <legend class="c-form__label"><?= e($label) ?><?php if ($required): ?><span class="c-form__mark" aria-hidden="true"><?= e(t('form.required_mark')) ?></span><?php endif; ?></legend>

                        <div class="c-form__choices">
<?php foreach ((array) ($spec['options'] ?? []) as $option): ?>
<?php
    $optionId    = $id . '-' . $option;
    $isChecked   = $value === $option;

    /*
       aria-expanded goes on the control that does the expanding, and here that
       is the Yes button specifically — No controls nothing and says nothing
       about a region. aria-controls names the region it opens.

       It is printed as "true" because the field below is rendered open: with
       no script that is the truth, and a control that claims to be collapsed
       above a visible field is worse than no attribute. main.js sets it to
       false at the same moment it hides the field, so the two never disagree.
    */
    $controls = '';

    foreach ($fields as $targetName => $targetSpec) {
        $targetReveal = $targetSpec['reveal'] ?? null;

        if (is_array($targetReveal)
            && ($targetReveal['field'] ?? '') === $name
            && ($targetReveal['value'] ?? '') === $option) {
            $controls = ' aria-controls="' . e($idFor($targetName) . '-field') . '" aria-expanded="true"';
        }
    }
?>
                            <span class="c-form__choice">
                                <input type="radio"
                                       id="<?= e($optionId) ?>"
                                       name="<?= e($name) ?>"
                                       value="<?= e($option) ?>"
                                       <?= $isChecked ? 'checked' : '' ?><?= $controls ?>>
                                <label for="<?= e($optionId) ?>"><?= e(t($key('fields.' . $name . '.options.' . $option))) ?></label>
                            </span>
<?php endforeach; ?>
                        </div>

<?php if ($error !== ''): ?>
                        <p class="c-form__error" id="<?= e($id . '-error') ?>"><?= e($error) ?></p>
<?php endif; ?>
                    </fieldset>

<?php else: ?>
                    <div class="c-form__field"<?= $revealed ?><?= is_array($reveal) ? ' id="' . e($id . '-field') . '"' : '' ?>>
                        <label class="c-form__label" for="<?= e($id) ?>"><?= e($label) ?><?php if ($required): ?><span class="c-form__mark" aria-hidden="true"><?= e(t('form.required_mark')) ?></span><?php endif; ?></label>

<?php if ($type === 'select'): ?>
                        <?php /*
                            A native <select>, styled with the same hairline
                            box as every other control and nothing else. No
                            script-built listbox: the native control is the one
                            that already works with a keyboard, with a screen
                            reader, with a thumb on a phone, and with the
                            script switched off — which is the whole rule this
                            form is built to.

                            No empty first option. The schema's first value is
                            what the field rests on, and it is 'general' for
                            exactly that reason (see validate.php).
                        */ ?>
                        <select class="c-form__control c-form__control--select"
                                id="<?= e($id) ?>"
                                name="<?= e($name) ?>"
                                <?= $required ? 'required' : '' ?><?= $describedByAttr ?><?= $invalidAttr ?>>
<?php foreach ((array) ($spec['options'] ?? []) as $option): ?>
                            <option value="<?= e($option) ?>"<?= $value === $option ? ' selected' : '' ?>><?= e(t($key('fields.' . $name . '.options.' . $option))) ?></option>
<?php endforeach; ?>
                        </select>
<?php elseif ($type === 'textarea'): ?>
                        <textarea class="c-form__control c-form__control--text"
                                  id="<?= e($id) ?>"
                                  name="<?= e($name) ?>"
                                  rows="6"
                                  maxlength="<?= (int) $max ?>"
                                  <?= $required ? 'required' : '' ?><?= $describedByAttr ?><?= $invalidAttr ?>><?= e($value) ?></textarea>
<?php else: ?>
                        <input class="c-form__control"
                               type="<?= e($type) ?>"
                               id="<?= e($id) ?>"
                               name="<?= e($name) ?>"
                               value="<?= e($value) ?>"
                               maxlength="<?= (int) $max ?>"
<?php if (!empty($spec['autocomplete'])): ?>
                               autocomplete="<?= e((string) $spec['autocomplete']) ?>"
<?php endif; ?>
                               <?= $required ? 'required' : '' ?><?= $describedByAttr ?><?= $invalidAttr ?>>
<?php endif; ?>

<?php if ($hasHint): ?>
                        <p class="c-form__hint" id="<?= e($id . '-hint') ?>"><?= e($hint) ?></p>
<?php endif; ?>

<?php if ($error !== ''): ?>
                        <p class="c-form__error" id="<?= e($id . '-error') ?>"><?= e($error) ?></p>
<?php endif; ?>
                    </div>
<?php endif; ?>
<?php endforeach; ?>
                </div>
<?php endforeach; ?>

                <p class="c-form__note"><?= e(t('form.required_note')) ?></p>

                <?php /*
                    THE PRIVACY NOTICE, DIRECTLY ABOVE THE BUTTON.

                    Where the person is looking at the moment they decide to
                    send it — not in the footer, not behind a link called
                    "legal". Both forms on this site collect personal data, the
                    GDPR applies, and a notice is only informed if the
                    information is where the decision is made (ARCHITECTURE
                    §12.3). What each form says about itself is its own
                    sentence, in common.php, because the two collect different
                    things for different reasons.

                    One sentence. The link is built from routes.php through
                    url() like every other address on this site, and the
                    sentence is assembled here rather than in common.php
                    because a content file holding a fragment of markup is the
                    thing the content layer exists to prevent.
                */ ?>
                <p class="c-form__privacy">
<?php
    $privacyLink = '<a href="' . e(url('privacy')) . '">'
        . e(t($key('privacy.link')))
        . '</a>';

    // The sentence is escaped, then the one anchor is put into it. Escaping
    // after the replacement would print the markup; not escaping at all would
    // publish whatever a translator wrote.
    echo str_replace('{link}', $privacyLink, e(t($key('privacy.text'))));
?>
                </p>

                <p class="c-form__actions">
                    <button class="c-btn c-btn--primary" type="submit"><?= e(t($key('submit'))) ?></button>
                </p>

            </form>

<?php endif; ?>

        </div>
    </div>
</section>
<?php
}
