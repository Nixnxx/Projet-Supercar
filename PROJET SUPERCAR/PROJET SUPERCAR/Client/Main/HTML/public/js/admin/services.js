// ============================================================
//  js/admin/services.js — Gestion des services (vues/admin/services_vue.php)
//  Contient : confirmation avant suppression, fermeture des fenêtres
//  (modales) en cliquant en dehors.
// ============================================================

// --- Confirmation avant suppression ---
document.addEventListener('click', function(event) {
    const lien = event.target.closest('[data-confirm]');
    if (lien) {
        if (!confirm(lien.dataset.confirm)) {
            event.preventDefault();
        }
    }
});

// --- Fermeture d'une fenêtre (modale) en cliquant en dehors ---
document.addEventListener('click', function(event) {
    const fenetre = event.target.closest('[data-close-href]');
    if (fenetre && event.target === fenetre) {
        location.href = fenetre.dataset.closeHref;
    }
});
