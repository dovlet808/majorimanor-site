# Majori Manor — EVENTS

**The fifth page cut from the Main Page's film, and the first whose hero is a
photograph.** Everything below is what was built, what it was built from, and
the decisions worth arguing with.

Read it with `public_html/content/en/events.php` open beside it. That file is
the page: every act, every scene, every ratio, every sentence and every picture
is declared there, and nothing on EVENTS can be changed anywhere else.

---

## 1. What it is

One page, nine scenes, six acts, read top to bottom as one continuous evening.

| | Scene | Act / ground | Carries |
|---|---|---|---|
| 00 | **The arrival** | — | The lit pavilion from the air at night — full screen, moving, and it is real footage |
| 01 | **The pavilion** | park · green | *A glass room in the park.* — the same place in the afternoon |
| 02 | **Day into dusk** | heritage · mahogany | *And then the light goes.* — one shot, afternoon to night, and the five settled facts under it |
| 03 | **The gathering** | interior · deepest | *Where the evening begins.* — the lawn, the strung lights, the first half hour |
| 04 | **The table** | heritage · mahogany | *A table that runs long.* — the house's own dining rooms |
| 05 | **The estate** | estate · near-black | *The estate is part of it.* — the frame the hero was descending toward |
| 06 | **The celebration** | evening · wine | *And the evening keeps going.* — inside the lit dome |
| 07 | **Six kinds of evening** | evening | Six rooms behind one list of names |
| 08 | **The estate** | evening | Four places, four pages, one line each |
| — | **The invitation** | evening | The seal, and two ways to write |

**THE HERO IS NIGHT AND SCENE 01 IS THE AFTERNOON, and that is the structure
rather than an accident.** The first screen is where the evening ends up; the
film then goes back to the beginning of the day and walks forward to it. PADEL
opens after sunset and puts its one daylight picture in act three for the same
reason. Scene 05 is the frame the hero film is descending toward, which is where
the loop closes: the reader sees the whole scene from the air at the top of the
page and again, still, five scenes later, having walked through it.

**It adds no component.** THE ESTATE brought the walk and the ledger; THE CLUB
brought the lateral track and the dialogue; PADEL brought none. This page is
built entirely out of what those four already approved — `film-hero`,
`film-band`, `film-chapter`, `film-ledger`, `film-plates`, `film-dialogue`,
`film-world`, `film-invitation`, `film-nav`, `film-footer` and the act wrapper.

**It is the second page to set the dialogue and the third to set the ledger.**
THE CLUB uses the dialogue for four ideas over one room; here it is six kinds of
evening over six rooms, which is what the brief asks for when it rules out a
grid of service cards in as many words.

**There is less prose than there was.** The version this replaces ran to about
480 words of body copy and described a building. This one runs to about 300 and
describes an evening.

**Four sentences survived word for word, because they are the approved ones:**
*A glass pavilion standing in the private park, with the estate around it for
the rest of the evening*, *It is one room. Nothing is partitioned off*, the
argument for a round building and against a hall with a door at each end, and
*A glass dome can be put up anywhere; a glass dome in the park of a 1910 manor
house in the middle of Jūrmala cannot.*

**No sentence acquired a fact.** The rebuild settled nothing, so the confirmed
list and the forbidden list at the top of the content file are the ones that
were already there: eighteen metres, about 250 m², 100–120 seated, the private
park, glass by day and a lit object by night — and no price, no package, no
catering, no availability, no equipment and no fourth number.

---

## 2. The asset audit

All twelve directories of `media_src/` were inspected again, file by file,
**and the library has not grown since PADEL was built** — the same twelve
directories and the same 110 stills in them. What this page found instead is
material four pages had walked past.

| Directory | Files | Kind | Used here | Used before |
|---|---|---|---|---|
| `pavilion/` | 3 | photographs | **all three** — 1, 2 and 3 | 1 only, once, as a 4:5 tile on PADEL |
| `MOTION/HERO/` | 2 | supplied masters | **`pavilion.mp4` — the hero** | `main-hero.mp4` is the Main Page's |
| `RESTAURANT/` | 7 | visualisations | **3** — chefs_room, dining_salon, majestic_lobby | all three elsewhere, none at these ratios |
| `ESTATE_and_HOSPITALITY/` | 7 | visualisations | **3** — reception_concierge, Restaurant_1, CIGAR_LOUNGE | reception_concierge as a sequence source only |
| `CIGAR_HOUSE/` | 9 | visualisations | **2** — atmospheric_details, vip_room | vip_room on home at 4:5 |
| `PRIVATE_CLUB_ECOSYSTEM/` | 12 | visualisations | **4** — 1, 2, 4, 6 | 1, 4 elsewhere; 2 and 6 effectively new |
| `estate/` | 4 | photographs | **1** — estate_1 | the retired non-film pipeline |
| `Majori_logo/` | 18 | brand | **2** — seal-cream, seal-gold | all four film pages |
| `interiors/` | 15 | photographs + renders | 0 | estate · club |
| `HOUSE_OF_DIALOGUE/` | 3 | visualisations | 0 | club · home |
| `grand-staircase/` | 4 | photographs | 0 | estate · home |
| `heritage-details/` | 3 | photographs | 0 | estate |
| `MOTION/` | — | the built sequences | its own | its own |

