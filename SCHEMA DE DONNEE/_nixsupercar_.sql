-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 01 oct. 2026 à 22:02
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `supercar`
--

-- --------------------------------------------------------

--
-- Structure de la table `accueil_bienvenue`
--

DROP TABLE IF EXISTS `accueil_bienvenue`;
CREATE TABLE IF NOT EXISTS `accueil_bienvenue` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) DEFAULT NULL,
  `sous_titre` varchar(255) DEFAULT NULL,
  `description` text,
  `texte` varchar(100) DEFAULT NULL,
  `lien` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `accueil_bienvenue`
--

INSERT INTO `accueil_bienvenue` (`id`, `titre`, `sous_titre`, `description`, `texte`, `lien`) VALUES
(1, 'Bienvenue chez SuperCar', 'Votre porte d\'entrée vers l\'excellence automobile à Maurice.', 'SuperCar importe et propose une sélection exclusive de voitures d\'occasion haut de gamme, contrôlées et certifiées, venues du Japon, Singapour, Afrique du Sud, États-Unis, Chine, Allemagne, France et plus encore.', 'Réserver dès maintenant', 'essai.php');

-- --------------------------------------------------------

--
-- Structure de la table `accueil_bienvenue_images`
--

DROP TABLE IF EXISTS `accueil_bienvenue_images`;
CREATE TABLE IF NOT EXISTS `accueil_bienvenue_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT NULL,
  `alt` varchar(255) DEFAULT NULL,
  `ordre` int DEFAULT '0',
  `actif` tinyint DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `accueil_bienvenue_images`
--

INSERT INTO `accueil_bienvenue_images` (`id`, `image`, `alt`, `ordre`, `actif`) VALUES
(1, 'Images-Index/accueil-image/mercedes3.webp', 'Showroom SuperCar luxe', 1, 1),
(2, 'Images-Index/accueil-image/audi4.webp', 'Supercars alignées', 2, 1),
(3, 'Images-Index/accueil-image/bmw1.webp', 'Essai supercar sur route', 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `accueil_carousel`
--

DROP TABLE IF EXISTS `accueil_carousel`;
CREATE TABLE IF NOT EXISTS `accueil_carousel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) DEFAULT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `lien` varchar(255) DEFAULT NULL,
  `texte_lien` varchar(100) DEFAULT NULL,
  `ordre` int DEFAULT '0',
  `actif` tinyint DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `accueil_carousel`
--

