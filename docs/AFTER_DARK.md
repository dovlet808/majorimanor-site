# Majori Manor — AFTER DARK

*The seventh page cut from the film, and the only one whose subject is the hour
itself.*

| | |
|---|---|
| Address | `/after-dark` |
| Template | `templates/pages/after_dark.php` — four lines |
| Content | `content/en/after_dark.php` |
| Layers | `home.css/js` → `estate.css/js` → `club.css/js` → `after-dark.css/js` |
| Media build | `tools/photos/build_after_dark_media.py` |
| Generated | 1 GPT Image 2 still, 5 Seedance 2.0 sequences |
| Credits | **121** (see §9) |

---

## 1. What it is

One page, ten screens, six acts — seven with a flag on — read top to bottom as
one evening.

| | Scene | Act / ground | Carries |
|---|---|---|---|
| 00 | **The night begins** | — | The manor from the lawn, after sunset — full screen, moving |
| 01 | **The salon** | evening · wine | *The first room is the quiet one.* — the lounge with the lamps already on |
| 02 | **Whisky & cigar** | heritage · mahogany | *Nobody is waiting for you to finish.* — and a cigar somebody put down |
| 03 | **What the room is made of** | heritage | Six close frames, panned. Nouns, not names |
| — | **Private gaming** | **park · green** | GATED on `ENABLE_GAMING`. A room, one picture, and the owner's line |
| 04 | **The quieter side** | interior · the pause | One photograph with nothing written on it, and one sentence |
| 05 | **The table** | evening · wine | *A table that runs long.* |
| 06 | **The conversation** | evening | *Some evenings are not events.* |
| 07 | **The house after dark** | estate · near-black | *And then the house is outside as well.* |
| 08 | **The estate** | **midnight · new** | Four places, four pages, one line each |
| — | **The invitation** | midnight | The seal, and two ways to write |

**THE PAGE GOES OUT, AND THAT IS THE WHOLE OF IT.** The six pages before this one
each hold an hour and grade their material to match it. This one holds the
passing of an hour, so the six full-bleed bands were graded to a descent —
**30.9 · 30.3 · 22.3 · 22.1 · 23.1 · 18.5**, measured on the frame the reader
actually sees (§5). It is monotonic except for one step of 1.0 between the
smoking room and the dining room, which is inside the width of the measurement
and is left there on purpose: a table with candles on it *is* marginally
brighter than a lounge at one in the morning, and grading that away would be
grading a lie. The hero is the brightest screen on the page and the last band is
the darkest moving screen on the site.

**It adds no component and it leaves two out.** THE ESTATE brought the walk and
the ledger; THE CLUB brought the lateral track and the dialogue; PADEL, EVENTS
and RESIDENCES brought none. This page is built entirely out of what those six
already approved — `film-hero`, `film-band`, `film-chapter`, `film-detail`,
`film-plates`, `film-world`, `film-invitation`, `film-nav`, `film-footer` and
the act wrapper — and it carries **no `film-ledger`** (no settled facts,
ARCHITECTURE §21) and **no `film-dialogue`** (that component is THE CLUB's house
of dialogue, and three pages already carry it).

**It does carry one component no other film page does, and only behind a flag.**
`components/clause.php` in its `standalone` form holds the owner's licensing
sentence. That field was written for this page and names it in its own header;
until now it had never been rendered on a page of acts.

**It adds one thing to the system and it is a colour.** `after-dark.css` §1
declares `--mm-midnight` — `#060506`, the darkest ground on the site — and the
last act stands on it. The argument is in §4 and mirrors RESIDENCES': that page
needed a ground *above* the range for a bedroom at sunrise, this one needs one
*below* it for a page that has to end further down than it started.

**There is less prose than there has ever been.** 340 words of body copy across
ten screens — about two thirds of what RESIDENCES says and a third of THE
ESTATE, and the shortest page on the site by a wide margin, as the brief asks.

**Five sentences survived word for word, because they are the approved ones:**
the title of the page, *In the evening the estate does not close so much as turn
inward*, *The light comes down and the colour goes deeper with it*, *There is
nothing to announce about it, which is most of the recommendation*, and *Some
evenings are not events.* The last has been promoted — it was a pull quote near
the end of the page this replaces and it is now the title of a scene.

**No sentence acquired a fact.** The forbidden list at the top of the content
file is the one that was already there, and one line was added to it: no hours,
no nights, no seasons, no prices, no capacities, no staff, no game, no table
count, no stake, no operator, **no named whisky and no named cigar** — and that
last rule now binds the pictures as well as the words (§3).

### The private gaming section, and what the rebuild changed about it

It is still the deferred module of ARCHITECTURE §14.2, still behind
`ENABLE_GAMING`, still false in production, and the gate is still a spread in
the content array rather than a branch in a template. With the flag off there is
no markup, no comment and no empty container — proved by byte comparison (§7).

**What changed is that it is now a whole act rather than two blocks.** On a page
of acts an act is a ground, and a gated scene sitting inside somebody else's act
would mean the flag changed which colours the page passes through. So it is an
act of its own, on the park's green — a colour nothing else on this page uses —
and with the flag off the page simply goes mahogany → pause ground, which is a
descent either way. Nothing above it or below it moves.

**It is the one scene without a number.** Every other scene carries a literal
index string, 01 to 08. A gated scene inside that run would leave a hole when the
flag is off or renumber six others when it is on — and no number is also the
honest treatment for the one room on the page that may turn out not to exist.