### What the audit found that four pages had missed

**`pavilion/pavilion_2.jpg` and `pavilion/pavilion_3.jpg` had never been used
anywhere.** They are the only two daylight photographs of this pavilion in
existence — the dome standing at the edge of the pine wood with a brick path
crossing the lawn and chairs set out on the grass, and the inside of the dome
laid for a dinner. PADEL's audit rejected both in one line: *"Both are broad
daylight and this page has no ground bright enough to stand them on."* That was
right for PADEL. This page is the one page on the site whose story has an
afternoon in it, and it takes them both — one graded to dusk and printed, one as
the reference for the still that opens scene 07. See §3 and §5.

**`PRIVATE_CLUB_ECOSYSTEM/2.png` was waiting for this page and says so.**
PADEL's audit: *"`2.png` is also `/events`, which has not been built."* It is an
evening reception inside a lit geodesic dome — chandelier, candles, guests in
dark evening dress — and it is the source of `ev-celebrate`.

**`PRIVATE_CLUB_ECOSYSTEM/6.png` and `ESTATE_and_HOSPITALITY/CIGAR_LOUNGE.png`
had never been used at all** and are two of the four tiles in scene 08.

**`ESTATE_and_HOSPITALITY/reception_concierge.png` had never been cut as a
still.** It is the source of the Main Page's `seq-arrival` sequence, which is
not the same thing as a picture of it — the same status PADEL gave
`RESTAURANT/dining_salon2.png`. It is scene 03's first plate.

**`CIGAR_HOUSE/atmospheric_details.png` had never been used anywhere.** It is
scene 03's second plate.

### What was deliberately not used

- **`PRIVATE_CLUB_ECOSYSTEM/11.jpeg`, the identity board**, and **`12.jpeg`,
  the club car.** PADEL's reasons hold unchanged and are in `docs/PADEL.md` §2.
- **`HOUSE_OF_DIALOGUE/1.png`, the marble hall in conversation.** It is the best
  "people talking" render in the library and it would have been scene 07's fifth
  room — but THE CLUB already sets that exact file at that exact ratio in that
  exact component (`club/dialogue-diplomacy`), and two pages showing one
  photograph in one component is one section built twice. Same reason for
  `grand_dining_room.png` and `outdoor_terrace.png`, which are THE CLUB's other
  two dialogue rooms. **Not one of this page's six is a file THE CLUB's four
  use.**
- **`interiors/`, `grand-staircase/`, `heritage-details/`.** The house's, and the
  house has two pages of its own.

Nothing was excluded for quality.

---

## 3. What was generated, and from what

**Two stills and four sequences. The hero is neither.** Every one descends from
a file in `media_src/`, and the descent is recorded in
`tools/photos/build_events_media.py` and repeated here.

### The hero is supplied footage and nothing was generated for it

    media_src/MOTION/HERO/pavilion.mp4     1280x720 · 24 fps · 8.06 s · +AAC

A real aerial shot of the real pavilion at night, descending slowly toward the
lit geodesic dome with the long event building at the right, the festoon-lit
lawn and its cocktail tables under it and the pines black behind. The brief for
this page names that file and forbids replacing it.

**Nothing replaced it and nothing was cropped out of it.** It was graded for the
copy that stands on it (§5), made into a palindrome loop, encoded at 1280 and at
854, and its own frame 0 exported as the poster. The audio was dropped with
`-an`, as it always has been on this site: the hero plays muted and unattended.
`media_src/` is untouched.

**It is the only film on the site declared `photo`**, and the only hero on the
site that is not a generation. The other fourteen sequences across five pages
are Seedance moves on visualisations; this one is a camera pointed at a building
that exists.

### Stills — GPT Image 2, 2K, high, 16:9, from a reference

