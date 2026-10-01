<?php
// ============================================================
//  modeles/admin/voiture_modele.php  —  MODÈLE ADMIN : voitures
//  Réservé au back-office : gestion du parc (ajout, modification,
//  suppression), gestion des photos du slider et liste des marques.
//
//  Les LECTURES partagées avec le site client (get_voiture) restent dans
//  modeles/voiture_modele.php, que le contrôleur admin inclut aussi.
//
//  Règles d'écriture : voir l'en-tête de modeles/voiture_modele.php.
// ============================================================

// Nombre total de voitures (tableau de bord).
// Une requête d'agrégat renvoie TOUJOURS une ligne : pas de repli nécessaire.
function compter_voitures($lienbd) {
    $sql = "SELECT COUNT(*) total FROM voiture";
    $res = mysqli_query($lienbd, $sql);
    return (int) mysqli_fetch_assoc($res)['total'];
}

// Liste des voitures pour l'admin (filtrable par marque ; -1 = toutes).
function get_voitures_admin($lienbd, $filtre_marque = -1) {
    if ($filtre_marque > 0) {
        $sql = "SELECT v.*, m.nom AS marque
                FROM voiture v JOIN marque m ON m.id_marque = v.id_marque
                WHERE v.id_marque = ?
                ORDER BY m.nom, v.model";
        $stmt = mysqli_prepare($lienbd, $sql);
        mysqli_stmt_bind_param($stmt, "i", $filtre_marque);
    } else {
        $sql = "SELECT v.*, m.nom AS marque
                FROM voiture v JOIN marque m ON m.id_marque = v.id_marque
                ORDER BY m.nom, v.model";
        $stmt = mysqli_prepare($lienbd, $sql);
    }
    mysqli_stmt_execute($stmt);
    $liste = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    return $liste ?: [];
}

// Toutes les marques (pour les filtres et les listes déroulantes).
function get_marques($lienbd) {
    $sql = "SELECT * FROM marque ORDER BY nom";
    $liste = mysqli_fetch_all(mysqli_query($lienbd, $sql), MYSQLI_ASSOC);
    return $liste ?: [];
}

// Les photos (slider) d'une voiture.
function get_images_voiture($lienbd, $id_voiture) {
    $sql = "SELECT * FROM voiture_images WHERE id_voiture = ? ORDER BY ordre";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_voiture);
    mysqli_stmt_execute($stmt);
    $liste = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    return $liste ?: [];
}

// Ajoute une voiture et renvoie son nouvel id.
function ajouter_voiture($lienbd, $model, $annee, $km, $carburant, $prix, $specs, $image, $id_marque,$transmission) {
    $sql = "INSERT INTO voiture (model, annee, km, type_carburant, prix, specs, image, id_marque, transmission)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "ssisissis", $model, $annee, $km, $carburant, $prix, $specs, $image, $id_marque, $transmission);
    mysqli_stmt_execute($stmt);
    return mysqli_insert_id($lienbd);
}

// Met à jour une voiture existante.
function modifier_voiture($lienbd, $id, $model, $annee, $km, $carburant, $prix, $specs, $id_marque, $transmission) {
    $sql = "UPDATE voiture
            SET model=?, annee=?, km=?, type_carburant=?, prix=?, specs=?, id_marque=?, transmission=?
            WHERE id_voiture=?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "ssisisisi", $model, $annee, $km, $carburant, $prix, $specs, $id_marque, $transmission, $id);
    mysqli_stmt_execute($stmt);
}

// Supprime une voiture ET ses photos.
function supprimer_voiture($lienbd, $id) {
    $sql = "DELETE FROM voiture_images WHERE id_voiture = ?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $sql = "DELETE FROM voiture WHERE id_voiture = ?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

// Renvoie le prochain numéro d'ordre pour une nouvelle photo.
function prochain_ordre_image($lienbd, $id_voiture) {
    $sql = "SELECT MAX(ordre) AS max_ordre FROM voiture_images WHERE id_voiture = ?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_voiture);
    mysqli_stmt_execute($stmt);
    $ligne = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    return ($ligne['max_ordre'] ?? 0) + 1;
}

// Ajoute une photo au slider d'une voiture.
function ajouter_image_voiture($lienbd, $id_voiture, $chemin, $ordre) {
    $sql = "INSERT INTO voiture_images (id_voiture, image, ordre) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "isi", $id_voiture, $chemin, $ordre);
    mysqli_stmt_execute($stmt);
}

// Supprime une photo précise du slider.
function supprimer_image_voiture($lienbd, $id) {
    $sql = "DELETE FROM voiture_images WHERE id = ?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}
