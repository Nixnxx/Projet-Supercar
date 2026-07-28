<?php
// ============================================================
//  vues/admin/essais_vue.php  —  VUE : demandes d'essai
//  Reçoit : $essais, $detail, $filtre, $succes, $statuts_labels, $statuts_class.
// ============================================================
require __DIR__ . '/layout_haut.php';
?>

<div class="page">
<div class="page-header">
    <h2>Demandes d'essai</h2>
    <span class="page-sub"><?= count($essais) ?> demandes</span>
</div>

<?php if ($succes): ?>
<div class="alert success">✓ Mise à jour effectuée.</div>
<?php endif; ?>

<!-- FILTRES -->
<div class="filtres">
    <a href="admin_essais.php" class="btn <?= $filtre<0?'btn-primary':'btn-ghost' ?>">Tout</a>
    <a href="?filtre=0" class="btn <?= $filtre===0?'btn-primary':'btn-ghost' ?>">En attente</a>
    <a href="?filtre=1" class="btn <?= $filtre===1?'btn-primary':'btn-ghost' ?>">Confirmés</a>
    <a href="?filtre=2" class="btn <?= $filtre===2?'btn-primary':'btn-ghost' ?>">Refusés</a>
    <a href="?filtre=3" class="btn <?= $filtre===3?'btn-primary':'btn-ghost' ?>">Terminés</a>
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
        <td style="font-family:'DM Mono',monospace;color:var(--text-dim)"><?= (int)$e['id_demande'] ?></td>
        <td>
            <div style="color:var(--text);font-weight:500"><?= e($e['nom'].' '.$e['prenom']) ?></div>
            <div style="font-size:11px;color:var(--text-dim)"><?= e($e['email']) ?></div>
        </td>
        <td><?= e($e['model']) ?></td>
        <td style="font-family:'DM Mono',monospace"><?= $e['date_essai_proposee'] ? date('d/m/Y', strtotime($e['date_essai_proposee'])) : '—' ?></td>
        <td><span class="badge <?= $statuts_class[$e['statut']] ?>"><?= $statuts_labels[$e['statut']] ?></span></td>
        <td>
            <div class="actions">
                <a class="btn btn-ghost btn-sm" href="?action=detail&id=<?= (int)$e['id_demande'] ?>">Gérer</a>
                <a class="btn btn-danger btn-sm" href="?action=supprimer&id=<?= (int)$e['id_demande'] ?>"
                   data-confirm="Supprimer cette demande ?">✕</a>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
</div>

</div><!-- /page -->

<!-- FENÊTRE DÉTAIL -->
<?php if ($detail): ?>
<div class="modal-overlay open" id="modalOverlay" data-close-href="admin_essais.php">
<div class="modal">
    <h3>Demande #<?= (int)$detail['id_demande'] ?></h3>

    <div class="form-2col">
        <div>
            <div class="form-label" style="font-size:10px;text-transform:uppercase;letter-spacing:.6px;color:var(--text-dim);margin-bottom:3px;">Client</div>
            <div style="color:var(--text)"><?= e($detail['nom'].' '.$detail['prenom']) ?></div>
            <div style="font-size:12px;color:var(--text-dim)"><?= e($detail['email']) ?></div>
            <div style="font-size:12px;color:var(--text-dim)"><?= e($detail['telephone']) ?></div>
        </div>
        <div>
            <div class="form-label" style="font-size:10px;text-transform:uppercase;letter-spacing:.6px;color:var(--text-dim);margin-bottom:3px;">Voiture</div>
            <div style="color:var(--text)"><?= e($detail['model']) ?></div>
            <div style="font-size:12px;color:var(--text-dim)">Date : <?= $detail['date_essai_proposee'] ? date('d/m/Y', strtotime($detail['date_essai_proposee'])) : '—' ?></div>
        </div>
    </div>

    <form method="POST">
        <input type="hidden" name="id_demande" value="<?= (int)$detail['id_demande'] ?>">
        <div class="form-group" style="margin-bottom:12px;">
            <label class="form-label">Statut</label>
            <select class="form-select" name="statut">
                <option value="0" <?= $detail['statut']==0?'selected':'' ?>>En attente</option>
                <option value="1" <?= $detail['statut']==1?'selected':'' ?>>Confirmé</option>
                <option value="2" <?= $detail['statut']==2?'selected':'' ?>>Refusé</option>
                <option value="3" <?= $detail['statut']==3?'selected':'' ?>>Terminé</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Commentaire</label>
            <textarea class="form-textarea" name="commentaire"><?= e($detail['commentaire'] ?? '') ?></textarea>
        </div>
        <div class="modal-footer">
            <a href="admin_essais.php" class="btn btn-ghost">Fermer</a>
            <button class="btn btn-primary" name="set_statut">Enregistrer</button>
        </div>
    </form>
</div>
</div>
<?php endif; ?>

<script src="../js/admin/essais.js"></script>

<?php require __DIR__ . '/layout_bas.php'; ?>
