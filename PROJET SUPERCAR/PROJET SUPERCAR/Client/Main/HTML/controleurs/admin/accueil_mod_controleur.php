<?php
// ============================================================
//  controleurs/admin/accueil_mod_controleur.php  —  CONTRÔLEUR :
//  ajout / modification d'un élément de l'accueil.
//   - "table" (GET) : carousel | hero | hero_image | point | stat
//   - "id"    (GET) : présent = modification ; absent/0 = ajout
//  Garde admin en premier. Enregistre les images via upload_image().
//  Appelé par ADMIN/accueil_mod.php.
// ============================================================

require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../../includes/garde_admin.php';
require_once __DIR__ . '/../../modeles/accueil_modele.php';

$table = $_GET['table'] ?? '';
$id    = intval($_GET['id'] ?? 0);

// En modification, on charge les données existantes pour pré-remplir le formulaire.
$donnees = ($id > 0) ? accueil_get_ligne($lienbd, $table, $id) : [];

// ---- Enregistrement (formulaire envoyé) ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($table === 'carousel') {
        $titre      = trim($_POST['titre']);
        $desc       = trim($_POST['description']);
        $lien       = trim($_POST['lien']);
        $texte_lien = trim($_POST['texte_lien']);
        $ordre      = intval($_POST['ordre']);
        $actif      = isset($_POST['actif']) ? 1 : 0;

        // On garde l'image existante, sauf si une nouvelle (valide) est envoyée.
        $image = $donnees['image'] ?? '';
        if (!empty($_FILES['image']['name'])) {
            $up = upload_image($_FILES['image'], DOSSIER_IMAGES);
            if ($up !== null) $image = $up;
        }

        carousel_enregistrer($lienbd, $id, $titre, $desc, $image, $lien, $texte_lien, $ordre, $actif);
        header("Location: accueil.php?msg=ok#carrousel");
        exit();
    }

    if ($table === 'hero') {
        $titre      = trim($_POST['titre']);
        $sous_titre = trim($_POST['sous_titre']);
        $desc       = trim($_POST['description']);
        $texte      = trim($_POST['texte_cta']);
        $lien       = trim($_POST['lien_cta']);
        hero_modifier($lienbd, $id, $titre, $sous_titre, $desc, $texte, $lien);
        header("Location: accueil.php?msg=ok#hero");
        exit();
    }

    if ($table === 'hero_image') {
        $alt   = trim($_POST['alt']);
        $ordre = intval($_POST['ordre']);
        $actif = isset($_POST['actif']) ? 1 : 0;

        $image = $donnees['image'] ?? '';
        if (!empty($_FILES['image']['name'])) {
            $up = upload_image($_FILES['image'], DOSSIER_IMAGES);
            if ($up !== null) $image = $up;
        }

        hero_image_enregistrer($lienbd, $id, $image, $alt, $ordre, $actif);
        header("Location: accueil.php?msg=ok#images");
        exit();
    }

    if ($table === 'point') {
        $texte = trim($_POST['texte']);
        $ordre = intval($_POST['ordre']);
        $actif = isset($_POST['actif']) ? 1 : 0;
        point_enregistrer($lienbd, $id, $texte, $ordre, $actif);
        header("Location: accueil.php?msg=ok#points");
        exit();
    }

    if ($table === 'stat') {
        $valeur = trim($_POST['valeur']);
        $label  = trim($_POST['label']);
        $ordre  = intval($_POST['ordre']);
        $actif  = isset($_POST['actif']) ? 1 : 0;
        stat_enregistrer($lienbd, $id, $valeur, $label, $ordre, $actif);
        header("Location: accueil.php?msg=ok#stats");
        exit();
    }
}

// Titre affiché selon l'action.
$titre_form = ($id > 0) ? "Modifier" : "Ajouter";

require __DIR__ . '/../../vues/admin/accueil_form_vue.php';
