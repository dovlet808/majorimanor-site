# Majori Manor — the Main Page

**The design prototype for the whole site.** Everything below is what was built,
what it was built from, and the decisions that are worth arguing with before the
rest of the site is made in its image.

Read it with `public_html/content/en/home.php` open beside it. That file is the
page: every scene, every ratio, every sentence and every picture is declared
there, and nothing on the Main Page can be changed anywhere else.

---

## 1. What it is

One page, nine scenes, read top to bottom as a single film.

| | Scene | Ground | Carries |
|---|---|---|---|
| 00 | **Hero** | night | The estate at blue hour — the delivered hero master, full screen |
| 01 | **Arrival** | night | The reception, and the crest on its wall |
| 02 | **Overture** | night | *Where heritage becomes a way of life.* |
| 03 | **The world** | night | Eight ways in, as an index |
| 04 | **Dining** | night | The salon, the private room, the chef's room |
| 05 | **Private club** | night | The bar, the cigar house, the courts, the dome |
| 06 | **Stay** | night | The suite, the guest house, the cottages |
| 07 | **The house as it stands** | night → day | The real building, photographed |
| 08 | **Invitation** | mahogany | *An invitation to belong.* |

**It never brightens, and then once it does.** The ground is near-black from the
first screen to the last. The only daylight on the page is scene 07, and that is
the whole point of scene 07: everything above it is what the estate is
*becoming*, and 07 is the building it is being *made from*. Putting the real
photographs last, in daylight, after twenty minutes of warm interiors, is the
page's one hard cut. It is also the most honest thing on it, and on a house that
has not opened, honesty is the only register that survives a second reading.

**The page says that in its own copy**, which is what carries the distinction
now that no picture is labelled: scene 07 reads *"Everything above this line is
Majori Manor as it is becoming"* under the eyebrow **Photographed**. Both were
reworded when the labels came off — from *"Everything above this line is a
visualisation…"* under *"Photographed, not visualised"* — and the cut they
announce is unchanged. It is also the most honest thing on it, and on a
house that has not opened, honesty is the only register that survives a second
reading.

**No sentence carries an unsettled fact.** No room count, no court count, no
size, no date, no opening hour, no menu, no price, no membership term, no named
person. Not one digit appears in the copy. That is the rule the rest of this
site already holds (ARCHITECTURE §21) and it happens to be the register the
brief asked for anyway.

---

## 2. The asset audit

`media_src/` holds **69 supplied images across eleven directories**, plus the
brand masters. They divide cleanly into two kinds, and the division is the one
thing on this page that must never be blurred:

| Kind | Directories | Marked | Used as |
|---|---|---|---|
| **Photographs of the real building** | `estate/` · `interiors/` · `grand-staircase/` · `heritage-details/` · `pavilion/` | `photo` | Scene 07, and only scene 07 |
| **Visualisations of the project** | `ESTATE_and_HOSPITALITY/` · `RESTAURANT/` · `CIGAR_HOUSE/` · `PRIVATE_CLUB_ECOSYSTEM/` · `HOUSE_OF_DIALOGUE/` | `render` | Scenes 00–06 |
| **Brand** | `Majori_logo/` | — | The seal, in two colourways |

**The captions no longer print "Visualisation", and that is a deliberate
change rather than a gap.** Every plate on this page used to append the word
automatically from its `source` value — `figure.php` and `film-plates.php` did
it, so it could not be forgotten and could not be switched off from the content
layer. On the owner's instruction the label was taken off this page and every
other one: `mark_for()` in `app/helpers.php` now returns the empty string for
every source, which is the single place the decision lives and the single place
it is undone.

**The marking itself is untouched.** Every picture still declares `source`, it
is still validated and still reaches the markup as `data-source`, and the
reference-image rule — a `mood` picture may not carry a factual caption — is
still enforced by `figure.php`. The division in the table above still governs
which material may appear in which scene. What went is the printed word.

**Scene 07 still does the work in its own copy.** The hard cut into daylight,
and the sentence that names it, are what tells a reader where the visualisations
stop — see the note below on how that copy was reworded.

### What was selected, and why

**Brand.** `Logo-05` (cream) and `Logo-07` (antique gold) are the only two
masters with an ink that carries a near-black ground — the other six are black,
wine, green or a white knockout. Cream is the hero and the navigation; gold is
the last screen, where the mark is an ornament rather than an identifier.
Trimmed to their own ink and exported at 96 / 160 / 320 as quantised PNG.
**The logo is never redrawn, never set as type, never substituted.**

