"""
Build the site's photography from the concept-brochure frames.

WHAT THIS SOLVES. The content files declare image slots by stem — home/estate,
estate/stove-piano — and img() in app/helpers.php draws a hatched placeholder for
every stem it cannot find on disk. The frames that exist are grouped by subject
rather than by slot (assets/img/estate, interiors, pavilion, heritage-details,
grand-staircase) and are neither cropped nor named to the convention. This script
is the mapping. It is a script rather than a folder of hand-cut exports because
the crop of every frame is a decision that has to be re-readable and re-runnable,
and because ONE table is the only way the question "which slot owns this frame?"
has a single answer — see the collision check at the bottom.

THE FRAMES ARE FEWER THAN THE SLOTS, AND SOME SLOTS LOSE.

A slot with no frame keeps its placeholder. That is not a gap to be filled with
the nearest thing to hand: the hatched box says "no photograph yet", which is
true and reviewable, while a stand-in says "this is the room" and is not.

    home/padel      no frame of the courts exists anywhere in the material.
                    They are not built. Nothing may stand in for them.

NOTHING IS UPSCALED, SO MOST LADDERS ARE SHORT.

§11 asks for 1280/1920/2560 on a hero, 960/1280/1920 on a chapter or split, and
640/960/1280 on a gallery thumbnail (with the lightbox reading the chapter
ladder). The widest frame in the brochure is 1735px and most are ~1180 — the
shortfall HANDOFF §4.1 records. Each slot is therefore exported at the rungs its
own frame can fill after cropping, and no others: an upscale is a soft image sold
as a sharp one, and img_files() is built to publish a one-entry srcset rather
than two broken URLs.

That truncation is also why a frame cannot simply be moved between slots. A hero
needs 1280 after cropping, which of the four exterior frames only estate_1
reaches — estate_2, _3 and _4 top out at 900-1055px. estate/hero-facade has one
possible frame and that is the whole reason estate_1 appears twice below.

WHY A BIAS AND NOT A CENTRE CROP. Most frames are portrait and most slots are
not, so a crop throws away up to two fifths of the height and where that height
comes from decides what survives. Centred, interiors_1 loses the crown of the
stove and pavilion_2 is all pine trees with the dome sliced off the bottom. The
bias below is the fraction of the surplus taken off the TOP (or off the LEFT, on
a frame that is too wide for its slot), each one was chosen by looking at the
result, and the reason is written beside it.

STALE RUNGS ARE DELETED, NOT LEFT. Re-pointing a slot at a narrower frame would
otherwise leave the old frame's wider rung on disk, and img_files() would put two
different photographs in one srcset. Every run sweeps the rungs it did not write.

Run from anywhere:  python3 tools/photos/build_images.py
"""
import os

from PIL import Image

HERE = os.path.dirname(os.path.abspath(__file__))
ROOT = os.path.dirname(os.path.dirname(HERE))          # tools/photos -> project root
IMG = os.path.join(ROOT, 'public_html', 'assets', 'img')

# The ladders from ARCHITECTURE §11. Rungs wider than the cropped frame are
# dropped. GALLERY is the union of the thumbnail ladder and the lightbox's,
# because one file serves both — see templates/components/gallery.php.
HERO = (1280, 1920, 2560)
CHAPTER = (960, 1280, 1920)
GALLERY = (640, 960, 1280, 1920)

JPEG_Q = 82
WEBP_Q = 80

# A frame that is deliberately in two slots, and the reason. Anything else
# appearing twice is a mistake and the run says so.
#
# The three pavilion frames are shared because there are three photographs of
# the pavilion and two pages about it. The home page's chapter 05 is the teaser
# that points at /events, so both pages are showing the same building on purpose;
# there is no re-pointing that removes the overlap, only frames that do not exist.
# /residences borrows four frames for a different reason: every slot on that page
# is declared 'mood', which is exactly the licence to stand a reference image in
# a slot, and there is no unused interior material left. The same photograph can
# be a captioned heritage item on /the-estate and atmosphere there, because the
# declaration describes what the SLOT claims and not what the file is. Each
# borrowed frame is cropped for its own slot rather than copied.
SHARED = {
    'estate/estate_1': 'the only exterior frame that reaches a hero rung',
    'pavilion/pavilion_1': 'the only night frame of the pavilion, and two pages open on it',
    'pavilion/pavilion_2': 'the only daylight frame of the pavilion',
    'pavilion/pavilion_3': 'the only frame of a table laid under the dome',
    'heritage-details/heritage_1': 'the only interior with the park showing through it',
    'grand-staircase/GrandStaircase_3': 'the only frame of a window as its subject',
    'interiors/interiors_4': 'the only frame of a stair turning out of sight',
    'interiors/interiors_1': 'the only frame of a lit fire',
    'interiors/interiors_3': 'the only interior shot in low light',
}

