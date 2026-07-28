<?php
// ============================================================
//  controleurs/connexion_controleur.php  —  CONTRÔLEUR : connexion client
//  Affiche le formulaire (GET) ET traite la connexion (POST).
//  Appelé par connexion.php.
// ============================================================

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../modeles/auth_modele.php';

// Déjà connecté ? On renvoie à l'accueil.
if (est_connecte()) {
    header('Location: index.php');
    exit();
}

// ---- Traitement du formulaire de connexion ----
if (isset($_POST['utilisateur'], $_POST['motdepasse'])) {
    $utilisateur = trim($_POST['utilisateur']);
    $password    = $_POST['motdepasse'];

    if ($utilisateur === '' || $password === '') {
        header('Location: connexion.php?erreur=2');
        exit();
    }

    // La case "politique de confidentialité" doit être cochée.
    if (!isset($_POST['politique'])) {
        header('Location: connexion.php?erreur=3');
        exit();
    }

    $user = trouver_client_par_email($lienbd, $utilisateur);

    if ($user !== null && password_verify($password, $user['mot_de_passe'])) {
        // Connexion réussie : on retient le client dans la session.
        $_SESSION['connecte']        = 1;
        $_SESSION['id_client']       = $user['id_client'];
        $_SESSION['client_connecte'] = true;
        // On garde aussi le nom et le prénom pour afficher "Bienvenue ..."
        // dans l'en-tête, sans avoir à refaire une requête à chaque page.
        $_SESSION['client_nom']      = $user['nom'];
        $_SESSION['client_prenom']   = $user['prenom'];

        // Reprise d'une action mise en attente avant la connexion.
        if (isset($_SESSION['essai_en_attente'])) {
            $params = [];
            if (isset($_SESSION['essai_id_marque']))  $params[] = 'id_marque=' . (int)$_SESSION['essai_id_marque'];
            if (isset($_SESSION['essai_id_voiture'])) $params[] = 'voiture='   . (int)$_SESSION['essai_id_voiture'];
            $query = count($params) > 0 ? '?' . implode('&', $params) : '';
            unset($_SESSION['essai_en_attente'], $_SESSION['essai_id_marque'], $_SESSION['essai_id_voiture']);
            header('Location: essai.php' . $query);
            exit();
        } elseif (isset($_SESSION['contact_en_attente'])) {
            unset($_SESSION['contact_en_attente']);
            header('Location: contact.php');
            exit();
        }

        header('Location: index.php');
        exit();
    }

    // Identifiants incorrects.
    header('Location: connexion.php?erreur=1');
    exit();
}

// Message d'erreur éventuel à afficher.
$erreur_msg = "";
if (isset($_GET['erreur'])) {
    switch ($_GET['erreur']) {
        case 1: $erreur_msg = "Identifiant ou mot de passe incorrect."; break;
        case 2: $erreur_msg = "Veuillez remplir tous les champs."; break;
        case 3: $erreur_msg = "Vous devez accepter la politique de confidentialité."; break;
    }
}

require __DIR__ . '/../vues/connexion_vue.php';
