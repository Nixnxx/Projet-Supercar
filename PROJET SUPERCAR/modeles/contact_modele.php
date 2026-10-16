<?php
// ============================================================
//  modeles/contact_modele.php  —  MODÈLE : messages de contact
//  CÔTÉ CLIENT : envoyer un message et lire les coordonnées affichées
//  sur la page Contact. Tout ce qui sert à TRAITER les messages
//  (lister, marquer lu, supprimer, modifier les coordonnées) est dans
//  modeles/admin/contact_modele.php.
// ============================================================

// Enregistre un message de contact.
// $id_client peut valoir null : un visiteur NON connecté peut aussi
// envoyer un message (la colonne id_client accepte NULL).
// Le téléphone est enregistré en texte ('s') pour garder les "+230 ...".
function ajouter_message($lienbd, $nom, $email, $message, $numero, $id_client) {
    $sql = "INSERT INTO contact (nom, email, message, id_client, numero)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "sssis", $nom, $email, $message, $id_client, $numero);
    return mysqli_stmt_execute($stmt);
}

// Renvoie la configuration de contact (adresse, email, téléphone, carte).
// Utilisée aussi par l'admin (pour pré-remplir son formulaire) : c'est une
// simple LECTURE, elle reste donc du côté client et le contrôleur admin
// inclut ce fichier en plus du sien.
function get_config_contact($lienbd) {
    $sql = "SELECT * FROM contact_config LIMIT 1";
    $ligne = mysqli_fetch_assoc(mysqli_query($lienbd, $sql));
    return $ligne ?: null;
}
