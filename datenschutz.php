<?php
require __DIR__ . '/inc/legal.php';

page_start([
    'title'       => 'Datenschutzerklärung – Elektrotechnik Rabenschlag',
    'description' => 'Informationen zur Verarbeitung personenbezogener Daten auf der Website der Elektrotechnik Rabenschlag.',
    'path'        => 'datenschutz',
]);
site_header();
legal_hero('Datenschutz', 'Datenschutzerklärung');
$text = (string) file_get_contents(__DIR__ . '/inc/datenschutz-text.html');
preg_match_all('/<h2 id="(s\d+)">(.*?)<\/h2>/', $text, $toc, PREG_SET_ORDER);
?>
<main id="main" class="section">
  <div class="legal">
    <div class="legal-body" data-reveal>
      <nav class="toc" aria-label="Inhalt">
        <?php foreach ($toc as [, $id, $label]): ?><a href="#<?= e($id) ?>"><?= $label ?></a><?php endforeach; ?>
      </nav>
      <?= $text ?>
    </div>
  </div>
</main>
<?php site_footer(); ?>
