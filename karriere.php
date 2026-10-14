<?php
require __DIR__ . '/inc/layout.php';

page_start([
    'title'       => 'Karriere – Jobs in der Elektrotechnik in Korschenbroich | Elektrotechnik Rabenschlag',
    'description' => 'Offene Stellen als MSR-Techniker/-in, Elektromonteur/-in, Elektroniker/-in und Elektro-Helfer/-in. Vollzeit, unbefristet, ab sofort – mit flexiblen Arbeitszeiten und Tankgutscheinen.',
    'path'        => 'karriere',
    'body'        => 'page-career',
]);
site_header('karriere', ['Jetzt bewerben', '#bewerbung']);
?>
<main id="main">

<section class="hero">
  <?= circuit_bg() ?>
  <div class="hero-inner">
    <div class="hero-grid" style="align-items:end">
      <div class="hero-copy" style="flex:1.3 1 560px">
        <span class="live-chip" data-reveal><span class="live-dot"></span><?= count(STELLEN) ?> offene Stellen · ab sofort</span>
        <h1 class="h1" data-split>Gestalten Sie den digitalen Wandel <span class="grad-text">mit uns.</span></h1>
      </div>
      <p class="lead" style="flex:1 1 360px;max-width:440px;color:var(--on-dark);--d:3" data-reveal>Verstärkung gesucht in MSR-Technik, Elektromontage, Elektronik und Elektro-Hilfsarbeiten. Sondermaschinenbau, Fördertechnik, MSR-Anlagen – bei uns erleben Sie die ganze Vielfalt.</p>
    </div>
    <dl class="stats" data-stagger>
      <div><dt>Arbeitsort</dt><dd style="font-size:22px"><?= e(SITE['city']) ?></dd></div>
      <div><dt>Anstellung</dt><dd style="font-size:22px">Vollzeit, unbefristet</dd></div>
      <div><dt>Start</dt><dd style="font-size:22px">Ab sofort</dd></div>
      <div><dt>Ansprechpartner</dt><dd style="font-size:22px"><?= e(SITE['owner']) ?></dd></div>
    </dl>
  </div>
</section>

<section class="section" style="padding-bottom:0">
  <div class="wrap split">
    <div>
      <?= eyebrow('Offene Positionen') ?>
      <h2 class="h2" style="margin:18px 0 32px" data-split>Finden Sie Ihre Rolle.</h2>
      <div class="positions" data-stagger>
        <?php foreach (STELLEN as $slug => $s): ?>
        <a class="position hov" href="#bewerbung" data-pick="<?= e($slug) ?>">
          <span class="job-main"><span class="tile"><?= icon($s['icon'], 24) ?></span><span><strong><?= e($s['title']) ?></strong><small>Vollzeit · <?= e(SITE['city']) ?></small></span></span>
          <span class="go"><?= icon('arrow-ur', 18) ?></span>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="media photo-slot" data-reveal="clip" style="--d:1">
      <?= img('karriere', '(max-width: 1000px) 100vw, 40vw', '', false) ?>
      <div class="tag"><span class="mono">=K1</span>Inbetriebnahme &amp; Service</div>
    </div>
  </div>
</section>

