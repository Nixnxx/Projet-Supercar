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
    <link rel="stylesheet" href="../css/transparent.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b3996a5c2b.js" crossorigin="anonymous"></script>
    <title>Connexion administrateur</title>
</head>
<body class="connexion">

<form class="connexion-form" method="POST" action="logina.php">
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

<!-- FENÊTRE D'ERREUR -->
<?php if ($erreur_msg != "") : ?>
<div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,0.7);">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0" style="background:#111; border-radius:16px; box-shadow: 0 0 30px rgba(249,115,22,0.2);">
            <div style="height:4px; background:linear-gradient(90deg,#f97316,#ea580c); border-radius:16px 16px 0 0;"></div>
            <div class="modal-body text-center px-4 py-4">
                <div style="width:48px; height:48px; background:rgba(249,115,22,0.1); border-radius:50%; display:flex; align-items:center; justify-content:center; margin: 0 auto 12px;">
                    <span style="font-size:1.3rem;">⚠️</span>
                </div>
                <h6 class="fw-bold mb-2" style="color:#f97316;">Erreur de connexion</h6>
                <p class="mb-3" style="color:#aaa; font-size:0.9rem;"><?= e($erreur_msg) ?></p>
                <a href="logina.php" class="btn btn-sm px-4" style="background:#f97316; color:white; border:none; border-radius:20px; font-size:0.85rem;">Réessayer</a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
