<footer class="position-relative text-white" style="min-height: 100px;" >

  <!-- Image de fond -->
  <div class="footer-bg"></div>

  <!-- Overlay sombre -->
  <div class="footer-overlay"></div>

  <div class="container position-relative z-index-1 py-5">

    <div class="container">

        <div class="row justify-content-center text-center g-4 mb-4">
            
            <div class="col-md-3">
                <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">Contactez-nous</h6>
                
                <p class="mb-2"><i class="bi bi-telephone-fill me-2"></i> +230 5XXX XXXX</p> 
               <p class="mb-2"><i class="bi bi-whatsapp me-2 text-success"></i> +230 5XXX XXXX (WhatsApp)</p> 
                <p class="mb-2"><i class="bi bi-envelope-fill me-2"></i> contact@supercar.mu</p> 
               <p class="mb-0"><i class="bi bi-geo-alt-fill me-2"></i> Ebene / Cybercity, Maurice</p> 

              </div>

            <div class="col-md-3 footer-social">
                <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">Suivez-nous</h6>
                <a href="#"><i class="bi bi-facebook mx-2 fs-4"></i></a>
                <a href="#"><i class="bi bi-instagram mx-2 fs-4"></i></a>
                <a href="#"><i class="bi bi-whatsapp mx-2 fs-4"></i></a>
                <a href="#"><i class="bi bi-linkedin mx-2 fs-4"></i></a>
            </div>

            <div class="col-md-3">
                <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">Liens utiles</h6>
                <p class="mb-2"><a href="index.php">Accueil</a></p>
                <p class="mb-2"><a href="voitures.php">Nos voitures</a></p>
                <p class="mb-2"><a href="essai.php">Demande d'essai</a></p>
                <p class="mb-2"><a href="contactclient.php">Contact</a></p>
                
            </div>

            <div class="col-md-3">
                <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">Nos politiques</h6>
                <p class="mb-2"><a href="#" data-bs-toggle="modal" data-bs-target="#mentionsLegalesModal">Mentions légales</a></p>
                <p class="mb-2"><a href="#" data-bs-toggle="modal" data-bs-target="#politique">Politique de confidentialité</a></p>
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


<!-- Modal Mentions Légales -->
<div class="modal fade" id="mentionsLegalesModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content bg-dark text-white border border-warning">
      
      <div class="modal-header border-bottom border-warning">
        <h5 class="modal-title fw-bold">Mentions Légales – SuperCar</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      
      <div class="modal-body">

        <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">1. Présentation du site</h6>
        <p class="mb-4">
          Le site SuperCar est une application web dynamique réalisée dans le cadre du BTS SIO (Services Informatiques aux Organisations), option SLAM, à la MCCI Business School.
        </p>

        <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">2. Responsables du projet</h6>
        <p class="mb-4">
          Nix - Julien - Ilaina<br>
          Étudiants en BTS SIO – Réalisation Professionnelle<br>
          MCCI Business School<br>
          Rue Savoir, Cybercity, Ebène, Maurice
        </p>

        <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">3. Objet du site</h6>
        <p class="mb-2">Le site a pour objectif :</p>
        <ul class="mb-4">
          <li>De présenter les véhicules proposés par le concessionnaire</li>
          <li>De permettre aux visiteurs de demander un essai de ces véhicules</li>
          <li>De gérer les demandes d'essai en ligne</li>
        </ul>

        <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">4. Hébergement</h6>
        <p class="mb-2">
          Le site est actuellement hébergé localement dans un environnement de développement utilisant :
        </p>
        <ul class="mb-4">
          <li>XAMPP</li>
          <li>Apache</li>
          <li>MySQL</li>
        </ul>

        <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">5. Technologies utilisées</h6>
        <p class="mb-2">Le projet utilise les technologies suivantes :</p>
        <ul class="mb-4">
          <li>PHP</li>
          <li>Apache</li>
          <li>MySQL</li>
          <li>HTML5</li>
          <li>CSS3</li>
          <li>Bootstrap</li>
          <li>JavaScript</li>
        </ul>

        <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">6. Accès à l'administration</h6>
        <p class="mb-2">
          L'accès à l'espace d'administration est réservé exclusivement aux administrateurs autorisés. Les données administratives sont protégées par :
        </p>
        <ul class="mb-4">
          <li>Un système d'authentification</li>
          <li>Des sessions PHP (<code>$_SESSION</code>)</li>
          <li>Des mots de passe sécurisés avec <code>password_hash</code></li>
          <li>Des requêtes préparées MySQLi afin de limiter les injections SQL</li>
        </ul>

        <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">7. Propriété intellectuelle</h6>
        <p class="mb-4">
          L'ensemble des contenus présents sur le site SuperCar (textes, images, logos, structure, code source et éléments graphiques) est utilisé dans un cadre pédagogique.<br><br>
          Toute reproduction, diffusion ou utilisation non autorisée des contenus du site est interdite sans autorisation préalable.<br><br>
          Les marques et modèles de voitures présentés restent la propriété de leurs détenteurs respectifs.
        </p>

        <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">8. Données personnelles</h6>
        <p class="mb-4">
          Le site collecte certaines données personnelles dans le cadre de l'inscription et des demandes d'essai. Ces données sont traitées conformément à la politique de confidentialité du site, consultable via le lien dédié.
        </p>

        <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">9. Limitation de responsabilité</h6>
        <p class="mb-2">
          Les développeurs du projet s'efforcent de fournir des informations aussi précises que possible. Toutefois, des erreurs ou omissions peuvent être présentes.<br><br>
          Le site étant un projet pédagogique, les développeurs ne pourront être tenus responsables :
        </p>
        <ul class="mb-4">
          <li>D'un dysfonctionnement technique</li>
          <li>D'une interruption temporaire</li>
          <li>D'une perte de données</li>
          <li>Ou d'une mauvaise utilisation du site</li>
        </ul>

        <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">10. Contact</h6>
        <p class="mb-4">
          Pour toute question concernant le site : <a href="mailto:contact@supercar.mu" class="text-warning">contact@supercar.mu</a>
        </p>

      </div>

      <div class="modal-footer border-top border-warning">
        <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal">Fermer</button>
      </div>

    </div>
  </div>
