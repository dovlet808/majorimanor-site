"""
Build the Main Page's media from media_src/ and the Seedance sequences.

WHAT THIS IS. The Main Page declares its pictures by stem — home/world-dining,
home/club-humidor — and img() in app/helpers.php looks for
assets/img/<stem>-<width>.<ext>. The material in media_src/ is grouped by
subject, at whatever shape it was delivered in, and is never touched. This
script is the mapping between the two, and it is a script rather than a folder
of hand-cut exports for the same reason build_images.py is one: every crop is a
decision, and a decision has to be re-readable and re-runnable.

NOTHING HERE GENERATES A PICTURE. Every output is a crop, a resize and a
re-encode of a file that already existed in media_src/, or a frame lifted out of
a Seedance sequence whose own first frame is a media_src photograph. No image is
invented, none is upscaled, and media_src/ is opened read-only.

NOTHING IS UPSCALED, SO EVERY LADDER IS SHORT WHERE THE SOURCE IS SMALL. A rung
wider than the cropped source is skipped rather than interpolated: img_files()
publishes a one-entry srcset happily and a soft image sold as a sharp one is the
thing that reads as cheap on a large screen.

THE POSTERS COME OUT OF THE VIDEOS, NOT OUT OF THE PHOTOGRAPHS. Seedance reframes
a square or 4:3 source to the requested aspect, so the sequence's first frame and
the photograph it was made from are not the same composition. A poster taken from
the photograph would visibly re-frame the moment the video faded up. Frame 0 of
the sequence is the poster, which makes the fade invisible by construction — and
on the five section bands frame 0 IS the photograph beside them, reframed, so
nothing new enters.

THE HERO IS THE ONE THAT IS NOT A DESCENDANT OF A media_src STILL. Its master —
media_src/MOTION/HERO/main-hero.mp4 — was delivered finished rather than
generated from a photograph on disk, so home/hero-manor has no photographic
ancestor to be re-cropped from and frame 0 is not merely the best poster for it,
it is the only honest one. See tools/motion/build_sequences.sh. Nothing else
about the rule changes: the poster is still the video's own first frame and the
fade is still invisible by construction.

BIAS IS THE FRACTION OF THE SURPLUS TAKEN OFF THE TOP (or off the left, on a
frame too wide for its slot). 0.5 is a centre crop. Each value below was chosen
by looking at the result; where it is not 0.5 the reason is written beside it.

Run from anywhere:  python3 tools/photos/build_home_media.py
"""
import os
import shutil
import subprocess
import sys

from PIL import Image

HERE = os.path.dirname(os.path.abspath(__file__))
ROOT = os.path.dirname(os.path.dirname(HERE))          # tools/photos -> project root
SRC = os.path.join(ROOT, 'media_src')
IMG = os.path.join(ROOT, 'public_html', 'assets', 'img')
VID = os.path.join(ROOT, 'public_html', 'assets', 'video')

# Frames pulled out of the finished sequences live here so a re-run does not
# need ffmpeg again. Committed, because they are the posters' only source.
POSTERS = os.path.join(SRC, 'MOTION', 'posters')

JPEG_Q = 82
WEBP_Q = 78


# ---------------------------------------------------------------------------
# The table
#
#   stem : (source, ratio, widths, bias)
#
# stem    path under assets/img, without the width or the extension
# source  path under media_src, or a poster frame under MOTION/posters
# ratio   (w, h) the slot is declared at in content/en/home.php
# widths  the rungs to export; any rung wider than the crop is skipped
# bias    where the surplus comes off — see the note above
# ---------------------------------------------------------------------------

