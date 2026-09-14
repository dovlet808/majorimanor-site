<?php
/**
 * Sending, over SMTP, with PHPMailer.
 *
 * TWO MAILS PER SUBMISSION (ARCHITECTURE §12.4), whichever form it came from:
 *
 *   notify_<form>     to info@majorimanor.com — every field, plain text, with
 *                     the sender on Reply-To so answering is a reply and not a
 *                     copy-and-paste
 *   autoreply_<form>  to the sender, from no-reply@ — the branded HTML
 *                     wrapper, and two lines inside it
 *
 * NOTHING THAT HAPPENS IN THIS FILE IS ALLOWED TO REACH THE APPLICANT. Every
 * send is wrapped, every failure is written to private/logs/form_errors.log
 * with the server's own words, and the caller is told nothing it could leak.
 * handler.php shows the thank-you either way, which is the requirement: a mail
 * server that is down is not something a person filling in a form can fix, and
 * an SMTP error on the page is a hostname and a stack trace shown to a
 * stranger.
 *
 * The library is vendored as files under app/vendor/PHPMailer — no Composer on
 * this host, and no autoloader (ARCHITECTURE §2).
 */

declare(strict_types=1);

use PHPMailer\PHPMailer\Exception as PHPMailerException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require_once APP_PATH . '/vendor/PHPMailer/Exception.php';
require_once APP_PATH . '/vendor/PHPMailer/PHPMailer.php';
require_once APP_PATH . '/vendor/PHPMailer/SMTP.php';

require_once __DIR__ . '/template.php';
require_once __DIR__ . '/notify_membership.php';
require_once __DIR__ . '/autoreply_membership.php';
require_once __DIR__ . '/notify_enquiry.php';
require_once __DIR__ . '/autoreply_enquiry.php';

/**
 * How long to wait on the mail server, in seconds.
 *
 * THIS NUMBER IS A PAGE LOAD, not a mail setting. The applicant is holding a
 * spinner until both mails have been attempted, so a dead SMTP host must fail
 * fast rather than sit on the default 300 seconds and turn a form into a
 * timeout. Ten is generous for a server in the same data centre.
 */
const MAIL_TIMEOUT = 10;

/**
 * A configured mailer, or null when there is nothing to configure it with.
 *
 * AN UNFINISHED DEPLOYMENT IS DETECTED HERE AND THE SEND IS SKIPPED, because
 * the alternative is PHPMailer spending MAIL_TIMEOUT discovering it while
 * somebody holds a spinner.
 *
 * WHAT COUNTS AS UNFINISHED HAS CHANGED, AND THIS IS WHY. It used to be the
 * host reading "smtp.example.com" — the placeholder config.example.php shipped
 * with. The sample now documents the real value, mail.majorimanor.com, because
 * a sample that names the actual host is a deployment step somebody cannot get
 * wrong, and there is nothing secret about a mail server's name. So the
 * host is no longer the thing that is obviously missing on a fresh copy: the
 * PASSWORD is, and the sample ships it empty for the obvious reason.
 *
 * Hence the two conditions below. No host at all is a config that predates the
 * mail layer; a username with no password beside it is a config.php copied
 * from the sample and not yet filled in. Both are logged in the words of what
 * is actually wrong, so the line in form_errors.log is the fix.
 */
function form_mailer(): ?PHPMailer
{
    $host = defined('SMTP_HOST') ? (string) SMTP_HOST : '';
    $user = defined('SMTP_USER') ? (string) SMTP_USER : '';
    $pass = defined('SMTP_PASS') ? (string) SMTP_PASS : '';

    if ($host === '') {
        form_log('smtp', 'no SMTP host configured — mail skipped');

        return null;
    }

    if ($user !== '' && $pass === '') {
        form_log('smtp', 'SMTP password not set in private/config.php — mail skipped');

        return null;
    }

    $mail = new PHPMailer(true);   // true: throw, so failures are catchable

    $mail->isSMTP();
    $mail->Host    = $host;
    $mail->Port    = defined('SMTP_PORT') ? (int) SMTP_PORT : 587;
    $mail->Timeout = MAIL_TIMEOUT;

    $secure = defined('SMTP_SECURE') ? (string) SMTP_SECURE : '';

    if ($secure === 'ssl') {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;      // implicit TLS, 465
    } elseif ($secure === 'tls') {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // upgrade, 587
    } else {
        $mail->SMTPSecure  = '';
        $mail->SMTPAutoTLS = false;
    }

    if ($user !== '') {
        $mail->SMTPAuth = true;
        $mail->Username = $user;
        $mail->Password = $pass;
    }

    /*
       ONE CONNECTION FOR BOTH MAILS. Without this PHPMailer opens a socket,
       negotiates TLS and authenticates twice for a single submission, and the
       worst case an applicant waits through is two timeouts instead of one.
       form_send_membership() closes it explicitly when both are done.
    */
    $mail->SMTPKeepAlive = true;

    /*
       UTF-8 throughout, and base64 for the body. "Jūrmala" and "Bērziņš" are
       the normal case on this site, and 8-bit bodies are what mangles them at
       the first relay that is not 8BITMIME-clean.
    */
    $mail->CharSet  = PHPMailer::CHARSET_UTF8;
    $mail->Encoding = PHPMailer::ENCODING_BASE64;

    // Errors are wanted in the log in English, whatever the site is running.
    $mail->setLanguage('en');

    // Off in production; SMTP::DEBUG_SERVER while a new mailbox is being wired
    // up. It writes to the PHP error log, never to the page.
    $mail->SMTPDebug   = DEV ? SMTP::DEBUG_OFF : SMTP::DEBUG_OFF;
    $mail->Debugoutput = 'error_log';

    return $mail;
}