**The footer lockup.** `Majori_logo/Footer/2.jpeg` — the house over the
wordmark, which is a different mark from the round seal and has no vector
source (`Logo.pdf` is eight pages of the seal). Cut out of its black ground and
re-inked to `--mm-cream-100` at 240 / 360 / 480 by
`tools/brand/build_footer_lockup.py`; the wine and green masters beside it
disappear on this ground, and the white one is the only pure white the page
would contain. **The master is cropped** — the leading M and the final R lose
about a pixel and a half each at 1600px — which is invisible at the 240px the
footer draws it at and is why the ladder stops at 480. An uncropped master is
the thing that would lift it.

**Hero — superseded, and the reasoning is kept because it still holds.** The
first screen was built from
`ESTATE_and_HOSPITALITY/SECOND_BUILDING_GUEST_SUITES.png`, the only supplied
frame that is architecture at blue hour with warm interior light, a foreground
to move through and foliage framing both edges. It now runs from a delivered
master, `media_src/MOTION/HERO/main-hero.mp4`, which was chosen against the same
description and meets it — see §3. What has not changed is the argument for the
temperature: the real exteriors (`estate/estate_1…4.jpg`) are bright midday
documentary photographs, excellent and wrong for a first screen that has to be
near-black. They carry scene 07 instead, where being daylight is the point.

**Not used, and deliberately.** `CIGAR_HOUSE/building-concept.png` and
`RESTAURANT/restaurant_1st_floor.png` are annotated floor plans — the right
material for a page about the plan and the wrong material for a film.
`pavilion/*` and `PRIVATE_CLUB_ECOSYSTEM/3.png` (the garden pavilion at night)
are strong frames with no scene of their own on a page this length.
`CIGAR_HOUSE/main_bar.png` is the best bar photograph in the whole set and is
still not on the page: the club section already carries `MANOR_BAR.png`, which
is the room the brief names, and two long bars of bottles in one scene is one
too many. Nothing was excluded for quality.

**The build script and the page agree exactly.** Every slot the script writes is
used, and every slot the page asks for is written — checked, because the script
sweeps rungs it did not write and a slot in one list and not the other is how a
page ends up with a hatched box on it.

### Where every picture on the page comes from

| Slot | Source in `media_src/` | Ratio |
|---|---|---|
| `home/hero-manor` | *video frame 0* ← `MOTION/HERO/main-hero.mp4` — **delivered master, no still behind it** | 16:9 |
| `home/seq-arrival` | *sequence frame 0* ← `ESTATE_and_HOSPITALITY/reception_concierge.png` | 16:9 |
| `home/seq-dining` | *sequence frame 0* ← `RESTAURANT/dining_salon2.png` | 16:9 |
| `home/seq-club` | *sequence frame 0* ← `CIGAR_HOUSE/cigar_lounge.png` | 16:9 |
| `home/seq-padel` | *sequence frame 0* ← `PRIVATE_CLUB_ECOSYSTEM/1.png` | 21:9 |
| `home/seq-suite` | *sequence frame 0* ← `ESTATE_and_HOSPITALITY/MAIN_MANOR_SUITE.png` | 16:9 |
| `home/story-hall` | `HOUSE_OF_DIALOGUE/1.png` | 16:9 |
| `home/story-library` | `HOUSE_OF_DIALOGUE/2.png` | 4:5 |
| `home/story-stair` | `HOUSE_OF_DIALOGUE/3.png` | 4:5 |
| `home/world-manor` | `RESTAURANT/majestic_lobby.png` | 4:5 |
| `home/world-club` | `PRIVATE_CLUB_ECOSYSTEM/4.png` | 4:5 |
| `home/world-dining` | `RESTAURANT/grand_dining_room.png` | 4:5 |
| `home/world-cigar` | `CIGAR_HOUSE/vip_room.png` | 4:5 |
| `home/world-padel` | `PRIVATE_CLUB_ECOSYSTEM/9.jpeg` | 4:5 |
| `home/world-wellness` | `PRIVATE_CLUB_ECOSYSTEM/7.png` | 4:5 |
| `home/world-suites` | `ESTATE_and_HOSPITALITY/MAIN_MANOR_SUITE.png` | 4:5 |
| `home/world-events` | `PRIVATE_CLUB_ECOSYSTEM/2.png` | 4:5 |
| `home/dining-salon` | `RESTAURANT/dining_salon.png` | 4:5 |
| `home/dining-private` | `RESTAURANT/private_dining_room.png` | 4:5 |
| `home/dining-chefs` | `RESTAURANT/chefs_room.png` | 3:2 |
| `home/club-bar` | `ESTATE_and_HOSPITALITY/MANOR_BAR.png` | 3:2 |
| `home/club-arrival` | `PRIVATE_CLUB_ECOSYSTEM/5.png` | 4:5 |
| `home/club-humidor` | `CIGAR_HOUSE/humidor_display.png` | 21:9 |
| `home/club-whisky` | `CIGAR_HOUSE/whisky_lounge.png` | 3:2 |
| `home/club-terrace` | `CIGAR_HOUSE/outdoor_terrace.png` | 3:2 |
| `home/stay-guest-house` | `ESTATE_and_HOSPITALITY/SECOND_BUILDING_GUEST_SUITES.png` — **replaced; 2880², ladder now reaches 1280** | 4:5 |
| `home/stay-cottages` | `ESTATE_and_HOSPITALITY/private_cottages.png` | 3:2 |
| ~~`home/house-facade`~~ | *slot removed — the plate was taken off the page; `estate/estate_1.jpg` still feeds `estate/hero-facade`* | — |
| `home/house-stair` | `grand-staircase/GrandStaircase_2.jpg` — **photo** | 4:5 |
| `home/house-hall` | `interiors/interiors_3.jpg` — **photo** | 4:5 |
| `home/house-piano` | `interiors/interiors_1.jpg` — **photo** | 4:5 |

