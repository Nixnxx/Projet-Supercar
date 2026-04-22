<?php
require('lienbd.php');

$action  = $_GET['action'] ?? '';
$id      = intval($_GET['id'] ?? 0);
$tab     = $_GET['tab'] ?? 'messages';
$succes  = $_GET['succes'] ?? '';

// supprimer
if ($action === 'supprimer' && $id > 0) {
    $s = mysqli_prepare($lienbd, "DELETE FROM contact WHERE id_contact=?");
    mysqli_stmt_bind_param($s, 'i', $id);
    mysqli_stmt_execute($s);
    header('Location: admin_contact.php?succes=supprime'); exit();
}

// lu / non lu
if (($action === 'lu' || $action === 'nonlu') && $id > 0) {
    $val = ($action === 'lu') ? 1 : 0;
    $s = mysqli_prepare($lienbd, "UPDATE contact SET lu=? WHERE id_contact=?");
    mysqli_stmt_bind_param($s, 'ii', $val, $id);
    mysqli_stmt_execute($s);
    header('Location: admin_contact.php'); exit();
}

// suppression multiple
if (isset($_POST['supprimer_selection']) && !empty($_POST['ids'])) {
    $ids = array_map('intval', $_POST['ids']);
    $ph = implode(',', array_fill(0, count($ids), '?'));
    $s = mysqli_prepare($lienbd, "DELETE FROM contact WHERE id_contact IN ($ph)");
    mysqli_stmt_bind_param($s, str_repeat('i', count($ids)), ...$ids);
    mysqli_stmt_execute($s);
    header('Location: admin_contact.php?succes=supprime'); exit();
}

// sauvegarde config
if (isset($_POST['save_config'])) {
    $adr = htmlspecialchars($_POST['adresse']);
    $em  = htmlspecialchars($_POST['email_config']);
    $tel = htmlspecialchars($_POST['telephone']);
    $lat = floatval($_POST['lat']);
    $lng = floatval($_POST['lng']);
    $map = "https://maps.google.com/maps?q={$lat},{$lng}&z=15&output=embed";
    $s = mysqli_prepare($lienbd,
        "UPDATE contact_config SET adresse=?, email=?, telephone=?, map_embed=? WHERE id_config=1");
    mysqli_stmt_bind_param($s, 'ssss', $adr, $em, $tel, $map);
    mysqli_stmt_execute($s);
    header('Location: admin_contact.php?tab=config&succes=config'); exit();
}

// DATA
$res = mysqli_query($lienbd, "SELECT * FROM contact ORDER BY id_contact DESC");
$messages = mysqli_fetch_all($res, MYSQLI_ASSOC);

$stats = mysqli_fetch_assoc(mysqli_query($lienbd,
    "SELECT COUNT(*) total, SUM(lu=0) non_lus, SUM(lu=1) lus FROM contact"));

$config = mysqli_fetch_assoc(mysqli_query($lienbd,
    "SELECT * FROM contact_config WHERE id_config=1"));

$lat = -20.2447; $lng = 57.4809;
if (!empty($config['map_embed']) && preg_match('/q=([-\d.]+),([-\d.]+)/', $config['map_embed'], $m)) {
    $lat = $m[1]; $lng = $m[2];
}

// Détail message
$msg_detail = null;
if ($action === 'voir' && $id > 0) {
    $s = mysqli_prepare($lienbd, "SELECT * FROM contact WHERE id_contact=?");
    mysqli_stmt_bind_param($s, 'i', $id);
    mysqli_stmt_execute($s);
    $msg_detail = mysqli_fetch_assoc(mysqli_stmt_get_result($s));
    // marquer lu
    $su = mysqli_prepare($lienbd, "UPDATE contact SET lu=1 WHERE id_contact=?");
    mysqli_stmt_bind_param($su, 'i', $id);
    mysqli_stmt_execute($su);
}
?>

