<?php
session_start();
require('lienbd.php');
require('fonction.php');

$succes = false;

// RECUP CONFIG CONTACT
$config_query = "SELECT * FROM contact_config LIMIT 1";
$config_result = mysqli_query($lienbd, $config_query);
$config = mysqli_fetch_assoc($config_result);

// MESSAGE EN ATTENTE SI CONNECTÉ
if (est_connecte() && isset($_SESSION['contact_en_attente'])) {

    $data = $_SESSION['contact_en_attente'];

    $sql = "INSERT INTO contact (nom, email, message, id_client, numero)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "sssii",
        $data['nom'],
        $data['email'],
        $data['message'],
        $_SESSION['id_client'],
        $data['numero']
    );

    if (mysqli_stmt_execute($stmt)) {
        unset($_SESSION['contact_en_attente']);
        header('Location: contactclient.php?succes=1');
        exit();
    }
}

// TRAITEMENT FORMULAIRE
if (isset($_POST['nom'], $_POST['numéro'], $_POST['email'], $_POST['message'])) {

    $nom = htmlspecialchars($_POST['nom']);
    $numero = htmlspecialchars($_POST['numéro']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    if (!est_connecte()) {
        $_SESSION['contact_en_attente'] = compact('nom','numero','email','message');
        header('Location: nonconnecte.php');
        exit();
    }

    $id_client = $_SESSION['id_client'];

    $sql = "INSERT INTO contact (nom, email, message, id_client, numero)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($lienbd, $sql);
    mysqli_stmt_bind_param($stmt, "sssii", $nom, $email, $message, $id_client, $numero);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: contactclient.php?succes=1');
        exit();
    }
}

include 'header.php';
?>

<link rel="stylesheet" href="contact.css">

<section id="contact">
    <div class="container">
        <h2>Contactez-nous</h2>

        <div class="contact-container">

            <!-- MAP -->
            <div class="mini-map-wrapper">
                <div class="map-header">
                    <h3>Notre Concession</h3>
                </div>

                <div class="mini-map">
                    <iframe src="<?= $config['map_embed'] ?>"></iframe>
                </div>
            </div>

            <!-- FORM -->
            <form method="POST">
                <input type="text" name="nom" placeholder="Nom" required>
                <input type="text" name="numéro" placeholder="Téléphone" required>
                <input type="email" name="email" placeholder="Email" required>
                <textarea name="message" placeholder="Votre message" required></textarea>
                <button type="submit">Envoyer</button>
            </form>

        </div>
    </div>
</section>

<!-- BULLES -->
<div class="contact-info-bubbles">

    <div class="info-bubble">
        <h4>Adresse</h4>
        <p><?= $config['adresse'] ?></p>
    </div>

    <div class="info-bubble">
        <h4>Email</h4>
        <p><?= $config['email'] ?></p>
    </div>

    <div class="info-bubble">
        <h4>Téléphone</h4>
        <p><?= $config['telephone'] ?></p>
    </div>

</div>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
