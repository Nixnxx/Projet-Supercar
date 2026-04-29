<?php
require('lienbd.php');
require('fonction.php');

$erreur = "";
if(isset($_POST['utilisateur']) && isset($_POST['motdepasse'])){
    $admin    = $_POST['utilisateur'];
    $password = $_POST['motdepasse'];

    if(!empty($admin) && !empty($password)){
        $bd = "SELECT * FROM login WHERE login = ?";
        $statement = mysqli_prepare($lienbd, $bd);
        mysqli_stmt_bind_param($statement, "s", $admin);
        mysqli_stmt_execute($statement);
        $resultat = mysqli_stmt_get_result($statement);

        if($resultat->num_rows === 0){
            header('Location: logina.php?erreur=1');
            exit();
        } else {
            $user = $resultat->fetch_assoc();
           

            if(password_verify($password, $user['mot_de_passe'])){
                session_start();
                $_SESSION['connecte']  = 1;
                $_SESSION['id_login']  = $user['id_login'];
                header('Location:accueil.php');
                exit();
            } else {
                header('Location: logina.php?erreur=1');
                exit();
            }
        }
    }
}

?>

<?php
if (est_connecte()) {
    header('Location: index.php');
    exit();
}
?>

<?php
if ($erreur) {
    echo $erreur;
}
?>