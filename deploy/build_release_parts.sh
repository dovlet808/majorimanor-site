#!/usr/bin/env bash
#
# Split the production release into parts small enough for the DirectAdmin
# File Manager's upload form.
#
#     deploy/build_release_parts.sh
#
# WHY THIS EXISTS. deploy/build_release.sh produces one archive of about 100 MB,
# which is correct and is what you want over SFTP or SSH. The File Manager
# uploads through PHP, so it is capped by upload_max_filesize and post_max_size
# — commonly 64 M or 100 M on shared hosting — and a 100 MB single file is the
# one part of this deploy most likely to fail halfway.
#
# IT IS DERIVED FROM THE CANONICAL ZIP AND NOT REBUILT BESIDE IT. This script
# runs build_release.sh, expands what it produced, and re-packs the same bytes
# into four archives. There is no second copy of the config transform, no second
# sitemap build and no chance of the parts and the whole disagreeing: the parts
# ARE the whole, cut up.
#
# ALL FOUR EXTRACT TO THE SAME PLACE and in any order. Each one carries the same
# directory prefixes, so the File Manager's extractor merges them into one tree:
#
#     domains/majorimanor.com/          <- extract all four HERE
#     ├── public_html/
#     └── private/
#
# THE FIRST PART IS THE ONE THAT MATTERS. It carries every .php, .css, .js,
# .htaccess and font on the site plus private/config.php — the whole working
# site, about 2 MB. Upload it first: if it extracts to the right place the other
# three are only pictures and film, and a mistake costs a re-upload of one small
# file rather than of a hundred megabytes.
#
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
OUT="$ROOT/deploy/parts"
STAGE="$(mktemp -d)"
trap 'rm -rf "$STAGE"' EXIT

echo "Building the canonical archive first"
"$ROOT/deploy/build_release.sh" >/dev/null

echo "Expanding it"
mkdir -p "$STAGE/tree"
unzip -q "$ROOT/deploy/majorimanor.zip" -d "$STAGE/tree"

rm -rf "$OUT"
mkdir -p "$OUT"

cd "$STAGE/tree"

# 1 — the site itself: everything except the two heavy asset directories.
#     -x excludes them from the recursive walk; private/ comes with it.
zip -q -r -X "$OUT/majorimanor-1-site.zip" public_html private \
    -x 'public_html/assets/img/*' -x 'public_html/assets/video/*'

# 2 and 3 — the pictures, split at roughly half. The split is by page directory
#     rather than by file count, so a part is always a whole page's imagery and
#     a half-finished upload never leaves one page with some of its pictures.
zip -q -r -X "$OUT/majorimanor-2-img-a.zip" \
    public_html/assets/img/home public_html/assets/img/club \
    public_html/assets/img/brand public_html/assets/img/after-dark

#     contact/ rides with estate/ because that is where its two real-building
#     plates are cut from, and because it is under a megabyte: it belongs to
#     whichever half is already carrying the photography of the house.
zip -q -r -X "$OUT/majorimanor-3-img-b.zip" \
    public_html/assets/img/estate public_html/assets/img/residences \
    public_html/assets/img/events public_html/assets/img/padel \
    public_html/assets/img/contact \
    public_html/assets/img/interiors public_html/assets/img/grand-staircase \
    public_html/assets/img/pavilion public_html/assets/img/heritage-details \
    public_html/assets/img/membership public_html/assets/img/privacy \
    public_html/assets/img/terms

#     membership/, privacy/ and terms/ are the three pages added in September.
#     Under four megabytes between them, they ride with the lighter half.
#     A NEW PAGE DIRECTORY MUST BE ADDED HERE OR TO PART 2: the check at the
#     bottom refuses to report success while one is missing, which is how
#     these three were found.

# 4 — the film.
zip -q -r -X "$OUT/majorimanor-4-video.zip" public_html/assets/video

# --- prove the parts add up to the whole ------------------------------------
#
# Not a checksum of the archives — a comparison of what is INSIDE them against
# what is inside the canonical zip. A file that fell between two -x patterns
# would be invisible to any other check.

whole="$(unzip -l "$ROOT/deploy/majorimanor.zip" | awk 'NR>3 && NF>=4 {print $4}' | grep -v '/$' | sort)"
parts="$(for z in "$OUT"/*.zip; do unzip -l "$z" | awk 'NR>3 && NF>=4 {print $4}'; done | grep -v '/$' | sort -u)"

if [ "$whole" != "$parts" ]; then
    echo "PARTS DO NOT ADD UP TO THE WHOLE:" >&2
    diff <(echo "$whole") <(echo "$parts") | head -20 >&2
    exit 1
fi

echo
printf '%-34s %8s\n' 'ARCHIVE' 'SIZE'
printf '%s\n' '-------------------------------------------'
for z in "$OUT"/*.zip; do
    printf '%-34s %8s\n' "$(basename "$z")" "$(du -h "$z" | cut -f1)"
done
printf '%s\n' '-------------------------------------------'
echo "$(echo "$whole" | wc -l) files, identical to deploy/majorimanor.zip"
