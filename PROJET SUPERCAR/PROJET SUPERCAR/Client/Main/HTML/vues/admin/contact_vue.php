<?php
// ============================================================
//  vues/admin/contact_vue.php  —  VUE : messages de contact
//  Reçoit : $messages, $stats, $config, $lat, $lng, $tab, $succes, $msg_detail.
// ============================================================
require __DIR__ . '/layout_haut.php';
?>

<div class="page">
<div class="page-header">
    <h2>Messages</h2>
    <span class="page-sub">Gestion des contacts</span>
</div>

<!-- ONGLETS internes -->
<div class="onglets">
    <a href="?tab=messages" class="onglet <?= $tab === 'messages' ? 'actif' : '' ?>">
        Messages
        <?php if ($stats['non_lus'] > 0 && $tab!=='messages'): ?>
        <span class="onglet-badge"><?= (int)$stats['non_lus'] ?></span>
        <?php endif; ?>
    </a>
    <a href="?tab=config" class="onglet <?= $tab === 'config' ? 'actif' : '' ?>">
        Configuration
    </a>
</div>

<?php if ($succes === 'supprime'): ?>
<div class="alert danger">Message(s) supprimé(s).</div>
<?php elseif ($succes === 'config'): ?>
<div class="alert success">✓ Configuration enregistrée.</div>
<?php endif; ?>

<?php if ($tab === 'messages'): ?>

<!-- STATS -->
<div class="stats-3col">
    <div class="stat-card"><div class="stat-icon"><svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8"/></svg></div><div><div class="stat-label">Total</div><div class="stat-value"><?= (int)$stats['total'] ?></div></div></div>
    <div class="stat-card"><div class="stat-icon orange"><svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01"/></svg></div><div><div class="stat-label">Non lus</div><div class="stat-value accent"><?= (int)$stats['non_lus'] ?></div></div></div>
    <div class="stat-card"><div class="stat-icon"><svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></div><div><div class="stat-label">Lus</div><div class="stat-value"><?= (int)$stats['lus'] ?></div></div></div>
</div>

<div class="table-wrap">
<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Message</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if (empty($messages)): ?>
    <tr><td colspan="5" class="empty-sm">Aucun message.</td></tr>
    <?php else: ?>
    <?php foreach ($messages as $m): ?>
    <tr class="<?= !$m['lu'] ? 'unread' : '' ?>">
        <td>
            <?php if (!$m['lu']): ?><span class="puce-non-lu"></span><?php endif; ?>
            <?= e($m['nom']) ?>
        </td>
        <td><?= e($m['email']) ?></td>
        <td><?= e($m['numero'] ?: '—') ?></td>
        <td class="cell-message">
            <?= e(substr($m['message'], 0, 55)) ?>…
        </td>
        <td>
            <div class="actions">
                <!-- "Voir" reste un LIEN : il ne fait qu'afficher le message. -->
                <a class="btn btn-ghost btn-sm" href="?action=voir&id=<?= (int)$m['id_contact'] ?>">Voir</a>

                <!-- Marquer lu / non lu : FORMULAIRE POST, car cela modifie la base. -->
                <form method="POST" class="form-action">
                    <?php csrf_champ(); ?>
                    <input type="hidden" name="id_marquer" value="<?= (int)$m['id_contact'] ?>">
                    <input type="hidden" name="nouvel_etat" value="<?= $m['lu'] ? 0 : 1 ?>">
                    <button class="btn btn-ghost btn-sm" name="marquer"><?= $m['lu'] ? 'Non lu' : 'Lu' ?></button>
                </form>

                <!-- Suppression : FORMULAIRE POST, avec une confirmation. -->
                <form method="POST" class="form-action">
                    <?php csrf_champ(); ?>
                    <input type="hidden" name="id_suppr" value="<?= (int)$m['id_contact'] ?>">
                    <button class="btn btn-danger btn-sm" name="supprimer"
                            data-confirm="Supprimer ce message ?">✕</button>
                </form>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
</div>

<?php else: ?>
<!-- CONFIGURATION -->
<div class="card">
    <div class="card-header">Informations de contact</div>
    <form method="POST">

        <!-- Jeton anti-CSRF : prouve que le formulaire vient bien de notre site -->
        <?php csrf_champ(); ?>

        <div class="form-grid">
            <div class="form-group full">
                <label class="form-label">Adresse</label>
                <input class="form-input" type="text" name="adresse" value="<?= e($config['adresse'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input class="form-input" type="text" name="email_config" value="<?= e($config['email'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Téléphone</label>
                <input class="form-input" type="text" name="telephone" value="<?= e($config['telephone'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Latitude</label>
                <input class="form-input" type="text" id="lat" name="lat" value="<?= e($lat) ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Longitude</label>
                <input class="form-input" type="text" id="lng" name="lng" value="<?= e($lng) ?>">
            </div>
        </div>
        <div class="bloc-carte">
            <div id="map" class="carte-map" data-lat="<?= e($lat) ?>" data-lng="<?= e($lng) ?>"></div>
            <p class="aide-champ">Glissez le marqueur pour ajuster la position.</p>
        </div>
        <div class="form-footer">
            <button class="btn btn-primary" name="save_config">Enregistrer</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>
<?php endif; ?>
</div>

<!-- FENÊTRE : voir le message complet -->
<?php if ($msg_detail): ?>
<div class="modal-overlay open" data-close-href="admin_contact.php">
<div class="modal">
    <h3>Message de <?= e($msg_detail['nom']) ?></h3>
    <div class="msg-entete">
        <div class="msg-meta">📧 <?= e($msg_detail['email']) ?></div>
        <?php if ($msg_detail['numero']): ?>
        <div class="msg-meta">📞 <?= e($msg_detail['numero']) ?></div>
        <?php endif; ?>
    </div>
    <div class="msg-corps"><?= e($msg_detail['message']) ?></div>
    <div class="modal-footer">
        <a href="admin_contact.php" class="btn btn-ghost">Fermer</a>
        <a href="mailto:<?= e($msg_detail['email']) ?>" class="btn btn-primary">Répondre</a>
    </div>
</div>
</div>
<?php endif; ?>

<script src="../js/admin/contact.js"></script>

<?php require __DIR__ . '/layout_bas.php'; ?>
