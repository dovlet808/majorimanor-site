# Majori Manor — PRIVACY

*The tenth page cut from the film, and the only one that is a document.*

| | |
|---|---|
| Address | `/privacy` |
| Template | `templates/pages/privacy.php` — its own, no longer `pages/legal.php` |
| Content | `content/en/privacy.php` — **the policy is byte for byte unchanged** |
| Layers | `home.css` → `privacy.css` · `privacy.js` (no GSAP, no Lenis, no `home.js`) |
| Media build | `tools/photos/build_privacy_media.py` |
| Generated | 1 GPT Image 2 still, 1 Seedance 2.0 sequence |
| Credits | **29** (see §9) |
| Weight | **1 122 KB** at 1440 (374 KB before the deferred hero video), against 1 750 KB for CONTACT, the lightest page before it (§8) |

---

## 1. What it is

**THE QUIET SIDE OF THE ESTATE.** The nine approved pages are a film. This one
is a policy, and it has exactly two things in common with them: the chrome and
the first screen. Everything under the hero is a reading surface.

| | Band | Ground | Carries |
|---|---|---|---|
| 00 | **The doors** | estate · near-black | A glazed mahogany screen at first light, one leaf standing open — clamped to 62svh, moving |
| 01 | **Contents** | `--green-900` | The ten clauses, the two sub-clauses, and when the document last changed |
| 02 | **The document** | `--cream` | The policy, in a 37rem column, numbered in the margin |
| 03 | **The footer** | the film's own | Unchanged |

### The concept, and what it is not

The brief: *"Do not make the privacy policy look like marketing. Make it feel
like THE SAME MAJORI MANOR, WITH THE DOORS OPEN."*

So the page opens on a photograph of exactly that — a screen of dark mahogany
and clear glass with one door standing open — and then gets out of the way. The
hero is two thirds of a screen rather than all of it, there is no scroll cue, no
seal, no subtitle, no invitation, no second picture, and nothing at all between
the first screen and the first clause but a table of contents.

### The colour rhythm is the brief's, exactly

```
hero        #0B0A08   near-black   the film's own ground
contents    #123328   green-900    the legal navigation
document    #F2EDE4   cream        the readable surface — 90% of the page
footer      #0B0A08   near-black   the site's footer, unchanged
```

**The document does not go dark and that is the one hard rule of this page.**
Every other page on this site is near-black from the first screen to the last;
two and a half thousand words of cream type on near-black is a page nobody
finishes.

---

## 2. The asset audit

All twelve directories of `media_src/` were re-walked before anything was
chosen. What was looked for: a manor exterior, an entrance, a reception, a quiet
interior, an architectural detail, a private corridor, dark wood, the estate at
dusk — and what was ruled out by the brief before looking: crowds, padel,
restaurants, cigars, gaming, celebration.

| Directory | Files | Verdict |
|---|---|---|
| `heritage-details/` | 3 | **`heritage_1.jpg` is this page's source.** The glazed mahogany screen with one leaf open — see below |
| `estate/` | 4 | The gate, the garden front, the elevation. All four are already a hero or a band on THE ESTATE, CONTACT, RESIDENCES or MEMBERSHIP |
| `grand-staircase/` | 4 | The stairhall. Quiet and right in kind, but it is THE ESTATE's walk, four plates of it |
| `interiors/` | 15 | Rooms of the real house and eleven renders of them. The four photographs are THE ESTATE's; the renders are dining and club rooms |
| `ESTATE_and_HOSPITALITY/` | 7 | `reception_concierge.png` is the only reception in the library and it is CONTACT's scene 04 |
| `PRIVATE_CLUB_ECOSYSTEM/` | 12 | Grounds, gates, signage. `12.jpeg` carries a branded buggy; `8.jpeg` is `pad-gates` on /padel |
| `pavilion/` | 3 | EVENTS' subject |
| `HOUSE_OF_DIALOGUE/` | 3 | THE CLUB's subject |
| `CIGAR_HOUSE/` | 9 | Ruled out by the brief — cigars |
| `RESTAURANT/` | 7 | Ruled out by the brief — restaurant scenes |
| `Majori_logo/` | 23 | Lockups; already built into `assets/img/brand/` |
| `MOTION/` | 10 folders, 74 files | Every existing sequence reviewed. All nine are an approved page's — see §3 |

### Why `heritage_1.jpg` and nothing else

