# Majori Manor — CONTACT

*The eighth page cut from the film, and the only one that is not a story.*

| | |
|---|---|
| Address | `/contact` |
| Template | `templates/pages/contact.php` — four lines |
| Content | `content/en/contact.php` |
| Layers | `home.css/js` → `estate.css/js` → `contact.css/js` |
| Media build | `tools/photos/build_contact_media.py` |
| Generated | 1 GPT Image 2 still, 1 Seedance 2.0 sequence |
| Credits | **31** (see §9) |
| Weight | **1 751 KB** whole page, against 6 845 – 8 964 KB for the six story pages (§8) |

---

## 1. What it is

One page, six scenes, five acts, about 190 words. It is the shortest page on the
site and the shortest by a wide margin: AFTER DARK runs to ten screens and
fifteen plates, this one to six and three.

| | Scene | Act / ground | Carries |
|---|---|---|---|
| 00 | **The approach** | — | The house at dusk, the portico, the door — full screen, moving |
| 01 | **The address** | heritage · mahogany | `Konkordijas iela 66`, set as display type, and the mailbox |
| 02 | **On the map** | heritage | One sentence and the map, framed in gold at 21:9 |
| 03 | **The approach** | estate · near-black | *And this is what to look for.* — the gate, the drive, the house |
| 04 | **The answer** | park · green | *An answer from a person.* — a desk, and the estate's name behind it |
| 05 | **Enquiries** | heritage · mahogany | The site's enquiry form, unchanged, lit for a dark ground |
| 06 | **The invitation** | estate · near-black | *One address. One invitation.* — the seal, and two ways on |

### The four facts, and they are the approved page's own

    Konkordijas iela 66, Jūrmala, LV-2015, Latvia
    info@majorimanor.com
    that an enquiry is answered by a person
    that there is no published telephone number

**Not one item was added to that list.** What changed is everything around it.
The page this replaces opened on a green band with a title in it, put the
address beside a map in a two-column split, and ended on a form; this one opens
on the house at dusk and walks a reader to the door.

### What is still not on it

A telephone number (there is no confirmed one — ARCHITECTURE §21). Opening
hours. A staffed reception. "Visits by appointment." Parking, an airport, a
station, a transfer, or anything whatever about arriving in person. How long an
answer takes. A company name or registration number. **The pictures are held to
the same rule**: scene 03 is captioned as the gate and never as "your entrance",
and scene 04 as a desk and never as a reception that is open.

### The grounds alternate, and that is the one structural rule this page breaks

ARCHITECTURE §3.4 settled that a film page moves monotonically — never back
toward a lighter ground — because each of the six story pages is a journey
inward. This page is not a journey. It is a threshold with two registers that
take turns:

```
hero    estate     #0B0A08   near-black
01 02   heritage   #17110C   mahogany   ← the letter
03      estate     #0B0A08   near-black
04      park       #0A1310   green
05      heritage   #17110C   mahogany   ← the letter
06      estate     #0B0A08   near-black
```

The two screens where a reader is asked to write something down are the same
colour. It is the only thing on the page a reader is meant to notice without
being told, and it only works because it happens twice.

**All five grounds are `estate.css` §1's own and not one is new.** This is the
first film page since THE ESTATE to add no ground at all, which is the right
outcome for the page that is meant to look most like the rest of the site.

---

## 2. The asset audit

All twelve directories of `media_src/` were re-walked before anything was
chosen. What was looked for: an estate entrance, a driveway, gates, a manor
exterior, a reception, a concierge, a pathway, an arrival, a garden, a night or
dusk exterior, architectural identity, and Majori Manor branding.

