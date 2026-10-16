<?php
// ============================================================
//  controleurs/mentions_controleur.php  —  CONTRÔLEUR : mentions légales
//  Page d'information (texte fixe) : aucune donnée à charger depuis la
//  base, on affiche simplement la vue. Même schéma que politique.
//  Appelé par public/mentions.php.
// ============================================================

require_once __DIR__ . '/../includes/init.php';

$titre_page = 'SuperCar – Mentions légales';

require __DIR__ . '/../vues/mentions_vue.php';
