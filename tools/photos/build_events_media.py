"""
Build EVENTS' media from media_src/, the supplied pavilion footage and the four
Seedance 2.0 sequences.

WHAT THIS IS. /events declares its pictures by stem — events/pavilion-day,
events/kind-wedding — and img() in app/helpers.php looks for
assets/img/<stem>-<width>.<ext>. This script is the mapping between the material
in media_src/ and those stems, and it is a script rather than a folder of
hand-cut exports for the reason build_home_media.py, build_estate_media.py,
build_club_media.py and build_padel_media.py are: every crop is a decision, and
a decision has to be re-readable and re-runnable.

THE HERO IS SUPPLIED FOOTAGE AND NOTHING WAS GENERATED FOR IT.

    media_src/MOTION/HERO/pavilion.mp4

1280x720, 24 fps, 8.06 s, WITH an AAC track. It is a real aerial shot of the
real pavilion at night — the lit geodesic dome, the long event building beside
it, the festoon-lit lawn with its cocktail tables — descending slowly toward the
dome. The brief for this page names it as the hero and forbids replacing it, and
nothing below replaces it: it is cropped to nothing, graded for legibility, made
into a palindrome loop and encoded twice, exactly as tools/motion/
build_sequences.sh treats the Main Page's own master. The audio is dropped with
-an, as it always has been: the hero plays muted and unattended.

IT IS THE ONLY FILM ON THE SITE DECLARED 'photo'. The other fourteen sequences
are Seedance generations of visualisations; this one is a camera pointed at a
building that exists. content/en/events.php says so, and docs/ASSET_MANIFEST.md
said the same thing about the earlier cut of this footage.

FOUR KINDS OF PICTURE COME OUT OF HERE AND THEY ARE FOUR DIFFERENT CLAIMS.

  PHOTOGRAPHS are crops of the three supplied pavilion frames and of the one
  external shot of the house. Declared 'photo'.

  VISUALISATIONS are crops of the project's own renders — the dining rooms, the
  lobby, the lounge, the bar, the padel complex. Declared 'render'.

  POSTERS are frame 0 of a sequence. The hero's is a frame of the supplied
  footage and is therefore 'photo'; the four Seedance posters are 'generated'.

  GENERATED STILLS are the one GPT Image 2 picture on this page,
  MOTION/events/still-gathering.png, and it is the first frame of ev-gather.

BIAS IS THE FRACTION OF THE SURPLUS TAKEN OFF THE TOP (or off the left, on a
frame too wide for its slot). 0.5 is a centre crop. Where a value is not 0.5 the
reason is written beside it.

NOTHING IS UPSCALED. A rung wider than the crop is skipped rather than
interpolated, so four of this page's plates ship at 640 alone — see
docs/EVENTS.md §8. That is the library being what it is, not a ladder being
half-exported.

Run from anywhere:  python3 tools/photos/build_events_media.py
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

# The four sequences as they came back from Seedance, the one GPT Image 2 still
# one of them was made from, and the hero's poster frame.
#
# THE STILL IS COMMITTED AND THE .mp4 MASTERS ARE NOT, which is the repository's
# existing rule rather than a decision taken here: .gitignore carries
# /media_src/**/*.mp4 — the master stays on disk and in the backup, the encode
# under public_html/assets/video/ is the deliverable and that one is committed.
# So a fresh clone can rebuild every PLATE below, and rebuilding the SEQUENCES
# needs the masters restored to this directory first.
MOTION = os.path.join(SRC, 'MOTION', 'events')
HERO_SRC = os.path.join(SRC, 'MOTION', 'HERO', 'pavilion.mp4')

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
# THREE CURVES, AND THIS IS THE FIRST PAGE THAT NEEDED MORE THAN ONE.
#
# GRADE is build_club_media.py's own — about eight percent off the highlights
# and five off the midtones — and it is used here on the one interior that is
# not dark to begin with.
#
# DUSK AND EVENING ARE DEEPER, AND THEY TILT. They exist for a single problem
# this page has and no page before it did: this is a near-black film, and three
# of its pictures were taken in daylight — a white geodesic dome on a mown lawn,
# and the real house against a blue sky. Measured, those are the brightest
# objects anywhere in the library. Pulled down they read as the end of an
# afternoon rather than as holes punched in the page.
#
# THE TILT IS THE PART WORTH ARGUING WITH. build_club_media.py's curve is
# neutral: one 256-entry table applied to all three channels, so a picture only
# gets darker. That is right for an interior lit by candles, whose highlights
# are already warm. It is wrong for an overcast northern daylight, whose
# highlights are blue: pulled down neutrally, a white dome under a grey sky
# becomes a GREY dome under a grey sky, and grey is the one colour this palette
# does not contain. So the blue channel comes down about twelve percent further
# than the red and the green about four, which is what a warm evening does to a
# cool photograph. It is a grade and not a recolour — no hue is invented, the
# existing ones are weighted — and it is declared here rather than baked into
# an export nobody can re-read.
#
#   (mid, high)           the curve, as build_club_media.py writes it
#   (mid, high, (r,g,b))  the same curve, with a per-channel weight after it
#
# WHICH PICTURE GETS WHICH IS A MEASUREMENT AND NOT A TASTE. Every plate on this
# page was exported, its mean luminance taken, and the curve chosen so that no
# picture in a group arrives more than about half again as bright as the darkest
# one beside it. The four world tiles land between 19 and 36, the six dialogue
# rooms between 24 and 56, the two plates at 20 and 24. The numbers, before and
# after, are in docs/EVENTS.md §5.
# ---------------------------------------------------------------------------

GRADE = (0.475, 0.92)                          # 0.5 -> 0.475, 1.0 -> 0.92
DUSK = (0.34, 0.66, (1.0, 0.965, 0.88))        # the pavilion in daylight
EVENING = (0.28, 0.52, (1.0, 0.95, 0.85))      # a cream interior lit at noon
NIGHT = (0.18, 0.34, (1.0, 0.94, 0.82))        # the house against a blue sky


def grade_lut(points):
    """A 256-entry curve per channel, through (0,0), (0.5, mid), (1, high)."""
    mid, high = points[0], points[1]
    tilt = points[2] if len(points) > 2 else (1.0, 1.0, 1.0)

    lut = []

    for channel in range(3):
        for i in range(256):
            x = i / 255.0

            if x <= 0.5:
                y = x / 0.5 * mid
            else:
                y = mid + (x - 0.5) / 0.5 * (high - mid)

            lut.append(max(0, min(255, int(round(y * 255 * tilt[channel])))))

    return lut


# ---------------------------------------------------------------------------
# 2. The plates
#
#   stem : (source, ratio, widths, bias, graded, why)
#
# THE BAND LADDER IS [768, 1152] AND IT IS NOT A CHOICE MADE HERE.
# film-band.php asks img() for exactly those two rungs at every ratio, and
# film-dialogue.php asks for the same two, so a third export would be a file on
# disk that the page never requests — which is one of the two things the
# build-versus-page check in docs/EVENTS.md counts.
# ---------------------------------------------------------------------------

PLATES = {

    # -- Scene 01: the pavilion, in the afternoon ---------------------------

    'events/pavilion-day': (
        'pavilion/pavilion_2.jpg', (16, 9), [768, 1152], 0.92, DUSK,
        'THE ONLY DAYLIGHT PICTURE ON THE PAGE AND THE ONLY ONE THAT SHOWS '
        'WHERE THE PAVILION STANDS. Taken low out of a portrait frame — bias '
        '0.92 — so the band is the lawn, the brick path, the ceremony chairs '
        'at the left and the dome at the right, with the pines standing over '
        'all of it; a centred crop of the same negative is trees and no '
        'pavilion. GRADED TO DUSK: see the note above. It is also the start '
        'image of ev-dusk, which is the point of the scene after it — the same '
        'composition, an hour later — and that sequence carries a matching '
        'grade at encode so the still and the film start at the same '
        'exposure.'),

    # -- Scene 05: the estate at dusk ---------------------------------------

    'events/pavilion-air': (
        'pavilion/pavilion_1.jpg', (16, 9), [768, 1152], 0.50, GRADE,
        'THE PICTURE THE HERO ARRIVES AT, held back five scenes. The dome lit '
        'from within beside the long event building, the festoon-lit lawn and '
        'its cocktail tables, shot from the air at night — the same evening '
        'and the same two buildings as the hero film, seen whole. 1637x961 is '
        'already close to 16:9 so almost nothing is cropped, and it is not '
        'graded: it was made dark.'),

    # -- Scene 03: two plates -----------------------------------------------

    'events/arrival-desk': (
        'ESTATE_and_HOSPITALITY/reception_concierge.png', (4, 5), [640, 960], 0.28, False,
        'THE FIRST THING AN ARRIVING GUEST SPEAKS TO. Taken high, because the '
        'crest and the wordmark on the panelling behind the desk are the top '
        'of the composition and a centred 4:5 out of a square would trade them '
        'for floor. THIS FILE HAS NEVER BEEN CUT AS A STILL — it is the source '
        'of the Main Page\'s seq-arrival sequence, which is not the same thing '
        'as a picture of it.'),

    'events/detail-lamp': (
        'CIGAR_HOUSE/atmospheric_details.png', (3, 2), [640, 960], 0.42, False,
        'WHERE THE EVENING GOES WHEN IT LEAVES THE LAWN: two buttoned leather '
        'chairs drawn up either side of a lamp and a portrait. A little above '
        'centre so the lamp and the picture are in the frame and the carpet is '
        'not. NEVER USED ANYWHERE BEFORE.'),

    # -- Scene 07: six kinds of evening, as the dialogue's six rooms --------
    #
    # Six pictures at 16:9, and not one of them is the same file at the same
    # ratio as any of THE CLUB's four dialogue rooms — which are
    # grand_dining_room, outdoor_terrace, HOUSE_OF_DIALOGUE/1 and /3. Two
    # sections that look alike are one section done twice.

    'events/kind-wedding': (
        'MOTION/events/still-wedding.png', (16, 9), [768, 1152], 0.50, False,
        'THE INSIDE OF THE DOME, LAID FOR A DINNER, AT NIGHT — and it is the '
        'one picture on this page that was generated because a grade could not '
        'save the photograph it came from. media_src/pavilion/pavilion_3.jpg is '
        'the only photograph in existence of this pavilion in use, it had never '
        'been used anywhere, and it is an overcast midday interior: white linen, '
        'white chairs, pale blue sashes and a mirror ball. Three curves were '
        'tried on it, down to half the luminance of anything else on the page, '
        'and every one of them produced a MURKY pale-blue wedding banquet rather '
        'than an evening — because the colours the brief rules out by name are '
        'in the objects, not in the exposure. So the photograph became the '
        'reference for a GPT Image 2 still that changed the hour and the '
        'dressing and nothing else: same dome, same frame members, same camera '
        'position, same tables, same floral arch. The prompt is below. The '
        'photograph is still in media_src and this page still descends from '
        'it — see docs/EVENTS.md §3 and §8.'),

    'events/kind-dining': (
        'RESTAURANT/chefs_room.png', (16, 9), [768, 1152], 0.44, False,
        'The small green room with the fire lit and three tables in it. The '
        'Main Page uses this file at 3:2; this is the wide cut of it.'),

    'events/kind-corporate': (
        'RESTAURANT/dining_salon.png', (16, 9), [768, 1152], 0.40, GRADE,
        'The panelled salon under its chandelier, round tables the length of '
        'it. High, because the chandelier is the top of the composition. The '
        'Main Page uses this file at 4:5.'),

    'events/kind-culture': (
        'CIGAR_HOUSE/vip_room.png', (16, 9), [768, 1152], 0.34, False,
        'A smaller panelled room: four leather armchairs round one low table, '
        'portraits, a fire. High, for the chandelier and the pictures. The '
        'Main Page uses this file at 4:5.'),

    'events/kind-members': (
        'PRIVATE_CLUB_ECOSYSTEM/4.png', (16, 9), [768, 1152], 0.30, False,
        'THE ONE TILE WITH PEOPLE IN IT, and they are at the far side of a '
        'room with their backs half turned. High, so the chandelier and the '
        'panelling stand over them rather than the carpet. THE CLUB uses this '
        'file at 3:2 and the Main Page at 4:5; neither is this picture.'),

    'events/kind-seasonal': (
        'RESTAURANT/majestic_lobby.png', (16, 9), [768, 1152], 0.34, EVENING,
        'The cream hall with the chandelier and the flowers on the centre '
        'table. THE ONE INTERIOR ON THE PAGE THAT IS NOT DARK — cream walls, '
        'a marble floor and a lit crystal chandelier — and at its own exposure '
        'it measures 81 against a group of six that otherwise runs 24 to 59. '
        'The club grade takes it to 77, which is not enough; EVENING takes it '
        'to 44 and it reads as the same hall in the evening. The Main Page uses '
        'this file at 4:5.'),

    # -- Scene 08: the rest of the estate -----------------------------------
    #
    # Four tiles, four pages, and four crops no other page has cut. Two of the
    # four files have never been used anywhere at all.

    'events/world-estate': (
        'estate/estate_1.jpg', (4, 5), [640], 0.30, NIGHT,
        'THE REAL HOUSE, PHOTOGRAPHED. The one external shot of Majori Manor '
        'in the library, taken high so the roof, the chimneys and the pediment '
        'carry the tile. It is the only picture on this page that is a '
        'photograph of the estate as it stands, and it was shot at noon under '
        'a blue sky, so it carries the deepest curve on the page — beside '
        'three near-black tiles an unfiltered midday photograph is not a '
        'fourth tile, it is a light left on. A 1628-wide landscape cut to 4:5 '
        'is 773 across, so it ships at 640 and no higher; nothing here is '
        'upscaled.'),

    'events/world-club': (
        'PRIVATE_CLUB_ECOSYSTEM/6.png', (4, 5), [640, 960], 0.34, False,
        'The bar under its lamps, the bottles ranked behind it. NEVER USED '
        'ANYWHERE BEFORE. High, because the shelves are the picture and the '
        'stools are the foreground.'),

    'events/world-padel': (
        'PRIVATE_CLUB_ECOSYSTEM/1.png', (4, 5), [640, 960], 0.50, False,
        'The glazed courts at night, cut tall out of the 21:9 panorama PADEL '
        'sets edge to edge. Same file, and not the same picture: that page '
        'uses its width, this uses one bay of it.'),

    'events/world-dark': (
        'ESTATE_and_HOSPITALITY/CIGAR_LOUNGE.png', (4, 5), [640], 0.30, False,
        'The dark panelled room with the fire lit and the portraits over it. '
        'NEVER USED ANYWHERE BEFORE. A 1449-wide frame cut to 4:5 is 869 '
        'across, so it ships at 640 alone.'),
}


# ---------------------------------------------------------------------------
# 3. The sequences
#
#   name : (ratio, poster widths, trim seconds or None, grade or None, source, motion)
#
# TRIM IS THE ONE EDITORIAL DECISION MADE AFTER THE GENERATION AND IT COSTS
# NOTHING. Seedance returns five seconds and a five-second dolly does not
# accelerate evenly: three of these four hold their framing the whole way, and
# one — ev-celebrate — arrives so far forward in the last second that two of the
# guests become portraits, which is the one thing the brief for this page rules
# out by name. The answer is a shorter shot rather than another generation: the
# master keeps its five seconds, the encode takes the first 3.6 of them, and the
# palindrome makes a 7.2-second loop out of what is left. Nothing was
# regenerated and no credit was spent on it.
#
# 'source' is the media_src reference the sequence descends from. One of them
# descends through a GPT Image 2 still: the still was made FROM the file named
# here and moved the camera, and nothing else. The still is in
# media_src/MOTION/events/ and its prompt is below and in docs/EVENTS.md §3.
# ---------------------------------------------------------------------------

# THE PROMPTS, VERBATIM, because a prompt is the only part of a generated asset
# that cannot be recovered by looking at it. Every one is written as a
# PRESERVATION instruction rather than a description: it names the architecture,
# the landscaping and the materials of that specific frame, states the one thing
# that may change, lists the motion that is allowed, and then says what may not
# appear. The negative half is the half that does the work. Same shape as
# tools/photos/build_padel_media.py and tools/motion/build_sequences.sh.
#
# ---- The crops the generations start from ---------------------------------
#
# ref-day      pavilion/pavilion_2.jpg, 16:9 low crop, bias 0.92 (1182x665)
#              — the same crop that is exported as events/pavilion-day, before
#                the grade. THE STILL AND THE SEQUENCE ARE THE SAME PICTURE,
#                which is the whole design of scenes 01 and 02.
# ref-table    ESTATE_and_HOSPITALITY/Restaurant_1.png, 16:9 crop, bias 0.40
#              (1396x785)
# ref-celebr   PRIVATE_CLUB_ECOSYSTEM/2.png, 16:9 crop, bias 0.45 (2304x1296)
# ref-gather   pavilion/pavilion_1.jpg, whole frame (1637x961)
#
# ---- GPT Image 2, 2K, high, 16:9, from a reference ------------------------
#
# still-gathering  <- ref-gather
#   "Recompose this exact place as a photograph taken standing on the lawn at
#    eye level, preserving every structure and material exactly as it appears.
#    Keep: the large geodesic glass-and-steel dome lit warmly from within with
#    its dense strings of small warm lights inside, its triangular glazing
#    pattern and its arched doorway; the long single-storey event building
#    beside it with its dark tiled roof, pale plaster walls and exposed brick
#    piers, its tall arched openings and the warm-lit interior behind them with
#    round tables in white linen; the pale paved path running along the
#    building; the mown lawn; the tall round cocktail tables with floor-length
#    pale linen covers; the closed cream parasols; the small young trees planted
#    in the grass; the strings of warm festoon lights hung on slim poles across
#    the lawn; the dark pine trees behind; the night sky. Change only the
#    camera: it now stands on the lawn among the cocktail tables at a person's
#    eye height, looking along the lawn with the lit dome to the left and the
#    long building to the right, the festoon lights overhead. Add a small number
#    of guests in restrained dark evening dress standing in twos and threes
#    among the cocktail tables, all of them at a distance and seen from behind
#    or in profile, quiet and unposed, none facing the camera, no close-ups, no
#    faces in focus. No new buildings, structures, marquees, furniture, signage
#    or lettering. No redesign of the dome, the building or the landscaping. No
#    confetti, no dance floor, no stage, no lasers, no fireworks, no coloured
#    lighting. Restrained European private-estate hospitality photography, warm
#    practical light against a deep night sky, natural colour, unstaged, no lens
#    flare, no HDR."
#
#   THE CAMERA CAME DOWN OFF THE DRONE AND NOTHING ELSE CHANGED. Every
#   photograph of this pavilion in the library was taken from the air; a page
#   whose argument is that a reader can imagine their own evening here has to be
#   able to stand them on the grass. Every object the prompt names is an object
#   already in pavilion_1.jpg, and the guests are the one addition — which is
#   also the one thing the brief for this page asks for by name, at exactly this
#   distance and with exactly these backs turned.
#
# still-wedding  <- pavilion/pavilion_3.jpg (whole frame)
#   "Preserve this exact geodesic glass pavilion precisely and change only the
#    hour and the dressing. Keep every structural element exactly as
#    photographed: the triangulated glass-and-steel dome with its slender frame
#    members and their node connectors, the clear glazing panels, the horizontal
#    steel ring beam running round the wall, the trees standing close outside the
#    glass on every side, the flat dark floor of the dance area at the centre,
#    the round tables arranged in an arc to left and right, the long top table
#    across the far side, the tall floral columns standing on the tables, and the
#    exact proportions and camera position of the room. Change the light: it is
#    now late evening, after dark. The sky beyond the glass is deep blue-black
#    and the trees outside are dark shapes; the room is lit only by its own light
#    — clusters of lit candles on every table, tall lit tapers in the floral
#    columns, warm strings of small lights threaded across the inside of the
#    dome, and a brass candle chandelier hanging at the centre where the mirror
#    ball was. Change the dressing to a warm restrained palette: cream and ivory
#    linen with no coloured sashes, bows or ribbons on the chairs, dark timber
#    chiavari chairs instead of white ones, ivory flowers and dark green foliage
#    in the arrangements instead of pale blue. Remove the mirror ball, the
#    loudspeakers and the hanging panels. No new architecture. No new buildings,
#    structures, marquees or rooms. No redesign of the dome, its frame or its
#    proportions. No people. No confetti, no fireworks, no lasers, no coloured
#    party lighting, no stage, no signage or lettering. Restrained European
#    private-estate photography, warm candlelight against a night sky, natural
#    colour, unstaged, no lens flare, no HDR."
#
#   THE HOUR AND THE DRESSING CHANGED AND THE BUILDING DID NOT. Every noun the
#   prompt keeps is a noun in the reference, and the two it replaces — white
#   chairs for dark timber, pale blue sashes for none at all — are the two the
#   brief for this page rules out by name. Nothing about the dome moved: the
#   frame, the ring beam, the arc of tables, the top table and the floral arch
#   are where the photograph put them, which is the test this page applies to
#   every generation on it.
#
# ---- Seedance 2.0, 720p, 16:9, 5s, no audio, start_image ------------------
#
# START_IMAGE AND NOT image_references, ON ALL FOUR. The reference is the first
# frame of the generation rather than a mood for it, which is the only setting
# under which a geodesic frame, a chandelier and a laid table survive five
# seconds of camera movement intact. It is also what makes the poster honest:
# frame 0 of the encode is the reference, so the still and the film cannot
# re-frame against each other when the video fades up.
#
# ev-dusk  <- ref-day
#   "Continuous cinematic transition from late afternoon into blue hour over
#    this exact glass pavilion in its park. Preserve everything as photographed:
#    the large geodesic dome of glass and white steel with its triangular
#    glazing pattern and its curved arched entrance, standing on the mown lawn;
#    the dense stand of tall straight pine trees behind and to the left with
#    their bare trunks and high crowns; the brick-paved path running diagonally
#    across the lawn; the pale paved terrace at the foot of the dome with its
#    low benches; the folding white chairs and the small draped tables set out
#    on the grass at the far left; the two figures standing together on the
#    path; the dark grey sofa on the grass; the low speaker stands. The only
#    change is the light and the hour: the low sun leaves the treetops, the warm
#    gold on the pines fades, the sky deepens slowly from pale evening into a
#    deep blue hour, the lawn cools, and warm light comes up gradually inside
#    the dome so that it begins to glow from within, with small warm lights
#    appearing along the path and among the trees. The only motion: an extremely
#    slow forward drift of the camera over the lawn, the pine crowns stirring
#    faintly in the evening air, the two figures on the path standing almost
#    still. No new people entering the frame. No new buildings, structures,
#    marquees, tents, furniture, signage or lettering. No redesign of the dome,
#    the path, the planting or the landscaping. Restrained European
#    private-estate architectural cinematography, one continuous shot, no cuts,
#    no camera shake, no zoom snap, no lens flare, no time-lapse stutter."
#
#   THE ONE SEQUENCE ON THE SITE WHOSE SUBJECT IS TIME. Every other one holds an
#   hour and moves a camera through it. This one is asked to change the hour
#   while the camera barely moves, because the scene it carries is the hinge of
#   the whole page: the afternoon the reader has just been shown, going over
#   into the evening the rest of the page is about.
#
# ev-table  <- ref-table
#   "Extremely slow cinematic dolly forward through this exact dining room by
#    candlelight. Preserve everything as photographed: the dark carved timber
#    panelling and pilasters; the brass and crystal candle chandelier hanging at
#    the centre; the gilt-framed portraits and landscapes on the walls; the tall
#    shuttered windows and the mirrored overmantel; the stone chimneypiece; the
#    round tables laid with cream linen, polished silver, cut-glass wine glasses
#    and lit candles; the dark leather and timber dining chairs; the pleated
#    silk table lamps on the side tables; the patterned carpet and the parquet
#    floor. The only motion: a very gradual dolly forward down the room between
#    the tables, gentle parallax between the foreground table and the room
#    beyond, the candle flames moving and breathing, the lamplight shifting very
#    slightly, faint reflections travelling across the glassware and the
#    polished silver. No people entering the frame. No new furniture, rooms,
#    doors, windows, paintings, signage or lettering. No redesign of the room,
#    the panelling or the table settings. Restrained European private-estate
#    hospitality cinematography, warm candlelight against dark wood, one
#    continuous shot, no cuts, no camera shake, no zoom snap, no lens flare."
#
#   NOBODY IS IN THE ROOM AND THAT IS THE SCENE. The brief asks for conversation
#   in the background here; the reference has no one in it, and putting people
#   into a dining room by prompt is the one thing this model reliably gets wrong
#   — it invents faces. The scene either side of it is full of guests, so the
#   room can be the room: a table laid and waiting, between the gathering that
#   comes to it and the celebration that leaves it.
#
# ev-celebrate  <- ref-celebr
#   "Extremely slow cinematic move inside this exact glass pavilion during an
#    evening celebration. Preserve everything as photographed: the geodesic dome
#    of glass and dark steel with its triangular framing and the dense strings
#    of small warm lights threaded across the whole of it; the brass candle
#    chandelier hanging at the centre; the round tables laid with pale linen,
#    glassware, low flowers and clusters of lit candles; the dark timber
#    chiavari chairs; the timber floor; the guests in restrained dark evening
#    dress standing and seated around the tables; the dark trees and the night
#    beyond the glass. The only motion: the camera drifts forward and very
#    slightly to the right among the tables; the guests move naturally and
#    unhurriedly, turning to one another in conversation, lifting and setting
#    down glasses, one or two walking slowly between the tables; the candle
#    flames move; the strings of lights and the chandelier reflect and shift
#    gently on the glass panels overhead. No crowd of new people entering the
#    frame. No close-up faces. No new buildings, structures, marquees,
#    furniture, signage or lettering. No redesign of the pavilion or the table
#    settings. No dancing, no confetti, no fireworks, no lasers, no coloured
#    party lighting, no stage. Restrained European private-estate celebration
#    cinematography, warm candlelight and warm string light against a night sky,
#    one continuous shot, no cuts, no camera shake, no zoom snap, no lens
#    flare."
#
# ev-gather  <- still-gathering
#   "Extremely slow cinematic drift across this exact lawn on a summer night as
#    guests gather before dinner. Preserve everything as photographed: the large
#    geodesic glass dome at the left, lit warmly from within with dense strings
#    of small warm lights inside it and its arched doorway; the long
#    single-storey building at the right with its dark tiled roof, pale plaster
#    and exposed brick piers, its tall arched openings and the warm-lit interior
#    behind them with round tables in white linen; the pale paved path along the
#    building; the mown lawn; the tall round cocktail tables with floor-length
#    pale linen covers; the closed cream parasols; the small young trees planted
#    in the grass; the strings of warm festoon lights hung across the lawn on
#    their slim poles; the dark pines behind; the night sky. The only motion: a
#    very gradual lateral drift of the camera to the right across the lawn with
#    gentle parallax between the foreground cocktail tables and the buildings
#    beyond; the guests already in the frame moving naturally and unhurriedly,
#    turning to one another in conversation, lifting and setting down glasses,
#    one or two walking slowly between the tables; the festoon lights swaying
#    almost imperceptibly; the pine crowns stirring faintly; warm light breathing
#    very gently inside the dome and behind the arches. No new people entering
#    the frame. No faces turning to the camera, no close-ups. No new buildings,
#    structures, marquees, tents, furniture, signage or lettering. No redesign of
#    the dome, the building or the landscaping. No dancing, no confetti, no
#    fireworks, no lasers, no coloured party lighting. Restrained European
#    private-estate hospitality cinematography, warm practical light against a
#    deep night sky, one continuous shot, no cuts, no camera shake, no zoom snap,
#    no lens flare."

# ONE SEQUENCE CARRIES A GRADE AND IT IS THE SAME DECISION events/pavilion-day
# CARRIES ONE. That plate is the still of scene 01; ev-dusk is the film of scene
# 02 and it starts from the identical crop, ungraded. Print the plate at DUSK and
# leave the film alone and the page brightens as it goes from the first scene to
# the second — the one thing this film may not do. So the encode carries the
# curve the plate carries, in ffmpeg's terms rather than Pillow's, and the two
# were matched by measurement rather than by eye: mean luminance of
# events/pavilion-day-1152.jpg against mean luminance of frame 0 of
# ev-dusk.mp4. The numbers are in docs/EVENTS.md §5.
#
# IT IS A UNIFORM CURVE OVER A SHOT WHOSE SUBJECT IS CHANGING LIGHT, and that is
# deliberate: taking the same amount off every frame moves the whole shot down
# and leaves the transition inside it exactly as generated.
DUSK_ENCODE = 'eq=brightness=-0.115:contrast=0.90:saturation=0.90,colorbalance=bs=-0.06:bm=-0.05'

SEQUENCES = {
    'ev-dusk': (
        (16, 9), [768, 1152], None, DUSK_ENCODE,
        'pavilion/pavilion_2.jpg -> 16:9 low crop -> Seedance 2.0',
        'Late afternoon going over into blue hour on the pavilion; the camera '
        'barely moves and the light does all of it. GRADED to meet the still '
        'of scene 01 — see the note above.'),

    'ev-gather': (
        (16, 9), [768, 1152], None, None,
        'pavilion/pavilion_1.jpg -> GPT Image 2 eye-level still -> Seedance 2.0',
        'Slow lateral drift across the lawn among the cocktail tables, the '
        'guests turning to one another, the dome lit at the left.'),

    'ev-table': (
        (16, 9), [768, 1152], None, None,
        'ESTATE_and_HOSPITALITY/Restaurant_1.png -> 16:9 crop -> Seedance 2.0',
        'Slow dolly down the dining room between the laid tables, candle '
        'flames moving.'),

    'ev-celebrate': (
        (16, 9), [768, 1152], 3.6, None,
        'PRIVATE_CLUB_ECOSYSTEM/2.png -> 16:9 crop -> Seedance 2.0',
        'Slow forward move among the tables inside the lit dome, the guests '
        'moving naturally, reflections travelling on the glass. TRIMMED at '
        '3.6 s — see the note above SEQUENCES.'),
}

# THE HERO IS NOT IN SEQUENCES BECAUSE IT IS NOT ONE.
#
#   name, ratio, poster widths, source, grade
#
# It is supplied footage, it gets the wide-and-narrow pair the Main Page's hero
# gets, and it is the only film here that carries a grade. The reason is the
# same one docs/ASSET_MANIFEST.md gives for the earlier cut of this footage: the
# lit dome sits directly behind the hero copy, and ungraded the eyebrow measures
# well under AA against it. The curve holds the blacks, stops short of clipping
# the strings of lights inside the dome, and is applied at encode time — the
# master in media_src/ is untouched, which is what the brief for this page asks
# for in as many words.
HERO_NAME = 'ev-arrival'
HERO_RATIO = (16, 9)
HERO_POSTER_WIDTHS = [768, 1280]
HERO_GRADE = 'eq=brightness=-0.055:contrast=1.045:saturation=0.97'

# CRF 29 ON THE FOUR SECTION FILMS, which is PADEL's own number and for PADEL's
# own reason: these are night exteriors and candlelit interiors — moving
# foliage, several hundred point sources strung inside a glass dome, and a
# chandelier — which is the hardest material H.264 is ever given.
#
# AND THE HERO GOES TWO RUNGS FURTHER, to 31 wide and 32 narrow. It is 1280
# rather than 1152, it is the largest single file on the page, and it is the
# only one a reader meets before they have decided to stay. Same numbers as the
# Main Page's hero and PADEL's.
CRF_WIDE = 29
CRF_HERO = 31
CRF_NARROW = 32

# ---------------------------------------------------------------------------
# 4. The loop is a palindrome, and that is not a shortcut
#
# Every one of the five is a single continuous camera move that never returns to
# where it started, so no frame anywhere matches its own first frame. A hard cut
# back to frame 0 jumps, and on a shot this slow a jump is the only thing in it
# that moves quickly. A cross-dissolve is worse: dissolving a near framing into
# a far one ghosts the scene against itself, and on the hero that means two
# domes.
#
# So each one plays forward and then backwards — seamless by construction,
# because the last frame of the reverse IS the first frame of the forward, and
# no two framings are ever blended. This is tools/motion/build_sequences.sh's
# filter, verbatim, because it is the Main Page's answer to the same problem and
# there is no reason for two.
#
# ONE OF THE FIVE PAYS A PRICE FOR IT AND IT IS ev-dusk. A palindrome on a shot
# whose subject is the passage of time runs the evening backwards for the second
# half of the loop. It is still the right filter — the alternative is a visible
# cut from night back to afternoon every five seconds — and the loop reads as
# the light breathing rather than as a rewind, because the transition it makes
# is gradual at both ends. Recorded in docs/EVENTS.md §8.
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
    """Write the rungs that the crop is actually wide enough for, and only those."""
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

    prune(stem, written)

    return written


def prune(stem, keep):
    """Delete rungs of `stem` that this run did not write.

    A RE-RUN HAS TO BE IDEMPOTENT AND THAT IS NOT A CONVENIENCE. It is
    build_images.py's own rule and this page is the reason it exists: a slot
    moved from a 640/960 ladder to a 768/1152 one, and the four files from the
    old ladder sat on disk afterwards — the same photograph at a different crop,
    under the same stem, waiting for a content file to ask for both. img_files()
    reports what is really on disk, so two crops under one stem is one srcset
    made of two different pictures.

    It only ever touches <stem>-<digits>.<ext> for a stem this script declares,
    so nothing outside PLATES and SEQUENCES can be reached by it.
    """
    prefix = os.path.basename(stem) + '-'
    out_dir = os.path.join(IMG, os.path.dirname(stem))

    if not os.path.isdir(out_dir):
        return

    for name in os.listdir(out_dir):
        if not name.startswith(prefix):
            continue

        rung, dot, ext = name[len(prefix):].partition('.')

        if not dot or not rung.isdigit() or ext not in ('jpg', 'jpeg', 'webp'):
            continue

        if int(rung) not in keep:
            os.remove(os.path.join(out_dir, name))
            print(f'  pruned   {os.path.dirname(stem)}/{name}')


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

        print(f'  {stem:<24} <- {source:<48} '
              f'{cropped.width}x{cropped.height}{"  graded" if graded else "":9} {rungs}')


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


def build_hero():
    ff = ffmpeg()
    os.makedirs(VID, exist_ok=True)
    os.makedirs(MOTION, exist_ok=True)
    print('\nHERO — the supplied pavilion footage\n' + '-' * 78)

    if not os.path.isfile(HERO_SRC):
        print(f'  MISSING  {HERO_SRC}')
        return

    wide = os.path.join(VID, f'{HERO_NAME}.mp4')
    small = os.path.join(VID, f'{HERO_NAME}-sm.mp4')

    wide_bytes = encode(ff, HERO_SRC, wide, 1280, CRF_HERO, HERO_GRADE)
    small_bytes = encode(ff, HERO_SRC, small, 854, CRF_NARROW, HERO_GRADE)

    frame = os.path.join(MOTION, f'{HERO_NAME}-frame0.png')
    rungs = poster(ff, wide, f'events/{HERO_NAME}', HERO_RATIO,
                   HERO_POSTER_WIDTHS, frame)

    print(f'  {HERO_NAME:<13} {wide_bytes // 1024:>5} KB  '
          f'+ {small_bytes // 1024} KB narrow  poster {rungs}'
          f'  <- media_src/MOTION/HERO/pavilion.mp4 (supplied footage)')


def build_sequences():
    ff = ffmpeg()
    os.makedirs(VID, exist_ok=True)
    print('\nSEQUENCES — encodes and posters\n' + '-' * 78)

    for name, (ratio, widths, trim, grade, source, _motion) in SEQUENCES.items():
        master = os.path.join(MOTION, f'{name}.mp4')

        if not os.path.isfile(master):
            print(f'  MISSING  {master}')
            continue

        wide = os.path.join(VID, f'{name}.mp4')
        wide_bytes = encode(ff, master, wide, 1152, CRF_WIDE,
                            extra_filter=grade or '', trim=trim)
        line = f'  {name:<13} {wide_bytes // 1024:>5} KB'

        if trim:
            line += f'  trimmed {trim}s'

        if grade:
            line += '  graded'

        frame = os.path.join(MOTION, f'{name}-frame0.png')
        rungs = poster(ff, wide, f'events/{name}', ratio, widths, frame)

        print(f'{line}  poster {rungs}  <- {source}')


if __name__ == '__main__':
    build_plates()
    build_hero()
    build_sequences()
    print('\ndone.\n')
