<?php
// ============================================================
//  vues/admin/accueil_list_vue.php  —  VUE : contenu de l'accueil
//  Reçoit : $carousel, $hero, $images, $points, $stats, $message.
//  $message contient seulement le TYPE de message ("ok" ou "supprime") :
//  c'est ici, dans la vue, que le HTML correspondant est construit.
//  Les suppressions se font par un formulaire POST vers accueil_supp.php.
// ============================================================
require __DIR__ . '/layout_haut.php';

// Petit utilitaire local : affiche un bouton "supprimer".
// $cle = carousel | hero_image | point | stat ; $id = identifiant.
//
// POURQUOI UN FORMULAIRE ET NON UN LIEN :
// une adresse (lien) peut être appelée par une simple balise <img> placée
// sur un site pirate. Le navigateur de l'admin la chargerait avec son
// cookie de session, et l'élément serait supprimé à son insu.
// Un formulaire POST ne peut pas être déclenché de cette façon.
function bouton_suppr($cle, $id, $confirmation) {
    echo '<form method="POST" action="accueil_supp.php" class="form-action">';
    csrf_champ();
    echo '<input type="hidden" name="table" value="' . e($cle) . '">';
    echo '<input type="hidden" name="id" value="' . (int)$id . '">';
    echo '<button class="btn btn-danger btn-sm" name="supprimer"';
    echo ' data-confirm="' . e($confirmation) . '">';
    echo '<i class="bi bi-trash"></i></button>';
    echo '</form>';
}
?>

<div class="page">

    <div class="page-header">
        <h2>Page Accueil</h2>
        <span class="page-sub">Ajoutez, modifiez ou supprimez les éléments affichés sur l'accueil.</span>
    </div>

    <?php if ($message === 'ok') : ?>
        <div class="alert success">✅ Opération réussie !</div>
    <?php elseif ($message === 'supprime') : ?>
        <div class="alert danger">🗑️ Élément supprimé.</div>
    <?php endif; ?>


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
                        <td><img src="../<?= e($slide['image']) ?>" class="vignette" alt=""></td>
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
        <div class="apercu-hero">
            <p class="hero-champ">
                <span class="hero-libelle">Titre</span><br>
                <?= e($hero['titre'] ?? '') ?>
            </p>
            <p class="hero-champ">
                <span class="hero-libelle">Sous-titre</span><br>
                <?= e($hero['sous_titre'] ?? '') ?>
            </p>
            <p class="hero-champ">
                <span class="hero-libelle">Description</span><br>
                <?= e(substr($hero['description'] ?? '', 0, 120)) ?>…
            </p>
            <p class="hero-champ">
                <span class="hero-libelle">Bouton</span><br>
                <span class="badge badge-wait"><?= e($hero['texte'] ?? '') ?></span>
                → <code class="hero-lien"><?= e($hero['lien'] ?? '') ?></code>
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
                        <td><img src="../<?= e($img['image']) ?>" class="vignette" alt=""></td>
                        <td class="cell-fichier"><?= e($img['image']) ?></td>
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
                        <td><strong class="valeur-stat"><?= e($stat['valeur']) ?></strong></td>
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
