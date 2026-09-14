# Majori Manor — website

The website of [Majori Manor](https://majorimanor.com), a 1910 manor house in Jūrmala, Latvia, being restored as a private members' club. Eleven pages cut as one cinematic scroll, two working forms, a contact map — and exactly one third-party request on the whole site.

Plain PHP on shared hosting. No framework, no build step, no Composer, no database, no CDN, no analytics. Published with the owner's permission — see [Licence](#licence).

🇷🇺 [Русская версия](README.ru.md) · 📐 [Developer guide](docs/DEVELOPER.md) · 📝 [Per-page design notes](docs/)

---

## Screenshots

| | |
|---|---|
| ![Home — hero](docs/screenshots/home-hero.jpg) | ![Home — scene 05, the cigar room](docs/screenshots/home-scene.jpg) |
| ![The Estate — the stained glass](docs/screenshots/estate-walk.jpg) | ![Padel — the social zone](docs/screenshots/padel-plan.jpg) |
| ![Contact — the enquiry form](docs/screenshots/enquiry-form.jpg) | ![Home on a phone](docs/screenshots/mobile-home.jpg) |

Live: **[majorimanor.com](https://majorimanor.com)**

---

## What is in it

| Part | How it is built |
|---|---|
| **Routing and i18n** | `routes.php` is the only file an address is written in. Templates carry no text, content files carry no markup, so a second language is a folder of arrays, not a rewrite. English lives at the root; the Latvian slugs are already reserved under `/lv/`. |
| **Design system** | One stylesheet in a fixed layer order: tokens → three colour temperatures (`day` / `dusk` / `night`) → components. Every component reads six variables and never names a colour. **31 KB gzipped against a 40 KB budget.** |
| **Cinematic pages** | Nine scroll-driven scenes on `/`, near-black throughout, with **51 short H.264 loops and ~700 WebP/JPEG renditions of the plates**. Each inner page adds one CSS and one JS layer on top of the film; GSAP + ScrollTrigger + Lenis, vendored. |
| **Forms** | Membership application and enquiry over one implementation: HMAC-signed time-trap token, honeypot, a two-counter rate limiter (5 accepted / 20 total per address per hour), PHPMailer over SMTP, HTML + plain-text letters. Both work with JavaScript off. |
| **Privacy by construction** | Self-hosted variable fonts subset to Latin Extended-A, Leaflet vendored, the map booted by an IntersectionObserver. CARTO's tiles are the only third-party request the site makes — from one page, after a scroll — which is what lets `/privacy` say so. |
| **SEO** | Per-page JSON-LD, canonical and Open Graph tags, generated sitemap, `.htaccess` with HTTPS and www→apex redirects, denied `app/` `content/` `templates/`, front controller. |
| **Media pipeline** | One Python + Pillow + ffmpeg script per page turns the client's concept renders and generated footage into every plate, poster and loop the site serves. Every prompt behind a generated frame is recorded verbatim in the script that built it. |
| **Regression check** | `snapshot_pages.sh` renders every route to disk; `compare_pages.sh` diffs two snapshots byte for byte. A change to one page proves it moved nothing on the other ten. |
| **Release** | `build_release.sh` stages the tree, rewrites the production config (DEV off, a fresh `FORM_SECRET`, SMTP carried over untouched), rebuilds the sitemap against the apex and zips it for DirectAdmin's file manager. |

---

## Stack and skills

| Area | Used |
|---|---|
| **Backend** | PHP 8 (`strict_types`, no framework), front controller, PHPMailer 6.9, Apache/LiteSpeed `.htaccess` |
| **Frontend** | HTML5, CSS custom properties and design tokens, vanilla JavaScript (ES2020, `IntersectionObserver`, no jQuery), GSAP 3.15 + ScrollTrigger, Lenis, Leaflet 1.9.4 |
| **Media** | Python 3.12, Pillow, NumPy, ffmpeg (H.264 loops, poster frames), responsive WebP/JPEG sets, `pyftsubset` font subsetting, generative footage and stills (Seedance 2.5, GPT Image) from the client's renders |
| **Tooling** | Bash, Node + puppeteer-core (contrast measurement with real wheel events), Chrome/Playwright review captures, git |
| **Ops** | DirectAdmin shared hosting, DNS, SSL, mailboxes and SMTP, staging vs production configs, release packaging |
| **Quality** | WCAG contrast measured rather than eyeballed, byte-identity regression, gzip budgets per file, CLS 0 verified on a throttled connection, every page usable with JavaScript off |

By the numbers: **~46 000 lines** — 3.9 k PHP application, 7.6 k templates, 8.5 k content, 11.7 k CSS, 3.9 k JS, 10 k tooling — 38 components, 14 page templates, 11 public pages.

---

## How a request is served

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

An address that matches nothing gets `404` from the same path. Nothing bypasses the layout.

The three rules that hold it together:

- **`routes.php` is the only place an address is written down.** Templates call `url('estate')`; no URL is ever hardcoded.
- **`templates/` contains no human-readable text.** Every string comes from `content/<lang>/` — a literal sentence in a template is a sentence that cannot be translated.
- **`content/` contains no markup.** Content files `return` an array and nothing else.

---

## Run it locally

```bash
git clone git@github.com:dovlet808/majorimanor-site.git
cd majorimanor-site
cp private/config.example.php private/config.php   # set DEV to true
php -S localhost:8000 -t public_html
```

Then open <http://localhost:8000>. PHP 8 is the only requirement; there is nothing to install.

Without `config.php` every request answers `500` with a plain-text reminder to copy the sample. Under PHP's built-in server `.htaccess` is ignored, so the HTTPS and www→apex redirects never fire and `app/`, `content/`, `templates/` are reachable — on Apache/LiteSpeed each of those directories denies everything.

With `DEV = true` two extra pages exist: `/styleguide` (every token, the type scale, the three temperatures, Latin Extended-A coverage) and `/components`. In production `index.php` drops them before anything loads and they answer a real 404.

---

## Project layout

```
majorimanor-site/
├── private/                    above the webroot — never served
│   ├── config.example.php       committed; the only file with settings in it
│   └── logs/                    PHP error log, form log, rate-limit state
├── public_html/                the DirectAdmin webroot
│   ├── .htaccess                https, www→apex, no listings, front controller
│   ├── index.php                the only entry point
│   ├── app/                     bootstrap, routing, helpers, forms/, vendor/PHPMailer
│   ├── content/en/              one array per page — text and nothing else
│   ├── templates/               layout, partials, 14 pages, 38 components — markup, no text
│   └── assets/
│       ├── css/                 main.css (the design system) + one file per film page
│       ├── js/                  main.js + one file per page; vendor/ (GSAP, Lenis), leaflet/
│       ├── fonts/               two variable woff2, self-hosted
│       ├── img/                 responsive plates, posters, brand
│       └── video/               51 H.264 loops
├── tools/
│   ├── photos/                  build_<page>_media.py — the media pipeline, one per page
│   ├── motion/                  build_sequences.sh — the video encodes
│   ├── brand/                   crest and monogram assets, caron fix
│   ├── snapshot_pages.sh        render every route to disk
│   ├── compare_pages.sh         byte-for-byte diff of two snapshots
│   ├── measure_contrast.js      worst contrast ratio of every text element, per page
│   ├── build_sitemap.php        + verify_sitemap.php
│   └── mail_preview.php         render both letters without sending them
├── deploy/
│   ├── build_release.sh         the production zip, one command
│   └── build_release_parts.sh   the same split into parts for the file manager's upload limit
└── docs/
    ├── DEVELOPER.md             the maintainer's guide: design system, helpers, Latvian, deployment
    ├── MAIN_PAGE.md             the account of the home page — asset audit, prompts, budget
    ├── THE_ESTATE.md … TERMS.md one account per page: what was decided and why
    └── ASSET_MANIFEST.md        every visual slot and what fills it
```

Not in the repository: the source masters under `media_src/` (the client's concept renders, camera originals and logo files — some 600 MB), the built release zips, and the real `config.php`. See `.gitignore`.

---

## How it was built

Solo project, August–September 2026, from a Russian-language brief and a concept brochure to a live site. I owned the whole of it: the brief with the owner, the architecture, the design system, the eleven pages and the two forms, the media pipeline, the hosting, DNS and mail on the client's DirectAdmin account, review in the browser at every step (desktop and phone), and every release. Every judgement call that mattered — what the site may and may not claim about an unopened house, why the map's attribution moved, why a 30 KB stylesheet budget became 40 — is written down in `docs/`.

---

## Security notes

- `private/` sits **beside** the webroot, not inside it; `bootstrap.php` finds it by walking one level up. The mail password never sits under a directory Apache serves.
- `private/config.php` is ignored by git and rewritten by `build_release.sh` for production, which carries SMTP settings over without echoing or storing them anywhere else.
- Every echo goes through `e()` (`htmlspecialchars`, `ENT_QUOTES`, UTF-8).
- Forms: time-trap token signed with HMAC-SHA-256 under `FORM_SECRET`, honeypot, per-address rate limiting keyed by a truncated HMAC of the address rather than the address itself, mail headers assembled by PHPMailer, so a newline in a name field cannot become a header.
- `app/`, `content/` and `templates/` each carry a `.htaccess` that denies everything; the check after a deploy is that `/app/routes.php` answers 403.
- No third-party script anywhere in the markup; the one external request (map tiles) is made only when the reader scrolls to the map.

---

## Licence

© Majori Manor. The source is published with the owner's permission so the work can be reviewed; it is **not** licensed for reuse. The code, the texts, the brand assets, the images and the video remain the property of the client.

Vendored libraries keep their own licences: GSAP (standard "no charge" licence), Lenis (MIT), Leaflet (BSD-2-Clause), PHPMailer (LGPL-2.1).
