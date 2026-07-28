<?php
// ============================================================
//  controleurs/services_controleur.php  —  CONTRÔLEUR : services
//  Appelé par le point d'entrée services.php.
// ============================================================

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../modeles/service_modele.php';

$services = get_services($lienbd);

$titre_page = 'SuperCar – Nos services';

require __DIR__ . '/../vues/services_vue.php';
