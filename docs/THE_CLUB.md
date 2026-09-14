# Majori Manor — THE CLUB

**The third page cut from the Main Page's film, and the first one that is
indoors from the first frame to the last.** Everything below is what was built,
what it was built from, and the decisions worth arguing with.

Read it with `public_html/content/en/club.php` open beside it. That file is the
page: every act, every scene, every ratio, every sentence and every picture is
declared there, and nothing on THE CLUB can be changed anywhere else.

---

## 1. What it is

One page, ten scenes, six acts, read top to bottom as an evening in a house.

| | Scene | Act / ground | Carries |
|---|---|---|---|
| 00 | **The arrival inside** | park · green | The hall at night, moving toward the lit doors — full screen |
| 01 | **The house** | park | *A house, used as a house.* |
| 02 | **One room leads to the next** | heritage · mahogany | The enfilade: two open doors and the room through one of them |
| 03 | **The rooms** | heritage | Six rooms, one sticky viewport, scroll-scrubbed |
| 04 | **The details** | interior · deepest | Six close frames, panned sideways |
| 05 | **Dining & gatherings** | park · green | *A table that runs long* — full bleed, moving |
| 06 | **The members' room** | evening · wine | *A quieter room.* — inset, and deliberately small |
| 07 | **A house of dialogue** | evening | Four ideas over one changing room |
| 08 | **The people** | estate · near-black | Three frames and not one face |
| 09 | **Belonging** | estate | *The house, and the people in it.* |

**It opens on the green, and THE ESTATE does not.** The Main Page holds one
ground from first screen to last. THE ESTATE moves through six and starts
near-black at the gates. This one starts where that page ended — already inside,
with the park on the other side of the glass — so it opens on the seal's green,
goes to mahogany where the woodwork is, to the darkest ground for the details,
back to green for the table, to wine for the members' room and the dialogue, and
closes on near-black. Every one of those five is declared in `estate.css` §1 and
not one of them is new. The brief's rhythm — *deep green → mahogany → dark
interior → deep green → wine → near-black* — is what that is.

**There is less prose than there was.** The version this replaces ran to about
640 words of body copy; this one runs to about 380. The heading *A house, used
as a house*, the line *A table that runs long*, the members' room's two
sentences and the closing *The house, and the people in it* are all the previous
page's, kept word for word. What was cut is every sentence that was describing a
room because there was no picture of it.

**No sentence carries an unsettled fact.** No room count, no size, no date, no
opening hour, no menu, no price, no membership term, no named person. Not one
digit appears in the copy. Nothing about the rebuild settled a single fact, so
the forbidden list at the top of the content file is the one that was already
there.

---

## 2. The asset audit

All twelve directories of `media_src/` were inspected again. **The library has
grown since THE ESTATE was built**, and the growth is the reason this page looks
the way it does:

| Directory | Files | Kind | Used here | Used on /the-estate |
|---|---|---|---|---|
| `interiors/` | **15** (was 4) | photographs | **9** — of the eleven new ones | 4 — interiors_1…4 |
| `HOUSE_OF_DIALOGUE/` | 3 | visualisations | **3** — all of them | 0 |
| `PRIVATE_CLUB_ECOSYSTEM/` | 12 (was 11) | visualisations | **2** — 4 and 5 | 0 |
| `RESTAURANT/` | 7 | visualisations | **3** — dining_salon, grand_dining_room, private_dining_room | 0 |
| `CIGAR_HOUSE/` | 9 | visualisations | **3** — vip_room, main_bar, outdoor_terrace | 0 |
| `estate/` | 4 | photographs | 0 | 3 |
| `grand-staircase/` | 4 | photographs | 0 | 3 |
| `heritage-details/` | 3 | photographs | 0 | 3 |
| `ESTATE_and_HOSPITALITY/` | 7 | visualisations | 0 | 0 |
| `pavilion/` | 3 | photographs | 0 | 0 |
| `Majori_logo/` | 18 | brand | **2** — seal-cream, seal-gold | 2 |
| `MOTION/` | — | the built sequences | its own | its own |

