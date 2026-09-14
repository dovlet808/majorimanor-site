"""
Build every brand asset from the caron-corrected masters.

The masters are the supplied art on a pure black ground. Because the ground is
black the JPEG is effectively PREMULTIPLIED: an antialiased edge pixel already
holds ink*coverage. So coverage comes off the value channel -- max(R,G,B), not
luma, because the brand green is dark enough that luma reads a solid stroke as
half-covered.

EVERY RESIZE HAPPENS IN PREMULTIPLIED SPACE and un-premultiplies only at the
end. Resizing straight RGBA mixes the colour of fully transparent pixels into
the edges, which is what turned the first favicon.ico into noise.

Icons are the gold seal on the brand green, opaque, at every size. The seal is
a fine-line mark: transparent on a tab strip it would be a faint smudge at
16px, and dark green on a dark strip is invisible. On its own green ground it
holds together, and it matches theme-color and the manifest.

Crests for the page keep their transparency -- those sit on the site's own
grounds and are large enough to read.

TWO MARKS, AND THE ICON SIZES ARE SPLIT BETWEEN THEM. The crest is legible from
48px up. Below that its rings close and its facade fills in, so the 16 and 32
layers of favicon.ico are the SMALL MARK -- the monogram from
public_html/assets/img/brand/mark.svg -- drawn here from that file's own
geometry rather than from numbers copied out of it. 48 and up stay the crest.
See README.md; this is an identity with two drawings, not a drawing and a
placeholder.
"""
import os
import re
import xml.dom.minidom
import numpy as np
from PIL import Image

HERE = os.path.dirname(os.path.abspath(__file__))
ROOT = os.path.dirname(os.path.dirname(HERE))      # tools/brand -> project root
MASTERS = os.path.join(HERE, 'masters')            # written by fix_caron.py
PUBLIC = os.path.join(ROOT, 'public_html')
OUT = os.path.join(PUBLIC, 'assets', 'img', 'brand')
os.makedirs(OUT, exist_ok=True)

GREEN_800 = (0x1A, 0x44, 0x38)
GOLD = (0xCB, 0xA9, 0x6A)
LO, HI = 5.0, 30.0          # coverage knee, in 0-255 value units

MARK_SVG = os.path.join(PUBLIC, 'assets', 'img', 'brand', 'mark.svg')
MARK_COV = 0.90             # how much of an icon the small mark fills


def cut_out(name):
    """Master -> (premultiplied RGB, alpha), cropped square on the crest."""
    img = np.asarray(Image.open(os.path.join(MASTERS, f'crest-{name}.png'))
                     .convert('RGB')).astype(np.float32)
    V = img.max(2)
    a = np.clip((V - LO) / (HI - LO), 0.0, 1.0)

    # Below the knee the source still holds a little JPEG haze; scale the
    # colour down with the coverage so the pair stays a true premultiplied one.
    pm = img * np.minimum(1.0, np.where(V > 0, a * 255.0 / np.maximum(V, 1e-6), 1.0))[..., None]

    ys, xs = np.nonzero(a > 0.35)
    cx, cy = (xs.min() + xs.max()) / 2.0, (ys.min() + ys.max()) / 2.0
    R = ((xs.max() - xs.min()) + (ys.max() - ys.min())) / 4.0
    half = R * 1.03
    x0, y0 = int(round(cx - half)), int(round(cy - half))
    x1, y1 = int(round(cx + half)), int(round(cy + half))
    return pm[y0:y1, x0:x1], a[y0:y1, x0:x1]


def scale(pm, a, px):
    """Resize in premultiplied space. Returns (pm, alpha) float arrays."""
    pi = Image.fromarray(np.clip(pm, 0, 255).astype(np.uint8)).resize((px, px), Image.LANCZOS)
    ai = Image.fromarray((a * 255.0).astype(np.uint8)).resize((px, px), Image.LANCZOS)
    return np.asarray(pi).astype(np.float32), np.asarray(ai).astype(np.float32) / 255.0


def to_rgba(pm, a):
    rgb = np.where(a[..., None] > 0.004, pm / np.maximum(a[..., None], 0.004), 0.0)
    return Image.fromarray(
        np.dstack([np.clip(rgb, 0, 255), a * 255.0]).astype(np.uint8), 'RGBA')


def over(pm, a, ground):
    """Composite premultiplied art onto an opaque ground."""
    g = np.array(ground, np.float32)
    return Image.fromarray(
        np.clip(pm + g * (1.0 - a[..., None]), 0, 255).astype(np.uint8), 'RGB')


def tile(crest, px, ground, coverage):
    """Opaque icon: the seal centred on a solid ground."""
    pm, a = crest
    inner = max(1, int(round(px * coverage)))
    spm, sa = scale(pm, a, inner)
    canvas_pm = np.zeros((px, px, 3), np.float32)
    canvas_a = np.zeros((px, px), np.float32)
    o = (px - inner) // 2
    canvas_pm[o:o + inner, o:o + inner] = spm
    canvas_a[o:o + inner, o:o + inner] = sa
    return over(canvas_pm, canvas_a, ground)


