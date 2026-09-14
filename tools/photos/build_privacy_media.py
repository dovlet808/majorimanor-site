#!/usr/bin/env python3
"""
Majori Manor — /privacy media.

ONE PICTURE. It is the smallest media build on this site by a wide margin:
CONTACT, the page that held the record, cut three plates and one sequence;
this cuts none and one. A privacy policy is a document, and a document with
five photographs in it is a brochure with clauses.

    ref-doors.png     16:9 out of media_src/heritage-details/heritage_1.jpg
        |             1611x906, centred — the same file and the same centre
        |             THE ESTATE cuts for its walk-doors plate
        v
    still-doors.png   GPT Image 2, 2K, high, 16:9, from that reference
        |             2688x1520. The hour changed and the house did not
        v
    pri-doors.mp4     Seedance 2.0, 720p, std, 16:9, 5 s, no audio,
        |             start_image = the still. 1280x720, 24 fps
        v
    assets/video/pri-doors.mp4      1280 wide, the hero
    assets/video/pri-doors-sm.mp4    854 wide, below 900px
    assets/img/privacy/pri-doors-{768,1280}.{jpg,webp}   frame 0 of the encode

WHY THIS FRAME AND NOT A FACADE. The brief asked for something calm that says
privacy, discretion, trust and quiet, and offered a manor exterior, a reception,
a corridor, dark wood or the estate at dusk. `heritage_1.jpg` is the only frame
in the library that is all of those at once and is also, literally, the subject:
a tall glazed mahogany screen with one leaf standing open. Dark wood and clear
glass. You can see through it. THE SAME MAJORI MANOR, WITH THE DOORS OPEN.

IT IS NOT AN APPROVED PAGE'S HERO. THE ESTATE uses this photograph twice — as
`walk-doors`, one of seven stills in a scroll-driven gallery, and as
`detail-fittings`, a 3:4 crop of the brass — both in flat summer daylight, and
neither of them a first screen. What this page shows is the same joinery at
first light, moving. Same negative, different photograph.

Run from anywhere:  python3 tools/photos/build_privacy_media.py
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

# The sequence as it came back from Seedance, the GPT Image 2 still it was made
# from, and the crop that still was made from.
#
# THE STILLS ARE COMMITTED AND THE .mp4 MASTER IS NOT — .gitignore carries
# /media_src/**/*.mp4. The master stays on disk and in the backup; the encode
# under public_html/assets/video/ is the deliverable and that one is committed.
MOTION = os.path.join(SRC, 'MOTION', 'privacy')

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
# The one thing in this file that starts from a photograph rather than from a
# generation. It is written out so that a fresh clone can rebuild the whole
# chain from media_src/heritage-details/heritage_1.jpg and nothing else.
# ---------------------------------------------------------------------------

REFERENCE_SOURCE = 'heritage-details/heritage_1.jpg'
REFERENCE_RATIO = (16, 9)

# Centred, which is THE ESTATE's own bias for this file: the open leaf and the
# room showing through it are both mid-frame, and the photograph is already
# 1.92 wide, so a 16:9 window takes 62px off each side and nothing else.
REFERENCE_BIAS = 0.50


# ---------------------------------------------------------------------------
# 2. The prompts, verbatim
#
# A prompt is the only part of a generated asset that cannot be recovered by
# looking at it. Both below are written as a PRESERVATION instruction rather
# than a description — each names the architecture, the joinery and the
# materials of that specific frame, states the one thing that may change, lists
# the motion that is allowed, and then says what may not appear. The negative
# half is the half that does the work. Same shape as build_contact_media.py.
#
# ---- GPT Image 2, 2K, high, 16:9, from a reference -------------------------
#
# still-doors  <- ref-doors
#   "Preserve this exact interior precisely and change only the hour and the
#    light. Keep every structural element exactly as photographed and in exactly
#    the same position, proportion and perspective: the tall dark-stained
#    mahogany glazed screen that fills the centre of the frame, made of many
#    small rectangular panes of clear glass in slender moulded timber glazing
#    bars, with its plain moulded cornice and its solid panelled lower section;
#    the pair of tall glazed doors at the centre of that screen with the
#    right-hand leaf standing open at the same angle into the room beyond and
#    the other leaf closed; the long brass espagnolette bolt with its lever
#    handle running the full height of the closed leaf, and the brass butt
#    hinges on the edge of the open leaf; the glazed overpanels above the screen
#    and the segmental-arched head of the doorway seen through them; the flat
#    panelled mahogany wall panel at the left of the screen; the plain pale
#    cream plastered wall at the left with the tall multi-pane casement window
#    in its dark timber surround and the green foliage of the trees outside it;
#    the dark timber balustrade at the lower left with its turned balusters, its
#    heavy moulded handrail and its round newel cap; the dark timber panelled
#    dado with the lozenge panel at the right edge of the frame; the timber
#    floor visible through the open doorway; the exact camera position, lens,
#    height and framing. Change the light: it is now very early morning, before
#    the house is open. The rooms are lit only by the daylight coming through
#    the windows, which is low, cool and quiet; the corridor itself is in soft
#    shadow and reads distinctly darker than in the reference. The mahogany goes
#    deep brown and almost black where it is not lit, the cream wall holds a
#    soft grey-blue cast, the glass of the screen reads dark with faint
#    reflections, and one narrow band of warm low sunlight falls across the
#    glazing bars and the floor near the open leaf. The foliage outside the
#    window is cool and slightly misty. No new architecture. No new doors,
#    windows, panels, mouldings, glazing bars, staircases, railings or arches.
#    No new furniture, rugs, curtains, plants, pictures, mirrors, lamps or light
#    fittings of any kind. No people. No signage, lettering or numbers. No
#    redesign of the glazed screen, the doors, the ironmongery, the balustrade,
#    the window or the dado. The open leaf stays open at exactly the same angle.
#    Restrained European private-estate architectural interior photography,
#    natural window light only, natural colour, unstaged, no lens flare, no HDR,
#    no vignette."
#
#   THE HOUR CHANGED AND THE JOINERY DID NOT. Every noun the prompt keeps is a
#   noun in heritage_1.jpg: the same screen, the same glazing bars, the same
#   open leaf at the same angle, the same two espagnolette bolts, the same brass
#   hinges, the same segmental arch, the same casement window, the same turned
#   balusters and round newel caps, the same lozenge panel at the right. What
#   the library does not contain is this joinery at any hour but noon.
#
#   WHAT THE MODEL CHANGED, STATED RATHER THAN HIDDEN: the framing opened very
#   slightly — a little more of the balustrade and of the wall at the left are
#   in shot than in the reference — and the cream wall reads cool grey rather
#   than cream, which is the light the prompt asked for rather than a repaint.
#   Recorded in docs/PRIVACY.md §8.
#
# ---- Seedance 2.0, 720p, std, 16:9, 5 s, no audio, start_image ------------
#
# START_IMAGE AND NOT omni_reference, WHICH IS THE RULE build_events_media.py
# SET AND FIVE PAGES HAVE KEPT. The brief for this page asked for
# mode: omni_reference; start_image is what it is built on instead, and the
# reason is the brief's own instruction two paragraphs above it — "Preserve:
# manor architecture, materials, windows, woodwork, doors, landscape,
# proportions, Majori Manor identity". A reference is a mood and a start frame
# is a contract: it is the only setting under which a hundred-odd glazing bars,
# two brass bolts and a segmental arch survive five seconds of camera movement
# intact. It is also what makes the poster honest — frame 0 of the encode is
# what a reader sees before the video plays, so the still and the film cannot
# re-frame against each other when the video fades up.
#
# pri-doors  <- still-doors
#   "Extremely slow cinematic push forward through this exact quiet manor
#    interior at first light, toward the tall mahogany glazed screen and the
#    single door leaf standing open into the room beyond. Preserve everything
#    exactly as photographed: the dark-stained mahogany glazed screen of many
#    small clear panes in slender moulded glazing bars with its moulded cornice;
#    the pair of tall glazed doors with the one leaf standing open at exactly
#    the same angle and the other closed; the long brass espagnolette bolts and
#    the brass hinges; the glazed overpanels and the segmental-arched head of
#    the doorway seen through them; the pale plastered wall at the left with its
#    tall multi-pane casement window and the trees outside it; the dark timber
#    balustrade at the lower left with its turned balusters, moulded handrail
#    and round newel caps; the panelled dado with the lozenge panel at the
#    right; the timber floor through the open doorway with the narrow band of
#    low warm morning light lying across it. The only motion: the camera drifts
#    forward extremely slowly and perfectly level, so the doorway opens very
#    slightly and the near glazing bars pass a little wider in the frame, with
#    gentle parallax between the screen in the foreground and the room behind
#    it; the leaves of the trees beyond the far windows stir faintly; the
#    daylight in the windows and the band of light on the floor brighten almost
#    imperceptibly and otherwise stay steady. No people. No people entering or
#    crossing the frame. No door opening or closing further. No new
#    architecture, doors, windows, panels, glazing bars, railings, arches or
#    mouldings. No new furniture, rugs, curtains, plants, pictures, mirrors,
#    lamps or light fittings. No signage or lettering. Restrained European
#    private-estate architectural cinematography, natural window light only, one
#    continuous shot, no cuts, no camera shake, no zoom snap, no lens flare."
#
#   NOTHING WAS ADDED AND NOTHING WAS REDESIGNED. Frame by frame the screen,
#   the open leaf, the bolts, the hinges, the arch, the balustrade, the newel
#   caps, the casement and the lozenge panel are all where the still put them.
#   The one thing the model did on its own is accelerate: measured against
#   frame 0 the shot grows 1.05x by one second, 1.15x by two and 1.26x by
#   three, and by five it is standing against the glass. See TRIM below.

SEQUENCE_NAME = 'pri-doors'
SEQUENCE_RATIO = (16, 9)
SEQUENCE_POSTER_WIDTHS = [768, 1280]
SEQUENCE_SOURCE = ('heritage-details/heritage_1.jpg -> 16:9 crop -> '
                   'GPT Image 2 first-light still -> Seedance 2.0')


# ---------------------------------------------------------------------------
# 3. The trim, the stretch, and why this hero is slower than every other one
#
# THE BRIEF ASKED FOR MOTION THAT IS "NEARLY IMPERCEPTIBLE" and for "a still
# architectural photograph that is quietly alive", which is a slower instruction
# than any of the eight sequences before it were given. Two things deliver it
# and neither is a fade.
#
# TRIM. The master accelerates — 1.05x at one second, 1.26x at three, 1.59x by
# the end — so the last two seconds are a camera walking into a door, which is
# an arrival and not a breath. Cut at 2.4 s the shot grows by about a fifth,
# which is the figure CONTACT's hero settled on and the most this design system
# has ever let a hero move.
#
# STRETCH. A fifth over 2.4 s is 7.9% a second, which is the rate of a marketing
# hero. setpts spreads the same travel over 3.84 s — 4.9% a second, the gentlest
# move on the site — and minterpolate rebuilds the intermediate frames so the
# encode is a true 24 fps rather than 15 fps of duplicates. On a shot this slow
# the estimator has almost nothing to solve: the frames were checked at 1 s and
# 2 s and the glazing bars, the balusters and the arch are clean.
#
# WHY THE TRIM IS AN INPUT OPTION AND NOT AN OUTPUT ONE. `-t` after `-i` limits
# the OUTPUT, so it truncates the palindrome instead of the source and the loop
# stops being a loop. Here it goes before `-i`, where it limits the decode, and
# the first and last frames of the encode are then the same frame — verified,
# see docs/PRIVACY.md §7.
# ---------------------------------------------------------------------------

SEQUENCE_TRIM = 2.4          # seconds of the master that are used
SEQUENCE_STRETCH = 1.6       # how much slower they are played

# NOTHING IS GRADED, AND IT IS THE FIRST SEQUENCE ON THIS SITE THAT NEEDED
# NOTHING. Every approved hero sits between 29 and 40 out of 255 at frame 0 and
# this master measures 29.1, because the still was generated dark rather than
# generated bright and pulled down afterwards. A curve here would be a curve
# applied for the sake of having one.
SEQUENCE_GRADE = ''

# CRF rather than a bitrate: this is a very slow shot of still joinery in low
# light and it compresses nothing like a room with a fire in it.
#
# TWO STOPS LOOSER THAN THE OTHER HEROES, AND IT IS MEASURED RATHER THAN GUESSED.
# The film pages encode their heroes at 25/28. At 25 this one is 991 KB, which is
# a third of a lightweight page spent on the one thing on it that is decoration;
# at 27 it is 748 KB. Frame for frame the two differ by 1.65 out of 255 on
# average and the dark door panel holds the same 183 distinct luma values in
# both, so there is no banding to buy back — the shot is dark, slow and almost
# static, which is the case CRF was designed for.
CRF_HERO = 27
CRF_NARROW = 29

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
# a far one ghosts the joinery against itself.
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
# crop_box, export, prune, encode and poster are build_contact_media.py's,
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
    """The 16:9 window on the photograph the whole chain descends from."""
    print('\nREFERENCE\n' + '-' * 78)

    path = os.path.join(SRC, REFERENCE_SOURCE)

    if not os.path.isfile(path):
        print(f'  MISSING  {REFERENCE_SOURCE}')
        return

    os.makedirs(MOTION, exist_ok=True)
    out = os.path.join(MOTION, 'ref-doors.png')

    with Image.open(path) as im:
        im = im.convert('RGB')
        cut = im.crop(crop_box(im.size, REFERENCE_RATIO, REFERENCE_BIAS))
        cut.save(out)

    print(f'  ref-doors      {cut.width}x{cut.height}  <- {REFERENCE_SOURCE}')


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
    rungs = poster(ff, wide, f'privacy/{SEQUENCE_NAME}',
                   SEQUENCE_RATIO, SEQUENCE_POSTER_WIDTHS, frame)

    print(f'  {SEQUENCE_NAME:<13} {wide_bytes // 1024:>5} KB  '
          f'+ {small_bytes // 1024} KB narrow  trimmed {SEQUENCE_TRIM}s  '
          f'slowed x{SEQUENCE_STRETCH}  poster {rungs}\n'
          f'  {"":<13} <- {SEQUENCE_SOURCE}')


if __name__ == '__main__':
    build_reference()
    build_sequence()
    print('\ndone.\n')
