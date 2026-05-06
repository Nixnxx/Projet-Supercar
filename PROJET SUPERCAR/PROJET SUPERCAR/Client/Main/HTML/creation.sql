-- TABLE CLIENT
DROP TABLE IF EXISTS client;
CREATE TABLE client (
  id_client INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(50),
  prenom VARCHAR(50),
  email VARCHAR(100),
  telephone VARCHAR(20),
  adresse VARCHAR(100),
  date_inscription DATE
);

-- TABLE LOGIN
DROP TABLE IF EXISTS login;
CREATE TABLE login (
  id_login INT AUTO_INCREMENT PRIMARY KEY,
  login VARCHAR(100),
  mot_de_passe VARCHAR(255),
  niveau VARCHAR(50), -- admin ou client
  id_client INT,
  FOREIGN KEY (id_client) REFERENCES client(id_client)
);



-- TABLE MARQUE
DROP TABLE IF EXISTS marque;
CREATE TABLE marque (
  id_marque INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(50),
  pays_origine VARCHAR(50),
  description VARCHAR(500)
);

-- TABLE VOITURE
DROP TABLE IF EXISTS voiture;
CREATE TABLE voiture (
  id_voiture INT AUTO_INCREMENT PRIMARY KEY,
  model VARCHAR(50),
  annee DATE,
  prix BIGINT,
  couleur VARCHAR(50),
  specs VARCHAR(300),
  type_carburant VARCHAR(50),
  km INT,
  image VARCHAR(255),
  stock_total INT DEFAULT 1,
  id_marque INT,
  FOREIGN KEY (id_marque) REFERENCES marque(id_marque)
);

-- IMAGES VOITURE
DROP TABLE IF EXISTS voiture_images;
CREATE TABLE voiture_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_voiture INT,
  image VARCHAR(255),
  ordre INT DEFAULT 0,
  FOREIGN KEY (id_voiture) REFERENCES voiture(id_voiture)
);



-- TABLE CONTACT
DROP TABLE IF EXISTS contact;
CREATE TABLE contact (
  id_contact INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(50),
  email VARCHAR(100),
  message VARCHAR(800),
  numero VARCHAR(20),
  id_client INT,
  lu TINYINT DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_client) REFERENCES client(id_client)
);

-- CONFIG CONTACT
DROP TABLE IF EXISTS contact_config;
CREATE TABLE contact_config (
  id_config INT AUTO_INCREMENT PRIMARY KEY,
  adresse VARCHAR(100),
  email VARCHAR(100),
  telephone VARCHAR(20),
  map_embed TEXT
);


DROP TABLE IF EXISTS demandeessai;
CREATE TABLE demandeessai (
  id_demande INT AUTO_INCREMENT PRIMARY KEY,
  date_demande DATETIME,
  date_essai_proposee DATE,
  statut INT,
  commentaire VARCHAR(200),
  id_client INT,
  id_voiture INT,
  FOREIGN KEY (id_client) REFERENCES client(id_client),
  FOREIGN KEY (id_voiture) REFERENCES voiture(id_voiture)
);



DROP TABLE IF EXISTS service;
CREATE TABLE service (
  id_service INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(50),
  description VARCHAR(300),
  image VARCHAR(255),
  icone VARCHAR(50),
  tag VARCHAR(100),
  numero INT DEFAULT 0
);

-- RELATION VOITURE / SERVICE
DROP TABLE IF EXISTS proposer;
CREATE TABLE proposer (
  id_voiture INT,
  id_service INT,
  PRIMARY KEY (id_voiture, id_service),
  FOREIGN KEY (id_voiture) REFERENCES voiture(id_voiture),
  FOREIGN KEY (id_service) REFERENCES service(id_service)
);



-- BIENVENUE
DROP TABLE IF EXISTS accueil_bienvenue;
CREATE TABLE accueil_bienvenue (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(255),
  sous_titre VARCHAR(255),
  description TEXT,
  texte VARCHAR(100),
  lien VARCHAR(255)
);

-- IMAGES BIENVENUE
DROP TABLE IF EXISTS accueil_bienvenue_images;
CREATE TABLE accueil_bienvenue_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  image VARCHAR(255),
  alt VARCHAR(255),
  ordre INT DEFAULT 0,
  actif TINYINT DEFAULT 1
);

-- CAROUSEL
DROP TABLE IF EXISTS accueil_carousel;
CREATE TABLE accueil_carousel (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(100),
  description TEXT,
  image VARCHAR(255),
  lien VARCHAR(255),
  texte_lien VARCHAR(100),
  ordre INT DEFAULT 0,
  actif TINYINT DEFAULT 1
);

-- POINTS FORTS
DROP TABLE IF EXISTS accueil_points;
CREATE TABLE accueil_points (
  id INT AUTO_INCREMENT PRIMARY KEY,
  texte VARCHAR(255),
  ordre INT DEFAULT 0,
  actif TINYINT DEFAULT 1
);

-- STATS
DROP TABLE IF EXISTS accueil_stats;
CREATE TABLE accueil_stats (
  id INT AUTO_INCREMENT PRIMARY KEY,
  valeur VARCHAR(50),
  label VARCHAR(100),
  ordre INT DEFAULT 0,
  actif TINYINT DEFAULT 1
);