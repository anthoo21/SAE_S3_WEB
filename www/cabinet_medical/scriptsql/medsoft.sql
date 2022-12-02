/* Création d'une base de données */
CREATE DATABASE IF NOT EXISTS medsoft DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

-- 1 Structure table genres
CREATE TABLE `genres` (
  `id_genre` CHAR(2) NOT NULL,
  `sexe` VARCHAR(15) NOT NULL,
  PRIMARY KEY(id_genre)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insertion des genres
INSERT INTO genres VALUES ('01', 'Féminin');
INSERT INTO genres VALUES ('02', 'Masculin');

-- 1 Structure table roles
CREATE TABLE `roles` (
  `id_role` CHAR(3) NOT NULL,
  `nom_role` VARCHAR(15) NOT NULL,
  PRIMARY KEY(id_role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insertion des roles
INSERT INTO roles VALUES ('ADM', 'administrateur');
INSERT INTO roles VALUES ('MED', 'medecin');

-- 1 Structure table cabinet
CREATE TABLE `cabinet` (
  `id_cabinet` CHAR(2) NOT NULL,
  `nom_cabinet` VARCHAR(15) NOT NULL,
  `adresse` VARCHAR(50) NOT NULL,
  PRIMARY KEY(id_cabinet)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insertion données du cabinet
INSERT INTO cabinet VALUES ('CB','Medsoft','Avenue de Bordeaux 12000 Rodez');

-- 2 Structure table utilisateurs
CREATE TABLE `utilisateurs` (
  `identifiant` CHAR(8) NOT NULL,
  `motDePasse` CHAR(8) NOT NULL,
  `code_role` CHAR(3) NOT NULL,
  PRIMARY KEY(identifiant),
  CONSTRAINT fk_utilisateurs_roles FOREIGN KEY(code_role) REFERENCES roles(id_role)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insertion des utilisateurs
INSERT INTO utilisateurs VALUES ('torcal83', '#lm3G7!x', 'MED');
INSERT INTO utilisateurs VALUES ('vaucle85', 'M!56#gs8', 'MED');
INSERT INTO utilisateurs VALUES ('administ', 'aDm1n1s!', 'ADM');
INSERT INTO utilisateurs VALUES ('chaber90', 'apM#é!Kp', 'MED');

-- 3 Structure table medecins
CREATE TABLE `medecins` (
  `id_med` CHAR(3) NOT NULL,
  `nom` VARCHAR(25) NOT NULL,
  `prenom` VARCHAR(25) NOT NULL,
  `dateNai` DATE NOT NULL, 
  `adresse` VARCHAR(50) NOT NULL,
  `tel` CHAR(10) NOT NULL,
  `email` VARCHAR(25),
  `id_util` CHAR(8),
  PRIMARY KEY(id_med),
  CONSTRAINT fk_medecin_utilisateurs FOREIGN KEY(id_util) REFERENCES utilisateurs(identifiant)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insertion des medecins
INSERT INTO medecins VALUES ('001', 'TORGE', 'Calin', '1974-10-18', '4, rue Albert Thomas 81130 Cagnac-les-mines', '0660616263', 'calin.torge@gmail.com', 'torcal83');
INSERT INTO medecins VALUES ('002', 'VAUR', 'Clement', '1985-02-27', '6, chemin des crètes 81990 Puygouzon', '0650515253', 'clement.vaur@gmail.com', 'vaucle85'); 
INSERT INTO medecins VALUES ('003', 'CHAZE', 'Bertille', '1990-03-04', '10, Lices Georges Pompidou 81000 Albi', '0671727374', 'bertille.chaze@gmail.com', 'chaber90'); 

-- 4 Structure table patients
CREATE TABLE `patients` (
  `numeroCarteVitale` CHAR(15) NOT NULL,
  `nom` VARCHAR(25) NOT NULL,
  `prenom` VARCHAR(25) NOT NULL,
  `id_genre` CHAR(2) NOT NULL,
  `tel` CHAR(10) NOT NULL,
  `email` VARCHAR(40),
  `dateNai` DATE NOT NULL,
  `poids` NUMERIC(6,3) NOT NULL,
  `id_medecin` CHAR(3) NOT NULL,
  `allergies` CHAR(3) NOT NULL,
  `commentaires` LONGBLOB,
  PRIMARY KEY(numeroCarteVitale),
  CONSTRAINT fk_patient_genre FOREIGN KEY(id_genre) REFERENCES genres(id_genre),
  CONSTRAINT fk_patient_medecin FOREIGN KEY(id_medecin) REFERENCES medecins(id_med)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insertion des patients
INSERT INTO patients VALUES ('180088100412100', 'DUPOND', 'Patrick', '02', '0636465666', 'patrickdupond@gmail.com', '1980-08-12', '082.500', '001', 'non', 
'Atteint de diabète de type II depuis l age de 6 ans. Consultation tous les 2 mois maximum pour les prescriptions du diabète. Fracture de la cheville gauche en 2020. Non-fumeur.');
INSERT INTO patients VALUES ('203118100403710', 'BONNET', 'Julie', '01', '0611223344', 'juliebonnet@gmail.com', '2003-11-01', '071.658', '003', 'non', 'Petits problemes respiratoire. Antécédents de diabète et de cancer dans la famille. 3 doses anticovid.');
INSERT INTO patients VALUES ('103068002154853', 'MONCZEWSKI', 'Gabriel', '02', '0781828384', 'gabrielmonczewski@gmail.com', '2003-06-14', '088.432', '002', 'non', 'Ablation des végétations et des amygdales. 3 doses anticovid + covid');

-- 5 Structure table visites
CREATE TABLE `visites` (
  `id_visite` CHAR(4) NOT NULL,
  `date_visite` DATE NOT NULL,
  `id_patient` CHAR(15) NOT NULL,
  `id_medecin` CHAR(3) NOT NULL,
  `motif` VARCHAR(50) NOT NULL,
  `observations` LONGBLOB,
  PRIMARY KEY(id_visite),
  CONSTRAINT fk_visites_patients FOREIGN KEY(id_patient) REFERENCES patients(numeroCarteVitale),
  CONSTRAINT fk_visites_medecins FOREIGN KEY(id_medecin) REFERENCES medecins(id_med)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insertion des visites
INSERT INTO visites VALUES ('V001', '2022-10-18', '180088100412100', '001', 'Surveillance diabete', 'Le patient régule très bien son diabete lors de phases d hypo ou d hyperglycémie. Quelques phases de baisses de sucres pendant la nuit.');
INSERT INTO visites VALUES ('V002', '2022-09-23', '203118100403710', '003', 'Vaccin papillon', 'Aucune reaction negativve');
INSERT INTO visites VALUES ('V003', '2022-04-25', '103068002154853', '002', 'Intoxication alimentaire', 'Le patient présente des maux de ventre, des nauxsées ainsi que des maux de tête');

-- 6 Structure table ordonnances
CREATE TABLE `ordonnances` (
  `id_ordo` CHAR(9) NOT NULL,
  `id_visite` CHAR(4) NOT NULL,
  PRIMARY KEY(id_ordo),
  CONSTRAINT fk_ordonnances_visites FOREIGN KEY(id_visite) REFERENCES visites(id_visite)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insertion des ordonnances
INSERT INTO ordonnances VALUES ('ORD000001', 'V001');
INSERT INTO ordonnances VALUES ('ORD000002', 'V002');
INSERT INTO ordonnances VALUES ('ORD000003', 'V003');

-- 7 Structure table prescriptions
CREATE TABLE `prescriptions` (
	`id_prescriptions` CHAR(9) NOT NULL,
	`id_ordonnance` CHAR(9) NOT NULL,
	`id_medicaments` CHAR(3) NOT NULL,
	`posologie` VARCHAR(50) NOT NULL,
	PRIMARY KEY(id_prescriptions),
	CONSTRAINT fk_prescriptions_ordonnances FOREIGN KEY(id_ordonnance) REFERENCES ordonnances(id_ordo)
	/*CONSTRAINT fk_prescriptions_medicaments FOREIGN KEY(id_medicaments) REFERENCES medicaments(id_medoc) à ajouter lorsque table medicaments crée*/
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insertion des prescriptions
INSERT INTO prescriptions VALUES ('PRE000001', 'ORD000001', 'AB1', '3 fois par jour');
INSERT INTO prescriptions VALUES ('PRE000002', 'ORD000002', 'AB2', '1 comprimé toutes les 4h');
INSERT INTO prescriptions VALUES ('PRE000003', 'ORD000002', 'AB3', '1 comprimé tous les soirs');
