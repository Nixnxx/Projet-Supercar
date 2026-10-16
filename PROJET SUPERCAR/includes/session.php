<?php
// ============================================================
//  includes/session.php
//  Démarre la session et fournit deux fonctions pour savoir
//  qui est connecté (un client ? un administrateur ?).
// ============================================================

// Options de sécurité du cookie de session.
// ATTENTION : à écrire AVANT session_start(), sinon le cookie est déjà créé.
//   httponly : le JavaScript ne peut plus lire le cookie (protection XSS)
//   samesite : le navigateur n'envoie plus le cookie quand la requête vient
//              d'un AUTRE site (protection CSRF)
//   secure   : à passer à true le jour où le site sera en HTTPS
session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
    'secure'   => false,
]);

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
