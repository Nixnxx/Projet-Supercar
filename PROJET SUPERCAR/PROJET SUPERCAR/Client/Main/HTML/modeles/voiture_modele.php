<?php
// ============================================================
//  modeles/voiture_modele.php  —  MODÈLE : voitures
//  Catalogue côté client + gestion côté admin (ajout/modif/suppression + photos).
//
//  ------------------------------------------------------------
//  RÈGLES D'ÉCRITURE — LES MÊMES DANS TOUS LES MODÈLES
//  ------------------------------------------------------------
//  1) La requête est TOUJOURS rangée dans $sql avant d'être exécutée :
//
//       $sql  = "SELECT ...";
//       $stmt = mysqli_prepare($lienbd, $sql);   // requête AVEC paramètres
//       $res  = mysqli_query($lienbd, $sql);     // requête SANS paramètre
//
//     On ne met jamais la requête directement entre les parenthèses de
//     mysqli_prepare() / mysqli_query(), et on n'assemble jamais une requête
//     bout à bout : dans un if/else, chaque cas écrit sa requête en entier.
//     Avantage : la requête est isolée, relisible, et peut être affichée
//     telle quelle (echo $sql;) pour déboguer.
//
//  2) Valeur renvoyée, selon ce que la fonction ramène :
//       - liste (plusieurs lignes) : $liste = mysqli_fetch_all(...);  return $liste ?: [];
//       - une ligne                : $ligne = mysqli_fetch_assoc(...); return $ligne ?: null;
//       - vrai/faux (existence)    : $res = ...; return mysqli_num_rows($res) > 0;
//       - agrégat (COUNT / SUM)    : return mysqli_fetch_assoc($res);
//                                    (un agrégat renvoie toujours une ligne)
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
    $sql = "SELECT * FROM voiture_images ORDER BY id_voiture, ordre";
    $res = mysqli_query($lienbd, $sql);
    $par_voiture = [];
    while ($img = mysqli_fetch_assoc($res)) {
        $par_voiture[$img['id_voiture']][] = $img['image'];
    }
    return $par_voiture;
}

// Vérifie qu'une voiture existe (avant d'enregistrer une demande d'essai).
function voiture_existe($lienbd, $id) {
    $sql = "SELECT id_voiture FROM voiture WHERE id_voiture = ?";
    $stmt = mysqli_prepare($lienbd, $sql);
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
    $sql = "SELECT disponible FROM voiture WHERE id_voiture = ?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $ligne = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    return $ligne && (int) $ligne['disponible'] === 1;
}

// Liste des voitures pour le formulaire d'essai (filtrable par marque).
// On récupère aussi "disponible" pour griser les voitures déjà réservées
// dans le menu déroulant (voir vues/essai_vue.php).
function get_voitures_pour_essai($lienbd, $id_marque = 0) {
    if ($id_marque > 0) {
        $sql = "SELECT v.id_voiture, v.model, v.disponible, m.nom AS marque
                FROM voiture v JOIN marque m ON v.id_marque = m.id_marque
                WHERE v.id_marque = ?
                ORDER BY v.model";
        $stmt = mysqli_prepare($lienbd, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_marque);
    } else {
        $sql = "SELECT v.id_voiture, v.model, v.disponible, m.nom AS marque
                FROM voiture v JOIN marque m ON v.id_marque = m.id_marque
                ORDER BY m.nom, v.model";
        $stmt = mysqli_prepare($lienbd, $sql);
    }
    mysqli_stmt_execute($stmt);
    $liste = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    return $liste ?: [];
}

// ---------- Côté admin ----------

// Nombre total de voitures (tableau de bord).
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

// Une voiture par son id.
function get_voiture($lienbd, $id) {
    $sql = "SELECT * FROM voiture WHERE id_voiture = ?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $ligne = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    return $ligne ?: null;
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