**The picture was chosen for what is not in it.** `CIGAR_HOUSE/vip_room.png` at
3:2 is a small panelled room with four leather armchairs, a low table, portraits
and a chandelier — and no gaming table, no felt, no cards, no chips and nobody
playing anything. It is the only frame in the library that is a private room
without being a picture of an activity.

---

## 2. The asset audit

All twelve directories of `media_src/` were inspected again, file by file.
**The library has grown by one directory since RESIDENCES was built** —
`MOTION/after-dark/`, which this page created — and by nothing else: the same
twelve top-level directories, the same 67 stills outside `Majori_logo/` and
`MOTION/`.

### The finding: this is the cigar house's page

Six pages have been cut out of this library and `CIGAR_HOUSE/` is the directory
they walked past. Of its nine files, one is a floor plan and seven of the
remaining eight had been used **exactly once each**, never at 16:9, never as a
sequence and never as the subject of a scene.

The audit was run as a map of *(source file → every ratio already cut from it)*
across all six build scripts, because a crop is the unit that can be duplicated,
not a file. It returns **nine landscape rooms in the whole library still free at
16:9**, and eight of the nine are in `CIGAR_HOUSE/` or in its two companions in
`ESTATE_and_HOSPITALITY/`:

| Free at 16:9 | Where it went |
|---|---|
| `CIGAR_HOUSE/whisky_lounge.png` | **`ad-salon`** — scene 01, and nothing had ever moved it |
| `ESTATE_and_HOSPITALITY/CIGAR_LOUNGE.png` | **`ad-cigar`** — scene 02, and the smoke is already in the frame |
| `CIGAR_HOUSE/cigar_lounge.png` | **`quiet`** — scene 04, the silent band |
| `RESTAURANT/dining_salon2.png` | **`ad-table`** — scene 05, the only dining room in the material with a fire lit in it |
| `ESTATE_and_HOSPITALITY/MANOR_BAR.png` | the detail track, at 3:4 |
| `CIGAR_HOUSE/main_bar.png` | the world index, at 4:5 |
| `CIGAR_HOUSE/whisky_collection.png` | the detail track, at 3:4 |
| `CIGAR_HOUSE/humidor_display.png` | the detail track, at 3:4 |
| `CIGAR_HOUSE/atmospheric_details.png` | the detail track, at 3:4 |

| Directory | Files | Kind | Used here | Used before |
|---|---|---|---|---|
| `CIGAR_HOUSE/` | 9 | visualisations | **5** — whisky_lounge, cigar_lounge (×2 crops), main_bar, whisky_collection, humidor_display, atmospheric_details, vip_room | every one of them once, and never at these ratios |
| `ESTATE_and_HOSPITALITY/` | 7 | visualisations | **2** — CIGAR_LOUNGE, MANOR_BAR | CIGAR_LOUNGE at 4:5 on EVENTS, MANOR_BAR at 3:2 on home |
| `HOUSE_OF_DIALOGUE/` | 3 | visualisations | **3** — 1, 2, 3 | all three, at 16:9 and 4:5; **3:2 had never been cut from any of them** |
| `RESTAURANT/` | 7 | visualisations | **1** — dining_salon2 | PADEL at 4:5 |
| `PRIVATE_CLUB_ECOSYSTEM/` | 12 | visualisations | **2** — 2, 3 | 2 at 4:5 on home; 3 at 16:9 on PADEL — see §8 |
| `estate/` | 4 | photographs | **1** — estate_4 | THE ESTATE at 4:3, RESIDENCES at 3:2 |
| `interiors/` | 15 | photographs | **1** — interiors_9 | RESIDENCES at 3:4; **4:5 had never been cut** |
| `Majori_logo/` | 21 | brand | **2** — seal-cream, seal-gold | all six film pages |
| `MOTION/after-dark/` | — | this page's references, still and masters | its own | — |
| `pavilion/`, `grand-staircase/`, `heritage-details/` | 10 | photographs | 0 | THE ESTATE · EVENTS · RESIDENCES |

### What the audit found that six pages had walked past

**`ESTATE_and_HOSPITALITY/CIGAR_LOUNGE.png` has smoke in it and nothing had ever
moved it.** Three portraits under picture lights, two chimneypieces with a fire
in one, leather drawn round it, and a lit cigar resting on a marble table beside
a glass with a thin ribbon of smoke coming off it. EVENTS prints a 4:5 of it as
one tile in a world index. It is the only frame in the entire library that
already contains the one thing the brief asks Seedance for by name — *delicate
smoke movement* — and it had been used once, small, as a link.

**`CIGAR_HOUSE/whisky_lounge.png` is a private members' salon and had only ever
been cut narrow.** The Main Page takes a 3:2 and RESIDENCES a 4:5. Cut wide it
is a coffered ceiling, a portrait over a chimneypiece, two lamps, a wall of lit
shelves, a bar and four chesterfields — which is the first room this page needed
and the room the whole page is about.

**`RESTAURANT/dining_salon2.png` is the only dining room in the material with a
fire lit in it.** THE CLUB moves `dining_salon.png` and EVENTS moves
`Restaurant_1.png`; this is the third, PADEL prints a 4:5 of it, and nothing had
cut it wide. Two rooms laid for dinner and one room laid for dinner with a fire
going are different hours.

**`HOUSE_OF_DIALOGUE/` had never been cut at 3:2.** All three files are on the
Main Page and THE CLUB at 16:9 and 4:5. The great hall at 3:2 is the same
conversation with the chandelier and the stair standing over it; the library at
3:2 is the fire with the bookcases either side of it.

