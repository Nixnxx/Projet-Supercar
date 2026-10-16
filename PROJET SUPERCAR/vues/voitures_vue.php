<?php
// ============================================================
//  vues/voitures_vue.php  —  VUE : catalogue des voitures
//  Reçoit : $voitures (liste) et $imagesParVoiture (photos par id).
//  CORRECTION XSS (HIGH-02) : model, specs, marque et chemins d'images
//  sont désormais échappés avec e().
// ============================================================
require __DIR__ . '/layout/header.php';
?>

<section id="voitures">
<div class="container">
    <h2>Nos voitures d'occasion disponibles</h2>
    <p>Recherchez par marque, modèle ou type</p>

    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Rechercher une voiture...">
    </div>
</div>

<div class="cars-grid" id="carsGrid">

<?php
$currentMarque = "";
foreach ($voitures as $row) :
    // Séparateur affiché à chaque changement de marque
    if ($currentMarque != $row['marque']) :
        $currentMarque = $row['marque'];
?>
<div class="brand-separator">
<p>— <?= e($currentMarque) ?> —</p>
</div>
<?php endif; ?>

<?php
    $id = $row['id_voiture'];
    // Photos du slider, ou l'image principale s'il n'y en a pas
    $photos = isset($imagesParVoiture[$id]) ? $imagesParVoiture[$id] : [$row['image']];
    // La voiture est-elle réservée (essai confirmé) ? → bouton grisé
    // (colonne voiture.disponible, synchronisée par essai_modele.php)
    $estIndisponible = ((int) $row['disponible'] === 0);
?>

<div class="car-card">
    <div class="car-image-wrapper">

        <?php if (count($photos) <= 1) : ?>
            <img src="<?= e($photos[0]) ?>">

        <?php else : ?>
            <div class="slider" id="slider-<?= e($id) ?>">

                <?php foreach ($photos as $i => $photo) : ?>
                <img src="<?= e($photo) ?>"
                     class="slide <?= $i === 0 ? 'active' : '' ?>">
                <?php endforeach; ?>

                <button class="slide-btn prev"
                        data-slide-action="prev" data-slide-id="<?= e($id) ?>">&#10094;</button>

                <button class="slide-btn next"
                        data-slide-action="next" data-slide-id="<?= e($id) ?>">&#10095;</button>

                <div class="slide-dots">
                    <?php foreach ($photos as $i => $photo) : ?>
                    <span class="dot <?= $i === 0 ? 'active' : '' ?>"
                          data-slide-action="dot" data-slide-id="<?= e($id) ?>" data-slide-index="<?= (int)$i ?>"></span>
                    <?php endforeach; ?>
                </div>

            </div>
        <?php endif; ?>

        <div class="car-badge">Premium</div>
    </div>

    <div class="car-content">
        <h3><?= e($row['model']) ?></h3>
        <p class="car-description"><?= e($row['specs']) ?></p>

        <div class="car-infos">

            <?php if (!empty($row['km'])) : ?>
            <span class="car-info-item">
                🛣️ <?= number_format($row['km'], 0, ',', ' ') ?> km
            </span>
            <?php endif; ?>

            <?php if (!empty($row['type_carburant'])) : ?>
            <span class="car-info-item">
                <?php
                $carburant = trim($row['type_carburant']);
                if (stripos($carburant, 'électrique') !== false)     echo '⚡';
                elseif (stripos($carburant, 'Hybrid') !== false)     echo '🔋';
                else                                                  echo '⛽';
                echo ' ' . e($carburant);
                ?>
            </span>
            <?php endif; ?>

            <?php if (!empty($row['annee'])) : ?>
            <span class="car-info-item">
                📅 <?= date('Y', strtotime($row['annee'])) ?>
            </span>
            <?php endif; ?>

            <?php if (!empty($row['transmission'])) : ?>
            <span class="car-info-item">
                🚗 <?= e($row['transmission']) ?>
            </span>
            <?php endif; ?>

        </div>

        <div class="car-footer">
            <span class="car-price">
                <?= number_format($row['prix'], 0, ',', ' ') ?> Rs
            </span>

           <?php if ($estIndisponible) : ?>
           <button class="btn-commander btn-indisponible" disabled>
               Indisponible
           </button>
           <?php else : ?>
           <?php
           // Lien de la demande d'essai : si le client n'est pas connecté,
           // on le redirige d'abord vers la page nonconnecte.php.
           $lien_essai = est_connecte()
               ? 'essai.php?voiture=' . (int)$row['id_voiture']
               : 'nonconnecte.php?redirect=essai&id_voiture=' . (int)$row['id_voiture'];
           ?>
           <button class="btn-commander" data-href="<?= e($lien_essai) ?>">
               Demande d'essai
           </button>
           <?php endif; ?>

        </div>
    </div>
</div>

<?php endforeach; ?>

</div>
</section>


<script src="js/voitures.js"></script>

<?php require __DIR__ . '/layout/footer.php'; ?>
