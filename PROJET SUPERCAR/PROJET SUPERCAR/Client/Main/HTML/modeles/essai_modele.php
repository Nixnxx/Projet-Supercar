<?php
// ============================================================
//  modeles/essai_modele.php  —  MODÈLE : demandes d'essai
//  CÔTÉ CLIENT : déposer une demande d'essai depuis le site.
//  Tout le SUIVI des demandes (lister, filtrer, changer le statut,
//  supprimer) est réservé au back-office et se trouve dans
//  modeles/admin/essai_modele.php.
// ============================================================

// Enregistre une nouvelle demande d'essai (statut 0 = en attente).
function creer_demande_essai($lienbd, $date_demande, $date_essai_proposee, $heure_souhaitee, $id_client, $id_voiture)
{
    $sql = "INSERT INTO demandeessai
            (date_demande, date_essai_proposee, heure_souhaitee, statut, commentaire, id_client, id_voiture)
            VALUES (?, ?, ?, 'en_attente', 'Demande via site', ?, ?)";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "sssii", $date_demande, $date_essai_proposee, $heure_souhaitee, $id_client, $id_voiture);
    return mysqli_stmt_execute($stmt);
}
