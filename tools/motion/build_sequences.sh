#!/usr/bin/env bash
#
# Turn the Main Page's sequences into the loops it actually ships.
#
#     tools/motion/build_sequences.sh <dir-of-source-mp4s>
#
# WHAT THE SOURCES ARE. Five of them are image-to-video generations made with
# Seedance 2.5 (Higgsfield, mode omni_reference, 720p, no audio), each one
# started FROM a photograph already in media_src/ — never from a prompt alone,
# and never from a generated still. docs/MAIN_PAGE.md is the wider account; the
# mapping and the prompts are here.
#
#     02-arrival.mp4  <- media_src/ESTATE_and_HOSPITALITY/reception_concierge.png
#     03-dining.mp4   <- media_src/RESTAURANT/dining_salon2.png
#     04-club.mp4     <- media_src/CIGAR_HOUSE/cigar_lounge.png
#     05-padel.mp4    <- media_src/PRIVATE_CLUB_ECOSYSTEM/1.png
#     06-suite.mp4    <- media_src/ESTATE_and_HOSPITALITY/MAIN_MANOR_SUITE.png
#
# THE HERO IS THE SIXTH AND IT IS NO LONGER ONE OF THEM.
#
#     media_src/MOTION/HERO/main-hero.mp4
#
# It was 01-manor.mp4, a 720p Seedance push-in generated from
# ESTATE_and_HOSPITALITY/SECOND_BUILDING_GUEST_SUITES.png with prompt 01 below,
# and it was replaced on the owner's instruction with a finished 1080p master
# delivered straight into media_src/MOTION/HERO/. Two things follow from that
# and both matter more than they look:
#
#   - IT IS NOT A DESCENDANT OF A media_src PHOTOGRAPH, so the provenance line
#     the other five carry cannot be written for it. Prompt 01 is kept below
#     because it is the record of what the retired sequence was, NOT a
#     description of what ships now. The master's own prompt is not on record
#     here; if one exists it belongs in this header the moment it is supplied.
#   - IT IS STILL A VISUALISATION, so content/en/home.php still marks the hero
#     source: render. The building in it is the estate as it is becoming, not
#     the 1910 house as photographed — that distinction is the Main Page's one
#     hard rule (§11) and the new master does not change which side it falls on.
#
# It is 1920x1080, 24 fps, 8.08 s, and it arrives WITH AN AAC TRACK. The encode
# below drops it with -an, as it always has: the hero plays muted and unattended
# and an audio stream on it would be bytes nobody can hear.
#
# THE PROMPTS, VERBATIM, because a prompt is the only part of a generated asset
# that cannot be recovered by looking at it. Every one of them is written as a
# PRESERVATION instruction rather than a description: it names the architecture,
# the furniture and the materials of that specific photograph, lists the motion
# that is allowed, and then says what may not appear. The negative half is the
# half that does the work.
#
# 01  RETIRED WITH THE SEQUENCE IT MADE — see the note on the hero above. Kept
#      because deleting the prompt of a retired asset loses the only part of it
#      that cannot be recovered by looking at the file.
#
#     "Extremely slow cinematic push-in toward this exact stone manor house at
#      blue hour. Preserve the building's architecture, stonework, portico
#      columns, pediment, window layout, roof line, chimneys and cobblestone
#      forecourt exactly as photographed; change nothing about the design. The
#      only motion: a very gradual dolly forward over the cobbles, gentle
#      parallax on the foreground foliage at the left and right edges as leaves
#      stir in a faint breeze, warm interior lamplight breathing almost
#      imperceptibly behind the windows, a slow drift of thin cloud in the deep
#      blue sky, subtle glisten on the wet cobblestones. No people. No new
#      windows, doors, furniture, vehicles or architectural elements. No camera
#      shake, no zoom snap, no lens flare. Restrained luxury hospitality
#      cinematography, anamorphic depth, natural night-exterior colour, one
#      continuous locked-off shot, no cuts."
#
# 02  "Slow controlled dolly forward through this exact manor reception hall.
#      Preserve every detail of the room: the dark carved wood panelling, the
#      concierge desk, the circular MAJORI MANOR crest and lettering on the back
#      wall exactly as it appears with no change to the logo, the brass desk
#      lamp, the flower arrangement, the chequered marble floor. The concierge
#      behind the desk moves only naturally and slightly, a small shift of the
#      shoulders, a hand moving on the desk. The only other motion: warm
#      practical light breathing gently, subtle depth opening between the
#      foreground desk and the background panelling, polished wood and marble
#      catching soft realistic highlights. No new people entering frame. No
#      redesign of the room, no new doors or furniture. Restrained luxury hotel
#      atmosphere, one continuous shot, no cuts."
#
# 03  "Slow continuous dolly forward through this exact manor dining salon.
#      Preserve the room precisely: the crystal chandelier, the carved wood
#      panelling, the oil portraits in gilt frames, the stone chimneypiece, the
#      round tables with white linen, the crystal glassware, the herringbone
#      parquet. The only motion: candle flames flickering naturally on the
#      tables, the chandelier's light breathing softly, warm reflections
#      travelling slowly across polished wood and glass, an almost imperceptible
#      forward drift of the camera with gentle parallax between the foreground
#      table and the far wall. No people. No new tables, furniture, doors or
#      windows. No redesign of the interior. Refined European manor atmosphere,
#      restrained movement, realistic luxury hospitality cinematography, one
#      continuous shot, no cuts."
#
# 04  "Very slow cinematic camera movement through this exact private cigar and
#      whisky lounge. Preserve the room exactly: the dark timber panelling, the
#      fitted cabinets of framed prints and bottles, the stone fireplace, the
#      buttoned leather chesterfield sofas and armchairs, the low table with
#      glasses, the patterned rug, the small table lamps and wall sconces. The
#      only motion: firelight flickering in the hearth and its warm glow moving
#      realistically across dark wood and leather, lamp light breathing gently,
#      a faint drift of cigar smoke in the air, an extremely gradual forward
#      dolly with subtle parallax. No people. No new furniture, doors, windows
#      or objects. No redesign. Warm amber practical lighting, sophisticated
#      members-club atmosphere, intimate and discreet, realistic materials, one
#      continuous shot, no cuts."
#
# 05  "Slow cinematic lateral tracking movement alongside these exact padel
#      courts at night. Preserve everything as photographed: the glass and black
#      steel court structure, the floodlights, the clipped hedge, the path
#      lights, the low pavilion building with the MAJORI MANOR PADEL CLUB sign
#      kept exactly as it reads, the trees, the deep blue night sky. The only
#      motion: the players inside the courts move naturally and unhurriedly, a
#      rally in progress with no exaggerated action, leaves stirring faintly,
#      court lights reflecting and shifting realistically on the glass walls and
#      the court surface as the camera slides. No new people entering frame, no
#      new buildings, no redesign of the courts or the sign. Elegant landscaped
#      surroundings, premium private-club atmosphere, restrained smooth dolly,
#      one continuous shot, no cuts."
#
# 06  "Very slow cinematic push forward through this exact manor suite. Preserve
#      the room precisely: the upholstered headboard and bed with its layered
#      linen, the bench at the foot of the bed, the bedside tables and lamps,
#      the small chandelier, the panelled walls, the tall window with its
#      curtains, the armchair, the parquet floor and the patterned rug. The only
#      motion: warm bedside lamplight breathing gently, the curtain at the
#      window stirring very slightly, evening light shifting almost
#      imperceptibly beyond the glass, a barely perceptible forward drift of the
#      camera with realistic depth and material detail. No people. No new
#      furniture, doors or windows. No redesign of the room. Quiet private
#      luxury, elegant heritage atmosphere, one continuous shot, no cuts."
#
# THE LOOP IS A PALINDROME AND THAT IS NOT A SHORTCUT.
#
# Every one of the six is a single continuous camera move that never returns to
# where it started, so no frame anywhere in any of them matches its own first
# frame. THE NEW HERO MASTER WAS CHECKED FOR THIS BEFORE IT WAS TREATED LIKE THE
# REST: its first frame is the house wide across the whole forecourt and its
# last is the portico filling the screen, which is as far from a seamless loop
# as the retired sequence was. A hard cut back to frame 0 jumps. A cross-dissolve is worse: dissolving
# a near framing into a far one ghosts the room against itself for the length of
# the blend, and on the dining sequence that means two chandeliers.
#
# So each one plays forward and then backwards — seamless by construction,
# because the last frame of the reverse IS the first frame of the forward, and
# no two framings are ever blended. On a shot this slow the direction change is
# not readable as a change of direction; it reads as the camera settling.
#
# The reverse drops its own first frame (trim=start_frame=1) so the turn does
# not hold one frame twice. The wrap holds frame 0 for one extra 24th of a
# second, which on a shot that moves a few pixels a second is not visible and
# costs nothing to leave.
#
# TWO ENCODES FOR THE HERO, ONE FOR THE REST. The hero is the only sequence a
# reader meets before they have decided to stay, so it gets a narrow encode as
# well: 854 wide at a third of the bytes, chosen against the viewport rather
# than the device. The five section bands are attached one at a time as the
# reader reaches them and released behind, so a second encode of each would be
# five files to save bytes nobody was going to spend.
#
# CRF 29 ON THE HERO IS A MEASURED CHOICE. 27 gives 2.9 MB, 29 gives 2.2 MB and
# 31 gives 1.6 MB; at 100% on the lit windows and the sky — the two places
# H.264 gives up first on a night exterior — 27 and 29 are indistinguishable and
# 31 begins to smear the foliage. 29 is the last rung before the picture pays.
#
# NO WEBM. VP9 at matching quality came out LARGER than H.264 on this material
# (3.17 MB against 2.99 MB at the time it was measured): these are dark, slow,
# grain-free shots, which is the case VP9's advantages do not appear in. A
# second format that is bigger than the first is a second format for nothing.
#
# ffmpeg is not on the host. Either put one on PATH or use the static build that
# comes with imageio-ffmpeg — the script finds either.
#
set -euo pipefail

