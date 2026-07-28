<?php
// ============================================================
//  controleurs/nonconnecte_controleur.php  —  CONTRÔLEUR : page
//  "connexion requise". Mémorise l'action voulue (essai / contact)
//  pour la reprendre après connexion. Appelé par nonconnecte.php.
// ============================================================

require_once __DIR__ . '/../includes/init.php';

if (isset($_GET['redirect']) && $_GET['redirect'] === 'essai') {
    $_SESSION['essai_en_attente'] = true;
    if (isset($_GET['id_marque']))  $_SESSION['essai_id_marque']  = (int)$_GET['id_marque'];
    if (isset($_GET['id_voiture'])) $_SESSION['essai_id_voiture'] = (int)$_GET['id_voiture'];
}

if (isset($_GET['redirect']) && $_GET['redirect'] === 'contact') {
    $_SESSION['contact_en_attente'] = true;
}

require __DIR__ . '/../vues/nonconnecte_vue.php';
