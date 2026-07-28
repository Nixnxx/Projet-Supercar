<?php
// ============================================================
//  vues/politique_vue.php  —  VUE : page "Politique de confidentialité"
//  Page normale du site (header + footer). Elle réutilise EXACTEMENT le
//  même texte que la fenêtre du footer, grâce au partiel partagé
//  vues/layout/politique_contenu.php (aucun copier-coller).
// ============================================================
require __DIR__ . '/layout/header.php';
?>

<section class="py-5">
  <div class="container" style="max-width: 900px;">

    <div style="background:#fff; border:1px solid var(--accent-grey);
                border-top:4px solid var(--primary-orange); border-radius:16px;
                padding:40px; box-shadow:0 6px 22px rgba(20,30,50,0.06);">

      <h1 class="mb-4" style="color: var(--text-dark);">Politique de confidentialité</h1>

      <?php require __DIR__ . '/layout/politique_contenu.php'; ?>

    </div>
  </div>
</section>

<?php require __DIR__ . '/layout/footer.php'; ?>