It is the only frame in the library that is *all* of the brief's adjectives at
once and is also, literally, the subject of the page:

> **A tall glazed screen of dark mahogany, with one leaf standing open.**
> Dark wood and clear glass. You can see through it.

A privacy policy is a document about what can be seen through. Nothing else in
182 files says that.

**It is not an approved page's hero.** THE ESTATE uses this photograph twice —
as `walk-doors`, one of seven stills in a scroll-driven gallery, and as
`detail-fittings`, a 3:4 crop of the brass ironmongery — both in flat summer
daylight, and neither of them a first screen. What this page shows is the same
joinery at first light, moving. Same negative, different photograph.

### Three things considered and not used

**`estate/estate_3.jpg`** — the garden elevation with its parterre, which is the
calmest exterior in the library. It is MEMBERSHIP's `mem-house` and RESIDENCES'
band, and a third page opening on the same elevation would read as a template.

**`grand-staircase/GrandStaircase_1.jpg`** — the landing under its coffered
ceiling. Quiet, architectural, correct in every way except that it is THE
ESTATE's `walk-landing` *and* its `detail-coffers`, at the top of a page whose
whole subject is that staircase.

**`MOTION/estate/est-hall.mp4`** — an existing slow push through the hall.
Reusing it would have put an approved page's scene on a second page, which is
the rule CONTACT set (`docs/CONTACT.md` §2) and every page since has kept.

---

## 3. What was generated, and from what

**One still and one sequence, and the page has no other picture in it.**

```
SOURCE       media_src/heritage-details/heritage_1.jpg    1735 x 906
             ↓ 16:9 crop, centred (62px off each side)
REFERENCE    media_src/MOTION/privacy/ref-doors.png       1611 x 906
             ↓ GPT Image 2, 2K, high, 16:9, from that reference
STILL        media_src/MOTION/privacy/still-doors.png     2688 x 1520
             ↓ Seedance 2.0, 720p, std, 16:9, 5 s, no audio, start_image
MASTER       media_src/MOTION/privacy/pri-doors.mp4       1280 x 720, 24 fps, 5.04 s
             ↓ trim 2.4 s → slow ×1.6 → interpolate to 24 fps → palindrome → encode
VIDEO        assets/video/pri-doors.mp4       748 KB   1280 wide   7.44 s
             assets/video/pri-doors-sm.mp4    279 KB    854 wide
POSTER       assets/img/privacy/pri-doors-{768,1280}.{jpg,webp}   frame 0 of the encode
MOTION       Extremely slow level push toward the open leaf. The doorway opens
             very slightly, the foliage beyond the far windows stirs, the band
             of morning light on the floor breathes. Nothing else moves.
```

Both prompts are printed verbatim in `tools/photos/build_privacy_media.py`,
because a prompt is the only part of a generated asset that cannot be recovered
by looking at it. Both are written as **preservation instructions**: each names
the architecture, the joinery and the materials of that specific frame, states
the one thing that may change, lists the motion that is allowed, and then says
what may not appear.

### What changed between the photograph and the still: the hour, and nothing else

Checked element by element against the reference — the glazed screen and its
cornice, the hundred-odd glazing bars, the open leaf at the same angle, both
brass espagnolette bolts, the brass hinges, the segmental-arched head of the
doorway, the panelled section at the left, the tall casement window with its
trees, the balustrade with its turned balusters and two round newel caps, the
lozenge panel at the right, the timber floor through the doorway. All present,
all in place, same camera, same lens, same horizon.

The reference measures **77 out of 255**; the still measures **29.1**, which is
the bottom of the 29–40 band every approved hero on this site sits in.

### `start_image`, not `omni_reference`

The brief asks for `mode: omni_reference`. The sequence is built on
`start_image` instead, and the reason is the brief's own instruction two
paragraphs above it — *"Preserve: manor architecture, materials, windows,
woodwork, doors, landscape, proportions, Majori Manor identity."* A reference is
a mood; a start frame is a contract. It is the only setting under which a
hundred glazing bars and two brass bolts survive five seconds of camera movement
intact, it is what every sequence on the nine approved pages uses
(`build_events_media.py` set the rule and five pages have kept it), and it is
what makes the poster honest: frame 0 of the encode is what a reader sees before
the video plays, so the still and the film cannot re-frame against each other
when the video fades up.

### Why it is trimmed to 2.4 s and then slowed to 3.84

