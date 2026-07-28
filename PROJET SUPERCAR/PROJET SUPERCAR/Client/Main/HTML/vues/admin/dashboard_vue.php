<?php
// ============================================================
//  vues/admin/dashboard_vue.php  —  VUE : tableau de bord admin
//  Reçoit : $stats, $derniers_msg, $derniers_essais.
// ============================================================
require __DIR__ . '/layout_haut.php';
?>

<div class="page">
<div class="page-header">
    <h2>Dashboard</h2>
    <span class="page-sub">Vue d'ensemble</span>
</div>

<!-- STATISTIQUES -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon orange">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <div>
            <div class="stat-label">Messages</div>
            <div class="stat-value"><?= (int)$stats['messages']['total'] ?></div>
            <?php if ($stats['messages']['non_lus'] > 0): ?>
            <div class="stat-badge"><?= (int)$stats['messages']['non_lus'] ?> non lus</div>
            <?php endif; ?>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div>
            <div class="stat-label">Clients</div>
            <div class="stat-value"><?= (int)$stats['clients'] ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <div>
            <div class="stat-label">Voitures</div>
            <div class="stat-value"><?= (int)$stats['voitures'] ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <div>
            <div class="stat-label">Essais</div>
            <div class="stat-value"><?= (int)$stats['essais']['total'] ?></div>
            <?php if ($stats['essais']['en_attente'] > 0): ?>
            <div class="stat-badge"><?= (int)$stats['essais']['en_attente'] ?> en attente</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- 2 colonnes -->
<div class="two-col">

    <!-- Derniers messages -->
    <div class="card">
        <div class="card-header">
            <span>Derniers messages</span>
            <a href="admin_contact.php" class="btn btn-ghost btn-sm">Voir tout</a>
        </div>
        <?php if (empty($derniers_msg)): ?>
        <div class="empty-sm">Aucun message.</div>
        <?php else: ?>
        <?php foreach ($derniers_msg as $m): ?>
        <div class="list-item <?= !$m['lu'] ? 'unread' : '' ?>">
            <div class="list-dot <?= !$m['lu'] ? 'dot-on' : '' ?>"></div>
            <div class="list-body">
                <div class="list-title"><?= e($m['nom']) ?> <span class="list-meta"><?= e($m['email']) ?></span></div>
                <div class="list-preview"><?= e(substr($m['message'], 0, 60)) ?>…</div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Dernières demandes d'essai -->
    <div class="card">
        <div class="card-header">
            <span>Dernières demandes d'essai</span>
            <a href="admin_essais.php" class="btn btn-ghost btn-sm">Voir tout</a>
        </div>
        <?php if (empty($derniers_essais)): ?>
        <div class="empty-sm">Aucune demande.</div>
        <?php else: ?>
        <?php foreach ($derniers_essais as $e): ?>
        <div class="list-item">
            <div class="list-dot <?= $e['statut'] == 0 ? 'dot-on' : '' ?>"></div>
            <div class="list-body">
                <div class="list-title"><?= e($e['nom'].' '.$e['prenom']) ?> <span class="list-meta"><?= e($e['model']) ?></span></div>
                <div class="list-preview">
                    <?php
                    $statuts = ['0'=>'En attente','1'=>'Confirmé','2'=>'Refusé'];
                    echo $e['date_essai_proposee'] ? date('d/m/Y', strtotime($e['date_essai_proposee'])) : '—';
                    echo ' · ';
                    echo $statuts[$e['statut']] ?? '—';
                    ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>
</div>

<?php require __DIR__ . '/layout_bas.php'; ?>
