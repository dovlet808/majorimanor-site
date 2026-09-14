# Majori Manor — home page asset manifest

**Every visual slot in the ten scenes, and what has to arrive to fill it.**

This file is the input to the generation pass. It is written against the page as
it stands on `feature/home-cinematic`: the structure and the motion are built,
the empty slots render as the hatched frame at their declared ratio, and the
film can be scrolled and timed today. Nothing below was generated in this pass.

Read it with `public_html/content/en/home.php` open beside it. That file is
where every ratio and every `source` value below is declared, and it is the only
place they may be changed.

---

## How to read this

**Slot id** is the `name` passed to `img()` — the stem under
`public_html/assets/img/`. `img()` finds the widths itself; the file on disk is
always `<slot>-<width>.<ext>`, e.g. `home/estate-1280.webp`.

**Target dimensions** are the widths that must be exported. The ladder for a
full-bleed scene is **960 · 1280 · 1920 · 2560**; for a frame inside a scene it
is **640 · 960 · 1280**. Export every rung — `img_files()` reports only what is
actually on disk, so a missing rung silently narrows the srcset and a rung that
exists but was not asked for is never served.

**Source marking** is a claim about the picture and is enforced in
`figure.php`, not here:

> **The two appended labels below no longer print.** They were removed from
> every page on the owner's instruction — `mark_for()` in `app/helpers.php`
> returns the empty string for every source. The `mood` row still holds: a
> reference image still has its factual caption dropped, by `figure.php`. The
> markings themselves are still declared and still validated. See ARCHITECTURE
> §11 for the change and how to reverse it.

| marking | means | caption behaviour |
|---|---|---|
| `photo` | real photography of this estate | prints as written |
| `render` | a visualisation of the project | ~~"Visualisation" appended~~ — nothing appended |
| `mood` | a reference image — atmosphere only | factual caption dropped entirely |
| `generated` | a synthesised picture | ~~"Generated image" appended~~ — nothing appended |

**Anything produced in the generation pass is `generated` unless it is a
photograph of this building.** That is not a formality: a synthesised image is
the one kind of material on this site no reader can tell from a photograph by
looking, which is exactly why the label is not optional. Where a slot below
says "regrade / re-crop of an existing frame" the marking does not change,
because the picture is still the picture that was taken.

**H** in the last column marks a slot that needs Higgsfield.

---

## Summary

| | count |
|---|---|
| Visual slots in the ten scenes | 15 |
| Filled today, at full ladder | 0 |
| Filled today, at partial ladder | 8 |
| Empty — hatched frame renders | 7 |
| Motion slots | 1 |
| Needing Higgsfield | 8 |

**No scene is blocked.** Every empty slot renders as its hatched frame at the
declared ratio, so the film's rhythm is measurable now — see
`captures/nojs-full-page.png` and the contact sheets.

---

## The slots

### 01 · HERO