# slot stem, master frame, ratio (None = no crop), bias, ladder, why this bias
SLOTS = (
    # -- home ---------------------------------------------------------------
    ('home/hero-pavilion-night', 'pavilion/pavilion_1', None, None, HERO,
     'No crop. The hero band is a window height and CSS covers it, so the '
     'widest frame available gives the crop the most to work with on a phone.'),

    ('home/estate', 'estate/estate_1', (3, 2), 0.50, CHAPTER,
     'Landscape already; only 179px of width comes off. Centred, because both '
     'gate piers frame the house and losing one unbalances it.'),

    ('home/club', 'interiors/interiors_2', (3, 2), 0.65, CHAPTER,
     'Low enough to stand the marble chimneypiece on its floor and keep the '
     'panelling behind it. Higher and the room is all wall.'),

    ('home/dining', 'pavilion/pavilion_3', (3, 2), 0.78, CHAPTER,
     'Low. The subject is the tables, not the dome above them — a centred crop '
     'is two thirds roof.'),

    ('home/pavilion', 'pavilion/pavilion_2', (3, 2), 0.82, CHAPTER,
     'Low, for the same reason inverted: the dome and the lawn sit in the '
     'bottom fifth and everything above them is pine wood.'),

    ('home/after-dark', 'interiors/interiors_3', (3, 2), 0.40, CHAPTER,
     'Keeps the chandelier whole with a band of dark ceiling above it, which is '
     'what makes the frame read as night rather than as a hall.'),

    ('home/residences', 'grand-staircase/GrandStaircase_4', (3, 2), 0.35, CHAPTER,
     'Holds the open leaded window and the doorway through to the next room — '
     'the threshold, which is what the chapter is about.'),

    # -- the estate ---------------------------------------------------------
    ('estate/hero-facade', 'estate/estate_1', (16, 9), 0.50, HERO,
     'Only 50px of height comes off a frame that is nearly 16/9 already, and '
     'the band re-crops it anyway. Centred.'),

    ('estate/staircase', 'heritage-details/heritage_3', (3, 4), 0.35, CHAPTER,
     'Puts the sweep of the stair and its balusters through the middle of a '
     'tall frame, with the marble floor under it.'),

    ('estate/stove-piano', 'interiors/interiors_1', (3, 4), 0.30, GALLERY,
     'The stove is the subject and the piano is the "with", so the stove sits '
     'centre-left with the lit firebox and the piano stays beside it.'),

    ('estate/marble-hall', 'heritage-details/heritage_2', (3, 2), 0.70, GALLERY,
     'Low, because the slot is the FLOOR: the checkerboard marble fills the '
     'frame and the glazed screen above it says which room it is in.'),

    ('estate/stained-glass', 'grand-staircase/GrandStaircase_2', (3, 4), 0.30, GALLERY,
     'Centres the stained-glass window in the stairwell. It cannot be cropped '
     'closer — the window alone is some 300px across and would fill no rung.'),

    ('estate/coffered-ceiling', 'grand-staircase/GrandStaircase_3', (3, 2), 0.00, GALLERY,
     'Hard top. The coffers are the slot and they are at the top of the frame; '
     'anything lower turns the picture into a balustrade with a ceiling above.'),

    ('estate/balustrade', 'interiors/interiors_4', (3, 4), 0.35, GALLERY,
     'The turned balusters carry the frame corner to corner, with the treads '
     'below them and no more wall than that needs.'),

    ('estate/glazed-doors', 'heritage-details/heritage_1', (3, 2), 0.60, GALLERY,
     'Right of centre, where a leaf stands open and the room beyond shows '
     'through it — the slot is doors BETWEEN two rooms.'),

    ('estate/park', 'estate/estate_4', (4, 3), 0.85, CHAPTER,
     'As low as the roofline allows, for as much lawn as the frame holds. This '
     'is a facade shot with its ground in it, which is the honest most of it.'),

    # -- events -------------------------------------------------------------
    #
    # EVENTS IS NOT BUILT HERE ANY MORE.
    #
    # This block used to carry three slots — events/hero-pavilion-night,
    # events/pavilion-day and events/dinner-inside — cut from the three
    # photographs of the pavilion for the informational page that /events used
    # to be. That page was replaced by a film page in the series that begins
    # with the Main Page, and film pages build their media from their own
    # script: tools/photos/build_events_media.py, which declares fourteen
    # plates, five encodes and their posters, at the ladders film-band.php and
    # film-dialogue.php actually request.
    #
    # THE ENTRIES ARE REMOVED RATHER THAN LEFT IN, and that is the whole reason
    # this note exists. events/pavilion-day still exists as a stem — at 768 and
    # 1152, cut low out of pavilion_2 and graded to dusk. The rows here wrote
    # the SAME STEM at 640 and 960, cut at a different bias and ungraded. Two
    # scripts writing one stem is the failure this file's own header warns
    # about ("one table on the whole site — otherwise on the question 'whose
    # frame is this' two scripts give two answers"), and a stale 640 sitting
    # beside a live 1152 is the same picture at two crops waiting for a content
    # file to ask for both. The four stale files were deleted with them.

    # -- residences ---------------------------------------------------------
    #
    # NOTHING. /residences was rebuilt on the film in the same pass that added
    # tools/photos/build_residences_media.py, and every picture on it is
    # declared there — nineteen plates, five sequences and their posters. The
    # five stems this table used to hold (hero, interior, room-park, stair,
    # fireplace) were one unused frame and four borrowed from /the-estate, and
    # the rebuilt page borrows none of them.
    #
    # THEY ARE REMOVED FROM HERE RATHER THAN LEFT TO BE OVERWRITTEN, for the
    # reason this file's own header gives about /the-club: two scripts writing
    # one stem is the failure it warns about, and a stale export sitting beside
    # a live one is the same picture at two crops waiting for a content file to
    # ask for both. The files themselves are cleared by retire_old_page() in
    # build_residences_media.py, which names all five.

    # -- after dark ---------------------------------------------------------
    #
    # THE ONE SLOT THIS PAGE HAD IS GONE, AND SO IS THE PAGE THAT ASKED FOR IT.
    # /after-dark was a page of sections until the film rebuild; it is now the
    # seventh page cut from the film and every picture on it is declared in
    # tools/photos/build_after_dark_media.py. The entry is removed from here
    # rather than left to be overwritten, for the reason this file's own header
    # gives about /the-club: two scripts writing one stem is the failure it
    # warns about. The file itself is cleared by retire_old_page() in that
    # script, which names all three of the stems the old page declared —
    # cigar-whisky, hero and gaming-salon — the last two of which never had a
    # file, because no frame existed for either of them.
    #
    # AND THE THING THAT NEEDED A GENERATION IS THE THING THAT BLOCKED THIS
    # SLOT: the note that stood here said "after-dark/hero wants the manor at
    # night and NO NIGHT FRAME OF THE HOUSE EXISTS". One now does. See
    # docs/AFTER_DARK.md §3.
)


