
CREATE TABLE IF NOT EXISTS accueil_carousel (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  titre       VARCHAR(100) NOT NULL,
  description TEXT NOT NULL,
  image       VARCHAR(255) NOT NULL,
  lien        VARCHAR(255) NOT NULL DEFAULT 'essai.php',
  texte_lien  VARCHAR(100) NOT NULL DEFAULT 'Demander un essai',
  ordre       INT NOT NULL DEFAULT 0,
  actif       TINYINT(1) NOT NULL DEFAULT 1
);

INSERT INTO accueil_carousel (titre, description, image, ordre) VALUES
('BMW',      'Le luxe allemand au service de la performance. Raffinement, puissance et élégance intemporelle.', 'bmw4.jpg',      1),
('MERCEDES', 'Une supercar d\'exception, née pour la vitesse. Sensations fortes garanties.',                   'mercedes2.jpg', 2),
('AUDI',     'L\'alliance parfaite entre sport et élégance. Une conduite précise et dynamique.',               'audi1.jpg',     3);


CREATE TABLE IF NOT EXISTS accueil_bienvenue (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  titre       VARCHAR(255) NOT NULL,
  sous_titre  VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  texte   VARCHAR(100) NOT NULL,
  lien    VARCHAR(255) NOT NULL
);

INSERT INTO accueil_bienvenue (titre, sous_titre, description, texte, lien) VALUES
(
  'Bienvenue chez SuperCar',
  'Votre porte d\'entrée vers l\'excellence automobile à Maurice.',
  'SuperCar importe et propose une sélection exclusive de voitures d\'occasion haut de gamme, contrôlées et certifiées, venues du Japon, Singapour, Afrique du Sud, États-Unis, Chine, Allemagne, France et plus encore.',
  'Réserver mon essai exclusif maintenant →',
  'essai.php'
);


CREATE TABLE IF NOT EXISTS accueil_bienvenue_images (
  id     INT AUTO_INCREMENT PRIMARY KEY,
  image  VARCHAR(255) NOT NULL,
  alt    VARCHAR(255) NOT NULL DEFAULT '',
  ordre  INT NOT NULL DEFAULT 0,
  actif  TINYINT(1) NOT NULL DEFAULT 1
);

INSERT INTO accueil_bienvenue_images (image, alt, ordre) VALUES
('mercedes3.jpg', 'Showroom SuperCar luxe',  1),
('audi4.jpg',     'Supercars alignées',       2),
('bmw1.jpg',      'Essai supercar sur route', 3);


CREATE TABLE IF NOT EXISTS accueil_points (
  id     INT AUTO_INCREMENT PRIMARY KEY,
  texte  VARCHAR(255) NOT NULL,
  ordre  INT NOT NULL DEFAULT 0,
  actif  TINYINT(1) NOT NULL DEFAULT 1
);

INSERT INTO accueil_points (texte, ordre) VALUES
('Modèles immédiatement disponibles – Pas d\'attente',  1),
('Inspection complète + préparation professionnelle',    2),
('Essai routier gratuit sur rendez-vous',                3),
('Livraison directe à domicile ou bureau',               4);


CREATE TABLE IF NOT EXISTS accueil_stats (
  id     INT AUTO_INCREMENT PRIMARY KEY,
  valeur VARCHAR(50)  NOT NULL,
  label  VARCHAR(100) NOT NULL,
  ordre  INT NOT NULL DEFAULT 0,
  actif  TINYINT(1) NOT NULL DEFAULT 1
);

INSERT INTO accueil_stats (valeur, label, ordre) VALUES
('+120',        'Véhicules vendus',   1),
('98%',         'Satisfaction client', 2),
('Île entière', 'Livraison gratuite',  3);