"""
Build RESIDENCES' media from media_src/, two GPT Image 2 stills and five
Seedance 2.0 sequences.

WHAT THIS IS. /residences declares its pictures by stem — residences/res-house,
residences/kind-cottage — and img() in app/helpers.php looks for
assets/img/<stem>-<width>.<ext>. This script is the mapping between the material
in media_src/ and those stems, and it is a script rather than a folder of
hand-cut exports for the reason the five build scripts before it are: every crop
is a decision, and a decision has to be re-readable and re-runnable.

THE SIXTH FILM PAGE, AND THE FIRST WHOSE SUBJECT IS A DAY RATHER THAN AN HOUR.
The Main Page holds blue hour, THE ESTATE holds an afternoon, THE CLUB and
EVENTS hold an evening, PADEL holds the hour after sunset. This page starts at
the door at night, goes back to a morning, crosses an afternoon and ends at the
fire — which is what a stay is, and it is why two of its five sequences carry
daylight and none of the five pages before it does.

FOUR KINDS OF PICTURE COME OUT OF HERE AND THEY ARE FOUR DIFFERENT CLAIMS.

  PHOTOGRAPHS are crops of the supplied photography of the real house — the
  landing, the stair hall, the window bay, the stove room, the great hall, the
  marble hall, the house and its park. Declared 'photo'.

  VISUALISATIONS are crops of the project's own renders — the main suite, the
  guest-suite building, the cottages, the concierge desk, the dining room, the
  club rooms. Declared 'render'.

  POSTERS are frame 0 of a sequence, which is the reference the sequence started
  from, and are declared as whatever the sequence is: 'generated'.

  GENERATED STILLS are the two GPT Image 2 pictures below. Both change the hour
  of a photograph of the real house and nothing else, and both are the start
  image of the sequence beside them. Declared 'generated'.

WHAT IS NOT CLAIMED, AND THE RULE IS THE ONE content/en/residences.php HAS
ALWAYS CARRIED. Not one picture here is captioned as a residence of ours. There
are no residences to photograph yet; there is a house, and a set of
visualisations of what will be in it, and the captions say which is which. A
crop of the real landing is the real landing — that is a photograph of this
building and it is declared 'photo' — but it is never labelled "your room".

BIAS IS THE FRACTION OF THE SURPLUS TAKEN OFF THE TOP (or off the left, on a
frame too wide for its slot). 0.5 is a centre crop. Where a value is not 0.5 the
reason is written beside it.

NOTHING IS UPSCALED. A rung wider than the crop is skipped rather than
interpolated, so five of this page's plates ship at 640 alone — see
docs/RESIDENCES.md §8. That is the library being what it is, not a ladder being
half-exported.

Run from anywhere:  python3 tools/photos/build_residences_media.py
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

# The five sequences as they came back from Seedance and the two GPT Image 2
# stills two of them were made from.
#
# THE STILLS ARE COMMITTED AND THE .mp4 MASTERS ARE NOT, which is the
# repository's existing rule rather than a decision taken here: .gitignore
# carries /media_src/**/*.mp4 — the master stays on disk and in the backup, the
# encode under public_html/assets/video/ is the deliverable and that one is
# committed. So a fresh clone can rebuild every PLATE below, and rebuilding the
# SEQUENCES needs the masters restored to this directory first.
MOTION = os.path.join(SRC, 'MOTION', 'residences')

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
# THREE CURVES, AND TWO OF THEM ARE ALREADY IN THE LIBRARY.
#
# GRADE and DEEP are build_club_media.py's own, unchanged, and they are here for
# the same material: this page and that one are cut from the same eleven
# photographs of the same house, and a curve that was measured against a window
# wall on THE CLUB is the curve that window wall wants here.
#
# GOLDEN IS THIS PAGE'S ONE ADDITION AND IT EXISTS FOR THREE PICTURES. Scene 05
# is the only screen on the site that has to put the estate's own daylight
# photography — a white manor house under a blue midday sky, which is measurably
# the brightest object in the library — on a page that has just come out of a
# dark bedroom. build_events_media.py answered the same problem with NIGHT, a
# curve that takes a noon photograph down to something that reads as after dark;
# that is the right answer for a tile beside three night tiles and the wrong one
# here, because this scene's whole argument is that there is a park out there in
# daylight. So GOLDEN goes down about as far as DUSK and tilts further: the blue
# channel comes down fourteen percent and the green five, which is what the last
# hour of a summer afternoon does to a photograph taken at noon. The house stays
# in daylight and stops being a hole punched in the page.
#
#   (mid, high)           the curve, as build_club_media.py writes it
#   (mid, high, (r,g,b))  the same curve, with a per-channel weight after it
#
# WHICH PICTURE GETS WHICH IS A MEASUREMENT AND NOT A TASTE, which is
# build_events_media.py's rule and is kept: every plate was exported, its mean
# luminance taken, and the curve chosen so that no picture in a group arrives
# more than about half again as bright as the darkest one beside it. The
# numbers, before and after, are in docs/RESIDENCES.md §5.
# ---------------------------------------------------------------------------

GRADE = (0.475, 0.92)                          # build_club_media.py's own
DEEP = (0.435, 0.83)                           # build_club_media.py's own
DUSK = (0.32, 0.62, (1.0, 0.96, 0.88))         # a lit building at blue hour
GOLDEN = (0.25, 0.48, (1.0, 0.95, 0.86))       # the estate's own daylight
NIGHT = (0.15, 0.28, (1.0, 0.94, 0.82))        # a lit room, at one in the morning


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
# build-versus-page check in docs/RESIDENCES.md counts.
#
# NOT ONE CROP BELOW IS A CROP ANOTHER PAGE HAS ALREADY CUT. Every stem was
# checked against the five build scripts before it: same file at the same ratio
# is the same picture, and this page has none. Where a file is shared with an
# approved page the ratio is different and the note says which page has the
# other one. Two files here have never been used anywhere at all —
# interiors_8.png and CIGAR_HOUSE/whisky_collection.png — and one,
# interiors_9.png, had never been used before this page took it twice.
# ---------------------------------------------------------------------------

PLATES = {

    # -- Scene 01: within the estate ----------------------------------------

    'residences/res-house': (
        'ESTATE_and_HOSPITALITY/SECOND_BUILDING_GUEST_SUITES.png',
        (16, 9), [768, 1152], 0.30, DUSK,
        'THE SECOND BUILDING AT BLUE HOUR, AND THE ONE PICTURE THAT ANSWERS '
        '"where are they". Taken high out of a 2880-square frame so the roof, '
        'the pediment and every lit window are in the band and the cobbles are '
        'not — a centred crop of a square is the forecourt. The Main Page uses '
        'this file at 4:5 for its own stay scene and scene 08 below uses it '
        'again at this ratio and bias 0.62, which is the lit ground floor and '
        'the door; three crops, three pictures, and the reasoning for the '
        'third is on its own entry.'),

    # -- Scene 03: the detail track -----------------------------------------
    #
    # Six frames at 3:4, and not one of them is the same file at the same ratio
    # as any of THE CLUB's six — which are interiors_5, _14, _7, _11, _6 and
    # _10 — or of THE ESTATE's five. Two sections that look alike are one
    # section done twice.

    'residences/detail-arch': (
        'interiors/interiors_9.png', (3, 4), [640, 960], 0.34, DEEP,
        'THE ARCH, THE CORRIDOR AND THE DOOR STANDING OPEN AT THE END OF IT, '
        'cut tall out of the landing. This file had never been used anywhere '
        'before this page, and this page uses it twice: here at 3:4, and as '
        'the 16:9 reference the hero sequence was generated from. High, '
        'because the arch is the top of the composition and the parquet is the '
        'bottom of it.'),

    'residences/detail-window': (
        'grand-staircase/GrandStaircase_4.jpg', (3, 4), [640, 960], 0.22, DEEP,
        'THE GLAZED INTERIOR WINDOW ON THE LANDING — a window in a wall '
        'inside the house, which is the detail this building has that nothing '
        'built since has. High, for the coffers over it. The Main Page uses '
        'this file at 3:2 and nothing uses it here.'),

    'residences/detail-stove': (
        'interiors/interiors_12.png', (3, 4), [640, 960], 0.30, DEEP,
        'THE WHITE TILED STOVE IN ITS CORNER, full height, with the panelled '
        'door beside it. High, so the moulded crown is in the frame. THE CLUB '
        'uses this file at 16:9, which is the room; this is the object in it.'),

    'residences/detail-doors': (
        'interiors/interiors_15.png', (3, 4), [640, 960], 0.30, DEEP,
        'THE TALL GLAZED DOORS AND THEIR GLAZING BARS, cut tall. THE CLUB uses '
        'this file at 16:9 for the drawing room; this is one wall of it. High, '
        'because the fanlight is the top of the door and the point of it.'),

    'residences/detail-hearth': (
        'interiors/interiors_2.jpg', (3, 4), [640, 960], 0.38, DEEP,
        'THE MARBLE CHIMNEYPIECE UNDER ITS MIRROR, with the panelling and the '
        'chequered floor. THE ESTATE uses this file at 16:9 and the Main Page '
        'at 3:2; neither is this picture.'),

    'residences/detail-floor': (
        'heritage-details/heritage_2.jpg', (3, 4), [640, 960], 0.46, DEEP,
        'THE CHEQUERED MARBLE OF THE HALL, seen down over the glazed stair '
        'enclosure. THE ESTATE uses this file at 16:9 for its walk and at 3:2 '
        'for the hall; this is the floor.'),

    # -- Scene 06: the quiet ------------------------------------------------

    'residences/res-quiet': (
        'interiors/interiors_8.png', (16, 9), [768, 1152], 0.40, NIGHT,
        'THE STAIR HALL WITH ITS THREE SCONCES LIT AND A LAMP BURNING IN THE '
        'ROOM BEYOND THE DOOR. NEVER USED ANYWHERE BEFORE — it and '
        'whisky_collection are the two files on this page that no other page '
        'has ever cut. It carries the deepest curve on the page because this '
        'is the one screen where nothing is meant to be happening: at its own '
        'exposure it is a well-lit stair hall in the afternoon, and at NIGHT '
        'it is three lamps and a great deal of dark oak. Slightly high, for '
        'the coffered ceiling and the underside of the stair.'),

    # -- Scene 05: the park -------------------------------------------------

    'residences/park-lawn': (
        'estate/estate_4.jpg', (3, 2), [640, 960], 0.35, GOLDEN,
        'THE HOUSE FROM THE LAWN WITH THE GREAT TREE OVER IT. THE ESTATE uses '
        'this file at 4:3; this is the wide cut. High, because the tree and '
        'the roofline are the picture and the mown grass is not. GOLDEN — see '
        'the note above.'),

    'residences/park-front': (
        'estate/estate_2.jpg', (4, 5), [640], 0.30, GOLDEN,
        'THE PORTICO AND THE TREE BESIDE IT, cut tall. THIS FILE HAS NEVER '
        'BEEN CUT AS A STILL — it is the reference THE ESTATE\'s golden-hour '
        'sequence was generated from, which is not the same thing as a picture '
        'of it. A 900-wide frame cut to 4:5 is 810 across, so it ships at 640 '
        'and no higher; nothing here is upscaled.'),

    # -- Scene 08: three ways to stay, as the dialogue's three rooms --------

    'residences/kind-suite': (
        'ESTATE_and_HOSPITALITY/MAIN_MANOR_SUITE.png', (16, 9), [768, 1152], 0.14, DUSK,
        'THE MAIN SUITE, TAKEN HIGH FOR THE CHANDELIER AND THE HEADS OF THE '
        'WINDOWS. The Main Page uses this file at 4:5 and the room sequence on '
        'this page starts from a 16:9 crop of it at bias 0.40, which is the '
        'bed, the lamps and the floor. Same room, two frames, and the tile is '
        'the one that keeps the ceiling.'),

    'residences/kind-guest': (
        'ESTATE_and_HOSPITALITY/SECOND_BUILDING_GUEST_SUITES.png',
        (16, 9), [768, 1152], 0.62, DUSK,
        'THE SAME BUILDING AS SCENE 01 AND NOT THE SAME PICTURE: low out of '
        'the square, so the band is the lit ground floor, the door under the '
        'portico and the cobbled forecourt, with the roof gone. 1260px of '
        'vertical surplus is what makes two crops of one square into two '
        'photographs rather than one photograph twice.'),

    'residences/kind-cottage': (
        'ESTATE_and_HOSPITALITY/private_cottages.png', (16, 9), [768, 1152], 0.46, False,
        'THE TIMBER COTTAGES AT NIGHT WITH THE LIT PATH BETWEEN THEM. The Main '
        'Page uses this file at 3:2 and PADEL at 4:5; this is the wide cut, '
        'centred, because the path running between the two of them is the '
        'composition.'),

    # -- Scene 09: the house around the stay --------------------------------

    'residences/host-dining': (
        'ESTATE_and_HOSPITALITY/Restaurant_1.png', (4, 5), [640], 0.34, DEEP,
        'THE PANELLED DINING ROOM, CUT TALL. THIS FILE HAS NEVER BEEN CUT AS A '
        'STILL — it is the reference EVENTS\' ev-table sequence was generated '
        'from. High, for the chandelier and the overmantel. A 1396-wide frame '
        'cut to 4:5 is 771 across, so it ships at 640 alone.'),

    'residences/host-desk': (
        'ESTATE_and_HOSPITALITY/reception_concierge.png', (3, 2), [640, 960], 0.34, False,
        'THE DESK, AND THE ONE PERSON ON THE PAGE. EVENTS uses this file at '
        '4:5, which is the crest and the wordmark standing over the desk; this '
        'is the wide cut, which is the desk itself and the flowers on it. High '
        'enough to keep the lamp and to lose the chequered floor.'),

    # -- Scene 10: the rest of the estate -----------------------------------
    #
    # Four tiles, four pages, and four crops no other page has cut. Two of the
    # four files have never been used anywhere at all.

    'residences/world-estate': (
        'estate/estate_3.jpg', (4, 5), [640], 0.34, NIGHT,
        'THE GARDEN FRONT OF THE REAL HOUSE. THIS FILE HAS NEVER BEEN CUT AS A '
        'STILL — it is the reference THE ESTATE\'s est-house sequence was '
        'generated from. Shot at midday under a blue sky, so it carries the '
        'deepest curve of the four: beside three near-black tiles an '
        'unfiltered midday photograph is not a fourth tile, it is a light left '
        'on. An 869-wide frame cut to 4:5 is 792 across, so it ships at 640 '
        'alone.'),

    'residences/world-club': (
        'CIGAR_HOUSE/whisky_lounge.png', (4, 5), [640, 960], 0.34, False,
        'THE WHISKY LOUNGE UNDER ITS LAMPS. The Main Page uses this file at '
        '3:2; this is the tall cut. High, because the shelves and the '
        'portraits are the picture.'),

    'residences/world-events': (
        'pavilion/pavilion_2.jpg', (4, 5), [640, 960], 0.62, GOLDEN,
        'THE PAVILION ON ITS LAWN, CUT TALL. EVENTS uses this file at 16:9 and '
        'the Main Page at 3:2; this is the portrait of it. Low, so the dome '
        'and the brick path are in the frame and most of the pines are not.'),

    'residences/world-dark': (
        'CIGAR_HOUSE/whisky_collection.png', (4, 5), [640], 0.42, GRADE,
        'THE RANKED BOTTLES, LIT FROM BEHIND. NEVER USED ANYWHERE BEFORE. A '
        '2592x1152 panorama cut to 4:5 is 922 across, so it ships at 640 '
        'alone.'),
}


# ---------------------------------------------------------------------------
# 3. The sequences
#
#   name : (ratio, poster widths, trim seconds or None, grade or None, source, motion)
#
# 'source' is the media_src reference the sequence descends from. Two of the
# five descend through a GPT Image 2 still: the still was made FROM the file
# named there and changed the hour, and nothing else. Both stills are in
# media_src/MOTION/residences/ and their prompts are below and in
# docs/RESIDENCES.md §3.
#
# NOTHING WAS TRIMMED AND NOTHING WAS REGENERATED. All five came back holding
# their framing for the whole five seconds, which is what a prompt written as a
# preservation instruction buys; the trim column stays because
# build_events_media.py needed it once and the day one of these has to be cut
# short, the mechanism is here rather than in a second script.
# ---------------------------------------------------------------------------

# THE PROMPTS, VERBATIM, because a prompt is the only part of a generated asset
# that cannot be recovered by looking at it. Every one is written as a
# PRESERVATION instruction rather than a description: it names the architecture,
# the joinery and the materials of that specific frame, states the one thing
# that may change, lists the motion that is allowed, and then says what may not
# appear. The negative half is the half that does the work. Same shape as
# build_events_media.py and build_padel_media.py.
#
# ---- The crops the generations start from ---------------------------------
#
# ref-threshold  interiors/interiors_9.png, cropped to (0,150)-(1700,1744) then
#                16:9 at bias 0.42 (1700x956) — the landing's left half: the two
#                arches, the corridor, the open door, the newel and the parquet.
#                THE SAME FILE THE DETAIL TRACK'S FIRST FRAME IS CUT FROM, at a
#                different ratio and a different bias.
# ref-suite      ESTATE_and_HOSPITALITY/MAIN_MANOR_SUITE.png, 16:9 at bias 0.40
#                (1240x698) — the bed, the lamps, the window, the glazed doors
#                and the armchair; the chandelier and the floor cropped away.
# ref-window     interiors/interiors_13.png, 16:9 at bias 0.30 (1920x1080) — the
#                window bay, the seat under it, the round table and the park
#                through the glass. THE CLUB uses this file at 16:9 at bias 0.32
#                as a dialogue room; this crop is 9px lower and is a still that
#                nothing prints — only the sequence made from it ships.
# ref-fire       interiors/interiors_1.jpg, 16:9 at bias 0.62 (1176x662) — the
#                lit firebox, the chimneypiece, the piano and the two chairs.
#
# ---- GPT Image 2, 2K, high, 16:9, from a reference ------------------------
#
# still-threshold  <- ref-threshold
#   "Preserve this exact interior landing precisely and change only the hour and
#    the lighting. Keep every structural element exactly as photographed and in
#    exactly the same position, proportion and perspective: the two tall
#    round-headed arches at the left standing on square dark-oak piers with
#    their carved capitals and moulded bases; the corridor seen through them
#    with its pale plaster walls, dark timber wainscot panelling, the tall
#    panelled timber door standing open at the far end, the second closed door
#    and the plain doorframe beside it; the dark oak balustrade at the right
#    with its barley-twist balusters, its panelled newel post with the turned
#    ball finial and the diamond-inlaid panel below it, and the stairwell
#    dropping away behind it; the herringbone oak parquet floor with its border;
#    the dark timber coffered ceiling with its deep moulded beams and cream
#    recessed panels; the exact camera position and lens. Change the light: it
#    is now late evening, after dark. The daylight is gone. The landing is lit
#    only by its own lamps -- a small warm ceiling light in the corridor beyond
#    the arches, warm lamplight spilling out through the open door at the far
#    end and lying in a long shape across the parquet, and a low warm glow
#    rising from the stairwell. The plaster walls fall away into warm shadow,
#    the oak reads almost black, and the parquet carries the reflected warm
#    light. No new architecture. No new doors, windows, arches, rooms,
#    furniture, pictures, rugs, signage or lettering. No redesign of the
#    joinery, the balustrade, the coffering or the floor. No people. No visible
#    light fittings that are not already in the photograph. Restrained European
#    private-estate architectural photography, warm practical light against dark
#    oak, natural colour, unstaged, no lens flare, no HDR."
#
#   THE HOUR CHANGED AND THE BUILDING DID NOT. Every noun the prompt keeps is a
#   noun in interiors_9.png, and the whole of the change is that the sun went
#   down: the same arches, the same barley-twist balusters, the same
#   diamond-inlaid newel panel, the same coffers, the same herringbone. This is
#   the one composition in the library that says what this page is about -- a
#   private door, inside a historic house, with a light on behind it -- and no
#   photograph of it at night exists.
#
# still-morning  <- ref-suite
#   "Preserve this exact bedroom precisely and change only the hour and the
#    light. Keep every element exactly as photographed and in exactly the same
#    position, proportion and perspective: the cream painted walls with their
#    applied rectangular mouldings and the deep cornice; the bed at the left
#    with its tall buttoned upholstered headboard and its stud detail, the stack
#    of pillows, the folded runner across the foot of the bed and the long
#    upholstered bench in front of it; the two dark mahogany bedside chests with
#    their brass handles and the pair of urn-shaped table lamps with pleated
#    shades standing on them; the tall window with its glazing bars and stone
#    sill in the centre right, and the glazed double doors to the right of it
#    with their own glazing bars and brass door furniture; the full-length
#    curtains hung from a dark iron pole with rings; the small buttoned armchair
#    at the right; the round table edge at the far right; the large patterned
#    rug and the dark herringbone parquet beneath it; the brass and glass candle
#    chandelier hanging at the centre of the ceiling; the exact camera position
#    and lens. Change the light: it is now early morning, just after sunrise.
#    The lamps and the chandelier are switched off and unlit. Cool, soft, low
#    daylight comes in through the window and the glazed doors, falls in long
#    shapes across the parquet and the rug, and lifts the cream walls; the
#    curtains are drawn back at the sides. Beyond the glass the park is visible
#    in soft morning light: the lawn, low mist standing between the trees, and
#    the tall trees behind, all softly overexposed. The bedcover is turned back
#    on one side of the bed, as a bed that has been slept in. No new
#    architecture. No new windows, doors, rooms, furniture, lamps, pictures,
#    signage or lettering. No redesign of the room, the joinery, the bed or the
#    curtains. No people. No clutter on the surfaces beyond what is already
#    there. Restrained European private-estate interior photography, soft
#    natural morning light, natural colour, unstaged, no lens flare, no HDR."
#
#   THE ONE PICTURE ON THE SITE OF A ROOM THAT HAS BEEN SLEPT IN. Every
#   visualisation in the library is a made bed in a lit room at night, which is
#   what a property brochure photographs; the scene this page needs at its
#   fourth screen is the opposite of that, and the only honest way to get it was
#   to take the brochure's own room and move the sun. Nothing about the room
#   moved: the headboard, the two chests, the lamps, the window, the doors, the
#   pole, the armchair, the rug and the parquet are where the visualisation put
#   them, which is the test this page applies to both its generations.
#
#   WHAT THE MODEL ADDED, STATED RATHER THAN HIDDEN: a low iron balcony rail
#   outside the glazed doors, which the reference does not show and does not
#   contradict -- a first-floor French door opens onto something. It is small,
#   it is behind glass, and it was left rather than spend a second generation
#   removing it. Recorded in docs/RESIDENCES.md §8.
#
# ---- Seedance 2.0, 720p, 16:9, 5s, no audio, start_image ------------------
#
# START_IMAGE AND NOT image_references, ON ALL FIVE, which is the rule
# build_events_media.py set and the only setting under which a coffered ceiling,
# a barley-twist balustrade and a laid bed survive five seconds of camera
# movement intact. It is also what makes the poster honest: frame 0 of the
# encode is the reference, so the still and the film cannot re-frame against
# each other when the video fades up.
#
# res-arrival  <- still-threshold
#   "Extremely slow cinematic dolly forward across this exact landing at night,
#    toward the arches and the open door beyond them. Preserve everything as
#    photographed: the two tall round-headed arches on their square dark-oak
#    piers with carved capitals; the corridor beyond them with its warm-lit
#    walls, its dark timber wainscot, the small warm ceiling light, and the tall
#    panelled door standing open at the far end with warm lamplight spilling out
#    of it across the floor; the dark oak balustrade at the right with its
#    barley-twist balusters, its panelled newel with the turned ball finial and
#    the diamond-inlaid panel; the herringbone oak parquet with the long shape
#    of light lying on it; the dark timber coffered ceiling with its deep
#    moulded beams; the deep warm shadow at the edges of the frame. The only
#    motion: the camera moves forward extremely slowly and very slightly to the
#    left, so the nearer arch opens and the lit corridor beyond it comes
#    gradually closer, with gentle parallax between the newel post in the
#    foreground and the doorway beyond; the warm light in the corridor breathes
#    almost imperceptibly; faint warm reflections shift on the polished parquet
#    and on the oak handrail. The camera never reaches the arch and never passes
#    through it. No people. No doors opening or closing. No new architecture. No
#    new doors, windows, arches, rooms, furniture, pictures, rugs, lamps,
#    signage or lettering. No redesign of the joinery, the balustrade, the
#    coffering or the floor. No lights switching on or off. Restrained European
#    private-estate architectural cinematography, warm practical light against
#    dark oak, one continuous shot, no cuts, no camera shake, no zoom snap, no
#    lens flare."
#
#   "THE CAMERA NEVER REACHES THE ARCH" IS THE LINE THAT MADE IT WORK. A dolly
#   toward a doorway is the one move this model will over-deliver: asked to
#   approach, it arrives, and a hero that arrives has nowhere to be for the
#   second half of its loop. Naming the limit rather than the speed kept the
#   whole five seconds inside one room.
#
# res-room  <- ref-suite
#   "Extremely slow cinematic lateral dolly to the right across this exact
#    bedroom at blue hour. Preserve everything as photographed: the cream
#    painted walls with their applied rectangular mouldings and deep cornice;
#    the bed at the left with its tall buttoned upholstered headboard, its
#    stacked pillows, the folded runner across its foot and the long upholstered
#    bench in front of it; the two dark mahogany bedside chests and the pair of
#    urn-shaped table lamps with pleated shades standing lit on them; the tall
#    window with its glazing bars, the glazed double doors beside it with their
#    brass door furniture, and the deep blue evening sky and dark trees beyond
#    the glass; the full-length curtains on their dark iron pole; the small
#    buttoned armchair at the right; the patterned rug and the dark herringbone
#    parquet; the brass and glass candle chandelier lit at the centre of the
#    ceiling. The only motion: the camera drifts very gradually to the right and
#    a little forward, so the room opens toward the window and the glazed doors,
#    with gentle parallax between the bed in the foreground and the window wall
#    beyond; the curtains stir almost imperceptibly; the lamplight and the
#    candle flames of the chandelier breathe very slightly; faint warm
#    reflections travel across the polished parquet and the glass. No people. No
#    new furniture, rooms, doors, windows, pictures, lamps, signage or
#    lettering. No redesign of the room, the joinery, the bed or the curtains.
#    No lights switching on or off. Restrained European private-estate interior
#    cinematography, warm lamplight against a blue evening window, one
#    continuous shot, no cuts, no camera shake, no zoom snap, no lens flare."
#
#   IT MOVES SIDEWAYS BECAUSE THE MAIN PAGE'S ALREADY MOVES FORWARD.
#   assets/video/seq-suite.mp4 is a Seedance push-in on this same room, made for
#   the Main Page's scene 06, and it was checked first: reusing it here would
#   have cost nothing and shown the reader the identical twelve seconds they
#   have already seen. So the camera was turned ninety degrees instead. The room
#   is the same room; the shot is not the same shot, and the direction is the
#   page's argument -- the bed is where you start and the window is where the
#   estate is.
#
# res-morning  <- still-morning
#   "Slow, quiet morning inside this exact bedroom, in one continuous shot.
#    Preserve everything as photographed: the cream painted walls with their
#    applied mouldings; the bed at the left with its tall buttoned upholstered
#    headboard, its pillows and its bedcover turned back; the long upholstered
#    bench at the foot of the bed; the two dark mahogany bedside chests with
#    their unlit table lamps and pleated shades; the tall window with its
#    glazing bars and the glazed double doors beside it with their brass
#    handles; the full-length curtains drawn back at the sides; the small
#    buttoned armchair at the right; the pale rug and the dark herringbone
#    parquet with the long shapes of morning light lying across it; the trees
#    and the park seen softly through the glass. The only motion: soft daylight
#    strengthens very gradually as the sun rises, so the shapes of light on the
#    parquet and the rug lengthen and warm almost imperceptibly; the curtains
#    stir very gently at the edge of the open window; the tree branches outside
#    move faintly; the camera drifts forward extremely slowly, almost
#    imperceptibly, toward the window. No people. No lamps switching on. No new
#    furniture, rooms, doors, windows, pictures, signage or lettering. No
#    redesign of the room, the joinery, the bed or the curtains. No time-lapse
#    stutter and no sudden change of exposure. Restrained European
#    private-estate interior cinematography, soft natural morning light, one
#    continuous shot, no cuts, no camera shake, no zoom snap, no lens flare."
#
#   THE ONLY SEQUENCE ON THE SITE IN FULL DAYLIGHT AND IT IS THE POINT OF THE
#   PAGE. Five film pages have gone by without one, because the film is a night
#   film; a page about staying has to be able to show the morning after, and a
#   morning that is merely a dimmer evening is not one.
#
# res-window  <- ref-window
#   "Extremely slow cinematic dolly forward toward the windows of this exact
#    room. Preserve everything as photographed: the dark red patterned damask
#    wall covering above the dark timber wainscot panelling; the white moulded
#    cornice; the two brass twin-branch wall sconces lit on the left and right
#    walls; the small crystal chandelier hanging in the window recess; the two
#    tall white-painted windows with their glazing bars and the bare winter
#    trees and pale sky beyond them; the fitted dark timber window seat running
#    under the windows with its panelled fronts and its moulded top; the small
#    round pedestal table with its carved base standing in the recess; the
#    herringbone oak parquet floor; the exact camera position, lens and
#    perspective. The only motion: the camera moves forward extremely slowly
#    toward the window recess, with gentle parallax between the panelling in the
#    foreground and the windows beyond; the bare branches outside move faintly
#    in the wind; the daylight on the parquet and on the panelling shifts very
#    slightly as a cloud passes; the sconce light stays steady. No people. No
#    new furniture, rooms, doors, windows, curtains, pictures, rugs, signage or
#    lettering. No redesign of the room, the panelling, the windows or the
#    floor. No change of season and no leaves on the trees. Restrained European
#    private-estate architectural cinematography, cool daylight against dark
#    wood and deep red, one continuous shot, no cuts, no camera shake, no zoom
#    snap, no lens flare."
#
#   "NO CHANGE OF SEASON AND NO LEAVES ON THE TREES" IS AN HONESTY INSTRUCTION
#   AND NOT A STYLE ONE. The photograph was taken in early spring and the park
#   through that glass is bare. A summer park behind those windows would have
#   been a nicer picture and a claim about a view nobody has photographed, so
#   the prompt forbids it, and the two plates beside this scene -- the house and
#   its lawn, both shot in leaf -- are graded to a late afternoon rather than
#   pretended into the same afternoon.
#
# res-evening  <- ref-fire
#   "Extremely slow cinematic push forward toward the fire in this exact room.
#    Preserve everything as photographed: the tall pale carved limestone
#    chimneypiece with its moulded hood, its relief panel and its arched firebox
#    with a fire burning in it; the dark red patterned damask wall covering; the
#    dark timber panelling and the tall panelled door to the right of the
#    chimneypiece; the black grand piano with its lid raised and its brass
#    pedals, and the piano stool; the rust-orange upholstered armchair at the
#    left and the pale boucle armchair at the right; the small round timber
#    table with the chess board and pieces set out on it and the stack of books
#    beneath; the patterned oriental carpet and the herringbone parquet floor
#    beneath it; the exact camera position, lens and perspective. The only
#    motion: the camera moves forward extremely slowly toward the fire, with
#    gentle parallax between the armchairs in the foreground and the
#    chimneypiece beyond; the flames move and breathe in the firebox; the
#    firelight shifts very gently across the pale stone, the polished lacquer of
#    the piano and the carpet; faint warm reflections travel on the piano's
#    raised lid. No people. No hands. No new furniture, rooms, doors, windows,
#    pictures, lamps, signage or lettering. No redesign of the room, the
#    chimneypiece, the piano or the panelling. Restrained European
#    private-estate interior cinematography, warm firelight against dark wood
#    and deep red, one continuous shot, no cuts, no camera shake, no zoom snap,
#    no lens flare."
#
#   THE FIRE IS REAL AND SO IS THE ROOM. interiors_1.jpg is the only photograph
#   in the library of a lit fire in this house; THE ESTATE prints it as a
#   heritage detail at 3:4 and the Main Page at 4:5, and neither of them moves.
#   This is the same fire, at 16:9, burning.

# EVERY ENCODE ON THIS PAGE CARRIES A GRADE AND THAT IS NEW. The five pages
# before this one graded at most one sequence each, because their material
# arrived at the page's own exposure. Two of these five are daylight and the
# other three are lit interiors that came back a stop brighter than the film
# runs, so all five are matched by MEASUREMENT rather than by eye: mean
# luminance of frame 0 of the encode, against the 31.1 that EVENTS' hero
# measures and the 46.1 that THE CLUB's hall measures.
#
#   sequence      raw    encoded    what it has to sit beside
#   res-arrival   28.7 -> 28.6      a hero; EVENTS' own measures 31.1
#   res-room      61.5 -> 40.5      the first interior after the hero
#   res-evening   64.2 -> 47.4      the wine act, beside THE CLUB's 46.1
#   res-morning   94.2 -> 62.0      THE PAGE'S ONE LIFT -- left the brightest
#                                   screen on the site, deliberately
#   res-window   104.1 -> 57.5      the afternoon, one step under the morning
#
# THE PAGE PEAKS AT THE MORNING AND NOT AT THE PARK, and that is the whole
# argument of the grade: the reader wakes up, and the light never gets better
# than the moment they do.
RES_ARRIVAL_GRADE = 'eq=brightness=0.012:contrast=1.030:saturation=0.97'
RES_ROOM_GRADE = 'eq=brightness=-0.062:contrast=1.020:saturation=0.96'
RES_MORNING_GRADE = ('eq=brightness=-0.105:contrast=1.020:saturation=0.95,'
                     'colorbalance=bs=-0.04:bm=-0.03')
RES_WINDOW_GRADE = ('eq=brightness=-0.190:contrast=0.95:saturation=0.90,'
                    'colorbalance=bs=-0.07:bm=-0.05')
RES_EVENING_GRADE = 'eq=brightness=-0.070:contrast=1.020:saturation=0.96'

SEQUENCES = {
    'res-room': (
        (16, 9), [768, 1152], None, RES_ROOM_GRADE,
        'ESTATE_and_HOSPITALITY/MAIN_MANOR_SUITE.png -> 16:9 crop -> Seedance 2.0',
        'Slow lateral drift to the right across the suite at blue hour, from '
        'the bed toward the window and the glazed doors.'),

    'res-morning': (
        (16, 9), [768, 1152], None, RES_MORNING_GRADE,
        'ESTATE_and_HOSPITALITY/MAIN_MANOR_SUITE.png -> GPT Image 2 morning '
        'still -> Seedance 2.0',
        'The light coming up in the same room, the curtains stirring, the '
        'camera almost still. THE ONE DAYLIGHT SEQUENCE ON THE SITE.'),

    'res-window': (
        (16, 9), [768, 1152], None, RES_WINDOW_GRADE,
        'interiors/interiors_13.png -> 16:9 crop -> Seedance 2.0',
        'Slow dolly toward the window bay, the bare branches moving outside '
        'and the daylight shifting on the parquet.'),

    'res-evening': (
        (16, 9), [768, 1152], None, RES_EVENING_GRADE,
        'interiors/interiors_1.jpg -> 16:9 crop -> Seedance 2.0',
        'Slow push toward the lit firebox, the flames breathing and the '
        'firelight moving on the piano.'),
}

# THE HERO IS NOT IN SEQUENCES BECAUSE IT DOES NOT GET WHAT THEY GET.
#
#   name, ratio, poster widths, grade
#
# It is the only film on the page encoded twice -- 1280 for a desktop and 854
# for a phone, which is film-hero.php's own pair and the Main Page's own
# reasoning: a 390px screen showing a 1280-wide film pays three times the bytes
# to fill it.
HERO_NAME = 'res-arrival'
HERO_RATIO = (16, 9)
HERO_POSTER_WIDTHS = [768, 1280]
HERO_GRADE = RES_ARRIVAL_GRADE

# CRF 29 ON THE FOUR SECTION FILMS, which is PADEL's and EVENTS' own number and
# for their own reason: these are lit interiors and moving foliage, which is the
# hardest material H.264 is ever given. res-window is the one that pays for it
# -- bare branches against a bright sky is the worst case in the whole library
# and it is still the largest of the five.
#
# AND THE HERO GOES TWO RUNGS FURTHER, to 31 wide and 32 narrow. It is 1280
# rather than 1152, it is the largest single file on the page, and it is the
# only one a reader meets before they have decided to stay. Same numbers as the
# Main Page's hero, PADEL's and EVENTS'.
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
# So each one plays forward and then backwards -- seamless by construction,
# because the last frame of the reverse IS the first frame of the forward, and
# no two framings are ever blended. This is tools/motion/build_sequences.sh's
# filter, verbatim.
#
# ONE OF THE FIVE PAYS A PRICE FOR IT AND IT IS res-morning, whose subject is
# the sun coming up: the second half of the loop runs the sunrise backwards. It
# is still the right filter -- the alternative is a visible cut from full
# morning back to first light every five seconds -- and on a change this gradual
# it reads as the light breathing. Same finding as EVENTS' ev-dusk. Recorded in
# docs/RESIDENCES.md §8.
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
            continue                      # never upscale -- see the note above

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
    one leaves the four files from the old ladder on disk afterwards -- the same
    photograph at a different crop, under the same stem, waiting for a content
    file to ask for both. img_files() reports what is really on disk, so two
    crops under one stem is one srcset made of two different pictures.

    It only ever touches <stem>-<digits>.<ext> for a stem this script declares,
    so nothing outside PLATES, SEQUENCES and the hero can be reached by it. The
    five stems the page this replaces built are cleared by retire_old_page()
    instead, which names them.
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


# THE FIVE STEMS THE OLD PAGE BUILT, AND THEY GO.
#
# build_images.py declared them -- that file is the non-film pages' builder and
# /residences was one until this rebuild -- so left alone they would be rebuilt
# by the next run of it and sit under assets/img/residences/ forever,
# unreferenced. The entries are removed from build_images.py in the same change;
# this list is what clears what is already on disk, and it is explicit rather
# than a wildcard so that it cannot reach a stem this page ships.
RETIRED = ['hero', 'interior', 'room-park', 'stair', 'fireplace']


def retire_old_page():
    print('\nRETIRED -- the stems the page this replaces built\n' + '-' * 78)

    out_dir = os.path.join(IMG, 'residences')

    if not os.path.isdir(out_dir):
        print('  nothing to remove')
        return

    for stem in RETIRED:
        gone = []

        for name in sorted(os.listdir(out_dir)):
            rung, dot, ext = name.rpartition('.')[0], '.', name.rpartition('.')[2]

            if ext not in ('jpg', 'jpeg', 'webp'):
                continue

            base, _, width = rung.rpartition('-')

            if base == stem and width.isdigit():
                os.remove(os.path.join(out_dir, name))
                gone.append(name)

        print(f'  {stem:<12} {len(gone)} files removed' if gone
              else f'  {stem:<12} already gone')


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
    rungs = poster(ff, wide, f'residences/{HERO_NAME}', HERO_RATIO,
                   HERO_POSTER_WIDTHS, frame)

    print(f'  {HERO_NAME:<13} {wide_bytes // 1024:>5} KB  '
          f'+ {small_bytes // 1024} KB narrow  poster {rungs}'
          f'  <- interiors_9.png -> GPT Image 2 -> Seedance 2.0')


def build_sequences():
    ff = ffmpeg()
    os.makedirs(VID, exist_ok=True)
    print('\nSEQUENCES -- encodes and posters\n' + '-' * 78)

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
        rungs = poster(ff, wide, f'residences/{name}', ratio, widths, frame)

        print(f'{line}  poster {rungs}  <- {source}')


if __name__ == '__main__':
    retire_old_page()
    build_plates()
    build_hero()
    build_sequences()
    print('\ndone.\n')
