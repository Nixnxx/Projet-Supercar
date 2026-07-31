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
