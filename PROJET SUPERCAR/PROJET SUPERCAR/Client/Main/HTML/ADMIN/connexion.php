<?php
require('config.php');

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: connexion.php');
    exit();
}

$erreur = '';

if (isset($_POST['login'], $_POST['mot_de_passe'])) {
    $login = $_POST['login'];
    $mdp   = $_POST['mot_de_passe'];

    $stmt = mysqli_prepare($lienbd,
        "SELECT * FROM login WHERE login=? AND mot_de_passe=? LIMIT 1");
    mysqli_stmt_bind_param($stmt, 'ss', $login, $mdp);
    mysqli_stmt_execute($stmt);
    $user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if ($user && $user['niveau'] === 'admin') {
        $_SESSION['niveau']    = 'admin';
        $_SESSION['id_client'] = $user['id_client'];
        header('Location: admin_dashboard.php');
        exit();
    } else {
        $erreur = "Identifiants admin incorrects";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Connexion Admin</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root { --accent:#ff6b00; }
* { box-sizing:border-box; margin:0; padding:0; }
body { background:#0d0d0d; color:#fff; font-family:'DM Sans',sans-serif; display:flex; justify-content:center; align-items:center; height:100vh; }
.box { background:#161616; border:1px solid #272727; padding:40px; border-radius:14px; width:320px; text-align:center; }
h2 { font-size:20px; font-weight:700; margin-bottom:28px; }
h2 span { color:var(--accent); }
input { width:100%; padding:11px 14px; margin:7px 0; background:#1e1e1e; border:1px solid #313131; color:white; border-radius:7px; font-family:inherit; font-size:14px; outline:none; transition:border-color .15s; }
input:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(255,107,0,0.12); }
button { width:100%; padding:12px; background:var(--accent); border:none; color:white; font-weight:600; font-size:14px; border-radius:7px; cursor:pointer; margin-top:10px; font-family:inherit; transition:opacity .15s; }
button:hover { opacity:.88; }
.erreur { background:rgba(224,84,99,0.12); border:1px solid rgba(224,84,99,0.3); color:#e05463; font-size:13px; padding:10px 14px; border-radius:6px; margin-bottom:14px; }
</style>
</head>
<body>
<div class="box">
    <h2>Super<span>Car</span> Admin</h2>
    <?php if ($erreur): ?>
    <div class="erreur"><?= $erreur ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="login" placeholder="Login" required>
        <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
        <button>Se connecter</button>
    </form>
</div>
</body>
</html>
