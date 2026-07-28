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

header('Location: logina.php');
exit();
