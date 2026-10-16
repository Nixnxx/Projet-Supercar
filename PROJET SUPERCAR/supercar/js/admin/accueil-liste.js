// ============================================================
//  js/admin/accueil-liste.js — Contenu de la page d'accueil
//  (vues/admin/accueil_list_vue.php)
//  Contient : confirmation avant suppression d'un élément.
// ============================================================

document.addEventListener('click', function(event) {
    const lien = event.target.closest('[data-confirm]');
    if (lien) {
        if (!confirm(lien.dataset.confirm)) {
            event.preventDefault();
        }
    }
});