### The eleven photographs, and why they matter more than anything else here

`media_src/interiors/interiors_5.png` … `interiors_15.png` are **eleven
high-resolution photographs of the restored interior that no page has ever
shown** — 2336×1744 each, taken after THE ESTATE was built. They are not the
bare shell that page documents. They show red damask above walnut dado
panelling, herringbone parquet, brass chandeliers and sconces already lit, a
white marble chimneypiece with the staircase standing in the mirror over it, a
glazed stove portal, an antique gilt settee and chairs, and a plaster ceiling.

**THE ESTATE is built from `interiors_1…4`, `grand-staircase/` and
`heritage-details/`. THE CLUB is built from nine of the eleven.** The two pages are the
same house and share not one frame — which is the same division the Main Page
and THE ESTATE made along a different line, and it means neither page ever shows
the reader a picture they have already seen.

### What was deliberately not used

- **`ESTATE_and_HOSPITALITY/` in its entirety.** Its bar, its cigar lounge, its
  reception and its suites are the Main Page's scenes 01, 05 and 06. A page
  about the rooms of the manor house does not need the guest house.
- **`CIGAR_HOUSE/cigar_lounge`, `whisky_lounge`, `whisky_collection`,
  `humidor_display`, `atmospheric_details`.** `/after-dark` owns *Cigar &
  Whisky* and has not been built yet; taking its best frames now would leave it
  with nothing to open on. `vip_room` is used here because it is a private
  members' room before it is a cigar room and nothing in the frame is a cigar.
- **The two annotated floor plans** — `CIGAR_HOUSE/building-concept.png` and
  `RESTAURANT/restaurant_1st_floor.png`. The right material for a page about
  the plan and the wrong material for a film.
- **`PRIVATE_CLUB_ECOSYSTEM/1, 2, 3, 7…12`** — padel, the dome, the gym, the
  garden pavilion, the brand board and the golf cart. Every one belongs to
  `/padel` or `/events`.
- **`interiors_8` and `interiors_9`** — two of the eleven, and the only two.
  Both are the stairwell and the landing from angles `interiors_10` and the
  detail track already cover; `interiors_8` in particular is the same winder
  stair from a metre further back.
- **`estate/`, `grand-staircase/`, `heritage-details/`, `pavilion/`.** THE
  ESTATE's, and the exteriors are the wrong temperature for a page that never
  goes outside.

Nothing was excluded for quality.

---

## 3. What was generated, and from what

**Two stills and four sequences.** Every one descends from a file in
`media_src/`, and the descent is recorded in `tools/photos/build_club_media.py`
and repeated below.

### Stills — GPT Image 2, 2K, 16:9, from a reference

| Output | From | What changed |
|---|---|---|
| `media_src/MOTION/club/still-threshold.png` | `interiors/interiors_6.png` | **The hour, and nothing else.** Evening: the windows are night, the chandelier and the sconce are lit, the rooms beyond the glazed doors are lamplit. Every element preserved — the glazed timber double doors and their leaded panes, the panelled overdoor bay, the staircase at the left, the built-in bench, the chequered marble, the white chimneypiece and its mirror at the right. |
| `media_src/MOTION/club/still-great-hall.png` | `interiors/interiors_5.png` | **The hour, and one fire.** Same room from the other side: the marble chimneypiece, the mirror over it with the staircase in it, both sconces, the gilt chandelier, the panelled overmantel bay, the open door to the lit corridor at the right, the glazed door at the left. |

**One thing was added and it is named here: a low fire in the fireplace of
`still-great-hall`.** The prompt asked for the hour to change and nothing else,
and it asked for the fire — the hearth is empty and cold in the photograph. It
is a fire in a fireplace that exists, in the position that fireplace is in, and
it is the single element on this page that is in a picture and not in the
building on the day it was photographed. Everything downstream of that still —
the `club-hall` sequence, its poster, walk station 01 — carries **"Generated
image"** for exactly this kind of reason.