def crop_to(im, ratio, bias):
    """The frame at `ratio`, with `bias` of the surplus off the top or left."""
    w, h = im.size
    want = ratio[0] / ratio[1]

    if w / h > want:
        nw, nh = int(round(h * want)), h
        off = int(round((w - nw) * bias))
        return im.crop((off, 0, off + nw, nh))

    nw, nh = w, int(round(w / want))
    off = int(round((h - nh) * bias))
    return im.crop((0, off, nw, off + nh))


def export(im, stem, width):
    """One rung, both formats. Returns (jpeg bytes, webp bytes)."""
    height = max(1, int(round(width * im.height / im.width)))
    rung = im.resize((width, height), Image.LANCZOS)

    jpg = os.path.join(IMG, f'{stem}-{width}.jpg')
    webp = os.path.join(IMG, f'{stem}-{width}.webp')

    # No EXIF is carried over: it is a camera's notes on a file nobody is
    # asking about, and on a poster it is weight against a 350 KB ceiling.
    rung.save(jpg, 'JPEG', quality=JPEG_Q, optimize=True, progressive=True)
    rung.save(webp, 'WEBP', quality=WEBP_Q, method=6)

    return os.path.getsize(jpg), os.path.getsize(webp)


def sweep(stem, widths):
    """Delete rungs of `stem` that this run did not write. See the docstring."""
    gone = []

    for width in widths:
        for extension in ('jpg', 'webp'):
            path = os.path.join(IMG, f'{stem}-{width}.{extension}')

            if os.path.isfile(path):
                os.remove(path)
                gone.append(f'{width}.{extension}')

    return gone


def main():
    for stem, master, ratio, bias, widths, _why in SLOTS:
        os.makedirs(os.path.join(IMG, os.path.dirname(stem)), exist_ok=True)

        path = os.path.join(IMG, f'{master}.jpg')

        if not os.path.isfile(path):
            print(f'  MISSING  {master}.jpg — {stem} keeps its placeholder')
            continue

        frame = Image.open(path).convert('RGB')
        source = frame.size
        frame = frame if ratio is None else crop_to(frame, ratio, bias)

        rungs = [w for w in widths if w <= frame.width]
        dropped = [w for w in widths if w > frame.width]

        print(f'{stem}')
        print(f'  {master}.jpg  {source[0]}x{source[1]}'
              f'  ->  {frame.width}x{frame.height}')

        for width in rungs:
            jpeg_kb, webp_kb = (n / 1024 for n in export(frame, stem, width))
            print(f'  {width:>4}  jpg {jpeg_kb:6.0f} KB   webp {webp_kb:6.0f} KB')

        if dropped:
            print(f'  no {", ".join(str(w) for w in dropped)}'
                  f' — the frame is only {frame.width}px wide')

        gone = sweep(stem, dropped)

        if gone:
            print(f'  swept a previous run: {", ".join(gone)}')

    # ---- One frame, one slot, unless it is declared otherwise --------------

    used = {}

    for stem, master, *_ in SLOTS:
        used.setdefault(master, []).append(stem)

    for master, stems in sorted(used.items()):
        if len(stems) > 1 and master not in SHARED:
            print(f'\n  COLLISION  {master} is in {len(stems)} slots — '
                  f'{", ".join(stems)}\n'
                  f'             Add it to SHARED with a reason, or re-point one.')

    for master, reason in sorted(SHARED.items()):
        stems = used.get(master, [])
        print(f'\n  shared  {master} in {", ".join(stems)}\n'
              f'          {reason}')


if __name__ == '__main__':
    main()
