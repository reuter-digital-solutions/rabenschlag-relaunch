<?php
/**
 * Kontaktformular → HTML-Mail an den Betrieb + Bestätigung an den Absender.
 */
declare(strict_types=1);

require_once __DIR__ . '/../inc/forms.php';
require_once __DIR__ . '/../inc/mailer.php';

require_post();

$guard = check_guard($_POST);
if ($guard === 'spam') {
    respond(true, 'anfrage'); // Bots bekommen kommentarlos „Erfolg“
}
if ($guard) {
    respond(false, 'anfrage', [], $guard);
}

$d = [
    'name'      => clean_line($_POST['name'] ?? '', 120),
    'firma'     => clean_line($_POST['firma'] ?? '', 160),
    'email'     => clean_line($_POST['email'] ?? '', 200),
    'telefon'   => clean_line($_POST['telefon'] ?? '', 60),
    'nachricht' => clean_text($_POST['nachricht'] ?? '', 5000),
    'bereich'   => clean_line($_POST['bereich'] ?? '', 40),
];

$errors = [];
if (mb_strlen($d['name']) < 2) {
    $errors['name'] = 'Bitte geben Sie Ihren Namen an.';
}
if (!filter_var($d['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Bitte geben Sie eine gültige E-Mail-Adresse an.';
}
if (mb_strlen($d['nachricht']) < 10) {
    $errors['nachricht'] = 'Bitte beschreiben Sie Ihr Anliegen kurz (mind. 10 Zeichen).';
}
if (empty($_POST['datenschutz'])) {
    $errors['datenschutz'] = 'Bitte stimmen Sie der Datenschutzerklärung zu.';
}
if (!isset(FACHBEREICHE[$d['bereich']])) {
    $d['bereich'] = 'sonstiges';
}
if ($errors) {
    respond(false, 'anfrage', $errors, 'Bitte prüfen Sie die markierten Felder.');
}
if (rate_limited()) {
    respond(false, 'anfrage', [], 'Zu viele Anfragen in kurzer Zeit. Bitte versuchen Sie es später erneut oder rufen Sie uns an.');
}

$bereich = FACHBEREICHE[$d['bereich']];

$internal = [
    'preheader'   => $bereich . ' · ' . $d['name'] . ($d['firma'] ? ', ' . $d['firma'] : '') . ' · ' . mb_substr($d['nachricht'], 0, 90),
    'badge'       => 'Neue Anfrage · Website',
    'title'       => 'Anfrage von ' . $d['name'],
    'intro'       => 'Über das Kontaktformular auf elektrotechnik-rabenschlag.de ist eine neue Projektanfrage eingegangen.',
    'chips'       => array_values(array_filter([$bereich, $d['firma']])),
    'rows'        => [
        ['Name', $d['name']],
        ['Firma', $d['firma'] ?: '–'],
        ['E-Mail', '<a href="mailto:' . me($d['email']) . '" style="color:#0A7462">' . me($d['email']) . '</a>', true],
        ['Telefon', $d['telefon'] ? '<a href="tel:' . me(preg_replace('/[^0-9+]/', '', $d['telefon'])) . '" style="color:#0A7462">' . me($d['telefon']) . '</a>' : '–', true],
        ['Fachbereich', $bereich],
    ],
    'message_label' => 'Anliegen',
    'message'     => $d['nachricht'],
    'actions'     => array_values(array_filter([
        ['Direkt antworten', 'mailto:' . $d['email'] . '?subject=' . rawurlencode('Ihre Anfrage: ' . $bereich), true],
        $d['telefon'] ? ['Zurückrufen', 'tel:' . preg_replace('/[^0-9+]/', '', $d['telefon'])] : null,
    ])),
    'note'        => 'Tipp: „Antworten“ in Ihrem Mailprogramm geht direkt an ' . me($d['email']) . '.',
];

$ok = send_mail(MAIL['to'], 'Neue Anfrage (' . $bereich . '): ' . $d['name'] . ($d['firma'] ? ' – ' . $d['firma'] : ''), $internal, $d['email']);

if ($ok && MAIL['send_confirmation']) {
    send_mail($d['email'], 'Ihre Anfrage bei ' . SITE['name'], [
        'preheader'    => 'Vielen Dank – wir haben Ihre Anfrage erhalten und melden uns schnellstmöglich.',
        'badge'        => 'Anfrage erhalten',
        'title'        => 'Vielen Dank, ' . $d['name'] . '.',
        'intro'        => 'Ihre Anfrage zum Thema <strong style="color:#FFFFFF">' . me($bereich) . '</strong> ist bei uns eingegangen. Wir sehen sie uns an und melden uns schnellstmöglich bei Ihnen.',
        'message_label' => 'Ihre Nachricht',
        'message'      => $d['nachricht'],
        'steps'        => [
            ['Sichtung', 'Wir prüfen Ihre Anforderungen und Unterlagen.'],
            ['Rückmeldung', 'Sie erhalten eine erste Einschätzung per E-Mail oder Telefon.'],
            ['Technische Beratung', 'Gemeinsam klären wir alle Details zu Ihrem Projekt.'],
        ],
        'contact_card' => true,
        'note'         => 'Diese E-Mail wurde automatisch versendet, weil über unsere Website eine Anfrage mit Ihrer Adresse gestellt wurde. Falls Sie das nicht waren, können Sie diese Nachricht ignorieren.',
    ], MAIL['to']);
}

$ok ? respond(true, 'anfrage') : respond(false, 'anfrage', [], 'Die Nachricht konnte nicht versendet werden. Bitte rufen Sie uns an oder schreiben Sie direkt eine E-Mail.');