Both prompts were written as **preservation instructions**: they name the
architecture, the joinery and the materials of that specific photograph, then
the one thing that may change, and then a list of what may not appear — people,
signage, lettering, new doors, new windows, new furniture, any redesign of the
room. **Both prompts are recorded verbatim in
`tools/photos/build_club_media.py`**, above the `SEQUENCES` table, for the reason
`tools/motion/build_sequences.sh` gives: a prompt is the only part of a generated
asset that cannot be recovered by looking at it.

### Sequences — Seedance 2.0, 720p, 16:9, no audio, 5s

| Sequence | Started from | Motion |
|---|---|---|
| `club-arrival` | `interiors_6` → `still-threshold` | Slow dolly across the hall toward the glazed doors |
| `club-hall` | `interiors_5` → `still-great-hall` | Slow push toward the chimneypiece, the fire alight |
| `club-dining` | `RESTAURANT/dining_salon.png` | Slow dolly through the salon, candle flames moving |
| `club-members` | `CIGAR_HOUSE/vip_room.png` | Very slow push to the hearth, firelight on leather |

Every prompt is a preservation instruction of the same shape, and the negative
half does the work: *no people, no new furniture, doors, windows or objects, no
redesign, no camera shake, no zoom snap, no lens flare, one continuous shot, no
cuts.* All four are recorded verbatim in `tools/photos/build_club_media.py`
beside the two above.

**The loop is a palindrome and that is not a shortcut.** Each of the four is a
single continuous move that never returns to where it started, so a hard cut
back to frame 0 jumps — and on a shot this slow the jump is the only thing in it
that moves quickly. Each plays forward and then backward, seamless by
construction. This is `tools/motion/build_sequences.sh`'s filter, verbatim,
because it is the Main Page's answer to the same problem and there is no reason
for two. It is also why the four encodes are ten seconds long and about twice
the bytes of a one-way cut.

### The honesty marking

| marking | count | what it is here |
|---|---|---|
| `photo` | 10 | Crops of nine supplied photographs. Graded (see §5), never upscaled, nothing added. |
| `render` | 9 | The project's own visualisations. Every one prints "Visualisation". |
| `generated` | 4 | The four sequences and their posters. Every one prints "Generated image". |
| `mood` | **0** | — |

Twenty-three pictures, plus the two seals and the footer lockup — twenty-six
images on the page.

**THE CLUB is the first page on the site to carry three of the four at once**,
and the first to carry none of the fourth. The version it replaces was eight
hatched boxes, every one of which was going to be a `mood` reference image —
atmosphere standing in for a room that could not be shown. There is nothing left
for that value to do here: the rooms can be shown, the ones that cannot be
photographed are visualised and say so, and a reference image on a page this
specific would be the only picture on it making no claim at all.

`mark_for()` in `app/helpers.php` is where the rule lives now, and four
components read it. A content file cannot switch a label off.

---

## 4. What was built, and what was reused

**Reused unchanged from the two approved pages:** `film-hero`, `film-band`,
`film-chapter`, `film-plates`, `film-invitation`, `film-walk`, `film-nav`,
`film-footer`, the whole of `home.css` and `home.js`, and the whole of
`estate.css` and `estate.js` — the tokens, both faces, the grain, the
navigation and its active state, the six act grounds, the sticky walk, the seven
motion jobs and the reveal states.

**`head.php` now lists three film pages, and THE CLUB's row loads THE ESTATE's
files before its own.** `estate.css` is not "the estate page's stylesheet"; it
is the second layer of the film — the acts, the walk and the ledger — and THE
CLUB is a page of acts with a walk in it. Copying those into a third file is how
two pages meant to be the same house begin to drift, and a rename was not
available: `asset_url()` cache-busts on `filemtime`, so touching either estate
file at all would re-version the stylesheet in the approved page's markup.

