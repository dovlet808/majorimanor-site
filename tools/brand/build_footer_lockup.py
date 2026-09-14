"""
Build the footer lockup — the house mark over the wordmark — from the supplied
master, as a transparent PNG ladder for the Main Page's footer.

THE MASTER IS A JPEG ON A PURE BLACK GROUND, like the crests, so the same
premultiplied logic applies: an antialiased edge pixel already holds
ink * coverage, and coverage comes off the value channel, max(R, G, B).
The ink of this master is a pure white knockout (measured: 254.3 neutral), so
un-premultiplying is a division by the coverage and the result is flat ink —
which means the mark can be re-inked losslessly, and is.

IT IS RE-INKED TO --mm-cream-100. Three masters were supplied — wine, white,
green — and none of them is the ink this ground wants: the footer sits on
--mm-black-900 and every other letterform on it is cream. Pure white would be
the only pure white on the page. The white master is the right one to take the
coverage from because a knockout is the cleanest alpha of the three; the ink
that goes back on is the site's own. Nothing is redrawn: this is a flat
silhouette re-inked, not a wordmark set as type.

THE MASTER IS CROPPED AND THAT IS WHY THERE IS NO 960 RUNG. The wordmark is
clipped at both frame edges — the leading M loses its left serif and the final
R its foot — by about a pixel and a half at 1600px wide. At the 240px the
footer draws it at, that is a sixth of a pixel and it cannot be seen; at
960 it starts to be a truncated letter. If an uncropped master ever arrives,
widen WIDTHS and rebuild. Logo.pdf is NOT that master: its eight pages are the
round seal, which is a different mark and is already built by build_assets.py.

    python3 tools/brand/build_footer_lockup.py

Needs Pillow only, deliberately: build_assets.py needs numpy, and this has no
resampling subtle enough to want it. Nothing in media_src/ is ever written to.
"""
import os

from PIL import Image, ImageChops

HERE = os.path.dirname(os.path.abspath(__file__))
ROOT = os.path.dirname(os.path.dirname(HERE))          # tools/brand -> project root
MASTER = os.path.join(ROOT, 'media_src', 'Majori_logo', 'Footer', '2.jpeg')
OUT = os.path.join(ROOT, 'public_html', 'assets', 'img', 'brand')

STEM = 'lockup-cream'
INK = (0xF2, 0xEC, 0xE0)        # --mm-cream-100, the footer's own ink
HAZE = 5                        # JPEG haze floor, in 0-255 value units
WIDTHS = [240, 360, 480]        # the footer draws it at 240 CSS px


def coverage(path):
    """Master -> alpha. Value channel, floored to drop the JPEG haze."""
    r, g, b = Image.open(path).convert('RGB').split()
    v = ImageChops.lighter(ImageChops.lighter(r, g), b)

    return v.point(lambda p: 0 if p < HAZE else min(255, round((p - HAZE) * 255 / (255 - HAZE))))


def main():
    os.makedirs(OUT, exist_ok=True)
    alpha = coverage(MASTER)
    ink = [Image.new('L', alpha.size, c) for c in INK]

    for width in WIDTHS:
        height = round(alpha.height * width / alpha.width)

        # Resize the coverage on its own. The ink is flat, so there is no
        # premultiplied pair to keep in step here — scaling alpha IS the crop.
        a = alpha.resize((width, height), Image.LANCZOS)
        art = Image.merge('RGBA', [c.resize((width, height), Image.LANCZOS) for c in ink] + [a])

        path = os.path.join(OUT, f'{STEM}-{width}.png')
        art.save(path, optimize=True)
        print(f'{os.path.relpath(path, ROOT)}  {width}x{height}  {os.path.getsize(path) / 1024:.1f} KB')


if __name__ == '__main__':
    main()
