
// ============================================================
//  admin_accueil_supprimer.php  -  Supprime un élément
//
//  On reçoit en GET :
//   - table : carousel | hero_image | point | stat
//   - id    : l'identifiant de la ligne à supprimer
// ============================================================

<?php
session_start();
require('lienbd.php');
require('fonction.php');

if (!est_connecte()) {
    header('Location: logina.php');
    exit();
}

// On récupère les paramètres de l'URL
$table = isset($_GET['table']) ? $_GET['table'] : '';
$id    = isset($_GET['id'])    ? intval($_GET['id']) : 0;

// Vérification : l'id doit être valide
if ($id <= 0) {
    header("Location: accueil.php?msg=erreur");
    exit();
}

// On choisit la bonne table selon le paramètre reçu
if ($table == 'carousel') {

    $req = mysqli_prepare($lienbd, "DELETE FROM accueil_carousel WHERE id = ?");
    mysqli_stmt_bind_param($req, "i", $id);
    mysqli_stmt_execute($req);
    header("Location: accueil.php?msg=supprime#carrousel");

} elseif ($table == 'hero_image') {

    $req = mysqli_prepare($lienbd, "DELETE FROM accueil_hero_images WHERE id = ?");
    mysqli_stmt_bind_param($req, "i", $id);
    mysqli_stmt_execute($req);
    header("Location: accueil.php?msg=supprime#images");

} elseif ($table == 'point') {

    $req = mysqli_prepare($lienbd, "DELETE FROM accueil_points WHERE id = ?");
    mysqli_stmt_bind_param($req, "i", $id);
    mysqli_stmt_execute($req);
    header("Location: accueil.php?msg=supprime#points");

} elseif ($table == 'stat') {

    $req = mysqli_prepare($lienbd, "DELETE FROM accueil_stats WHERE id = ?");
    mysqli_stmt_bind_param($req, "i", $id);
    mysqli_stmt_execute($req);
    header("Location: accueil.php?msg=supprime#stats");

} else {
    header("Location: accueil.php?msg=erreur");
}

exit();
?>