**New, and only what the two pages before it have no use for:**

| File | What it is |
|---|---|
| `components/film-detail.php` | The lateral track: a row of close frames panned by scroll |
| `components/film-dialogue.php` | Four ideas over one changing room |
| `partials/film-acts.php` | The act loop, so a third page did not copy it a second time |
| `assets/css/club.css` | The two components, one hero subtraction, three legibility overrides, the mobile pass |
| `assets/js/club.js` | Three jobs: the track, the dialogue, and holding the walk's films |
| `tools/photos/build_club_media.py` | The crop, grade, encode and poster table |
| `docs/THE_CLUB.md` | This file |

**Shared files were touched and none of them changed a byte of any other page**
(proved in §7):

- `app/helpers.php` — **`mark_for()` is new.** Three components were writing the
  same rule out separately and one had only half of it: `film-band` and
  `film-plates` labelled `render` and `generated`, and `film-walk` labelled
  `generated` alone — so the first walk station that was a visualisation would
  have gone out unmarked, and THE CLUB has two. The rule now lives once, beside
  the list it reads.
- `components/film-band.php`, `film-plates.php` — now call `mark_for()` instead
  of restating it. Output is byte-identical on every existing page.
- `components/film-walk.php` — the same, which is the fix: a `render` station is
  labelled now.
- `partials/head.php` — the film-page table gained a third row. The other two
  rows are unchanged.
- `tools/compare_pages.sh` — the page allowed to differ is an argument now
  instead of the string `home`, and it still defaults to `home`.

`templates/pages/estate.php` still carries its own copy of the act loop. That is
a decision rather than an oversight: THE ESTATE is approved, its output is proved
byte-identical after this work, and the cheapest way to keep that true was not to
open the file. The two copies are the same fifteen lines; when a fourth film page
arrives, `estate.php` should require the partial and the snapshot harness will
prove nothing moved.

---

## 5. The grade, and why the photographs needed one

**The supplied photographs were taken at noon and this page is an evening.**
Every one of the eleven is a bright, even, documentary frame with daylight in the
windows — exactly right for a record of a building, and half a stop wrong on a
near-black ground beside a Seedance interior lit by its own chandeliers. Dropped
into the walk unaltered they do not read as the same house at the same hour; they
read as a different photographer.

So the pictures are taken down rather than the ground brought up. The curve is
the one `build_estate_media.py` uses on its hero — about eight percent off the
highlights and five off the midtones — applied through a 256-entry LUT in
`build_club_media.py`. It is a grade and not a re-lighting: the windows stay
windows, the white marble stays white, and nothing in any frame changes shape.

**Two frames get more, and it is because of what is in them.** `interiors_11`
and `interiors_13` are the two photographs with a full bay of untreated daylight
— a window wall and an open door onto a lit room — and at the standard curve they
still arrived a stop brighter than the frames either side. They are pulled
further rather than everything being pulled with them; a curve strong enough for
those two would have taken the fire out of the stove room.

**One visualisation is graded and only one.** `club/dialogue-capital`
(`grand_dining_room`) is the single picture in the dialogue lit like a ballroom,
and the dialogue stands four lines of cream type over it. The renders were made
dark; grading them again closes them up, so the others are untouched.

---

## 6. Legibility, measured

Type standing on a photograph is the one thing on this page that cannot be
settled by eye. Every measurement below was taken on the rendered page, against
the **95th-percentile brightest background pixel each element crosses**, with the
type hidden so it is not sampled as its own background, an element skipped unless
it is fully on screen and clear of the fixed bar, and effective opacity walked up
the ancestors so a faded-out walk station is never measured.

**Five things had to change and every one of them is a number, not a taste.**

