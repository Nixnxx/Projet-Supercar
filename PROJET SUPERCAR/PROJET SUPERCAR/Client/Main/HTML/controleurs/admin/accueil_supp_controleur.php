<?php
// ============================================================
//  controleurs/admin/accueil_supp_controleur.php  —  CONTRÔLEUR :
//  suppression d'un élément de l'accueil (carrousel, image, point, stat).
//  Garde admin en premier. On reçoit "table" et "id" dans l'URL.
//  Appelé par ADMIN/accueil_supp.php.
// ============================================================

require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../../includes/garde_admin.php';
require_once __DIR__ . '/../../modeles/accueil_modele.php';

$table = $_GET['table'] ?? '';
$id    = intval($_GET['id'] ?? 0);

accueil_supprimer($lienbd, $table, $id);

header('Location: accueil.php?msg=supprime');
exit();
