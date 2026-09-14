<?php
/**
 * Two counters per address per hour, and the split between them is the point.
 *
 *     5   SUCCESSFUL submissions   what actually reaches the inbox
 *     20  POSTs of any kind        what the server is asked to do
 *
 * ONE NUMBER CANNOT DO BOTH JOBS. The earlier version of this file counted
 * every POST against a single limit of five, and the trade was written down
 * here as acceptable: an applicant who trips five validation errors inside an
 * hour is locked out for the rest of it. It is not acceptable. Five is a
 * plausible afternoon for somebody filling in eleven fields on a phone — a
 * mistyped address, a paste that dropped, a required answer missed twice — and
 * the person it locks out is precisely the one the form exists for. Meanwhile
 * five is a generous allowance for something posting garbage in a loop.
 *
 * So the two questions are asked separately, because they are separate:
 *
 *   How many applications may one address actually send?  Five. Past that it is
 *   not an applicant, it is somebody filling the inbox, and the count is of
 *   submissions that were accepted and mailed — a failed validation costs
 *   nothing against it.
 *
 *   How many times may one address post anything at all?  Twenty. This is the
 *   ceiling on work: every POST is counted before the honeypot, the token and
 *   the validator, because all three cost something and a flood does not have
 *   to be valid to be a flood. Twenty is four times the number of mistakes a
 *   real person makes and a fraction of the number a script makes in a second.
 *
 * A genuine applicant fumbling validation five times therefore still gets
 * through on the sixth attempt; a bot posting rubbish still meets a wall.
 *
 * Both windows are one hour, both are counted per address, and both are stored
 * in the same JSON file in private/logs/rate_limit.json, held under an
 * exclusive lock for the whole read-modify-write. No database, and none needed:
 * the file is a few hundred bytes and it is touched once or twice per POST.
 *
 * THE LOCK IS THE WHOLE POINT, so it is worth saying what it is protecting
 * against. Two requests arriving together both read "4", both decide there is
 * room, and both write "5" — and the counter has lost a submission. Worse, one
 * can be part-way through fwrite() while the other is reading, and what the
 * reader gets is half a JSON document. flock() with LOCK_EX serialises the
 * pair: the second request waits at the open, reads what the first actually
 * wrote, and sees "5".
 *
 * The file is opened 'c+' — create if absent, read/write, DO NOT TRUNCATE. The
 * usual 'w' would empty the file before the lock is taken, which is the same
 * bug with an extra step: a concurrent reader that got in first would find
 * nothing there and start the count again from zero.
 *
 * ADDRESSES ARE STORED HASHED. An IP address is personal data under the GDPR,
 * the site's own privacy notice says what the forms collect, and a rate limiter
 * does not need to know who anybody is — only whether it has seen them before.
 * So the key is HMAC-SHA-256 of the address under FORM_SECRET, truncated to 16
 * hex characters, which is far past the point where a collision matters for
 * counting to twenty. Rotating FORM_SECRET resets every counter, and that is
 * harmless.
 */

declare(strict_types=1);

/** Where the counter lives. private/ is above the web root. */
const RATE_LIMIT_FILE = PRIVATE_PATH . '/logs/rate_limit.json';

/** The window, in seconds. One hour, for both counters. */
const RATE_LIMIT_WINDOW = 3600;

/**
 * The two ceilings, used when private/config.php does not name them.
 *
 * FORM_RATE_LIMIT is the accepted-submission cap and FORM_RATE_LIMIT_POSTS the
 * cap on POSTs of any kind; both are documented in config.example.php. The
 * defaults are here as well so that a config.php written before the split
 * still gets a sane second number rather than no limit at all.
 */
const RATE_LIMIT_SENDS_DEFAULT = 5;
const RATE_LIMIT_POSTS_DEFAULT = 20;

/**
 * A stop on the file's size, in bytes, and it is a backstop rather than a
 * budget. Pruning keeps the document to the addresses seen in the last hour,
 * which is a few hundred bytes on this site; a file past this has been
 * corrupted or written by something else, and starting a fresh one is a better
 * answer than parsing a megabyte on every POST.
 */
const RATE_LIMIT_MAX_BYTES = 262144;

/**
 * The visitor's address, as far as it can be known.
 *
 * REMOTE_ADDR AND NOTHING ELSE. X-Forwarded-For is a request header, which
 * means the sender writes it, which means a limiter that trusted it could be
 * cleared by adding a line to a request. Fozzy's LiteSpeed hands the real
 * address in REMOTE_ADDR; if the site ever moves behind a proxy that does not,
 * this is the one function to change, and it should then trust exactly the
 * proxy's own hop and no further.
 */
