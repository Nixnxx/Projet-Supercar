<?php
// ============================================================
//  modeles/admin/auth_modele.php  —  MODÈLE ADMIN : connexion
//  Recherche d'un compte ADMINISTRATEUR uniquement.
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
