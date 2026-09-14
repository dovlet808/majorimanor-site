#!/usr/bin/env python3
"""
Majori Manor — /terms media.

ONE PICTURE, AND NOTHING WAS GENERATED TO MAKE IT. It is the smallest media
build on this site: /privacy, which held the record, cut no plate and made one
still and one sequence; this cuts no plate, makes NO still, and makes one
sequence. The brief said so — "Use existing media_src assets whenever they are
already suitable. Do NOT regenerate an image unnecessarily" — and the library
was already the picture.

    HOUSE_OF_DIALOGUE/2.png   2160x1920, the library, its fire lit
        |                     (a visualisation of the project — 'render')
        v
    ref-library.png           16:9 out of it at bias 0.26, 2160x1215.
        |                     Rebuildable by this file from that one PNG
        |                     and nothing else. No GPT Image 2 step: the
        |                     room is already at the hour the page wants
        v
    ter-library.mp4           Seedance 2.0, 720p, std, 16:9, 5 s, no audio,
        |                     start_image = the crop. 1280x720, 24 fps
        v
    assets/video/ter-library.mp4      1280 wide, the hero
    assets/video/ter-library-sm.mp4    854 wide, below 900px
    assets/img/terms/ter-library-{768,1280}.{jpg,webp}   frame 0 of the encode

WHY THE LIBRARY AND NOT THE HOUSE. The brief offered eleven subjects and asked
for four qualities — quiet authority, heritage, discretion, trust. Four of the
eleven were the manor exterior, and ALL FOUR EXTERIOR NEGATIVES IN THE LIBRARY
ARE ALREADY SOMEBODY'S HERO: estate_1 is THE ESTATE's gate at blue hour,
estate_2 is CONTACT's portico at dusk, estate_3 is MEMBERSHIP's north front at
night, estate_4 is AFTER DARK's garden front. A fifth facade with warm windows
would be the same page a fifth time, and the rule that keeps this site from
drifting is docs/MEMBERSHIP.md's: a hero source is spent once.

So it is one of the other seven, and it is the one that is the subject. A
library is where an estate keeps its documents. HOUSE_OF_DIALOGUE/2.png is
bookcases to the ceiling on three walls, a fire, a portrait in a gilt frame and
four leather chairs with nobody in them — dark wood, heritage, discretion,
quiet, and no crowd, no padel, no cigar, no party, every one of which the brief
named as something to avoid. It has been a plate on the Main Page and on THE
CLUB since those pages were approved, in daylight-flat 4:5 and 16:9 crops that
nothing animates. IT HAS NEVER BEEN A HERO AND HAS NEVER MOVED.

WHY NOTHING WAS GENERATED FROM IT. The room in the file is already lit by its
own fire and its own two lamps, at the hour a legal page wants. /privacy needed
GPT Image 2 because heritage_1.jpg is a noon photograph and the page needed
first light; there is no equivalent gap here, and a generation whose whole
instruction would be "change nothing" is 6.5 credits spent to introduce risk.
The crop below IS the reference and IS the start frame, and frame 0 of the
finished encode measures 1.92 mean absolute difference against it out of 255 —
which is JPEG, not the model.

Run from anywhere:  python3 tools/photos/build_terms_media.py
Needs:              Pillow, and ffmpeg on PATH, at $MM_FFMPEG, or imageio-ffmpeg
"""
import os
import shutil
import subprocess
import sys

from PIL import Image

Image.MAX_IMAGE_PIXELS = None

HERE = os.path.dirname(os.path.abspath(__file__))
ROOT = os.path.dirname(os.path.dirname(HERE))          # tools/photos -> project root
SRC = os.path.join(ROOT, 'media_src')
IMG = os.path.join(ROOT, 'public_html', 'assets', 'img')
VID = os.path.join(ROOT, 'public_html', 'assets', 'video')

# The sequence as it came back from Seedance and the crop it was made from.
#
# THE CROP IS COMMITTED AND THE .mp4 MASTER IS NOT — .gitignore carries
# /media_src/**/*.mp4. The master stays on disk and in the backup; the encode
# under public_html/assets/video/ is the deliverable and that one is committed.
MOTION = os.path.join(SRC, 'MOTION', 'terms')

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
    except Exception:
        sys.exit('ffmpeg not found: put it on PATH or set MM_FFMPEG')


