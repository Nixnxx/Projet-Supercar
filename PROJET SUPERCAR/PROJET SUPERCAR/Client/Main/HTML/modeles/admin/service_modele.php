<?php
// ============================================================
//  modeles/admin/service_modele.php  —  MODÈLE ADMIN : services
//  Réservé au back-office : consulter un service précis, ajouter,
//  modifier et supprimer.
//
//  La LECTURE partagée avec le site client (get_services) reste dans
//  modeles/service_modele.php, que le contrôleur admin inclut aussi.
//
//  Règles d'écriture : voir l'en-tête de modeles/voiture_modele.php.
// ============================================================

// Un service par son id.
function get_service($lienbd, $id) {
    $sql = "SELECT * FROM service WHERE id_service = ?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $ligne = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    return $ligne ?: null;
}

// Ajoute un service.
function ajouter_service($lienbd, $nom, $desc, $image, $icone, $tag, $numero) {
    $sql = "INSERT INTO service (nom, description, image, icone, tag, numero) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "sssssi", $nom, $desc, $image, $icone, $tag, $numero);
    mysqli_stmt_execute($stmt);
}

// Met à jour un service.
// $image vaut :
//   null   => on ne change pas l'image existante
//   ''     => on retire l'image
//   chemin => on remplace l'image
function modifier_service($lienbd, $id, $nom, $desc, $icone, $tag, $numero, $image) {
    if ($image === null) {
        // On ne touche pas à l'image
        $sql = "UPDATE service SET nom=?, description=?, icone=?, tag=?, numero=? WHERE id_service=?";
        $stmt = mysqli_prepare($lienbd, $sql);
        mysqli_stmt_bind_param($stmt, "ssssii", $nom, $desc, $icone, $tag, $numero, $id);
    } else {
        // On remplace (ou on vide) l'image
        $sql = "UPDATE service SET nom=?, description=?, image=?, icone=?, tag=?, numero=? WHERE id_service=?";
        $stmt = mysqli_prepare($lienbd, $sql);
        mysqli_stmt_bind_param($stmt, "sssssii", $nom, $desc, $image, $icone, $tag, $numero, $id);
    }
    mysqli_stmt_execute($stmt);
}

// Supprime un service.
function supprimer_service($lienbd, $id) {
    $sql = "DELETE FROM service WHERE id_service = ?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}
