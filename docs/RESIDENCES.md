# Majori Manor — RESIDENCES

*The sixth page cut from the film, and the first whose subject is a day rather
than an hour.*

| | |
|---|---|
| Address | `/residences` |
| Template | `templates/pages/residences.php` — four lines |
| Content | `content/en/residences.php` |
| Layers | `home.css/js` → `estate.css/js` → `club.css/js` → `residences.css/js` |
| Media build | `tools/photos/build_residences_media.py` |
| Generated | 2 GPT Image 2 stills, 5 Seedance 2.0 sequences |
| Credits | **140.5** (see §9) |

---

## 1. What it is

One page, eleven scenes, six acts, read top to bottom as one stay.

| | Scene | Act / ground | Carries |
|---|---|---|---|
| 00 | **The arrival** | — | A landing at night and a door standing open — full screen, moving |
| 01 | **Within the estate** | heritage · mahogany | *The rooms are in the house.* — and the building they are in, at blue hour |
| 02 | **The room** | interior · the pause ground | *And then the door shuts.* — the main suite, lamps lit |
| 03 | **The house it is in** | interior | *Made, rather than specified.* — six close frames of the real house, panned |
| 04 | **The morning** | **dawn · new** | *And then it is simply morning.* — the same room, eight hours later |
| 05 | **The park** | park · green | *The park, just outside.* — the window, and what is on the other side of it |
| 06 | **The quiet** | estate · near-black | One picture with nothing written on it, and one sentence |
| 07 | **The evening** | evening · wine | *The evening does not end at the door.* — the fire downstairs |
| 08 | **Three ways to stay** | evening | Three rooms behind one list of names |
| 09 | **The house around it** | evening | *Nobody checks in.* |
| 10 | **The estate** | evening | Four places, four pages, one line each |
| — | **The invitation** | evening | The seal, and two ways to write |

**THE HERO IS NIGHT AND THE FOURTH SCENE IS SUNRISE, and that is the structure
rather than an accident.** EVENTS opens where its evening ends and walks back to
the beginning of the day. This page opens where a stay begins — at a door, late
— and then does the one thing a visit cannot, which is to still be there in the
morning. Every other page on this site is an hour. This one is a night, a
morning, an afternoon and an evening, in that order, and the grade proves it
(§5).

**It adds no component and it is the first to leave one out.** THE ESTATE
brought the walk and the ledger; THE CLUB brought the lateral track and the
dialogue; PADEL and EVENTS brought none. This page is built entirely out of what
those five already approved — `film-hero`, `film-band`, `film-chapter`,
`film-plates`, `film-detail`, `film-dialogue`, `film-world`, `film-invitation`,
`film-nav`, `film-footer` and the act wrapper — **and it carries no
`film-ledger`**, because there are no settled facts to put in one
(ARCHITECTURE §21). THE ESTATE, PADEL and EVENTS all close a scene on five
facts; this page has no five. That absence is the one structural difference
between it and the four film pages before it, and it is deliberate.

**It is the second page to set the lateral track and the third to set the
dialogue.** THE CLUB pans six close frames of the house along a wall; here it is
six different frames of the same house, and the point of putting them in this
component is the sentence over them — *what a residence at Majori Manor is made
of is not a specification; it is a house that already exists.* The dialogue
carries three kinds of residence, which is the first time that component has
been asked for fewer than it was drawn for.

**It adds one thing to the system and it is a colour.** `residences.css` §1
declares `--mm-dawn`, a sixth act ground, and act three stands on it. The
argument is in §4 below and in the stylesheet: EVENTS and PADEL both refused the
brief's warm cream because *on this system cream is the ink and not a ground*,
and both were right about pages that never see daylight. This page has a sunrise
in it.

**There is less prose than there was.** The version this replaces ran to about
480 words of body copy beside five photographs and described an interior style.
This one runs to about 330 across eleven screens and describes a stay.

**Six sentences survived word for word, because they are the approved ones:**
*The residences are inside the estate rather than beside it*, the
hotel-room-versus-part-of-the-house distinction after it, *An evening at the
estate has a point at which going home is the least interesting thing left to
do*, *The rooms look onto the park* and the sentence that finishes it, *Dark
wood, and light kept warm and low enough that a room is a room after dark rather
than a lit box*, and the English-private-club register paragraph.