### What was deliberately not used

- **`CIGAR_HOUSE/outdoor_terrace.png`** — the lit evening terrace, which is the
  obvious fifth cigar-house frame. THE CLUB already moves it in its dialogue and
  the Main Page prints it; 16:9 and 3:2 are both taken.
- **`CIGAR_HOUSE/vip_room.png` at 16:9 and 4:5** — EVENTS' and the Main Page's,
  and THE CLUB's own `club-members` sequence is a push through this room. The
  3:2 taken here is a crop nothing has cut, and it appears only behind the flag.
- **`interiors/interiors_3.jpg`, the great hall by lamplight.** The best low-light
  photograph of the real house, the frame the *old* `/after-dark` used, and on
  the Main Page twice and moved by THE ESTATE.
- **`interiors/interiors_1.jpg`, the lit fire and the chess table.** A chess board
  by a fire is a tempting picture for a scene about private gaming and it is
  RESIDENCES' `res-evening` sequence, THE ESTATE's `est-hearth` sequence, a Main
  Page plate and a `build_images.py` slot. Four crops of it already ship.
- **`MOTION/events/still-wedding.png` and the other pages' generated stills.**
  They are those pages'.

Nothing was excluded for quality.

---

## 3. What was generated, and from what

**One still and five sequences.** Every one descends from a file in `media_src/`,
and every prompt is in `tools/photos/build_after_dark_media.py` verbatim, because
a prompt is the only part of a generated asset that cannot be recovered by
looking at it.

### The crops the generations start from

| Reference | From | Crop |
|---|---|---|
| `ref-nightfall` | `estate/estate_4.jpg` | 16:9 at bias 0.48 → 1055 × 593 |
| `ref-salon` | `CIGAR_HOUSE/whisky_lounge.png` | 16:9 at bias 0.42 → 2048 × 1152 |
| `ref-cigar` | `ESTATE_and_HOSPITALITY/CIGAR_LOUNGE.png` | 16:9 at bias 0.46 → 1449 × 815 |
| `ref-table` | `RESTAURANT/dining_salon2.png` | 16:9 at bias 0.22 → 2160 × 1215 |
| `ref-garden` | `PRIVATE_CLUB_ECOSYSTEM/3.png` | 16:9 at bias 0.42 → 2048 × 1152 |

### The still — GPT Image 2, 2K, high, 16:9, from a reference

| Still | From | What changed | What did not |
|---|---|---|---|
| `still-nightfall` | `ref-nightfall` | The hour. Midday under a blue sky → late evening: warm lamplight in eleven windows, several of them dark; low uplighting on the columns and the granite plinth; a lantern under the portico; the render into cool shadow; the roof near-black; the lawn in deep shadow; **and the two figures on the steps gone** | The roof and its five chimneys, the dormer, every window opening, the balcony and its curved iron balustrade on the curved bay, the portico, the pediment, the oculus, the plinth, the young tree, the camera |

**THE SITE HAD NO NIGHT PHOTOGRAPH OF THE HOUSE AND NOW IT HAS ONE.** That
absence has been written into `tools/photos/build_images.py` since the first
build — *"after-dark/hero wants the manor at night and NO NIGHT FRAME OF THE
HOUSE EXISTS"* — and the slot stood as a hatched box on this page for the whole
of the project. The two night frames in the library are the pavilion, which is
EVENTS' subject and already opens two pages, and one interior 1178px wide against
a hero rung of 1280. So the hour was moved on the one wide photograph of the
garden front, and every noun in the prompt is a noun in `estate_4.jpg`.

**What the model added, stated rather than hidden:** the four portico columns
came back with Ionic volutes where the photograph shows plain Tuscan capitals,
and the entrance came back as a pair of panelled doors under a lantern where the
photograph shows one doorway in shadow. Both are small, both are at the far right
of a frame whose subject is the lit windows, and both were left rather than spend
a second generation on a detail that is about 40px wide at the rung the hero
ships at. Recorded again in §8.

### Sequences — Seedance 2.0, 720p, std, 16:9, 5 s, no audio, `start_image`

| Sequence | Start image | Motion |
|---|---|---|
| `ad-nightfall` (hero) | `still-nightfall` | Extremely slow approach across the lawn; the house grows and the portico opens; the young tree passes in parallax. **The camera stays out on the lawn.** |
| `ad-salon` | `ref-salon` | Slow push forward and slightly right toward the lit shelves and the bar; lamplight breathing, reflections travelling on glass and leather |
| `ad-cigar` | `ref-cigar` | **Almost no camera at all.** Smoke rises off the cigar, drifts, curls and dissolves; the fire breathes; the glass never moves |
| `ad-table` | `ref-table` | Slow dolly between the laid tables toward the fire; candle flames in the chandelier and on the cloths |
| `ad-garden` | `ref-garden` | Slow lateral drift right along the lit path; the rotunda opens, foliage stirs, light travels on wet stone |

**`START_IMAGE` and not `image_references`, on all five** — EVENTS' rule, kept by
RESIDENCES, and the only setting under which a coffered ceiling, a wall of
several hundred labelled bottles and a laid table survive five seconds of camera
movement. It is also what makes the poster honest: frame 0 of the encode *is* the
reference, so the still and the film cannot re-frame against each other when the
video fades up.

