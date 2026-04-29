<?php
session_start();
require('lienbd.php');
require('fonction.php');

$succes = false;

// RECUP INFOS CLIENT CONNECTÉ
$client = [];
if (est_connecte()) {
    $sql_client = "SELECT * FROM client WHERE id_client = ?";
    $stmt_client = mysqli_prepare($lienbd, $sql_client);
    mysqli_stmt_bind_param($stmt_client, "i", $_SESSION['id_client']);
    mysqli_stmt_execute($stmt_client);
    $result_client = mysqli_stmt_get_result($stmt_client);
    $client = mysqli_fetch_assoc($result_client);
}

// RECUP CONFIG CONTACT
$config_query = "SELECT * FROM contact_config LIMIT 1";
$config_result = mysqli_query($lienbd, $config_query);
$config = mysqli_fetch_assoc($config_result);

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
        unset($_SESSION['contact_en_attente']);
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
    <?php $attente = $_SESSION['contact_en_attente'] ?? []; ?>
    
    <input type="text" name="nom" 
       placeholder="Nom" 
       value="<?= htmlspecialchars($attente['nom'] ?? $client['nom'] ?? '') ?>" required>

<input type="text" name="numéro" 
       placeholder="Téléphone" 
       value="<?= htmlspecialchars($attente['numero'] ?? $client['telephone'] ?? '') ?>" required>

<input type="email" name="email" 
       placeholder="Email" 
       value="<?= htmlspecialchars($attente['email'] ?? $client['email'] ?? '') ?>" required>

    <textarea name="message" 
              placeholder="Votre message" required><?= htmlspecialchars($attente['message'] ?? '') ?></textarea>

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

<!-- POPUP SUCCES -->
<!-- POPUP SUCCES -->
<?php if (isset($_GET['succes'])): ?>
<div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,0.6);">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 rounded-3" style="background:#111;">
            <div class="modal-body text-center px-4 py-4">
                <p class="text-white mb-3" style="font-size:0.95rem;">Message bien envoyé.</p>
                <a href="contactclient.php" class="btn btn-sm px-4" style="background:#f97316; color:white; border-radius:20px;">OK</a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>