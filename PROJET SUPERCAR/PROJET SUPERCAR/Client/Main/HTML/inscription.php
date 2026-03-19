<?php
require('lienbd.php');
require ('fonction.php');


if(isset($_POST['nom'])
    &&    isset($_POST['prenom'])
    &&    isset($_POST['email'])
    &&    isset($_POST['telephone'])
    &&    isset($_POST['adresse'])
    &&    isset($_POST['motdepasse'])
){

    $nom        =$_POST['nom'];
    $prenom     =$_POST['prenom'];
    $email      =$_POST['email'];
    $telephone  =$_POST['telephone'];
    $adresse    =$_POST['adresse'];
    $mdp    =password_hash($_POST['motdepasse'],PASSWORD_DEFAULT);;

    //requete
    $bd="INSERT INTO client(nom,prenom,email,telephone,adresse,date_inscription,id_contact)
            VALUES (?,?,?,?,?,NOW(),1)";

        //Mise en relation de la B.D et la requete
    $statement=mysqli_prepare($lienbd,$bd);

    //liaison de la variable 
    mysqli_stmt_bind_param($statement, "sssss", $nom,$prenom,$email,$telephone,$adresse);
        
    //execution de la requete
        if (mysqli_stmt_execute($statement)) {

                $id_client = mysqli_insert_id($lienbd);
            $bd2="INSERT INTO login (login,mot_de_passe,niveau,id_client)
            VALUES(?,?,?,?)";
                $statement2=mysqli_prepare($lienbd,$bd2);
                 $niveau = "client";

        mysqli_stmt_bind_param($statement2,"sssi",$email,$mdp,$niveau,$id_client);

        mysqli_stmt_execute($statement2);


            session_start();
            $_SESSION['connecte'] = 1;

            header('Location: index.php');
            exit();

        } else {
            echo "Erreur lors de l'inscription : " . mysqli_error($lienbd);
        }

    } else {
        echo "Erreur de préparation de la requête : " . mysqli_error($lienbd);
    }
?>


<?php
    if(est_connecte()){
        header('Location: index.php');
        exit();
    }

    ?>