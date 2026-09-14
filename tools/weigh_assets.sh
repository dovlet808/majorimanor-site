#!/usr/bin/env bash
#
# What the home page's motion layer weighs, raw and gzipped.
#
# gzip -9 rather than the default, because that is what a server sends: nginx
# gzip_comp_level and Apache's mod_deflate both compress once per request from
# a cache in practice, and -9 is what every static-asset pipeline uses. Brotli
# would be smaller again; gzip is the floor and the honest number to quote.
#
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)/public_html"

gz() { gzip -9 -c "$1" | wc -c | tr -d ' '; }
raw() { wc -c < "$1" | tr -d ' '; }

row() {
    printf '%-38s %10s %10s\n' "$2" "$(raw "$1")" "$(gz "$1")"
}

echo "                                             raw       gzip"
echo "-------------------------------------------------------------"
echo "ADDED — home page only"
row "$ROOT/assets/js/vendor/gsap.min.js"          "  gsap.min.js (3.15.0)"
row "$ROOT/assets/js/vendor/ScrollTrigger.min.js" "  ScrollTrigger.min.js (3.15.0)"
row "$ROOT/assets/js/vendor/lenis.min.js"         "  lenis.min.js (1.3.26)"
row "$ROOT/assets/js/home.js"                     "  home.js"
row "$ROOT/assets/js/home-atmosphere.js"          "  home-atmosphere.js (WebGL)"
echo "-------------------------------------------------------------"

cat "$ROOT/assets/js/vendor/gsap.min.js" \
    "$ROOT/assets/js/vendor/ScrollTrigger.min.js" \
    "$ROOT/assets/js/vendor/lenis.min.js" \
    "$ROOT/assets/js/home.js" \
    "$ROOT/assets/js/home-atmosphere.js" > /tmp/mm-added-js.$$
printf '%-38s %10s %10s\n' "  TOTAL ADDED JS" "$(raw /tmp/mm-added-js.$$)" "$(gz /tmp/mm-added-js.$$)"

cat "$ROOT/assets/js/vendor/gsap.min.js" \
    "$ROOT/assets/js/vendor/ScrollTrigger.min.js" \
    "$ROOT/assets/js/vendor/lenis.min.js" \
    "$ROOT/assets/js/home.js" > /tmp/mm-added-js-mob.$$
printf '%-38s %10s %10s\n' "  TOTAL ADDED JS below 1024px" "$(raw /tmp/mm-added-js-mob.$$)" "$(gz /tmp/mm-added-js-mob.$$)"
rm -f /tmp/mm-added-js.$$ /tmp/mm-added-js-mob.$$

echo
row "$ROOT/assets/css/home.css" "  home.css (home only)"

echo
echo "UNCHANGED — the shared budget"
row "$ROOT/assets/css/main.css" "  main.css   ceiling 40960 gz"
row "$ROOT/assets/js/main.js"   "  main.js"
echo "-------------------------------------------------------------"

MAIN_GZ=$(gz "$ROOT/assets/css/main.css")
if [ "$MAIN_GZ" -le 40960 ]; then
    echo "main.css $MAIN_GZ B gzipped — within the 40 KB ceiling, $((40960 - MAIN_GZ)) B spare."
else
    echo "main.css $MAIN_GZ B gzipped — OVER the 40 KB ceiling."
fi
