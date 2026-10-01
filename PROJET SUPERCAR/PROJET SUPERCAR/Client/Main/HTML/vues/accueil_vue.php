<?php
// ============================================================
//  vues/accueil_vue.php  —  VUE : page d'accueil
//  Reçoit du contrôleur : $carousel, $hero, $hero_images, $points, $stats.
//  Toute donnée issue de la base est échappée avec e() (anti-XSS).
// ============================================================
require __DIR__ . '/layout/header.php';
?>

<!-- ============================================================
     CARROUSEL — on boucle sur les slides actives
============================================================ -->
<div id="carouselExampleSlidesOnly" class="carousel slide"
     data-bs-ride="carousel"
     data-bs-interval="3500"
     data-bs-pause="false">

  <div class="carousel-inner">
    <?php foreach ($carousel as $i => $slide) : ?>
      <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
        <img src="<?= e($slide['image']) ?>" class="d-block w-100" alt="<?= e($slide['titre']) ?>">
        <div class="carousel-caption text-start">
          <h5><?= e($slide['titre']) ?></h5>
          <p><?= nl2br(e($slide['description'])) ?></p>
          <!-- url_sure() et non e() : le lien est saisi librement par l'admin.
               e() laisserait passer un lien "javascript:..." qui s'exécuterait
               au clic. url_sure() n'autorise que les liens internes et http(s). -->
          <a href="<?= url_sure($slide['lien']) ?>" class="btn btn-outline-light">
            <?= e($slide['texte_lien']) ?>
          </a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>


<!-- ============================================================
     SECTION HERO
============================================================ -->
<section id="accueil" class="py-5">
  <div class="container">
    <div class="row align-items-center">

      <!-- Texte à gauche -->
      <div class="col-lg-6 mb-5 mb-lg-0">

        <h2 class="display-4 fw-bold mb-4 titre-degrade">
          <?= e($hero['titre'] ?? '') ?>
        </h2>

        <p class="lead fs-4 mb-4"><?= e($hero['sous_titre'] ?? '') ?></p>
        <p class="fs-5 mb-4"><?= e($hero['description'] ?? '') ?></p>

        <ul class="list-unstyled fs-5 mb-5">
          <?php foreach ($points as $point) : ?>
            <li class="mb-3">
              <i class="bi bi-check-circle-fill text-orange me-3"></i>
              <?= e($point['texte']) ?>
            </li>
          <?php endforeach; ?>
        </ul>

        <!-- url_sure() : même raison que pour le carrousel ci-dessus. -->
        <a href="<?= url_sure($hero['lien'] ?? 'essai.php') ?>"
           class="btn btn-orange btn-lg px-5 py-3 fw-bold rounded-pill shadow-lg">
          <?= e($hero['texte'] ?? '') ?>
        </a>

      </div>

      <!-- Images à droite -->
      <div class="col-lg-6">
        <div class="hero-grid">
          <!-- Image principale (gauche) -->
          <div class="hero-grid-left">
            <img src="<?= e($hero_images[0]['image'] ?? 'Images-Index/accueil-image/mercedes3.webp') ?>" 
                 alt="<?= e($hero_images[0]['alt'] ?? 'SuperCar') ?>" class="img-fluid">
          </div>
          <!-- Images secondaires (droite empilées) -->
          <div class="hero-grid-right">
            <img src="<?= e($hero_images[1]['image'] ?? 'Images-Index/accueil-image/audi4.webp') ?>" 
                 alt="<?= e($hero_images[1]['alt'] ?? 'SuperCar') ?>" class="img-fluid">
            <img src="<?= e($hero_images[2]['image'] ?? 'Images-Index/accueil-image/bmw1.webp') ?>" 
                 alt="<?= e($hero_images[2]['alt'] ?? 'SuperCar') ?>" class="img-fluid">
          </div>
        </div>
      </div>

    </div><!-- fin row -->


    <!-- Bloc statistiques : bande orange pleine (met l'accent en valeur) -->
    <div class="bande-orange text-center mt-5 px-4 py-5">
      <p class="fs-5 mb-4 fw-semibold bande-titre">Pourquoi choisir SuperCar ?</p>
      <div class="d-flex justify-content-center align-items-center gap-4 flex-wrap">
        <?php foreach ($stats as $index => $stat) : ?>
          <?php if ($index > 0) : ?>
            <!-- Barre de séparation verticale visible sur desktop, masquée sur mobile -->
            <div class="vr d-none d-md-block bande-separateur"></div>
          <?php endif; ?>
          <div class="px-3">
            <h5 class="fw-bold mb-1 bande-valeur"><?= e($stat['valeur']) ?></h5>
            <p class="mb-0 text-uppercase tracking-wider fw-medium bande-label"><?= e($stat['label']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

  </div>
</section>

<?php require __DIR__ . '/layout/footer.php'; ?>
