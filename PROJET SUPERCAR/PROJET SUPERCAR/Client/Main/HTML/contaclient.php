<?php
require ('lienbd.php');
require ('fonction.php');

    
    if (!est_connecte()) {
        header('Location: connexion.php');
        exit();
    }

if (        isset($_POST['nom'])
        &&  isset($_POST['numéro'])
        &&  isset($_POST['email'])
        &&  isset($_POST['message'])) {

    $nom = htmlspecialchars($_POST['nom']);
    $numéro = htmlspecialchars($_POST['numéro']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

  //requete
  $bd= "INSERT INTO contact (nom, email, message, id_client) 
                VALUES (?, ?, ?, ?)";
    //preparation de la requete
    $statement = mysqli_prepare($lienbd, $bd);
    //Lier la variable dans la requete
 mysqli_stmt_bind_param($statement, "sssi", $nom, $email, $message, $_SESSION['id_client']);
    //execution de la requete
    if (mysqli_stmt_execute($statement)) {
        echo "Message envoyé avec succès !";
    } else {
        echo "Erreur lors de l'envoi du message : " . mysqli_error($lienbd);
    }
        }

?>
    