<?php
require __DIR__ . '/inc/service.php';

service_page([
    'slug'       => 'msr-technik',
    'meta_title' => 'MSR-Technik für Heizung, Lüftung & Klima – Elektrotechnik Rabenschlag',
    'meta_desc'  => 'Mess-, Steuer- und Regelungstechnik: DDC-Programmierung, Bus-Systeme und Installation durch eigene Mitarbeiter – für Versorgungssicherheit, Raumklima und effizienten Betrieb.',
    'title'      => 'MSR-Technik',
    'icon'       => 'gauge',
    'claim'      => 'Das Gebäude verstehen.',
    'intro'      => 'Wenn Ihnen Versorgungssicherheit, ein behagliches Raumklima und ein ökonomischer Betrieb wichtig sind. Die Installation der Elektrotechnik zwischen den Feldgeräten und den Schaltschränken übernehmen unsere eigenen Mitarbeiter.',
    'hero_img'   => 'msr_hero',
    'tag'        => ['=M1', 'Heizung · Lüftung · Klima'],
    'offer_eyebrow' => 'Was MSR-Technik leistet',
    'offer_title'   => ['Messen, Steuern, Regeln –', 'das Herz der Gebäudetechnik.'],
    'offer' => [
        ['bus', 'DDC-Programmierung & Bus-Systeme', 'Bus-Systeme reduzieren den Installationsaufwand, beschleunigen die Reaktion von MSR-Systemen und vereinfachen die Integration weiterer Systeme.'],
        ['energy', 'Kernstück des Energiemanagements', 'Die MSR-Technik verbindet die einzelnen technischen Anlagen einer Immobilie und sorgt für einen reibungslosen und effizienten Ablauf.'],
        ['building', 'Intelligente Systemlösungen', 'Wir vernetzen die Gewerke zu einer zukunftsweisenden Systemlösung – je nach Ausstattung und Nutzung mit deutlichen Einsparungen im Energieverbrauch.'],
        ['wrench', 'Installation durch eigene Mitarbeiter', 'Die Verbindung zwischen Feldgeräten in der Anlagentechnik und den Schaltschränken stellen wir selbst her.'],
    ],
    'areas_title' => 'MSR-Technik für',
    'areas_text'  => 'Für Immobilien, Produktion und Anlagen – mit Blick auf Energieeffizienz.',
    'areas' => [['flame', 'Heizung'], ['wind', 'Lüftung'], ['snow', 'Klima'], ['energy', 'Energiemanagement']],
    'gallery_eyebrow' => 'Einblicke',
    'gallery_title'   => 'Technik, die mitdenkt',
    'gallery'    => ['msr_2', 'gal_1', 'firma', 'gal_2'],
    'projects_text' => 'Ein Einblick in unsere Arbeit im Bereich der Mess-, Steuer- und Regelungstechnik.',
    'projects' => [
        ['Schaltschrankbau und MSR-Installation', '[Kunde, Ort]'],
        ['Konzeption, Visualisierung und Programmierung einer Heizungsanlage mit BHKW, Hybridsolar und Eisspeicher. Anbindung an den Pool', '[Kunde, Ort]'],
        ['Programmierung, Visualisierung und Schaltschrankbau für eine Lüftungsanlage in der Produktion', '[Kunde, Ort]'],
    ],
    'cta_title' => 'Jetzt Ihr Projekt anfragen.',
    'cta_text'  => 'Haben Sie Fragen oder möchten Sie ein Projekt besprechen? Wir freuen uns auf Ihre Nachricht.',
]);
