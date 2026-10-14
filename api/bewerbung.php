<?php
/**
 * Bewerbungsformular → HTML-Mail mit Anhängen an den Betrieb + Eingangsbestätigung an Bewerber/-in.
 * Dateien werden nicht auf dem Server gespeichert, sondern direkt aus dem Upload-Tempverzeichnis angehängt.
 */
declare(strict_types=1);

require_once __DIR__ . '/../inc/forms.php';
require_once __DIR__ . '/../inc/mailer.php';

require_post();

// Upload größer als post_max_size → $_POST ist leer
if (empty($_POST) && (int) ($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
    respond(false, 'bewerbung', [], 'Die Dateien sind insgesamt zu groß (max. 15 MB).');
}

$guard = check_guard($_POST);
if ($guard === 'spam') {
    respond(true, 'bewerbung');
}
if ($guard) {
    respond(false, 'bewerbung', [], $guard);
}

$d = [
    'vorname'   => clean_line($_POST['vorname'] ?? '', 80),
    'nachname'  => clean_line($_POST['nachname'] ?? '', 80),
    'email'     => clean_line($_POST['email'] ?? '', 200),
    'telefon'   => clean_line($_POST['telefon'] ?? '', 60),
    'position'  => clean_line($_POST['position'] ?? '', 40),
    'nachricht' => clean_text($_POST['nachricht'] ?? '', 5000),
];

$errors = [];
if (mb_strlen($d['vorname']) < 1) {
    $errors['vorname'] = 'Bitte geben Sie Ihren Vornamen an.';
}
if (mb_strlen($d['nachname']) < 1) {
    $errors['nachname'] = 'Bitte geben Sie Ihren Nachnamen an.';
}
if (!filter_var($d['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Bitte geben Sie eine gültige E-Mail-Adresse an.';
}
if (!isset(STELLEN[$d['position']])) {
    $errors['position'] = 'Bitte wählen Sie eine Position aus.';
}
if (empty($_POST['datenschutz'])) {
    $errors['datenschutz'] = 'Bitte stimmen Sie der Datenschutzerklärung zu.';
}

// Dateien prüfen
$allowed = [
    'pdf'  => ['application/pdf'],
    'doc'  => ['application/msword', 'application/octet-stream'],
    'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip', 'application/octet-stream'],
    'jpg'  => ['image/jpeg'], 'jpeg' => ['image/jpeg'], 'png' => ['image/png'],
];
$finfo = new finfo(FILEINFO_MIME_TYPE);

/** @return array{name:string,path:string,type:string,size:int}|string */
$check = function (array $f, bool $cvOnly) use ($allowed, $finfo) {
    if (($f['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_INI_SIZE || ($f['error'] ?? 0) === UPLOAD_ERR_FORM_SIZE) {
        return 'Die Datei „' . $f['name'] . '“ ist zu groß (max. 5 MB).';
    }
    if (($f['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK || !is_uploaded_file($f['tmp_name'])) {
        return 'Die Datei konnte nicht hochgeladen werden.';
    }
    if ($f['size'] > MAIL['max_file']) {
        return 'Die Datei „' . $f['name'] . '“ ist zu groß (max. 5 MB).';
    }
    $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
    $exts = $cvOnly ? ['pdf', 'doc', 'docx'] : array_keys($allowed);
    $mime = (string) $finfo->file($f['tmp_name']);
    if (!in_array($ext, $exts, true) || !in_array($mime, $allowed[$ext], true)) {
        return 'Dateityp von „' . $f['name'] . '“ ist nicht erlaubt.';
    }
    $name = clean_line(basename($f['name']), 120);
    return ['name' => $name, 'path' => $f['tmp_name'], 'type' => $mime, 'size' => (int) $f['size']];
};

$files = [];
$cv = $_FILES['lebenslauf'] ?? null;
if (!$cv || ($cv['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
    $errors['lebenslauf'] = 'Bitte laden Sie Ihren Lebenslauf hoch.';
} else {
    $r = $check($cv, true);
    is_string($r) ? $errors['lebenslauf'] = $r : $files[] = $r;
}

if (!empty($_FILES['dokumente']['name']) && is_array($_FILES['dokumente']['name'])) {
    $docs = $_FILES['dokumente'];
    $n = count($docs['name']);
    if ($n > MAIL['max_docs']) {
        $errors['dokumente'] = 'Bitte maximal ' . MAIL['max_docs'] . ' weitere Dokumente anhängen.';
    } else {
        for ($i = 0; $i < $n; $i++) {
            if (($docs['error'][$i] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
                continue;
            }
            $r = $check(['name' => $docs['name'][$i], 'tmp_name' => $docs['tmp_name'][$i], 'error' => $docs['error'][$i], 'size' => $docs['size'][$i]], false);
            if (is_string($r)) {
                $errors['dokumente'] = $r;
                break;
            }
            $files[] = $r;
        }
    }
}
if (array_sum(array_column($files, 'size')) > MAIL['max_total']) {
    $errors['dokumente'] = 'Alle Dateien zusammen dürfen höchstens 15 MB groß sein.';
}

if ($errors) {
    respond(false, 'bewerbung', $errors, 'Bitte prüfen Sie die markierten Felder.');
}
if (rate_limited()) {
    respond(false, 'bewerbung', [], 'Zu viele Versuche in kurzer Zeit. Bitte versuchen Sie es später erneut.');
}

$stelle = STELLEN[$d['position']]['title'];
$name = $d['vorname'] . ' ' . $d['nachname'];
$fileList = array_map(fn($f) => [$f['name'], $f['size']], $files);

$internal = [
    'preheader' => $stelle . ' · ' . $name . ' · ' . count($files) . ' Anhang/Anhänge',
    'badge'     => 'Neue Bewerbung · Karriere',
    'title'     => $name,
    'intro'     => 'bewirbt sich über die Karriereseite als <strong style="color:#FFFFFF">' . me($stelle) . '</strong>.',
    'chips'     => [$stelle, count($files) . ' ' . (count($files) === 1 ? 'Dokument' : 'Dokumente')],
    'rows'      => [
        ['Name', $name],
        ['Position', $stelle],
        ['E-Mail', '<a href="mailto:' . me($d['email']) . '" style="color:#0A7462">' . me($d['email']) . '</a>', true],
        ['Telefon', $d['telefon'] ? '<a href="tel:' . me(preg_replace('/[^0-9+]/', '', $d['telefon'])) . '" style="color:#0A7462">' . me($d['telefon']) . '</a>' : '–', true],
    ],
    'message_label' => 'Nachricht',
    'message'   => $d['nachricht'],
    'attachments' => $fileList,
    'actions'   => array_values(array_filter([
        ['Antworten', 'mailto:' . $d['email'] . '?subject=' . rawurlencode('Ihre Bewerbung als ' . $stelle), true],
        $d['telefon'] ? ['Anrufen', 'tel:' . preg_replace('/[^0-9+]/', '', $d['telefon'])] : null,
    ])),
    'note'      => 'Die Unterlagen hängen dieser E-Mail an und wurden nicht auf dem Webserver gespeichert. Bitte behandeln Sie sie vertraulich.',
];

$ok = send_mail(MAIL['to'], 'Neue Bewerbung: ' . $name . ' – ' . $stelle, $internal, $d['email'], $files);

if ($ok && MAIL['send_confirmation']) {
    send_mail($d['email'], 'Ihre Bewerbung bei ' . SITE['name'], [
        'preheader'    => 'Danke für Ihre Bewerbung als ' . $stelle . ' – Ihre Unterlagen sind angekommen.',
        'badge'        => 'Bewerbung eingegangen',
        'title'        => 'Danke, ' . $d['vorname'] . '!',
        'intro'        => 'Ihre Bewerbung als <strong style="color:#FFFFFF">' . me($stelle) . '</strong> ist bei uns angekommen. Wir freuen uns über Ihr Interesse und melden uns zeitnah bei Ihnen.',
        'attachments'  => $fileList,
        'steps'        => [
            ['Unterlagen sichten', 'Wir schauen uns Ihre Bewerbung in Ruhe an.'],
            ['Rückmeldung', 'Sie hören zeitnah von uns – per E-Mail oder Telefon.'],
            ['Persönliches Gespräch', 'Passt es, lernen wir uns persönlich kennen.'],
        ],
        'contact_card' => true,
        'note'         => 'Fragen vorab? Rufen Sie einfach an. Diese E-Mail wurde automatisch versendet.',
    ], MAIL['to']);
}

$ok ? respond(true, 'bewerbung') : respond(false, 'bewerbung', [], 'Die Bewerbung konnte nicht versendet werden. Bitte senden Sie Ihre Unterlagen per E-Mail an ' . SITE['email'] . '.');
