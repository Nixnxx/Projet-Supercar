

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



-- ------------------------------------------------------------
-- accueil_bienvenue
-- ------------------------------------------------------------
INSERT INTO `accueil_bienvenue` (`id`, `titre`, `sous_titre`, `description`, `texte`, `lien`) VALUES
(1, 'Bienvenue chez SuperCar',
    'Votre porte d\'entrée vers l\'excellence automobile à Maurice.',
    'SuperCar importe et propose une sélection exclusive de voitures d\'occasion haut de gamme, contrôlées et certifiées, venues du Japon, Singapour, Afrique du Sud, États-Unis, Chine, Allemagne, France et plus encore.',
    'Réserver dès maintenant ',
    'essai.php');

-- ------------------------------------------------------------
-- accueil_bienvenue_images
-- ------------------------------------------------------------
INSERT INTO `accueil_bienvenue_images` (`id`, `image`, `alt`, `ordre`, `actif`) VALUES
(1, 'Images-Index/accueil-image/mercedes3.jpg', 'Showroom SuperCar luxe',          1, 1),
(2, 'Images-Index/accueil-image/audi4.jpg',     'Supercars alignées',               2, 1),
(3, 'Images-Index/accueil-image/bmw1.jpg',      'Essai supercar sur route',         3, 1);

-- ------------------------------------------------------------
-- accueil_carousel
-- ------------------------------------------------------------
INSERT INTO `accueil_carousel` (`id`, `titre`, `description`, `image`, `lien`, `texte_lien`, `ordre`, `actif`) VALUES
(1, 'BMW',
    'Le luxe allemand au service de la performance. Raffinement, puissance et élégance intemporelle.', 
    'Images-Index/accueil-carousel/bmw4.jpg',
    'nonconnecte.php?redirect=essai&id_marque=2',
    'Demander un essai', 1, 1),
(2, 'MERCEDES',
    'Une supercar d\'exception, née pour la vitesse. Sensations fortes garanties.',
    'Images-Index/accueil-carousel/mercedes2.jpg',
    'nonconnecte.php?redirect=essai&id_marque=3',
    'Demander un essai', 2, 1),
(3, 'AUDI',
    'L\'alliance parfaite entre sport et élégance. Une conduite précise et dynamique.',
    'Images-Index/accueil-carousel/audi1.jpg',
    'nonconnecte.php?redirect=essai&id_marque=1',
    'Demander un essai', 3, 1);

-- ------------------------------------------------------------
-- accueil_points
-- ------------------------------------------------------------
INSERT INTO `accueil_points` (`id`, `texte`, `ordre`, `actif`) VALUES
(1, 'Modèles immédiatement disponibles – Pas d\'attente',     1, 1),
(2, 'Inspection complète + préparation professionnelle',       2, 1),
(3, 'Essai routier gratuit sur rendez-vous',                   3, 1),
(4, 'Livraison directe à domicile ou bureau',                  4, 1);

-- ------------------------------------------------------------
-- accueil_stats
-- ------------------------------------------------------------
INSERT INTO `accueil_stats` (`id`, `valeur`, `label`, `ordre`, `actif`) VALUES
(1, '+130',       'Véhicules vendus',    1, 1),
(2, '98%',        'Satisfaction client', 2, 1),
(3, 'Île entière','Livraison gratuite',  3, 1);

-- ------------------------------------------------------------
-- marque  (pas de FK sortante → à insérer en premier)
-- ------------------------------------------------------------
INSERT INTO `marque` (`id_marque`, `nom`) VALUES
(1, 'Audi'),
(2, 'Bmw'),
(3, 'Mercedes');

-- ------------------------------------------------------------
-- service
-- ------------------------------------------------------------
INSERT INTO `service` (`id_service`, `nom`, `description`, `image`, `icone`, `tag`, `numero`) VALUES
(1, 'Test de Diagnostic',
    'Le voyant moteur clignote ? On branche nos outils pour détecter le problème.',
    'Images-Index/Service_Image/diagnostic-auto-opt-scaled.jpg',
    'bi-cpu', 'Électronique & Moteur', 1),
(2, 'Test de Batterie',
    'On vérifie l\'état de votre batterie pour éviter les pannes inattendues.',
    'Images-Index/Service_Image/batterie.jpeg',
    'bi-battery-charging', 'Énergie', 2),
(3, 'Garantie & Inspection',
    'Toutes nos voitures passent des contrôles stricts avec garantie possible.',
    'Images-Index/Service_Image/medium_garantie_constructeur_b72f96b316.png',
    'bi-shield-check', 'Contrôle qualité', 3),
(4, 'Maintenance',
    'Entretien complet pour garder votre voiture en parfait état.',
    'Images-Index/Service_Image/hero-service-img1.jpg',
    'bi-tools', 'Entretien', 4);

