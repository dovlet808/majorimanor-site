# Majori Manor — PADEL

**The fourth page cut from the Main Page's film, and the first one that never
goes indoors.** Everything below is what was built, what it was built from, and
the decisions worth arguing with.

Read it with `public_html/content/en/padel.php` open beside it. That file is the
page: every act, every scene, every ratio, every sentence and every picture is
declared there, and nothing on PADEL can be changed anywhere else.

---

## 1. What it is

One page, eight scenes, six acts, read top to bottom as an evening at a club
that happens to have courts.

| | Scene | Act / ground | Carries |
|---|---|---|---|
| 00 | **The arrival** | — | The lit path to the clubhouse after sunset — full screen, moving |
| 01 | **The club** | park · green | *A club that happens to have courts.* + the whole complex at 21:9 |
| 02 | **The complex** | heritage · mahogany | The five settled facts as a drawing sheet, and the plan under them |
| 03 | **The courts** | interior · deepest | An hour before sunset, tracked sideways along the hedge |
| 04 | **The social side** | park · green | *The side of it nobody plays on.* — the terrace, the shop, the bar |
| 05 | **The park** | estate · near-black | *Inside the park walls.* — the club's sign, and the house behind it |
| 06 | **Day into evening** | evening · wine | *The courts go quiet.* — the park on the way back up |
| 07 | **The estate** | evening | Four places, four pages, one line each |
| 08 | **A court, and the rest of the day** | evening | The seal, and two ways to write |

**It is the first film page that adds no component.** THE ESTATE brought the
walk and the ledger; THE CLUB brought the lateral track and the dialogue. This
one is built entirely out of what those three already approved — `film-hero`,
`film-band`, `film-chapter`, `film-ledger`, `film-plates`, `film-world`,
`film-invitation`, `film-nav`, `film-footer` and the act wrapper — plus one
block that is not from the film's library at all: `plan-padel`, the drawing the
old page rendered, unchanged.

**It is the second page to set the ledger and the first to set it against a
drawing.** THE ESTATE uses it for the house's five facts. Here the five are the
five settled facts of the complex, and the plan stands directly under them —
which makes the ledger a title block and the drawing the sheet it belongs to.

**There is less prose than there was.** The version this replaces ran to about
430 words of body copy; this one runs to about 250. What was cut is every
sentence that was describing something there was no picture of.

**Four sentences survived word for word, because they are the approved ones:**
*Play. Meet. Stay.*, *A club that happens to have courts*, *The side of it
nobody plays on*, and *Padel is where the day begins, not where the experience
ends.* The last is the CEO's line and the argument of the whole page; it is set
as a display lede immediately under the last band rather than as a pull-quote
between two sections, because on this page it is a conclusion.

**No sentence acquired a fact.** The rebuild settled nothing, so the confirmed
list and the forbidden list at the top of the content file are the ones that
were already there. The five ways the courts are used — private tournaments,
members' matches, coaching, guest access, events — are §10 of the owner's brief
verbatim, and they are the only programme named anywhere on the page. No
schedule, no season, no hour, no coach and no tournament has a name.

---

## 2. The asset audit

All twelve directories of `media_src/` were inspected again. **The library has
not grown since THE CLUB was built** — the same 12 directories, the same files —
so this page is built entirely out of material three pages had already been
through, and the work was finding the frames none of them had used.

| Directory | Files | Kind | Used here | Used before |
|---|---|---|---|---|
| `PRIVATE_CLUB_ECOSYSTEM/` | 12 | visualisations | **5** — 1, 3, 8, 9, 10 | 4, 5 (club) · 2, 4, 5, 7, 9 (home) |
| `pavilion/` | 3 | photographs | **1** — pavilion_1 | **0 — no page had ever used this directory** |
| `RESTAURANT/` | 7 | visualisations | **1** — dining_salon2 | 4 elsewhere; this file only ever as a *sequence* source |
| `CIGAR_HOUSE/` | 9 | visualisations | **1** — cigar_lounge | as above |
| `ESTATE_and_HOSPITALITY/` | 7 | visualisations | **1** — private_cottages | home, at a different ratio |
| `interiors/` | 15 | photographs | 0 | estate · club |
| `HOUSE_OF_DIALOGUE/` | 3 | visualisations | 0 | club · home |
| `estate/` | 4 | photographs | 0 | estate |
| `grand-staircase/` | 4 | photographs | 0 | estate · home |
| `heritage-details/` | 3 | photographs | 0 | estate |
| `Majori_logo/` | 18 | brand | **2** — seal-cream, seal-gold | all three |
| `MOTION/` | — | the built sequences | its own | its own |

