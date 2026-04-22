<?php
session_start();

$lienbd = mysqli_connect('localhost', 'root', '', 'supercar');
if (!$lienbd) die('Erreur BDD : ' . mysqli_connect_error());
mysqli_set_charset($lienbd, 'utf8');

function est_connecte() { return isset($_SESSION['id_client']); }
function est_admin()     { return isset($_SESSION['niveau']) && $_SESSION['niveau'] === 'admin'; }
