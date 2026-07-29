<?php
// ============================================================
//  controleurs/admin/services_controleur.php  —  CONTRÔLEUR : services
//  Garde admin en premier. Les images passent par upload_image().
//  Appelé par ADMIN/admin_services.php.
// ============================================================

require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../../includes/garde_admin.php';
require_once __DIR__ . '/menu_controleur.php';   // compteurs des pastilles du menu
require_once __DIR__ . '/../../modeles/service_modele.php';

$action = $_GET['action'] ?? '';
$id     = intval($_GET['id'] ?? 0);
$succes = $_GET['succes'] ?? '';

// ---- Modification (formulaire envoyé) ----
if (isset($_POST['set_service'])) {
    $nid    = intval($_POST['id_service']);
    $nom    = trim($_POST['nom']);
    $desc   = trim($_POST['description']);
    $icone  = trim($_POST['icone']);
    $tag    = trim($_POST['tag']);
    $numero = intval($_POST['numero']);

    // Image : null = on ne change pas ; '' = on retire ; chemin = on remplace.
    $nouvelle_image = null;
    if (!empty($_FILES['image']['name'])) {
        $up = upload_image($_FILES['image'], DOSSIER_IMAGES_SERVICES);
        if ($up !== null) {
            $nouvelle_image = $up;
        }
    } elseif (isset($_POST['remove_image'])) {
        $nouvelle_image = '';
    }

    modifier_service($lienbd, $nid, $nom, $desc, $icone, $tag, $numero, $nouvelle_image);
    header('Location: admin_services.php?succes=update');
    exit();
}

// ---- Ajout (formulaire envoyé) ----
if (isset($_POST['add_service'])) {
    $nom    = trim($_POST['nom'] ?? '');
    $desc   = trim($_POST['description'] ?? '');
    $icone  = trim($_POST['icone'] ?? 'bi-tools');
    $tag    = trim($_POST['tag'] ?? '');
    $numero = intval($_POST['numero'] ?? 0);

    $chemin = '';
    if (!empty($_FILES['image']['name'])) {
        $up = upload_image($_FILES['image'], DOSSIER_IMAGES_SERVICES);
        if ($up !== null) {
            $chemin = $up;
        }
    }

    ajouter_service($lienbd, $nom, $desc, $chemin, $icone, $tag, $numero);
    header('Location: admin_services.php?succes=ajoute');
    exit();
}

// ---- Suppression (lien) ----
if ($action === 'supprimer' && $id > 0) {
    supprimer_service($lienbd, $id);
    header('Location: admin_services.php?succes=supprime');
    exit();
}

// ---- Affichage ----
$services = get_services($lienbd);
$detail   = ($action === 'detail' && $id > 0) ? get_service($lienbd, $id) : null;

$titre_page = 'Admin — Services';

require __DIR__ . '/../../vues/admin/services_vue.php';
