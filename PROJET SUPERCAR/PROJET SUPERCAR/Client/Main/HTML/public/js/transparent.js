// ============================================================
//  js/transparent.js — Animation d'apparition de la page
//  Partagé par connexion_vue.php et inscription_vue.php
//  (les 2 pages utilisent déjà la même feuille de style
//  transparent.css, donc le même script leur convient à toutes les 2).
// ============================================================
document.addEventListener("DOMContentLoaded", function() {
    // Petit délai de 50ms pour s'assurer que le navigateur applique l'état initial avant la transition
    setTimeout(function() {
        document.body.classList.add("loaded");
    }, 50);
});
