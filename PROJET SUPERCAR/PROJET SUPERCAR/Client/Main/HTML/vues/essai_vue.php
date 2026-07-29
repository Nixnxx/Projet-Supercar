<?php
// ============================================================
//  vues/essai_vue.php  —  VUE : formulaire de demande d'essai
//  Reçoit : $client, $message, $voitures, $voitureSelected.
// ============================================================
require __DIR__ . '/layout/header.php';
?>

<section id="essai">
  <div class="container">

    <div class="essai-header">
      <h2>Demande d'essai</h2>
      <p>Réservez votre expérience</p>
    </div>

    <?php if ($message != "") : ?>
      <p class="success"><?= e($message) ?></p>
    <?php endif; ?>

    <?php if ($reservation_ok) : ?>
      <!-- Demande enregistrée : on ouvre WhatsApp dans un nouvel onglet.
           Un bouton manuel est proposé au cas où le navigateur bloque
           l'ouverture automatique (blocage des pop-ups). -->
      <div class="essai-whatsapp" id="zone-whatsapp" data-lien="<?= e($lien_whatsapp) ?>">
        <p>Vous allez être redirigé vers WhatsApp pour finaliser votre demande avec le concessionnaire.</p>
        <a href="<?= e($lien_whatsapp) ?>" target="_blank" rel="noopener" class="btn-whatsapp-essai">
          <i class="bi bi-whatsapp"></i> Continuer sur WhatsApp
        </a>
      </div>
    <?php endif; ?>

    <form method="POST" class="essai-form">

        <!-- Jeton anti-CSRF : prouve que le formulaire vient bien de notre site -->
        <?php csrf_champ(); ?>


      <label>Nom</label>
      <input type="text" name="nom" value="<?= e($client['nom'] ?? '') ?>" required>

      <label>Email</label>
      <input type="email" name="email" value="<?= e($client['email'] ?? '') ?>" required>

      <label>Téléphone</label>
      <input type="text" name="telephone" value="<?= e($client['telephone'] ?? '') ?>" required>

      <label>Choisir une voiture</label>
      <select name="voiture" required>
        <?php foreach ($voitures as $row) : ?>
          <?php $estIndisponible = ((int) $row['disponible'] === 0); ?>
          <option value="<?= (int)$row['id_voiture'] ?>"
            <?= ($row['id_voiture'] == $voitureSelected) ? 'selected' : '' ?>
            <?= $estIndisponible ? 'disabled style="color:#9aa0a6;"' : '' ?>>
            <?= e($row['model']) ?><?= $estIndisponible ? ' (indisponible)' : '' ?>
          </option>
        <?php endforeach; ?>
      </select>

      <label>Date souhaitée</label>
      <input type="date" name="date_essai" required>

      <button type="submit" name="reserver">
        Réserver un essai
      </button>

    </form>

  </div>
</section>

<script src="js/essai.js"></script>

<?php require __DIR__ . '/layout/footer.php'; ?>
