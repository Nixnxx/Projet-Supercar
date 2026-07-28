<?php
// ============================================================
//  includes/session.php
//  Démarre la session et fournit deux fonctions pour savoir
//  qui est connecté (un client ? un administrateur ?).
// ============================================================

// On démarre la session (nécessaire pour utiliser $_SESSION).
session_start();

// Renvoie true si un CLIENT est connecté.
function est_connecte() {
    return !empty($_SESSION['client_connecte']);
}

// Renvoie true si un ADMINISTRATEUR est connecté.
// On vérifie le drapeau admin ET le niveau 'admin' : c'est ce qui
// empêche un simple client d'accéder à l'administration.
function est_admin() {
    return !empty($_SESSION['admin_connecte'])
        && isset($_SESSION['niveau'])
        && $_SESSION['niveau'] === 'admin';
}