**Nothing was trimmed and nothing was regenerated.** All five held their framing
for the whole five seconds, and every one of the 121 credits spent bought
something that shipped.

### Three prompt lines did the work, and all three are limits rather than descriptions

> **"The camera stays out on the lawn and never reaches the house."**
> RESIDENCES' finding restated for a building. Asked to approach, this model
> arrives, and a hero that arrives has nowhere to be for the second half of its
> loop. Naming the limit rather than the speed is what keeps five seconds of
> dolly inside one composition.

> **"No bottles moving."**
> A wall of several hundred labelled bottles is the hardest thing in this library
> to hold still: it is exactly the kind of repeated small detail a video model
> re-invents frame by frame. Naming it as a thing that must not happen is what
> kept the shelves a photograph of shelves.

> **"No hands. No glass or cigar moving, lifting or being picked up."**
> A lit cigar and a poured drink is the exact shot a video model wants to
> complete by putting a person into it, and a hand entering that frame would turn
> a private room into an advertisement for a drink.

### `ad-cigar` is the one sequence on the site whose subject is not the camera

Every other film on these seven pages is a room and a move through it. This one
is a room that is *not* moved through: the camera is nearly locked off, and the
only thing that happens in five seconds is that smoke rises off a cigar somebody
put down and a fire breathes in a grate. The brief asks for delicate smoke
movement; this is the one frame in the library that already had smoke in it, so
the generation had nothing to invent — it only had to let it drift.

### The rule that bound a crop rather than a caption

`content/en/after_dark.php` has forbidden a named whisky since the page was first
written: *"a named whisky is a promise that a particular bottle is on a
particular shelf in a room that is not finished, and it is the easiest false
statement on this site to make by accident."* That has always been read as a rule
about copy.

`CIGAR_HOUSE/whisky_collection.png` has two labelled bottles standing in the
middle of it, and at 864px **the marque, the expression and the age on both of
them are fully legible**. The first cut of `detail-whisky` shipped them.

A 2592-wide panorama cut to 3:4 is 864 across and leaves 1728px of travel, so the
answer was to move rather than to drop the frame: **bias 0.115** is the left-hand
glass on the dark bar top with nothing but bokeh behind it, and there is no
readable lettering anywhere in it. The caption is *"A glass, put down"*, which is
what it is. Every other frame on the page was then re-checked at full size; the
cigar bands in `detail-humidor` carry illegible ornament and no brand.

**One thing this check found outside the page, reported and not touched:**
`assets/img/residences/world-dark-640.jpg` — RESIDENCES' After Dark tile, cut
from the same panorama — shows *THE BALV…* and *AGED 15 YEA…* legibly. That page
is approved and out of scope. It is a one-line fix in
`build_residences_media.py` (bias 0.42 → about 0.10) whenever the owner wants it.

### The honesty marking

| Value | Count | What |
|---|---|---|
| `photo` | 2 | The garden front, and the first-floor landing |
| `render` | 13 | The whisky lounge, the cigar lounge (twice), the manor bar, the humidor, the bottles, the chair, the private room, the great hall, the library, the stair, the bar, the dome |
| `generated` | 5 | The five sequences and their posters |
| `mood` | **0** | — |

**The page this replaces declared all three of its pictures `mood`, and its own
header argued that this was permanent.** That rule is kept and the value is gone,
which is RESIDENCES' finding applied here: `mood` is the licence to stand a
reference image in a slot and say nothing about it, and what this page does
instead is say what every picture actually is. Every caption was written against
the rule the old header set — **no caption names a room the estate has open, an
hour, a service, a bottle, a cigar or a game** — and every one of them was
re-read against it after the crops were final.

---

## 4. What was built, and what was reused

### Reused unchanged

`film-hero`, `film-band`, `film-chapter`, `film-detail`, `film-plates`,
`film-world`, `film-invitation`, `film-nav`, `film-menu`, `film-footer`,
`film-acts`, `clause` (standalone), the act grounds and seams, the grain, the
reveals, the smooth scroll, the anchor easing, the band attach/release, the plate
settle and the lateral track. Twelve components, five motion files, and not one
of them was edited.

### `after-dark.css` — 5 sections, 25.2 KB raw / 9.1 KB gzip

| § | What | Why |
|---|---|---|
| 1 | `--mm-midnight` and `.c-act--midnight` | The bottom of the night. See below |
| 2 | The hero's two measures, its scrim, and the eyebrow's wash | Six words where every other film hero has two or four; centred copy over a lit facade |
| 3 | The standalone clause on an act's ground | A component that had never stood on a page of scenes |
| 4 | Two object-positions below 900px | The hero's crop and the garden's |
| 5 | The band overlay's measured wash, then the narrow pass | The one element that failed AA (§6), the silent band's ratio, the heading-only chapter, the CTA's tracking |

### `after-dark.js` — one job, 5.2 KB raw / 2.3 KB gzip

The camera on the one band that is a photograph: a 7% scale scrubbed to the
scroll. It is `residences.js`'s job, copied, which is `events.js`'s, which is
`padel.js`'s, and the argument for copying twenty lines rather than loading a
page's whole stylesheet for one of its rules is in the header of all four files.

**The silent band is included deliberately.** Act four is the page's pause — one
photograph with no scene number, no eyebrow, no title and no caption. On a page
where every other full screen has a camera in it, a photograph that does not move
reads as a picture that failed to load.

### The seventh ground, and why it is in this file