**No sentence acquired a fact.** The rebuild settled nothing, so the forbidden
list at the top of the content file is the one that was already there: no number
of residences, no size, no rate, no minimum stay, no season, no opening date, no
amenities of any kind, and nobody who works here. The only facts on the page are
the ones other approved pages already carry — the private park of two and a half
hectares, the courts behind the hedge, the manor at one end of it, and the Main
Page's own sentence about where the three kinds of residence are.

### Scene 09, and why it is written as a negation

The brief for the rebuild asks for a hospitality scene whose message is *you are
staying inside a private estate, not checking into a hotel*. The content file's
own standing rule forbids housekeeping, service, check-in, keys **or anybody who
works here**. Both are satisfiable at once, because the message is entirely a
statement about what does **not** happen:

> Arriving at a house is not the same transaction as arriving at a hotel, and
> the estate has no intention of making it one. What that comes to in practice
> is a conversation rather than a counter.
>
> And the rest of the house is downstairs. The rooms, the table, the fire and
> the park are not amenities of the residence — the residence is a room inside
> the building they are already in.

Not one sentence in scene 09 says what anybody does for you. The two pictures
are the project's own visualisations of a desk in a hall and a dining room, and
their captions name the rooms rather than the service.

---

## 2. The asset audit

All twelve directories of `media_src/` were inspected again, file by file.
**The library has grown by one directory since EVENTS was built** —
`MOTION/residences/`, which this page created — and by nothing else: the same
twelve top-level directories, the same 67 stills outside `Majori_logo/` and
`MOTION/`.

| Directory | Files | Kind | Used here | Used before |
|---|---|---|---|---|
| `interiors/` | 15 | photographs of the real house | **7** — 1, 2, 8, 9, 12, 13, 15 | 1, 2, 12, 13, 15 elsewhere at other ratios; **8 and 9 never anywhere** |
| `ESTATE_and_HOSPITALITY/` | 7 | visualisations | **5** — MAIN_MANOR_SUITE, SECOND_BUILDING, private_cottages, reception_concierge, Restaurant_1 | all five elsewhere or as sequence sources, none at these ratios |
| `estate/` | 4 | photographs | **3** — estate_2, 3, 4 | estate_4 at 4:3; **2 and 3 had never been cut as stills** |
| `grand-staircase/` | 4 | photographs | **1** — GrandStaircase_4 | the Main Page, at 3:2 |
| `heritage-details/` | 3 | photographs | **1** — heritage_2 | THE ESTATE, at 16:9 and 3:2 |
| `CIGAR_HOUSE/` | 9 | visualisations | **2** — whisky_lounge, whisky_collection | whisky_lounge on home at 3:2; **whisky_collection never anywhere** |
| `pavilion/` | 3 | photographs | **1** — pavilion_2 | EVENTS at 16:9, home at 3:2 |
| `Majori_logo/` | 21 | brand | **2** — seal-cream, seal-gold | all five film pages |
| `MOTION/residences/` | — | this page's masters and stills | its own | — |
| `RESTAURANT/` | 7 | visualisations | 0 | home · club · events |
| `PRIVATE_CLUB_ECOSYSTEM/` | 12 | visualisations | 0 | home · club · padel · events |
| `HOUSE_OF_DIALOGUE/` | 3 | visualisations | 0 | home · club |

### What the audit found that five pages had walked past

**`interiors/interiors_9.png` had never been used anywhere, and it is the page.**
It is the first-floor landing of Majori Manor: two round-headed arches on carved
oak piers, a corridor beyond them with a tall panelled door standing open at the
end, a barley-twist balustrade with a diamond-inlaid newel panel, a coffered
ceiling and herringbone parquet. Five pages had been built out of this library
and not one of them had cut a frame from it. It is the single composition in the
library that says what this page is about — *a private door, inside a historic
house, with a light on behind it* — and it is used twice: as the reference the
hero sequence was generated from, and at 3:4 as the first frame of the detail
track.

**`interiors/interiors_8.png` had never been used anywhere either.** The stair
hall with three lit sconces, the carved balustrade turning above and a lamp
burning in a room through an open door. Graded to the deepest curve on the page,
it is scene 06 — the one screen with nothing written on it.

**`CIGAR_HOUSE/whisky_collection.png` had never been used anywhere.** Ranked
bottles lit from behind; it is the After Dark tile in scene 10.

**`estate/estate_2.jpg` and `estate/estate_3.jpg` had never been cut as
stills.** Both are references THE ESTATE's own sequences were generated from,
which is not the same thing as a picture of them — the status PADEL gave
`RESTAURANT/dining_salon2.png` and EVENTS gave `reception_concierge.png`.
estate_2 is the portico in scene 05; estate_3 is The Estate tile in scene 10.

