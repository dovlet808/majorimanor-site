# Brand asset pipeline

Everything in `public_html/assets/img/brand/` and `public_html/favicon.ico` is
generated **except `mark.svg`, which is authored** — see below. Do not hand-edit
the generated files: edit the source art, `mark.svg`, or these two scripts, and
re-run.

## Two marks, and which one goes where

**This is a two-mark identity. Neither drawing is a placeholder for the other.**

| | drawing | where |
| --- | --- | --- |
| **large mark** | the club seal — twenty letters around two rings, four fleur-de-lis, the facade | **48px and above, only** |
| **small mark** | the monogram M in the double circle, `assets/img/brand/mark.svg` | **below 48px** |

The rule is a legibility measurement, not a preference. The crest is a fine-line
engraving with white detail cut into the ink. Below about 48px its two rings
close into one band, the twenty letters become a dotted grey ring and the facade
fills in solid: it stops being a seal and becomes a smudge. The monogram is drawn
at weights that were checked at 16px — outer ring 0.88px, inner ring 0.42px, and
an M whose notch stays open instead of closing into an H. The reasoning is
written out in `mark.svg` itself, and anyone touching those numbers has to
re-render at 16px and confirm the letter is still an M.

Where the split lands:

```
mark    .c-seal--sm (32px)      favicon.ico 16, 32      favicon.svg (a tab is 16–20px)
crest   .c-seal--md, --lg       favicon.ico 48          apple-touch, icon-192/512, maskable
```

`mark.svg` is the one asset here that is **hand-drawn and committed** rather than
generated — it is real vector geometry, and there is nothing to derive it from.
Everything downstream reads it: `build_assets.py` draws the icon layers from its
own shapes, and `main.css` masks it for `.c-seal--sm`. Change it in one place and
both follow.

On the page the mark is a CSS mask over `--seal-ink` rather than a coloured
file, because it is a true vector and can take a colour. That is the same
mechanism `--seal-src` gives the crest — the ground decides, the component does
not know — and it is why the small mark needs one file where the crest needs
three. See §3 and §7 of `main.css`.

## Source

The three supplied JPGs in the project root, each the club seal on a black
ground at 1024×1536:

```
favicon (#1A4438).jpg    green    — the on-page mark for cream grounds
favicon (#7B1E2B).jpg    bordeaux — the third colourway
favicon (#CBA96A).jpg    gold     — dark grounds, and every icon
```

They are the originals and **nothing writes to them**.

## Running it

```bash
python3 -m venv .venv && .venv/bin/pip install numpy pillow
.venv/bin/python tools/brand/fix_caron.py      # -> tools/brand/masters/
.venv/bin/python tools/brand/build_assets.py   # -> public_html/...
```

`fix_caron.py` first, always: `build_assets.py` reads the masters it writes.

## What fix_caron.py is for

**The supplied art has a spelling error and this is where it is corrected.**

The lower arc reads `MAJORI ⚜ MUIŽA`. Over the Z the artwork puts a
near-horizontal bar — rotate the glyph upright and it is a macron. Latvian
*muiža* takes Z-caron. All three files carry the same error, so it is a defect
in the source rather than in one export.

The script erases that bar and draws a caron in its place, matching the ink
colour sampled off the Z beside it, the stroke weight of the letterforms, and
(on the green file, the only one that has them) the white keyline.

It is a retouch, not a redraw, and it is worth knowing its limits:

- The caron is **shallower than it should be**, most of all on the bordeaux
  file. The ring above the diacritic sits 7–13px clear of the bar at a crest
  radius of ~400px, and the rise is clamped so the new mark never crowds that
  ring more than the old one did.
- The three files are separate renders at slightly different scales and
  spacings, so the three carons are not pixel-identical to each other.

**The real fix is upstream.** When the designer next supplies art, ask for a
true caron in the source, and for a vector while you are asking — see
ARCHITECTURE §8.5 for what a vector would buy back.

## What build_assets.py is for

Cutting the seal off its black ground and writing every asset the site needs.

Because the ground is pure black the JPEG is effectively **premultiplied** —
an antialiased edge pixel already holds `ink × coverage`. Coverage comes off
the value channel, `max(R,G,B)` rather than luma, because the brand green is
dark enough that luma reads a solid stroke as half-covered. Every resize then
happens in premultiplied space and un-premultiplies only at the end; resizing
straight RGBA mixes the colour of fully transparent pixels into the edges,
which is what turned the first `favicon.ico` into noise.

Output:

| file | what it is |
| --- | --- |
| `crest-green.png` `crest-wine.png` `crest-gold.png` | 320px, transparent — the on-page crest, one per colourway. 320 covers the largest rendered size (140px) at 2× |
| `favicon.ico` | into the document root. **Mark at 16 and 32, crest at 48** |
| `favicon.svg` | **the mark**, as geometry lifted out of `mark.svg` at build time |
| `apple-touch-icon.png` | 180×180, crest |
| `icon-192.png` `icon-512.png` | PWA, purpose `any`, crest |
| `icon-maskable-512.png` | PWA, purpose `maskable` — crest at 60% for the safe zone |

**Every icon is gold on `--green-800`, opaque** — whichever mark it carries.
Left transparent, either mark is a faint scratch at 16px, and the brand green on
a dark tab strip is invisible. On its own green ground the pair holds at every
size a tab will ask for, matches `theme-color`, and needs no
`prefers-color-scheme` switch.

The `.ico` is where the split is most visible, and Pillow will not do it by
accident: asked for three sizes it resamples one image into all of them, so the
16 and 32 frames are drawn separately and handed over through `append_images`.
The crest is never used below 48.

`favicon.svg` is the mark rather than the crest because a browser draws it in a
tab — 16 to 20 CSS pixels — and an SVG icon has no size at which the rule stops
applying. It is also the one place the mark is given a literal colour instead of
taking a ground's: a favicon has no element to inherit `currentColor` from,
which is why the file is generated rather than authored.

## If a vector crest ever arrives

Delete both scripts and most of this. A single-colour vector goes back to
`currentColor`, `--seal-src` in §3 of `main.css` collapses back to a colour the
way `--seal-ink` already has, and `seal()` can go back to printing inline SVG.
The raster route is here because the crest was supplied as artwork, not because
it is preferable.

**It would not merge the two marks.** A vector crest would still be twenty
letters and a facade, and it would still be illegible at 16px — a vector is not
a simpler drawing, only a sharper one. The small mark stays either way.
