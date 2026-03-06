<?php
require('lienbd.php');
$erreur=null;

if(isset($_POST['utilisateur']) && isset($_POST['motdepasse'])){
        $utilisateur=$_POST['utilisateur'];
        $password=$_POST['motdepasse'];

if(!empty($utilisateur) &&(!empty($password))){
//lien avec la Base de donnée

        $bd= "SELECT * FROM client WHERE email= ?";
        //Mise en relation de la B.D et la requete
        $statement = mysqli_prepare($lienbd, $bd);
        //Lier la variable dans la requete
        mysqli_stmt_bind_param($statement, "s", $utilisateur);
        //execution de la requete
        mysqli_stmt_execute($statement);
        $resultat =  mysqli_stmt_get_result($statement);

        if($resultat ->num_rows===0){
        $erreur="email inconnue";
}
    else{
        $user=$resultat ->fetch_assoc();
        if(password_verify($password, $user['motdepasse'])){
            session_start();
            $_SESSION['connecte'] = 1;
            header('Location:index.php');
            exit();
    }else {
        $erreur="identifiant incorrect";
    }
}
}
}
?>


<?php
if($erreur){
    echo $erreur;
}

?> 

