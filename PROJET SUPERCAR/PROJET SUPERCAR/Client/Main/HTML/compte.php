<?php
require('lienbd.php');
$erreur=null;

if(isset($_POST['utilisateur']) && isset($_POST['motdepasse'])){
        $utilisateur=$_POST['utilisateur'];
        $password=$_POST['motdepasse'];

if(!empty($utilisateur) &&(!empty($password))){
//lien avec la Base de donnée

        $bd= "SELECT * FROM client WHERE email= ?";
        $statement = mysqli_prepare($lienbd, $bd);
        mysqli_stmt_bind_param($statement, "s", $utilisateur);
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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription-connexion</title>
</head>
<body>
    <form method="POST" action=""> 
    
       <p> avez-vous déjà un compte ?identifiez-vous </p>
       <input type="email" name="utilisateur" placeholder="Saisissez votre email">
       <br>
       <input type="password" name="motdepasse"placeholder="Saisissez votre mot de passe">
       <button type="submit">Se connecter</button> 
    <p>vous etes nouveau client ?cliquez-<a href="inscription.html">ici</a> pour creer votre compte</p>


</form>
</body>
</html>