`estate.css` §1 declares five grounds; RESIDENCES added a sixth at the **top** of
the range (`--mm-dawn`, for a bedroom at sunrise). This page adds one at the
**bottom**, and the argument is the mirror image.

`--mm-estate` (`#0B0A08`) is the Main Page's floor: the black it opens on, the
black THE ESTATE stands its gates on, and the black every film page has ended on.
That is right for six pages whose last screen is the same temperature as their
first. It is wrong for a page whose whole argument is a descent — a page that
finishes on the ground the Main Page starts on has not taken the reader anywhere.

| | |
|---|---|
| A real step down | `#060506` against `#0B0A08` — about 45% of the luminance, the same size of step that separates `--mm-estate` from `--mm-interior` in the other direction |
| Still a ground and not black | Below this there is only `#000`, and pure black is not a ground on this site: the grain in `home.css` §2 has nothing to sit on and the act seams stop reading as washes |
| Still the brand's colour | The same near-black, cooled by one point of blue rather than warmed — the one place on the site where the palette goes cold, on the last screens of a page about being outdoors at night |
| Type clears by more than anywhere else | `--ink` 18.9:1, `--gold-ink` 9.9:1, `--ink-muted` 9.7:1, `--ink-faint` 5.8:1 — every one higher than on any other ground, because this is the darkest one. The page's contrast floor is therefore never on this act |
| Declared here and nowhere else | `estate.css` is untouched, so the five approved pages that load it are byte-identical. `asset_url()` cache-busts on `filemtime` |

**What it does not reach, stated rather than left to be noticed.** `.c-film-invite`
paints its own ground — `--ground-raised` under a mahogany radial — and
`home.css` §11 says why in as many words: *"a mahogany that only ever appears
here makes the last screen read as a room rather than as a footer."* True on six
approved pages and true here, so it is left alone. The darkest screen on this
page is therefore the **world index** and not the last one, which is the right
place for it: scene 08 is the reader standing outside in the dark looking back at
four lit rooms, and the invitation after it is the door being opened again.

### The hero title breaks two ways, and the measure is the switch

The brief draws the headline as a couplet — AFTER DARK / THE HOURS THE ESTATE /
KEEPS FOR ITSELF — and that is the right composition on a wide screen. It is the
wrong one on a phone. Measured in the real face at 73.1px, where the clamp tops
out, "THE HOURS THE ESTATE" sets 978px wide and "THE HOURS THE" sets 656px:

| Width | The couplet | The measure | Result |
|---|---|---|---|
| 1920 · 1440 · 1120 | 978px | ~1040–1344px | **two lines** |
| 1024 | 978px | ~944px | three lines |
| 768 | 524px at 58px type | ~700px | three lines |
| 430 · 390 · 375 | 432px at 32px type | 335–390px | three lines |

So `max-width` is set in **em on the title's own type** — 9.4em holds "THE HOURS
THE" and breaks three ways, 13.7em holds the couplet and breaks two ways, and one
media query at 1120px chooses. One property, two values, and the type ladder
never changes. Forcing the couplet at 375 would have cost a third of the type
size to buy it.

---

## 5. The grade, and the descent it exists to make

**Every encode on this page carries a grade and the curve is a gamma, not a
brightness offset.** `eq=brightness` subtracts a constant from every pixel, which
lifts nothing and *crushes* the shadows — acceptable on material shot in
daylight, fatal on five frames that are ninety percent shadow already.
`eq=gamma` bends the midtones and leaves black at black.

All five are matched by **measurement**: mean luminance of frame 0 of the encode.

| Sequence | Raw | Encoded | Sitting beside |
|---|---|---|---|
| `ad-nightfall` | 33.9 | **30.9** | A hero. EVENTS' own is 31.0, RESIDENCES' 28.5 |
| `ad-salon` | 33.4 | **30.3** | The hero, one step under it |
| `ad-cigar` | 24.9 | **22.3** | Deeper into the same house |
| `ad-table` | 48.5 | **23.1** | The brightest thing generated for this page, brought to the plateau |
| `ad-garden` | 29.1 | **18.5** | Nothing. It is the darkest moving screen on the site |

Read down the six full-bleed bands in page order and the arc is an evening:

```
30.9  hero        the manor, the last of the light
30.3  scene 01    the salon, lamps on
22.3  scene 02    the smoking room
22.1  scene 04    the pause
23.1  scene 05    the table, candlelight
18.5  scene 07    outside, the middle of the night
```

**`ad-table` is the one that pays for the arc.** 48.5 raw down to 23.1 — a
twenty-six point drop, and the value was chosen by rendering gamma 1.00, 0.78,
0.696 and 0.62 side by side rather than by arithmetic: at 0.62 the panelling goes
to mud, at 0.78 the room is a lit restaurant, and at 0.66 it is a dining room
with candles in it. The one place the descent moves at all is between scene 02
and scene 05, where the two arrive 0.8 apart in the other order; a table with
candles on it is marginally brighter than a cigar lounge at one in the morning
and grading that away would be grading a lie.

### The still curves

| Curve | Value | Used on |
|---|---|---|
| `DEEP` | `(0.435, 0.83)` | `build_club_media.py`'s own — the silent band, the stair, the great hall |
| `LOW` | `(0.30, 0.56)` | **new** — a lit close-up brought to the track's plateau: the humidor and the glass |
| `SHADE` | `(0.22, 0.40, (1.0, 0.95, 0.86))` | **new** — a lit room seen from outside its own hour: the dome |
| `NIGHT` | `(0.15, 0.28, …)` | `build_residences_media.py`'s own — unused in the end |
| `MIDNIGHT` | `(0.11, 0.21, (1.0, 0.93, 0.80))` | **new** — the garden front and the landing, on the darkest ground on the site |

