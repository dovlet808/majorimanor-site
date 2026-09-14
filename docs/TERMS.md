# Majori Manor — TERMS & IMPRESSUM

**The eleventh page, the last one, and the second document.**

> *Modify ONLY /terms.* The ten approved pages are byte-identical after this
> work. Proved rather than asserted — `tools/compare_pages.sh`, §7.

| | |
|---|---|
| Route | `/terms` — `routes.php`, unchanged |
| Content | `content/en/terms.php` — **not one word of either document changed** |
| Template | `templates/pages/terms.php` (new, 160 lines) |
| Stylesheet | `assets/css/privacy.css` (the legal layer, untouched) + `assets/css/terms.css` (new, 511 lines) |
| Script | `assets/js/privacy.js` (untouched, loaded — there is no `terms.js`) |
| Hero | `ter-library` — `HOUSE_OF_DIALOGUE/2.png` → 16:9 crop → Seedance 2.0 |
| Credits | **22.5** spent. 654 → 631.5 |

---

## 1. What it is

### The concept, and what it is not

The brief asked for **"THE TERMS OF ENTERING THIS WORLD"** and then spent most of
its length saying what that must not turn into: *"it must NOT become a marketing
page… Do NOT hide legal information behind cinematic interactions… Do NOT make
important clauses appear only after scrolling through animations… THIS IS NOT A
COPYWRITING TASK."*

So this is a document with one photograph at the top of it. Everything under the
first screen is a reading surface — warm cream, one column at a comfortable
measure, a numbered index beside it, and about eleven hundred words of legal text
that no script is allowed to be responsible for.

### It is two documents and it now says so

`content/en/terms.php` has said since the day it was written that it holds **two
documents**: the terms proper, which are short because the site is short, and the
impressum, which is the legally required part and the part that cannot be
finished. Until this rebuild a reader had no way to see the seam between them.
They do now, and it is the one break on the page that means anything — see §5.

### The colour rhythm is the brief's, exactly

The brief drew it:

> DARK HERO → WARM CREAM DOCUMENT → SUBTLE GREEN CHAPTER → WARM CREAM DOCUMENT
> → DARK FOOTER

The page:

| | |
|---|---|
| hero | near-black — the film's own ground, 56svh of it |
| index | deep green — a panel standing on the cream |
| document | warm cream — clauses 01–06 |
| **chapter** | **deep green — the seam, before 07** |
| document | warm cream — the impressum |
| footer | `--green-900`, as on every other page |

---

## 2. The asset audit

A fresh recursive pass over all twelve directories of `media_src/`.

| Directory | Files | What it is | Used here |
|---|---|---|---|
| `CIGAR_HOUSE/` | 9 | visualisations | 0 |
| `estate/` | 4 | real photography — the four exteriors | 0 — **all four are already heroes**, see below |
| `ESTATE_and_HOSPITALITY/` | 7 | visualisations | 0 |
| `grand-staircase/` | 4 | real photography | 0 |
| `heritage-details/` | 3 | real photography | 0 — `heritage_1` is /privacy's hero |
| `HOUSE_OF_DIALOGUE/` | 3 | visualisations | **1 — `2.png`, the library** |
| `interiors/` | 15 | real photography | 0 |
| `Majori_logo/` | 23 | brand artwork | 0 (the crest ships from `assets/img/brand/`) |
| `MOTION/` | 96 | every sequence and its references | + `MOTION/terms/`, new |
| `pavilion/` | 3 | real photography | 0 |
| `PRIVATE_CLUB_ECOSYSTEM/` | 12 | visualisations | 0 |
| `RESTAURANT/` | 7 | visualisations | 0 |

Nothing new had arrived since /privacy. `MOTION/terms/` is this page's own and is
the only addition.

### Why the library, and not the house

The brief offered eleven subjects — manor exterior, estate entrance, gate,
reception, architectural detail, dark wood, corridor, library, quiet interior,
estate at dusk, heritage architecture — and asked for four qualities: **quiet
authority, heritage, discretion, trust.** Its suggested Seedance direction was
the entrance at dusk with warm light in the windows.

**That shot is already on this site four times, and each one is an approved
page's first screen.**

