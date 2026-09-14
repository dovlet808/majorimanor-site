#!/usr/bin/env bash
#
# Compare two snapshots and report per page.
#
#     tools/compare_pages.sh before after [page-being-rebuilt]
#
# Exits non-zero if any page other than the one being rebuilt differs. That page
# defaults to 'home', which is what it was when this script was written.
#
# ONE FIELD IS MASKED AND IT IS NOT A CONVENIENCE.
#
# The enquiry and membership forms carry a hidden "form_time": a timestamp with
# an HMAC of it, minted per request by app/forms/validate.php as the time-trap
# that rejects a submission filled in faster than a person can type. It is
# different on every single render by design, so /contact and /membership can
# never be byte-identical to a render taken a second earlier — not after a
# change, and not against themselves.
#
# So the comparison is run twice: raw bytes first, and if that fails, again with
# only that one token masked. A page that passes the second and not the first is
# reported as IDENTICAL(t) — identical but for the token — and anything else is
# still a failure. Nothing else is normalised: no whitespace, no attribute
# order, no cache-busting ?v= query, all of which would hide a real change.
#
set -uo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
A="$ROOT/.snapshots/${1:?usage: compare_pages.sh <before> <after> [page-being-rebuilt]}"
B="$ROOT/.snapshots/${2:?usage: compare_pages.sh <before> <after> [page-being-rebuilt]}"

# THE ONE PAGE THAT IS ALLOWED TO DIFFER, and it is named rather than assumed.
# This script was written while the home page was the one being rebuilt and had
# 'home' written into it; THE ESTATE and then THE CLUB were each rebuilt in turn
# and each had to be excused by hand. It is an argument now, and it still
# defaults to home so every existing invocation means what it always meant.
REBUILT="${3:-home}"

# The token, and only the token.
mask() {
    sed -E 's/(name="form_time" value=")[^"]*"/\1MASKED"/g' "$1"
}

printf '%-14s %-13s %10s %10s  %s\n' PAGE RESULT BEFORE AFTER 'SHA256 (after)'
printf '%s\n' "--------------------------------------------------------------------------------"

fail=0
tokened=0

for f in "$A"/*.html; do
    id="$(basename "$f" .html)"
    g="$B/$id.html"

    if [ ! -f "$g" ]; then
        printf '%-14s %-13s\n' "$id" "MISSING"
        fail=1
        continue
    fi

    sa=$(wc -c < "$f" | tr -d ' ')
    sb=$(wc -c < "$g" | tr -d ' ')
    hb=$(sha256sum "$g" | cut -c1-16)

    if cmp -s "$f" "$g"; then
        result="IDENTICAL"
    elif cmp -s <(mask "$f") <(mask "$g"); then
        result="IDENTICAL(t)"
        tokened=1
    elif [ "$id" = "$REBUILT" ]; then
        result="CHANGED*"
    else
        result="DIFFERS"
        fail=1
    fi

    printf '%-14s %-13s %10s %10s  %s\n' "$id" "$result" "$sa" "$sb" "$hb"
done

printf '%s\n' "--------------------------------------------------------------------------------"

if [ "$fail" -eq 0 ]; then
    echo "PASS — every page except $REBUILT is unchanged."
    [ "$tokened" -eq 1 ] && echo "       (t) = identical but for the per-request form_time token; see the note in this script."
    echo "       (*) = $REBUILT, which is the page being rebuilt."
else
    echo "FAIL — a page that must not change did."
fi

exit "$fail"
