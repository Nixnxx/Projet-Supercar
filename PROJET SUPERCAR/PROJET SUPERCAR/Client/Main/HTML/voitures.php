
<body>
      <?php
  include 'header.php';
  ?>

  <section id="voitures">
    <div class="container">
        <h2>Nos voitures d'occasion disponibles</h2>
        <p>Recherchez par marque, modèle ou type (Sport, Premium, Piste…).</p>
 
        <!--  BARRE DE RECHERCHE -->
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder=" Rechercher une voiture...">
        </div>
    </div>
 
    <!--  GRID  -->
    <div class="cars-grid" id="carsGrid">
 
        <div class="brand-separator">
    <p>— Porsche —</p>
</div>
 
        <!-- PORSCHE -->
        <div class="car-card">
            <div class="car-image-wrapper">
                <img src="Images-Index/Porsche911GT2.jpg" alt="Porsche 911 GT2 RS">
                <div class="car-badge">Premium</div>
            </div>
            <div class="car-content">
                <h3>Porsche 911 GT2 RS</h3>
                <p class="car-description">Moteur 3.8L biturbo de 700 ch, performance extrême.</p>
                <div class="car-footer">
                    <span class="car-price">12,500,000 Rs</span>
                    <button class="btn-commander">Demande d'essai</button>
                </div>
            </div>
        </div>
 
        <div class="car-card">
            <div class="car-image-wrapper">
                <img src="Images-Index/Porsche911GT3.jpg" alt="Porsche 911 GT3 RS">
                <div class="car-badge">Sport</div>
            </div>
            <div class="car-content">
                <h3>Porsche 911 GT3 RS</h3>
                <p class="car-description">Moteur 4.0L de 520 ch, aérodynamique active.</p>
                <div class="car-footer">
                    <span class="car-price">8,900,000 Rs</span>
                    <button class="btn-commander">Demande d'essai</button>
                </div>
            </div>
        </div>
 
        <div class="car-card">
            <div class="car-image-wrapper">
                <img src="Images-Index/Porsche911Trubo1978.jpg" alt="Porsche 911 Turbo 1978">
                <div class="car-badge">Classic</div>
            </div>
            <div class="car-content">
                <h3>Porsche 911 Turbo 1978</h3>
                <p class="car-description">Icône intemporelle restaurée, pièce de collection.</p>
                <div class="car-footer">
                    <span class="car-price">6,200,000 Rs</span>
                    <button class="btn-commander">Demande d'essai</button>
                </div>
            </div>
        </div>
 
        <div class="car-card">
            <div class="car-image-wrapper">
                <img src="Images-Index/PorscheMaisto911GT2.jpg" alt="Porsche 911 GT2">
                <div class="car-badge">Sport</div>
            </div>
            <div class="car-content">
                <h3>Porsche 911 GT2</h3>
                <p class="car-description">Flat-six biturbo ultra-performant.</p>
                <div class="car-footer">
                    <span class="car-price">9,900,000 Rs</span>
                    <button class="btn-commander">Demande d'essai</button>
                </div>
            </div>
        </div>
 
        <div class="car-card">
            <div class="car-image-wrapper">
                <img src="Images-Index/Porsche918Spyde.jpg" alt="Porsche 918 Spyder">
                <div class="car-badge">Hybride</div>
            </div>
            <div class="car-content">
                <h3>Porsche 918 Spyder</h3>
                <p class="car-description">Supercar hybride V8 + électrique.</p>
                <div class="car-footer">
                    <span class="car-price">8,900,000 Rs</span>
                    <button class="btn-commander">Demande d'essai</button>
                </div>
            </div>
        </div>
 
        <div class="brand-separator">
    <p>— McLaren —</p>
</div>
 
        <!-- McLAREN -->
        <div class="car-card">
            <div class="car-image-wrapper">
                <img src="Images-Index/sabre.png" alt="McLaren Sabre">
                <div class="car-badge">Hybride</div>
            </div>
            <div class="car-content">
                <h3>McLaren Sabre</h3>
                <p class="car-description">Hypercar ultra-exclusive (~15 exemplaires).</p>
                <div class="car-footer">
                    <span class="car-price">160,000,000 Rs</span>
                    <button class="btn-commander">Demande d'essai</button>
                </div>
            </div>
        </div>
 
        <div class="car-card">
            <div class="car-image-wrapper">
                <img src="Images-Index/artura.png" alt="McLaren Artura">
                <div class="car-badge">Hybride</div>
            </div>
            <div class="car-content">
                <h3>McLaren Artura</h3>
                <p class="car-description">Coupé hybride V6 dernière génération.</p>
                <div class="car-footer">
                    <span class="car-price">7,000,000 Rs</span>
                    <button class="btn-commander">Demande d'essai</button>
                </div>
            </div>
        </div>
 
        <div class="car-card">
            <div class="car-image-wrapper">
                <img src="Images-Index/McLaren 650S GT3.jpg" alt="McLaren 650S GT3">
                <div class="car-badge">Piste</div>
            </div>
            <div class="car-content">
                <h3>McLaren 650S GT3</h3>
                <p class="car-description">Version racing axée performance.</p>
                <div class="car-footer">
                    <span class="car-price">14,000,000 Rs</span>
                    <button class="btn-commander">Demande d'essai</button>
                </div>
            </div>
        </div>
 
        <div class="car-card">
            <div class="car-image-wrapper">
                <img src="Images-Index/senna.png" alt="McLaren Senna">
                <div class="car-badge">Piste</div>
            </div>
            <div class="car-content">
                <h3>McLaren Senna</h3>
                <p class="car-description">Machine de piste homologuée route.</p>
                <div class="car-footer">
                    <span class="car-price">70,000,000 Rs</span>
                    <button class="btn-commander">Demande d'essai</button>
                </div>
            </div>
        </div>
 
        <div class="car-card">
            <div class="car-image-wrapper">
                <img src="Images-Index/p1.png" alt="McLaren P1">
                <div class="car-badge">Premium</div>
            </div>
            <div class="car-content">
                <h3>McLaren P1</h3>
                <p class="car-description">Hypercar de légende V8 + électrique.</p>
                <div class="car-footer">
                    <span class="car-price">80,000,000 Rs</span>
                    <button class="btn-commander">Demande d'essai</button>
                </div>
            </div>
        </div>
 
        <div class="brand-separator">
    <p>— Aston Martin —</p>
