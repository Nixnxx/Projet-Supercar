
<body>
       <?php
  include 'header.php';
  ?>

    <section id="services">
    <div class="container">
        <h2>Nos Services</h2>

        <div class="accordion-item">
            <input type="checkbox" id="service1">
            <label class="accordion-header" for="service1">
                <span>Test de Diagnostic</span>
                <span class="icon">+</span>
            </label>
            <div class="accordion-content">
                <div class="diagnostic-card">
                    <div class="diag-image">
                        <img src="Images-Index/Service_Image/diagnostic-auto-opt-scaled.jpg" alt="Test de Diagnostic">
                    </div>
                    <div class="diag-text">
                        <p>Le voyant moteur clignote comme une discothèque depuis trois semaines ? On branche nos outils, on décode le mystère et on vous dit ce qui cloche vraiment.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <input type="checkbox" id="service2">
            <label class="accordion-header" for="service2">
                <span>Test de Batterie</span>
                <span class="icon">+</span>
            </label>
            <div class="accordion-content">
                <div class="diagnostic-card">
                    <div class="diag-image">
                        <img src="Images-Index/Service_Image/batterie.jpeg" alt="Test de Batterie">
                    </div>
                    <div class="diag-text">
                        <p>On teste la Batterie pour s'assurer qu'elle est en pleine forme. Si elle est faible, on vous le dit avant que votre voiture ne décide de faire une sieste au milieu de la route.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <input type="checkbox" id="service3">
            <label class="accordion-header" for="service3">
                <span>Garantie & Inspection</span>
                <span class="icon">+</span>
            </label>
            <div class="accordion-content">
                <div class="diagnostic-card">
                    <div class="diag-image">
                        <img src="Images-Index/Service_Image/medium_garantie_constructeur_b72f96b316.png">
                    </div>
                    <div class="diag-text">
                        <p>Toutes nos voitures passent par des contrôles techniques stricts. Des garanties allant jusqu'à 24 mois peuvent être ajoutées selon vos besoins.</p>
                    </div>
                </div>
            </div>
        </div>


    </div>
</section>

     <?php
  include 'footer.php';
  ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>