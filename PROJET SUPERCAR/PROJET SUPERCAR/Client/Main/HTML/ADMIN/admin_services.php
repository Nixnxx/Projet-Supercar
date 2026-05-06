<?php
session_start();
require('lienbd.php');
require('fonction.php');

if (!est_connecte()) {
    header('Location: logina.php');
    exit();
}

$action = $_GET['action'] ?? '';
$id     = intval($_GET['id'] ?? 0);
$succes = $_GET['succes'] ?? '';
$upload_dir = "Images-Index/Service_Image/";

// ─── 1. SUPPRESSION ───
if ($action === 'supprimer' && $id > 0) {
    $s = mysqli_prepare($lienbd, "DELETE FROM service WHERE id_service=?");
    mysqli_stmt_bind_param($s, 'i', $id);
    mysqli_stmt_execute($s);
    header('Location: admin_services.php?succes=supprime');
    exit();
}

// ─── 2. MODIFICATION ───
if (isset($_POST['set_service'])) {
    $nid    = intval($_POST['id_service']);
    $nom    = $_POST['nom'];
    $desc   = $_POST['description'];
    $icone  = $_POST['icone'];
    $tag    = $_POST['tag'];
    $numero = intval($_POST['numero']);
    $remove_img = isset($_POST['remove_image']);

    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], '../' . $upload_dir . $image_name);
        $path_to_db = $upload_dir . $image_name;
        $s = mysqli_prepare($lienbd, "UPDATE service SET nom=?, description=?, image=?, icone=?, tag=?, numero=? WHERE id_service=?");
        mysqli_stmt_bind_param($s, 'sssssii', $nom, $desc, $path_to_db, $icone, $tag, $numero, $nid);
    } elseif ($remove_img) {
        $s = mysqli_prepare($lienbd, "UPDATE service SET nom=?, description=?, image='', icone=?, tag=?, numero=? WHERE id_service=?");
        mysqli_stmt_bind_param($s, 'ssssii', $nom, $desc, $icone, $tag, $numero, $nid);
    } else {
       $s = mysqli_prepare($lienbd, "UPDATE service SET nom=?, description=?, icone=?, tag=?, numero=? WHERE id_service=?");
mysqli_stmt_bind_param($s, 'ssssii', $nom, $desc, $icone, $tag, $numero, $nid);
    }
    mysqli_stmt_execute($s);
    header('Location: admin_services.php?succes=update');
    exit();
}

// ─── 3. AJOUT ───
if (isset($_POST['add_service'])) {
    $nom    = $_POST['nom'] ?? '';
    $desc   = $_POST['description'] ?? '';
    $icone  = $_POST['icone'] ?? 'bi-tools';
    $tag    = $_POST['tag'] ?? '';
    $numero = intval($_POST['numero'] ?? 0);
    $path_to_db = "";

    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], '../' . $upload_dir . $image_name)) {
            $path_to_db = $upload_dir . $image_name;
        }
    }
    $s = mysqli_prepare($lienbd, "INSERT INTO service (nom, description, image, icone, tag, numero) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($s, 'sssssi', $nom, $desc, $path_to_db, $icone, $tag, $numero);
    mysqli_stmt_execute($s);
    header('Location: admin_services.php?succes=ajoute');
    exit();
}

// ─── 4. AFFICHAGE ───
$services = mysqli_fetch_all(mysqli_query($lienbd, "SELECT * FROM service ORDER BY numero"), MYSQLI_ASSOC);
$detail = null;
if ($action === 'detail' && $id > 0) {
    $s = mysqli_prepare($lienbd, "SELECT * FROM service WHERE id_service=?");
    mysqli_stmt_bind_param($s, 'i', $id);
    mysqli_stmt_execute($s);
    $detail = mysqli_fetch_assoc(mysqli_stmt_get_result($s));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin — Services</title>
    <?php include 'admin_style.php'; ?>
</head>
<body>
<?php include 'admin_nav.php'; ?>

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
                    <td><?= $s['id_service'] ?></td>
                    <td><?= str_pad($s['numero'], 2, '0', STR_PAD_LEFT) ?></td>
                    <td>
                        <?php if ($s['image']): ?>
                            <img src="../<?= htmlspecialchars($s['image']) ?>" style="width:50px; height:35px; object-fit:cover; border-radius:4px;">
                        <?php else: ?>
                            <div style="width:50px; height:35px; background:var(--border); border-radius:4px;"></div>
                        <?php endif; ?>
                    </td>
                    <td style="font-weight:600;"><?= htmlspecialchars($s['nom']) ?></td>
                    <td><i class="bi <?= htmlspecialchars($s['icone']) ?>"></i> <small><?= htmlspecialchars($s['icone']) ?></small></td>
                    <td><small><?= htmlspecialchars($s['tag']) ?></small></td>
                    <td style="font-size:12px; color:var(--text-dim);"><?= htmlspecialchars(substr($s['description'], 0, 50)) ?>...</td>
                    <td style="text-align:right;">
                        <div class="actions" style="justify-content:flex-end;">
                            <a class="btn btn-ghost btn-sm" href="?action=detail&id=<?= $s['id_service'] ?>">Modifier</a>
                            <a class="btn btn-danger btn-sm" href="?action=supprimer&id=<?= $s['id_service'] ?>" onclick="return confirm('Supprimer ?')">✕</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL MODIFICATION -->
<?php if ($detail): ?>
<div class="modal-overlay open" onclick="if(event.target===this)location.href='admin_services.php'">
    <div class="modal" style="max-width:400px;">
        <h3 style="margin-bottom:15px;">Modifier Service</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_service" value="<?= $detail['id_service'] ?>">

            <div class="form-group">
                <label class="form-label">Numéro d'ordre</label>
                <input class="form-input" type="number" name="numero" value="<?= $detail['numero'] ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Nom</label>
                <input class="form-input" type="text" name="nom" required value="<?= htmlspecialchars($detail['nom']) ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea class="form-textarea" name="description" rows="3" required><?= htmlspecialchars($detail['description']) ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Icône Bootstrap (ex: bi-cpu)</label>
                <input class="form-input" type="text" name="icone" value="<?= htmlspecialchars($detail['icone']) ?>" placeholder="bi-tools">
            </div>

            <div class="form-group">
                <label class="form-label">Tag</label>
                <input class="form-input" type="text" name="tag" value="<?= htmlspecialchars($detail['tag']) ?>" placeholder="Électronique & Moteur">
            </div>

            <div class="form-group">
                <?php if($detail['image']): ?>
                    <div style="margin-bottom:10px; text-align:center; background:var(--bg-card); padding:8px; border-radius:8px; border:1px solid var(--border);">
                        <img src="../<?= $detail['image'] ?>" style="max-width:100%; height:80px; object-fit:contain; border-radius:4px;">
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

<!-- MODAL AJOUT -->
<?php if ($action === 'ajouter'): ?>
<div class="modal-overlay open" onclick="if(event.target===this)location.href='admin_services.php'">
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

</body>
</html>