<?php
// ============================================================
//  config/config.php
//  Quelques réglages réutilisés dans le site.
// ============================================================

// Dossiers où sont rangées les images (chemins à partir du dossier HTML/).
define('DOSSIER_IMAGES',          'Images-Index/');
define('DOSSIER_IMAGES_SERVICES', 'Images-Index/Service_Image/');

// Longueur minimale d'un mot de passe à l'inscription.
define('MDP_LONGUEUR_MIN', 8);

// Numéro WhatsApp du concessionnaire, au format international sans "+" ni
// espaces (celui qu'attend un lien wa.me). 230 = indicatif de Maurice.
// Défini ici une seule fois, puis réutilisé (footer + demande d'essai).
define('WHATSAPP_NUMERO', '23057456170');
?>