<?php
// ============================================================
//  modeles/admin/auth_modele.php  —  MODÈLE ADMIN : connexion
//  Recherche d'un compte ADMINISTRATEUR, et limitation des tentatives
//  de connexion (protection contre le brute force).
//
//  Règles d'écriture : voir l'en-tête de modeles/voiture_modele.php.
// ============================================================

// Cherche un ADMINISTRATEUR à partir de son login.
// IMPORTANT : on filtre sur niveau = 'admin'. Sans ce filtre, un simple
// client pouvait se connecter à l'espace admin (c'était la grosse faille).
function trouver_admin_par_login($lienbd, $login) {
    $sql = "SELECT * FROM login WHERE login = ? AND niveau = 'admin'";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "s", $login);
    mysqli_stmt_execute($stmt);
    $ligne = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    return $ligne ?: null;
}

// ============================================================
//  LIMITATION DES TENTATIVES DE CONNEXION
//
//  Sans limite, un programme peut essayer des milliers de mots de
//  passe par minute. On bloque donc 5 minutes après 5 échecs.
//
//  Le compteur est stocké en base (colonnes tentatives_echouees et
//  derniere_tentative de la table login), pas en session : il est donc
//  attaché au COMPTE, pas au navigateur. Vider ses cookies ou changer
//  de navigateur ne remet plus le compteur à zéro.
//
//  On filtre systématiquement sur niveau = 'admin', comme le fait déjà
//  trouver_admin_par_login() : la colonne login n'étant pas unique en
//  base, ce filtre évite de toucher un compte client par erreur.
//
//  Les mêmes fonctions existent pour les clients dans
//  modeles/auth_modele.php, avec le suffixe _client.
// ============================================================

// Renvoie true si ce compte admin doit patienter avant de réessayer.
function connexion_bloquee_admin($lienbd, $login) {
    // L'écart de temps est calculé par MySQL (TIMESTAMPDIFF), jamais en
    // comparant à l'horloge PHP : les deux peuvent tourner sur des fuseaux
    // horaires différents (vérifié sur ce projet : PHP est en UTC, MySQL
    // en heure locale, 4h d'écart — comparer time() à derniere_tentative
    // aurait bloqué un compte pendant 4h au lieu de 5 minutes).
    $sql = "SELECT tentatives_echouees,
                   TIMESTAMPDIFF(SECOND, derniere_tentative, NOW()) AS secondes_ecoulees
            FROM login
            WHERE login = ? AND niveau = 'admin'";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "s", $login);
    mysqli_stmt_execute($stmt);
    $ligne = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    // Compte inconnu, ou aucun échec enregistré : rien à bloquer.
    if (!$ligne || (int) $ligne['tentatives_echouees'] === 0) {
        return false;
    }

    // Le délai de 5 minutes (300 secondes) est écoulé : on repart à zéro.
    if ((int) $ligne['secondes_ecoulees'] >= 300) {
        reussite_connexion_admin($lienbd, $login);
        return false;
    }

    return (int) $ligne['tentatives_echouees'] >= 5;
}

// À appeler après un mot de passe incorrect.
function echec_connexion_admin($lienbd, $login) {
    $sql = "UPDATE login
            SET tentatives_echouees = tentatives_echouees + 1, derniere_tentative = NOW()
            WHERE login = ? AND niveau = 'admin'";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "s", $login);
    mysqli_stmt_execute($stmt);
}

// À appeler après une connexion réussie : on remet le compteur à zéro.
function reussite_connexion_admin($lienbd, $login) {
    $sql = "UPDATE login SET tentatives_echouees = 0 WHERE login = ? AND niveau = 'admin'";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "s", $login);
    mysqli_stmt_execute($stmt);
}