| Output | From | What changed |
|---|---|---|
| `media_src/MOTION/events/still-gathering.png` | `pavilion/pavilion_1.jpg` | **The camera came down off the drone, and the guests.** Every photograph of this pavilion is an aerial; a page whose argument is that a reader can imagine their own evening here has to be able to stand them on the grass. Every object the prompt keeps — the dome and its strings of lights, the long building with its tiled roof and brick piers and arched openings, the paved path, the cocktail tables in their floor-length linen, the closed parasols, the young trees, the festoon lights on their poles, the pines — is an object already in the reference. The guests are the one addition, and they are what the brief asks for by name: in twos and threes, at a distance, seen from behind or in profile, none facing the camera. |
| `media_src/MOTION/events/still-wedding.png` | `pavilion/pavilion_3.jpg` | **The hour and the dressing, and nothing structural.** Same dome, same frame members and node connectors, same ring beam, same camera position, same arc of round tables, same long top table, same floral arch. Late evening instead of overcast noon; candles, tapers, strings of light and a brass chandelier where the mirror ball was; cream linen, dark timber chairs and ivory-and-green flowers instead of white chairs with pale blue sashes. |

**Both prompts are recorded verbatim in the build script**, above the
`SEQUENCES` table, and both are written as **preservation instructions**: they
name the architecture, the landscaping and the materials of that specific frame,
state the one thing that may change, and then list what may not appear.

**The second still is the one picture on the page that exists because a grade
could not save the photograph it came from, and that is worth reading.**
`pavilion_3.jpg` is the only photograph in existence of this pavilion in use,
the audit found it unused, and it would have been the honest choice for scene
07's first room. It is also an overcast midday interior with white chairs, pale
blue sashes and a mirror ball in it — three of the things the brief for this page
rules out by name. Three curves were tried on it, down to half the luminance of
anything else on the page, and every one produced a *murky pale-blue wedding
banquet* rather than an evening: the colours the brief rejects are properties of
the objects, not of the exposure. So the photograph became the reference and the
tile is declared `generated`. The photograph is still in `media_src/`, still
unused as a picture, and still the only one there is; if the owner ever wants it
printed as it was shot, the stem is one line in the content file.

### Sequences — Seedance 2.0, 720p, 16:9, no audio, 5 s, `start_image`

| Sequence | Started from | Motion | Scene |
|---|---|---|---|
| `ev-dusk` | `pavilion_2` → 16:9 low crop (the same crop scene 01 prints) | Late afternoon into blue hour into night; the camera barely moves and the light does all of it | **02** |
| `ev-gather` | `pavilion_1` → `still-gathering` | Slow lateral drift across the lawn among the cocktail tables, the guests turning to one another | 03 |
| `ev-table` | `ESTATE_and_HOSPITALITY/Restaurant_1.png` → 16:9 crop | Slow dolly down the dining room between the laid tables, candle flames moving | 04 |
| `ev-celebrate` | `PRIVATE_CLUB_ECOSYSTEM/2.png` → 16:9 crop | Slow forward move among the tables inside the lit dome, reflections travelling on the glass | 06 |

**`start_image` on all four, not `image_references`** — PADEL's finding, and it
holds: the reference is the first frame of the generation rather than a mood for
it, which is the only setting under which a geodesic frame, a chandelier and a
laid table survive five seconds of camera movement intact. It is also what makes
the poster honest: frame 0 of the encode *is* the reference.

**`ev-dusk` is the one sequence on the site whose subject is time.** Every other
one holds an hour and moves a camera through it. This one is asked to change the
hour while the camera barely moves, because the scene it carries is the hinge of
the page: the afternoon the reader has just been shown as a still, going over
into the evening the rest of the page is about. It is also the only place where
the still and the film are the same picture on purpose — scene 01 prints frame 0
as a photograph and scene 02 makes it get dark.

**The loop is a palindrome and one of the five pays for it.** Each sequence
plays forward and then backward, seamless by construction, which is
`tools/motion/build_sequences.sh`'s filter verbatim. On a shot whose subject is
the passage of time that means the evening runs backwards for the second half of
the loop. It is still the right filter — the alternative is a visible cut from
night back to afternoon every five seconds — and because the transition is
gradual at both ends it reads as the light breathing rather than as a rewind.
Recorded in §8.

**One sequence was trimmed rather than regenerated, and it cost nothing.**
`ev-celebrate` arrives so far forward in its last second that two of the guests
become portraits, which is the one thing the brief rules out by name. The master
keeps its five seconds; the encode takes the first 3.6 of them and the palindrome
makes a 7.2-second loop out of what is left. No credit was spent on the change.

