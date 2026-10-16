<?php
// ============================================================
//  vues/layout/politique_contenu.php  —  VUE (partiel) : texte de la
//  politique de confidentialité.
//  Le texte est isolé ici pour n'exister qu'à un seul endroit. Il est
//  affiché par politique_vue.php (page publique politique.php). Le
//  footer ne contient plus de fenêtre : il renvoie vers cette page.
//
//  RÈGLE : ce texte doit décrire ce que le code fait RÉELLEMENT.
//  Toute modification du traitement des données (nouveau formulaire,
//  nouvelle colonne, nouveau service externe) doit être répercutée ici.
// ============================================================
?>
<h6 class="fw-bold mb-3 titre-section">1. Introduction</h6>
<p class="mb-4">
  La présente politique de confidentialité informe les utilisateurs du site SuperCar
  sur les données personnelles collectées, l'usage qui en est fait et les droits dont
  ils disposent. Le site étant réalisé et hébergé à Maurice, il se réfère au cadre posé
  par le <em>Data Protection Act 2017</em> mauricien, dont l'autorité de contrôle est le
  Data Protection Office.
</p>

<h6 class="fw-bold mb-3 titre-section">2. Données collectées</h6>
<p class="mb-2">Le site collecte des données par trois formulaires distincts.</p>

