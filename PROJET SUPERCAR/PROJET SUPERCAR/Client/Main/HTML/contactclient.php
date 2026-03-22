<?php
require ('lienbd.php');
require ('fonction.php');
 

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
    echo "Message envoyé avec succès !";
    } else {
        echo "Erreur lors de l'envoi du message : " . mysqli_error($lienbd);
    }


    // Supprime le message de la session après insertion
    unset($_SESSION['contact_en_attente']);
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
        echo "Message envoyé avec succès !";
    } else {
        echo "Erreur lors de l'envoi du message : " . mysqli_error($lienbd);
    }
        }

?>
    