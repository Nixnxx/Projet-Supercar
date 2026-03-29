   <?php
   require_once 'fonction.php';
if (!est_connecte()) {
    header('Location: nonconnecte.php');
    exit();
}

  include 'header.php';
  ?>

  <?php

$conn = new mysqli("localhost", "root", "", "supercar");

if ($conn->connect_error) {
    die("Erreur connexion : " . $conn->connect_error);
}

$message = "";

// récupérer voiture avec URL (oui c'est dure.....)
$voitureSelected = isset($_GET['voiture']) ? $_GET['voiture'] : "";

if(isset($_POST['reserver'])){

    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $date = $_POST['date_essai'];
    $voiture = $_POST['voiture'];

    $dateDemande = date("Y-m-d H:i:s");

    //  insert client
    $sqlClient = "INSERT INTO client (nom, prenom, email, telephone, adresse, date_inscription)
                 VALUES ('$nom','','$email','$telephone','',CURDATE())";

    if($conn->query($sqlClient)){
        $idClient = $conn->insert_id;

        //  insert demande essai (Nix bouffon)
        $sql = "INSERT INTO demandeessai 
                (date_demande, date_essai_proposee, statut, commentaire, id_client, id_voiture)
                VALUES 
                ('$dateDemande','$date',0,'Demande via site',$idClient,'$voiture')";

        if($conn->query($sql)){
            $message = "Votre demande d'essai a été envoyée !";
        }else{
            $message = "Erreur lors de la réservation.";
        }
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
<input type="text" name="nom" required>

<label>Email</label>
<input type="email" name="email" required>

<label>Téléphone</label>
<input type="text" name="telephone" required>

<label>Choisir une voiture</label>
<select name="voiture" required>

<?php
$sql = "SELECT id_voiture, model FROM voiture";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()){
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
