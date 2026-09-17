// ============================================================
//  js/admin/contact.js — Messages de contact (vues/admin/contact_vue.php)
//  Contient : la carte Leaflet (position du garage, onglet Configuration),
//  la confirmation avant suppression et la fermeture des fenêtres (modales).
// ============================================================

// --- Carte Leaflet (affichée uniquement sur l'onglet Configuration) ---
document.addEventListener('DOMContentLoaded', function() {
    const divCarte = document.getElementById('map');
    if (divCarte) {
        // Latitude/longitude préparées par le contrôleur (attributs data-lat/data-lng)
        const lat = parseFloat(divCarte.dataset.lat);
        const lng = parseFloat(divCarte.dataset.lng);

        var map = L.map('map').setView([lat, lng], 13);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            referrerPolicy: 'no-referrer-when-downgrade',
            maxZoom: 19
        }).addTo(map);
        var marker = L.marker([lat, lng], {draggable: true}).addTo(map);

        marker.on('dragend', function(e) {
            var pos = marker.getLatLng();
            document.getElementById('lat').value = pos.lat.toFixed(6);
            document.getElementById('lng').value = pos.lng.toFixed(6);
        });
    }
});

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