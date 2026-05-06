<?php
require('lienbd.php');
require('fonction.php');
if (!est_connecte()) {
    header('Location: logina.php');
    exit();
}

$action = $_GET['action'] ?? '';
$id     = intval($_GET['id'] ?? 0);
$succes = $_GET['succes'] ?? '';

// SUPPRESSION D'UNE PHOTO du slider
if ($action === 'supprimer_photo' && $id > 0) {
    $id_voiture_retour = intval($_GET['id_voiture'] ?? 0);
    $s = mysqli_prepare($lienbd, "DELETE FROM voiture_images WHERE id=?");
    mysqli_stmt_bind_param($s, 'i', $id);
    mysqli_stmt_execute($s);
    header('Location: admin_voitures.php?action=detail&id=' . $id_voiture_retour . '&succes=photo_supprime');
    exit();
}

// AJOUT D'UNE PHOTO dans le slider 
if (isset($_POST['add_photo'])) {
    $id_voiture_photo = intval($_POST['id_voiture_photo']);
    if (!empty($_FILES['nouvelle_photo']['name'])) {
        $nom_fichier = 'Images-Index/' . basename($_FILES['nouvelle_photo']['name']);
        move_uploaded_file($_FILES['nouvelle_photo']['tmp_name'], '../' . $nom_fichier);
        $res_ordre = mysqli_query($lienbd, "SELECT MAX(ordre) as max_ordre FROM voiture_images WHERE id_voiture=$id_voiture_photo");
        $row_ordre = mysqli_fetch_assoc($res_ordre);
        $prochain_ordre = ($row_ordre['max_ordre'] ?? 0) + 1;
        $s = mysqli_prepare($lienbd, "INSERT INTO voiture_images (id_voiture, image, ordre) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($s, 'isi', $id_voiture_photo, $nom_fichier, $prochain_ordre);
        mysqli_stmt_execute($s);
    }
    header('Location: admin_voitures.php?action=detail&id=' . $id_voiture_photo . '&succes=photo_ajoutee');
    exit();
}

// ─── SUPPRESSION ───
if ($action === 'supprimer' && $id > 0) {
    // Supprimer les images liées dans voiture_images
    $s = mysqli_prepare($lienbd, "DELETE FROM voiture_images WHERE id_voiture=?");
    mysqli_stmt_bind_param($s, 'i', $id);
    mysqli_stmt_execute($s);
    // Supprimer la voiture
    $s = mysqli_prepare($lienbd, "DELETE FROM voiture WHERE id_voiture=?");
    mysqli_stmt_bind_param($s, 'i', $id);
    mysqli_stmt_execute($s);
    header('Location: admin_voitures.php?succes=supprime');
    exit();
}

// ─── MODIFICATION (POST depuis modal) ───
if (isset($_POST['set_voiture'])) {
    $nid       = intval($_POST['id_voiture']);
    $model     = $_POST['model'];
    $annee     = $_POST['annee'];
    $km        = intval($_POST['km']);
    $carburant = $_POST['type_carburant'];
    $prix      = intval($_POST['prix']);
    $specs     = $_POST['specs'];
    $id_marque = intval($_POST['id_marque']);

    $s = mysqli_prepare($lienbd,
        "UPDATE voiture SET model=?, annee=?, km=?, type_carburant=?, prix=?, specs=?, id_marque=?
         WHERE id_voiture=?");
    // Ordre des types : s=model, s=annee, i=km, s=carburant, i=prix, s=specs, i=id_marque, i=id_voiture
    mysqli_stmt_bind_param($s, 'ssisisii', $model, $annee, $km, $carburant, $prix, $specs, $id_marque, $nid);
    mysqli_stmt_execute($s);
    header('Location: admin_voitures.php?succes=update');
    exit();
}

// ─── AJOUT (POST depuis modal) ───
if (isset($_POST['add_voiture'])) {
    $model     = $_POST['model'];
    $annee     = $_POST['annee'];
    $km        = intval($_POST['km']);
    $carburant = $_POST['type_carburant'];
    $prix      = intval($_POST['prix']);
    $specs     = $_POST['specs'];
    $id_marque = intval($_POST['id_marque']);
    $image     = '';

    // Upload toutes les photos du slider
    $photos_uploadees = [];
    if (!empty($_FILES['photos_slider']['name'][0])) {
        foreach ($_FILES['photos_slider']['name'] as $i => $nom) {
            if ($nom) {
                $chemin = 'Images-Index/' . basename($nom);
                move_uploaded_file($_FILES['photos_slider']['tmp_name'][$i], '../' . $chemin);
                $photos_uploadees[] = $chemin;
            }
        }
    }

    // La 1ère photo = image principale de la voiture
    $image = !empty($photos_uploadees) ? $photos_uploadees[0] : '';

    $s = mysqli_prepare($lienbd,
        "INSERT INTO voiture (model, annee, km, type_carburant, prix, specs, image, id_marque)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    // s=model, s=annee, i=km, s=carburant, i=prix, s=specs, s=image, i=id_marque
    mysqli_stmt_bind_param($s, 'ssisissi', $model, $annee, $km, $carburant, $prix, $specs, $image, $id_marque);
    mysqli_stmt_execute($s);

    // Insérer toutes les photos dans voiture_images
    if (!empty($photos_uploadees)) {
        $new_id = mysqli_insert_id($lienbd);
        $s2 = mysqli_prepare($lienbd, "INSERT INTO voiture_images (id_voiture, image, ordre) VALUES (?, ?, ?)");
        foreach ($photos_uploadees as $ordre => $chemin) {
            mysqli_stmt_bind_param($s2, 'isi', $new_id, $chemin, $ordre);
            mysqli_stmt_execute($s2);
        }
    }

    header('Location: admin_voitures.php?succes=ajoute');
    exit();
}

// ─── Filtre par marque ───
$filtre_marque = isset($_GET['marque']) ? intval($_GET['marque']) : -1;
$where = $filtre_marque > 0 ? "WHERE v.id_marque=$filtre_marque" : '';

// ─── Liste des voitures ───
$voitures = mysqli_fetch_all(mysqli_query($lienbd,
    "SELECT v.*, m.nom as marque
     FROM voiture v
     JOIN marque m ON m.id_marque = v.id_marque
     $where
     ORDER BY m.nom, v.model"), MYSQLI_ASSOC);

// ─── Liste des marques (pour filtres + formulaires) ───
$marques = mysqli_fetch_all(mysqli_query($lienbd,
    "SELECT * FROM marque ORDER BY nom"), MYSQLI_ASSOC);

// ─── Détail voiture pour modal modification ───
$detail = null;
if ($action === 'detail' && $id > 0) {
    $s = mysqli_prepare($lienbd, "SELECT * FROM voiture WHERE id_voiture=?");
    mysqli_stmt_bind_param($s, 'i', $id);
    mysqli_stmt_execute($s);
    $detail = mysqli_fetch_assoc(mysqli_stmt_get_result($s));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Admin — Voitures</title>
<?php include 'admin_style.php'; ?>
</head>
<body>
<?php include 'admin_nav.php'; ?>

<div class="page">

<div class="page-header">
    <h2>Voitures</h2>
    <span class="page-sub"><?= count($voitures) ?> véhicule(s)</span>
</div>

<!-- Messages de confirmation -->
<?php if ($succes === 'update'):  ?><div class="alert success">✓ Voiture mise à jour.</div>
<?php elseif ($succes === 'ajoute'):  ?><div class="alert success">✓ Voiture ajoutée.</div>
<?php elseif ($succes === 'supprime'): ?><div class="alert success">✓ Voiture supprimée.</div>
<?php endif; ?>

<!-- ─── BARRE : Filtres par marque + Bouton Ajouter ─── -->
<div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;margin-bottom:20px;">

    <!-- Filtres (même style que admin_essais) -->
    <div style="display:flex;gap:6px;flex-wrap:wrap;">
        <a href="admin_voitures.php"
           class="btn <?= $filtre_marque < 0 ? 'btn-primary' : 'btn-ghost' ?>">Toutes</a>
        <?php foreach ($marques as $m): ?>
        <a href="?marque=<?= $m['id_marque'] ?>"
           class="btn <?= $filtre_marque == $m['id_marque'] ? 'btn-primary' : 'btn-ghost' ?>">
            <?= htmlspecialchars($m['nom']) ?>
        </a>
        <?php endforeach; ?>
    </div>

    <!-- Bouton ouvrir modal Ajouter -->
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
        <td style="font-family:'DM Mono',monospace;color:var(--text-dim)"><?= $v['id_voiture'] ?></td>
        <td>
            <div style="color:var(--text);font-weight:500"><?= htmlspecialchars($v['model']) ?></div>
            <div style="font-size:11px;color:var(--text-dim)">
                <?= $v['specs'] ? htmlspecialchars(substr($v['specs'], 0, 55)) . '…' : '—' ?>
            </div>
        </td>
        <td><?= htmlspecialchars($v['marque']) ?></td>
        <td style="font-family:'DM Mono',monospace">
            <?= $v['annee'] ? date('Y', strtotime($v['annee'])) : '—' ?>
        </td>
        <td style="font-family:'DM Mono',monospace">
            <?= $v['km'] ? number_format($v['km'], 0, ',', ' ') . ' km' : '—' ?>
        </td>
        <td>
            <?php
            // Badge coloré selon le type (on réutilise les classes badge de admin_style.php)
            $carb = trim($v['type_carburant'] ?? '');
            if (stripos($carb, 'lectrique') !== false)
                echo '<span class="badge badge-ok">⚡ ' . htmlspecialchars($carb) . '</span>';
            elseif (stripos($carb, 'Hybrid') !== false)
                echo '<span class="badge badge-wait">🔋 ' . htmlspecialchars($carb) . '</span>';
            elseif ($carb)
                echo '<span class="badge badge-no">⛽ ' . htmlspecialchars($carb) . '</span>';
            else
                echo '<span style="color:var(--text-dim)">—</span>';
            ?>
        </td>
        <td style="font-family:'DM Mono',monospace;color:var(--accent)">
            <?= $v['prix'] ? number_format($v['prix'], 0, ',', ' ') . ' Rs' : '—' ?>
        </td>
        <td>
            <div class="actions">
                <!-- Ouvre la modal de modification -->
                <a class="btn btn-ghost btn-sm"
                   href="?action=detail&id=<?= $v['id_voiture'] ?>">Modifier</a>
                <!-- Suppression avec confirmation -->
                <a class="btn btn-danger btn-sm"
                   href="?action=supprimer&id=<?= $v['id_voiture'] ?>"
                   onclick="return confirm('Supprimer <?= htmlspecialchars(addslashes($v['model'])) ?> ?')">✕</a>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
</div>

</div><!-- /page -->


<!-- ═══════════════════════════════════════════════
     MODAL — MODIFIER une voiture existante
     S'ouvre quand ?action=detail&id=X
════════════════════════════════════════════════ -->
<?php if ($detail): ?>
<div class="modal-overlay open"
     onclick="if(event.target===this)location.href='admin_voitures.php'">
<div class="modal" style="max-width:560px;">

    <h3>Modifier — <?= htmlspecialchars($detail['model']) ?></h3>

    <form method="POST">
        <input type="hidden" name="id_voiture" value="<?= $detail['id_voiture'] ?>">

        <!-- Modèle + Marque -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
            <div class="form-group">
                <label class="form-label">Modèle</label>
                <input class="form-input" type="text" name="model" required
                       value="<?= htmlspecialchars($detail['model'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Marque</label>
                <select class="form-select" name="id_marque">
                    <?php foreach ($marques as $m): ?>
                    <option value="<?= $m['id_marque'] ?>"
                        <?= $detail['id_marque'] == $m['id_marque'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($m['nom']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Année + Kilométrage -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
            <div class="form-group">
                <label class="form-label">Année</label>
                <input class="form-input" type="date" name="annee"
                       value="<?= $detail['annee'] ?? '' ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Kilométrage</label>
                <input class="form-input" type="number" name="km" min="0"
                       value="<?= $detail['km'] ?? '' ?>"
                       placeholder="ex : 45000">
            </div>
        </div>

        <!-- Type carburant + Prix -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
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
                       value="<?= $detail['prix'] ?? '' ?>"
                       placeholder="ex : 2500000">
            </div>
        </div>

        <!-- Description / Specs -->
        <div class="form-group" style="margin-bottom:16px;">
            <label class="form-label">Description / Specs</label>
            <textarea class="form-textarea" name="specs"><?= htmlspecialchars($detail['specs'] ?? '') ?></textarea>
        </div>

        <div class="modal-footer">
            <a href="admin_voitures.php" class="btn btn-ghost">Fermer</a>
            <button class="btn btn-primary" name="set_voiture">Enregistrer</button>
        </div>
    </form>

    <!-- ─── SECTION PHOTOS DU SLIDER ─── -->
    <?php
    $photos_slider = mysqli_fetch_all(mysqli_query($lienbd,
        "SELECT * FROM voiture_images WHERE id_voiture={$detail['id_voiture']} ORDER BY ordre"), MYSQLI_ASSOC);
    ?>

    <div style="margin-top:20px;padding-top:16px;border-top:1px solid var(--border);">
        <div class="form-label" style="margin-bottom:10px;">
            📸 Photos du slider (<?= count($photos_slider) ?> photo<?= count($photos_slider) > 1 ? 's' : '' ?>)
        </div>

        <!-- Liste des photos existantes -->
        <?php if (!empty($photos_slider)): ?>
        <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:14px;">
            <?php foreach ($photos_slider as $ph): ?>
            <div style="position:relative;display:inline-block;">
                <!-- Miniature -->
                <img src="../<?= htmlspecialchars($ph['image']) ?>"
                     style="width:80px;height:55px;object-fit:cover;border-radius:6px;border:1px solid var(--border);"
                     alt="">
                <!-- Bouton supprimer cette photo -->
                <a href="?action=supprimer_photo&id=<?= $ph['id'] ?>&id_voiture=<?= $detail['id_voiture'] ?>"
                   onclick="return confirm('Supprimer cette photo ?')"
                   style="position:absolute;top:-6px;right:-6px;background:#e53e3e;color:white;
                          border-radius:50%;width:18px;height:18px;font-size:11px;line-height:18px;
                          text-align:center;text-decoration:none;display:block;">✕</a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div style="font-size:12px;color:var(--text-dim);margin-bottom:14px;">Aucune photo pour l'instant.</div>
        <?php endif; ?>

        <!-- Formulaire upload nouvelle photo -->
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_voiture_photo" value="<?= $detail['id_voiture'] ?>">
            <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                <input class="form-input" type="file" name="nouvelle_photo"
                       accept="image/*" style="flex:1;min-width:180px;"
                       onchange="previewNouvellePhoto(this)">
                <button class="btn btn-primary btn-sm" name="add_photo">+ Ajouter</button>
            </div>
            <!-- Aperçu avant upload -->
            <img id="previewNouvellePhoto"
                 style="display:none;margin-top:8px;max-height:80px;border-radius:6px;border:1px solid var(--border)"
                 alt="aperçu">
            <div style="font-size:11px;color:var(--text-dim);margin-top:4px;">
                Fichier déposé dans <code>Images-Index/</code>
            </div>
        </form>
    </div>
    <!-- FIN SECTION PHOTOS -->

</div>
</div>
<?php endif; ?>


<!-- ═══════════════════════════════════════════════
     MODAL — AJOUTER une nouvelle voiture
     S'ouvre quand ?action=ajouter
════════════════════════════════════════════════ -->
<?php if ($action === 'ajouter'): ?>
<div class="modal-overlay open"
     onclick="if(event.target===this)location.href='admin_voitures.php'">
<div class="modal" style="max-width:560px;">

    <h3>Ajouter un véhicule</h3>

    <!-- enctype nécessaire pour l'upload d'image -->
    <form method="POST" enctype="multipart/form-data">

        <!-- Modèle + Marque -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
            <div class="form-group">
                <label class="form-label">Modèle *</label>
                <input class="form-input" type="text" name="model"
                       required placeholder="ex : Audi A5">
            </div>
            <div class="form-group">
                <label class="form-label">Marque *</label>
                <select class="form-select" name="id_marque">
                    <?php foreach ($marques as $m): ?>
                    <option value="<?= $m['id_marque'] ?>"><?= htmlspecialchars($m['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Année + Kilométrage -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
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

        <!-- Type carburant + Prix -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
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

        <!-- Description / Specs -->
        <div class="form-group" style="margin-bottom:12px;">
            <label class="form-label">Description / Specs</label>
            <textarea class="form-textarea" name="specs"
                      placeholder="Décrivez le moteur, les performances..."></textarea>
        </div>

        <!-- Photos du slider -->
        <div class="form-group" style="margin-bottom:16px;padding:12px;background:rgba(255,255,255,0.03);border:1px solid var(--border);border-radius:8px;">
            <label class="form-label" style="margin-bottom:8px;">📸 Photos du slider</label>
            <div style="font-size:11px;color:var(--text-dim);margin-bottom:10px;">
                Sélectionne une ou plusieurs photos. La 1ère sera l'image principale.
            </div>

            <!-- Zone de drop / sélection multiple -->
            <input class="form-input" type="file" name="photos_slider[]"
                   accept="image/*" multiple
                   onchange="previewMultiple(this)">

            <!-- Aperçus en ligne -->
            <div id="previewsContainer"
                 style="display:flex;flex-wrap:wrap;gap:8px;margin-top:10px;"></div>

            <div style="font-size:11px;color:var(--text-dim);margin-top:6px;">
                Fichiers enregistrés dans <code>Images-Index/</code>
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

<script>
// Aperçu multiple pour la modal Ajouter
function previewMultiple(input) {
    const container = document.getElementById('previewsContainer');
    container.innerHTML = '';
    if (input.files) {
        Array.from(input.files).forEach((file, i) => {
            const reader = new FileReader();
            reader.onload = e => {
                const wrapper = document.createElement('div');
                wrapper.style.cssText = 'position:relative;display:inline-block;';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.cssText = 'width:80px;height:55px;object-fit:cover;border-radius:6px;border:1px solid var(--border);';

                // Badge "Principal" sur la 1ère photo
                if (i === 0) {
                    const badge = document.createElement('div');
                    badge.textContent = '★ Principal';
                    badge.style.cssText = 'position:absolute;bottom:0;left:0;right:0;background:rgba(255,107,0,0.85);color:white;font-size:9px;text-align:center;border-radius:0 0 6px 6px;padding:2px 0;';
                    wrapper.appendChild(badge);
                }

                wrapper.appendChild(img);
                container.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });
    }
}

// Aperçu pour la modal Modifier (ajout d'une photo)
function previewNouvellePhoto(input) {
    const img = document.getElementById('previewNouvellePhoto');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

</body>
</html>