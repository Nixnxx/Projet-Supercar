<?php
require ('lienbd.php');
require ('fonction.php');
 
$succes = false;

/*SI LE CLIENT VIENT DE SE CONNECTER ,ET A UN MESSAGE EN ATTENTE */

    if (est_connecte() && isset($_SESSION['contact_en_attente'])) {
    $message_en_attente = $_SESSION['contact_en_attente'];

    $bd= "INSERT INTO contact (nom, email, message, id_client, numero) 
                VALUES (?, ?, ?, ?, ?)";

$statement= mysqli_prepare($lienbd, $bd);
mysqli_stmt_bind_param($statement,"sssii",
        $message_en_attente['nom'],
        $message_en_attente['email'],
        $message_en_attente['message'], 
        $_SESSION['id_client'],
        $message_en_attente['numero']);

if(mysqli_stmt_execute($statement)){
        // Supprime le message de la session après insertion réussie
    unset($_SESSION['contact_en_attente']);
    // $succes= true;
    //QUAND LE CLIENT RAFRAICHIT LA PAGE,LE MESSAGE NE SE REENGISTRE PLUS
     header('Location: contactclient.php?succes=1');
    exit();
    } else {
        echo "Erreur lors de l'envoi du message : " . mysqli_error($lienbd);
    }


}
    
//TRAITEMENT DU FORMULAIRE DE CONTACT DANS LE CAS OU L'UTILISATEUR EST DEJA CONNECTE
if (        isset($_POST['nom'])
        &&  isset($_POST['numéro'])
        &&  isset($_POST['email'])
        &&  isset($_POST['message'])) {

    $nom = htmlspecialchars($_POST['nom']);
    $numero = htmlspecialchars($_POST['numéro']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    /* SI L'UTILISATEUR N'EST PAS CONNECTÉ,
    ALORS QUE L'IL ESSAIE DE SOUMETTRE UN MESSAGE ,
    ON ENREGISTRE LE MESSAGE DANS UNE SESSION EN ATTENDANT QU'IL SE CONNECTE,
    ENTRE TEMPS , IL SERA REDIRIGÉ VERS LA PAGE DE CONNEXION 
    */  
    if (!est_connecte()) {
        $_SESSION['contact_en_attente'] = [
            'nom' => $nom ,
            'numero' => $numero,   
            'email' => $email,
            'message' => $message
        ];
        header('Location: nonconnecte.php');
        exit();
    }


   
    
    if (!isset($_SESSION['id_client'])) {
    die("Erreur : id_client non défini");
}
  //requete
  $bd= "INSERT INTO contact (nom, email, message, id_client,numero) 
    
                VALUES (?, ?, ?, ?,?
                )";
    $id_client=$_SESSION['id_client'];
    //preparation de la requete
    $statement = mysqli_prepare($lienbd, $bd);
    //Lier la variable dans la requete
 mysqli_stmt_bind_param($statement, "sssii", $nom, $email, $message, $id_client, $numero);
    //execution de la requete
    if (mysqli_stmt_execute($statement)) {
        unset($_SESSION['contact_en_attente']);
        // $succes = true;
         header('Location: contactclient.php?succes=1');
    exit();
    } else {
        echo "Erreur lors de l'envoi du message : " . mysqli_error($lienbd);
    }
        }

?>
    

       <?php
  include 'header.php';
   ?>
   <?php if ($succes): ?>
<button
    data-bs-toggle="modal"
    data-bs-target="#modalSucces"
    style="display:none"
    id="btnModalSucces">
</button>
<?php endif; ?>
 
<!-- ── Bootstrap Modal ── -->
<div class="modal fade" id="modalSucces" tabindex="-1" aria-labelledby="modalSuccesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
 
            <div class="modal-body py-4">
                <div style="font-size:50px">✅</div>
                <h5 class="mt-3 mb-2">Message envoyé !</h5>
                <p class="text-muted">Votre message a bien été enregistré. Nous vous répondrons dans les plus brefs délais.</p>
            </div>
 
            <div class="modal-footer justify-content-center border-0 pb-4">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fermer</button>
            </div>
 
        </div>
    </div>
</div>

     

<section id="contact">
    <div class="container">
        <h2>Contactez-nous</h2>
        <p>Une question ? Une voiture vous intéresse ? Contactez-nous via le formulaire ou rendez-nous visite.</p>

        <div class="contact-container">

            <!-- MINI MAP -->
            <div class="mini-map-wrapper">
                <div class="map-header">
                    <h3>📍 Notre Concession</h3>
                    <p>MCCI – Ebène, Maurice</p>
                </div>

                <div class="mini-map">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14945.63749751723!2d57.4809!3d-20.2447!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x217c5ad7d9b3d19f%3A0x9c5e0e4b5fbc3e2f!2sMauritius%20Chamber%20of%20Commerce%20and%20Industry!5e0!3m2!1sfr!2smu!4v0000000000"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <a href="https://maps.google.com/?q=Mauritius+Chamber+of+Commerce+and+Industry+Ebene"
                   target="_blank"
                   class="map-link">
                   Voir sur Google Maps
                </a>
            </div>

            <!-- FORMULAIRE -->
            <form method="POST" action="contactclient.php">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" required>

                <label for="numéro">Numéro de téléphone</label>
                <input type="text" id="numéro" name="numéro" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message</label>
                <textarea id="message" name="message" required></textarea>

                <button type="submit">Envoyer</button>
            </form>

        </div>
    </div>
</section>

        <?php
  include 'footer.php';
  ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<?php if ($succes): ?>
<script>
    document.getElementById('btnModalSucces').click();
</script>
<?php endif; ?>


</body>
</html>