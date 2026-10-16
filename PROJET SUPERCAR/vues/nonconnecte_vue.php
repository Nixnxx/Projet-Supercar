<?php
// ============================================================
//  vues/nonconnecte_vue.php  —  VUE : "accès réservé aux clients"
//  Redirige automatiquement vers la connexion après 1 seconde.
// ============================================================
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="1;url=connexion.php">
    <link rel="stylesheet" href="css/nonconnecte.css?v=1.1">
    <title>Connexion requise</title>
</head>
<body>

<div class="carte">
    <div class="cadenas">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="11" width="18" height="11" rx="2"/>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
        </svg>
    </div>
    <p class="titre">Accès réservé aux clients </p>
    <p class="sous-titre">Vous devez être connecté pour accéder à cette page.</p>

    <div class="barre-conteneur">
        <div class="barre"></div>
    </div>

    <p class="texte-redirection">Redirection en cours...</p>
</div>

</body>
</html>