**The grades are the lightest of the seven build scripts, and that is the point.**
Every room on this page is a room photographed at night: the cigar-house
visualisations are lit by lamps, fires and picture lights against dark timber and
measure between 18 and 30 at their own exposure, which is exactly where this film
runs. Six of the seventeen plates are ungraded. The curves exist for the three
pictures that arrived from another hour — a white manor house under a noon sky,
the brightest visualisation in the library, and a daylight photograph of a
landing — all three of which are world tiles on `--mm-midnight`.

### Every group, measured

| Group | Range | Ratio |
|---|---|---|
| The six bands | 18.5 – 30.9 | 1.67 — **the descent, deliberately** |
| The six track frames | 18.5 – 28.6 | 1.55 |
| The three act plates | 23.8 – 34.0 | 1.43 |
| The four world tiles | 20.2 – 25.1 | **1.24** — the tightest group on the site |

The rule everywhere except the bands is EVENTS': no picture in a group arrives
more than about half again as bright as the darkest one beside it. The bands
break it on purpose, and that break is the page.

---

## 6. Legibility, measured

Same harness, same method, same three rules as EVENTS and RESIDENCES —
`tools/measure_contrast.js`, sampling the **95th-percentile brightest background
pixel each element's letters actually cross**, glyphs made transparent rather
than hidden, `Range.getClientRects()` rather than the border box, and the page
driven by real wheel events so Lenis moves it as a reader does.

**Two selector groups were added to the harness with this page** — `.c-detail__*`
and `.c-clause p`. The lateral track arrived with THE CLUB and the standalone
clause has only ever appeared on `/after-dark`, and neither was in the list: three
pages' detail captions and one page's legal line were being swept past rather
than measured. Both are text on a ground like everything else.

### One thing had to change and it is a number, not a taste

| Where | Before | After | What changed |
|---|---|---|---|
| `.c-film-band__index` on the salon band, at **1920 × 1080 only** | **4.01** | 4.9+ | `after-dark.css` §5a — an 18% wash on the top third of the overlay box |

**1920 is where it happens because of what the overlay is.** `club.css` §1c gives
the box `padding-top: clamp(4rem, 12vh, 9rem)`, so the taller the viewport the
further the scene number stands above the copy under it — and that file's own
gradient is 88% black at the foot of the box and only 44% at the top. At 1080
tall the number sits 153px up, on 44%, directly under the lit whisky shelves,
which are the brightest thing on this page's second screen. At 1440 the same
element on the same band measures 6.7.

**And the fix is 18%, which is arithmetic rather than taste.** To take 4.01 to
4.5 the background under those letters has to come down from 0.0646 to 0.052
relative luminance — a factor of 0.80 in linear light, therefore about 0.91 in
sRGB, therefore a black wash of nine percent. Eighteen gets it to about 4.9,
which is a margin rather than a hair's breadth, and it is small enough that the
picture behind the number does not visibly change. It is a **second** wash
hanging off the overlay box rather than a restatement of `club.css`'s four
stops — which is the argument that file makes for its own existence — and it
fades out entirely by 62% of the box's height, so the eyebrow, the title and the
caption all still stand on `club.css`'s own 74% and 88%.

**Result, swept across the whole page at 375, 390, 430, 768, 1024, 1440 and 1920**
— every text element, sampled at 18 scroll positions each:

| Width | line boxes measured | below AA | lowest |
|---|---|---|---|
| 375 × 812 | 187 | **0** | `.c-film-band__caption` 4.81 |
| 390 × 844 | 182 | **0** | `.c-film-band__caption` 4.81 |
| 430 × 932 | 195 | **0** | `.c-film-band__caption` 4.81 |
| 768 × 1024 | 142 | **0** | `.c-film-hero__cue span` 4.81 |
| 1024 × 768 | 131 | **0** | `.c-film-band__caption` 4.81 |
| 1440 × 900 | 127 | **0** | `.c-film-band__caption` 4.81 |
| 1920 × 1080 | 129 | **0** | `.c-film-band__caption` 4.81 |

**Nothing on this page is below AA at any width, and the floor is higher than
either of the two pages before it.** 4.81 against RESIDENCES' 4.61 and EVENTS'
4.57 — because the floor element is `--ink-faint` on an act's own ground, and
this page's grounds are the darkest on the site.

**The hero eyebrow never became a problem, and the reason is worth writing down.**
On PADEL, EVENTS and RESIDENCES the first-screen eyebrow was the measurement that
failed — gold at 10.6px over a lit dome, a lit terrace, a lit corridor — and each
page answered it with a soft ellipse behind the line. That ellipse is here too
(§2c), applied at every width and invisible at most of them. What is different is
that this hero's copy stands on a **lawn in deep shadow** rather than on the lit
part of the picture: the crop at 76% puts the portico and the balcony in the
window and the type below both of them. The eyebrow measures above 8:1 at 390.

---

## 7. Verification

Run against the built page on `php -S 127.0.0.1:8321 -t public_html
tools/serve_router.php`.