### The honesty marking

| marking | count | what it is here |
|---|---|---|
| `photo` | **5** | The hero film and its poster, the pavilion in the afternoon, the pavilion from the air, and the real house in scene 08. **This is the only film page with a photographed hero.** |
| `render` | 11 | The project's own visualisations — the dining rooms, the lobby, the lounge, the bar, the concierge desk, the courts, the cigar room. |
| `generated` | 6 | The four Seedance sequences with their posters, and the GPT Image 2 still that is scene 07's first room. |
| `mood` | **0** | — |

Twenty pictures, plus the two seals and the footer lockup — **twenty-two images
in the markup**, of which twenty-two load and none is broken at every width
tested.

**The page this replaces carried two `mood` images and both were the same
admission**: no photograph existed of a ceremony in this park or of a dinner laid
in this pavilion. Both are now answered by pictures that descend from
photographs of this place, so there is nothing left for that value to do.

`mark_for()` in `app/helpers.php` is where the rule lives, and it still returns
the empty string for every source (ARCHITECTURE §11). The declarations are all
in the content file and nowhere else.

---

## 4. What was built, and what was reused

**Reused unchanged from the four approved pages:** `film-hero`, `film-band`,
`film-chapter`, `film-ledger`, `film-plates`, `film-dialogue`, `film-world`,
`film-invitation`, `film-nav`, `film-footer`, `film-acts`, the whole of
`home.css`/`home.js`, `estate.css`/`estate.js` and `club.css`/`club.js` — the
tokens, both faces, the grain, the navigation and its active state, the six act
grounds, the ledger, the dialogue and its stage, and the ten motion jobs.

**EVENTS is the first page to load three shared layers.** estate for the acts and
the ledger, club for the dialogue, and then its own. head.php's table says why in
full; the short version is the rule the head of `events.css` states: *a page may
add to the system and may not fork it.*

**New, and only what the four pages before it have no use for:**

| File | What it is |
|---|---|
| `assets/css/events.css` | The hero's own scrim over a lit dome, one measured legibility fix under it, the dialogue at six rooms instead of four, the hero's crop on a phone, and this page's mobile pass |
| `assets/js/events.js` | One job: a camera for the two bands that are photographs |
| `tools/photos/build_events_media.py` | The crop, grade, trim, encode and poster table, and the six prompts |
| `docs/EVENTS.md` | This file |

**Shared files were touched and none of them changed a byte of any other page**
(proved in §7):

- `templates/pages/events.php` — rewritten. Four statements, and it requires
  `partials/film-acts.php` rather than carrying a fourth copy of the act loop.
- `content/en/events.php` — rewritten.
- `partials/head.php` — the film-page table gained a fifth row. The other four
  rows are unchanged.
- `components/film-invitation.php` — **gained four lines, and losing them would
  have been a regression.** `components/cta.php` has always let a content file
  put `?subject=private-event` on the address of the closing button, and
  `form-enquiry.php` reads that, checks it against the schema's own option list
  and starts the select on it. The old `/events` did exactly that; the film's
  invitation could not, so rebuilding this page on the film would have quietly
  dropped it. The branch is additive — an action with no `query` produces the
  href it produced before — which is why the four approved pages are
  byte-identical after it.
- `tools/photos/build_images.py` — three superseded `events/*` rows removed, and
  the four stale files they had left on disk deleted with them. See §8.
- `.gitignore` — one rule, for `media_src/MOTION/events/*-frame0.png`, matching
  the three already there.

`templates/pages/estate.php` still carries its own copy of the act loop. That is
still a decision rather than an oversight, and the argument has not changed.

**EVENTS loads two stylesheets it barely draws.** `estate.css` §2 is the sticky
walk and `club.css` §2 is the lateral track — about five hundred lines between
them that this page never renders, because neither `[data-walk]` nor
`[data-detail]` is in its DOM and both jobs return on their first line. PADEL
flagged this as a limitation and said *"it stops being free if a fifth film page
also has no walk"*; this is that page, and the number is now 500 rather than 300.
It is still cheaper than the alternative — `asset_url()` cache-busts on
`filemtime`, so splitting the walk out of `estate.css` would re-version the
stylesheet in three approved pages' markup to save bytes that are already in the
reader's cache from them — but it is now the largest single piece of dead weight
on the site and it belongs in the next round of shared-file work. §8.

---

## 5. The grade, and the two curves this page had to invent

