<?php
require('lienbd.php');
require ('fonction.php');




    if(est_connecte()){
        header('Location: index.php');
        exit();
    }


$succes=false ;

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

    $bd3="SELECT * FROM client WHERE email = ?";
$statement3=mysqli_prepare($lienbd,$bd3);
mysqli_stmt_bind_param($statement3,"s",$email);
mysqli_stmt_execute($statement3);
$result=mysqli_stmt_get_result($statement3);

if (mysqli_num_rows($result) > 0) {
    echo "L'adresse e-mail est déjà utilisée. Veuillez en choisir une autre.";
    exit();
}



    //requete
    $bd="INSERT INTO client(nom,prenom,email,telephone,adresse,date_inscription)
            VALUES (?,?,?,?,?,NOW())";

    //preparation de la requete
    $statement=mysqli_prepare($lienbd,$bd);

    //Lier la variable dans la requete 
    mysqli_stmt_bind_param($statement, "sssss", $nom,$prenom,$email,$telephone,$adresse);
        
    //execution de la requete
        if (mysqli_stmt_execute($statement)) {
    // Récupérer l'ID du client nouvellement inséré
                $id_client = mysqli_insert_id($lienbd);
            $bd2="INSERT INTO login (login,mot_de_passe,niveau,id_client)
            VALUES(?,?,?,?)";
                $statement2=mysqli_prepare($lienbd,$bd2);
                 $niveau = "client";

        mysqli_stmt_bind_param($statement2,"sssi",$email,$mdp,$niveau,$id_client);

        if(mysqli_stmt_execute($statement2)){
            $succes=true;

        } else {
            echo "Erreur lors de l'inscription : " . mysqli_error($lienbd);
        }

    } else {
        echo "Erreur de préparation de la requête : " . mysqli_error($lienbd);
    }
}


   ?>  

<?php include 'header.php'; ?>
 
<!-- Bouton caché pour déclencher le modal -->
<?php if ($succes): ?>
<button
    data-bs-toggle="modal"
    data-bs-target="#modalSucces"
    style="display:none"
    id="btnModalSucces">
</button>
<?php endif; ?>
 
<!-- Bootstrap Modal -->
<!-- Bootstrap Modal - Thème SuperCar (orange / noir) -->
<div class="modal fade" id="modalSucces" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="background: #1c1c1c; border-radius: 14px; box-shadow: 0 0 30px rgba(255, 107, 0, 0.3);">

            <!-- Barre orange en haut -->
            <div style="height: 5px; background: linear-gradient(90deg, #f37e2b, #eb9429); border-radius: 14px 14px 0 0;"></div>

            <div class="modal-body py-4 text-center" style="color: #fff;">

               

                <!-- Titre -->
                <h5 class="mt-3 mb-2 fw-bold" style="color: #ff6b00; font-size: 1.3rem;">
                    Compte créé avec succès !
                </h5>

                <!-- Message -->
                <p style="color: #aaa; font-size: 0.95rem;">
                    Votre compte a bien été créé.<br>Vous pouvez maintenant vous connecter.
                </p>

            </div>

            <div class="modal-footer justify-content-center border-0 pb-4" style="background: transparent;">
                <a href="connexion.html" class="btn fw-bold px-4 py-2"
                   style="background: #ff6b00; color: #fff; border: none; border-radius: 8px;">
                    Se connecter →
                </a>
            </div>

        </div>
    </div>
</div>
 
<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 
<!-- Ouvrir le modal si succès -->
<?php if ($succes): ?>
<script>
    document.getElementById('btnModalSucces').click();
</script>
<?php endif; ?>
 
</body>
</html>