| # | Check | Result |
|---|---|---|
| 1 | All twelve `media_src/` directories inspected, file by file | ✅ §2 |
| 2 | Every generated still descends from a named `media_src/` file | ✅ §3 — 1 of 1 |
| 3 | Every Seedance sequence has a documented start image | ✅ §3 — 5 of 5 |
| 4 | No unsupported architecture introduced | ✅ every prompt is a preservation instruction; the two additions are named in §3 |
| 5 | No unsupported factual claim added | ✅ §1 |
| 6 | Private gaming is static and informational only | ✅ no game, no table, no stake, no hour, no operator, no interaction; the owner's licensing line verbatim |
| 7 | `ENABLE_GAMING = false` leaves no trace | ✅ 37 041 bytes, six acts, zero occurrences of *gaming*, *licensing*, *clause* or *green* in view-source |
| 8 | Main Page byte-identical | ✅ `tools/compare_pages.sh` |
| 9 | THE ESTATE byte-identical | ✅ |
| 10 | THE CLUB byte-identical | ✅ |
| 11 | PADEL byte-identical | ✅ |
| 12 | EVENTS byte-identical | ✅ |
| 13 | RESIDENCES byte-identical | ✅ |
| 14 | CONTACT, MEMBERSHIP, PRIVACY, TERMS, 404, styleguide, components byte-identical | ✅ |
| 15 | Zero broken images | ✅ 0 of 22, at all seven widths, after a full scroll |
| 16 | Zero 4xx/5xx responses | ✅ |
| 17 | Zero console errors or warnings | ✅ |
| 18 | Zero horizontal overflow | ✅ `document.scrollWidth === window.innerWidth` at every scroll stop, at all seven widths |
| 19 | Every text element clears AA | ✅ §6 — 0 below AA at seven widths |
| 20 | Navigation active state | ✅ `AFTER DARK` carries `aria-current="page"` and `.is-current`, in the bar and in the sheet |
| 21 | Hero film attaches and plays | ✅ 1280 wide / 854 narrow, after the load event |
| 22 | Band films attach on approach and release behind | ✅ 5 of 5 |
| 23 | Reduced motion loads no library at all | ✅ 0 of 7 motion scripts fetched; 0 of 5 video sources attached; 1 523 KB total |
| 24 | Reduced motion shows the whole page | ✅ 636 words, 40 of 40 revealed elements at full opacity, 6 of 6 track frames as a plain grid |
| 25 | No JavaScript at all | ✅ identical to 24, and `has-js` absent |
| 26 | The lateral track reaches its last frame by scrolling | ✅ frame 06, track at x = −1278 |
| 27 | Lazy loading | ✅ 20 of 22 images `loading="lazy"`; the two eager ones are the hero poster's `<picture>` |
| 28 | The page runs top to bottom, rendered, at 1440 × 900 | ✅ 14 825px of document, 16 stops |
| 29 | Mobile rendering | ✅ 375 / 390 / 430 / 768 / 1024 / 1440 / 1920, rendered and read |

### What the snapshot harness proved

```
PAGE           RESULT            BEFORE      AFTER
after_dark     CHANGED*           37497      39257
club           IDENTICAL          42450      42450
components     IDENTICAL          52111      52111
contact        IDENTICAL          13963      13963
estate         IDENTICAL          38684      38684
events         IDENTICAL          41046      41046
home           IDENTICAL          52790      52790
membership     IDENTICAL          18506      18506
notfound       IDENTICAL           5918       5918
padel          IDENTICAL          39955      39955
privacy        IDENTICAL          13788      13788
residences     IDENTICAL          45342      45342
styleguide     IDENTICAL          44427      44427
terms          IDENTICAL          10155      10155

PASS — every page except after_dark is unchanged.
```

**Two files this work touched are shared and neither of them re-versions
anything.** `templates/partials/head.php` gained one row in `$filmPages`, which
is an array key the other twelve pages never read — the snapshot above is the
proof, taken with the row removed and again with it in place.
`tools/photos/build_images.py` lost one slot entry, and it was **not run**: that
script rewrites every file it declares and therefore changes every `filemtime`,
and `asset_url()` cache-busts on `filemtime`. Running it would have re-versioned
several dozen URLs in six approved pages' markup to delete two files. The two
files were deleted by this page's own `retire_old_page()` instead.

### The mobile pass

Not a stack of the desktop page. What actually changes below 900px:

- **The hero title breaks three ways instead of two** — one `max-width`, chosen
  by measurement (§4)
- **The hero crop moves to 76%**, chosen by rendering 62 / 70 / 76 / 82 side by
  side at 390px: the portico, the balcony and the lit bay in one window
- **The garden band crops to 64%**, so the rotunda and the lamp are both in frame
  rather than a lamp and a hedge
- **The silent band turns portrait** — 4:5 instead of 16:9, because a 16:9 frame
  at 390px is 219 pixels tall and a silent picture that small reads as a picture
  that failed rather than as a pause
- **The lateral track becomes a two-column grid** — `club.js` does not take the
  stage below 900px at all, which is the vertical form of the same story
- **Every band overlay carries its own gradient**, one step deeper than
  RESIDENCES' because all four of these frames have their light source in the
  bottom third
- **Nothing depends on hover.** There is no hover state anywhere on this page
  except the world index's plate lift, which discloses nothing

---

## 8. Limitations

1. **`ad-garden` shares its composition with PADEL.**
   `PRIVATE_CLUB_ECOSYSTEM/3.png` is the only photograph of the estate's own park
   at night in the whole library, and a 2048 × 1360 frame cut to 16:9 has 208px
   of vertical travel in it — so no bias makes a second picture out of it. PADEL
   prints this framing as a still; here it moves, and it is graded from 29.1 to
   18.5 against PADEL's own value. The alternatives were both worse: dropping the
   scene, or generating a second garden, which is the one thing the brief forbids.