The master accelerates. Measured against frame 0 by best-fit scale:

| t | 1.0 s | 2.0 s | 2.4 s | 3.0 s | 4.0 s | 5.0 s |
|---|---|---|---|---|---|---|
| scale | 1.05 | 1.15 | ~1.19 | 1.26 | 1.59 | 1.59 |

The last two seconds are a camera walking into a door, which is an arrival and
not a breath. **Cut at 2.4 s** the shot grows by about a fifth, which is the
figure CONTACT's hero settled on and the most this design system has ever let a
hero move.

That is still 7.9% a second — a marketing hero's rate — and this brief asks for
motion that is *"nearly imperceptible"* and for *"a still architectural
photograph that is quietly alive"*. So `setpts` spreads the same travel over
**3.84 s — 4.9% a second, the gentlest move on the site** — and `minterpolate`
rebuilds the intermediate frames so the encode is a true 24 fps rather than 15
fps of duplicates. Interpolated frames were inspected at 1 s and 2 s: the
glazing bars, the balusters and the arch are clean.

### The loop is a real palindrome, and the harness found that the last one was not

`build_privacy_media.py` puts `-t` **before** `-i`, so the trim limits the
decode and the palindrome is built from 2.4 seconds of it.
`build_contact_media.py` puts it after, where it limits the **output** — which
truncates the palindrome instead of the source. Measured on the shipped files:

| | first frame vs last frame, mean abs difference |
|---|---|
| `pri-doors.mp4` | **2.17** — compression noise; a seamless loop |
| `con-arrival.mp4` | **33.18** — a hard cut back to frame 0 |

/contact is approved and outside this brief, so nothing there was touched and
nothing there was rebuilt. It is recorded here because the next page to copy
that script should copy this one's argument order instead.

---

## 4. What was built, and what was reused

### New files (6)

| File | Lines | What it is |
|---|---|---|
| `templates/pages/privacy.php` | 145 | The page. Numbers the clauses, groups the sub-clauses, draws the document frame |
| `templates/components/legal-clause.php` | 181 | One clause, set as an editorial document. `clause.php`'s text pipeline exactly |
| `templates/components/legal-index.php` | 98 | The contents — one list, a band on a phone and a sticky index on a desktop |
| `assets/css/privacy.css` | 932 | This page's layer — tokens, hero clamp, document grid, index, clause, notice |
| `assets/js/privacy.js` | 302 | Four jobs, no library. Replaces GSAP + ScrollTrigger + Lenis + `home.js` |
| `tools/photos/build_privacy_media.py` | 465 | One reference crop, one sequence, both prompts verbatim |
| `docs/PRIVACY.md` | this file | |

### Rewritten (1)

`content/en/privacy.php` — **one line changed and five keys added. No legal text
was touched.** See §6.

### Additive edits to shared files (3) — every one proved inert

| File | Change | Who can see it |
|---|---|---|
| `templates/partials/head.php` | a `'privacy'` row in the film table, plus `'motion'` and `'defer'`, both defaulted | /privacy only |
| `templates/pages/legal.php` | comments only — it is now a one-page template | nobody |
| `tools/measure_contrast.js` | fifteen selectors added to the harness | a local harness; nothing under `public_html/` knows it exists |

**Proved, not assumed.** `tools/snapshot_pages.sh` was run with the `head.php`
patch reverted and again with it in place; `tools/compare_pages.sh` reports
every one of the other thirteen routes byte-identical. /contact and /membership
differ only by their per-request `form_time` token, which is what that token is
for.

### What was left out

Every film component: the acts, the walk, the ledger, the lateral detail track,
the dialogue, the plates, the world and the invitation. This page is a hero, a
list and a document, and each of those would have been a screen it did not need.

### Why it does not share a template with /terms any more

It used to: `pages/privacy.php` and `pages/terms.php` were two lines each and
both required `pages/legal.php`. Rebuilding the shared frame would have redrawn
/terms as well — unbriefed and unapproved — and the brief is *"Modify ONLY
/privacy"*. So `legal.php` and `clause.php` are untouched, /terms renders
byte-identically, and the cost is one duplicated text pipeline in
`legal-clause.php`. **When /terms is rebriefed it should be rebuilt from
`legal-clause.php`, and `legal.php` should go.**

---

## 5. The layout

### Desktop, ≥1080px

