// ============================================================
//  js/admin/accueil.js — Formulaire d'un élément d'accueil
//  (vues/admin/accueil_form_vue.php)
//  Affiche un aperçu de l'image choisie avant l'envoi du formulaire.
// ============================================================

function afficherApercu(input) {
    var img = document.getElementById('apercu');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            img.classList.remove('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// --- Branchement du champ d'upload (remplace onchange="afficherApercu(this)") ---
// Selon le type d'élément modifié (carousel ou hero_image), un seul de ces
// champs existe à la fois sur la page : on branche donc tous ceux qui portent
// la classe .input-image-apercu, sans avoir besoin de savoir lequel.
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.input-image-apercu').forEach(function(input) {
        input.addEventListener('change', function() {
            afficherApercu(this);
        });
    });
});
