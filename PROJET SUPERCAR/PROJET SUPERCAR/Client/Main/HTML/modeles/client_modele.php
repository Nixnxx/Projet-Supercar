<?php
// ============================================================
//  modeles/client_modele.php  —  MODÈLE : clients
//  Requêtes sur la table client et son compte de connexion (login).
// ============================================================

// Vérifie si un email est déjà utilisé (renvoie true ou false).
function email_existe($lienbd, $email) {
    $stmt = mysqli_prepare($lienbd, "SELECT id_client FROM client WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    return mysqli_num_rows($res) > 0;
}

// Crée un nouveau client et renvoie son id (ou false si erreur).
function creer_client($lienbd, $nom, $prenom, $email, $telephone, $adresse) {
    $sql = "INSERT INTO client (nom, prenom, email, telephone, adresse, date_inscription)
            VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $nom, $prenom, $email, $telephone, $adresse);
    if (mysqli_stmt_execute($stmt)) {
        return mysqli_insert_id($lienbd);
    }
    return false;
}

// Crée le compte de connexion lié à un client.
// Le niveau est toujours 'client' : on ne crée jamais d'admin ici.
function creer_login($lienbd, $login, $mdp_hash, $id_client) {
    $niveau = "client";
    $sql = "INSERT INTO login (login, mot_de_passe, niveau, id_client) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $login, $mdp_hash, $niveau, $id_client);
    return mysqli_stmt_execute($stmt);
}

// Nombre total de clients (pour le tableau de bord admin).
function compter_clients($lienbd) {
    $res = mysqli_query($lienbd, "SELECT COUNT(*) total FROM client");
    return (int) mysqli_fetch_assoc($res)['total'];
}

// Renvoie les infos d'un client à partir de son id.
function get_client($lienbd, $id_client) {
    $stmt = mysqli_prepare($lienbd, "SELECT * FROM client WHERE id_client = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_client);
    mysqli_stmt_execute($stmt);
    $ligne = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    return $ligne ?: null;
}
