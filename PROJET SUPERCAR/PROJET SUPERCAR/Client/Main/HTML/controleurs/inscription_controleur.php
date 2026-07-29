<?php
// ============================================================
//  controleurs/inscription_controleur.php  —  CONTRÔLEUR : inscription
//  Affiche le formulaire (GET) ET crée le compte (POST).
//  Validations : email valide + mot de passe d'au moins 8 caractères.
//  Appelé par inscription.php.
// ============================================================

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../modeles/client_modele.php';

// Déjà connecté ? On renvoie à l'accueil.
if (est_connecte()) {
    header('Location: index.php');
    exit();
}

$succes = false;

// ---- Traitement du formulaire d'inscription ----
if (isset($_POST['nom'], $_POST['prenom'], $_POST['email'],
          $_POST['telephone'], $_POST['adresse'], $_POST['motdepasse'])) {

    // On vérifie le jeton CSRF avant tout traitement.
    csrf_verifier();

    $nom       = trim($_POST['nom']);
    $prenom    = trim($_POST['prenom']);
    $email     = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);
    $adresse   = trim($_POST['adresse']);
    $mdp_clair = $_POST['motdepasse'];

    // Validation 0 : la case "politique de confidentialité" doit être cochée.
    // La case n'est envoyée que si elle est cochée (sinon $_POST['politique'] absent).
    if (!isset($_POST['politique'])) {
        header('Location: inscription.php?erreur=5');
        exit();
    }
    // Validation 1 : format de l'email.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: inscription.php?erreur=3');
        exit();
    }
    // Validation 2 : longueur du mot de passe.
    if (strlen($mdp_clair) < MDP_LONGUEUR_MIN) {
        header('Location: inscription.php?erreur=4');
        exit();
    }
    // Validation 3 : email pas déjà utilisé.
    if (email_existe($lienbd, $email)) {
        header('Location: inscription.php?erreur=1');
        exit();
    }

    // Création du client puis de son compte de connexion.
    $mdp_hash  = password_hash($mdp_clair, PASSWORD_DEFAULT);
    $id_client = creer_client($lienbd, $nom, $prenom, $email, $telephone, $adresse);

    if ($id_client !== false && creer_login($lienbd, $email, $mdp_hash, $id_client)) {
        $succes = true;
    } else {
        header('Location: inscription.php?erreur=2');
        exit();
    }
}

// Message d'erreur éventuel.
$erreur_msg = "";
if (isset($_GET['erreur'])) {
    switch ($_GET['erreur']) {
        case 1: $erreur_msg = "L'adresse e-mail est déjà utilisée. Veuillez en choisir une autre."; break;
        case 2: $erreur_msg = "Erreur lors de l'inscription : veuillez réessayer."; break;
        case 3: $erreur_msg = "L'adresse e-mail saisie n'est pas valide."; break;
        case 4: $erreur_msg = "Le mot de passe doit contenir au moins " . MDP_LONGUEUR_MIN . " caractères."; break;
        case 5: $erreur_msg = "Vous devez accepter la politique de confidentialité."; break;
    }
}

require __DIR__ . '/../vues/inscription_vue.php';
