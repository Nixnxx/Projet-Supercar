<?php
session_start();
require('lienbd.php');
require('fonction.php');

include 'header.php';

$sql = "SELECT v.*, m.nom as marque 
        FROM voiture v 
        JOIN marque m ON v.id_marque = m.id_marque
        ORDER BY m.nom";

$result = mysqli_query($lienbd, $sql);

// -------------------------------------------------------
// Récupérer toutes les images par voiture
// -------------------------------------------------------
$sqlImages = "SELECT * FROM voiture_images ORDER BY id_voiture, ordre";
$resImages = mysqli_query($lienbd, $sqlImages);

$imagesParVoiture = [];
while ($img = mysqli_fetch_assoc($resImages)) {
    $imagesParVoiture[$img['id_voiture']][] = $img['image'];
}
// -------------------------------------------------------

$currentMarque = "";
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

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<?php if($currentMarque != $row['marque']){ 
$currentMarque = $row['marque']; ?>
<div class="brand-separator">
<p>— <?php echo $currentMarque; ?> —</p>
</div>
<?php } ?>

<?php
$id = $row['id_voiture'];
$photos = isset($imagesParVoiture[$id]) ? $imagesParVoiture[$id] : [$row['image']];
?>

<div class="car-card">
    <div class="car-image-wrapper">

        <?php if(count($photos) <= 1): ?>
            <img src="<?php echo $photos[0]; ?>">

        <?php else: ?>
            <div class="slider" id="slider-<?php echo $id; ?>">

                <?php foreach($photos as $i => $photo): ?>
                <img src="<?php echo $photo; ?>"
                     class="slide <?php echo $i === 0 ? 'active' : ''; ?>">
                <?php endforeach; ?>

                <button class="slide-btn prev"
                        onclick="changeSlide('<?php echo $id; ?>', -1)">&#10094;</button>

                <button class="slide-btn next"
                        onclick="changeSlide('<?php echo $id; ?>', 1)">&#10095;</button>

                <div class="slide-dots">
                    <?php foreach($photos as $i => $photo): ?>
                    <span class="dot <?php echo $i === 0 ? 'active' : ''; ?>"
                          onclick="goToSlide('<?php echo $id; ?>', <?php echo $i; ?>)"></span>
                    <?php endforeach; ?>
                </div>

            </div>
        <?php endif; ?>

        <div class="car-badge">Premium</div>
    </div>

    <div class="car-content">
        <h3><?php echo $row['model']; ?></h3>
        <p class="car-description"><?php echo $row['specs']; ?></p>

        <div class="car-infos">

            <?php if(!empty($row['km'])): ?>
            <span class="car-info-item">
                🛣️ <?php echo number_format($row['km'], 0, ',', ' '); ?> km
            </span>
            <?php endif; ?>

            <?php if(!empty($row['type_carburant'])): ?>
            <span class="car-info-item">
                <?php
                $carburant = trim($row['type_carburant']);
                if(stripos($carburant, 'électrique') !== false)       echo '⚡';
                elseif(stripos($carburant, 'Hybrid') !== false)      echo '🔋';
                elseif(stripos($carburant, 'Diesel') !== false)      echo '⛽';
                else                                                  echo '⛽';
                echo ' ' . $carburant;
                ?>
            </span>
            <?php endif; ?>

            <?php if(!empty($row['annee'])): ?>
            <span class="car-info-item">
                📅 <?php echo date('Y', strtotime($row['annee'])); ?>
            </span>
            <?php endif; ?>

        </div>

        <div class="car-footer">
            <span class="car-price">
                <?php echo number_format($row['prix'],0,',',' '); ?> Rs
            </span>

           <button class="btn-commander"
    onclick="window.location.href='<?php echo est_connecte() ? 'essai.php?voiture='.$row['id_voiture'] : 'nonconnecte.php?redirect=essai&id_voiture='.$row['id_voiture']; ?>'">
    Demande d'essai
</button>

        </div>
    </div>
</div>

<?php } ?>

</div>
</section>


<style>

</style>


<script>
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

const searchInput = document.getElementById("searchInput");
const cars = document.querySelectorAll(".car-card");
const separators = document.querySelectorAll(".brand-separator");

searchInput.addEventListener("keyup", () => {
    const value = searchInput.value.toLowerCase();

    cars.forEach(car => {
        const text = car.innerText.toLowerCase();
        if (text.includes(value)) {
            car.style.display = "";
        } else {
            car.style.display = "none";
        }
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
</script>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>