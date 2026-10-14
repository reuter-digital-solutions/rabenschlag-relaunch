<?php
/**
 * Template für Leistungsseiten (Schaltschrankbau, Automatisierung, MSR-Technik).
 * Jede Seite übergibt nur ihre Inhalte als Array.
 */
declare(strict_types=1);

require_once __DIR__ . '/layout.php';

function service_page(array $p): void
{
    page_start([
        'title'       => $p['meta_title'],
        'description' => $p['meta_desc'],
        'path'        => $p['slug'],
        'body'        => 'page-service',
    ]);
    site_header('leistungen', ['Projekt anfragen', '#anfrage']);
    ?>
<main id="main">

<section class="hero hero-sub">
  <?= circuit_bg() ?>
  <div class="hero-inner">
    <div class="hero-grid">
      <div class="hero-copy">
        <ol class="crumbs" aria-label="Brotkrumen" data-reveal>
          <li><a href="./">Startseite</a></li><li aria-hidden="true">/</li>
          <li><a href="./#leistungen">Leistungen</a></li><li aria-hidden="true">/</li>
          <li aria-current="page"><?= e($p['title']) ?></li>
        </ol>
        <span class="tile tile-teal" data-reveal="scale" style="--d:1"><?= icon($p['icon'], 34) ?></span>
        <h1 class="h1" data-split><?= e($p['title']) ?></h1>
        <p class="claim" data-reveal style="--d:3"><?= e($p['claim']) ?></p>
        <p class="lead" data-reveal style="--d:4"><?= e($p['intro']) ?></p>
        <div class="hero-ctas" data-reveal style="--d:5">
          <?= btn('Projekt anfragen', '#anfrage') ?>
          <a class="btn btn-line mag" href="tel:<?= e(SITE['mobile_tel']) ?>"><?= icon('phone', 18) ?><span class="btn-label"><?= e(SITE['mobile']) ?></span></a>
        </div>
      </div>
      <div class="hero-media" data-reveal="clip" style="--d:2">
        <?= img($p['hero_img'], '(max-width: 1000px) 100vw, 45vw', '', true) ?>
        <span class="scanline" aria-hidden="true"></span>
        <div class="tag"><span class="mono"><?= e($p['tag'][0]) ?></span><?= e($p['tag'][1]) ?></div>
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-bottom:0">
  <div class="wrap">
    <div class="sec-head">
      <div>
        <?= eyebrow($p['offer_eyebrow']) ?>
        <h2 class="h2" data-split><?= e($p['offer_title'][0]) ?> <span class="muted"><?= e($p['offer_title'][1]) ?></span></h2>
      </div>
    </div>
    <div class="offer">
      <?php foreach ($p['offer'] as $k => [$ic, $t, $d]): $dark = $k === count($p['offer']) - 1; ?>
      <div class="card offer-card spot hov<?= $dark ? ' dark' : '' ?>" data-reveal style="--d:<?= $k ?>">
        <span class="tile<?= $dark ? ' tile-teal' : '' ?>"><?= icon($ic, 28) ?></span>
        <h3><?= e($t) ?></h3>
        <p><?= e($d) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section" style="padding-bottom:0">
  <div class="panel">
    <div class="sec-head">
      <div><h2 class="h2-sm" data-split><?= e($p['areas_title']) ?></h2></div>
      <p data-reveal style="--d:2"><?= e($p['areas_text']) ?></p>
    </div>
    <ul class="areas">
      <?php foreach ($p['areas'] as $k => [$ic, $t]): ?>
      <li class="area hov" data-reveal style="--d:<?= $k ?>"><span class="tile tile-sm tile-white"><?= icon($ic, 22) ?></span><?= e($t) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

<?php if (!empty($p['gallery'])): ?>
<section class="section" style="padding-bottom:0">
  <div class="wrap">
    <div class="sec-head">
      <div>
        <?= eyebrow($p['gallery_eyebrow']) ?>
        <h2 class="h2" data-split><?= e($p['gallery_title']) ?></h2>
      </div>
    </div>
    <div class="gallery">
      <?php foreach ($p['gallery'] as $k => $key): ?>
      <figure class="media" data-reveal="clip" style="--d:<?= $k ?>"><?= img($key, '(max-width: 640px) 100vw, (max-width: 1000px) 50vw, 25vw', '', false, '3:5') ?><figcaption><?= e(IMAGES[$key]['alt']) ?></figcaption></figure>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="section" style="padding-bottom:0">
  <div class="wrap">
    <div class="sec-head">
      <div>
        <?= eyebrow('Projekte') ?>
        <h2 class="h2" data-split>Realisierte Projekte</h2>
      </div>
      <p data-reveal style="--d:2"><?= e($p['projects_text']) ?></p>
    </div>
    <div class="projects">
      <?php foreach ($p['projects'] as $k => [$t, $client]): ?>
      <article class="card project spot" style="background:var(--card);border:1px solid var(--line);--d:<?= $k ?>" data-reveal>
        <div class="card-top"><span class="cat" style="background:var(--paper)"><?= icon($p['icon'], 16) ?><?= e($p['title']) ?></span><span class="pnum">P.0<?= $k + 1 ?></span></div>
        <h3><?= e($t) ?></h3>
        <span class="client" style="margin-top:auto"><?= e($client) ?></span>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section" id="anfrage-cta" style="padding-bottom:0">
  <div class="cta" data-reveal="scale">
    <div>
      <h2 class="h2" data-split><?= e($p['cta_title']) ?></h2>
      <p data-reveal style="--d:2"><?= e($p['cta_text']) ?></p>
    </div>
    <div class="btns" data-reveal style="--d:3">
      <?= btn('Anfrage senden', '#anfrage', 'dark') ?>
      <a class="btn btn-outline-ink mag" href="tel:<?= e(SITE['mobile_tel']) ?>"><span class="btn-label"><?= e(SITE['mobile']) ?></span></a>
    </div>
  </div>
</section>

<?php contact_section('anfrage', $p['slug']); ?>

</main>
<?php
    site_footer();
}
