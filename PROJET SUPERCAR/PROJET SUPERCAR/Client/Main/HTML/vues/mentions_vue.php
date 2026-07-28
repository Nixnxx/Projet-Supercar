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
  <div class="container" style="max-width: 900px;">

    <div style="background:#fff; border:1px solid var(--accent-grey);
                border-top:4px solid var(--primary-orange); border-radius:16px;
                padding:40px; box-shadow:0 6px 22px rgba(20,30,50,0.06);">

      <h1 class="mb-4" style="color: var(--text-dark);">Mentions légales</h1>

      <?php require __DIR__ . '/layout/mentions_contenu.php'; ?>

    </div>
  </div>
</section>

<?php require __DIR__ . '/layout/footer.php'; ?>
