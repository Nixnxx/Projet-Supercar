<?php
session_start();

// Supprime TOUTES les variables de session
$_SESSION = [];

// Détruit complètement la session
session_destroy();

// Redirection
header('Location: /index.php');
exit();
?>