-- ------------------------------------------------------------
-- client
-- ------------------------------------------------------------
INSERT INTO `client` (`id_client`, `nom`, `prenom`, `email`, `telephone`, `adresse`, `date_inscription`) VALUES
(1, 'Rakotoarisoa', 'niela Minia',  'rakotoarisoanielaminia@gmail.com', '57456170',  'vacoas',         '2026-03-29'),
(3, 'ROSE JULIEN',  '',             'rosejulien@gmail.com',             '5456456',   '',               '2026-03-31'),
(5, 'manjaka',      'ilaina',       'manjakailaina@gmail.com',          '06158491',  'mahebourg',      '2026-04-21'),
(6, 'tsiresy',      'hoby',         'tsiresyhoby@gmail.com',            '584891',    '894189189',      '2026-05-12'),
(7, 'tsiresy',      'hoby',         'tsires@gmail.com',                 '584891',    '40 rue ebene',   '2026-05-12');

-- ------------------------------------------------------------
-- login
-- ------------------------------------------------------------
INSERT INTO `login` (`id_login`, `login`, `mot_de_passe`, `niveau`, `id_client`) VALUES
(1, 'rakotoarisoanielaminia@gmail.com', '$2y$10$7T7dbgzYOTkpT.ENb1sDA.6uvSk16oGc2VMQpLnbQ4OlkCaEep45.', 'client', 1),
(3, 'admin@gmail.com',                 '$2y$10$qB5MPJhAk8qgq8aJFqPHhOlTcuEzbbxhpEecpZxd.NZAkm1hWOs.u', 'admin',  NULL),
(4, 'manjakailaina@gmail.com',         '$2y$10$RH4hRISB9W7WAcKrw23jMuT/AJMZ8x68n0ftbZOhowUt7kmVHV0rS', 'client', 5),
(5, 'tsiresyhoby@gmail.com',           '$2y$10$cqaFYPastdhHd07M9zV8mOH1ttHNVTx7Hs54s/1fcg/z8Iy4h3vXq', 'client', 6),
(6, 'tsires@gmail.com',                '$2y$10$3DfXcmwYJzWaCVMaha7qW.6U9Tzk1AHUzexFV3E.pACCdh6Fidsdm', 'client', 7);

-- ------------------------------------------------------------
-- contact_config
-- ------------------------------------------------------------
INSERT INTO `contact_config` (`id_config`, `adresse`, `email`, `telephone`, `map_embed`) VALUES
(1, 'Ebène Cybercity', 'nix@supercar.com', '+230 1234567',
    'https://maps.google.com/maps?q=-20.246435,57.489352&z=15&output=embed');

-- ------------------------------------------------------------
-- voiture
-- ------------------------------------------------------------
INSERT INTO `voiture` (`id_voiture`, `model`, `annee`, `prix`, `specs`, `type_carburant`, `km`, `image`, `stock_total`, `id_marque`) VALUES
( 1, 'Audi A5',          '2014-01-30', 1500000, 'Berline coupé', 'Essence',    100003, 'Images-Index/audia5.jpg',          1, 1),
( 2, 'Audi E-Tron',      '2022-06-10', 4000000, 'Électrique',   'Électrique',   7700, 'Images-Index/audietron.jpg',        1, 1),
( 3, 'Audi Q5',          '2021-04-03', 2000000, 'SUV',          'Essence',      75000, 'Images-Index/audiq5.jpg',           1, 1),
( 4, 'Audi R8',          '2009-07-02', 4200000, 'Sport',        'Essence',      62000, 'Images-Index/audir8.jpg',           1, 1),
( 5, 'Audi TT',          '2016-03-22', 2300000, 'Coupé',        'Essence',      79000, 'Images-Index/auditt.jpg',           1, 1),
( 6, 'BMW 330e',         '2022-02-02', 2300000, 'Hybride',      'Hybrid',       38000, 'Images-Index/bmw330e.jpg',          1, 2),
( 7, 'BMW i4 M50',       '2022-07-15', 2800000, 'Électrique',   'Électrique',   45000, 'Images-Index/bmwi4.jpg',            1, 2),
( 8, 'BMW M8',           '2022-05-19', 6000000, 'Sport',        'Essence',      41000, 'Images-Index/bmwm8.jpg',            1, 2),
( 9, 'BMW 740e',         '2017-05-19', 2700000, 'Hybride',      'Hybrid',       40000, 'Images-Index/bmwserie7.jpg',        1, 2),
(10, 'BMW X5 45e',       '2022-08-12', 4500000, 'SUV Hybride',  'Hybrid',       36500, 'Images-Index/bmwx5.jpg',            1, 2),
(11, 'Mercedes G350d',   '2023-11-30', 8000000, 'SUV Luxe',     'Diesel',       40000, 'Images-Index/mercedesclassg.jpg',   1, 3),
(12, 'Mercedes CLE200',  '2024-03-12', 4000000, 'Coupé',        'Essence',     180004, 'Images-Index/mercedescle.jpg',      1, 3),
(13, 'Mercedes EQC',     '2021-04-15', 3200000, 'Électrique',   'Électrique',   70000, 'Images-Index/mercedeseqc.jpg',      1, 3),
(14, 'Mercedes S450 AMG','2022-06-03', 6200000, 'Luxe',         'Hybrid',       15000, 'Images-Index/mercedessclass.jpg',   1, 3),
(15, 'CLA 45s AMG',      '2026-05-16', 4800000, 'Sport',        'Essence',          1, 'Images-Index/cla45.jpg',            1, 3);