PLATES = {

    # -- Posters, from the sequences' own first frames ----------------------
    #
    # 1280 is the ceiling on all of them because the sequences are 720p and
    # the padel one is 1470 wide. A poster is behind a video for under a
    # second; upscaling one to 1920 to match a display would be inventing
    # detail for a picture nobody looks at twice.

    'home/hero-manor':    ('MOTION/posters/hero-manor.png',  (16, 9), [768, 1280], 0.5),
    'home/seq-arrival':   ('MOTION/posters/seq-arrival.png', (16, 9), [768, 1152], 0.5),
    'home/seq-dining':    ('MOTION/posters/seq-dining.png',  (16, 9), [768, 1152], 0.5),
    'home/seq-club':      ('MOTION/posters/seq-club.png',    (16, 9), [768, 1152], 0.5),
    'home/seq-padel':     ('MOTION/posters/seq-padel.png',   (21, 9), [768, 1152], 0.5),
    'home/seq-suite':     ('MOTION/posters/seq-suite.png',   (16, 9), [768, 1152], 0.5),

    # -- The editorial story ------------------------------------------------

    # The hall reads left to right and the staircase is the right third of it;
    # a centre crop of a 2:1 frame into 16:9 keeps all of it anyway.
    'home/story-hall':    ('HOUSE_OF_DIALOGUE/1.png',        (16, 9), [960, 1280, 1920], 0.5),
    # 0.42: the portrait over the chimneypiece is the subject and sits high.
    'home/story-library': ('HOUSE_OF_DIALOGUE/2.png',        (4, 5),  [640, 960, 1280], 0.42),
    # 0.30: the flight climbs out of frame; keeping the top keeps the climb.
    'home/story-stair':   ('HOUSE_OF_DIALOGUE/3.png',        (4, 5),  [640, 960, 1280], 0.30),

    # -- The world of Majori Manor — eight portrait plates -------------------

    'home/world-manor':   ('RESTAURANT/majestic_lobby.png',              (4, 5), [640, 960], 0.38),
    'home/world-club':    ('PRIVATE_CLUB_ECOSYSTEM/4.png',               (4, 5), [640, 960], 0.34),
    'home/world-dining':  ('RESTAURANT/grand_dining_room.png',           (4, 5), [640, 960], 0.30),
    'home/world-cigar':   ('CIGAR_HOUSE/vip_room.png',                    (4, 5), [640, 960], 0.40),
    # Already portrait and already 4:5 to within a hair — nothing is lost.
    'home/world-padel':   ('PRIVATE_CLUB_ECOSYSTEM/9.jpeg',              (4, 5), [640, 960], 0.50),
    'home/world-wellness': ('PRIVATE_CLUB_ECOSYSTEM/7.png',              (4, 5), [640, 960], 0.44),
    'home/world-suites':  ('ESTATE_and_HOSPITALITY/MAIN_MANOR_SUITE.png', (4, 5), [640, 960], 0.30),
    # 0.34: the lit dome is the whole picture and it fills the upper two thirds.
    'home/world-events':  ('PRIVATE_CLUB_ECOSYSTEM/2.png',               (4, 5), [640, 960], 0.34),

    # -- Dining -------------------------------------------------------------

    'home/dining-private': ('RESTAURANT/private_dining_room.png', (4, 5), [640, 960, 1280], 0.34),
    'home/dining-chefs':   ('RESTAURANT/chefs_room.png',          (3, 2), [640, 960, 1280], 0.5),
    'home/dining-salon':   ('RESTAURANT/dining_salon.png',        (4, 5), [640, 960, 1280], 0.30),

    # -- The private club ---------------------------------------------------

    'home/club-bar':      ('ESTATE_and_HOSPITALITY/MANOR_BAR.png', (3, 2), [640, 960, 1280], 0.5),
    'home/club-whisky':   ('CIGAR_HOUSE/whisky_lounge.png',        (3, 2), [640, 960, 1280], 0.5),
    # A 21:9 band, kept as one: it is a wall of drawers and it wants the width.
    'home/club-humidor':  ('CIGAR_HOUSE/humidor_display.png',      (21, 9), [960, 1280, 1920], 0.5),
    'home/club-terrace':  ('CIGAR_HOUSE/outdoor_terrace.png',      (3, 2), [640, 960, 1280], 0.5),
    # The glove and the door handle are the subject and they are centred low.
    'home/club-arrival':  ('PRIVATE_CLUB_ECOSYSTEM/5.png',         (4, 5), [640, 960, 1280], 0.44),

    # -- Stay ---------------------------------------------------------------

    # THE LADDER GOES TO 1280 NOW BECAUSE THE SOURCE DOES. This plate was capped
    # at 960 by the rule at the top of this file and not by choice: the picture
    # it was cut from was 1254 square, so a 4:5 crop of it was 1003 wide and the
    # 1280 rung was skipped rather than interpolated. The picture was replaced
    # with a 2880 square — same composition, same framing, the façade in marble
    # rather than grey stone — which crops to 2304 wide, so the rung its
    # neighbour stay-cottages has always had is now real for this one too. At
    # 31vw on a 1920 viewport the plate is drawn near 600 CSS px and a second-
    # generation display asks for twice that; 960 was the compromise the old
    # file forced. The bias is untouched at 0.30 because the framing is.
    'home/stay-guest-house': ('ESTATE_and_HOSPITALITY/SECOND_BUILDING_GUEST_SUITES.png',
                                                                   (4, 5), [640, 960, 1280], 0.30),
    'home/stay-cottages':    ('ESTATE_and_HOSPITALITY/private_cottages.png',
                                                                   (3, 2), [640, 960, 1280], 0.5),

    # -- The house as it stands ---------------------------------------------
    #
    # Real photography of the real building, and the only pictures on the page
    # that are. They carry source: photo in the content file; everything above
    # carries source: render. The distinction is the point of the section.
    #
    # THERE IS NO home/house-facade SLOT ANY MORE. The plate it fed was taken
    # off the Main Page on the owner's instruction; the slot goes with it so
    # that the script and the page still agree exactly, which is the property
    # this table is checked for. estate/estate_1.jpg is untouched and still
    # feeds estate/hero-facade through build_images.py — see the note beside
    # the plates in content/en/home.php for the open question about it. If the
    # façade returns to this page it is a line here first and a plate there
    # second.

    'home/house-stair':   ('grand-staircase/GrandStaircase_2.jpg', (4, 5),  [640, 960], 0.30),
    'home/house-hall':    ('interiors/interiors_3.jpg',            (4, 5),  [640, 960], 0.30),
    'home/house-piano':   ('interiors/interiors_1.jpg',            (4, 5),  [640, 960], 0.34),
}