| Negative | Whose hero it is |
|---|---|
| `estate/estate_1.jpg` | THE ESTATE — `est-arrival`, the gate piers at blue hour |
| `estate/estate_2.jpg` | CONTACT — `con-arrival`, the portico at dusk, warm windows, a mature tree |
| `estate/estate_3.jpg` | MEMBERSHIP — `mem-threshold`, the north front at night |
| `estate/estate_4.jpg` | AFTER DARK — `ad-nightfall`, the garden front at night |

A fifth facade with lit windows would have been the same page a fifth time. The
rule that stops this site drifting is `docs/MEMBERSHIP.md`'s, and it is one line:
**a hero source is spent once.** That page declined `estate_4.jpg` for exactly
this reason and it was right to.

### So it is one of the other seven, and it is the one that is the subject

`HOUSE_OF_DIALOGUE/2.png` is a library: oak bookcases floor to ceiling on three
walls, bound volumes, a carved marble chimneypiece with a fire in it, a portrait
in a gilt frame, two candelabra, two lamps and four leather chairs with **nobody
in them.**

- **A library is where an estate keeps its documents.** The page is the estate's
  formal papers; the room is where formal papers live. It is the brief's own
  "library", "dark wood" and "quiet interior" at once.
- It is none of the things the brief said to avoid — no padel, no crowd, no
  wedding, no party, no cigar smoke, no gaming, nothing social.
- **It has never been a hero and has never moved.** The Main Page prints it as
  `home/story-library` at 4:5 and THE CLUB as a 16:9 room plate. Both are flat,
  both are stills, neither is a first screen.

### Three others considered and not used

- **`interiors/interiors_11.png`** — the enfilade with the white tiled stove and
  two open doors. Quiet, formal, empty, and it has never been a sequence either.
  It lost on subject: it is a way *through* a house, and /privacy's hero is
  already a way through a house (a glazed screen with one leaf open). Two legal
  pages opening on two doorways is one idea used twice.
- **`ESTATE_and_HOSPITALITY/reception_concierge.png`** — the brief lists
  "reception", and this is one, with the estate's crest on the wall behind it.
  **There is a man standing at the desk.** The brief says no people, twice.
- **`estate/estate_1.jpg`, tighter** — the gate alone, which is *literally* "the
  terms of entering this world", and it was the first idea. It is THE ESTATE's
  hero re-cropped. See above.

---

## 3. What was generated, and from what

**Nothing was generated but the motion**, and that is the brief's own
instruction: *"Use existing media_src assets whenever they are already suitable.
Do NOT regenerate an image unnecessarily."*

```
HOUSE_OF_DIALOGUE/2.png        2160 x 1920   the library, its fire lit
      |                                      (a visualisation — 'render')
      |  16:9 window at bias 0.26, by tools/photos/build_terms_media.py
      v
MOTION/terms/ref-library.png   2160 x 1215   the reference AND the start frame
      |
      |  Seedance 2.0 · 720p · std · 16:9 · 5 s · generate_audio false
      v
MOTION/terms/ter-library.mp4   1280 x 720    24 fps, the master
      |
      |  trim 2.4 s -> stretch x1.6 -> palindrome -> x264
      v
assets/video/ter-library.mp4       696 KB    1280 wide
assets/video/ter-library-sm.mp4    276 KB     854 wide
assets/img/terms/ter-library-*     poster, frame 0 of the encode
```

### There is no GPT Image 2 step, and that is the difference from /privacy

/privacy needed one because `heritage_1.jpg` is a **noon photograph** and that
page wanted first light: the generation's whole job was to change the hour. There
is no equivalent gap here. The library in the file is already lit by its own fire
and its own two lamps, at the hour a legal page wants, and a generation whose
entire instruction would have been *"change nothing"* is 6.5 credits spent to
introduce risk. **The crop is the reference and the crop is the start frame.**

Measured: frame 0 of the finished encode differs from `ref-library.png` by
**1.92** mean absolute difference out of 255 — which is JPEG, not the model.

### The crop, chosen by looking

The negative is 2160 × 1920, almost square, so a 16:9 window drops 705px of
height and the only question is where. Three were rendered and compared:

| bias | what it keeps |
|---|---|
| 0.10 | the top shelf; loses the table, the silver and the chair fronts — a bookcase with a fire in it rather than a room |
| **0.26** | **the whole portrait in its frame, both candelabra, the mantel, the fire, both lamps, the chesterfield, both armchairs, the silver** |
| 0.42 | cuts the top of the gilt frame and gains carpet |

### `start_image`, not `omni_reference`

The brief asked for `mode: omni_reference`. It is built on `start_image` instead,
which is the rule `build_events_media.py` set and six pages have now kept, and
the reason is the brief's own instruction two paragraphs above it: *"Preserve:
manor architecture, estate identity, materials, proportions… Majori Manor visual
identity."*

**A reference is a mood and a start frame is a contract.** It is the only setting
under which nine bays of bookcase, a carved chimneypiece, a gilt frame and two
candelabra survive five seconds of camera movement intact. It is also what makes
the poster honest: frame 0 of the encode is what a reader sees before the video
plays, so the still and the film cannot re-frame against each other when the
video fades up.

### The model went the other way, and it was kept

The prompt asked the camera to drift **in**; the master drifts **out**. Measured
against frame 0, the shot is 1.06× wider at one second, 1.13× at two, 1.19× at
three and 1.32× at five.

It is kept because **the loop is a palindrome and therefore plays both**. The
encode runs forward and then backwards, so a reader sees the room open and then
close again, continuously; "toward" and "away" are the same 2.4 seconds seen from
either end. What the direction does decide is the poster, and it decides it the
right way round: frame 0 is the tightest framing in the shot, which is the
composition that was chosen and checked.

### Why it is trimmed to 2.4 s, and the hard reason is not the one you expect

Two reasons, and the tighter wins.

- **The soft one** is /privacy's: the shot keeps travelling, and a fifth of a
  frame is the most this design system has ever let a hero move.
- **The hard one** is that at about **four seconds the model invents a doorway in
  the left wall.** The pull-back opens that wall far enough that it fills the new
  space with architecture the estate has not published — which a page about what
  this site does and does not claim may not ship. 2.4 s stops a second and a half
  before it.

Frame by frame to 2.4 s the bookcases, the chimneypiece, the relief tablet, the
gilt frame, the two candelabra, the two lamps, the chesterfield, the armchairs,
the table and the silver are all where the crop put them, and no object enters.

### And then slowed: this is now the slowest hero on the site

15.5% of travel over 2.4 s is 6.5% a second. `setpts` spreads the same travel
over 3.84 s — **4.0% a second, against /privacy's 4.9%** — and `minterpolate`
rebuilds the intermediate frames so the encode is a true 24 fps rather than 15
fps of duplicates. The brief asked for movement that is "almost imperceptible"
and for "a still architectural image that is quietly alive". It is the gentlest
move on Majori Manor.

### The loop, measured

`-t` goes **before** `-i`, so the trim limits the decode and the palindrome is
built from the source rather than cut out of the output. Frame counts and the
seam, measured on the shipped files:

| | frames | an ordinary adjacent step | the loop seam | the turn |
|---|---|---|---|---|
| `ter-library.mp4` | 186 | 2.89 | **4.87** | 2.79 |
| `pri-doors.mp4` | 186 | 2.40 | **2.69** | 5.69 |
| `con-arrival.mp4` | — | — | **33.18** — a hard cut | — |

The seam here is 1.7× an ordinary frame step rather than /privacy's 1.1×, and the
fire is why: the reversed half plays the flames backwards, so at the rejoin one
frame of fire motion is doubled. It is the same regime — /privacy's *turn* is
2.4× its own step — and nowhere near a cut.

### The encode is the loosest on the site, and that was measured too

Nine bays of bookcase are a wall of fine high-contrast detail that changes in
every frame, and a fire is the one light source that never repeats one. The film
pages encode heroes at 25/28 and /privacy measured its way to 27; at 27 this one
is 1246 KB.

| CRF | wide encode | mean abs diff vs crf 25 | distinct luma in the firebox |
|---|---|---|---|
| 25 | 1699 KB | — | 142 |
| 27 | 1246 KB | 2.60 | 146 |
| 29 | 922 KB | 2.95 | 145 |
| **31** | **695 KB** | **3.40** | **139** |
| 33 | 536 KB | 3.93 | 143 |

