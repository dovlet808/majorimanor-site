"""
Build CONTACT's media from media_src/, one GPT Image 2 still and one Seedance
2.0 sequence.

WHAT THIS IS. /contact declares its pictures by stem — contact/con-arrival,
contact/con-gate — and img() in app/helpers.php looks for
assets/img/<stem>-<width>.<ext>. This script is the mapping between the material
in media_src/ and those stems, and it is a script rather than a folder of
hand-cut exports for the reason the seven build scripts before it are: every
crop is a decision, and a decision has to be re-readable and re-runnable.

THE EIGHTH FILM PAGE, AND THE SMALLEST BY A LONG WAY. THE ESTATE ships six
sequences, AFTER DARK five and fifteen plates; this page ships ONE sequence and
TWO plates, and the brief is the reason: /contact is the threshold and not
another cinematic story page. Everything here had to earn its place against the
question "does the reader need to see this in order to write to us", and three
pictures is what survived it.

ONE SEQUENCE, AND IT IS THE ONE THE PAGE IS NAMED AFTER. con-arrival is the
last few metres of the approach — the lit portico of the real house, at dusk,
with the front door under it — and it is generated because no such frame exists:
the library holds this facade in flat daylight (estate_2.jpg) and nowhere else.

IT IS NOT est-arrival AND IT IS NOT est-park, WHICH IS THE FIRST THING TO SAY
ABOUT IT. THE ESTATE's hero is the GATE at blue hour, dollying through the
piers, out of estate_1.jpg. Its scene five is the whole garden front at golden
hour, drifting sideways at 21:9, out of estate_2.jpg. This is the same house and
neither picture: a different hour (half an hour after sunset rather than blue
hour or golden), a different subject (the portico and the door rather than the
gate or the elevation), a different ratio from est-park's, and a camera that
walks in rather than across. Two pages that look alike are one page done twice,
and the six scripts before this one all carry the same paragraph.

WHY THE DOOR AND NOT THE GATE. /the-estate already owns the gate in motion, and
the last impression this page has to leave is not "here is the way in from the
street" — the address and the map say that in words a reader can copy — it is
"and there is a door at the end of it, with a light on". So the hero is the
threshold and the GATE is a still, one screen further down, where the reader has
just been told the address and wants to know what to look for.

THREE KINDS OF PICTURE COME OUT OF HERE AND THEY ARE THREE DIFFERENT CLAIMS.

  PHOTOGRAPH   one crop of the supplied photography of the real house: the
               gate on Konkordijas iela, the drive, and the north front behind
               it. Declared 'photo'.

  VISUALISATION  one crop of the project's own render of a reception desk.
               Declared 'render', and captioned as a desk rather than as a
               service that is running.

  GENERATED    the sequence and its poster, which is frame 0 of the encode. It
               descends through a GPT Image 2 still that changed the hour of a
               photograph of this house and nothing else. Declared 'generated'.

WHAT IS NOT CLAIMED. No caption on this page names an hour the estate keeps, a
person who works here, a service that is open, or a way of arriving. The estate
is under restoration and nobody has said what a visitor may do (ARCHITECTURE
§21) — so the desk is "a desk", the gate is "the gate", and the only facts on
the page are the address, the mailbox and two coordinates.

BIAS IS THE FRACTION OF THE SURPLUS TAKEN OFF THE TOP (or off the left, on a
frame too wide for its slot). 0.5 is a centre crop. Where a value is not 0.5 the
reason is written beside it.

NOTHING IS UPSCALED. A rung wider than the crop is skipped rather than
interpolated, which is why con-gate ships at [768, 985] and not at the band
ladder's 1152 — see its entry.

Run from anywhere:  python3 tools/photos/build_contact_media.py
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
# THE STILLS ARE COMMITTED AND THE .mp4 MASTER IS NOT, which is the repository's
# existing rule rather than a decision taken here: .gitignore carries
# /media_src/**/*.mp4 — the master stays on disk and in the backup, the encode
# under public_html/assets/video/ is the deliverable and that one is committed.
# So a fresh clone can rebuild both PLATES below, and rebuilding the SEQUENCE
# needs the master restored to this directory first.
MOTION = os.path.join(SRC, 'MOTION', 'contact')

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
# 1. The grades
#
# ONE CURVE, AND IT IS THIS PAGE'S OWN.
#
# LATE exists for exactly one picture and the argument is a measurement.
# estate/estate_1.jpg is a bright summer photograph — the crop below means 77
# out of 255 ungraded — and the act it stands in is near-black. Every approved
# band on the site sits between 18 and 49: ad-garden is 18, ad-nightfall 31,
# est-arrival 40, ev-gather 42, pad-gates 49. Dropped in raw this frame would be
# a hole punched in the page.
#
# WHAT IT IS NOT IS A NIGHT CURVE. build_residences_media.py's NIGHT takes the
# same file to 22 and build_events_media.py uses it for a tile; on a band this
# size that reading is an underexposed daylight photograph rather than an
# evening, because the sky is still a summer sky and the render is still lit by
# the sun. So LATE leans into the hour the photograph actually has — the sun is
# already low in it, the shadows are already long — and deepens it: the mid
# comes down to 0.30, the highlights are held at 0.74 so the warm light on the
# gate pier and the render survives, and the blue channel comes down twelve
# percent and the green four and a half. It measures 47, which is inside the
# band the site already ships, and it reads as the end of an afternoon rather
# than as a mistake.
#
# THE OTHER PLATE IS NOT GRADED AT ALL. reception_concierge.png measures 20 in
# this crop — darker than every band on the site except ad-garden — because it
# is a low-key render of a panelled room lit by one lamp. There is nothing for
# a curve to do to it, and a lift would be the only thing on this page that
# changed a picture to make it prettier.
#
#   (mid, high)           the curve, as build_club_media.py writes it
#   (mid, high, (r,g,b))  the same curve, with a per-channel weight after it
# ---------------------------------------------------------------------------

LATE = (0.30, 0.74, (1.0, 0.955, 0.88))        # the last of the afternoon


def grade_lut(points):
    """A 256-entry curve per channel, through (0,0), (0.5, mid), (1, high)."""
    mid, high = points[0], points[1]
    tilt = points[2] if len(points) > 2 else (1.0, 1.0, 1.0)

    lut = []

    for channel in range(3):
        for i in range(256):
            x = i / 255.0

            if x <= 0.5:
                y = (x / 0.5) * mid
            else:
                y = mid + ((x - 0.5) / 0.5) * (high - mid)

            lut.append(max(0, min(255, int(round(y * 255 * tilt[channel])))))

    return lut


# ---------------------------------------------------------------------------
# 2. The plates
#
#   stem : (source, box, ratio, widths, bias, graded, why)
#
# 'box' IS THE ONE THING THIS SCRIPT ADDS TO THE SEVEN BEFORE IT, and it exists
# for con-gate. It is a pixel window taken out of the source BEFORE the ratio is
# applied — (left, top, right, bottom), or None for the whole frame — and it is
# how a crop can stop short of something rather than merely be centred away from
# it. build_after_dark_media.py needed the same thing and solved it by moving a
# bias until two labelled bottles fell out of frame; that works when the thing to
# avoid is at an edge and does not when it is a third of the way in.
#
# NEITHER CROP BELOW IS A CROP ANOTHER PAGE HAS ALREADY CUT. Both files are
# shared with approved pages and both are used here at a ratio no page uses
# them at: estate_1.jpg is 3:2 on the Main Page, 16:9 on THE ESTATE and 4:5 on
# EVENTS, and this is 21:9; reception_concierge.png is 4:5 on EVENTS and 3:2 on
# RESIDENCES, and this is 16:9. Same file at the same ratio is the same picture,
# and this page has none.
# ---------------------------------------------------------------------------

PLATES = {

    # -- Scene 03: the approach ---------------------------------------------

    'contact/con-gate': (
        'estate/estate_1.jpg',
        (0, 0, 985, 966), (21, 9), [768, 985], 0.72, LATE,
        'THE GATE ON KONKORDIJAS IELA, AND IT IS THE ONE PICTURE ON THIS PAGE '
        'A READER MIGHT ACTUALLY NEED. The stone pier, the timber gate standing '
        'open, the paved drive running in, and the north front of the house '
        'behind it with its curved gable, its oculus and its door. Low, because '
        'the drive is the bottom of the composition and the sky is not the '
        'subject: bias 0.72 puts the paving in the frame and takes the '
        'unremarkable summer sky out of it.\n\n'
        '        THE CROP STOPS AT 985px OF 1628 AND THAT IS THE WHOLE POINT OF '
        'THE BOX. The gate pier at the right of this photograph carries the '
        'estate\'s old enamel sign, in a language that is not Latvian and with a '
        'name on it that is not Majori Manor. It is a true detail of the '
        'building as photographed and every other page can carry it — /the-'
        'estate ships this frame at 16:9 with the sign in it and is approved. '
        'This is the one page in the site whose job is to tell somebody what to '
        'look for when they arrive, and a photograph of the entrance with '
        'another name on the pier is the single most confusing thing it could '
        'print. So the window ends before the pier does. '
        'build_after_dark_media.py moved a crop off two labelled bottles for the '
        'same class of reason.\n\n'
        '        WHAT IT COSTS IS THE TOP RUNG. 985px is the whole of the '
        'window, so the band ladder\'s 1152 would be an upscale and is not '
        'exported. That is why the block declares variant "wide" rather than '
        '"full": inside the shell the band is about 1200px on a 1440 desktop, '
        'against 1440 full-bleed, and the frame is asked to stretch about as far '
        'as the site\'s own 1152 plates already are. See docs/CONTACT.md.'),

    # -- Scene 04: an answer from a person -----------------------------------

    'contact/con-desk': (
        'ESTATE_and_HOSPITALITY/reception_concierge.png',
        None, (16, 9), [768, 1152], 0.35, None,
        'A DESK, A LAMP, AND THE ESTATE\'S NAME ON THE WALL BEHIND IT. Cut wide '
        'out of a square render so the frame is a room rather than a portrait: '
        'the panelling, the flowers, the brass lamp, the desk and the wordmark '
        'are all in it, and the person at the desk is one thing among six '
        'rather than the subject. Bias 0.35 is what puts MAJORI MANOR complete '
        'in the frame — higher and the wordmark loses its top line, lower and '
        'the desk front runs out of the bottom.\n\n'
        '        THE BRIEF ASKS FOR A RECEPTION AND NOT FOR A STAFF PROFILE, '
        'and the ratio is how that is kept: at 4:5 (EVENTS) this file is a '
        'person, at 3:2 (RESIDENCES) it is a desk with a person at it, and at '
        '16:9 it is a room. The caption names the room and never the person.\n\n'
        '        IT IS NOT GRADED — see the note on LATE above. It measures 20 '
        'out of 255 as cut, which is darker than every band on the site bar '
        'one, and it is the quietest picture on this page on purpose.'),
}


# ---------------------------------------------------------------------------
# 3. The sequence
#
#   name : (ratio, poster widths, trim seconds or None, grade or None, source)
#
# 'source' is the media_src reference the sequence descends from. This one
# descends through a GPT Image 2 still: the still was made FROM the crop named
# there and changed the hour, and nothing else. The still and the crop are both
# in media_src/MOTION/contact/ and the prompts are below and in
# docs/CONTACT.md §3.
# ---------------------------------------------------------------------------

# THE PROMPTS, VERBATIM, because a prompt is the only part of a generated asset
# that cannot be recovered by looking at it. Both are written as a PRESERVATION
# instruction rather than a description: each names the architecture, the
# joinery and the materials of that specific frame, states the one thing that
# may change, lists the motion that is allowed, and then says what may not
# appear. The negative half is the half that does the work. Same shape as
# build_residences_media.py and build_after_dark_media.py.
#
# ---- The crop the generation starts from ----------------------------------
#
# ref-approach   estate/estate_2.jpg, 16:9 at bias 0.68 (900x506) — the garden
#                front's portico: four columns, the pediment with its oculus,
#                the timber front door, the steps, the bench under the portico,
#                the canted bay at the left, the mature tree at the right, and
#                the lawn across the foreground. THE ESTATE uses this file at
#                21:9 as the reference for est-park, which is the whole
#                elevation drifting sideways at golden hour; this crop is
#                tighter, squarer and centred on the door.
#
# ---- GPT Image 2, 2K, high, 16:9, from a reference -------------------------
#
# still-approach  <- ref-approach
#   "Preserve this exact manor house precisely and change only the hour and the
#    lighting. Keep every structural element exactly as photographed and in
#    exactly the same position, proportion and perspective: the projecting
#    portico at the centre with its four tall smooth white columns on square
#    plinths and their moulded capitals, the plain entablature and the low
#    pediment above them with the small round oculus window in it; the timber
#    panelled front door under the portico with its moulded architrave and the
#    tall narrow window beside it; the flight of shallow stone steps rising to
#    the portico floor and the long dark bench standing under it against the
#    wall; the pale cream rendered walls; the tall brown-framed multi-pane
#    windows in their brown surrounds, the canted bay window with its own small
#    hipped roof at the left and the second canted bay at the right; the steep
#    slate hipped roof with its two small dormers, its ridge and its white
#    rendered chimneys; the large mature deciduous tree standing to the right of
#    the portico with its heavy dark trunk and its full crown of leaves
#    overhanging the right of the frame; the mown lawn across the whole
#    foreground; the exact camera position, lens and horizon. Change the light:
#    it is now evening, half an hour after sunset. The daylight is gone from the
#    sky, which is a deep even blue with the last pale warmth low behind the
#    trees. The house is lit only by its own lights: warm lamplight standing in
#    the ground-floor and first-floor windows, a warm glow under the portico
#    with the front door lit and the light falling down the stone steps onto the
#    grass, and low warm uplight washing the four columns and the render from
#    below. The slate roof goes almost black, the cream render holds a warm cast
#    where the light reaches it and falls into cool shadow where it does not,
#    and the leaves of the tree are dark against the blue. No new architecture.
#    No new doors, windows, dormers, chimneys, wings, porches, railings,
#    terraces, paths, driveways, gates, fences, garden furniture, planting, lamp
#    posts, statues, flags, signage or lettering. No redesign of the portico,
#    the columns, the roof, the windows, the steps or the tree. No people. No
#    vehicles. No visible light fittings that are not already in the photograph.
#    Restrained European private-estate architectural photography, warm
#    practical light against a deep blue evening sky, natural colour, unstaged,
#    no lens flare, no HDR."
#
#   THE HOUR CHANGED AND THE BUILDING DID NOT. Every noun the prompt keeps is a
#   noun in estate_2.jpg: the same four columns, the same oculus in the same
#   pediment, the same timber door, the same bench, the same steps, the same
#   bay windows, the same dormers and chimneys, the same tree. This is the one
#   composition in the library that says what this page is about — a door, with
#   a light on behind it — and no photograph of it after dark exists.
#
#   WHAT THE MODEL ADDED, STATED RATHER THAN HIDDEN: small ground uplighters at
#   the foot of the columns and the steps, which the prompt asked it not to add.
#   They are consistent with the light the prompt DID ask for — something has to
#   be washing those columns from below — they are small, they are at the
#   bottom of the frame, and they were left rather than spend a second
#   generation on them. Recorded in docs/CONTACT.md §8.
#
# ---- Seedance 2.0, 720p, 16:9, 5s, no audio, start_image ------------------
#
# START_IMAGE AND NOT image_references, WHICH IS THE RULE build_events_media.py
# SET AND FOUR PAGES HAVE KEPT. The brief for this page asked for omni_reference;
# start_image is what it is built on instead, and the reason is the brief's own
# next sentence — "Preserve the exact architecture, driveway, landscaping,
# gates, windows and proportions of the source". A reference is a mood and a
# start frame is a contract: it is the only setting under which a pediment, four
# columns and a glazing pattern survive five seconds of camera movement intact,
# and it is what every sequence on the seven approved pages uses. It is also
# what makes the poster honest: frame 0 of the encode is what the reader sees
# before the video plays, so the still and the film cannot re-frame against each
# other when the video fades up.
#
# con-arrival  <- still-approach
#   "Extremely slow cinematic dolly forward across the lawn toward this exact
#    manor house at dusk, approaching the lit portico and the front door beneath
#    it. Preserve everything exactly as photographed: the four tall white
#    columns on their square plinths under the low pediment with its round
#    oculus window; the timber panelled front door under the portico with its
#    moulded architrave; the shallow stone steps rising to the portico and the
#    long dark bench standing under it; the pale rendered walls with their warm
#    lamplight standing in every ground-floor and first-floor window; the canted
#    bay window at the left and the second canted bay at the right; the steep
#    slate roof with its dormers and white chimneys; the large mature tree at
#    the right with its heavy dark trunk and its crown of leaves overhanging the
#    frame; the mown lawn across the foreground; the deep blue evening sky. The
#    only motion: the camera drifts forward extremely slowly and perfectly
#    level, so the portico opens very slightly and the columns pass a little
#    wider in the frame, with gentle parallax between the tree in the foreground
#    and the house behind it; the leaves and the outer branches of the tree stir
#    faintly in the evening air; the grass moves almost imperceptibly; the warm
#    light in the windows and under the portico breathes very slightly and
#    otherwise stays steady. No people. No cars. No new buildings, wings, doors,
#    windows, lamps, railings, paths, driveways, gates, fences, furniture,
#    planting, signage or lettering. No redesign of the portico, the columns,
#    the roof, the windows, the steps or the tree. No door opening or closing.
#    Restrained European private-estate architectural cinematography, warm
#    practical light against a deep blue evening sky, one continuous shot, no
#    cuts, no camera shake, no zoom snap, no lens flare."
#
#   IT IS TRIMMED TO 3.2 OF ITS 5 SECONDS AND THAT IS THE BRIEF BEING FOLLOWED
#   RATHER THAN A FAULT BEING HIDDEN. The master is a clean, level, continuous
#   dolly with no drift and no shake, and it holds the architecture for the
#   whole five seconds — but over five it travels far enough that the last
#   second is standing at the foot of the steps, which is a promotional arrival
#   and not the "extremely restrained" one the brief asks for. Cut at 3.2 the
#   house grows by about a fifth across the shot; palindromed (see §4) the
#   reader sees six and a half seconds of the camera easing in and easing back
#   out, and nothing else on the screen moves at all.
#
#   WHAT SEEDANCE ADDED, STATED RATHER THAN HIDDEN: a second mature tree at the
#   left of the frame, mirroring the one the still has at the right, and a
#   slightly wider framing than the still it started from. The still is not the
#   poster — the poster is frame 0 of this encode, which is how the page never
#   shows the two side by side — and the added tree is consistent with the
#   estate's own park, which is planted with mature trees on both sides of this
#   lawn in estate_2.jpg. It is landscaping the model invented all the same, and
#   it is recorded in docs/CONTACT.md §8.

SEQUENCE_NAME = 'con-arrival'
SEQUENCE_RATIO = (16, 9)
SEQUENCE_POSTER_WIDTHS = [768, 1280]
SEQUENCE_TRIM = 3.2
SEQUENCE_SOURCE = 'estate/estate_2.jpg -> GPT Image 2 dusk still -> Seedance 2.0'

# THE HERO IS GRADED AND THE ARGUMENT IS LEGIBILITY, WHICH IS THE ONE THE
# ESTATE MADE FIRST. The copy of this hero — the eyebrow, the title, the
# statement and the cue — stands on a facade that the sequence lights from below
# in warm uplight, and cream type on lit white render measures about 1.2:1. The
# master runs from 46 out of 255 at frame 0 to 65 by the trim; every approved
# hero on this site sits between 29 and 40. So the midtones come down about a
# fifth, contrast is lifted three percent to keep the windows from flattening
# into the wall, and saturation comes off five percent because a warm picture
# darkened goes orange before it goes dark.
#
# HALF THE FIX IS HERE AND HALF IS IN THE STYLESHEET, exactly as on THE ESTATE:
# contact.css §2 lays a soft band behind the copy on top of this. Neither does
# it alone, and either alone taken far enough to do it would have cost the
# windows the glow that makes the shot.
SEQUENCE_GRADE = 'eq=gamma=0.80:contrast=1.030:saturation=0.95'

# CRF rather than a bitrate: this is a slow shot of still architecture and it
# compresses very differently from a room with a fire in it.
CRF_HERO = 25
CRF_NARROW = 28

# The wide encode is what a desktop gets; the narrow one is for below 900px,
# where a 1280-wide film is three times the bytes needed to fill a 390px screen.
HERO_WIDE = 1280
HERO_NARROW = 854


# ---------------------------------------------------------------------------
# 4. The loop is a palindrome
#
# The sequence is a single continuous camera move that never returns to where it
# started, so no frame in it matches its own first frame. A hard cut back to
# frame 0 jumps, and on a shot this slow a jump is the only thing in it that
# moves quickly. A cross-dissolve is worse: dissolving a near framing into a far
# one ghosts the scene against itself.
#
# So it plays forward and then backwards — seamless by construction, because the
# last frame of the reverse IS the first frame of the forward, and no two
# framings are ever blended. This is tools/motion/build_sequences.sh's filter,
# verbatim, and it is what turns a 3.2-second push into a 6.4-second breath.
# ---------------------------------------------------------------------------

PALINDROME = ('[0:v]split[a][b];[b]reverse,trim=start_frame=1,'
              'setpts=PTS-STARTPTS[r];[a][r]concat=n=2:v=1[c]')


# ---------------------------------------------------------------------------
# 5. The machinery
#
# crop_box, export, prune, encode and poster are build_residences_media.py's,
# unchanged but for `box`. They are copied rather than imported for the reason
# every one of these scripts is standalone: a build script that a future reader
# has to follow across three files to find out what a crop was is a build script
# that stops being read.
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
            continue                      # nothing is upscaled — see the header

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


def build_plates():
    print('\nPLATES\n' + '-' * 78)

    for stem, (source, box, ratio, widths, bias, graded, _why) in PLATES.items():
        path = os.path.join(SRC, source)

        if not os.path.isfile(path):
            print(f'  MISSING  {source}')
            continue

        with Image.open(path) as im:
            im = im.convert('RGB')

            if box is not None:
                im = im.crop(box)

            cut = im.crop(crop_box(im.size, ratio, bias))

            if graded is not None:
                cut = cut.point(grade_lut(graded))

            rungs = export(cut, stem, widths)

        window = f'  box {box[2] - box[0]}x{box[3] - box[1]}' if box else ''

        print(f'  {stem:<22} {ratio[0]}:{ratio[1]:<3} {rungs}'
              f'{"  graded" if graded else ""}{window}  <- {source}')


def encode(ff, master, out, width, crf, extra_filter='', trim=None):
    """Palindrome, scale, encode, no audio. `trim` cuts the input first."""
    chain = f'{PALINDROME};[c]scale={width}:-2:flags=lanczos'

    if extra_filter:
        chain += f',{extra_filter}'

    chain += ',format=yuv420p[v]'

    # -t before -i would seek the container; after -i it limits the decode,
    # which is what the palindrome then reverses. The master is not touched.
    trim_args = ['-t', str(trim)] if trim else []

    subprocess.run([
        ff, '-nostdin', '-y', '-loglevel', 'error', '-i', master, *trim_args,
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
                        SEQUENCE_GRADE, SEQUENCE_TRIM)
    small_bytes = encode(ff, master, small, HERO_NARROW, CRF_NARROW,
                         SEQUENCE_GRADE, SEQUENCE_TRIM)

    frame = os.path.join(MOTION, f'{SEQUENCE_NAME}-frame0.png')
    rungs = poster(ff, wide, f'contact/{SEQUENCE_NAME}',
                   SEQUENCE_RATIO, SEQUENCE_POSTER_WIDTHS, frame)

    print(f'  {SEQUENCE_NAME:<13} {wide_bytes // 1024:>5} KB  '
          f'+ {small_bytes // 1024} KB narrow  trimmed {SEQUENCE_TRIM}s  graded'
          f'  poster {rungs}\n'
          f'  {"":<13} <- {SEQUENCE_SOURCE}')


if __name__ == '__main__':
    build_plates()
    build_sequence()
    print('\ndone.\n')
