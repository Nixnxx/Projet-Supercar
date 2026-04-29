<?php
$erreur_msg = "";
if (isset($_GET['erreur'])) {
    if ($_GET['erreur'] == 1) {
        $erreur_msg = "L'adresse e-mail est déjà utilisée. Veuillez en choisir une autre.";
    } else if ($_GET['erreur'] == 2) {
        $erreur_msg = "Erreur lors de l'inscription : veuillez réessayer.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/transparent.css">
    
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>inscription</title>
</head>
<body class="inscription">
    <form class="inscription-form" method=POST action="inscription.php" > 
        <section>
            <h1>Inscription</h1>
                    <div class="input-box">
            <input type="text" name="nom" placeholder="Nom" required>
                    </div>

                    <div class="input-box">
            <input type="text" name="prenom"  placeholder="Prenom" required>
                    </div>

                            <div class="input-box">
            <input type="email" name="email" placeholder="Email" required>
                            <div class="input-box">

            <input type="tel" name="telephone" placeholder="Telephone" required>

                             <div class="input-box">
            <input type="text" name="adresse"placeholder="Adresse postale" required>
                            </div>
                    
                            <div class="input-box">
            <input type="password"name="motdepasse" placeholder="mot de passe" required>
                            </div>
            
                            <button class="login-btn" type="submit">S'inscrire</button>
            <a href="index.php" class="login-btn">Retour à l'accueil</a>

        </section>    
       
    </form>

    
<!-- POPUP ERREUR -->
<?php if ($erreur_msg != ""): ?>
<div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,0.7);">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0" style="background:#111; border-radius:16px; box-shadow: 0 0 30px rgba(249,115,22,0.2);">
            
            <!-- barre orange en haut -->
            <div style="height:4px; background:linear-gradient(90deg,#f97316,#ea580c); border-radius:16px 16px 0 0;"></div>

            <div class="modal-body text-center px-4 py-4">
                <div style="width:48px; height:48px; background:rgba(249,115,22,0.1); border-radius:50%; display:flex; align-items:center; justify-content:center; margin: 0 auto 12px;">
                    <span style="font-size:1.3rem;">⚠️</span>
                </div>
                <h6 class="fw-bold mb-2" style="color:#f97316;">Erreur d'inscription</h6>
                <p class="mb-3" style="color:#aaa; font-size:0.9rem;"><?= $erreur_msg ?></p>
                <a href="inscriptionh.php" class="btn btn-sm px-4" style="background:#f97316; color:white; border:none; border-radius:20px; font-size:0.85rem;">Réessayer</a>
            </div>

        </div>
    </div>
</div>
<?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>