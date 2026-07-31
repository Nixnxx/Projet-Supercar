<?php
// ============================================================
//  controleurs/admin/voitures_controleur.php  —  CONTRÔLEUR : voitures
//  Garde admin en premier. Les photos passent par upload_image().
//  Appelé par ADMIN/admin_voitures.php.
// ============================================================

require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../../includes/garde_admin.php';
require_once __DIR__ . '/menu_controleur.php';   // compteurs des pastilles du menu
require_once __DIR__ . '/../../modeles/voiture_modele.php';        // lecture partagée (get_voiture)
require_once __DIR__ . '/../../modeles/admin/voiture_modele.php';

$action = $_GET['action'] ?? '';
$id     = intval($_GET['id'] ?? 0);
$succes = $_GET['succes'] ?? '';

// Toutes les actions qui MODIFIENT la base passent par POST (ajout,
// modification, suppression). Une simple lecture (afficher la liste, voir
// un détail) se fait en GET et n'a pas besoin de jeton.
if (!empty($_POST)) {
    csrf_verifier();
}

// ---- Ajout d'une photo dans le slider (formulaire envoyé) ----
if (isset($_POST['add_photo'])) {
    $id_voiture_photo = intval($_POST['id_voiture_photo']);
    if (!empty($_FILES['nouvelle_photo']['name'])) {
        $chemin = upload_image($_FILES['nouvelle_photo'], DOSSIER_IMAGES);
        if ($chemin !== null) {
            ajouter_image_voiture($lienbd, $id_voiture_photo, $chemin, prochain_ordre_image($lienbd, $id_voiture_photo));
        }
    }
    header('Location: admin_voitures.php?action=detail&id=' . $id_voiture_photo . '&succes=photo_ajoutee');
    exit();
}

// ---- Modification d'une voiture (formulaire envoyé) ----
if (isset($_POST['set_voiture'])) {
    $nid       = intval($_POST['id_voiture']);
    $model     = trim($_POST['model']);
    $annee     = $_POST['annee'];
    $km        = intval($_POST['km']);
    $carburant = $_POST['type_carburant'];
    $prix      = intval($_POST['prix']);
    $specs     = trim($_POST['specs']);
    $id_marque = intval($_POST['id_marque']);
    modifier_voiture($lienbd, $nid, $model, $annee, $km, $carburant, $prix, $specs, $id_marque);
    header('Location: admin_voitures.php?succes=update');
    exit();
}

// ---- Ajout d'une voiture (formulaire envoyé) ----
if (isset($_POST['add_voiture'])) {
    $model     = trim($_POST['model']);
    $annee     = $_POST['annee'];
    $km        = intval($_POST['km']);
    $carburant = $_POST['type_carburant'];
    $prix      = intval($_POST['prix']);
    $specs     = trim($_POST['specs']);
    $id_marque = intval($_POST['id_marque']);

    // On enregistre chaque photo choisie (plusieurs photos possibles).
    $photos = [];
    if (!empty($_FILES['photos_slider']['name'][0])) {
        foreach ($_FILES['photos_slider']['name'] as $i => $nom) {
            if ($nom === '') {
                continue;
            }
            // On reconstruit une case $_FILES simple pour chaque photo.
            $fichier = [
                'name'     => $_FILES['photos_slider']['name'][$i],
                'tmp_name' => $_FILES['photos_slider']['tmp_name'][$i],
            ];
            $up = upload_image($fichier, DOSSIER_IMAGES);
            if ($up !== null) {
                $photos[] = $up;
            }
        }
    }

    // La 1re photo devient l'image principale.
    $image  = $photos[0] ?? '';
    $new_id = ajouter_voiture($lienbd, $model, $annee, $km, $carburant, $prix, $specs, $image, $id_marque);

    // Les autres photos vont dans le slider.
    foreach ($photos as $ordre => $chemin) {
        ajouter_image_voiture($lienbd, $new_id, $chemin, $ordre);
    }

    header('Location: admin_voitures.php?succes=ajoute');
    exit();
}

// ---- Suppression d'une photo du slider (formulaire envoyé) ----
if (isset($_POST['supprimer_photo'])) {
    $id_photo   = intval($_POST['id_photo_suppr']);
    $id_voiture = intval($_POST['id_voiture_photo_suppr']);
    if ($id_photo > 0) {
        supprimer_image_voiture($lienbd, $id_photo);
    }
    header('Location: admin_voitures.php?action=detail&id=' . $id_voiture . '&succes=photo_supprime');
    exit();
}

// ---- Suppression d'une voiture (formulaire envoyé) ----
if (isset($_POST['supprimer'])) {
    $id_suppr = intval($_POST['id_suppr']);
    if ($id_suppr > 0) {
        supprimer_voiture($lienbd, $id_suppr);
    }
    header('Location: admin_voitures.php?succes=supprime');
    exit();
}

// ---- Données pour l'affichage ----
$filtre_marque = isset($_GET['marque']) ? intval($_GET['marque']) : -1;
$voitures = get_voitures_admin($lienbd, $filtre_marque);
$marques  = get_marques($lienbd);

$detail        = ($action === 'detail' && $id > 0) ? get_voiture($lienbd, $id) : null;
$photos_slider = $detail ? get_images_voiture($lienbd, (int)$detail['id_voiture']) : [];

$titre_page = 'Admin — Voitures';

require __DIR__ . '/../../vues/admin/voitures_vue.php';
