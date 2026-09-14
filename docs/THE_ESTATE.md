# Majori Manor — THE ESTATE

**The second page cut from the Main Page's film.** Everything below is what was
built, what it was built from, and the decisions worth arguing with.

Read it with `public_html/content/en/estate.php` open beside it. That file is
the page: every act, every scene, every ratio, every sentence and every picture
is declared there, and nothing on THE ESTATE can be changed anywhere else.

---

## 1. What it is

One page, nine scenes, six acts, read top to bottom as a walk through a house.

| | Scene | Act / ground | Carries |
|---|---|---|---|
| 00 | **The arrival** | estate · near-black | The manor at blue hour — a Seedance sequence, full screen |
| 01 | **The house** | estate | *A house, and the ground it stands on.* |
| 02 | **What it has kept** | estate | The facade, tracked; the architecture that survived |
| 03 | **The walk** | heritage · mahogany | Seven rooms, one sticky viewport, scroll-scrubbed |
| 04 | **The details** | heritage | Six things a century of other uses usually takes |
| 05 | **The record** | interior · deepest | The five settled facts, set as a drawing sheet |
| 06 | **The lands** | park · green | The sixteenth century, and the one that followed |
| 07 | **The park** | park | *Ground of its own* — 21:9, full width |
| 08 | **Renewal** | evening · wine | The hearth, and the work under way now |
| 09 | **Belonging** | estate · near-black | *Some places are visited. Others, you belong to.* |

**It changes temperature and the Main Page does not.** The Main Page holds one
ground from first screen to last, which is right for a film that never
brightens. This one is a walk through a house, so it moves: near-black at the
gates, mahogany where the woodwork is, green out in the park, wine at the
hearth, near-black again at the end. Every act is still a dark ground — the
difference between them is a few percent of hue — and each is washed into the
next by a gradient rather than cut to. See §1 of `estate.css`.

**Nothing in the copy is new.** The page was rebuilt in the Main Page's visual
language and the copy came with it, nearly word for word: the same facts, the
same headings — *What the house has kept*, *The lands, and the century that
followed*, *Ground of its own*, *A period of renewal* — and the same five-line
inventory. What changed is how it is set. There is **less** of it than there
was, because six sequences and eleven photographs now do the telling and a
paragraph that repeated a picture was cut rather than kept.

---

## 2. The asset audit

All twelve directories of `media_src/` were inspected: **73 supplied stills**
(55 photographs and visualisations, 18 brand files), plus the Main Page's
`MOTION/` folder.

| Directory | Files | Kind | Used here |
|---|---|---|---|
| `estate/` | 4 | photographs | **3** — estate_1, estate_2, estate_3 |
| `interiors/` | 4 | photographs | **4** — all of them |
| `grand-staircase/` | 4 | photographs | **3** — GS_1, GS_2, GS_3 |
| `heritage-details/` | 3 | photographs | **3** — all of them |
| `pavilion/` | 3 | photographs | 0 |
| `ESTATE_and_HOSPITALITY/` | 7 | visualisations | 0 |
| `RESTAURANT/` | 7 | visualisations | 0 |
| `CIGAR_HOUSE/` | 9 | visualisations | 0 |
| `PRIVATE_CLUB_ECOSYSTEM/` | 11 | visualisations | 0 |
| `HOUSE_OF_DIALOGUE/` | 3 | visualisations | 0 |
| `Majori_logo/` | 18 | brand | **2** — seal-cream, seal-gold |
| `MOTION/` | 13 | the Main Page's sequences | 0 |

**Thirteen of the fifteen photographs of the manor are on this page.** The two
that are not:

- `estate/estate_4` — the park front again, which `estate_2` frames better and
  which the golden-hour still is made from.
- `grand-staircase/GrandStaircase_4` — a landing with a service hatch, the one
  interior frame with nothing architectural as its subject.

**The five directories of visualisations were deliberately not used, and the
pavilion with them.** THE ESTATE is the heritage page. Its subject is the
building that exists; a render of a room the club intends to build has nothing
to say about the house of 1910. The pavilion is a marquee on a lawn and it
belongs to /events. This is the exact inverse of the Main Page, where scenes
00–06 are visualisations and only scene 07 is the real building — the two pages
divide the same library along the same line, from opposite sides.

---

## 3. What was generated, and from what

