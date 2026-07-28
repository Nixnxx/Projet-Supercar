<?php
// ============================================================
//  vues/evenement_vue.php  —  VUE : page des événements
//  Contenu statique (démonstration).
// ============================================================
require __DIR__ . '/layout/header.php';
?>

<section id="evenements" class="events-page">
    <div class="events-hero">
        <span class="events-label">SuperCar Experience</span>
        <h1>Nos <span>Événements</span></h1>
        <p>Retrouvez nos journées portes ouvertes, essais exclusifs et rencontres passion auto dans toute la région.</p>
    </div>

    <div class="events-grid">
        <article class="event-card">
            <div class="event-date">
                <strong>12</strong>
                <span>Juin 2026</span>
            </div>
            <div class="event-content">
                <h2>Journée Portes Ouvertes Premium</h2>
                <p>Visitez notre showroom, échangez avec nos experts et découvrez nos dernières arrivées en stock.</p>
                <ul>
                    <li><i class="bi bi-geo-alt"></i> Antananarivo Centre</li>
                    <li><i class="bi bi-clock"></i> 09h00 - 17h00</li>
                </ul>
            </div>
        </article>

        <article class="event-card">
            <div class="event-date">
                <strong>26</strong>
                <span>Juin 2026</span>
            </div>
            <div class="event-content">
                <h2>Soirée Lancement Collection Sport</h2>
                <p>Une soirée privée pour découvrir les modèles sportifs de la saison avec présentation personnalisée.</p>
                <ul>
                    <li><i class="bi bi-geo-alt"></i> SuperCar Lounge</li>
                    <li><i class="bi bi-clock"></i> 18h30 - 22h00</li>
                </ul>
            </div>
        </article>

        <article class="event-card">
            <div class="event-date">
                <strong>10</strong>
                <span>Juillet 2026</span>
            </div>
            <div class="event-content">
                <h2>Week-end Essais Privés</h2>
                <p>Réservez un créneau et testez vos modèles préférés avec accompagnement de nos conseillers.</p>
                <ul>
                    <li><i class="bi bi-geo-alt"></i> Circuit partenaire</li>
                    <li><i class="bi bi-clock"></i> 10h00 - 16h00</li>
                </ul>
            </div>
        </article>
    </div>
</section>

<?php require __DIR__ . '/layout/footer.php'; ?>