# ---------------------------------------------------------------------------
# 1. The reference crop
#
# The only thing in this file that starts from a picture rather than from a
# generation, and on this page it is also the last: the crop below is what
# Seedance was handed. A fresh clone rebuilds the whole chain from
# media_src/HOUSE_OF_DIALOGUE/2.png and this script.
#
# THE BIAS IS 0.26 AND IT WAS CHOSEN BY LOOKING. The negative is 2160x1920 —
# almost square — so a 16:9 window drops 705px of height and the only question
# is where. Three were rendered and compared:
#
#   0.10  keeps the top shelf and cuts the table, the silver and the chair
#         fronts: a bookcase with a fire in it rather than a room
#   0.26  keeps the portrait whole in its frame, both candelabra, the mantel,
#         the fire, both lamps, the chesterfield, both armchairs and the silver
#   0.42  cuts the top of the gilt frame and gains carpet
#
# 0.26 is the only one of the three that holds the whole chimneypiece group and
# still stands in the room rather than at the bookcase.
# ---------------------------------------------------------------------------

REFERENCE_SOURCE = 'HOUSE_OF_DIALOGUE/2.png'
REFERENCE_RATIO = (16, 9)
REFERENCE_BIAS = 0.26


# ---------------------------------------------------------------------------
# 2. The prompt, verbatim
#
# A prompt is the only part of a generated asset that cannot be recovered by
# looking at it. It is written as a PRESERVATION instruction rather than a
# description — it names the joinery, the chimneypiece, the pictures and the
# furniture of that specific frame, states the only motion that is allowed, and
# then says what may not appear. The negative half is the half that does the
# work. Same shape as build_privacy_media.py.
#
# ---- Seedance 2.0, 720p, std, 16:9, 5 s, no audio, start_image -------------
#
# START_IMAGE AND NOT omni_reference, WHICH IS THE RULE build_events_media.py
# SET AND SIX PAGES HAVE NOW KEPT. The brief for this page asked for
# mode: omni_reference; start_image is what it is built on instead, and the
# reason is the brief's own instruction two paragraphs above it — "Preserve:
# manor architecture, estate identity, materials, proportions, landscaping,
# lighting language, Majori Manor visual identity". A reference is a mood and a
# start frame is a contract: it is the only setting under which nine bays of
# bookcase, a carved chimneypiece, a gilt frame and two candelabra survive five
# seconds of camera movement intact. It is also what makes the poster honest —
# frame 0 of the encode is what a reader sees before the video plays, so the
# still and the film cannot re-frame against each other when the video fades up.
#
# ter-library  <- ref-library
#   "Extremely slow cinematic drift forward into this exact panelled manor
#    library at evening, toward the chimneypiece and the portrait above it.
#    Preserve everything exactly as photographed: the dark oak bookcases running
#    floor to ceiling on all three walls with their moulded cornices, their
#    pilasters and every shelf of bound leather volumes exactly as they stand;
#    the carved dark marble chimneypiece with its central relief tablet, its
#    moulded shelf and its arched firebox; the large gilt-framed portrait of a
#    seated bearded man in a dark coat hanging above the shelf, at exactly the
#    same size, position and angle; the two brass candelabra on the shelf either
#    side of it with their lit candles; the two pleated silk table lamps, one on
#    the low cabinet at the left and one on the pedestal at the right, both lit;
#    the buttoned dark leather chesterfield sofa at the right and the two deep
#    leather armchairs in the foreground; the low mahogany table with the silver
#    tea service and tray on it; the patterned carpet and the dark parquet
#    floor. The only motion: the camera drifts forward extremely slowly and
#    perfectly level, so the chimneypiece grows very slightly in the frame with
#    gentle parallax between the armchairs in the foreground and the bookcases
#    behind them; the fire in the grate burns and flickers gently and its light
#    moves faintly across the marble and the leather; the candle flames waver
#    very slightly; the lamplight stays steady. No people. No people entering or
#    crossing the frame. No hands, no smoke, no cigar. No new architecture,
#    bookcases, shelves, doors, windows, panelling, mouldings or chimneypieces.
#    No new furniture, books, lamps, candlesticks, pictures, mirrors, plants or
#    objects of any kind. No book moving or being taken from a shelf. No signage
#    or lettering. No change to the portrait. Restrained European private-estate
#    architectural cinematography, firelight and lamplight only, one continuous
#    shot, no cuts, no camera shake, no zoom snap, no lens flare."
#
#   WHAT THE MODEL DID DIFFERENTLY, STATED RATHER THAN HIDDEN. It went the
#   other way. The prompt asked the camera to drift IN and the master drifts
#   OUT — the room opens rather than closes, measured against frame 0 at 1.06x
#   by one second, 1.13x by two, 1.19x by three and 1.32x by five.
#
#   IT IS KEPT BECAUSE THE LOOP IS A PALINDROME AND THEREFORE PLAYS BOTH. The
#   encode runs forward and then backwards, so a reader sees the room open and
#   then close again, continuously; "toward" and "away" are the same five
#   seconds seen from either end. What the direction DOES decide is the poster,
#   and it decides it the right way round: frame 0 is the tightest framing in
#   the shot, which is the composition that was chosen and checked.
#
#   NOTHING WAS ADDED INSIDE THE TRIM. Frame by frame to 2.4 s the bookcases,
#   the chimneypiece, the relief tablet, the gilt frame, the two candelabra,
#   the two lamps, the chesterfield, the armchairs, the table and the silver
#   are all where the crop put them, and no object enters. PAST IT THEY DO: at
#   about four seconds the pull-back has opened the left wall far enough that
#   the model invents a doorway there. That is the second reason for the trim
#   below and it is the harder one — see TRIM.

