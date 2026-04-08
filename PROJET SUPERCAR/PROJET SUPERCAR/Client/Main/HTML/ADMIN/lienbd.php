<?php
$server="localhost";
$user="root";
$mdp="";
$db="supercar";

//connexion à la base de donnée
$lienbd=mysqli_connect($server,$user,$mdp,$db);

//vérification de la connexion 
if (!$lienbd){
    echo"connexion echoué". mysqli_connect_error();
}

?>