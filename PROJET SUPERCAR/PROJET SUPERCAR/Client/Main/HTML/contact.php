
<body>
      <?php
  include 'header.php';
  ?>

     

<section id="contact">
    <div class="container">
        <h2>Contactez-nous</h2>
        <p>Une question ? Une voiture vous intéresse ? Contactez-nous via le formulaire ou rendez-nous visite.</p>

        <div class="contact-container">

            <!-- MINI MAP -->
            <div class="mini-map-wrapper">
                <div class="map-header">
                    <h3>📍 Notre Concession</h3>
                    <p>MCCI – Ebène, Maurice</p>
                </div>

                <div class="mini-map">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14945.63749751723!2d57.4809!3d-20.2447!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x217c5ad7d9b3d19f%3A0x9c5e0e4b5fbc3e2f!2sMauritius%20Chamber%20of%20Commerce%20and%20Industry!5e0!3m2!1sfr!2smu!4v0000000000"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <a href="https://maps.google.com/?q=Mauritius+Chamber+of+Commerce+and+Industry+Ebene"
                   target="_blank"
                   class="map-link">
                   Voir sur Google Maps
                </a>
            </div>

            <!-- FORMULAIRE -->
            <form method="POST" action="contactclient.php">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" required>

                <label for="numéro">Numéro de téléphone</label>
                <input type="text" id="numéro" name="numéro" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message</label>
                <textarea id="message" name="message" required></textarea>

                <button type="submit">Envoyer</button>
            </form>

        </div>
    </div>
</section>

        <?php
  include 'footer.php';
  ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>