def check_svg(path):
    """
    Parse an SVG as XML and raise if it is not well formed.

    THIS IS NOT A FORMALITY. An SVG with a broken comment does not warn and does
    not fall back: the browser drops the whole document, the mask has nothing to
    cut, and the mark is simply absent from the page with no error anywhere to
    say why. It happened once, to mark.svg, over a double hyphen inside a
    comment -- which is illegal in XML and is exactly what a CSS custom property
    name starts with. So mark.svg is checked on the way in and every SVG written
    out is checked on the way out.
    """
    xml.dom.minidom.parse(path)

    return path


def mark_geometry(path=MARK_SVG):
    """
    The small mark, read off mark.svg rather than copied out of it.

    Three shapes and two numbers each, which is the whole drawing: two circles
    and an open polyline, all of them strokes. Reading them keeps ONE source of
    truth -- edit the SVG and the icons follow on the next build. Anything the
    file grows that is not one of those three raises rather than being silently
    dropped, because an icon quietly missing a shape looks like a rendering bug
    and not like a parser that gave up.

    Returns (circles, polyline, widths) in viewBox units:
        circles   [(cx, cy, r, stroke_width), ...]
        polyline  [(x, y), ...] -- round caps and joins
        widths    the polyline's stroke width
    """
    src = re.sub(r'<!--.*?-->', '', open(check_svg(path), encoding='utf-8').read(), flags=re.S)

    def attr(tag, name, cast=float):
        m = re.search(r'%s\s*=\s*"([^"]*)"' % name, tag)
        if m is None:
            raise ValueError('mark.svg: <%s> has no %s' % (tag.split()[0], name))
        return cast(m.group(1))

    circles = [(attr(t, 'cx'), attr(t, 'cy'), attr(t, 'r'), attr(t, 'stroke-width'))
               for t in re.findall(r'<circle\b[^>]*>', src)]

    paths = re.findall(r'<path\b[^>]*>', src)
    if len(circles) != 2 or len(paths) != 1:
        raise ValueError('mark.svg: expected two <circle> and one <path>, got %d and %d'
                         % (len(circles), len(paths)))

    unknown = set(re.findall(r'<(\w+)', src)) - {'svg', 'circle', 'path'}
    if unknown:
        raise ValueError('mark.svg: unhandled element(s) %s -- teach this parser or '
                         'the icons will be drawn without them' % sorted(unknown))

    # M/L/V absolute only, which is all the mark uses. A curve would need a
    # flattener and would change the distance field below, so it raises.
    d = attr(paths[0], 'd', str)
    tokens = re.findall(r'[A-Za-z]|-?\d*\.?\d+', d)
    points, i = [], 0
    while i < len(tokens):
        cmd = tokens[i]
        if cmd in ('M', 'L'):
            points.append((float(tokens[i + 1]), float(tokens[i + 2])))
            i += 3
        elif cmd == 'V':
            points.append((points[-1][0], float(tokens[i + 1])))
            i += 2
        else:
            raise ValueError("mark.svg: path command '%s' is not handled here" % cmd)

    return circles, points, attr(paths[0], 'stroke-width')


def draw_mark(px, ground=GREEN_800, ink=GOLD, coverage=MARK_COV):
    """
    The small mark at `px` square: the ink on an opaque ground.

    Drawn as a distance field rather than with a drawing library, because that
    is what gives clean coverage at 16px: every shape in the mark is a stroke,
    a stroke is "within half a stroke-width of a line", and the distance to
    that line is exactly what antialiasing wants. One device pixel is one unit
    of the ramp, so an edge lands on the right fraction of a pixel instead of
    on a resampled guess.
    """
    circles, points, stroke = mark_geometry()

    inner = px * coverage
    offset = (px - inner) / 2.0

    # Pixel centres, in viewBox units.
    c = ((np.arange(px) + 0.5) - offset) / inner * 100.0
    x, y = np.meshgrid(c, c)

    d = np.full((px, px), 1e9)

    for cx, cy, r, w in circles:
        np.minimum(d, np.abs(np.hypot(x - cx, y - cy) - r) - w / 2.0, out=d)

    for (ax, ay), (bx, by) in zip(points, points[1:]):
        vx, vy = bx - ax, by - ay
        t = np.clip(((x - ax) * vx + (y - ay) * vy) / (vx * vx + vy * vy), 0.0, 1.0)
        np.minimum(d, np.hypot(x - ax - t * vx, y - ay - t * vy) - stroke / 2.0, out=d)

    unit = 100.0 / inner                       # one device pixel, in viewBox units
    a = np.clip(0.5 - d / unit, 0.0, 1.0)[..., None]

    rgb = np.array(ink, np.float32) * a + np.array(ground, np.float32) * (1.0 - a)

    return Image.fromarray(np.clip(rgb, 0, 255).astype(np.uint8), 'RGB')


