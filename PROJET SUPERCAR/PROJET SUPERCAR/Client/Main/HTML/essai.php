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

$voitureSelected = isset($_GET['voiture']) ? $_GET['voiture'] : "";

if(isset($_POST['reserver'])){

    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $date = $_POST['date_essai'];
    $voiture = $_POST['voiture'];

    $dateDemande = date("Y-m-d H:i:s");
    $idClient = $_SESSION['id_client']; // ← directement depuis la session

        $sql = "INSERT INTO demandeessai 
                (date_demande, date_essai_proposee, statut, commentaire, id_client, id_voiture)
                VALUES 
                ('$dateDemande','$date',0,'Demande via site',$idClient,'$voiture')";

        if(mysqli_query($lienbd, $sql)){
            $message = "Votre demande d'essai a été envoyée !";
        }else{
            $message = "Erreur lors de la réservation.";
        }
    }

?>

<section id="essai">
<div class="container">

<div class="essai-header">
<h2>Demande d'essai</h2>
<p>Réservez votre expérience</p>

<div class="car-image">
<img src="Images-Index/Porsche - Ilaina/porsche-essai.jpg">
</div>
</div>

<?php if($message!=""){ ?>
<p class="success"><?php echo $message; ?></p>
<?php } ?>

<form method="POST" class="essai-form">

<label>Nom</label>
<input type="text" name="nom" value="<?= htmlspecialchars($client['nom'] ?? '') ?>" required>

<label>Email</label>
<input type="email" name="email" value="<?= htmlspecialchars($client['email'] ?? '') ?>" required>

<label>Téléphone</label>
<input type="text" name="telephone" value="<?= htmlspecialchars($client['telephone'] ?? '') ?>" required>

<label>Choisir une voiture</label>
<select name="voiture" required>

<?php
$sql = "SELECT id_voiture, model FROM voiture";
$result = mysqli_query($lienbd, $sql);

while($row = mysqli_fetch_assoc($result)){
    $selected = ($row['id_voiture'] == $voitureSelected) ? "selected" : "";
    echo "<option value='".$row['id_voiture']."' $selected>".$row['model']."</option>";
}
?>

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