INSERT INTO `accueil_carousel` (`id`, `titre`, `description`, `image`, `lien`, `texte_lien`, `ordre`, `actif`) VALUES
(1, 'BMW', 'Le luxe allemand au service de la performance. Raffinement, puissance et élégance intemporelle.', 'Images-Index/accueil-carousel/bmw4.webp', 'nonconnecte.php?redirect=essai&id_marque=2', 'Demander un essai', 1, 1),
(2, 'MERCEDES', 'Une supercar d\'exception, née pour la vitesse. Sensations fortes garanties.', 'Images-Index/accueil-carousel/mercedes2.webp', 'nonconnecte.php?redirect=essai&id_marque=3', 'Demander un essai', 2, 1),
(3, 'AUDI', 'L\'alliance parfaite entre sport et élégance. Une conduite précise et dynamique.', 'Images-Index/accueil-carousel/audi1.webp', 'nonconnecte.php?redirect=essai&id_marque=1', 'Demander un essai', 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `accueil_points`
--

DROP TABLE IF EXISTS `accueil_points`;
CREATE TABLE IF NOT EXISTS `accueil_points` (
  `id` int NOT NULL AUTO_INCREMENT,
  `texte` varchar(255) DEFAULT NULL,
  `ordre` int DEFAULT '0',
  `actif` tinyint DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `accueil_points`
--

INSERT INTO `accueil_points` (`id`, `texte`, `ordre`, `actif`) VALUES
(1, 'Modèles immédiatement disponibles – Pas d\'attente', 1, 1),
(2, 'Inspection complète + préparation professionnelle', 2, 1),
(3, 'Essai routier gratuit sur rendez-vous', 3, 1),
(4, 'Livraison directe à domicile ou bureau', 4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `accueil_stats`
--

DROP TABLE IF EXISTS `accueil_stats`;
CREATE TABLE IF NOT EXISTS `accueil_stats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `valeur` varchar(50) DEFAULT NULL,
  `label` varchar(100) DEFAULT NULL,
  `ordre` int DEFAULT '0',
  `actif` tinyint DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `accueil_stats`
--

INSERT INTO `accueil_stats` (`id`, `valeur`, `label`, `ordre`, `actif`) VALUES
(1, '+130', 'Véhicules vendus', 1, 1),
(2, '98%', 'Satisfaction client', 2, 1),
(3, 'Île entière', 'Livraison gratuite', 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `audit`
--

DROP TABLE IF EXISTS `audit`;
CREATE TABLE IF NOT EXISTS `audit` (
  `id_audit` int NOT NULL AUTO_INCREMENT,
  `id_admin` int DEFAULT NULL,
  `nom_table` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `date_action` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_produit` int DEFAULT NULL,
  PRIMARY KEY (`id_audit`),
  KEY `audit_ibfk_2` (`id_produit`),
  KEY `audit_ibfk_1` (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `audit`
--

INSERT INTO `audit` (`id_audit`, `id_admin`, `nom_table`, `action`, `date_action`, `id_produit`) VALUES
(1, NULL, 'voiture', 'insertion', '2026-09-06 19:50:15', NULL),
(2, NULL, 'voiture', 'insertion', '2026-09-06 20:00:42', NULL),
(5, 29, 'voiture', 'insertion', '2026-10-01 05:20:57', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `adresse` varchar(100) DEFAULT NULL,
  `date_inscription` date DEFAULT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `nom`, `prenom`, `email`, `telephone`, `adresse`, `date_inscription`) VALUES
(1, 'Rakotoarisoa', 'niela Minia', 'rakotoarisoanielaminia@gmail.com', '57456170', 'vacoas', '2026-03-29'),
(3, 'ROSE JULIEN', '', 'rosejulien@gmail.com', '5456456', '', '2026-03-31'),
(5, 'manjaka', 'ilaina', 'manjakailaina@gmail.com', '06158491', 'mahebourg', '2026-04-21'),
(6, 'tsiresy', 'hoby', 'tsiresyhoby@gmail.com', '584891', '894189189', '2026-05-12'),
(7, 'tsiresy', 'hoby', 'tsires@gmail.com', '584891', '40 rue ebene', '2026-05-12'),
(8, 'nax', 'rakotoarisoa', 'naxrakoto@gmail.com', '57421979', 'tana', '2026-07-24');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id_contact` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message` varchar(800) DEFAULT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `id_client` int DEFAULT NULL,
  `lu` tinyint DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_contact`),
  KEY `id_client` (`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id_contact`, `nom`, `email`, `message`, `numero`, `id_client`, `lu`, `created_at`) VALUES
(1, 'niela Minia Rakotoarisoa', 'rakotoarisoanielaminia@gmail.com', 'bonjour', '57456170', 1, 0, '2026-04-21 08:52:08'),
(2, 'ROSE JULIEN', 'rosejulien@gmail.com', 'test', '65489489', 1, 0, '2026-04-21 08:52:08'),
(3, 'Joss Jess', 'jossjess@mail.com', 'test', '58415678', 1, 1, '2026-04-21 08:52:08'),
(5, 'nix nx', 'ninx@gmail.com', 'test du 16 juillet', '58487525', NULL, 0, '2026-07-16 12:32:09'),
(7, 'nax', 'naxrakoto@gmail.com', 'ceci est un test du 24 juillet', '57421979', 8, 0, '2026-07-24 12:37:22');

-- --------------------------------------------------------

--
-- Structure de la table `contact_config`
--

DROP TABLE IF EXISTS `contact_config`;
CREATE TABLE IF NOT EXISTS `contact_config` (
  `id_config` int NOT NULL AUTO_INCREMENT,
  `adresse` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `map_embed` text,
  PRIMARY KEY (`id_config`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `contact_config`
--

INSERT INTO `contact_config` (`id_config`, `adresse`, `email`, `telephone`, `map_embed`) VALUES
(1, 'Ebène Cybercity', 'nix@supercar.com', '+230 57456170', 'https://maps.google.com/maps?q=-20.246435,57.489352&z=15&output=embed');

-- --------------------------------------------------------

--
-- Structure de la table `demandeessai`
--

DROP TABLE IF EXISTS `demandeessai`;
CREATE TABLE IF NOT EXISTS `demandeessai` (
  `id_demande` int NOT NULL AUTO_INCREMENT,
  `date_demande` datetime DEFAULT NULL,
  `date_essai_proposee` date DEFAULT NULL,
  `statut` int DEFAULT NULL,
  `commentaire` varchar(200) DEFAULT NULL,
  `id_client` int DEFAULT NULL,
  `id_voiture` int DEFAULT NULL,
  PRIMARY KEY (`id_demande`),
  KEY `id_client` (`id_client`),
  KEY `id_voiture` (`id_voiture`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `demandeessai`
--

INSERT INTO `demandeessai` (`id_demande`, `date_demande`, `date_essai_proposee`, `statut`, `commentaire`, `id_client`, `id_voiture`) VALUES
(1, '2026-03-30 06:47:01', '2026-03-27', 0, 'Demande via site', 3, 1),
(2, '2026-04-02 06:21:25', '2026-04-03', 1, 'Demande via site', 5, 1),
(3, '2026-05-06 14:42:07', '2026-05-27', 0, 'Demande via site', 1, 6),
(4, '2026-05-06 14:42:30', '2026-05-15', 1, 'Demande via site', 1, 7),
(5, '2026-05-06 23:22:09', '2026-05-15', 1, 'Demande via site', 5, 7),
(6, '2026-07-24 12:36:33', '2026-07-31', 3, 'Demande via site', 8, 2),
(9, '2026-07-24 13:35:10', '2026-07-31', 2, 'Demande via site', 8, 5),
(10, '2026-07-27 14:12:20', '2026-07-30', 0, 'Demande via site', 8, 9),
(11, '2026-07-28 17:13:06', '2026-07-29', 1, 'Demande via site', 8, 3);

-- --------------------------------------------------------

--
-- Structure de la table `demande_service`
--

DROP TABLE IF EXISTS `demande_service`;
CREATE TABLE IF NOT EXISTS `demande_service` (
  `id_demande` int NOT NULL AUTO_INCREMENT,
  `id_client` int NOT NULL,
  `id_service` int NOT NULL,
  `date_demande` date NOT NULL DEFAULT (curdate()),
  `date_souhaite` date DEFAULT NULL,
  `status` enum('en attente','confirme','refuse') DEFAULT 'en attente',
  PRIMARY KEY (`id_demande`),
  KEY `fk_demande_service_client` (`id_client`),
  KEY `fk_demande_service_service` (`id_service`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `demande_service`
--

INSERT INTO `demande_service` (`id_demande`, `id_client`, `id_service`, `date_demande`, `date_souhaite`, `status`) VALUES
(7, 8, 2, '2026-09-12', '2026-09-17', ''),
(8, 8, 3, '2026-09-12', '2026-09-28', ''),
(9, 8, 4, '2026-09-12', '2026-09-17', ''),
(10, 8, 1, '2026-09-12', '2026-09-29', ''),
(11, 8, 2, '2026-09-12', '2026-09-29', 'en attente');

-- --------------------------------------------------------

--
-- Structure de la table `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `id_login` int NOT NULL AUTO_INCREMENT,
  `login` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `niveau` varchar(50) DEFAULT NULL,
  `id_client` int DEFAULT NULL,
  `tentatives_echouees` int NOT NULL DEFAULT '0',
  `derniere_tentative` datetime DEFAULT NULL,
  PRIMARY KEY (`id_login`),
  KEY `id_client` (`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `login`
--

INSERT INTO `login` (`id_login`, `login`, `mot_de_passe`, `niveau`, `id_client`, `tentatives_echouees`, `derniere_tentative`) VALUES
(1, 'rakotoarisoanielaminia@gmail.com', '$2y$10$7T7dbgzYOTkpT.ENb1sDA.6uvSk16oGc2VMQpLnbQ4OlkCaEep45.', 'client', 1, 1, '2026-08-27 18:13:37'),
(3, 'admin@gmail.com', '$2y$10$qB5MPJhAk8qgq8aJFqPHhOlTcuEzbbxhpEecpZxd.NZAkm1hWOs.u', 'admin', NULL, 0, '2026-09-10 11:11:11'),
(4, 'manjakailaina@gmail.com', '$2y$10$RH4hRISB9W7WAcKrw23jMuT/AJMZ8x68n0ftbZOhowUt7kmVHV0rS', 'client', 5, 0, NULL),
(5, 'tsiresyhoby@gmail.com', '$2y$10$cqaFYPastdhHd07M9zV8mOH1ttHNVTx7Hs54s/1fcg/z8Iy4h3vXq', 'client', 6, 0, NULL),
(6, 'tsires@gmail.com', '$2y$10$3DfXcmwYJzWaCVMaha7qW.6U9Tzk1AHUzexFV3E.pACCdh6Fidsdm', 'client', 7, 0, NULL),
(7, 'naxrakoto@gmail.com', '$2y$10$78ZNUNH/hJsrWUoWrpc4K.jG0pjxQ77U9oNoVGug97K9MEKN4Ffn.', 'client', 8, 0, NULL),
(29, 'nix@gmail.com', '$2y$10$QPKLpqg0twDPF.cdsiR.A.FQiqCegShOQsfGEFeLjiJrvZ1ryYFkC', 'admin', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

DROP TABLE IF EXISTS `marque`;
CREATE TABLE IF NOT EXISTS `marque` (
  `id_marque` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_marque`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`id_marque`, `nom`) VALUES
(1, 'Audi'),
(2, 'Bmw'),
(3, 'Mercedes');

-- --------------------------------------------------------

--
-- Structure de la table `proposer`
--

DROP TABLE IF EXISTS `proposer`;
CREATE TABLE IF NOT EXISTS `proposer` (
  `id_voiture` int NOT NULL,
  `id_service` int NOT NULL,
  PRIMARY KEY (`id_voiture`,`id_service`),
  KEY `id_service` (`id_service`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

DROP TABLE IF EXISTS `service`;
CREATE TABLE IF NOT EXISTS `service` (
  `id_service` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `icone` varchar(50) DEFAULT NULL,
  `tag` varchar(100) DEFAULT NULL,
  `numero` int DEFAULT '0',
  PRIMARY KEY (`id_service`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `service`
--

INSERT INTO `service` (`id_service`, `nom`, `description`, `image`, `icone`, `tag`, `numero`) VALUES
(1, 'Test de Diagnostic', 'Le voyant moteur clignote ? On branche nos outils pour détecter le problème.', 'Images-Index/Service_Image/diagnostic-auto-opt-scaled.webp', 'bi-cpu', 'Électronique & Moteur', 1),
(2, 'Test de Batterie', 'On vérifie l\'état de votre batterie pour éviter les pannes inattendues.', 'Images-Index/Service_Image/batterie.webp', 'bi-battery-charging', 'Énergie', 2),
(3, 'Garantie & Inspection', 'Toutes nos voitures passent des contrôles stricts avec garantie possible.', 'Images-Index/Service_Image/medium_garantie_constructeur_b72f96b316.webp', 'bi-shield-check', 'Contrôle qualité', 3),
(4, 'Maintenance', 'Entretien complet pour garder votre voiture en parfait état.', 'Images-Index/Service_Image/hero-service-img1.webp', 'bi-tools', 'Entretien', 4);

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

DROP TABLE IF EXISTS `voiture`;
CREATE TABLE IF NOT EXISTS `voiture` (
  `id_voiture` int NOT NULL AUTO_INCREMENT,
  `model` varchar(50) DEFAULT NULL,
  `annee` date DEFAULT NULL,
  `prix` bigint DEFAULT NULL,
  `specs` varchar(300) DEFAULT NULL,
  `type_carburant` varchar(50) DEFAULT NULL,
  `km` int DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `stock_total` int DEFAULT '1',
  `disponible` tinyint(1) NOT NULL DEFAULT '1',
  `id_marque` int DEFAULT NULL,
  `transmission` varchar(20) NOT NULL DEFAULT 'Automatique',
  PRIMARY KEY (`id_voiture`),
  KEY `id_marque` (`id_marque`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `voiture`
--

INSERT INTO `voiture` (`id_voiture`, `model`, `annee`, `prix`, `specs`, `type_carburant`, `km`, `image`, `stock_total`, `disponible`, `id_marque`, `transmission`) VALUES
(1, 'Audi A5', '2014-01-30', 1500000, 'Berline coupé', 'Essence', 100003, 'Images-Index/audia5.webp', 1, 0, 1, 'Automatique'),
(2, 'Audi E-Tron', '2022-06-10', 4000000, 'Électrique', 'Électrique', 7700, 'Images-Index/audietron.webp', 1, 1, 1, 'Automatique'),
(3, 'Audi Q5', '2021-04-03', 2000000, 'SUV', 'Essence', 75000, 'Images-Index/audiq5.webp', 1, 0, 1, 'Automatique'),
(4, 'Audi R8', '2009-07-02', 4200000, 'Sport', 'Essence', 62000, 'Images-Index/audir8.webp', 1, 1, 1, 'Automatique'),
(5, 'Audi TT', '2016-03-22', 2300000, 'Coupé', 'Essence', 79000, 'Images-Index/auditt.webp', 1, 1, 1, 'Automatique'),
(6, 'BMW 330e', '2022-02-02', 2300000, 'Hybride', 'Hybrid', 38000, 'Images-Index/bmw330e.webp', 1, 1, 2, 'Automatique'),
(7, 'BMW i4 M50', '2022-07-15', 2800000, 'Électrique', 'Électrique', 45000, 'Images-Index/bmwi4.webp', 1, 0, 2, 'Automatique'),
(8, 'BMW M8', '2022-05-19', 6000000, 'Sport', 'Essence', 41000, 'Images-Index/bmwm8.webp', 1, 1, 2, 'Automatique'),
(9, 'BMW 740e', '2017-05-19', 2700000, 'Hybride', 'Hybrid', 40000, 'Images-Index/bmwserie7.webp', 1, 1, 2, 'Automatique'),
(10, 'BMW X5 45e', '2022-08-12', 4500000, 'SUV Hybride', 'Hybrid', 36500, 'Images-Index/bmwx5.webp', 1, 1, 2, 'Automatique'),
(11, 'Mercedes G350d', '2023-11-30', 8000000, 'SUV Luxe', 'Diesel', 40000, 'Images-Index/mercedesclassg.webp', 1, 1, 3, 'Automatique'),
(12, 'Mercedes CLE200', '2024-03-12', 4000000, 'Coupé', 'Essence', 180004, 'Images-Index/mercedescle.webp', 1, 1, 3, 'Automatique'),
(13, 'Mercedes EQC', '2021-04-15', 3200000, 'Électrique', 'Électrique', 70000, 'Images-Index/mercedeseqc.webp', 1, 1, 3, 'Automatique'),
(14, 'Mercedes S450 AMG', '2022-06-03', 6200000, 'Luxe', 'Hybrid', 15000, 'Images-Index/mercedessclass.webp', 1, 1, 3, 'Automatique'),
(15, 'CLA 45s AMG', '2026-05-16', 4800000, 'Sport', 'Essence', 1, 'Images-Index/cla45.webp', 1, 1, 3, 'Automatique');

--
-- Déclencheurs `voiture`
--
DROP TRIGGER IF EXISTS `insert_voiture`;
DELIMITER $$
CREATE TRIGGER `insert_voiture` AFTER INSERT ON `voiture` FOR EACH ROW BEGIN
    INSERT INTO audit (nom_table, action, date_action, id_produit)
    VALUES ('voiture', 'insertion', NOW(), NEW.id_voiture);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `voiture_images`
--

DROP TABLE IF EXISTS `voiture_images`;
CREATE TABLE IF NOT EXISTS `voiture_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_voiture` int DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `ordre` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_voiture` (`id_voiture`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `voiture_images`
--

INSERT INTO `voiture_images` (`id`, `id_voiture`, `image`, `ordre`) VALUES
(1, 1, 'Images-Index/audia5.webp', 0),
(2, 2, 'Images-Index/audietron.webp', 0),
(3, 3, 'Images-Index/audiq5.webp', 0),
(4, 4, 'Images-Index/audir8.webp', 0),
(5, 5, 'Images-Index/auditt.webp', 0),
(35, 4, 'Images-Index/r81.webp', 1),
(37, 5, 'Images-Index/auditt1.webp', 1),
(39, 1, 'Images-Index/audia51.webp', 1),
(41, 2, 'Images-Index/audietron1.webp', 1),
(43, 3, 'Images-Index/audiq51.webp', 1),
(48, 11, 'Images-Index/6aaa2c1449034.jpg', 1),
(49, 11, 'Images-Index/6aaa2cb1ea092.jpg', 2),
(50, 12, 'Images-Index/6aaa2cff4cfba.jpg', 1),
(51, 12, 'Images-Index/6aaa2d05a0f1c.jpg', 2),
(52, 13, 'Images-Index/6aaaddb4628fd.jpg', 1),
(53, 13, 'Images-Index/6aaaddbcda008.jpg', 2),
(54, 14, 'Images-Index/6aaade3c1d22d.jpg', 1),
(55, 14, 'Images-Index/6aaade43dc654.jpg', 2),
(56, 15, 'Images-Index/6aaadf02010a7.jpg', 1),
(57, 15, 'Images-Index/6aaadf0dce306.jpg', 2),
(58, 6, 'Images-Index/6aab72f0bb79d.jpg', 1),
(59, 6, 'Images-Index/6aab72f77e062.jpg', 2),
(60, 9, 'Images-Index/6aab7310449af.jpg', 1),
(61, 9, 'Images-Index/6aab7315279be.jpg', 2),
(62, 7, 'Images-Index/6aab73263bc43.jpg', 1),
(63, 8, 'Images-Index/6aab733acda19.jpg', 1),
(64, 8, 'Images-Index/6aab7341e616c.jpg', 2),
(65, 10, 'Images-Index/6aab738f59358.jpg', 1),
(66, 10, 'Images-Index/6aab739cb2357.jpg', 2);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `audit`
--
ALTER TABLE `audit`
  ADD CONSTRAINT `audit_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `login` (`id_login`) ON DELETE SET NULL,
  ADD CONSTRAINT `audit_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `voiture` (`id_voiture`) ON DELETE SET NULL;

--
-- Contraintes pour la table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`);

--
-- Contraintes pour la table `demandeessai`
--
ALTER TABLE `demandeessai`
  ADD CONSTRAINT `demandeessai_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`),
  ADD CONSTRAINT `demandeessai_ibfk_2` FOREIGN KEY (`id_voiture`) REFERENCES `voiture` (`id_voiture`);

--
-- Contraintes pour la table `demande_service`
--
ALTER TABLE `demande_service`
  ADD CONSTRAINT `fk_demande_service_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`),
  ADD CONSTRAINT `fk_demande_service_service` FOREIGN KEY (`id_service`) REFERENCES `service` (`id_service`);

--
-- Contraintes pour la table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`);

--
-- Contraintes pour la table `proposer`
--
ALTER TABLE `proposer`
  ADD CONSTRAINT `proposer_ibfk_1` FOREIGN KEY (`id_voiture`) REFERENCES `voiture` (`id_voiture`),
  ADD CONSTRAINT `proposer_ibfk_2` FOREIGN KEY (`id_service`) REFERENCES `service` (`id_service`);

--
-- Contraintes pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD CONSTRAINT `voiture_ibfk_1` FOREIGN KEY (`id_marque`) REFERENCES `marque` (`id_marque`);

--
-- Contraintes pour la table `voiture_images`
--
ALTER TABLE `voiture_images`
  ADD CONSTRAINT `voiture_images_ibfk_1` FOREIGN KEY (`id_voiture`) REFERENCES `voiture` (`id_voiture`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