</div>
 
        <!-- ASTON MARTIN -->
        <div class="car-card">
            <div class="car-image-wrapper">
                <img src="Images-Index/dbx707.png" alt="DBX 707">
                <div class="car-badge">Premium</div>
            </div>
            <div class="car-content">
                <h3>Aston Martin DBX 707</h3>
                <p class="car-description">SUV de luxe de 707 ch.</p>
                <div class="car-footer">
                    <span class="car-price">20,000,000 Rs</span>
                    <button class="btn-commander">Demande d'essai</button>
                </div>
            </div>
        </div>
 
        <div class="car-card">
            <div class="car-image-wrapper">
                <img src="Images-Index/valour.png" alt="Aston Martin Valour">
                <div class="car-badge">Sport</div>
            </div>
            <div class="car-content">
                <h3>Aston Martin Vanquish</h3>
                <p class="car-description">V12 atmosphérique légendaire.</p>
                <div class="car-footer">
                    <span class="car-price">,000,000 Rs</span>
                    <button class="btn-commander">Demande d'essai</button>
                </div>
            </div>
        </div>
 
        <div class="car-card">
            <div class="car-image-wrapper">
                <img src="Images-Index/vanquish.png" alt="Vanquish">
                <div class="car-badge">Sport</div>
            </div>
            <div class="car-content">
                <h3>Aston Martin Valour</h3>
                <p class="car-description">V12 biturbo + boîte manuelle.</p>
                <div class="car-footer">
                    <span class="car-price">100,000,000 Rs</span>
                    <button class="btn-commander">Demande d'essai</button>
                </div>
            </div>
        </div>
 
        <div class="car-card">
            <div class="car-image-wrapper">
                <img src="Images-Index/valhalla.png" alt="Valhalla">
                <div class="car-badge">Piste</div>
            </div>
            <div class="car-content">
                <h3>Aston Martin Valhalla</h3>
                <p class="car-description">1 012 ch hybrides, performance ultime.</p>
                <div class="car-footer">
                    <span class="car-price">120,000,000 Rs</span>
                    <button class="btn-commander">Demande d'essai</button>
                </div>
            </div>
        </div>
 
        <div class="car-card">
            <div class="car-image-wrapper">
                <img src="Images-Index/vantage.png" alt="Vantage">
                <div class="car-badge">Sport</div>
            </div>
            <div class="car-content">
                <h3>Aston Martin Vantage</h3>
                <p class="car-description">V8 biturbo de 665 ch.</p>
                <div class="car-footer">
                    <span class="car-price">24,000,000 Rs</span>
                    <button class="btn-commander">Demande d'essai</button>
                </div>
            </div>
        </div>
 
    </div>
</section>

        
       <?php
  include 'footer.php';
  ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<!-- JS RECHERCHE -->
<script>
    const searchInput = document.getElementById("searchInput");
    const cars = document.querySelectorAll(".car-card");
    const separators = document.querySelectorAll(".brand-separator");
 
    searchInput.addEventListener("keyup", () => {
        const value = searchInput.value.toLowerCase();
 
        // Filtrer les voitures
        cars.forEach(car => {
            const text = car.innerText.toLowerCase();
            car.style.display = text.includes(value) ? "block" : "none";
        });
 
        // Gérer l'affichage des séparateurs
        separators.forEach(separator => {
            let next = separator.nextElementSibling;
            let showSeparator = false;
 
            // Vérifie s'il y a au moins une voiture visible après ce séparateur
            while (next && !next.classList.contains("brand-separator")) {
                if (next.classList.contains("car-card") && next.style.display !== "none") {
                    showSeparator = true;
                }
                next = next.nextElementSibling;
            }
 
            separator.style.display = showSeparator ? "block" : "none";
        });
    });
</script>
 
</body>
</html>