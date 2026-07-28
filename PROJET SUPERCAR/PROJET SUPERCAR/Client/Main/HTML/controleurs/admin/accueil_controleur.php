<?php
// ============================================================
//  controleurs/admin/accueil_controleur.php  —  CONTRÔLEUR : contenu d'accueil
//  Affiche les 5 blocs (carrousel, hero, images, points, stats).
//  Garde admin en premier. Appelé par ADMIN/accueil.php.
// ============================================================

require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../../includes/garde_admin.php';
require_once __DIR__ . '/../../modeles/accueil_modele.php';

// Toutes les données (actives ou non) pour l'administration.
$carousel = get_carousel_tout($lienbd);
$hero     = get_hero($lienbd);
$images   = get_hero_images_tout($lienbd);
$points   = get_points_tout($lienbd);
$stats    = get_stats_tout($lienbd);

// Message de confirmation éventuel.
$message = "";
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === "ok")       $message = '<div class="alert success">✅ Opération réussie !</div>';
    if ($_GET['msg'] === "supprime") $message = '<div class="alert danger">🗑️ Élément supprimé.</div>';
}

$titre_page = 'Admin — Page Accueil';
$css_extra  = '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">';

require __DIR__ . '/../../vues/admin/accueil_list_vue.php';
