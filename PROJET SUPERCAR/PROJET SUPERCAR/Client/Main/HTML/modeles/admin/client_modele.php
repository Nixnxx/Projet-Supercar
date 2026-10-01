<?php
// ============================================================
//  modeles/admin/client_modele.php  —  MODÈLE ADMIN : clients
//  Statistiques sur les clients, pour le tableau de bord.
//
//  Règles d'écriture : voir l'en-tête de modeles/voiture_modele.php.
// ============================================================

// Nombre total de clients (pour le tableau de bord admin).
// Une requête d'agrégat renvoie TOUJOURS une ligne : pas de repli nécessaire.
function compter_clients($lienbd) {
    $sql = "SELECT COUNT(*) total FROM client";
    $res = mysqli_query($lienbd, $sql);
    return (int) mysqli_fetch_assoc($res)['total'];
}
