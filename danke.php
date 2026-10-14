<?php
require __DIR__ . '/inc/layout.php';

$bewerbung = ($_GET['t'] ?? '') === 'bewerbung';
page_start([
    'title'       => ($bewerbung ? 'Bewerbung gesendet' : 'Anfrage gesendet') . ' – Elektrotechnik Rabenschlag',
    'description' => 'Vielen Dank für Ihre Nachricht.',
    'path'        => 'danke',
    'noindex'     => true,
]);
site_header();
?>
<main id="main" class="hero status">
  <?= circuit_bg() ?>
  <div>
    <div class="success-mark" data-reveal="scale"><svg viewBox="0 0 52 52" aria-hidden="true"><circle cx="26" cy="26" r="24"/><path d="M15 27l7 7 15-16"/></svg></div>
    <h1 class="h1" data-split><?= $bewerbung ? 'Bewerbung angekommen.' : 'Vielen Dank!' ?></h1>
    <p class="lead" data-reveal style="--d:3"><?= $bewerbung
        ? 'Danke für Ihr Interesse an ' . e(SITE['name']) . '. Eine Eingangsbestätigung ist per E-Mail unterwegs – wir melden uns zeitnah bei Ihnen.'
        : 'Ihre Anfrage ist bei uns eingegangen. Eine Bestätigung haben wir an Ihre E-Mail-Adresse gesendet. Wir melden uns schnellstmöglich.' ?></p>
    <div class="hero-ctas" data-reveal style="--d:4">
      <?= btn('Zur Startseite', './', 'teal', 'home') ?>
      <a class="btn btn-line mag" href="tel:<?= e(SITE['mobile_tel']) ?>"><?= icon('phone', 18) ?><span class="btn-label"><?= e(SITE['mobile']) ?></span></a>
    </div>
  </div>
</main>
<?php site_footer(); ?>
