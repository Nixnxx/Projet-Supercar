<?php
// ============================================================
//  includes/securite.php
//  Les fonctions de sécurité utilisées partout dans le site :
//    - e()            : rend une valeur sûre avant de l'afficher (anti-XSS)
//    - url_sure()     : rend un lien sûr avant de le mettre dans un href
//    - upload_image() : enregistre une image envoyée par un formulaire
//    - csrf_*()       : protège les formulaires contre le CSRF
//
//  La limitation des tentatives de connexion (force brute) est dans
//  modeles/admin/auth_modele.php : elle interroge la base (colonnes
//  tentatives_echouees / derniere_tentative de la table login), ce
//  n'est donc pas à sa place ici.
// ============================================================

// e() = "échapper". On l'utilise pour afficher toute donnée qui vient
// de la base ou de l'utilisateur. htmlspecialchars transforme les
// caractères dangereux (< > " ') en texte, ce qui empêche l'injection
// de code HTML/JavaScript dans la page (faille XSS).
function e($valeur) {
    return htmlspecialchars($valeur, ENT_QUOTES);
}

// url_sure() sécurise un lien AVANT de le mettre dans un href.
// Pourquoi e() ne suffit pas ici : htmlspecialchars protège le texte HTML,
// mais elle laisse passer un lien du type "javascript:..." car il n'y a ni
// chevron ni guillemet à échapper. Ce lien s'exécuterait au clic.
// On n'autorise donc que les liens internes et les liens http / https.
function url_sure($url) {
    $url = trim($url);

    // Lien vide : on renvoie une ancre neutre.
    if ($url === '') {
        return '#';
    }

    // Pas de deux-points = lien interne (essai.php, voitures.php...) : sans risque.
    if (strpos($url, ':') === false) {
        return e($url);
    }

    // Sinon, seuls http:// et https:// sont acceptés.
    if (stripos($url, 'http://') === 0 || stripos($url, 'https://') === 0) {
        return e($url);
    }

    // Tout le reste (javascript:, data:, ...) est refusé.
    return '#';
}

// upload_image() enregistre une image envoyée via un <input type="file">.
//   $fichier = la case de $_FILES (exemple : $_FILES['image'])
//   $dossier = où ranger l'image (exemple : 'Images-Index/')
// Renvoie le chemin à stocker en base, ou null si ce n'est pas une image.
function upload_image($fichier, $dossier) {
    // Aucun fichier envoyé
    if (empty($fichier['name'])) {
        return null;
    }

    // On récupère l'extension du fichier, en minuscules (jpg, png...)
    $ext = strtolower(pathinfo($fichier['name'], PATHINFO_EXTENSION));

    // VÉRIFICATION 1 : on n'accepte que les vraies extensions d'image.
    // Tout le reste (par exemple un fichier .php) est refusé.
    $extensions_autorisees = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    if (!in_array($ext, $extensions_autorisees)) {
        return null;
    }

    // VÉRIFICATION 2 : on regarde le CONTENU du fichier, pas seulement son nom.
    // Vérifier l'extension ne suffit pas : un pirate peut renommer son
    // fichier "virus.php" en "photo.jpg" et passer la vérification 1.
    // getimagesize() lit le début du fichier : elle échoue (renvoie false)
    // si ce n'est pas une vraie image, quel que soit le nom du fichier.
    if (getimagesize($fichier['tmp_name']) === false) {
        return null;
    }

    // VÉRIFICATION 3 : on limite la taille à 2 Mo pour éviter de saturer
    // le disque du serveur avec des fichiers énormes.
    if ($fichier['size'] > 2 * 1024 * 1024) {
        return null;
    }

    // On invente un nom unique pour ne pas écraser une image existante.
    $nom = uniqid() . '.' . $ext;

    // Chemin réel où enregistrer le fichier. Ce fichier est dans
    // HTML/includes/, et les images sont servies depuis HTML/public/.
    // On remonte d'un dossier (../), on entre dans public/, puis dans
    // le dossier voulu (ex : public/Images-Index/).
    // Le chemin RENVOYÉ, lui, reste "Images-Index/xxx.jpg" : c'est celui
    // du <img src="...">, relatif aux pages qui sont dans public/.
    $chemin = __DIR__ . '/../public/' . $dossier . $nom;

    // On déplace le fichier temporaire vers sa destination finale.
    move_uploaded_file($fichier['tmp_name'], $chemin);

    // On renvoie le chemin relatif (celui qu'on met en base et dans le src).
    return $dossier . $nom;
}


// ============================================================
//  PROTECTION CSRF
//
//  Le CSRF (Cross-Site Request Forgery) : un pirate crée une page
//  piégée. Si un administrateur connecté la visite, son navigateur
//  envoie automatiquement son cookie de session, et l'action part
//  en son nom (par exemple : supprimer une voiture).
//
//  La parade : un JETON. C'est une longue suite de caractères
//  aléatoires, gardée en session et recopiée dans chaque formulaire.
//  Le pirate ne peut pas la deviner, donc sa requête est rejetée.
// ============================================================

// Renvoie le jeton de la session. Il est créé au premier appel,
// puis réutilisé pendant toute la durée de la session.
function csrf_jeton() {
    if (!isset($_SESSION['csrf'])) {
        // random_bytes() tire 32 octets vraiment imprévisibles,
        // bin2hex() les transforme en texte lisible.
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

// Affiche le champ caché à placer dans CHAQUE formulaire.
// Dans une vue, on l'appelle juste après la balise <form>.
function csrf_champ() {
    echo '<input type="hidden" name="csrf" value="' . e(csrf_jeton()) . '">';
}

// Vérifie le jeton reçu. À appeler dans le contrôleur AVANT
// d'enregistrer quoi que ce soit. Si le jeton est absent ou faux,
// on arrête tout de suite le script.
function csrf_verifier() {
    // Le jeton arrive par POST (formulaire) ou par GET (lien de suppression).
    $recu = $_POST['csrf'] ?? $_GET['csrf'] ?? '';

    // hash_equals() compare les deux chaînes en prenant toujours le même
    // temps. Un == classique s'arrête au premier caractère différent, ce
    // qui permettrait à un pirate de deviner le jeton lettre par lettre.
    if (!isset($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $recu)) {
        http_response_code(403);
        die("Erreur de sécurité : formulaire invalide. Merci de recharger la page.");
    }
}
