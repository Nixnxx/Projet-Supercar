<?php
// ============================================================
//  includes/securite.php
//  Deux petites fonctions utiles partout dans le site :
//    - e()            : rend une valeur sûre avant de l'afficher (anti-XSS)
//    - upload_image() : enregistre une image envoyée par un formulaire
// ============================================================

// e() = "échapper". On l'utilise pour afficher toute donnée qui vient
// de la base ou de l'utilisateur. htmlspecialchars transforme les
// caractères dangereux (< > " ') en texte, ce qui empêche l'injection
// de code HTML/JavaScript dans la page (faille XSS).
function e($valeur) {
    return htmlspecialchars($valeur, ENT_QUOTES);
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

    // On n'accepte que les vraies extensions d'image.
    // Tout le reste (par exemple un fichier .php) est refusé.
    $extensions_autorisees = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    if (!in_array($ext, $extensions_autorisees)) {
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