### The padel material, grouped

Everything in the library that is about the padel club, and what happened to it:

| Group | File | Used |
|---|---|---|
| **COURTS** | `PRIVATE_CLUB_ECOSYSTEM/1.png` — 2688×1152, the whole complex at night | **three pictures** — §3 |
| **ARRIVAL** | `PRIVATE_CLUB_ECOSYSTEM/8.jpeg` — the lit sign panel, the path, the house | **the scene 05 sequence** |
| **SOCIAL ZONE** | `PRIVATE_CLUB_ECOSYSTEM/9.jpeg` — the racket sign over the terrace at dusk | **the scene 04 sequence, and a plate** |
| **PADEL SHOP** | `PRIVATE_CLUB_ECOSYSTEM/10.jpeg` — the racket cabinet and ball lockers | **a plate** |
| **LANDSCAPE** | `PRIVATE_CLUB_ECOSYSTEM/3.png` — the park at night, the lit path, the rotunda | **the scene 06 band** |
| **MEMBERS / SOCIAL** | `PRIVATE_CLUB_ECOSYSTEM/4.png`, `5.png` | no — THE CLUB's, and its people scene |
| **BRAND** | `PRIVATE_CLUB_ECOSYSTEM/11.jpeg` — the identity board | **no** — see below |
| **ESTATE CONTEXT** | `PRIVATE_CLUB_ECOSYSTEM/12.jpeg` — the club car at the manor door | **no** — see below |
| **ARCHITECTURAL PLAN** | the owner's infographic | **redrawn**, and it was redrawn before this page — `plan-padel.php` |
| **LOUNGE · BAR · EVENING** | `CIGAR_HOUSE/`, `ESTATE_and_HOSPITALITY/`, `RESTAURANT/` | four frames, in the estate index only |

### What was deliberately not used

- **`PRIVATE_CLUB_ECOSYSTEM/11.jpeg`, the identity board.** Its top third is a
  real signage visualisation — the wordmark on a dark wall between two hedges,
  with a court behind — and it is the best brand frame in the library. It is
  1179×1615 and that panel is about 290px tall, which is a 4:1 strip that no
  slot on this page can take without upscaling. **The page uses no `mood`
  images and does not upscale**, so it stayed out. If the panel is ever
  re-exported on its own it belongs in scene 01.
- **`PRIVATE_CLUB_ECOSYSTEM/12.jpeg`, the club car.** A branded electric cart at
  the manor's front door, in flat daylight. Every other picture on this page is
  an evening; and the only caption that would explain what it is doing here —
  that it runs between the house and the courts — is a fact nobody has
  confirmed. Two reasons, either one sufficient.
- **`PRIVATE_CLUB_ECOSYSTEM/2.png` (the dome) and `7.png` (the gym).** Both are
  the Main Page's index tiles at the same ratio; putting them in this page's
  index would have been the same four pictures twice on one site. `2.png` is
  also `/events`, which has not been built.
- **`pavilion_2` and `pavilion_3`.** Both are broad daylight — an aerial of the
  dome on a lawn and the inside of it laid for lunch — and this page has no
  ground bright enough to stand them on.
- **`interiors/`, `grand-staircase/`, `heritage-details/`, `estate/`,
  `HOUSE_OF_DIALOGUE/`.** The house's, and the house has two pages of its own.

Nothing was excluded for quality.

---

## 3. What was generated, and from what

**Two stills and four sequences.** Every one descends from a file in
`media_src/`, and the descent is recorded in `tools/photos/build_padel_media.py`
and repeated here.

### One file carries most of the page, and it carries three pictures

`media_src/PRIVATE_CLUB_ECOSYSTEM/1.png` is 2688×1152 and is the only frame in
the library that holds the whole complex — the clubhouse and its sign, the lit
path, the hedge, and the courts running away in depth. Three pictures are cut
from it, and they are three pictures rather than three crops:

