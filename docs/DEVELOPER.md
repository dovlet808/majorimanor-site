> **The maintainer's guide.** This is the project README as it lives in the working copy of the site — the design system, the helpers, the Latvian switch, deployment, and the state of each phase. The portfolio overview is [../README.md](../README.md); one account per page is beside this file.

# Majori Manor — website

Static PHP site for [majorimanor.com](https://majorimanor.com). No frameworks, no
build step, no Composer, no database — it runs as plain files on Fozzy shared
hosting (DirectAdmin, Apache/LiteSpeed + PHP).

English only for now; the architecture is ready for Latvian.

---

## Run it locally

```bash
cd majorimanor
cp private/config.example.php private/config.php   # once; set DEV to true locally
php -S localhost:8000 -t public_html
```

Then open <http://localhost:8000>.

`config.php` is not committed. Without it every request answers `500` with a
plain-text reminder to copy the sample.

Two things behave differently under PHP's built-in server than on the real host:

- `.htaccess` is ignored, so `app/`, `content/` and `templates/` are reachable
  locally. On Apache/LiteSpeed each of those directories denies everything.
- The HTTPS and www→apex redirects never fire locally. The front-controller
  fallback does work: an address that is not a file is served by `index.php`.

---

## Layout

```
majorimanor/
├── private/                 above the webroot — never served
│   ├── config.example.php    committed
│   ├── config.php           NOT committed (.gitignore)
│   └── logs/                PHP error log
└── public_html/             the DirectAdmin webroot
    ├── .htaccess            https, www→apex, no listings, front controller
    ├── index.php            the only entry point
    ├── robots.txt
    ├── app/                 routing and helpers      (Require all denied)
    ├── content/             text, arrays only        (Require all denied)
    ├── templates/           markup, no text          (Require all denied)
    └── assets/              served publicly
        ├── css/main.css     the whole design system, one file
        ├── js/main.js       five behaviours, no library
        ├── js/leaflet/      Leaflet 1.9.4, vendored — see the README beside it
        └── fonts/           self-hosted woff2 — see below
```

### How a request is served

```
GET /the-estate
   → .htaccess: not a file, not a directory      → index.php
   → resolve_request(): segment 0 is not a known non-default language,
     so it is a slug and the language is DEFAULT_LANG ('en')
   → routes.php: 'the-estate' → page id 'estate'
   → $t = content/en/common.php   $c = content/en/estate.php
   → templates/pages/estate.php rendered into a buffer
   → templates/layout.php wraps it
```

An address that matches nothing gets `404` from the same path, with page id
`404`. Nothing bypasses the layout.

### The rules that hold this together

- **`routes.php` is the only place an address is written down.** Templates call
  `url('estate')`; no URL is ever hardcoded. A new page is a line in the routing
  table plus a content file and a template.
- **`templates/` contains no human-readable text.** Every string comes from
  `content/<lang>/` — either through `$c` (page content) or `t()` (interface
  strings in `common.php`). A literal sentence in a template is a bug: it is a
  sentence that cannot be translated.
- **`content/` contains no markup.** Content files `return` an array and nothing
  else.
- **Page ids are `snake_case`** (`after_dark`), **slugs are kebab-case ASCII**
  (`after-dark`, `muiza` — never `muiža`). No trailing slash except the root.

### Helpers

Defined in `app/helpers.php`, available in every template.

| Helper | Does |
|---|---|
| `e($value)` | `htmlspecialchars` with `ENT_QUOTES` and UTF-8. Called on every echo. |
| `url($pageId, $lang = null)` | Address from `routes.php`. `url('estate')` → `/the-estate`, `url('estate', 'lv')` → `/lv/muiza`. |
| `t($key)` | Interface string from `common.php`; dot notation walks the array (`t('nav.estate')`). |
| `is_current($pageId)` | Drives `aria-current="page"` in the navigation. |
| `mood()` | Colour temperature of the page: `day`, `dusk` or `night`; `day` unless the content says otherwise. |
| `jsonld()` | The page's structured data from `$c['jsonld']`, encoded. `@context` and the canonical `url` are added here, so a content file never writes an address. Empty when the page declares none. |

With `DEV = true` a missing key renders as `[[missing: nav.estate]]` so gaps are
visible on the page; with `DEV = false` it renders as nothing.

---

## The design system

One stylesheet, `assets/css/main.css`, in a fixed layer order: `@font-face`,
tokens, colour temperatures, reset, base typography, layout primitives,
components, page overrides, utilities. **31.2 KB gzipped against a 40 KB
budget** — most of the raw file is comment. Anything added from here still has
to buy its place: check with `gzip -c assets/css/main.css | wc -c` before and
after.

**The ceiling was 30 KB until phase 2 and it was raised deliberately.** It was
a self-imposed number rather than a platform limit, and it had been met — 29.7
KB, with about a quarter of a kilobyte left. Three more pages do not fit in 275
bytes, and the work that would have made them fit is the wrong work: squeezing
comments out of a stylesheet whose comments are the reason anybody can change
it, or collapsing components into shorter selectors nobody can read. 40 KB is
the same kind of number as 30 was — chosen, not measured off a device — and it
is still small enough that the stylesheet cannot quietly become the page's
weight. **The JS budget is unchanged at 25 KB.**

Three things about it decide how everything later is written.

**Brand colours are provisional.** They were read off the concept brochure and
the logo files and the designer has not confirmed them. They sit in one
contiguous block at the top of the file so that confirming them is a single
edit and nothing else changes.

**Nothing outside the mood system names a colour.** Each temperature —
`day`, `dusk`, `night`, set on `<body data-mood="…">` — defines six variables
and only six:

| | `--bg` | `--fg` | `--rule` | `--accent` | `--seal-src` | `--seal-ink` |
|---|---|---|---|---|---|---|
| `day` | cream | ink | cream-deep | **gold-ink** | crest-green | green-800 |
| `dusk` | green-800 | cream | green-700 | gold | crest-gold | gold |
| `night` | wine-900 | cream | wine-800 | gold | crest-gold | gold |

Every other rule reads those six, so a component never knows which ground it
is standing on and the same component works on cream and on wine without a
modifier. `.section--day` / `--dusk` / `--night` do the same for one section,
and `.seam` carries the ~120px gradient band between two temperatures — the one
place that has to name two grounds at once, which is why it lives in the mood
layer rather than among the components.

The last two are the club seal, and there are two of them because there are two
marks: `--seal-src` names a file for the crest, which is artwork and cannot
inherit a colour, and `--seal-ink` names a colour for the small monogram, which
is a real vector and can. Crest from 48px up, monogram below — see
`tools/brand/README.md`.

The accent is not the same in all three, and that is deliberate. `--gold` on
cream measures **1.9:1** — it fails WCAG for body text and for large text.
So `--gold` is for large display type, rules, the crest and active states **on
dark grounds only**, where it measures 4.9:1 on green-800 and 6.5:1 on
wine-900. `--gold-ink` (#7A5C24, 5.3:1 on cream) is the only gold allowed for
small text on cream, and it is what `day` takes as its accent.

**Vertical space between blocks comes from `.section` and nowhere else.**
Components carry no outer margin. Space *inside* a block is `.stack`'s, through
the `--stack-space` custom property. This is what stops the usual argument
between a section's padding and a component's margin.

### Fonts

Self-hosted woff2 in `assets/fonts/`, `font-display: swap`. **No Google Fonts
and no CDN** — the client is in the EU and a font request is a third-party
request.

Two files, not eight. Both are variable fonts with a 400–600 weight axis, subset
to Latin + Latin Extended-A, which is what carries the Latvian diacritics
(ā č ē ģ ī ķ ļ ņ š ū ž — "Jūrmala"):

```
playfairdisplay-var-latinext.woff2    inter-var-latinext.woff2
```

One file per family covers every weight the design uses, so there is no
`unicode-range` split to keep in sync and no second request when a page turns
out to contain a diacritic. Both are preloaded in `partials/head.php`, and the
preload href has to match the URL `main.css` asks for character for character
or the browser downloads each file twice.

If a face is ever missing the stacks fall through — display to Georgia, body to
the system UI face — and the site stays legible. `assets/fonts/README.md` has
the `pyftsubset` commands.

### /styleguide

A development page: every colour token as a labelled swatch with its hex, the
type scale as live text, the three temperatures as full-width bands, the seams,
the `.u-eyebrow` treatment, the space ramp, and

```
Jūrmala · Majori Muiža — ĀČĒĢĪĶĻŅŠŪŽ
```

in both font stacks, so Latin Extended-A coverage can be checked by eye rather
than by reading a specification. Worth doing before the fonts are fixed:
Latvian arrives in phase 3 and changing the face on a finished site means
re-setting all of it.

It renders only while `DEV` is true. With `DEV = false` `index.php` drops the
page id before anything loads and `/styleguide` answers a real 404, like any
address that does not exist. Its own styles are inline in the template and
never reach `main.css`.

---

## Latvian

Latvian is **not active**. `LANGS` is `['en']`, so `/lv/anything` returns a real
404 — the language is known but switched off.

The Latvian slugs are already in `routes.php` so they never have to be invented
later. English lives at the root with no `/en/` prefix (`/en/` itself is a 404);
Latvian will live under `/lv/`.

Switching it on, when the time comes:

1. create `content/lv/` with a translation of every file in `content/en/`
2. add `'lv'` to `LANGS` in `private/config.php`
3. add `templates/partials/lang-switcher.php` — the header already has the slot
   and renders it as soon as `LANGS` holds more than one language

No template changes. `head.php` also grows `hreflang` at that point; it emits
none today, which is correct while one language is active.

---

## Deployment

Upload the **contents of `public_html/`** into the domain's `public_html` on
DirectAdmin (zip + extract through File Manager is fastest), and `private/` as a
sibling of it, one level above the webroot:

```
domains/majorimanor.com/
├── private/          ← config.php with DEV = false
└── public_html/      ← contents of public_html/
```

`bootstrap.php` finds `private/` by walking one level up from the webroot, so the
layout above is what it expects. Check that `DEV` is `false` in the uploaded
`private/config.php`, and that `https://majorimanor.com/app/routes.php` answers
403 — if it answers anything else, the `.htaccess` files did not upload.

---

## State of the build

### The Main Page — rebuilt as a cinematic film

**`/` is now a different page from the one described below it**, and it is the
design prototype the rest of the site will be made in the image of. Nine scenes,
near-black throughout, cut entirely from `media_src/` — six of them moving,
because six Seedance 2.5 sequences were generated *from* the photographs that
sit beside them. No still image was generated at any point.

It is a self-contained addition. `main.css` and `main.js` are untouched; the
page carries its own stylesheet, its own motion layer, its own six components
(`templates/components/film-*.php`) and its own navigation and footer, and it
asks for the last of those with one key — `'own_chrome' => true` in its content
file, which is the only change `layout.php` needed. **Every other page renders
byte for byte as it did before**, verified with `tools/snapshot_pages.sh` and
`tools/compare_pages.sh`.

Two build steps rebuild everything it shows:

```bash
tools/motion/build_sequences.sh <dir-of-source-mp4s>   # the seven video encodes
python3 tools/photos/build_home_media.py               # every plate, poster and seal
```

**`docs/MAIN_PAGE.md` is the account of it** — the asset audit, which frame
became which slot and why, the six prompts verbatim, the loading budget, what
was measured and what is deliberately still missing. Read that before changing
anything on `/`.

### The pages cut from it

Two more pages are built in the same language and load the same files.

| Page | Adds | Account |
|---|---|---|
| `/the-estate` | `estate.css`, `estate.js` — six act grounds, the sticky walk, the ledger | `docs/THE_ESTATE.md` |
| `/the-club` | `club.css`, `club.js` — the lateral track, the dialogue | `docs/THE_CLUB.md` |

The two legal pages are built the same way out of a different second layer —
`privacy.css` and `privacy.js`, which are the document rather than the film. See
**The legal pages** below.

`head.php` holds the table of which page loads what, and THE CLUB's row loads
THE ESTATE's two files before its own: `estate.css` is the second layer of the
film — the acts and the walk — rather than one page's stylesheet, and copying
it into a third file is how two pages meant to be the same house begin to drift.

```bash
python3 tools/photos/build_estate_media.py   # THE ESTATE's plates and six encodes
python3 tools/photos/build_club_media.py     # THE CLUB's plates and four encodes
```

Every prompt behind a generated frame is recorded verbatim in the script that
built it. **Every page other than the one being rebuilt renders byte for byte as
it did before**, each time — `tools/compare_pages.sh before after <page>`.

---


Done — the skeleton (routing, layout, header, drawer, footer, 404), the design
system (tokens, colour temperatures, typography, layout primitives), the brand
assets (both marks, icons, favicons), the component library, **the home page**
— hero, eight blocks of immersion, the day timeline, and the three seams
between the temperatures — **The Estate**: the page variant of the hero, the
heritage prose, the facts, the gallery with the lightbox, and one seam into the
closing call — and **Padel & Social Club**, which is the same shape plus one
component of its own.

That component is `plan-padel`: an inline SVG schematic of the complex, drawn
against the owner's plan rather than traced from the project infographic, whose
annotations are in Russian and whose register is a builder's. One user unit is
one metre, so every coordinate in the file reads against the plan. Every string
on it — the labels, the legend, the two the screen reader is given — comes out
of `content/en/padel.php`, which is what lets Latvian arrive without the drawing
being touched. Below 768px the labels are hidden and a numbered `<ol>` under the
drawing carries them instead: 53 metres of plan inside a 360px phone puts a
label at seven pixels, and the discs on the drawing are the key to the list. The
drawing itself never changes, and it holds its own aspect ratio at every width.

The hero is one component with two variants. `full` is the home page's first
screen — full height, two ways in, the scroll cue. `page` opens every internal
page: shorter, a one-sentence lede instead of the actions, no cue, and still
the LCP image. A new page asks for it with `'variant' => 'page'` in its `hero`
block and changes nothing else.

**Phase 1 is complete.** `events`, `contact`, `privacy`, `terms` and the 404 are
built, which leaves every page of the launch set on the site with real English
copy behind it.

**Phase 2 is complete too** — `club`, `residences` and `after-dark` — and every
route in `routes.php` now has a template of its own. Those three are a different
kind of page from the five before them and it is worth knowing why before
editing one.

**They have no facts, and the absence is the design.** Every earlier page opens
its content file with the short list of what the owner has confirmed and checks
every sentence against it. These three have nothing to check against: no room
count, no size, no date, no opening hours, no menu, no drinks list, no price, no
membership terms, no named person or supplier. Not "not yet supplied" — not
settled (ARCHITECTURE §21). So none of them carries a `facts` block, none of
them contains a digit, and where a sentence wanted a specific it was rewritten
shorter instead. The brief's line is that the less information there is the more
interesting the place becomes; on a house that has not opened it also happens to
be the only honest register available. The photographs are meant to carry the
rest, which is what all those hatched boxes are the shape of.

Each content file opens with the list of what it may never acquire without the
owner writing it down. Those lists are the useful part of the file.

**Three things about the three pages that are not obvious.**

`/the-club` answers two chapters of the home page — 02, "Inside the club", and
04, "Dining at the club" — which are two links to one address, because the table
is not a separate place from the house it is laid in. Both land at the top, so
the page argues that in its first block rather than leaving a reader to scroll
for it; the dining block carries the eyebrow the second link used.

The Members' Room block is the `quote` component with a name, a sentence, and
nothing else. There is no list of what is in the room, and there must not be.

`/after-dark` is night from the first pixel to the last: no day section, no dusk
section, no seam anywhere, since a seam is a door between two temperatures and
there is only one. It is the only page on the site that opens in wine. It also
carries the private gaming section (ARCHITECTURE §14.2), behind `ENABLE_GAMING`
and switched off — which means the page as it is published today is the five
blocks it has always been, with nothing in view-source about a sixth. The
section is described at the end of this file.

Two components grew one field each to make those pages, both opt-in, and nothing
that does not ask for them moved:

- **`hero` takes a `mood`** — `dusk` (default) or `night`, no `day`. The hero's
  ground is a colour under a photograph rather than the page's temperature, and
  dusk is right for every page but one: a green band across the top of
  `/after-dark` would be the one lighter thing on it. `.c-hero.section--night`
  in §7 takes the scrim to wine with it. `day` is refused — the scrim would be a
  wash of cream over a picture, and the words would go with it.
- **`quote` takes an `eyebrow`** — a subject above the line, not a speaker.
  An attribution says who said it and belongs in a `<figcaption>`; THE MEMBERS'
  ROOM is what the line is about. The two are not interchangeable and the
  component says so.

**The forms.** Both of them work, and they are one implementation:
`form_fields()` in `app/forms/validate.php` is the schema, the `form.<type>`
block in `content/en/common.php` is the words, `templates/partials/form.php` is
the markup, and the two components — `form-membership` and `form-enquiry` — are
four lines each over it. A third form would be a schema, a block of strings, a
component and two mail builders, and no change to the handler.

The enquiry form carries a subject chosen from five, and the notification's
subject line carries it too — `Enquiry — Private event — {Name}` — so one
mailbox sorts itself. The calls at the foot of `/events` and `/residences` link
to `/contact?subject=private-event` and `/contact?subject=residences`, which the
component reads, checks against its own option list and preselects; the field is
never hidden, so the sender can change it. A content file can fix the subject
instead with `'subject_default'`.

Residences was already one of the five, in `validate.php` and in `common.php`,
before the page existed — the schema was written for the three pages it would
appear on. So `/residences` needed the link and nothing else, and
`Enquiry — Residences — {Name}` reaches the mailbox today.

**Rate limiting is two counters, not one** (`app/forms/rate_limit.php`): five
*accepted* submissions per address per hour, and twenty POSTs of any kind. A
real applicant who trips five validation errors still gets through on the sixth
attempt; something posting rubbish still meets a wall at twenty.

**The map** is `templates/components/map.php` with Leaflet 1.9.4 vendored into
`assets/js/leaflet/` — no CDN, ever. It is not fetched until the reader reaches
it: an IntersectionObserver in `main.js` boots it, and until then (and forever,
without JavaScript) the frame holds the address, a `geo:` link that opens in
whatever the device uses for maps, and the coordinates as copyable text. CARTO's
tiles are **the only third-party request this site ever makes**, from one page,
after a scroll — which is what lets `/privacy` say so in as many words.

**Its attribution is under the frame rather than inside it, and it is intact.**
OpenStreetMap's data is ODbL and CARTO's terms require their credit: neither may
be removed and neither has been. What was removed is the plate Leaflet puts them
on in the corner of the canvas, which is the one thing that makes a map read as
somebody else's software sitting in a page. `main.js` builds with
`attributionControl: false` and `map.php` prints `CARTO · OpenStreetMap` in the
thin line under the frame that already carries the coordinates — smaller than
the body text, in the page's own ink, on no plate of its own, pushed to the end
of the line so the hand-off link and the coordinates are what the eye lands on.
The stylesheet reveals it on `[data-map-ready]`, so the credit appears exactly
when the tiles do and never while the frame is still a printed address with
nothing to credit. Leaflet's own prefix went with the control — that one is the
library crediting itself and is not a licence condition.

The frame's hairline reads the page's `--rule` now, through `--map-rule` on
`.c-map`. It used to read its own: `data-ground="deep"` sits on the frame, so
the border was resolving to the footer's green-700 and disappearing into the
basemap. It is the same 1px square-cornered rule the image components carry.

**The legal pages.** Both are now editorial documents in the film's system, and
neither of them changed a word to get there.

`/privacy` was rebuilt on 8 September 2026 with its own template, its own clause
component and its own stylesheet — a clamped cinematic hero, a warm cream reading
surface and a numbered contents index. `/terms` followed on 10 September and was
rebuilt from it: it takes `privacy.css` and `privacy.js` as the **legal layer**,
exactly as seven film pages take `estate.css` as the act layer, and adds
`terms.css` for the four things that file has never had to draw — this page's
hero clamp and scrim, the two chapter breaks the brief for /privacy forbade and
the brief for this one asks for, and the impressum's four gaps set as one
schedule rather than four boxes. `templates/pages/legal.php`, the frame both
pages used to share, has gone: nothing reached it any more.

**Not one word of either document changed.** The whole diff of each content file
is `'mood'`, plus presentation keys; both `sections` arrays are byte-identical to
the approved ones, verified by diff and again by comparing the rendered text
string by string, in order. See `docs/PRIVACY.md` and `docs/TERMS.md`.

Both pages still describe what this site actually does,
checked line by line against the code; the gaps the owner has not filled — the
company's legal name, registration number, registered address, and the
governing law that follows from them — are printed as visible `TODO` blocks on
`/terms` and on `/privacy`, because a plausible registration number is a false
statement about a legal entity.

Not done yet, in order: the rest of the SEO layer (Open Graph and the sitemap —
per-page JSON-LD is in, see `jsonld()`), the final `.htaccess` with security
headers and caching, and then phase 3 (Latvian, cinematic video, padel booking).
The private gaming section of §14.2 is built and off; what is left on it is the
owner's — the copy they want, the photograph or the visualisation, and the
decision to publish, which is a legal one.

Three of the new pages carry no JSON-LD and that is a decision, not a gap.
ARCHITECTURE §13 assigns a type to every page with something a crawler can
describe and assigns none to these; the types that would fit — an Organization
with hours, a Restaurant, a LodgingBusiness — all describe a business that is
running, which is the "unbuilt service marked up as running" §13 forbids in as
many words. `/the-estate` and `/contact` already carry the place itself.

`templates/pages/_placeholder.php` is **gone**, along with the fallback in
`index.php` that reached for it and the one string in `common.php` it printed.
Every route has its own template, so there was nothing left for it to stand in
for. A page id with no template now takes the ordinary 404 path — the same
status and the same page as any address that leads nowhere — and says so in
`DEV`, where it means a file was not saved rather than a page was not written.

`assets/js/main.js` does five things and the page is complete without all five:
the header's ground, the mobile drawer, the gallery lightbox, the forms' inline
validation, and the map. No library, deferred, about 12.2 KB gzipped against a
25 KB budget. With JavaScript off the header is solid everywhere, the full
navigation stays on screen, both forms post and answer at their own address, the
map is the address it stands in for, and every link works.

Six notes on what is deliberately provisional:

- **The legal pages have visible `TODO` blocks and they are meant to be seen.**
  Four on `/terms`, one on `/privacy`. They come from `'todo'` in the content
  files; deleting the key removes the block.
- **The pin on the contact map is OpenStreetMap's.** Forward and reverse
  geocoding agree that 56.9653, 23.8125 is `66, Konkordijas iela, Majori,
  Jūrmala` and OSM tags it `historic=manor`, but what a pin should mark on 2.4
  hectares is the gate a car arrives at. The two numbers are in
  `content/en/contact.php` and nowhere else.

- **Brand colours await the designer.** See the design system section above.
- **There is no booking system, and which one it will be is undecided.** BOOK
  PADEL goes to Contact, where an enquiry is answered by a person. The slot a
  widget lands in is commented into `templates/components/cta.php`, on the one
  component that already owns the site's single conversion path — with the three
  rules it will have to keep, which are the site's usual ones: no third-party
  script in the markup, no English inside a template, and nothing marked up in
  JSON-LD as running because a widget can be seen on the page.
- **There is no photography.** Every `img()` call renders a hatched box of
  exactly the shape the picture will take, with the filename printed in it while
  `DEV` is on. Dropping the files into `assets/img/<page>/` is the whole of the
  change: the boxes hold the ratio, so nothing on the page moves — measured at
  CLS 0 with the files arriving late on a throttled connection.
- **The private gaming section on `/after-dark` is behind `ENABLE_GAMING`**, and
  the flag is `false` in both configs and `false` in production. See below.

---

## The private gaming section

`/after-dark` carries one section that does not render. It is the deferred
module of ARCHITECTURE §14.2, built early so that the layout can be reviewed,
and it is switched off:

```php
define('ENABLE_GAMING', false);   // private/config.php and config.example.php
```

**`false` is the default and it is the production value.** The gate is in
`content/en/after_dark.php`, where the two blocks are appended to the sections
array only when the flag is true — not in a template and not in CSS. So with
the flag off there is no markup, no comment, no empty container and nothing in
view-source: the section does not exist rather than being hidden, and the page
is byte-for-byte what it was before this was written.

**It has no route, no navigation entry and no inbound link from anywhere.** It
is one section on one page, which is what §14.2 asks for — inside the evening,
not in the main navigation.

Two blocks, and the second is the reason the first is allowed to exist:

- a `split` mirroring Cigar & Whisky — that one has its image left, this one
  has its image right — describing the room and not the activity. What it may
  never acquire is listed at the top of the content file and the list is long.
- the licensing line, in a `clause` with `'standalone' => true`. The wording is
  the owner's and is fixed; it is set in the fine-print treatment the legal
  pages use, which is `--fs-sm` under a hairline at 0.7 — the same treatment,
  and within a hundredth of the same contrast, as `.p-legal__updated`.

`after-dark/gaming-salon` is declared `'mood'`, because it is a reference
image. It becomes `'photo'` or `'render'` the day the owner supplies a
photograph or a visualisation of the actual room, and not before: §11 does not
bend for this section either.
