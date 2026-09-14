"""
Build AFTER DARK's media from media_src/, one GPT Image 2 still and five
Seedance 2.0 sequences.

WHAT THIS IS. /after-dark declares its pictures by stem — after-dark/ad-salon,
after-dark/detail-humidor — and img() in app/helpers.php looks for
assets/img/<stem>-<width>.<ext>. This script is the mapping between the material
in media_src/ and those stems, and it is a script rather than a folder of
hand-cut exports for the reason the six build scripts before it are: every crop
is a decision, and a decision has to be re-readable and re-runnable.

THE SEVENTH FILM PAGE, AND THE FIRST WHOSE SUBJECT IS THE HOUR ITSELF. The Main
Page holds blue hour, THE ESTATE an afternoon, THE CLUB and EVENTS an evening,
PADEL the hour after sunset, RESIDENCES a whole day. This one is what happens
after all of those have finished: the estate turns inward, and the page is one
continuous descent from the last of the light to the middle of the night.

THIS PAGE IS THE CIGAR HOUSE'S PAGE, AND THAT IS AN AUDIT FINDING RATHER THAN A
PREFERENCE. Six pages have been cut out of media_src/ and CIGAR_HOUSE/ is the
directory they walked past: of its nine files, seven had been used exactly once
each and never at 16:9, never as a sequence and never as the subject of a scene.
Eight of the nine landscape rooms in the whole library that are still free at
16:9 are in that directory or are its two companions in
ESTATE_and_HOSPITALITY/. See docs/AFTER_DARK.md §2.

FOUR KINDS OF PICTURE COME OUT OF HERE AND THEY ARE FOUR DIFFERENT CLAIMS.

  PHOTOGRAPHS are crops of the supplied photography of the real house — the
  landing, and the garden front. Declared 'photo'.

  VISUALISATIONS are crops of the project's own renders — the whisky lounge, the
  cigar lounge, the manor bar, the humidor, the private room, the dining room,
  the great hall, the library, the stair, the park at night. Declared 'render'.

  POSTERS are frame 0 of a sequence, which is the reference the sequence started
  from, and are declared as whatever the sequence is: 'generated'.

  THE ONE GENERATED STILL is the GPT Image 2 picture below. It changes the hour
  of a photograph of the real house and nothing else, and it is the start image
  of the hero. Declared 'generated'.

WHAT IS NOT CLAIMED. Not one picture here is captioned as a room the estate has
open. The house is being restored; what exists is a building, a set of
visualisations of what will be in it, and one generation that moved the sun. The
captions say which is which, and no caption on this page names a service, an
hour, a bottle, a cigar or a game.

BIAS IS THE FRACTION OF THE SURPLUS TAKEN OFF THE TOP (or off the left, on a
frame too wide for its slot). 0.5 is a centre crop. Where a value is not 0.5 the
reason is written beside it.

NOTHING IS UPSCALED. A rung wider than the crop is skipped rather than
interpolated, so two of this page's plates ship at 640 alone — see
docs/AFTER_DARK.md §8.

Run from anywhere:  python3 tools/photos/build_after_dark_media.py
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

# The five sequences as they came back from Seedance, the four reference crops
# they started from and the one GPT Image 2 still.
#
# THE STILLS AND THE REFERENCE CROPS ARE COMMITTED AND THE .mp4 MASTERS ARE NOT,
# which is the repository's existing rule rather than a decision taken here:
# .gitignore carries /media_src/**/*.mp4 — the master stays on disk and in the
# backup, the encode under public_html/assets/video/ is the deliverable and that
# one is committed. So a fresh clone can rebuild every PLATE below, and
# rebuilding the SEQUENCES needs the masters restored to this directory first.
MOTION = os.path.join(SRC, 'MOTION', 'after-dark')

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
# THIS IS THE ONE PAGE WHOSE MATERIAL ARRIVED ALREADY AT ITS OWN HOUR, and the
# grades are therefore the lightest of the seven build scripts. Every room on
# this page is a room photographed at night: the CIGAR_HOUSE and
# ESTATE_and_HOSPITALITY visualisations are lit by lamps, fires and picture
# lights against dark timber and measure between 22 and 42 mean at their own
# exposure, which is where this film runs. Grading them would be taking a stop
# out of a photograph that was already exposed for the hour the page is set in.
#
# SO THE CURVES ARE HERE FOR THE THREE PICTURES THAT ARE NOT: the garden front
# of the real house, photographed at midday under a blue sky; the lit dome, which
# is the brightest visualisation in the library; and the first-floor landing,
# photographed in daylight. All three are world tiles standing in the last act
# on the darkest ground on the site, and at their own exposure they are not
# tiles, they are three lights left on.
#
#   (mid, high)           the curve, as build_club_media.py writes it
#   (mid, high, (r,g,b))  the same curve, with a per-channel weight after it
#
# WHICH PICTURE GETS WHICH IS A MEASUREMENT AND NOT A TASTE, which is
# build_events_media.py's rule and is kept: every plate was exported, its mean
# luminance taken, and the curve chosen so that no picture in a group arrives
# more than about half again as bright as the darkest one beside it. The
# numbers, before and after, are in docs/AFTER_DARK.md §5.
# ---------------------------------------------------------------------------

GRADE = (0.475, 0.92)                          # build_club_media.py's own
DEEP = (0.435, 0.83)                           # build_club_media.py's own
LOW = (0.30, 0.56)                             # a lit close-up, brought to the plateau
SHADE = (0.22, 0.40, (1.0, 0.95, 0.86))        # a lit room, seen from outside the hour
NIGHT = (0.15, 0.28, (1.0, 0.94, 0.82))        # build_residences_media.py's own
MIDNIGHT = (0.11, 0.21, (1.0, 0.93, 0.80))     # this page's floor — see below

# MIDNIGHT IS THIS PAGE'S ONE ADDITION TO THE CURVES AND IT EXISTS FOR ONE
# PICTURE. estate/estate_4.jpg is a white rendered manor house under a blue
# midday sky and it is measurably the brightest object in the library. EVENTS
# answered that problem with NIGHT and RESIDENCES took NIGHT for the same file's
# sibling; both of those tiles stand on --mm-evening, which is a wine ground.
# This page's world index stands on --mm-midnight, which is the darkest ground on
# the site, and a tile graded for wine reads as a hole punched in it. MIDNIGHT is
# NIGHT taken about a quarter further down with the blue channel two points
# cooler, which is the difference between a photograph taken at noon and a
# building seen from the far side of a dark lawn.


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
# film-band.php asks img() for exactly those two rungs at every ratio, so a third
# export would be a file on disk that the page never requests.
#
# NOT ONE CROP BELOW IS A CROP ANOTHER PAGE HAS ALREADY CUT. Every stem was
# checked against the six build scripts before it, file by file and ratio by
# ratio: same file at the same ratio is the same picture, and this page has none.
# Where a file is shared with an approved page the ratio is different and the
# note says which page holds the other one.
#
# TWO FILES ARE USED TWICE HERE, DELIBERATELY, AND BOTH ARE NOTED ON THEIR OWN
# ENTRIES: CIGAR_HOUSE/cigar_lounge.png is the silent band at 16:9 and one
# detail frame at 3:4, and estate/estate_4.jpg is the hero's reference and the
# first world tile. That is build_residences_media.py's own precedent with
# interiors_9.png and SECOND_BUILDING_GUEST_SUITES.png: a wide frame and a tall
# frame out of one negative are two photographs, not one photograph twice.
# ---------------------------------------------------------------------------

PLATES = {

    # -- Scene 04: the quieter side -----------------------------------------
    #
    # THE ONE FULL SCREEN ON THIS PAGE THAT DOES NOT MOVE BY ITSELF, and the one
    # with nothing written on it. after-dark.js gives it the only camera a still
    # can honestly have, a very slow scale scrubbed to the scroll.

    'after-dark/quiet': (
        'CIGAR_HOUSE/cigar_lounge.png', (16, 9), [768, 1152], 0.44, DEEP,
        'THE CIGAR LOUNGE WITH THE FIRE LIT: leather either side of it, the '
        'glazed cabinet of cigars at the right, framed pictures over the '
        'panelling and two lamps. NEVER CUT AT THIS RATIO AND NEVER MOVED — '
        'PADEL takes this file at 4:5 for a world tile and nothing else has '
        'touched it. A shade above centre so the chimneypiece and the pictures '
        'are in the band and the rug is not. Ungraded: it arrived at the hour '
        'this page is set in.'),

    # -- Scene 03: the detail track -----------------------------------------
    #
    # FOUR OF THE SIX CARRY A SECOND RUNG THAT IS NOT ON THE SITE'S LADDER, AND
    # THE NUMBER IS THE CROP'S OWN WIDTH. Every other detail track on this site
    # ships [640, 960]; four of these six are cut out of 2592x1152 and 1402x1122
    # panoramas, and a 3:4 crop of a frame that is only 1152 tall is 864 across —
    # 96px short of the rung above it. The rule is that nothing is upscaled, so
    # the honest choices were 640 alone or 640 and the native width.
    #
    # club.css sizes a track frame at clamp(13rem, ..., 26rem), which is 416
    # CSS pixels at its widest and therefore 832 device pixels on a 2x screen.
    # 640 is 23% short of that on exactly the component a reader leans in at;
    # 864 covers it. So the ladder is [640, <native>] and the content file
    # declares the same pair, because img() builds a srcset from what is on disk
    # and a rung nobody asked for is a file nobody fetches.

    #
    # Six frames at 3:4, and not one of them is the same file at the same ratio
    # as any of THE CLUB's six — interiors_5, _14, _7, _11, _6 and _10 — or of
    # RESIDENCES' six. Five of the six come out of the cigar house, which is
    # what this scene is about; the sixth is the stair that gets you there.

    'after-dark/detail-humidor': (
        'CIGAR_HOUSE/humidor_display.png', (3, 4), [640, 864], 0.10, LOW,
        'THE OPEN HUMIDOR DRAWERS, cut tall out of the left of a 2592x1152 '
        'panorama. The Main Page keeps this file whole at 21:9 because it is a '
        'wall of drawers; this is one cabinet of it. Far left, because that is '
        'where the open drawers are and the lit table at the right is a '
        'different picture.'),

    'after-dark/detail-bar': (
        'ESTATE_and_HOSPITALITY/MANOR_BAR.png', (3, 4), [640, 842], 0.50, False,
        'THE MAHOGANY BAR AND THE RANKED BOTTLES BEHIND IT, cut tall. The Main '
        'Page uses this file at 3:2, which is the room; this is the height of '
        'it — the shelves, the counter and the stools in one column. Centred, '
        'because the bar runs the width of the frame.'),

    'after-dark/detail-whisky': (
        'CIGAR_HOUSE/whisky_collection.png', (3, 4), [640, 864], 0.115, LOW,
        'ONE GLASS, PUT DOWN, WITH THE SHELVES OUT OF FOCUS BEHIND IT — and '
        'the bias is a content rule rather than a composition. This panorama '
        'has two labelled bottles standing in the middle of it, and at 864px '
        'the label, the expression and the age on both of them are fully '
        'legible. content/en/after_dark.php has forbidden a named whisky since '
        'the page was first written: "a named whisky is a promise that a '
        'particular bottle is on a particular shelf in a room that is not '
        'finished". A 2592-wide frame cut to 864 leaves 1728px of travel, so '
        'the answer was to move rather than to drop the frame: bias 0.115 is '
        'the left-hand glass on the dark bar top with nothing but bokeh behind '
        'it, and there is no readable lettering anywhere in it. RESIDENCES '
        'takes this file at 4:5 from the middle, which is a different picture '
        'and a different page. LOW, from 46.3 to the track plateau.'),

    'after-dark/detail-chair': (
        'CIGAR_HOUSE/atmospheric_details.png', (3, 4), [640, 864], 0.28, False,
        'ONE BUTTONED LEATHER CHAIR, THE LAMP BESIDE IT AND THE PORTRAIT OVER '
        'IT. EVENTS takes this file at 3:2, which is two chairs and the lamp '
        'between them; this is one chair and what is above it. Left of centre, '
        'for the portrait and the shade.'),

    'after-dark/detail-cabinet': (
        'CIGAR_HOUSE/cigar_lounge.png', (3, 4), [640, 960], 0.80, False,
        'THE GLAZED CABINET AT THE RIGHT OF THE SAME LOUNGE, with the framed '
        'pictures over it. The same negative as after-dark/quiet above and not '
        'the same picture: that one is the room at 16:9 and this is the '
        'right-hand eighth of it, cut tall. 2048px of width against a 1020px '
        'crop is what makes two frames out of one file honest.'),

    'after-dark/detail-stair': (
        'HOUSE_OF_DIALOGUE/3.png', (3, 4), [640, 960], 0.26, DEEP,
        'THE STAIR AND THE PORTRAITS CLIMBING THE WALL BESIDE IT, in lamplight. '
        'The Main Page uses this file at 4:5 and THE CLUB at 16:9; 3:4 has '
        'never been cut. High, because the portraits are the subject and the '
        'treads are not.'),

    # -- Private gaming: gated, and one picture -----------------------------
    #
    # THE PLATE IS BUILT WHETHER OR NOT THE SECTION IS SWITCHED ON, and that is
    # deliberate. ENABLE_GAMING is a rendering decision taken in the content
    # file at request time; whether a file exists on disk is not the gate, and
    # making it one would mean the layout could not be reviewed without a
    # rebuild. Nothing links to it and no page requests it while the flag is
    # false. See the note at the top of content/en/after_dark.php.

    'after-dark/gaming-room': (
        'CIGAR_HOUSE/vip_room.png', (3, 2), [640, 960, 1280], 0.50, False,
        'THE SMALL PANELLED PRIVATE ROOM: dark green panelling, four leather '
        'armchairs round one low table, oil portraits, a chandelier and two '
        'lamps. The Main Page uses this file at 4:5, EVENTS at 16:9 and THE '
        'CLUB moves it; 3:2 has never been cut. Centred. THERE IS NO TABLE, NO '
        'FELT AND NO GAME IN THIS FRAME, and that is the whole reason it is the '
        'right one — see content/en/after_dark.php.'),

    # -- Scene 06: the conversation -----------------------------------------

    'after-dark/talk-hall': (
        'HOUSE_OF_DIALOGUE/1.png', (3, 2), [640, 960, 1280], 0.50, DEEP,
        'THE GREAT HALL AT NIGHT, with people standing about it in evening '
        'dress at a distance and none of them looking at the camera. The Main '
        'Page and THE CLUB both take this file at 16:9, which is the length of '
        'the hall; 3:2 has never been cut and is the same conversation with the '
        'chandelier and the stair over it. Centred, because the groups are '
        'spread the whole width.'),

    'after-dark/talk-library': (
        'HOUSE_OF_DIALOGUE/2.png', (3, 2), [640, 960], 0.34, False,
        'THE LIBRARY WITH THE FIRE LIT, the bookcases either side and the '
        'portrait over the chimneypiece. The Main Page uses this file at 4:5 '
        'and THE CLUB at 16:9; 3:2 has never been cut. A little above centre, '
        'so the portrait is in the frame and the carpet is not.'),

    # -- Scene 08: the rest of the estate -----------------------------------
    #
    # Four tiles, four pages, four crops no other page has cut — and three of
    # the four carry a curve, because three of the four were photographed with
    # the lights on somewhere other than this hour.

    'after-dark/world-estate': (
        'estate/estate_4.jpg', (4, 5), [640], 0.30, MIDNIGHT,
        'THE GARDEN FRONT OF THE REAL HOUSE, cut tall. THE ESTATE uses this '
        'file at 4:3 and RESIDENCES at 3:2; this is the portrait of it, and it '
        'is the same negative the hero was generated from — which is the point '
        'rather than an accident: the tile is the photograph, and the hero is '
        'that photograph with the sun taken out of it. MIDNIGHT, because a '
        'white rendered house under a noon sky is the brightest object in the '
        'library and this tile stands on the darkest ground on the site. A '
        '1055-wide frame cut to 4:5 is 797 across, so it ships at 640 alone.'),

    'after-dark/world-club': (
        'CIGAR_HOUSE/main_bar.png', (4, 5), [640, 960], 0.34, False,
        'THE LONG BAR UNDER ITS LAMPS with one figure behind it. THE CLUB uses '
        'this file at 3:2, which is the length of the bar; this is the height '
        'of it, and 1076px of width comes off to get there. High, because the '
        'ranked bottles and the panelling are the picture and the stools are '
        'the foreground.'),

    'after-dark/world-events': (
        'PRIVATE_CLUB_ECOSYSTEM/2.png', (4, 5), [640, 960], 0.72, SHADE,
        'THE LIT DOME FROM INSIDE IT, cut low: the laid tables, the candles and '
        'the guests, with the roof structure mostly out of frame. The Main Page '
        'takes this file at 4:5 from high up, where the dome itself is the '
        'subject; 870px of vertical surplus is what makes the top of a square '
        'and the bottom of it two photographs. NIGHT, because it is the '
        'brightest visualisation in the library.'),

    'after-dark/world-stay': (
        'interiors/interiors_9.png', (4, 5), [640, 960], 0.34, MIDNIGHT,
        'THE FIRST-FLOOR LANDING OF THE REAL HOUSE, with the corridor beyond '
        'the arches and the door standing open at the end of it. RESIDENCES '
        'uses this file at 3:4 and generated its hero from a 16:9 of it; 4:5 '
        'has never been cut. NIGHT, because the photograph was taken in '
        'daylight and this tile is the last picture on a page that has spent '
        'nine screens getting dark.'),
}


# ---------------------------------------------------------------------------
# 3. The sequences
#
#   name : (ratio, poster widths, trim seconds or None, grade or None, source, motion)
#
# 'source' is the media_src reference the sequence descends from. One of the five
# descends through a GPT Image 2 still: the still was made FROM the file named
# there and changed the hour, and nothing else. The still is in
# media_src/MOTION/after-dark/ and its prompt is below and in
# docs/AFTER_DARK.md §3.
# ---------------------------------------------------------------------------

# THE PROMPTS, VERBATIM, because a prompt is the only part of a generated asset
# that cannot be recovered by looking at it. Every one is written as a
# PRESERVATION instruction rather than a description: it names the architecture,
# the joinery and the materials of that specific frame, states the one thing
# that may change, lists the motion that is allowed, and then says what may not
# appear. The negative half is the half that does the work.
#
# ---- The crops the generations start from ---------------------------------
#
# ref-nightfall  estate/estate_4.jpg, 16:9 at bias 0.48 (1055x593) — the garden
#                front whole: the slate roof and its five chimneys, the dormer,
#                the brown-framed windows, the balcony on its curved bay, the
#                columned portico, the granite plinth, the young tree at the
#                left and a strip of mown lawn. THE ESTATE uses this file at
#                4:3 and RESIDENCES at 3:2; neither is this frame.
# ref-salon      CIGAR_HOUSE/whisky_lounge.png, 16:9 at bias 0.42 (2048x1152) —
#                the whole lounge: the coffered ceiling, the portrait over the
#                chimneypiece, the two lamps, the wall of lit shelves, the bar
#                and its stools, the chesterfields and the tray on the low
#                table. The Main Page uses this file at 3:2 and RESIDENCES at
#                4:5; NOTHING HAS EVER MOVED IT.
# ref-cigar      ESTATE_and_HOSPITALITY/CIGAR_LOUNGE.png, 16:9 at bias 0.46
#                (1449x815) — the three portraits, the two chimneypieces with
#                the fire in the right-hand one, the two lamps, the leather,
#                and the lit cigar resting on the marble table beside the glass.
#                EVENTS uses this file at 4:5 for a world tile; NOTHING HAS
#                EVER MOVED IT, AND THE SMOKE IS THE REASON IT SHOULD BE MOVED.
# ref-table      RESTAURANT/dining_salon2.png, 16:9 at bias 0.22 (2160x1215) —
#                the candle chandelier, the fire in the stone chimneypiece, the
#                portrait, the sconces and four tables laid with white cloths.
#                PADEL uses this file at 4:5; NOTHING HAS EVER MOVED IT.
# ref-garden     PRIVATE_CLUB_ECOSYSTEM/3.png, 16:9 at bias 0.42 (2048x1152) —
#                the wet path, the clipped box, the lamp standard, the rotunda
#                and the receding line of lamps. See the note under ad-garden.
#
# ---- GPT Image 2, 2K, high, 16:9, from a reference ------------------------
#
# still-nightfall  <- ref-nightfall
#   "Preserve this exact building precisely and change only the hour and the
#    light. Keep every element of the architecture exactly as photographed and
#    in exactly the same position, proportion and perspective: the long
#    two-storey manor house in pale cream render with its steep slate roof of
#    irregular weathered grey-green slates; the five tall pale rendered chimney
#    stacks along the ridge and the small hipped dormer window in the roof
#    slope; the deep eaves; the brown-framed timber windows in their several
#    sizes, the ground-floor bay with its many lights, and the first-floor
#    balcony with its brown curved iron balustrade carried on the curved bay
#    below it; the projecting columned portico at the right with its four white
#    columns, its moulded pediment and the round oculus window with its glazing
#    bars set in the pediment; the tall panelled timber entrance doors under the
#    portico and the stone steps up to them; the granite rubble stone plinth
#    running the length of the facade; the small young tree at the left and the
#    mown lawn in the foreground; the exact camera position and lens. Change the
#    light: it is now late evening, well after sunset, near the end of blue
#    hour. The sky is a deep near-black blue with the last of the light very low
#    behind the roofline. Warm lamplight fills the windows from inside the
#    house, some rooms brighter than others and several windows dark; warm low
#    uplighting grazes the white columns of the portico and the rendered wall, a
#    warm light burns under the portico over the entrance doors, and low warm
#    garden lighting catches the granite plinth and the edge of the lawn. The
#    cream render falls into cool shadow away from the lit windows, the slate
#    roof reads almost black against the sky, and the mown lawn in the
#    foreground goes into deep shadow. No people. No new architecture. No new
#    windows, doors, chimneys, dormers, wings, columns, balconies, railings,
#    terraces, paths, vehicles, furniture, signage or lettering. No redesign of
#    the roof, the render, the joinery, the portico or the plinth. No
#    floodlighting of the whole facade and no visible light fittings that are
#    not already implied. Restrained European private-estate architectural
#    photography at night, warm practical window light against a deep blue sky,
#    natural colour, unstaged, no lens flare, no HDR, no light trails."
#
#   THE SITE HAD NO NIGHT PHOTOGRAPH OF THE HOUSE AND NOW IT HAS ONE. That
#   absence is written down in the page this replaces and in
#   tools/photos/build_images.py: "after-dark/hero wants the manor at night and
#   NO NIGHT FRAME OF THE HOUSE EXISTS", and the slot has stood as a hatched box
#   ever since. The two night frames in the library are the pavilion, which is
#   EVENTS' subject and already opens two pages, and one interior. So the hour
#   was moved on the one wide photograph of the garden front, and every noun in
#   the prompt is a noun in estate_4.jpg.
#
#   WHAT THE MODEL ADDED, STATED RATHER THAN HIDDEN: the capitals of the four
#   portico columns came back with Ionic volutes where the photograph shows
#   plain Tuscan capitals, and the entrance under the portico came back as a
#   pair of panelled doors under a lantern where the photograph shows one
#   doorway in shadow. Both are small, both are at the far right of a frame
#   whose subject is the lit windows, and both were left rather than spend a
#   second generation on a detail that is 40px wide at the rung the hero ships
#   at. Recorded in docs/AFTER_DARK.md §8.
#
# ---- Seedance 2.0, 720p, 16:9, 5s, no audio, start_image ------------------
#
# START_IMAGE AND NOT image_references, ON ALL FIVE, which is the rule
# build_events_media.py set and build_residences_media.py kept: it is the only
# setting under which a coffered ceiling, a wall of ranked bottles and a laid
# table survive five seconds of camera movement intact. It is also what makes
# the poster honest — frame 0 of the encode IS the reference, so the still and
# the film cannot re-frame against each other when the video fades up.
#
# ad-nightfall  <- still-nightfall     THE HERO
#   "Extremely slow cinematic approach across the lawn toward this exact manor
#    house at night. Preserve everything as photographed and in exactly the same
#    position, proportion and perspective: the long two-storey manor house in
#    pale cream render with its steep dark slate roof; the five pale rendered
#    chimney stacks along the ridge and the small lit dormer window in the roof
#    slope; the brown-framed timber windows in their several sizes with warm
#    lamplight in them, some rooms brighter than others and several windows
#    dark; the first-floor balcony with its curved iron balustrade carried on
#    the curved bay below it; the columned portico at the right with its four
#    white columns lit warm from below, its pediment and the round oculus window
#    in it, the panelled entrance doors and the lantern burning under it, and
#    the stone steps; the granite rubble plinth grazed by low warm garden
#    lighting; the small bare young tree at the left; the mown lawn in deep
#    shadow across the foreground; the deep near-black blue night sky. The only
#    motion: the camera moves forward across the lawn extremely slowly and very
#    slightly to the right, so the house grows almost imperceptibly larger and
#    the portico opens, with gentle parallax between the young tree in the left
#    foreground and the facade beyond it; the bare branches of the young tree
#    stir very faintly in the night air; the warm light in the windows breathes
#    almost imperceptibly. The camera stays out on the lawn and never reaches
#    the house, never reaches the steps and never passes the plinth. No people.
#    No animals. No vehicles. No new architecture, wings, windows, doors,
#    chimneys, columns, balconies, paths, terraces, lamps, furniture, signage or
#    lettering. No redesign of the roof, the render, the joinery, the portico or
#    the plinth. No lights switching on or off. No fog, no rain, no fireworks,
#    no moon. Restrained European private-estate architectural cinematography at
#    night, warm practical window light against a deep blue sky, one continuous
#    shot, no cuts, no camera shake, no zoom snap, no lens flare."
#
#   "THE CAMERA STAYS OUT ON THE LAWN" IS THE LINE THAT MADE IT WORK, and it is
#   build_residences_media.py's own finding restated for a building: asked to
#   approach, this model arrives, and a hero that arrives has nowhere to be for
#   the second half of its loop. Naming the limit rather than the speed is what
#   keeps five seconds of dolly inside one composition.
#
# ad-salon  <- ref-salon
#   "Extremely slow cinematic push forward into this exact panelled whisky
#    lounge at night. Preserve everything as photographed and in exactly the
#    same position: the dark timber coffered ceiling with its moulded beams and
#    small recessed downlights; the dark mahogany wall panelling with its carved
#    pilasters and capitals; the oil portrait of a man in a dark suit in its
#    heavy frame over the dark stone chimneypiece at the centre left; the two
#    brass table lamps with pleated cream shades standing lit on the side
#    tables; the glazed cabinets of bottles either side of the chimneypiece; the
#    tall lit shelving on the right wall ranked with whisky bottles on every
#    shelf; the bar counter with its stone top and its row of turned-leg
#    leather-topped stools; the buttoned brown leather chesterfield sofa and
#    armchairs; the low timber coffee table with the tray, the decanter and the
#    cut-glass tumblers on it; the patterned red and brown oriental carpet and
#    the dark parquet floor. The only motion: the camera moves forward extremely
#    slowly and very slightly to the right, so the room opens toward the lit
#    shelves and the bar, with gentle parallax between the armchair in the
#    foreground and the shelving beyond; the lamplight breathes almost
#    imperceptibly; faint warm reflections travel across the glass of the
#    bottles, the stone bar top and the polished leather. The camera never
#    reaches the bar. No people. No hands. No new furniture, rooms, doors,
#    windows, pictures, lamps, signage or lettering. No redesign of the room,
#    the panelling, the shelving or the ceiling. No bottles moving. No lights
#    switching on or off. Restrained European private-members-club interior
#    cinematography, warm lamplight against dark mahogany, one continuous shot,
#    no cuts, no camera shake, no zoom snap, no lens flare."
#
#   "NO BOTTLES MOVING" IS NOT A STYLE NOTE. A wall of several hundred labelled
#   bottles is the single hardest thing in this library to hold still for five
#   seconds: it is exactly the kind of repeated small detail a video model
#   re-invents frame by frame. Naming it as a thing that must not happen is what
#   kept the shelves a photograph of shelves.
#
# ad-cigar  <- ref-cigar
#   "Almost still cinematic shot of this exact panelled cigar lounge at night,
#    with the cigar smoke as the only real movement. Preserve everything as
#    photographed and in exactly the same position: the dark timber wall
#    panelling with its raised and fielded panels and carved mouldings; the
#    three gilt-framed oil portraits of men in dark Edwardian dress hanging on
#    the panelling, each under its own small warm picture light; the two dark
#    carved chimneypieces, the right-hand one with a small fire burning low in
#    its firebox; the crystal and silver objects standing on the mantelshelves;
#    the two brass table lamps with pleated cream shades lit at the left and the
#    right; the buttoned brown leather chesterfield armchairs and sofa drawn
#    round the fire; the small round marble-topped table in the foreground with
#    the cut-glass tumbler of whisky standing on it and the lit cigar resting on
#    its edge with a thin ribbon of smoke rising from it; the patterned oriental
#    carpet. The only motion: the ribbon of cigar smoke rises and drifts and
#    curls slowly and naturally through the warm lamplight and dissolves before
#    it reaches the ceiling; the small fire breathes in the grate and its light
#    shifts very gently across the leather and the marble; the whisky in the
#    glass is perfectly still; the camera drifts forward extremely slowly,
#    almost imperceptibly. No people. No hands. No new furniture, rooms, doors,
#    windows, pictures, lamps, signage or lettering. No redesign of the room,
#    the panelling, the portraits or the chimneypieces. No glass or cigar
#    moving, lifting or being picked up. No lights switching on or off.
#    Restrained European private-members-club interior cinematography, warm
#    lamplight and firelight against dark timber, one continuous shot, no cuts,
#    no camera shake, no zoom snap, no lens flare."
#
#   THIS IS THE ONE SEQUENCE ON THE SITE WHOSE SUBJECT IS NOT THE CAMERA. Every
#   other film on these seven pages is a room and a move through it. This one is
#   a room that is not moved through: the camera is nearly locked off and the
#   only thing that happens in five seconds is that smoke rises off a cigar
#   somebody put down. The brief asks for delicate smoke movement and this is
#   the one frame in the library that already has smoke in it, so the generation
#   had nothing to invent — it only had to let it drift.
#
#   "NO HANDS" AND "NO GLASS BEING PICKED UP" ARE THERE FOR ONE REASON: a lit
#   cigar and a poured drink is the exact shot a video model wants to complete
#   by putting a person into it, and a hand entering this frame would turn a
#   private room into an advertisement for a drink.
#
# ad-table  <- ref-table
#   "Extremely slow cinematic dolly forward through this exact panelled dining
#    room at night, between the laid tables and toward the fire. Preserve
#    everything as photographed and in exactly the same position: the dark
#    carved timber wall panelling with its inset painted panels and its moulded
#    cornice; the large crystal and brass candle chandelier hanging at the
#    centre with its lit candles and its swagged crystal drops; the stone
#    chimneypiece at the right with its carved consoles and a fire burning in
#    the grate; the framed equestrian painting over the mantel and the brass and
#    crystal objects standing on the mantelshelf; the oil portrait of a man in
#    black in its gilt frame on the left wall; the tall window with its glazing
#    bars and its heavy drawn-back curtains at the left; the brass wall sconces
#    lit on the panelling; the round tables laid with white cloths, silver
#    cutlery, ranked crystal glasses and low topiary centrepieces with candles
#    burning in them; the dark leather studded dining armchairs; the dark stone
#    floor. The only motion: the camera moves forward extremely slowly down the
#    room toward the fire, with gentle parallax between the nearest laid table
#    in the foreground and the chimneypiece beyond; the candle flames on the
#    tables and in the chandelier move and breathe naturally; the fire moves in
#    the grate; faint warm reflections travel across the crystal, the silver and
#    the polished panelling. The camera never reaches the fire. No people. No
#    hands. No new furniture, tables, rooms, doors, windows, pictures, lamps,
#    signage or lettering. No redesign of the room, the panelling, the
#    chandelier or the chimneypiece. No plates, glasses or cutlery moving. No
#    lights switching on or off. Restrained European private-estate interior
#    cinematography, candlelight and firelight against dark timber, one
#    continuous shot, no cuts, no camera shake, no zoom snap, no lens flare."
#
#   THE ROOM IS DINING'S AND THE HOUR IS THIS PAGE'S. THE CLUB moves
#   dining_salon.png and EVENTS moves Restaurant_1.png; this is the third dining
#   room in the material and the only one photographed with a fire lit in it,
#   and it has never been cut at this ratio or moved by anything.
#
# ad-garden  <- ref-garden
#   "Extremely slow cinematic lateral drift to the right across this exact
#    private park at night. Preserve everything as photographed and in exactly
#    the same position: the wet stone-flagged path curving through the
#    foreground and away into the distance; the clipped box hedging and the
#    round clipped shrubs laid out either side of it; the low stone kerbs and
#    the beds of small flowers; the tall black cast-iron lamp standard in the
#    centre of the frame with its glazed lantern burning warm, and the receding
#    line of smaller lamp standards along the paths behind it; the great mature
#    trees with their heavy trunks and their canopies lit warm from below; the
#    pale stone rotunda at the right with its domed roof, its ring of slender
#    columns and its balustraded parapet, standing above its stone steps; the
#    mown grass; the deep near-black night sky between the branches. The only
#    motion: the camera drifts very gradually to the right and a little forward
#    along the path, so the rotunda opens and the nearer tree trunk passes with
#    gentle parallax against the lamps behind it; the leaves and the smaller
#    branches stir faintly in the night air and the light through them shifts;
#    the warm lamplight breathes almost imperceptibly; faint warm reflections
#    travel on the wet stone of the path. No people. No animals. No vehicles. No
#    new architecture, buildings, paths, lamps, benches, fountains, statues,
#    signage or lettering. No redesign of the rotunda, the planting or the
#    paths. No lights switching on or off. No fog, no rain falling, no
#    fireworks. Restrained European private-estate architectural cinematography
#    at night, warm lamplight against deep night planting, one continuous shot,
#    no cuts, no camera shake, no zoom snap, no lens flare."
#
#   THE ONE FRAME ON THIS PAGE THAT SHARES A COMPOSITION WITH AN APPROVED PAGE,
#   AND IT IS SAID HERE RATHER THAN LEFT TO BE NOTICED. PADEL prints
#   PRIVATE_CLUB_ECOSYSTEM/3.png at 16:9 as a still, and a 2048x1360 frame cut
#   to 16:9 has only 208px of vertical travel in it, so no bias makes a second
#   picture out of it — this is the same framing at bias 0.42. What is different
#   is that it moves and that it is graded a stop and a half under PADEL's. The
#   alternatives were both worse: this is the only photograph of the estate's own
#   park at night in the whole library, and the scene it is for exists to put the
#   reader back outside. Inventing a second garden would have been the one thing
#   the brief forbids. Recorded in docs/AFTER_DARK.md §8.

# EVERY ENCODE ON THIS PAGE CARRIES A GRADE AND THE GRADES ARE THE PAGE.
# RESIDENCES graded five sequences to a CURVE THROUGH A DAY. This page grades
# five to a STRAIGHT DESCENT, because that is what an evening is, and it is the
# steepest arc on the site:
#
#   sequence      raw    encoded    where it sits
#   ad-nightfall  33.9 -> 31.3      the hero, the last of the light
#   ad-salon      33.4 -> 30.0      the first room, lamps on
#   ad-cigar      24.9 -> 21.9      deeper into the same house
#   ad-table      48.5 -> 22.8      the table, candlelight only
#   ad-garden     29.1 -> 18.2      outside, the middle of the night
#
# READ THE NUMBERS AND YOU HAVE READ THE PAGE: 31, 30, 22, 23, 18. The hero is
# the brightest screen on it and the last one is the darkest, and nothing in
# between ever comes back up by more than the width of the measurement. The one
# place it moves at all is between the cigar lounge and the dining room, which
# arrive a point apart in the other order; a table with candles on it is
# marginally brighter than a lounge at one in the morning and grading that away
# would be grading a lie.
#
# THE CURVE IS A GAMMA AND NOT A BRIGHTNESS OFFSET, and that is the difference
# between this page's grades and the six before it. eq=brightness subtracts a
# constant from every pixel, which lifts nothing and CRUSHES the shadows —
# acceptable on material shot in daylight, fatal on five frames that are ninety
# percent shadow already. eq=gamma bends the midtones and leaves black at black,
# so the dining room comes down twenty-six points and the dark oak behind the
# candles is still oak rather than a flat field of zero.
#
# ad-table IS THE ONE THAT PAYS FOR THE ARC: 48.5 raw, which is the brightest
# thing generated for this page, down to 22.8. The value was chosen by looking
# at four of them side by side rather than by arithmetic — at gamma 0.62 the
# panelling goes to mud and at 0.78 the room is a lit restaurant.
AD_NIGHTFALL_GRADE = 'eq=contrast=1.030:saturation=0.96'
AD_SALON_GRADE = 'eq=gamma=0.9862:contrast=1.030:saturation=0.96'
AD_CIGAR_GRADE = 'eq=contrast=1.030:saturation=0.96'
AD_TABLE_GRADE = 'eq=gamma=0.6600:contrast=1.030:saturation=0.96'
AD_GARDEN_GRADE = ('eq=gamma=0.8396:contrast=1.020:saturation=0.93,'
                   'colorbalance=bs=-0.03')

SEQUENCES = {
    'ad-salon': (
        (16, 9), [768, 1152], None, AD_SALON_GRADE,
        'CIGAR_HOUSE/whisky_lounge.png -> 16:9 crop -> Seedance 2.0',
        'Very slow push into the whisky lounge toward the lit shelves and the '
        'bar, the lamplight breathing and reflections travelling on the glass.'),

    'ad-cigar': (
        (16, 9), [768, 1152], None, AD_CIGAR_GRADE,
        'ESTATE_and_HOSPITALITY/CIGAR_LOUNGE.png -> 16:9 crop -> Seedance 2.0',
        'A nearly locked-off frame in which the only thing that happens is that '
        'smoke rises off a cigar somebody put down. THE ONE SEQUENCE ON THE '
        'SITE WHOSE SUBJECT IS NOT THE CAMERA.'),

    'ad-table': (
        (16, 9), [768, 1152], None, AD_TABLE_GRADE,
        'RESTAURANT/dining_salon2.png -> 16:9 crop -> Seedance 2.0',
        'Slow dolly down the dining room between the laid tables toward the '
        'fire, candle flames moving in the chandelier and on the cloths.'),

    'ad-garden': (
        (16, 9), [768, 1152], None, AD_GARDEN_GRADE,
        'PRIVATE_CLUB_ECOSYSTEM/3.png -> 16:9 crop -> Seedance 2.0',
        'Slow lateral drift along the lit path, the foliage stirring and the '
        'lamplight breathing on the wet stone.'),
}

# THE HERO IS NOT IN SEQUENCES BECAUSE IT DOES NOT GET WHAT THEY GET.
#
#   name, ratio, poster widths, grade
#
# It is the only film on the page encoded twice — 1280 for a desktop and 854 for
# a phone, which is film-hero.php's own pair and the Main Page's own reasoning:
# a 390px screen showing a 1280-wide film pays three times the bytes to fill it.
HERO_NAME = 'ad-nightfall'
HERO_RATIO = (16, 9)
HERO_POSTER_WIDTHS = [768, 1280]
HERO_GRADE = AD_NIGHTFALL_GRADE

# CRF 29 ON THE FOUR SECTION FILMS and two rungs further on the hero, which is
# PADEL's, EVENTS' and RESIDENCES' own pair of numbers. This page is the easiest
# material any of the seven has given H.264 — five near-static cameras on lit
# interiors with very little high-frequency detail in motion — and it is the
# lightest set of encodes on the site because of it.
CRF_WIDE = 29
CRF_HERO = 31
CRF_NARROW = 32


# ---------------------------------------------------------------------------
# 4. The loop is a palindrome
#
# Every one of the five is a single continuous camera move that never returns to
# where it started, so no frame anywhere matches its own first frame. A hard cut
# back to frame 0 jumps, and on a shot this slow a jump is the only thing in it
# that moves quickly. A cross-dissolve is worse: dissolving a near framing into
# a far one ghosts the scene against itself.
#
# So each one plays forward and then backwards — seamless by construction,
# because the last frame of the reverse IS the first frame of the forward, and
# no two framings are ever blended. This is tools/motion/build_sequences.sh's
# filter, verbatim.
#
# AND ON THIS PAGE IT COSTS NOTHING, which is worth writing down because it has
# cost something on two pages before it. EVENTS' ev-dusk runs a sunset backwards
# and RESIDENCES' res-morning runs a sunrise backwards; both were accepted as
# the lesser of two faults. Nothing here is a change of light over time. Smoke
# drifting, a fire breathing, leaves stirring and a camera creeping four metres
# forward all reverse into themselves without reading as anything at all.
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
    """Write the rungs the crop is actually wide enough for, and only those."""
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
    build_images.py's own rule: a slot moved from a 640/960 ladder to a 768/1152
    one leaves the four files from the old ladder on disk afterwards — the same
    photograph at a different crop, under the same stem, waiting for a content
    file to ask for both. img_files() reports what is really on disk, so two
    crops under one stem is one srcset made of two different pictures.

    It only ever touches <stem>-<digits>.<ext> for a stem this script declares,
    so nothing outside PLATES, SEQUENCES and the hero can be reached by it. The
    stem the page this replaces built is cleared by retire_old_page() instead,
    which names it.
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


# THE STEMS THE OLD PAGE BUILT, AND THEY GO.
#
# build_images.py declared after-dark/cigar-whisky — that file is the non-film
# pages' builder and /after-dark was one until this rebuild — so left alone it
# would be rebuilt by the next run of it and sit under assets/img/after-dark/
# forever, unreferenced. The entry is removed from build_images.py in the same
# change; this list is what clears what is already on disk, and it is explicit
# rather than a wildcard so that it cannot reach a stem this page ships.
#
# 'hero' and 'gaming-salon' are named too although neither has ever had a file:
# both were declared in the page this replaces and both stood as hatched boxes
# because no frame existed for them. The hatch is gone because the frames now
# exist — the hero as a generation, the private room as a crop nothing had cut —
# and naming the two stems here means a stray export from an older working copy
# cannot survive the rebuild.
RETIRED = ['cigar-whisky', 'hero', 'gaming-salon']


def retire_old_page():
    print('\nRETIRED — the stems the page this replaces built\n' + '-' * 78)

    out_dir = os.path.join(IMG, 'after-dark')

    if not os.path.isdir(out_dir):
        print('  nothing to remove')
        return

    for stem in RETIRED:
        gone = []

        for name in sorted(os.listdir(out_dir)):
            ext = name.rpartition('.')[2]

            if ext not in ('jpg', 'jpeg', 'webp'):
                continue

            base, _, width = name.rpartition('.')[0].rpartition('-')

            if base == stem and width.isdigit():
                os.remove(os.path.join(out_dir, name))
                gone.append(name)

        print(f'  {stem:<14} {len(gone)} files removed' if gone
              else f'  {stem:<14} already gone')


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

        print(f'  {stem:<28} <- {source:<48} '
              f'{cropped.width}x{cropped.height}'
              f'{"  graded" if graded else "":9} {rungs}')


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
    print('\nHERO\n' + '-' * 78)

    master = os.path.join(MOTION, f'{HERO_NAME}.mp4')

    if not os.path.isfile(master):
        print(f'  MISSING  {master}')
        return

    wide = os.path.join(VID, f'{HERO_NAME}.mp4')
    small = os.path.join(VID, f'{HERO_NAME}-sm.mp4')

    wide_bytes = encode(ff, master, wide, 1280, CRF_HERO, HERO_GRADE)
    small_bytes = encode(ff, master, small, 854, CRF_NARROW, HERO_GRADE)

    frame = os.path.join(MOTION, f'{HERO_NAME}-frame0.png')
    rungs = poster(ff, wide, f'after-dark/{HERO_NAME}', HERO_RATIO,
                   HERO_POSTER_WIDTHS, frame)

    print(f'  {HERO_NAME:<13} {wide_bytes // 1024:>5} KB  '
          f'+ {small_bytes // 1024} KB narrow  poster {rungs}'
          f'  <- estate_4.jpg -> GPT Image 2 -> Seedance 2.0')


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
        rungs = poster(ff, wide, f'after-dark/{name}', ratio, widths, frame)

        print(f'{line}  poster {rungs}  <- {source}')


if __name__ == '__main__':
    retire_old_page()
    build_plates()
    build_hero()
    build_sequences()
    print('\ndone.\n')
