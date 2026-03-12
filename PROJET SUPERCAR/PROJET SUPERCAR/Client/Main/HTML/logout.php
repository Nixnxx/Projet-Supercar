<?php
session_start();
unset($_SESSION['connecte']);
header('Location:index.php');
// PAS BESOIN DE METTRE EXIT PUISQU'IL N'Y A PLUS DE CODE DERRIERE
?>