```
      ┌── 13–16rem ──┐   ┌──────── 37rem ────────┐ ┌ 4.5rem ┐
      │  CONTENTS    │   │                       │ │        │
      │  Last updated│   │  ─────────────────────────────── │
      │              │   │  What this covers         01     │
      │  01 …        │   │                       │ │        │
      │  02 …   ←    │   │  This policy covers …  │ │       │
      │  (sticky)    │   │                       │ │        │
      └──────────────┘   └───────────────────────┘ └────────┘
        green panel        the reading column       the number
```

The reading column is **37rem — 66 to 70 characters** at the document's
18–19.5px body. `main.css`'s `--measure` is 34rem, which is right for a caption
under a photograph and one line short for a clause.

**The clause number hangs in the right margin above 1240px**, which is the
brief's *"subtle page metadata"* on the right without a second navigation. It is
the oldest device in legal typesetting, it costs no script and no observer, and
it is `aria-hidden` because the index beside it carries the same information in
a form a reader can actually use.

### The index is one element with two behaviours

| Width | What it is |
|---|---|
| < 600px | A full-bleed green band between the hero and the document. The brief's *"small top-level legal navigation"* |
| 600–1079px | The same band, inset, in two columns — ten short lines down one edge of a 700px panel is a block of green rather than a table of contents |
| ≥ 1080px | The same element, sticky in the left column, one column |

**It is never duplicated and never hidden.** Rendering it twice and hiding one
copy would put all twelve headings of this policy into the accessibility tree
twice, which is the one thing a document navigator must not do.

At a 900px window the whole index fits (740px of content against 764 available);
below that it scrolls inside itself with `overscroll-behavior: contain`.

### The highlighted notice

The controller's legal name, registration number and registered address have not
been supplied (ARCHITECTURE §21, open question 4) and the policy prints the gap.
The brief: *"Preserve the existing notice exactly… subtle border, warm
paper-like surface, elegant label, sufficient contrast… Do NOT visually hide or
de-emphasize legally important information."*

**The sentence is untouched and the label is still `t('legal.todo')` — the word
TODO.** What changed is the treatment: it was a dashed `--danger` box, which
reads as a form validation error, and it is now a warmer sheet of the same paper
with a wine edge down its side. Wine on that ground measures **7.9:1** and the
body text on it **14.3:1**.

---

## 6. Legal-content preservation, verified two ways

### 1. The arrays, diffed

A copy of `content/en/privacy.php` was taken before any work started. The
`title`, `links`, `updated`, `meta` and `sections` arrays were dumped from both
and compared:

```
LEGAL ARRAYS IDENTICAL: title, links, updated, meta, all 12 sections
```

The whole diff of the file is **one line removed** — `'mood' => 'day',` — and
comments and five presentation keys added: `mood` (now `'night'`), `own_chrome`,
`nav`, `footer`, `hero`, `document`. Not one of the five contains a word of the
policy. The hero's eyebrow, headline and supporting line are read from `title`,
which is where they have always lived, so the first screen cannot say anything
the approved document does not.

> The brief offered a supporting line: *"WHAT THIS SITE COLLECTS, WHY IT GOES
> THERE, AND HOW TO HAVE IT REMOVED"*, on condition it already exists in the
> project. **It does not.** The approved line is *"What this site collects, why,
> where it goes, and how to have it removed."* — and that is what the page
> prints, word for word.

### 2. The rendered page, compared node by node

The document region of the rendered HTML was parsed and every heading,
paragraph, list item and notice compared, in order, against the strings in the
content file with the `{token}` links resolved the way `clause.php` resolves
them:

```
54 text nodes  ->  IDENTICAL to the approved content, in order
12 anchors: scope, controller, collected, collected-membership,
            collected-enquiry, basis, where, retention, technical,
            cookies, map, rights   — the content file's own ids, unchanged
 3 mailto links to info@majorimanor.com
 3 internal links: /contact, /membership, /terms
```

**Nothing was rewritten, paraphrased, shortened, reordered, added or removed.**
No new legal basis, retention period, cookie, processor, controller,
obligation, right, jurisdiction, contact detail or company fact appears
anywhere on the page. Every anchor a reader or another site may already have
bookmarked still lands on the same clause.

---

## 7. Verification

Local server, `php -S 127.0.0.1:8321 -t public_html tools/serve_router.php`.
Playwright 1.56 Chromium at eight widths; the hero video checked in system
Chrome, which is the browser on this machine with an H.264 decoder.