-- ------------------------------------------------------------
-- contact
-- ------------------------------------------------------------
INSERT INTO `contact` (`id_contact`, `nom`, `email`, `message`, `numero`, `id_client`, `lu`, `created_at`) VALUES
(1, 'niela Minia Rakotoarisoa', 'rakotoarisoanielaminia@gmail.com', 'bonjour',  '57456170', 1, 0, '2026-04-21 08:52:08'),
(2, 'ROSE JULIEN',             'rosejulien@gmail.com',             'test',     '65489489', 1, 0, '2026-04-21 08:52:08'),
(3, 'Joss Jess',               'jossjess@mail.com',                'test',     '58415678', 1, 1, '2026-04-21 08:52:08');

-- ------------------------------------------------------------
-- demandeessai
-- ------------------------------------------------------------
INSERT INTO `demandeessai` (`id_demande`, `date_demande`, `date_essai_proposee`, `statut`, `commentaire`, `id_client`, `id_voiture`) VALUES
(1, '2026-03-30 06:47:01', '2026-03-27', 0, 'Demande via site', 3, 1),
(2, '2026-04-02 06:21:25', '2026-04-03', 1, 'Demande via site', 5, 1),
(3, '2026-05-06 14:42:07', '2026-05-27', 0, 'Demande via site', 1, 6),
(4, '2026-05-06 14:42:30', '2026-05-15', 1, 'Demande via site', 1, 7),
(5, '2026-05-06 23:22:09', '2026-05-15', 1, 'Demande via site', 5, 7);

-- ------------------------------------------------------------
-- voiture_images
-- ------------------------------------------------------------
INSERT INTO `voiture_images` (`id`, `id_voiture`, `image`, `ordre`) VALUES
( 1,  1, 'Images-Index/audia5.jpg',           0),
( 2,  2, 'Images-Index/audietron.jpg',         0),
( 3,  3, 'Images-Index/audiq5.jpg',            0),
( 4,  4, 'Images-Index/audir8.jpg',            0),
( 5,  5, 'Images-Index/auditt.jpg',            0),
( 6,  6, 'Images-Index/bmw330e.jpg',           0),
( 7,  7, 'Images-Index/bmwi4.jpg',             0),
( 8,  8, 'Images-Index/bmwm8.jpg',             0),
( 9,  9, 'Images-Index/bmwserie7.jpg',         0),
(10, 10, 'Images-Index/bmwx5.jpg',             0),
(11, 11, 'Images-Index/mercedesclassg.jpg',    0),
(12, 12, 'Images-Index/mercedescle.jpg',       0),
(13, 13, 'Images-Index/mercedeseqc.jpg',       0),
(14, 14, 'Images-Index/mercedessclass.jpg',    0),
(15, 15, 'Images-Index/cla45.jpg',             0),
(16, 13, 'Images-Index/eqc1.jpeg',             1),
(17, 13, 'Images-Index/eqc2.jpg',              1),
(18, 15, 'Images-Index/cla451.jpg',            1),
(20, 15, 'Images-Index/cla452.jpg',            1),
(21, 14, 'Images-Index/s4501.jpg',             1),
(22, 14, 'Images-Index/s4502.jpg',             1),
(23, 12, 'Images-Index/cle2001.jpg',           1),
(24, 12, 'Images-Index/cle2002.jpg',           1),
(25, 11, 'Images-Index/g1.jpg',                1),
(26, 11, 'Images-Index/g2.jpg',                1),
(27,  6, 'Images-Index/330e1.jpg',             1),
(28,  6, 'Images-Index/330e2.jpg',             1),
(29,  8, 'Images-Index/m81.jpg',               1),
(30,  8, 'Images-Index/m82.jpg',               1),
(31,  9, 'Images-Index/740e1.jpg',             1),
(32,  9, 'Images-Index/740e2.jpg',             1),
(33, 10, 'Images-Index/x45e1.jpg',             1),
(34, 10, 'Images-Index/x45e2.jpg',             1),
(35,  4, 'Images-Index/r81.jpg',               1),
(36,  4, 'Images-Index/r82.jpg',               1),
(37,  5, 'Images-Index/auditt1.jpg',           1),
(38,  5, 'Images-Index/auditt2.jpg',           1),
(39,  1, 'Images-Index/audia51.jpg',           1),
(40,  1, 'Images-Index/audia52.jpg',           1),
(41,  2, 'Images-Index/audietron1.jpg',        1),
(42,  2, 'Images-Index/audietron2.jpg',        1),
(43,  3, 'Images-Index/audiq51.jpg',           1),
(44,  3, 'Images-Index/audiq52.jpg',           1),
(45, 15, 'Images-Index/cla45s123.jpg',         2);

COMMIT;

