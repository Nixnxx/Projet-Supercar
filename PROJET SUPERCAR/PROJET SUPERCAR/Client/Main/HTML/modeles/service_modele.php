<?php
// ============================================================
//  modeles/service_modele.php  —  MODÈLE : services
//  CÔTÉ CLIENT : afficher la liste des services proposés.
//  La GESTION des services (ajouter, modifier, supprimer) est dans
//  modeles/admin/service_modele.php.
// ============================================================

// Tous les services, triés par numéro d'ordre.
// Utilisée aussi par l'admin (pour afficher son tableau de gestion) :
// c'est une simple LECTURE, elle reste donc du côté client et le
// contrôleur admin inclut ce fichier en plus du sien.
function get_services($lienbd) {
    $sql = "SELECT * FROM service ORDER BY numero";
    $liste = mysqli_fetch_all(mysqli_query($lienbd, $sql), MYSQLI_ASSOC);
    return $liste ?: [];
}
