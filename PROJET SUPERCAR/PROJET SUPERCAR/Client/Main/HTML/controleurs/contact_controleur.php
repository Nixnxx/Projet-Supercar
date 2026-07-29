<?php
// ============================================================
//  controleurs/contact_controleur.php  —  CONTRÔLEUR : contact
//  Un visiteur NON CONNECTÉ peut envoyer un message (id_client = NULL).
//  Appelé par contact.php.
// ============================================================

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../modeles/client_modele.php';
require_once __DIR__ . '/../modeles/contact_modele.php';

// Si le visiteur est connecté, on pré-remplit avec ses infos.
$client = est_connecte() ? get_client($lienbd, (int)$_SESSION['id_client']) : [];

// Configuration de contact (adresse, carte, etc.) affichée sur la page.
$config = get_config_contact($lienbd);

// ---- Traitement du formulaire ----
if (isset($_POST['nom'], $_POST['numero'], $_POST['email'], $_POST['message'])) {

    // On vérifie le jeton CSRF avant tout traitement.
    csrf_verifier();

    $nom     = trim($_POST['nom']);
    $numero  = trim($_POST['numero']);
    $email   = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Connecté => on rattache le message au client ; sinon => NULL (message anonyme).
    $id_client = est_connecte() ? (int)$_SESSION['id_client'] : null;

    if (ajouter_message($lienbd, $nom, $email, $message, $numero, $id_client)) {
        header('Location: contact.php?succes=1');
        exit();
    }
}

// Le message a-t-il été envoyé ? (on revient ici avec ?succes=1 après
// l'enregistrement). C'est le contrôleur qui lit l'URL, pas la vue :
// la vue reçoit un simple vrai/faux et se contente de l'afficher.
$succes = isset($_GET['succes']);

$titre_page = 'SuperCar – Contactez-nous';

require __DIR__ . '/../vues/contact_vue.php';