**`ESTATE_and_HOSPITALITY/SECOND_BUILDING_GUEST_SUITES.png` is 2880 × 2880 and
had only ever been cut tall.** The Main Page takes a 4:5 of it. A square that
size yields 1260px of vertical surplus at 16:9, which is enough for two
photographs rather than one photograph twice: the house whole at bias 0.30 for
scene 01, and the lit ground floor and the cobbles at 0.62 for scene 08.

### What was deliberately not used

- **`RESTAURANT/`, `PRIVATE_CLUB_ECOSYSTEM/`, `HOUSE_OF_DIALOGUE/` — none of
  the twenty-two.** They are the club's, the courts' and the pavilion's, and
  those have four pages between them. The one file this page nearly took is
  `PRIVATE_CLUB_ECOSYSTEM/5.png`, the gloved hand at the car door, for scene 09
  — and it is the Main Page's and THE CLUB's at 4:5, and a chauffeur's glove is
  a picture of a service on a page that is forbidden to describe one.
- **`interiors/interiors_3.jpg`, the great hall by lamplight.** The best low-light
  interior in the library, and it opens `/after-dark` and appears twice on the
  Main Page.
- **`interiors/interiors_5, 6, 7, 10, 11, 14`.** These are THE CLUB's six detail
  frames, at 3:4, in this exact component. **Not one of this page's six is a
  file THE CLUB's six use.**
- **`grand-staircase/GrandStaircase_1, 2, 3` and `heritage-details/heritage_1,
  3`.** THE ESTATE's walk and detail frames.
- **`MOTION/HERO/main-hero.mp4` and `pavilion.mp4`.** The Main Page's and
  EVENTS'.
- **`assets/video/seq-suite.mp4`.** Checked first, and the check is the reason
  scene 02 is a new generation — see §3.

Nothing was excluded for quality.

---

## 3. What was generated, and from what

**Two stills and five sequences.** Every one descends from a file in
`media_src/`, and every prompt is in
`tools/photos/build_residences_media.py` verbatim, because a prompt is the only
part of a generated asset that cannot be recovered by looking at it.

### The crops the generations start from

| Reference | From | Crop |
|---|---|---|
| `ref-threshold` | `interiors/interiors_9.png` | `(0,150)-(1700,1744)`, then 16:9 at bias 0.42 → 1700 × 956 |
| `ref-suite` | `ESTATE_and_HOSPITALITY/MAIN_MANOR_SUITE.png` | 16:9 at bias 0.40 → 1240 × 698 |
| `ref-window` | `interiors/interiors_13.png` | 16:9 at bias 0.30 → 1920 × 1080 |
| `ref-fire` | `interiors/interiors_1.jpg` | 16:9 at bias 0.62 → 1176 × 662 |

### Stills — GPT Image 2, 2K, high, 16:9, from a reference

| Still | From | What changed | What did not |
|---|---|---|---|
| `still-threshold` | `ref-threshold` | The hour. Daylight → late evening, lit only by a corridor light, lamplight through the open door lying across the parquet, and a glow from the stairwell | The two arches, the piers and their capitals, the corridor, both doors, the barley-twist balusters, the diamond-inlaid newel panel, the coffers, the herringbone, the camera |
| `still-morning` | `ref-suite` | The hour. Blue hour with four lamps lit → early morning, lamps off, curtains drawn back, long shapes of daylight on the parquet, the park through the glass, the bedcover turned back on one side | The headboard, the pillows, the bench, both chests, both lamps, the window, the glazed doors, the pole, the armchair, the rug, the parquet, the chandelier, the camera |

**`still-morning` is the only picture on the site of a room that has been slept
in.** Every visualisation in the library is a made bed in a lit room at night,
because that is what a property brochure photographs. The scene this page needs
at its fourth screen is the opposite of that, and the only honest way to get it
was to take the brochure's own room and move the sun.

**What the model added, stated rather than hidden:** a low iron balcony rail
outside the glazed doors of `still-morning`, which the reference does not show
and does not contradict — a first-floor French door opens onto something. It is
small, it is behind glass, and it was left rather than spend a second generation
removing it.

### Sequences — Seedance 2.0, 720p, 16:9, 5 s, no audio, `start_image`

