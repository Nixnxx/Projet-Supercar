<?php
// ============================================================
//  vues/layout/footer.php  —  VUE : pied de page commun
//  Affiche le pied de page puis ferme le document HTML.
//  Les mentions légales et la politique de confidentialité ne sont
//  PLUS des fenêtres (modales) : ce sont désormais des pages à part
//  entière (mentions.php et politique.php), exactement les mêmes pages
//  que celles ouvertes depuis les formulaires de connexion/inscription.
//  Ce footer contient aussi le bouton flottant WhatsApp : il apparaît
//  donc sur toutes les pages qui l'incluent (= tout le site client).
//  (Inclus à la fin de chaque vue de page client.)
// ============================================================

// Numéro WhatsApp : défini une seule fois dans config/config.php
// (constante WHATSAPP_NUMERO), pour ne pas le réécrire à plusieurs endroits.
$whatsapp_numero = WHATSAPP_NUMERO;
?>
<footer class="position-relative text-white" style="min-height: 100px;" >

  <div class="container position-relative z-index-1 py-5">

    <div class="container">

        <div class="row justify-content-center text-center g-4 mb-4">

            <div class="col-md-3">
                <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">Contactez-nous</h6>
                <p class="mb-2"><i class="bi bi-whatsapp me-2 text-success"></i> +230 57 45 61 70 </p>
                <p class="mb-2"><i class="bi bi-envelope-fill me-2"></i> contact@supercar.mu</p>
                <p class="mb-0"><i class="bi bi-geo-alt-fill me-2"></i> Ebene / Cybercity, Maurice</p>
              </div>

            <div class="col-md-3 footer-social">
                <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">Suivez-nous</h6>
                <a href="#"><i class="bi bi-facebook mx-2 fs-4"></i></a>
                <a href="#"><i class="bi bi-instagram mx-2 fs-4"></i></a>
                <a href="https://wa.me/<?= $whatsapp_numero ?>" target="_blank" rel="noopener"><i class="bi bi-whatsapp mx-2 fs-4"></i></a>
            </div>

            <div class="col-md-3">
                <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">Liens utiles</h6>
                <p class="mb-2"><a href="index.php">Accueil</a></p>
                <p class="mb-2"><a href="voitures.php">Nos voitures</a></p>
                <p class="mb-2"><a href="essai.php">Demande d'essai</a></p>
                <p class="mb-2"><a href="contact.php">Contact</a></p>
            </div>

            <div class="col-md-3">
                <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">Nos politiques</h6>
                <!-- Liens vers les PAGES dédiées (mêmes pages que celles ouvertes
                     depuis la case à cocher des formulaires connexion/inscription). -->
                <p class="mb-2"><a href="mentions.php">Mentions légales</a></p>
                <p class="mb-2"><a href="politique.php">Politique de confidentialité</a></p>
            </div>

        </div>

        <div class="footer-bottom mt-3 text-center">
            <p class="mb-2 small">
                &copy;  SuperCar
                <br>
               • Livraison à domicile île entière • Véhicules certifiés
            </p>
            <p class="mb-0 small opacity-75">
                Projet d'étude BTS SIO – Etudiants | Nix - Julien - Ilaina
            </p>
        </div>

    </div>
  </div>

</footer>


<!-- ============================================================
     Bouton flottant WhatsApp (rond vert, fixé en bas à droite).
     Présent sur toutes les pages du site client, car elles incluent
     ce footer. Il est donc ABSENT des pages connexion / inscription
     (qui n'utilisent pas ce layout) et de l'espace admin (autre layout).
     Son apparence est définie dans css/footer.css (.whatsapp-flottant).
============================================================ -->
<a href="https://wa.me/<?= $whatsapp_numero ?>"
   class="whatsapp-flottant"
   target="_blank"
   rel="noopener"
   aria-label="Nous contacter sur WhatsApp"
   title="Contactez-nous sur WhatsApp">
   <i class="bi bi-whatsapp"></i>
</a>

<!-- Script Bootstrap (menus déroulants) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Animation d'ouverture de page (Niveau BTS SIO) -->
<script src="js/layout.js"></script>
</body>
</html>