/**
 * Send one message on an existing mailer. Never throws.
 *
 * The mailer is reset first: it carries the previous message's recipients,
 * reply-to list and embedded crest, and a second send on a dirty instance is
 * how the applicant ends up copied on the notification.
 *
 * @param  array{to: string, to_name?: string, subject: string, html?: string,
 *               text: string, reply_to?: string, reply_to_name?: string,
 *               embed?: array{path: string, cid: string}} $message
 * @return bool true when SMTP accepted it
 */
function form_send_one(PHPMailer $mail, array $message, string $label): bool
{
    try {
        $mail->clearAllRecipients();
        $mail->clearReplyTos();
        $mail->clearAttachments();

        $mail->setFrom(
            defined('SMTP_FROM') ? (string) SMTP_FROM : (string) SMTP_USER,
            defined('SMTP_FROM_NAME') ? (string) SMTP_FROM_NAME : ''
        );

        $mail->addAddress($message['to'], (string) ($message['to_name'] ?? ''));

        if (!empty($message['reply_to'])) {
            $mail->addReplyTo($message['reply_to'], (string) ($message['reply_to_name'] ?? ''));
        }

        $mail->Subject = $message['subject'];

        if (!empty($message['embed'])) {
            $mail->addEmbeddedImage(
                $message['embed']['path'],
                $message['embed']['cid'],
                'crest.png',
                PHPMailer::ENCODING_BASE64,
                'image/png'
            );
        }

        if (!empty($message['html'])) {
            $mail->isHTML(true);
            $mail->Body    = $message['html'];
            $mail->AltBody = $message['text'];
        } else {
            $mail->isHTML(false);
            $mail->Body = $message['text'];
        }

        $mail->send();

        return true;
    } catch (PHPMailerException $exception) {
        /*
           ErrorInfo rather than the exception message: PHPMailer puts the
           server's own refusal there — "SMTP Error: Could not authenticate",
           the 550, the connection failure — and that is the line worth having
           at three in the morning. It is the mail server talking about itself,
           so nothing an applicant typed goes into the log with it.
        */
        form_log('smtp', $label . ' failed: ' . trim($mail->ErrorInfo));

        return false;
    } catch (Throwable $throwable) {
        // A missing crest file, a bad address constant — anything that is not
        // the mail server. Same treatment: logged, swallowed, invisible.
        form_log('smtp', $label . ' failed: ' . $throwable->getMessage());

        return false;
    }
}

/**
 * Both mails for one submission, of either form.
 *
 * Returns nothing on purpose. handler.php shows the sender the thank-you
 * whatever happened here, so there is no outcome for it to branch on — and a
 * return value would be an invitation to branch on it.
 *
 * @param string                $formType 'membership' | 'enquiry'
 * @param array<string, string> $values   cleaned, validated
 */
function form_send(string $formType, array $values): void
{
    /*
       Named outright rather than built from the type with a variable function
       name. Two lines of match() is the price of being able to grep for who
       sends what, and of an unknown type being an event in the log instead of
       a call to a function that does not exist.
    */
    $build = match ($formType) {
        'membership' => ['notify' => 'mail_notify_membership', 'autoreply' => 'mail_autoreply_membership'],
        'enquiry'    => ['notify' => 'mail_notify_enquiry',    'autoreply' => 'mail_autoreply_enquiry'],
        default      => null,
    };

    if ($build === null) {
        form_log('smtp', "no mail for form type '{$formType}'");

        return;
    }

    $mail = form_mailer();

    if ($mail === null) {
        return;
    }

    try {
        /*
           THE NOTIFICATION GOES FIRST, and the order is not arbitrary. If the
           connection is going to fail it fails on the first send, and the one
           mail that must not be lost is the one carrying the submission. The
           autoreply is a courtesy; the notification is the enquiry itself.
        */
        form_send_one($mail, $build['notify']($values), 'notify_' . $formType);

        /*
           The address has been through filter_var in form_validate(), so this
           is not the first thing standing between a posted string and an SMTP
           envelope — but a send to an address PHPMailer rejects would raise,
           and the guard keeps that out of the log as a failure when it is
           simply a submission with an address that does not exist.
        */
        if (filter_var($values['email'] ?? '', FILTER_VALIDATE_EMAIL)) {
            form_send_one($mail, $build['autoreply']($values), 'autoreply_' . $formType);
        }
    } finally {
        // The keep-alive socket, closed whatever happened above.
        try {
            $mail->smtpClose();
        } catch (Throwable) {
            // Closing a socket that is already gone is not an event.
        }
    }
}
