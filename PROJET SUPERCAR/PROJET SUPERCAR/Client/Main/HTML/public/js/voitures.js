// ============================================================
//  js/voitures.js — Catalogue des voitures (vues/voitures_vue.php)
//  Contient : les sliders de photos, le clic sur "Demande d'essai"
//  et la barre de recherche.
// ============================================================

// --- Sliders de photos (un par voiture) ---
const sliderIndex = {};

function changeSlide(id, direction) {
    const slider = document.getElementById('slider-' + id);
    const slides = slider.querySelectorAll('.slide');
    const dots   = slider.querySelectorAll('.dot');

    if (sliderIndex[id] === undefined) sliderIndex[id] = 0;

    slides[sliderIndex[id]].classList.remove('active');
    dots[sliderIndex[id]].classList.remove('active');

    sliderIndex[id] = (sliderIndex[id] + direction + slides.length) % slides.length;

    slides[sliderIndex[id]].classList.add('active');
    dots[sliderIndex[id]].classList.add('active');
}

function goToSlide(id, index) {
    const slider = document.getElementById('slider-' + id);
    const slides = slider.querySelectorAll('.slide');
    const dots   = slider.querySelectorAll('.dot');

    if (sliderIndex[id] === undefined) sliderIndex[id] = 0;

    slides[sliderIndex[id]].classList.remove('active');
    dots[sliderIndex[id]].classList.remove('active');

    sliderIndex[id] = index;

    slides[sliderIndex[id]].classList.add('active');
    dots[sliderIndex[id]].classList.add('active');
}

// --- Clics sur les boutons du slider (prev / next / dot) et sur "Demande d'essai" ---
// Un seul écouteur sur toute la page (délégation d'événements) car chaque
// voiture a son propre slider et son propre bouton, générés en boucle par le PHP.
document.addEventListener('click', function(event) {

    // Bouton "Demande d'essai" : le lien a été préparé par le contrôleur
    // et rangé dans l'attribut data-href (voir voitures_vue.php).
    const boutonEssai = event.target.closest('[data-href]');
    if (boutonEssai) {
        window.location.href = boutonEssai.dataset.href;
        return;
    }

    // Boutons prev / next / dot du slider
    const boutonSlide = event.target.closest('[data-slide-action]');
    if (boutonSlide) {
        const id = boutonSlide.dataset.slideId;
        const action = boutonSlide.dataset.slideAction;

        if (action === 'prev') changeSlide(id, -1);
        else if (action === 'next') changeSlide(id, 1);
        else if (action === 'dot') goToSlide(id, parseInt(boutonSlide.dataset.slideIndex));
    }
});

// --- Barre de recherche (filtre les cartes en direct) ---
const searchInput = document.getElementById("searchInput");
const cars = document.querySelectorAll(".car-card");
const separators = document.querySelectorAll(".brand-separator");

searchInput.addEventListener("keyup", () => {
    const value = searchInput.value.toLowerCase();

    cars.forEach(car => {
        const text = car.innerText.toLowerCase();
        car.style.display = text.includes(value) ? "" : "none";
    });

    separators.forEach(separator => {
        let next = separator.nextElementSibling;
        let show = false;

        while (next && !next.classList.contains("brand-separator")) {
            if (next.classList.contains("car-card") && next.style.display !== "none") {
                show = true;
            }
            next = next.nextElementSibling;
        }

        separator.style.display = show ? "" : "none";
    });
});
