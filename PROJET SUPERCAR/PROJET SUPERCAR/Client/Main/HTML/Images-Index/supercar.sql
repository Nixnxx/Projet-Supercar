CREATE TABLE marque(
   id_marque INT,
   nom VARCHAR(50),
   pays_origine VARCHAR(50),
   description VARCHAR(500),
   PRIMARY KEY(id_marque)
)ENGINE=InnoDB;
 
CREATE TABLE client(
   id_client INT,
   nom VARCHAR(50),
   prenom VARCHAR(50),
   email VARCHAR(100),
   telephone INT,
   adresse VARCHAR(50),
   inscrit BOOLEAN,
   date_inscription DATE,
   id_contact INT NOT NULL,
   PRIMARY KEY(id_client),
   FOREIGN KEY(id_contact) REFERENCES contact(id_contact)
)ENGINE=InnoDB;
 
 
CREATE TABLE login(
   id_login INT,
   login VARCHAR(50),
   mot_de_passe VARCHAR(50),
   niveau VARCHAR(50),
   nom VARCHAR(100),
   id_client INT NOT NULL,
   PRIMARY KEY(id_login),
   FOREIGN KEY(id_client) REFERENCES client(id_client)
)ENGINE=InnoDB;
 
CREATE TABLE contact(
   id_contact INT,
   nom VARCHAR(50),
   email VARCHAR(100),
   message VARCHAR(800),
   PRIMARY KEY(id_contact)
)ENGINE=InnoDB;
 
 
 
CREATE TABLE demandeEssai(
   id_demande INT,
   date_demande DATETIME,
   date_essai_proposee DATE,
   statut INT,
   commentaire VARCHAR(100),
   id_client INT NOT NULL,
   PRIMARY KEY(id_demande),
   FOREIGN KEY(id_client) REFERENCES client(id_client)
)ENGINE=InnoDB;
 
CREATE TABLE service(
   id_service INT,
   nom VARCHAR(50),
   description VARCHAR(300),
   PRIMARY KEY(id_service)
)ENGINE=InnoDB;
 
CREATE TABLE voiture(
   id_voiture INT,
   model VARCHAR(50),
   annee DATE,
   prix BIGINT,
   couleur VARCHAR(50),
   specs VARCHAR(300),
   stock_total INT,
   id_demande INT NOT NULL,
   id_marque INT NOT NULL,
   PRIMARY KEY(id_voiture),
   FOREIGN KEY(id_demande) REFERENCES demandeEssai(id_demande),
   FOREIGN KEY(id_marque) REFERENCES marque(id_marque)
)ENGINE=InnoDB;
 
CREATE TABLE proposer(
   id_voiture INT,
   id_service INT,
   PRIMARY KEY(id_voiture, id_service),
   FOREIGN KEY(id_voiture) REFERENCES voiture(id_voiture),
   FOREIGN KEY(id_service) REFERENCES service(id_service)
)ENGINE=InnoDB;