function rate_limit_address(): string
{
    $address = (string) ($_SERVER['REMOTE_ADDR'] ?? '');

    return $address !== '' ? $address : 'unknown';
}

/**
 * The storage key for an address: keyed, truncated, and not reversible.
 *
 * hash_hmac rather than a plain hash: an IPv4 address has four billion
 * possibilities, so an unkeyed digest of one is a lookup table away from being
 * the address again.
 */
function rate_limit_key(string $address): string
{
    return substr(hash_hmac('sha256', $address, FORM_SECRET), 0, 16);
}

/** The accepted-submission ceiling. */
function rate_limit_sends_max(): int
{
    $max = defined('FORM_RATE_LIMIT') ? (int) FORM_RATE_LIMIT : 0;

    return $max > 0 ? $max : RATE_LIMIT_SENDS_DEFAULT;
}

/** The ceiling on POSTs of any kind. */
function rate_limit_posts_max(): int
{
    $max = defined('FORM_RATE_LIMIT_POSTS') ? (int) FORM_RATE_LIMIT_POSTS : 0;

    return $max > 0 ? $max : RATE_LIMIT_POSTS_DEFAULT;
}

/**
 * Open the counter, prune it, hand this address's two lists to $mutate, and
 * write back whatever it leaves behind — all inside one exclusive lock.
 *
 * The lock dance is here once rather than in both of the functions below, and
 * that is not only tidiness: two copies of a read-modify-write are two places
 * for the write to be forgotten.
 *
 * @param callable(array{p: int[], s: int[]}): mixed $mutate  takes the entry by
 *        reference; its return value is this function's return value
 * @param mixed $unavailable  what to return when the file cannot be opened or
 *        locked — see the note below on why that is not a refusal
 */
function rate_limit_update(callable $mutate, mixed $unavailable): mixed
{
    $now    = time();
    $cutoff = $now - RATE_LIMIT_WINDOW;
    $key    = rate_limit_key(rate_limit_address());

    $handle = @fopen(RATE_LIMIT_FILE, 'c+');

    /*
       THE COUNTER FAILING IS NOT THE APPLICANT'S PROBLEM.

       An unwritable logs/ directory is a deployment fault. Refusing the
       submission would turn it into a silent outage on the site's one
       conversion path, so the form is allowed through and the fault is logged
       for somebody to fix. The honeypot, the time-trap and the validation are
       all still standing; this is the layer that can be down without the door
       being open.
    */
    if ($handle === false) {
        form_log('rate_limit', 'counter unavailable: ' . RATE_LIMIT_FILE);

        return $unavailable;
    }

    if (!flock($handle, LOCK_EX)) {
        fclose($handle);
        form_log('rate_limit', 'lock failed: ' . RATE_LIMIT_FILE);

        return $unavailable;
    }

    // ---- Read --------------------------------------------------------------

    $size = (int) (fstat($handle)['size'] ?? 0);
    $data = [];

    if ($size > 0 && $size <= RATE_LIMIT_MAX_BYTES) {
        $raw     = (string) fread($handle, $size);
        $decoded = json_decode($raw, true);

        if (is_array($decoded)) {
            $data = $decoded;
        } else {
            // A truncated or hand-edited file. Starting again loses at most an
            // hour of counts, and is better than every POST failing to parse.
            form_log('rate_limit', 'unreadable counter, starting a new one');
        }
    } elseif ($size > RATE_LIMIT_MAX_BYTES) {
        form_log('rate_limit', 'counter over ' . RATE_LIMIT_MAX_BYTES . ' bytes, starting a new one');
    }

    // ---- Prune -------------------------------------------------------------

    /*
       Everything older than the window goes, for every address and not only
       this one. Without it the file is an append-only record of every visitor
       who ever submitted, which is a growing file and, since it is keyed by a
       person, a growing pile of personal data with no reason to exist.

       A bare list is the shape this file had before the counters were split.
       It is read as the POST list and its successes start from zero, so an
       upgrade in place costs one hour of half-counts and nothing else.
    */
    foreach ($data as $storedKey => $entry) {
        $entry = rate_limit_normalise($entry, $cutoff, $now);

        if ($entry['p'] === [] && $entry['s'] === []) {
            unset($data[$storedKey]);
        } else {
            $data[$storedKey] = $entry;
        }
    }

    // ---- Decide ------------------------------------------------------------

    $entry = $data[$key] ?? ['p' => [], 's' => []];

    $result = $mutate($entry);

    if ($entry['p'] === [] && $entry['s'] === []) {
        unset($data[$key]);
    } else {
        $data[$key] = $entry;
    }

    // ---- Write -------------------------------------------------------------

    $json = json_encode($data, JSON_UNESCAPED_SLASHES);

    if ($json !== false) {
        rewind($handle);
        ftruncate($handle, 0);
        fwrite($handle, $json);
        fflush($handle);
    } else {
        form_log('rate_limit', 'json_encode: ' . json_last_error_msg());
    }

    flock($handle, LOCK_UN);
    fclose($handle);

    return $result;
}

