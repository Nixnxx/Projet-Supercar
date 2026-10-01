<?php


require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../../includes/garde_admin.php';
require_once __DIR__ . '/menu_controleur.php';  
require_once __DIR__ . '/../../modeles/admin/audit_modele.php';


$audit =get_audit($lienbd);


$titre_page = 'Journal d\'audit — SuperCar';


require __DIR__ . '/../../vues/admin/triggers_vue.php';
