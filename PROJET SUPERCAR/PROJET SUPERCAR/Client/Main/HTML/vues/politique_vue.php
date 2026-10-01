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
  <div class="container page-legale">

    <div class="carte-legale">

      <h1 class="mb-4">Politique de confidentialité</h1>

      <?php require __DIR__ . '/layout/politique_contenu.php'; ?>

    </div>
  </div>
</section>

<?php require __DIR__ . '/layout/footer.php'; ?>
