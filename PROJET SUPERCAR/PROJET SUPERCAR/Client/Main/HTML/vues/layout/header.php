<?php
// ============================================================
//  vues/layout/header.php  —  VUE : en-tête commun du site client
//  Ouvre le document HTML (<!DOCTYPE>, <head>) et affiche la barre
//  de navigation. Chaque vue de page inclut ce fichier en premier,
//  puis vues/layout/footer.php à la fin.
//
//  $titre_page peut être défini par le contrôleur avant l'inclusion
//  pour personnaliser le titre de l'onglet.
// ============================================================
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($titre_page ?? 'SuperCar – Voitures d\'occasion') ?></title>

    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Feuilles de style du site (une par grande partie) -->
    <link rel="stylesheet" href="css/styles.css?v=1.1">   <!-- variables + base -->
    <link rel="stylesheet" href="css/header.css?v=1.1">
    <link rel="stylesheet" href="css/accueil.css?v=1.1">
    <link rel="stylesheet" href="css/footer.css?v=1.1">
    <link rel="stylesheet" href="css/contact.css?v=1.1">
    <link rel="stylesheet" href="css/service.css?v=1.1">
    <link rel="stylesheet" href="css/voiture.css?v=1.1">
    <link rel="stylesheet" href="css/essai.css?v=1.1">
    <!-- Note : connexion.css, inscription.css, logout.css et contactclient.css
         ont été retirés : les 2 premiers ne servaient nulle part (les pages
         de connexion utilisent transparent.css) et les 2 autres n'existaient
         pas (liens cassés). -->

    <!-- Bibliothèques externes -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

<header>
  <div class="container">
    <div class="d-flex align-items-center justify-content-between w-100 flex-wrap">

      <!-- Logo + titre cliquable -->
      <div class="d-flex align-items-center gap-3">
        <a href="index.php" class="logo-link"></a>
        <h1 class="mb-0">Super<span class="text-orange">Car</span></h1>
      </div>

      <!-- Menu central. On repère la page courante pour la surligner. -->
      <?php $pageactuelle = basename($_SERVER['SCRIPT_NAME']); ?>

      <nav class="d-flex align-items-center gap-4">
            <a href="index.php" class="text-white text-decoration-none fw-semibold <?= ($pageactuelle === 'index.php') ? 'active' : '' ?>">Accueil</a>
            <a href="voitures.php" class="text-white text-decoration-none fw-semibold <?= ($pageactuelle === 'voitures.php') ? 'active' : '' ?>">Voitures</a>
            <a href="services.php" class="text-white text-decoration-none fw-semibold <?= ($pageactuelle === 'services.php') ? 'active' : '' ?>">Services</a>
            <!-- Si connecté : accès direct à l'essai. Sinon : passage par la page "connexion requise". -->
            <a href="<?= est_connecte() ? 'essai.php' : 'nonconnecte.php?redirect=essai' ?>"
               class="text-white text-decoration-none fw-semibold <?= ($pageactuelle === 'essai.php') ? 'active' : '' ?>">
               Demande d'essai
            </a>
            <a href="contact.php" class="text-white text-decoration-none fw-semibold <?= ($pageactuelle === 'contact.php') ? 'active' : '' ?>">Contactez-nous</a>
      </nav>

      <!-- ============================================================
           Bloc de droite de l'en-tête : le bouton "compte".
           - Client CONNECTÉ       : bouton "Bienvenue <prénom>" ; le menu
                                     déroulant propose "Se déconnecter".
           - Visiteur NON connecté : bouton "Mon compte" ; le menu propose
                                     "Se connecter" et "S'inscrire".
           Les deux utilisent la MÊME classe .btn-compte (définie dans
           header.css) pour un rendu cohérent : bordure orange arrondie qui
           se remplit au survol. Le menu déroulant est géré par Bootstrap
           (data-bs-toggle="dropdown").
      ============================================================ -->
      <?php if (est_connecte()) : ?>

        <?php
          // Nom affiché : le prénom en priorité, sinon le nom, sinon "Client".
          // Ces valeurs sont enregistrées en session au moment de la connexion.
          $nom_affiche = $_SESSION['client_prenom'] ?? $_SESSION['client_nom'] ?? 'Client';
        ?>

        <div class="dropdown">
          <!-- Bouton "Bienvenue ..." : on clique dessus pour ouvrir le menu. -->
          <button class="btn-compte dropdown-toggle" type="button"
                  data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle"></i>
            <span>Bienvenue <?= e($nom_affiche) ?></span>
          </button>

          <ul class="dropdown-menu dropdown-menu-end mt-2" style="min-width: 190px;">
            <li>
              <!-- "danger" = rouge, pour bien distinguer l'action de déconnexion. -->
              <a class="dropdown-item dropdown-item-danger py-2 d-flex align-items-center gap-2" href="logout.php">
                <i class="bi bi-box-arrow-right"></i> Se déconnecter
              </a>
            </li>
          </ul>
        </div>

      <?php else : ?>

        <div class="dropdown">
          <!-- Bouton "Mon compte" : on clique pour ouvrir le menu connexion/inscription. -->
          <button class="btn-compte dropdown-toggle" type="button"
                  data-bs-toggle="dropdown" aria-expanded="false"
                  aria-label="Menu du compte">
            <i class="bi bi-person-circle"></i>
            <span>Mon compte</span>
          </button>

          <ul class="dropdown-menu dropdown-menu-end mt-2" style="min-width: 200px;">
            <li>
              <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="connexion.php">
                <i class="bi bi-box-arrow-in-right"></i> Se connecter
              </a>
            </li>
            <li>
              <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="inscription.php">
                <i class="bi bi-person-plus"></i> S'inscrire
              </a>
            </li>
          </ul>
        </div>

      <?php endif; ?>
    </div>
  </div>
</header>
