<?php
// ============================================================
//  includes/init.php
//  Amorçage commun (le "noyau" de l'application).
//
//  Chaque CONTRÔLEUR inclut ce fichier en premier. Il met en place,
//  dans l'ordre :
//    1. les constantes de configuration
//    2. la connexion à la base ($lienbd)
//    3. la session + les fonctions d'authentification
//    4. les fonctions de sécurité (échappement, CSRF, upload)
//
//  L'emploi de __DIR__ rend les chemins corrects, que le contrôleur
//  soit dans HTML/ (client) ou dans HTML/ADMIN/ (admin).
// ============================================================

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/securite.php';
