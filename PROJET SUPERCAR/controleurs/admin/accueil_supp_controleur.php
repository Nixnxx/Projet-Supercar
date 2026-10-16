<?php
// ============================================================
//  controleurs/admin/accueil_supp_controleur.php  —  CONTRÔLEUR :
//  suppression d'un élément de l'accueil (carrousel, image, point, stat).
//  Garde admin en premier. On reçoit "table" et "id" par POST.
//  Appelé par ADMIN/accueil_supp.php.
// ============================================================

require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../../includes/garde_admin.php';
require_once __DIR__ . '/../../modeles/admin/accueil_modele.php';

// On n'accepte QUE la méthode POST : une suppression modifie la base,
// elle ne doit donc jamais pouvoir être déclenchée par une simple adresse.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: accueil.php');
    exit();
}

// On vérifie le jeton CSRF avant de supprimer.
csrf_verifier();

$table = $_POST['table'] ?? '';
$id    = intval($_POST['id'] ?? 0);

accueil_supprimer($lienbd, $table, $id);

header('Location: accueil.php?msg=supprime');
exit();
