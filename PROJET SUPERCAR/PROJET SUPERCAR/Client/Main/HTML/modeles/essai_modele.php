<?php
// ============================================================
//  modeles/essai_modele.php  —  MODÈLE : demandes d'essai
//  Côté client : créer une demande.
//  Côté admin  : lister, filtrer, changer le statut, supprimer.
// ============================================================

// Enregistre une nouvelle demande d'essai (statut 0 = en attente).
function creer_demande_essai($lienbd, $date_demande, $date_essai, $id_client, $id_voiture) {
    $sql = "INSERT INTO demandeessai
            (date_demande, date_essai_proposee, statut, commentaire, id_client, id_voiture)
            VALUES (?, ?, 0, 'Demande via site', ?, ?)";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "ssii", $date_demande, $date_essai, $id_client, $id_voiture);
    return mysqli_stmt_execute($stmt);
}

// ---------- Côté admin ----------

// Liste des demandes (avec infos client et voiture).
// $filtre = -1 : toutes ; sinon on filtre sur le statut.
function get_essais_admin($lienbd, $filtre = -1) {
    $base = "SELECT d.*, v.model, c.nom, c.prenom, c.email, c.telephone
             FROM demandeessai d
             JOIN voiture v ON v.id_voiture = d.id_voiture
             JOIN client  c ON c.id_client  = d.id_client";
    if ($filtre >= 0) {
        $stmt = mysqli_prepare($lienbd, $base . " WHERE d.statut = ? ORDER BY d.id_demande DESC");
        mysqli_stmt_bind_param($stmt, "i", $filtre);
    } else {
        $stmt = mysqli_prepare($lienbd, $base . " ORDER BY d.id_demande DESC");
    }
    mysqli_stmt_execute($stmt);
    $liste = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    return $liste ?: [];
}

// Les dernières demandes (tableau de bord).
function get_derniers_essais($lienbd, $limite = 5) {
    $stmt = mysqli_prepare($lienbd,
        "SELECT d.*, v.model, c.nom, c.prenom
         FROM demandeessai d
         JOIN voiture v ON v.id_voiture = d.id_voiture
         JOIN client  c ON c.id_client  = d.id_client
         ORDER BY d.id_demande DESC LIMIT ?");
    mysqli_stmt_bind_param($stmt, "i", $limite);
    mysqli_stmt_execute($stmt);
    $liste = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    return $liste ?: [];
}

// Détail d'une demande.
function get_essai_detail($lienbd, $id) {
    $stmt = mysqli_prepare($lienbd,
        "SELECT d.*, v.model, c.nom, c.prenom, c.email, c.telephone
         FROM demandeessai d
         JOIN voiture v ON v.id_voiture = d.id_voiture
         JOIN client  c ON c.id_client  = d.id_client
         WHERE d.id_demande = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $ligne = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    return $ligne ?: null;
}

// Statistiques : total et nombre en attente.
function get_stats_essais($lienbd) {
    $res = mysqli_query($lienbd,
        "SELECT COUNT(*) total, SUM(statut=0) en_attente FROM demandeessai");
    return mysqli_fetch_assoc($res);
}

// Change le statut et le commentaire d'une demande.
// Synchronise aussi la colonne voiture.disponible :
//  - passage à 1 (Confirmé) → la voiture devient indisponible (0)
//  - passage à 3 (Terminé)  → la voiture redevient disponible  (1)
function maj_statut_essai($lienbd, $id, $statut, $commentaire) {
    $stmt = mysqli_prepare($lienbd,
        "UPDATE demandeessai SET statut = ?, commentaire = ? WHERE id_demande = ?");
    mysqli_stmt_bind_param($stmt, "isi", $statut, $commentaire, $id);
    mysqli_stmt_execute($stmt);

    if ($statut == 1 || $statut == 3) {
        $stmt = mysqli_prepare($lienbd, "SELECT id_voiture FROM demandeessai WHERE id_demande = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $demande = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

        if ($demande) {
            $disponible = ($statut == 3) ? 1 : 0;
            $stmt = mysqli_prepare($lienbd, "UPDATE voiture SET disponible = ? WHERE id_voiture = ?");
            mysqli_stmt_bind_param($stmt, "ii", $disponible, $demande['id_voiture']);
            mysqli_stmt_execute($stmt);
        }
    }
}

// Supprime une demande d'essai.
// Si elle était "Confirmée" (statut 1), la voiture redevient disponible
// avant la suppression (sinon elle resterait bloquée indéfiniment).
function supprimer_essai($lienbd, $id) {
    $stmt = mysqli_prepare($lienbd, "SELECT statut, id_voiture FROM demandeessai WHERE id_demande = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $demande = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if ($demande && (int) $demande['statut'] === 1) {
        $stmt = mysqli_prepare($lienbd, "UPDATE voiture SET disponible = 1 WHERE id_voiture = ?");
        mysqli_stmt_bind_param($stmt, "i", $demande['id_voiture']);
        mysqli_stmt_execute($stmt);
    }

    $stmt = mysqli_prepare($lienbd, "DELETE FROM demandeessai WHERE id_demande = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}
