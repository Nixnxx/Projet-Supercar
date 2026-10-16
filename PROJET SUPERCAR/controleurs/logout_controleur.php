<?php
// ============================================================
//  controleurs/logout_controleur.php  —  CONTRÔLEUR : déconnexion CLIENT
//  CORRECTION (MED-05) : on ne retire que les clés du client
//  (un admin connecté dans un autre onglet reste connecté).
//  Appelé par logout.php.
// ============================================================

require_once __DIR__ . '/../includes/session.php';

// On retire TOUTES les clés posées par connexion_controleur.php.
// client_nom et client_prenom étaient oubliées : elles restaient en
// session après la déconnexion, alors qu'elles servent à afficher
// "Bienvenue ..." dans l'en-tête.
unset(
    $_SESSION['client_connecte'],
    $_SESSION['id_client'],
    $_SESSION['connecte'],
    $_SESSION['client_nom'],
    $_SESSION['client_prenom']
);

// On change l'identifiant de session au moment où l'on PERD des droits,
// comme on le fait déjà à la connexion quand on en gagne. L'ancien
// identifiant devient inutilisable : même si quelqu'un l'avait intercepté,
// il ne pourra plus s'en servir.
session_regenerate_id(true);

header('Location: index.php');
exit();
