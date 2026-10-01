<?php
// ============================================================
//  vues/admin/triggers_vue.php  —  VUE : journal d'audit
//  Reçoit : $audit (liste).
//  Page 100% lecture : aucun formulaire, rien à modifier ici — les
//  lignes sont écrites par le trigger MySQL, pas par cette page.
// ============================================================
require __DIR__ . '/layout_haut.php';
?>


<div class="page">
<div class="page-header">
    <h2>Journal d'audit</h2>
    <span class="page-sub"><?= count($audit) ?> actions enregistrées</span>
</div>


<p class="page-note">
    Chaque ligne est créée automatiquement par un trigger MySQL
    (<code>insert_voiture</code>) dès qu'une voiture est ajoutée en base —
    même si l'ajout ne passe pas par ce site. L'admin responsable n'est
    ajouté qu'ensuite, par le contrôleur : un trigger n'a pas accès à la
    session du site.
</p>


<div class="table-wrap">
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Table</th>
            <th>Action</th>
            <th>Voiture concernée</th>
            <th>Admin</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
    <?php if (empty($audit)): ?>
    <tr><td colspan="6" class="empty-sm">Aucune action enregistrée.</td></tr>
    <?php else: ?>
    <?php foreach ($audit as $ligne): ?>
    <tr>
        <td class="cell-mono-dim"><?= (int) $ligne['id_audit'] ?></td>
        <td><?= e($ligne['nom_table']) ?></td>
        <td><span class="badge badge-ok"><?= e($ligne['action']) ?></span></td>


        <!-- Le ?? gère le cas où la voiture a depuis été supprimée :
             ON DELETE SET NULL a alors mis id_produit à NULL, mais la
             ligne d'audit, elle, reste — c'est tout l'intérêt du journal. -->
        <td><?= $ligne['voiture_model'] !== null ? e($ligne['voiture_model']) : '— voiture supprimée —' ?></td>


        <td><?= $ligne['admin_login'] !== null ? e($ligne['admin_login']) : '—' ?></td>


        <td class="cell-mono"><?= date('d/m/Y à H:i', strtotime($ligne['date_action'])) ?></td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
</div>


</div><!-- /page -->


<?php require __DIR__ . '/layout_bas.php'; ?>
