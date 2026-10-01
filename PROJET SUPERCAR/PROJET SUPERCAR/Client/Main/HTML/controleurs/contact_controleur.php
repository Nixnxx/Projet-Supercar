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

    // On met de côté ce que le visiteur vient de taper, AVANT les contrôles.
    // Comme on redirige en cas d'erreur, le contenu du formulaire est perdu :
    // la session sert à le faire passer d'une requête à l'autre. Il est effacé
    // dès qu'il a été relu (plus bas), et aussi en cas de succès.
    $_SESSION['contact_saisie'] = [
        'nom'     => $nom,
        'numero'  => $numero,
        'email'   => $email,
        'message' => $message,
    ];

    if ($nom === '' || $numero === '' || $email === '' || $message === '') {
        header('Location: contact.php?erreur=1');
        exit();
    }

    if (mb_strlen($nom) > 50 || mb_strlen($numero) > 20
        || mb_strlen($email) > 100 || mb_strlen($message) > 800) {
        header('Location: contact.php?erreur=2');
        exit();
    }
    // filter_var renvoie l'adresse si elle est valide, false sinon.
    // Le ! porte donc sur le RÉSULTAT de la fonction, pas sur $email.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: contact.php?erreur=3');
        exit();
    }

    if (ajouter_message($lienbd, $nom, $email, $message, $numero, $id_client)) {
        // Message enregistré : le formulaire doit repartir vide.
        unset($_SESSION['contact_saisie']);
        header('Location: contact.php?succes=1');
        exit();
    }
    else {
        header('Location: contact.php?erreur=4');
        exit();
    }
}

// ---- Ce qu'on va réafficher dans le formulaire ----
// On relit la saisie mise de côté plus haut, PUIS on l'efface aussitôt :
// elle ne doit servir qu'une seule fois. Sans ce unset, le visiteur
// retrouverait son ancien message la prochaine fois qu'il vient sur la page.
$saisie = $_SESSION['contact_saisie'] ?? [];
unset($_SESSION['contact_saisie']);

$message_erreur='';
if (isset($_GET['erreur'])) {
    switch ($_GET['erreur']) {
        case '1':
            $message_erreur = 'Tous les champs sont obligatoires.';
            break;
        case '2':
            $message_erreur = 'Un ou plusieurs champs dépassent la longueur maximale autorisée.';
            break;
        case '3':
            $message_erreur = 'L\'adresse e-mail n\'est pas valide.';
            break;
        case '4':
            $message_erreur = 'Une erreur est survenue lors de l\'envoi du message.';
            break;
        default:
            $message_erreur = 'Erreur inconnue.';
            break;
    }
}

// Le message a-t-il été envoyé ? (on revient ici avec ?succes=1 après
// l'enregistrement). C'est le contrôleur qui lit l'URL, pas la vue :
// la vue reçoit un simple vrai/faux et se contente de l'afficher.
$succes = isset($_GET['succes']);

$titre_page = 'SuperCar – Contactez-nous';

require __DIR__ . '/../vues/contact_vue.php';
