<?php
/** Hero für Rechtstexte und Statusseiten. */
declare(strict_types=1);

require_once __DIR__ . '/layout.php';

function legal_hero(string $eyebrow, string $title, string $lead = ''): void
{
    ?>
<section class="hero hero-legal">
  <?= circuit_bg() ?>
  <div class="hero-inner">
    <div class="hero-grid">
      <div class="hero-copy">
        <ol class="crumbs" aria-label="Brotkrumen" data-reveal><li><a href="./">Startseite</a></li><li aria-hidden="true">/</li><li aria-current="page"><?= e($eyebrow) ?></li></ol>
        <h1 class="h1" data-split><?= e($title) ?></h1>
        <?php if ($lead): ?><p class="lead" style="color:var(--on-dark);--d:3" data-reveal><?= e($lead) ?></p><?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php
}
