<?php
require('lienbd.php');
require ('fonction.php');
$erreur=null;

if(isset($_POST['utilisateur']) && isset($_POST['motdepasse'])){
        $utilisateur=$_POST['utilisateur'];
        $password=$_POST['motdepasse'];

if(!empty($utilisateur) &&(!empty($password))){
//lien avec la Base de donnée

        $bd= "SELECT * 
       FROM client 
       JOIN login ON client.id_client = login.id_login
       WHERE client.email = ?";

        //preparation de la requete
        $statement = mysqli_prepare($lienbd, $bd);
        //Lier la variable dans la requete
        mysqli_stmt_bind_param($statement, "s", $utilisateur);
        //execution de la requete
        mysqli_stmt_execute($statement);
        //resultat de la requete
        $resultat =  mysqli_stmt_get_result($statement);

        //Si le resultat est vide alors l'identifiant est incorrect sinon on verifie le mot de passe
        if($resultat ->num_rows===0){
        $erreur="identifiant incorrect";
}
    else{
        $user=$resultat ->fetch_assoc();
        if(password_verify($password, $user['mot_de_passe'])){
            session_start();
            $_SESSION['connecte'] = 1;
            $_SESSION['id_client'] = $user['id_client'];

            if (isset($_SESSION['contact_en_attente'])){
                header('Location: contactclient.php');
            }else{
                header('Location:index.php');
            }
            exit();
    }
    else {
        $erreur="identifiant incorrect";
    }
}
}
}
?>

<?php
    if(est_connecte()){
        header('Location: index.php');
        exit();
    }

    ?>

    
<?php
if($erreur){
    echo $erreur;
}

?> 