**Three curves, and this is the first page that needed more than one.**

`GRADE`, `build_club_media.py`'s own — about eight percent off the highlights and
five off the midtones — is used on three pictures. `DUSK` and `EVENING` are
deeper and they **tilt**: the blue channel comes down twelve to fifteen percent
further than the red, and the green about four.

**The tilt is the part worth arguing with.** The existing curve is neutral: one
table applied to all three channels, so a picture only gets darker. That is right
for an interior lit by candles, whose highlights are already warm. It is wrong
for an overcast northern daylight, whose highlights are blue — pulled down
neutrally, a white dome under a grey sky becomes a *grey* dome under a grey sky,
and grey is the one colour this palette does not contain.

**Which picture gets which is a measurement and not a taste.** Every plate was
exported, its mean luminance taken, and the curve chosen so that no picture in a
group arrives more than about half again as bright as the darkest one beside it.

| Slot | raw | curve | shipped |
|---|---|---|---|
| `events/pavilion-day` | 118 | `DUSK` | **41** |
| `events/pavilion-air` | 66 | `GRADE` | **62** |
| `events/kind-seasonal` | 82 | `EVENING` | **43** |
| `events/kind-corporate` | 106 | `GRADE` | **56** |
| `events/world-estate` | 110 | `NIGHT` | **36** |
| the other nine | — | none | **19 – 46** |

**`pavilion-air` carries the club grade and it is the only night photograph that
does**, for PADEL's reason at `padel/park-night`: its lawn is lit and the bands
either side of it are a dining room and a night sky, so at its own exposure it
arrives as the brightest full screen on the page.

**One sequence carries a grade at encode and it is the same decision.**
`events/pavilion-day` is the still of scene 01 and `ev-dusk` is the film of scene
02, and the film starts from the identical crop, ungraded. Print the plate at
`DUSK` and leave the film alone and the page **brightens** as it goes from the
first scene to the second — the one thing this film may not do. So the encode
carries the curve the plate carries, in ffmpeg's terms rather than Pillow's, and
the two were matched by measurement: mean luminance 41.4 for the plate against
45.8 for frame 0 of the encode, which is inside the eleven percent at which a
reader cannot see a step. It is a uniform curve over a shot whose subject is
changing light, which is deliberate — taking the same amount off every frame
moves the whole shot down and leaves the transition inside it as generated.

**The hero carries one too, and that is a legibility requirement rather than a
look.** `docs/ASSET_MANIFEST.md` says the same thing about the earlier cut of
this footage: the lit dome sits directly behind the hero copy and ungraded the
eyebrow measures well under AA against it. `HERO_GRADE` holds the blacks, stops
short of clipping the strings of lights inside the dome, and is applied at encode
time. The master in `media_src/` is untouched, which is what the brief asks for
in as many words.

---

## 6. Legibility, measured

Type standing on a photograph is the one thing on this page that cannot be
settled by eye. Every measurement below was taken on the rendered page against
the **95th-percentile brightest background pixel each element's letters
actually cross**, with the glyphs made transparent so they are not sampled as
their own background, an element skipped unless it is fully on screen and clear
of the fixed bar, effective opacity walked up the ancestors, and the page driven
by real wheel events so Lenis moves it exactly as a reader does.

**Two refinements to the harness, and both changed the answer.** Hiding an
element with `visibility: hidden` takes its own background and pseudo-elements
with it — which is exactly what two of the measured elements use to become
legible — so the glyphs are made transparent instead and every painted layer
stays where it is. And the box sampled is `Range.getClientRects()` rather than
the element's border box: a centred `<p>` inside the hero's copy column is
1325px wide and its text is 200 of them, and taking the brightest pixel of the
whole block samples a picture the letters never cross.

**Three things had to change and every one of them is a number, not a taste.**

| # | Where | Before | After | What changed |
|---|---|---|---|---|
| 1 | The hero eyebrow, over the lit dome | **3.39** | 10.87 | `events.css` §1b — a soft ellipse behind the line itself |
| 2 | The band eyebrow at 375–430, over six lit night pictures | **4.06–4.44** | 4.9+ | `events.css` §4a — the copy box carries its own gradient below 900px |
| 3 | The dialogue's current line at 375–768, over six rooms | **3.81–3.93** | 4.6+ | `events.css` §4b — three stops of the narrow stage scrim come up |

**The first one is the interesting one, and the numbers are the argument:**

