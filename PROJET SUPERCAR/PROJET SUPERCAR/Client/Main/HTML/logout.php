<?php
Session_start();
unset($_SESSION['connecte']);
header('Location: index.php');