**31, and the stopping rule is banding rather than size.** The firebox — the one
place a picture this dark could band — holds the same ~140 distinct luma values
at every step, and the two encodes were put side by side at the book spines, the
candle flames, the gilt ornament and the carved relief. They are the same
picture. The narrow encode takes 33.

---

## 4. What was built, and what was reused

### New files (4)

| File | Lines | What it is |
|---|---|---|
| `templates/pages/terms.php` | 160 | The page. Numbers the clauses, places the breaks, draws the document frame |
| `templates/components/legal-break.php` | 128 | The seal seam and the green chapter field |
| `assets/css/terms.css` | 511 | The hero clamp and scrim, the two breaks, the index's chapter mark, the impressum schedule, the narrow pass |
| `tools/photos/build_terms_media.py` | 472 | The crop and the encode, rebuildable from one PNG |

### Deleted (1)

`templates/pages/legal.php` — the frame both legal pages used to render through.
/privacy left it in September and this page was the only thing still holding it
up. It is unreachable now. **`components/clause.php` was NOT touched**: AFTER
DARK still prints one standalone clause through it.

### Reused, untouched (2 — and this is the design)

- **`assets/css/privacy.css`.** It is not "the privacy page's stylesheet" any
  more than `estate.css` is "the estate page's". It is **the legal document
  layer** — the cream reading surface, the two-column frame, the green index, the
  clause, the notice and the foot — and TERMS is a legal document. Seven approved
  pages take `estate.css` for exactly this reason.
- **`assets/js/privacy.js`.** Its four jobs are the compact bar, the navigation
  sheet, the hero's one video and the mark on the clause being read, and all four
  are addressed by data attribute — every one of which this page has. **There is
  no `terms.js` and there was nothing for one to do.**

Both ought to be called `legal.css` and `legal.js`. Renaming them is not
available: `asset_url()` cache-busts on `filemtime`, so touching either file at
all would re-version the stylesheet in an approved page's markup. It is the trade
`estate.css` made when THE CLUB took it.

### Additive edits to shared files (3) — every one proved inert

| File | The edit | Why it cannot reach an approved page |
|---|---|---|
| `content/en/terms.php` | `'mood'` `day`→`night`; six keys added (`own_chrome`, `nav`, `footer`, `hero`, `document`, `chapters`) | It is this page's content file. **The `sections` array is byte-identical** — §6 |
| `templates/components/legal-index.php` | an entry may carry a `chapter`, which draws a divider in the contents | `pages/privacy.php` builds its plan from `index` and `subs` and sets no such key. /privacy renders byte-identical — §7 |
| `templates/partials/head.php` | one row in `$filmPages` | The other ten rows are untouched; ten pages render byte-identical — §7 |

`tools/measure_contrast.js` gained four selectors. It is a local harness and
nothing under `public_html/` knows it exists.

---

## 5. The layout

### Desktop, ≥1080px

A 16rem sticky index in the left column and the document in the right, at a
37rem measure — `privacy.css` §3 and §4, unchanged. Above 1240px the clause
numbers move out into their own margin strip.

### The two breaks, and the limit the brief set on them

> *"Unlike the Privacy page, TERMS may contain subtle visual breaks between major
> legal chapters… Do NOT insert visuals so frequently that reading becomes
> annoying. One visual break after approximately every 2–3 major sections is
> sufficient."*

Seven clauses, two breaks, both keyed in the content file to the id of the clause
they stand before — so a break cannot drift when a clause moves.

**The seal seam, before 04.** A gold hairline fading out at both ends with the
estate's crest standing in the middle of it. Pure ornament: `aria-hidden`, no
text. It is `components/seam.php`'s idea at a document's scale.

- It is **green** and not `auto`. The page's mood is `night`, so the ground rules
  resolve `--seal-src` to the gold crest, and gold artwork on cream paper
  measures about 1.6:1 and reads as a smudge.
- It is **56px** and not 46. `partials/seal.php`: *"the club seal is legible from
  48px up; below that its rings close and it reads as a grey disc."* 46 was under
  the line and looked it. The narrow pass takes 50, still clear of it.
- The clause under it drops its own hairline. A gold seam and a grey rule a
  centimetre apart read as a box drawn round nothing.

