#!/usr/bin/env bash
#
# Build majorimanor.zip — the production release for DirectAdmin shared hosting.
#
#     deploy/build_release.sh [output-dir]
#
# WHAT COMES OUT, AND WHY THE ZIP HAS TWO FOLDERS IN IT RATHER THAN ONE.
# bootstrap.php resolves PRIVATE_PATH as dirname(PUBLIC_PATH) . '/private' —
# the private directory is the SIBLING of the webroot, not a child of it, and
# that is deliberate: config.php holds the mail password and must never sit
# under a directory Apache serves. So the archive expands to
#
#     majorimanor.com/            <- extract HERE, one level ABOVE public_html
#     ├── public_html/            <- the site
#     └── private/                <- config.php + logs/, never web-served
#
# Extracting it INSIDE public_html gives public_html/public_html and a site that
# answers "Configuration missing." on every address.
#
# WHAT THE PRODUCTION CONFIG CHANGES, against the local private/config.php:
#
#     DEV            true  -> false   errors stop printing to the page, and
#                                     /styleguide and /components stop existing
#     SITE_URL       dev.  -> apex    canonical tags, OG urls and the sitemap
#     ENABLE_GAMING  true  -> false   the private gaming block on /after-dark;
#                                     config.example.php calls false the
#                                     production value in as many words
#     ENABLE_VIDEO   true  -> false   the production value; it gates only the
#                                     old hero.php slot, which no public page
#                                     declares, so nothing on the site moves
#                                     that was moving before
#     FORM_SECRET    dev   -> fresh   it signs the forms' time-trap and salts
#                                     the rate limiter; a development value is
#                                     not a production signing key
#
# SMTP_* and MAIL_TO are carried over UNCHANGED from private/config.php, which
# is why this script transforms that file instead of writing a new one: the
# mail password is not retyped, not echoed and not stored anywhere else.
#
# THE SITEMAP IS REBUILT, not copied. The committed one is generated against
# dev.majorimanor.com; shipping it tells crawlers the canonical host is the dev
# host. tools/build_sitemap.php regenerates it from the production SITE_URL.
#
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
OUT_DIR="${1:-$ROOT/deploy}"
STAGE="$(mktemp -d)"
trap 'rm -rf "$STAGE"' EXIT

[ -f "$ROOT/private/config.php" ] || { echo "no private/config.php to build from" >&2; exit 1; }

echo "Staging"
mkdir -p "$STAGE/majorimanor.com"
cp -a "$ROOT/public_html" "$STAGE/majorimanor.com/public_html"
mkdir -p "$STAGE/majorimanor.com/private/logs"
touch "$STAGE/majorimanor.com/private/logs/.gitkeep"
cp -a "$ROOT/private/config.example.php" "$STAGE/majorimanor.com/private/config.example.php"

# --- the production config, derived from the local one ----------------------

SECRET="$(php -r 'echo bin2hex(random_bytes(32));')"

php -r '
$src    = $argv[1];
$dst    = $argv[2];
$secret = $argv[3];
$s = file_get_contents($src);

$rules = [
    ["/^ \* LOCAL DEVELOPMENT COPY.*$/m",            " * PRODUCTION CONFIGURATION — built by deploy/build_release.sh."],
    ["/define\(\x27SITE_URL\x27,\s*\x27[^\x27]*\x27\)/",       "define(\x27SITE_URL\x27, \x27https://majorimanor.com\x27)"],
    ["/define\(\x27DEV\x27,\s*true\)/",                        "define(\x27DEV\x27, false)"],
    ["/define\(\x27ENABLE_GAMING\x27,\s*true\)/",              "define(\x27ENABLE_GAMING\x27, false)"],
    ["/define\(\x27ENABLE_VIDEO\x27,\s*true\)/",               "define(\x27ENABLE_VIDEO\x27, false)"],
    ["/define\(\x27FORM_SECRET\x27,\s*\x27[^\x27]*\x27\)/",    "define(\x27FORM_SECRET\x27, \x27" . $secret . "\x27)"],
];

foreach ($rules as [$pattern, $replacement]) {
    $out = preg_replace($pattern, $replacement, $s, 1, $n);
    if ($out === null) { fwrite(STDERR, "regex failed: $pattern\n"); exit(1); }
    $s = $out;
}

/* Every switched value is asserted rather than assumed: a silent no-op here
   ships a development configuration to a live domain. */
foreach ([
    "define(\x27DEV\x27, false)", "define(\x27SITE_URL\x27, \x27https://majorimanor.com\x27)",
    "define(\x27ENABLE_GAMING\x27, false)", "define(\x27ENABLE_VIDEO\x27, false)",
    "define(\x27FORM_SECRET\x27, \x27" . $secret . "\x27)",
] as $needle) {
    if (!str_contains($s, $needle)) { fwrite(STDERR, "NOT APPLIED: $needle\n"); exit(1); }
}
if (str_contains($s, "dev.majorimanor.com")) { fwrite(STDERR, "dev host survived in config\n"); exit(1); }

file_put_contents($dst, $s);
' "$ROOT/private/config.php" "$STAGE/majorimanor.com/private/config.php" "$SECRET"

echo "  private/config.php written (DEV=false, apex SITE_URL, fresh FORM_SECRET)"

# --- the sitemap, against the production SITE_URL ---------------------------

cp -a "$ROOT/tools" "$STAGE/majorimanor.com/tools"
php "$STAGE/majorimanor.com/tools/build_sitemap.php" >/dev/null
rm -rf "$STAGE/majorimanor.com/tools"

grep -q 'dev\.majorimanor\.com' "$STAGE/majorimanor.com/public_html/sitemap.xml" \
    && { echo "dev host survived in sitemap" >&2; exit 1; }
echo "  sitemap.xml rebuilt on https://majorimanor.com"

# --- the archive ------------------------------------------------------------

mkdir -p "$OUT_DIR"
rm -f "$OUT_DIR/majorimanor.zip"

( cd "$STAGE/majorimanor.com" && zip -q -r -X "$OUT_DIR/majorimanor.zip" public_html private )

echo
echo "Built $OUT_DIR/majorimanor.zip  ($(du -h "$OUT_DIR/majorimanor.zip" | cut -f1))"
