<?php
require __DIR__ . '/inc/legal.php';

page_start([
    'title'       => 'Impressum – Elektrotechnik Rabenschlag',
    'description' => 'Impressum der Elektrotechnik Rabenschlag, Schiefbahner Str. 25, 41352 Korschenbroich.',
    'path'        => 'impressum',
]);
site_header();
legal_hero('Impressum', 'Impressum');
?>
<main id="main" class="section">
  <div class="legal">
    <div class="legal-body" data-reveal>
      <h2>Angaben gemäß § 5 DDG</h2>
      <p><strong><?= e(SITE['name']) ?></strong><br>Inhaber: <?= e(SITE['owner']) ?> (Einzelunternehmen)<br><?= e(SITE['street']) ?><br><?= e(SITE['zip'] . ' ' . SITE['city']) ?></p>
      <h3>Kontakt</h3>
      <p>Telefon: <a href="tel:<?= e(SITE['phone_tel']) ?>"><?= e(SITE['phone']) ?></a><br>
      Mobil: <a href="tel:<?= e(SITE['mobile_tel']) ?>"><?= e(SITE['mobile']) ?></a><br>
      Telefax: <?= e(SITE['fax']) ?><br>
      E-Mail: <a href="mailto:<?= e(SITE['email']) ?>"><?= e(SITE['email']) ?></a></p>

      <h2>Verbraucher&shy;streit&shy;beilegung / Universal&shy;schlichtungs&shy;stelle</h2>
      <p>Wir sind nicht bereit oder verpflichtet, an Streitbeilegungsverfahren vor einer Verbraucherschlichtungsstelle teilzunehmen.</p>

      <h2>Haftung für Inhalte</h2>
      <p>Als Diensteanbieter sind wir für eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich. Als Diensteanbieter sind wir jedoch nicht verpflichtet, übermittelte oder gespeicherte fremde Informationen zu überwachen oder nach Umständen zu forschen, die auf eine rechtswidrige Tätigkeit hinweisen.</p>
      <p>Verpflichtungen zur Entfernung oder Sperrung der Nutzung von Informationen nach den allgemeinen Gesetzen bleiben hiervon unberührt. Eine diesbezügliche Haftung ist jedoch erst ab dem Zeitpunkt der Kenntnis einer konkreten Rechtsverletzung möglich. Bei Bekanntwerden von entsprechenden Rechtsverletzungen werden wir diese Inhalte umgehend entfernen.</p>

      <h2>Haftung für Links</h2>
      <p>Unser Angebot enthält Links zu externen Websites Dritter, auf deren Inhalte wir keinen Einfluss haben. Deshalb können wir für diese fremden Inhalte auch keine Gewähr übernehmen. Für die Inhalte der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten verantwortlich. Die verlinkten Seiten wurden zum Zeitpunkt der Verlinkung auf mögliche Rechtsverstöße überprüft. Rechtswidrige Inhalte waren zum Zeitpunkt der Verlinkung nicht erkennbar.</p>
      <p>Eine permanente inhaltliche Kontrolle der verlinkten Seiten ist jedoch ohne konkrete Anhaltspunkte einer Rechtsverletzung nicht zumutbar. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Links umgehend entfernen.</p>

      <h2>Urheberrecht</h2>
      <p>Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen Urheberrecht. Die Vervielfältigung, Bearbeitung, Verbreitung und jede Art der Verwertung außerhalb der Grenzen des Urheberrechtes bedürfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers. Downloads und Kopien dieser Seite sind nur für den privaten, nicht kommerziellen Gebrauch gestattet.</p>
      <p>Soweit die Inhalte auf dieser Seite nicht vom Betreiber erstellt wurden, werden die Urheberrechte Dritter beachtet. Insbesondere werden Inhalte Dritter als solche gekennzeichnet. Sollten Sie trotzdem auf eine Urheberrechtsverletzung aufmerksam werden, bitten wir um einen entsprechenden Hinweis. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Inhalte umgehend entfernen.</p>

      <h2>Bildnachweise</h2>
      <p class="credits">Fotos über <a href="https://unsplash.com" target="_blank" rel="noopener">Unsplash</a> (Unsplash-Lizenz):
      <?php
      $by = [];
      foreach (IMAGES as $i) { $by[$i['by']][] = $i['ref']; }
      $parts = [];
      foreach ($by as $name => $refs) { $parts[] = '<a href="' . e($refs[0]) . '" target="_blank" rel="noopener">' . e($name) . '</a>'; }
      echo implode(', ', $parts);
      ?>. Icons und Illustrationen: eigene Gestaltung.</p>
    </div>
  </div>
</main>
<?php site_footer(); ?>
