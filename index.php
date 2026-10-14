<?php
require __DIR__ . '/inc/layout.php';

page_start([
    'title'       => 'Elektrotechnik Rabenschlag – Schaltschrankbau, Automatisierung & MSR-Technik in Korschenbroich',
    'description' => 'Innungsbetrieb seit 2000: Schaltschrankbau ab Losgröße 1, Automatisierung mit DDC-Programmierung und Visualisierung sowie MSR-Technik für Heizung, Lüftung und Klima – von der Beratung bis zur Inbetriebnahme.',
    'path'        => '',
    'body'        => 'page-home',
]);
site_header();
$years = (int) date('Y') - SITE['founded'];
?>
<main id="main">

<!-- ============ HERO ============ -->
<section class="hero">
  <?= circuit_bg() ?>
  <div class="hero-inner">
    <div class="hero-grid">
      <div class="hero-copy">
        <span class="live-chip" data-reveal><span class="live-dot"></span>Innungsbetrieb in Korschenbroich · seit <?= SITE['founded'] ?></span>
        <h1 class="h1" data-split>Schaltschränke, Steuerungen &amp; MSR&#8209;Technik <span class="grad-text">aus einer Hand.</span></h1>
        <p class="lead" data-reveal style="--d:4">Von der technischen Beratung über Projektierung, Programmierung und Schaltschrankbau bis zur Inbetriebnahme – für Heizung, Lüftung und Klima ebenso wie für Förder- und Produktionsanlagen.</p>
        <div class="hero-ctas" data-reveal style="--d:6">
          <?= btn('Projekt anfragen', '#kontakt') ?>
          <a class="btn btn-line mag" href="tel:<?= e(SITE['mobile_tel']) ?>"><?= icon('phone', 18) ?><span class="btn-label"><?= e(SITE['mobile']) ?></span></a>
        </div>
      </div>

      <div class="hero-media" data-reveal="clip" style="--d:2">
        <video class="hero-video" autoplay muted loop playsinline preload="auto" poster="assets/video/serienfertigung-poster.jpg" aria-label="Video: Verdrahtung eines Schaltschranks in unserer Fertigung">
          <source src="assets/video/serienfertigung.mp4" type="video/mp4">
        </video>
        <span class="scanline" aria-hidden="true"></span>
        <div class="tag"><span class="mono">=S1</span>Serienfertigung im eigenen Betrieb</div>
        <div class="hero-chips">
          <div class="float-chip"><span class="tile tile-sm"><?= icon('box', 20) ?></span><span><strong>Ab Losgröße 1</strong><small>Einzelstück bis Serie</small></span></div>
          <div class="float-chip"><span class="tile tile-sm"><?= icon('power', 20) ?></span><span><strong>Inbetriebnahme</strong><small>aus einer Hand</small></span></div>
        </div>
      </div>
    </div>

    <dl class="stats" data-stagger>
      <div><dt>Erfahrung</dt><dd><span data-count="<?= $years ?>">0</span><small>Jahre</small></dd></div>
      <div><dt>Fachbereiche</dt><dd><span data-count="3">0</span></dd></div>
      <div><dt>Projektschritte aus einer Hand</dt><dd><span data-count="6">0</span></dd></div>
      <div><dt>Betrieb</dt><dd>Innung</dd></div>
    </dl>
  </div>
</section>

<div class="marquee" aria-hidden="true">
  <div class="marquee-track">
    <?php for ($r = 0; $r < 2; $r++): ?>
    <span>Schaltschrankbau <?= icon('bolt', 20) ?> DDC-Programmierung <?= icon('bolt', 20) ?> Visualisierung <?= icon('bolt', 20) ?> Heizung · Lüftung · Klima <?= icon('bolt', 20) ?> Bus-Systeme <?= icon('bolt', 20) ?> Fördertechnik <?= icon('bolt', 20) ?> Inbetriebnahme <?= icon('bolt', 20) ?></span>
    <?php endfor; ?>
  </div>
</div>

