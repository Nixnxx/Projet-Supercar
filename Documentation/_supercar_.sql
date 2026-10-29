-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql-nix.alwaysdata.net
-- Generation Time: Oct 29, 2026 at 07:22 PM
-- Server version: 11.4.13-MariaDB
-- PHP Version: 8.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nix_supercar`
--

-- --------------------------------------------------------

--
-- Table structure for table `accueil_bienvenue`
--

CREATE TABLE `accueil_bienvenue` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `sous_titre` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `texte` varchar(100) DEFAULT NULL,
  `lien` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `accueil_bienvenue`
--

INSERT INTO `accueil_bienvenue` (`id`, `titre`, `sous_titre`, `description`, `texte`, `lien`) VALUES
(1, 'Bienvenue chez SuperCar', 'Votre porte d\'entrée vers l\'excellence automobile à Maurice.', 'SuperCar importe et propose une sélection exclusive de voitures d\'occasion haut de gamme, contrôlées et certifiées, venues du Japon, Singapour, Afrique du Sud, États-Unis, Chine, Allemagne, France et plus encore.', 'Réserver un essai dès maintenant', 'essai.php');

-- --------------------------------------------------------

--
-- Table structure for table `accueil_bienvenue_images`
--

CREATE TABLE `accueil_bienvenue_images` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `alt` varchar(255) DEFAULT NULL,
  `ordre` int(11) DEFAULT 0,
  `actif` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `accueil_bienvenue_images`
--

INSERT INTO `accueil_bienvenue_images` (`id`, `image`, `alt`, `ordre`, `actif`) VALUES
(1, 'Images-Index/accueil-image/mercedes3.webp', 'Showroom SuperCar luxe', 1, 1),
(2, 'Images-Index/accueil-image/audi4.webp', 'Supercars alignées', 2, 1),
(3, 'Images-Index/accueil-image/bmw1.webp', 'Essai supercar sur route', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `accueil_carousel`
--

CREATE TABLE `accueil_carousel` (
  `id` int(11) NOT NULL,
  `titre` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `lien` varchar(255) DEFAULT NULL,
  `texte_lien` varchar(100) DEFAULT NULL,
  `ordre` int(11) DEFAULT 0,
  `actif` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `accueil_carousel`
--

INSERT INTO `accueil_carousel` (`id`, `titre`, `description`, `image`, `lien`, `texte_lien`, `ordre`, `actif`) VALUES
(1, 'BMW', 'Le luxe allemand au service de la performance. Raffinement, puissance et élégance intemporelle.', 'Images-Index/accueil-carousel/bmw4.webp', 'nonconnecte.php?redirect=essai&id_marque=2', 'Demander un essai', 1, 1),
(2, 'MERCEDES', 'Une supercar d\'exception, née pour la vitesse. Sensations fortes garanties.', 'Images-Index/accueil-carousel/mercedes2.webp', 'nonconnecte.php?redirect=essai&id_marque=3', 'Demander un essai', 2, 1),
(3, 'AUDI', 'L\'alliance parfaite entre sport et élégance. Une conduite précise et dynamique.', 'Images-Index/accueil-carousel/audi1.webp', 'nonconnecte.php?redirect=essai&id_marque=1', 'Demander un essai', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `accueil_points`
--

CREATE TABLE `accueil_points` (
  `id` int(11) NOT NULL,
  `texte` varchar(255) DEFAULT NULL,
  `ordre` int(11) DEFAULT 0,
  `actif` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `accueil_points`
--

INSERT INTO `accueil_points` (`id`, `texte`, `ordre`, `actif`) VALUES
(1, 'Modèles immédiatement disponibles – Pas d\'attente', 1, 1),
(2, 'Inspection complète + préparation professionnelle', 2, 1),
(3, 'Essai routier gratuit sur rendez-vous', 3, 1),
(4, 'Livraison directe à domicile ou bureau', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `accueil_stats`
--

CREATE TABLE `accueil_stats` (
  `id` int(11) NOT NULL,
  `valeur` varchar(50) DEFAULT NULL,
  `label` varchar(100) DEFAULT NULL,
  `ordre` int(11) DEFAULT 0,
  `actif` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `accueil_stats`
--

INSERT INTO `accueil_stats` (`id`, `valeur`, `label`, `ordre`, `actif`) VALUES
(1, '+130', 'Véhicules vendus', 1, 1),
(2, '98%', 'Satisfaction client', 2, 1),
(3, 'Île entière', 'Livraison gratuite', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `audit`
--

CREATE TABLE `audit` (
  `id_audit` int(11) NOT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `nom_table` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `date_action` timestamp NULL DEFAULT current_timestamp(),
  `id_produit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `audit`
