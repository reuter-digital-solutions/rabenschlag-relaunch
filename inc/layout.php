<?php
/**
 * Layout-Bausteine: <head>, Header, Mobilmenü, Footer, Bild- und Hilfsfunktionen.
 */
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/icons.php';
require_once __DIR__ . '/forms.php';

function e(?string $s): string
{
    return htmlspecialchars((string) $s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Responsives Bild aus IMAGES (Unsplash-CDN mit Formatwahl oder lokale Datei). */
function img(string $key, string $sizes = '100vw', string $class = '', bool $eager = false, string $ratio = ''): string
{
    $i = IMAGES[$key];
    $attrs = ' alt="' . e($i['alt']) . '"'
        . ($class ? ' class="' . e($class) . '"' : '')
        . ' style="object-position:' . e($i['pos'] ?? 'center') . '"'
        . ($eager ? ' fetchpriority="high"' : ' loading="lazy"')
        . ' decoding="async"';

    if (!empty($i['local'])) {
        return '<img src="' . e($i['local']) . '"' . $attrs . '>';
    }

    $crop = $ratio ? '&fit=crop&ar=' . $ratio : '';
    $set = [];
    foreach ([480, 800, 1200, 1600, 2000] as $w) {
        $set[] = $i['src'] . '?auto=format&q=72&w=' . $w . $crop . ' ' . $w . 'w';
    }
    return '<img src="' . e($i['src'] . '?auto=format&q=72&w=1200' . $crop) . '" srcset="' . e(implode(', ', $set)) . '" sizes="' . e($sizes) . '"' . $attrs . '>';
}

/** Primär-Button: Pille mit Kreis und Pfeil. */
function btn(string $label, string $href, string $variant = 'teal', string $iconName = 'arrow-ur', string $extra = ''): string
{
    return '<a class="btn btn-' . $variant . ' mag ' . $extra . '" href="' . e($href) . '"><span class="btn-label">' . e($label) . '</span><span class="btn-dot">' . icon($iconName, 18) . '</span></a>';
}

function eyebrow(string $label, bool $dark = false): string
{
    return '<span class="eyebrow' . ($dark ? ' eyebrow-dark' : '') . '" data-reveal><span class="eyebrow-dot"></span>' . e($label) . '</span>';
}

/** Dekorative Leiterbahnen mit wandernden Stromimpulsen (Hero-Hintergrund). */
function circuit_bg(): string
{
    $traces = [
        'M-20 120 H180 L240 180 H520 L580 120 H900',
        'M-20 260 H120 L170 310 H420 L470 260 H700 L760 320 H1300',
        'M200 -20 V60 L260 120 V420 L320 480 V700',
        'M640 -20 V90 L700 150 H980 L1040 90 H1300',
        'M860 700 V520 L920 460 V330 L980 270 H1300',
        'M-20 520 H260 L320 580 H600 L660 520 H820',
    ];
    $nodes = [[180, 120], [520, 180], [420, 310], [260, 420], [700, 150], [920, 460], [600, 580], [980, 270]];
    $o = '<svg class="circuit" viewBox="0 0 1280 680" preserveAspectRatio="xMidYMid slice" aria-hidden="true">';
    foreach ($traces as $k => $d) {
        $o .= '<path class="trace" d="' . $d . '"/>';
        $o .= '<path class="pulse" pathLength="1" style="--d:' . (5 + $k * 1.3) . 's;--delay:' . ($k * -1.7) . 's" d="' . $d . '"/>';
    }
    foreach ($nodes as $k => [$x, $y]) {
        $o .= '<circle class="node' . ($k % 3 === 0 ? ' node-volt' : '') . '" style="--delay:' . ($k * .45) . 's" cx="' . $x . '" cy="' . $y . '" r="4"/>';
    }
    return $o . '</svg>';
}

const NAV = [
    'leistungen'  => ['label' => 'Leistungen',  'href' => './#leistungen'],
    'ablauf'      => ['label' => 'Ablauf',      'href' => './#ablauf'],
    'unternehmen' => ['label' => 'Unternehmen', 'href' => './#unternehmen'],
    'projekte'    => ['label' => 'Projekte',    'href' => './#projekte'],
    'karriere'    => ['label' => 'Karriere',    'href' => 'karriere'],
];

const SERVICES = [
    'schaltschrankbau' => ['label' => 'Schaltschrankbau', 'icon' => 'cabinet'],
    'automatisierung'  => ['label' => 'Automatisierung',  'icon' => 'plc'],
    'msr-technik'      => ['label' => 'MSR-Technik',      'icon' => 'gauge'],
];

function page_start(array $m): void
{
    $title = $m['title'];
    $desc  = $m['description'];
    $path  = $m['path'] ?? '';
    $url   = SITE['url'] . '/' . $path;
    $ld = [
        '@context' => 'https://schema.org',
        '@type' => 'Electrician',
        'name' => SITE['name'],
        'url' => SITE['url'],
        'email' => SITE['email'],
        'telephone' => SITE['mobile_tel'],
        'foundingDate' => (string) SITE['founded'],
        'founder' => ['@type' => 'Person', 'name' => SITE['owner']],
        'address' => ['@type' => 'PostalAddress', 'streetAddress' => SITE['street'], 'postalCode' => SITE['zip'], 'addressLocality' => SITE['city'], 'addressCountry' => 'DE'],
        'openingHoursSpecification' => [
            ['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday'], 'opens' => '08:00', 'closes' => '16:00'],
            ['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => 'Friday', 'opens' => '08:00', 'closes' => '12:00'],
        ],
        'knowsAbout' => ['Schaltschrankbau', 'Automatisierungstechnik', 'MSR-Technik', 'DDC-Programmierung', 'Heizung, Lüftung, Klima'],
    ];
    ?>
<!doctype html>
<html lang="de" class="no-js">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title) ?></title>
<meta name="description" content="<?= e($desc) ?>">
<link rel="canonical" href="<?= e($url) ?>">
<meta name="theme-color" content="#0E1314">
<meta property="og:type" content="website">
<meta property="og:locale" content="de_DE">
<meta property="og:site_name" content="<?= e(SITE['name']) ?>">
<meta property="og:title" content="<?= e($title) ?>">
<meta property="og:description" content="<?= e($desc) ?>">
<meta property="og:url" content="<?= e($url) ?>">
<meta property="og:image" content="<?= e(IMAGES['hero']['src'] . '?auto=format&w=1200&h=630&fit=crop') ?>">
<?php if (!empty($m['noindex'])): ?><meta name="robots" content="noindex, follow">
<?php endif; ?>
<link rel="icon" href="favicon.ico">
<link rel="preload" href="assets/fonts/Geist-Variable.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preconnect" href="https://images.unsplash.com">
<link rel="stylesheet" href="assets/css/site.css?v=3">
<script>document.documentElement.classList.replace('no-js','js')</script>
<script src="assets/js/site.js?v=2" defer></script>
<script type="application/ld+json"><?= json_encode($ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
</head>
<body class="<?= e($m['body'] ?? '') ?>">
<a class="skip" href="#main">Zum Inhalt springen</a>
<div class="progress" aria-hidden="true"></div>
<?php
}

function site_header(string $active = '', array $cta = ['Projekt anfragen', './#kontakt']): void
{
    ?>
<header class="site-header" id="top">
  <div class="site-header-inner">
    <a class="logo" href="./" aria-label="<?= e(SITE['name']) ?> – Startseite"><img src="assets/img/logo-light.png" width="746" height="137" alt="<?= e(SITE['name']) ?>"></a>
    <nav class="navpill" aria-label="Hauptnavigation">
      <span class="navpill-indicator" aria-hidden="true"></span>
      <?php foreach (NAV as $key => $n): ?>
      <a class="nl<?= $active === $key ? ' on' : '' ?>" href="<?= e($n['href']) ?>"<?= $active === $key ? ' aria-current="page"' : '' ?>><?= e($n['label']) ?></a>
      <?php endforeach; ?>
    </nav>
    <div class="header-actions">
      <?= btn($cta[0], $cta[1], 'teal', 'arrow-ur', 'btn-sm hide-sm') ?>
      <button class="burger" type="button" aria-label="Menü öffnen" aria-expanded="false" aria-controls="mnav"><span></span><span></span></button>
    </div>
  </div>
</header>

<div class="mnav" id="mnav" role="dialog" aria-modal="true" aria-label="Navigation" hidden>
  <div class="mnav-inner">
    <div class="mnav-label mono">Leistungen</div>
    <div class="mnav-tiles">
      <?php $i = 0; foreach (SERVICES as $slug => $s): ?>
      <a class="mnav-tile<?= $active === $slug ? ' on' : '' ?>" href="<?= e($slug) ?>" style="--i:<?= $i++ ?>"><?= icon($s['icon'], 24) ?><span><?= e($s['label']) ?></span></a>
      <?php endforeach; ?>
    </div>
    <ul class="mnav-list">
      <?php $links = ['Ablauf' => './#ablauf', 'Unternehmen' => './#unternehmen', 'Projekte' => './#projekte', 'Karriere' => 'karriere', 'Kontakt' => './#kontakt'];
      $i = 3; foreach ($links as $label => $href): ?>
      <li style="--i:<?= $i++ ?>"><a href="<?= e($href) ?>"><span><?= e($label) ?><?php if ($label === 'Karriere'): ?> <em class="badge"><?= count(STELLEN) ?> Stellen</em><?php endif; ?></span><?= icon('arrow-ur', 20) ?></a></li>
      <?php endforeach; ?>
    </ul>
    <a class="mnav-call" href="tel:<?= e(SITE['mobile_tel']) ?>" style="--i:9">
      <span class="avatar">KR</span>
      <span class="grow"><small><?= e(SITE['owner']) ?> direkt</small><strong><?= e(SITE['mobile']) ?></strong></span>
      <?= icon('phone', 22) ?>
    </a>
    <div class="mnav-hours mono"><?= e(SITE['hours']) ?></div>
  </div>
</div>
<?php
}

function site_footer(): void
{
    $year = date('Y');
    ?>
<footer class="site-footer">
  <div class="wrap footer-grid">
    <div data-reveal>
      <span class="logo logo-footer"><img src="assets/img/logo-light.png" width="746" height="137" alt="<?= e(SITE['name']) ?>" loading="lazy"></span>
      <p class="footer-claim">Steuerungs- und Schaltanlagenbau, Mess-, Steuer- und Regelungstechnik. Innungsbetrieb seit <?= SITE['founded'] ?>.</p>
    </div>
    <nav aria-label="Leistungen" data-reveal style="--d:1">
      <div class="footer-h">Leistungen</div>
      <ul>
        <?php foreach (SERVICES as $slug => $s): ?><li><a href="<?= e($slug) ?>"><?= e($s['label']) ?></a></li><?php endforeach; ?>
      </ul>
    </nav>
    <nav aria-label="Unternehmen" data-reveal style="--d:2">
      <div class="footer-h">Unternehmen</div>
      <ul>
        <li><a href="./#unternehmen">Über uns</a></li>
        <li><a href="./#projekte">Projekte</a></li>
        <li><a href="karriere">Karriere</a></li>
        <li><a href="./#kontakt">Kontakt</a></li>
      </ul>
    </nav>
    <div data-reveal style="--d:3">
      <div class="footer-h">Kontakt</div>
      <address>
        <?= e(SITE['street']) ?><br><?= e(SITE['zip'] . ' ' . SITE['city']) ?><br>
        <a href="tel:<?= e(SITE['phone_tel']) ?>"><?= e(SITE['phone']) ?></a><br>
        <a class="footer-mail" href="mailto:<?= e(SITE['email']) ?>"><?= e(SITE['email']) ?></a>
      </address>
    </div>
  </div>
  <div class="wrap footer-bottom">
    <span class="footer-word" aria-hidden="true" data-reveal><?php foreach (mb_str_split('Rabenschlag') as $k => $ch): ?><span style="--i:<?= $k ?>"><?= e($ch) ?></span><?php endforeach; ?></span>
    <div class="footer-legal">
      <span>© <?= $year ?> <?= e(SITE['name']) ?></span>
      <a href="impressum">Impressum</a>
      <a href="datenschutz">Datenschutz</a>
      <a href="#top" class="totop" aria-label="Nach oben"><?= icon('arrow-ur', 16) ?></a>
    </div>
  </div>
</footer>

<div class="dock" aria-label="Schnellkontakt">
  <a class="dock-call" href="tel:<?= e(SITE['mobile_tel']) ?>"><?= icon('phone', 20) ?>Anrufen</a>
  <a class="dock-mail" href="mailto:<?= e(SITE['email']) ?>"><?= icon('mail', 20) ?>E-Mail</a>
</div>
</body>
</html>
<?php
}

/** Kontaktblock in Teal + Formular (Startseite und Kontaktbereiche). */
function contact_section(string $id = 'kontakt', string $preset = ''): void
{
    ?>
<section class="section" id="<?= e($id) ?>">
  <div class="wrap contact">
    <div class="contact-card" data-reveal>
      <span class="eyebrow eyebrow-ink"><span class="eyebrow-dot"></span>Kontakt</span>
      <h2 class="h2">Sprechen wir über Ihr Projekt.</h2>
      <a class="person" href="tel:<?= e(SITE['mobile_tel']) ?>">
        <span class="avatar">KR</span>
        <span><small><?= e(SITE['owner']) ?> · Geschäftsführer</small><strong><?= e(SITE['mobile']) ?></strong></span>
        <span class="person-go"><?= icon('phone', 20) ?></span>
      </a>
      <ul class="contact-list">
        <li><?= icon('phone', 20) ?><a href="tel:<?= e(SITE['phone_tel']) ?>"><?= e(SITE['phone']) ?></a></li>
        <li><?= icon('mail', 20) ?><a href="mailto:<?= e(SITE['email']) ?>"><?= e(SITE['email']) ?></a></li>
        <li><?= icon('pin', 20) ?><span><?= e(SITE['street'] . ', ' . SITE['zip'] . ' ' . SITE['city']) ?></span></li>
        <li><?= icon('clock', 20) ?><span><?= e(SITE['hours']) ?></span></li>
      </ul>
    </div>

    <form class="form card-form" action="api/anfrage.php" method="post" novalidate data-form="anfrage"<?= defined('DEMO_EXPORT') ? ' data-demo' : '' ?> data-reveal style="--d:1">
      <div class="form-head">
        <h3 class="h3">Anfrage senden</h3>
        <p>Wir melden uns schnellstmöglich bei Ihnen.</p>
      </div>
      <?= form_guard() ?>
      <fieldset class="chips span-2">
        <legend class="sr-only">Fachbereich</legend>
        <?php foreach (FACHBEREICHE as $slug => $label): ?>
        <label class="chip"><input type="radio" name="bereich" value="<?= e($slug) ?>"<?= ($preset ? $preset === $slug : $slug === 'schaltschrankbau') ? ' checked' : '' ?>><span><?= e($label) ?></span></label>
        <?php endforeach; ?>
      </fieldset>
      <div class="field"><label for="a-name">Name *</label><input class="fld" id="a-name" name="name" type="text" autocomplete="name" required maxlength="120"><span class="err" aria-live="polite"></span></div>
      <div class="field"><label for="a-firma">Firma</label><input class="fld" id="a-firma" name="firma" type="text" autocomplete="organization" maxlength="160"><span class="err"></span></div>
      <div class="field"><label for="a-email">E-Mail *</label><input class="fld" id="a-email" name="email" type="email" autocomplete="email" required maxlength="200"><span class="err" aria-live="polite"></span></div>
      <div class="field"><label for="a-tel">Telefon</label><input class="fld" id="a-tel" name="telefon" type="tel" autocomplete="tel" maxlength="60"><span class="err"></span></div>
      <div class="field span-2"><label for="a-msg">Ihr Anliegen *</label><textarea class="fld" id="a-msg" name="nachricht" rows="5" required minlength="10" maxlength="5000"></textarea><span class="err" aria-live="polite"></span></div>
      <div class="field span-2">
        <label class="check"><input type="checkbox" name="datenschutz" value="1" required><span class="check-box"><?= icon('check', 14, 'nd') ?></span><span>Ich habe die <a href="datenschutz" target="_blank">Datenschutzerklärung</a> gelesen und stimme der Verarbeitung meiner Daten zur Bearbeitung der Anfrage zu. *</span></label>
        <span class="err" aria-live="polite"></span>
      </div>
      <div class="span-2 form-foot">
        <button class="btn btn-dark mag" type="submit"><span class="btn-label">Anfrage absenden</span><span class="btn-dot"><?= icon('arrow-ur', 18) ?></span></button>
        <p class="form-status" role="status" aria-live="polite"></p>
      </div>
      <div class="form-success" hidden>
        <div class="success-mark"><svg viewBox="0 0 52 52" aria-hidden="true"><circle cx="26" cy="26" r="24"/><path d="M15 27l7 7 15-16"/></svg></div>
        <h3 class="h3">Vielen Dank!</h3>
        <p>Ihre Anfrage ist bei uns eingegangen. Eine Bestätigung haben wir an Ihre E-Mail-Adresse gesendet.</p>
      </div>
    </form>
  </div>
</section>
<?php
}
