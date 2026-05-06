<?php
session_start();
require('lienbd.php');
require('fonction.php');

if (!est_connecte()) {
    header('Location: login.html');
    exit();
}

// Les slides du carrousel
$req_carousel = mysqli_query($lienbd, "SELECT * FROM accueil_carousel ORDER BY ordre");

// Le texte hero (1 seule ligne)
$req_hero = mysqli_query($lienbd, "SELECT * FROM accueil_bienvenue LIMIT 1");
$hero     = mysqli_fetch_assoc($req_hero);

// Les images hero
$req_images = mysqli_query($lienbd, "SELECT * FROM accueil_bienvenue_images ORDER BY ordre");

// Les points forts
$req_points = mysqli_query($lienbd, "SELECT * FROM accueil_points ORDER BY ordre");

// Les statistiques
$req_stats = mysqli_query($lienbd, "SELECT * FROM accueil_stats ORDER BY ordre");

// Message de confirmation
$message = "";
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == "ok")       $message = '<div class="alert success">✅ Opération réussie !</div>';
    if ($_GET['msg'] == "supprime") $message = '<div class="alert danger">🗑️ Élément supprimé.</div>';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin – Page Accueil | SuperCar</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <?php include 'admin_style.php'; ?>
</head>
<body>

<?php include 'admin_nav.php'; ?>