| | |
|---|---|
| **Slot** | `home/hero-pavilion-night` |
| **Depicts** | The pavilion in the park at night, lit from within |
| **Ratio** | 16/9 — *declared 3/2 today; see note* |
| **Target** | 1280 · 1920 · 2560 wide |
| **Still / motion** | Still (also the video's first frame) |
| **On disk** | `home/hero-pavilion-night-1280.jpg/.webp` — **1280 only**, and the file is 1280×751 (1.704), not 16/9 |
| **Marking** | `photo` |
| **Action** | Re-export at 1920 and 2560 from the original. At 1440px CSS the 1280 is already being upscaled; on a 2560 display it is upscaled twice. |
| **H** | No — this is an existing photograph, not a generation |

> **Note on the ratio.** The hero declares no `ratio`, so `img()` falls back to
> 3/2 and prints that onto the wrapper. It changes nothing on screen — the hero
> switches `aspect-ratio` off and fills the window — but it means the markup
> makes a claim about the file that the file does not meet. Fixing it is one
> line in `home.php` and it should be done when the re-export lands, not before,
> so the declaration follows the file rather than the other way round.

| | |
|---|---|
| **Slot** | `assets/video/hero-pavilion.webm` + `.mp4` |
| **Depicts** | The pavilion at night, lit from within, the manor's terrace to the right. A slow aerial push toward the dome. |
| **Ratio** | 16/9 |
| **Target** | 1920×1080, H.264 High + VP9 |
| **Still / motion** | **Motion** |
| **Duration** | 8–12 s |
| **Seamless loop** | **Yes — required.** The loop point must be invisible; the element carries `loop` and plays unattended for as long as the reader stays on the first screen. |
| **Weight** | ≤ 4 MB per file |
| **On disk** | **Both files. Shot, not generated.** `hero-pavilion.mp4` 1.74 MB · `hero-pavilion.webm` 2.48 MB, 1280×720, 24 fps, 11.000 s, no audio track. Camera original: `media_src/pavilion/pavilion.mp4` (git-ignored). |
| **Marking** | `photo` — this is real footage of the place, not a generation |
| **H** | No longer — superseded by the shot |
| **Motion needed** | Met by the footage. |

**How the loop was made, because it is not a straight cut.** The footage is one
continuous aerial push that accelerates to the end and never holds, so there is
no frame anywhere in it that matches its first — the closest candidate is still
far off, and a hard cut would jump. A cross-dissolve was tried first and was
worse: dissolving a near frame back into a wide one ghosts the dome against
itself for the length of the blend. What ships instead is a **palindrome** —
frames 0→132 forward, then 131→1 back — which is seamless by construction and
never blends two framings together. The turn is at frame 132 because the source
carries a compression jolt every 24th frame and 132 is clear of them; measured,
both the turn and the wrap are smaller than the average frame-to-frame step,
which is what "invisible" means here.

**It is graded down about a third from the camera original**, and that is a
legibility requirement rather than a look. The lit dome sits directly behind the
hero copy: ungraded, the gold eyebrow measured **1.40:1** against it, where the
approved poster still manages 3.10:1. Raising the scrim does almost nothing at
that height (1.50 → 1.70) and a wash behind the copy topped out at 2.15:1 — the
footage itself was the only effective lever. The shipped curve holds the blacks,
stops short of clipping the string lights, and restores the eyebrow to **3.22:1
mean / 2.94:1 worst** across the loop, with the title at 4.19:1. Regrade from
`media_src/` if the copy or the crop ever moves.

The slot is live in `hero.php` behind `ENABLE_VIDEO`, which is now **`true`**.
The element ships with **no `src`** — the two sources are on `data-` attributes
and `home.js` attaches one only when the viewport is ≥1024px, motion is welcome,
`saveData` is off and the load event has passed. All four gates were verified in
Chrome: ≥1024px fetches the WebM and plays it, 1023px and below fetch nothing,
and reduced-motion fetches nothing. The still stays the LCP element in both
scenarios.

> **The poster is a different photograph from the footage** — a closer angle,
> dome to the left — so there is a visible re-frame when the video fades up on
> desktop, and every phone visitor sees the still alone. Deliberately left as
> it is: it is the approved image. Deriving the poster from the video's first
> frame would close both that gap and the 1920/2560 one below.

---

### 02 · DISSOLVE

**No slot of its own.** The scene is the transition: the hero's still dissolving
into the estate's. It consumes 01 and 03 and commissions nothing.

---

### 03 · ESTATE

| | |
|---|---|
| **Slot** | `home/estate` |
| **Depicts** | The manor house behind its stone gate piers, in evening light |
| **Ratio** | 16/9 |
| **Target** | 960 · 1280 · **1920 · 2560** |
| **Still / motion** | Still |
| **On disk** | `-960` and `-1280`, both 3:2 (1280×853) |
| **Marking** | `photo` |
| **Action** | Re-crop to 16/9 and export the two upper rungs. This is the film's first full frame and the one the dissolve resolves onto — it is the single most-looked-at photograph on the page after the hero. |
| **H** | No — re-crop and re-export of an existing frame. Consider Higgsfield **upscale** only if the original is not available above 1280. |

---

### 04 · THE WALK — three frames, one movement inward

Portrait, because a tall frame is an opening you go through and a landscape one
is a view. Declared 4/5 each.

| | 04a | 04b | 04c |
|---|---|---|---|
| **Slot** | `home/club` | `home/walk-staircase` | `home/walk-heritage` |
| **Depicts** | A panelled room with a marble chimneypiece, on a chequered floor | The grand staircase, from the foot of the first flight | A heritage detail of the house, close to |
| **Ratio** | 4/5 | 4/5 | 4/5 |
| **Target** | 640 · 960 · 1280 | 640 · 960 · 1280 | 640 · 960 · 1280 |
| **Still / motion** | Still | Still | Still |
| **On disk** | `-960`, **3:2 landscape** — cropped to the doorway shape by the wrapper | **Nothing** | **Nothing** |
| **Marking** | `mood` | `photo` | `photo` |
| **H** | No | **No — see below** | **No — see below** |

**Raw material for 04b and 04c is already in the repository and is not on the
img() ladder.** These are unprocessed source files, not slots:

- `assets/img/grand-staircase/GrandStaircase_1…4.jpg` — 1179×1334, **0.88 (≈8:9)**
- `assets/img/heritage-details/heritage_1…3.jpg` — 1174×1340 and 1735×906
- `assets/img/interiors/interiors_1…4.jpg` — 1176×1337

They are already close to portrait, which is what this scene wants. **Do not
generate these two frames.** Pick a frame from each directory, crop to 4/5 and
run it through `tools/photos/build_images.py` to get the ladder. Generating a
staircase for a house that has four photographs of its own staircase is the
failure `source: photo` exists to prevent.

`home/club` is a stand-in in 04a and is honest about it: it is a real room of
this house at `mood`, cropped hard to portrait. Replace it with a purpose-cropped
interior from `assets/img/interiors/` when someone chooses one.

---

### 05 · CONTRAST

| | |
|---|---|
| **Slot** | `home/padel` |
| **Depicts** | The padel courts from the gallery above them |
| **Ratio** | 16/9 |
| **Target** | 960 · 1280 · 1920 · 2560 |
| **Still / motion** | Still |
| **On disk** | **Nothing, and this has been true since the first day of the site.** |
| **Marking** | `render` |
| **H** | **Yes** |
| **Motion needed** | n/a — still |

**The courts are not built.** There is no frame of them anywhere in the
material and nothing else in the brochure may stand in for them. The hatched box
is the true state of it.

**Do not commission a second, darker export for this scene.** The brief's "the
frame darkens almost entirely" is a scrim — `--scene-scrim: 0.94` in
`home.css` §6 — over this one file. One picture, one slot.

---

### 06 · BLUEPRINT

Two slots and an inline `<svg>`. The SVG is **structure, not an asset**:
`blueprint.php` lays out four 2:1 courts (a padel court is 20 m × 10 m) two
across and two down from the `courts` number in the content file, every stroke
carrying `pathLength="1"` so a later pass animates the whole plan with one
custom property. It is drawn in `--accent` and needs no file.

| | 06a | 06b |
|---|---|---|
| **Slot** | `home/blueprint-courts` | `home/courts-resolved` |
| **Depicts** | The architectural drawing of the four courts — hand-drawn plan, hairline, no colour | The same four courts, real, under their roof, lit for evening play |
| **Ratio** | 16/9 | 16/9 |
| **Target** | 960 · 1280 · 1920 · 2560 | 960 · 1280 · 1920 · 2560 |
| **Still / motion** | Still | Still |
| **On disk** | **Nothing** | **Nothing** |
| **Marking** | `render` | `render` |
| **H** | **Yes** | **Yes** |
| **Motion needed** | n/a — the drawing *animation* is driven by `--blueprint-draw` in `home.js` against the inline SVG, not by a video | n/a — the resolve is an opacity scrub, `--blueprint-resolve` |

06a and 06b must be **the same plan from the same angle** or the resolve is a
cut rather than a resolve. Generate 06b first and derive 06a from it.

---

### 07 · MEMBERSHIP

| | |
|---|---|
| **Slot** | `home/dining` |
| **Depicts** | Long tables laid for dinner under the pavilion's glass dome |
| **Ratio** | 3/2 |
| **Target** | 960 · 1280 · 1920 · 2560 |
| **Still / motion** | Still |
| **On disk** | `-960` only |
| **Marking** | `mood` |
| **Action** | Re-export the upper rungs. It is full-bleed on a desktop and a 960 stretched across 2560 is visibly soft. |
| **H** | Upscale only, if no larger original exists |

---

### 08 · PAVILION — three frames through a mask

| | 08a | 08b | 08c |
|---|---|---|---|
| **Slot** | `home/pavilion` | `home/pavilion-interior` | `home/pavilion-avenue` |
| **Depicts** | The pavilion on its lawn, the pine wood standing behind it | Inside the pavilion, the glass dome above the floor | The pavilion seen from the avenue, lit from within |
| **Ratio** | 3/2 | 3/2 | 3/2 |
| **Target** | 640 · 960 · 1280 | 640 · 960 · 1280 | 640 · 960 · 1280 |
| **Still / motion** | Still | Still | Still |
| **On disk** | `-960` | **Nothing** | **Nothing** |
| **Marking** | `photo` | `photo` | `photo` |
| **H** | No | **No — see below** | **No — see below** |

**Raw material is in the repository**: `assets/img/pavilion/pavilion_1.jpg`
(1637×961, landscape — the avenue shot) and `pavilion_2.jpg` / `pavilion_3.jpg`
(1182×1330, portrait — interiors). Crop to 3/2 and run through
`tools/photos/build_images.py`. Both slots are declared `photo`; generating them
would mean either relabelling them `generated` or making a false claim.

---

### 09 · THE DAY

**No image slot, and that is the scene.** The background carrying morning to
night is the existing temperature system — `dusk` → `night`, declared as
`from`/`to` on the block and interpolated by `home.js` between `--green-800` and
`--wine-900`, the same two values `main.css` §3 already defines. No new colour,
no gradient asset, no file.

---

### 10 · FINALE

| | 10a | 10b |
|---|---|---|
| **Slot** | `home/after-dark` | `home/residences` |
| **Depicts** | A panelled hall in low light, under a lit chandelier | An open leaded window on the landing, a room through the doorway beyond |
| **Ratio** | 16/9 | 16/9 |
| **Target** | 960 · 1280 · 1920 · 2560 | 960 · 1280 · 1920 · 2560 |
| **Still / motion** | Still | Still |
| **On disk** | `-960`, 3:2 | `-960`, 3:2 |
| **Marking** | `mood` | `mood` |
| **Action** | Re-crop to 16/9, export the upper rungs | As 10a |
| **H** | Upscale only | Upscale only |

The closing CTA carries no image. The crest in the last seam is
`assets/img/brand/crest-gold.png` and already exists.

---

## Everything needing Higgsfield, in one list

| # | Slot | Scene | Kind | Motion needed |
|---|---|---|---|---|
| ~~1~~ | ~~`assets/video/hero-pavilion`~~ | 01 | **Delivered — no longer needed.** Shot on location instead of generated; both files are on disk and the flag is on. See 01 · HERO above. | — |
| 2 | `home/padel` | 05 | Still, 16/9 | — |
| 3 | `home/blueprint-courts` | 06 | Still, 16/9 | — |
| 4 | `home/courts-resolved` | 06 | Still, 16/9 | — |
| 5 | `home/hero-pavilion-night` @1920/2560 | 01 | Upscale | — |
| 6 | `home/dining` @1280+ | 07 | Upscale | — |
| 7 | `home/after-dark` @1280+ | 10 | Upscale | — |
| 8 | `home/residences` @1280+ | 10 | Upscale | — |

**1–4 are generations. 5–8 are upscales of frames that already exist and must
not be re-imagined** — the picture stays the picture; only the pixel count
changes. Marking follows: a generation is `generated`, an upscale keeps whatever
the original was.

**Nothing in scenes 04 and 08 is on this list.** Six of the seven empty frames on
this page are covered by unprocessed photography already sitting in
`assets/img/`. Crop those first; it is the cheapest work on the page and it is
the only work that produces a `photo`.

---

## Copy the film asks for and does not have

Every word of approved copy is in the DOM and nothing was rewritten. Four lines
the brief describes do not exist in `content/en/home.php`, and in each case the
existing string was left standing rather than invented around. **These are
decisions for the client, not for the next prompt.**

| Scene | The brief asks for | The approved copy says | Where it stands |
|---|---|---|---|
| 01 | `MAJORI MANOR` as the hero's first line | *(no such string in `home.php`)* | **Already satisfied, not missing.** The header is transparent over the hero and prints `t('site.name')` — "Majori Manor" — at the top of this exact photograph. Setting it again inside the hero would give the first screen two of the same lockup and read it twice to a screen reader. |
| 03 | `Majori Manor · Jūrmala, Latvia` low in the frame | nearest is the hero's own `Jūrmala · Latvia` | **Slot declared and left empty.** `scene.php` renders a `caption` when one is given; `home.php` passes `''`. Moving the hero's line here would be writing copy by relocating it. Needs one new approved string. |
| 05 | eyebrow `THE CLUB` | `Padel & social` | **Left as approved.** "The club" is the eyebrow of scene 04, on the same page, doing its own job. The title the brief wants — `Play. Meet. Stay.` — is this block's own approved title and is exactly where the film wants it. |
| 07 | a membership line | *(no membership chapter exists)* | The only membership copy on the page is one sentence inside scene 04's lede and the closing CTA. Neither can move here without duplicating a line or spending the ending eight scenes early. The scene carries the dining chapter in its own place in the running order. **Needs a written, approved membership line.** |
| 09 | `07:00` to `22:00` | rows run `09:00` – `22:30` | **Left as approved.** This scene is signed off by the client; the rows are untouched. |
| 10 | `AN ENTIRE WORLD.` | `An entire day.` | **Left as approved.** The line is the brand's formula. Changing "day" to "world" is a brand decision. |

One string **moved and none was edited**: `One estate. One membership. An entire
day.` was the daytimeline's closing line and is now the finale's opening one,
three blocks further down the same page. The words are byte-identical; the film
wants them over the night estate rather than under a timetable.

---

## Export routine

`tools/photos/build_images.py` is the existing pipeline and produces the
`<slot>-<width>.jpg` + `.webp` pairs `img()` looks for. Anything dropped in by
hand must match that naming exactly or `img_files()` will not find it and the
slot will keep rendering its hatched frame — which is the correct failure, and
loud enough to notice.

Naming rule, enforced by a regex in `img_files()`: lowercase, digits, dash,
underscore, single slashes. `GrandStaircase_1.jpg` is **not** a valid slot name;
that is why the raw directories are source and not slots.