--

INSERT INTO `audit` (`id_audit`, `id_admin`, `nom_table`, `action`, `date_action`, `id_produit`) VALUES
(1, NULL, 'voiture', 'insertion', '2026-09-06 19:50:15', NULL),
(2, NULL, 'voiture', 'insertion', '2026-09-06 20:00:42', NULL),
(5, 29, 'voiture', 'insertion', '2026-10-01 05:20:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id_client` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `adresse` varchar(100) DEFAULT NULL,
  `date_inscription` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id_client`, `nom`, `prenom`, `email`, `telephone`, `adresse`, `date_inscription`) VALUES
(8, 'nax', 'rakotoarisoa', 'naxrakoto@gmail.com', '57421979', 'tana', '2026-07-24'),
(33, 'Kausim', 'Jess', 'jess@gmail.com', '58185926', 'Vacoas la caverne No.2', '2026-10-15');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id_contact` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message` varchar(800) DEFAULT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `id_client` int(11) DEFAULT NULL,
  `lu` tinyint(4) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id_contact`, `nom`, `email`, `message`, `numero`, `id_client`, `lu`, `created_at`) VALUES
(7, 'nax', 'naxrakoto@gmail.com', 'ceci est un test du 24 juillet', '57421979', 8, 0, '2026-07-24 12:37:22');

-- --------------------------------------------------------

--
-- Table structure for table `contact_config`
--

CREATE TABLE `contact_config` (
  `id_config` int(11) NOT NULL,
  `adresse` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `map_embed` text DEFAULT NULL,
  `personne_nom` varchar(100) DEFAULT 'Nix',
  `personne_email` varchar(100) DEFAULT 'nix@supercar.com',
  `personne_telephone` varchar(20) DEFAULT '+230 5745 6170'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact_config`
--

INSERT INTO `contact_config` (`id_config`, `adresse`, `email`, `telephone`, `map_embed`, `personne_nom`, `personne_email`, `personne_telephone`) VALUES
(1, 'Ebène Cybercity', 'nix@supercar.com', '+230 57456170', 'https://maps.google.com/maps?q=-20.246435,57.489352&z=15&output=embed', 'Nix', 'nix@supercar.com', '+230 5745 6170');

-- --------------------------------------------------------

--
-- Table structure for table `demandeessai`
--

CREATE TABLE `demandeessai` (
  `id_demande` int(11) NOT NULL,
  `date_demande` date DEFAULT NULL,
  `date_essai_proposee` date DEFAULT NULL,
  `heure_souhaitee` time DEFAULT NULL,
  `statut` enum('en_attente','valide','refuse','annule') NOT NULL DEFAULT 'en_attente',
  `commentaire` varchar(200) DEFAULT NULL,
  `id_client` int(11) DEFAULT NULL,
  `id_voiture` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `demandeessai`
--

INSERT INTO `demandeessai` (`id_demande`, `date_demande`, `date_essai_proposee`, `heure_souhaitee`, `statut`, `commentaire`, `id_client`, `id_voiture`) VALUES
(21, '2026-10-15', '2026-10-22', '15:00:00', 'en_attente', 'Demande via site', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `demande_service`
--

CREATE TABLE `demande_service` (
  `id_demande` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_service` int(11) NOT NULL,
  `date_demande` date NOT NULL DEFAULT curdate(),
  `date_souhaite` date DEFAULT NULL,
  `status` enum('en attente','confirme','refuse') DEFAULT 'en attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `demande_service`
--

INSERT INTO `demande_service` (`id_demande`, `id_client`, `id_service`, `date_demande`, `date_souhaite`, `status`) VALUES
(7, 8, 2, '2026-09-12', '2026-09-17', ''),
(8, 8, 3, '2026-09-12', '2026-09-28', ''),
(9, 8, 4, '2026-09-12', '2026-09-17', ''),
(10, 8, 1, '2026-09-12', '2026-09-29', ''),
(11, 8, 2, '2026-09-12', '2026-09-29', 'en attente');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id_login` int(11) NOT NULL,
  `login` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `niveau` varchar(50) DEFAULT NULL,
  `id_client` int(11) DEFAULT NULL,
  `tentatives_echouees` int(11) NOT NULL DEFAULT 0,
  `derniere_tentative` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id_login`, `login`, `mot_de_passe`, `niveau`, `id_client`, `tentatives_echouees`, `derniere_tentative`) VALUES
