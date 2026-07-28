<?php
// ============================================================
//  vues/admin/layout_haut.php  —  VUE (partiel) : haut de page admin
//  Ouvre le document, insère les styles et le menu latéral.
//  Le contrôleur peut définir avant l'inclusion :
//    $titre_page  : titre de l'onglet
//    $css_extra   : balises <link> supplémentaires à mettre dans <head>
// ============================================================
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title><?= e($titre_page ?? 'Administration — SuperCar') ?></title>
<?php require __DIR__ . '/style.php'; ?>
<?= $css_extra ?? '' ?>
</head>
<body>
<?php require __DIR__ . '/nav.php'; ?>
