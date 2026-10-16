<?php
// ============================================================
//  modeles/accueil_modele.php  —  MODÈLE : contenu de la page d'accueil
//  CÔTÉ CLIENT : ne renvoie que les éléments ACTIFS, ceux que le
//  visiteur doit voir. Tout ce qui sert à GÉRER l'accueil (ajouter,
//  modifier, supprimer, voir les éléments inactifs) est dans
//  modeles/admin/accueil_modele.php.
// ============================================================

function get_carousel_actif($lienbd) {
    $sql = "SELECT * FROM accueil_carousel WHERE actif = 1 ORDER BY ordre";
    $liste = mysqli_fetch_all(mysqli_query($lienbd, $sql), MYSQLI_ASSOC);
    return $liste ?: [];
}

// Le texte de la bannière d'accueil.
// Utilisé aussi par l'admin (pour pré-remplir le formulaire de modification) :
// c'est une simple LECTURE, elle reste donc du côté client et le contrôleur
// admin inclut ce fichier en plus du sien.
function get_hero($lienbd) {
    $sql = "SELECT * FROM accueil_bienvenue LIMIT 1";
    $ligne = mysqli_fetch_assoc(mysqli_query($lienbd, $sql));
    return $ligne ?: null;
}

function get_hero_images_actives($lienbd) {
    $sql = "SELECT * FROM accueil_bienvenue_images WHERE actif = 1 ORDER BY ordre";
    $liste = mysqli_fetch_all(mysqli_query($lienbd, $sql), MYSQLI_ASSOC);
    return $liste ?: [];
}

function get_points_actifs($lienbd) {
    $sql = "SELECT * FROM accueil_points WHERE actif = 1 ORDER BY ordre";
    $liste = mysqli_fetch_all(mysqli_query($lienbd, $sql), MYSQLI_ASSOC);
    return $liste ?: [];
}

function get_stats_actives($lienbd) {
    $sql = "SELECT * FROM accueil_stats WHERE actif = 1 ORDER BY ordre";
    $liste = mysqli_fetch_all(mysqli_query($lienbd, $sql), MYSQLI_ASSOC);
    return $liste ?: [];
}