# The seal, which is artwork rather than photography: exported as PNG so the
# transparency survives, at the three sizes the page actually draws it at.
SEAL = {
    'brand/seal-cream': ('Majori_logo/Logo-05.png', [96, 160, 320]),
    'brand/seal-gold':  ('Majori_logo/Logo-07.png', [96, 160, 320]),
}

# Frame 0 of each sequence, which is the poster. Lifted once and kept.
SEQUENCES = ['hero-manor', 'seq-arrival', 'seq-dining', 'seq-club', 'seq-padel', 'seq-suite']


# ---------------------------------------------------------------------------


def crop_to(im, ratio, bias):
    """Crop to ratio, taking the surplus off the top / left by `bias`."""
    want = ratio[0] / ratio[1]
    have = im.width / im.height

    if abs(have - want) < 0.002:
        return im

    if have > want:                       # too wide — take it off the sides
        w = round(im.height * want)
        x = round((im.width - w) * bias)
        return im.crop((x, 0, x + w, im.height))

    h = round(im.width / want)            # too tall — take it off top / bottom
    y = round((im.height - h) * bias)
    return im.crop((0, y, im.width, y + h))


def export(stem, source, ratio, widths, bias, written):
    path = os.path.join(SRC, source)

    if not os.path.isfile(path):
        print(f'  MISSING SOURCE  {source}  -> {stem} skipped')
        return

    im = Image.open(path)
    im = im.convert('RGB') if im.mode != 'RGB' else im
    im = crop_to(im, ratio, bias)

    out_dir = os.path.join(IMG, os.path.dirname(stem))
    os.makedirs(out_dir, exist_ok=True)

    kept = []

    for width in widths:
        if width > im.width:
            continue                       # never upscale

        height = round(width * ratio[1] / ratio[0])
        rung = im.resize((width, height), Image.LANCZOS)

        for ext, opts in (('jpg', dict(quality=JPEG_Q, optimize=True, progressive=True)),
                          ('webp', dict(quality=WEBP_Q, method=6))):
            name = f'{stem}-{width}.{ext}'
            rung.save(os.path.join(IMG, name), **opts)
            written.add(name)

        kept.append(width)

    skipped = [w for w in widths if w > im.width]
    note = f'   (source {im.width}px — skipped {skipped})' if skipped else ''
    print(f'  {stem:26} {ratio[0]}:{ratio[1]}  {kept}{note}')


