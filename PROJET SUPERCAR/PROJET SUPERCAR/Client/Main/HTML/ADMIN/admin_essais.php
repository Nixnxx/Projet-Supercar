<?php
require('lienbd.php');
require('fonction.php');
if (!est_connecte()) {
    header('Location: login.html');
    exit();
}

$action = $_GET['action'] ?? '';
$id     = intval($_GET['id'] ?? 0);
$succes = $_GET['succes'] ?? '';

$statuts_labels = ['0' => 'En attente', '1' => 'Confirmé', '2' => 'Refusé'];
$statuts_class  = ['0' => 'badge-wait', '1' => 'badge-ok',  '2' => 'badge-no'];

// ─── ACTIONS ───
if ($action === 'supprimer' && $id > 0) {
    $s = mysqli_prepare($lienbd, "DELETE FROM demandeessai WHERE id_demande=?");
    mysqli_stmt_bind_param($s, 'i', $id);
    mysqli_stmt_execute($s);
    header('Location: admin_essais.php?succes=supprime'); exit();
}

if (isset($_POST['set_statut'])) {
    $nid  = intval($_POST['id_demande']);
    $stat = intval($_POST['statut']);
    $com  = $_POST['commentaire'];
    $s = mysqli_prepare($lienbd,
        "UPDATE demandeessai SET statut=?, commentaire=? WHERE id_demande=?");
    mysqli_stmt_bind_param($s, 'isi', $stat, $com, $nid);
    mysqli_stmt_execute($s);
    header('Location: admin_essais.php?succes=update'); exit();
}

// Filtre statut
$filtre = isset($_GET['filtre']) ? intval($_GET['filtre']) : -1;
$where  = $filtre >= 0 ? "WHERE d.statut=$filtre" : '';

$essais = mysqli_fetch_all(mysqli_query($lienbd,
    "SELECT d.*, v.model, c.nom, c.prenom, c.email, c.telephone
     FROM demandeessai d
     JOIN voiture v ON v.id_voiture = d.id_voiture
     JOIN client c ON c.id_client = d.id_client
     $where
     ORDER BY d.id_demande DESC"), MYSQLI_ASSOC);

// Détail pour modal
$detail = null;
if ($action === 'detail' && $id > 0) {
    $s = mysqli_prepare($lienbd,
        "SELECT d.*, v.model, c.nom, c.prenom, c.email, c.telephone
         FROM demandeessai d
         JOIN voiture v ON v.id_voiture=d.id_voiture
         JOIN client c ON c.id_client=d.id_client
         WHERE d.id_demande=?");
    mysqli_stmt_bind_param($s, 'i', $id);
    mysqli_stmt_execute($s);
    $detail = mysqli_fetch_assoc(mysqli_stmt_get_result($s));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Admin — Essais</title>
<?php include 'admin_style.php'; ?>
</head>
<body>
<?php include 'admin_nav.php'; ?>

<div class="page">
<div class="page-header">
    <h2>Demandes d'essai</h2>
    <span class="page-sub"><?= count($essais) ?> demandes</span>
</div>

<?php if ($succes): ?>
<div class="alert success">✓ Mise à jour effectuée.</div>
<?php endif; ?>

<!-- FILTRES -->
<div style="display:flex;gap:6px;margin-bottom:20px;">
    <a href="admin_essais.php" class="btn <?= $filtre<0?'btn-primary':'btn-ghost' ?>">Tout</a>
    <a href="?filtre=0" class="btn <?= $filtre===0?'btn-primary':'btn-ghost' ?>">En attente</a>
    <a href="?filtre=1" class="btn <?= $filtre===1?'btn-primary':'btn-ghost' ?>">Confirmés</a>
    <a href="?filtre=2" class="btn <?= $filtre===2?'btn-primary':'btn-ghost' ?>">Refusés</a>
</div>

<div class="table-wrap">
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Client</th>
            <th>Voiture</th>
            <th>Date souhaitée</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if (empty($essais)): ?>
    <tr><td colspan="6" class="empty-sm">Aucune demande.</td></tr>
    <?php else: ?>
    <?php foreach ($essais as $e): ?>
    <tr>
        <td style="font-family:'DM Mono',monospace;color:var(--text-dim)"><?= $e['id_demande'] ?></td>
        <td>
            <div style="color:var(--text);font-weight:500"><?= htmlspecialchars($e['nom'].' '.$e['prenom']) ?></div>
            <div style="font-size:11px;color:var(--text-dim)"><?= htmlspecialchars($e['email']) ?></div>
        </td>
        <td><?= htmlspecialchars($e['model']) ?></td>
        <td style="font-family:'DM Mono',monospace"><?= $e['date_essai_proposee'] ? date('d/m/Y', strtotime($e['date_essai_proposee'])) : '—' ?></td>
        <td><span class="badge <?= $statuts_class[$e['statut']] ?>"><?= $statuts_labels[$e['statut']] ?></span></td>
        <td>
            <div class="actions">
                <a class="btn btn-ghost btn-sm" href="?action=detail&id=<?= $e['id_demande'] ?>">Gérer</a>
                <a class="btn btn-danger btn-sm" href="?action=supprimer&id=<?= $e['id_demande'] ?>"
                   onclick="return confirm('Supprimer cette demande ?')">✕</a>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
</div>

</div><!-- /page -->

<!-- MODAL DETAIL -->
<?php if ($detail): ?>
<div class="modal-overlay open" id="modalOverlay" onclick="if(event.target===this)location.href='admin_essais.php'">
<div class="modal">
    <h3>Demande #<?= $detail['id_demande'] ?></h3>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:16px;">
        <div>
            <div class="form-label" style="font-size:10px;text-transform:uppercase;letter-spacing:.6px;color:var(--text-dim);margin-bottom:3px;">Client</div>
            <div style="color:var(--text)"><?= htmlspecialchars($detail['nom'].' '.$detail['prenom']) ?></div>
            <div style="font-size:12px;color:var(--text-dim)"><?= htmlspecialchars($detail['email']) ?></div>
            <div style="font-size:12px;color:var(--text-dim)"><?= htmlspecialchars($detail['telephone']) ?></div>
        </div>
        <div>
            <div class="form-label" style="font-size:10px;text-transform:uppercase;letter-spacing:.6px;color:var(--text-dim);margin-bottom:3px;">Voiture</div>
            <div style="color:var(--text)"><?= htmlspecialchars($detail['model']) ?></div>
            <div style="font-size:12px;color:var(--text-dim)">Date : <?= $detail['date_essai_proposee'] ? date('d/m/Y', strtotime($detail['date_essai_proposee'])) : '—' ?></div>
        </div>
    </div>

    <form method="POST">
        <input type="hidden" name="id_demande" value="<?= $detail['id_demande'] ?>">
        <div class="form-group" style="margin-bottom:12px;">
            <label class="form-label">Statut</label>
            <select class="form-select" name="statut">
                <option value="0" <?= $detail['statut']==0?'selected':'' ?>>En attente</option>
                <option value="1" <?= $detail['statut']==1?'selected':'' ?>>Confirmé</option>
                <option value="2" <?= $detail['statut']==2?'selected':'' ?>>Refusé</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Commentaire</label>
            <textarea class="form-textarea" name="commentaire"><?= htmlspecialchars($detail['commentaire'] ?? '') ?></textarea>
        </div>
        <div class="modal-footer">
            <a href="admin_essais.php" class="btn btn-ghost">Fermer</a>
            <button class="btn btn-primary" name="set_statut">Enregistrer</button>
        </div>
    </form>
</div>
</div>
<?php endif; ?>

</body>
</html>
