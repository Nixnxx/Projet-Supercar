<?php
// ============================================================
//  controleurs/admin/contact_controleur.php  —  CONTRÔLEUR : messages
//  Garde admin en premier : personne ne peut agir sans être connecté admin.
//  Appelé par ADMIN/admin_contact.php.
// ============================================================

require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../../includes/garde_admin.php';   // ← barrière de sécurité
require_once __DIR__ . '/menu_controleur.php';   // compteurs des pastilles du menu
require_once __DIR__ . '/../../modeles/contact_modele.php';        // lecture partagée (get_config_contact)
require_once __DIR__ . '/../../modeles/admin/contact_modele.php';

$action = $_GET['action'] ?? '';
$id     = intval($_GET['id'] ?? 0);
$tab    = $_GET['tab'] ?? 'messages';
$succes = $_GET['succes'] ?? '';

// Toutes les actions qui MODIFIENT la base passent par POST (configuration,
// marquage lu/non lu, suppression). Une simple lecture (afficher la liste,
// voir un message) se fait en GET et n'a pas besoin de jeton.
if (!empty($_POST)) {
    csrf_verifier();
}

// ---- Enregistrement de la configuration (formulaire envoyé) ----
if (isset($_POST['save_config'])) {
    $adr = trim($_POST['adresse']);
    $em  = trim($_POST['email_config']);
    $tel = trim($_POST['telephone']);
    $personne_nom = trim($_POST['personne_nom'] ?? '');
    $personne_email = trim($_POST['personne_email'] ?? '');
    $personne_telephone = trim($_POST['personne_telephone'] ?? '');
    $lat = floatval($_POST['lat']);
    $lng = floatval($_POST['lng']);
    $map = "https://maps.google.com/maps?q={$lat},{$lng}&z=15&output=embed";

    maj_config_contact(
    $lienbd,
    $adr,
    $em,
    $tel,
    $map,
    $personne_nom,
    $personne_email,
    $personne_telephone
);
    header('Location: admin_contact.php?tab=config&succes=config');
    exit();
}

// ---- Suppression d'un message (formulaire envoyé) ----
if (isset($_POST['supprimer'])) {
    $id_suppr = intval($_POST['id_suppr']);
    if ($id_suppr > 0) {
        supprimer_message($lienbd, $id_suppr);
    }
    header('Location: admin_contact.php?succes=supprime');
    exit();
}

// ---- Marquer lu / non lu (formulaire envoyé) ----
if (isset($_POST['marquer'])) {
    $id_marquer = intval($_POST['id_marquer']);
    // On ne garde que 0 ou 1 : toute autre valeur devient 0.
    $nouvel_etat = intval($_POST['nouvel_etat']) === 1 ? 1 : 0;
    if ($id_marquer > 0) {
        marquer_message($lienbd, $id_marquer, $nouvel_etat);
    }
    header('Location: admin_contact.php');
    exit();
}

// ---- Données pour l'affichage ----
$messages = get_tous_messages($lienbd);
$stats    = get_stats_messages($lienbd);
$config   = get_config_contact($lienbd);

// Position de la carte, extraite de l'URL enregistrée.
$lat = -20.2447;
$lng = 57.4809;
if (!empty($config['map_embed']) && preg_match('/q=([-\d.]+),([-\d.]+)/', $config['map_embed'], $m)) {
    $lat = $m[1];
    $lng = $m[2];
}

// Détail d'un message (et passage en "lu").
$msg_detail = null;
if ($action === 'voir' && $id > 0) {
    $msg_detail = get_message($lienbd, $id);
    marquer_message($lienbd, $id, 1);
}

$titre_page = 'Admin — Messages';
$css_extra  = '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css">';

require __DIR__ . '/../../vues/admin/contact_vue.php';
