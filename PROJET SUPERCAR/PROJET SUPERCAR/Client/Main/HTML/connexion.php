<?php
require('lienbd.php');
require('fonction.php');
$erreur = null;

if (isset($_POST['utilisateur']) && isset($_POST['motdepasse'])) {
    $utilisateur = $_POST['utilisateur'];
    $password    = $_POST['motdepasse'];

    if (!empty($utilisateur) && (!empty($password))) {

        $bd = "SELECT * 
               FROM client 
               JOIN login ON client.id_client = login.id_client
               WHERE client.email = ?";

        // Préparation de la requête
        $statement = mysqli_prepare($lienbd, $bd);
        // Lier la variable dans la requête
        mysqli_stmt_bind_param($statement, "s", $utilisateur);
        // Exécution de la requête
        mysqli_stmt_execute($statement);
        // Résultat de la requête
        $resultat = mysqli_stmt_get_result($statement);

        // Si le résultat est vide alors l'identifiant est incorrect sinon on vérifie le mot de passe
        if ($resultat->num_rows === 0) {
            $erreur = "identifiant incorrect";
        } else {
            $user = $resultat->fetch_assoc();

            if (password_verify($password, $user['mot_de_passe'])) {
                session_start();
                $_SESSION['connecte']  = 1;
                $_SESSION['id_client'] = $user['id_client'];

                // Vérifier s'il y a un message de contact en attente dans la session
                if (isset($_SESSION['contact_en_attente'])) {
                    $email_en_attente = $_SESSION['contact_en_attente']['email'];

                    if ($email_en_attente === $utilisateur) {
                        header('Location: contactclient.php');
                    } else {
                        unset($_SESSION['contact_en_attente']);
                        header('Location: index.php');
                    }
                } else {
                    header('Location: index.php');
                }
                exit();

            } else {
                $erreur = "identifiant incorrect";
            }
        }
    } else {
        $erreur = "Veuillez remplir tous les champs";
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