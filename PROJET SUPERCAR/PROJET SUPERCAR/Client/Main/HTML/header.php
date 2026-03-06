<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperCar – Voitures d'occasion</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<header>
  <div class="container">
    <div class="d-flex align-items-center justify-content-between w-100 flex-wrap">
      
      <!-- Logo + titre -->
      <div class="d-flex align-items-center gap-3">
        <h1 class="mb-0">SuperCar</h1>
      </div>

      <!-- Menu central -->
       <?php $pageactuelle = basename($_SERVER['SCRIPT_NAME']); ?>

      <nav class="d-flex align-items-center gap-4">
        <a href="index.php" class="text-white text-decoration-none fw-semibold <?= ($pageactuelle ==='index.php') ? 'active' : '' ?>">Accueil</a>
    <a href="voitures.php" class="text-white text-decoration-none fw-semibold <?= ($pageactuelle==='voitures.php') ? 'active' : '' ?>">Voitures</a>
    <a href="services.php" class="text-white text-decoration-none fw-semibold <?= ($pageactuelle==='services.php') ? 'active' : '' ?>">Services</a>
        <a href="essai.php" class="text-white text-decoration-none fw-semibold <?= ($pageactuelle=== 'essai.php') ? 'active' : '' ?>">Demande d'essai</a>
        
        <a href="contact.php" class="text-white text-decoration-none fw-semibold <?= ($pageactuelle==='contact.php') ? 'active' : '' ?>">Contactez-nous</a>
      </nav>

      <!-- Dropdown (Contact + Compte) -->
      <div class="dropdown">
        <button class="btn btn-link text-white p-0 border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
              d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
          </svg>
        </button>

        <ul class="dropdown-menu dropdown-menu-end bg-dark text-white border-0 shadow-lg mt-2" style="min-width: 200px;">
          <li><a class="dropdown-item text-white py-3" href="connexion.html">Mon compte</a></li>
        </ul>
      </div>

    </div>
  </div>
</header>

