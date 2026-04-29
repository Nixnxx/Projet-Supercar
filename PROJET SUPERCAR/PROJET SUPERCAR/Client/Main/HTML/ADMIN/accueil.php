<?php
session_start();
require('lienbd.php');
require('fonction.php');

if (!est_connecte()) {
    header('Location: login.html');
    exit();
}

// Les slides du carrousel
$req_carousel = mysqli_query($lienbd, "SELECT * FROM accueil_carousel ORDER BY ordre");

// Le texte hero (1 seule ligne)
$req_hero = mysqli_query($lienbd, "SELECT * FROM accueil_bienvenue LIMIT 1");
$hero     = mysqli_fetch_assoc($req_hero);

// Les images hero
$req_images = mysqli_query($lienbd, "SELECT * FROM accueil_bienvenue_images ORDER BY ordre");

// Les points forts
$req_points = mysqli_query($lienbd, "SELECT * FROM accueil_points ORDER BY ordre");

// Les statistiques
$req_stats = mysqli_query($lienbd, "SELECT * FROM accueil_stats ORDER BY ordre");

// ---- Message de confirmation (après ajout / modif / suppr) ----
$message = "";
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == "ok")       $message = '<div class="alert alert-success">✅ Opération réussie !</div>';
    if ($_GET['msg'] == "supprime") $message = '<div class="alert alert-warning">🗑️ Élément supprimé.</div>';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin – Page Accueil | SuperCar</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    body        { background: #111; color: #ddd; }
    .sidebar    { width: 220px; min-height: 100vh; background: #1c1c1c; border-right: 2px solid #ff6b00; }
    .sidebar h4 { color: #ff6b00; padding: 20px 15px; border-bottom: 1px solid #333; }
    .nav-link   { color: #aaa !important; }
    .nav-link:hover { color: #ff6b00 !important; }
    .card-section { background: #1c1c1c; border: 1px solid #333; border-radius: 10px; margin-bottom: 40px; }
    .card-section .entete { background: #222; padding: 15px 20px; border-radius: 10px 10px 0 0;
                             font-weight: bold; border-bottom: 1px solid #333; }
    .table-dark th { color: #ff6b00; }
    .btn-orange { background: #ff6b00; color: #fff; border: none; }
    .btn-orange:hover { background: #cc5500; color: #fff; }
    .miniature  { width: 70px; height: 45px; object-fit: cover; border-radius: 5px; }
  </style>
</head>
<body>

<div class="d-flex">

  <!-- ===== MENU GAUCHE ===== -->
  <div class="sidebar">
    <nav class="nav flex-column p-2 mt-2">
      <?php include 'admin_style.php'; ?>
      <?php include 'admin_nav.php'; ?>
    </nav>
  </div>

  <!-- ===== CONTENU PRINCIPAL ===== -->
  <div class="flex-grow-1 p-4">

    <h2 class="mb-1" style="color:#ff6b00">Gestion – Page Accueil</h2>
    <p class="text-secondary mb-4">Ajoutez, modifiez ou supprimez les éléments affichés sur l'accueil.</p>

    <?= $message ?>


    <!-- ================================================
         SECTION 1 : CARROUSEL
    ================================================ -->
    <div class="card-section" id="carrousel">
      <div class="entete d-flex justify-content-between align-items-center">
        <span><i class="bi bi-images me-2 text-warning"></i>Slides du Carrousel</span>
        <a href="accueil_mod.php?table=carousel" class="btn btn-orange btn-sm">
          <i class="bi bi-plus-lg me-1"></i>Ajouter une slide
        </a>
      </div>
      <div class="table-responsive p-2">
        <table class="table table-dark table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Image</th>
              <th>Titre</th>
              <th>Ordre</th>
              <th>Actif</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php while ($slide = mysqli_fetch_assoc($req_carousel)) : ?>
            <tr>
              <td><?= $slide['id'] ?></td>
              <td><img src="../<?= htmlspecialchars($slide['image']) ?>" class="miniature" alt=""></td>
              <td><?= htmlspecialchars($slide['titre']) ?></td>
              <td><?= $slide['ordre'] ?></td>
              <td><?= $slide['actif'] ? '<span class="badge bg-success">Oui</span>' : '<span class="badge bg-danger">Non</span>' ?></td>
              <td>
                <a href="accueil_mod.php?table=carousel&id=<?= $slide['id'] ?>" class="btn btn-warning btn-sm me-1">
                  <i class="bi bi-pencil"></i>
                </a>
                <a href="accueil_supp.php?table=carousel&id=<?= $slide['id'] ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Supprimer cette slide ?')">
                  <i class="bi bi-trash"></i>
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>


    <!-- ================================================
         SECTION 2 : TEXTE HERO
    ================================================ -->
    <div class="card-section" id="hero">
      <div class="entete d-flex justify-content-between align-items-center">
        <span><i class="bi bi-type-h1 me-2 text-info"></i>Texte de la section Hero</span>
        <a href="accueil_mod.php?table=hero&id=<?= $hero['id'] ?>" class="btn btn-orange btn-sm">
          <i class="bi bi-pencil me-1"></i>Modifier
        </a>
      </div>
      <div class="p-4">
        <p><strong>Titre :</strong> <?= htmlspecialchars($hero['titre']) ?></p>
        <p><strong>Sous-titre :</strong> <?= htmlspecialchars($hero['sous_titre']) ?></p>
        <p><strong>Description :</strong> <?= htmlspecialchars(substr($hero['description'], 0, 100)) ?>…</p>
        <p><strong>Bouton :</strong>
          <span class="badge bg-warning text-dark"><?= htmlspecialchars($hero['texte']) ?></span>
          → <code><?= htmlspecialchars($hero['lien']) ?></code>
        </p>
      </div>
    </div>


    <!-- ================================================
         SECTION 3 : IMAGES HERO
    ================================================ -->
    <div class="card-section" id="images">
      <div class="entete d-flex justify-content-between align-items-center">
        <span><i class="bi bi-card-image me-2 text-success"></i>Images Hero (colonne droite)</span>
        <a href="accueil_mod.php?table=hero_image" class="btn btn-orange btn-sm">
          <i class="bi bi-plus-lg me-1"></i>Ajouter une image
        </a>
      </div>
      <div class="table-responsive p-2">
        <table class="table table-dark table-hover">
          <thead>
            <tr><th>ID</th><th>Aperçu</th><th>Fichier</th><th>Alt</th><th>Ordre</th><th>Actif</th><th>Actions</th></tr>
          </thead>
          <tbody>
          <?php while ($img = mysqli_fetch_assoc($req_images)) : ?>
            <tr>
              <td><?= $img['id'] ?></td>
              <td><img src="../<?= htmlspecialchars($img['image']) ?>" class="miniature" alt=""></td>
              <td><?= htmlspecialchars($img['image']) ?></td>
              <td><?= htmlspecialchars($img['alt']) ?></td>
              <td><?= $img['ordre'] ?></td>
              <td><?= $img['actif'] ? '<span class="badge bg-success">Oui</span>' : '<span class="badge bg-danger">Non</span>' ?></td>
              <td>
                <a href="accueil_mod.php?table=hero_image&id=<?= $img['id'] ?>" class="btn btn-warning btn-sm me-1"><i class="bi bi-pencil"></i></a>
                <a href="accueil_supp.php?table=hero_image&id=<?= $img['id'] ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Supprimer cette image ?')"><i class="bi bi-trash"></i></a>
              </td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>


    <!-- ================================================
         SECTION 4 : POINTS FORTS
    ================================================ -->
    <div class="card-section" id="points">
      <div class="entete d-flex justify-content-between align-items-center">
        <span><i class="bi bi-list-check me-2 text-warning"></i>Points Forts</span>
        <a href="accueil_mod.php?table=point" class="btn btn-orange btn-sm">
          <i class="bi bi-plus-lg me-1"></i>Ajouter un point
        </a>
      </div>
      <div class="table-responsive p-2">
        <table class="table table-dark table-hover">
          <thead>
            <tr><th>ID</th><th>Texte</th><th>Ordre</th><th>Actif</th><th>Actions</th></tr>
          </thead>
          <tbody>
          <?php while ($point = mysqli_fetch_assoc($req_points)) : ?>
            <tr>
              <td><?= $point['id'] ?></td>
              <td>✅ <?= htmlspecialchars($point['texte']) ?></td>
              <td><?= $point['ordre'] ?></td>
              <td><?= $point['actif'] ? '<span class="badge bg-success">Oui</span>' : '<span class="badge bg-danger">Non</span>' ?></td>
              <td>
                <a href="accueil_mod.php?table=point&id=<?= $point['id'] ?>" class="btn btn-warning btn-sm me-1"><i class="bi bi-pencil"></i></a>
                <a href="accueil_supp.php?table=point&id=<?= $point['id'] ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Supprimer ce point ?')"><i class="bi bi-trash"></i></a>
              </td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>


    <!-- ================================================
         SECTION 5 : STATISTIQUES
    ================================================ -->
    <div class="card-section" id="stats">
      <div class="entete d-flex justify-content-between align-items-center">
        <span><i class="bi bi-bar-chart me-2 text-danger"></i>Statistiques</span>
        <a href="accueil_mod.php?table=stat" class="btn btn-orange btn-sm">
          <i class="bi bi-plus-lg me-1"></i>Ajouter une stat
        </a>
      </div>
      <div class="table-responsive p-2">
        <table class="table table-dark table-hover">
          <thead>
            <tr><th>ID</th><th>Valeur</th><th>Label</th><th>Ordre</th><th>Actif</th><th>Actions</th></tr>
          </thead>
          <tbody>
          <?php while ($stat = mysqli_fetch_assoc($req_stats)) : ?>
            <tr>
              <td><?= $stat['id'] ?></td>
              <td><strong class="text-warning"><?= htmlspecialchars($stat['valeur']) ?></strong></td>
              <td><?= htmlspecialchars($stat['label']) ?></td>
              <td><?= $stat['ordre'] ?></td>
              <td><?= $stat['actif'] ? '<span class="badge bg-success">Oui</span>' : '<span class="badge bg-danger">Non</span>' ?></td>
              <td>
                <a href="accueil_mod.php?table=stat&id=<?= $stat['id'] ?>" class="btn btn-warning btn-sm me-1"><i class="bi bi-pencil"></i></a>
                <a href="accueil_supp.php?table=stat&id=<?= $stat['id'] ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Supprimer cette stat ?')"><i class="bi bi-trash"></i></a>
              </td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div><!-- fin contenu -->
</div><!-- fin flex -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>