<?php
include 'header.php';

$conn = new mysqli("localhost", "root", "", "supercar");
if ($conn->connect_error) {
    die("Erreur connexion");
}

$sql = "SELECT v.*, m.nom as marque 
        FROM voiture v 
        JOIN marque m ON v.id_marque = m.id_marque
        ORDER BY m.nom";

$result = $conn->query($sql);

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

<?php while($row = $result->fetch_assoc()){ ?>

<?php if($currentMarque != $row['marque']){ 
$currentMarque = $row['marque']; ?>
<div class="brand-separator">
<p>— <?php echo $currentMarque; ?> —</p>
</div>
<?php } ?>

<div class="car-card">
    <div class="car-image-wrapper">
        <img src="<?php echo $row['image']; ?>">
        <div class="car-badge">Premium</div>
    </div>

    <div class="car-content">
        <h3><?php echo $row['model']; ?></h3>
        <p class="car-description"><?php echo $row['specs']; ?></p>

        <div class="car-footer">
            <span class="car-price">
                <?php echo number_format($row['prix'],0,',',' '); ?> Rs
            </span>

            <!-- bouton essai -->
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

<script>
// J'ai du changer le js pour qu'il cherche sans utiliser "voiture" mais sépare par marque et mot clé

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

    // Gestion séparateurs (marques)
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