| | Crop | Becomes |
|---|---|---|
| the whole frame | 2688×1152, exactly 21:9, nothing cropped | `padel/club-park` — scene 01's band, a still |
| the left 2048 | the clubhouse end, 16:9 | `pad-arrival` — **the hero**, a slow approach |
| the right 2048 | the courts end, 16:9 | the reference for the afternoon still → `pad-courts` |

The last two are the same negative at opposite ends of it, at different hours
and moving in different directions. It is the division
`build_club_media.py` makes between `club/house-enfilade` and
`club/detail-portal` — *that one is the room, this is the thing in it* — on a
frame that has to work harder.

**The Main Page's `seq-padel` is also made from this file**, as a lateral track
across the full width at night. Nothing on this page repeats that shot: the hero
is a forward move on the left third, and the courts sequence is the right third
at golden hour.

### Stills — GPT Image 2, 2K, high, 16:9, from a reference

| Output | From | What changed |
|---|---|---|
| `media_src/MOTION/padel/still-courts-afternoon.png` | `PRIVATE_CLUB_ECOSYSTEM/1.png` → 16:9 right crop | **The hour, and nothing else.** Late afternoon, an hour before sunset: warm gold sky, low sun behind the trees, long shadows across the courts and the hedge. Every element preserved — the glass and black steel court walls, the blue-grey playing surfaces and their white lines, the four players where they stand, the strings of lights inside the courts, the floodlight columns, the clipped hedge, the path bollards, the trees. |
| `media_src/MOTION/padel/still-social.png` | `PRIVATE_CLUB_ECOSYSTEM/9.jpeg` | **The camera moved, and nothing else did.** The supplied frame is a portrait with the racket sign filling two thirds of it and the social zone behind it, mostly out of shot; a 16:9 band cut from it is the sign again. The instruction is a step backwards and to the left, and every object it names — the timber pavilion, the bar and its bottle shelves, the pendant lanterns, the rattan seating and its cushions, the candle lanterns, the ribbed planters, the racket sculpture and its lettering, the court and its players, the umbrella — is an object already in the reference. The hour is unchanged. |

**Nothing was added to either still.** THE CLUB's `still-great-hall` lit a fire
in an empty hearth and that page names it as its one addition; there is no
equivalent here. Both prompts were written as **preservation instructions**:
they name the architecture, the landscaping and the materials of that specific
frame, state the one thing that may change, and then list what may not appear.
**Both are recorded verbatim in `tools/photos/build_padel_media.py`**, above the
`SEQUENCES` table.

**The afternoon still is the one daylight picture on the site, and it exists
because the page needs a day.** Every padel reference in the library is an
evening, a night or a dusk. A page whose argument is that a member can spend a
whole day here has to be able to show one, and the honest way to get it is to
move the sun on a picture of *these* courts rather than to find a picture of
somebody else's. It was marked "Generated image" for exactly that reason — a
label since removed from every page on the owner's instruction (ARCHITECTURE
§11). It is still declared `generated` in the content file; the reasoning above
is why, and it is now carried by the declaration alone.

### Sequences — Seedance 2.0, 720p, 16:9, no audio, 5s, `start_image`

| Sequence | Started from | Motion | Scene |
|---|---|---|---|
| `pad-arrival` | `PCE/1` → 16:9 left crop | Very slow approach along the lit path toward the clubhouse | **00, the hero** |
| `pad-courts` | `PCE/1` → 16:9 right crop → `still-courts-afternoon` | Slow lateral track along the hedge, the courts opening in depth | 03 |
| `pad-social` | `PCE/9` → `still-social` | Slow dolly across the terrace, candle flames moving | 04 |
| `pad-gates` | `PCE/8` → 16:9 centre crop | Slow dolly along the path, past the club sign, the house lit beyond | 05 |

**`start_image` on all four, not `image_references`.** The reference is the
first frame of the generation rather than a mood for it, which is the only
setting under which court geometry, a hedge line and a piece of signage survive
five seconds of camera movement intact. It is also what makes the poster honest:
frame 0 of the encode *is* the reference, so the still and the film cannot
re-frame against each other when the video fades up.

Every prompt is a preservation instruction of the same shape, and the negative
half does the work: *no new people entering frame, no new buildings, courts,
fences, signs, lettering or objects, no redesign of the courts, the sign or the
landscaping, one continuous shot, no cuts, no camera shake, no zoom snap, no
lens flare.* All four are recorded verbatim in the build script.