| Sequence | Start image | Motion |
|---|---|---|
| `res-arrival` (hero) | `still-threshold` | Extremely slow dolly forward and slightly left; the nearer arch opens and the lit corridor comes closer. **The camera never reaches the arch.** |
| `res-room` | `ref-suite` | Slow lateral drift to the right, from the bed toward the window and the glazed doors; curtains stirring, lamplight breathing |
| `res-morning` | `still-morning` | The light strengthening as the sun rises, the shapes on the parquet lengthening, curtains stirring, the camera almost still |
| `res-window` | `ref-window` | Slow dolly toward the window bay; bare branches moving outside, daylight shifting on the parquet |
| `res-evening` | `ref-fire` | Slow push toward the lit firebox; flames breathing, firelight moving on the piano's lacquer |

**`START_IMAGE` and not `image_references`, on all five** — EVENTS' rule, and the
only setting under which a coffered ceiling, a barley-twist balustrade and a laid
bed survive five seconds of camera movement. It is also what makes the poster
honest: frame 0 of the encode *is* the reference, so the still and the film
cannot re-frame against each other when the video fades up.

**Nothing was trimmed and nothing was regenerated.** All five held their framing
for the whole five seconds, which is what a prompt written as a preservation
instruction buys.

### `res-room` exists because the Main Page's `seq-suite` was checked first

`assets/video/seq-suite.mp4` is a Seedance push-in on this same room, built for
the Main Page's scene 06. Reusing it here would have cost nothing and shown the
reader the identical twelve seconds they have already seen on the page that sent
them. So the camera was turned ninety degrees instead: `res-room` drifts
sideways, from the bed toward the window, which is also the direction of the
page's argument — *the bed is where you start and the window is where the estate
is.* Same room, different shot.

### Two prompt lines did the work, and both are limits rather than descriptions

> **"The camera never reaches the arch and never passes through it."**
> A dolly toward a doorway is the one move this model will over-deliver: asked
> to approach, it arrives, and a hero that arrives has nowhere to be for the
> second half of its loop.

> **"No change of season and no leaves on the trees."**
> `interiors_13.png` was photographed in early spring and the park through that
> glass is bare. A summer park behind those windows would have been a nicer
> picture and a claim about a view nobody has photographed.

### The honesty marking

| Value | Count | What |
|---|---|---|
| `photo` | 11 | The landing, the stair hall, the interior window, the stove, the glazed doors, the chimneypiece, the hall floor, the house from the lawn, the portico, the garden front, the pavilion |
| `render` | 8 | The main suite, the guest-suite building (twice), the cottages, the desk in the hall, the dining room, the whisky lounge, the bottles |
| `generated` | 5 | The five sequences and their posters |
| `mood` | **0** | — |

**The page this replaces declared all five of its pictures `mood`, and its own
header argued that this was permanent.** That rule is kept and the value is
gone, which is not a contradiction. `mood` is the licence to stand a reference
image in a slot and say nothing about it; what this page does instead is say
what every picture actually is. A photograph of the real landing is a photograph
of the real landing — that is `photo`, and its caption says *the landing*, not
*your room*. Every caption was written against the same test the old header set:
it may describe the frame that arrived, and it may not promise a room. **Nothing
on this page is captioned as a residence of ours, because there is not one yet.**

---

## 4. What was built, and what was reused

### Reused unchanged

`film-hero`, `film-band`, `film-chapter`, `film-plates`, `film-detail`,
`film-dialogue`, `film-world`, `film-invitation`, `film-nav`, `film-menu`,
`film-footer`, `film-acts`, the act grounds and seams, the grain, the reveals,
the smooth scroll, the anchor easing, the band attach/release, the plate
settle, the lateral track and the dialogue stage. Eleven components, five
motion files, and not one of them was edited.

### `residences.css` — 5 sections

| § | What | Why |
|---|---|---|
| 1 | `--mm-dawn` and `.c-act--dawn` | The morning. See below. |
| 2 | The hero's title measure, its scrim, and the eyebrow's wash | Four words where every other film hero has two; a lit corridor behind centred copy |
| 3 | The dialogue at three, and its narrow scrim | Fewer names than the component was drawn for; one measured line |
| 4 | Two object-positions below 900px | The hero's crop and the morning's |
| 5 | The narrow pass | The band overlay's gradient, the quiet band's ratio, the statement chapter, the CTA's tracking |

### `residences.js` — one job

The camera on the two bands that are photographs: a 7% scale scrubbed to the
scroll. It is `events.js`'s job, copied, which is `padel.js`'s job, copied,
and the argument for copying twenty lines rather than loading a page's whole
stylesheet for one of its rules is in the header of both files.