SEQUENCE_NAME = 'ter-library'
SEQUENCE_RATIO = (16, 9)
SEQUENCE_POSTER_WIDTHS = [768, 1280]
SEQUENCE_SOURCE = 'HOUSE_OF_DIALOGUE/2.png -> 16:9 crop -> Seedance 2.0'


# ---------------------------------------------------------------------------
# 3. The trim, the stretch, and why this is now the slowest hero on the site
#
# THE BRIEF ASKED FOR MOVEMENT THAT IS "ALMOST IMPERCEPTIBLE" and for "a still
# architectural image that is quietly alive". Two things deliver it and neither
# is a fade.
#
# TRIM. It has to cut somewhere for two separate reasons and the tighter of the
# two wins. The soft reason is the same one /privacy had: the shot keeps
# travelling, and a fifth of a frame is the most this design system has ever
# let a hero move. The hard reason is that at about four seconds the model
# invents a doorway in the left wall, which is a fact about the building that
# the estate has not published and this page may not either. 2.4 s is the
# figure /privacy and CONTACT both settled on, it holds the travel to 15.5%,
# and it stops a second and a half before the door.
#
# STRETCH. 15.5% over 2.4 s is 6.5% a second. setpts spreads the same travel
# over 3.84 s — 4.0% a second, against /privacy's 4.9%, WHICH MAKES THIS THE
# SLOWEST MOVE ON THE SITE — and minterpolate rebuilds the intermediate frames
# so the encode is a true 24 fps rather than 15 fps of duplicates. On a shot
# this slow the estimator has almost nothing to solve: the frames were checked
# at 1 s and 2 s and the shelves, the glazing of the gilt frame and the candle
# flames are clean.
#
# WHY THE TRIM IS AN INPUT OPTION AND NOT AN OUTPUT ONE. `-t` after `-i` limits
# the OUTPUT, so it truncates the palindrome instead of the source and the loop
# stops being a loop. Here it goes before `-i`, where it limits the decode, and
# the first and last frames of the encode are then the same frame — verified,
# see docs/TERMS.md §7.
# ---------------------------------------------------------------------------

SEQUENCE_TRIM = 2.4          # seconds of the master that are used
SEQUENCE_STRETCH = 1.6       # how much slower they are played

# NOTHING IS GRADED, AND IT IS THE SECOND SEQUENCE ON THIS SITE THAT NEEDED
# NOTHING. Every approved hero sits between 29 and 40 out of 255 at frame 0;
# /privacy measured 29.1 and this one measures 23.3, because the room was
# rendered by firelight rather than lit for a camera. It is the darkest first
# screen on the site and it got there without a curve.
SEQUENCE_GRADE = ''

