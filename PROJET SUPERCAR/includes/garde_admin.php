<?php
// ============================================================
//  includes/garde_admin.php
//  Barrière des pages d'administration.
//  À inclure tout en haut de chaque contrôleur admin : si la
//  personne n'est pas un administrateur connecté, on la renvoie
//  vers la page de connexion et on arrête le script.
// ============================================================

require_once __DIR__ . '/session.php';

if (!est_admin()) {
    header('Location: logina.php');
    exit();
}