**The silent band is included deliberately.** Act five is the page's pause — one
photograph with no scene number, no eyebrow, no title and no caption. The
temptation is to let it be the one screen that is completely still. On a page
where every other full screen has a camera in it, a photograph that does not
move reads as a picture that failed to load.

### The sixth ground, and why it is in this file

`estate.css` §1 declares five grounds and every film page since has been built
out of them. EVENTS was asked for a warm cream in the middle of its rhythm and
refused; PADEL gave the same answer. Both were right about pages that never see
daylight. This page's fourth screen is a bedroom at sunrise, and a ground that
holds mahogany above it and mahogany below it makes that screen *a bright
picture on a dark page* when what it is meant to be is *the moment the page
itself comes up*.

So one ground was added, and every constraint the other five meet is met:

| | |
|---|---|
| Still a dark ground | `#1A160F` — warm brown-grey, lighter than `--mm-heritage` by about a third |
| Still the brand's colour | The same mahogany, one stop up |
| Type still clears | `--ink` 15.31:1, `--gold-ink` 8.01:1, `--ink-muted` 7.88:1, `--ink-faint` 4.70:1 |
| Declared in this file and nowhere else | `estate.css` is untouched, so the four approved pages that load it are byte-identical. `asset_url()` cache-busts on `filemtime`; one line in `estate.css` would have re-versioned the stylesheet in the markup of THE ESTATE, THE CLUB, PADEL and EVENTS to save one selector here. |

**It started at `#1C1811` and came down four percent of luminance.** At the
lighter value the band caption on the morning scene — the one element on the
site set in `--ink-faint` on an act's own ground — measured 4.51, which passes
AA and is under the 4.57 floor EVENTS shipped at. §6 has the number.

---

## 5. The grade, and the temporal arc it exists to make

**Every encode on this page carries a grade, and that is new.** The five pages
before it graded at most one sequence each, because their material arrived at
the page's own exposure. Two of these five are daylight and the other three are
lit interiors that came back a stop brighter than the film runs.

All five are matched by **measurement**: mean luminance of frame 0 of the
encode, against the 31.1 that EVENTS' hero measures and the 46.1 that THE CLUB's
hall measures.

| Sequence | Raw | Encoded | Sitting beside |
|---|---|---|---|
| `res-arrival` | 28.7 | **28.6** | A hero. EVENTS' own is 31.1 |
| `res-room` | 61.5 | **40.5** | The first interior after the hero |
| `res-evening` | 64.2 | **47.4** | The wine act, beside THE CLUB's 46.1 |
| `res-morning` | 94.2 | **62.0** | Nothing. It is the brightest screen on the site, deliberately |
| `res-window` | 104.1 | **57.5** | The afternoon, one step under the morning |

**The page peaks at the morning and not at the park, and that is the whole
argument of the grade: the reader wakes up, and the light never gets better than
the moment they do.**

Read down the bands in page order and the arc is a day:

```
29  hero        a landing at night
46  scene 01    the house at blue hour
41  scene 02    the room, lamps lit
62  scene 04    THE MORNING
57  scene 05    the afternoon
31  scene 06    the quiet
48  scene 07    the fire
```

### The still curves

| Curve | Value | Used on |
|---|---|---|
| `GRADE` | `(0.475, 0.92)` | `build_club_media.py`'s own — one world tile |
| `DEEP` | `(0.435, 0.83)` | `build_club_media.py`'s own — the six detail frames and the dining room |
| `DUSK` | `(0.32, 0.62, (1.0, 0.96, 0.88))` | The guest-suite building, twice, and the main suite |
| `GOLDEN` | `(0.25, 0.48, (1.0, 0.95, 0.86))` | The estate's own daylight — the lawn, the portico, the pavilion |
| `NIGHT` | `(0.15, 0.28, (1.0, 0.94, 0.82))` | A lit room at one in the morning — the quiet, the garden front |

`GOLDEN` is the one worth arguing with. EVENTS answered *a white manor house
under a blue midday sky* with `NIGHT`, a curve that takes a noon photograph down
to something that reads as after dark. That is right for a tile beside three
night tiles and wrong here, because scene 05's whole argument is that there is a
park out there **in daylight**. `GOLDEN` goes down about as far and tilts
further: the blue channel comes down fourteen percent and the green five, which
is what the last hour of a summer afternoon does to a photograph taken at noon.

### Every group, measured

