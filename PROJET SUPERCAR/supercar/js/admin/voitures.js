// ============================================================
//  js/admin/voitures.js — Gestion des voitures (vues/admin/voitures_vue.php)
//  Contient : aperçus des photos avant envoi, confirmation avant
//  suppression, fermeture des fenêtres (modales) en cliquant à côté.
// ============================================================

// --- Aperçu multiple (fenêtre "Ajouter") ---
function previewMultiple(input) {
    const container = document.getElementById('previewsContainer');
    container.innerHTML = '';
    if (input.files) {
        Array.from(input.files).forEach((file, i) => {
            const reader = new FileReader();
            reader.onload = e => {
                const wrapper = document.createElement('div');
                wrapper.style.cssText = 'position:relative;display:inline-block;';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.cssText = 'width:80px;height:55px;object-fit:cover;border-radius:6px;border:1px solid var(--border);';

                if (i === 0) {
                    const badge = document.createElement('div');
                    badge.textContent = '★ Principal';
                    badge.style.cssText = 'position:absolute;bottom:0;left:0;right:0;background:rgba(255,107,0,0.85);color:white;font-size:9px;text-align:center;border-radius:0 0 6px 6px;padding:2px 0;';
                    wrapper.appendChild(badge);
                }

                wrapper.appendChild(img);
                container.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });
    }
}

// --- Aperçu (fenêtre "Modifier" : ajout d'une photo) ---
function previewNouvellePhoto(input) {
    const img = document.getElementById('previewNouvellePhoto');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// --- Branchement des champs d'upload (remplace les onchange="...") ---
document.addEventListener('DOMContentLoaded', function() {
    const inputMultiple = document.getElementById('inputPhotosMultiple');
    if (inputMultiple) {
        inputMultiple.addEventListener('change', function() {
            previewMultiple(this);
        });
    }

    const inputNouvellePhoto = document.getElementById('inputNouvellePhoto');
    if (inputNouvellePhoto) {
        inputNouvellePhoto.addEventListener('change', function() {
            previewNouvellePhoto(this);
        });
    }
});

// --- Confirmation avant suppression (remplace les onclick="return confirm(...)") ---
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