</div>
      
      <div class="modal-footer border-top border-warning">
        <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal">Fermer</button>
      </div>
      
    </div>
  </div>
</div>



<!-- Modal Politique de Confidentialité -->
<div class="modal fade" id="politique" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content bg-dark text-white border border-warning">
      
      <div class="modal-header border-bottom border-warning">
        <h5 class="modal-title fw-bold">Politique de Confidentialité – SuperCar</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      
      <div class="modal-body">

        <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">1. Introduction</h6>
        <p class="mb-4">
          La présente politique de confidentialité a pour objectif d'informer les utilisateurs du site SuperCar sur la collecte et l'utilisation de leurs données personnelles. Le respect de la vie privée des utilisateurs fait partie des priorités du projet.
        </p>

        <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">2. Données collectées</h6>
        <p class="mb-2 fw-semibold">Lors de l'inscription :</p>
        <ul class="mb-3">
          <li>Nom</li>
          <li>Prénom</li>
          <li>Adresse e-mail</li>
          <li>Numéro de téléphone</li>
          <li>Adresse postale</li>
          <li>Mot de passe sécurisé</li>
        </ul>
        <p class="mb-2 fw-semibold">Lors d'une demande d'essai :</p>
        <ul class="mb-4">
          <li>Nom</li>
          <li>Adresse e-mail</li>
          <li>Numéro de téléphone</li>
          <li>Véhicule souhaité</li>
          <li>Date d'essai demandée</li>
        </ul>

        <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">3. Finalité des données</h6>
        <p class="mb-2">Les données collectées sont utilisées uniquement pour :</p>
        <ul class="mb-3">
          <li>Gérer les comptes utilisateurs</li>
          <li>Traiter les demandes d'essai</li>
          <li>Organiser les rendez-vous</li>
          <li>Assurer le bon fonctionnement du site</li>
        </ul>
        <p class="mb-4">Les données ne sont ni revendues ni transmises à des tiers.</p>

        <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">4. Sécurité des données</h6>
        <p class="mb-2">Le site met en œuvre plusieurs mesures de sécurité :</p>
        <ul class="mb-4">
          <li>Mots de passe hachés avec <code>password_hash</code></li>
          <li>Utilisation de requêtes préparées MySQLi</li>
          <li>Protection des espaces administrateurs par session PHP</li>
          <li>Contrôle d'accès administrateur</li>
        </ul>

        <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">5. Sessions et cookies</h6>
        <p class="mb-4">
          Le site utilise des sessions PHP (<code>session_start()</code> et <code>$_SESSION</code>) afin de maintenir la connexion des utilisateurs et sécuriser certaines fonctionnalités. Aucun système publicitaire ou outil de suivi externe n'est utilisé.
        </p>

        <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">6. Conservation des données</h6>
        <p class="mb-2">
          Les données collectées via les formulaires d'inscription et de demande d'essai sont enregistrées dans une base de données MySQL. Ces données sont conservées pendant une durée raisonnable nécessaire :
        </p>
        <ul class="mb-3">
          <li>À la gestion des comptes utilisateurs</li>
          <li>Au traitement des demandes d'essai</li>
          <li>Au bon fonctionnement du projet pédagogique SuperCar</li>
        </ul>
        <p class="mb-4">L'accès aux données est limité exclusivement à l'administrateur du site.</p>

        <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">7. Droits des utilisateurs</h6>
        <p class="mb-2">Les utilisateurs peuvent demander :</p>
        <ul class="mb-3">
          <li>L'accès à leurs données</li>
          <li>La modification de leurs informations</li>
          <li>La suppression de leurs données personnelles</li>
        </ul>
        <p class="mb-4">
          Toute demande peut être envoyée à : <a href="mailto:contact@supercar.mu" class="text-warning">contact@supercar.mu</a>
        </p>

        <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">8. Protection des mineurs</h6>
        <p class="mb-4">
          Le site SuperCar est accessible à tout public. Toutefois, certaines fonctionnalités liées aux essais de véhicules peuvent nécessiter l'intervention d'un adulte disposant d'un permis de conduire valide.
        </p>

        <h6 class="fw-bold mb-3" style="color: var(--primary-orange);">9. Modification de la politique</h6>
        <p class="mb-0">
          La présente politique de confidentialité peut être modifiée à tout moment afin d'améliorer le fonctionnement du site ou de respecter les évolutions du projet pédagogique.
        </p>

      </div>

      <div class="modal-footer border-top border-warning">
        <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal">Fermer</button>
      </div>

    </div>
  </div>
</div>
      
    </div>
  </div>
</div>





   
    <!-- FOOTER -->
  
