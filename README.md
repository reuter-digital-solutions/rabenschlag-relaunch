# Elektrotechnik Rabenschlag – Relaunch 2026

Neue Website für Elektrotechnik Rabenschlag (Korschenbroich): Schaltschrankbau, Automatisierung, MSR-Technik.

- **PHP-Seiten** mit gemeinsamen Bausteinen (`inc/`), eigenem Icon-Set (`inc/icons.php`) und Animationen (`assets/`)
- **Formulare** für Anfragen und Bewerbungen (`api/`) mit gebrandeten HTML-Mails (`inc/mail-template.php`)
- **Demo** als statische Version in `docs/` (GitHub Pages) – Formulare simulieren dort den Versand

## Lokal starten

```bash
php -S localhost:8090 _router.php
```

Mails werden lokal nicht versendet, sondern als `.eml`/`.html` in `_dev-mails/` abgelegt.
Mail-Vorlagen ansehen: `http://localhost:8090/mail-vorschau?v=anfrage` (`anfrage-bestaetigung`, `bewerbung`, `bewerbung-bestaetigung`).

## Demo neu bauen

```bash
./tools/build-demo.sh
```

## Vor dem Go-live

1. `inc/secret.php` anlegen: `<?php return 'langer-zufallswert';`
2. Empfänger in `inc/config.php` (`MAIL['to']`) prüfen
3. Fotos lokal hosten (aktuell Unsplash-CDN) und Datenschutzerklärung aktualisieren
4. Offene Inhalte: Festnetz/Fax, Partnerlogos, Kundennamen, Stellentitel
