<?php
// ============================================================
//  vues/admin/voitures_vue.php  —  VUE : voitures (admin)
//  Reçoit : $voitures, $marques, $detail, $photos_slider,
//           $action, $succes, $filtre_marque.
// ============================================================
require __DIR__ . '/layout_haut.php';
?>

<div class="page">

<div class="page-header">
    <h2>Voitures</h2>
    <span class="page-sub"><?= count($voitures) ?> véhicule(s)</span>
</div>

<!-- Messages de confirmation -->
<?php if ($succes === 'update'):  ?><div class="alert success">✓ Voiture mise à jour.</div>
<?php elseif ($succes === 'ajoute'):  ?><div class="alert success">✓ Voiture ajoutée.</div>
<?php elseif ($succes === 'supprime'): ?><div class="alert success">✓ Voiture supprimée.</div>
<?php elseif ($succes === 'photo_ajoutee'): ?><div class="alert success">✓ Photo ajoutée.</div>
<?php elseif ($succes === 'photo_supprime'): ?><div class="alert success">✓ Photo supprimée.</div>
<?php endif; ?>

<!-- ─── Filtres par marque + Bouton Ajouter ─── -->
<div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;margin-bottom:20px;">

    <div style="display:flex;gap:6px;flex-wrap:wrap;">
        <a href="admin_voitures.php"
           class="btn <?= $filtre_marque < 0 ? 'btn-primary' : 'btn-ghost' ?>">Toutes</a>
        <?php foreach ($marques as $m): ?>
        <a href="?marque=<?= (int)$m['id_marque'] ?>"
           class="btn <?= $filtre_marque == $m['id_marque'] ? 'btn-primary' : 'btn-ghost' ?>">
            <?= e($m['nom']) ?>
        </a>
        <?php endforeach; ?>
    </div>

    <a href="?action=ajouter" class="btn btn-primary">+ Ajouter un véhicule</a>
</div>

<!-- ─── TABLEAU ─── -->
<div class="table-wrap">
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Modèle</th>
            <th>Marque</th>
            <th>Année</th>
            <th>Kilométrage</th>
            <th>Carburant</th>
            <th>Prix</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if (empty($voitures)): ?>
    <tr><td colspan="8" class="empty-sm">Aucune voiture.</td></tr>
    <?php else: ?>
    <?php foreach ($voitures as $v): ?>
    <tr>
        <td style="font-family:'DM Mono',monospace;color:var(--text-dim)"><?= (int)$v['id_voiture'] ?></td>
        <td>
            <div style="color:var(--text);font-weight:500"><?= e($v['model']) ?></div>
            <div style="font-size:11px;color:var(--text-dim)">
                <?= $v['specs'] ? e(substr($v['specs'], 0, 55)) . '…' : '—' ?>
            </div>
        </td>
        <td><?= e($v['marque']) ?></td>
        <td style="font-family:'DM Mono',monospace">
            <?= $v['annee'] ? date('Y', strtotime($v['annee'])) : '—' ?>
        </td>
        <td style="font-family:'DM Mono',monospace">
            <?= $v['km'] ? number_format($v['km'], 0, ',', ' ') . ' km' : '—' ?>
        </td>
        <td>
            <?php
            $carb = trim($v['type_carburant'] ?? '');
            if (stripos($carb, 'lectrique') !== false)
                echo '<span class="badge badge-ok">⚡ ' . e($carb) . '</span>';
            elseif (stripos($carb, 'Hybrid') !== false)
                echo '<span class="badge badge-wait">🔋 ' . e($carb) . '</span>';
            elseif ($carb)
                echo '<span class="badge badge-no">⛽ ' . e($carb) . '</span>';
            else
                echo '<span style="color:var(--text-dim)">—</span>';
            ?>
        </td>
        <td style="font-family:'DM Mono',monospace;color:var(--accent)">
            <?= $v['prix'] ? number_format($v['prix'], 0, ',', ' ') . ' Rs' : '—' ?>
        </td>
        <td>
            <div class="actions">
                <a class="btn btn-ghost btn-sm" href="?action=detail&id=<?= (int)$v['id_voiture'] ?>">Modifier</a>
                <a class="btn btn-danger btn-sm" href="?action=supprimer&id=<?= (int)$v['id_voiture'] ?>"
                   data-confirm="Supprimer <?= e($v['model']) ?> ?">✕</a>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