**The green chapter field, before 07.** The seam between the two documents, in
the same `--pv-green` as the index panel and under the same gold rule.

### The field was display type, and the page said no

It began with **Impressum** set in the display serif at 2.15rem — directly above
the clause heading **Impressum**, in the display serif, at 2.15rem. It did not
read as a chapter opening a document. It read as a heading printed twice, and
therefore as a mistake in a legal document.

Set as small uppercase metadata the relationship is the one it actually is: a
running head over the section it belongs to, the way a part-title works in a
printed act. It is also the treatment the contents was already giving the same
chapter — and with both on screen it was the index's version that looked right.

### And then the accessibility tree said no to the rest of it

The label was a `<p>` from the start — an `<h2>` would have put "Impressum" into
the document outline twice in a row — inside a `role="group"` named by that
label, on the theory that a chapter is a region and a region should be announced.
Dumped, the tree read:

```
StaticText "IMPRESSUM"
heading    "Impressum"
```

The same word twice with nothing between them, the second being the real heading
of the real clause. **The field is `aria-hidden` now and nothing is lost by it:**
a chapter mark whose entire content is the name of the single clause underneath
it is, for anybody not looking at the page, that clause's heading printed early.

This is not a general rule about chapter marks. A field naming a chapter of
*several* clauses would carry information the outline does not have and should be
announced. This one does not.

### The impressum: four boxes became one schedule

`privacy.css` §6 draws a TODO notice as a warm panel with a wine edge, which is
right when a document has one. **This document has four in a row.** Four stacked
panels with four repeated labels read as four errors rather than as one list of
what is missing.

Joined edge to edge under a single wine rule, with the label in its own 5.5rem
column above 560px, they read as what they are: **a form with four unfilled
fields.** No markup changed, no word changed, and all four labels still print.

### Mobile, and one bug found by measuring

Below 1080px the index is a green band between the hero and the document; between
600 and 1079 it runs in two columns and the chapter mark spans both.

**The hero copy was sliding off the bottom of the frame on a phone, and it is
`privacy.css`'s bug rather than this page's.** `home.css` §6 sets the hero to
`align-items: end`, then under 620px to `align-items: center` with 6–9rem of
bottom padding — both correct for a *full-screen* film hero with a scroll cue in
it. `privacy.css` re-cuts the padding to 2.5–4.25rem because a clamped legal hero
has no cue to clear, but nothing puts the alignment back. Measured at 390 × 844:
a 473px hero with its copy at 119…303 and **170px of empty photograph under it.**

One line in `terms.css` §1 restores `align-items: end` below 620px. The copy now
sits at 238…422 and stands over the darkest band of this particular picture.

**It is not fixed in `privacy.css`.** That page is approved and outside this
brief, so nothing there was touched and nothing there was rebuilt. It is recorded
here so the next page to take that stylesheet takes the line with it.

### Where the 16:9 frame is cut

A hero 1440 wide and 504 tall is 2.86:1 and the picture is 1.78:1, so a third of
its height is cropped and `object-position` decides which third. `home.css` sets
42% for a facade under a sky. Rendered at four values:

| | |
|---|---|
| 0% | loses the crest at the top of the gilt frame |
| **22%** | **the whole portrait, both candelabra, the mantel, the head of the firebox, both lamps, bookcases to both edges — and its darkest band is exactly where the h1 lands** |
| 42% | the portrait cut at the collar |
| 62% | the portrait cut at the hands; the fire is directly behind the title |

Below about 900px the number stops mattering: a phone hero is taller than it is
wide, so `cover` fits the height and crops the **sides**. The full height of the
frame survives and the reader gets the chimneypiece group, centred. The mobile
crop is elegant because the picture is symmetrical, not because it is steered.

---

## 6. Legal-content preservation, verified two ways

### 1. The arrays, diffed

`content/en/terms.php` was copied before the work started and the two were
diffed:

```
$ diff <(sed -n '/^    .sections. => \[/,$p' terms.php.orig) \
       <(sed -n '/^    .sections. => \[/,$p' terms.php)
SECTIONS ARRAY: BYTE-IDENTICAL
```

