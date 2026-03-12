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

        //Mise en relation de la B.D et la requete
        $statement = mysqli_prepare($lienbd, $bd);
        //Lier la variable dans la requete
        mysqli_stmt_bind_param($statement, "s", $utilisateur);
        //execution de la requete
        mysqli_stmt_execute($statement);
        $resultat =  mysqli_stmt_get_result($statement);

        if($resultat ->num_rows===0){
        $erreur="identifiant incorrect";
}
    else{
        $user=$resultat ->fetch_assoc();
        if(password_verify($password, $user['mot_de_passe'])){
            session_start();
            $_SESSION['connecte'] = 1;
            header('Location:index.php');
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

