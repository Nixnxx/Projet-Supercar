// ============================================================
//  js/layout.js — Animation d'apparition de la page
//  Commun à TOUTES les pages du site client (appelé depuis
//  vues/layout/footer.php, inclus à la fin de chaque page).
// ============================================================
document.addEventListener("DOMContentLoaded", function() {
    // 1. Rend le corps de la page visible
    document.body.classList.add("loaded");

    // 2. Sélectionne les sections principales et conteneurs pour l'animation
    const animElements = document.querySelectorAll("section, .container, form");

    animElements.forEach((el, index) => {
        // Applique l'état initial masqué et décalé vers le bas
        el.style.opacity = "0";
        el.style.transform = "translateY(20px)";
        el.style.transition = "opacity 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94), transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94)";
        el.style.transitionDelay = (index * 0.08) + "s"; // Effet cascade (stagger)

        // Déclenche l'animation avec un léger différé
        setTimeout(() => {
            el.style.opacity = "1";
            el.style.transform = "translateY(0)";
        }, 50);
    });
});