Every crop is a line in `tools/photos/build_home_media.py`, with the bias — how
much of the surplus comes off the top — written beside it and its reason. Run
the script to rebuild the whole ladder; **nothing in `media_src/` is ever
written to.**

**Nothing is upscaled.** A rung wider than the cropped source is skipped rather
than interpolated, which is why some ladders are short: `world-*` tops out at
960 and the six posters at 1152–1280. `stay-guest-house` was in that list until
its source was replaced with a 2880² picture; it now carries 1280 like the
plate beside it, and the change is a line in the build script rather than a
decision about the page. `img_files()` publishes the srcset it actually finds.

---

## 3. The cinematic sequences

Six moving plates. **Five are image-to-video generations**, Seedance 2.5 through
Higgsfield, mode `omni_reference`, 720p, no audio, each started from the
photograph beside it. **No still image was generated at any point** — not as an
intermediate, not as a replacement, not as a stand-in for a slot.

**The sixth is the hero, and it is delivered rather than descended.** Its master
arrives finished as `media_src/MOTION/HERO/main-hero.mp4` — 1920×1080, 24 fps,
8.08 s, with an AAC track the encode drops — and it replaced the Seedance
push-in that used to be built from `SECOND_BUILDING_GUEST_SUITES.png`. It has no
ancestor in `media_src/`, so the row below has nothing to name in its *From*
column and the frame-by-frame check against a source photograph cannot be run on
it. **Its marking does not change:** the building in it is the estate as it is
becoming rather than the 1910 house as photographed, so `content/en/home.php`
still declares the hero `source: render`. The retired prompt 01 is kept at the
top of `tools/motion/build_sequences.sh` as the record of what was replaced.
If the new master has a prompt of its own it is not on record and belongs in
that header the moment it is supplied.

| # | Sequence | From | Out | Ship |
|---|---|---|---|---|
| 01 | The manor / hero | *none — delivered as `MOTION/HERO/main-hero.mp4`* | 8 s · 16:9 | `hero-manor.mp4` 2.1 MB · `hero-manor-sm.mp4` 1.2 MB |
| 02 | The arrival | `reception_concierge.png` | 6 s · 16:9 | `seq-arrival.mp4` 0.9 MB |
| 03 | Dining | `dining_salon2.png` | 6 s · 16:9 | `seq-dining.mp4` 1.3 MB |
| 04 | Private club | `cigar_lounge.png` | 6 s · 16:9 | `seq-club.mp4` 1.3 MB |
| 05 | Sport / padel | `PRIVATE_CLUB_ECOSYSTEM/1.png` | 6 s · 21:9 | `seq-padel.mp4` 1.7 MB |
| 06 | Accommodation | `MAIN_MANOR_SUITE.png` | 6 s · 16:9 | `seq-suite.mp4` 0.8 MB |

