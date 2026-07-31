<?php
// ============================================================
//  vues/layout/mentions_contenu.php  —  VUE (partiel) : texte des
//  mentions légales.
//  Même principe que politique_contenu.php : un SEUL fichier avec le
//  texte, réutilisable. Ici il sert la page autonome mentions.php
//  (via mentions_vue.php).
// ============================================================
?>
<h6 class="fw-bold mb-3 titre-section">1. Présentation du site</h6>
<p class="mb-4">
  Le site SuperCar est une application web dynamique réalisée dans le cadre du BTS SIO (Services Informatiques aux Organisations), option SLAM, à la MCCI Business School.
</p>

<h6 class="fw-bold mb-3 titre-section">2. Responsables du projet</h6>
<p class="mb-4">
  Nix - Julien - Ilaina<br>
  Étudiants en BTS SIO – Réalisation Professionnelle<br>
  MCCI Business School<br>
  Rue Savoir, Cybercity, Ebène, Maurice
</p>

<h6 class="fw-bold mb-3 titre-section">3. Objet du site</h6>
<p class="mb-2">Le site a pour objectif :</p>
<ul class="mb-4">
  <li>De présenter les véhicules proposés par le concessionnaire</li>
  <li>De permettre aux visiteurs de demander un essai de ces véhicules</li>
  <li>De gérer les demandes d'essai en ligne</li>
</ul>

<h6 class="fw-bold mb-3 titre-section">4. Hébergement</h6>
<p class="mb-2">
  Le site est actuellement hébergé localement dans un environnement de développement utilisant :
</p>
<ul class="mb-4">
  <li>WAMP</li>
  <li>Apache</li>
  <li>MySQL</li>
</ul>

<h6 class="fw-bold mb-3 titre-section">5. Technologies utilisées</h6>
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

<h6 class="fw-bold mb-3 titre-section">6. Accès à l'administration</h6>
<p class="mb-2">
  L'accès à l'espace d'administration est réservé exclusivement aux administrateurs autorisés. Les données administratives sont protégées par :
</p>
<ul class="mb-4">
  <li>Un système d'authentification</li>
  <li>Des sessions PHP (<code>$_SESSION</code>)</li>
  <li>Des mots de passe sécurisés avec <code>password_hash</code></li>
  <li>Des requêtes préparées MySQLi afin de limiter les injections SQL</li>
</ul>

<h6 class="fw-bold mb-3 titre-section">7. Propriété intellectuelle</h6>
<p class="mb-4">
  L'ensemble des contenus présents sur le site SuperCar (textes, images, logos, structure, code source et éléments graphiques) est utilisé dans un cadre pédagogique.<br><br>
  Toute reproduction, diffusion ou utilisation non autorisée des contenus du site est interdite sans autorisation préalable.<br><br>
  Les marques et modèles de voitures présentés restent la propriété de leurs détenteurs respectifs.
</p>

<h6 class="fw-bold mb-3 titre-section">8. Données personnelles</h6>
<p class="mb-4">
  Le site collecte certaines données personnelles dans le cadre de l'inscription et des demandes d'essai. Ces données sont traitées conformément à la politique de confidentialité du site, consultable via le lien dédié.
</p>

<h6 class="fw-bold mb-3 titre-section">9. Limitation de responsabilité</h6>
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

<h6 class="fw-bold mb-3 titre-section">10. Contact</h6>
<p class="mb-0">
  Pour toute question concernant le site : <a href="mailto:contact@supercar.mu" class="text-orange">contact@supercar.mu</a>
</p>
