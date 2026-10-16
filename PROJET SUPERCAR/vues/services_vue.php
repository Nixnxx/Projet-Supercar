<?php
// ============================================================
//  vues/services_vue.php  —  VUE : liste des services
//  Reçoit : $services (liste).
// ============================================================
require __DIR__ . '/layout/header.php';
?>

<section id="services">

    <div class="services-hero">
        <span class="hero-label">Ce que nous offrons</span>
        <h1 class="hero-title">Nos <span class="highlight">Services</span></h1>
        <p class="hero-sub">De la vérification à la livraison — une expertise complète au service de votre supercar.</p>
    </div>

    <div class="services-wrapper">

    <?php foreach ($services as $service) : ?>
        <div class="service-card">
            <div class="card-icon">
                <i class="bi <?= e($service['icone']) ?>"></i>
            </div>
            <div class="card-number"><?= str_pad($service['numero'], 2, '0', STR_PAD_LEFT) ?></div>
            <h3 class="card-title"><?= e($service['nom']) ?></h3>
            <?php if (!empty($service['image'])) : ?>
            <div class="card-image-wrap">
                <img src="<?= e($service['image']) ?>" alt="<?= e($service['nom']) ?>">
            </div>
            <?php endif; ?>
            <p class="card-desc"><?= e($service['description']) ?></p>
            <?php if (!empty($service['tag'])) : ?>
            <span class="card-tag"><?= e($service['tag']) ?></span>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    </div>

</section>

<?php require __DIR__ . '/layout/footer.php'; ?>
