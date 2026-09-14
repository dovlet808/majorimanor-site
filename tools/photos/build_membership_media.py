"""
Build MEMBERSHIP's media from media_src/, one GPT Image 2 still and two
Seedance 2.0 sequences.

WHAT THIS IS. /membership declares its pictures by stem — membership/mem-
threshold, membership/world-heritage — and img() in app/helpers.php looks for
assets/img/<stem>-<width>.<ext>. This script is the mapping between the material
in media_src/ and those stems, and it is a script rather than a folder of
hand-cut exports for the reason the eight build scripts before it are: every
crop is a decision, and a decision has to be re-readable and re-runnable.

THE NINTH FILM PAGE AND THE LAST GATE ON THE SITE. It ships TWO sequences and
EIGHT plates, which puts it between CONTACT (one and two) and RESIDENCES
(five and fifteen). The brief is explicit about the ceiling — "1 primary hero
sequence, optional 1 secondary atmospheric sequence", "do not create 5-6 videos
for this page", "the purpose is to make MEMBERSHIP feel cinematic, not to turn
the application process into a movie" — and everything below had to answer
"does a reader need to see this in order to decide whether to apply" before it
was allowed to exist.

EVERY PLATE ON THIS PAGE IS A CROP OF EXISTING MATERIAL AND NOT ONE OF THEM WAS
GENERATED. The brief's source-of-truth rule is that an existing asset that is
already strong is used rather than regenerated, and eight of the ten pictures on
this page cleared that test on the first pass. One still was generated, for the
one frame the library does not hold, and it is the hero.

═══════════════════════════════════════════════════════════════════════════════
THE ONE GENERATION, AND WHY IT IS NOT ad-nightfall

The brief's suggested hero — "slow, restrained cinematic arrival toward the
illuminated Majori Manor estate at night, mature trees framing the path" — is
almost word for word the shot AFTER DARK already ships as ITS hero. ad-nightfall
is an extremely slow approach across the lawn toward this house at night, out of
estate_4.jpg, and it is approved. Building it again here would be one page done
twice, which is the thing every script in this directory is written to prevent.

So this hero takes the brief's INTENT — the threshold of a private world, at
night — and finds the frame the site does not own:

                        source        elevation            hour      vantage
  est-arrival           estate_1      the gate             blue      through the piers
  est-house             estate_3      the north front      day       lateral
  est-park              estate_2      the garden front     golden    lateral drift
  con-arrival           estate_2      the portico          dusk      walking in
  ad-nightfall          estate_4      the long elevation   night     open lawn, forward
  ── mem-threshold      estate_3      the north front      night     INSIDE THE TREE LINE

estate_3.jpg is the north front — the curved barrel gable with its oculus, the
balcony on the stair bay, the panelled door and its stone steps — and it is the
one elevation of this house that has never been taken past daylight. THE ESTATE
animates it as a daytime lateral (est-house); nothing else uses it at all.

AND THE VANTAGE IS THE HALF THAT SEPARATES IT FROM ad-nightfall. That shot
stands out on an open lawn with one bare young tree and walks toward the house.
This one stands BACK INSIDE THE PARK'S TREE LINE: the trunks and the low
foliage of two mature trees are in the near foreground at both edges, unlit and
out of focus, and the lit house is seen between them. It is the brief's own
"mature trees framing the path" and it is a place on the estate no frame on this
site has stood before. A reader arriving at MEMBERSHIP is outside a world that
is lit — which is the whole argument of the page in one frame.

THE SECOND SEQUENCE IS NOT GENERATED AT ALL. mem-house is a 21:9 crop of
HOUSE_OF_DIALOGUE/1.png handed straight to Seedance. That file — the great hall
with people standing about it in evening dress — is on this site three times as
a still and has NEVER been animated, and it is the only picture in the library
that is literally the last screen's headline: the house, and the people in it.

═══════════════════════════════════════════════════════════════════════════════
TWO KINDS OF PICTURE COME OUT OF HERE AND THEY ARE TWO DIFFERENT CLAIMS.

  PHOTOGRAPH   two crops of the supplied photography of the real house and the
               real club: the coffered ceiling and the glazed screen over the
               stair, and the lamp-lit approach to the padel club at blue hour.
               Declared 'photo'.

  VISUALISATION  six crops of the project's own renders — the private dining
               room, the lit dome, the manor bar, the park at night, the
               members' room and the dining salon. Declared 'render', and each
               captioned as a room rather than as a service that is open.

  GENERATED    the hero sequence and its poster, which is frame 0 of the encode.
               It descends through a GPT Image 2 still that changed the hour and
               the vantage of a photograph of this house and nothing else.
               Declared 'generated'.

  mem-house's poster is 'render': the file it descends from is one of the
  project's own visualisations and Seedance moved a camera in it. It did not
  pass through an image generator, so 'generated' would over-claim.

WHAT IS NOT CLAIMED. No caption on this page names a price, a fee, a number of
members, a waiting list, an acceptance rate, a timeline or a benefit. The estate
has settled none of it (ARCHITECTURE §21), the page says so in words, and the
pictures are held to the same rule: the bar is "a bar", the hall is "the hall",
and the people in the frames are never described as members.

NOT ONE SOURCE:RATIO PAIR BELOW IS ONE ANOTHER PAGE HAS ALREADY CUT. Every
plate was checked against the eight scripts in this directory before it was
written down; the five ecosystem tiles are all 21:9 for that reason among
others, and 21:9 is also what makes this stack read as a different object from
THE CLUB's dialogue, EVENTS' and RESIDENCES', all three of which are 16:9.

BIAS IS THE FRACTION OF THE SURPLUS TAKEN OFF THE TOP (or off the left, on a
frame too wide for its slot). 0.5 is a centre crop. Where a value is not 0.5 the
reason is written beside it.

NOTHING IS UPSCALED. A rung wider than the crop is skipped rather than
interpolated, and it is the reason PRIVATE_CLUB_ECOSYSTEM/9.jpeg is not the
padel tile: boxed clear of the sign standing in the middle of it, that file
leaves 692px of usable width, which is short of the ladder's bottom rung. See
the note on world-padel.

Run from anywhere:  python3 tools/photos/build_membership_media.py
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

# The sequences as they came back from Seedance, the GPT Image 2 still the hero
# was made from, and the crops both started from.
#
# THE STILLS ARE COMMITTED AND THE .mp4 MASTERS ARE NOT, which is the
# repository's existing rule rather than a decision taken here: .gitignore
# carries /media_src/**/*.mp4 — the master stays on disk and in the backup, the
# encode under public_html/assets/video/ is the deliverable and that one is
# committed. So a fresh clone can rebuild every PLATE below, and rebuilding a
# SEQUENCE needs its master restored to this directory first.
MOTION = os.path.join(SRC, 'MOTION', 'membership')

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
# THREE CURVES, AND ALL THREE EXIST FOR THE SAME REASON: THIS PAGE IS NIGHT AND
# THREE OF ITS TEN PICTURES ARRIVE TOO BRIGHT FOR IT.
#
# Every approved band on this site measures between 18 and 49 out of 255:
# ad-garden is 18, ad-nightfall 31, est-arrival 40, ev-gather 42, pad-gates 49.
# A picture dropped into a MEMBERSHIP act above that range is a hole punched in
# the page, and three of the ten would have done it: the staircase at 81, the
# dining salon at 64 and the lit dome at 56.
#
# THE FIVE ECOSYSTEM TILES ARE GRADED TO ONE ROOM TONE AND NOT TO A DESCENT,
# which is the opposite of build_after_dark_media.py's arc and is the right
# call for this component rather than a departure from that one. AFTER DARK's
# five are five sequences a reader meets one screen at a time, so a curve
# through them reads as an evening going on. These five stand behind ONE list
# and CROSS-FADE INTO EACH OTHER as the reader scrolls — see film-dialogue.php.
# Two tiles eight points apart flash when they swap. So they are held inside a
# nine-point band instead:
#
#   world-heritage  81.0 -> 35.3   the woodwork
#   world-padel     44.6 -> 35.3   the approach
#   world-dining    34.9 -> 34.9   the table       (ungraded)
#   world-events    56.0 -> 33.4   the dome
#   world-dark      27.1 -> 27.1   the bar         (ungraded)
#
# EVENING is for the woodwork, and it is the steepest curve in this directory.
# GrandStaircase_3.jpg is a bright daylight interior — 81.0 out of 255 as cut,
# the brightest thing on this page by seventeen points — and it stands first in
# the ecosystem. Taken to a night curve it would be an underexposed daylight
# photograph rather than an evening, because the light in it is plainly coming
# through the glazed screen. So EVENING leans into that light instead:
# the mid comes down to 0.20, the highlights are held at 0.52 so the pale
# plaster of the vault and the polished handrail keep their modelling, and the
# blue channel comes down eleven percent against the green's five to warm it
# toward the lamp rather than toward the window. It measures 35.3.
#
# DUSK is for the club's approach. PRIVATE_CLUB_ECOSYSTEM/8.jpeg is already at
# blue hour — the sky in it has gone — so it needs about half as much: the mid to
# 0.40 and the highlights to 0.84, which takes the last of the daylight out of
# the hedge and the grass without touching the lit windows of the house or the
# illuminated panel, which are the two things in the frame that are supposed to
# be bright. 44.6 to 35.3.
#
# LANTERN is for the two renders that are simply lit brighter than this page —
# the dome and the dining salon. It is the gentlest of the three because
# neither picture is at the wrong HOUR; both are night already and both are
# just turned up. Mid 0.30, highlights 0.66, and barely any tilt, because the
# light in both is candle and filament and is the right colour as it stands.
#
# NOTHING ELSE IS GRADED. The five remaining pictures arrive between 23.6 and
# 35.7 as cut, which is inside the band the site already ships, and grading a
# picture that is already at its hour is grading a lie.
# ---------------------------------------------------------------------------

EVENING = (0.20, 0.52, (1.0, 0.95, 0.89))      # daylight interior -> lamplight
DUSK    = (0.40, 0.84, (1.0, 0.975, 0.94))     # the end of the afternoon
LANTERN = (0.30, 0.66, (1.0, 0.97, 0.93))      # a night render, turned down


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
# 'box' is a pixel window taken out of the source BEFORE the ratio is applied —
# (left, top, right, bottom), or None for the whole frame. It is
# build_contact_media.py's addition and no plate on this page needs it; it is
# kept so the two scripts read the same.
#
# THE FIVE ECOSYSTEM TILES ARE ALL 21:9 AND THAT IS ONE DECISION, NOT FIVE.
# Scene 02 is a film-dialogue — one large picture behind a list of names, the
# picture changing as the reader scrolls — and THE CLUB, EVENTS and RESIDENCES
# all set that component at 16:9. A fourth 16:9 dialogue is a fourth page that
# looks like the third. At 21:9 the stack is a widescreen strip rather than a
# stack of screens, it is the widest thing on the site after est-park, and it
# gave every one of the five an unclaimed source:ratio pair in a library where
# 16:9 is nearly exhausted. The mobile pass for it is membership.css §5.
# ---------------------------------------------------------------------------

PLATES = {

    # -- Scene 02: the world it opens ---------------------------------------

    'membership/world-heritage': (
        'grand-staircase/GrandStaircase_3.jpg',
        None, (21, 9), [768, 1152], 0.28, EVENING,
        'THE HOUSE AND ITS ROOMS, and it is a real photograph of real surviving '
        'fabric — the panelled coffers of the ceiling, the tall glazed timber '
        'screen with warm light standing behind it, and the carved balustrade of '
        'the staircase at the right. THE ESTATE takes this file at 3:2 for a '
        'chapter; at 21:9 it stops being a staircase seen whole and becomes a '
        'band of the joinery, which is what a tile behind a list of names has '
        'room to be.\n\n'
        '        BIAS 0.28 IS HIGH AND IT IS THE SECOND CROP RATHER THAN THE '
        'FIRST. Centred, this window lands on the lower half of the glazed '
        'screen and reads as a door with a rail beside it — a picture of nothing '
        'in particular. Taken up to 0.28 it catches the coffers along the top, '
        'the whole of the lit screen and the carving on the balustrade, and the '
        'frame is about the woodwork, which is what HERITAGE means on this '
        'site.\n\n'
        '        IT IS THE BRIGHTEST SOURCE ON THE PAGE AND TAKES THE STEEPEST '
        'CURVE: 81.0 as cut, 35.3 under EVENING. See §1.\n\n'
        '        IT IS THE ONE PICTURE ON THIS PAGE OF THE SURVIVING FABRIC, '
        'which is why it is the first of the five: HERITAGE is the only line in '
        'the ecosystem that is about something already standing.'),

    'membership/world-padel': (
        'PRIVATE_CLUB_ECOSYSTEM/8.jpeg',
        None, (21, 9), [768, 1152], 0.34, DUSK,
        'PADEL AND THE SOCIAL CLUB, in the one frame that is the club INSIDE the '
        'estate: the manor lit at the left, the lamp-lit path running down the '
        'middle, the clipped yew hedge, the courts\' fence above it, and the '
        'illuminated panel with the estate\'s crest on it at the right. PADEL '
        'animates this file at 16:9 as pad-gates, which is a camera walking the '
        'path past the sign; at 21:9 and standing still it is the whole approach '
        'seen at once.\n\n'
        '        BIAS 0.34 TAKES THE WORDS OUT OF THE FRAME. The lit panel reads '
        'MAJORI MANOR / PADEL CLUB in full, and a tile with a legible sign on it '
        'is the one tile in a five-tile stack a reader stops to READ instead of '
        'scrolling — and it would be saying, in letters, the word the label '
        'beside it already says. High, and the panel is a lit crest, the words '
        'are below the frame line, and the house and the path are what the '
        'picture is about.\n\n'
        '        DUSK takes it from 44.6 to 35.3 — the lightest of the three '
        'curves, because the photograph is already at its hour.\n\n'
        '        IT IS NOT PRIVATE_CLUB_ECOSYSTEM/9.jpeg, WHICH WAS CUT FIRST '
        'AND THROWN AWAY. That file is the terrace with the racket-shaped sign '
        'standing in the middle of it, and at 21:9 the sign is the picture at '
        'every bias: boxing it out leaves 692px of usable width, which is short '
        'of the ladder\'s bottom rung, and nothing on this site is upscaled.'),

    'membership/world-dining': (
        'RESTAURANT/private_dining_room.png',
        None, (21, 9), [768, 1152], 0.54, None,
        'DINING AND GATHERINGS — one long table laid for a dozen under a single '
        'low light, panelled walls, a chimneypiece and a painting over it. '
        'EVENTS takes this file at 16:9 and RESIDENCES at 4:5; at 21:9 the '
        'ceiling and the floor both go and what is left is the table, which is '
        'the noun in the line.\n\n'
        '        NOT GRADED. It measures 34.9 as cut — the room is lit by the '
        'candles and the one pendant over the table and nothing else — which is '
        'already inside the tile band.\n\n'
        '        BIAS 0.54 IS BARELY OFF CENTRE and the reason is the painting: '
        'at 0.5 its bottom edge cuts the frame line exactly, which reads as a '
        'mistake rather than as a crop.'),

    'membership/world-events': (
        'PRIVATE_CLUB_ECOSYSTEM/2.png',
        None, (21, 9), [768, 1152], 0.58, LANTERN,
        'THE PAVILION AND PRIVATE EVENTS — the geodesic dome at night with the '
        'dinner inside it, the glazing bars picked out in light and the tables '
        'under them. EVENTS animates this file at 16:9 as ev-celebrate and '
        'AFTER DARK takes it at 4:5; at 21:9 the top of the dome comes off and '
        'the frame is the room under the glass rather than the object in the '
        'park.\n\n'
        '        BIAS 0.58 KEEPS THE TABLES AND LOSES THE APEX. The dome is '
        'already on this site twice as a shape against a sky; the thing this '
        'tile has to say is that people eat under it.\n\n'
        '        LANTERN, because it arrives at 56.0 — the dome is lit from '
        'inside for a party and is the second-brightest thing considered for '
        'this page. Down to 33.4, which is inside the tile band and a point '
        'and a half under world-dining standing beside it.'),

    'membership/world-dark': (
        'CIGAR_HOUSE/main_bar.png',
        None, (21, 9), [768, 1152], 0.50, None,
        'EVENINGS AT THE ESTATE — the long bar, the ranked bottles behind it '
        'under their lamps, the stools along it and the boarded floor. AFTER '
        'DARK takes this file at 3:2 for a world tile and at 4:5 for a plate; '
        'at 21:9 it is the length of the bar and nothing above or below it, '
        'which is the only one of the three that reads at the size a dialogue '
        'tile is drawn.\n\n'
        '        CENTRED, because the bar runs the whole width of the frame and '
        'there is nothing at either edge to favour.\n\n'
        '        NOT GRADED: 27.1 as cut. It is the darkest of the five and it '
        'is last, and it is the one tile that needed nothing done to it.'),

    # -- Scene 03: belonging ------------------------------------------------

    'membership/mem-belong': (
        'PRIVATE_CLUB_ECOSYSTEM/3.png',
        None, (21, 9), [768, 1152], 0.56, None,
        'THE PARK AT NIGHT, AND IT IS THE ONE PICTURE ON THIS PAGE WITH NO ROOM '
        'AND NO BUILDING IN IT. Lamps down a wet path, clipped box either side, '
        'mature trees closing over the top, and the little open pavilion '
        'standing off among them. It carries "Some places are visited. Others, '
        'you belong to." and that sentence needed a frame that is a PLACE '
        'rather than a facility — a room under it would have made it a sentence '
        'about a room.\n\n'
        '        AFTER DARK animates this file at 16:9 as ad-garden, which is a '
        'camera moving through the planting in the middle of the night. At 21:9 '
        'and standing still it is the avenue seen whole, with the light going '
        'away from the reader down it, and it is the quietest thing on the '
        'page.\n\n'
        '        BIAS 0.56 PUTS THE PATH ON THE LOWER THIRD and keeps the '
        'canopy closing overhead. Higher and the trees go; lower and it is a '
        'photograph of paving.\n\n'
        '        NOT GRADED: 23.6 as cut, the darkest picture on this page by '
        'three points, and this scene is meant to be the one a reader can '
        'hear.'),

    # -- Scene 04: members and guests ---------------------------------------

    'membership/mem-room': (
        'PRIVATE_CLUB_ECOSYSTEM/4.png',
        None, (3, 4), [640, 960], 0.44, None,
        'THREE PEOPLE STANDING AT THE BAR IN A PANELLED ROOM, SEEN FROM BEHIND. '
        'The brief asks for silhouettes, small groups, quiet conversations, '
        'people seen from behind, and for no identifiable close-up portraits; '
        'this is the frame in the library that is all four at once. Nobody in '
        'it faces the camera and nobody is closer to it than about four metres.\n\n'
        '        AT 3:4 IT IS A PORTRAIT OF THE ROOM AND NOT OF THE PEOPLE, '
        'which is the whole reason for the ratio. THE CLUB takes this file at '
        '16:9, EVENTS at 3:2 and RESIDENCES at 4:5, and all three are wide '
        'frames of a lounge; upright, the chandelier, the panelling, the '
        'chesterfields and the three figures stack into one column and the '
        'figures are a third of it.\n\n'
        '        BIAS 0.44 KEEPS THE CHANDELIER IN. It is the top of the room '
        'and the thing that says the room is in a house rather than in a hotel.'),

    'membership/mem-table': (
        'RESTAURANT/dining_salon.png',
        None, (3, 4), [640, 960], 0.50, LANTERN,
        'A TABLE LAID FOR A SMALL PARTY, upright beside the room above it. THE '
        'CLUB animates this file at 16:9 as club-dining and takes it at 4:5; '
        '3:4 is the one shape that is not on the site, and it is the shape that '
        'puts the table, the glasses, the panelling and the light over it into '
        'one column beside mem-room\'s.\n\n'
        '        THE TWO PLATES ARE THE WHOLE OF SCENE 04 and there is no third '
        'on purpose. "Members bring guests" is a sentence about two things — a '
        'room people stand in and a table people sit at — and a third picture '
        'would have been the page saying it again.\n\n'
        '        LANTERN, because it arrives at 63.7 — this render is lit '
        'like a photographed restaurant rather than like a room at ten at '
        'night. Down to 38.1, two and a half points over mem-room standing '
        'beside it, which is as close as two different rooms should be asked '
        'to come.'),
}


# ---------------------------------------------------------------------------
# 3. The sequences
#
#   name : (ratio, poster widths, trim seconds or None, grade or None, source)
#
# TWO, AND THE BRIEF'S CEILING IS TWO. The hero, and the last screen. Everything
# between them is a still and CSS, which is the brief's own instruction — "use
# existing photography and CSS motion for the remainder" — and is also what
# keeps this page under a megabyte.
# ---------------------------------------------------------------------------

# THE PROMPTS, VERBATIM, because a prompt is the only part of a generated asset
# that cannot be recovered by looking at it. All three are written as a
# PRESERVATION instruction rather than a description: each names the
# architecture, the joinery and the materials of that specific frame, states the
# one thing that may change, lists the motion that is allowed, and then says
# what may not appear. The negative half is the half that does the work. Same
# shape as build_contact_media.py and build_after_dark_media.py.
#
# ---- The crops the generations start from ---------------------------------
#
# ref-threshold  estate/estate_3.jpg, 16:9 at bias 0.80 (869x488) — the north
#                front: the curved barrel gable with its oculus at the left, the
#                slate roof and its dormer, the brown-framed windows in their
#                bays, the canted stair bay with the balcony on it, the panelled
#                timber door and its stone steps, the granite rubble plinth, and
#                the clipped box of the parterre across the foot of the frame.
#                Bias 0.80 is what puts the door, the steps and the parterre in
#                the window: at 0.5 this crop is roof and first-floor windows.
#                THE ESTATE uses this file at 4:5 and animates it in daylight as
#                est-house; this crop is wider, lower, and centred on the way in.
#
# ref-hall       HOUSE_OF_DIALOGUE/1.png, 21:9 at bias 0.42 (2816x1207) — the
#                great hall by chandelier light with people standing about it in
#                evening dress at a distance, the chequered marble floor, the
#                staircase at the back and the portraits on the walls. The Main
#                Page and THE CLUB both take this file at 16:9 and AFTER DARK at
#                3:2; 21:9 is unclaimed, and no page has ever put a camera in it.
#                Bias 0.42 holds the chandelier and the heads of the standing
#                figures in the same window.
#
# ---- GPT Image 2, 2K, high, 16:9, from a reference -------------------------
#
# still-threshold  <- ref-threshold
#   "Preserve this exact manor house precisely and change only the hour, the
#    lighting and the vantage point. Keep every structural element exactly as
#    photographed and in exactly the same position, proportion and perspective:
#    the long two-storey elevation in pale cream roughcast render; the curved
#    barrel gable at the left with the round oculus window in it, its radiating
#    glazing bars and its brown moulded surround; the steep grey slate roof with
#    its courses of slate and the single small dormer with a brown-framed window
#    in the roof slope; the tall brown-framed multi-pane timber windows in their
#    several sizes, all in brown surrounds, in the same bays and the same rhythm
#    along the front; the canted stair bay with its tall narrow stair window and
#    the small first-floor balcony on it with a turned timber balustrade carried
#    on brackets; the brown panelled timber front door with a glazed upper panel
#    and its moulded brown architrave; the flight of shallow stone steps rising
#    to that door with its dark iron handrail; the granite rubble stone plinth
#    running along the base of the wall with its small vent opening; the
#    rainwater downpipe; the clipped low box hedging of the parterre, the
#    ornamental grasses and the low shrubs in the beds; the gravel and the mown
#    lawn across the foreground. Change the light: it is now night, well after
#    dark. The sky is a deep near-black blue with no daylight left in it. The
#    house is lit only by its own lights: steady warm lamplight standing in the
#    ground-floor and first-floor windows, some rooms brighter than others and
#    two or three windows dark; a warm lantern over the front door with its
#    light falling down the stone steps onto the gravel; and low warm garden
#    uplighting grazing the granite plinth and the clipped box of the parterre
#    from below. The slate roof goes almost black, the cream render holds a warm
#    cast where the light reaches it and falls into deep cool shadow where it
#    does not. Change the vantage: the camera now stands back inside the park's
#    tree line, so the heavy dark trunks and the low overhanging foliage of two
#    mature deciduous trees enter the frame at the left edge and the right edge
#    as unlit near-black silhouettes, slightly out of focus, and the lit house
#    is seen between them across the dark lawn. No new architecture. No new
#    doors, windows, dormers, chimneys, wings, porches, balconies, railings,
#    terraces, paths, driveways, gates, fences, garden furniture, planting beds,
#    statues, flags, signage or lettering. No redesign of the gable, the oculus,
#    the roof, the windows, the balcony, the door, the steps or the plinth. No
#    people. No animals. No vehicles. No visible light fittings, lamp posts or
#    bollards. No windows switching on or off. No fog, no rain, no snow, no
#    fireworks, no moon. Restrained European private-estate architectural
#    photography at night, warm practical light against a deep blue-black sky,
#    natural colour, unstaged, no lens flare, no HDR."
#
#   THE HOUR AND THE VANTAGE CHANGED AND THE BUILDING DID NOT. Every noun the
#   prompt keeps is a noun in estate_3.jpg: the same barrel gable, the same
#   oculus with the same glazing bars, the same dormer, the same balcony on the
#   same canted bay, the same door, the same steps, the same rubble plinth, the
#   same box parterre.
#
#   WHAT THE MODEL DID WITH IT, STATED RATHER THAN HIDDEN — see docs/
#   MEMBERSHIP.md §8, which carries the full list.
#
# ---- Seedance 2.0, 720p, std, 5s, no audio, start_image --------------------
#
# START_IMAGE AND NOT omni_reference, WHICH IS THE RULE build_events_media.py
# SET AND FIVE PAGES HAVE KEPT. This brief asks for mode: omni_reference;
# start_image is what both sequences are built on instead, and the reason is the
# brief's own source-of-truth rule — "preserve architecture, manor identity,
# materials, landscaping, room proportions, lighting language". A reference is a
# mood and a start frame is a contract: it is the only setting under which a
# barrel gable, an oculus and a glazing pattern survive five seconds of camera
# movement intact, and it is what every sequence on the eight approved pages
# uses. It is also what makes the poster honest: frame 0 of the encode is what
# the reader sees before the video plays, so the still and the film cannot
# re-frame against each other when the video fades up.
#
# mem-threshold  <- still-threshold
#   "Extremely slow cinematic approach toward this exact manor house at night,
#    seen from inside the park's tree line across the dark lawn. Preserve
#    everything exactly as photographed: the long two-storey elevation in pale
#    cream render; the curved barrel gable at the left with the round oculus
#    window in it; the steep slate roof with its dormer; the brown-framed
#    multi-pane timber windows in their bays with steady warm lamplight standing
#    in them; the canted stair bay with the small balcony and its turned timber
#    balustrade; the panelled timber front door with the lantern burning over it
#    and the light falling down the stone steps; the granite rubble plinth
#    grazed by low warm garden light; the clipped box of the parterre; the dark
#    lawn across the foreground; the heavy dark trunks and low foliage of the
#    two mature trees standing unlit at the left and right edges of the frame;
#    the deep near-black blue night sky. The only motion: the camera moves
#    forward extremely slowly and perfectly level, so the house grows almost
#    imperceptibly larger and opens a little between the two trees, with gentle
#    parallax between the dark foliage in the foreground and the lit facade
#    beyond it; the leaves and the outer branches of both trees stir very
#    faintly in the night air; the warm light in the windows and under the
#    lantern breathes almost imperceptibly. The camera stays back among the
#    trees and never reaches the lawn's far edge, never reaches the parterre and
#    never reaches the steps. No people. No animals. No vehicles. No new
#    architecture, wings, windows, doors, dormers, chimneys, balconies, paths,
#    terraces, gates, lamps, lamp posts, furniture, planting, signage or
#    lettering. No redesign of the gable, the oculus, the roof, the joinery, the
#    balcony, the door, the steps or the plinth. No lights switching on or off.
#    No door opening or closing. No fog, no rain, no snow, no fireworks, no
#    moon. Restrained European private-estate architectural cinematography at
#    night, warm practical light against a deep blue-black sky, one continuous
#    shot, no cuts, no camera shake, no zoom snap, no lens flare."
#
# mem-house  <- ref-hall
#   "The great hall of a private house on an evening, with people standing about
#    it in small groups in evening dress. Preserve everything exactly as
#    photographed: the chequered marble floor; the panelled walls and the gilt-
#    framed portraits on them; the timber staircase rising at the back of the
#    hall with its turned balusters and its moulded handrail; the chandelier
#    hanging over the middle of the room and the wall lights burning warm along
#    both sides; the standing figures in dark evening dress at their distances,
#    in the same positions, in the same groups, at the same scale, all of them
#    turned toward each other and none of them toward the camera. The only
#    motion: the camera drifts forward almost imperceptibly and perfectly level
#    down the length of the hall; the standing figures shift their weight and
#    incline their heads very slightly in conversation where they stand; the
#    warm light of the chandelier and the wall lights breathes very slightly.
#    Nobody walks. Nobody crosses the frame. Nobody turns to face the camera.
#    Nobody arrives and nobody leaves. No new people. No faces in close-up. No
#    new architecture, doors, windows, staircases, furniture, chandeliers,
#    lamps, signage or lettering. No redesign of the floor, the panelling, the
#    portraits or the staircase. Restrained European private-club
#    cinematography, warm chandelier and lamplight against dark panelling, one
#    continuous shot, no cuts, no camera shake, no zoom snap, no lens flare."
#
#   NOBODY WALKS, AND THAT IS THE WHOLE INSTRUCTION. The brief asks for subtle
#   human presence, for no crowds and for the environment to remain the
#   protagonist. A figure crossing a five-second frame is the only thing a
#   reader would look at; figures shifting their weight where they stand are a
#   room with people in it.
# ---------------------------------------------------------------------------

SEQUENCES = {
    # name             ratio    poster widths  trim  grade         source
    'mem-threshold': (
        (16, 9), [768, 1280], 3.4,
        'eq=gamma=0.94:contrast=1.020:saturation=0.96',
        'estate/estate_3.jpg -> GPT Image 2 night still -> Seedance 2.0'),

    'mem-house': (
        (21, 9), [768, 1152], 2.6,
        'eq=gamma=0.88:contrast=1.025:saturation=0.94',
        'HOUSE_OF_DIALOGUE/1.png -> 21:9 crop -> Seedance 2.0'),
}

# THE HERO IS THE ONLY FILM ON THIS PAGE ENCODED TWICE — 1280 for a desktop and
# 854 for a phone, which is film-hero.php's own pair and the Main Page's own
# reasoning: a 390px screen showing a 1280-wide film pays three times the bytes
# to fill it. mem-house is a band rather than a hero, and film-band.php reads
# one source, so it ships at 1152 only.
HERO_NAME = 'mem-threshold'

HERO_WIDE = 1280
HERO_NARROW = 854
BAND_WIDE = 1152

# THE THREE NUMBERS WERE CHOSEN BY LOOKING AT THE FRAMES, NOT BY COPYING A ROW.
# The hero is night footage of a pale rendered wall under a deep blue sky, which
# is the two things h264 is worst at in one frame: a flat gradient that bands and
# a fine texture that smooths. Cut at three stops and compared at 1:1 on the
# gable — the oculus glazing bars, the roughcast render, the sky above the roof:
#
#     crf 27   855 KB   no visible loss
#     crf 29   619 KB   no visible loss — the render still has its texture
#     crf 31   454 KB   the sky flattens and the roughcast starts to smooth
#
# 29 is the last stop before the picture changes, and it saves 28 percent over
# 27. The narrow encode goes one further, to 31, because it is 854 wide on a
# phone and the detail that 29 protects is not resolvable there. The band takes
# 31 as well: it is dark panelling behind a title, it is the second video on a
# page whose form has priority over its film, and it is never the first thing
# fetched.
CRF_HERO = 29
CRF_NARROW = 31
CRF_BAND = 31


# ---------------------------------------------------------------------------
# 4. The loop is a palindrome
#
# Both sequences are a single continuous camera move that never returns to where
# it started, so no frame in either matches its own first frame. A hard cut back
# to frame 0 jumps, and on shots this slow a jump is the only thing in them that
# moves quickly. A cross-dissolve is worse: dissolving a near framing into a far
# one ghosts the scene against itself.
#
# So each plays forward and then backwards — seamless by construction, because
# the last frame of the reverse IS the first frame of the forward, and no two
# framings are ever blended. This is tools/motion/build_sequences.sh's filter,
# verbatim.
# ---------------------------------------------------------------------------

PALINDROME = ('[0:v]split[a][b];[b]reverse,trim=start_frame=1,'
              'setpts=PTS-STARTPTS[r];[a][r]concat=n=2:v=1[c]')


# ---------------------------------------------------------------------------
# 5. The machinery
#
# crop_box, export, prune, encode and poster are build_contact_media.py's,
# unchanged. They are copied rather than imported for the reason every one of
# these scripts is standalone: a build script that a future reader has to follow
# across three files to find out what a crop was is a build script that stops
# being read.
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


def mean_level(image):
    """Mean luminance out of 255 — the number the grade notes above quote."""
    grey = image.convert('L')
    histogram = grey.histogram()
    total = sum(histogram)

    return round(sum(i * n for i, n in enumerate(histogram)) / total, 1)


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
            raw = mean_level(cut)

            if graded is not None:
                cut = cut.point(grade_lut(graded))

            level = mean_level(cut)
            rungs = export(cut, stem, widths)

        print(f'  {stem:<28} {ratio[0]}:{ratio[1]:<3} {str(rungs):<14}'
              f'{raw:>6} ->{level:>6}{"  graded" if graded else ""}  <- {source}')


def encode(ff, master, out, width, crf, extra_filter='', trim=None):
    """Palindrome, scale, encode, no audio. `trim` cuts the input first."""
    chain = f'{PALINDROME};[c]scale={width}:-2:flags=lanczos'

    if extra_filter:
        chain += f',{extra_filter}'

    chain += ',format=yuv420p[v]'

    # THE TRIM IS AN INPUT OPTION AND IT HAS TO BE, WHICH IS A CORRECTION TO THE
    # EIGHT SCRIPTS BEFORE THIS ONE AND IS WORTH THE PARAGRAPH.
    #
    # build_contact_media.py puts '-t' AFTER '-i', with a comment saying that
    # there it "limits the decode, which is what the palindrome then reverses".
    # It does not. After '-i', '-t' is an OUTPUT option and ffmpeg applies it to
    # the finished filter graph: the palindrome is built from the whole five
    # seconds, giving ten, and then the first 3.4 of those ten are kept. What
    # ships is therefore the forward pass alone, cut off mid-move — and because
    # nothing brings it home, the loop hard-cuts from the last frame back to the
    # first every time it repeats.
    #
    # MEASURED, ON THE FILES THEMSELVES. Mean absolute difference between the
    # first frame and the last, out of 255:
    #
    #     ad-nightfall   3.2   no trim — a true palindrome, seamless
    #     con-arrival   34.0   trimmed  — a visible cut every 3.2 seconds
    #
    # Before '-i', '-t' limits how much of the INPUT is read, which is what the
    # comment describes and what the palindrome then needs: 3.4 seconds in, 6.8
    # out, and the last frame of the reverse IS the first frame of the forward.
    # ('-ss' is the option that seeks; '-t' does not.) After this change
    # mem-threshold measures 0.0 and mem-house 0.0.
    #
    # build_contact_media.py IS NOT TOUCHED AND con-arrival IS NOT RE-ENCODED.
    # CONTACT is approved, its bytes are what the CEO saw, and a page this work
    # is not allowed to modify is not a page to fix quietly. It is written up in
    # docs/MEMBERSHIP.md §9 as a defect in the shared machinery, with the
    # measurement, for whoever takes that page next.
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


def build_sequences():
    ff = ffmpeg()
    os.makedirs(VID, exist_ok=True)
    os.makedirs(MOTION, exist_ok=True)
    print('\nSEQUENCES\n' + '-' * 78)

    for name, (ratio, poster_widths, trim, grade, source) in SEQUENCES.items():
        master = os.path.join(MOTION, f'{name}.mp4')

        if not os.path.isfile(master):
            print(f'  MISSING  {master}')
            continue

        is_hero = name == HERO_NAME

        wide = os.path.join(VID, f'{name}.mp4')
        wide_bytes = encode(ff, master, wide,
                            HERO_WIDE if is_hero else BAND_WIDE,
                            CRF_HERO if is_hero else CRF_BAND, grade, trim)

        narrow_note = ''

        if is_hero:
            small = os.path.join(VID, f'{name}-sm.mp4')
            small_bytes = encode(ff, master, small, HERO_NARROW, CRF_NARROW,
                                 grade, trim)
            narrow_note = f'  + {small_bytes // 1024} KB narrow'

        frame = os.path.join(MOTION, f'{name}-frame0.png')
        rungs = poster(ff, wide, f'membership/{name}', ratio, poster_widths, frame)

        print(f'  {name:<15} {wide_bytes // 1024:>5} KB{narrow_note}'
              f'  trimmed {trim}s  graded  poster {rungs}\n'
              f'  {"":<15} <- {source}')


if __name__ == '__main__':
    build_plates()
    build_sequences()
    print('\ndone.\n')
