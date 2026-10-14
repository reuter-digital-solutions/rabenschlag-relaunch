<?php
/**
 * Zentrale Konfiguration – Firmendaten, Mail-Versand, Bilder.
 * Alles, was sich ändern kann, steht hier und nur hier.
 */
declare(strict_types=1);

const SITE = [
    'name'        => 'Elektrotechnik Rabenschlag',
    'url'         => 'https://www.elektrotechnik-rabenschlag.de',
    'street'      => 'Schiefbahner Str. 25',
    'zip'         => '41352',
    'city'        => 'Korschenbroich',
    'owner'       => 'Kai Rabenschlag',
    'mobile'      => '0171 4457040',
    'mobile_tel'  => '+491714457040',
    // OFFEN: Festnetz/Fax wirken wie Platzhalter – echte Nummern beim Kunden erfragen.
    'phone'       => '+49 2161 999999',
    'phone_tel'   => '+492161999999',
    'fax'         => '+49 2161 999911',
    'email'       => 'rabenschlag-elektrotechnik@t-online.de',
    'hours'       => 'Mo–Do 08–16 Uhr · Fr 08–12 Uhr',
    'founded'     => 2000,
];

define('MAIL', [
    // Empfänger der Formulare (aus bisherigem bewerber.php übernommen – vor Go-live prüfen)
    'to'                => 'webmaster@reuter-solutions.de',
    'from'              => 'noreply@elektrotechnik-rabenschlag.de',
    'from_name'         => 'Website Elektrotechnik Rabenschlag',
    // Bestätigungsmail an Absender/Bewerber senden
    'send_confirmation' => true,
    // 'mail' = PHP mail(), 'file' = .eml in _dev-mails/ schreiben (lokal automatisch)
    'transport'         => PHP_SAPI === 'cli-server' ? 'file' : 'mail',
    // Geheimnis für das Formular-Token: aus inc/secret.php (nicht im Git) oder Umgebungsvariable
    'secret'            => (is_file(__DIR__ . '/secret.php') ? (string) include __DIR__ . '/secret.php' : (getenv('RBS_SECRET') ?: 'bitte-in-inc-secret-php-setzen')),
    'rate_limit'        => 6,      // Sendungen pro Stunde und IP
    'max_file'          => 5 * 1024 * 1024,
    'max_total'         => 15 * 1024 * 1024,
    'max_docs'          => 5,
]);

const FACHBEREICHE = [
    'schaltschrankbau' => 'Schaltschrankbau',
    'automatisierung'  => 'Automatisierung',
    'msr-technik'      => 'MSR-Technik',
    'sonstiges'        => 'Sonstiges',
];

// OFFEN: Stellentitel mit dem Kunden vereinheitlichen (Startseite alt vs. Stellenanzeige alt).
const STELLEN = [
    'msr-techniker'  => ['title' => 'MSR-Techniker/-in',  'icon' => 'gauge',   'text' => 'Messen, Steuern, Regeln – von der DDC-Programmierung bis zur Inbetriebnahme'],
    'elektromonteur' => ['title' => 'Elektromonteur/-in', 'icon' => 'wrench',  'text' => 'Von Fabrikanlagen bis zur Ampelschaltung'],
    'elektroniker'   => ['title' => 'Elektroniker/-in',   'icon' => 'plc',     'text' => 'Gewissenhaftes Arbeiten als Basis für komplexe Automatisierung'],
    'elektro-helfer' => ['title' => 'Elektro-Helfer/-in', 'icon' => 'bolt',    'text' => 'Mit anpacken in Werkstatt und auf Montage'],
];

/**
 * Bilder: frei lizenzierte Fotos (Unsplash-Lizenz, kommerziell nutzbar, keine Namensnennung nötig –
 * wir nennen die Fotografen trotzdem im Impressum).
 * Für den Live-Betrieb empfohlen: Dateien lokal ablegen und 'local' setzen (DSGVO, kein Drittanbieter-Abruf).
 */
