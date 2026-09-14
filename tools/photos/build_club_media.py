"""
Build THE CLUB's media from media_src/ and the four Seedance 2.0 sequences.

WHAT THIS IS. /the-club declares its pictures by stem — club/room-drawing,
club/detail-chimney — and img() in app/helpers.php looks for
assets/img/<stem>-<width>.<ext>. This script is the mapping between the
material in media_src/ and those stems, and it is a script rather than a folder
of hand-cut exports for the same reason build_home_media.py and
build_estate_media.py are: every crop is a decision, and a decision has to be
re-readable and re-runnable.

THREE KINDS OF PICTURE COME OUT OF HERE AND THEY ARE THREE DIFFERENT CLAIMS.
THE CLUB is the first page on the site to carry all three at once, which is not
a lapse — it is the honest description of a members' club inside a house that is
standing but has not opened.

  PHOTOGRAPHS are crops of the supplied photography of this building. Nothing
  is added, nothing is invented, nothing is upscaled: a rung wider than the
  cropped source is skipped rather than interpolated. Declared 'photo'.

  VISUALISATIONS are crops of the project's own renders — the library, the
  private dining room, the terrace, the rooms with people in them. Declared
  'render', and every component prints "Visualisation" under them.

  POSTERS are frame 0 of a Seedance sequence. Two of the four descend directly
  from a render; two descend from a GPT Image 2 still that was itself made from
  a photograph of this house and changed nothing but the hour. Either way the
  output is synthesised, so all four are declared 'generated' and the
  components print "Generated image".

THE ELEVEN PHOTOGRAPHS THIS PAGE USES ARE THE ELEVEN THE ESTATE DOES NOT.
media_src/interiors/ grew from four files to fifteen after THE ESTATE was
built: interiors_5 to interiors_15 are eleven high-resolution photographs of
the restored interior that no page has ever shown. THE ESTATE is built from
interiors_1-4, grand-staircase/ and heritage-details/; THE CLUB is built from
the eleven. The two pages are the same house and share no frame.

THE POSTER IS THE SEQUENCE'S OWN FIRST FRAME, WHICH IS WHY THE FADE IS
INVISIBLE. A poster cut from the source instead would visibly re-frame the
moment the video faded up, because the two are not the same composition.

BIAS IS THE FRACTION OF THE SURPLUS TAKEN OFF THE TOP (or off the left, on a
frame too wide for its slot). 0.5 is a centre crop. Where a value is not 0.5
the reason is written beside it.

REGION IS THE ONE THING A BIAS CANNOT DO: a bias slides the crop along the axis
that has surplus, it cannot go INTO a photograph. Every frame of the detail
track declares (left, top, right, bottom) in source pixels, and the aspect crop
is taken from that instead. A REGION MAY NOT BE SMALLER THAN THE LADDER IT
FEEDS — nothing is upscaled here, so each of the six is cut at least 960 wide.

Run from anywhere:  python3 tools/photos/build_club_media.py
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

# The four sequences as they came back from Seedance, and the two GPT Image 2
# stills that two of them were made from.
#
# THE STILLS ARE COMMITTED AND THE .mp4 MASTERS ARE NOT, which is the
# repository's existing rule rather than a decision taken here: .gitignore
# carries /media_src/**/*.mp4 — the master stays on disk and in the backup, the
# encode under public_html/assets/video/ is the deliverable and that one is
# committed. So a fresh clone can rebuild every PLATE below, and rebuilding the
# SEQUENCES needs the masters restored to this directory first.
MOTION = os.path.join(SRC, 'MOTION', 'club')

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
# 1. The grade
#
# THE SUPPLIED PHOTOGRAPHS WERE TAKEN AT NOON AND THIS PAGE IS AN EVENING.
# Every one of the eleven interiors is a bright, even, documentary frame with
# daylight in the windows — which is exactly right for a record of a building
# and half a stop wrong on a near-black ground beside a Seedance interior lit by
# its own chandeliers. Dropped into the walk unaltered they do not read as the
# same house at the same hour; they read as a different photographer.
#
# So the pictures are taken down rather than the ground being brought up. The
# curve is the one build_estate_media.py uses on its hero, at the same strength
# and for a related reason: about eight percent off the highlights and five off
# the midtones, which is a grade rather than a re-lighting — the windows stay
# windows, the white marble stays white, and nothing in the frame changes shape.
#
# IT IS APPLIED TO PHOTOGRAPHS AND NOT TO RENDERS. The visualisations were made
# dark; grading them again would close them up. Which entries carry it is the
# last field of each row below.
# ---------------------------------------------------------------------------

GRADE = (0.475, 0.92)      # 0.5 -> 0.475 and 1.0 -> 0.92

# TWO FRAMES NEED MORE THAN THE OTHERS AND IT IS BECAUSE OF WHAT IS IN THEM.
# interiors_13 and interiors_11 are the two photographs with a full bay of
# untreated daylight in them — a window wall and an open door onto a lit room —
# and at the standard grade they still arrive a stop brighter than the frames
# either side. They are pulled further rather than everything being pulled with
# them; a curve strong enough for these two would have taken the fire out of
# the stove room.
DEEP = (0.435, 0.83)


def grade_lut(points):
    """A 256-entry curve through (0,0), (0.5, mid), (1, high)."""
    mid, high = points
    lut = []

    for i in range(256):
        x = i / 255.0

        if x <= 0.5:
            y = x / 0.5 * mid
        else:
            y = mid + (x - 0.5) / 0.5 * (high - mid)

        lut.append(max(0, min(255, int(round(y * 255)))))

    return lut * 3          # one channel each for R, G and B


# ---------------------------------------------------------------------------
# 2. The plates
#
#   stem : (source, ratio, widths, bias, graded, why)
#   stem : (source, ratio, widths, bias, graded, why, region)
# ---------------------------------------------------------------------------

PLATES = {

    # -- Scene 02: the house, one room leading to the next -------------------

    'club/house-enfilade': (
        'interiors/interiors_11.png', (16, 9), [768, 1152], 0.25, DEEP,
        'High. The subject is the two open doors and the room showing through '
        'the right one — a house being walked through — and the glazed stove '
        'portal between them wants its carved crown kept.'),

    # -- Scene 03: the rooms, one screen each -------------------------------
    #
    # 16:9 out of a 1.34 photograph takes a quarter of the height off, and
    # where that quarter comes from is the whole decision: the station is a
    # full-bleed screen, so what it wants is the widest band of the room.

    'club/room-drawing': (
        'interiors/interiors_15.png', (16, 9), [768, 1152], 0.20, True,
        'High, because the chandelier is at the top of the frame and the gilt '
        'settee and chairs are at the bottom of it, and this is the one room '
        'in the house photographed with its own furniture in it.'),

    'club/room-library': (
        'HOUSE_OF_DIALOGUE/2.png', (16, 9), [768, 1152], 0.35, False,
        'A little above centre: the portrait over the chimneypiece is the top '
        'of the composition and the low table is the bottom, and a centred '
        'band would trade the portrait for carpet.'),

    'club/room-dining': (
        'RESTAURANT/private_dining_room.png', (16, 9), [768, 1152], 0.38, False,
        'The long table and the fire behind it in one band. Slightly high, so '
        'the panelling and the picture over the chimneypiece stay in.'),

    'club/room-lounge': (
        'interiors/interiors_13.png', (16, 9), [768, 1152], 0.32, DEEP,
        'Holds the bay window, the fitted banquette under it and the oval '
        'table — the whole of what makes this a room to sit in rather than a '
        'room to pass through.'),

    'club/room-fire': (
        'interiors/interiors_12.png', (16, 9), [768, 1152], 0.45, True,
        'Centred on the stove rather than on the room: its moulded crown at '
        'the top of the band and its firebox at the bottom.'),

    # -- Scene 04: the detail track -----------------------------------------
    #
    # Six 3:4 frames, each one INTO a photograph rather than across it, and
    # each cut at least 960 wide so both rungs are real exports.

    'club/detail-chimney': (
        'interiors/interiors_5.png', (3, 4), [640, 960], 0.50, True,
        'The white marble chimneypiece, the mirror over it with the staircase '
        'in it, and the sconces either side. The one place in the house where '
        'you can see two rooms at once.',
        (810, 349, 1791, 1657)),

    'club/detail-ceiling': (
        'interiors/interiors_14.png', (3, 4), [640, 960], 0.50, True,
        'The plaster relief of the ceiling and the chandelier on its rose. '
        'Taken looking up, which is the only way this one exists.',
        (654, 87, 1682, 1395)),

    'club/detail-carving': (
        'interiors/interiors_7.png', (3, 4), [640, 960], 0.50, True,
        'The carved oriel bay over the hall, under the coffers. The relief on '
        'its apron is hand-cut and it is the reason this frame is portrait.',
        (327, 0, 1448, 1494)),

    'club/detail-portal': (
        'interiors/interiors_11.png', (3, 4), [640, 960], 0.50, True,
        'The glazed stove portal: fluted pilasters, a carved crown, and the '
        'arched niche between them. A different picture from the same negative '
        'as club/house-enfilade — that one is the room, this is the thing in '
        'it.',
        (758, 0, 1718, 1280)),

    'club/detail-glass': (
        'interiors/interiors_6.png', (3, 4), [640, 960], 0.50, True,
        'The glazed doors of the hall and the transom over them, which is the '
        'largest run of leaded joinery in the building.',
        (280, 300, 1307, 1669)),

    'club/detail-stair': (
        'interiors/interiors_10.png', (3, 4), [640, 960], 0.20, True,
        'The stair from above: the turned balusters, the winder treads and the '
        'tall leaded window over them. High, because the window is the light '
        'in this frame and the treads are only the floor.',
        (1051, 140, 2219, 1744)),

    # -- Scene 07: the dialogue ---------------------------------------------

    'club/dialogue-capital': (
        'RESTAURANT/grand_dining_room.png', (16, 9), [768, 1152], 0.30, DEEP,
        'The chandelier and the length of the room, which is what makes a '
        'table a place where something is decided rather than eaten. THE ONE '
        'VISUALISATION ON THE PAGE THAT IS GRADED: the dialogue stands four '
        'lines of cream type over these four pictures, and this is the only one '
        'of them lit like a ballroom. At its own exposure the type crosses a '
        'chandelier.'),

    'club/dialogue-social': (
        'CIGAR_HOUSE/outdoor_terrace.png', (16, 9), [768, 1152], 0.50, False,
        'Already 1.69 wide, so almost nothing comes off. The lit terrace, the '
        'seating in groups, and the house behind it.'),

    'club/dialogue-diplomacy': (
        'HOUSE_OF_DIALOGUE/1.png', (16, 9), [768, 1152], 0.50, False,
        'Two to one already; only width comes off, and centred, because the '
        'conversations are spread the whole length of the hall.'),

    'club/dialogue-culture': (
        'HOUSE_OF_DIALOGUE/3.png', (16, 9), [768, 1152], 0.32, False,
        'A square source and the band is taken high: the portraits up the '
        'stairwell wall are the subject, and the treads are not.'),

    # -- Scene 08: the people -----------------------------------------------
    #
    # Three frames and not one face. See content/en/club.php.

    'club/people-arrival': (
        'PRIVATE_CLUB_ECOSYSTEM/5.png', (4, 5), [640, 960, 1280], 0.50, False,
        'A gloved hand on the door of a car, and nothing else in focus. '
        'Portrait, because the gesture is vertical.'),

    'club/people-room': (
        'PRIVATE_CLUB_ECOSYSTEM/4.png', (3, 2), [640, 960, 1280], 0.50, False,
        'A 1.51 source into a 1.5 slot: nothing is cropped. Four people at a '
        'distance, none of them looking at the camera.'),

    'club/people-bar': (
        'CIGAR_HOUSE/main_bar.png', (3, 2), [640, 960, 1280], 0.50, False,
        'The long bar and one figure behind it. The best bar frame in the '
        'library and the first page to use it.'),
}


# ---------------------------------------------------------------------------
# 3. The sequences
#
#   name : (ratio, poster widths, narrow encode?, source, motion)
#
# 'source' is the media_src reference the sequence descends from. Two of them
# descend through a GPT Image 2 still: the still was made FROM the photograph
# named here and changed the hour and nothing else, and the sequence was made
# from the still. Both stills are in media_src/MOTION/club/ and both prompts
# are in docs/THE_CLUB.md §3.
# ---------------------------------------------------------------------------

# THE PROMPTS, VERBATIM, because a prompt is the only part of a generated asset
# that cannot be recovered by looking at it. Every one is written as a
# PRESERVATION instruction rather than a description: it names the architecture,
# the joinery and the materials of that specific frame, states the one thing that
# may change, lists the motion that is allowed, and then says what may not
# appear. The negative half is the half that does the work. Same shape as
# tools/motion/build_sequences.sh, which is where the Main Page's six live.
#
# ---- GPT Image 2, 2K, high, 16:9, from a reference ------------------------
#
# still-threshold  <- interiors/interiors_6.png
#   "Preserve this exact manor entrance hall precisely and change only the time
#    of day. Keep every architectural element exactly as photographed: the tall
#    glazed timber double doors at the centre with their small leaded panes and
#    the wooden staircase visible through the glass behind them, the tall
#    multi-pane windows at the left, the dark walnut dado panelling, the deep red
#    patterned damask wallpaper above it, the black and white chequered marble
#    floor, the white marble chimneypiece, the built-in wooden bench, the brass
#    candle chandelier and the wall sconces, the moulded ceiling and its beams.
#    Change only the light: it is now late evening. Beyond the windows the park
#    is dark blue night. The chandelier, the sconces and the lamps beyond the
#    glazed doors are lit, warm amber, and their light falls across the polished
#    marble floor and the panelling. Deep shadow in the corners, warm pools of
#    light, the lit staircase glowing through the glass of the doors. No people.
#    No signage, lettering, plaques or logos anywhere. No new doors, windows,
#    furniture or architectural elements. No redesign of the room. Restrained
#    heritage interior photography, natural warm practical lighting, quiet and
#    unstaged, no lens flare."
#
# still-great-hall  <- interiors/interiors_5.png
#   "Preserve this exact manor hall precisely and change only the time of day.
#    Keep every element exactly as photographed: the white marble chimneypiece at
#    the centre with the large rectangular mirror above it reflecting the wooden
#    staircase, the pair of brass wall sconces either side of the mirror, the
#    gilt-brass candle chandelier hanging at the upper left, the deep red damask
#    wallpaper, the dark walnut dado panelling and the panelled overmantel bay
#    above it, the black and white chequered marble floor, the built-in wooden
#    bench at the left, the glazed door at the far left, the open doorway at the
#    right with the corridor beyond it. Change only the light: it is now late
#    evening. The windows at the left are dark blue night. The chandelier, both
#    sconces and the light in the corridor beyond the open door are lit, warm
#    amber. A low fire burns in the marble fireplace and its light reaches a
#    little way across the chequered floor. Deep shadow in the upper corners. No
#    people. No signage, lettering, plaques or logos. No new furniture, doors,
#    windows or architectural elements. No redesign of the room. Restrained
#    heritage interior photography, warm practical lighting, quiet and unstaged,
#    no lens flare."
#
#   THE FIRE IS THE ONE ADDITION ON THIS PAGE AND IT IS NAMED HERE. The hearth in
#   interiors_5 is empty and cold. It is a fire in a fireplace that exists, in
#   the position that fireplace is in, and everything downstream of this still
#   carries "Generated image" for exactly this class of reason.
#
# ---- Seedance 2.0, 720p, 16:9, 5s, no audio ------------------------------
#
# club-arrival  <- still-threshold
#   "Extremely slow cinematic dolly forward across this exact manor entrance
#    hall toward the glazed timber doors at the centre. Preserve the architecture
#    exactly as it is: the tall glazed double doors and their small leaded panes,
#    the panelled overdoor bay above them, the wooden staircase at the left with
#    its turned balusters, the tall multi-pane windows showing dark blue night
#    beyond, the deep red damask wallpaper, the dark walnut dado panelling, the
#    built-in wooden bench, the black and white chequered marble floor, the brass
#    candle chandelier, the wall sconce, the white marble chimneypiece and its
#    mirror at the right. The only motion: a very gradual forward drift of the
#    camera over the chequered floor toward the doors, gentle parallax between
#    the foreground and the doorway, candle flames in the chandelier and the
#    sconce breathing almost imperceptibly, warm lamplight from beyond the glass
#    shifting very slightly, soft reflections travelling on the polished marble
#    and the panelling. No people. No doors opening or closing. No new furniture,
#    windows, doors or architectural elements. No redesign of the room. No
#    signage or lettering. Restrained heritage cinematography, warm practical
#    light against a cold night window, one continuous locked-off shot, no cuts,
#    no camera shake, no zoom snap, no lens flare."
#
# club-hall  <- still-great-hall
#   "Very slow cinematic push forward through this exact manor hall toward the
#    marble chimneypiece. Preserve the room exactly: the white marble
#    chimneypiece and the rectangular mirror above it reflecting the wooden
#    staircase, the two brass wall sconces either side of the mirror, the
#    gilt-brass candle chandelier at the upper left, the deep red damask
#    wallpaper, the dark walnut dado panelling and the panelled bay above, the
#    black and white chequered marble floor, the built-in bench at the left, the
#    glazed door at the far left, the open doorway at the right with the lit
#    corridor beyond it. The only motion: the fire in the marble fireplace
#    burning naturally and its warm glow moving realistically across the
#    chequered floor and the panelling, the candle flames of the chandelier and
#    the sconces breathing very gently, a barely perceptible forward drift of the
#    camera with subtle parallax between the foreground floor and the far wall.
#    No people. No new furniture, doors, windows or architectural elements. No
#    redesign of the room. No signage or lettering. Quiet private heritage
#    interior, warm amber practical lighting, one continuous shot, no cuts, no
#    camera shake, no lens flare."
#
# club-dining  <- RESTAURANT/dining_salon.png
#   "Slow continuous dolly forward through this exact manor dining salon.
#    Preserve the room precisely: the crystal chandelier, the carved wood
#    panelling, the oil portraits in their gilt frames, the candle sconces on the
#    walls, the round tables with white linen and crystal glassware, the dark
#    leather dining chairs, the herringbone parquet floor, the tall curtained
#    window at the far end. The only motion: candle flames flickering naturally
#    on the tables and in the sconces, the chandelier's light breathing very
#    softly, warm reflections travelling slowly across polished glass and wood,
#    an almost imperceptible forward drift of the camera with gentle parallax
#    between the foreground table and the far wall. No people. No new tables,
#    chairs, doors, windows or objects. No redesign of the interior. Refined
#    European manor atmosphere, restrained movement, realistic cinematography,
#    one continuous shot, no cuts, no camera shake, no zoom snap, no lens flare."
#
# club-members  <- CIGAR_HOUSE/vip_room.png
#   "Very slow cinematic push forward through this exact private members' room.
#    Preserve the room exactly: the dark timber wall panelling, the oil portraits
#    in their gilt frames, the buttoned leather armchairs and sofa, the low round
#    table with its glasses, the small brass chandelier, the shaded floor lamps
#    and wall sconces, the fireplace at the far end with the portrait above it,
#    the patterned rug. The only motion: firelight flickering in the hearth and
#    its warm glow moving realistically across dark wood and leather, lamp light
#    breathing very gently, a barely perceptible forward drift of the camera with
#    subtle parallax between the foreground armchair and the far wall. No people.
#    No new furniture, doors, windows or objects. No redesign of the room. Warm
#    amber practical lighting, private and discreet, restrained, realistic
#    materials, one continuous shot, no cuts, no camera shake, no lens flare."

SEQUENCES = {
    'club-arrival': (
        (16, 9), [768, 1280], True,
        'interiors/interiors_6.png -> GPT Image 2 evening still -> Seedance 2.0',
        'Slow dolly across the hall toward the glazed doors.'),

    'club-hall': (
        (16, 9), [768, 1152], False,
        'interiors/interiors_5.png -> GPT Image 2 evening still -> Seedance 2.0',
        'Slow push toward the chimneypiece, the fire alight.'),

    'club-dining': (
        (16, 9), [768, 1152], False,
        'RESTAURANT/dining_salon.png -> Seedance 2.0',
        'Slow dolly through the dining salon, candle flames moving.'),

    'club-members': (
        (16, 9), [768, 1152], False,
        'CIGAR_HOUSE/vip_room.png -> Seedance 2.0',
        'Very slow push toward the hearth, firelight on leather.'),
}

# CRF 29 ON THE HERO IS A MEASURED CHOICE and it is the Main Page's own: at 26
# this shot is 2.5 MB and at 29 it is 1.3, and on the two places H.264 gives up
# first here — the night window and the damask — the pair are indistinguishable
# at 100%. The three section films stay at 27, where they are attached one at a
# time and the reader is already inside the page.
CRF_WIDE = 27
CRF_HERO = 29
CRF_NARROW = 30

# ---------------------------------------------------------------------------
# 4. The loop is a palindrome, and that is not a shortcut
#
# Every one of the four is a single continuous camera move that never returns
# to where it started, so no frame anywhere matches its own first frame. A hard
# cut back to frame 0 jumps, and on a shot this slow a jump is the only thing
# in it that moves quickly. A cross-dissolve is worse: dissolving a near
# framing into a far one ghosts the room against itself, and on the dining
# sequence that means two chandeliers.
#
# So each one plays forward and then backwards — seamless by construction,
# because the last frame of the reverse IS the first frame of the forward, and
# no two framings are ever blended. On a shot this slow the direction change
# reads as the camera settling rather than as a reversal.
#
# The reverse drops its own first frame so the turn does not hold one frame
# twice. This is tools/motion/build_sequences.sh's filter, verbatim, because it
# is the Main Page's answer to the same problem and there is no reason for two.
# ---------------------------------------------------------------------------

PALINDROME = ('[0:v]split[a][b];[b]reverse,trim=start_frame=1,'
              'setpts=PTS-STARTPTS[r];[a][r]concat=n=2:v=1[c]')


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
    print('\nPLATES\n' + '-' * 78)

    for stem, entry in PLATES.items():
        source, ratio, widths, bias, graded, _why = entry[:6]
        region = entry[6] if len(entry) > 6 else None
        path = os.path.join(SRC, source)

        if not os.path.isfile(path):
            print(f'  MISSING  {source}')
            continue

        with Image.open(path) as im:
            im = im.convert('RGB')

            if region is not None:
                im = im.crop(region)

            cropped = im.crop(crop_box(im.size, ratio, bias))

            if graded:
                cropped = cropped.point(
                    grade_lut(GRADE if graded is True else graded))

            rungs = export(cropped, stem, widths)

            if not rungs:
                print(f'  NO RUNGS {stem}: crop is {cropped.width}px, '
                      f'ladder starts at {min(widths)}')

        print(f'  {stem:<26} <- {source:<44} '
              f'{cropped.width}x{cropped.height}{"  graded" if graded else "":9} {rungs}')


def build_sequences():
    ff = ffmpeg()
    os.makedirs(VID, exist_ok=True)
    print('\nSEQUENCES — encodes and posters\n' + '-' * 78)

    for name, (ratio, widths, narrow, source, _motion) in SEQUENCES.items():
        master = os.path.join(MOTION, f'{name}.mp4')

        if not os.path.isfile(master):
            print(f'  MISSING  {master}')
            continue

        crf = CRF_HERO if narrow else CRF_WIDE
        width = 1280 if narrow else 1152

        # -- the wide encode ------------------------------------------------
        wide = os.path.join(VID, f'{name}.mp4')
        subprocess.run([
            ff, '-nostdin', '-y', '-loglevel', 'error', '-i', master,
            '-filter_complex',
            f'{PALINDROME};[c]scale={width}:-2:flags=lanczos,format=yuv420p[v]',
            '-map', '[v]', '-an',
            '-c:v', 'libx264', '-profile:v', 'high', '-preset', 'slow',
            '-crf', str(crf), '-g', '48', '-movflags', '+faststart',
            wide,
        ], check=True)

        line = f'  {name:<14} {os.path.getsize(wide) // 1024:>5} KB'

        # -- the narrow encode, where one is wanted --------------------------
        #
        # The hero is the only sequence a reader meets before they have decided
        # to stay, so it gets a second encode at 854: a third of the bytes for a
        # screen a third of the width, chosen against the VIEWPORT rather than
        # the device. The three section films are attached one at a time as the
        # reader reaches them, so a second encode of each would be three files
        # to save bytes nobody was going to spend.
        if narrow:
            small = os.path.join(VID, f'{name}-sm.mp4')
            subprocess.run([
                ff, '-nostdin', '-y', '-loglevel', 'error', '-i', master,
                '-filter_complex',
                f'{PALINDROME};[c]scale=854:-2:flags=lanczos,format=yuv420p[v]',
                '-map', '[v]', '-an',
                '-c:v', 'libx264', '-profile:v', 'high', '-preset', 'slow',
                '-crf', str(CRF_NARROW), '-g', '48', '-movflags', '+faststart',
                small,
            ], check=True)
            line += f'  + {os.path.getsize(small) // 1024} KB narrow'

        # -- the poster: frame 0 of the encode the reader will actually see --
        frame = os.path.join(MOTION, f'{name}-frame0.png')
        subprocess.run([
            ff, '-nostdin', '-y', '-loglevel', 'error', '-i', wide,
            '-vf', 'select=eq(n\\,0)', '-vframes', '1', frame,
        ], check=True)

        with Image.open(frame) as im:
            im = im.convert('RGB')
            cropped = im.crop(crop_box(im.size, ratio, 0.5))
            rungs = export(cropped, f'club/{name}', widths)

        print(f'{line}  poster {rungs}  <- {source}')


if __name__ == '__main__':
    build_plates()
    build_sequences()
    print('\ndone.\n')
