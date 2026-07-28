<?php
// ============================================================
//  vues/layout/politique_contenu.php  —  VUE (partiel) : texte de la
//  politique de confidentialité.
//  Un SEUL fichier, réutilisé à 2 endroits (pas de copier-coller) :
//   - dans la fenêtre du footer (footer.php)
//   - dans la page autonome politique.php (politique_vue.php)
// ============================================================
?>
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
  Toute demande peut être envoyée à : <a href="mailto:contact@supercar.mu" class="text-orange">contact@supercar.mu</a>
</p>

<h6 class="fw-bold mb-3" style="color: var(--primary-orange);">8. Protection des mineurs</h6>
<p class="mb-4">
  Le site SuperCar est accessible à tout public. Toutefois, certaines fonctionnalités liées aux essais de véhicules peuvent nécessiter l'intervention d'un adulte disposant d'un permis de conduire valide.
</p>

<h6 class="fw-bold mb-3" style="color: var(--primary-orange);">9. Modification de la politique</h6>
<p class="mb-0">
  La présente politique de confidentialité peut être modifiée à tout moment afin d'améliorer le fonctionnement du site ou de respecter les évolutions du projet pédagogique.
</p>
