<?php
// ============================================================
//  controleurs/voitures_controleur.php  —  CONTRÔLEUR : catalogue
//  Appelé par le point d'entrée voitures.php.
// ============================================================

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../modeles/voiture_modele.php';

$voitures         = get_voitures_avec_marque($lienbd);
$imagesParVoiture = get_images_groupees($lienbd);
// La disponibilité de chaque voiture vient directement de la colonne
// voiture.disponible (synchronisée par essai_modele.php à chaque changement
// de statut d'essai) : pas besoin d'une requête séparée.

$titre_page = 'SuperCar – Nos voitures';

require __DIR__ . '/../vues/voitures_vue.php';