<div class="page">

    <div class="page-header">
        <h2>Page Accueil</h2>
        <span class="page-sub">Ajoutez, modifiez ou supprimez les éléments affichés sur l'accueil.</span>
    </div>

    <?= $message ?>


    <!-- ================================================
         SECTION 1 : CARROUSEL
    ================================================ -->
    <div class="card" id="carrousel">
        <div class="card-header">
            <span><i class="bi bi-images me-2"></i>Slides du Carrousel</span>
            <a href="accueil_mod.php?table=carousel" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Ajouter une slide
            </a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Titre</th>
                        <th>Ordre</th>
                        <th>Actif</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($slide = mysqli_fetch_assoc($req_carousel)) : ?>
                    <tr>
                        <td><?= $slide['id'] ?></td>
                        <td><img src="../<?= htmlspecialchars($slide['image']) ?>" style="width:70px;height:45px;object-fit:cover;border-radius:5px;" alt=""></td>
                        <td><?= htmlspecialchars($slide['titre']) ?></td>
                        <td><?= $slide['ordre'] ?></td>
                        <td>
                            <?= $slide['actif']
                                ? '<span class="badge badge-ok">Oui</span>'
                                : '<span class="badge badge-no">Non</span>' ?>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="accueil_mod.php?table=carousel&id=<?= $slide['id'] ?>" class="btn btn-ghost btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="accueil_supp.php?table=carousel&id=<?= $slide['id'] ?>" class="btn btn-danger btn-sm"
                                   onclick="return confirm('Supprimer cette slide ?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- ================================================
         SECTION 2 : TEXTE HERO
    ================================================ -->
    <div class="card" id="hero">
        <div class="card-header">
            <span><i class="bi bi-type-h1 me-2"></i>Section titre, description...</span>
            <a href="accueil_mod.php?table=hero&id=<?= $hero['id'] ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-pencil"></i> Modifier
            </a>
        </div>
        <div style="padding: 20px; display: flex; flex-direction: column; gap: 10px;">
            <p style="color: var(--text-muted); font-size: 13px;">
                <span style="color: var(--text-dim); font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px;">Titre</span><br>
                <?= htmlspecialchars($hero['titre']) ?>
            </p>
            <p style="color: var(--text-muted); font-size: 13px;">
                <span style="color: var(--text-dim); font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px;">Sous-titre</span><br>
                <?= htmlspecialchars($hero['sous_titre']) ?>
            </p>
            <p style="color: var(--text-muted); font-size: 13px;">
                <span style="color: var(--text-dim); font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px;">Description</span><br>
                <?= htmlspecialchars(substr($hero['description'], 0, 120)) ?>…
            </p>
            <p style="color: var(--text-muted); font-size: 13px;">
                <span style="color: var(--text-dim); font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px;">Bouton</span><br>
                <span class="badge badge-wait"><?= htmlspecialchars($hero['texte']) ?></span>
                → <code style="color: var(--text-dim); font-size: 12px;"><?= htmlspecialchars($hero['lien']) ?></code>
            </p>
        </div>
    </div>


    <!-- ================================================
         SECTION 3 : IMAGES HERO
    ================================================ -->
    <div class="card" id="images">
        <div class="card-header">
            <span><i class="bi bi-card-image me-2"></i>Images Hero (colonne droite)</span>
            <a href="accueil_mod.php?table=hero_image" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Ajouter une image
            </a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Aperçu</th>
                        <th>Fichier</th>
                        <th>Alt</th>
                        <th>Ordre</th>
                        <th>Actif</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($img = mysqli_fetch_assoc($req_images)) : ?>
                    <tr>
                        <td><?= $img['id'] ?></td>
                        <td><img src="../<?= htmlspecialchars($img['image']) ?>" style="width:70px;height:45px;object-fit:cover;border-radius:5px;" alt=""></td>
                        <td style="max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= htmlspecialchars($img['image']) ?></td>
                        <td><?= htmlspecialchars($img['alt']) ?></td>
                        <td><?= $img['ordre'] ?></td>
                        <td>
                            <?= $img['actif']
                                ? '<span class="badge badge-ok">Oui</span>'
                                : '<span class="badge badge-no">Non</span>' ?>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="accueil_mod.php?table=hero_image&id=<?= $img['id'] ?>" class="btn btn-ghost btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="accueil_supp.php?table=hero_image&id=<?= $img['id'] ?>" class="btn btn-danger btn-sm"
                                   onclick="return confirm('Supprimer cette image ?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- ================================================
         SECTION 4 : POINTS FORTS
    ================================================ -->
    <div class="card" id="points">
        <div class="card-header">
            <span><i class="bi bi-list-check me-2"></i>Points Forts</span>
            <a href="accueil_mod.php?table=point" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Ajouter un point
            </a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Texte</th>
                        <th>Ordre</th>
                        <th>Actif</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($point = mysqli_fetch_assoc($req_points)) : ?>
                    <tr>
                        <td><?= $point['id'] ?></td>
                        <td>✅ <?= htmlspecialchars($point['texte']) ?></td>
                        <td><?= $point['ordre'] ?></td>
                        <td>
                            <?= $point['actif']
                                ? '<span class="badge badge-ok">Oui</span>'
                                : '<span class="badge badge-no">Non</span>' ?>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="accueil_mod.php?table=point&id=<?= $point['id'] ?>" class="btn btn-ghost btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="accueil_supp.php?table=point&id=<?= $point['id'] ?>" class="btn btn-danger btn-sm"
                                   onclick="return confirm('Supprimer ce point ?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- ================================================
         SECTION 5 : STATISTIQUES
    ================================================ -->
    <div class="card" id="stats">
        <div class="card-header">
            <span><i class="bi bi-bar-chart me-2"></i>Statistiques</span>
            <a href="accueil_mod.php?table=stat" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Ajouter une stat
            </a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Valeur</th>
                        <th>Label</th>
                        <th>Ordre</th>
                        <th>Actif</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($stat = mysqli_fetch_assoc($req_stats)) : ?>
                    <tr>
                        <td><?= $stat['id'] ?></td>
                        <td><strong style="color: var(--accent);"><?= htmlspecialchars($stat['valeur']) ?></strong></td>
                        <td><?= htmlspecialchars($stat['label']) ?></td>
                        <td><?= $stat['ordre'] ?></td>
                        <td>
                            <?= $stat['actif']
                                ? '<span class="badge badge-ok">Oui</span>'
                                : '<span class="badge badge-no">Non</span>' ?>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="accueil_mod.php?table=stat&id=<?= $stat['id'] ?>" class="btn btn-ghost btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="accueil_supp.php?table=stat&id=<?= $stat['id'] ?>" class="btn btn-danger btn-sm"
                                   onclick="return confirm('Supprimer cette stat ?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</div><!-- fin .page -->

</body>
</html>