<!-- ============ LEISTUNGEN ============ -->
<section class="section" id="leistungen">
  <div class="wrap">
    <div class="sec-head">
      <div>
        <?= eyebrow('Leistungen') ?>
        <h2 class="h2" data-split>Drei Fachbereiche. <span class="muted">Ein Projektpartner.</span></h2>
      </div>
      <p data-reveal style="--d:2">Planung, Fertigung und Programmierung verantworten wir selbst – die drei Bereiche greifen nahtlos ineinander.</p>
    </div>

    <div class="bento">
      <a class="card bento-big hov" href="schaltschrankbau" data-reveal="scale">
        <?= img('bento', '(max-width: 1000px) 100vw, 55vw') ?>
        <span class="wash" aria-hidden="true"></span>
        <div class="card-top">
          <span class="tile tile-teal"><?= icon('cabinet', 28) ?></span>
          <span class="go"><?= icon('arrow-r', 20) ?></span>
        </div>
        <div>
          <h3>Schaltschrankbau</h3>
          <p>Individuelle Steuerungen und Serienaufträge. Jedes Gehäuse und jede Grundplatte wird bei uns einzeln bearbeitet – jedes Element sitzt exakt an seiner Position.</p>
          <div class="pills"><span class="pill">Sonderanfertigung</span><span class="pill">Schranksysteme</span><span class="pill">Klein- &amp; Großserie</span></div>
        </div>
      </a>
      <div class="bento-col">
        <a class="card bento-card bento-photo spot hov" href="automatisierung" data-reveal style="--d:1">
          <?= img('auto_hero', '(max-width: 1000px) 100vw, 40vw') ?>
          <span class="wash" aria-hidden="true"></span>
          <div class="card-top">
            <span class="tile"><?= icon('plc', 28) ?></span>
            <span class="go"><?= icon('arrow-r', 18) ?></span>
          </div>
          <h3>Automatisierung</h3>
          <p>DDC-Steuerungen für effizientere Lüftungs- und Heizungsanlagen – mit Programmierung und Visualisierung, für Fabriken und Fördersysteme.</p>
        </a>
        <a class="card bento-card bento-photo spot hov" href="msr-technik" data-reveal style="--d:2">
          <?= img('msr_hero', '(max-width: 1000px) 100vw, 40vw') ?>
          <span class="wash" aria-hidden="true"></span>
          <div class="card-top">
            <span class="tile"><?= icon('gauge', 28) ?></span>
            <span class="go"><?= icon('arrow-r', 18) ?></span>
          </div>
          <h3>MSR-Technik</h3>
          <p>Messen, Steuern, Regeln für Heizung, Lüftung und Klima – mit DDC-Programmierung, Bus-Systemen und Installation durch eigene Mitarbeiter.</p>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ============ ABLAUF ============ -->
