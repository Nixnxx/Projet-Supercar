<?php
// ============================================================
//  controleurs/admin/essais_controleur.php  —  CONTRÔLEUR : demandes d'essai
//  Garde admin en premier. Appelé par ADMIN/admin_essais.php.
// ============================================================

require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../../includes/garde_admin.php';
require_once __DIR__ . '/../../modeles/essai_modele.php';

$action = $_GET['action'] ?? '';
$id     = intval($_GET['id'] ?? 0);
$succes = $_GET['succes'] ?? '';

// Pour afficher le statut en toutes lettres et avec la bonne couleur.
// Statut 1 (Confirmé) = voiture réservée → indisponible côté client.
// Statut 3 (Terminé)  = essai réalisé   → la voiture redevient disponible.
$statuts_labels = ['0' => 'En attente', '1' => 'Confirmé', '2' => 'Refusé', '3' => 'Terminé'];
$statuts_class  = ['0' => 'badge-wait', '1' => 'badge-ok',  '2' => 'badge-no', '3' => 'badge-done'];

// ---- Changement de statut (formulaire envoyé) ----
if (isset($_POST['set_statut'])) {
    $nid  = intval($_POST['id_demande']);
    $stat = intval($_POST['statut']);
    $com  = trim($_POST['commentaire']);
    maj_statut_essai($lienbd, $nid, $stat, $com);
    header('Location: admin_essais.php?succes=update');
    exit();
}

// ---- Suppression (lien) ----
if ($action === 'supprimer' && $id > 0) {
    supprimer_essai($lienbd, $id);
    header('Location: admin_essais.php?succes=supprime');
    exit();
}

// ---- Données pour l'affichage ----
$filtre = isset($_GET['filtre']) ? intval($_GET['filtre']) : -1;
$essais = get_essais_admin($lienbd, $filtre);

$detail = ($action === 'detail' && $id > 0) ? get_essai_detail($lienbd, $id) : null;

$titre_page = 'Admin — Essais';

require __DIR__ . '/../../vues/admin/essais_vue.php';