2. **The hero's portico is not quite the photograph's portico.** Ionic volutes
   where the reference has Tuscan capitals, and a pair of doors under a lantern
   where the reference has one doorway in shadow. About 40px wide at the rung the
   hero ships at, and left rather than regenerated. §3.

3. **Four track frames ship at 640 and their own native width** — 864, 842, 864
   and 864 — rather than at the site's 960 rung, because four of the six are cut
   out of panoramas only 1152px tall and a 3:4 crop of one is 864 across. Nothing
   is upscaled. `club.css` sizes a track frame at 416 CSS pixels at its widest,
   which is 832 device pixels on a 2x screen, so 864 covers it and 640 would have
   been 23% short. The ladder is the honest pair; it is not a standard rung.

4. **`world-estate` ships at 640 alone** — a 1055-wide frame cut to 4:5 is 797
   across. That is the library being what it is.

5. **`estate.css` §2 and §3 and `club.css` §3 are dead weight on this page.**
   About six hundred lines of the walk, the ledger and the dialogue match nothing
   here, and all three motion jobs return on their first line because none of
   `[data-walk]`, `[data-ledger-row]` or `[data-dialogue]` is in the DOM. That is
   the price of not forking a shared file, and it is the right price for PADEL's
   reason: the bytes are already in the reader's cache from the pages that do use
   them.

6. **RESIDENCES' After Dark tile shows a legible whisky label.** Found while
   checking this page's own crops against the same rule, reported in §3, and not
   touched: that page is approved and out of scope.

7. **`private/config.php` on this machine has `ENABLE_GAMING = true`**, which is
   how it was found and how it was left, so the gated act can be reviewed
   locally. Production and the committed sample are both `false`, and §7 check 7
   is the proof that `false` leaves nothing behind.

8. **Nothing on this page is a photograph of a room the estate has open**, because
   there is not one. Every interior is either a visualisation of what will be
   there or a generation that changed the hour of a photograph of the building.
   The captions say so, and not one of them names an hour, a service, a bottle, a
   cigar or a game.

### Weight

| | Raw | Gzipped |
|---|---|---|
| `after-dark.html` | 38.3 KB | 7.0 KB |
| `after-dark.css` | 25.2 KB | 9.1 KB |
| `after-dark.js` | 5.2 KB | 2.3 KB |
| The four stylesheets together | 228.9 KB | 62.7 KB |
| The motion layer (injected at the load event) | 238 KB | — |

| | |
|---|---|
| First screen — HTML, CSS, fonts, the two eager images | **508 KB** |
| The whole page, fully scrolled, every film played | 8.00 MB |
| Of which video, none of it in the critical path | 6.14 MB |
| Under `prefers-reduced-motion`, fully scrolled | **1.52 MB** |
| The hero, wide and narrow | 675 KB + 296 KB |

Nothing below the first screen is fetched until it is a screen away, and under
`prefers-reduced-motion` the motion layer is never fetched at all.

---

## 9. Credits

| | count | rate | credits |
|---|---|---|---|
| GPT Image 2, 2K, high, 16:9, from a reference | 1 | 7 | **7** |
| Seedance 2.0, 720p, std, 16:9, 5 s, no audio | 5 | 22.8 | **114** |
| | | **spent** | **121** |

Balance before **988.5**, balance after **867.5**.

**Nothing was discarded and nothing was regenerated.** Every credit spent bought
an asset that ships. The still came back with the architecture intact on the
first request, and all five sequences held their framing for the whole five
seconds — which is what a prompt written as a preservation instruction buys, and
it is the first page in this project where that was true of every generation.

---

## 10. Two things worth reading the code for

### The directory six pages walked past

`media_src/CIGAR_HOUSE/` has been in the library since the beginning. Six pages
were built out of that library — the Main Page, THE ESTATE, THE CLUB, PADEL,
EVENTS and RESIDENCES — and each of them took one frame from it, small, as a tile
or a plate. Not one of them cut a wide frame from any of the eight usable files,
and not one of them moved a camera in any of those rooms.

The audit that found this is not a list of files; it is a map of *(file → every
ratio already cut from it)* built across all six build scripts, because a **crop**
is the unit that can be duplicated and a file is not. It returns nine landscape
rooms in the whole library still free at 16:9, and eight of them are the cigar
house and its two companions.

What a reader gets is a page whose four interior sequences are four rooms nobody
has been shown moving before, on a site with twenty-four sequences already on it.

### The measurement that turned into a content rule

`content/en/after_dark.php` has forbidden a named whisky since the day it was
written, and everybody who has read that file has read it as a rule about
sentences. The first cut of this page's detail track put a bottle in the frame
with *THE BALVENIE · SINGLE BARREL · AGED 15 YEARS* legible at 864px — an
inventory claim about a room that is not finished, made in a photograph, on a
page whose own header forbids exactly that in words.

The fix is one number: bias 0.115 instead of 0.62, which moves the crop 1200
pixels to the left and lands on a single glass on a dark bar top with nothing but
bokeh behind it. It is a better picture as well as a legal one — *A glass, put
down* is what this page is about, and a shelf of named bottles is what it is not.

The rule is now written into the content file as binding the pictures, and the
same check found the same problem on an approved page (§8). A rule that only
governs copy governs half the page.
