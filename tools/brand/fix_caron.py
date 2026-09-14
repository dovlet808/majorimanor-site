"""
Replace the wrong diacritic over the Z in MAJORI MUIZA with a proper caron.

The supplied art puts a near-horizontal bar over the Z. Rotated upright it is a
macron, not a caron -- Latvian 'muiza' needs Z-caron. This erases the bar and
draws a V in its place, matching the art's stroke weight, ink colour and (on
the green file, the only one that has them) the white keyline.

Geometry is done in LETTER SPACE: u runs along the arc's baseline, v points
radially inward, which is the direction the letter's own up points. Sizes are
fractions of the crest radius R so the gold file -- drawn at a different scale
-- gets a proportional caron rather than a copied one.

The band the diacritic lives in is TIGHT: the ring above it sits only 9-13px
clear of the bar at a crest radius of ~400px. V_CEIL is that measured ceiling
per file, and the caron's rise is clamped to it, so the new mark never comes
closer to the ring than the old one did.
"""
import numpy as np
from PIL import Image
from collections import deque
import os

HERE = os.path.dirname(os.path.abspath(__file__))
ROOT = os.path.dirname(os.path.dirname(HERE))      # tools/brand -> project root
OUT = os.path.join(HERE, 'masters')
os.makedirs(OUT, exist_ok=True)

# file, chroma threshold, value threshold, keyline width (px @ R=403), v ceiling
SRC = {
    'green': ('favicon (#1A4438).jpg', 0.20, 0.05, 1.8, 11.5),
    'wine':  ('favicon (#7B1E2B).jpg', 0.33, 0.075, 0.0,  7.5),
    'gold':  ('favicon (#CBA96A).jpg', 0.33, 0.075, 0.0,  9.5),
}

REF_R    = 402.8          # the radius every measurement below was taken at
HALF_W   = 15.0 / REF_R   # caron half-width: 30px across a 44px Z
THICK    = 5.8 / REF_R    # arm weight, matching the Z's thin stroke
RISE_REL = 0.62           # rise as a fraction of half-width, before clamping
R_FRAC, THETA = 310.7 / REF_R, np.deg2rad(48.2)   # where the diacritic sits


def geometry(path):
    g = np.asarray(Image.open(path).convert('L'))
    ys, xs = np.nonzero(g > 28)
    return ((xs.min() + xs.max()) / 2.0,
            (ys.min() + ys.max()) / 2.0,
            ((xs.max() - xs.min()) + (ys.max() - ys.min())) / 4.0)


def flood(mask, seed, win=34):
    """Blob of `mask` nearest `seed`, as (y, x) float array."""
    sy, sx = int(seed[1]), int(seed[0])
    sub = mask[sy - win:sy + win, sx - win:sx + win]
    yy, xx = np.mgrid[sy - win:sy + win, sx - win:sx + win]
    d = np.where(sub, (yy - seed[1]) ** 2 + (xx - seed[0]) ** 2, 1e9)
    start = np.unravel_index(d.argmin(), d.shape)

    seen = np.zeros(sub.shape, bool)
    seen[start] = True
    q = deque([start])
    px = []
    while q:
        y, x = q.popleft()
        px.append((y, x))
        for dy in (-1, 0, 1):
            for dx in (-1, 0, 1):
                ny, nx = y + dy, x + dx
                if 0 <= ny < sub.shape[0] and 0 <= nx < sub.shape[1] \
                        and sub[ny, nx] and not seen[ny, nx]:
                    seen[ny, nx] = True
                    q.append((ny, nx))
    return np.array([(p[0] + sy - win, p[1] + sx - win) for p in px], float)


def seg_dist(py, px, a, b):
    vy, vx = b[0] - a[0], b[1] - a[1]
    wy, wx = py - a[0], px - a[1]
    t = np.clip((wy * vy + wx * vx) / (vy * vy + vx * vx), 0.0, 1.0)
    return np.hypot(wy - t * vy, wx - t * vx)