<p class="mb-2 fw-semibold">Lors de la création d'un compte :</p>
<ul class="mb-3">
  <li>Nom et prénom</li>
  <li>Adresse e-mail (elle sert également d'identifiant de connexion)</li>
  <li>Numéro de téléphone</li>
  <li>Adresse postale</li>
  <li>Mot de passe — il n'est jamais conservé tel que vous l'avez tapé (voir le point 4)</li>
</ul>

<p class="mb-2 fw-semibold">Lors d'une demande d'essai :</p>
<ul class="mb-3">
  <li>Le véhicule concerné</li>
  <li>La date d'essai souhaitée</li>
  <li>La date de la demande et son statut de traitement</li>
</ul>
<p class="mb-3">
  Cette demande est rattachée au compte de l'utilisateur. Ses coordonnées ne sont donc
  pas saisies une seconde fois : elles sont déjà enregistrées lors de l'inscription.
</p>

<p class="mb-2 fw-semibold">Lors de l'envoi d'un message via le formulaire de contact :</p>
<ul class="mb-3">
  <li>Nom, adresse e-mail et numéro de téléphone indiqués dans le formulaire</li>
  <li>Le contenu du message et sa date d'envoi</li>
</ul>
<p class="mb-4">
  Le formulaire de contact est accessible sans compte : un message peut être envoyé de
  façon anonyme, sans être rattaché à un utilisateur inscrit.
</p>

<h6 class="fw-bold mb-3 titre-section">3. Finalité des données</h6>
<p class="mb-2">Les données collectées servent uniquement à :</p>
<ul class="mb-3">
  <li>Créer et gérer les comptes utilisateurs</li>
  <li>Traiter les demandes d'essai et organiser les rendez-vous</li>
  <li>Répondre aux messages envoyés par le formulaire de contact</li>
  <li>Protéger les comptes contre les tentatives de connexion répétées</li>
</ul>
<p class="mb-4">
  Les données ne font l'objet d'aucune revente, d'aucune publicité et d'aucun profilage.
  Les seuls échanges avec des services extérieurs sont décrits au point 7.
</p>

<h6 class="fw-bold mb-3 titre-section">4. Sécurité des données</h6>
<p class="mb-2">Vos informations sont protégées de plusieurs façons :</p>
<ul class="mb-3">
  <li><strong>Votre mot de passe n'est jamais conservé tel que vous l'avez tapé.</strong>
      Il est transformé en une suite de caractères impossible à retrouver. Même nous
      ne pouvons pas le lire.</li>
  <li><strong>Vos informations ne sont visibles que par vous.</strong> Votre espace
      personnel n'est accessible qu'une fois connecté, et le site vérifie à chaque page
      que les données affichées sont bien les vôtres.</li>
  <li><strong>Votre compte se bloque quelques minutes</strong> après plusieurs mots de
      passe erronés, pour empêcher quelqu'un d'essayer des mots de passe à la chaîne.</li>
  <li><strong>Les formulaires ne peuvent pas être utilisés depuis un autre site</strong>
      à votre insu : chaque envoi est vérifié pour s'assurer qu'il vient bien de vous.</li>
  <li><strong>La gestion du site est réservée aux administrateurs</strong>, et les
      fichiers internes ne sont pas consultables depuis Internet.</li>
</ul>
<p class="mb-4">
  Aucun système n'est infaillible, mais ces mesures sont appliquées sur l'ensemble du site.
</p>

<h6 class="fw-bold mb-3 titre-section">5. Cookies</h6>
<p class="mb-2">
  Le site utilise <strong>un seul cookie</strong> : celui qui vous garde connecté d'une
  page à l'autre.
</p>
<ul class="mb-3">
  <li>Il ne contient <strong>ni votre nom, ni votre e-mail, ni aucune donnée
      personnelle</strong> — seulement un numéro qui permet au site de vous reconnaître.</li>
  <li>Il disparaît dès que vous vous déconnectez ou que vous fermez votre navigateur.</li>
  <li>Il ne peut pas être lu par un autre site.</li>
</ul>
<p class="mb-4">
  Le site n'utilise <strong>aucun cookie publicitaire</strong> et ne mesure pas votre
  navigation. Vous n'êtes suivi nulle part.
</p>

<h6 class="fw-bold mb-3 titre-section">6. Conservation des données</h6>
<p class="mb-2">
  Les données sont enregistrées dans la base de données du site, et conservées :
</p>
<ul class="mb-3">
  <li>Pour un compte : tant qu'il reste actif, et jusqu'à sa suppression sur demande</li>
  <li>Pour une demande d'essai : jusqu'à son traitement, puis à titre d'historique du compte</li>
  <li>Pour un message de contact : le temps d'y répondre et d'en garder la trace</li>
</ul>
<p class="mb-4">
  L'accès aux données enregistrées est limité aux administrateurs du site.
</p>

<h6 class="fw-bold mb-3 titre-section">7. Services extérieurs</h6>
<p class="mb-2">
  L'affichage et l'usage du site entraînent des échanges avec trois services extérieurs,
  qui reçoivent alors l'adresse IP du visiteur :
</p>
<ul class="mb-3">
  <li><strong>Google Fonts</strong> — chargement de la police d'écriture du site</li>
  <li><strong>jsDelivr</strong> — chargement des bibliothèques Bootstrap et Bootstrap Icons</li>
  <li><strong>WhatsApp</strong> — à l'issue d'une demande d'essai, l'utilisateur est invité
      à confirmer son rendez-vous par un message pré-rempli contenant le véhicule choisi
      et la date souhaitée. Cette étape est facultative : la demande est déjà enregistrée
      avant l'ouverture de WhatsApp. L'utilisateur qui poursuit sur WhatsApp relève alors
      de la politique de confidentialité de ce service.</li>
</ul>
<p class="mb-4">
  Aucune donnée n'est transmise à ces services en dehors de ce que décrit ce paragraphe.
</p>

<h6 class="fw-bold mb-3 titre-section">8. Droits des utilisateurs</h6>
<p class="mb-2">Tout utilisateur peut demander :</p>
<ul class="mb-3">
  <li>L'accès aux données le concernant</li>
  <li>La correction de ses informations personnelles</li>
  <li>La suppression de son compte et des données associées</li>
</ul>
<p class="mb-4">
  Ces demandes sont à adresser à
  <a href="mailto:contact@supercar.mu" class="text-orange">contact@supercar.mu</a>
  et sont traitées dans les meilleurs délais.
</p>

<h6 class="fw-bold mb-3 titre-section">9. Protection des mineurs</h6>
<p class="mb-4">
  Le site est consultable par tout public. La réservation d'un essai suppose toutefois
  d'être en mesure de conduire le véhicule : elle requiert un permis de conduire valide,
  vérifié lors du rendez-vous en concession.
</p>

<h6 class="fw-bold mb-3 titre-section">10. Modification de la politique</h6>
<p class="mb-0">
  Cette politique peut évoluer avec le site. Toute modification du traitement des données
  y sera reportée, et la date ci-dessous mise à jour.<br>
  <span class="text-muted">Dernière mise à jour : 28 août 2026.</span>
</p>
