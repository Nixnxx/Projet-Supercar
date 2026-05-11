<?php
session_start();
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

        if ($resultat->num_rows === 0) {
             header('Location: connexionh.php?erreur=1');
exit();
        } else {
            $user = $resultat->fetch_assoc();

            if (password_verify($password, $user['mot_de_passe'])) {
                $_SESSION['connecte']  = 1;
                $_SESSION['id_client'] = $user['id_client'];
                $_SESSION['client_connecte'] = true;

              if (isset($_SESSION['essai_en_attente'])) {
    $params = [];
    if (isset($_SESSION['essai_id_marque']))  $params[] = 'id_marque='  . $_SESSION['essai_id_marque'];
    if (isset($_SESSION['essai_id_voiture'])) $params[] = 'voiture='    . $_SESSION['essai_id_voiture'];
    $query = count($params) > 0 ? '?' . implode('&', $params) : '';
    unset($_SESSION['essai_en_attente'], $_SESSION['essai_id_marque'], $_SESSION['essai_id_voiture']);
    header('Location: essai.php' . $query);
} elseif (isset($_SESSION['contact_en_attente'])) {
    unset($_SESSION['contact_en_attente']);
    header('Location: contactclient.php');
} else {
    header('Location: index.php');
}
exit();

            } else {
                header('Location: connexionh.php?erreur=1');
exit();
            }
        }
    } else {
       header('Location: connexionh.php?erreur=2');
exit();
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