| | Checked | Result |
|---|---|---|
| 1 | All twelve `media_src/` directories re-audited | §2 |
| 2 | The generated still descends from `media_src/` | §3 — `heritage_1.jpg` → 16:9 crop → still |
| 3 | The sequence descends from that still | §3 — `start_image`, not a text prompt |
| 4 | Architecture preserved through both generations | Screen, cornice, glazing bars, open leaf, both bolts, hinges, arch, casement, balusters, newel caps, lozenge panel, floor — all present and in place |
| 5 | The policy's wording is unchanged | §6 — arrays diffed, 54 rendered nodes compared |
| 6 | No clause rewritten, shortened or reordered | §6 |
| 7 | No new factual or legal claim added | §6 |
| 8 | Every section readable | 12 clauses, 29 paragraphs, 14 list items, rendered at every width |
| 9 | Anchor navigation | All 12 land clear of the fixed bar — heading top 182px, bar bottom 76px. The hash updates; a deep link to `/privacy#rights` lands the same way |
| 10 | Active-section indicator | Follows a click on all 12, and tracks a scroll through the document in order without skipping or sticking |
| 11 | Return to the top | `scrollY = 0` |
| 12 | Desktop layout | 1080 / 1280 / 1440 / 1920 — sticky index, reading column, margin numbers |
| 13 | Mobile layout | 375 / 390 / 430 — full-bleed contents band, one column, 18px body |
| 14 | **JavaScript OFF** | 55 text nodes, **0 hidden**, 5 631 characters. 0 scripts and 0 video fetched. The bar renders solid; all 7 navigation links plus MEMBERSHIP are on screen at 390px; all 12 anchors work |
| 15 | **prefers-reduced-motion** | 55 text nodes, 0 hidden. No video, no GSAP, no Lenis, no `home.js`. Hero animation `none`, opacity 1. `scroll-behavior: auto` |
| 16 | Horizontal overflow | `scrollWidth − innerWidth = 0` at 375 / 390 / 430 / 768 / 1024 / 1280 / 1440 / 1920, at the top of the page and at the bottom |
| 17 | Broken images | 0 at all eight widths |
| 18 | Console errors | 0. HTTP 4xx/5xx: 0 |
| 19 | PHP notices / warnings | 0 for this route with `DEV = true` and `E_ALL` |
| 20 | Navigation unchanged | `film-nav.php` untouched; PRIVACY is in `NAV_EXCLUDE`, so the bar names the same seven pages plus the MEMBERSHIP action and cannot point at this page |
| 21 | Footer | `film-footer.php` untouched — lockup, tagline, place, the four `FOOTER_LINKS`, the address, MEMBERS & GUESTS |
| 22 | Mobile menu | Opens, `aria-expanded` flips, scroll locks, the label becomes "Close the menu", Escape closes it and returns focus to the button |
| 23 | Keyboard | 36 stops in document order, **0 without a visible focus ring** |
| 24 | Contrast | **0 failures** at 375 / 390 / 768 / 1024 / 1440 / 1920 — §10 |
| 25 | Hero video | 1280×720, 7.44 s, looping, seam 2.17; the 854-wide encode below 900px; attached after `load`, never in the critical path |
| 26 | Whole document top to bottom | Rendered at 375 (9 137px) and 1440 (7 205px) |
| 27–39 | Main Page, THE ESTATE, THE CLUB, PADEL, EVENTS, RESIDENCES, AFTER DARK, MEMBERSHIP, CONTACT, /terms, 404, styleguide, components | **Byte-identical** — `tools/compare_pages.sh` |

### The scroll offset, measured rather than assumed

`scroll-padding-block-start` was first set at 7rem *and* `scroll-margin-block-start`
at 7rem on the clauses. They add up: with the clause's own 76px of space above
its rule, a heading landed **318px** down a 900px window — a quarter of a screen
of empty paper. One property, at 6rem, lands the rule just under the bar and the
heading at **182px**.

### The active-section band, measured rather than assumed

With a band 15% of the viewport tall, clicking a *short* clause marked the next
one — "What this covers" is 180px tall, so "Who is responsible" was inside the
band too and, being later in document order, took the mark. Measured on two of
the twelve. The band is now 2% tall at a quarter of the way down the window: a
line rather than a region, and all twelve are correct.

---

## 8. Performance

