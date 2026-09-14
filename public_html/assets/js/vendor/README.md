# Vendored motion libraries

Self-hosted, because this site makes **zero external requests on load** and that
is a hard rule (ARCHITECTURE §8 and the note at the top of
`templates/partials/head.php`). Nothing here is fetched from a CDN, at any
point, on any page.

They are loaded **only on the home page**, and only after first paint — see
`assets/js/home.js` and the block guarded by `current_page() === 'home'` in
`templates/partials/head.php`. The other ten pages do not request a byte of it.

Files are the published UMD minified builds, copied verbatim. They are not
rebuilt, not re-minified and not edited: an edited vendor file is a vendor file
nobody can update.

| File | Version | Raw | Gzipped |
|---|---|---|---|
| `gsap.min.js` | 3.15.0 | 72 927 B | 28 268 B |
| `ScrollTrigger.min.js` | 3.15.0 | 44 575 B | 17 998 B |
| `lenis.min.js` | 1.3.26 | 18 722 B | 5 431 B |
| **total** | | **136 224 B** | **51 697 B** |

Each exposes a global — `gsap`, `ScrollTrigger`, `Lenis` — so they load as
ordinary classic scripts with no bundler and no build step, which is the same
arrangement `main.js` already uses.

## Licences

### GSAP core and ScrollTrigger — 3.15.0

GreenSock standard "no charge" licence: <https://gsap.com/standard-license>
Copyright (c) 2008–2026, GreenSock. All rights reserved.

**Free for commercial use, and that includes ScrollTrigger.** Since Webflow's
sponsorship of GSAP the whole library is covered at no charge, including the
plugins that were formerly Club-GreenSock-only. There is no paid tier to fall
foul of and no per-site or per-developer fee.

The one restriction in the licence is that GSAP may not be used to build a tool
that lets *its own* users author animations without code in a way that competes
with Webflow's visual animation builder. A brochure site for a manor house is
not that, so the restriction does not bite here.

**Only two GSAP files are vendored.** The package ships twenty-five plugins;
this site uses the core and ScrollTrigger and nothing else, so nothing else is
on the server. Every plugin in use is therefore covered, because there are two
of them and both are the same licence.

### Lenis — 1.3.26

MIT, Copyright (c) 2024 darkroom.engineering. Full text in `LICENSE-lenis.txt`,
which is kept beside the file because MIT requires the notice to travel with the
copy.

Free for commercial use with no conditions beyond retaining that notice.
