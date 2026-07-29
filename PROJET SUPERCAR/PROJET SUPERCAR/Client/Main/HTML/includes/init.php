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

// ------------------------------------------------------------
//  En-têtes de sécurité envoyés sur TOUTES les pages du site.
//  Ils doivent partir avant tout affichage, donc ici.
// ------------------------------------------------------------

// Interdit d'afficher le site dans une iframe d'un autre site.
// Empêche le "clickjacking" : un pirate met notre back-office dans une
// iframe invisible et fait cliquer l'admin sans qu'il s'en rende compte.
header('X-Frame-Options: SAMEORIGIN');

// Interdit au navigateur de "deviner" le type d'un fichier.
// Sans ça, un fichier image contenant du script pourrait être exécuté.
header('X-Content-Type-Options: nosniff');

// N'envoie pas l'adresse de notre page aux sites extérieurs.
// Évite de leur transmettre des informations dans l'URL.
header('Referrer-Policy: same-origin');

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/securite.php';
