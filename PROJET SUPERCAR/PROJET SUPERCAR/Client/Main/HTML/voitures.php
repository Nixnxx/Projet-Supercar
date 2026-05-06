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
                if(stripos($carburant, 'lectrique') !== false)       echo '⚡';
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
                onclick="window.location.href='essai.php?voiture=<?php echo $row['id_voiture']; ?>'">
                Demande d'essai
            </button>

        </div>
    </div>
</div>

<?php } ?>

</div>
</section>


<style>
.slider {
    position: relative;
    overflow: hidden;
    width: 100%;
    height: 100%;
}

.slider .slide {
    display: none;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.slider .slide.active {
    display: block;
}

.slide-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0,0,0,0.5);
    color: white;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    font-size: 16px;
    border-radius: 4px;
    z-index: 10;
}

.slide-btn.prev { left: 8px; }
.slide-btn.next { right: 8px; }

.slide-dots {
    position: absolute;
    bottom: 8px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 6px;
}

.dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(255,255,255,0.5);
    cursor: pointer;
}

.dot.active {
    background: white;
}

.car-infos {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin: 10px 0;
}

.car-info-item {
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 20px;
    padding: 4px 10px;
    font-size: 13px;
    color: #ccc;
}
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