<?php
// ============================================================
//  controleurs/politique_controleur.php  —  CONTRÔLEUR : politique
//  Page d'information (texte fixe) : il n'y a aucune donnée à charger
//  depuis la base, on affiche simplement la vue.
//  Appelé par politique.php.
// ============================================================

require_once __DIR__ . '/../includes/init.php';

$titre_page = 'SuperCar – Politique de confidentialité';

require __DIR__ . '/../vues/politique_vue.php';
