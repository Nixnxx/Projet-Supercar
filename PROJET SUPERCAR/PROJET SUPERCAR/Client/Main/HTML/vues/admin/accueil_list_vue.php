<?php
// ============================================================
//  vues/admin/accueil_list_vue.php  —  VUE : contenu de l'accueil
//  Reçoit : $carousel, $hero, $images, $points, $stats, $message.
//  Les suppressions se font par un simple lien vers accueil_supp.php.
// ============================================================
require __DIR__ . '/layout_haut.php';

// Petit utilitaire local : affiche un bouton "supprimer" (un lien).
// $cle = carousel | hero_image | point | stat ; $id = identifiant.
function bouton_suppr($cle, $id, $confirmation) {
    echo '<a class="btn btn-danger btn-sm"';
    echo ' href="accueil_supp.php?table=' . e($cle) . '&id=' . (int)$id . '"';
    echo ' data-confirm="' . e($confirmation) . '">';
    echo '<i class="bi bi-trash"></i></a>';
}
?>

<div class="page">

    <div class="page-header">
        <h2>Page Accueil</h2>
        <span class="page-sub">Ajoutez, modifiez ou supprimez les éléments affichés sur l'accueil.</span>
    </div>

    <?= $message ?>


    <!-- SECTION 1 : CARROUSEL -->
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
                    <tr><th>ID</th><th>Image</th><th>Titre</th><th>Ordre</th><th>Actif</th><th>Actions</th></tr>
                </thead>
                <tbody>
                <?php foreach ($carousel as $slide) : ?>
                    <tr>
                        <td><?= (int)$slide['id'] ?></td>
                        <td><img src="../<?= e($slide['image']) ?>" style="width:70px;height:45px;object-fit:cover;border-radius:5px;" alt=""></td>
                        <td><?= e($slide['titre']) ?></td>
                        <td><?= (int)$slide['ordre'] ?></td>
                        <td><?= $slide['actif'] ? '<span class="badge badge-ok">Oui</span>' : '<span class="badge badge-no">Non</span>' ?></td>
                        <td>
                            <div class="actions">
                                <a href="accueil_mod.php?table=carousel&id=<?= (int)$slide['id'] ?>" class="btn btn-ghost btn-sm"><i class="bi bi-pencil"></i></a>
                                <?php bouton_suppr('carousel', (int)$slide['id'], 'Supprimer cette slide ?'); ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- SECTION 2 : TEXTE HERO -->
    <div class="card" id="hero">
        <div class="card-header">
            <span><i class="bi bi-type-h1 me-2"></i>Section titre, description...</span>
            <a href="accueil_mod.php?table=hero&id=<?= (int)($hero['id'] ?? 0) ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-pencil"></i> Modifier
            </a>
        </div>
        <div style="padding: 20px; display: flex; flex-direction: column; gap: 10px;">
            <p style="color: var(--text-muted); font-size: 13px;">
                <span style="color: var(--text-dim); font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px;">Titre</span><br>
                <?= e($hero['titre'] ?? '') ?>
            </p>
            <p style="color: var(--text-muted); font-size: 13px;">
                <span style="color: var(--text-dim); font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px;">Sous-titre</span><br>
                <?= e($hero['sous_titre'] ?? '') ?>
            </p>
            <p style="color: var(--text-muted); font-size: 13px;">
                <span style="color: var(--text-dim); font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px;">Description</span><br>
                <?= e(substr($hero['description'] ?? '', 0, 120)) ?>…
            </p>
            <p style="color: var(--text-muted); font-size: 13px;">
                <span style="color: var(--text-dim); font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px;">Bouton</span><br>
                <span class="badge badge-wait"><?= e($hero['texte'] ?? '') ?></span>
                → <code style="color: var(--text-dim); font-size: 12px;"><?= e($hero['lien'] ?? '') ?></code>
            </p>
        </div>
    </div>


    <!-- SECTION 3 : IMAGES HERO -->
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
                    <tr><th>ID</th><th>Aperçu</th><th>Fichier</th><th>Alt</th><th>Ordre</th><th>Actif</th><th>Actions</th></tr>
                </thead>
                <tbody>
                <?php foreach ($images as $img) : ?>
                    <tr>
                        <td><?= (int)$img['id'] ?></td>
                        <td><img src="../<?= e($img['image']) ?>" style="width:70px;height:45px;object-fit:cover;border-radius:5px;" alt=""></td>
                        <td style="max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= e($img['image']) ?></td>
                        <td><?= e($img['alt']) ?></td>
                        <td><?= (int)$img['ordre'] ?></td>
                        <td><?= $img['actif'] ? '<span class="badge badge-ok">Oui</span>' : '<span class="badge badge-no">Non</span>' ?></td>
                        <td>
                            <div class="actions">
                                <a href="accueil_mod.php?table=hero_image&id=<?= (int)$img['id'] ?>" class="btn btn-ghost btn-sm"><i class="bi bi-pencil"></i></a>
                                <?php bouton_suppr('hero_image', (int)$img['id'], 'Supprimer cette image ?'); ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- SECTION 4 : POINTS FORTS -->
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
                    <tr><th>ID</th><th>Texte</th><th>Ordre</th><th>Actif</th><th>Actions</th></tr>
                </thead>
                <tbody>
                <?php foreach ($points as $point) : ?>
                    <tr>
                        <td><?= (int)$point['id'] ?></td>
                        <td>✅ <?= e($point['texte']) ?></td>
                        <td><?= (int)$point['ordre'] ?></td>
                        <td><?= $point['actif'] ? '<span class="badge badge-ok">Oui</span>' : '<span class="badge badge-no">Non</span>' ?></td>
                        <td>
                            <div class="actions">
                                <a href="accueil_mod.php?table=point&id=<?= (int)$point['id'] ?>" class="btn btn-ghost btn-sm"><i class="bi bi-pencil"></i></a>
                                <?php bouton_suppr('point', (int)$point['id'], 'Supprimer ce point ?'); ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- SECTION 5 : STATISTIQUES -->
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
                    <tr><th>ID</th><th>Valeur</th><th>Label</th><th>Ordre</th><th>Actif</th><th>Actions</th></tr>
                </thead>
                <tbody>
                <?php foreach ($stats as $stat) : ?>
                    <tr>
                        <td><?= (int)$stat['id'] ?></td>
                        <td><strong style="color: var(--accent);"><?= e($stat['valeur']) ?></strong></td>
                        <td><?= e($stat['label']) ?></td>
                        <td><?= (int)$stat['ordre'] ?></td>
                        <td><?= $stat['actif'] ? '<span class="badge badge-ok">Oui</span>' : '<span class="badge badge-no">Non</span>' ?></td>
                        <td>
                            <div class="actions">
                                <a href="accueil_mod.php?table=stat&id=<?= (int)$stat['id'] ?>" class="btn btn-ghost btn-sm"><i class="bi bi-pencil"></i></a>
                                <?php bouton_suppr('stat', (int)$stat['id'], 'Supprimer cette stat ?'); ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div><!-- fin .page -->

<script src="../js/admin/accueil-liste.js"></script>

<?php require __DIR__ . '/layout_bas.php'; ?>
