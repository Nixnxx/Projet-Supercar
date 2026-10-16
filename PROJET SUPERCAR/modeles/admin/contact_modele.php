<?php
// ============================================================
//  modeles/admin/contact_modele.php  —  MODÈLE ADMIN : messages
//  Réservé au back-office : lister, lire, marquer lu/non lu, supprimer
//  les messages, et modifier les coordonnées affichées sur le site.
//
//  La LECTURE partagée avec le site client (get_config_contact) reste
//  dans modeles/contact_modele.php, que le contrôleur admin inclut aussi.
//
//  Règles d'écriture : voir l'en-tête de modeles/voiture_modele.php.
// ============================================================

// Tous les messages, du plus récent au plus ancien.
function get_tous_messages($lienbd) {
    $sql = "SELECT * FROM contact ORDER BY id_contact DESC";
    $liste = mysqli_fetch_all(mysqli_query($lienbd, $sql), MYSQLI_ASSOC);
    return $liste ?: [];
}

// Les derniers messages (pour le tableau de bord).
function get_derniers_messages($lienbd, $limite = 5) {
    $sql = "SELECT * FROM contact ORDER BY id_contact DESC LIMIT ?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "i", $limite);
    mysqli_stmt_execute($stmt);
    $liste = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    return $liste ?: [];
}

// Statistiques : total, non lus, lus.
// Une requête d'agrégat renvoie TOUJOURS une ligne : pas de repli nécessaire.
function get_stats_messages($lienbd) {
    $sql = "SELECT COUNT(*) total, SUM(lu=0) non_lus, SUM(lu=1) lus FROM contact";
    $res = mysqli_query($lienbd, $sql);
    return mysqli_fetch_assoc($res);
}

// Un message précis.
function get_message($lienbd, $id) {
    $sql = "SELECT * FROM contact WHERE id_contact = ?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $ligne = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    return $ligne ?: null;
}

// Marque un message comme lu (1) ou non lu (0).
function marquer_message($lienbd, $id, $lu) {
    $sql = "UPDATE contact SET lu = ? WHERE id_contact = ?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $lu, $id);
    mysqli_stmt_execute($stmt);
}

// Supprime un message.
function supprimer_message($lienbd, $id) {
    $sql = "DELETE FROM contact WHERE id_contact = ?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

// Met à jour la configuration de contact.

function maj_config_contact($lienbd, $adresse, $email, $telephone, $map_embed,
                            $personne_nom, $personne_email, $personne_telephone) {
    $sql = "UPDATE contact_config
            SET adresse = ?, email = ?, telephone = ?, map_embed = ?,
                personne_nom = ?, personne_email = ?, personne_telephone = ?
            WHERE id_config = 1";

    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "sssssss",
        $adresse,
        $email,
        $telephone,
        $map_embed,
        $personne_nom,
        $personne_email,
        $personne_telephone
    );

    return mysqli_stmt_execute($stmt);
}

