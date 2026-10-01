<?php
// ============================================================
//  vues/mentions_vue.php  —  VUE : page "Mentions légales"
//  Page normale du site (header + footer). Construite exactement
//  comme politique_vue.php : elle affiche le texte du partiel
//  vues/layout/mentions_contenu.php.
// ============================================================
require __DIR__ . '/layout/header.php';
?>

<section class="py-5">
  <div class="container page-legale">

    <div class="carte-legale">

      <h1 class="mb-4">Mentions légales</h1>

      <?php require __DIR__ . '/layout/mentions_contenu.php'; ?>

    </div>
  </div>
</section>

<?php require __DIR__ . '/layout/footer.php'; ?>