**Two stills and six sequences.** Every one descends from a photograph in
`media_src/`, and the descent is recorded in
`tools/photos/build_estate_media.py`.

### Stills — GPT Image 2, 2K, from a reference

| Output | From | What changed |
|---|---|---|
| `still-bluehour.png` | `estate/estate_1.jpg` | **The time of day, and nothing else.** Blue hour, interior lamps lit, the brick damp. Every architectural element preserved: the barrel-vaulted bay and its oculus, the chimney count and positions, the dark timber windows, the fieldstone base, the slat fencing, the gate piers. |
| `still-park-evening.png` | `estate/estate_2.jpg` | **The time of day.** Golden hour from the left, the mature tree backlit. The portico, its four columns, the pedimented gable and its oval window, the polygonal bay, the lawn — all as photographed. |

**One thing was removed and nothing put in its place.** `estate_1` carries an
Estonian name plate — `VINKEEE MAJA AEBNIK` — legible on the gate pier. The
prompt forbade signage and lettering anywhere, so the pier is blank. Inventing
a Majori plate would have been the first dishonest thing on the page.

### Sequences — Seedance 2.0, 720p, 16:9 (21:9 for the park), no audio

| Sequence | Started from | Motion |
|---|---|---|
| `est-arrival` | the blue-hour still | Slow dolly forward through the gate piers |
| `est-house` | `estate/estate_3.jpg` | Slow lateral track across the facade |
| `est-hall` | `interiors/interiors_3.jpg` | Slow push-in under the chandelier |
| `est-stair` | `heritage-details/heritage_3.jpg` | Slow rising push toward the foot of the stair |
| `est-hearth` | `interiors/interiors_1.jpg` | Slow drift to the tiled stove, fire alight |
| `est-park` | the golden-hour still | Slow lateral drift across the park |

Every prompt is written as a **preservation instruction**, following
`tools/motion/build_sequences.sh`: it names the architecture, the furniture and
the materials of that specific photograph, lists the motion that is allowed,
and then says what may not appear. The negative half does the work. All six
are in the build script, verbatim, because a prompt is the only part of a
generated asset that cannot be recovered by looking at it.

### The honesty marking, and why this page is the first to use `generated`

| marking | count | what it is here |
|---|---|---|
| `photo` | 11 | Crops of the supplied photographs. Nothing added, nothing upscaled. |
| `generated` | 6 | The six sequences and their posters. |

`IMG_SOURCES` in `app/helpers.php` has carried `generated` unused since before
this page existed. It is used now for a specific reason:

> Every sequence was started from a photograph and every prompt was a
> preservation instruction — **but Seedance reframes a portrait source to a
> landscape output.** All the interior sources are ~0.88 aspect; the outputs
> are 16:9. What fills the new width is synthesised from the vocabulary of the
> photograph rather than photographed.

That is not a visualisation of an unbuilt room, so it is not `render`; and it
is not a photograph. `film-band.php`, `film-plates.php` and `film-walk.php`
append **"Generated image"** automatically and a content file cannot switch it
off.

**Where the synthesis is most visible, stated plainly:** `est-house` extends
the facade laterally beyond what `estate_3` shows and adds a lower wing at the
right with a standing-seam roof. Every element is drawn from the photograph's
own vocabulary and `estate_1`/`estate_4` confirm the house is long and
multi-bay — but that specific wing is not in any supplied frame. It is
labelled, and it is the clearest instance of extrapolation on the page.

**The hero carries no label**, because the hero has no caption slot and the
Main Page's hero — also synthesised — carries none either. Consistency with
the approved page won over adding a caption to a component the Main Page
renders. It is a known gap on both pages rather than a decision special to
this one.

---

## 4. What was built, and what was reused

**Reused unchanged from the approved Main Page:** `film-hero`, `film-band`,
`film-chapter`, `film-plates`, `film-invitation`, `film-nav`, `film-footer`,
and the whole of `home.css` and `home.js` — the tokens, both faces, the grain,
the navigation, the seven motion jobs, the reveal states, the mobile pass.
`head.php` now lists the two film pages in one table, so a token edited in
`home.css` moves both pages and they cannot drift.

**New, and only what the Main Page has no use for:**

