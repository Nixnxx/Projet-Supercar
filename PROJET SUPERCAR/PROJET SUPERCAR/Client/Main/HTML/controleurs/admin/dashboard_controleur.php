<?php
// ============================================================
//  controleurs/admin/dashboard_controleur.php  —  CONTRÔLEUR : tableau de bord
//  Garde admin en premier. Appelé par ADMIN/admin_dashboard.php.
// ============================================================

require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../../includes/garde_admin.php';   // accès réservé aux admins
require_once __DIR__ . '/menu_controleur.php';   // compteurs des pastilles du menu

require_once __DIR__ . '/../../modeles/admin/contact_modele.php';
require_once __DIR__ . '/../../modeles/admin/client_modele.php';
require_once __DIR__ . '/../../modeles/admin/voiture_modele.php';
require_once __DIR__ . '/../../modeles/admin/essai_modele.php';

// Statistiques globales.
$stats = [
    'messages' => get_stats_messages($lienbd),
    'clients'  => compter_clients($lienbd),
    'voitures' => compter_voitures($lienbd),
    'essais'   => get_stats_essais($lienbd),
];

// Aperçus récents.
$derniers_msg    = get_derniers_messages($lienbd, 5);
$derniers_essais = get_derniers_essais($lienbd, 5);

$titre_page = 'Admin — Dashboard';

require __DIR__ . '/../../vues/admin/dashboard_vue.php';
