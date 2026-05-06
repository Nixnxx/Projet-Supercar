<?php
session_start();
require('lienbd.php');
require('fonction.php');
include 'header.php';

$services = mysqli_fetch_all(mysqli_query($lienbd, "SELECT * FROM service ORDER BY numero"), MYSQLI_ASSOC);
?>

<body>
<section id="services">

    <div class="services-hero">
        <span class="hero-label">Ce que nous offrons</span>
        <h1 class="hero-title">Nos <span class="highlight">Services</span></h1>
        <p class="hero-sub">De la vérification à la livraison — une expertise complète au service de votre supercar.</p>
    </div>

    <div class="services-wrapper">

    <?php foreach ($services as $i => $service): ?>
        <div class="service-card">
            <div class="card-icon">
                <i class="bi <?= htmlspecialchars($service['icone']) ?>"></i>
            </div>
            <div class="card-number"><?= str_pad($service['numero'], 2, '0', STR_PAD_LEFT) ?></div>
            <h3 class="card-title"><?= htmlspecialchars($service['nom']) ?></h3>
            <?php if (!empty($service['image'])): ?>
            <div class="card-image-wrap">
                <img src="<?= htmlspecialchars($service['image']) ?>" alt="<?= htmlspecialchars($service['nom']) ?>">
            </div>
            <?php endif; ?>
            <p class="card-desc"><?= htmlspecialchars($service['description']) ?></p>
            <?php if (!empty($service['tag'])): ?>
            <span class="card-tag"><?= htmlspecialchars($service['tag']) ?></span>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    </div>

</section>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>