| Group | Range | Ratio |
|---|---|---|
| The seven bands | 28.6 – 62.0 | 2.17 — **the arc, deliberately** |
| The three dialogue rooms | 35.0 – 41.7 | 1.19 |
| The two park plates | 56.0 – 62.3 | 1.11 |
| The two hospitality plates | 19.1 – 27.3 | 1.43 |
| The four world tiles | 25.1 – 38.6 | 1.54 |
| The six detail frames | 73.3 – 105.7 | 1.44 — inside THE CLUB's own 76.2 – 169.3 |

The rule everywhere except the bands is EVENTS': no picture in a group arrives
more than about half again as bright as the darkest one beside it. The bands
break it on purpose, and that break is the page.

---

## 6. Legibility, measured

Same harness, same method, same three rules as EVENTS —
`tools/measure_contrast.js`, sampling the **95th-percentile brightest background
pixel each element's letters actually cross**, glyphs made transparent rather
than hidden, `Range.getClientRects()` rather than the border box, and the page
driven by real wheel events so Lenis moves it as a reader does.

**Three things had to change and every one of them is a number, not a taste.**

| # | Where | Before | After | What changed |
|---|---|---|---|---|
| 1 | The hero eyebrow at 375–430, over the lit corridor | **1.95** | 4.7+ | `residences.css` §2b deepens the middle of the narrow scrim, §2c hangs a soft ellipse behind the line itself |
| 2 | The band caption on the morning scene | **4.51** | 4.61 | `residences.css` §1 — the new ground came down four percent of luminance |
| 3 | The dialogue's current line at 768 | **4.44** | 4.8+ | `residences.css` §3b — three stops of the narrow stage scrim come up |

**The first one is the interesting one, and the arithmetic is the argument.**
"PRIVATE RESIDENCES" is set in gold at 10.6px and its letters cross a background
of 0.2745 relative luminance — the inside of the lit doorway. To reach 4.5:1 that
background has to come down to 0.0905, which is a wash of about 68% over the one
part of the picture that is lit. That is not a scrim any more; it is switching
the light off.

So the fix is split. The narrow scrim's middle stops come up (the top eighth and
the bottom fifth are left alone, so the coffered ceiling keeps its black and the
parquet keeps the long shape of light lying on it) — which is enough for the
title, in cream at 35.7px, to go from 3.50 to comfortably clear. And the eyebrow
gets EVENTS' own answer, which was PADEL's before it: a soft ellipse behind the
line itself, at most 30rem wide against a corridor 1500px wide in a portrait
window, so nothing about the picture changes.

**A note on the ellipse: it is applied at every width and it is invisible at
most of them.** On a desktop this eyebrow already measures 5.34 because the copy
stands on near-black oak, and a black ellipse painted over near-black oak is a
black ellipse painted over black.

**Result, swept across the whole page at 375, 390, 430, 768, 1024, 1440 and
1920** — every text element, sampled at 16–20 scroll positions each:

| Width | line boxes measured | below AA | lowest |
|---|---|---|---|
| 375 × 812 | 173 | **0** | `.c-film-band__caption` 4.61 |
| 390 × 844 | 173 | **0** | `.c-film-band__caption` 4.61 |
| 430 × 932 | 177 | **0** | `.c-film-band__caption` 4.61 |
| 768 × 1024 | 132 | **0** | `.c-film-band__caption` 4.61 |
| 1024 × 768 | 138 | **0** | `.c-film-band__caption` 4.81 |
| 1440 × 900 | 115 | **0** | `.c-film-band__caption` 4.61 |
| 1920 × 1080 | 123 | **0** | `.c-film-band__caption` 4.61 |

**Nothing on this page is below AA at any width.** The floor is the band caption
on the morning scene, at 4.61, which is `--ink-faint` on the page's own lightest
ground — and it is 0.04 above the floor EVENTS shipped at.

### The title is four words where every other film hero has two

`home.css` sizes the hero title at `clamp(2.6rem, 9.2vw, 8.25rem)`, measured for
"MAJORI MANOR", "THE ESTATE" and "PRIVATE CELEBRATIONS" — two words that break
once. This page's title is the approved page's own line, twenty-nine characters,
which breaks twice. At `home.css`'s size the longest of the three possible
lines, RATHER THAN, measures about 8.3em of uppercase Playfair with its tracking
on it:

| Width | Type | Longest line | Measure | Margin |
|---|---|---|---|---|
| 1440 | 109px | 909px | 1344px | comfortable |
| 375 | 41.6px | 332px | 335px | **3px** |

