<?php
// ============================================================
//  modeles/voiture_modele.php  —  MODÈLE : voitures
//  Catalogue côté client + gestion côté admin (ajout/modif/suppression + photos).
//
//  Règles d'écriture (les mêmes dans tous les modèles) :
//   - liste (plusieurs lignes)  : $liste = mysqli_fetch_all(...); return $liste ?: [];
//   - une ligne (un enregistrement) : $ligne = mysqli_fetch_assoc(...); return $ligne ?: null;
//   - vrai/faux (existence)     : $res = ...; return mysqli_num_rows($res) > 0;
// ============================================================

// ---------- Côté client ----------

// Toutes les voitures avec le nom de leur marque (page catalogue).
function get_voitures_avec_marque($lienbd) {
    $sql = "SELECT v.*, m.nom AS marque
            FROM voiture v
            JOIN marque m ON v.id_marque = m.id_marque
            ORDER BY m.nom";
    $liste = mysqli_fetch_all(mysqli_query($lienbd, $sql), MYSQLI_ASSOC);
    return $liste ?: [];
}

// Renvoie les photos regroupées par voiture :
// un tableau [id_voiture => [photo1, photo2, ...]].
function get_images_groupees($lienbd) {
    $res = mysqli_query($lienbd, "SELECT * FROM voiture_images ORDER BY id_voiture, ordre");
    $par_voiture = [];
    while ($img = mysqli_fetch_assoc($res)) {
        $par_voiture[$img['id_voiture']][] = $img['image'];
    }
    return $par_voiture;
}

// Vérifie qu'une voiture existe (avant d'enregistrer une demande d'essai).
function voiture_existe($lienbd, $id) {
    $stmt = mysqli_prepare($lienbd, "SELECT id_voiture FROM voiture WHERE id_voiture = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    return mysqli_num_rows($res) > 0;
}

// Vrai si CETTE voiture est disponible (colonne voiture.disponible = 1).
// Cette colonne est synchronisée automatiquement par essai_modele.php
// quand l'admin change le statut d'une demande d'essai (voir maj_statut_essai).
// Sert à bloquer une réservation lancée directement par l'URL.
function voiture_disponible($lienbd, $id) {
    $stmt = mysqli_prepare($lienbd, "SELECT disponible FROM voiture WHERE id_voiture = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $ligne = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    return $ligne && (int) $ligne['disponible'] === 1;
}

// Liste des voitures pour le formulaire d'essai (filtrable par marque).
function get_voitures_pour_essai($lienbd, $id_marque = 0) {
    if ($id_marque > 0) {
        $stmt = mysqli_prepare($lienbd,
            "SELECT v.id_voiture, v.model, m.nom AS marque
             FROM voiture v JOIN marque m ON v.id_marque = m.id_marque
             WHERE v.id_marque = ? ORDER BY v.model");
        mysqli_stmt_bind_param($stmt, "i", $id_marque);
    } else {
        $stmt = mysqli_prepare($lienbd,
            "SELECT v.id_voiture, v.model, m.nom AS marque
             FROM voiture v JOIN marque m ON v.id_marque = m.id_marque
             ORDER BY m.nom, v.model");
    }
    mysqli_stmt_execute($stmt);
    $liste = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    return $liste ?: [];
}

// ---------- Côté admin ----------

// Nombre total de voitures (tableau de bord).
function compter_voitures($lienbd) {
    $res = mysqli_query($lienbd, "SELECT COUNT(*) total FROM voiture");
    return (int) mysqli_fetch_assoc($res)['total'];
}

// Liste des voitures pour l'admin (filtrable par marque ; -1 = toutes).
function get_voitures_admin($lienbd, $filtre_marque = -1) {
    if ($filtre_marque > 0) {
        $stmt = mysqli_prepare($lienbd,
            "SELECT v.*, m.nom AS marque
             FROM voiture v JOIN marque m ON m.id_marque = v.id_marque
             WHERE v.id_marque = ? ORDER BY m.nom, v.model");
        mysqli_stmt_bind_param($stmt, "i", $filtre_marque);
        mysqli_stmt_execute($stmt);
        $liste = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
        return $liste ?: [];
    }
    $sql = "SELECT v.*, m.nom AS marque
            FROM voiture v JOIN marque m ON m.id_marque = v.id_marque
            ORDER BY m.nom, v.model";
    $liste = mysqli_fetch_all(mysqli_query($lienbd, $sql), MYSQLI_ASSOC);
    return $liste ?: [];
}

// Toutes les marques (pour les filtres et les listes déroulantes).
function get_marques($lienbd) {
    $liste = mysqli_fetch_all(mysqli_query($lienbd, "SELECT * FROM marque ORDER BY nom"), MYSQLI_ASSOC);
    return $liste ?: [];
}

// Une voiture par son id.
function get_voiture($lienbd, $id) {
    $stmt = mysqli_prepare($lienbd, "SELECT * FROM voiture WHERE id_voiture = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $ligne = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    return $ligne ?: null;
}

// Les photos (slider) d'une voiture.
function get_images_voiture($lienbd, $id_voiture) {
    $stmt = mysqli_prepare($lienbd, "SELECT * FROM voiture_images WHERE id_voiture = ? ORDER BY ordre");
    mysqli_stmt_bind_param($stmt, "i", $id_voiture);
    mysqli_stmt_execute($stmt);
    $liste = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    return $liste ?: [];
}

// Ajoute une voiture et renvoie son nouvel id.
function ajouter_voiture($lienbd, $model, $annee, $km, $carburant, $prix, $specs, $image, $id_marque) {
    $sql = "INSERT INTO voiture (model, annee, km, type_carburant, prix, specs, image, id_marque)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "ssisissi", $model, $annee, $km, $carburant, $prix, $specs, $image, $id_marque);
    mysqli_stmt_execute($stmt);
    return mysqli_insert_id($lienbd);
}

// Met à jour une voiture existante.
function modifier_voiture($lienbd, $id, $model, $annee, $km, $carburant, $prix, $specs, $id_marque) {
    $sql = "UPDATE voiture
            SET model=?, annee=?, km=?, type_carburant=?, prix=?, specs=?, id_marque=?
            WHERE id_voiture=?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "ssisisii", $model, $annee, $km, $carburant, $prix, $specs, $id_marque, $id);
    mysqli_stmt_execute($stmt);
}

// Supprime une voiture ET ses photos.
function supprimer_voiture($lienbd, $id) {
    $stmt = mysqli_prepare($lienbd, "DELETE FROM voiture_images WHERE id_voiture = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $stmt = mysqli_prepare($lienbd, "DELETE FROM voiture WHERE id_voiture = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

// Renvoie le prochain numéro d'ordre pour une nouvelle photo.
function prochain_ordre_image($lienbd, $id_voiture) {
    $stmt = mysqli_prepare($lienbd, "SELECT MAX(ordre) AS max_ordre FROM voiture_images WHERE id_voiture = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_voiture);
    mysqli_stmt_execute($stmt);
    $ligne = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    return ($ligne['max_ordre'] ?? 0) + 1;
}

// Ajoute une photo au slider d'une voiture.
function ajouter_image_voiture($lienbd, $id_voiture, $chemin, $ordre) {
    $stmt = mysqli_prepare($lienbd, "INSERT INTO voiture_images (id_voiture, image, ordre) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "isi", $id_voiture, $chemin, $ordre);
    mysqli_stmt_execute($stmt);
}

// Supprime une photo précise du slider.
function supprimer_image_voiture($lienbd, $id) {
    $stmt = mysqli_prepare($lienbd, "DELETE FROM voiture_images WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}