| Directory | Files | Verdict |
|---|---|---|
| `estate/` | 4 | **Both of this page's real-building sources.** `estate_1.jpg` is the gate; `estate_2.jpg` is the portico the hero was generated from |
| `ESTATE_and_HOSPITALITY/` | 7 | **`reception_concierge.png` is scene 04.** The only reception in the library, and the only frame with the estate's own wordmark on a wall |
| `PRIVATE_CLUB_ECOSYSTEM/` | 13 | Audited, not used — see below |
| `CIGAR_HOUSE/` | 9 | Interiors of the club. Nothing a contact page needs |
| `RESTAURANT/` | 7 | Dining rooms. Nothing a contact page needs |
| `interiors/` | 15 | Rooms of the real house. Not an arrival |
| `grand-staircase/` | 4 | Inside the hall. Not an arrival |
| `heritage-details/` | 3 | Close details. Not an arrival |
| `HOUSE_OF_DIALOGUE/` | 3 | THE CLUB's subject |
| `pavilion/` | 3 | EVENTS' subject |
| `Majori_logo/` | lockups | Already built into `assets/img/brand/` |
| `MOTION/` | 9 folders | Every existing sequence reviewed — see §3 |

### Three files considered and not used, with the reason

**`PRIVATE_CLUB_ECOSYSTEM/12.jpeg`** — the strongest branding frame in the
library: a MAJORI MANOR plaque beside a lantern-lit stone entrance. Two things
kept it off: a branded buggy fills the right two thirds of the frame and the
brief forbids vehicles, and the building in it is a limestone visualisation that
is not the manor. On the one page whose job is to say what to look for, a
picture of a door that is not this door is the wrong picture.

**`PRIVATE_CLUB_ECOSYSTEM/8.jpeg`** — the lit gravel path toward the manor
through mature trees, which is very close to the brief's own description of the
hero. It is `pad-gates` on /padel and its subject is the Padel Club sign.

**`MOTION/estate/est-arrival.mp4`** — the existing arrival, and it is /the-estate's
hero: a dolly through the gate piers at blue hour. Reusing it would have put an
approved page's first screen on a second page. See §3.

---

## 3. What was generated, and from what

**One still and one sequence.** The brief asks for one primary cinematic visual
and says not to generate a still for the sake of generating one; the library was
checked against that instruction first, and what it does not contain is this
building's front door with a light behind it.

```
SOURCE       media_src/estate/estate_2.jpg          900 × 1013, the garden front
             ↓ 16:9 crop at bias 0.68               900 × 506
REFERENCE    media_src/MOTION/contact/ref-approach.png
             ↓ GPT Image 2, 2K, high, 16:9
STILL        media_src/MOTION/contact/still-approach.png     2688 × 1520
             ↓ Seedance 2.0, 720p, std, 16:9, 5 s, no audio, start_image
MASTER       media_src/MOTION/contact/con-arrival.mp4        1280 × 720, 5 s
             ↓ trim 3.2 s → palindrome → grade → encode
VIDEO        assets/video/con-arrival.mp4      747 KB   1280 wide
             assets/video/con-arrival-sm.mp4   260 KB    854 wide
POSTER       assets/img/contact/con-arrival-{768,1280}.{jpg,webp}   frame 0 of the encode
MOTION       Extremely slow level dolly forward across the lawn toward the lit
             portico; leaves stirring; the light breathing. Nothing else moves.
```

Both prompts are printed verbatim in `tools/photos/build_contact_media.py`,
because a prompt is the only part of a generated asset that cannot be recovered
by looking at it. Both are written as **preservation instructions**: each names
the architecture and materials of that specific frame, states the one thing that
may change, lists the motion that is allowed, and then says what may not appear.

### Why this is not `est-arrival` and not `est-park`

Same house, and neither picture:

| | THE ESTATE's hero | THE ESTATE's scene 05 | **CONTACT's hero** |
|---|---|---|---|
| Source | `estate_1.jpg` | `estate_2.jpg` | `estate_2.jpg` |
| Subject | the gate | the whole elevation | **the portico and the door** |
| Hour | blue hour | golden hour | **half an hour after sunset** |
| Ratio | 16:9 | 21:9 | **16:9** |
| Camera | dolly through the piers | lateral drift | **walk in, level** |

### `start_image`, not `omni_reference`

