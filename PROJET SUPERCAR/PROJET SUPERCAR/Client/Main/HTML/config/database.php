<?php
// ============================================================
//  config/database.php
//  Connexion à la base de données MySQL (mysqli procédural).
//  C'est le seul fichier où se trouvent les identifiants de la base.
// ============================================================

$hote        = 'localhost';
$utilisateur = 'root';   // utilisateur par défaut de WAMP
$motdepasse  = '';       // mot de passe vide par défaut en local
$base        = 'supercar';

// On ouvre la connexion. La variable $lienbd est utilisée dans tous les modèles.
$lienbd = mysqli_connect($hote, $utilisateur, $motdepasse, $base);

// Si la connexion échoue, on arrête tout avec un message.
if (!$lienbd) {
    die("Erreur de connexion à la base de données.");
}

// On force l'encodage UTF-8 pour bien afficher les accents.
mysqli_set_charset($lienbd, 'utf8mb4');
