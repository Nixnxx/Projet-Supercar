<?php

function renseigner_admin_audit($lienbd, $id_admin, $id_produit) {
    $sql = "UPDATE audit SET id_admin = ? WHERE id_produit = ? ORDER BY id_audit DESC LIMIT 1";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id_admin, $id_produit);
    mysqli_stmt_execute($stmt);
}

// id_admin et id_produit
// peuvent valoir NULL — un admin ou une voiture supprimé(e) ne doit pas
// faire disparaître la ligne d'audit (voir ON DELETE SET NULL sur les
// deux clés étrangères de la table audit).
function get_audit($lienbd) {
    $sql = "SELECT a.id_audit, a.nom_table, a.action, a.date_action,
                   l.login AS admin_login, v.model AS voiture_model
            FROM audit a
            LEFT JOIN login l ON a.id_admin = l.id_login
            LEFT JOIN voiture v ON a.id_produit = v.id_voiture
            ORDER BY a.id_audit DESC";
    $liste = mysqli_fetch_all(mysqli_query($lienbd, $sql), MYSQLI_ASSOC);
    return $liste ?: [];
}

?>