The brief asks for `mode: omni_reference`. The sequence is built on `start_image`
instead, and the reason is the brief's own next sentence — *"Preserve the exact
architecture, driveway, landscaping, gates, windows and proportions of the
source."* A reference is a mood; a start frame is a contract. It is the only
setting under which a pediment, four columns and a glazing pattern survive five
seconds of camera movement intact, it is what every sequence on the seven
approved pages uses (`build_events_media.py` set the rule and four pages have
kept it), and it is what makes the poster honest: frame 0 of the encode is what
a reader sees before the video plays, so the still and the film cannot re-frame
against each other when the video fades up.

### Why it is trimmed to 3.2 of its 5 seconds

The master is clean for the whole five seconds — level, continuous, no drift, no
shake, architecture held. Over five it simply travels far enough that the last
second is standing at the foot of the steps, which is a promotional arrival and
not the *extremely restrained* one the brief asks for. Cut at 3.2 the house grows
by about a fifth across the shot; palindromed, the reader sees six and a half
seconds of the camera easing in and easing back out, and nothing else on the
screen moves at all.

---

## 4. What was built, and what was reused

### New files (6)

| File | Lines | What it is |
|---|---|---|
| `templates/components/contact-address.php` | 102 | The address, set as display type inside one `<address>` element |
| `templates/components/contact-map.php` | 78 | A scene around the map this site already had. Draws no map |
| `assets/css/contact.css` | 939 | This page's layer — grounds, hero, address, map scene, form |
| `assets/js/contact.js` | 126 | One job: a slow scale on the two bands that are photographs |
| `tools/photos/build_contact_media.py` | 622 | Two plates and one sequence |
| `docs/CONTACT.md` | this file | |

### Rewritten (2)

`content/en/contact.php` and `templates/pages/contact.php`.

### Additive edits to shared files (5) — every one proved inert

| File | Change | Who can see it |
|---|---|---|
| `templates/partials/head.php` | a `'contact'` row in the film table | /contact only |
| `templates/components/film-band.php` | optional `widths` and `sizes` on a film | a band that declares them |
| `templates/components/film-invitation.php` | optional `anchor` on an action | an action that declares one |
| `templates/partials/form.php` | optional `index` (a scene number) | a form block that declares one |
| `templates/components/map.php` | optional `MAP_API_KEY` from config | only when a key is defined |

**Proved, not assumed.** `tools/snapshot_pages.sh` was run with the five patches
in place and again with all five reversed, and `tools/compare_pages.sh` reports
every one of the other thirteen routes byte-identical. /membership differs only
by its per-request `form_time` token, which is what that token is for.

### What was left out

Six film components this page does not draw: the walk, the ledger, the lateral
detail track, the dialogue, the plates and the world. It is six screens long and
every one of them would have been a screen it did not need.

### The form is the site's form

`components/form-enquiry.php` and `partials/form.php` render scene 05, unchanged.
Same schema, same five fields, same `required` attributes, same maxlengths
(120 / 254 / 40 / 2000), same subject list, same honeypot, same signed time-trap,
same rate limiter, same error summary that takes focus, same privacy sentence
above the button, same thank-you in place of the form, same no-JavaScript POST,
same handler and same two mails. **What changed is the ground under it and the
type on it**, and that is `contact.css` §6 — six rules.

---

## 5. The grade, and the two pictures it exists for

### The hero

The master runs from 46 out of 255 at frame 0 to 65 by the trim. Every approved
hero on this site sits between 29 and 40, and this one has to carry four lines of
cream type over a facade lit from below.

    eq=gamma=0.80:contrast=1.030:saturation=0.95     →  frame 0 measures 29

Midtones down about a fifth; contrast up three percent so the windows do not
flatten into the wall; saturation off five percent because a warm picture
darkened goes orange before it goes dark. Half the fix is here and half is in
`contact.css` §2b, exactly as on THE ESTATE — neither does it alone, and either
alone taken far enough would have cost the windows the glow that makes the shot.

### The gate

`estate_1.jpg` is a bright summer photograph: the crop measures **77** ungraded,
against 18 – 49 for every band the site already ships. Dropped in raw it would be
a hole punched in the page.

    LATE = (0.30, 0.74, (1.0, 0.955, 0.88))          →  measures 47