def save_png(im, path, colors=None):
    if colors:
        im = im.quantize(colors=colors, method=Image.FASTOCTREE)
    im.save(path, optimize=True)
    return os.path.getsize(path)


crests = {n: cut_out(n) for n in ('green', 'wine', 'gold')}
for n, (pm, a) in crests.items():
    print(f'{n:6s} cut-out {pm.shape[1]}x{pm.shape[0]}')

# ---- the on-page crest, one per colourway, transparent -------------------
# 320px covers the largest rendered size (140px) at 2x.
for n, (pm, a) in crests.items():
    p = os.path.join(OUT, f'crest-{n}.png')
    print('crest-%-5s %7d bytes' % (n, save_png(to_rgba(*scale(pm, a, 320)), p, 128)))

# ---- icons: gold on brand green, opaque, every size ----------------------
for fn, px, cov, cols in (('apple-touch-icon.png', 180, 0.84, 128),
                          ('icon-192.png', 192, 0.84, 128),
                          ('icon-512.png', 512, 0.84, 192),
                          ('icon-maskable-512.png', 512, 0.60, 192)):
    p = os.path.join(OUT, fn)
    print('%-21s %7d bytes' % (fn, save_png(tile(crests['gold'], px, GREEN_800, cov), p, cols)))

# ---- favicon.ico: the small mark at 16 and 32, the crest at 48 ------------
# Pillow builds every size it is asked for by resampling the base image, unless
# a frame of exactly that size is handed to it -- so the two mark layers are
# passed in and the crest is only ever used at 48, which is the first size it
# survives. Sizes checked at 100% on a light and a dark tab strip.
ico_path = os.path.join(PUBLIC, 'favicon.ico')      # the document root, not brand/
tile(crests['gold'], 48, GREEN_800, 0.88).save(
    ico_path, sizes=[(16, 16), (32, 32), (48, 48)],
    append_images=[draw_mark(16), draw_mark(32)])
print('%-21s %7d bytes  (mark 16, mark 32, crest 48)'
      % ('favicon.ico', os.path.getsize(ico_path)))

# ---- favicon.svg ---------------------------------------------------------
#
# THE SMALL MARK, AS ACTUAL GEOMETRY. This is the icon every current browser
# uses, and it uses it in a tab -- 16 to 20 CSS pixels. That is squarely inside
# the range the crest cannot survive, so this file follows the same rule as the
# 16 and 32 layers of the .ico rather than the 48 one, and the whole point of
# an SVG favicon is that there is no size at which it stops applying.
#
# It was a base64 PNG of the crest in a wrapper, because the crest is artwork
# and there was no geometry to write out. The mark is a real vector, so there
# is: the shapes below are mark.svg's own, lifted verbatim and given the gold
# outright. currentColor cannot be used here -- a favicon has no element to
# inherit from -- which is exactly why this file is generated and not authored.
shape_src = re.sub(r'<!--.*?-->', '', open(MARK_SVG, encoding='utf-8').read(), flags=re.S)
shapes = re.findall(r'<(?:circle|path)\b[^>]*>', shape_src)

if len(shapes) != 3:
    raise ValueError('favicon.svg: expected three shapes in mark.svg, found %d' % len(shapes))

gold_hex = '#%02X%02X%02X' % GOLD
inset = 96 * (1 - MARK_COV) / 2.0

svg = '''<!--
  THE SVG FAVICON. Generated by tools/brand/build_assets.py. Do not edit.

  THE SMALL MARK, not the crest. A browser draws this in a tab, at 16 to 20
  pixels, and the crest is a fine-line engraving that turns to grey mush below
  48. The two-mark rule is in tools/brand/README.md: crest from 48 up, monogram
  below it, and an SVG icon has no size at which it is not the small one.

  The geometry is mark.svg's, copied at build time so the two cannot drift.
  currentColor is resolved to the brand gold here because a favicon has nothing
  to inherit a colour from: it is the one place the mark is given a colour
  rather than taking the ground's.

  IT IS OPAQUE, AND THAT IS THE POINT. Left transparent the mark is a faint
  scratch on a dark tab strip. Gold on its own green ground reads at every size
  a tab will ask for, needs no prefers-color-scheme switch, matches theme-color
  and carries the same colouring as the touch and PWA icons.
-->
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 96 96">
  <rect width="96" height="96" fill="%s"/>
  <g transform="translate(%s %s) scale(%s)" stroke="%s">
    %s
  </g>
</svg>
''' % (
    '#%02X%02X%02X' % GREEN_800,
    round(inset, 2), round(inset, 2), round(96 * MARK_COV / 100.0, 4),
    gold_hex,
    '\n    '.join(s.replace('currentColor', gold_hex) for s in shapes),
)

p = os.path.join(OUT, 'favicon.svg')
with open(p, 'w') as f:
    f.write(svg)
check_svg(p)
print('%-21s %7d bytes  (the small mark, as geometry)' % ('favicon.svg', os.path.getsize(p)))