| | |
|---|---|
| 3.39 | as it stands |
| 3.39 | home.css's text-shadow tripled — *no movement at all*, because a shadow separates type from a highlight and this line is sitting inside a continuous field of warm light. PADEL found the same thing at its own hero and said so in one sentence: *"a shadow can only separate type from something it is not already sitting inside."* |
| 5.38 | the hero scrim's middle stop taken from 56% to 72%. It clears, and it costs the dome the glow that is the whole shot — the picture is a lit object among dark trees and dimming the lit object is dimming the subject. |
| **10.87** | a soft ellipse behind the line itself. 578px wide on a 1440 screen against a dome nine hundred wide, so nothing about the picture changes. |

**Result, swept across the whole page at 375, 390, 430, 768, 1024, 1440 and
1920** — every text element on the page, sampled at 18–22 scroll positions each:

| Width | line boxes measured | below AA | lowest |
|---|---|---|---|
| 375×812 | 260 | **0** | `.c-film-hero__statement` 4.64 |
| 390×844 | 256 | **0** | `.c-dialogue__note` 4.63 |
| 430×932 | 267 | **0** | `.c-dialogue__note` 4.60 |
| 768×1024 | 204 | **0** | `.c-dialogue__note` 4.57 |
| 1024×768 | 179 | **0** | `.c-film-band__caption` 4.81 |
| 1440×900 | 171 | **0** | `.c-film-band__caption` 4.81 |
| 1920×1080 | 185 | **0** | `.c-film-band__caption` 4.81 |

**Nothing on this page is below AA at any width.** The gold **Plan a private
event** button measures 8.97 rather than the 1.1 the old harness reported, which
is the second harness fix earning its keep: hiding an element to sample its
background hid the gold fill the label stands on.

**The dialogue at six needed three numbers as well, and they are layout rather
than contrast.** `club.css` pins a stage one viewport tall and stands a column of
names on it; six of THE CLUB's four-sized names run past the foot of a 900px
window, which is the one way that component can be got wrong. The gap between
names, the size of a name and the head above them each come down about a fifth.
The stage's own height was already right — `club.css` sizes it as
`(--items + 1) * 78vh` and `film-dialogue.php` writes `--items` from the content
file, so six rooms already get six slices of scroll, and all six are reached by
scrolling alone (measured, §7).

---

## 7. Verification

Everything below was run against `php -S` with `tools/serve_router.php`, in
headless Chrome, with real wheel events so Lenis drives the scroll.

**Nothing else on the site moved.**

```
tools/compare_pages.sh events-before events-after3 events

after_dark  IDENTICAL     membership  IDENTICAL(t)
club        IDENTICAL     notfound    IDENTICAL
components  IDENTICAL     padel       IDENTICAL
contact     IDENTICAL(t)  privacy     IDENTICAL
estate      IDENTICAL     residences  IDENTICAL
events      CHANGED*      styleguide  IDENTICAL
home        IDENTICAL     terms       IDENTICAL
```

The Main Page, THE ESTATE, THE CLUB and PADEL are **byte-identical with no
masking at all** — including the `?v=` cache-busting query on every asset, which
is the proof that not one shared file any of them loads was modified. `(t)` is
`/contact` and `/membership`, identical but for the per-request form-time token
they mint on every render by design.

> **One run of the check failed and the failure is worth recording.** Re-running
> `tools/photos/build_images.py` after editing it rewrote sixteen images
> byte-for-byte identically and *moved their mtimes*, which moved the `?v=` on
> three pages that had not otherwise changed. The bytes were never in question;
> the cache-buster was. The mtimes were restored from the `?v=` values in the
> before-snapshot — which is what those values are — and the check passed. Any
> future run of a shared build script needs the same treatment.

**Rendering.**

| Width | doc height | overflow-x | broken images | console | videos held at once |
|---|---|---|---|---|---|
| 375×812 | 12 893 | 0 | 0 of 22 | clean | 3 |
| 390×844 | 13 106 | 0 | 0 of 22 | clean | 3 |
| 430×932 | 13 686 | 0 | 0 of 22 | clean | 3 |
| 768×1024 | 15 751 | 0 | 0 of 22 | clean | 3 |
| 1024×768 | 15 635 | 0 | 0 of 22 | clean | 3 |
| 1440×900 | 18 821 | 0 | 0 of 22 | clean | 3 |
| 1920×1080 | 22 542 | 0 | 0 of 22 | clean | 3 |

No console errors, no page errors, no failed requests, no 4xx, and no horizontal
scroll at any width, swept across 24 scroll positions per width.

**Fallbacks.**