<?php
require('fonction.php');
if (!est_connecte()) {
    header('Location: login.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Admin — Messages</title>
<?php include 'admin_style.php'; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css">
</head>
<body>
<?php include 'admin_nav.php'; ?>

<div class="page">
<div class="page-header">
    <h2>Messages</h2>
    <span class="page-sub">Gestion des contacts</span>
</div>

<!-- TABS internes -->
<div style="display:flex;gap:4px;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:4px;width:fit-content;margin-bottom:24px;">
    <a href="?tab=messages" style="padding:6px 16px;border-radius:6px;text-decoration:none;font-size:13px;font-weight:500;
        <?= $tab==='messages' ? 'background:var(--accent);color:#fff' : 'color:var(--text-muted)' ?>">
        Messages
        <?php if ($stats['non_lus'] > 0 && $tab!=='messages'): ?>
        <span style="background:#ff6b00;color:#fff;font-size:10px;padding:1px 6px;border-radius:20px;margin-left:4px"><?= $stats['non_lus'] ?></span>
        <?php endif; ?>
    </a>
    <a href="?tab=config" style="padding:6px 16px;border-radius:6px;text-decoration:none;font-size:13px;font-weight:500;
        <?= $tab==='config' ? 'background:var(--accent);color:#fff' : 'color:var(--text-muted)' ?>">
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
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:24px;">
    <div class="stat-card"><div class="stat-icon"><svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8"/></svg></div><div><div class="stat-label">Total</div><div class="stat-value"><?= $stats['total'] ?></div></div></div>
    <div class="stat-card"><div class="stat-icon orange"><svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01"/></svg></div><div><div class="stat-label">Non lus</div><div class="stat-value" style="color:var(--accent)"><?= $stats['non_lus'] ?></div></div></div>
    <div class="stat-card"><div class="stat-icon"><svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></div><div><div class="stat-label">Lus</div><div class="stat-value"><?= $stats['lus'] ?></div></div></div>
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
            <?php if (!$m['lu']): ?><span style="display:inline-block;width:7px;height:7px;background:var(--accent);border-radius:50%;margin-right:6px;vertical-align:middle"></span><?php endif; ?>
            <?= htmlspecialchars($m['nom']) ?>
        </td>
        <td><?= htmlspecialchars($m['email']) ?></td>
        <td><?= htmlspecialchars($m['numero'] ?: '—') ?></td>
        <td style="max-width:240px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:var(--text-dim)">
            <?= htmlspecialchars(substr($m['message'], 0, 55)) ?>…
        </td>
        <td>
            <div class="actions">
                <a class="btn btn-ghost btn-sm" href="?action=voir&id=<?= $m['id_contact'] ?>">Voir</a>
                <a class="btn btn-ghost btn-sm" href="?action=<?= $m['lu']?'nonlu':'lu' ?>&id=<?= $m['id_contact'] ?>"><?= $m['lu']?'Non lu':'Lu' ?></a>
                <a class="btn btn-danger btn-sm" href="?action=supprimer&id=<?= $m['id_contact'] ?>" onclick="return confirm('Supprimer ?')">✕</a>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
</div>

<?php else: ?>
<!-- CONFIG -->
<div class="card">
    <div class="card-header">Informations de contact</div>
    <form method="POST">
        <div class="form-grid">
            <div class="form-group full">
                <label class="form-label">Adresse</label>
                <input class="form-input" type="text" name="adresse" value="<?= htmlspecialchars($config['adresse']) ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input class="form-input" type="text" name="email_config" value="<?= htmlspecialchars($config['email']) ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Téléphone</label>
                <input class="form-input" type="text" name="telephone" value="<?= htmlspecialchars($config['telephone']) ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Latitude</label>
                <input class="form-input" type="text" id="lat" name="lat" value="<?= $lat ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Longitude</label>
                <input class="form-input" type="text" id="lng" name="lng" value="<?= $lng ?>">
            </div>
        </div>
        <div style="padding:0 20px 20px;">
            <div id="map" style="height:240px;border-radius:6px;border:1px solid var(--border);overflow:hidden;"></div>
            <p style="font-size:11px;color:var(--text-dim);margin-top:6px;">Glissez le marqueur pour ajuster la position.</p>
        </div>
        <div class="form-footer">
            <button class="btn btn-primary" name="save_config">Enregistrer</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
var map = L.map('map').setView([<?= $lat ?>, <?= $lng ?>], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
var marker = L.marker([<?= $lat ?>, <?= $lng ?>], {draggable:true}).addTo(map);
marker.on('dragend', function(e){
    var pos = marker.getLatLng();
    document.getElementById('lat').value = pos.lat.toFixed(6);
    document.getElementById('lng').value = pos.lng.toFixed(6);
});
</script>
<?php endif; ?>
</div>

<!-- MODAL : voir message complet -->
<?php if ($msg_detail): ?>
<div class="modal-overlay open" onclick="if(event.target===this)location.href='admin_contact.php'">
<div class="modal">
    <h3>Message de <?= htmlspecialchars($msg_detail['nom']) ?></h3>
    <div style="display:grid;gap:6px;margin-bottom:16px;">
        <div style="font-size:12px;color:var(--text-dim)">📧 <?= htmlspecialchars($msg_detail['email']) ?></div>
        <?php if ($msg_detail['numero']): ?>
        <div style="font-size:12px;color:var(--text-dim)">📞 <?= htmlspecialchars($msg_detail['numero']) ?></div>
        <?php endif; ?>
    </div>
    <div style="background:var(--surface-2);border:1px solid var(--border);border-radius:6px;padding:14px;font-size:13px;color:var(--text);line-height:1.7;white-space:pre-wrap;"><?= htmlspecialchars($msg_detail['message']) ?></div>
    <div class="modal-footer">
        <a href="admin_contact.php" class="btn btn-ghost">Fermer</a>
        <a href="mailto:<?= htmlspecialchars($msg_detail['email']) ?>" class="btn btn-primary">Répondre</a>
    </div>
</div>
</div>
<?php endif; ?>

</body>
</html>
