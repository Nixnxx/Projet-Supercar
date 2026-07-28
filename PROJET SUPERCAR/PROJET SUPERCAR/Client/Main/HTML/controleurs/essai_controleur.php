<?php
// ============================================================
//  controleurs/essai_controleur.php  —  CONTRÔLEUR : demande d'essai
//  Réservé aux clients connectés. Appelé par essai.php.
//  Vérifications : la date d'essai doit être future et la voiture doit exister.
// ============================================================

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../modeles/client_modele.php';
require_once __DIR__ . '/../modeles/voiture_modele.php';
require_once __DIR__ . '/../modeles/essai_modele.php';

date_default_timezone_set('Indian/Mauritius');

// Cette page est réservée aux clients connectés.
if (!est_connecte()) {
    header('Location: nonconnecte.php');
    exit();
}

// Informations du client connecté (pré-remplissage du formulaire).
$client = get_client($lienbd, (int)$_SESSION['id_client']);

$message = "";
// WhatsApp : $reservation_ok passe à true quand la demande est bien
// enregistrée, ce qui déclenche l'ouverture de WhatsApp côté vue.
// $lien_whatsapp contiendra alors l'URL wa.me avec le message pré-rempli.
$reservation_ok = false;
$lien_whatsapp  = "";

// Paramètres reçus par l'URL (voiture / marque pré-sélectionnées).
$voitureSelected = isset($_GET['voiture'])   ? (int)$_GET['voiture']   : 0;
$marqueSelected  = isset($_GET['id_marque']) ? (int)$_GET['id_marque'] : 0;

// ---- Traitement du formulaire de réservation ----
if (isset($_POST['reserver'])) {
    $date    = $_POST['date_essai'] ?? '';
    $voiture = (int)($_POST['voiture'] ?? 0);

    // Validation 1 : la date doit être valide ET dans le futur.
    $ts_date = strtotime($date);
    if ($ts_date === false || $ts_date < strtotime('today')) {
        $message = "Veuillez choisir une date d'essai future.";
    // Validation 2 : la voiture doit exister.
    } elseif (!voiture_existe($lienbd, $voiture)) {
        $message = "La voiture sélectionnée n'existe pas.";
    // Validation 3 : la voiture ne doit pas être déjà réservée (essai confirmé).
    // Empêche de contourner le bouton grisé en tapant l'URL directement.
    } elseif (!voiture_disponible($lienbd, $voiture)) {
        $message = "Cette voiture est actuellement indisponible (déjà réservée).";
    } else {
        $dateDemande = date("Y-m-d H:i:s");
        $idClient    = (int)$_SESSION['id_client'];

        if (creer_demande_essai($lienbd, $dateDemande, $date, $idClient, $voiture)) {
            // La demande est enregistrée en base. On prépare maintenant le
            // lien WhatsApp (avec un message pré-rempli) que la vue ouvrira
            // automatiquement dans un nouvel onglet.
            $reservation_ok = true;

            // Nom du modèle choisi, pour l'insérer dans le message.
            $v      = get_voiture($lienbd, $voiture);
            $modele = $v ? $v['model'] : 'un véhicule';

            // Message pré-rempli. rawurlencode() rend le texte utilisable dans
            // une URL (il encode les espaces, accents, etc.).
            $texte = "Bonjour SuperCar, je souhaite reserver un essai pour la "
                   . $modele . " le " . $date . ".";
            $lien_whatsapp = "https://wa.me/" . WHATSAPP_NUMERO
                           . "?text=" . rawurlencode($texte);

            $message = "Votre demande d'essai a bien été enregistrée !";
        } else {
            $message = "Erreur lors de la réservation.";
        }
    }
}

// Liste des voitures proposées (filtrée si une marque est demandée).
$voitures = get_voitures_pour_essai($lienbd, $marqueSelected);

$titre_page = 'SuperCar – Demande d\'essai';

require __DIR__ . '/../vues/essai_vue.php';
