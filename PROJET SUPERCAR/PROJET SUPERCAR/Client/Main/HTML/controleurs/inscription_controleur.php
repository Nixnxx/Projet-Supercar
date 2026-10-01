<?php
// ============================================================
//  controleurs/inscription_controleur.php  —  CONTRÔLEUR : inscription
//  Affiche le formulaire (GET) ET crée le compte (POST).
//  Les contrôles sont faits dans cet ordre, du moins coûteux au plus
//  coûteux : champs remplis, longueurs, case cochée, format de l'email,
//  mot de passe (longueur puis confirmation), et seulement en dernier
//  l'email déjà utilisé — c'est le seul qui interroge la base.
//  Appelé par inscription.php.
// ============================================================

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../modeles/client_modele.php';

// Déjà connecté ? On renvoie à l'accueil.
if (est_connecte()) {
    header('Location: index.php');
    exit();
}

// ---- Traitement du formulaire d'inscription ----
if (isset($_POST['nom'], $_POST['prenom'], $_POST['email'],
          $_POST['telephone'], $_POST['adresse'], $_POST['motdepasse'], $_POST['motdepasse_confirmation'])) {

    // On vérifie le jeton CSRF avant tout traitement.
    csrf_verifier();

    $nom       = trim($_POST['nom']);
    $prenom    = trim($_POST['prenom']);
    $email     = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);
    $adresse   = trim($_POST['adresse']);
    $mdp_clair1 = $_POST['motdepasse'];
    $mdp_clair2 = $_POST['motdepasse_confirmation'];

    // Validation 1 : aucun champ ne doit être vide.
    // Le "required" du formulaire ne suffit pas : il se contourne en
    // envoyant la requête sans passer par la page.
    if ($nom === '' || $prenom === '' || $email === '' || $telephone === ''
        || $adresse === '' || $mdp_clair1 === '' || $mdp_clair2 === '') {
        header('Location: inscription.php?erreur=7');
        exit();
    }

    // Validation 2 : longueurs maximales des colonnes de la table client.
    // mb_strlen() compte les CARACTÈRES et non les octets : en UTF-8 un « é »
    // occupe 2 octets, strlen() refuserait donc à tort un nom accentué.
    if (mb_strlen($nom) > 50 || mb_strlen($prenom) > 50
        || mb_strlen($email) > 100 || mb_strlen($telephone) > 20
        || mb_strlen($adresse) > 100) {
        header('Location: inscription.php?erreur=8');
        exit();
    }

    // Validation 3 : la case "politique de confidentialité" doit être cochée.
    // La case n'est envoyée que si elle est cochée (sinon $_POST['politique'] absent).
    if (!isset($_POST['politique'])) {
        header('Location: inscription.php?erreur=5');
        exit();
    }

    // Validation 4 : format de l'email.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: inscription.php?erreur=3');
        exit();
    }

    // Validation 5 : longueur du mot de passe.
    if (mb_strlen($mdp_clair1) < MDP_LONGUEUR_MIN) {
        header('Location: inscription.php?erreur=4');
        exit();
    }

    // Validation 6 : les deux mots de passe doivent correspondre.
    if ($mdp_clair1 !== $mdp_clair2) {
        header('Location: inscription.php?erreur=6');
        exit();
    }

    // Validation 7 : email pas déjà utilisé.
    // Placée en dernier car c'est la seule qui interroge la base : inutile
    // de faire une requête si la saisie est déjà refusée plus haut.
    if (email_existe($lienbd, $email)) {
        header('Location: inscription.php?erreur=1');
        exit();
    }

    // Création du client puis de son compte de connexion.
    $mdp_hash  = password_hash($mdp_clair1, PASSWORD_DEFAULT);
    $id_client = creer_client($lienbd, $nom, $prenom, $email, $telephone, $adresse);

    if ($id_client !== false && creer_login($lienbd, $email, $mdp_hash, $id_client)) {
        // On redirige au lieu d'afficher directement : sans ça, recharger la
        // page renverrait le formulaire et le visiteur verrait « email déjà
        // utilisé » juste après avoir créé son compte.
        header('Location: inscription.php?succes=1');
        exit();
    } else {
        header('Location: inscription.php?erreur=2');
        exit();
    }
}

// Le compte vient-il d'être créé ? (on revient ici avec ?succes=1 après
// l'enregistrement). C'est le contrôleur qui lit l'URL, pas la vue.
$succes = isset($_GET['succes']);

// Message d'erreur éventuel.
$erreur_msg = "";
if (isset($_GET['erreur'])) {
    switch ($_GET['erreur']) {
        case 1: $erreur_msg = "L'adresse e-mail est déjà utilisée. Veuillez en choisir une autre."; break;
        case 2: $erreur_msg = "Erreur lors de l'inscription : veuillez réessayer."; break;
        case 3: $erreur_msg = "L'adresse e-mail saisie n'est pas valide."; break;
        case 4: $erreur_msg = "Le mot de passe doit contenir au moins " . MDP_LONGUEUR_MIN . " caractères."; break;
        case 5: $erreur_msg = "Vous devez accepter la politique de confidentialité."; break;
        case 6: $erreur_msg = "Les mots de passe ne correspondent pas."; break;
    
    case 7: $erreur_msg = "Veuillez remplir tous les champs."; break;
    case 8: $erreur_msg = "Un des champs dépasse la longueur autorisée."; break;
    }
}

require __DIR__ . '/../vues/inscription_vue.php';