SRC="${1:?usage: build_sequences.sh <dir-of-source-mp4s>}"
ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
OUT="$ROOT/public_html/assets/video"

FF="$(command -v ffmpeg || true)"
if [ -z "$FF" ]; then
    FF="$(python3 -c 'import imageio_ffmpeg; print(imageio_ffmpeg.get_ffmpeg_exe())' 2>/dev/null || true)"
fi
[ -n "$FF" ] || { echo "no ffmpeg: install one, or pip install imageio-ffmpeg" >&2; exit 1; }

mkdir -p "$OUT"

# forward, then the reverse minus its duplicated first frame
PALINDROME='[0:v]split[a][b];[b]reverse,trim=start_frame=1,setpts=PTS-STARTPTS[r];[a][r]concat=n=2:v=1[c]'

# A source is a bare filename inside <dir-of-source-mp4s>, or a path from the
# project root when the master does not live in that directory. The hero is the
# second case and is the reason this exists: it is delivered into
# media_src/MOTION/HERO/ rather than dropped in the folder of Seedance outputs
# with the other five, and naming it from the root is better than pretending it
# sits somewhere it does not.
resolve () {
    case "$1" in
        */*) printf '%s\n' "$ROOT/$1" ;;
        *)   printf '%s\n' "$SRC/$1"  ;;
    esac
}

# $1 source  $2 output stem  $3 width  $4 crf  $5 maxrate
encode () {
    local src
    src="$(resolve "$1")"
    [ -f "$src" ] || { echo "no such source: $src" >&2; exit 1; }

    "$FF" -nostdin -loglevel error -y -i "$src" \
        -filter_complex "$PALINDROME;[c]scale=$3:-2:flags=lanczos,format=yuv420p[v]" \
        -map '[v]' -an \
        -c:v libx264 -profile:v high -preset slow \
        -crf "$4" -maxrate "$5" -bufsize "$((${5%k} * 2))k" \
        -g 48 -movflags +faststart \
        "$OUT/$2.mp4"

    printf '  %-18s %s\n' "$2.mp4" "$(du -h "$OUT/$2.mp4" | cut -f1)"
}

echo 'Sequences'
encode media_src/MOTION/HERO/main-hero.mp4 hero-manor    1280 29 1500k
encode media_src/MOTION/HERO/main-hero.mp4 hero-manor-sm  854 29 1000k
encode 02-arrival.mp4 seq-arrival    1152 27 1700k
encode 03-dining.mp4  seq-dining     1152 27 1700k
encode 04-club.mp4    seq-club       1152 27 1700k
encode 05-padel.mp4   seq-padel      1280 27 1700k
encode 06-suite.mp4   seq-suite      1152 27 1700k

echo
echo 'Posters — rebuild them, because every one is its own sequence frame 0.'
echo '  rm -rf media_src/MOTION/posters && python3 tools/photos/build_home_media.py'
