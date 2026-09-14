# assets/fonts/

Self-hosted woff2 only. Nothing here is fetched from a third party — the client
is in the EU and a Google Fonts request is a request to Google.

Two files, and they are both here:

```
playfairdisplay-var-latinext.woff2   display face — Playfair Display
inter-var-latinext.woff2             body face    — Inter
```

Both are **variable** fonts with a weight axis of **400–600**, subset to
**Latin + Latin Extended-A**. `assets/css/main.css` declares one `@font-face`
per family with `font-weight: 400 600`, and
`templates/partials/head.php` preloads both.

One file per family, not one per weight and subset. Everything the design uses
— 400 for body copy, 500 for headings and the eyebrow — is one axis position in
one request, so there is no `unicode-range` split to keep in sync and no second
request the first time a page turns out to contain a diacritic.

Latin Extended-A is where the Latvian diacritics live — `ā č ē ģ ī ķ ļ ņ š ū ž`
— and Latvian arrives in phase 3, so the coverage has to be right now rather
than after the site is set. Check it by rendering, not by reading a
specification: `/styleguide` prints the line
`Jūrmala · Majori Muiža — ĀČĒĢĪĶĻŅŠŪŽ` in both stacks.

If a file is ever missing the `src` fails, the family stays undefined, and the
stacks in `main.css` fall through to Prata / Georgia and the system UI face.
The site stays readable; it just stops being the brand.

## Replacing them

Same filenames, and nothing else changes. Different filenames means editing
both the `@font-face` `src` in `main.css` and the preload list in `head.php` —
the preload URL and the `src` URL have to match character for character or the
browser downloads the file twice.

## Subsetting

Both families are SIL Open Font License 1.1, so self-hosting is permitted.
Take the variable original and subset it, keeping the weight axis:

```bash
pip install fonttools brotli

pyftsubset PlayfairDisplay[wght].ttf \
  --output-file=playfairdisplay-var-latinext.woff2 \
  --flavor=woff2 --layout-features='*' \
  --variations --instance-features='*' \
  --unicodes="U+0000-00FF,U+0100-017F,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+2000-206F,U+2074,U+20AC,U+2122,U+2212,U+FEFF,U+FFFD"
```

`U+0100-017F` is Latin Extended-A. If the range changes here it changes for
both families, or the two faces disagree about which characters they can set.
