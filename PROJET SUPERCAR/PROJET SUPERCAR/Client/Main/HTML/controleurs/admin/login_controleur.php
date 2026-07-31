<?php
// ============================================================
//  controleurs/admin/login_controleur.php  —  CONTRÔLEUR : connexion admin
//  Affiche le formulaire (GET) ET traite la connexion (POST).
//  Sécurité : le modèle ne renvoie QUE les comptes de niveau 'admin',
//  ce qui empêche un simple client de se connecter ici.
//  Appelé par ADMIN/logina.php.
// ============================================================

require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../../modeles/admin/auth_modele.php';

// Déjà connecté en admin ? On va au tableau de bord.
if (est_admin()) {
    header('Location: admin_dashboard.php');
    exit();
}

// ---- Traitement du formulaire ----
if (isset($_POST['utilisateur'], $_POST['motdepasse'])) {

    // On vérifie le jeton CSRF avant tout traitement.
    csrf_verifier();

    // Trop d'échecs récents : on refuse sans même regarder le mot de passe.
    if (connexion_bloquee()) {
        header('Location: logina.php?erreur=3');
        exit();
    }

    $admin    = trim($_POST['utilisateur']);
    $password = $_POST['motdepasse'];

    if ($admin === '' || $password === '') {
        header('Location: logina.php?erreur=2');
        exit();
    }

    // Le modèle filtre déjà sur niveau = 'admin'.
    $user = trouver_admin_par_login($lienbd, $admin);

    if ($user !== null && password_verify($password, $user['mot_de_passe'])) {

        // On change l'identifiant de session au moment où l'on gagne des
        // droits. Protection contre la FIXATION DE SESSION : si un pirate
        // avait imposé son identifiant de session à la victime, celui-ci
        // devient inutilisable. Le "true" supprime l'ancienne session.
        session_regenerate_id(true);

        // Connexion réussie : on remet le compteur d'échecs à zéro.
        reussite_connexion();

        $_SESSION['admin_connecte'] = true;
        $_SESSION['niveau']         = 'admin';
        $_SESSION['id_login']       = $user['id_login'];
        header('Location: admin_dashboard.php');
        exit();
    }

    // Mot de passe incorrect : on compte l'échec.
    echec_connexion();

    header('Location: logina.php?erreur=1');
    exit();
}

// Message d'erreur éventuel.
$erreur_msg = "";
if (isset($_GET['erreur'])) {
    if ($_GET['erreur'] == 1)      $erreur_msg = "Identifiant ou mot de passe incorrect.";
    elseif ($_GET['erreur'] == 2)  $erreur_msg = "Veuillez remplir tous les champs.";
    elseif ($_GET['erreur'] == 3)  $erreur_msg = "Trop de tentatives. Veuillez patienter 5 minutes.";
}

require __DIR__ . '/../../vues/admin/login_vue.php';
