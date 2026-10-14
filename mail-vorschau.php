<?php
/**
 * Vorschau der E-Mail-Vorlagen – nur lokal erreichbar.
 * Aufruf: /mail-vorschau?v=anfrage | anfrage-bestaetigung | bewerbung | bewerbung-bestaetigung
 */
declare(strict_types=1);

require __DIR__ . '/inc/mail-template.php';

if (!in_array(PHP_SAPI, ['cli', 'cli-server'], true) && !in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true)) {
    http_response_code(404);
    exit;
}

$msg = "Guten Tag Herr Rabenschlag,\n\nfür unsere neue Lüftungsanlage in Halle 3 suchen wir einen Partner für Schaltschrankbau und DDC-Programmierung inkl. Visualisierung. Schaltpläne können wir gern zusenden.\n\nViele Grüße\nAnna Beispiel";
$logo = 'assets/img/logo-mail.png';
$v = $_GET['v'] ?? 'anfrage';

$tpl = match ($v) {
    'anfrage-bestaetigung' => [
        'preheader' => 'Vielen Dank – wir haben Ihre Anfrage erhalten.', 'badge' => 'Anfrage erhalten', 'title' => 'Vielen Dank, Anna Beispiel.',
        'intro' => 'Ihre Anfrage zum Thema <strong style="color:#FFFFFF">Schaltschrankbau</strong> ist bei uns eingegangen. Wir sehen sie uns an und melden uns schnellstmöglich bei Ihnen.',
        'message_label' => 'Ihre Nachricht', 'message' => $msg,
        'steps' => [['Sichtung', 'Wir prüfen Ihre Anforderungen und Unterlagen.'], ['Rückmeldung', 'Sie erhalten eine erste Einschätzung per E-Mail oder Telefon.'], ['Technische Beratung', 'Gemeinsam klären wir alle Details zu Ihrem Projekt.']],
        'contact_card' => true, 'note' => 'Diese E-Mail wurde automatisch versendet.',
    ],
    'bewerbung' => [
        'preheader' => 'MSR-Techniker/-in · Max Mustermann', 'badge' => 'Neue Bewerbung · Karriere', 'title' => 'Max Mustermann',
        'intro' => 'bewirbt sich über die Karriereseite als <strong style="color:#FFFFFF">MSR-Techniker/-in</strong>.', 'chips' => ['MSR-Techniker/-in', '3 Dokumente'],
        'rows' => [['Name', 'Max Mustermann'], ['Position', 'MSR-Techniker/-in'], ['E-Mail', '<a href="#" style="color:#0A7462">max@example.org</a>', true], ['Telefon', '0170 1234567']],
        'message' => "Hallo,\nich bin Elektrotechnikermeister mit 6 Jahren Erfahrung in DDC und SPS.",
        'attachments' => [['Lebenslauf_Mustermann.pdf', 845000], ['Meisterbrief.pdf', 1320000], ['Zeugnisse.pdf', 2100000]],
        'actions' => [['Antworten', '#', true], ['Anrufen', '#']], 'note' => 'Die Unterlagen hängen dieser E-Mail an.',
    ],
    'bewerbung-bestaetigung' => [
        'preheader' => 'Danke für Ihre Bewerbung', 'badge' => 'Bewerbung eingegangen', 'title' => 'Danke, Max!',
        'intro' => 'Ihre Bewerbung als <strong style="color:#FFFFFF">MSR-Techniker/-in</strong> ist bei uns angekommen. Wir freuen uns über Ihr Interesse und melden uns zeitnah bei Ihnen.',
        'attachments' => [['Lebenslauf_Mustermann.pdf', 845000]],
        'steps' => [['Unterlagen sichten', 'Wir schauen uns Ihre Bewerbung in Ruhe an.'], ['Rückmeldung', 'Sie hören zeitnah von uns – per E-Mail oder Telefon.'], ['Persönliches Gespräch', 'Passt es, lernen wir uns persönlich kennen.']],
        'contact_card' => true, 'note' => 'Diese E-Mail wurde automatisch versendet.',
    ],
    default => [
        'preheader' => 'Schaltschrankbau · Anna Beispiel', 'badge' => 'Neue Anfrage · Website', 'title' => 'Anfrage von Anna Beispiel',
        'intro' => 'Über das Kontaktformular auf elektrotechnik-rabenschlag.de ist eine neue Projektanfrage eingegangen.', 'chips' => ['Schaltschrankbau', 'Beispiel GmbH'],
        'rows' => [['Name', 'Anna Beispiel'], ['Firma', 'Beispiel GmbH'], ['E-Mail', '<a href="#" style="color:#0A7462">anna@beispiel.de</a>', true], ['Telefon', '02161 123456'], ['Fachbereich', 'Schaltschrankbau']],
        'message_label' => 'Anliegen', 'message' => $msg,
        'actions' => [['Direkt antworten', '#', true], ['Zurückrufen', '#']], 'note' => 'Tipp: „Antworten“ geht direkt an anna@beispiel.de.',
    ],
};
$tpl['logo_src'] = $logo;
echo render_mail($tpl);
