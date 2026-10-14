<?php
require __DIR__ . '/inc/layout.php';

http_response_code(isset($_GET['t']) ? 200 : 404);
$back = ($_GET['t'] ?? '') === 'bewerbung' ? 'karriere#bewerbung' : './#kontakt';
page_start([
    'title'       => 'Nachricht nicht gesendet – Elektrotechnik Rabenschlag',
    'description' => 'Beim Versand ist ein Fehler aufgetreten.',
    'path'        => 'fehler',
    'noindex'     => true,
]);
site_header();
?>
<main id="main" class="hero status">
  <?= circuit_bg() ?>
  <div>
    <span class="tile tile-glass" style="width:88px;height:88px;border-radius:26px;--node:var(--volt)" data-reveal="scale"><?= icon(isset($_GET['t']) ? 'alert' : 'spark', 40) ?></span>
    <h1 class="h1" data-split><?= isset($_GET['t']) ? 'Das hat nicht geklappt.' : 'Seite nicht gefunden.' ?></h1>
    <p class="lead" data-reveal style="--d:3"><?= isset($_GET['t'])
        ? 'Ihre Nachricht konnte leider nicht gesendet werden. Bitte prüfen Sie Ihre Angaben und versuchen Sie es erneut – oder schreiben Sie uns direkt an ' . e(SITE['email']) . '.'
        : 'Hier ist leider kein Kontakt. Die Seite wurde verschoben oder existiert nicht mehr.' ?></p>
    <div class="hero-ctas" data-reveal style="--d:4">
      <?= isset($_GET['t']) ? btn('Erneut versuchen', $back) : btn('Zur Startseite', './', 'teal', 'home') ?>
      <a class="btn btn-line mag" href="tel:<?= e(SITE['mobile_tel']) ?>"><?= icon('phone', 18) ?><span class="btn-label"><?= e(SITE['mobile']) ?></span></a>
    </div>
  </div>
</main>
<?php site_footer(); ?>