| Mode | classes set | libraries fetched | mp4 fetched | reveals hidden | dialogue |
|---|---|---|---|---|---|
| normal | `has-js motion lenis is-revealing is-dialogue` | 7 | 1 | 37 of 40 | a stage, one line printed |
| **reduced motion** | `has-js` | **0** | **0** | **0 of 40** | **a grid, all six lines printed** |
| **JavaScript off** | *none* | **0** | **0** | **0 of 40** | **a grid, all six lines printed** |

With JavaScript off the page is a complete 15 313px document: a full first
screen with the poster in place of the film, six captioned bands, six chapters,
the five facts, two plates, six captioned rooms, the estate index and the
invitation — 22 images loaded, 0 broken. Under `prefers-reduced-motion` not one
library byte is fetched.

**Navigation and structure.** EVENTS carries `aria-current="page"` and
`.is-current` in both the bar and the sheet. The sheet opens, locks the scroll,
marks itself `04 Events`, and closes on Escape with focus returned to the toggle.
The hero's cue reads `#pavilion`, `#pavilion` exists, and pressing it eases to it
(y = 886) and updates the address bar. One `<h1>`; every other heading is an
`<h2>`, with no level skipped. All six dialogue rooms are reached by scrolling
alone.

**The build script and the page agree exactly.** 70 image files on disk under
`assets/img/events/`, 70 requested by the rendered page, **0 requested and
missing, 0 on disk and unused, 0 hatched placeholders**. Six video files on
disk, six declared, six requested. A re-run of the build script writes the same
70 files and prunes nothing, which is what idempotent means.

**Weight.**

| | raw | gzip |
|---|---|---|
| `events.css` | 17 826 | **6 484** |
| `events.js` | 4 702 | **2 114** |
| page HTML | 41 046 | **7 376** |
| the film's four stylesheets together | — | 29 939 |
| the film's four scripts together | — | 15 261 |
| the six encodes on disk | — | 6.0 MB |

| | 1440×900 | 390×844 |
|---|---|---|
| First contentful paint | 144 ms | 108 ms |
| Largest contentful paint | 1 196 ms | 1 160 ms |
| Cumulative layout shift, unscrolled | **0** | **0** |
| Transferred at the load event | **2.19 MB** | **1.39 MB** |
| Transferred, whole page scrolled | 7.30 MB | 6.02 MB |
| JS heap after a full scroll | 2 MB | 2 MB |

Of the first screen, **1.53 MB at 1440 and 763 KB at 390 is the hero film**,
which is fetched only after `load`, only when motion is welcome, only off a
metered connection, and at the narrow encode below 900px. Without it the first
screen is about 0.66 MB and 0.63 MB.

**The LCP element is the seal**, at both widths, which is the Main Page's own
behaviour and PADEL's: the poster paints at about 200 ms and the seal waits on
the hero's entrance animation. Same numbers as PADEL to within 3%.

**Video, by scene.** Five sequences plus the hero's narrow encode, 6.0 MB on
disk, and **a reader never holds more than three at once** — measured across
thirty scroll positions at every width.

**The two bands that do not move are given a camera, and only those two.**
`events.js` decides which is which by asking whether the band has a
`[data-band-video]` at all, so the day either of them becomes a sequence the job
stops touching it without being edited.

---

## 8. Limitations

1. **The hero is night and scene 01 is the afternoon.** §1 argues this is the
   structure rather than a fault, and it is still the one thing about the page a
   reader could be surprised by. It is the consequence of a supplied hero the
   brief forbids replacing, and the alternative — reordering the film so the
   daylight comes first — would open the page on a white dome under an overcast
   sky, which is the picture the brief's colour instructions rule out.
2. **`ev-dusk` runs the evening backwards for the second half of its loop.** The
   palindrome is the site's answer to a shot that never returns to its first
   frame and it is right here too, but on this one sequence it means the light
   comes back. §3 explains why the alternative is worse.
3. **Scene 07's first room is generated and its source photograph is not
   printed anywhere.** §3 gives the reasoning in full. If the owner wants the
   photograph itself on the page it is one stem in the content file and one row
   in the build script.
4. **Scene 05 cannot show the pavilion and the manor in one frame, because no
   such picture exists.** The band is the pavilion and the long building beside
   it; the sentence under it says the manor is at the other end of the park and
   the picture does not prove it. Every alternative — compositing the two,
   generating a wider view — would be inventing a geography nobody has
   confirmed, which is the one thing the brief rules out first.
