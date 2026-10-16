<?php
// ============================================================
//  modeles/voiture_modele.php  —  MODÈLE : voitures
//  CÔTÉ CLIENT : catalogue public et vérifications liées à la demande
//  d'essai. La GESTION du parc (ajout, modification, suppression,
//  photos, marques) est dans modeles/admin/voiture_modele.php.
//
//  ------------------------------------------------------------
//  RÈGLES D'ÉCRITURE — LES MÊMES DANS TOUS LES MODÈLES
//  (client comme admin ; ce bloc est la référence du projet)
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
//
//  3) Séparation client / admin :
//     Une fonction utilisée UNIQUEMENT par le back-office va dans
//     modeles/admin/. Une fonction utilisée par le site client — même si
//     l'admin s'en sert aussi pour une simple lecture — reste ici.
// ============================================================

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
// Cette colonne est synchronisée automatiquement par admin/essai_modele.php
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

// Une voiture par son id.
// Utilisée par le client (page de demande d'essai) ET par l'admin (pré-remplir
// le formulaire de modification) : c'est une simple LECTURE, elle reste donc
// ici et le contrôleur admin inclut ce fichier en plus du sien.
function get_voiture($lienbd, $id) {
    $sql = "SELECT * FROM voiture WHERE id_voiture = ?";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $ligne = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    return $ligne ?: null;
}