(3, 'admin@gmail.com', '$2y$10$qB5MPJhAk8qgq8aJFqPHhOlTcuEzbbxhpEecpZxd.NZAkm1hWOs.u', 'admin', NULL, 0, '2026-09-10 11:11:11'),
(7, 'naxrakoto@gmail.com', '$2y$10$78ZNUNH/hJsrWUoWrpc4K.jG0pjxQ77U9oNoVGug97K9MEKN4Ffn.', 'client', 8, 0, NULL),
(29, 'nix@gmail.com', '$2y$10$QPKLpqg0twDPF.cdsiR.A.FQiqCegShOQsfGEFeLjiJrvZ1ryYFkC', 'admin', NULL, 1, '2026-10-16 14:31:33'),
(38, 'jess@gmail.com', '$2y$12$AMlpAagYVEuFKhtkyPGtmePRllX0I0pYv5xkTd26unn2X23IrybXG', 'client', 33, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `marque`
--

CREATE TABLE `marque` (
  `id_marque` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `marque`
--

INSERT INTO `marque` (`id_marque`, `nom`) VALUES
(1, 'Audi'),
(2, 'Bmw'),
(3, 'Mercedes');

-- --------------------------------------------------------

--
-- Table structure for table `proposer`
--

CREATE TABLE `proposer` (
  `id_voiture` int(11) NOT NULL,
  `id_service` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id_service` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `icone` varchar(50) DEFAULT NULL,
  `tag` varchar(100) DEFAULT NULL,
  `numero` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id_service`, `nom`, `description`, `image`, `icone`, `tag`, `numero`) VALUES
(1, 'Test de Diagnostic', 'Le voyant moteur clignote ? On branche nos outils pour détecter le problème.', 'Images-Index/Service_Image/diagnostic-auto-opt-scaled.webp', 'bi-cpu', 'Électronique & Moteur', 1),
(2, 'Test de Batterie', 'On vérifie l\'état de votre batterie pour éviter les pannes inattendues.', 'Images-Index/Service_Image/batterie.webp', 'bi-battery-charging', 'Énergie', 2),
(3, 'Garantie & Inspection', 'Toutes nos voitures passent des contrôles stricts avec garantie possible.', 'Images-Index/Service_Image/medium_garantie_constructeur_b72f96b316.webp', 'bi-shield-check', 'Contrôle qualité', 3),
(4, 'Maintenance', 'Entretien complet pour garder votre voiture en parfait état.', 'Images-Index/Service_Image/hero-service-img1.webp', 'bi-tools', 'Entretien', 4);

-- --------------------------------------------------------

--
-- Table structure for table `voiture`
--

CREATE TABLE `voiture` (
  `id_voiture` int(11) NOT NULL,
  `model` varchar(50) DEFAULT NULL,
  `annee` date DEFAULT NULL,
  `prix` bigint(20) DEFAULT NULL,
  `specs` varchar(300) DEFAULT NULL,
  `type_carburant` varchar(50) DEFAULT NULL,
  `km` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `stock_total` int(11) DEFAULT 1,
  `disponible` tinyint(1) NOT NULL DEFAULT 1,
  `id_marque` int(11) DEFAULT NULL,
  `transmission` varchar(20) NOT NULL DEFAULT 'Automatique'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `voiture`
--

INSERT INTO `voiture` (`id_voiture`, `model`, `annee`, `prix`, `specs`, `type_carburant`, `km`, `image`, `stock_total`, `disponible`, `id_marque`, `transmission`) VALUES
(1, 'Audi A5', '2014-01-30', 1500000, 'Berline coupé', 'Essence', 100003, 'Images-Index/audia5.webp', 1, 1, 1, 'Automatique'),
(2, 'Audi E-Tron', '2022-06-10', 4000000, 'Électrique', 'Électrique', 7700, 'Images-Index/audietron.webp', 1, 1, 1, 'Automatique'),
(3, 'Audi Q5', '2021-04-03', 2000000, 'SUV', 'Essence', 75000, 'Images-Index/audiq5.webp', 1, 1, 1, 'Automatique'),
(4, 'Audi R8', '2009-07-02', 4200000, 'Sport', 'Essence', 62000, 'Images-Index/audir8.webp', 1, 1, 1, 'Automatique'),
(5, 'Audi TT', '2016-03-22', 2300000, 'Coupé', 'Essence', 79000, 'Images-Index/auditt.webp', 1, 1, 1, 'Automatique'),
(6, 'BMW 330e', '2022-02-02', 2300000, 'Hybride', 'Hybrid', 38000, 'Images-Index/bmw330e.webp', 1, 1, 2, 'Automatique'),
(7, 'BMW i4 M50', '2022-07-15', 2800000, 'Électrique', 'Électrique', 45000, 'Images-Index/bmwi4.webp', 1, 1, 2, 'Automatique'),
(8, 'BMW M8', '2022-05-19', 6000000, 'Sport', 'Essence', 41000, 'Images-Index/bmwm8.webp', 1, 1, 2, 'Automatique'),
(9, 'BMW 740e', '2017-05-19', 2700000, 'Hybride', 'Hybrid', 40000, 'Images-Index/bmwserie7.webp', 1, 1, 2, 'Automatique'),
(10, 'BMW X5 45e', '2022-08-12', 4500000, 'SUV Hybride', 'Hybrid', 36500, 'Images-Index/bmwx5.webp', 1, 1, 2, 'Automatique'),
(11, 'Mercedes G350d', '2023-11-30', 8000000, 'SUV Luxe', 'Diesel', 40000, 'Images-Index/mercedesclassg.webp', 1, 1, 3, 'Automatique'),
(12, 'Mercedes CLE200', '2024-03-12', 4000000, 'Coupé', 'Essence', 180004, 'Images-Index/mercedescle.webp', 1, 1, 3, 'Automatique'),
(13, 'Mercedes EQC', '2021-04-15', 3200000, 'Électrique', 'Électrique', 70000, 'Images-Index/mercedeseqc.webp', 1, 1, 3, 'Automatique'),
(14, 'Mercedes S450 AMG', '2022-06-03', 6200000, 'Luxe', 'Hybrid', 15000, 'Images-Index/mercedessclass.webp', 1, 1, 3, 'Automatique'),
(15, 'CLA 45s AMG', '2026-05-16', 4800000, 'Sport', 'Essence', 1, 'Images-Index/cla45.webp', 1, 1, 3, 'Automatique');

--
-- Triggers `voiture`
--
DELIMITER $$
CREATE TRIGGER `insert_voiture` AFTER INSERT ON `voiture` FOR EACH ROW BEGIN
    INSERT INTO audit (nom_table, action, date_action, id_produit)
    VALUES ('voiture', 'insertion', NOW(), NEW.id_voiture);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `voiture_images`
--

CREATE TABLE `voiture_images` (
  `id` int(11) NOT NULL,
  `id_voiture` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `ordre` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `voiture_images`
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
-- Indexes for dumped tables
--

--
-- Indexes for table `accueil_bienvenue`
--
ALTER TABLE `accueil_bienvenue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accueil_bienvenue_images`
--
ALTER TABLE `accueil_bienvenue_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accueil_carousel`
--
ALTER TABLE `accueil_carousel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accueil_points`
--
ALTER TABLE `accueil_points`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accueil_stats`
--
ALTER TABLE `accueil_stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit`
--
ALTER TABLE `audit`
  ADD PRIMARY KEY (`id_audit`),
  ADD KEY `audit_ibfk_2` (`id_produit`),
  ADD KEY `audit_ibfk_1` (`id_admin`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id_contact`),
  ADD KEY `id_client` (`id_client`);

--
-- Indexes for table `contact_config`
--
ALTER TABLE `contact_config`
  ADD PRIMARY KEY (`id_config`);

--
-- Indexes for table `demandeessai`
--
ALTER TABLE `demandeessai`
  ADD PRIMARY KEY (`id_demande`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_voiture` (`id_voiture`);

--
-- Indexes for table `demande_service`
--
ALTER TABLE `demande_service`
  ADD PRIMARY KEY (`id_demande`),
  ADD KEY `fk_demande_service_client` (`id_client`),
  ADD KEY `fk_demande_service_service` (`id_service`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_login`),
  ADD KEY `id_client` (`id_client`);

--
-- Indexes for table `marque`
--
ALTER TABLE `marque`
  ADD PRIMARY KEY (`id_marque`);

--
-- Indexes for table `proposer`
--
ALTER TABLE `proposer`
  ADD PRIMARY KEY (`id_voiture`,`id_service`),
  ADD KEY `id_service` (`id_service`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id_service`);

--
-- Indexes for table `voiture`
--
ALTER TABLE `voiture`
  ADD PRIMARY KEY (`id_voiture`),
  ADD KEY `id_marque` (`id_marque`);

--
-- Indexes for table `voiture_images`
--
ALTER TABLE `voiture_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_voiture` (`id_voiture`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accueil_bienvenue`
--
ALTER TABLE `accueil_bienvenue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `accueil_bienvenue_images`
--
ALTER TABLE `accueil_bienvenue_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `accueil_carousel`
--
ALTER TABLE `accueil_carousel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `accueil_points`
--
ALTER TABLE `accueil_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `accueil_stats`
--
ALTER TABLE `accueil_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `audit`
--
ALTER TABLE `audit`
  MODIFY `id_audit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id_contact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `contact_config`
--
ALTER TABLE `contact_config`
  MODIFY `id_config` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `demandeessai`
--
ALTER TABLE `demandeessai`
  MODIFY `id_demande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `demande_service`
--
ALTER TABLE `demande_service`
  MODIFY `id_demande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `marque`
--
ALTER TABLE `marque`
  MODIFY `id_marque` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id_service` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `voiture`
--
ALTER TABLE `voiture`
  MODIFY `id_voiture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `voiture_images`
--
ALTER TABLE `voiture_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit`
--
ALTER TABLE `audit`
  ADD CONSTRAINT `audit_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `login` (`id_login`) ON DELETE SET NULL,
  ADD CONSTRAINT `audit_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `voiture` (`id_voiture`) ON DELETE SET NULL;

--
-- Constraints for table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`);

--
-- Constraints for table `demandeessai`
--
ALTER TABLE `demandeessai`
  ADD CONSTRAINT `demandeessai_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`),
  ADD CONSTRAINT `demandeessai_ibfk_2` FOREIGN KEY (`id_voiture`) REFERENCES `voiture` (`id_voiture`);

--
-- Constraints for table `demande_service`
--
ALTER TABLE `demande_service`
  ADD CONSTRAINT `fk_demande_service_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`),
  ADD CONSTRAINT `fk_demande_service_service` FOREIGN KEY (`id_service`) REFERENCES `service` (`id_service`);

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`);

--
-- Constraints for table `proposer`
--
ALTER TABLE `proposer`
  ADD CONSTRAINT `proposer_ibfk_1` FOREIGN KEY (`id_voiture`) REFERENCES `voiture` (`id_voiture`),
  ADD CONSTRAINT `proposer_ibfk_2` FOREIGN KEY (`id_service`) REFERENCES `service` (`id_service`);

--
-- Constraints for table `voiture`
--
ALTER TABLE `voiture`
  ADD CONSTRAINT `voiture_ibfk_1` FOREIGN KEY (`id_marque`) REFERENCES `marque` (`id_marque`);

--
-- Constraints for table `voiture_images`
--
ALTER TABLE `voiture_images`
  ADD CONSTRAINT `voiture_images_ibfk_1` FOREIGN KEY (`id_voiture`) REFERENCES `voiture` (`id_voiture`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