for name, (path, sth, vth, key_w, v_ceil) in SRC.items():
    src = os.path.join(ROOT, path)
    img = np.asarray(Image.open(src).convert('RGB')).astype(np.float32)
    cx, cy, R = geometry(src)
    scale = R / REF_R

    mx = img.max(2); mn = img.min(2)
    V = mx / 255.0
    S = np.where(mx > 0, (mx - mn) / np.maximum(mx, 1), 0)
    ink = (S > sth) & (V > vth)
    lit = ink | (V > 0.55)          # ink together with its white keyline

    seed = (cx + R_FRAC * R * np.cos(THETA), cy + R_FRAC * R * np.sin(THETA))
    bar = flood(ink, seed)
    c = bar.mean(0)

    up = np.array([cy - c[0], cx - c[1]]); up /= np.linalg.norm(up)
    rt = np.array([-up[1], up[0]])
    D = bar - c
    v_bar = D @ up

    # Ink colour is sampled from the Z below, not from the bar: the bar is
    # small enough that its median is dragged down by antialiased edge pixels,
    # which left the gold caron visibly duller than the letters beside it. The
    # Z is a big blob, and the gold art carries a vertical gradient, so take
    # only the part of it nearest the diacritic and only its brighter half.
    zed = flood(ink, (c[1] - up[1] * 26, c[0] - up[0] * 26), win=42)
    near = zed[np.hypot(zed[:, 0] - c[0], zed[:, 1] - c[1]) < 26]
    if len(near) < 40:
        near = zed
    px_rgb = img[near[:, 0].astype(int), near[:, 1].astype(int)]
    lum = px_rgb @ np.array([0.2126, 0.7152, 0.0722])
    ink_rgb = np.median(px_rgb[lum >= np.percentile(lum, 55)], 0)

    # ---- erase the old bar -------------------------------------------------
    # Flood ink|white so the keyline goes with it. If that leaks into the Z or
    # the ring the blob blows up, so fall back to a dilation of the ink blob
    # clamped to the diacritic's own band.
    halo = flood(lit, seed)
    hy, hx = halo[:, 0], halo[:, 1]
    leaked = (hy.max() - hy.min() > 40) or (hx.max() - hx.min() > 52)

    ys, xs = bar[:, 0].astype(int), bar[:, 1].astype(int)
    y0, y1 = ys.min() - 12, ys.max() + 13
    x0, x1 = xs.min() - 12, xs.max() + 13
    gy, gx = np.mgrid[y0:y1, x0:x1]

    src_y, src_x = (ys, xs) if leaked else (hy.astype(int), hx.astype(int))
    dist = np.full(gy.shape, 1e9)
    for py, px_ in zip(src_y, src_x):
        np.minimum(dist, np.hypot(gy - py, gx - px_), out=dist)
    rad = (2.0 + key_w * scale) if not leaked else (3.4 + key_w * scale)
    erase = np.clip(0.5 + (rad - dist), 0, 1)

    gv = ((gy - c[0]) * up[0] + (gx - c[1]) * up[1])
    erase = np.where((gv > v_bar.min() - 1.2) & (gv < v_ceil * scale + 1.0), erase, 0)[..., None]

    patch = img.copy()
    patch[y0:y1, x0:x1] = patch[y0:y1, x0:x1] * (1 - erase)

    # ---- draw the caron ----------------------------------------------------
    a = HALF_W * R
    t = THICK * R
    h = min(RISE_REL * a, v_ceil * scale - v_bar.min() - t)

    apex_v = v_bar.min() + t / 2.0
    apex = c + up * apex_v
    tipL = c + up * (apex_v + h) - rt * a
    tipR = c + up * (apex_v + h) + rt * a

    d = np.minimum(seg_dist(gy, gx, apex, tipL), seg_dist(gy, gx, apex, tipR))
    a_ink = np.clip(0.5 + (t / 2.0 - d), 0, 1)[..., None]

    reg = patch[y0:y1, x0:x1]
    if key_w > 0:
        key_rgb = np.array([230., 239., 240.])
        a_key = np.clip(np.clip(0.5 + (t / 2.0 + key_w * scale - d), 0, 1)[..., None] - a_ink, 0, 1)
        reg = reg * (1 - a_key) + key_rgb * a_key
    reg = reg * (1 - a_ink) + ink_rgb * a_ink
    patch[y0:y1, x0:x1] = reg

    Image.fromarray(np.clip(patch, 0, 255).astype(np.uint8)).save(
        os.path.join(OUT, f'crest-{name}.png'))
    print('%-6s R=%.1f leaked=%-5s a=%.1f t=%.1f h=%.1f angle=%.0fdeg ink=%s'
          % (name, R, leaked, a, t, h, np.degrees(np.arctan2(h, a)), ink_rgb.round(0)))