5. **Four plates ship at 640 and no higher**, and one at 640 alone from a
   922-wide crop. `estate_1.jpg`, `CIGAR_LOUNGE.png` and `PRIVATE_CLUB_ECOSYSTEM/1.png`
   are not wide enough for the 960 rung after their 4:5 cut, and nothing on this
   site is upscaled.
6. **EVENTS loads about five hundred lines of CSS and two motion jobs it never
   uses** — `estate.css`'s walk and `club.css`'s lateral track. PADEL predicted
   this exact page and this exact number. §4 explains why it is still the right
   trade and why the fix belongs in a round of shared-file work rather than here.
7. **`.c-film-band--full .c-film-band__frame` is wider than the viewport at
   every width and always has been.** `home.css` gives it `min-height` on top of
   `aspect-ratio`, and a forced height makes the ratio widen the box. It is
   contained by `#main { overflow-x: clip }`, it is identical on the Main Page,
   THE CLUB and PADEL, and it was not introduced here.
8. **The closing headline is not either of the two the brief proposed.** *"An
   evening worth remembering"* and *"Make the estate your occasion"* are the two
   registers `content/en/events.php`'s own header has forbidden since it was
   written — the first is the family of "unforgettable" and "your special day",
   the second is the second person this site does not use. What ships — *An
   evening worth staying for.* — says the same thing in the house's grammar and
   is the page's own argument in five words. This is a judgment call against an
   explicit instruction and it is flagged rather than buried; the line is one
   string in the content file if the owner prefers the brief's.
9. **`build_images.py` lost three rows and it was the right amputation, but that
   file is now the only place on the site where the retired pipeline and the
   film pipeline could still collide.** `events/pavilion-day` existed as a stem
   in both, at two ladders and two crops, and the four stale files were on disk.
   The other pages' rows in that script have not been audited for the same
   problem.
10. **Latvian is not written.** `content/lv/events.php` does not exist, as for
    every other page. The route is already in `routes.php`.
11. **`tools/weigh_assets.sh` is still broken** and was broken before this work —
    it references `assets/js/home-atmosphere.js`, which does not exist. Not
    touched, because it is the Main Page's tool.

---

## 9. Credits

| | count | rate | credits |
|---|---|---|---|
| GPT Image 2, 2K, high | 2 | 7 | **14** |
| Seedance 2.0, 720p, 16:9, 5 s, no audio | 4 | 22.5 | **90** |
| The hero — supplied footage, re-encoded locally | 1 | 0 | **0** |
| | | **spent** | **104** |

Balance before 1 233, balance after **1 129**. Nothing was regenerated: the one
sequence that came back wrong in its last second was trimmed at encode, and the
one still that could not be graded into the palette was replaced by a generation
from the same photograph rather than by a second attempt at the same generation.

---

## 10. Two things worth reading the code for

### The still and the film are the same picture, and that is the scene

`events/pavilion-day` is a 16:9 crop taken low out of `pavilion_2.jpg`, graded to
dusk, printed full-bleed at the end of act one. `ev-dusk` is a Seedance move
started from *that same crop, ungraded*, and encoded with a matching curve so the
two meet at the same exposure.

Nothing about this is visible as a technique. What a reader gets is a photograph
of a lawn in the afternoon, a paragraph, and then the same lawn getting dark in
front of them — which is the transformation the brief asks for, made out of one
crop and two entries in a build script rather than out of a transition.

The measurement that makes it work is one line of §5: 41.4 against 45.8. Print
the plate graded and the film raw and the page brightens between scene 01 and
scene 02, and everything the sequence is doing is undone by the step in front of
it.

### The harness was wrong twice and the page was right both times

The first legibility sweep reported seventeen elements below AA, including a
caption at 1.05:1 on a ground that measures 4.87 by hand. Three bugs, in order:

1. `page.screenshot({clip})` clips in **document** coordinates, not viewport
   coordinates — so every sample after the first screen was taken against the
   hero.
2. `visibility: hidden` removes an element's own background and pseudo-elements,
   so the two fixes that work by putting something *behind* the type — the gold
   button's fill and the eyebrow's wash — were measured against the ground they
   exist to cover.
3. The border box of a centred `<p>` is the column, not the words. A 1325px box
   over a lit dome has a bright 95th percentile no matter where the 200px of
   text sits inside it.

None of the three was a fault in the page. All three would have produced a
"fix" — a darker scrim, a heavier shadow, a wash where none was needed — and
each of those costs a picture. The harness ships as
`tools/measure_contrast.js`, with all three rules written into its header, so
the next page can repeat the method rather than re-derive it.