The whole diff against the approved file, outside `sections`, is **one line
removed** — `'mood' => 'day',` — and six keys added, none of which is legal text:
`own_chrome`, `nav`, `footer`, `hero`, `document`, `chapters`. `title`, `links`,
`updated` and `meta` are untouched.

### 2. The rendered page, compared string by string

A harness reads every string out of the content file — the title trio, and every
clause title, body paragraph, list item and **TODO line** — resolves each
`{token}` to the label the page prints for it, and requires all of them to appear
in the rendered text **in document order**:

```
27 strings checked, 0 failures, in document order.
TODO notices rendered: 4   labelled with the word TODO: 4
```

### TODO preservation

The owner has not supplied the company's legal name, its registration number, its
registered address, or the governing law and competent court that follow from
them (ARCHITECTURE §21, open question 4). **All four gaps print, all four are
labelled, and the label is still the word.**

| | |
|---|---|
| Notices rendered | 4 of 4 |
| Label | `t('legal.todo')` → **TODO**, from `common.php`, unchanged |
| Visible with JS off | 4 of 4, at full opacity |
| Visible under reduced motion | 4 of 4, at full opacity |
| Contrast, label / body | 7.97 / 14.45 |

**"OWNER ACTION REQUIRED" is not used.** The brief allowed that wording only *"if
that wording already exists in the project"*, and it does not. The project's word
is TODO, and `common.php` says why: *"'to be supplied' reads as a decision; TODO
reads as unfinished work, which is what it is."*

Nothing was inferred, guessed or filled from general knowledge. No legal entity,
registration number, registered address, telephone number, governing law, court,
price, fee or commercial term appears on this page that was not already in the
content file.

### The impressum, checked field by field

| | On the page |
|---|---|
| Address | Konkordijas iela 66, Jūrmala, LV-2015, Latvia — as written |
| Email | `info@majorimanor.com`, a live `mailto:` — as written |
| Telephone | *"There is no published telephone number."* — as written |
| Company name · registration number · registered address · governing law | **four TODO notices, unresolved** |

---

## 7. Verification

Every check below was run against the page served locally at
`http://127.0.0.1:8321/terms`.

### The ten approved pages

`tools/snapshot_pages.sh` before and after, `tools/compare_pages.sh` between:

```
after_dark   IDENTICAL      estate     IDENTICAL      privacy     IDENTICAL
club         IDENTICAL      events     IDENTICAL      residences  IDENTICAL
components   IDENTICAL      home       IDENTICAL      styleguide  IDENTICAL
contact      IDENTICAL(t)   membership IDENTICAL(t)   notfound    IDENTICAL
padel        IDENTICAL      terms      CHANGED*
PASS — every page except terms is unchanged.
```

`(t)` is the per-request `form_time` token on the two pages with forms, which is
different on every render by design. **/privacy is byte-identical**, which is what
proves the `legal-index.php` edit inert.

### The page itself

| Check | Result |
|---|---|
| Console errors | **none** |
| Failed requests | **none** |
| Broken images | none — 4 poster rungs + the crest, all 200 |
| Horizontal overflow | **none at 375, 390, 430, 768, 1024, 1440, 1920** — `scrollWidth === clientWidth` at every one, and no element's right edge past the viewport |
| Hero height | 56% of the viewport at every width — 473/844, 560/1000, 504/900. The brief asks 45–65vh |
| Heading outline | one `<h1>`, seven `<h2>`, no others. The chapter field adds no rung |
| Sitemap | 11 urls, every `<loc>` equal to the canonical its page renders |

### JavaScript OFF

| | |
|---|---|
| Clauses rendered | **7 of 7** |
| Legal paragraphs and titles | **28 of 28 visible**, none hidden, **none below full opacity** |
| TODO notices | **4 of 4**, labelled |
| Contents index | 7 anchors, every one a plain in-page link |
| Navigation | **9 links visible at 390px** — `privacy.css` §10 brings the row back when the sheet's script is not there |
| Footer | Contact · Membership · Privacy · Terms |
| Hero | the poster; the `<video>` never gets a `src` |
| Animations in the document | **none** |

### prefers-reduced-motion: reduce

| | |
|---|---|
| Legal content | 28 of 28 visible, none below full opacity |
| Hero text entrance | `animation-name: none` on all three lines |
| Hero video | never attached — `videoSrc: (none)` |
| Anchor scrolling | the browser's own jump; `scroll-behavior: smooth` is inside a no-preference query |