**The loop is a palindrome and that is not a shortcut.** Each of the four is a
single continuous move that never returns to where it started, so a hard cut
back to frame 0 jumps — and on a shot this slow the jump is the only thing in it
that moves quickly. Each plays forward and then backward, seamless by
construction. This is `tools/motion/build_sequences.sh`'s filter, verbatim.

### The hero changed after it was built, and nothing was regenerated

The first cut opened on the sign — a lit stone panel with the estate's crest cut
into it, standing in the middle right of the frame. It is the best single
picture in the padel material and it was **the wrong plate for a hero**: the
crest on that panel is the same crest `film-hero` stands in cream at the top of
the copy, so the first screen carried it twice, and the panel's own lettering
ran directly under the statement while *STAY.* crossed the crest.

So the approach to the clubhouse became the hero and the sign panel became scene
05, where the manor standing lit behind it is that scene's whole argument. **The
two are the same two files under different names** — `pad-evening` became
`pad-arrival`, `pad-arrival` became `pad-gates` — and not one credit was spent
on the change. The same collision is the reason the mobile hero is cropped at
`object-position: 48%` rather than centred: at the centre the clubhouse fascia
lands behind *PLAY*.

### The honesty marking

| marking | count | prints its mark | what it is here |
|---|---|---|---|
| `render` | 7 | 4 | The project's own visualisations — the complex, the park, the shop, the terrace, and three tiles in the estate index. |
| `generated` | 4 | 3 | The four Seedance sequences, each carrying its own frame 0 as its poster. |
| `photo` | **1** | — | The pavilion, in the estate index — and it is not a photograph of the padel club. |
| `mood` | **0** | — | — |

Twelve pictures, plus the two seals and the footer lockup — **fifteen images in
the markup**, of which fifteen load and none is broken at every width tested.

**Five of the twelve print no mark, and all five are in components that never
print one.** `film-hero` does not label its poster — that is true of the hero on
the Main Page, THE ESTATE and THE CLUB, and this page's hero is the fourth. And
`film-world` does not label its tiles, which is how the Main Page's own index of
eight visualisations has always rendered. Neither is a decision taken here and
neither can be changed without changing an approved page's output; both are in
§8.

**There is no photograph of these courts and there cannot be one.** The complex
is drawn, not built. When it is standing and a photographer has been, the
`render` values become `photo` — one word each, in the content file, and nowhere
else. The version this page replaces said the same thing and it is still true.

`mark_for()` in `app/helpers.php` is where the rule lives, and five components
read it. A content file cannot switch a label off.

---

## 4. What was built, and what was reused

**Reused unchanged from the three approved pages:** `film-hero`, `film-band`,
`film-chapter`, `film-ledger`, `film-plates`, `film-world`, `film-invitation`,
`film-nav`, `film-footer`, `film-acts`, the whole of `home.css` and `home.js`,
and the whole of `estate.css` and `estate.js` — the tokens, both faces, the
grain, the navigation and its active state, the six act grounds, the ledger and
its drawn rules, the seven motion jobs and the reveal states.

**`plan-padel.php` was not touched, and that is the point of §1 of `padel.css`.**
Its own comment in `main.css` says the drawing "reads `--fg`, `--bg` and
`--accent` like everything else in this section, so the same plan stands on
cream and on green without a second version of it existing." A film page is the
third ground and the claim held: the same coordinates, the same six labels, the
same accessible description, drawn in cream hairlines with a gold dimension on
mahogany. What `padel.css` supplies is the light and the measure, not the
drawing.

**New, and only what the three pages before it have no use for:**

| File | What it is |
|---|---|
| `assets/css/padel.css` | The plan on a dark ground, the reveal's states, three measured legibility fixes, the mobile pass |
| `assets/js/padel.js` | Two jobs: the drawing drawing itself, and a camera for the two bands that are stills |
| `tools/photos/build_padel_media.py` | The crop, grade, encode and poster table, and the six prompts |
| `docs/PADEL.md` | This file |

**Shared files were touched and none of them changed a byte of any other page**
(proved in §7):

- `templates/pages/padel.php` — rewritten. It is the same four statements THE
  CLUB's is, and it requires `partials/film-acts.php` rather than carrying a
  third copy of the act loop.