# CRF rather than a bitrate — and this is the loosest hero on the site, which
# was measured rather than assumed and is the opposite of what the picture
# looks like it should need.
#
# IT IS THE MOST EXPENSIVE SHOT ON THIS SITE TO ENCODE, BECAUSE OF THE BOOKS.
# Nine bays of bookcase are a wall of fine high-contrast detail that changes a
# little in every frame as the camera moves, and a fire is the one light source
# that never repeats a frame. The film pages encode their heroes at 25/28 and
# /privacy measured its way to 27; at 27 this one is 1246 KB, which is more
# than a lightweight legal page should spend on the one thing on it that is
# decoration.
#
# Ladder measured at the trim and the stretch below, wide encode:
#
#     crf 25   1699 KB       crf 31    695 KB
#     crf 27   1246 KB       crf 33    536 KB
#     crf 29    922 KB
#
# 31 IS WHERE IT STOPS AND THE STOPPING RULE IS BANDING, NOT SIZE. Against the
# crf 25 encode, frame 45 differs by 2.60 out of 255 at crf 27, 2.95 at 29,
# 3.40 at 31 and 3.93 at 33 — a ladder that is climbing slowly enough to be
# noise rather than loss. The thing worth banding on a picture this dark is the
# fire, and the firebox holds 142 distinct luma values at crf 25, 139 at 31 and
# 143 at 33: the shot is dark, slow and soft, which is the case CRF was
# designed for. The two encodes were also put side by side at the book spines,
# the candle flames, the gilt ornament and the carved relief of the
# chimneypiece, which is where a loss would show first, and they are the same
# picture.
CRF_HERO = 31
CRF_NARROW = 33

# The wide encode is what a desktop gets; the narrow one is for below 900px,
# where a 1280-wide film is three times the bytes needed to fill a 390px screen.
HERO_WIDE = 1280
HERO_NARROW = 854


# ---------------------------------------------------------------------------
# 4. The loop is a palindrome
#
# The sequence is a single continuous camera move that never returns to where it
# started, so no frame in it matches its own first frame. A hard cut back to
# frame 0 jumps, and on a shot this slow a jump would be the only thing in it
# that moves quickly. A cross-dissolve is worse: dissolving a near framing into
# a far one ghosts nine bays of bookcase against themselves.
#
# So it plays forward and then backwards — seamless by construction, because the
# last frame of the reverse IS the first frame of the forward, and no two
# framings are ever blended. tools/motion/build_sequences.sh's filter, verbatim.
# ---------------------------------------------------------------------------

PALINDROME = ('[0:v]{pre}split[a][b];[b]reverse,trim=start_frame=1,'
              'setpts=PTS-STARTPTS[r];[a][r]concat=n=2:v=1[c]')

# What happens before the split: the stretch, and the frames that fill it in.
SLOW = ('setpts={stretch}*PTS,'
        'minterpolate=fps=24:mi_mode=mci:mc_mode=aobmc:me_mode=bidir:vsbmc=1,')


# ---------------------------------------------------------------------------
# 5. The machinery
#
# crop_box, export, prune, encode and poster are build_privacy_media.py's,
# unchanged. They are copied rather than imported for the reason every one of
# these scripts is standalone: a build script that a future reader has to follow
# across three files to find out what a crop was is one that stops being read.
# ---------------------------------------------------------------------------


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
    """Write <stem>-<width>.jpg and .webp for every width that is not an upscale."""
    out = os.path.join(IMG, os.path.dirname(stem))
    os.makedirs(out, exist_ok=True)

    written = []

    for width in sorted(widths):
        if width > image.width:
            continue                      # nothing is upscaled

        height = int(round(width * image.height / image.width))
        rung = image.resize((width, height), Image.LANCZOS)

        base = os.path.join(IMG, f'{stem}-{width}')
        rung.save(base + '.jpg', 'JPEG', quality=JPEG_Q, optimize=True, progressive=True)
        rung.save(base + '.webp', 'WEBP', quality=WEBP_Q, method=6)

        written.append(width)

    prune(stem, written)

    return written


def prune(stem, keep):
    """Remove rungs of this stem that this build did not write."""
    folder = os.path.join(IMG, os.path.dirname(stem))
    name = os.path.basename(stem)

    if not os.path.isdir(folder):
        return

    for entry in os.listdir(folder):
        if not entry.startswith(name + '-'):
            continue

        tail = entry[len(name) + 1:]
        digits, _, extension = tail.partition('.')

        if extension not in ('jpg', 'webp') or not digits.isdigit():
            continue

        if int(digits) not in keep:
            os.remove(os.path.join(folder, entry))
            print(f'    pruned {entry}')