<section class="section" style="padding-bottom:0">
  <div class="wrap">
    <p class="lead" style="max-width:760px;margin-bottom:40px" data-reveal>Bei uns können Sie die Vielfalt der MSR-Technik ausleben. Wenn Sie es lieben, Maschinen zum Tanzen zu bringen und schöne Visualisierungen zu gestalten, sollten wir uns kennenlernen.</p>
    <div class="lists">
      <div class="list-card" data-reveal>
        <span class="mono muted">01</span>
        <h3>Ihre Aufgaben</h3>
        <ul>
          <?php foreach (['Automatisierungstechnik', 'Inbetriebnahmen von Anlagen', 'Service und Wartung', 'Technische Beratung unserer Kunden'] as $t): ?>
          <li><span class="tick"><?= icon('check', 14, 'nd') ?></span><?= e($t) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="list-card" data-reveal style="--d:1">
        <span class="mono muted">02</span>
        <h3>Ihr Profil</h3>
        <ul>
          <?php foreach (['Abgeschlossene Ausbildung als Geselle, Meister oder Techniker in der Elektrotechnik', 'Erfahrung in der SPS-Programmierung', 'Teamfähigkeit und selbstständige Arbeitsweise'] as $t): ?>
          <li><span class="tick"><?= icon('check', 14, 'nd') ?></span><?= e($t) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="list-card dark" data-reveal style="--d:2">
        <span class="mono muted">03</span>
        <h3>Was wir bieten</h3>
        <ul>
          <li><?= icon('clock', 22) ?>Flexible Arbeitszeiten und Work-Life-Balance</li>
          <li><?= icon('users', 22) ?>Ein tolles Team und abwechslungsreiche Projekte</li>
          <li><?= icon('fuel', 22) ?>Attraktive Prämien und monatliche Tankgutscheine</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<section class="section" id="bewerbung">
  <div class="wrap contact">
    <div class="contact-card" style="flex:1 1 340px" data-reveal>
      <span class="eyebrow eyebrow-ink"><span class="eyebrow-dot"></span>Online-Bewerbung</span>
      <h2 class="h2">In drei Minuten beworben.</h2>
      <p style="margin-top:18px;font-size:17px;color:#0F2E28">Ein Lebenslauf reicht für den Anfang. Lieber erst sprechen?</p>
      <a class="person" style="margin-top:auto;padding-top:16px" href="tel:<?= e(SITE['mobile_tel']) ?>">
        <span class="avatar">KR</span>
        <span><small><?= e(SITE['owner']) ?> · Geschäftsführer</small><strong><?= e(SITE['mobile']) ?></strong></span>
        <span class="person-go"><?= icon('phone', 20) ?></span>
      </a>
    </div>

    <form class="form card-form" style="flex:1.6 1 560px;--d:1" action="api/bewerbung.php" method="post" enctype="multipart/form-data" novalidate data-form="bewerbung"<?= defined('DEMO_EXPORT') ? ' data-demo' : '' ?> data-reveal>
      <?= form_guard() ?>
      <div class="field"><label for="b-vorname">Vorname *</label><input class="fld" id="b-vorname" name="vorname" type="text" autocomplete="given-name" required maxlength="80"><span class="err" aria-live="polite"></span></div>
      <div class="field"><label for="b-nachname">Nachname *</label><input class="fld" id="b-nachname" name="nachname" type="text" autocomplete="family-name" required maxlength="80"><span class="err" aria-live="polite"></span></div>
      <div class="field"><label for="b-email">E-Mail-Adresse *</label><input class="fld" id="b-email" name="email" type="email" autocomplete="email" required maxlength="200"><span class="err" aria-live="polite"></span></div>
      <div class="field"><label for="b-tel">Telefonnummer</label><input class="fld" id="b-tel" name="telefon" type="tel" autocomplete="tel" maxlength="60"><span class="err"></span></div>
      <div class="field span-2"><label for="b-position">Gewünschte Position *</label>
        <select class="fld" id="b-position" name="position" required>
          <option value="">Bitte auswählen</option>
          <?php foreach (STELLEN as $slug => $s): ?><option value="<?= e($slug) ?>"><?= e($s['title']) ?></option><?php endforeach; ?>
        </select><span class="err" aria-live="polite"></span>
      </div>
      <div class="field span-2"><label for="b-msg">Ihre Nachricht (optional)</label><textarea class="fld" id="b-msg" name="nachricht" rows="4" maxlength="5000"></textarea><span class="err"></span></div>
      <div class="field">
        <label class="drop" for="b-cv">
          <span class="tile tile-sm tile-white"><?= icon('upload', 22) ?></span>
          <span><strong>Lebenslauf *</strong><small>PDF, DOC, DOCX · max. 5 MB</small></span>
          <input id="b-cv" type="file" name="lebenslauf" accept=".pdf,.doc,.docx" required>
        </label>
        <ul class="files"></ul>
        <span class="err" aria-live="polite"></span>
      </div>
      <div class="field">
        <label class="drop" for="b-docs">
          <span class="tile tile-sm tile-white"><?= icon('file', 22) ?></span>
          <span><strong>Weitere Dokumente</strong><small>Zeugnisse, Zertifikate · je max. 5 MB</small></span>
          <input id="b-docs" type="file" name="dokumente[]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" multiple>
        </label>
        <ul class="files"></ul>
        <span class="err" aria-live="polite"></span>
      </div>
      <div class="field span-2">
        <label class="check"><input type="checkbox" name="datenschutz" value="1" required><span class="check-box"><?= icon('check', 14, 'nd') ?></span><span>Ich habe die <a href="datenschutz" target="_blank">Datenschutzerklärung</a> gelesen und stimme der Verarbeitung meiner Daten im Rahmen des Bewerbungsverfahrens zu. *</span></label>
        <span class="err" aria-live="polite"></span>
      </div>
      <div class="span-2 form-foot">
        <button class="btn btn-dark mag" type="submit"><span class="btn-label">Bewerbung absenden</span><span class="btn-dot"><?= icon('arrow-ur', 18) ?></span></button>
        <p class="form-status" role="status" aria-live="polite"></p>
      </div>
      <div class="form-success" hidden>
        <div class="success-mark"><svg viewBox="0 0 52 52" aria-hidden="true"><circle cx="26" cy="26" r="24"/><path d="M15 27l7 7 15-16"/></svg></div>
        <h3 class="h3">Bewerbung angekommen!</h3>
        <p>Vielen Dank für Ihr Interesse. Eine Eingangsbestätigung ist unterwegs – wir melden uns zeitnah bei Ihnen.</p>
      </div>
    </form>
  </div>
</section>

</main>
<?php site_footer(); ?>
