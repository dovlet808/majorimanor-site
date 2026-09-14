# Majori Manor — MEMBERSHIP

The ninth page cut from the film, and the last gate on the site.

**Status:** built, measured and run locally. Not yet seen by the CEO.
**Route:** `/membership` · **Page id:** `membership` · **Mood:** `night`
**Scope:** `/membership` only. The eight approved pages are proved byte-identical
— see §7.

| | |
|---|---|
| Scenes | 10 (hero + 9) |
| Pictures | 10 — 8 plates, 2 sequence posters |
| Sequences | 2 (the brief's ceiling) |
| Generated | 1 GPT Image 2 still, 2 Seedance 2.0 sequences |
| Credits spent | **51.5** (734.5 → 683.0) — see §10 |
| New components | 1 (`film-letterhead`) |
| New grounds | **0** |
| Page weight | 2.33 MB whole page, raw — the second lightest film page |

---

## 1. What it is

The current page was **functional and looked like a form**. It opened on a
coloured band with a heading in it, printed the crest at 140 px, set three
paragraphs and a five-row facts list, and ended on the application. Everything it
SAID was approved. Nothing it said has been changed.

What changed is that it now walks a reader from the dark of the park to a lit
door and hands them an application at the end of it.

### The order is the argument

```
00  the threshold   the house at night, from inside the trees — moving
01  one membership  what the arrangement is
02  the world       the five parts of the estate, one behind the other
03  belonging       the park at night, and one sentence on it
04  members         that members bring guests, and two rooms
05  applications    how they are handled — the anxious paragraph
06  the letterhead  the seal, two rules, and the estate's address
07  the application the form
08  the house       the hall on an evening — moving
09  the invitation  one line, and two ways on
```

### The grounds are the brief's own progression

| Scenes | Ground | Hex | |
|---|---|---|---|
| hero, 01 | `estate` | `#0B0A08` | near-black — outside |
| 02 | `park` | `#0A1310` | the seal's green — the estate |
| 03, 04 | `heritage` | `#17110C` | warm mahogany — the rooms and the people |
| 05, 06, 07 | `evening` | `#150B0D` | deep wine — the document |
| 08, 09 | `estate` | `#0B0A08` | near-black — the way out |

NEAR-BLACK → DEEP GREEN → WARM MAHOGANY → DEEP WINE → NEAR-BLACK is the brief's
recommended progression exactly, and **all five are `estate.css` §1's existing
grounds**. This page adds none — CONTACT was the first to manage that and this is
the second. It is also the only page on the site that spends exactly those five
and no others.

**The form stands on the wine, and it is the only screen on this site that does.**
`--mm-evening` carries a photograph on THE ESTATE and on AFTER DARK and has never
carried type. The brief asked for "warm cream or deep wine depending on section";
a cream ground exists nowhere in this film — the argument is `contact.css` §1 and
it has not changed — so it is the wine, which is the brief's own other option and
the fourth step of the brief's own progression. Measured on `--ink` it is 15.9:1.

### What is still not on it

Every prohibition is the approved page's own, carried across unchanged: no price,
fee, joining cost, deposit or annual figure; no member count or cap; no waiting
list; no age, income or net-worth threshold; no acceptance rate or quota; no
referral requirement; **no timeline for review**; no benefit that is not on the
approved list. None of it is settled by the owner (ARCHITECTURE §21).

---

## 2. The asset audit

All twelve `media_src/` directories were walked, 175 files, dimensions read.

| Directory | Files | Used here |
|---|---|---|
| `CIGAR_HOUSE` | 9 | 1 — `main_bar.png` |
| `estate` | 4 | 1 — `estate_3.jpg` (the hero's reference) |
| `ESTATE_and_HOSPITALITY` | 7 | — |
| `grand-staircase` | 4 | 1 — `GrandStaircase_3.jpg` |
| `heritage-details` | 3 | — |
| `HOUSE_OF_DIALOGUE` | 3 | 1 — `1.png` (the second sequence) |
| `interiors` | 15 | — |
| `Majori_logo` | 18 | the shipped seal (see below) |
| `MOTION` | 85 | its own new `membership/` folder |
| `pavilion` | 3 | — |
| `PRIVATE_CLUB_ECOSYSTEM` | 12 | 4 — `2`, `3`, `4`, `8` |
| `RESTAURANT` | 7 | 2 — `private_dining_room`, `dining_salon` |

### The seal is the supplied artwork and was not redrawn

`assets/img/brand/seal-cream-*.png` and `seal-gold-*.png` are the existing
masters, derived from `media_src/Majori_logo/` when the brand kit was built
(`tools/brand/`). The hero prints the cream one, the letterhead prints the
ground's own colourway through `partials/seal.php`, and the last screen prints
the gold one. **Nothing in this work touched `media_src/Majori_logo/` or
regenerated the mark.**

### Every source:ratio pair is unclaimed

Each of the eight plates was checked against the eight build scripts in
`tools/photos/` before it was written down. Same file at the same ratio is the
same picture, and this page has none.

### Files considered and rejected, with the reason

| File | Considered for | Why not |
|---|---|---|
| `PRIVATE_CLUB_ECOSYSTEM/9.jpeg` | the padel tile | The racket-shaped sign stands in the middle of the frame at every 21:9 bias. Boxed clear of it the file leaves 692 px of usable width, short of the ladder's bottom rung, and nothing on this site is upscaled. |
| `interiors/interiors_9.png` | the heritage tile | Cut and measured: 118.8 mean, which needs a curve steep enough to turn the plaster to mud. `GrandStaircase_3.jpg` at 81.0 takes the same idea for a third of the damage. |
| `pavilion/pavilion_3.jpg` | the events tile | The only unclaimed pavilion frame, and it is flat daylight with white banqueting linen — the one bright object in a night ecosystem. |
| `estate/estate_4.jpg` | the hero | It is `ad-nightfall`'s source and AFTER DARK's approved hero is already this house at night. See §3. |

---

## 3. What was generated, and from what

**One still and two sequences.** The brief allows one hero sequence and one
optional secondary, and says not to generate a still for the sake of it. The
library was checked against that first, and what it does not contain is this
house's north front after dark.

```
SOURCE       media_src/estate/estate_3.jpg              869 × 990, the north front
             ↓ 16:9 crop at bias 0.80                   869 × 488
REFERENCE    media_src/MOTION/membership/ref-threshold.png
             ↓ GPT Image 2, 2K, high, 16:9
STILL        media_src/MOTION/membership/still-threshold.png    2688 × 1520
             ↓ Seedance 2.0, 720p, std, 16:9, 5 s, no audio, start_image
MASTER       media_src/MOTION/membership/mem-threshold.mp4      1280 × 720, 5 s
             ↓ trim 3.4 s → palindrome → grade → encode
VIDEO        assets/video/mem-threshold.mp4      619 KB  1280 wide  6.76 s
             assets/video/mem-threshold-sm.mp4   211 KB   854 wide  6.76 s
POSTER       assets/img/membership/mem-threshold-{768,1280}.{jpg,webp}
MOTION       Extremely slow level push through the tree line toward the lit
             house; foliage stirring; the light breathing. Nothing else moves.
```

```
SOURCE       media_src/HOUSE_OF_DIALOGUE/1.png         2816 × 1408, the great hall
             ↓ 21:9 crop at bias 0.42                  2816 × 1207
REFERENCE    media_src/MOTION/membership/ref-hall.png
             ↓ Seedance 2.0, 720p, std, 21:9, 5 s, no audio, start_image
MASTER       media_src/MOTION/membership/mem-house.mp4          1470 × 630, 5 s
             ↓ trim 2.6 s → palindrome → grade → encode
VIDEO        assets/video/mem-house.mp4          430 KB  1152 wide  5.20 s
POSTER       assets/img/membership/mem-house-{768,1152}.{jpg,webp}
MOTION       Almost imperceptible level drift down the hall; standing figures
             shift their weight where they stand. Nobody walks.
```

**No image generator touched `mem-house`** — Seedance moved a camera inside one
of the project's own renders. Its poster is declared `render`, not `generated`.

All three prompts are printed **verbatim** in
`tools/photos/build_membership_media.py`, because a prompt is the only part of a
generated asset that cannot be recovered by looking at it. Each is written as a
**preservation instruction**: it names the architecture and materials of that
specific frame, states the one thing that may change, lists the motion that is
allowed, and then says what may not appear.

### Why the hero is not the shot the brief describes

The brief's suggested hero — *"slow, restrained cinematic arrival toward the
illuminated Majori Manor estate at night, mature trees framing the path"* — is
almost word for word **AFTER DARK's approved hero**. `ad-nightfall` is an
extremely slow approach across the lawn toward this house at night, out of
`estate_4.jpg`, and the CEO has signed it off.

Building it again here would be one page done twice. So the hero takes the
brief's *intent* — the threshold of a private world, at night — and finds the
frame the site does not own:

| | source | elevation | hour | vantage |
|---|---|---|---|---|
| `est-arrival` | `estate_1` | the gate | blue | through the piers |
| `est-house` | `estate_3` | the north front | day | lateral |
| `est-park` | `estate_2` | the garden front | golden | lateral drift |
| `con-arrival` | `estate_2` | the portico | dusk | walking in |
| `ad-nightfall` | `estate_4` | the long elevation | night | open lawn, forward |
| **`mem-threshold`** | **`estate_3`** | **the north front** | **night** | **inside the tree line** |

`estate_3.jpg` is the one elevation of this house that has never been taken past
daylight. And the vantage is the half that separates it from `ad-nightfall`: that
shot stands on an open lawn and walks toward the house; this one stands **back
inside the park's tree line**, with two mature trunks unlit in the near
foreground and the lit house between them. It is the brief's own "mature trees
framing the path", and it is a place on the estate no frame on this site has
stood. **A reader arriving at MEMBERSHIP is outside a world that is lit.**

### `start_image`, not `omni_reference`

The brief asks for `mode: omni_reference`. Both sequences are built on
`start_image` instead, and the reason is the brief's own source-of-truth rule —
*preserve architecture, manor identity, materials, landscaping, room proportions,
lighting language*. A reference is a mood; a start frame is a contract. It is the
only setting under which a barrel gable, an oculus and a glazing pattern survive
five seconds of camera movement, it is what every sequence on the eight approved
pages uses (`build_events_media.py` set the rule), and it is what makes the
poster honest: **frame 0 of the encode is the poster**, so the still and the film
cannot re-frame against each other when the video fades up. Proved: mean absolute
difference between frame 0 and the shipped poster is 1.08 and 2.16 out of 255 —
JPEG quantisation and nothing else.

### One preset declined

Higgsfield offered the `IN THE DARK` preset for the hero prompt. It was declined
(`declined_preset_id`) and the prompt generated literally: a preset is a look
applied over the request, and this request is a contract about a specific
building.

---

## 4. What was built, and what was reused

### New files (5)

| File | What it is |
|---|---|
| `templates/components/film-letterhead.php` | the seal, two rules and the estate's address — 30 lines |
| `assets/css/membership.css` | this page's layer, 9 sections |
| `assets/js/membership.js` | one motion job — the shortest page layer on the site |
| `tools/photos/build_membership_media.py` | the crops, the grades, the prompts, the encodes |
| `docs/MEMBERSHIP.md` | this file |

### Rewritten (2)

`content/en/membership.php` and `templates/pages/membership.php`.

### Additive edits to shared files (2) — both proved inert

| File | Edit | Why it cannot move another page |
|---|---|---|
| `partials/film-nav.php` | `is-current` + `aria-current="page"` on the accent action, in the bar and in the sheet | `NAV_ACCENT` is `membership`, so `is_current(NAV_ACCENT)` is false on every other page and neither attribute is printed |
| `partials/head.php` | one row in `$filmPages` | keyed on `current_page()`; no other page reads it |

Proved, not assumed: `tools/compare_pages.sh` — §7.

### The one new component, and the four it is not

Nothing in the film draws a document. Each existing block was tried first:

- **`film-chapter`** — a heading and paragraphs. It cannot centre a mark, and
  this scene is mostly a mark.
- **`film-band`** — a picture with type over it. There is no picture, and a band
  with an empty frame is a band that failed to load.
- **`film-invitation`** — the closest, and wrong in the way that matters: it is
  the *last* screen of a page and it ends on buttons. This scene is the *head* of
  the screen below it and must not offer a way out of it. Teaching the block that
  closes six approved pages to have optional actions is how a component starts
  meaning two things.
- **`seam`** — a rule with a crest on it, decorative by definition, carries no
  type.

### The crest kept its role and moved four screens

The approved page rendered the crest at 140 px in its own band between the hero
and the first paragraph — the one place on this site where it is the *subject*
rather than a mark on something (ARCHITECTURE §8.5). It is still that, at the
same size, still the only one on the page, still `decorative: false` with
`t('a11y.crest')` — now at the head of the document, which is where a seal on an
application belongs. `.c-pageseal` is gone; `templates/pages/membership.php` is
back to the site's three lines.

### What was left out

No walk, no ledger, no lateral detail track, no seam, no world grid — five
components this page could have had and did not need.

### The form is the site's form

`components/form-membership.php` and `partials/form.php` draw scene 07,
**unchanged**. Same schema, same eleven fields in the same order, same required
flags, same maxlengths, same referral pair and its `aria-expanded`, same
honeypot, same signed time-trap, same rate limiter, same error summary that takes
focus, same privacy sentence above the button, same thank-you, same handler, same
no-JavaScript POST. Everything that changed is the ground it stands on and the
type on it, and all of it is `membership.css` §7 — most of which is
`contact.css` §6's rules kept byte-identical on purpose, marked as such in the
file. The two forms on this site are one form.

---

## 5. The grades

Every approved band on this site measures between 18 and 49 out of 255. Three of
the ten pictures arrived above that.

### The five ecosystem tiles are graded to one room tone, not to a descent

This is the opposite of `build_after_dark_media.py`'s arc, and it is the right
call for this component rather than a departure. AFTER DARK's five are five
sequences a reader meets one screen at a time, so a curve through them reads as
an evening going on. **These five cross-fade into each other** as the reader
scrolls, and two tiles eight points apart flash when they swap.

| Stem | Source | Ratio | Bias | Raw | Shipped | Curve |
|---|---|---|---|---|---|---|
| `world-heritage` | `grand-staircase/GrandStaircase_3.jpg` | 21:9 | 0.28 | 81.0 | **35.3** | EVENING |
| `world-padel` | `PRIVATE_CLUB_ECOSYSTEM/8.jpeg` | 21:9 | 0.34 | 44.6 | **35.3** | DUSK |
| `world-dining` | `RESTAURANT/private_dining_room.png` | 21:9 | 0.54 | 34.9 | **34.9** | — |
| `world-events` | `PRIVATE_CLUB_ECOSYSTEM/2.png` | 21:9 | 0.58 | 56.0 | **33.4** | LANTERN |
| `world-dark` | `CIGAR_HOUSE/main_bar.png` | 21:9 | 0.50 | 27.1 | **27.1** | — |
| `mem-belong` | `PRIVATE_CLUB_ECOSYSTEM/3.png` | 21:9 | 0.56 | 23.6 | **23.6** | — |
| `mem-room` | `PRIVATE_CLUB_ECOSYSTEM/4.png` | 3:4 | 0.44 | 35.7 | **35.7** | — |
| `mem-table` | `RESTAURANT/dining_salon.png` | 3:4 | 0.50 | 63.7 | **38.1** | LANTERN |

An eleven-point band across the whole page, and eight points across the five
tiles that cross-fade.

### Two crops are worth reading twice

**`world-padel` at bias 0.34 takes the words out of the frame.** The lit panel
reads `MAJORI MANOR / PADEL CLUB` in full, and a tile with a legible sign on it
is the one tile in a five-tile stack a reader stops to *read* instead of
scrolling — and it would be saying, in letters, the word the label beside it
already says. High, and the panel is a lit crest, the words are below the frame
line, and the house and the lamp-lit path are what the picture is about.

**`world-heritage` at bias 0.28 is the second crop, not the first.** Centred,
that window lands on the lower half of the glazed screen and reads as a door with
a rail beside it. Taken up, it catches the coffers, the whole lit screen and the
carving on the balustrade, and the frame is about the woodwork — which is what
HERITAGE means on this site.

### The dialogue is 21:9 and the three pages before it are 16:9

THE CLUB built the component for four ideas, EVENTS took it for six evenings,
RESIDENCES for three kinds of room; all three are 16:9. A fourth 16:9 dialogue is
a fourth page that looks like the third. At 21:9 the stack reads as a widescreen
strip — the one shape that says "the whole estate, seen at once" — and it gave
every tile an unclaimed source:ratio pair in a library where 16:9 is nearly
exhausted.

---

## 6. Legibility, measured

`tools/measure_contrast.js`'s method, run on the available browser: real scroll,
transparent glyphs (not `visibility: hidden`), `Range.getClientRects()` for the
letter boxes, 95th-percentile brightest background pixel each element's letters
actually cross.

**At 1440 × 900, 24 stops, 218 samples — every element passes WCAG AA.**

| Element | Ratio | px | Needs |
|---|---|---|---|
| `.c-film-hero__cue span` | 4.65 | 9.6 | 4.5 |
| `.c-film-chapter__index` | 4.81 | 10.6 | 4.5 |
| `.c-film-band__caption` | 4.81 | 11.7 | 4.5 |
| `.c-dialogue__note` | 4.82 | 14.9 | 4.5 |
| `.c-letterhead__note` | 5.00 | 11.7 | 4.5 |
| `.c-form__index` | 5.00 | 10.6 | 4.5 |
| `.c-form__label` | 8.36 | 13.3 | 4.5 |
| `.c-form__actions .c-btn--primary` | 8.97 | 11.7 | 4.5 |
| `.c-film-hero__title` | 10.97 | 105.4 | 3.0 |
| `.c-form__head h2` | 16.29 | 57.8 | 3.0 |

**At 390 × 844, 30 stops, 332 samples — every element passes.** One did not on
the first run: `.c-dialogue__note` at **4.10**. The fix is in `membership.css` §8
and it is EVENTS' and RESIDENCES' own override, one stop further: the stage scrim
below 900 px goes to 99/97/94/90 and the note comes back at **4.67**. Two more
stops buy 0.02 and start flattening the photograph, so it stops there — and 4.67
sits between two approved components on this same page that measure 4.81.

### The hero's scrim

Frame 0 measures **23.6** mean — the darkest first screen on the site, against
CONTACT's 29 and AFTER DARK's 31 — because two thirds of the frame is unlit park.
The mean is not the problem: the remaining third is pale cream render, lit from
below and from eleven windows, exactly where the copy sits. So the added band is
**narrower and deeper than any of the six before it** — it takes the middle third
and leaves the sky and the lawn to `home.css`. The title measures 10.97.

---

## 7. Verification

Every item below was executed, not reasoned about.

| # | Check | Result |
|---|---|---|
| 1 | All 12 `media_src` directories walked | 175 files, dimensions read |
| 2 | Membership-relevant assets identified | §2 |
| 3 | The real seal is used, not redrawn | `brand/seal-*`, from the supplied artwork |
| 4 | Generated visuals descend from `media_src` | `estate_3.jpg` → still → sequence |
| 5 | Seedance source images verified | both `start_image`, both committed |
| 6 | Architecture and materials consistent | gable, oculus, dormer, balcony, door, steps, plinth, parterre all held |
| 7 | No unsupported membership facts | §1; the approved list, unchanged |
| 8 | All eleven form fields functional | POST round-trip |
| 9 | Validation | empty POST → 4 required errors; bad email → format error |
| 10 | Required-field behaviour | `required` on name, surname, country, email |
| 11 | Conditional referral rule | `referred=yes` + empty name → error, summary link, `aria-invalid` |
| 12 | Values preserved on error | `value="Anna"` etc. returned |
| 13 | Privacy notice | present above the button, links to `/privacy` |
| 14 | Honeypot | filled → success, **no mail sent**, logged |
| 15 | Time-trap | under 3 s → refused; tampered token → refused |
| 16 | Submission behaviour | thank-you replaces the form in place, `role="status"`, `autofocus` |
| 17 | Navigation active state | `.is-current` + `aria-current="page"` in bar **and** sheet |
| 18–25 | Main Page, ESTATE, CLUB, PADEL, EVENTS, RESIDENCES, AFTER DARK, CONTACT unchanged | **byte-identical** — `compare_pages.sh` |
| 26 | Desktop rendering | 1024 / 1440 / 1920 |
| 27 | Mobile rendering | 375 / 390 / 430 / 768 |
| 28 | Horizontal overflow | **none** at any width — `scrollWidth === clientWidth` |
| 29 | Broken images | **none** — 13/13 load |
| 30 | Console errors | **none** |
| 31 | Cinematic hero | poster is frame 0; video attaches after `load` |
| 32 | Form usable while video loads | video has **no `src`** in the markup; `preload="none"`; no `poster` attribute |
| 33 | Reduced motion | **zero libraries fetched**, no video `src`, 0 hidden elements |
| 34 | No JavaScript | 10 controls, 11 labels, 5 captioned tiles, submit present, nothing hidden |
| 35 | Keyboard | skip link first; logical order; 2 px outline on every stop |
| 36 | Headings | one `h1`, eight `h2`, no skipped level |
| 37 | Labels | 0 unlabelled controls, 0 images without `alt` |
| 38 | Loop seam | see §8 |

### The byte-identical proof

```
PAGE           RESULT            BEFORE      AFTER
after_dark     IDENTICAL          39255      39255
club           IDENTICAL          42450      42450
components     IDENTICAL          52111      52111
contact        IDENTICAL(t)       24082      24082
estate         IDENTICAL          38684      38684
events         IDENTICAL          41046      41046
home           IDENTICAL          52790      52790
membership     CHANGED*           18506      35932
notfound       IDENTICAL           5918       5918
padel          IDENTICAL          39955      39955
privacy        IDENTICAL          13788      13788
residences     IDENTICAL          45342      45342
styleguide     IDENTICAL          44427      44427
terms          IDENTICAL          10155      10155

PASS — every page except membership is unchanged.
```

`(t)` = identical but for the per-request `form_time` token.

---

## 8. A defect found in the shared encode machinery

**`-t` is on the wrong side of `-i` in every build script on this site, and it
silently disables the palindrome on any sequence that is trimmed.**

`build_contact_media.py` puts `-t` *after* `-i`, with a comment saying that there
it "limits the decode, which is what the palindrome then reverses". It does not.
After `-i`, `-t` is an **output** option: ffmpeg builds the palindrome from the
whole five seconds, giving ten, and then keeps the first 3.2 of those ten. What
ships is the forward pass alone, cut off mid-move — and because nothing brings it
home, **the loop hard-cuts back to frame 0 every time it repeats**.

Measured, on the files themselves — mean absolute difference between the first
frame and the last, out of 255:

| Sequence | Trim | Seam | |
|---|---|---|---|
| `ad-nightfall` | none | **3.2** | a true palindrome, seamless |
| `con-arrival` | 3.2 s | **34.0** | a visible cut every 3.2 seconds |
| `mem-threshold` | 3.4 s | **18.2** | before the fix |
| `mem-house` | 2.6 s | **28.6** | before the fix |

Before `-i`, `-t` limits how much of the **input** is read, which is what the
comment describes and what the palindrome needs. (`-ss` is the option that seeks;
`-t` does not.) `build_membership_media.py` puts it there, and this page's two
sequences now measure **2.3** and **4.8** — the same range as `ad-nightfall`,
which is the residual of `trim=start_frame=1` and inter-frame compression.

**`build_contact_media.py` was not touched and `con-arrival` was not re-encoded.**
CONTACT is approved, its bytes are what the CEO saw, and a page this work is not
allowed to modify is not a page to fix quietly. Whoever takes CONTACT next: the
fix is moving four characters, and it costs 3.2 seconds of extra encode.

The same applies to any other trimmed sequence on the site. `ad-nightfall`,
`res-arrival` and the other 10.00 s encodes are untrimmed and were never
affected.

---

## 9. Limitations, and what needs a decision

### "Some places are visited. Others, you belong to." is now on three pages

It closes `/the-estate` and `/residences`, and it is scene 03 here. **The brief
names it explicitly for this scene and says it may be reused**, so it is used.

The concern is worth stating anyway, because the approved membership page carried
a long note arguing the opposite: a reader coming here from THE ESTATE — which is
where the site sends people first — meets the same sentence twice in one visit,
and three printings across nine pages is a slogan. The old note's objection was
to putting it *under the form* as the last thing a reader sees; here it is four
screens above the form, on a photograph, and the six screens after it are the
answer to it. That is a different position and a weaker objection, not no
objection.

**If the owner would rather not spend it a third time,** the site holds one
approved formula that has never been printed on a public page at all — *"Not
everyone needs to know about Majori Manor. The right people will."* It is one
line in `content/en/membership.php`.

### "An entire day", not "an entire world"

The brief proposes `ONE ESTATE. ONE MEMBERSHIP. AN ENTIRE WORLD.` The project's
approved formula is *One estate. One membership. An entire day.*, and
`docs/ASSET_MANIFEST.md` records that **this exact substitution was put to the
client before and left as approved** — "the line is the brand's formula; changing
'day' to 'world' is a brand decision". So it is the approved one, and this is its
first appearance on a page a reader can visit (it has only ever been on the
DEV-only `/components`). Changing it back is one line and one brand decision.

### What the models added, stated rather than hidden

**GPT Image 2** put small visible ground uplighters along the plinth and in the
parterre; the prompt asked for the light and asked for no visible fittings. They
are consistent with the light the prompt did ask for, they are small and at the
bottom of the frame, and they were left rather than spend a second generation.
The iron handrail on the steps is simplified, and the door's glazed upper panel
came back as a diamond lattice rather than the photograph's pattern. Every major
element — the barrel gable, the oculus and its glazing bars, the dormer, the
window rhythm, the balcony and its turned balustrade, the steps, the rubble
plinth, the box parterre — is where the photograph has it.

**Seedance** held both framings for the full five seconds with no drift, no shake
and no new architecture. `mem-house` is trimmed to 2.6 s rather than the full
five for a content reason and not a technical one: past about three seconds the
camera has walked far enough down the hall that the nearest figures approach the
size of portraits, and the brief asks for no identifiable close-ups.

### The videos could not be played in this environment

The available headless Chromium is built without H.264
(`canPlayType('video/mp4; codecs="avc1.640028"')` returns `""`), so playback was
not observed. What *was* verified: both encodes are valid H.264 High / yuv420p
with `+faststart`, the durations are the expected palindromes (6.76 s and 5.20 s),
frame 0 matches the shipped poster to within JPEG noise, the loop seams measure
2.3 and 4.8, and `home.js` attaches the correct `src` at the correct moment.
**The moving picture itself should be looked at on a real browser before sign-off.**

### Unused shared CSS and JS

This page loads `estate.css`/`estate.js` and `club.css`/`club.js` and draws no
walk, no ledger and no lateral detail track — about 650 lines that match nothing,
and three motion jobs that return on their first line because none of
`[data-walk]`, `[data-ledger-row]` or `[data-detail]` is in the DOM. That is the
price of not forking a shared file, and it is the right price for PADEL's reason:
the bytes are already in the reader's cache from the pages that do use them.

### Weight

| Page | CSS gz | JS gz | Whole page, raw |
|---|---|---|---|
| `contact` | 62.7 K | 25.8 K | 1.64 MB |
| **`membership`** | **71.8 K** | **31.9 K** | **2.33 MB** |
| `residences` | 67.5 K | 31.5 K | 6.85 MB |
| `after_dark` | 68.5 K | 31.5 K | 7.99 MB |

The heaviest stylesheet total on the site by 3.3 K, and the second **lightest**
page — a third of AFTER DARK. `main.css` is 31.9 K gz against its own 40 K
ceiling and was not touched. `membership.css` is 13.3 K gz, within 1 % of
`contact.css`, and most of both files is prose.

### Not done here

- **No live mail was sent.** SMTP in `private/config.php` points at the real
  `mail.majorimanor.com` and `MAIL_TO` is `info@majorimanor.com`; sending a test
  application would have put a fake applicant in the estate's inbox. The success
  state was exercised through the honeypot branch, which returns the thank-you
  and sends nothing. The rate-limit log confirms it: `"s":[]`, zero sends.
  **One real end-to-end send still has to be done by the operator**, as
  HANDOFF §4.2 already requires for both forms.
- **English proofreading.** Every sentence on this page is either the approved
  page's own or new copy written in the brand register, and none of it has been
  read by a native speaker (HANDOFF §4.4).
- **The Latvian version.** `content/lv/membership.php` does not exist. Nothing in
  this work writes English into a template; the page is a content file like every
  other.

---

## 10. Asset accounting

### Generations

| Generation | Settings | Count | Each | Total |
|---|---|---|---|---|
| GPT Image 2 | 2K, high, 16:9, from a reference | 1 | 6.5 | **6.5** |
| Seedance 2.0 | 720p, std, 5 s, no audio, `start_image` | 2 | 22.5 | **45.0** |
| | | | **spent** | **51.5** |

Balance before **734.5**, balance after **683.0**.

**Nothing was discarded and nothing was regenerated.** Three requests, three
assets, all three shipped. The still came back with the architecture intact on
the first request and both sequences held their framing for the whole five
seconds. The only rejected thing was a *preset*, which costs nothing.

### Every generated still

```
SOURCE   media_src/estate/estate_3.jpg  ->  16:9 crop, bias 0.80
OUTPUT   media_src/MOTION/membership/ref-threshold.png     869 × 488
REASON   The reference the hero is generated from. Bias 0.80 is what puts the
         door, the steps and the parterre in the window; at 0.5 the crop is roof
         and first-floor windows.

SOURCE   media_src/MOTION/membership/ref-threshold.png
OUTPUT   media_src/MOTION/membership/still-threshold.png   2688 × 1520
REASON   The library holds this elevation in daylight and nowhere else. The
         prompt changes the hour and the vantage and nothing structural. It is
         the one frame on this page that had to be generated.

SOURCE   media_src/HOUSE_OF_DIALOGUE/1.png  ->  21:9 crop, bias 0.42
OUTPUT   media_src/MOTION/membership/ref-hall.png          2816 × 1207
REASON   The start frame for the second sequence. Not generated — a crop. Bias
         0.42 holds the chandelier and the heads of the standing figures in one
         window.
```

### Every Seedance sequence

```
SOURCE IMAGE  media_src/estate/estate_3.jpg
START IMAGE   media_src/MOTION/membership/still-threshold.png
MASTER        media_src/MOTION/membership/mem-threshold.mp4   1280 × 720, 5 s
VIDEO         assets/video/mem-threshold.mp4     619 KB  1280 wide  6.76 s
              assets/video/mem-threshold-sm.mp4  211 KB   854 wide  6.76 s
POSTER        assets/img/membership/mem-threshold-{768,1280}.{jpg,webp}
MOTION        Extremely slow level push forward through the tree line; the house
              opens between two trunks; foliage stirs; the window light breathes.
              Trimmed to 3.4 s, palindromed to 6.76, graded gamma 0.94.

SOURCE IMAGE  media_src/HOUSE_OF_DIALOGUE/1.png
START IMAGE   media_src/MOTION/membership/ref-hall.png
MASTER        media_src/MOTION/membership/mem-house.mp4       1470 × 630, 5 s
VIDEO         assets/video/mem-house.mp4         430 KB  1152 wide  5.20 s
POSTER        assets/img/membership/mem-house-{768,1152}.{jpg,webp}
MOTION        Almost imperceptible level drift down the hall; standing figures
              shift their weight where they stand. Nobody walks, nobody crosses
              the frame, nobody turns to the camera. Trimmed to 2.6 s,
              palindromed to 5.20, graded gamma 0.88.
```

### Every plate

Eight, all crops of existing `media_src` material, none generated. Sources,
ratios, biases, raw and shipped levels: §5. The full reasoning for each crop —
what is in it, what was kept out of it and why that bias — is in
`tools/photos/build_membership_media.py`, which is the source of truth and is
re-runnable from a fresh clone.

### The encode ladder

| | Width | CRF | Why |
|---|---|---|---|
| `mem-threshold` | 1280 | 29 | cut at 27 / 29 / 31 and compared at 1:1 on the gable; 29 is the last stop before the sky bands and the roughcast smooths, and saves 28 % over 27 |
| `mem-threshold-sm` | 854 | 31 | one stop further — the detail 29 protects is not resolvable on a phone |
| `mem-house` | 1152 | 31 | dark panelling behind a title, on a page whose form has priority over its film |