/**
 * One stored entry, in the current shape, with everything outside the window
 * dropped.
 *
 * @param  mixed $entry whatever was in the file under this key
 * @return array{p: int[], s: int[]}
 */
function rate_limit_normalise(mixed $entry, int $cutoff, int $now): array
{
    // The pre-split shape: a bare list of POST timestamps.
    if (is_array($entry) && array_is_list($entry)) {
        $entry = ['p' => $entry, 's' => []];
    }

    if (!is_array($entry)) {
        return ['p' => [], 's' => []];
    }

    $clean = ['p' => [], 's' => []];

    foreach (['p', 's'] as $list) {
        foreach ((array) ($entry[$list] ?? []) as $stamp) {
            $stamp = (int) $stamp;

            // A stamp in the future is a clock that moved; it is not evidence
            // of anything, so it is dropped rather than trusted.
            if ($stamp > $cutoff && $stamp <= $now) {
                $clean[$list][] = $stamp;
            }
        }
    }

    return $clean;
}

/**
 * Count this POST, and say whether the submission may go any further.
 *
 * Called once per submission, before the honeypot, the token and the
 * validator — see the order of the checks at the top of handler.php.
 *
 * @return array{allowed: bool, posts: int, sends: int, retry_after: int}
 *         posts        POSTs inside the window, this one included when it was
 *                      allowed
 *         sends        accepted submissions inside the window
 *         retry_after  seconds until the exhausted budget's oldest entry falls
 *                      out of the window, so the reader can be told when to
 *                      come back
 */
function rate_limit_hit(): array
{
    $now       = time();
    $sendsMax  = rate_limit_sends_max();
    $postsMax  = rate_limit_posts_max();

    return rate_limit_update(
        static function (array &$entry) use ($now, $sendsMax, $postsMax): array {
            $posts = count($entry['p']);
            $sends = count($entry['s']);

            $allowed = $posts < $postsMax && $sends < $sendsMax;

            if ($allowed) {
                $entry['p'][] = $now;
                $posts += 1;
            }

            /*
               A refused submission is NOT recorded. If it were, a visitor who
               keeps trying would keep pushing their own window forward and the
               block would never end — an hour after the last attempt that was
               allowed is the promise, not an hour after they stop.

               Which budget ran out decides when they may come back, and the
               two can differ by fifty minutes: somebody who sent five real
               applications at nine o'clock and is refused at ten past waits
               for the nine o'clock one to age out, not for the POST they just
               made.
            */
            $retryAfter = 0;

            if (!$allowed) {
                $full = $sends >= $sendsMax ? $entry['s'] : $entry['p'];

                if ($full !== []) {
                    $retryAfter = max(1, (min($full) + RATE_LIMIT_WINDOW) - $now);
                }
            }

            return [
                'allowed'     => $allowed,
                'posts'       => $posts,
                'sends'       => $sends,
                'retry_after' => $retryAfter,
            ];
        },
        ['allowed' => true, 'posts' => 0, 'sends' => 0, 'retry_after' => 0]
    );
}

/**
 * Record an accepted submission — one that passed every check and was handed
 * to the mailer.
 *
 * THE HONEYPOT DOES NOT COME THROUGH HERE, and that is deliberate. A trapped
 * bot is shown the thank-you and no mail is sent (see handler.php), so nothing
 * reached the inbox and nothing is counted against the budget that protects it.
 * The POST it made is already counted against the other one, which is the
 * budget that was going to stop it anyway.
 *
 * A failure inside the mailer does not un-record it either: the submission was
 * accepted, and whether SMTP was reachable at that second is not something the
 * sender should be able to spend an allowance on.
 */
function rate_limit_sent(): void
{
    $now = time();

    rate_limit_update(
        static function (array &$entry) use ($now): bool {
            $entry['s'][] = $now;

            return true;
        },
        false
    );
}