| # | Where | Before | After | What changed |
|---|---|---|---|---|
| 1 | Hero eyebrow, gold, 0.7rem | **3.34** | 4.98 | `club.css` §1 — the hero band, which starts as a *subtraction* from `estate.css`'s and was then brought back up in the middle third |
| 2 | Hero scroll cue, on the way out | **4.29** | 4.7–11.8 | The hero scrim no longer reaches transparent at its foot; the film parallaxes and takes the scrim with it |
| 3 | Walk legend — the gold number and the "Visualisation" mark, over the library and the private dining room | **3.10 / 2.57** | 6.3–8.2 | `club.css` §1b — the mark goes from `--ink-faint` to `--ink-muted`, and the walk's own scrim is deepened for this page's brighter stations |
| 4 | Band overlays — the eyebrow and the scene number on the dining salon and the members' room | **2.04 / 1.30** | 5.5–8.5 | `club.css` §1c — the copy box carries its own gradient, and the scene number goes to `--ink-muted`. The members' room is the first inset band on the site to carry an overlay at all |
| 5 | Dialogue — the number and its mark at 390px | **4.04** | 6.9–8.4 | `club.css` §3 — one step up, plus a scrim that turns through ninety degrees in a portrait window |

**Result, swept across the whole page at 375, 390, 430, 768, 1024, 1440 and
1920** — every text element on the page, sampled at 16–24 scroll positions each:

| Width | elements measured | below 4.5:1 |
|---|---|---|
| 375×812 | 32 selectors | 1 · the cue at 4.47, mid-exit |
| 390×844 | 32 | 1 · the cue at 4.47, mid-exit |
| 430×932 | 32 | 0 |
| 768×1024 | 32 | 0 |
| 1024×768 | 32 | 1 · the cue at 4.46, mid-exit |
| 1440×900 | 32 | 0 |
| 1920×1080 | 32 | 0 |

The one straggler is **"Come in"** at 4.46–4.47, three hundredths under AA, and
only at the moment the hero is more than ninety percent scrolled away and the
parallax has slid the film out from under its own scrim. At rest it measures
5.1–11.8 at every width. It is recorded in §8 rather than fixed, because the
only remaining lever is the shared hero component the Main Page is approved on.

The gold **Apply for membership** button reports 1.1 in the sweep and that is the
harness, not the page: hiding an element to sample its background hides its own
gold fill, so the near-black label is measured against the section's ground.
Against the fill it actually stands on it is **8.63:1**.

---

## 7. Verification

Everything below was run against `php -S` with `tools/serve_router.php`, in
headless Chrome, with real wheel events so Lenis drives the scroll.

**Nothing else on the site moved.**

```
tools/compare_pages.sh club-before club-final club

after_dark  IDENTICAL     membership  IDENTICAL(t)
club        CHANGED*      notfound    IDENTICAL
components  IDENTICAL     padel       IDENTICAL
contact     IDENTICAL(t)  privacy     IDENTICAL
estate      IDENTICAL     residences  IDENTICAL
events      IDENTICAL     styleguide  IDENTICAL
home        IDENTICAL     terms       IDENTICAL
```

The Main Page and THE ESTATE are **byte-identical with no masking at all** —
including the `?v=` cache-busting query on every asset, which is the proof that
not one shared file either of them loads was modified. `(t)` is `/contact` and
`/membership`, identical but for the per-request form-time token they mint on
every render by design.

**Rendering.**

| Width | doc height | walk | track | dialogue | overflow-x | broken images | console |
|---|---|---|---|---|---|---|---|
| 375×812 | 14 066 | stage | grid | stage | 0 | 0 of 26 | clean |
| 390×844 | 14 419 | stage | grid | stage | 0 | 0 of 26 | clean |
| 430×932 | 15 309 | stage | grid | stage | 0 | 0 of 26 | clean |
| 768×1024 | 17 793 | stage | grid | stage | 0 | 0 of 26 | clean |
| 1024×768 | 16 562 | stage | **track** | stage | 0 | 0 of 26 | clean |
| 1440×900 | 20 216 | stage | **track** | stage | 0 | 0 of 26 | clean |
| 1920×1080 | 23 427 | stage | **track** | stage | 0 | 0 of 26 | clean |