const IMAGES = [
    'hero'        => ['src' => 'https://images.unsplash.com/photo-1652715564391-38cc4475b7f5', 'alt' => 'Verdrahteter Steuerschrank mit Reihenklemmen und Steuerungsmodulen', 'by' => 'Bruno Guerrero', 'ref' => 'https://unsplash.com/photos/hP0yzStvp-M', 'pos' => 'center 40%'],
    'bento'       => ['src' => 'https://images.unsplash.com/photo-1780034766295-43db0f2a0fb7', 'alt' => 'Schaltschrank mit Frequenzumrichtern und Verkabelung', 'by' => 'Raymond Sime', 'ref' => 'https://unsplash.com/photos/KDkU44ikiko', 'pos' => 'center 40%'],
    'firma'       => ['src' => 'https://images.unsplash.com/photo-1780034766462-e8af5f2c9e22', 'alt' => 'Offener Schaltschrank mit zahlreichen Bauteilen', 'by' => 'Raymond Sime', 'ref' => 'https://unsplash.com/photos/dtbSMLkwVCI', 'pos' => 'center'],
    'firma2'      => ['src' => 'https://images.unsplash.com/photo-1635335874521-7987db781153', 'alt' => 'Kabelbündel wird in einen Schaltkasten geführt', 'by' => 'mostafa mahmoudi', 'ref' => 'https://unsplash.com/photos/47jO5Y8nsYo', 'pos' => 'center'],
    'ssb_hero'    => ['src' => 'https://images.unsplash.com/photo-1780034766312-73825064806c', 'alt' => 'Offenes Schaltschrankfeld mit Modulen und Verdrahtung', 'by' => 'Raymond Sime', 'ref' => 'https://unsplash.com/photos/NAchd3UmxXo', 'pos' => 'center'],
    'gal_1'       => ['src' => 'https://images.unsplash.com/photo-1576446468729-7674e99608f5', 'alt' => 'Reihe von Leitungsschutzschaltern', 'by' => 'Mark Kats', 'ref' => 'https://unsplash.com/photos/ufo5IiRdqjc', 'pos' => 'center'],
    'gal_2'       => ['src' => 'https://images.unsplash.com/photo-1652715648725-c84d5035e9a2', 'alt' => 'Nahaufnahme eines Bedienfelds mit Kabeln', 'by' => 'Bruno Guerrero', 'ref' => 'https://unsplash.com/photos/4Qj1QaYAQQQ', 'pos' => 'center'],
    'auto_hero'   => ['src' => 'https://images.unsplash.com/photo-1716191299980-a6e8827ba10b', 'alt' => 'Industrieroboter in einer automatisierten Fertigung', 'by' => 'Homa Appliances', 'ref' => 'https://unsplash.com/photos/sz1CHL7Pky0', 'pos' => 'center'],
    'auto_2'      => ['src' => 'https://images.unsplash.com/photo-1717386255767-52643970d483', 'alt' => 'Automatisierte Fertigungslinie in einer Fabrikhalle', 'by' => 'Homa Appliances', 'ref' => 'https://unsplash.com/photos/5hPe-Tr2wog', 'pos' => 'center'],
    'auto_3'      => ['src' => 'https://images.unsplash.com/photo-1717386255773-1e3037c81788', 'alt' => 'Große Produktionsanlage in einer Halle', 'by' => 'Homa Appliances', 'ref' => 'https://unsplash.com/photos/pWUyHVJgLhg', 'pos' => 'center'],
    'msr_hero'    => ['src' => 'https://images.unsplash.com/photo-1698479603408-1a66a6d9e80f', 'alt' => 'Klima- und Lüftungsgeräte einer Gebäudetechnik-Anlage', 'by' => 'Kettenreaktion', 'ref' => 'https://unsplash.com/photos/l_Vn4HlFQVw', 'pos' => 'center'],
    'msr_2'       => ['src' => 'https://images.unsplash.com/photo-1652463370143-62773eb2e054', 'alt' => 'Lüftungskanäle auf einem Gebäudedach', 'by' => 'Jannik', 'ref' => 'https://unsplash.com/photos/VDHYvBgvH8w', 'pos' => 'center'],
    'karriere'    => ['src' => 'https://images.unsplash.com/photo-1758101755915-462eddc23f57', 'alt' => 'Elektriker prüft eine Schalttafel mit dem Multimeter', 'by' => 'Toolmash Expo', 'ref' => 'https://unsplash.com/photos/PkHf7BUWbtk', 'pos' => 'center'],
];
