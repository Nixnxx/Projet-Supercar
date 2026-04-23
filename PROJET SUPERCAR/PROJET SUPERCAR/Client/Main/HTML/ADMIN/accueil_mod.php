<?php

// ============================================================
//  admin_accueil_form.php  -  Ajouter OU Modifier un élément
//
//  Comment ça marche :
//  - On reçoit "table" en GET  (carousel, hero, hero_image, point, stat)
//  - On reçoit "id"    en GET  (si id existe = modification, sinon = ajout)
// ============================================================

// Connexion à la base de données
$conn = mysqli_connect("localhost", "root", "", "supercar");
if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// On récupère la table et l'id depuis l'URL
$table = isset($_GET['table']) ? $_GET['table'] : '';
$id    = isset($_GET['id'])    ? intval($_GET['id']) : 0;

// On initialise un tableau vide (sera rempli si modification)
$donnees = array();

// ---- Si on est en mode MODIFICATION, on charge les données existantes ----
if ($id > 0) {

    if ($table == 'carousel') {
        $req  = mysqli_prepare($conn, "SELECT * FROM accueil_carousel WHERE id = ?");
        mysqli_stmt_bind_param($req, "i", $id);
        mysqli_stmt_execute($req);
        $res  = mysqli_stmt_get_result($req);
        $donnees = mysqli_fetch_assoc($res);
    }

    if ($table == 'hero') {
        $req  = mysqli_prepare($conn, "SELECT * FROM accueil_bienvenue WHERE id = ?");
        mysqli_stmt_bind_param($req, "i", $id);
        mysqli_stmt_execute($req);
        $res  = mysqli_stmt_get_result($req);
        $donnees = mysqli_fetch_assoc($res);
    }

    if ($table == 'hero_image') {
        $req  = mysqli_prepare($conn, "SELECT * FROM accueil_bienvenue_images WHERE id = ?");
        mysqli_stmt_bind_param($req, "i", $id);
        mysqli_stmt_execute($req);
        $res  = mysqli_stmt_get_result($req);
        $donnees = mysqli_fetch_assoc($res);
    }

    if ($table == 'point') {
        $req  = mysqli_prepare($conn, "SELECT * FROM accueil_points WHERE id = ?");
        mysqli_stmt_bind_param($req, "i", $id);
        mysqli_stmt_execute($req);
        $res  = mysqli_stmt_get_result($req);
        $donnees = mysqli_fetch_assoc($res);
    }

    if ($table == 'stat') {
        $req  = mysqli_prepare($conn, "SELECT * FROM accueil_stats WHERE id = ?");
        mysqli_stmt_bind_param($req, "i", $id);
        mysqli_stmt_execute($req);
        $res  = mysqli_stmt_get_result($req);
        $donnees = mysqli_fetch_assoc($res);
    }
}