</div>

</div><!-- /page -->


<!-- ═══ FENÊTRE : MODIFIER une voiture ═══ -->
<?php if ($detail): ?>
<div class="modal-overlay open"
     data-close-href="admin_voitures.php">
<div class="modal" style="max-width:560px;">

    <h3>Modifier — <?= e($detail['model']) ?></h3>

    <form method="POST">
        <input type="hidden" name="id_voiture" value="<?= (int)$detail['id_voiture'] ?>">

        <div class="form-2col">
            <div class="form-group">
                <label class="form-label">Modèle</label>
                <input class="form-input" type="text" name="model" required
                       value="<?= e($detail['model'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Marque</label>
                <select class="form-select" name="id_marque">
                    <?php foreach ($marques as $m): ?>
                    <option value="<?= (int)$m['id_marque'] ?>"
                        <?= $detail['id_marque'] == $m['id_marque'] ? 'selected' : '' ?>>
                        <?= e($m['nom']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-2col">
            <div class="form-group">
                <label class="form-label">Année</label>
                <input class="form-input" type="date" name="annee"
                       value="<?= e($detail['annee'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Kilométrage</label>
                <input class="form-input" type="number" name="km" min="0"
                       value="<?= e($detail['km'] ?? '') ?>"
                       placeholder="ex : 45000">
            </div>
        </div>

        <div class="form-2col">
            <div class="form-group">
                <label class="form-label">Type de carburant</label>
                <select class="form-select" name="type_carburant">
                    <?php foreach (['Essence', 'Diesel', 'Électrique', 'Hybrid'] as $t): ?>
                    <option value="<?= $t ?>"
                        <?= trim($detail['type_carburant'] ?? '') == $t ? 'selected' : '' ?>>
                        <?= $t ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Prix (Rs)</label>
                <input class="form-input" type="number" name="prix" min="0"
                       value="<?= e($detail['prix'] ?? '') ?>"
                       placeholder="ex : 2500000">
            </div>
        </div>

        <div class="form-group" style="margin-bottom:16px;">
            <label class="form-label">Description / Specs</label>
            <textarea class="form-textarea" name="specs"><?= e($detail['specs'] ?? '') ?></textarea>
        </div>

        <div class="modal-footer">
            <a href="admin_voitures.php" class="btn btn-ghost">Fermer</a>
            <button class="btn btn-primary" name="set_voiture">Enregistrer</button>
        </div>
    </form>

    <!-- ─── PHOTOS DU SLIDER ─── -->
    <div style="margin-top:20px;padding-top:16px;border-top:1px solid var(--border);">
        <div class="form-label" style="margin-bottom:10px;">
            📸 Photos du slider (<?= count($photos_slider) ?> photo<?= count($photos_slider) > 1 ? 's' : '' ?>)
        </div>

        <?php if (!empty($photos_slider)): ?>
        <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:14px;">
            <?php foreach ($photos_slider as $ph): ?>
            <div style="position:relative;display:inline-block;">
                <img src="../<?= e($ph['image']) ?>"
                     style="width:80px;height:55px;object-fit:cover;border-radius:6px;border:1px solid var(--border);"
                     alt="">
                <!-- Suppression d'une photo : simple lien avec confirmation -->
                <a href="?action=supprimer_photo&id_photo=<?= (int)$ph['id'] ?>&id_voiture=<?= (int)$detail['id_voiture'] ?>"
                   data-confirm="Supprimer cette photo ?"
                   style="position:absolute;top:-6px;right:-6px;background:#e53e3e;color:white;
                          text-decoration:none;border-radius:50%;width:18px;height:18px;
                          font-size:11px;line-height:18px;text-align:center;">✕</a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div style="font-size:12px;color:var(--text-dim);margin-bottom:14px;">Aucune photo pour l'instant.</div>
        <?php endif; ?>

        <!-- Formulaire upload d'une nouvelle photo -->
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_voiture_photo" value="<?= (int)$detail['id_voiture'] ?>">
            <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                <input class="form-input" type="file" name="nouvelle_photo" id="inputNouvellePhoto"
                       accept="image/*" style="flex:1;min-width:180px;">
                <button class="btn btn-primary btn-sm" name="add_photo">+ Ajouter</button>
            </div>
            <img id="previewNouvellePhoto"
                 style="display:none;margin-top:8px;max-height:80px;border-radius:6px;border:1px solid var(--border)"
                 alt="aperçu">
            <div style="font-size:11px;color:var(--text-dim);margin-top:4px;">
                Formats acceptés : JPG, PNG, WEBP, GIF.
            </div>
        </form>
    </div>

</div>
</div>
<?php endif; ?>


<!-- ═══ FENÊTRE : AJOUTER une voiture ═══ -->
<?php if ($action === 'ajouter'): ?>
<div class="modal-overlay open"
     data-close-href="admin_voitures.php">
<div class="modal" style="max-width:560px;">

    <h3>Ajouter un véhicule</h3>

    <form method="POST" enctype="multipart/form-data">

        <div class="form-2col">
            <div class="form-group">
                <label class="form-label">Modèle *</label>
                <input class="form-input" type="text" name="model"
                       required placeholder="ex : Audi A5">
            </div>
            <div class="form-group">
                <label class="form-label">Marque *</label>
                <select class="form-select" name="id_marque">
                    <?php foreach ($marques as $m): ?>
                    <option value="<?= (int)$m['id_marque'] ?>"><?= e($m['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-2col">
            <div class="form-group">
                <label class="form-label">Année</label>
                <input class="form-input" type="date" name="annee">
            </div>
            <div class="form-group">
                <label class="form-label">Kilométrage</label>
                <input class="form-input" type="number" name="km"
                       min="0" placeholder="ex : 45000">
            </div>
        </div>

        <div class="form-2col">
            <div class="form-group">
                <label class="form-label">Type de carburant</label>
                <select class="form-select" name="type_carburant">
                    <option value="Essence">Essence</option>
                    <option value="Diesel">Diesel</option>
                    <option value="Électrique">Électrique</option>
                    <option value="Hybrid">Hybrid</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Prix (Rs) *</label>
                <input class="form-input" type="number" name="prix"
                       min="0" required placeholder="ex : 2500000">
            </div>
        </div>

        <div class="form-group" style="margin-bottom:12px;">
            <label class="form-label">Description / Specs</label>
            <textarea class="form-textarea" name="specs"
                      placeholder="Décrivez le moteur, les performances..."></textarea>
        </div>

        <div class="form-group" style="margin-bottom:16px;padding:12px;background:rgba(255,255,255,0.03);border:1px solid var(--border);border-radius:8px;">
            <label class="form-label" style="margin-bottom:8px;">📸 Photos du slider</label>
            <div style="font-size:11px;color:var(--text-dim);margin-bottom:10px;">
                Sélectionne une ou plusieurs photos. La 1ère sera l'image principale.
            </div>

            <input class="form-input" type="file" name="photos_slider[]" id="inputPhotosMultiple"
                   accept="image/*" multiple>

            <div id="previewsContainer"
                 style="display:flex;flex-wrap:wrap;gap:8px;margin-top:10px;"></div>

            <div style="font-size:11px;color:var(--text-dim);margin-top:6px;">
                Formats acceptés : JPG, PNG, WEBP, GIF.
            </div>
        </div>

        <div class="modal-footer">
            <a href="admin_voitures.php" class="btn btn-ghost">Annuler</a>
            <button class="btn btn-primary" name="add_voiture">Ajouter</button>
        </div>
    </form>

</div>
</div>
<?php endif; ?>

<script src="../js/admin/voitures.js"></script>

<?php require __DIR__ . '/layout_bas.php'; ?>