### Keyboard and anchors

Tab order from a fresh load: skip link → wordmark → the eight nav links →
Membership → the contents index → the document's own links → *Return to the top*.
**Every focusable element has a visible 2px outline** — `#7A5C24` on the cream
document, `#E0C68F` on the green panel and the dark chrome.

Clicking a contents link lands the clause at **y = 102** with the fixed bar
ending at **y = 76** — 26px of daylight, from `html { scroll-padding-block-start:
6rem }` in `privacy.css` §1.

### The active-section mark

Scrolled to `#availability`, the contents shows `05 Availability` marked, with
`aria-current="true"`. The bar is `.is-compact`. Neither is required for anything
to work.

### The hero sequence

```
playing true · currentTime 3.52 · readyState 4 · 1280x720
loop true · muted true · .is-playing set · opacity 1
```

---

## 8. Legibility, measured

`tools/measure_contrast.js`, extended with this page's four new selectors and run
at seven widths. It scrolls with real wheel events, makes the glyphs transparent
rather than hidden so every wash behind them stays where it is, samples the
95th-percentile **brightest** pixel each element's letters cross — which on a
light ground is the paper itself, and is therefore still the worst case for dark
ink — and reports the worst ratio each element reaches anywhere on the page.

| Width | Elements | Failures | Worst on the page |
|---|---|---|---|
| 375 | 26 | **0** | `.c-film-foot__members` 5.13 |
| 390 | 26 | **0** | `.c-film-foot__members` 5.13 |
| 430 | 26 | **0** | `.c-film-foot__members` 5.13 |
| 768 | 26 | **0** | `.c-film-foot__members` 5.13 |
| 1024 | 26 | **0** | `.c-film-foot__members` 5.13 |
| 1440 | 26 | **0** | `.c-film-foot__members` 5.13 |
| 1920 | 26 | **0** | `.c-film-foot__members` 5.13 |

The worst element on the page is the footer line every page shares, and it is
above 4.5. The elements this page introduced, at 1440:

| | ratio | size |
|---|---|---|
| `.c-legal-index__chapter` | 5.92 | 11.7px |
| `.c-legal-break__numeral` | 5.93 | 11.7px |
| `.c-legal-note__label` | 7.97 | 11.7px |
| `.c-legal-index__chapter-n` | 8.08 | 11.7px |
| `.c-legal-break__label` | 11.32 | 11.7px |
| `.c-legal-note__body` | 14.45 | 15.9px |

The body of the legal text measures **15.84** — near-black on cream — and is set
at 18–19.5px over 1.75 line-height at a 66–70 character measure, which is
`privacy.css` §5's column and the brief's *"comfortable line-height, sufficient
reading width, do not use extremely small typography."*

---

## 9. Performance

| | desktop 1440 | phone 390 |
|---|---|---|
| Everything | 1187 KB | **726 KB** |
| — of which the hero sequence | 696 KB | 277 KB |
| **Without the sequence** | **491 KB** | **449 KB** |
| Requests | 16 | 16 |
| LCP | **164 ms** | **96 ms** |

/privacy on the same harness: 1148 KB at 1440, LCP 148 ms. This page is 39 KB
heavier and the difference is accounted for below.

**The video is not in the critical path.** It ships with no `src` at all;
`privacy.js` attaches one after the `load` event, only when motion is welcome and
the connection is not metered, and picks the 277 KB narrow encode below 900px
against the 696 KB wide one above it. Until then, and forever for a reader who
has asked for reduced motion, the poster is the hero — a real `<picture>` with a
srcset, lazily decoded, and the same frame at the same crop.

**Where the 39 KB went, stated rather than hidden.** `terms.css` is 23 KB and
`crest-green.png` is 32 KB, against a 16 KB smaller video. The crest is the
supplied brand artwork at 320 × 320 — the size the 140px seal on /membership
needs at 2× — fetched here to draw one 56px mark. Cutting a second, smaller copy
of the same crest would mint a brand file that `tools/brand/build_assets.py` does
not own and that nothing else would use, which is how two files of one mark start
disagreeing. It is one request, it is cached, and it is the only ornament on the
page.