// ---- Si le formulaire est ENVOYÉ (bouton Enregistrer cliqué) ----
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // ---- CARROUSEL ----
    if ($table == 'carousel') {

        $titre       = $_POST['titre'];
        $description = $_POST['description'];
        $lien        = $_POST['lien'];
        $texte_lien  = $_POST['texte_lien'];
        $ordre       = intval($_POST['ordre']);
        $actif       = isset($_POST['actif']) ? 1 : 0;

        // Gestion de l'image uploadée
        $image = $donnees['image'] ?? ''; // on garde l'ancienne image par défaut
        if (!empty($_FILES['image']['name'])) {
            $nom_fichier = basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], "../" . $nom_fichier);
            $image = $nom_fichier;
        }

        if ($id > 0) {
            // MODIFIER
            $req = mysqli_prepare($conn, "UPDATE accueil_carousel SET titre=?, description=?, image=?, lien=?, texte_lien=?, ordre=?, actif=? WHERE id=?");
            mysqli_stmt_bind_param($req, "sssssiis", $titre, $description, $image, $lien, $texte_lien, $ordre, $actif, $id);
            // Note : "sssssiis" = 7 string + 1 int + 1 int + 1 int =  s=string, i=integer
        } else {
            // AJOUTER
            $req = mysqli_prepare($conn, "INSERT INTO accueil_carousel (titre, description, image, lien, texte_lien, ordre, actif) VALUES (?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($req, "sssssii", $titre, $description, $image, $lien, $texte_lien, $ordre, $actif);
        }
        mysqli_stmt_execute($req);
        header("Location:accueil.php?msg=ok#carrousel");
        exit();
    }


    // ---- HERO ----
    if ($table == 'hero') {

        $titre       = $_POST['titre'];
        $sous_titre  = $_POST['sous_titre'];
        $description = $_POST['description'];
        $texte_cta   = $_POST['texte_cta'];
        $lien_cta    = $_POST['lien_cta'];

        // Le hero a toujours 1 seule ligne donc c'est toujours un UPDATE
        $req = mysqli_prepare($conn, "UPDATE accueil_bienvenue SET titre=?, sous_titre=?, description=?, texte=?, lien=? WHERE id=?");
        mysqli_stmt_bind_param($req, "sssssi", $titre, $sous_titre, $description, $texte_cta, $lien_cta, $id);
        mysqli_stmt_execute($req);
        header("Location: accueil.php?msg=ok#hero");
        exit();
    }


    // ---- IMAGE HERO ----
    if ($table == 'hero_image') {

        $alt   = $_POST['alt'];
        $ordre = intval($_POST['ordre']);
        $actif = isset($_POST['actif']) ? 1 : 0;

        $image = $donnees['image'] ?? '';
        if (!empty($_FILES['image']['name'])) {
            $nom_fichier = basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], "../" . $nom_fichier);
            $image = $nom_fichier;
        }

        if ($id > 0) {
            $req = mysqli_prepare($conn, "UPDATE accueil_bienvenue_images SET image=?, alt=?, ordre=?, actif=? WHERE id=?");
            mysqli_stmt_bind_param($req, "ssiii", $image, $alt, $ordre, $actif, $id);
        } else {
            $req = mysqli_prepare($conn, "INSERT INTO accueil_bienvenue_images (image, alt, ordre, actif) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($req, "ssii", $image, $alt, $ordre, $actif);
        }
        mysqli_stmt_execute($req);
        header("Location:accueil.php?msg=ok#images");
        exit();
    }


    // ---- POINT FORT ----
    if ($table == 'point') {

        $texte = $_POST['texte'];
        $ordre = intval($_POST['ordre']);
        $actif = isset($_POST['actif']) ? 1 : 0;

        if ($id > 0) {
            $req = mysqli_prepare($conn, "UPDATE accueil_points SET texte=?, ordre=?, actif=? WHERE id=?");
            mysqli_stmt_bind_param($req, "siii", $texte, $ordre, $actif, $id);
        } else {
            $req = mysqli_prepare($conn, "INSERT INTO accueil_points (texte, ordre, actif) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($req, "sii", $texte, $ordre, $actif);
        }
        mysqli_stmt_execute($req);
        header("Location:accueil.php?msg=ok#points");
        exit();
    }


    // ---- STATISTIQUE ----
    if ($table == 'stat') {

        $valeur = $_POST['valeur'];
        $label  = $_POST['label'];
        $ordre  = intval($_POST['ordre']);
        $actif  = isset($_POST['actif']) ? 1 : 0;

        if ($id > 0) {
            $req = mysqli_prepare($conn, "UPDATE accueil_stats SET valeur=?, label=?, ordre=?, actif=? WHERE id=?");
            mysqli_stmt_bind_param($req, "ssiii", $valeur, $label, $ordre, $actif, $id);
        } else {
            $req = mysqli_prepare($conn, "INSERT INTO accueil_stats (valeur, label, ordre, actif) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($req, "ssii", $valeur, $label, $ordre, $actif);
        }
        mysqli_stmt_execute($req);
        header("Location:accueil.php?msg=ok#stats");
        exit();
    }
}


// Titre de la page selon ce qu'on fait
$titre_page = ($id > 0) ? "Modifier" : "Ajouter";
?>


<?php
require_once('fonction.php');
if (!est_connecte()) {
    header('Location: login.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $titre_page ?> | Admin SuperCar</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body       { background: #111; color: #ddd; }
    .formulaire { max-width: 650px; margin: 40px auto; background: #1c1c1c;
                  border: 1px solid #333; border-radius: 10px; }
    .entete    { background: #222; padding: 15px 20px; border-radius: 10px 10px 0 0;
                 font-weight: bold; border-bottom: 1px solid #333; color: #ff6b00; }
    .form-control, .form-select { background: #111; border: 1px solid #444; color: #ddd; }
    .form-control:focus { background: #111; color: #fff; border-color: #ff6b00; box-shadow: none; }
    .btn-orange { background: #ff6b00; color: #fff; border: none; }
    .btn-orange:hover { background: #cc5500; color: #fff; }
    label      { color: #aaa; font-size: 0.9rem; }
    .apercu    { max-height: 130px; border-radius: 6px; margin-top: 8px; border: 1px solid #444; }
  </style>
</head>
<body>

<div class="formulaire">
  <div class="entete">
    <?= $titre_page ?> –
    <?php
      if ($table == 'carousel')   echo "Slide Carrousel";
      if ($table == 'hero')       echo "Texte Hero";
      if ($table == 'hero_image') echo "Image Hero";
      if ($table == 'point')      echo "Point Fort";
      if ($table == 'stat')       echo "Statistique";
    ?>
  </div>

  <div class="p-4">
    <form method="POST" enctype="multipart/form-data">

      <?php /* ==============================
               FORMULAIRE CARROUSEL
             ============================== */ ?>
      <?php if ($table == 'carousel') : ?>

        <div class="mb-3">
          <label>Titre *</label>
          <input type="text" name="titre" class="form-control"
                 value="<?= htmlspecialchars($donnees['titre'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
          <label>Description</label>
          <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($donnees['description'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
          <label>Image (JPG, PNG, WEBP)</label>
          <input type="file" name="image" class="form-control" accept="image/*"
                 onchange="afficherApercu(this)">
          <?php if (!empty($donnees['image'])) : ?>
            <img src="../<?= htmlspecialchars($donnees['image']) ?>" class="apercu" id="apercu" alt="">
          <?php else : ?>
            <img id="apercu" class="apercu d-none" alt="">
          <?php endif; ?>
          <small class="text-secondary">Laisser vide pour garder l'image actuelle.</small>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-6">
            <label>Lien du bouton</label>
            <input type="text" name="lien" class="form-control"
                   value="<?= htmlspecialchars($donnees['lien'] ?? 'essai.php') ?>">
          </div>
          <div class="col-6">
            <label>Texte du bouton</label>
            <input type="text" name="texte_lien" class="form-control"
                   value="<?= htmlspecialchars($donnees['texte_lien'] ?? 'Demander un essai') ?>">
          </div>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-6">
            <label>Ordre d'affichage</label>
            <input type="number" name="ordre" class="form-control"
                   value="<?= $donnees['ordre'] ?? 0 ?>" min="0">
          </div>
          <div class="col-6 d-flex align-items-end">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="actif" id="actif"
                     <?= ($donnees['actif'] ?? 1) ? 'checked' : '' ?>>
              <label class="form-check-label" for="actif">Slide active</label>
            </div>
          </div>
        </div>

      <?php endif; ?>


      <?php /* ==============================
               FORMULAIRE HERO
             ============================== */ ?>
      <?php if ($table == 'hero') : ?>

        <div class="mb-3">
          <label>Titre principal *</label>
          <input type="text" name="titre" class="form-control"
                 value="<?= htmlspecialchars($donnees['titre'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
          <label>Sous-titre</label>
          <input type="text" name="sous_titre" class="form-control"
                 value="<?= htmlspecialchars($donnees['sous_titre'] ?? '') ?>">
        </div>

        <div class="mb-3">
          <label>Description</label>
          <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($donnees['description'] ?? '') ?></textarea>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-8">
            <label>Texte du bouton</label>
            <input type="text" name="texte_cta" class="form-control"
                   value="<?= htmlspecialchars($donnees['texte_cta'] ?? '') ?>">
          </div>
          <div class="col-4">
            <label>Lien </label>
            <input type="text" name="lien_cta" class="form-control"
                   value="<?= htmlspecialchars($donnees['lien_cta'] ?? 'essai.php') ?>">
          </div>
        </div>

      <?php endif; ?>


      <?php /* ==============================
               FORMULAIRE IMAGE HERO
             ============================== */ ?>
      <?php if ($table == 'hero_image') : ?>

        <div class="mb-3">
          <label>Image *</label>
          <input type="file" name="image" class="form-control" accept="image/*"
                 onchange="afficherApercu(this)">
          <?php if (!empty($donnees['image'])) : ?>
            <img src="../<?= htmlspecialchars($donnees['image']) ?>" class="apercu" id="apercu" alt="">
          <?php else : ?>
            <img id="apercu" class="apercu d-none" alt="">
          <?php endif; ?>
        </div>

        <div class="mb-3">
          <label>Texte alternatif (description de l'image)</label>
          <input type="text" name="alt" class="form-control"
                 value="<?= htmlspecialchars($donnees['alt'] ?? '') ?>">
        </div>

        <div class="row g-3 mb-3">
          <div class="col-6">
            <label>Ordre</label>
            <input type="number" name="ordre" class="form-control"
                   value="<?= $donnees['ordre'] ?? 0 ?>" min="0">
          </div>
          <div class="col-6 d-flex align-items-end">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="actif" id="actif"
                     <?= ($donnees['actif'] ?? 1) ? 'checked' : '' ?>>
              <label class="form-check-label" for="actif">Image active</label>
            </div>
          </div>
        </div>

      <?php endif; ?>


      <?php /* ==============================
               FORMULAIRE POINT FORT
             ============================== */ ?>
      <?php if ($table == 'point') : ?>

        <div class="mb-3">
          <label>Texte du point fort *</label>
          <input type="text" name="texte" class="form-control"
                 value="<?= htmlspecialchars($donnees['texte'] ?? '') ?>" required>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-6">
            <label>Ordre</label>
            <input type="number" name="ordre" class="form-control"
                   value="<?= $donnees['ordre'] ?? 0 ?>" min="0">
          </div>
          <div class="col-6 d-flex align-items-end">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="actif" id="actif"
                     <?= ($donnees['actif'] ?? 1) ? 'checked' : '' ?>>
              <label class="form-check-label" for="actif">Point actif</label>
            </div>
          </div>
        </div>

      <?php endif; ?>


      <?php /* ==============================
               FORMULAIRE STATISTIQUE
             ============================== */ ?>
      <?php if ($table == 'stat') : ?>

        <div class="mb-3">
          <label>Valeur affichée (ex : +120, 98%, Île entière) *</label>
          <input type="text" name="valeur" class="form-control"
                 value="<?= htmlspecialchars($donnees['valeur'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
          <label>Label (ex : Véhicules vendus) *</label>
          <input type="text" name="label" class="form-control"
                 value="<?= htmlspecialchars($donnees['label'] ?? '') ?>" required>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-6">
            <label>Ordre</label>
            <input type="number" name="ordre" class="form-control"
                   value="<?= $donnees['ordre'] ?? 0 ?>" min="0">
          </div>
          <div class="col-6 d-flex align-items-end">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="actif" id="actif"
                     <?= ($donnees['actif'] ?? 1) ? 'checked' : '' ?>>
              <label class="form-check-label" for="actif">Stat active</label>
            </div>
          </div>
        </div>

      <?php endif; ?>


      <!-- Boutons -->
      <hr style="border-color:#333">
      <div class="d-flex gap-3">
        <button type="submit" class="btn btn-orange px-4">
          💾 <?= $id > 0 ? 'Enregistrer les modifications' : 'Ajouter' ?>
        </button>
        <a href="accueil.php" class="btn btn-outline-secondary">Annuler</a>
      </div>

    </form>
  </div>
</div>

<?php mysqli_close($conn); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Affiche un aperçu de l'image choisie avant l'envoi
function afficherApercu(input) {
    var img = document.getElementById('apercu');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            img.classList.remove('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
</body>
</html>


