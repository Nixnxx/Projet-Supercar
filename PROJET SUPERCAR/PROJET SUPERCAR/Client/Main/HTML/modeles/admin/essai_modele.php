<?php
// ============================================================
//  modeles/admin/essai_modele.php  —  MODÈLE ADMIN : demandes d'essai
//  Réservé au back-office : lister, filtrer, consulter le détail,
//  changer le statut et supprimer les demandes.
//
//  Règles d'écriture : voir l'en-tête de modeles/voiture_modele.php.
// ============================================================

// Liste des demandes (avec infos client et voiture).
// $filtre = -1 : toutes ; sinon on filtre sur le statut.
// Les deux requêtes sont écrites en entier (plutôt qu'assemblées bout à bout) :
// c'est le même découpage que get_voitures_admin(), et chaque requête reste
// lisible d'un seul coup d'œil.
function get_essais_admin($lienbd, $filtre = -1) {
    if ($filtre >= 0) {
        $sql = "SELECT d.*, v.model, c.nom, c.prenom, c.email, c.telephone
                FROM demandeessai d
                JOIN voiture v ON v.id_voiture = d.id_voiture
                JOIN client  c ON c.id_client  = d.id_client
                WHERE d.statut = ?
                ORDER BY d.id_demande DESC";
        $stmt = mysqli_prepare($lienbd, $sql);
        mysqli_stmt_bind_param($stmt, "i", $filtre);
    } else {
        $sql = "SELECT d.*, v.model, c.nom, c.prenom, c.email, c.telephone
                FROM demandeessai d
                JOIN voiture v ON v.id_voiture = d.id_voiture
                JOIN client  c ON c.id_client  = d.id_client
                ORDER BY d.id_demande DESC";
        $stmt = mysqli_prepare($lienbd, $sql);
    }
    mysqli_stmt_execute($stmt);
    $liste = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    return $liste ?: [];
}

// Les dernières demandes (tableau de bord).
function get_derniers_essais($lienbd, $limite = 5) {
    $sql = "SELECT d.*, v.model, c.nom, c.prenom
            FROM demandeessai d
            JOIN voiture v ON v.id_voiture = d.id_voiture
            JOIN client  c ON c.id_client  = d.id_client
            ORDER BY d.id_demande DESC LIMIT ?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "i", $limite);
    mysqli_stmt_execute($stmt);
    $liste = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    return $liste ?: [];
}

// Détail d'une demande.
function get_essai_detail($lienbd, $id) {
    $sql = "SELECT d.*, v.model, c.nom, c.prenom, c.email, c.telephone
            FROM demandeessai d
            JOIN voiture v ON v.id_voiture = d.id_voiture
            JOIN client  c ON c.id_client  = d.id_client
            WHERE d.id_demande = ?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $ligne = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    return $ligne ?: null;
}

// Statistiques : total et nombre en attente.
// Une requête d'agrégat renvoie TOUJOURS une ligne : pas de repli nécessaire.
function get_stats_essais($lienbd) {
    $sql = "SELECT COUNT(*) total, SUM(statut=0) en_attente FROM demandeessai";
    $res = mysqli_query($lienbd, $sql);
    return mysqli_fetch_assoc($res);
}

// Change le statut et le commentaire d'une demande.
// Synchronise aussi la colonne voiture.disponible :
//  - passage à 1 (Confirmé) → la voiture devient indisponible (0)
//  - passage à 3 (Terminé)  → la voiture redevient disponible  (1)
function maj_statut_essai($lienbd, $id, $statut, $commentaire) {
    $sql = "UPDATE demandeessai SET statut = ?, commentaire = ? WHERE id_demande = ?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "isi", $statut, $commentaire, $id);
    mysqli_stmt_execute($stmt);

    if ($statut == 1 || $statut == 3) {
        $sql = "SELECT id_voiture FROM demandeessai WHERE id_demande = ?";
        $stmt = mysqli_prepare($lienbd, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $demande = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

        if ($demande) {
            $disponible = ($statut == 3) ? 1 : 0;
            $sql = "UPDATE voiture SET disponible = ? WHERE id_voiture = ?";
            $stmt = mysqli_prepare($lienbd, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $disponible, $demande['id_voiture']);
            mysqli_stmt_execute($stmt);
        }
    }
}

// Supprime une demande d'essai.
// Si elle était "Confirmée" (statut 1), la voiture redevient disponible
// avant la suppression (sinon elle resterait bloquée indéfiniment).
function supprimer_essai($lienbd, $id) {
    $sql = "SELECT statut, id_voiture FROM demandeessai WHERE id_demande = ?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $demande = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if ($demande && (int) $demande['statut'] === 1) {
        $sql = "UPDATE voiture SET disponible = 1 WHERE id_voiture = ?";
        $stmt = mysqli_prepare($lienbd, $sql);
        mysqli_stmt_bind_param($stmt, "i", $demande['id_voiture']);
        mysqli_stmt_execute($stmt);
    }

    $sql = "DELETE FROM demandeessai WHERE id_demande = ?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}