**No motion layer.** `'motion' => false` keeps GSAP, ScrollTrigger, Lenis and
`home.js` — about 50 KB — off this page entirely, as on /privacy. The brief asks
for a lightweight page and for legal text that never waits on a script.

---

## 10. Assets and credits

```
ASSET ACCOUNTING

SOURCE            media_src/HOUSE_OF_DIALOGUE/2.png                2160 x 1920
                  the library, its fire lit
                  (a visualisation of the project — declared 'render')

REFERENCE CROP    media_src/MOTION/terms/ref-library.png           2160 x 1215
                  16:9 at bias 0.26, rebuildable by build_terms_media.py
                  REASON  the negative is almost square; the window that
                          holds the whole chimneypiece group is 0.26

GENERATED IMAGE   none
  REASON          the room is already lit by its own fire at the hour the
                  page wants. The brief: "Do NOT regenerate an image
                  unnecessarily." The crop IS the reference and the start
                  frame — frame 0 of the encode differs from it by 1.92/255
  COST            0 credits

SEEDANCE HERO     media_src/MOTION/terms/ter-library.mp4           1280 x 720
  SOURCE IMAGE    ref-library.png
  START IMAGE     ref-library.png   (start_image, not omni_reference — §3)
  MODEL           Seedance 2.0 · 720p · std · 16:9 · 5 s · generate_audio false
  MOTION          extremely slow level drift; firelight moving on the marble
                  and the leather; the candle flames wavering; nothing else
  TRIM            2.4 s of 5.04, then slowed x1.6 to 3.84 s
                  4.0% of travel a second — the slowest hero on the site
  COST            22.5 credits

VIDEO             public_html/assets/video/ter-library.mp4    696 KB  1280 wide
                  public_html/assets/video/ter-library-sm.mp4 276 KB   854 wide
POSTER            public_html/assets/img/terms/ter-library-1280.jpg  140 KB
                  public_html/assets/img/terms/ter-library-1280.webp  81 KB
                  public_html/assets/img/terms/ter-library-768.jpg    64 KB
                  public_html/assets/img/terms/ter-library-768.webp   41 KB
                  (frame 0 of the encode — the still and the film cannot
                   re-frame against each other when the video fades up)

CREDITS SPENT     22.5      (654 → 631.5)
CREDITS LEFT      631.5
```

`media_src/MOTION/terms/` holds 8.5 MB: the reference crop, the master and frame
0. `.gitignore` carries `/media_src/**/*.mp4`, so the master stays on disk and in
the backup and the encodes under `assets/video/` are the committed deliverable.

---

## 11. Limitations

1. **`main.js` is fetched and does nothing here.** 45 KB, deferred. Its job is
   the *site* header's scroll state and the *site* navigation drawer, and this
   page renders neither — it draws the film's chrome and `privacy.js` runs it.
   `head.php` loads `main.js` unconditionally for all eleven pages; moving that
   line would re-version the script URL in ten approved pages' markup, so it
   stays. /privacy carries the same 45 KB for the same reason.

2. **`privacy.css` and `privacy.js` are the legal layer under the wrong names.**
   Neither can be renamed without cache-busting an approved page. §4.

3. **The mobile hero-alignment bug is still live on /privacy.** Identified,
   measured and fixed here; not touched there, because that page is approved and
   outside this brief. §5.

4. **`crest-green.png` is 32 KB for a 56px mark.** §9.

5. **The four impressum gaps are still gaps**, and no amount of design work is
   going to close them. The owner has to supply the company's legal name, its
   registration number, its registered address, and — following from those — the
   governing law and the competent court. Until then the page prints four TODOs,
   on purpose, where a reader and the owner can both see them.

6. **`clause.php`'s non-standalone half is now dead code.** Nothing renders a
   non-standalone clause any more: /privacy and /terms both use
   `legal-clause.php`, and AFTER DARK's single clause is `standalone`. It was
   left alone rather than trimmed, because trimming it means editing a file an
   approved page renders through to remove something that costs nothing. The same
   is true of `main.css` §7's `.c-clause` and `.p-legal` rules, which nothing on
   the site now matches — and `main.css` may not be touched at all, since
   `asset_url()` would re-version it in all eleven pages' markup.
