

<body>

  <?php
  include 'header.php';
  ?>




<div id="carouselExampleSlidesOnly" class="carousel slide"
     data-bs-ride="carousel"
     data-bs-interval="3500"
     data-bs-pause="false">

  <div class="carousel-inner">

    <!-- Aston Martin -->
    <div class="carousel-item active">
      <img src="Images-Index/accueil/am6.jpg" class="d-block w-100" alt="Aston Martin">
      <div class="carousel-caption d-none d-md-block text-start">
        <h5>Aston Martin</h5>
        <p>
          Le luxe britannique au service de la performance.<br>
          Raffinement, puissance et élégance intemporelle.
        </p>
        <a href="essai.html" class="btn btn-outline-light">Demander un essai</a>
      </div>
    </div>

    <!-- McLaren -->
    <div class="carousel-item">
      <img src="Images-Index/accueil/mc2.webp" class="d-block w-100" alt="McLaren">
      <div class="carousel-caption d-none d-md-block text-start">
        <h5>McLaren</h5>
        <p>
          Une supercar d’exception, née pour la vitesse.<br>
          Sensations fortes garanties.
        </p>
        <a href="essai.html" class="btn btn-outline-light">Demander un essai</a>
      </div>
    </div>

    <!-- Porsche -->
    <div class="carousel-item">
      <img src="Images-Index/accueil/pr1.webp" class="d-block w-100" alt="Porsche">
      <div class="carousel-caption d-none d-md-block text-start">
        <h5>Porsche</h5>
        <p>
          L’alliance parfaite entre sport et élégance.<br>
          Une conduite précise et dynamique.
        </p>
        <a href="essai.html" class="btn btn-outline-light">Demander un essai</a>
      </div>
    </div>

  </div>
</div>






   <!-- ACCUEIL - Hero amélioré -->
<section id="accueil" class="py-5 bg-dark text-white">
    <div class="container">
        <div class="row align-items-center">
            <!-- Texte à gauche + images à droite (ou stack sur mobile) -->
            <div class="col-lg-6 mb-5 mb-lg-0">
                <h2 class="display-4 fw-bold mb-4" style="background: linear-gradient(135deg, var(--primary-orange), #ff8c00); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    Bienvenue chez SuperCar
                </h2>
                <p class="lead fs-4 mb-4">
                    Votre porte d'entrée vers l'excellence automobile à Maurice.
                </p>
                <p class="fs-5 mb-4">
                    SuperCar importe et propose une sélection exclusive de voitures d'occasion haut de gamme, contrôlées et certifiées, venues du Japon, Singapour, Afrique du Sud, États-Unis, Chine, Allemagne, France et plus encore.
                </p>

                <!-- Points forts en liste icônée -->
                <ul class="list-unstyled fs-5 mb-5">
                    <li class="mb-3"><i class="bi bi-check-circle-fill text-warning me-3"></i>Modèles immédiatement disponibles – Pas d'attente</li>
                    <li class="mb-3"><i class="bi bi-check-circle-fill text-warning me-3"></i>Inspection complète + préparation professionnelle</li>
                    <li class="mb-3"><i class="bi bi-check-circle-fill text-warning me-3"></i>Essai routier gratuit sur rendez-vous</li>
                    <li class="mb-3"><i class="bi bi-check-circle-fill text-warning me-3"></i>Livraison directe à domicile ou bureau</li>
                </ul>

                <!-- CTA principal -->
                <a href="essai.html" class="btn btn-warning btn-lg px-5 py-3 fw-bold rounded-pill shadow-lg">
                    Réserver mon essai exclusif maintenant →
                </a>
            </div>

            <!-- Images / Galerie à droite -->
            <div class="col-lg-6">
                <div class="row g-4">
                    <div class="col-6">
                        <!-- Image showroom luxe -->
                        <img src="Images-Index/amc.jpg" 
                             class="img-fluid rounded shadow-lg" alt="Showroom SuperCar luxe" style="height: 280px; object-fit: cover;">
                    </div>
                    <div class="col-6">
                        <!-- Image lineup supercars -->
                        <img src="Images-Index/pr2.jpg" 
                             class="img-fluid rounded shadow-lg" alt="Supercars alignées" style="height: 280px; object-fit: cover;">
                    </div>
                    <div class="col-12">
                        <!-- Image essai sur route (scenic) -->
                        <img src="Images-Index/mc1.jpg"  
                             class="img-fluid rounded shadow-lg" alt="Essai supercar sur route" style="height: 300px; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Petit bloc confiance en bas -->
        <div class="text-center mt-5 pt-4 border-top border-secondary">
            <p class="fs-5 mb-3">Pourquoi choisir SuperCar ?</p>
            <div class="d-flex justify-content-center gap-5 flex-wrap">
                <div>
                    <h5 class="text-warning">+120</h5>
                    <p>Véhicules vendus</p>
                </div>
                <div>
                    <h5 class="text-warning">98%</h5>
                    <p>Satisfaction client</p>
                </div>
                <div>
                    <h5 class="text-warning">Île entière</h5>
                    <p>Livraison gratuite</p>
                </div>
            </div>
        </div>
    </div>
</section>

 




<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
