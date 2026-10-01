<?php
// ============================================================
//  vues/admin/nav.php  —  VUE (partiel) : menu latéral du back-office
//
//  Cette vue se contente d'AFFICHER : elle n'interroge plus la base.
//  Les deux compteurs des pastilles sont préparés en amont par
//  controleurs/admin/menu_controleur.php, inclus par chaque
//  contrôleur admin.
//
//  Reçoit : $nb_messages_non_lus, $nb_essais_en_attente
// ============================================================


// Page courante, pour surligner le bon lien du menu.
$current = basename($_SERVER['PHP_SELF']);
?>
<nav class="nav">
    <div class="nav-logo">Super<span>Car</span></div>


    <div class="nav-section">Principal</div>


    <a href="admin_dashboard.php" class="nav-link <?= $current==='admin_dashboard.php'?'active':'' ?>">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
        Dashboard
    </a>


    <a href="admin_contact.php" class="nav-link <?= $current==='admin_contact.php'?'active':'' ?>">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        Messages
        <?php if ($nb_messages_non_lus > 0): ?><span class="nav-badge"><?= $nb_messages_non_lus ?></span><?php endif; ?>
    </a>


    <a href="admin_essais.php" class="nav-link <?= $current==='admin_essais.php'?'active':'' ?>">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        Essais
        <?php if ($nb_essais_en_attente > 0): ?><span class="nav-badge"><?= $nb_essais_en_attente ?></span><?php endif; ?>
    </a>


     <a href="accueil.php" class="nav-link <?= $current==='accueil.php'?'active':'' ?>">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"/></svg>
        Accueil
    </a>


    <div class="nav-section">Catalogue</div>


    <a href="admin_voitures.php" class="nav-link <?= $current==='admin_voitures.php'?'active':'' ?>">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"/></svg>
        Voitures
    </a>


    <a href="admin_services.php" class="nav-link <?= $current==='admin_services.php'?'active':'' ?>">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        Services
    </a>


    <div class="nav-section">Système</div>


    <a href="admin_triggers.php" class="nav-link <?= $current==='admin_triggers.php'?'active':'' ?>">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        Journal d'audit
    </a>


    <div class="nav-bottom">
        <!-- CORRECTION (MED-01) : le bouton pointe vers logout.php qui déconnecte réellement -->
        <a href="logout.php" class="nav-link">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            Déconnexion
        </a>
    </div>
</nav>
