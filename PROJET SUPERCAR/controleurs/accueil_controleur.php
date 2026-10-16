<?php
// ============================================================
//  controleurs/accueil_controleur.php  —  CONTRÔLEUR : page d'accueil
//  Récupère le contenu via le modèle, puis affiche la vue.
//  Appelé par le point d'entrée index.php.
// ============================================================

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../modeles/accueil_modele.php';

// On demande au modèle uniquement les éléments ACTIFS.
$carousel    = get_carousel_actif($lienbd);
$hero        = get_hero($lienbd);
$hero_images = get_hero_images_actives($lienbd);
$points      = get_points_actifs($lienbd);
$stats       = get_stats_actives($lienbd);

$titre_page = 'SuperCar – Accueil';

require __DIR__ . '/../vues/accueil_vue.php';
