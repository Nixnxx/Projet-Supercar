<?php
// ============================================================
//  vues/contact_vue.php  —  VUE : page de contact
//  Reçoit : $client (fiche du client connecté), $saisie (ce qu’il vient
//           de taper, réaffiché après une erreur), $config (infos concession),
//           $succes         (vrai si le message vient d'être envoyé),
//           $message_erreur (texte d'erreur de saisie, '' s'il n'y en a pas).
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

                <!-- Message d'erreur de saisie. Il est placé DANS le formulaire,
                     au-dessus des champs : le visiteur doit voir le problème et
                     les champs à corriger en même temps. Le contrôleur a déjà lu
                     l'URL et préparé le texte ; la vue ne fait que l'afficher. -->
                <?php if ($message_erreur !== '') : ?>
                    <p class="contact-erreur"><?= e($message_erreur) ?></p>
                <?php endif; ?>

                <!-- Les maxlength reprennent les limites vérifiées par le
                     contrôleur : le visiteur est arrêté tout de suite, sans
                     aller-retour au serveur. La vraie validation reste celle
                     du contrôleur, un attribut HTML se contourne. -->
                <!-- Ordre de priorité pour remplir un champ :
                     1. $saisie  : ce que le visiteur vient de taper, quand un
                        contrôle a échoué — il ne doit rien avoir à retaper ;
                     2. $client  : sa fiche, s'il est connecté ;
                     3. vide     : premier passage d'un visiteur anonyme. -->
                <input type="text" name="nom" maxlength="50" required
                       placeholder="Nom"
                       value="<?= e($saisie['nom'] ?? $client['nom'] ?? '') ?>">

                <input type="text" name="numero" maxlength="20" required
                       placeholder="Téléphone"
                       value="<?= e($saisie['numero'] ?? $client['telephone'] ?? '') ?>">

                <input type="email" name="email" maxlength="100" required
                       placeholder="Email"
                       value="<?= e($saisie['email'] ?? $client['email'] ?? '') ?>">

                <!-- Un textarea n'a pas d'attribut value : son contenu s'écrit
                     ENTRE les balises ouvrante et fermante. Aucun espace ni
                     retour à la ligne autour de la balise PHP ci-dessous,
                     sinon ils apparaîtraient dans le champ. -->
                <textarea name="message" maxlength="800" required
                          placeholder="Votre message"><?= e($saisie['message'] ?? '') ?></textarea>

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

    <div class="info-bubble">
        <h4>Personne à contacter</h4>
        <p><?= e($config['personne_nom'] ?? '') ?></p>
        <p><?= e($config['personne_email'] ?? '') ?></p>
        <p><?= e($config['personne_telephone'] ?? '') ?></p>
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

<?php /* Pas de fenêtre pour les erreurs de saisie : le message s'affiche
         directement dans le formulaire (voir plus haut), là où se trouvent
         les champs à corriger. Une fenêtre obligerait à cliquer "OK" avant
         de pouvoir modifier quoi que ce soit. */ ?>

<?php require __DIR__ . '/layout/footer.php'; ?>
