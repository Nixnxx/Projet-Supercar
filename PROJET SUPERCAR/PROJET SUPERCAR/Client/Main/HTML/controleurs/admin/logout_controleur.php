<?php
// ============================================================
//  controleurs/admin/logout_controleur.php  —  CONTRÔLEUR :
//  déconnexion ADMINISTRATEUR.
//  CORRECTION (MED-05) : on ne retire que les clés admin.
//  Appelé par ADMIN/logout.php.
// ============================================================

require_once __DIR__ . '/../../includes/session.php';

unset(
    $_SESSION['admin_connecte'],
    $_SESSION['niveau'],
    $_SESSION['id_login']
);

// On change l'identifiant de session au moment où l'on PERD des droits,
// comme on le fait déjà à la connexion quand on en gagne. L'ancien
// identifiant devient inutilisable : même si quelqu'un l'avait intercepté,
// il ne pourra plus s'en servir.
session_regenerate_id(true);

header('Location: logina.php');
exit();