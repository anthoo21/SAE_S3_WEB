<<<<<<< HEAD:cabinet_medical/scriptsql/creationTablesMedicaments.sql
-- 1 Structure table CIS_bdpm
CREATE TABLE CIS_bdpm (
    codeCis CHAR(8) NOT NULL,
    denomination VARCHAR(800) NOT NULL,
    forme VARCHAR(500),
    voieAdmin VARCHAR(500),
    statutAdmin VARCHAR(200),
    typeProcedure VARCHAR(200),
    etatCommerc VARCHAR(100),
    dateAMM VARCHAR(20) NOT NULL, /*Format JJ/MM/AAAA : penser à faire date_format()*/
    statutBdm VARCHAR(100),
    numeroAutoUE VARCHAR(25),
    titulaire VARCHAR(100),
    surveillance CHAR(3)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 2 Structure table CIS_CIP_bdpm
CREATE TABLE CIS_CIP_bdpm (
    codeCis_CIP CHAR(8) NOT NULL,
    codeCip7 CHAR(7) NOT NULL,
    libelle VARCHAR(500) NOT NULL,
    statutAdmin VARCHAR(300),
    etatCommerc VARCHAR(100),
    dateDecla VARCHAR(20) NOT NULL, /*Format JJ/MM/AAAA : penser à faire date_format()*/
    codeCip13 CHAR(13),
    agrement VARCHAR(8),
    tauxRemboursement VARCHAR(5),
    prix VARCHAR(20),
    droitRemboursement VARCHAR(5000)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 3 Structure table CIS_COMPO_bdpm
CREATE TABLE CIS_COMPO_bdpm (
    codeCis_COMPO CHAR(8) NOT NULL,
    designation VARCHAR(50) NOT NULL,
    codeSubstance CHAR(6) NOT NULL,
    denomSubstance VARCHAR(300) NOT NULL,
    dosage VARCHAR(100),
    refDosage VARCHAR(100),
    natureCompo VARCHAR(10),
    numeroLier VARCHAR(10)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 4 Structure table CIS_COMPO_bdpm
CREATE TABLE CIS_CPD_bdpm (
    codeCis_CPD CHAR(8) NOT NULL,
    conditionPrescri VARCHAR(200)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 5 Structure table CIS_GENER_bdpm
CREATE TABLE CIS_GENER_bdpm (
    idGroupe VARCHAR(4) NOT NULL,
    libelle VARCHAR(800) NOT NULL,
    codeCis_GENER CHAR(8) NOT NULL,
    typeGener CHAR(1) NOT NULL,
    numTri VARCHAR(3) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 6 Structure table CIS_HAS_ASMR_bdpm
CREATE TABLE CIS_HAS_ASMR_bdpm (
    codeCis_HAS_ASMR CHAR(8) NOT NULL,
    codeDossier VARCHAR(8) NOT NULL,
    motifEval VARCHAR(50) NOT NULL,
    dateAvis DATE NOT NULL, /*Format JJ/MM/AAAA : penser à faire date_format()*/
    valeurASMR CHAR(40) NOT NULL,
    libelle VARCHAR(5000)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 7 Structure table CIS_HAS_SMR_bdpm
CREATE TABLE CIS_HAS_SMR_bdpm (
    codeCis_HAS_SMR CHAR(8) NOT NULL,
    codeDossier VARCHAR(8) NOT NULL,
    motifEval VARCHAR(50) NOT NULL,
    dateAvis DATE NOT NULL, /*Format JJ/MM/AAAA : penser à faire date_format()*/
    valeurSMR CHAR(40) NOT NULL,
    libelle VARCHAR(5000)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 8 Structure table CIS_InfoImportantes_bdpm
CREATE TABLE CIS_InfoImportantes_bdpm (
    codeCis_INFO CHAR(8) NOT NULL,
    dateDebut DATE NOT NULL,
    dateFin DATE NOT NULL,
    texteLien VARCHAR(2000)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 9 Structure table HAS_LiensPageCT_bdpm
CREATE TABLE HAS_LiensPageCT_bdpm (
    codeHas VARCHAR(8) NOT NULL,
    liensPage VARCHAR(2000) NOT NULL
=======
-- 1 Structure table CIS_bdpm
CREATE TABLE CIS_bdpm (
    codeCis CHAR(8) NOT NULL,
    denomination VARCHAR(800) NOT NULL,
    forme VARCHAR(500),
    voieAdmin VARCHAR(500),
    statutAdmin VARCHAR(200),
    typeProcedure VARCHAR(200),
    etatCommerc VARCHAR(100),
    dateAMM VARCHAR(20) NOT NULL, /*Format JJ/MM/AAAA : penser à faire date_format()*/
    statutBdm VARCHAR(100),
    numeroAutoUE VARCHAR(25),
    titulaire VARCHAR(100),
    surveillance CHAR(3)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 2 Structure table CIS_CIP_bdpm
CREATE TABLE CIS_CIP_bdpm (
    codeCis_CIP CHAR(8) NOT NULL,
    codeCip7 CHAR(7) NOT NULL,
    libelle VARCHAR(500) NOT NULL,
    statutAdmin VARCHAR(300),
    etatCommerc VARCHAR(100),
    dateDecla VARCHAR(20) NOT NULL, /*Format JJ/MM/AAAA : penser à faire date_format()*/
    codeCip13 CHAR(13),
    agrement VARCHAR(8),
    tauxRemboursement VARCHAR(5),
    prix VARCHAR(20),
    droitRemboursement VARCHAR(5000)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 3 Structure table CIS_COMPO_bdpm
CREATE TABLE CIS_COMPO_bdpm (
    codeCis_COMPO CHAR(8) NOT NULL,
    designation VARCHAR(50) NOT NULL,
    codeSubstance CHAR(6) NOT NULL,
    denomSubstance VARCHAR(300) NOT NULL,
    dosage VARCHAR(100),
    refDosage VARCHAR(100),
    natureCompo VARCHAR(10),
    numeroLier VARCHAR(100)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 4 Structure table CIS_COMPO_bdpm
CREATE TABLE CIS_CPD_bdpm (
    codeCis_CPD CHAR(8) NOT NULL,
    conditionPrescri VARCHAR(200)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 5 Structure table CIS_GENER_bdpm
CREATE TABLE CIS_GENER_bdpm (
    idGroupe VARCHAR(4) NOT NULL,
    libelle VARCHAR(800) NOT NULL,
    codeCis_GENER CHAR(8) NOT NULL,
    typeGener CHAR(1) NOT NULL,
    numTri VARCHAR(3) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 6 Structure table CIS_HAS_ASMR_bdpm
CREATE TABLE CIS_HAS_ASMR_bdpm (
    codeCis_HAS_ASMR CHAR(8) NOT NULL,
    codeDossier VARCHAR(8) NOT NULL,
    motifEval VARCHAR(50) NOT NULL,
    dateAvis DATE NOT NULL, /*Format JJ/MM/AAAA : penser à faire date_format()*/
    valeurASMR CHAR(40) NOT NULL,
    libelle VARCHAR(5000)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 7 Structure table CIS_HAS_SMR_bdpm
CREATE TABLE CIS_HAS_SMR_bdpm (
    codeCis_HAS_SMR CHAR(8) NOT NULL,
    codeDossier VARCHAR(8) NOT NULL,
    motifEval VARCHAR(50) NOT NULL,
    dateAvis DATE NOT NULL, /*Format JJ/MM/AAAA : penser à faire date_format()*/
    valeurSMR CHAR(40) NOT NULL,
    libelle VARCHAR(5000)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 8 Structure table CIS_InfoImportantes_bdpm
CREATE TABLE CIS_InfoImportantes_bdpm (
    codeCis_INFO CHAR(8) NOT NULL,
    dateDebut DATE NOT NULL,
    dateFin DATE NOT NULL,
    texteLien VARCHAR(2000)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 9 Structure table HAS_LiensPageCT_bdpm
CREATE TABLE HAS_LiensPageCT_bdpm (
    codeHas VARCHAR(8) NOT NULL,
    liensPage VARCHAR(2000) NOT NULL
>>>>>>> 45090a88a28f79475442f344cd61c946f31eaf7f:www/cabinet_medical/scriptsql/creationTablesMedicaments.sql
)ENGINE=InnoDB DEFAULT CHARSET=utf8;