def export_seal(stem, source, sizes, written):
    path = os.path.join(SRC, source)

    if not os.path.isfile(path):
        print(f'  MISSING SOURCE  {source}  -> {stem} skipped')
        return

    im = Image.open(path).convert('RGBA')

    # The masters carry a wide transparent margin. Trimming to the ink is what
    # lets the mark be sized by its own diameter in CSS instead of by a box
    # that is mostly nothing.
    box = im.getchannel('A').getbbox()
    if box:
        im = im.crop(box)

    os.makedirs(os.path.join(IMG, os.path.dirname(stem)), exist_ok=True)

    for size in sizes:
        name = f'{stem}-{size}.png'
        rung = im.resize((size, size), Image.LANCZOS)

        # THE SEAL IS ONE COLOUR ON NOTHING, and a full RGBA PNG stores it as
        # though it were a photograph — 34 KB at 160px, which is a quarter of
        # the hero's poster for a mark the size of a stamp. Quantising to a
        # palette with a real alpha channel is lossless to the eye on line art
        # and takes it to about a fifth of that. Alpha is quantised separately
        # from the ink so the anti-aliased edge survives.
        rung = rung.quantize(colors=64, method=Image.FASTOCTREE, dither=Image.NONE)

        rung.save(os.path.join(IMG, name), optimize=True)
        written.add(name)

    print(f'  {stem:26} PNG  {sizes}')


def lift_posters(ffmpeg):
    """Frame 0 out of each sequence in assets/video, into media_src/MOTION/posters."""
    os.makedirs(POSTERS, exist_ok=True)
    made = 0

    for name in SEQUENCES:
        out = os.path.join(POSTERS, name + '.png')

        if os.path.isfile(out):
            continue

        src = os.path.join(VID, name + '.mp4')

        if not os.path.isfile(src):
            print(f'  no sequence on disk: {name}.mp4')
            continue

        if not ffmpeg:
            print(f'  no ffmpeg and no frame for {name} — poster not built')
            continue

        subprocess.run([ffmpeg, '-nostdin', '-loglevel', 'error', '-y',
                        '-i', src, '-frames:v', '1', out], check=True)
        made += 1

    if made:
        print(f'  lifted {made} poster frame(s) into media_src/MOTION/posters/')


def find_ffmpeg():
    found = shutil.which('ffmpeg')

    if found:
        return found

    try:
        import imageio_ffmpeg
        return imageio_ffmpeg.get_ffmpeg_exe()
    except Exception:
        return None


def main():
    print('Posters')
    lift_posters(find_ffmpeg())

    written = set()

    print('\nPlates')
    for stem, (source, ratio, widths, bias) in PLATES.items():
        export(stem, source, ratio, widths, bias, written)

    print('\nSeal')
    for stem, (source, sizes) in SEAL.items():
        export_seal(stem, source, sizes, written)

    # Rungs this run did not write are rungs a previous mapping wrote. Leaving
    # them puts two different crops of two different sources into one srcset.
    print('\nSweep')
    stale = 0

    for group in ('home', 'brand'):
        base = os.path.join(IMG, group)

        if not os.path.isdir(base):
            continue

        for entry in sorted(os.listdir(base)):
            name = f'{group}/{entry}'

            if name in written or not entry.endswith(('.jpg', '.webp', '.png')):
                continue

            # brand/ predates this script and holds the crest, the icons and
            # the favicons. Only the seal rungs below are ours to sweep.
            if group == 'brand' and not entry.startswith('seal-'):
                continue

            os.remove(os.path.join(base, entry))
            print(f'  removed stale {name}')
            stale += 1

    if not stale:
        print('  nothing stale')

    print(f'\n{len(written)} files written into assets/img/')


if __name__ == '__main__':
    sys.exit(main())