No console errors, no page errors, no failed requests, no 4xx, and no horizontal
scroll at any width.

**Fallbacks.**

| Mode | classes set | walk frames hidden | track frames hidden | dialogue rooms hidden | dialogue lines hidden | libraries fetched | images |
|---|---|---|---|---|---|---|---|
| normal | `motion is-revealing is-walking is-tracking is-dialogue` | 5 of 6 | 0 | 3 of 4 | 3 of 4 | 4 | lazy |
| **JavaScript off** | *none* | **0 of 6** | **0 of 6** | **0 of 4** | **0 of 4** | **0** | 26 of 26 loaded, 0 broken |
| **reduced motion** | `has-js` | **0 of 6** | **0 of 6** | **0 of 4** | **0 of 4** | **0** | lazy |

With JavaScript off the page is a complete 18 391px document: six captioned
rooms, six captioned details in a three-column grid, four captioned ideas each
with its own line, the plates, the invitation and the footer. Under
`prefers-reduced-motion` not one library byte is fetched.

**Vertical rhythm.** Every gap between sections measures **158–159px at 1440 —
exactly one `--scene`.** The two that do not are correct: `walk → detail` is 0
because the detail section carries its own `--scene` of padding, and
`detail → band` is 143 because `.c-film-band--full` declares
`margin-block: calc(var(--scene) * 0.9)`.

**Navigation.** THE CLUB carries `aria-current="page"` and `.is-current` in both
the bar and the sheet. The sheet opens, locks the scroll, marks itself `02 The
Club`, and closes on Escape with focus returned to the toggle. The hero's cue
reads `#house`, `#house` exists, and pressing it eases to it and updates the
address bar.

**The build script and the page agree exactly.** 49 image files on disk, 49
requested by the rendered page, **0 requested and missing, 0 on disk and unused,
0 hatched placeholders**.

**Weight.**

| | raw | gzip |
|---|---|---|
| `club.css` | 29 509 | **8 938** |
| `club.js` | 14 050 | **4 627** |
| page HTML | 43 016 | **7 593** |

| | 1440×900 | 390×844 |
|---|---|---|
| First contentful paint | 112 ms | 136 ms |
| Largest contentful paint | 1 176 ms | 1 184 ms |
| Transferred, 3.5 s after load | **2.36 MB** | **1.28 MB** |

The hero's poster is 95 KB WebP at 1280 and 44 KB at 768. The hero film is
1.55 MB wide / 615 KB narrow and is fetched only after `load`, only when motion
is welcome, only off a metered connection.

**Video, by scene.** Four sequences, 6.2 MB on disk, and **a reader never holds
more than three at once** — measured across forty scroll positions at 1440. The
first screen fetches **one**: see §9.

---

## 8. Limitations

1. **`still-great-hall` lights a fire that was not burning.** Stated in §3, and
   it is the one addition on the page. Everything downstream of it is labelled
   "Generated image".
2. **The four sequences are two steps from a photograph, not one, for two of
   them.** `club-arrival` and `club-hall` descend through a GPT Image 2 still.
   Recorded in the build script's `SEQUENCES` table.
3. **Seedance reframes.** All four sources are 1.12–1.69 and all four outputs are
   16:9; what fills the new width is synthesised from the vocabulary of the
   source. That is why all four are `generated` and not `render` or `photo`.
4. **"Come in" measures 4.46–4.47 at three widths during the hero's exit**, three
   hundredths under AA, at a moment the reader is not reading it. §6. Fixing it
   properly means changing where `home.css` puts the cue relative to the scrim
   the film parallaxes, and that component is the Main Page's.