**Every prompt was written as a preservation instruction rather than a
description.** Each one names the architecture, the furniture and the materials
of the specific photograph and then lists the motion that is allowed — a
gradual dolly, firelight, a candle, a curtain, leaves, a player's rally — and,
explicitly, what may not appear: no new people, no new windows, doors, furniture
or architectural elements, no redesign, no camera shake, no lens flare.
**All six are written out verbatim at the top of
`tools/motion/build_sequences.sh`**, alongside the mapping — a prompt is the
only part of a generated asset that cannot be recovered by looking at it. Prompt
01 is there as history, not as a description of what ships.

**The result was checked frame by frame** against its source before anything was
built on it: four frames across each of the five. The hero has no source in
`media_src/` to be checked against — see the note below — so what was checked on
it instead is that it does not loop, which is what decides the encode.
The reception keeps the MAJORI MANOR crest and lettering exactly; the padel
courts keep the club sign; nothing gains a window or loses a chair.

### The loop is a palindrome

None of the six returns to where it started, so no frame in any of them matches
its own first frame — the replacement hero included, whose first frame is the
house wide across the forecourt and whose last is the portico filling the
screen. A hard cut jumps; a cross-dissolve ghosts the room against
itself — on the dining sequence, two chandeliers. Each therefore plays forward
and then backwards, which is seamless by construction because the last frame of
the reverse *is* the first frame of the forward and no two framings are ever
blended. On a shot this slow the turn reads as the camera settling.

### Encoding

**H.264 only, and that is a measurement rather than a preference.** VP9 at
matching quality came out *larger* on this material — 3.17 MB against 2.99 MB —
because these are dark, slow, grain-free shots, which is the case VP9's
advantages do not appear in. A second format that is bigger than the first is a
second format for nothing.

**CRF 29 on the hero.** 27 gives 2.9 MB, 29 gives 2.2 MB, 31 gives 1.6 MB. At
100% on the lit windows and the sky — where H.264 gives up first on a night
exterior — 27 and 29 are indistinguishable and 31 begins to smear the foliage.

`tools/motion/build_sequences.sh` rebuilds all seven encodes from the six
sources. Five live in `media_src/MOTION/sequences/` and the hero master lives in
`media_src/MOTION/HERO/`, which is why the script now takes a source either as a
bare filename in the directory it is given or as a path from the project root.
All of them are **git-ignored by the existing rule** for masters: the encodes
under `public_html/assets/video/` are the deliverable and those are committed.

---

## 4. The design system

Near-black foundation, warm cream type, restrained antique gold, one warm ground
used once. It is `assets/css/home.css`, it is loaded on this page and no other,
and `main.css` was **not touched** — which is also why the other ten pages
render byte for byte as they did before (verified; see §7).

```
ground        #0B0A08   the page
ground-raised #100E0C   a raised scene
mahogany      #241812   the last screen, and nowhere else
ink           #F2ECE0   16.8:1
ink-muted     #B6AA96    8.4:1
ink-faint     #8B8172    5.2:1
gold          #C9A961    8.8:1  — small text is safe only because the ground is this dark
gold-bright   #E0C68F
```

Primitive → semantic → component, and only the semantic layer is read below the
token block, so the whole page can be regraded from one edit.

**Type** is the two faces the site already self-hosts: Playfair Display for
display at 400 only, Inter for everything else. No new family, no Google Fonts,
no CDN — the client is in the EU and a font request is a third-party request.

**One texture over everything.** A near-black page in flat sRGB bands visibly on
a large panel; the grain is an inline SVG turbulence under 400 bytes that breaks
the band and reads as film. Not a tiled PNG, which would have been 40 KB.

**Twelve columns and the asymmetry is the design.** A plate declares `span`,
`offset` and `raise` in the content file and the grid reads nothing else. Below
900px every offset and raise is *dropped* rather than scaled — a one-column
offset at 390px is four pixels, which is not a composition.

---

## 5. Motion

Everything moves slowly and in one direction. Opacity, one axis of translate,
and a photograph settling from 1.06 to 1. Nothing rotates, bounces or overshoots.

**Nothing is ever hidden by CSS alone.** The usual scroll-reveal sets
`opacity: 0` in the stylesheet and lets a script put it back, which ships a
blank page to anybody whose script does not arrive. Here every element is
visible in the stylesheet, and `home.js` hides an element only at the moment it
creates the trigger that will reveal it — and only if it is below the fold. An
element already on screen is never touched, which is also why there is no flash.

**Reduced motion loads nothing.** Not a smaller animation: the four libraries
are never fetched, `html.motion` is never set, every video is `display: none`
and the posters carry the page. Verified: zero motion requests.

