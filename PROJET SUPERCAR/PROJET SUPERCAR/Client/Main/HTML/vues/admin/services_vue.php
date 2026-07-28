<?php
// ============================================================
//  vues/admin/services_vue.php  —  VUE : services (admin)
//  Reçoit : $services, $detail, $action, $succes.
// ============================================================
require __DIR__ . '/layout_haut.php';
?>

<div class="page">
    <div class="page-header">
        <h2>Services</h2>
        <span class="page-sub"><?= count($services) ?> service(s)</span>
    </div>

    <?php if ($succes === 'update'):   ?><div class="alert success">✓ Mis à jour.</div><?php endif; ?>
    <?php if ($succes === 'ajoute'):   ?><div class="alert success">✓ Ajouté.</div><?php endif; ?>
    <?php if ($succes === 'supprime'): ?><div class="alert success">✕ Supprimé.</div><?php endif; ?>

    <div style="display:flex; justify-content:flex-end; margin-bottom:20px;">
        <a href="?action=ajouter" class="btn btn-primary">+ Ajouter</a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>N°</th>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Icône</th>
                    <th>Tag</th>
                    <th>Description</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $s): ?>
                <tr>
                    <td><?= (int)$s['id_service'] ?></td>
                    <td><?= str_pad($s['numero'], 2, '0', STR_PAD_LEFT) ?></td>
                    <td>
                        <?php if ($s['image']): ?>
                            <img src="../<?= e($s['image']) ?>" style="width:50px; height:35px; object-fit:cover; border-radius:4px;">
                        <?php else: ?>
                            <div style="width:50px; height:35px; background:var(--border); border-radius:4px;"></div>
                        <?php endif; ?>
                    </td>
                    <td style="font-weight:600;"><?= e($s['nom']) ?></td>
                    <td><i class="bi <?= e($s['icone']) ?>"></i> <small><?= e($s['icone']) ?></small></td>
                    <td><small><?= e($s['tag']) ?></small></td>
                    <td style="font-size:12px; color:var(--text-dim);"><?= e(substr($s['description'], 0, 50)) ?>...</td>
                    <td style="text-align:right;">
                        <div class="actions" style="justify-content:flex-end;">
                            <a class="btn btn-ghost btn-sm" href="?action=detail&id=<?= (int)$s['id_service'] ?>">Modifier</a>
                            <a class="btn btn-danger btn-sm" href="?action=supprimer&id=<?= (int)$s['id_service'] ?>"
                               data-confirm="Supprimer ce service ?">✕</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- FENÊTRE MODIFICATION -->
<?php if ($detail): ?>
<div class="modal-overlay open" data-close-href="admin_services.php">
    <div class="modal" style="max-width:400px;">
        <h3 style="margin-bottom:15px;">Modifier Service</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_service" value="<?= (int)$detail['id_service'] ?>">

            <div class="form-group">
                <label class="form-label">Numéro d'ordre</label>
                <input class="form-input" type="number" name="numero" value="<?= (int)$detail['numero'] ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Nom</label>
                <input class="form-input" type="text" name="nom" required value="<?= e($detail['nom']) ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea class="form-textarea" name="description" rows="3" required><?= e($detail['description']) ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Icône Bootstrap (ex: bi-cpu)</label>
                <input class="form-input" type="text" name="icone" value="<?= e($detail['icone']) ?>" placeholder="bi-tools">
            </div>

            <div class="form-group">
                <label class="form-label">Tag</label>
                <input class="form-input" type="text" name="tag" value="<?= e($detail['tag']) ?>" placeholder="Électronique & Moteur">
            </div>

            <div class="form-group">
                <?php if($detail['image']): ?>
                    <div style="margin-bottom:10px; text-align:center; background:var(--bg-card); padding:8px; border-radius:8px; border:1px solid var(--border);">
                        <img src="../<?= e($detail['image']) ?>" style="max-width:100%; height:80px; object-fit:contain; border-radius:4px;">
                        <label style="display:flex; align-items:center; justify-content:center; gap:8px; color:var(--danger); cursor:pointer; font-size:12px; margin-top:8px;">
                            <input type="checkbox" name="remove_image"> 🗑 Retirer l'image
                        </label>
                    </div>
                <?php endif; ?>
                <label class="form-label">Remplacer l'image</label>
                <input class="form-input" type="file" name="image" accept="image/*">
            </div>

            <div class="modal-footer" style="padding-top:10px;">
                <a href="admin_services.php" class="btn btn-ghost">Annuler</a>
                <button type="submit" class="btn btn-primary" name="set_service">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<!-- FENÊTRE AJOUT -->
<?php if ($action === 'ajouter'): ?>
<div class="modal-overlay open" data-close-href="admin_services.php">
    <div class="modal" style="max-width:400px;">
        <h3 style="margin-bottom:15px;">Nouveau Service</h3>
        <form method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label class="form-label">Numéro d'ordre *</label>
                <input class="form-input" type="number" name="numero" required placeholder="1">
            </div>

            <div class="form-group">
                <label class="form-label">Nom *</label>
                <input class="form-input" type="text" name="nom" required placeholder="Titre du service">
            </div>

            <div class="form-group">
                <label class="form-label">Description *</label>
                <textarea class="form-textarea" name="description" rows="4" required placeholder="Détails..."></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Icône Bootstrap (ex: bi-cpu)</label>
                <input class="form-input" type="text" name="icone" placeholder="bi-tools">
            </div>

            <div class="form-group">
                <label class="form-label">Tag</label>
                <input class="form-input" type="text" name="tag" placeholder="Électronique & Moteur">
            </div>

            <div class="form-group">
                <label class="form-label">Image (Optionnel)</label>
                <input class="form-input" type="file" name="image" accept="image/*">
            </div>

            <div class="modal-footer" style="padding-top:10px;">
                <a href="admin_services.php" class="btn btn-ghost">Annuler</a>
                <button type="submit" class="btn btn-primary" name="add_service">Créer</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<script src="../js/admin/services.js"></script>

<?php require __DIR__ . '/layout_bas.php'; ?>