Three pixels is not a margin, it is a coincidence. So the ladder comes down to
`clamp(2.1rem, 7.6vw, 6.6rem)` — about a fifth at the bottom, an eighth at the
top — and the line that was three pixels clear is sixty-seven. Same type, same
tracking, same case; one clamp, because this page's headline is longer than the
five before it, which is a property of the sentence and not a change of design.

---

## 7. Verification

Run against the built page on `php -S 127.0.0.1:8321 -t public_html
tools/serve_router.php`.

| # | Check | Result |
|---|---|---|
| 1 | All twelve `media_src/` directories inspected, file by file | ✅ §2 |
| 2 | Every generated still descends from a named `media_src/` file | ✅ §3 — 2 of 2 |
| 3 | Every Seedance sequence has a documented start image | ✅ §3 — 5 of 5 |
| 4 | No unsupported architecture introduced | ✅ every prompt is a preservation instruction; the one addition is named in §3 |
| 5 | No unsupported factual claim added | ✅ §1 |
| 6 | Main Page byte-identical | ✅ `tools/compare_pages.sh` |
| 7 | THE ESTATE byte-identical | ✅ |
| 8 | THE CLUB byte-identical | ✅ |
| 9 | PADEL byte-identical | ✅ |
| 10 | EVENTS byte-identical | ✅ |
| 11 | AFTER DARK, CONTACT, MEMBERSHIP, PRIVACY, TERMS, 404, styleguide, components byte-identical | ✅ |
| 12 | Zero broken images | ✅ 0 of 27, at all seven widths, after a full scroll |
| 13 | Zero 4xx/5xx responses | ✅ |
| 14 | Zero console errors or warnings | ✅ |
| 15 | Zero horizontal overflow | ✅ `document.scrollWidth === window.innerWidth` at every scroll stop, at all seven widths |
| 16 | Every text element clears AA | ✅ §6 — 0 below AA at seven widths |
| 17 | Navigation active state | ✅ `RESIDENCES` carries `aria-current="page"` and `.is-current` |
| 18 | Hero film attaches and plays | ✅ 1280 wide / 854 narrow, after the load event |
| 19 | Band films attach on approach and release behind | ✅ 4 of 4 |
| 20 | Reduced motion loads no library at all | ✅ 0 of 7 motion scripts fetched; no video src attached |
| 21 | Reduced motion shows the whole page | ✅ 835 words, 45 of 45 revealed elements at full opacity, 6 of 6 track frames and 3 of 3 dialogue rooms as plain grids |
| 22 | No JavaScript at all | ✅ identical to 21, and `has-js` absent |
| 23 | The lateral track reaches its last frame by scrolling | ✅ frame 06 |
| 24 | The dialogue reaches its last room by scrolling | ✅ room 03 |
| 25 | The page runs top to bottom, rendered, at 1440 × 900 | ✅ 19 065px of document, 23 stops |

### What the snapshot harness proved

```
PAGE           RESULT            BEFORE      AFTER
after_dark     IDENTICAL           9952       9952
club           IDENTICAL          42450      42450
components     IDENTICAL          52111      52111
contact        IDENTICAL(t)       13963      13963
estate         IDENTICAL          38684      38684
events         IDENTICAL          41046      41046
home           IDENTICAL          52790      52790
membership     IDENTICAL(t)       18506      18506
notfound       IDENTICAL           5918       5918
padel          IDENTICAL          39955      39955
privacy        IDENTICAL          13788      13788
residences     CHANGED*           14539      45342
styleguide     IDENTICAL          44427      44427
terms          IDENTICAL          10155      10155

PASS — every page except residences is unchanged.
```

**One thing nearly broke that and it is worth writing down.** `build_images.py`
declares every slot on the nine non-film pages, and removing this page's five
retired stems meant running it — which rewrites every file it declares and
therefore changes every `filemtime`, and `asset_url()` cache-busts on
`filemtime`. Six files came back with a new mtime and the same bytes, which
would have re-versioned six URLs in four approved pages' markup. They were
restored from the `?v=` values in the *before* snapshot, which is the only
record of what those mtimes were. Anyone touching that script again should
snapshot first and check after.

---

## 8. Limitations

1. **`res-morning`'s palindrome runs the sunrise backwards.** Every sequence on
   this site plays forward and then reverses, because a hard cut back to frame 0
   jumps and a cross-dissolve ghosts the scene against itself. On a shot whose
   subject is the sun coming up, the second half of the loop is the sun going
   back down. It is still the right filter — the alternative is a visible cut
   from full morning back to first light every five seconds — and on a change
   this gradual it reads as the light breathing. Same finding as EVENTS'
   `ev-dusk`.

