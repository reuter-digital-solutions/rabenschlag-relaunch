<?php
require __DIR__ . '/inc/service.php';

service_page([
    'slug'       => 'automatisierung',
    'meta_title' => 'Automatisierung & DDC-Programmierung – Elektrotechnik Rabenschlag',
    'meta_desc'  => 'Automatisierungstechnik für Fabriken, Fördersysteme sowie Lüftungs- und Heizungsanlagen: DDC-Steuerungen, Programmierung und Visualisierung aus Korschenbroich.',
    'title'      => 'Automatisierung',
    'icon'       => 'plc',
    'claim'      => 'Erfolgreiche Automatisierung beginnt bei uns.',
    'intro'      => 'Ohne Automatisierungstechnik geht heute fast nichts mehr. Von Fabriken über Fördersysteme bis hin zu automatisierten Systemen – die Welt wird zunehmend digital. Wir haben unsere Kompetenzen darauf ausgerichtet und sind Ihr Projektpartner für die Automatisierung.',
    'hero_img'   => 'auto_hero',
    'tag'        => ['=A1', 'Automatisierte Fertigung'],
    'offer_eyebrow' => 'Was wir automatisieren',
    'offer_title'   => ['Steuern, programmieren,', 'sichtbar machen.'],
    'offer' => [
        ['plc', 'DDC-Steuerungen', 'Für effizientere Lüftungs- und Heizungsanlagen – abgestimmt auf Ihre Anlage und Ihren Betrieb.'],
        ['code', 'Programmierung & Visualisierung', 'Wir programmieren Ihre Steuerung und machen Prozesse mit klaren Visualisierungen bedienbar.'],
        ['users', 'Automatisierungstechnik', 'Wir unterstützen Sie nicht nur mit unserem Know-how, sondern auch mit unserer leistungsstarken Produktpalette, um gemeinsam mit Ihnen die passende Lösung zu bauen.'],
    ],
    'areas_title' => 'Automatisierung für',
    'areas_text'  => 'Von der Fabrik bis zur Gebäudetechnik.',
    'areas' => [['factory', 'Fabriken'], ['conveyor', 'Fördersysteme'], ['wind', 'Lüftungsanlagen'], ['flame', 'Heizungsanlagen']],
    'gallery_eyebrow' => 'Einblicke',
    'gallery_title'   => 'Anlagen, die laufen',
    'gallery'    => ['auto_2', 'auto_3', 'gal_2', 'hero'],
    'projects_text' => 'Ein Einblick in unsere Arbeit im Bereich der Automatisierung.',
    'projects' => [
        ['Schaltschrankbau für einen unserer Bestandskunden', '[Kunde], Düsseldorf'],
        ['Technische Beratung, Projektierung, Programmierung mit Visualisierung, Schaltschrankbau, Installation und Inbetriebnahme', '[Kunde], Düsseldorf'],
        ['Programmierung, Visualisierung und Schaltschrankbau für die Lüftungsanlage für Produktion und Reinigung eines Zerlegebetriebs', '[Kunde], Düsseldorf'],
    ],
    'cta_title' => 'Jetzt Ihr Projekt anfragen.',
    'cta_text'  => 'Haben Sie Fragen oder möchten Sie ein Projekt besprechen? Wir freuen uns auf Ihre Nachricht.',
]);