| File | What it is |
|---|---|
| `components/film-walk.php` | The sticky scroll-scrubbed sequence |
| `components/film-ledger.php` | The five facts as a drawing sheet |
| `assets/css/estate.css` | The six acts, the walk, the ledger, the nav's active state, the hero's copy band |
| `assets/js/estate.js` | Two jobs: the walk, and the ledger's rules |
| `tools/photos/build_estate_media.py` | The crop, encode and poster table |

**Three shared files were touched and none of them changed a single byte of
any other page** (proved in §7):

- `partials/head.php` — the film-page table. The home row adds no file, so its
  markup is what it was.
- `partials/film-nav.php` — `aria-current` / `.is-current` on the link that
  names the current page. `home` is in `NAV_EXCLUDE`, so on the Main Page no
  bar link is ever current and the markup is unchanged.
- `components/film-band.php`, `film-plates.php` — the caption now labels
  `generated` as well as `render`. Every picture on the Main Page is `render`
  or `photo`, so its output is unchanged.
- `components/film-hero.php` — the scroll cue's target. It was hardcoded
  `href="#arrival"`, which is the id of the Main Page's first scene and was
  correct on the one page this component had. On the second it pointed at
  nothing: THE ESTATE has no `#arrival`, so pressing "Enter the house" changed
  the address bar and did nothing else. It now reads `cue_target` from the
  content file and **defaults to `arrival`**, so the Main Page's markup and
  content file are both unchanged. Caught by walking every in-page anchor in
  the browser; it is the one real defect this work found in a shared component.

---

## 5. The walk

The one place on the site where scroll drives a camera. Seven stations, in the
order somebody actually moves through the house:

> the hall → the chandelier → the marble → the staircase → the glass → the
> landing → the doors

**Five are photographs and two are sequences**, each sequence made from the
photograph of the very room it stands in.

**It is a gallery first and a sequence second.** `estate.css` draws it as seven
full-width captioned figures in content order. `estate.js` adds
`html.is-walking` at the moment it takes responsibility for the stage, and only
that class turns the stack into a viewport. With no JavaScript, a blocked CDN,
or `prefers-reduced-motion`, the reader gets a long quiet gallery — which is a
complete way to see seven rooms, and not a column of blank boxes. This is §13
of `home.css` applied to a component `home.css` knows nothing about.

**The dissolve is opaque from the bottom up.** Cross-fading two frames at half
opacity lets the ground through between them and ghosts one room over another;
on architecture, which is all straight lines, that reads as a printing error.
So every frame stays at 1 once it has arrived and the next fades in *on top of
it*. Only one pair is ever mixing, and `BAND = 0.26` means about three quarters
of every station is one clean photograph.

**Two films at a time, wherever the reader stops.** A station's film is
attached when it is the one in front or next in line, and released otherwise;
measured peak across a full scroll of the page is **three videos attached at
once out of six**, and one at the bottom.

**A station may declare a `focus`.** The stage is the viewport, so a 16:9 frame
in a 390×844 window is cropped to about a third of its width — and the middle
third of a room is very often the wall nothing is happening on. Four stations
carry an `object-position` chosen by looking at the portrait result: the hall at
80% (the chimneypiece is at the right), the staircase at 35%, the glass at 30%,
the landing at 26%. Without it, *The glass* on a phone is a blank plaster wall
and the stained window is off-frame.

---

## 6. The hero's legibility, and the grade

The Main Page's hero puts its copy over dark stone, which is why `home.css`
leaves the scrim transparent between 26% and 44%. **THE ESTATE's hero is the
real Majori Manor, and the real Majori Manor is white render.** Cream type on a
white wall measures about 1.2:1.

Half the fix is in the picture and half is in CSS:

1. `est-arrival` is graded down before encoding — `curves=all='0/0 0.5/0.44
   1/0.90'`, about six percent off the mids and ten off the highlights. That
   lands it at roughly the density of the approved Main Page hero: deep blue
   hour, the lit windows the only bright thing in frame. It is the
   cinematographer's answer, and it leaves `home.css` alone.
2. `estate.css` adds a soft band behind the copy as a **pseudo-element over**
   the existing scrim, not a replacement for it, so `home.css` stays the only
   place the hero's scrim is described.

Measured on the rendered page, against the 95th-percentile brightest
background pixel each line crosses, with the copy hidden so the type is not
sampled as its own background:

| | eyebrow (gold) | title | subtitle | statement | cue |
|---|---|---|---|---|---|
| 1440×900 | 4.98 | 9.15 | 9.36 | 6.14 | 7.51 |
| 390×844 | 5.41 | 10.61 | 6.47 | 5.31 | 7.46 |
| 1920×1080 | 5.35 | 8.59 | 10.16 | 6.68 | 7.78 |

All clear WCAG AA (4.5:1 normal, 3:1 large). Neither half does it alone, and
either alone taken far enough would have cost the building.

---

## 7. Verification

Everything below was run against `php -S` with `tools/serve_router.php`, and a
second server built from an inverted copy of the working tree — the "before"
state — on a second port.

**Scope.** All eleven other routes plus the 404 were diffed between the two
servers:

```
/  (home)      IDENTICAL      /membership    IDENTICAL
/the-club      IDENTICAL      /contact       IDENTICAL
/padel         IDENTICAL      /privacy       IDENTICAL
/events        IDENTICAL      /terms         IDENTICAL
/residences    IDENTICAL      /nope-404      IDENTICAL
/after-dark    IDENTICAL
```

The home page is **byte-identical with no masking at all** — including the
`?v=` cache-busting query on every asset, which means not one shared file the
Main Page loads was modified.

**Rendering.** Headless Chrome, real wheel events so Lenis drives the scroll.

| Width | doc height | walk | overflow-x | console |
|---|---|---|---|---|
| 375×812 | 14 346 | stage | 0 | clean |
| 390×844 | 14 609 | stage | 0 | clean |
| 430×932 | 15 186 | stage | 0 | clean |
| 768×1024 | 17 740 | stage | 0 | clean |
| 1024×768 | 14 785 | stage | 0 | clean |
| 1440×900 | 18 572 | stage | 0 | clean |
| 1920×1080 | 20 936 | stage | 0 | clean |

No console errors, no page errors, no failed requests, no 4xx, and no
horizontal scroll at any width.

**Fallbacks.**

| Mode | `is-walking` | frames hidden | videos attached | images loaded |
|---|---|---|---|---|
| normal | yes | 6 of 7 | 3 of 6 | lazy |
| **JavaScript off** | no | **0 of 7** | 0 | 20 of 20 |
| **reduced motion** | no | **0 of 7** | 0 | lazy |

With JavaScript off the page is 12 scrolled screens of complete, captioned
gallery, the footer renders, and no image is broken. Under
`prefers-reduced-motion` no library is fetched at all.

**Vertical rhythm.** Every gap between sections measures 158–159px at 1440 —
exactly one `--scene`. Margins collapse correctly through the act wrappers.

**Navigation.** THE ESTATE carries `aria-current="page"` and `.is-current` in
both the bar and the sheet, styled as the hover rule held rather than as a new
state. The mobile sheet opens, locks the scroll, marks itself, and closes on
Escape with focus returned.

**Weight.**

| | raw | gzip |
|---|---|---|
| `estate.css` | 21 930 | **6 686** |
| `estate.js` | 15 035 | **5 132** |
| page HTML | — | **7 272** |

The hero's poster is 82 KB WebP and is the LCP element. The film is 967 KB
wide / 260 KB narrow and is fetched only after `load`, only when motion is
welcome, only off a metered connection. The six sequences total 5.9 MB on disk
and a reader never holds more than three.

---

## 8. Limitations

1. **`est-house` extrapolates.** Stated in §3. It is labelled, and a second
   photograph of the entrance front is the thing that would fix it.
2. **The hero is unlabelled**, matching the Main Page. §3.
3. **The two exterior sequences descend through a generated still**, so they
   are two steps from a photograph rather than one. Recorded in the build
   script's `SEQUENCES` table.
4. **`detail-baluster`, `detail-capital` and `detail-fittings` publish only a
   640 rung.** Nothing is upscaled here, and a genuine detail crop of an
   1170px source does not reach 960. They render at ~380–480 CSS px, so the
   rung is sufficient; a wider source would buy a sharper plate on a 2× screen.
5. **`tools/weigh_assets.sh` is broken** and was already broken before this
   work — it references `assets/js/home-atmosphere.js`, which does not exist.
   Not touched, because it is the Main Page's tool.
6. **Latvian is not written.** `content/lv/estate.php` does not exist, as for
   every other page. The route is already in `routes.php`.
