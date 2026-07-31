<?php
// ============================================================
//  vues/contact_vue.php  —  VUE : page de contact
//  Reçoit : $client (pré-remplissage), $config (infos concession),
//           $succes (vrai si le message vient d'être envoyé).
//  Les données de configuration sont échappées avec e().
// ============================================================
require __DIR__ . '/layout/header.php';
?>

<section id="contact">
    <div class="container">
        <h2>Contactez-nous</h2>

        <div class="contact-container">

            <!-- CARTE -->
            <div class="mini-map-wrapper">
                <div class="map-header">
                    <h3>Notre Concession</h3>
                </div>

                <div class="mini-map">
                    <!-- url_sure() : l'adresse de la carte vient de la base.
                         On n'autorise que http(s), jamais "javascript:". -->
                    <iframe src="<?= url_sure($config['map_embed'] ?? '') ?>"></iframe>
                </div>
            </div>

            <!-- FORMULAIRE -->
<form method="POST">

    <!-- Jeton anti-CSRF : prouve que le formulaire vient bien de notre site -->
    <?php csrf_champ(); ?>

    <input type="text" name="nom"
       placeholder="Nom"
       value="<?= e($client['nom'] ?? '') ?>" required>

<input type="text" name="numero"
       placeholder="Téléphone"
       value="<?= e($client['telephone'] ?? '') ?>" required>

<input type="email" name="email"
       placeholder="Email"
       value="<?= e($client['email'] ?? '') ?>" required>

    <textarea name="message"
              placeholder="Votre message" required></textarea>

    <button type="submit">Envoyer</button>
</form>

        </div>
    </div>
</section>

<!-- BULLES D'INFOS -->
<div class="contact-info-bubbles">

    <div class="info-bubble">
        <h4>Adresse</h4>
        <p><?= e($config['adresse'] ?? '') ?></p>
    </div>

    <div class="info-bubble">
        <h4>Email</h4>
        <p><?= e($config['email'] ?? '') ?></p>
    </div>

    <div class="info-bubble">
        <h4>Téléphone</h4>
        <p><?= e($config['telephone'] ?? '') ?></p>
    </div>

</div>

<!-- FENÊTRE DE CONFIRMATION -->
<?php if ($succes) : ?>
<div class="modal fade show d-block modal-succes" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 rounded-3">
            <div class="modal-body text-center px-4 py-4">
                <p class="text-white mb-3 modal-succes-texte">Message bien envoyé.</p>
                <a href="contact.php" class="btn btn-sm px-4 btn-modal-ok">OK</a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php require __DIR__ . '/layout/footer.php'; ?>