- `content/en/padel.php` — rewritten.
- `partials/head.php` — the film-page table gained a fourth row. The other three
  rows are unchanged.
- `.gitignore` — one rule, for `media_src/MOTION/padel/*-frame0.png`, matching
  the two already there for the estate's and the club's poster frames.

`templates/pages/estate.php` still carries its own copy of the act loop. That is
still a decision rather than an oversight, and the argument has not changed: THE
ESTATE is approved, its output is proved byte-identical after this work, and the
cheapest way to keep that true is not to open the file.

**PADEL loads `estate.css` and never draws its walk.** About three hundred lines
of that file are the sticky sequence, and this page has no `[data-walk]` in it —
`estate.js`'s walk job returns on its first line, and every rule in §2 matches
nothing. That is the price of not forking a shared file, and it is the right
price: `asset_url()` cache-busts on `filemtime`, so splitting the acts out of
`estate.css` would re-version the stylesheet in two approved pages' markup to
save bytes that are already in the reader's cache from them.

---

## 5. The grade, and why almost nothing needed one

**THE CLUB grades nine photographs and this page grades one picture.** That page
had eleven documentary interiors shot at noon and a near-black ground to stand
them on; every picture here was made dark to begin with — the padel material is
a blue hour, a night and a dusk — and pulling it down again closes it up.

The single graded entry is **`padel/park-night`**, and it is graded because of
what is either side of it: a night court before and a night clubhouse after.
Its lawn and its path are lit and theirs are not, so at its own exposure it
arrives as the brightest thing on the page. The curve is
`build_club_media.py`'s own — about eight percent off the highlights and five
off the midtones, through a 256-entry LUT.

**One value moved the other way, and it is the only one on the site that has.**
The plan's hedge is drawn as a dotted band — a dash of nothing with a round cap
— at 1.1 units, which is the width of the planting rather than a line weight. On
cream at `main.css`'s 55% those dots are a grey band behind the drawing. On
mahogany at the same number they are the brightest thing on the sheet: forty
cream discs, each one wider than every stroke in the plan, reading as beads.
`padel.css` takes them to 0.42, which puts the band just under the enclosure
hairline it runs beside.

---

## 6. Legibility, measured

Type standing on a photograph is the one thing on this page that cannot be
settled by eye. Every measurement below was taken on the rendered page against
the **95th-percentile brightest background pixel each element crosses**, with the
type hidden so it is not sampled as its own background, an element skipped
unless it is fully on screen and clear of the fixed bar, effective opacity
walked up the ancestors, and the page driven by real wheel events so Lenis moves
it exactly as a reader does.

**Three things had to change and every one of them is a number, not a taste.**

| # | Where | Before | After | What changed |
|---|---|---|---|---|
| 1 | The hero's scroll cue, over the uplit hedge | **2.94** | 4.74–4.91 | `padel.css` §3a — a foot on the hero scrim (`::before`, which `home.css` and `estate.css` both leave free) plus a soft ellipse behind the word itself. A text-shadow alone reached 3.4 and stopped: the hedge is a continuous band of warm light rather than a highlight, and a shadow can only separate type from something it is not sitting inside. |
| 2 | The band scene number, over the lit path of the park band | **3.98** | 4.60–4.72 | `padel.css` §3b — the copy box carries its own gradient, and it starts at the top of the type rather than above it |
| 3 | The same number at 375 and 390 | **4.11 / 4.32** | 4.6+ | `padel.css` §4 — the title is one line at 1440 and two at 375, so the overlay is half as tall again and the number sits where a desktop gradient has barely started. Deeper wash in the narrow query only. |

**The overlay keeps `position: absolute` and takes a `z-index`, and that is the
one way to get §3b wrong.** `home.css` pins the overlay to the foot of the frame
with `inset: auto 0 0`; making it `relative` in order to hang a pseudo-element
off it drops it back into the flow and prints the scene title at the *top* of
the picture. That mistake was made, seen in a screenshot and fixed; the note is
in the stylesheet so it is not made again.

**Result, swept across the whole page at 375, 390, 430, 768, 1024, 1440 and
1920** — every text element on the page, sampled at 16–20 scroll positions each:

| Width | elements measured | below 4.5:1 |
|---|---|---|
| 375×812 | 27 selectors | **0** |
| 390×844 | 26 | **0** |
| 430×932 | 28 | **0** |
| 768×1024 | 30 | **0** |
| 1024×768 | 24 | **0** |
| 1440×900 | 30 | **0** |
| 1920×1080 | 30 | **0** |

**Nothing on this page is below AA at any width**, which is one better than THE
CLUB, whose scroll cue measures 4.46–4.47 mid-exit at three widths. The two fixes
that closed it — a foot on the hero scrim and a wash behind the cue — are both
page-local overrides of the shared hero, and both belong in `home.css` the day
the Main Page is next opened. See §8.

The lowest reading anywhere is the ledger's label at **4.81**, and the gold
**Apply for membership** button reports 1.1 in the sweep for the reason THE
CLUB's does: hiding an element to sample its background hides its own gold fill,
so the near-black label is measured against the section's ground rather than
against the fill it stands on.

---

## 7. Verification

Everything below was run against `php -S` with `tools/serve_router.php`, in
headless Chrome, with real wheel events so Lenis drives the scroll.

**Nothing else on the site moved.**

```
tools/compare_pages.sh padel-before padel-final padel

after_dark  IDENTICAL     membership  IDENTICAL(t)
club        IDENTICAL     notfound    IDENTICAL
components  IDENTICAL     padel       CHANGED*
contact     IDENTICAL(t)  privacy     IDENTICAL
estate      IDENTICAL     residences  IDENTICAL
events      IDENTICAL     styleguide  IDENTICAL
home        IDENTICAL     terms       IDENTICAL
```

The Main Page, THE ESTATE and THE CLUB are **byte-identical with no masking at
all** — including the `?v=` cache-busting query on every asset, which is the
proof that not one shared file any of them loads was modified. `(t)` is
`/contact` and `/membership`, identical but for the per-request form-time token
they mint on every render by design.

`/components` and `/styleguide` are identical too, and they are the two pages
that render `plan-padel` — which is the proof that the drawing itself was not
touched.

**Rendering.**

| Width | doc height | overflow-x | broken images | console | plan labels | legend | 21:9 band |
|---|---|---|---|---|---|---|---|
| 375×812 | 10 681 | 0 | 0 of 15 | clean | hidden | shown | 3:2 |
| 390×844 | 10 865 | 0 | 0 of 15 | clean | hidden | shown | 3:2 |
| 430×932 | 11 091 | 0 | 0 of 15 | clean | hidden | shown | 3:2 |
| 768×1024 | 12 084 | 0 | 0 of 15 | clean | shown | hidden | 3:2 |
| 1024×768 | 11 059 | 0 | 0 of 15 | clean | shown | hidden | **21:9** |
| 1440×900 | 13 339 | 0 | 0 of 15 | clean | shown | hidden | **21:9** |
| 1920×1080 | 15 419 | 0 | 0 of 15 | clean | shown | hidden | **21:9** |

No console errors, no page errors, no failed requests, no 4xx, and no horizontal
scroll at any width.

> **One element is wider than the viewport at every width and always has been.**
> `.c-film-band--full .c-film-band__frame` measures 1065px inside a 1024px
> window, because `home.css` gives it `min-height: min(78svh, 44rem)` on top of
> `aspect-ratio: 16/9` and a forced height makes the ratio widen the box. It is
> contained by `#main { overflow-x: clip }`, it is identical on the Main Page and
> THE CLUB, and it was not introduced here — measured on all three.

**Fallbacks.**

| Mode | classes set | plan strokes hidden | plan annotations hidden | libraries fetched | videos attached | images |
|---|---|---|---|---|---|---|
| normal | `motion is-revealing is-drawing` | 16 of 16 | 19 of 19 | 3 | 1 of 4 | lazy |
| **JavaScript off** | *none* | **0 of 16** | **0 of 19** | **0** | **0 of 4** | 15 of 15 loaded, 0 broken |
| **reduced motion** | `has-js` | **0 of 16** | **0 of 19** | **0** | **0 of 4** | lazy |

With JavaScript off the page is a complete 13 339px document: a finished
drawing, six captioned bands, four chapters, two plates, the estate index and
the invitation. Under `prefers-reduced-motion` not one library byte is fetched
and no band image carries a transform.

