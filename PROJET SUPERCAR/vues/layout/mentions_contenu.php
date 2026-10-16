<?php
// ============================================================
//  vues/layout/mentions_contenu.php  —  VUE (partiel) : texte des
//  mentions légales.
//  Même principe que politique_contenu.php : un SEUL fichier avec le
//  texte, réutilisable. Ici il sert la page autonome mentions.php
//  (via mentions_vue.php).
//
//  RÈGLE : ce texte doit décrire le site tel qu'il est réellement
//  (hébergement, technologies, services externes). À relire à chaque
//  changement d'environnement.
// ============================================================
?>
<h6 class="fw-bold mb-3 titre-section">1. Présentation du site</h6>
<p class="mb-4">
  SuperCar est une application web dynamique réalisée dans le cadre du BTS SIO
  (Services Informatiques aux Organisations), option SLAM, à la MCCI Business School.
  Il s'agit d'un <strong>projet pédagogique</strong> : la concession, les véhicules
  et les offres présentés sont fictifs et ne constituent aucune offre commerciale.
</p>

<h6 class="fw-bold mb-3 titre-section">2. Éditeurs du site</h6>
<p class="mb-4">
  Nix – Julien – Ilaina<br>
  Étudiants en BTS SIO – Réalisation Professionnelle<br>
  MCCI Business School<br>
  Rue Savoir, Cybercity, Ebène, Maurice
</p>

<h6 class="fw-bold mb-3 titre-section">3. Responsables de la publication</h6>
<p class="mb-4">
  La publication du site et de son contenu relève des trois étudiants cités ci-dessus,
  sous la supervision pédagogique de l'équipe enseignante de la MCCI Business School.
  Toute question relative au contenu peut être adressée à l'adresse indiquée au point 12.
</p>

<h6 class="fw-bold mb-3 titre-section">4. Objet du site</h6>
<p class="mb-2">Le site a pour objectif :</p>
<ul class="mb-4">
  <li>De présenter les véhicules proposés par le concessionnaire</li>
  <li>De permettre aux clients inscrits de demander un essai de ces véhicules</li>
  <li>De recevoir les messages envoyés via le formulaire de contact</li>
  <li>De gérer l'ensemble de ces demandes depuis un espace d'administration</li>
</ul>

<h6 class="fw-bold mb-3 titre-section">5. Hébergement</h6>
<p class="mb-2">
  Le site est actuellement exécuté dans un environnement de développement local, sans
  mise en ligne publique. Il n'est donc hébergé par aucun prestataire tiers. L'environnement
  repose sur :
</p>
<ul class="mb-4">
  <li>WAMP (Windows, Apache, MySQL, PHP)</li>
  <li>Serveur web Apache</li>
  <li>Serveur de base de données MySQL</li>
</ul>

<h6 class="fw-bold mb-3 titre-section">6. Technologies utilisées</h6>
<p class="mb-2">Le projet est développé avec :</p>
<ul class="mb-4">
  <li>PHP en programmation procédurale, avec l'extension MySQLi</li>
  <li>Une architecture MVC : modèles, contrôleurs et vues séparés</li>
  <li>Base de données MySQL</li>
  <li>HTML5, CSS3 et JavaScript</li>
  <li>Bootstrap et Bootstrap Icons pour la mise en page</li>
</ul>

<h6 class="fw-bold mb-3 titre-section">7. Services extérieurs</h6>
<p class="mb-2">
  Le site fait appel à des ressources hébergées en dehors du projet :
</p>
<ul class="mb-4">
  <li>Google Fonts, pour la police d'écriture</li>
  <li>jsDelivr, pour les bibliothèques Bootstrap et Bootstrap Icons</li>
  <li>WhatsApp, proposé en fin de demande d'essai pour confirmer le rendez-vous</li>
</ul>
<p class="mb-4">
  Les conséquences de ces appels sur les données personnelles sont détaillées au point 7
  de la <a href="politique.php" class="text-orange">politique de confidentialité</a>.
</p>

<h6 class="fw-bold mb-3 titre-section">8. Accès à l'administration</h6>
<p class="mb-2">
  L'espace d'administration est réservé aux comptes disposant du rôle administrateur.
  Il est protégé par :
</p>
<ul class="mb-4">
  <li>Une authentification par identifiant et mot de passe haché</li>
  <li>Un contrôle du rôle effectué à chaque page, avant tout traitement</li>
  <li>Des sessions PHP configurées avec les options <code>httponly</code> et <code>samesite</code></li>
  <li>Un jeton anti-CSRF sur chaque formulaire modifiant des données</li>
  <li>Un blocage temporaire après plusieurs tentatives de connexion échouées</li>
  <li>Des requêtes préparées sur tous les accès à la base de données</li>
</ul>

<h6 class="fw-bold mb-3 titre-section">9. Propriété intellectuelle</h6>
<p class="mb-4">
  L'ensemble des contenus du site (textes, images, structure, code source et éléments
  graphiques) est produit et utilisé dans un cadre strictement pédagogique.<br><br>
  Toute reproduction ou diffusion en dehors de ce cadre est soumise à l'autorisation
  préalable des auteurs.<br><br>
  Les marques, modèles et visuels de véhicules présentés demeurent la propriété de
  leurs détenteurs respectifs et sont utilisés à titre d'illustration.
</p>

<h6 class="fw-bold mb-3 titre-section">10. Données personnelles</h6>
<p class="mb-4">
  Le site collecte des données personnelles lors de l'inscription, des demandes d'essai
  et de l'envoi d'un message. Le détail des données, de leur usage, de leur durée de
  conservation et des droits des utilisateurs figure dans la
  <a href="politique.php" class="text-orange">politique de confidentialité</a>,
  établie au regard du <em>Data Protection Act 2017</em> mauricien.
</p>

<h6 class="fw-bold mb-3 titre-section">11. Limitation de responsabilité</h6>
<p class="mb-2">
  Les auteurs s'efforcent de fournir des informations aussi exactes que possible, sans
  pouvoir garantir l'absence d'erreurs ou d'omissions. S'agissant d'un projet pédagogique
  non destiné à une exploitation commerciale, leur responsabilité ne saurait être engagée
  en cas :
</p>
<ul class="mb-4">
  <li>De dysfonctionnement technique</li>
  <li>D'interruption temporaire du service</li>
  <li>De perte de données</li>
  <li>D'usage du site non conforme à son objet</li>
</ul>

<h6 class="fw-bold mb-3 titre-section">12. Contact</h6>
<p class="mb-0">
  Pour toute question concernant le site ou son contenu :
  <a href="mailto:contact@supercar.mu" class="text-orange">contact@supercar.mu</a><br>
  <span class="text-muted">Dernière mise à jour : 28 août 2026.</span>
</p>
