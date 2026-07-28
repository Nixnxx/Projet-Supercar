<?php
// ============================================================
//  modeles/auth_modele.php  —  MODÈLE : connexion
//  Requêtes pour connecter un client ou un administrateur.
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
