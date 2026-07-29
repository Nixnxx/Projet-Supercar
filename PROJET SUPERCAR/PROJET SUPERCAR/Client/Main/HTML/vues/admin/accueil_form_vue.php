<?php
// ============================================================
//  vues/admin/accueil_form_vue.php  —  VUE : formulaire d'un
//  élément d'accueil. Page autonome (sans le menu latéral).
//  Reçoit : $table, $id, $donnees, $titre_form.
// ============================================================
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($titre_form) ?> | Admin SuperCar</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body       { background: #111; color: #ddd; }
    .formulaire { max-width: 650px; margin: 40px auto; background: #1c1c1c;
                  border: 1px solid #333; border-radius: 10px; }
    .entete    { background: #222; padding: 15px 20px; border-radius: 10px 10px 0 0;
                 font-weight: bold; border-bottom: 1px solid #333; color: #ff6b00; }
    .form-control, .form-select { background: #111; border: 1px solid #444; color: #ddd; }
    .form-control:focus { background: #111; color: #fff; border-color: #ff6b00; box-shadow: none; }
    .btn-orange { background: #ff6b00; color: #fff; border: none; }
    .btn-orange:hover { background: #cc5500; color: #fff; }
    label      { color: #aaa; font-size: 0.9rem; }
    .apercu    { max-height: 130px; border-radius: 6px; margin-top: 8px; border: 1px solid #444; }

    /* ── RESPONSIVE ──
       Mêmes points de rupture que le reste du site (voir styles.css). */

    /* Petit écran : le cadre ne colle plus aux bords de l'écran */
    @media (max-width: 767.98px) {
      .formulaire { margin: 20px 14px; }
    }

    /* Mobile : on réduit encore les marges et les boutons passent
       l'un sous l'autre sur toute la largeur (plus faciles à toucher) */
    @media (max-width: 575.98px) {
      .formulaire      { margin: 14px 10px; }
      .entete          { padding: 12px 14px; font-size: 0.95rem; }
      .formulaire .p-4 { padding: 1rem !important; }
      .boutons-form    { flex-direction: column; }
      .boutons-form .btn { width: 100%; }
    }
  </style>
</head>
<body>

<div class="formulaire">
  <div class="entete">
    <?= e($titre_form) ?> –
    <?php
      if ($table == 'carousel')   echo "Slide Carrousel";
      if ($table == 'hero')       echo "Texte Hero";
      if ($table == 'hero_image') echo "Image Hero";
      if ($table == 'point')      echo "Point Fort";
      if ($table == 'stat')       echo "Statistique";
    ?>
  </div>

  <div class="p-4">
    <!-- Le formulaire est envoyé à la même URL (table + id conservés) -->
    <form method="POST" enctype="multipart/form-data">

        <!-- Jeton anti-CSRF : prouve que le formulaire vient bien de notre site -->
        <?php csrf_champ(); ?>


      <?php if ($table == 'carousel') : ?>

        <div class="mb-3">
          <label>Titre *</label>
          <input type="text" name="titre" class="form-control"
                 value="<?= e($donnees['titre'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
          <label>Description</label>
          <textarea name="description" class="form-control" rows="3"><?= e($donnees['description'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
          <label>Image (JPG, PNG, WEBP)</label>
          <input type="file" name="image" class="form-control input-image-apercu" accept="image/*">
          <?php if (!empty($donnees['image'])) : ?>
            <img src="../<?= e($donnees['image']) ?>" class="apercu" id="apercu" alt="">
          <?php else : ?>
            <img id="apercu" class="apercu d-none" alt="">
          <?php endif; ?>
          <small class="text-secondary">Laisser vide pour garder l'image actuelle.</small>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-12 col-md-6">
            <label>Lien du bouton</label>
            <input type="text" name="lien" class="form-control"
                   value="<?= e($donnees['lien'] ?? 'essai.php') ?>">
          </div>
          <div class="col-12 col-md-6">
            <label>Texte du bouton</label>
            <input type="text" name="texte_lien" class="form-control"
                   value="<?= e($donnees['texte_lien'] ?? 'Demander un essai') ?>">
          </div>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-12 col-md-6">
            <label>Ordre d'affichage</label>
            <input type="number" name="ordre" class="form-control"
                   value="<?= (int)($donnees['ordre'] ?? 0) ?>" min="0">
          </div>
          <div class="col-12 col-md-6 d-flex align-items-end">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="actif" id="actif"
                     <?= ($donnees['actif'] ?? 1) ? 'checked' : '' ?>>
              <label class="form-check-label" for="actif">Slide active</label>
            </div>
          </div>
        </div>

      <?php endif; ?>


      <?php if ($table == 'hero') : ?>

        <div class="mb-3">
          <label>Titre principal *</label>
          <input type="text" name="titre" class="form-control"
                 value="<?= e($donnees['titre'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
          <label>Sous-titre</label>
          <input type="text" name="sous_titre" class="form-control"
                 value="<?= e($donnees['sous_titre'] ?? '') ?>">
        </div>

        <div class="mb-3">
          <label>Description</label>
          <textarea name="description" class="form-control" rows="4"><?= e($donnees['description'] ?? '') ?></textarea>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-12 col-md-8">
            <label>Texte du bouton</label>
            <input type="text" name="texte_cta" class="form-control"
                   value="<?= e($donnees['texte'] ?? '') ?>">
          </div>
          <div class="col-12 col-md-4">
            <label>Lien</label>
            <input type="text" name="lien_cta" class="form-control"
                   value="<?= e($donnees['lien'] ?? 'essai.php') ?>">
          </div>
        </div>

      <?php endif; ?>


      <?php if ($table == 'hero_image') : ?>

        <div class="mb-3">
          <label>Image *</label>
          <input type="file" name="image" class="form-control input-image-apercu" accept="image/*">
          <?php if (!empty($donnees['image'])) : ?>
            <img src="../<?= e($donnees['image']) ?>" class="apercu" id="apercu" alt="">
          <?php else : ?>
            <img id="apercu" class="apercu d-none" alt="">
          <?php endif; ?>
        </div>

        <div class="mb-3">
          <label>Texte alternatif (description de l'image)</label>
          <input type="text" name="alt" class="form-control"
                 value="<?= e($donnees['alt'] ?? '') ?>">
        </div>

        <div class="row g-3 mb-3">
          <div class="col-12 col-md-6">
            <label>Ordre</label>
            <input type="number" name="ordre" class="form-control"
                   value="<?= (int)($donnees['ordre'] ?? 0) ?>" min="0">
          </div>
          <div class="col-12 col-md-6 d-flex align-items-end">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="actif" id="actif"
                     <?= ($donnees['actif'] ?? 1) ? 'checked' : '' ?>>
              <label class="form-check-label" for="actif">Image active</label>
            </div>
          </div>
        </div>

      <?php endif; ?>


      <?php if ($table == 'point') : ?>

        <div class="mb-3">
          <label>Texte du point fort *</label>
          <input type="text" name="texte" class="form-control"
                 value="<?= e($donnees['texte'] ?? '') ?>" required>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-12 col-md-6">
            <label>Ordre</label>
            <input type="number" name="ordre" class="form-control"
                   value="<?= (int)($donnees['ordre'] ?? 0) ?>" min="0">
          </div>
          <div class="col-12 col-md-6 d-flex align-items-end">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="actif" id="actif"
                     <?= ($donnees['actif'] ?? 1) ? 'checked' : '' ?>>
              <label class="form-check-label" for="actif">Point actif</label>
            </div>
          </div>
        </div>

      <?php endif; ?>


      <?php if ($table == 'stat') : ?>

        <div class="mb-3">
          <label>Valeur affichée (ex : +120, 98%, Île entière) *</label>
          <input type="text" name="valeur" class="form-control"
                 value="<?= e($donnees['valeur'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
          <label>Label (ex : Véhicules vendus) *</label>
          <input type="text" name="label" class="form-control"
                 value="<?= e($donnees['label'] ?? '') ?>" required>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-12 col-md-6">
            <label>Ordre</label>
            <input type="number" name="ordre" class="form-control"
                   value="<?= (int)($donnees['ordre'] ?? 0) ?>" min="0">
          </div>
          <div class="col-12 col-md-6 d-flex align-items-end">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="actif" id="actif"
                     <?= ($donnees['actif'] ?? 1) ? 'checked' : '' ?>>
              <label class="form-check-label" for="actif">Stat active</label>
            </div>
          </div>
        </div>

      <?php endif; ?>


      <hr style="border-color:#333">
      <div class="d-flex gap-3 boutons-form">
        <button type="submit" class="btn btn-orange px-4">
          💾 <?= $id > 0 ? 'Enregistrer les modifications' : 'Ajouter' ?>
        </button>
        <a href="accueil.php" class="btn btn-outline-secondary">Annuler</a>
      </div>

    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/admin/accueil.js"></script>
</body>
</html>
