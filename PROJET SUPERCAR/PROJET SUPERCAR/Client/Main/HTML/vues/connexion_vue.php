<?php
// ============================================================
//  vues/connexion_vue.php  —  VUE : formulaire de connexion client
//  Page autonome (plein écran). Reçoit : $erreur_msg.
// ============================================================
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/transparent.css?v=1.3">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b3996a5c2b.js" crossorigin="anonymous"></script>
    <title>Connexion</title>
</head>
<body class="connexion">

<!-- Le formulaire s'envoie à lui-même (le contrôleur connexion.php) -->
<form class="connexion-form" method="POST" action="connexion.php">

    <!-- Jeton anti-CSRF : prouve que le formulaire vient bien de notre site -->
    <?php csrf_champ(); ?>

    <section>
        <h1>Connexion</h1>
        <p>Avez-vous déjà un compte ? Identifiez-vous</p>

        <div class="input-box">
            <input type="email" name="utilisateur" placeholder="Votre identifiant" required>
            <i class="fa-solid fa-user"></i>
        </div>

        <div class="input-box">
            <input type="password" name="motdepasse" placeholder="Votre mot de passe" required>
            <i class="fa-solid fa-lock"></i>
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

        <button class="login-btn" type="submit">Se connecter</button>

        <div class="register-link">
            <p>Vous êtes nouveau client ? Cliquez <a href="inscription.php">ici</a> pour créer votre compte</p>
            <a href="index.php" class="retour-accueil">
                <i class="fa-solid fa-arrow-left" style="margin-right: 8px;"></i>Retour à l'accueil
            </a>
        </div>

    </section>
</form>

<!-- FENÊTRE D'ERREUR
     Le style est dans css/transparent.css (classes .fenetre-*),
     partagé avec l'inscription et la connexion admin. -->
<?php if ($erreur_msg != "") : ?>
<div class="modal fade show d-block fenetre-message" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content fenetre-carte">
            <div class="fenetre-barre"></div>
            <div class="fenetre-corps">
                <div class="fenetre-icone erreur">⚠️</div>
                <p class="fenetre-titre">Erreur de connexion</p>
                <p class="fenetre-texte"><?= e($erreur_msg) ?></p>
                <a href="connexion.php" class="fenetre-bouton">Réessayer</a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/transparent.js"></script>
</body>
</html>