<section class="section section-tight" id="ablauf">
  <div class="panel proc-panel">
    <div class="sec-head">
      <div>
        <?= eyebrow('Ablauf') ?>
        <h2 class="h2-sm" style="margin-top:16px" data-split>Vom ersten Gespräch bis zum laufenden Betrieb.</h2>
      </div>
      <p data-reveal style="--d:2">Ein Ansprechpartner für alle Schritte – keine Schnittstellenverluste zwischen Planung, Bau und Programmierung.</p>
    </div>

    <div class="proc" data-proc>
      <div class="proc-line" aria-hidden="true"><span class="proc-fill"><span class="proc-head"></span></span></div>
      <ol class="proc-steps">
        <?php
        $steps = [
            ['chat', 'Technische Beratung', 'Wir klären Anforderungen und Ziele – gemeinsam mit Ihnen an einem Tisch.'],
            ['plan', 'Projektierung', 'Planung von Steuerung und Schaltanlage – auf Wunsch mit bestehenden Regelungen oder Regelungen führender Hersteller.'],
            ['code', 'Programmierung &amp; Visualisierung', 'DDC- und SPS-Programmierung mit Visualisierungen, die Ihre Prozesse bedienbar machen.'],
            ['cabinet', 'Schaltschrankbau', 'Fertigung im eigenen Betrieb – vom Einzelstück ab Losgröße 1 bis zur Serie.'],
            ['wrench', 'Installation', 'Die Verbindung zwischen Feldgeräten und Schaltschränken stellen unsere eigenen Mitarbeiter her.'],
        ];
        foreach ($steps as $k => [$ic, $t, $d]): ?>
        <li class="proc-step" style="--i:<?= $k ?>">
          <span class="proc-tile"><?= icon($ic, 24, 'nd') ?><span class="proc-ping" aria-hidden="true"></span></span>
          <span class="proc-num">0<?= $k + 1 ?></span>
          <h3 class="proc-title"><?= $t ?></h3>
          <p class="proc-text"><?= e(html_entity_decode($d)) ?></p>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <div class="power" data-power>
      <span class="power-light" aria-hidden="true"></span>
      <div class="power-copy">
        <span class="proc-num power-num">06 · Inbetriebnahme</span>
        <h3 class="power-title"><span class="t-off">Bereit zur Inbetriebnahme.</span><span class="t-on">Ihre Anlage läuft.</span></h3>
        <p class="power-text"><span class="t-off">Beraten, geplant, programmiert, gebaut und installiert. Jetzt fehlt nur noch ein Handgriff.</span><span class="t-on">Wir nehmen Ihre Anlage in Betrieb und übergeben sie – vom ersten Gespräch bis zum laufenden Betrieb aus einer Hand.</span></p>
        <ul class="leds" aria-hidden="true">
          <li><span></span>Spannung</li>
          <li><span></span>Steuerung</li>
          <li><span></span>Betrieb</li>
        </ul>
        <div class="power-cta"><?= btn('Projekt starten', '#kontakt') ?></div>
      </div>
      <div class="power-switch">
        <button class="mainswitch" type="button" aria-pressed="false" aria-label="Hauptschalter einschalten">
          <svg viewBox="0 0 200 200" aria-hidden="true">
            <rect class="ms-plate" x="10" y="10" width="180" height="180" rx="22"/>
            <circle class="ms-ring" cx="100" cy="100" r="60"/>
            <text class="ms-lbl ms-0" x="16" y="109">0</text>
            <text class="ms-lbl ms-1" x="94" y="33">I</text>
            <g class="ms-handle">
              <rect x="46" y="85" width="108" height="30" rx="15"/>
              <circle cx="100" cy="100" r="28"/>
              <rect class="ms-grip" x="54" y="95" width="30" height="10" rx="5"/>
            </g>
          </svg>
        </button>
        <span class="power-hint mono"><span class="t-off">Hauptschalter umlegen</span><span class="t-on">Eingeschaltet</span></span>
      </div>
    </div>
  </div>
</section>

<!-- ============ UNTERNEHMEN ============ -->
<section class="section section-tight" id="unternehmen">
  <div class="wrap about">
    <div class="about-media">
      <div class="media media-tall" data-reveal="clip"><?= img('firma', '(max-width: 1000px) 50vw, 25vw') ?></div>
      <div class="media media-sq" data-reveal="clip" style="--d:1"><?= img('firma2', '(max-width: 1000px) 50vw, 25vw') ?></div>
      <div class="innung" data-reveal style="--d:2">
        <span class="tile tile-glass"><?= icon('award', 24) ?></span>
        <span><strong>Innungsbetrieb</strong><small>Fachrichtung Elektrotechnik</small></span>
      </div>
    </div>
    <div class="about-copy">
      <?= eyebrow('Unternehmen') ?>
      <h2 class="h2" data-split>Aus Leidenschaft für Technik.</h2>
      <p class="lead" data-reveal style="--d:2">Seit unserer Gründung im Jahr <?= SITE['founded'] ?> haben wir uns stetig weiterentwickelt. Angefangen mit MSR-Technik und Schaltanlagenbau, sind wir heute etablierter Partner der Automatisierungstechnik – mit dem Anspruch, unseren Kunden zukunftssichere Technologie zu bieten.</p>
      <div class="facts" data-stagger>
        <div class="fact"><small>Inhaber</small><strong><?= e(SITE['owner']) ?></strong></div>
        <div class="fact"><small>Schwerpunkt</small><strong>MSR-Technik</strong></div>
        <div class="fact"><small>Standort</small><strong><?= e(SITE['city']) ?></strong></div>
        <div class="fact"><small>Fertigung</small><strong>Einzelstück bis Serie</strong></div>
      </div>
    </div>
  </div>