**Vertical rhythm.** Every gap between blocks measures **158–159px at 1440 —
exactly one `--scene`.** The two that do not are correct: `ledger → plan` is 0
because the drawing declares `padding-block: 0 var(--scene)` and the ledger's own
bottom padding is the air between them, and `plan → band` is 142 because
`.c-film-band--full` declares `margin-block: calc(var(--scene) * 0.9)`.

**Navigation.** PADEL carries `aria-current="page"` and `.is-current` in both the
bar and the sheet. The sheet opens, locks the scroll, marks itself `03 Padel`,
and closes on Escape with focus returned to the toggle. The hero's cue reads
`#club`, `#club` exists, and pressing it eases to it (y = 886) and updates the
address bar. One `<h1>`; every other heading is an `<h2>`, with no level skipped.
The drawing carries `role="img"` and `aria-labelledby`.

**The build script and the page agree exactly.** 46 image files on disk, 46
requested by the rendered page, **0 requested and missing, 0 on disk and unused,
0 hatched placeholders**.

**Weight.**

| | raw | gzip |
|---|---|---|
| `padel.css` | 20 064 | **7 395** |
| `padel.js` | 11 907 | **4 129** |
| page HTML | 41 682 | **7 947** |
| the film's three stylesheets together | — | 24 017 (THE CLUB's: 24 904) |
| the film's three scripts together | — | 12 968 |

| | 1440×900 | 390×844 |
|---|---|---|
| First contentful paint | 164 ms | 120 ms |
| Largest contentful paint | 1 196 ms | 1 180 ms |
| Transferred, 3.5 s after load | **2.45 MB** | **1.40 MB** |

Of the first screen, **1.74 MB at 1440 and 787 KB at 390 is the hero film**,
which is fetched only after `load`, only when motion is welcome, only off a
metered connection, and at the narrow encode below 900px. Without it the first
screen is 0.71 MB and 0.61 MB.

**Video, by scene.** Four sequences, 7.1 MB on disk including the hero's narrow
encode, and **a reader never holds more than three at once** — measured across
thirty-one scroll positions at both widths.

**The two bands that do not move are given a camera, and only those two.**
Measured: `padel/club-park` and `padel/park-night` scale 1.000 → 1.070 across
their own travel; all four sequence bands stay at 1.000. `padel.js` decides
which is which by asking whether the band has a `[data-band-video]` at all, so
the day one of them becomes a sequence the job stops touching it without being
edited.

**The drawing.** Twelve stroked shapes and nineteen annotations, in six steps,
in the order somebody would draw them: the boundary, the two strips, the four
courts, what is marked on a court, the dimension across the top, and then the
numbers and the words. The whole sheet stands inside about two and a half
seconds, after which `padel.js` clears the dash properties and takes
`html.is-drawing` off again — so `will-change` on forty elements lasts as long
as the animation and not as long as the page.

---

## 8. Limitations

1. **The hero and scene 05 are the same two files under different names.** The
   swap is documented in §3 and in the build script, and it means the git
   history of `media_src/MOTION/padel/` is not the order they were generated in.
2. **Three of the four sequences are two steps from a reference, not one, for
   two of them.** `pad-courts` and `pad-social` descend through a GPT Image 2
   still. Recorded in the build script's `SEQUENCES` table.
3. **Seedance reframes, even from a 16:9 start image.** All four outputs are
   synthesised video and all four are `generated`; what a frame contains after
   the first is the model's, drawn from the vocabulary of the reference.
4. **`padel/world-events` ships at 640 and no higher.** `pavilion_1.jpg` is
   1637×961 and a 4:5 cut of it is 769 across; nothing on this site is upscaled,
   so the 960 rung is skipped. It is the only tile on the page with one rung, and
   it is the only `photo` on the page.
5. **Two of `padel.css`'s legibility fixes belong in `home.css`.** The foot on
   the hero scrim and the wash behind the scroll cue are the fix for THE CLUB's
   own straggler (`docs/THE_CLUB.md` §8.4), held here as page-local overrides
   because that component is the approved Main Page's. When the Main Page is
   next opened, both belong in `home.css` §6 and the overrides here should come
   out.
