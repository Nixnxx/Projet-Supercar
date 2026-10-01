<?php
// ============================================================
//  vues/admin/login_vue.php  —  VUE : formulaire de connexion admin
//  Page autonome. Affichée depuis ADMIN/logina.php : les chemins
//  relatifs (css, action) sont donc relatifs au dossier ADMIN/.
//  Reçoit : $erreur_msg.
// ============================================================
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/transparent.css?v=1.3">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b3996a5c2b.js" crossorigin="anonymous"></script>
    <title>Connexion administrateur</title>
</head>
<body class="connexion">

<form class="connexion-form" method="POST" action="logina.php">

    <!-- Jeton anti-CSRF : prouve que le formulaire vient bien de notre site -->
    <?php csrf_champ(); ?>

    <section>
        <h1>Connexion</h1>

        <div class="input-box">
                <input type="text" name="utilisateur" placeholder=" Votre identifiant" required>
        <i class="fa-solid fa-user"></i>
            </div>
                    <div class="input-box">
    <input type="password" name="motdepasse" placeholder="Votre mot de passe" required>
        <i class="fa-solid fa-lock"></i>
</div>
    <button class="login-btn" type="submit">Se connecter</button>

        </section>
</form>

<!-- FENÊTRE D'ERREUR
     Même gabarit que la connexion et l'inscription côté client :
     le style est dans css/transparent.css (classes .fenetre-*). -->
<?php if ($erreur_msg != "") : ?>
<div class="modal fade show d-block fenetre-message" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content fenetre-carte">
            <div class="fenetre-barre"></div>
            <div class="fenetre-corps">
                <div class="fenetre-icone erreur">⚠️</div>
                <p class="fenetre-titre">Erreur de connexion</p>
                <p class="fenetre-texte"><?= e($erreur_msg) ?></p>
                <a href="logina.php" class="fenetre-bouton">Réessayer</a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/transparent.js"></script>
</body>
</html>