Measured over the local server with the page scrolled to the bottom, so every
lazy image and the hero video are counted.

| | requests | total | video | css | js | fonts | images |
|---|---|---|---|---|---|---|---|
| **/privacy 1440** | **11** | **1 122 KB** | 748 | 187 | 57 | 81 | 49 |
| **/privacy 390** | **11** | **633 KB** | 279 | 187 | 57 | 81 | 29 |
| /contact 1440 | 41 | 1 750 KB | 747 | 228 | 364 | 81 | 329 |

**374 KB before the video**, which is not in the critical path: the `<video>`
ships with no `src`, and `privacy.js` attaches one after the `load` event, only
when the reader has not asked for reduced motion and is not on a metered or 2G
connection. Until then — and forever, for a reader who has — the hero is its
poster, which is frame 0 of the same encode.

### Where the saving is: the motion layer this page does not load

The nine film pages fetch GSAP, ScrollTrigger, Lenis and `home.js` — **364 KB of
JavaScript on /contact** — to drive scroll choreography that a legal document
has none of. `'motion' => false` in `head.php`'s film table keeps all four off
this page, and `privacy.js` does the four things the chrome actually needs in
**11.9 KB**: the compact bar, the navigation sheet, the hero's one video, and
the mark on the clause being read.

**That is also an accessibility fix and not only a saving.** On a film page the
whole script layer sits behind a `prefers-reduced-motion` check, so a reader who
has asked for less motion gets no `home.js` — and below 900px that means a menu
button that does nothing. `privacy.js` is a plain deferred `<script>` that
always runs; the one thing inside it that is motion checks for itself.

### The encode

CRF 27/29 rather than the film pages' 25/28. At 25 the wide encode is 991 KB; at
27 it is 748 KB. Frame for frame the two differ by **1.65 out of 255** on average
and the darkest door panel holds the same 183 distinct luma values in both, so
there is no banding to buy back — the shot is dark, slow and almost static,
which is the case CRF was designed for.

---

## 9. Assets and credits

```
ASSET ACCOUNTING

SOURCE            media_src/heritage-details/heritage_1.jpg        1735 x 906
                  (real photography of the estate)

REFERENCE CROP    media_src/MOTION/privacy/ref-doors.png           1611 x 906
                  16:9, centred, rebuildable by build_privacy_media.py

GENERATED IMAGE   media_src/MOTION/privacy/still-doors.png         2688 x 1520
  SOURCE REF      ref-doors.png
  MODEL           GPT Image 2 · 2K · high · 16:9 · from a reference
  CHANGED         the hour and the light only
  COST            6.5 credits

SEEDANCE HERO     media_src/MOTION/privacy/pri-doors.mp4           1280 x 720
  SOURCE IMAGE    still-doors.png
  START IMAGE     still-doors.png   (start_image, not omni_reference — §3)
  MODEL           Seedance 2.0 · 720p · std · 16:9 · 5 s · generate_audio false
  MOTION          extremely slow level push toward the open leaf; foliage
                  stirring beyond the far windows; the light breathing
  COST            22.5 credits

VIDEO             public_html/assets/video/pri-doors.mp4      748 KB  1280 wide
                  public_html/assets/video/pri-doors-sm.mp4   279 KB   854 wide
POSTER            public_html/assets/img/privacy/pri-doors-1280.jpg   92 KB
                  public_html/assets/img/privacy/pri-doors-1280.webp  39 KB
                  public_html/assets/img/privacy/pri-doors-768.jpg    42 KB
                  public_html/assets/img/privacy/pri-doors-768.webp   19 KB
                  (frame 0 of the encode — the still and the film cannot
                   re-frame against each other when the video fades up)

CREDITS SPENT     29        (683 → 654)
CREDITS LEFT      654
```

`media_src/MOTION/privacy/` holds 8.9 MB: the reference crop, the still, the
master and frame 0. `.gitignore` carries `/media_src/**/*.mp4`, so the master
stays on disk and in the backup and the encodes under `assets/video/` are the
committed deliverable.

---

## 10. Legibility, measured

`tools/measure_contrast.js`, extended with this page's fifteen selectors and run
at six widths. It scrolls with real wheel events, makes the glyphs transparent
rather than hidden so every wash behind them stays where it is, samples the
95th-percentile **brightest** pixel each element's letters cross — which on a
light ground is the paper itself, and is therefore still the worst case for dark
ink — and reports the worst ratio each element reaches anywhere on the page.