6. **`film-world` prints no honesty mark and this page is the first where that
   costs something.** Its eight tiles on the Main Page are all `render` and none
   of them says so; here the four tiles are three `render` and one `photo`, and
   the difference between them is invisible to a reader. `mark_for()` exists and
   five components call it — `film-band`, `film-plates`, `film-walk`,
   `film-detail`, `film-dialogue` — and `film-world` is the sixth that should.
   Adding the branch changes the Main Page's markup, so it was not added here.
   The tiles are wayfinding thumbnails rather than claims about rooms, which is
   the reason this is a limitation and not a defect, but it is the next thing to
   fix in that component.
7. **The hero's poster carries no mark**, and it is `generated`. ~~That is
   true of all four film pages and is `film-hero.php`'s own shape; the alt text
   describes what the picture is, and the first thing under the hero on this
   page is a band that does print "Visualisation".~~ **Overtaken:** no element
   on any page prints a mark now (ARCHITECTURE §11), so this is no longer an
   inconsistency between the hero and the bands below it. The alt text still
   describes what the picture is.
8. **THE ESTATE still wants THE CLUB's two fixes and still has not been given
   them.** Unchanged by this work, and repeated here so it is not lost:
   `docs/THE_CLUB.md` §8.5.
9. **`estate.css`'s walk is dead weight on this page** — about three hundred
   lines this page never draws. §4 explains why it is cheaper than the
   alternative; it stops being free if a fifth film page also has no walk.
10. **The 21:9 panorama is a desktop picture.** Below 900px the frame becomes 3:2
   and the image is cropped to it, held left so the clubhouse and its sign stay
   in the window — which shows about 43% of a picture whose whole point is its
   width. A phone reader does not see the whole range in one frame; they see
   the clubhouse and two of the courts, and the courts scene four screens later.
11. **`PRIVATE_CLUB_ECOSYSTEM/11.jpeg` is unused and should not be.** §2 explains
   why: the one panel worth having is 290px tall inside an identity board. A
   re-export of that panel on its own is the cheapest picture this page could
   still gain.
12. **Latvian is not written.** `content/lv/padel.php` does not exist, as for
    every other page. The route is already in `routes.php`, and every string the
    drawing prints is in the content file precisely so that the SVG never has to
    be opened for it.
13. **`tools/weigh_assets.sh` is still broken** and was broken before this work —
    it references `assets/js/home-atmosphere.js`, which does not exist. Not
    touched, because it is the Main Page's tool.

---

## 9. Two things worth reading the code for

### Why the plan's discs were the wrong colour, and the one line that fixed it

`home.css` §2 declares `--bg: var(--ground)` on `[data-mood="night"]`, which is
the `<body>`. Custom properties substitute **at the point of declaration**, so
`--bg` computes there, once, against the root ground — and every act inherits
that one computed value however dark or warm its own ground is.

Nothing on THE ESTATE or THE CLUB reads `--bg`, so it never mattered. On this
page the plan does: `.c-plan-padel__disc` and `.c-plan-padel__crest-ground` are
filled with it, because their job is to knock a hole in the line underneath them.
On mahogany, ten near-black holes — six discs and four crest grounds.

```css
.c-act { --bg: var(--ground); }
```

One line, declared on the element whose `--ground` is the one that matters. It
is not a workaround; it is where that binding should have been.

### A band that has no film gets a camera, and it is a query rather than a list

Four of this page's six bands are sequences and two are photographs — and the two
are the ones carrying the argument rather than the atmosphere: the whole complex
seen from the park, and the park itself at night. On a page where every other
full screen has a camera in it, a photograph that does not move reads as a
picture that failed to load.

`padel.js` gives those two the only camera move a still can honestly have — a
very slow scale, scrubbed to the scroll, seven percent across the band's whole
travel, which is the walk's own vocabulary. Which bands they are is not written
down anywhere:

```js
if (band.querySelector('[data-band-video]')) return;   // it already moves
```

`film-band.php` renders the `<video>` only when the encode is on disk, so *"the
bands that do not already move"* is a fact about the DOM rather than a list to
keep in step with the content file. The day one of them becomes a sequence, this
job stops touching it and nobody has to remember why.

**And `cover` is what makes it safe.** The still is `object-fit: cover` inside a
frame with `overflow: clip`, so scaling it up can only ever crop and can never
show an edge — which is also why the harness reports the image as "overflowing"
at every width and the page reports `overflow-x: 0`.
