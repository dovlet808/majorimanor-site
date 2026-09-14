"""
Build THE ESTATE's media from media_src/ and the six Seedance 2.0 sequences.

WHAT THIS IS. /the-estate declares its pictures by stem — estate/walk-hall,
estate/detail-baluster — and img() in app/helpers.php looks for
assets/img/<stem>-<width>.<ext>. This script is the mapping between the
material in media_src/ and those stems, and it is a script rather than a folder
of hand-cut exports for the same reason build_home_media.py is one: every crop
is a decision, and a decision has to be re-readable and re-runnable.

TWO KINDS OF PICTURE COME OUT OF HERE AND THEY ARE NOT THE SAME CLAIM.

  PLATES are crops of the supplied photographs. Nothing is added, nothing is
  invented, nothing is upscaled: a rung wider than the cropped source is
  skipped rather than interpolated. They are declared 'photo' in the content
  file because that is what they are — this building, photographed.

  POSTERS are frame 0 of a Seedance sequence. Every sequence was started from a
  photograph in media_src/ (or, for two of them, from a GPT Image 2 still that
  was itself made from one), and every prompt is a preservation instruction —
  but Seedance reframes a portrait source to a landscape output, which means it
  extends the room or the facade sideways using the vocabulary of the
  photograph. That extension is synthesis. It is honest architecture and it is
  still not a photograph, so every one of them is declared 'generated' in the
  content file and the components print "Generated image" under it. See
  IMG_SOURCES in app/helpers.php, which has carried that fourth value unused
  since before this page existed, and §11 of the architecture note.

THE POSTER IS THE SEQUENCE'S OWN FIRST FRAME, WHICH IS WHY THE FADE IS
INVISIBLE. A poster cut from the source photograph instead would visibly
re-frame the moment the video faded up, because the two are not the same
composition. Frame 0 is, by construction.

BIAS IS THE FRACTION OF THE SURPLUS TAKEN OFF THE TOP (or off the left, on a
frame too wide for its slot). 0.5 is a centre crop. Where a value is not 0.5
the reason is written beside it.

Run from anywhere:  python3 tools/photos/build_estate_media.py
Needs:              Pillow, and ffmpeg on PATH or at $MM_FFMPEG
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

# The six sequences as they came back from Seedance, and the two GPT Image 2
# stills the exterior ones were made from.
#
# THE STILLS ARE COMMITTED AND THE .mp4 MASTERS ARE NOT, and that is the
# repository's existing rule rather than a decision taken here: .gitignore
# carries /media_src/**/*.mp4 with the reasoning beside it — the master stays
# on disk and in the backup, the encode under public_html/assets/video/ is the
# deliverable and that one is committed. tools/motion/build_sequences.sh makes
# the same assumption for the Main Page's six.
#
# So a fresh clone can rebuild every PLATE below, and rebuilding the SEQUENCES
# needs the masters restored to this directory first. The poster frames this
# script pulls out of them are gitignored for the opposite reason: they are
# regenerable from the masters in one command.
MOTION = os.path.join(SRC, 'MOTION', 'estate')

JPEG_Q = 82
WEBP_Q = 78


def ffmpeg() -> str:
    """ffmpeg, from $MM_FFMPEG, from PATH, or from imageio-ffmpeg if installed."""
    if os.environ.get('MM_FFMPEG'):
        return os.environ['MM_FFMPEG']

    found = shutil.which('ffmpeg')
    if found:
        return found

    try:
        import imageio_ffmpeg
        return imageio_ffmpeg.get_ffmpeg_exe()
    except ImportError:
        sys.exit('ffmpeg not found: put it on PATH or set MM_FFMPEG')


# ---------------------------------------------------------------------------
# 1. The plates
#
#   stem : (source, ratio, widths, bias, why)
#   stem : (source, ratio, widths, bias, why, region)
#
# REGION IS THE ONE THING A BIAS CANNOT DO. A bias slides the crop along the
# axis that has surplus; it cannot go INTO a photograph. Two of the detail
# plates want a part of the frame rather than the whole of it — the carved
# capital, the turned balusters — so those declare (left, top, right, bottom)
# in source pixels and the aspect crop is taken from that instead.
#
# A REGION MAY NOT BE SMALLER THAN THE LADDER IT FEEDS. Nothing is upscaled
# here, so a 400px region would publish no rungs at all rather than a soft
# picture. The two below are 720px wide against a 640 rung, which is as tight
# as an 1170px source goes while still being a real export.
# ---------------------------------------------------------------------------

PLATES = {

    # -- The walk: five stills, each the full width of the viewport ----------
    #
    # 16:9 out of a 0.88 portrait is a hard crop and it is the right one: the
    # station is a full-bleed screen, so what it wants is the widest band of
    # the room, not the most of it.

    'estate/walk-hall': (
        'interiors/interiors_2.jpg', (16, 9), [768, 1152], 0.52,
        'The chimneypiece and the chequered floor, with the tall window at the '
        'left still in frame. A shade below centre so the marble hearth stands '
        'on its own floor rather than on the bottom edge.'),

    'estate/walk-marble': (
        'heritage-details/heritage_2.jpg', (16, 9), [768, 1152], 0.62,
        'Low, because the slot is the FLOOR: the chequerboard fills the band '
        'and the glazed screen above it says which room it is in.'),

    'estate/walk-glass': (
        'grand-staircase/GrandStaircase_2.jpg', (16, 9), [768, 1152], 0.24,
        'High. The stained-glass window is the subject and it sits in the '
        'upper third; a centred band loses it and keeps the dado.'),

    'estate/walk-landing': (
        'grand-staircase/GrandStaircase_1.jpg', (16, 9), [768, 1152], 0.30,
        'Holds the coffered ceiling, the arch through to the next room and the '
        'barley-twist balusters in one band — the landing as a threshold.'),

    'estate/walk-doors': (
        'heritage-details/heritage_1.jpg', (16, 9), [768, 1152], 0.50,
        'Already 1.92 wide, so only height comes off. Centred: the open leaf '
        'and the room showing through it are both mid-frame.'),

    # -- The details: six crops, tighter than a room ------------------------
    #
    # These are the only pictures on the page that are not a whole room. A
    # detail plate is a different photograph from the same negative, which is
    # what makes it worth standing beside the walk rather than repeating it.

    'estate/detail-baluster': (
        'interiors/interiors_4.jpg', (3, 4), [640], 0.50,
        'INTO the frame rather than across it: the turned balusters and the '
        'curve of the handrail, without the empty wall the full frame carries '
        'above them.',
        (30, 420, 750, 1380)),

    'estate/detail-capital': (
        'heritage-details/heritage_3.jpg', (3, 4), [640], 0.50,
        'The carved capital of the spiral column and the arcaded balustrade '
        'behind it. The full frame is the whole stairhall, which is what the '
        'walk already shows; this is the column in it.',
        (80, 380, 800, 1340)),

    'estate/detail-glass': (
        'grand-staircase/GrandStaircase_3.jpg', (3, 2), [640, 960], 0.18,
        'The leaded amber glazing in its moulded timber frame, under the '
        'coffers. High: the glass is the top half of the frame.'),

    'estate/detail-fittings': (
        'heritage-details/heritage_1.jpg', (3, 4), [640, 960], 0.50,
        'The brass espagnolette bolt and hinges on the open leaf, which are the '
        'artistic metal door fittings the record names. Off-centre left, where '
        'the ironmongery actually is.'),

    'estate/detail-coffers': (
        'grand-staircase/GrandStaircase_1.jpg', (3, 2), [640, 960], 0.00,
        'Hard top. The coffers are the slot and they are at the top of the '
        'frame; anything lower turns the picture into a landing with a ceiling '
        'above it.'),

    'estate/detail-stove': (
        'interiors/interiors_1.jpg', (3, 2), [640, 960], 0.34,
        'The relief panel and moulded crown of the tiled stove, with the lit '
        'firebox below it and the wallpaper either side.'),
}


# ---------------------------------------------------------------------------
# 2. The sequences
#
#   name : (mp4, ratio, poster widths, narrow encode?, source, prompt gist)
#
# 'source' is the media_src reference the sequence descends from. Two of them
# descend through a GPT Image 2 still: the still was made FROM the photograph
# named here, and the sequence was made from the still.
# ---------------------------------------------------------------------------

SEQUENCES = {
    'est-arrival': (
        (16, 9), [768, 1280], True,
        'estate/estate_1.jpg -> GPT Image 2 blue-hour still -> Seedance 2.0',
        'Slow dolly forward through the gate piers at blue hour.'),

    'est-house': (
        (16, 9), [768, 1152], False,
        'estate/estate_3.jpg -> Seedance 2.0',
        'Slow lateral track across the facade.'),

    'est-hall': (
        (16, 9), [768, 1152], False,
        'interiors/interiors_3.jpg -> Seedance 2.0',
        'Slow push-in under the chandelier.'),

    'est-stair': (
        (16, 9), [768, 1152], False,
        'heritage-details/heritage_3.jpg -> Seedance 2.0',
        'Slow rising push toward the foot of the stair.'),

    'est-hearth': (
        (16, 9), [768, 1152], False,
        'interiors/interiors_1.jpg -> Seedance 2.0',
        'Slow drift toward the tiled stove, fire alight.'),

    'est-park': (
        (21, 9), [768, 1152], False,
        'estate/estate_2.jpg -> GPT Image 2 golden-hour still -> Seedance 2.0',
        'Slow lateral drift across the park.'),
}

# The wide encode is what a desktop gets; the narrow one is for the hero below
# 900px, where a 1280-wide film is three times the bytes needed to fill a 390px
# screen. CRF rather than a bitrate: these are slow shots of still architecture
# and they compress very differently from one another.
CRF_WIDE = 27
CRF_HERO = 25
CRF_NARROW = 28

# ---------------------------------------------------------------------------
# 3. The grade
#
# ONE SEQUENCE IS GRADED AND IT IS THE HERO, FOR A LEGIBILITY REASON RATHER
# THAN A TASTE ONE. The hero's copy — the eyebrow, the subtitle, the lede —
# stands in the middle of the frame, and in the middle of this frame is a white
# rendered wall. The Main Page's hero puts the same lines over dark stone,
# which is why home.css leaves its scrim transparent between 26% and 44%: it
# has nothing to protect there. Cream type on a white wall measures about
# 1.2:1, and no scrim gentle enough to keep the building legible will fix that
# on its own.
#
# So the picture is taken down rather than the type propped up. The curve pulls
# the midtones about six percent and the highlights about ten, which lands the
# render at roughly the density of the approved Main Page hero — deep blue
# hour, with the lit windows as the only bright thing in frame. It is the
# cinematographer's answer to the problem, and it leaves home.css alone.
#
# The scrim in estate.css adds a soft band behind the copy on top of this; the
# two together are what clear AA. Neither does it alone.
GRADE = {
    'est-arrival': "curves=all='0/0 0.5/0.44 1/0.90'",
}


def crop_box(size, ratio, bias):
    """The box to cut from an image of `size` to land exactly on `ratio`."""
    w, h = size
    rw, rh = ratio
    want = rw / rh

    if w / h > want:                      # too wide: take width off the sides
        new_w = int(round(h * want))
        left = int(round((w - new_w) * bias))
        return (left, 0, left + new_w, h)

    new_h = int(round(w / want))          # too tall: take height off top/bottom
    top = int(round((h - new_h) * bias))
    return (0, top, w, top + new_h)


def export(image, stem, widths):
    """Write the rungs that the crop is actually wide enough for."""
    out_dir = os.path.join(IMG, os.path.dirname(stem))
    os.makedirs(out_dir, exist_ok=True)

    written = []

    for width in widths:
        if width > image.width:
            continue                      # never upscale — see the note above

        height = int(round(width * image.height / image.width))
        rung = image.resize((width, height), Image.LANCZOS)
        base = os.path.join(IMG, f'{stem}-{width}')

        rung.save(f'{base}.jpg', 'JPEG', quality=JPEG_Q, optimize=True,
                  progressive=True)
        rung.save(f'{base}.webp', 'WEBP', quality=WEBP_Q, method=6)
        written.append(width)

    return written


def build_plates():
    print('\nPLATES — crops of the supplied photographs\n' + '-' * 72)

    for stem, entry in PLATES.items():
        source, ratio, widths, bias, _why = entry[:5]
        region = entry[5] if len(entry) > 5 else None
        path = os.path.join(SRC, source)

        if not os.path.isfile(path):
            print(f'  MISSING  {source}')
            continue

        with Image.open(path) as im:
            im = im.convert('RGB')

            if region is not None:
                im = im.crop(region)

            cropped = im.crop(crop_box(im.size, ratio, bias))
            rungs = export(cropped, stem, widths)

            if not rungs:
                print(f'  NO RUNGS {stem}: crop is {cropped.width}px, '
                      f'ladder starts at {min(widths)}')

        print(f'  {stem:<28} <- {source:<44} {cropped.width}x{cropped.height}'
              f'  {rungs}')


def build_sequences():
    ff = ffmpeg()
    os.makedirs(VID, exist_ok=True)
    print('\nSEQUENCES — encodes and posters\n' + '-' * 72)

    for name, (ratio, widths, narrow, source, _gist) in SEQUENCES.items():
        master = os.path.join(MOTION, f'{name}.mp4')

        if not os.path.isfile(master):
            print(f'  MISSING  {master}')
            continue

        crf = CRF_HERO if narrow else CRF_WIDE
        grade = GRADE.get(name)

        # -- the wide encode ------------------------------------------------
        wide = os.path.join(VID, f'{name}.mp4')
        subprocess.run([
            ff, '-y', '-loglevel', 'error', '-i', master,
            '-an',                                   # the page never plays sound
        ] + (['-vf', grade] if grade else []) + [
            '-c:v', 'libx264', '-profile:v', 'high', '-pix_fmt', 'yuv420p',
            '-crf', str(crf), '-preset', 'slow',
            '-movflags', '+faststart',
            wide,
        ], check=True)

        line = f'  {name:<14} {os.path.getsize(wide) // 1024:>5} KB'

        # -- the narrow encode, where one is wanted --------------------------
        if narrow:
            small = os.path.join(VID, f'{name}-sm.mp4')
            # The grade comes first and the scale second: grading after a
            # downscale grades interpolated pixels, and the two encodes have to
            # be the same picture or the swap at 900px is visible.
            chain = (grade + ',' if grade else '') + 'scale=854:-2'
            subprocess.run([
                ff, '-y', '-loglevel', 'error', '-i', master,
                '-an', '-vf', chain,
                '-c:v', 'libx264', '-profile:v', 'high', '-pix_fmt', 'yuv420p',
                '-crf', str(CRF_NARROW), '-preset', 'slow',
                '-movflags', '+faststart',
                small,
            ], check=True)
            line += f'  + {os.path.getsize(small) // 1024} KB narrow'

        # -- the poster: frame 0 of the encode the reader will actually see --
        frame = os.path.join(MOTION, f'{name}-frame0.png')
        subprocess.run([
            ff, '-y', '-loglevel', 'error', '-i', wide,
            '-vf', 'select=eq(n\\,0)', '-vframes', '1', frame,
        ], check=True)

        with Image.open(frame) as im:
            im = im.convert('RGB')
            cropped = im.crop(crop_box(im.size, ratio, 0.5))
            rungs = export(cropped, f'estate/{name}', widths)

        print(f'{line}  poster {rungs}  <- {source}')


if __name__ == '__main__':
    build_plates()
    build_sequences()
    print('\ndone.\n')
