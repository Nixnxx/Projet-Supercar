<?php
// ============================================================
//  index.php  -  Page Accueil (partie client)
//  On va chercher toutes les données dans la base de données
// ============================================================

session_start();
require('lienbd.php');
require('fonction.php');

// ---- On récupère les données depuis la BD ------------------

// Les slides du carrousel (seulement celles qui sont actives, dans l'ordre)
$req_carousel = mysqli_query($lienbd, "SELECT * FROM accueil_carousel WHERE actif = 1 ORDER BY ordre");

// Le texte hero (1 seule ligne)
$req_hero = mysqli_query($lienbd, "SELECT * FROM accueil_bienvenue LIMIT 1");
$hero     = mysqli_fetch_assoc($req_hero);

// Les images de droite du hero (actives uniquement)
$req_images = mysqli_query($lienbd, "SELECT * FROM accueil_bienvenue_images WHERE actif = 1 ORDER BY ordre");

// Les points forts (actifs uniquement)
$req_points = mysqli_query($lienbd, "SELECT * FROM accueil_points WHERE actif = 1 ORDER BY ordre");

// Les statistiques (actives uniquement)
$req_stats = mysqli_query($lienbd, "SELECT * FROM accueil_stats WHERE actif = 1 ORDER BY ordre");

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SuperCar – Accueil</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

<?php include 'header.php'; ?>


<!-- ============================================================
     CARROUSEL
     On boucle sur les slides récupérées dans la BD
============================================================ -->
<div id="carouselExampleSlidesOnly" class="carousel slide"
     data-bs-ride="carousel"
     data-bs-interval="3500"
     data-bs-pause="false">

  <div class="carousel-inner">

    <?php
    $premier = true;
    while ($slide = mysqli_fetch_assoc($req_carousel)) :
    ?>
      <div class="carousel-item <?= $premier ? 'active' : '' ?>">
        <img src="<?= htmlspecialchars($slide['image']) ?>" class="d-block w-100" alt="<?= htmlspecialchars($slide['titre']) ?>">
        <div class="carousel-caption d-none d-md-block text-start">
          <h5><?= htmlspecialchars($slide['titre']) ?></h5>
          <p><?= nl2br(htmlspecialchars($slide['description'])) ?></p>
          <a href="<?= htmlspecialchars($slide['lien']) ?>" class="btn btn-outline-light">
            <?= htmlspecialchars($slide['texte_lien']) ?>
          </a>
        </div>
      </div>
    <?php
    $premier = false;
    endwhile;
    ?>

  </div>
</div>


<!-- ============================================================
     SECTION HERO
     On affiche les données qui viennent de la BD
============================================================ -->
<section id="accueil" class="py-5 bg-dark text-white">
  <div class="container">
    <div class="row align-items-center">

      <!-- Texte à gauche -->
      <div class="col-lg-6 mb-5 mb-lg-0">

        <h2 class="display-4 fw-bold mb-4"
            style="background: linear-gradient(135deg, var(--primary-orange), #ff8c00);
                   -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
          <?= htmlspecialchars($hero['titre']) ?>
        </h2>

        <p class="lead fs-4 mb-4">
          <?= htmlspecialchars($hero['sous_titre']) ?>
        </p>

        <p class="fs-5 mb-4">
          <?= htmlspecialchars($hero['description']) ?>
        </p>

        <ul class="list-unstyled fs-5 mb-5">
          <?php while ($point = mysqli_fetch_assoc($req_points)) : ?>
            <li class="mb-3">
              <i class="bi bi-check-circle-fill text-warning me-3"></i>
              <?= htmlspecialchars($point['texte']) ?>
            </li>
          <?php endwhile; ?>
        </ul>

        <a href="<?= htmlspecialchars($hero['lien']) ?>"
           class="btn btn-warning btn-lg px-5 py-3 fw-bold rounded-pill shadow-lg">
          <?= htmlspecialchars($hero['texte']) ?>
        </a>

      </div>

      <!-- Images à droite : on boucle sur la BD -->
      <div class="col-lg-6 photo">
  <div class="row g-4">

          <?php
          $compteur = 0;
          while ($img = mysqli_fetch_assoc($req_images)) :
            $compteur++;
          ?>

            <?php if ($compteur <= 2) : ?>
              <div class="col-6">
                <img src="<?= htmlspecialchars($img['image']) ?>"
                     class="img-fluid rounded shadow-lg"
                     alt="<?= htmlspecialchars($img['alt']) ?>"
                     style="height: 280px; object-fit: cover;">
              </div>
            <?php else : ?>
              <div class="col-12">
                <img src="<?= htmlspecialchars($img['image']) ?>"
                     class="img-fluid rounded shadow-lg"
                     alt="<?= htmlspecialchars($img['alt']) ?>"
                     style="height: 300px; object-fit: cover;">
              </div>
            <?php endif; ?>

          <?php endwhile; ?>

        </div>
      </div>

    </div><!-- fin row -->


    <!-- Bloc statistiques : on boucle sur la BD -->
    <div class="text-center mt-5 pt-4 border-top border-secondary">
      <p class="fs-5 mb-3">Pourquoi choisir SuperCar ?</p>
      <div class="d-flex justify-content-center gap-5 flex-wrap">

        <?php while ($stat = mysqli_fetch_assoc($req_stats)) : ?>
          <div>
            <h5 class="text-warning"><?= htmlspecialchars($stat['valeur']) ?></h5>
            <p><?= htmlspecialchars($stat['label']) ?></p>
          </div>
        <?php endwhile; ?>

      </div>
    </div>

  </div>
</section>


<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>