It is **not** a night curve. `build_residences_media.py`'s NIGHT takes the same
file to 22, and at band size that reads as an underexposed daylight photograph
rather than an evening — the sky is still a summer sky and the render is still
lit by the sun. LATE leans into the hour the photograph actually has: the mid
comes down to 0.30, the highlights are held at 0.74 so the warm light on the
gate pier survives, and blue comes down twelve percent against green's four and
a half.

### The desk is not graded at all

`reception_concierge.png` measures **20** as cut — darker than every band on the
site bar one — because it is a low-key render of a panelled room lit by one lamp.
There is nothing for a curve to do to it, and a lift would be the only thing on
this page that changed a picture to make it prettier.

---

## 6. Legibility, measured

`tools/measure_contrast.js`, adapted to the Playwright driver available on this
machine, run at four widths. It scrolls with real wheel events so Lenis moves the
page exactly as a reader does, makes the glyphs transparent rather than hidden so
every wash behind them stays where it is, samples the 95th-percentile brightest
pixel each element's **letters** cross, and reports the worst ratio each element
reaches anywhere on the page.

| Width | Elements | Failures | Worst element on the page |
|---|---|---|---|
| 375 | 36 | **0** | `.c-film-hero__statement` 4.77 |
| 390 | 36 | **0** | `.c-film-hero__statement` 4.78 |
| 768 | 36 | **0** | `.c-contact-place__index` 4.81 |
| 1440 | 36 | **0** | `.c-contact-place__index` 4.81 |
| 1920 | 36 | **0** | `.c-contact-place__index` 4.81 |

The threshold is 4.5:1 for small text and 3:1 for large. Nothing on the page is
within a tenth of failing, and the two elements that come closest — the hero's
one sentence and a 10.6px scene number — clear by a quarter of a stop.

Four things failed on the way there and each was fixed by moving type or by a
wash, never by darkening a picture into something it is not.

