"""
Build PADEL's media from media_src/ and the four Seedance 2.0 sequences.

WHAT THIS IS. /padel declares its pictures by stem — padel/club-park,
padel/shop-lockers — and img() in app/helpers.php looks for
assets/img/<stem>-<width>.<ext>. This script is the mapping between the
material in media_src/ and those stems, and it is a script rather than a folder
of hand-cut exports for the same reason build_home_media.py,
build_estate_media.py and build_club_media.py are: every crop is a decision,
and a decision has to be re-readable and re-runnable.

TWO KINDS OF PICTURE COME OUT OF HERE AND THEY ARE TWO DIFFERENT CLAIMS.

  VISUALISATIONS are crops of the project's own renders — the courts, the sign,
  the terrace, the padel shop, the park. Declared 'render', and every component
  prints "Visualisation" under them. THERE IS NO 'photo' ON THIS PAGE AND THERE
  CANNOT BE ONE: the complex is drawn and not built, so a photograph of these
  courts does not exist. The one photograph in the library that /padel shows —
  pavilion_1, in the ecosystem index — is a photograph of the pavilion and is
  declared as one.

  POSTERS are frame 0 of a Seedance sequence. Two of the four descend directly
  from a crop of a supplied visualisation; two descend through a GPT Image 2
  still that was itself made from one of those crops and changed nothing but
  the hour. Either way the output is synthesised, so all four are declared
  'generated' and the components print "Generated image".

THE PADEL MATERIAL IS THINNER THAN THE HOUSE'S AND ONE FILE CARRIES MOST OF IT.
media_src/PRIVATE_CLUB_ECOSYSTEM/1.png is 2688x1152 and is the only frame in
the library that holds the whole complex — the clubhouse, the path, the hedge
and the courts in depth. Three pictures are cut from it and they are three
pictures rather than three crops: the whole panorama at 21:9 (scene 01), a 16:9
of the clubhouse end (the evening sequence), and a 16:9 of the courts end (the
afternoon still the courts sequence is made from, at a different hour). The
same division build_club_media.py makes between club/house-enfilade and
club/detail-portal, on a frame that has to work harder.

THE POSTER IS THE SEQUENCE'S OWN FIRST FRAME, which is why the fade is
invisible. A poster cut from the source instead would visibly re-frame the
moment the video faded up, because the two are not the same composition.

BIAS IS THE FRACTION OF THE SURPLUS TAKEN OFF THE TOP (or off the left, on a
frame too wide for its slot). 0.5 is a centre crop. Where a value is not 0.5
the reason is written beside it.

NOTHING IS UPSCALED. A rung wider than the crop is skipped rather than
interpolated, so three of the four ecosystem tiles ship at 640 alone — see
docs/PADEL.md §8. That is the library being what it is, not a ladder being
half-exported.

Run from anywhere:  python3 tools/photos/build_padel_media.py
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
MOTION = os.path.join(SRC, 'MOTION', 'padel')

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
# THE VISUALISATIONS ARE NOT GRADED AND THAT IS THE DIFFERENCE FROM THE CLUB.
# That page grades nine photographs taken at noon down onto a near-black ground.
# Every picture here was made dark already — the padel material is a blue hour,
# a night and a dusk — and pulling it down again closes it up. The one entry
# that carries a curve is the park at night, which arrives a stop brighter than
# the two bands either side of it because its lawn is lit and theirs is not.
# ---------------------------------------------------------------------------

GRADE = (0.475, 0.92)      # 0.5 -> 0.475 and 1.0 -> 0.92, build_club_media's own


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
#
# THE BAND LADDER IS [768, 1152] AND IT IS NOT A CHOICE MADE HERE.
# film-band.php asks img() for exactly those two rungs at every ratio, so a
# third export would be a file on disk that the page never requests — which is
# one of the two things the build-versus-page check in docs/PADEL.md counts.
# ---------------------------------------------------------------------------

PLATES = {

    # -- Scene 01: the club, from the park ----------------------------------

    'padel/club-park': (
        'PRIVATE_CLUB_ECOSYSTEM/1.png', (21, 9), [768, 1152], 0.5, False,
        'THE ONE FRAME IN THE LIBRARY THAT HOLDS THE WHOLE COMPLEX, and it is '
        'already 21:9 to the pixel — 2688x1152 — so nothing is cropped at all. '
        'The clubhouse and its sign at the left, the lit path and the hedge '
        'across the foreground, the courts in depth at the right. The scene '
        'says "a club that happens to have courts"; this is that sentence as a '
        'picture.'),

    # -- Scene 04: the social side ------------------------------------------

    'padel/shop-lockers': (
        'PRIVATE_CLUB_ECOSYSTEM/10.jpeg', (4, 5), [640, 960], 0.22, False,
        'High, because the subject is the racket cabinet at the top and the '
        'ball lockers under it, and a centred 4:5 out of a 0.61 source would '
        'trade the cabinet for floor. The court through the glass at the right '
        'is what makes it the padel shop and not a vitrine.'),

    'padel/social-terrace': (
        'PRIVATE_CLUB_ECOSYSTEM/9.jpeg', (3, 2), [640, 960], 0.10, False,
        'A 3:2 band taken high out of a portrait frame: the bar under its '
        'canopy at the left, the racket sign at the centre, the court at the '
        'right. THE MAIN PAGE USES THIS FILE AT 4:5 AND THIS IS NOT THAT '
        'PICTURE — that one is the sign, this one is the terrace the sign '
        'stands on.'),

    # -- Scene 05: the park -------------------------------------------------

    'padel/park-night': (
        'PRIVATE_CLUB_ECOSYSTEM/3.png', (16, 9), [768, 1152], 0.42, GRADE,
        'The park itself at night: the lit gravel path, the clipped box, the '
        'lamps and the stone rotunda. Taken a little high so the path leads out '
        'of the bottom of the frame rather than stopping in it. THE ONE GRADED '
        'ENTRY — its lawn is lit and the two bands either side of it are a '
        'night court and a night clubhouse, so at its own exposure it arrives '
        'as the brightest thing on the page.'),

    # -- Scene 07: the rest of the estate -----------------------------------
    #
    # Four tiles, four pages, and four sources no other page has cut a still
    # from. Two of them are the sources of the Main Page's own SEQUENCES, which
    # is not the same thing as its pictures: no crop of either exists anywhere
    # on the site.

    'padel/world-club': (
        'RESTAURANT/dining_salon2.png', (4, 5), [640, 960], 0.30, False,
        'The laid table in the panelled room. High, because the chandelier is '
        'the top of the composition.'),

    'padel/world-events': (
        'pavilion/pavilion_1.jpg', (4, 5), [640], 0.08, False,
        'THE ONE PHOTOGRAPH ON THE PAGE. The glass dome lit from within beside '
        'the long building, shot from the air at night — the same pavilion the '
        'Main Page hero was filmed at. Far left, because the dome is the '
        'subject and the building runs away to the right. A 1637-wide landscape '
        'cut to 4:5 is 769 across, so it ships at 640 and no higher; nothing '
        'here is upscaled.'),

    'padel/world-dark': (
        'CIGAR_HOUSE/cigar_lounge.png', (4, 5), [640, 960], 0.40, False,
        'The lit hearth, the leather and the shelves. A little above centre so '
        'the fire is in the frame and the rug is not.'),

    'padel/world-stay': (
        'ESTATE_and_HOSPITALITY/private_cottages.png', (4, 5), [640, 960], 0.42, False,
        'The cottages at night with the lit path between them. High, so the '
        'lit gables carry the frame.'),
}


# ---------------------------------------------------------------------------
# 3. The sequences
#
#   name : (ratio, poster widths, narrow encode?, source, motion)
#
# 'source' is the media_src reference the sequence descends from. Two of them
# descend through a GPT Image 2 still: the still was made FROM the crop named
# here and changed the hour, or the framing, and nothing else. Both stills are
# in media_src/MOTION/padel/ and both prompts are in docs/PADEL.md §3.
# ---------------------------------------------------------------------------

# THE PROMPTS, VERBATIM, because a prompt is the only part of a generated asset
# that cannot be recovered by looking at it. Every one is written as a
# PRESERVATION instruction rather than a description: it names the architecture,
# the landscaping and the materials of that specific frame, states the one thing
# that may change, lists the motion that is allowed, and then says what may not
# appear. The negative half is the half that does the work. Same shape as
# tools/photos/build_club_media.py and tools/motion/build_sequences.sh.
#
# ---- The crops the generations start from ---------------------------------
#
# ref-arrival   PRIVATE_CLUB_ECOSYSTEM/8.jpeg, 16:9 centre band (1448x814)
# ref-courts    PRIVATE_CLUB_ECOSYSTEM/1.png,  16:9 right  band (2048x1152)
# ref-evening   PRIVATE_CLUB_ECOSYSTEM/1.png,  16:9 left   band (2048x1152)
# ref-social    PRIVATE_CLUB_ECOSYSTEM/9.jpeg, whole frame      (1122x1402)
#
# ---- GPT Image 2, 2K, high, 16:9, from a reference ------------------------
#
# still-courts-afternoon  <- ref-courts
#   "Preserve this exact padel club precisely and change only the time of day.
#    Keep every element exactly as photographed: the row of glass-and-black-steel
#    panoramic padel courts running away into depth, the tall black mesh and
#    glass court walls with their steel posts and horizontal rails, the blue-grey
#    playing surfaces with their white lines, the players in white and dark
#    sportswear standing exactly where they are, the strings of small warm lights
#    running along the inside of the court structure, the tall slim black
#    floodlight columns, the dense clipped green hedge running the full width of
#    the foreground, the small bronze path bollards set along it, the mature
#    trees behind and beside the courts, the gravel path at the left. Change only
#    the light: it is now late afternoon, an hour before sunset. The sky is warm
#    pale gold and soft blue with high thin cloud, the sun low behind the trees
#    to the left, long soft shadows falling across the courts and the hedge, warm
#    raking light on the top of the hedge and on the steel and glass, the string
#    lights inside the courts still lit but subtle against the daylight. The
#    court surfaces keep their own blue-grey colour and are not repainted. No
#    people added or removed. No signage, lettering, plaques or logos anywhere.
#    No new buildings, courts, fences, furniture or architectural elements. No
#    redesign of the courts or the landscaping. Restrained architectural and
#    hospitality photography, natural late-afternoon colour, quiet and unstaged,
#    no lens flare, no HDR."
#
#   THE HOUR IS THE ONLY THING THAT CHANGED, AND IT IS THE WHOLE REASON THIS
#   STILL EXISTS. Every padel reference in the library is an evening or a night.
#   A page whose argument is that a member can spend the day here has to be able
#   to show one, and the honest way to get one is to move the sun on a picture
#   of these courts rather than to find a picture of somebody else's.
#
# still-social  <- ref-social
#   "Recompose this exact scene as a wide landscape photograph of the same place,
#    preserving every element and material exactly as it appears. Keep: the
#    open-sided timber-framed pavilion with its dark steel structure and slatted
#    timber ceiling, the long bar beneath it with backlit shelves of bottles, the
#    row of warm glass pendant lanterns hanging from the structure, the trailing
#    greenery along the canopy, the guests seated in low woven rattan armchairs
#    and sofas with pale linen cushions and dark green velvet cushions, the low
#    round timber tables with glasses on them, the small brass storm lanterns,
#    the potted olive and boxwood planting in dark ribbed planters, the wide
#    timber deck, the tall dark-green illuminated padel-racket sculpture with the
#    MAJORI MANOR PADEL CLUB crest and lettering on it kept exactly as it reads,
#    the glass and black steel padel court to the right with players on the
#    blue-grey surface, the black umbrella, the low landscape lighting in the
#    planting, the mature trees behind. The hour is unchanged: dusk, a deep blue
#    and violet sky with warm cloud, warm amber practical light throughout. Move
#    the camera back and to the left so that the whole social terrace is seen in
#    a wide frame, with the racket sculpture standing to the right of centre
#    rather than filling the frame, the bar and the lounge seating to the left,
#    and the courts beyond. No new buildings, structures, furniture or objects.
#    No redesign. No additional signage or lettering. Restrained hospitality
#    architectural photography, natural warm practical lighting, unstaged, no
#    lens flare."
#
#   THE CAMERA MOVED AND NOTHING ELSE DID. The supplied frame is a portrait with
#   the racket sign filling two thirds of it; the social zone is behind the sign
#   and mostly out of shot. A 16:9 band cut from it is the sign again. So the
#   instruction is a step backwards rather than a new scene, and every object it
#   names is an object that is already in the reference.
#
# ---- Seedance 2.0, 720p, 16:9, 5s, no audio, start_image ------------------
#
# START_IMAGE AND NOT image_references, ON ALL FOUR. The reference is the first
# frame of the generation rather than a mood for it, which is the only setting
# under which court geometry, a hedge line and a piece of signage survive five
# seconds of camera movement intact. It is also what makes the poster honest:
# frame 0 of the encode is the reference, so the still and the film cannot
# re-frame against each other.
#
# pad-gates  <- ref-arrival
#   "Extremely slow cinematic dolly forward along this exact landscaped path
#    toward the Majori Manor Padel Club. Preserve everything as photographed: the
#    tall illuminated stone sign panel at the right with its circular MAJORI
#    MANOR crest and the words Padel Club beneath it, kept exactly as they read;
#    the clipped hedge running away behind it, uplit from below; the row of small
#    bronze path bollards along the gravel path at the left; the mature tree with
#    its low branches at the upper left; the manor house in the distance with its
#    lit windows, columns and pale render; the black steel and glass padel court
#    enclosure with its floodlight columns along the top right; the mown lawn;
#    the deep blue evening sky. The only motion: a very gradual forward drift of
#    the camera along the path, gentle parallax between the sign in the
#    foreground and the manor beyond, leaves and the crowns of the trees stirring
#    faintly in the evening air, the hedge moving almost imperceptibly, the warm
#    light of the bollards and the uplighters breathing very slightly, warm light
#    steady in the manor's windows. No people. No cars. No new buildings, signs,
#    lettering, fences or architectural elements. No redesign of the sign, the
#    crest, the landscaping or the house. Restrained European private-club
#    architectural cinematography, warm practical lighting against a blue-hour
#    sky, one continuous shot, no cuts, no camera shake, no zoom snap, no lens
#    flare."
#
# pad-courts  <- still-courts-afternoon
#   "Slow controlled lateral camera movement alongside these exact padel courts
#    at the end of the afternoon. Preserve everything as it appears: the row of
#    glass and black steel panoramic courts running away into depth, the tall
#    mesh and glass walls with their steel posts and rails, the blue-grey playing
#    surfaces with their white lines, the players in white and dark sportswear,
#    the strings of small warm lights inside the court structure, the slim black
#    floodlight columns, the dense clipped hedge across the foreground, the small
#    bronze path bollards, the trees, the low golden sun and the warm pale sky.
#    The only motion: the camera sliding smoothly and slowly sideways along the
#    hedge, revealing more of the courts in depth, gentle parallax between the
#    foreground hedge and the far end of the courts, the players moving naturally
#    and unhurriedly with no exaggerated action, leaves and hedge stirring
#    faintly in the evening air, warm reflections travelling slowly across the
#    glass and steel as the camera moves. No new people entering the frame. No
#    new buildings, courts, fences, signs, lettering or objects. No redesign of
#    the courts or the landscaping. Restrained private club architectural
#    cinematography, natural late-afternoon colour, one continuous shot, no cuts,
#    no camera shake, no zoom snap, no lens flare."
#
# pad-social  <- still-social
#   "Slow cinematic dolly forward through this exact social terrace overlooking
#    the padel courts. Preserve everything as it appears: the open-sided timber
#    pavilion with its dark steel structure and slatted ceiling, the long bar
#    beneath it with its backlit shelves of bottles, the strings of small warm
#    lights and the glass pendant lanterns, the trailing greenery, the guests
#    seated in low woven rattan armchairs and sofas with pale and dark green
#    cushions, the round timber tables with candle lanterns on them, the potted
#    planting in dark ribbed planters, the timber deck, the tall dark green
#    illuminated padel racket sculpture with its crest and MAJORI MANOR PADEL
#    CLUB lettering kept exactly as it reads, the glass and black steel padel
#    court to the right with players on it, the umbrella, the low landscape
#    lighting, the trees, the dusk sky. The only motion: a very gradual forward
#    drift of the camera across the deck with gentle parallax between the
#    foreground planting and the bar beyond, candle flames in the lanterns moving
#    naturally, the guests shifting only slightly in conversation, the pendant
#    lights breathing very gently, leaves stirring faintly, the players on the
#    court beyond moving naturally and unhurriedly. No new people entering the
#    frame. No new furniture, buildings, structures, signs, lettering or objects.
#    No redesign. Refined private members club hospitality cinematography, warm
#    amber practical light against a blue dusk sky, one continuous shot, no cuts,
#    no camera shake, no lens flare."
#
# pad-arrival  <- ref-evening
#   "Very slow cinematic push forward along this exact lit path toward the Majori
#    Manor Padel Club pavilion after sunset. Preserve everything as photographed:
#    the low dark clubhouse at the left with its glazed front, the warm lit
#    interior behind the glass and the MAJORI MANOR PADEL CLUB sign on its fascia
#    kept exactly as it reads; the mature tree at the far left; the clipped hedge
#    running away to the right, uplit by the small bronze bollards set along it;
#    the paved path in the foreground; the tall black steel and glass padel
#    courts filling the right of the frame with their strings of small warm
#    lights, the blue-grey playing surfaces and the players standing on them; the
#    slim black floodlight columns; the deep blue night sky. The only motion: an
#    almost imperceptible forward drift of the camera along the path with gentle
#    parallax between the foreground hedge and the pavilion, the players inside
#    the courts moving naturally and unhurriedly with no exaggerated action,
#    leaves and hedge stirring faintly, warm light breathing very gently in the
#    pavilion and in the bollards, court lights reflecting and shifting
#    realistically on the glass. No new people entering the frame. No new
#    buildings, courts, fences, signs, lettering or objects. No redesign of the
#    pavilion, the courts, the sign or the landscaping. Restrained private
#    members club cinematography, warm practical light against a night sky, one
#    continuous shot, no cuts, no camera shake, no lens flare."

#
# WHICH SEQUENCE IS THE HERO WAS DECIDED BY LOOKING AT IT, AND IT CHANGED.
# The first cut of this page opened on the sign — a lit stone panel with the
# estate's crest cut into it, standing in the middle right of the frame. It is
# the best single picture in the padel material and it is the wrong plate for
# this hero: the crest on the panel is the same crest the hero component stands
# in cream at the top of the copy, so the first screen carried it twice, and the
# panel's own lettering ran directly under the statement. A hero plate whose
# subject is a bright rectangle with type on it cannot take centred type.
#
# So the hero is the approach to the clubhouse instead — an even, dark frame
# with the sign small at the far left, the courts glowing at the right and a lit
# hedge across the foot of it — and the sign panel became the picture of scene
# five, where the manor standing lit behind it is the whole argument of that
# scene. Nothing was regenerated to make the change: the two are the same two
# files under different names.

SEQUENCES = {
    'pad-arrival': (
        (16, 9), [768, 1280], True,
        'PRIVATE_CLUB_ECOSYSTEM/1.png -> 16:9 left crop -> Seedance 2.0',
        'Very slow approach along the lit path toward the clubhouse, the courts '
        'opening at the right. THE HERO.'),

    'pad-courts': (
        (16, 9), [768, 1152], False,
        'PRIVATE_CLUB_ECOSYSTEM/1.png -> 16:9 right crop -> GPT Image 2 '
        'late-afternoon still -> Seedance 2.0',
        'Slow lateral track along the hedge, the courts opening in depth.'),

    'pad-social': (
        (16, 9), [768, 1152], False,
        'PRIVATE_CLUB_ECOSYSTEM/9.jpeg -> GPT Image 2 wide still -> Seedance 2.0',
        'Slow dolly across the terrace, candle flames moving, the court beyond.'),

    'pad-gates': (
        (16, 9), [768, 1152], False,
        'PRIVATE_CLUB_ECOSYSTEM/8.jpeg -> 16:9 centre crop -> Seedance 2.0',
        'Slow dolly along the path, past the club sign, the house lit beyond it.'),
}

# CRF 29 ON ALL FOUR, AND THAT IS A DEPARTURE FROM THE CLUB'S 27.
#
# THE CLUB's sequences are interiors: four walls, a few practical lights and
# almost nothing moving. These four are night and dusk EXTERIORS — moving
# foliage, a clipped hedge running the width of the frame, and several hundred
# point sources strung inside a glass court — which is the hardest material
# H.264 is ever given and the reason the same CRF costs half again as many bytes
# here. Measured on pad-evening at 1152: 27 gives 2 444 KB, 28 gives 2 132,
# 29 gives 1 866 and 30 gives 1 633. Compared at 100% on the two places this
# codec gives up first — the string lights behind the glass and the uplit hedge
# — 27 and 29 are indistinguishable and 30 begins to smear the leaves. So 29 on
# the three section films, which is the Main Page's own hero number.
#
# AND THE HERO GOES ONE RUNG FURTHER STILL, to 31. It is 1280 rather than 1152,
# it is the largest single file on the page, and it is the only one a reader
# meets before they have decided to stay: at 29 it is 2 284 KB and at 31 it is
# 1 742, and on the same two places, at 100%, the pair are indistinguishable.
# The narrow encode goes to 32 for the same reason at a third of the width.
CRF_WIDE = 29
CRF_HERO = 31
CRF_NARROW = 32

# ---------------------------------------------------------------------------
# 4. The loop is a palindrome, and that is not a shortcut
#
# Every one of the four is a single continuous camera move that never returns
# to where it started, so no frame anywhere matches its own first frame. A hard
# cut back to frame 0 jumps, and on a shot this slow a jump is the only thing
# in it that moves quickly. A cross-dissolve is worse: dissolving a near
# framing into a far one ghosts the scene against itself, and on the arrival
# that means two sign panels.
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
        path = os.path.join(SRC, source)

        if not os.path.isfile(path):
            print(f'  MISSING  {source}')
            continue

        with Image.open(path) as im:
            im = im.convert('RGB')
            cropped = im.crop(crop_box(im.size, ratio, bias))

            if graded:
                cropped = cropped.point(
                    grade_lut(GRADE if graded is True else graded))

            rungs = export(cropped, stem, widths)

            if not rungs:
                print(f'  NO RUNGS {stem}: crop is {cropped.width}px, '
                      f'ladder starts at {min(widths)}')

        print(f'  {stem:<24} <- {source:<46} '
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

        line = f'  {name:<13} {os.path.getsize(wide) // 1024:>5} KB'

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
            rungs = export(cropped, f'padel/{name}', widths)

        print(f'{line}  poster {rungs}  <- {source}')


if __name__ == '__main__':
    build_plates()
    build_sequences()
    print('\ndone.\n')