5. **THE ESTATE wants two of this page's fixes and has not been given them.**
   Its walk mark is `--ink-faint` over its own stations, and `estate.js` attaches
   the first two stations' films at boot — which on THE ESTATE means 645 KB of
   `est-hall.mp4` on the first screen. Both are held here by overrides in
   `club.css` and `club.js` rather than by editing the approved files. When THE
   ESTATE is next opened, both belong in `estate.css` and `estate.js` and the
   overrides here should come out.
6. **`interiors_8` and `interiors_9` are unused**, and they are the only two of
   the eleven new photographs no page shows. Both are the stairwell from angles
   the detail track already covers.
7. **The lateral track is desktop-only.** Below 900px `club.js` does not take the
   stage at all and the six frames are two columns of captioned figures. That is
   the mobile design rather than its fallback — §5 of `club.css` — but it does
   mean the page has one fewer camera move on a phone.
8. **The dialogue prints one line at a time on the stage.** All four names are
   always on screen and scrolling reaches every line, and the grid it becomes
   without JavaScript prints all four at once — but a reader who never scrolls
   past the first idea sees only the first line.
9. **Latvian is not written.** `content/lv/club.php` does not exist, as for every
   other page. The route is already in `routes.php`.
10. **`tools/weigh_assets.sh` is still broken** and was broken before this work —
    it references `assets/js/home-atmosphere.js`, which does not exist. Not
    touched, because it is the Main Page's tool.

---

## 9. Two things worth reading the code for

### The dialogue's stacking

In stage mode the four pictures are lifted out of the flow to fill the viewport
and the type stands over them with a scrim in between:

```
.c-dialogue__img     absolute, z-index 0 (1 while it is arriving)
.c-dialogue__scrim   absolute, z-index 5
the three type lines             z-index 6
```

The type's z-index is set on the **leaves** and on nothing above them, because
any ancestor of a picture that takes a z-index becomes a stacking context and
carries that picture up with it — the type would win and the photograph would
print on top of the scrim meant to hold it down. The leaves are grid items, and
z-index applies to a grid item without `position: relative`, which is what lets
`__item`, `__list` and `__inner` all stay static and out of the way.

**The numbers are not adjacent on purpose.** `club.js` lifts an arriving picture
to z-index 1 so it fades in *on top* of the one it is replacing rather than
cross-dissolving through the ground. The scrim was 1 as well for one revision,
and since the pictures come later in the DOM, the arriving room printed itself
over the very thing holding it down.

**And a grid item with auto inline margins is not stretched**, it is shrunk to
fit and centred: auto margins absorb free space before alignment gets a look at
it. `.c-dialogue__inner` carries `margin-inline: auto` for the block layout it
has everywhere else, and the moment the stage became a grid that margin collapsed
the whole column of type to the width of its longest line and parked it in the
middle of the window. `inline-size: 100%` puts it back.

### Holding the walk's films

`estate.js` attaches the first two stations' films the moment it paints the
stage, and it paints the stage at boot — before any trigger exists, so a reader
whose setters do not work is looking at a room rather than a black rectangle.
That is the right call and it has a cost this page is the first to pay: THE
ESTATE's first station is a photograph, and **THE CLUB's first station is a
1.5 MB sequence**. Measured on the first screen, `club-hall.mp4` was arriving
beside the hero — 3.1 MB of video for a reader who had not scrolled.

`club.js` §3 takes the `data-src` attribute off every walk video at boot and
gives it back half a screen before the walk. `estate.js` skips a station with no
`data-src` in both directions — it neither attaches nor releases one — so
removing the attribute is a complete and side-effect-free way to say *not yet*.
The two stations it would have chosen are attached by hand on the way in, because
its own `land()` only re-attaches on a **change** of station and the station it
is standing on has not changed.

Measured: first-screen transfer **3.75 MB → 2.36 MB** at 1440, and
**1.28 MB** at 390 on the narrow encode.
