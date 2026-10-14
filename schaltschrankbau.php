<?php
require __DIR__ . '/inc/service.php';

service_page([
    'slug'       => 'schaltschrankbau',
    'meta_title' => 'Schaltschrankbau ab Losgröße 1 – Elektrotechnik Rabenschlag, Korschenbroich',
    'meta_desc'  => 'Individuelle Steuerungen, Sonderanfertigungen und Serienaufträge: Schaltschrankbau aus eigener Fertigung in Korschenbroich – von der Planung bis zur Inbetriebnahme.',
    'title'      => 'Schaltschrankbau',
    'icon'       => 'cabinet',
    'claim'      => 'Wirtschaftlich ab Losgröße 1.',
    'intro'      => 'Komplexe Montagezyklen einhalten, Lieferzeiten reduzieren, kundenindividuelle Produkte wirtschaftlich fertigen – darauf haben wir uns eingestellt und begleiten Sie von der Planung bis zur Inbetriebnahme.',
    'hero_img'   => 'ssb_hero',
    'tag'        => ['=S2', 'Montage im eigenen Betrieb'],
    'offer_eyebrow' => 'Was wir fertigen',
    'offer_title'   => ['Einzelstück oder Serie –', 'mit derselben Sorgfalt.'],
    'offer' => [
        ['pen', 'Sonderanfertigung', 'Individuelle Steuerungen exakt nach Ihren Vorgaben. Jedes Gehäuse und jede Grundplatte bearbeiten wir einzeln, damit jedes Element an der gewünschten Position sitzt.'],
        ['racks', 'Montage von Schranksystemen', 'Serienaufträge in Klein- und Großstückzahlen – mit der gleichen Sorgfalt wie bei jedem Einzelstück.'],
        ['users', 'Ihr Projektpartner', 'Planung, Beratung und Entwicklung mit Ihnen an einem Tisch. Bei Bedarf übernehmen wir bestehende Regelungen oder greifen auf Regelungen führender Hersteller zurück.'],
    ],
    'areas_title' => 'Passende Steuerungslösungen für',
    'areas_text'  => 'Komplexe Aufgaben für die Industrie ebenso wie standardisierte Lösungen.',
    'areas' => [['gear', 'Maschinen'], ['conveyor', 'Förderanlagen'], ['sprout', 'Agraranlagen'], ['flame', 'Heizungstechnik'], ['wind', 'Lüftungstechnik'], ['snow', 'Klimatechnik']],
    'gallery_eyebrow' => 'Aus der Werkstatt',
    'gallery_title'   => 'Präzision bis zur letzten Klemme',
    'gallery'    => ['gal_1', 'gal_2', 'bento', 'firma2'],
    'projects_text' => 'Ein Einblick in unsere Arbeit im Schaltschrankbau.',
    'projects' => [
        ['Visualisierung und Programmierung einer Förderstrecke mit Anbindung an einen OPC-Server', '[Kunde, Ort]'],
        ['Beratung, Projektierung, Programmierung, Schaltschrankbau, Installation und Inbetriebnahme – weltweit', '[Kunde, Ort]'],
        ['Programmierung, Visualisierung und Schaltschrankbau für die Lüftungsanlage eines Zerlegebetriebs', '[Kunde, Ort]'],
    ],
    'cta_title' => 'Ihre Aufgabe ist unser Projekt.',
    'cta_text'  => 'Schicken Sie uns Ihre Anforderungen oder Schaltpläne – wir melden uns mit einer Einschätzung.',
]);