2. **The seasons do not match in act four and nothing pretends they do.** The
   window bay was photographed in early spring and the park through that glass
   is bare; the two plates under it were photographed in leaf. The sequence's
   prompt forbids putting leaves on those branches and the plates are graded to
   a late afternoon rather than graded into the same afternoon as the window. An
   estate has seasons; a page that hides them is claiming a view nobody has
   photographed.

3. **Four plates ship at 640 and no higher** — `park-front` (810px wide after
   the crop), `host-dining` (771), `world-estate` (792) and `world-dark` (922).
   Nothing is upscaled: a rung wider than the crop is skipped rather than
   interpolated. That is the library being what it is, not a ladder being
   half-exported.

4. **`estate.css` §2 and §3 are dead weight on this page.** About 350 lines of
   the walk and the ledger match nothing here, and both motion jobs return on
   their first line because neither `[data-walk]` nor `[data-ledger-row]` is in
   the DOM. That is the price of not forking a shared file, and it is the right
   price for PADEL's reason: the bytes are already in the reader's cache from
   the pages that do use them.

5. **The morning still has an iron balcony rail the reference does not show.**
   §3. Small, behind glass, and left rather than regenerated.

6. **The residences still do not exist.** Nothing on this page is a photograph
   of a residence, because there is not one to photograph. Every picture is
   either the house they will be in, a visualisation of what will be in it, or a
   generation that changed the hour of one of those two. The captions say so.

### Weight

| | Raw | Gzipped |
|---|---|---|
| `residences.html` | 45.3 KB | 8.0 KB |
| `residences.css` | 24.9 KB | 9.0 KB |
| `residences.js` | 5.3 KB | 2.4 KB |
| The four stylesheets together | 228.0 KB | 60.2 KB |
| The motion layer (injected at the load event) | 237.5 KB | — |

| | |
|---|---|
| First screen — HTML, CSS, fonts, the two eager images, `main.js` | **497 KB** |
| The whole page, fully scrolled, every film played | 9.06 MB |
| Of which video, none of it in the critical path | 5.21 MB |
| The hero, wide and narrow | 743 KB + 336 KB |

Nothing below the first screen is fetched until it is a screen away, and under
`prefers-reduced-motion` the motion layer is never fetched at all.

---

## 9. Credits

| | count | rate | credits |
|---|---|---|---|
| GPT Image 2, 2K, high — shipped | 2 | 7 | **14** |
| GPT Image 2, 2K, high — **discarded, submitted without their reference** | 2 | 7 | **14** |
| Seedance 2.0, 720p, 16:9, 5 s, no audio | 5 | 22.5 | **112.5** |
| | | **spent** | **140.5** |

Balance before 1 129, balance after **988.5**.

**Fourteen of those credits bought nothing and the reason is written down here
rather than rounded off.** The first pair of still requests went out with the
prompt and without the `medias` array, so GPT Image 2 had no reference and
invented a manor of its own. They were unusable for this project and were
resubmitted correctly. Nothing else was regenerated: all five sequences held
their framing for the whole five seconds and none was trimmed.

---

## 10. Two things worth reading the code for

### The picture that had been sitting there for five pages

`media_src/interiors/interiors_9.png` is a photograph of the first-floor landing
of the real Majori Manor. It has been in the library since the beginning. Five
pages were built out of that library — the Main Page, THE ESTATE, THE CLUB,
PADEL and EVENTS — and not one of them cut a single frame from it.

It is the only composition in the whole library in which a door is standing open
with a light on behind it, which is the entire subject of this page. The hero is
that photograph with the sun moved and a camera walked four metres down the
landing; the detail track's first frame is the same photograph, cut tall,
ungenerated.

Nothing about that is a technique. What a reader gets is a first screen that is
already indoors, already upstairs, and three metres from a door that is not
locked — before they have read a word.

### The grade is the story, and it is seven numbers

Every other film page on this site holds one hour and grades its material to
match it. This one is a stay, and a stay has a morning in it. So the five
sequences were not graded to a single exposure; they were graded to a **curve
through the day**, measured frame by frame:

```
29  →  46  →  41  →  62  →  57  →  31  →  48
```

The page gets darker for three screens, then comes up thirty points at once, then
walks back down. Read the numbers and you have read the page: you arrive in the
dark, you shut a door, you wake up, you spend an afternoon, the house goes quiet,
and somebody lights the fire.

Print the morning at the same exposure as the room before it and everything the
page is doing is undone by one step in the middle of it.