| Width | Elements | Failures | Worst on the page |
|---|---|---|---|
| 375 | 23 | **0** | `.c-film-foot__members` 5.13 |
| 390 | 23 | **0** | `.c-film-foot__members` 5.13 |
| 768 | 23 | **0** | `.c-film-foot__members` 5.13 |
| 1024 | 23 | **0** | `.c-film-foot__members` 5.13 |
| 1440 | 23 | **0** | `.c-film-foot__members` 5.13 |
| 1920 | 23 | **0** | `.c-film-foot__members` 5.13 |

The threshold is 4.5:1 for small text and 3:1 for large. The worst element on
the page is the footer's own, unchanged from the nine approved pages; the worst
element this work introduced is the clause number at **5.33:1**, and the body of
the policy measures **15.8:1**.

Every colour on the document is `main.css`'s own primitive, chosen against its
measured ratio rather than by eye:

| | on | ratio |
|---|---|---|
| `--pv-ink` #101511 — the policy | cream | 15.8:1 |
| `--pv-ink-soft` #4A5148 — the date | cream | 7.0:1 |
| `--pv-gold-ink` #7A5C24 — numbers, rules, links | cream | 5.3:1 |
| `--pv-wine` #7B1E2B — the notice's label and edge | the notice | 7.9:1 |
| `--pv-on-green` #F2EDE4 — the current clause | green-900 | 11.8:1 |
| `--pv-on-green-soft` #A9B5AB — an index link at rest | green-900 | 6.5:1 |
| `--pv-gold` #CBA96A — the index numbers | green-900 | 6.2:1 |

> **The document cannot use the film's colour names**, and it is worth knowing
> why before editing `privacy.css`. `home.css` redefines `--ink` to `#F2ECE0`,
> because on a film page ink is cream. `main.css` defines it as `#101511`,
> because everywhere else ink is near-black. `home.css` loads second, so on this
> page `var(--ink)` is **cream** — and cream ink on a cream document is an
> invisible policy. Hence `--pv-*`, declared on `.c-legal`, quoting the
> primitives rather than referencing the ones that are shadowed.

---

## 11. Limitations

**The `.htaccess` still has no compression.** Every number in §8 is uncompressed
bytes over the local PHP server. `public_html/.htaccess` says security headers
and caching "are added in a later step", and they have not been; with `DEFLATE`
on, the 187 KB of CSS and 57 KB of JavaScript on this page would be roughly a
quarter of that. It is a project-wide item and not this page's to close.

**`main.js` is 46 KB of the 57 and it does nothing here.** `head.php` links it
on all eleven routes, and its whole job — the `.c-header` scroll state and the
`nav-mobile` drawer — belongs to chrome that a page with `'own_chrome' => true`
never renders. That is equally true of the nine approved film pages. Dropping it
for `own_chrome` pages is one condition in `head.php` and would need the
snapshot harness run over all of them; it was left alone because this brief is
one page wide.

**The controller's legal details are still a visible TODO.** That is the
approved content and the brief's own instruction, not an oversight — but the
page ships with a gap in the one clause Article 13 says must be complete, and it
is one line of `content/en/privacy.php` to close when the owner supplies the
company name, registration number and registered address.

**/terms is now the only page on the old legal template.** `pages/legal.php` and
the non-standalone half of `components/clause.php` exist for one page, and
`legal-clause.php` duplicates that file's text pipeline. That is the price of
`Modify ONLY /privacy` and it should be paid back the next time /terms is
briefed.

**`con-arrival.mp4` on /contact is not the palindrome its build script says it
is** — see §3. Found by this page's harness, not fixed, because /contact is
approved and outside this brief.

**What the models did on their own, stated rather than hidden.** GPT Image 2
opened the framing very slightly — a little more of the balustrade and of the
left wall are in shot than in the reference — and rendered the plastered wall
cool grey rather than cream, which is the light the prompt asked for rather than
a repaint. Seedance added nothing: frame by frame, every element of the still is
where the still put it.

**The hero video cannot be verified in Playwright's Chromium**, which ships no
H.264 decoder — `canPlayType` returns empty and both /privacy and /contact
report `MEDIA_ERR_SRC_NOT_SUPPORTED`. It was verified in the system Chrome
instead: 1280×720, 7.44 s, playing, looping, `is-playing` set, and the 854-wide
encode selected below 900px.
