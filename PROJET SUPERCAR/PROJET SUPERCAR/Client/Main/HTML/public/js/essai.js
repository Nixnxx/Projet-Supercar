// ============================================================
//  js/essai.js — Demande d'essai (vues/essai_vue.php)
//  Ouvre automatiquement WhatsApp dans un nouvel onglet une fois
//  la demande enregistrée en base.
// ============================================================
document.addEventListener('DOMContentLoaded', function() {
    const zone = document.getElementById('zone-whatsapp');
    if (zone) {
        // Le lien WhatsApp a été préparé par le contrôleur et rangé
        // dans l'attribut data-lien (voir essai_vue.php).
        // Si le navigateur bloque l'ouverture automatique (pop-up),
        // le bouton visible sur la page permet de le faire manuellement.
        window.open(zone.dataset.lien, '_blank');
    }
});
