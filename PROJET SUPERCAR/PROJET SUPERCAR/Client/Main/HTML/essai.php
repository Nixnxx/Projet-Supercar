<?php
session_start();
date_default_timezone_set('Indian/Mauritius');
require_once 'lienbd.php';
require_once 'fonction.php';

if (!est_connecte()) {
    header('Location: nonconnecte.php');
    exit();
}

// RECUP INFOS CLIENT CONNECTÉ
$sql_client = "SELECT * FROM client WHERE id_client = ?";
$stmt_client = mysqli_prepare($lienbd, $sql_client);
mysqli_stmt_bind_param($stmt_client, "i", $_SESSION['id_client']);
mysqli_stmt_execute($stmt_client);
$result_client = mysqli_stmt_get_result($stmt_client);
$client = mysqli_fetch_assoc($result_client);

include 'header.php';

$message = "";

// Récupération des paramètres GET
$voitureSelected = isset($_GET['voiture'])   ? (int)$_GET['voiture']   : 0;
$marqueSelected  = isset($_GET['id_marque']) ? (int)$_GET['id_marque'] : 0;

// TRAITEMENT FORMULAIRE
if (isset($_POST['reserver'])) {

    $date    = $_POST['date_essai'];
    $voiture = (int)$_POST['voiture'];

    $dateDemande = date("Y-m-d H:i:s");
    $idClient    = $_SESSION['id_client'];

    $sql_insert = "INSERT INTO demandeessai 
                   (date_demande, date_essai_proposee, statut, commentaire, id_client, id_voiture)
                   VALUES (?, ?, 0, 'Demande via site', ?, ?)";
    $stmt_insert = mysqli_prepare($lienbd, $sql_insert);
    mysqli_stmt_bind_param($stmt_insert, "ssii", $dateDemande, $date, $idClient, $voiture);

    if (mysqli_stmt_execute($stmt_insert)) {
        $message = "Votre demande d'essai a été envoyée !";
    } else {
        $message = "Erreur lors de la réservation.";
    }
}

// REQUÊTE VOITURES selon la marque ou toutes
if ($marqueSelected > 0) {
    $stmt_v = mysqli_prepare($lienbd,
        "SELECT v.id_voiture, v.model, m.nom AS marque
         FROM voiture v
         JOIN marque m ON v.id_marque = m.id_marque
         WHERE v.id_marque = ?
         ORDER BY v.model");
    mysqli_stmt_bind_param($stmt_v, "i", $marqueSelected);
} else {
    $stmt_v = mysqli_prepare($lienbd,
        "SELECT v.id_voiture, v.model, m.nom AS marque
         FROM voiture v
         JOIN marque m ON v.id_marque = m.id_marque
         ORDER BY m.nom, v.model");
}
mysqli_stmt_execute($stmt_v);
$result_voitures = mysqli_stmt_get_result($stmt_v);
?>

<section id="essai">
  <div class="container">

    <div class="essai-header">
      <h2>Demande d'essai</h2>
      <p>Réservez votre expérience</p>
    </div>

    <?php if ($message != "") : ?>
      <p class="success"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST" class="essai-form">

      <label>Nom</label>
      <input type="text" name="nom" value="<?= htmlspecialchars($client['nom'] ?? '') ?>" required>

      <label>Email</label>
      <input type="email" name="email" value="<?= htmlspecialchars($client['email'] ?? '') ?>" required>

      <label>Téléphone</label>
      <input type="text" name="telephone" value="<?= htmlspecialchars($client['telephone'] ?? '') ?>" required>

      <label>Choisir une voiture</label>
      <select name="voiture" required>
        <?php while ($row = mysqli_fetch_assoc($result_voitures)) : ?>
          <option value="<?= (int)$row['id_voiture'] ?>"
            <?= ($row['id_voiture'] == $voitureSelected) ? 'selected' : '' ?>>
            <?= htmlspecialchars($row['model']) ?>
          </option>
        <?php endwhile; ?>
      </select>

      <label>Date souhaitée</label>
      <input type="date" name="date_essai" required>

      <button type="submit" name="reserver">
        Réserver un essai
      </button>

    </form>

  </div>
</section>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>