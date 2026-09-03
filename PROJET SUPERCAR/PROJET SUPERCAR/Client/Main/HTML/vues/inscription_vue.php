<?php
// ============================================================
//  vues/inscription_vue.php  —  VUE : formulaire d'inscription
//  Page autonome (plein écran). Reçoit : $succes, $erreur_msg.
// ============================================================
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/transparent.css?v=1.3">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Inscription</title>
</head>
<body class="inscription">

    <!-- Le formulaire s'envoie à lui-même (le contrôleur inscription.php) -->
    <form class="inscription-form" method="POST" action="inscription.php">

        <!-- Jeton anti-CSRF : prouve que le formulaire vient bien de notre site -->
        <?php csrf_champ(); ?>

        <section>
            <h1>Inscription</h1>

            <div class="input-box">
                <input type="text" name="nom" placeholder="Nom" required>
            </div>

            <div class="input-box">
                <input type="text" name="prenom" placeholder="Prenom" required>
            </div>

            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="input-box">
                <input type="tel" name="telephone" placeholder="Telephone" required>
            </div>

            <div class="input-box">
                <input type="text" name="adresse" placeholder="Adresse postale" required>
            </div>

            <div class="input-box">
                <input type="password" name="motdepasse" placeholder="Mot de passe (8 caractères min.)" required>
            </div>

            <div class="input-box">
                <input type="password" name="motdepasse_confirmation" placeholder="Confirmer le mot de passe" required>
            </div>

            <!-- Case obligatoire : le client confirme avoir lu la politique.
                 "required" empêche l'envoi si la case n'est pas cochée. -->
            <div class="checkbox-box">
                <input type="checkbox" name="politique" id="politique" required>
                <label for="politique">
                    J'ai lu et j'accepte la
                    <a href="politique.php" target="_blank">politique de confidentialité</a>
                </label>
            </div>

            <button class="login-btn" type="submit">S'inscrire</button>

            <div class="register-link">
                <p>Déjà inscrit ? Cliquez <a href="connexion.php">ici</a> pour vous connecter</p>
                <a href="index.php" class="retour-accueil">
                    <i class="bi bi-arrow-left icone-retour"></i>Retour à l'accueil
                </a>
            </div>

        </section>
    </form>

<!-- FENÊTRE D'ERREUR
     Le style est dans css/transparent.css (classes .fenetre-*),
     partagé avec la connexion client et la connexion admin. -->
<?php if ($erreur_msg != "") : ?>
<div class="modal fade show d-block fenetre-message" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content fenetre-carte">
            <div class="fenetre-barre"></div>
            <div class="fenetre-corps">
                <div class="fenetre-icone erreur">⚠️</div>
                <p class="fenetre-titre">Erreur d'inscription</p>
                <p class="fenetre-texte"><?= e($erreur_msg) ?></p>
                <a href="inscription.php" class="fenetre-bouton">Réessayer</a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- FENÊTRE DE SUCCÈS (même gabarit que la fenêtre d'erreur) -->
<?php if ($succes) : ?>
<div class="modal fade show d-block fenetre-message" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content fenetre-carte">
            <div class="fenetre-barre"></div>
            <div class="fenetre-corps">
                <div class="fenetre-icone succes">✅</div>
                <p class="fenetre-titre">Compte créé avec succès</p>
                <p class="fenetre-texte">
                    Votre compte a bien été créé.<br>Vous pouvez maintenant vous connecter.
                </p>
                <a href="connexion.php" class="fenetre-bouton">Se connecter</a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/transparent.js"></script>
</body>
</html>
