<?php
// ============================================================
//  modeles/auth_modele.php  —  MODÈLE : connexion d'un CLIENT
//  La connexion d'un ADMINISTRATEUR est dans
//  modeles/admin/auth_modele.php : les deux ne doivent jamais se
//  mélanger, c'est ce qui garantit qu'un client ne peut pas entrer
//  dans le back-office.
// ============================================================

// Cherche un CLIENT à partir de son email.
// On joint la table login pour récupérer aussi le mot de passe.
function trouver_client_par_email($lienbd, $email) {
    $sql = "SELECT *
            FROM client
            JOIN login ON client.id_client = login.id_client
            WHERE client.email = ?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    // On renvoie la ligne, ou null si aucun compte trouvé.
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
//  On filtre systématiquement sur niveau = 'client'. La colonne login
//  n'étant pas unique en base, ce filtre évite de toucher un compte
//  administrateur par erreur. Pour un client, la colonne login contient
//  son adresse email : c'est bien ce que le formulaire envoie.
//
//  Les mêmes fonctions existent pour les administrateurs dans
//  modeles/admin/auth_modele.php, avec le suffixe _admin.
// ============================================================

// Renvoie true si ce compte client doit patienter avant de réessayer.
function connexion_bloquee_client($lienbd, $email) {
    // L'écart de temps est calculé par MySQL (TIMESTAMPDIFF), jamais en
    // comparant à l'horloge PHP : les deux peuvent tourner sur des fuseaux
    // horaires différents (vérifié sur ce projet : PHP est en UTC, MySQL
    // en heure locale, 4h d'écart — comparer time() à derniere_tentative
    // aurait bloqué un compte pendant 4h au lieu de 5 minutes).
    $sql = "SELECT tentatives_echouees,
                   TIMESTAMPDIFF(SECOND, derniere_tentative, NOW()) AS secondes_ecoulees
            FROM login
            WHERE login = ? AND niveau = 'client'";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $ligne = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    // Compte inconnu, ou aucun échec enregistré : rien à bloquer.
    if (!$ligne || (int) $ligne['tentatives_echouees'] === 0) {
        return false;
    }

    // Le délai de 5 minutes (300 secondes) est écoulé : on repart à zéro.
    if ((int) $ligne['secondes_ecoulees'] >= 300) {
        reussite_connexion_client($lienbd, $email);
        return false;
    }

    return (int) $ligne['tentatives_echouees'] >= 5;
}

// À appeler après un mot de passe incorrect.
function echec_connexion_client($lienbd, $email) {
    $sql = "UPDATE login
            SET tentatives_echouees = tentatives_echouees + 1, derniere_tentative = NOW()
            WHERE login = ? AND niveau = 'client'";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
}

// À appeler après une connexion réussie : on remet le compteur à zéro.
function reussite_connexion_client($lienbd, $email) {
    $sql = "UPDATE login SET tentatives_echouees = 0 WHERE login = ? AND niveau = 'client'";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
}
