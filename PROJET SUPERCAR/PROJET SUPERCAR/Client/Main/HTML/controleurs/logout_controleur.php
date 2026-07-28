<?php
// ============================================================
//  controleurs/logout_controleur.php  —  CONTRÔLEUR : déconnexion CLIENT
//  CORRECTION (MED-05) : on ne retire que les clés du client
//  (un admin connecté dans un autre onglet reste connecté).
//  Appelé par logout.php.
// ============================================================

require_once __DIR__ . '/../includes/session.php';

unset(
    $_SESSION['client_connecte'],
    $_SESSION['id_client'],
    $_SESSION['connecte']
);

header('Location: index.php');
exit();
