<?php
// ============================================================
//  modeles/admin/accueil_modele.php  —  MODÈLE ADMIN : page d'accueil
//  Réservé au back-office : voir TOUS les éléments (actifs ou non),
//  ajouter, modifier, supprimer. L'accueil est composé de 5 blocs :
//  carrousel, texte hero, images hero, points forts, statistiques.
//
//  Les LECTURES partagées avec le site client (get_hero) restent dans
//  modeles/accueil_modele.php, que le contrôleur admin inclut aussi.
//
//  Règles d'écriture : voir l'en-tête de modeles/voiture_modele.php.
// ============================================================

// ---------- Listes complètes (éléments actifs ET inactifs) ----------

function get_carousel_tout($lienbd) {
    $sql = "SELECT * FROM accueil_carousel ORDER BY ordre";
    $liste = mysqli_fetch_all(mysqli_query($lienbd, $sql), MYSQLI_ASSOC);
    return $liste ?: [];
}

function get_hero_images_tout($lienbd) {
    $sql = "SELECT * FROM accueil_bienvenue_images ORDER BY ordre";
    $liste = mysqli_fetch_all(mysqli_query($lienbd, $sql), MYSQLI_ASSOC);
    return $liste ?: [];
}

function get_points_tout($lienbd) {
    $sql = "SELECT * FROM accueil_points ORDER BY ordre";
    $liste = mysqli_fetch_all(mysqli_query($lienbd, $sql), MYSQLI_ASSOC);
    return $liste ?: [];
}

function get_stats_tout($lienbd) {
    $sql = "SELECT * FROM accueil_stats ORDER BY ordre";
    $liste = mysqli_fetch_all(mysqli_query($lienbd, $sql), MYSQLI_ASSOC);
    return $liste ?: [];
}

// Traduit le mot reçu dans l'URL (ex : "carousel") en vrai nom de table SQL.
// On ne met jamais directement un nom de table venu de l'utilisateur dans une
// requête : on passe par cette liste. Si le mot n'y est pas, on renvoie null.
function accueil_table_reelle($cle) {
    $map = [
        'carousel'   => 'accueil_carousel',
        'hero'       => 'accueil_bienvenue',
        'hero_image' => 'accueil_bienvenue_images',
        'point'      => 'accueil_points',
        'stat'       => 'accueil_stats',
    ];
    return $map[$cle] ?? null;
}

// Récupère une ligne par id (pour pré-remplir un formulaire de modification).
// EXCEPTION à la règle "une ligne => null" : ici on renvoie un tableau vide,
// car l'appelant s'en sert directement pour pré-remplir des champs de
// formulaire (voir controleurs/admin/accueil_mod_controleur.php).
function accueil_get_ligne($lienbd, $cle, $id) {
    $table = accueil_table_reelle($cle);
    if ($table === null || $id <= 0) {
        return [];
    }
    $sql = "SELECT * FROM `$table` WHERE id = ?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $ligne = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    return $ligne ?: [];
}

// Supprime une ligne dans un des blocs de l'accueil.
function accueil_supprimer($lienbd, $cle, $id) {
    $table = accueil_table_reelle($cle);
    if ($table === null || $id <= 0) {
        return false;
    }
    $sql = "DELETE FROM `$table` WHERE id = ?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    return true;
}

// ---------- Enregistrement (ajout OU modification) par bloc ----------
// $id = 0 => ajout ; $id > 0 => modification.

function carousel_enregistrer($lienbd, $id, $titre, $desc, $image, $lien, $texte_lien, $ordre, $actif) {
    if ($id > 0) {
        $sql = "UPDATE accueil_carousel SET titre=?, description=?, image=?, lien=?, texte_lien=?, ordre=?, actif=? WHERE id=?";
        $stmt = mysqli_prepare($lienbd, $sql);
        mysqli_stmt_bind_param($stmt, "sssssiis", $titre, $desc, $image, $lien, $texte_lien, $ordre, $actif, $id);
    } else {
        $sql = "INSERT INTO accueil_carousel (titre, description, image, lien, texte_lien, ordre, actif) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($lienbd, $sql);
        mysqli_stmt_bind_param($stmt, "sssssii", $titre, $desc, $image, $lien, $texte_lien, $ordre, $actif);
    }
    mysqli_stmt_execute($stmt);
}

function hero_modifier($lienbd, $id, $titre, $sous_titre, $desc, $texte, $lien) {
    $sql = "UPDATE accueil_bienvenue SET titre=?, sous_titre=?, description=?, texte=?, lien=? WHERE id=?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "sssssi", $titre, $sous_titre, $desc, $texte, $lien, $id);
    mysqli_stmt_execute($stmt);
}

function hero_image_enregistrer($lienbd, $id, $image, $alt, $ordre, $actif) {
    if ($id > 0) {
        $sql = "UPDATE accueil_bienvenue_images SET image=?, alt=?, ordre=?, actif=? WHERE id=?";
        $stmt = mysqli_prepare($lienbd, $sql);
        mysqli_stmt_bind_param($stmt, "ssiii", $image, $alt, $ordre, $actif, $id);
    } else {
        $sql = "INSERT INTO accueil_bienvenue_images (image, alt, ordre, actif) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($lienbd, $sql);
        mysqli_stmt_bind_param($stmt, "ssii", $image, $alt, $ordre, $actif);
    }
    mysqli_stmt_execute($stmt);
}

function point_enregistrer($lienbd, $id, $texte, $ordre, $actif) {
    if ($id > 0) {
        $sql = "UPDATE accueil_points SET texte=?, ordre=?, actif=? WHERE id=?";
        $stmt = mysqli_prepare($lienbd, $sql);
        mysqli_stmt_bind_param($stmt, "siii", $texte, $ordre, $actif, $id);
    } else {
        $sql = "INSERT INTO accueil_points (texte, ordre, actif) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($lienbd, $sql);
        mysqli_stmt_bind_param($stmt, "sii", $texte, $ordre, $actif);
    }
    mysqli_stmt_execute($stmt);
}

function stat_enregistrer($lienbd, $id, $valeur, $label, $ordre, $actif) {
    if ($id > 0) {
        $sql = "UPDATE accueil_stats SET valeur=?, label=?, ordre=?, actif=? WHERE id=?";
        $stmt = mysqli_prepare($lienbd, $sql);
        mysqli_stmt_bind_param($stmt, "ssiii", $valeur, $label, $ordre, $actif, $id);
    } else {
        $sql = "INSERT INTO accueil_stats (valeur, label, ordre, actif) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($lienbd, $sql);
        mysqli_stmt_bind_param($stmt, "ssii", $valeur, $label, $ordre, $actif);
    }
    mysqli_stmt_execute($stmt);
}
