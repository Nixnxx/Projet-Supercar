<?php
// ============================================================
//  controleurs/admin/menu_controleur.php  —  CONTRÔLEUR (partagé)
//  Prépare les deux compteurs affichés en pastille dans le menu
//  latéral du back-office (vues/admin/nav.php).
//
//  POURQUOI CE FICHIER ?
//  Avant, c'était la VUE nav.php qui allait chercher ces chiffres
//  elle-même en appelant les modèles. Une vue ne doit jamais
//  interroger la base : son seul rôle est d'afficher des variables
//  déjà préparées. Le calcul est donc remonté ici, côté contrôleur.
//
//  Comme le menu est affiché par 6 pages différentes, on regroupe
//  ces 2 lignes dans un fichier commun plutôt que de les recopier
//  6 fois. Chaque contrôleur admin qui affiche le menu l'inclut
//  avec une seule ligne, juste après la garde de sécurité.
//
//  Fournit à la vue : $nb_messages_non_lus, $nb_essais_en_attente
// ============================================================

require_once __DIR__ . '/../../modeles/admin/contact_modele.php';
require_once __DIR__ . '/../../modeles/admin/essai_modele.php';

// Nombre de messages jamais ouverts par l'administrateur.
$nb_messages_non_lus = (int) (get_stats_messages($lienbd)['non_lus'] ?? 0);

// Nombre de demandes d'essai encore au statut 0 (en attente).
$nb_essais_en_attente = (int) (get_stats_essais($lienbd)['en_attente'] ?? 0);
