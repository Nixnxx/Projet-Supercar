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
    <link rel="stylesheet" href="css/transparent.css?v=1.2">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Inscription</title>
</head>
<body class="inscription">

    <!-- Le formulaire s'envoie à lui-même (le contrôleur inscription.php) -->
    <form class="inscription-form" method="POST" action="inscription.php">
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
                    <i class="bi bi-arrow-left" style="margin-right: 8px;"></i>Retour à l'accueil
                </a>
            </div>

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
                <h6 class="fw-bold mb-2" style="color:#f97316;">Erreur d'inscription</h6>
                <p class="mb-3" style="color:#aaa; font-size:0.9rem;"><?= e($erreur_msg) ?></p>
                <a href="inscription.php" class="btn btn-sm px-4" style="background:#f97316; color:white; border:none; border-radius:20px; font-size:0.85rem;">Réessayer</a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- FENÊTRE DE SUCCÈS -->
<?php if ($succes) : ?>
<div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,0.7);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="background: #1c1c1c; border-radius: 14px; box-shadow: 0 0 30px rgba(255, 107, 0, 0.3);">
            <div style="height: 5px; background: linear-gradient(90deg, #f37e2b, #eb9429); border-radius: 14px 14px 0 0;"></div>
            <div class="modal-body py-4 text-center" style="color: #fff;">
                <h5 class="mt-3 mb-2 fw-bold" style="color: #ff6b00; font-size: 1.3rem;">
                    Compte créé avec succès !
                </h5>
                <p style="color: #aaa; font-size: 0.95rem;">
                    Votre compte a bien été créé.<br>Vous pouvez maintenant vous connecter.
                </p>
            </div>
            <div class="modal-footer justify-content-center border-0 pb-4" style="background: transparent;">
                <a href="connexion.php" class="btn fw-bold px-4 py-2"
                   style="background: #ff6b00; color: #fff; border: none; border-radius: 8px;">
                    Se connecter →
                </a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/transparent.js"></script>
</body>
</html>
