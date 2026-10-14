<?php
/**
 * Schlanker MIME-Mailer: HTML + Text, eingebettetes Logo (CID), Dateianhänge.
 * Transport 'mail' nutzt PHP mail(); 'file' schreibt .eml-Dateien (lokale Entwicklung).
 * Wechsel auf SMTP (z. B. PHPMailer) ist nur in send_mail() nötig.
 */
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/mail-template.php';

function mime_header(string $s): string
{
    return preg_match('/[^\x20-\x7E]/', $s) ? '=?UTF-8?B?' . base64_encode($s) . '?=' : $s;
}

function mime_filename(string $name): string
{
    $de = strtr($name, ['ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'Ä' => 'Ae', 'Ö' => 'Oe', 'Ü' => 'Ue', 'ß' => 'ss']);
    $ascii = preg_replace('/[^A-Za-z0-9._-]+/', '_', $de) ?: 'datei';
    return 'filename="' . $ascii . '"; filename*=UTF-8\'\'' . rawurlencode($name);
}

/**
 * @param array<array{name:string,path:string,type:string}> $attachments
 */
function send_mail(string $to, string $subject, array $tpl, ?string $replyTo = null, array $attachments = []): bool
{
    $html = render_mail($tpl);
    $text = render_mail_text($tpl);
    $mixed = 'mx_' . bin2hex(random_bytes(8));
    $related = 'rl_' . bin2hex(random_bytes(8));
    $alt = 'al_' . bin2hex(random_bytes(8));
    $eol = "\r\n";

    $headers = [
        'From: ' . mime_header(MAIL['from_name']) . ' <' . MAIL['from'] . '>',
        'MIME-Version: 1.0',
        'Content-Type: multipart/mixed; boundary="' . $mixed . '"',
        'X-Mailer: Rabenschlag-Web',
    ];
    if ($replyTo && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
        $headers[] = 'Reply-To: ' . $replyTo;
    }

    $b = '--' . $mixed . $eol
        . 'Content-Type: multipart/related; boundary="' . $related . '"' . $eol . $eol
        . '--' . $related . $eol
        . 'Content-Type: multipart/alternative; boundary="' . $alt . '"' . $eol . $eol
        . '--' . $alt . $eol
        . 'Content-Type: text/plain; charset=UTF-8' . $eol
        . 'Content-Transfer-Encoding: base64' . $eol . $eol
        . chunk_split(base64_encode($text)) . $eol
        . '--' . $alt . $eol
        . 'Content-Type: text/html; charset=UTF-8' . $eol
        . 'Content-Transfer-Encoding: base64' . $eol . $eol
        . chunk_split(base64_encode($html)) . $eol
        . '--' . $alt . '--' . $eol . $eol;

    $logo = dirname(__DIR__) . '/assets/img/logo-mail.png';
    if (is_file($logo)) {
        $b .= '--' . $related . $eol
            . 'Content-Type: image/png; name="logo.png"' . $eol
            . 'Content-Transfer-Encoding: base64' . $eol
            . 'Content-ID: <logo@rabenschlag>' . $eol
            . 'Content-Disposition: inline; filename="logo.png"' . $eol . $eol
            . chunk_split(base64_encode((string) file_get_contents($logo))) . $eol;
    }
    $b .= '--' . $related . '--' . $eol . $eol;

    foreach ($attachments as $a) {
        $b .= '--' . $mixed . $eol
            . 'Content-Type: ' . $a['type'] . '; name="' . preg_replace('/[^A-Za-z0-9._-]+/', '_', $a['name']) . '"' . $eol
            . 'Content-Transfer-Encoding: base64' . $eol
            . 'Content-Disposition: attachment; ' . mime_filename($a['name']) . $eol . $eol
            . chunk_split(base64_encode((string) file_get_contents($a['path']))) . $eol;
    }
    $b .= '--' . $mixed . '--' . $eol;

    $subjectEnc = mime_header($subject);

    if (MAIL['transport'] === 'file') {
        $dir = dirname(__DIR__) . '/_dev-mails';
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
        $name = date('Ymd-His') . '-' . substr(md5($to . $subject . microtime()), 0, 6);
        file_put_contents("$dir/$name.eml", 'To: ' . $to . $eol . 'Subject: ' . $subjectEnc . $eol . 'Date: ' . date('r') . $eol . implode($eol, $headers) . $eol . $eol . $b);
        file_put_contents("$dir/$name.html", str_replace('cid:logo@rabenschlag', '../assets/img/logo-mail.png', $html));
        return true;
    }

    return mail($to, $subjectEnc, $b, implode($eol, $headers), '-f' . MAIL['from']);
}
