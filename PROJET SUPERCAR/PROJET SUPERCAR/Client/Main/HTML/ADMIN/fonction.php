<?php
function est_connecte():bool{
    //UNE FONCTION POUR SAVOIR SI LA SESSION EST DEMARRE OU PAS
    if (session_status()=== PHP_SESSION_NONE){
        session_start();
    }
    return !empty($_SESSION['connecte']);
}

?>