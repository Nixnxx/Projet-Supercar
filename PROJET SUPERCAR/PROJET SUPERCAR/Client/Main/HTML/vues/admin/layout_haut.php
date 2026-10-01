<?php
// ============================================================
//  vues/admin/layout_haut.php  —  VUE (partiel) : haut de page admin
//  Ouvre le document, charge les styles et affiche le menu latéral.
//  Le contrôleur peut définir avant l'inclusion :
//    $titre_page  : titre de l'onglet
//    $css_extra   : balises <link> supplémentaires à mettre dans <head>
//
//  Les feuilles de style sont dans public/css/admin/ (une par page,
//  plus style.css pour tout ce qui est commun) — même découpage que
//  les scripts de public/js/admin/. Les pages admin étant dans
//  public/ADMIN/, le chemin remonte d'un cran : "../css/admin/".
// ============================================================
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($titre_page ?? 'Administration — SuperCar') ?></title>

<!-- Polices -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

<!-- Feuilles de style du back-office -->
<link rel="stylesheet" href="../css/admin/style.css?v=1.2">      <!-- variables + composants communs -->
<link rel="stylesheet" href="../css/admin/accueil.css?v=1.2">
<link rel="stylesheet" href="../css/admin/voitures.css?v=1.2">
<link rel="stylesheet" href="../css/admin/services.css?v=1.2">
<link rel="stylesheet" href="../css/admin/contact.css?v=1.2">
<link rel="stylesheet" href="../css/admin/essais.css?v=1.2">

<?= $css_extra ?? '' ?>
</head>
<body>

<!-- ============================================================
     BOUTON "RETOUR" DU NAVIGATEUR APRÈS UNE DÉCONNEXION
     Pour que le bouton Retour soit instantané, les navigateurs
     gardent en mémoire une photo complète des pages déjà visitées
     (le "bfcache"). Ils la réaffichent SANS redemander la page au
     serveur : après une déconnexion, on revoyait donc l'ancien
     back-office alors que la session est bien fermée. C'est pour
     ça qu'actualiser (F5) corrigeait l'affichage.

     event.persisted vaut true UNIQUEMENT quand la page vient d'être
     restaurée depuis cette mémoire. Dans ce cas seulement, on force
     un vrai rechargement : la garde admin s'applique alors et
     renvoie vers la page de connexion.
     ============================================================ -->
<script>
window.addEventListener('pageshow', function (event) {
    if (event.persisted) {
        window.location.reload();
    }
});
</script>

<?php require __DIR__ . '/nav.php'; ?>