| | Was | Now | Fix |
|---|---|---|---|
| `.c-film-band__title` on the gate | under 2 at 1440 | **13.3 – 15.9** | Held to 13ch so it sets in two lines over the gate pier, and a gradient that leans into the bottom-left corner rather than covering the frame |
| `.c-film-band__index`, both bands | 3.21 at 1440, 2.12 at 390 | **5.67 – 8.23** | `--ink-muted` instead of `--ink-faint`. One colour, both bands, no picture darkened |
| `.c-film-band__eyebrow` on the desk, at 390 | 1.31 | **6.95 – 8.42** | The full-bleed band takes a height instead of a ratio on a phone (`padel.css` §5's answer), and the crop moves right so the vase and the lamp go out of frame |
| `.c-map__coordinates`, `.c-map__credit a` | 2.94 / 2.35 | **4.81** | Off their `opacity` and onto a colour. Opacity is the wrong instrument on a dark ground: it fades toward the ground rather than away from it. The credit in particular is a licence condition, not decoration |

---

## 7. Verification

| | Checked | Result |
|---|---|---|
| 1 | All twelve `media_src/` directories re-audited | §2 |
| 2 | Every generated asset descends from `media_src/` | §3 — `estate_2.jpg` → still → sequence |
| 3 | Architecture preserved through both generations | Columns, pediment, oculus, door, bench, steps, bay windows, dormers, chimneys, tree — all present and in place |
| 4 | The map works | Placeholder, observer, Leaflet build, gold pin, pan, zoom, geo: hand-off, credit — all confirmed. **Tiles watermarked, see §8** |
| 5 | Address unchanged | `Konkordijas iela 66 / Jūrmala, LV-2015 / Latvia` |
| 6 | Mailbox unchanged | `info@majorimanor.com`, in the page and in the JSON-LD |
| 7 | Coordinates unchanged | 56.9653, 23.8125 — in one place in the content file |
| 8 | Form submission | Valid submission → thank-you replaces the form, mail sent |
| 9 | Required-field validation | Empty POST → summary with 3 field errors, 3 × `aria-invalid`, typed values preserved, fresh token issued |
| 10 | Privacy messaging | Present, directly above the button, linking `/privacy` |
| 11 | Honeypot | Filled trap → success page, no mail |
| 12 | Time-trap | Sub-3-second POST → refused with a recoverable message |
| 13 | Rate limiter | Counting; logged in `private/logs/` |
| 14–20 | Main Page, THE ESTATE, THE CLUB, PADEL, EVENTS, RESIDENCES, AFTER DARK | **Byte-identical** — `tools/compare_pages.sh` |
| 21 | 375 / 390 / 430 / 768 / 1024 / 1440 / 1920 | All rendered and screenshotted |
| 22 | Horizontal overflow | None at any width (`scrollWidth === innerWidth` at all seven) |
| 23 | Broken images | 0 at all seven widths |
| 24 | Console errors | 0 |
| 25 | PHP notices / warnings | 0 for this route |
| 26 | Keyboard navigation | 27 stops in document order, every one with a visible 2px gold focus ring, no trap, honeypot skipped |
| 27 | Reduced motion | No GSAP, no Lenis, no page scripts, no video fetched. All 21 reveal elements fully visible. Same layout, ~50 KB lighter |
| 28 | Cinematic hero | Wide encode above 900px, narrow below, both attached after `load` |
| 29 | Mobile menu | Opens, `aria-expanded` flips, CONTACT marked current, sheet scrolls |
| 30 | Whole page rendered top to bottom | 1440 and 375 |

---

## 8. Limitations

### The map tiles are watermarked, and it is not this page's doing

CARTO changed the terms of their keyless raster basemaps. `dark_all` still
answers 200 and still draws Jūrmala, but every tile now comes back with
**"API KEY REQUIRED / carto.com/basemaps/apikey"** written diagonally across it.
Verified directly against `a.basemaps.cartocdn.com`, the Fastly host and the
`rastertiles` path — all three, every zoom.

Nothing in the site broke. The component, the IntersectionObserver, the printed
address, the gold pin, the pan, the zoom, the coordinates and the geo: hand-off
all work exactly as they did. The pictures underneath them are watermarked.

**`/contact` is the only page that renders a map**, so this is visible on one
page — but the decision is not this page's to take, for two reasons:

1. `/privacy` carries an approved clause that names CARTO and tells a reader
   that opening the map makes a request to their servers **and to nobody
   else's**. Changing the tile host would make that sentence false, and
   `/privacy` is outside this brief's scope.
2. Which company receives a visitor's IP address is the owner's decision, not a
   detail of a stylesheet.

So the plumbing is in and the provider is not changed. `components/map.php` now
reads an optional key:

```php
// private/config.php
define('MAP_API_KEY', '…');   // from a CARTO account
```

With it defined the key is appended and the tiles come back clean. With it
undefined — today, and in `config.example.php` — the URL printed onto the frame
is byte for byte the one this component has always printed.

**The two ways out, costed:**

| | Change | Touches |
|---|---|---|
| A | A CARTO key in `private/config.php` | One line. `/privacy` stays true |
| B | A different tile provider | `map.php`, **and one sentence in `/privacy`**, which needs re-approval |

### What the models added, stated rather than hidden

**GPT Image 2** added small ground uplighters at the foot of the columns and the
steps, which the prompt asked it not to add. They are consistent with the light
the prompt *did* ask for — something has to be washing those columns from below
— they are small, they are at the bottom of the frame, and they were left rather
than spend a second generation on them.

**Seedance** added a second mature tree at the left of the frame, mirroring the
one the still has at the right, and opened the framing slightly. The still is not
the poster — the poster is frame 0 of the encode — so the page never shows the
two side by side, and the estate's own park is planted with mature trees on both
sides of this lawn in `estate_2.jpg`. It is landscaping the model invented all
the same.

### The gate ships at 985 px and not at 1152

The crop stops before the gate pier that carries the estate's old enamel sign, in
a language that is not Latvian and with a name on it that is not Majori Manor. It
is a true detail of the building as photographed and every other page can carry
it — `/the-estate` ships this frame at 16:9 with the sign in it and is approved.
This is the one page whose job is to tell somebody what to look for when they
arrive, and a photograph of the entrance with another name on the pier is the
single most confusing thing it could print.

The cost is the top rung: 985 px is the whole of the window, so the band ladder's
1152 would be an upscale and is not exported. That is why the band is `wide`
rather than `full` — inside the shell it is about 1 313 px on a 1 440 desktop,
which asks the frame to stretch about as far as the site's own 1 152 plates
already are.

### One test enquiry reached the real mailbox

`private/config.php` carries live SMTP credentials, so the valid-submission test
in §7 row 8 **actually sent** — one message to `info@majorimanor.com` from
*Test Sender / test@example.com*, subject *"Enquiry — Residences — Test Sender"*,
at 15:26 UTC on 5 September 2026, plus its autoreply to a non-existent address.
It should be deleted. No local mail catcher exists in this project; adding one is
the obvious next housekeeping job.

### Unused shared CSS

This page draws no walk and no ledger, so `estate.css` §2 and §3 — about 350
lines — match nothing here, and both of `estate.js`'s jobs return on their first
line because neither `[data-walk]` nor `[data-ledger-row]` is in the DOM. That is
the price of not forking a shared file and it is still the right price: the bytes
are already in the reader's cache from the pages that do use them.

### Weight

Uncompressed transfer, dev server, whole page after a full scroll:

| Page | Total | Video | Images |
|---|---|---|---|
| **/contact** | **1 751 KB** | 747 | 329 |
| /residences | 6 845 KB | 4 871 | 1 426 |
| /the-estate | 8 034 KB | 6 463 | 1 100 |
| /after-dark | 7 992 KB | 6 285 | 1 157 |
| /events | 8 964 KB | 7 047 | 1 377 |

First screen: 1 333 KB on a desktop and 854 KB on a phone, of which the video is
747 / 260 — and the video is attached after the `load` event, so none of it is in
the critical path. Under `prefers-reduced-motion` no video and no motion library
is fetched at all.

---

## 9. Credits

| | count | rate | credits |
|---|---|---|---|
| GPT Image 2, 2K, high, 16:9, from a reference | 1 | 8.5 | **8.5** |
| Seedance 2.0, 720p, std, 16:9, 5 s, no audio | 1 | 22.5 | **22.5** |
| | | **spent** | **31** |

Balance before **765.5**, balance after **734.5**.

**Nothing was discarded and nothing was regenerated.** Two requests, two assets,
both shipped. The still came back with the architecture intact on the first
request and the sequence held its framing for the whole five seconds — which is
what a prompt written as a preservation instruction buys.

It is the cheapest page in the project by a wide margin: AFTER DARK spent 121,
RESIDENCES 114, and this one 31.

---

## 10. Two things worth reading the code for

### The crop that stops before the sign

`tools/photos/build_contact_media.py` adds one field to a plate spec that the
seven build scripts before it did not have: `box`, a pixel window taken out of
the source **before** the ratio is applied. `build_after_dark_media.py` needed
the same thing and solved it by moving a bias until two labelled bottles fell out
of frame; that works when the thing to avoid is at an edge and it does not when
it is a third of the way in.

The entry on `contact/con-gate` is the longest comment in that file, and all of
it is about one enamel sign.

### The form that changed by six rules

`main.css` draws every form control as a hairline box on the page's own ground,
reading `--rule`, `--fg` and `--accent`, precisely so that one control works on
cream, on green and on wine without a modifier. `home.css` §2 has already pointed
those three at the film's own cream, hairline and gold. **The form arrives
correct** — which is why `contact.css` §6 is six rules and not sixty, and why not
one line of the form's markup or behaviour had to move to put the site's enquiry
form on a cinematic page.

What those six rules do is give it the film's rhythm rather than the page's: the
section's vertical space becomes the scene's, the column widens from 44rem to
48rem because a film measure is wider than a page measure, the heading is set in
the display face at chapter size, the controls' hairline is lifted from 12% to
22% because a field somebody has to find needs a firmer edge than a rule between
two blocks, and the submit takes the same padding, tracking and unhurried
transition as the invitation's button on the screen below — so the two buttons on
this page are one button.
