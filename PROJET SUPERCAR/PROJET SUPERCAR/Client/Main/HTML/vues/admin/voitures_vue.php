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
<div class="page-toolbar">

    <div class="filtres">
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
        <td class="cell-mono-dim"><?= (int)$v['id_voiture'] ?></td>
        <td>
            <div class="cell-titre"><?= e($v['model']) ?></div>
            <div class="cell-sous">
                <?= $v['specs'] ? e(substr($v['specs'], 0, 55)) . '…' : '—' ?>
            </div>
        </td>
        <td><?= e($v['marque']) ?></td>
        <td class="cell-mono">
            <?= $v['annee'] ? date('Y', strtotime($v['annee'])) : '—' ?>
        </td>
        <td class="cell-mono">
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
                echo '<span class="txt-dim">—</span>';
            ?>
        </td>
        <td class="cell-mono-prix">
            <?= $v['prix'] ? number_format($v['prix'], 0, ',', ' ') . ' Rs' : '—' ?>
        </td>
        <td>
            <div class="actions">
                <!-- "Modifier" reste un LIEN : il ne fait qu'afficher un formulaire. -->
                <a class="btn btn-ghost btn-sm" href="?action=detail&id=<?= (int)$v['id_voiture'] ?>">Modifier</a>

                <!-- "Supprimer" est un FORMULAIRE POST : il modifie la base,
                     donc il ne doit pas être déclenchable par une simple adresse. -->
                <form method="POST" class="form-action">
                    <?php csrf_champ(); ?>
                    <input type="hidden" name="id_suppr" value="<?= (int)$v['id_voiture'] ?>">
                    <button class="btn btn-danger btn-sm" name="supprimer"
                            data-confirm="Supprimer <?= e($v['model']) ?> ?">✕</button>
                </form>
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
<div class="modal modal-lg">

    <h3>Modifier — <?= e($detail['model']) ?></h3>

    <form method="POST">

        <!-- Jeton anti-CSRF : prouve que le formulaire vient bien de notre site -->
        <?php csrf_champ(); ?>

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
                <label class="form-label">Transmission</label>
                <select class="form-select" name="transmission">
                    <?php foreach (['Manuelle', 'Automatique'] as $t): ?>
                    <option value="<?= $t ?>"
                        <?= trim($detail['transmission'] ?? '') == $t ? 'selected' : '' ?>>
                        <?= $t ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group espace-sm">
            <label class="form-label">Prix (Rs)</label>
            <input class="form-input" type="number" name="prix" min="0"
                   value="<?= e($detail['prix'] ?? '') ?>"
                   placeholder="ex : 2500000">
        </div>

        <div class="form-group espace">
            <label class="form-label">Description / Specs</label>
            <textarea class="form-textarea" name="specs"><?= e($detail['specs'] ?? '') ?></textarea>
        </div>

        <div class="modal-footer">
            <a href="admin_voitures.php" class="btn btn-ghost">Fermer</a>
            <button class="btn btn-primary" name="set_voiture">Enregistrer</button>
        </div>
    </form>

    <!-- ─── PHOTOS DU SLIDER ─── -->
    <div class="bloc-photos">
        <div class="form-label espace">
            📸 Photos du slider (<?= count($photos_slider) ?> photo<?= count($photos_slider) > 1 ? 's' : '' ?>)
        </div>

        <?php if (!empty($photos_slider)): ?>
        <div class="galerie-photos">
            <?php foreach ($photos_slider as $ph): ?>
            <div class="photo-vignette">
                <img src="../<?= e($ph['image']) ?>" alt="">
                <!-- Suppression d'une photo : FORMULAIRE POST avec confirmation.
                     Le formulaire est en display:inline (.form-action), il ne
                     perturbe donc pas le positionnement du bouton en absolu. -->
                <form method="POST" class="form-action">
                    <?php csrf_champ(); ?>
                    <input type="hidden" name="id_photo_suppr" value="<?= (int)$ph['id'] ?>">
                    <input type="hidden" name="id_voiture_photo_suppr" value="<?= (int)$detail['id_voiture'] ?>">
                    <button class="btn-suppr-photo" name="supprimer_photo"
                            data-confirm="Supprimer cette photo ?">✕</button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="photos-vide">Aucune photo pour l'instant.</div>
        <?php endif; ?>

        <!-- Formulaire upload d'une nouvelle photo -->
        <form method="POST" enctype="multipart/form-data">

            <!-- Jeton anti-CSRF : prouve que le formulaire vient bien de notre site -->
            <?php csrf_champ(); ?>

            <input type="hidden" name="id_voiture_photo" value="<?= (int)$detail['id_voiture'] ?>">
            <div class="ligne-upload">
                <input class="form-input" type="file" name="nouvelle_photo" id="inputNouvellePhoto"
                       accept="image/*">
                <button class="btn btn-primary btn-sm" name="add_photo">+ Ajouter</button>
            </div>
            <img id="previewNouvellePhoto" class="apercu-photo" alt="aperçu">
            <div class="aide-formats">
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
<div class="modal modal-lg">

    <h3>Ajouter un véhicule</h3>

    <form method="POST" enctype="multipart/form-data">

        <!-- Jeton anti-CSRF : prouve que le formulaire vient bien de notre site -->
        <?php csrf_champ(); ?>


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
                <label class="form-label">Transmission</label>
                <select class="form-select" name="transmission">
                    <option value="Manuelle">Manuelle</option>
                    <option value="Automatique">Automatique</option>
                </select>
            </div>
        </div>

        <div class="form-group espace-sm">
            <label class="form-label">Prix (Rs) *</label>
            <input class="form-input" type="number" name="prix" min="0" required
                   placeholder="ex : 2500000">
        </div>

        <div class="form-group espace-sm">
            <label class="form-label">Description / Specs</label>
            <textarea class="form-textarea" name="specs"
                      placeholder="Décrivez le moteur, les performances..."></textarea>
        </div>

        <div class="form-group bloc-photos-ajout">
            <label class="form-label espace-sm">📸 Photos du slider</label>
            <div class="aide-photos">
                Sélectionne une ou plusieurs photos. La 1ère sera l'image principale.
            </div>

            <input class="form-input" type="file" name="photos_slider[]" id="inputPhotosMultiple"
                   accept="image/*" multiple>

            <div id="previewsContainer" class="apercus-multiples"></div>

            <div class="aide-champ">
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
