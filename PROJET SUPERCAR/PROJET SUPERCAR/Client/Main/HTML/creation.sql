

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE SUPERCAR CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE SUPERCAR;
-- ------------------------------------------------------------
-- Table : accueil_bienvenue
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `accueil_bienvenue`;
CREATE TABLE IF NOT EXISTS `accueil_bienvenue` (
  `id`          int          NOT NULL AUTO_INCREMENT,
  `titre`       varchar(255) DEFAULT NULL,
  `sous_titre`  varchar(255) DEFAULT NULL,
  `description` text,
  `texte`       varchar(100) DEFAULT NULL,
  `lien`        varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ------------------------------------------------------------
-- Table : accueil_bienvenue_images
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `accueil_bienvenue_images`;
CREATE TABLE IF NOT EXISTS `accueil_bienvenue_images` (
  `id`    int          NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT NULL,
  `alt`   varchar(255) DEFAULT NULL,
  `ordre` int          DEFAULT '0',
  `actif` tinyint      DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ------------------------------------------------------------
-- Table : accueil_carousel
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `accueil_carousel`;
CREATE TABLE IF NOT EXISTS `accueil_carousel` (
  `id`          int          NOT NULL AUTO_INCREMENT,
  `titre`       varchar(100) DEFAULT NULL,
  `description` text,
  `image`       varchar(255) DEFAULT NULL,
  `lien`        varchar(255) DEFAULT NULL,
  `texte_lien`  varchar(100) DEFAULT NULL,
  `ordre`       int          DEFAULT '0',
  `actif`       tinyint      DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ------------------------------------------------------------
-- Table : accueil_points
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `accueil_points`;
CREATE TABLE IF NOT EXISTS `accueil_points` (
  `id`    int          NOT NULL AUTO_INCREMENT,
  `texte` varchar(255) DEFAULT NULL,
  `ordre` int          DEFAULT '0',
  `actif` tinyint      DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ------------------------------------------------------------
-- Table : accueil_stats
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `accueil_stats`;
CREATE TABLE IF NOT EXISTS `accueil_stats` (
  `id`     int         NOT NULL AUTO_INCREMENT,
  `valeur` varchar(50) DEFAULT NULL,
  `label`  varchar(100) DEFAULT NULL,
  `ordre`  int         DEFAULT '0',
  `actif`  tinyint     DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ------------------------------------------------------------
-- Table : client
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id_client`        int         NOT NULL AUTO_INCREMENT,
  `nom`              varchar(50) DEFAULT NULL,
  `prenom`           varchar(50) DEFAULT NULL,
  `email`            varchar(100) DEFAULT NULL,
  `telephone`        varchar(20) DEFAULT NULL,
  `adresse`          varchar(100) DEFAULT NULL,
  `date_inscription` date        DEFAULT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ------------------------------------------------------------
-- Table : contact
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id_contact` int          NOT NULL AUTO_INCREMENT,
  `nom`        varchar(50)  DEFAULT NULL,
  `email`      varchar(100) DEFAULT NULL,
  `message`    varchar(800) DEFAULT NULL,
  `numero`     varchar(20)  DEFAULT NULL,
  `id_client`  int          DEFAULT NULL,
  `lu`         tinyint      DEFAULT '0',
  `created_at` datetime     DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_contact`),
  KEY `id_client` (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ------------------------------------------------------------
-- Table : contact_config
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `contact_config`;
CREATE TABLE IF NOT EXISTS `contact_config` (
  `id_config`  int          NOT NULL AUTO_INCREMENT,
  `adresse`    varchar(100) DEFAULT NULL,
  `email`      varchar(100) DEFAULT NULL,
  `telephone`  varchar(20)  DEFAULT NULL,
  `map_embed`  text,
  PRIMARY KEY (`id_config`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ------------------------------------------------------------
-- Table : demandeessai
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `demandeessai`;
CREATE TABLE IF NOT EXISTS `demandeessai` (
  `id_demande`          int          NOT NULL AUTO_INCREMENT,
  `date_demande`        datetime     DEFAULT NULL,
  `date_essai_proposee` date         DEFAULT NULL,
  `statut`              int          DEFAULT NULL,
  `commentaire`         varchar(200) DEFAULT NULL,
  `id_client`           int          DEFAULT NULL,
  `id_voiture`          int          DEFAULT NULL,
  PRIMARY KEY (`id_demande`),
  KEY `id_client`  (`id_client`),
  KEY `id_voiture` (`id_voiture`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ------------------------------------------------------------
-- Table : login
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `id_login`     int          NOT NULL AUTO_INCREMENT,
  `login`        varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `niveau`       varchar(50)  DEFAULT NULL,
  `id_client`    int          DEFAULT NULL,
  PRIMARY KEY (`id_login`),
  KEY `id_client` (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ------------------------------------------------------------
-- Table : marque
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `marque`;
CREATE TABLE IF NOT EXISTS `marque` (
  `id_marque`    int          NOT NULL AUTO_INCREMENT,
  `nom`          varchar(50)  DEFAULT NULL,
  PRIMARY KEY (`id_marque`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ------------------------------------------------------------
-- Table : service
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `service`;
CREATE TABLE IF NOT EXISTS `service` (
  `id_service`  int          NOT NULL AUTO_INCREMENT,
  `nom`         varchar(50)  DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `image`       varchar(255) DEFAULT NULL,
  `icone`       varchar(50)  DEFAULT NULL,
  `tag`         varchar(100) DEFAULT NULL,
  `numero`      int          DEFAULT '0',
  PRIMARY KEY (`id_service`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ------------------------------------------------------------
-- Table : voiture
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `voiture`;
CREATE TABLE IF NOT EXISTS `voiture` (
  `id_voiture`    int          NOT NULL AUTO_INCREMENT,
  `model`         varchar(50)  DEFAULT NULL,
  `annee`         date         DEFAULT NULL,
  `prix`          bigint       DEFAULT NULL,
  `specs`         varchar(300) DEFAULT NULL,
  `type_carburant` varchar(50) DEFAULT NULL,
  `km`            int          DEFAULT NULL,
  `image`         varchar(255) DEFAULT NULL,
  `stock_total`   int          DEFAULT '1',
  `id_marque`     int          DEFAULT NULL,
  PRIMARY KEY (`id_voiture`),
  KEY `id_marque` (`id_marque`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ------------------------------------------------------------
-- Table : voiture_images
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `voiture_images`;
CREATE TABLE IF NOT EXISTS `voiture_images` (
  `id`         int          NOT NULL AUTO_INCREMENT,
  `id_voiture` int          DEFAULT NULL,
  `image`      varchar(255) DEFAULT NULL,
  `ordre`      int          DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_voiture` (`id_voiture`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ------------------------------------------------------------
-- Table : proposer  (table de liaison voiture <-> service)
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `proposer`;
CREATE TABLE IF NOT EXISTS `proposer` (
  `id_voiture` int NOT NULL,
  `id_service` int NOT NULL,
  PRIMARY KEY (`id_voiture`, `id_service`),
  KEY `id_service` (`id_service`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ============================================================
--  Contraintes de clés étrangères (FK)
--  À ajouter APRÈS la création de toutes les tables
-- ============================================================

ALTER TABLE `contact`
  ADD CONSTRAINT `contact_ibfk_1`
    FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`);

ALTER TABLE `demandeessai`
  ADD CONSTRAINT `demandeessai_ibfk_1`
    FOREIGN KEY (`id_client`)  REFERENCES `client`  (`id_client`),
  ADD CONSTRAINT `demandeessai_ibfk_2`
    FOREIGN KEY (`id_voiture`) REFERENCES `voiture` (`id_voiture`);

ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1`
    FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`);

ALTER TABLE `proposer`
  ADD CONSTRAINT `proposer_ibfk_1`
    FOREIGN KEY (`id_voiture`) REFERENCES `voiture` (`id_voiture`),
  ADD CONSTRAINT `proposer_ibfk_2`
    FOREIGN KEY (`id_service`) REFERENCES `service` (`id_service`);

ALTER TABLE `voiture`
  ADD CONSTRAINT `voiture_ibfk_1`
    FOREIGN KEY (`id_marque`) REFERENCES `marque` (`id_marque`);

ALTER TABLE `voiture_images`
  ADD CONSTRAINT `voiture_images_ibfk_1`
    FOREIGN KEY (`id_voiture`) REFERENCES `voiture` (`id_voiture`);

COMMIT;