def build_reference():
    """The 16:9 window on the visualisation the whole chain descends from."""
    print('\nREFERENCE\n' + '-' * 78)

    path = os.path.join(SRC, REFERENCE_SOURCE)

    if not os.path.isfile(path):
        print(f'  MISSING  {REFERENCE_SOURCE}')
        return

    os.makedirs(MOTION, exist_ok=True)
    out = os.path.join(MOTION, 'ref-library.png')

    with Image.open(path) as im:
        im = im.convert('RGB')
        cut = im.crop(crop_box(im.size, REFERENCE_RATIO, REFERENCE_BIAS))
        cut.save(out)

    print(f'  ref-library    {cut.width}x{cut.height}  <- {REFERENCE_SOURCE}')


def encode(ff, master, out, width, crf, extra_filter='', trim=None, stretch=None):
    """Slow, palindrome, scale, encode, no audio. `trim` cuts the INPUT first."""
    pre = SLOW.format(stretch=stretch) if stretch else ''
    chain = PALINDROME.format(pre=pre) + f';[c]scale={width}:-2:flags=lanczos'

    if extra_filter:
        chain += f',{extra_filter}'

    chain += ',format=yuv420p[v]'

    # BEFORE -i, so it limits the decode rather than the output. After -i it
    # would cut the palindrome in half and the loop would stop being one.
    trim_args = ['-t', str(trim)] if trim else []

    subprocess.run([
        ff, '-nostdin', '-y', '-loglevel', 'error', *trim_args, '-i', master,
        '-filter_complex', chain,
        '-map', '[v]', '-an',
        '-c:v', 'libx264', '-profile:v', 'high', '-preset', 'slow',
        '-crf', str(crf), '-g', '48', '-movflags', '+faststart',
        out,
    ], check=True)

    return os.path.getsize(out)


def poster(ff, encoded, stem, ratio, widths, frame_path):
    """Frame 0 of the encode the reader will actually see, exported as a plate."""
    subprocess.run([
        ff, '-nostdin', '-y', '-loglevel', 'error', '-i', encoded,
        '-vf', 'select=eq(n\\,0)', '-vframes', '1', frame_path,
    ], check=True)

    with Image.open(frame_path) as im:
        im = im.convert('RGB')
        cropped = im.crop(crop_box(im.size, ratio, 0.5))
        return export(cropped, stem, widths)


def build_sequence():
    ff = ffmpeg()
    os.makedirs(VID, exist_ok=True)
    os.makedirs(MOTION, exist_ok=True)
    print('\nSEQUENCE\n' + '-' * 78)

    master = os.path.join(MOTION, f'{SEQUENCE_NAME}.mp4')

    if not os.path.isfile(master):
        print(f'  MISSING  {master}')
        return

    wide = os.path.join(VID, f'{SEQUENCE_NAME}.mp4')
    small = os.path.join(VID, f'{SEQUENCE_NAME}-sm.mp4')

    wide_bytes = encode(ff, master, wide, HERO_WIDE, CRF_HERO,
                        SEQUENCE_GRADE, SEQUENCE_TRIM, SEQUENCE_STRETCH)
    small_bytes = encode(ff, master, small, HERO_NARROW, CRF_NARROW,
                         SEQUENCE_GRADE, SEQUENCE_TRIM, SEQUENCE_STRETCH)

    frame = os.path.join(MOTION, f'{SEQUENCE_NAME}-frame0.png')
    rungs = poster(ff, wide, f'terms/{SEQUENCE_NAME}',
                   SEQUENCE_RATIO, SEQUENCE_POSTER_WIDTHS, frame)

    print(f'  {SEQUENCE_NAME:<13} {wide_bytes // 1024:>5} KB  '
          f'+ {small_bytes // 1024} KB narrow  trimmed {SEQUENCE_TRIM}s  '
          f'slowed x{SEQUENCE_STRETCH}  poster {rungs}\n'
          f'  {"":<13} <- {SEQUENCE_SOURCE}')


if __name__ == '__main__':
    build_reference()
    build_sequence()
    print('\ndone.\n')
