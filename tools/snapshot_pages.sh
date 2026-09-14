#!/usr/bin/env bash
#
# Render every route to a directory, one file per page.
#
#     tools/snapshot_pages.sh before
#     …make the change…
#     tools/snapshot_pages.sh after
#     tools/compare_pages.sh before after
#
# The point of it is the ten pages that are not the home page: the home page is
# being rebuilt and is expected to differ, everything else must come out of the
# renderer byte for byte identical.
#
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
OUT="${1:?usage: snapshot_pages.sh <label>}"
DIR="$ROOT/.snapshots/$OUT"

rm -rf "$DIR"
mkdir -p "$DIR"

# page_id:uri — every route in app/routes.php, plus the 404 path.
ROUTES="
home:/
estate:/the-estate
club:/the-club
padel:/padel
events:/events
residences:/residences
after_dark:/after-dark
membership:/membership
contact:/contact
privacy:/privacy
terms:/terms
styleguide:/styleguide
components:/components
notfound:/no-such-address
"

for entry in $ROUTES; do
    id="${entry%%:*}"
    uri="${entry#*:}"
    php "$ROOT/tools/render_route.php" "$uri" > "$DIR/$id.html"
done

echo "snapshot '$OUT' → $DIR"
ls -la "$DIR" | tail -n +2