**The hero's own entrance is a CSS keyframe**, so the first screen composes
itself whether or not GSAP arrives.

Libraries: GSAP 3.15 + ScrollTrigger + Lenis 1.3, all vendored, all self-hosted,
all injected after the load event.

---

## 6. Loading

| | |
|---|---|
| Critical path (before load event) | **361 KB** — of which 192 KB is CSS + JS that gzips to about 50 KB |
| Post-load | 2.2 MB hero film + 0.9 MB the first band + 150 KB libraries |
| Full scroll, every band played | ~15.5 MB |
| FCP | 128 ms |
| LCP | 1.16 s |

**No `poster` attribute anywhere, and its absence is worth 470 KB.** A
`<video poster>` is fetched eagerly whatever `preload` says, which was dragging
six JPEGs the reader had not scrolled to into the critical path. The still under
each band is the same frame, is a real `<picture>` with a srcset, and is
lazy-loaded at the right moment.

**Films are attached and released.** Each band's video is fetched when the band
is within a screen of the viewport and released once it is two screens behind,
so a reader who stops halfway has fetched two films and not six. None is fetched
at all on a metered connection or under reduced motion.

**The hero has two encodes** and the choice is made against the viewport rather
than the device: below 900px the 854-wide file, a third of the bytes for a
screen a third of the width.

**LCP is 1.16 s and the photograph is on screen at about 130 ms.** The gap is
the hero's one-second entrance: every element of the first screen is an LCP
candidate and a candidate that is still fading in has not been painted. The
entrance was cut from 1.5 s to 1 s for exactly this reason, which took the
measurement from 1.67 s. Shortening it further would start to cost the
composition; under reduced motion, where there is no entrance, LCP is 100 ms.

---

## 7. What was verified

Tested in headless Chrome at **375 · 390 · 430 · 768 · 1024 · 1440 · 1920**, on
every one scrolling the full page so that every trigger and every lazy image
fires:

- **0 console errors, 0 page errors, 0 failed requests** at every width
- **0 broken images** — all 170 referenced URLs resolve
- **No horizontal overflow** at any width
- **No stuck reveals** — nothing left invisible after the page settles
- **No dead anchors** — every `href="#…"` on the page lands on an element
- **All six films play** in view and are released behind
- **Mobile sheet** opens, traps the scroll, closes on a link and on Escape
- **Reduced motion**: no libraries fetched, nothing hidden, no video
- **No JavaScript**: the complete page renders, all 733 words, all eight index
  labels, every link works
- **Contrast**: 23 text styles measured against their real rendered ground —
  every one passes WCAG AA, lowest 4.8:1
- **The other ten pages are byte-identical**, checked with
  `tools/snapshot_pages.sh` + `tools/compare_pages.sh`
- **No page anywhere lost a photograph it had before** — every slot every
  content file asks for was checked against what was on disk at the previous
  commit

One file outside the Main Page was edited on purpose, and it is not one of the
ten: `content/en/components.php`, the DEV-only component showcase, pointed its
hero example at `home/hero-pavilion-night`. That slot belonged to the old home
page, the Main Page does not declare it, and `build_home_media.py` sweeps rungs
nothing declares — so the showcase would have grown a hatched box in the one
place on the site that exists to show a component finished. It now points at
`home/hero-manor`, marked `render`, because that is what the picture is.

---

## 8. What this is not, and what is left

**It is one page.** No booking, no CMS, no authentication, no membership
back end, no dashboards. The two actions on the last screen lead to
`/membership` and `/contact`, which already exist and already work.

Known limits, all deliberate:

- **The six posters top out at 1152–1280px** because the sequences are 720p.
  On a 4K display the poster is upscaled for the second before the film
  arrives. Fixing it means regenerating at 1080p, which is a credit decision.
- **`world-cigar` and the other `world-*` plates top out at 960px.** They render
  at about 305px on a desktop, so 960 covers 2× and stops there.
- **The navigation addresses this page, not the site.** `THE MANOR`, `DINING`,
  `STAY` and the rest are anchors into the film. When the other pages are
  designed, this bar becomes a real site navigation and `own_chrome` in the
  content file comes back out.
- **`WELLNESS` and `EVENTS` have no scene of their own.** They anchor to their
  own plates inside the club, which is where the supplied material puts them.
- **Nothing on this page has been seen on a real iOS device.** `100svh`,
  `backdrop-filter` and inline autoplay all behave in headless Chrome; Safari is
  the one that has to be checked by hand before this goes in front of anyone.