</section>

<!-- ============ PROJEKTE ============ -->
<section class="section band" id="projekte">
  <div class="wrap">
    <div class="sec-head">
      <div>
        <?= eyebrow('Projekte') ?>
        <h2 class="h2" data-split>Ausgewählte Projekte</h2>
      </div>
      <p data-reveal style="--d:2">Ein Einblick in unsere Arbeit – von der Lüftungsanlage bis zur Förderstrecke.</p>
    </div>
    <div class="projects">
      <?php
      $projects = [
          ['Automatisierung', 'plc', 'Lüftungsanlage für Produktion und Reinigung eines Zerlegebetriebs', 'Programmierung · Visualisierung · Schaltschrankbau', '[Kunde], Düsseldorf'],
          ['MSR-Technik', 'gauge', 'Heizungsanlage mit BHKW, Hybridsolar und Eisspeicher, Anbindung an den Pool', 'Konzeption · Visualisierung · Programmierung', '[Kunde, Ort]'],
          ['Schaltschrankbau', 'cabinet', 'Förderstrecke mit Anbindung an einen OPC-Server', 'Visualisierung · Programmierung', '[Kunde, Ort]'],
          ['Komplettprojekt', 'power', 'Von der Beratung bis zur Inbetriebnahme', 'Beratung · Projektierung · Programmierung · Schaltschrankbau · Installation', '[Kunde], Düsseldorf'],
      ];
      foreach ($projects as $k => [$cat, $ic, $title, $scope, $client]): ?>
      <article class="card project spot<?= $k === 3 ? ' project-dark' : '' ?>" data-reveal style="--d:<?= $k ?>">
        <div class="card-top"><span class="cat"><?= icon($ic, 16) ?><?= e($cat) ?></span><span class="pnum">P.0<?= $k + 1 ?></span></div>
        <h3><?= e($title) ?></h3>
        <p><?= e($scope) ?></p>
        <span class="client"><?= e($client) ?></span>
      </article>
      <?php endforeach; ?>
    </div>
    <div class="partners">
      <span data-reveal>Partner vertrauen auf unsere Expertise</span>
      <ul class="logos" data-stagger>
        <li><img src="assets/img/partner/siemens.svg" alt="Siemens" width="160" height="25" loading="lazy"></li>
        <li><img src="assets/img/partner/henkel.svg" alt="Henkel" width="58" height="43" loading="lazy" class="logo-h"></li>
        <li><img src="assets/img/partner/gelsenwasser.png" alt="Gelsenwasser" width="170" height="40" loading="lazy"></li>
        <li><img src="assets/img/partner/fkr.png" alt="FKR Krefeld" width="40" height="40" loading="lazy" class="logo-h"></li>
      </ul>
    </div>
  </div>
</section>

<!-- ============ KARRIERE ============ -->
<section class="section" style="padding-bottom:0">
  <div class="career" data-reveal="scale">
    <div class="career-copy">
      <?= eyebrow('Karriere', true) ?>
      <h2 class="h2" data-split>Sie bringen Maschinen gern zum Tanzen?</h2>
      <p data-reveal style="--d:2">Sondermaschinenbau, Fördertechnik, MSR-Anlagen und schöne Visualisierungen – in einem festen Team mit flexiblen Arbeitszeiten.</p>
      <div class="pills" data-reveal style="--d:3"><span class="pill pill-light">Vollzeit, unbefristet</span><span class="pill pill-light">Ab sofort</span><span class="pill pill-light">Tankgutscheine</span></div>
    </div>
    <div class="career-jobs" data-stagger="left">
      <?php foreach (STELLEN as $slug => $s): ?>
      <a class="job hov" href="karriere?stelle=<?= e($slug) ?>#bewerbung">
        <span class="job-main"><span class="tile tile-sm"><?= icon($s['icon'], 22) ?></span><span><strong><?= e($s['title']) ?></strong><small><?= e($s['text']) ?></small></span></span>
        <span class="go"><?= icon('arrow-ur', 18) ?></span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php contact_section(); ?>

</main>
<?php site_footer(); ?>
