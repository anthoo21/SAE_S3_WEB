<?php


namespace services;

use PDOException;

class InsertFichierService
{

    public function insertCisBdpm($pdo, $codeCis, $denom, $forme, $voie, $statut, $typeProced, $etatCommerc, $dateAMM, $statutBdm, $numeroAutoEU, $titulaire, $surveillance) {
        $codeCis1 = iconv(mb_detect_encoding($codeCis, mb_detect_order(), true), "UTF-8", $codeCis);
        $denom1 = iconv(mb_detect_encoding($denom, mb_detect_order(), true), "UTF-8", $denom);
        $forme1 = iconv(mb_detect_encoding($forme, mb_detect_order(), true), "UTF-8", $forme);
        $voie1 = iconv(mb_detect_encoding($voie, mb_detect_order(), true), "UTF-8", $voie);
        $statut1 = iconv(mb_detect_encoding($statut, mb_detect_order(), true), "UTF-8", $statut);
        $typeProced1 = iconv(mb_detect_encoding($typeProced, mb_detect_order(), true), "UTF-8", $typeProced);
        $etatCommerc1 = iconv(mb_detect_encoding($etatCommerc, mb_detect_order(), true), "UTF-8", $etatCommerc);
        $dateAMM1 = iconv(mb_detect_encoding($dateAMM, mb_detect_order(), true), "UTF-8", $dateAMM);
        $statutBdm1 = iconv(mb_detect_encoding($statutBdm, mb_detect_order(), true), "UTF-8", $statutBdm);
        $numeroAutoUE1 = iconv(mb_detect_encoding($numeroAutoEU, mb_detect_order(), true), "UTF-8", $numeroAutoEU);
        $titulaire1 = iconv(mb_detect_encoding($titulaire, mb_detect_order(), true), "UTF-8", $titulaire);
        $surveillance1 = iconv(mb_detect_encoding($surveillance, mb_detect_order(), true), "UTF-8", $surveillance);
        $sql = "INSERT INTO CIS_bdpm (codeCis, denomination, forme, voieAdmin, statutAdmin, typeProcedure, etatCommerc, dateAMM, statutBdm, numeroAutoUE, titulaire, surveillance) 
        VALUES (:codeCis , :denom, :forme, :voie, :statut, :typeProced, :etatCommerc, :dateAMM, :statutBdm, :numeroAutoUE, :titulaire, :surveillance)";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('codeCis', $codeCis1);
        $searchStmt->bindParam('denom', $denom1);
        $searchStmt->bindParam('forme', $forme1);
        $searchStmt->bindParam('voie', $voie1);
        $searchStmt->bindParam('statut', $statut1);
        $searchStmt->bindParam('typeProced', $typeProced1);
        $searchStmt->bindParam('etatCommerc', $etatCommerc1);
        $searchStmt->bindParam('dateAMM', $dateAMM1);
        $searchStmt->bindParam('statutBdm', $statutBdm1);
        $searchStmt->bindParam('numeroAutoUE', $numeroAutoUE1);
        $searchStmt->bindParam('titulaire', $titulaire1);
        $searchStmt->bindParam('surveillance', $surveillance1);
        $searchStmt->execute();
        return $searchStmt;
    }
    public function insertCisCip($pdo, $codeCis_CIP, $codeCip7, $libelle, $statutAdmin, $etatCommerc, $dateDecla, $codeCip13, $agrement, $tauxRemboursement, $prix, $droitRemboursement) {
        $codeCis_CIP1 = iconv(mb_detect_encoding($codeCis_CIP, mb_detect_order(), true), "UTF-8", $codeCis_CIP);
        $codeCip71 = iconv(mb_detect_encoding($codeCip7, mb_detect_order(), true), "UTF-8", $codeCip7);
        $libelle1 = iconv(mb_detect_encoding($libelle, mb_detect_order(), true), "UTF-8", $libelle);
        $statutAdmin1 = iconv(mb_detect_encoding($statutAdmin, mb_detect_order(), true), "UTF-8", $statutAdmin);
        $etatCommerc1 = iconv(mb_detect_encoding($etatCommerc, mb_detect_order(), true), "UTF-8", $etatCommerc);
        $dateDecla1 = iconv(mb_detect_encoding($dateDecla, mb_detect_order(), true), "UTF-8", $dateDecla);
        $codeCip131 = iconv(mb_detect_encoding($codeCip13, mb_detect_order(), true), "UTF-8", $codeCip13);
        $agrement1 = iconv(mb_detect_encoding($agrement, mb_detect_order(), true), "UTF-8", $agrement);
        $tauxRemboursement1 = iconv(mb_detect_encoding($tauxRemboursement, mb_detect_order(), true), "UTF-8", $tauxRemboursement);
        $prix1 = iconv(mb_detect_encoding($prix, mb_detect_order(), true), "UTF-8", $prix);
        $droitRemboursement1 = iconv(mb_detect_encoding($droitRemboursement, mb_detect_order(), true), "UTF-8", $droitRemboursement);
        $sql = "INSERT INTO CIS_CIP_bdpm (codeCis_CIP, codeCip7, libelle, statutAdmin, etatCommerc, dateDecla, codeCip13, agrement, tauxRemboursement, prix, droitRemboursement) 
        VALUES (:codeCis_CIP, :codeCip7, :libelle, :statutAdmin, :etatCommerc, :dateDecla, :codeCip13, :agrement, :tauxRemboursement, :prix, :droitRemboursement)";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('codeCis_CIP', $codeCis_CIP1);
        $searchStmt->bindParam('codeCip7', $codeCip71);
        $searchStmt->bindParam('libelle', $libelle1);
        $searchStmt->bindParam('statutAdmin', $statutAdmin1);
        $searchStmt->bindParam('etatCommerc', $etatCommerc1);
        $searchStmt->bindParam('dateDecla', $dateDecla1);
        $searchStmt->bindParam('codeCip13', $codeCip131);
        $searchStmt->bindParam('agrement', $agrement1);
        $searchStmt->bindParam('tauxRemboursement', $tauxRemboursement1);
        $searchStmt->bindParam('prix', $prix1);
        $searchStmt->bindParam('droitRemboursement', $droitRemboursement1);
        $searchStmt->execute();
        return $searchStmt;
    }

    public function insertCisCompo($pdo, $codeCis_COMPO, $designation, $codeSubstance, $denomSubstance, $dosage, $refDosage, $natureCompo, $numeroLier) {
        $codeCis_COMPO1 = iconv(mb_detect_encoding($codeCis_COMPO, mb_detect_order(), true), "UTF-8", $codeCis_COMPO);
        $designation1 = iconv(mb_detect_encoding($designation, mb_detect_order(), true), "UTF-8", $designation);
        $codeSubstance1 = iconv(mb_detect_encoding($codeSubstance, mb_detect_order(), true), "UTF-8", $codeSubstance);
        $denomSubstance1 = iconv(mb_detect_encoding($denomSubstance, mb_detect_order(), true), "UTF-8", $denomSubstance);
        $dosage1 = iconv(mb_detect_encoding($dosage, mb_detect_order(), true), "UTF-8", $dosage);
        $refDosage1 = iconv(mb_detect_encoding($refDosage, mb_detect_order(), true), "UTF-8", $refDosage);
        $natureCompo1 = iconv(mb_detect_encoding($natureCompo, mb_detect_order(), true), "UTF-8", $natureCompo);
        $numeroLier1 = iconv(mb_detect_encoding($numeroLier, mb_detect_order(), true), "UTF-8", $numeroLier);
        $sql = "INSERT INTO CIS_COMPO_bdpm (codeCis_COMPO, designation, codeSubstance, denomSubstance, dosage, refDosage, natureCompo, numeroLier) 
        VALUES (:codeCis_COMPO, :designation, :codeSubstance, :denomSubstance, :dosage, :refDosage, :natureCompo, :numeroLier)";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('codeCis_COMPO', $codeCis_COMPO1);
        $searchStmt->bindParam('designation', $designation1);
        $searchStmt->bindParam('codeSubstance', $codeSubstance1);
        $searchStmt->bindParam('denomSubstance', $denomSubstance1);
        $searchStmt->bindParam('dosage', $dosage1);
        $searchStmt->bindParam('refDosage', $refDosage1);
        $searchStmt->bindParam('natureCompo', $natureCompo1);
        $searchStmt->bindParam('numeroLier', $numeroLier1);
        $searchStmt->execute();
        return $searchStmt;
    }

    public function insertCisCpd($pdo, $codeCiscodeCis_CPD_COMPO, $conditionPrescri) {
        $codeCis_CPD1 = iconv(mb_detect_encoding($codeCiscodeCis_CPD_COMPO, mb_detect_order(), true), "UTF-8", $codeCiscodeCis_CPD_COMPO);
        $conditionPrescri1 = iconv(mb_detect_encoding($conditionPrescri, mb_detect_order(), true), "UTF-8", $conditionPrescri);
        $sql = "INSERT INTO CIS_CPD_bdpm (codeCis_CPD, conditionPrescri) 
        VALUES (:codeCis_CPD, :conditionPrescri)";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('codeCis_CPD', $codeCis_CPD1);
        $searchStmt->bindParam('conditionPrescri', $conditionPrescri1);
        $searchStmt->execute();
        return $searchStmt;
    }

    public function insertCisGener($pdo, $idGroupe, $libelle, $codeCis_GENER, $typeGener, $numTri) {
        $idGroupe1 = iconv(mb_detect_encoding($idGroupe, mb_detect_order(), true), "UTF-8", $idGroupe);
        $libelle1 = iconv(mb_detect_encoding($libelle, mb_detect_order(), true), "UTF-8", $libelle);
        $codeCis_GENER1 = iconv(mb_detect_encoding($codeCis_GENER, mb_detect_order(), true), "UTF-8", $codeCis_GENER);
        $typeGener1 = iconv(mb_detect_encoding($typeGener, mb_detect_order(), true), "UTF-8", $typeGener);
        $numTri1 = iconv(mb_detect_encoding($numTri, mb_detect_order(), true), "UTF-8", $numTri);
        $sql = "INSERT INTO CIS_GENER_bdpm (idGroupe, libelle, codeCis_GENER, typeGener, numTri) 
        VALUES (:idGroupe, :libelle, :codeCis_GENER, :typeGener, :numTri)";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('idGroupe', $idGroupe1);
        $searchStmt->bindParam('libelle', $libelle1);
        $searchStmt->bindParam('codeCis_GENER', $codeCis_GENER1);
        $searchStmt->bindParam('typeGener', $typeGener1);
        $searchStmt->bindParam('numTri', $numTri1);
        $searchStmt->execute();
        return $searchStmt;
    }

    public function insertCisHasAsmr($pdo, $codeCis_HAS_ASMR, $codeDossier, $motifEval, $dateAvis, $valeurASMR, $libelle) {
        $codeCis_HAS_ASMR1 = iconv(mb_detect_encoding($codeCis_HAS_ASMR, mb_detect_order(), true), "UTF-8", $codeCis_HAS_ASMR);
        $codeDossier1 = iconv(mb_detect_encoding($codeDossier, mb_detect_order(), true), "UTF-8", $codeDossier);
        $motifEval1 = iconv(mb_detect_encoding($motifEval, mb_detect_order(), true), "UTF-8", $motifEval);
        $dateAvis1 = iconv(mb_detect_encoding($dateAvis, mb_detect_order(), true), "UTF-8", $dateAvis);
        $valeurASMR1 = iconv(mb_detect_encoding($valeurASMR, mb_detect_order(), true), "UTF-8", $valeurASMR);
        $libelle1 = iconv(mb_detect_encoding($libelle, mb_detect_order(), true), "UTF-8", $libelle);
        $sql = "INSERT INTO CIS_HAS_ASMR_bdpm (codeCis_HAS_ASMR, codeDossier, motifEval, dateAvis, valeurASMR, libelle) 
        VALUES (:codeCis_HAS_ASMR, :codeDossier, :motifEval, :dateAvis, :valeurASMR, :libelle)";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('codeCis_HAS_ASMR', $codeCis_HAS_ASMR1);
        $searchStmt->bindParam('codeDossier', $codeDossier1);
        $searchStmt->bindParam('motifEval', $motifEval1);
        $searchStmt->bindParam('dateAvis', $dateAvis1);
        $searchStmt->bindParam('valeurASMR', $valeurASMR1);
        $searchStmt->bindParam('libelle', $libelle1);
        $searchStmt->execute();
        return $searchStmt;
    }

    public function insertCisHasSmr($pdo, $codeCis_HAS_SMR, $codeDossier, $motifEval, $dateAvis, $valeurSMR, $libelle) {
        $codeCis_HAS_SMR1 = iconv(mb_detect_encoding($codeCis_HAS_SMR, mb_detect_order(), true), "UTF-8", $codeCis_HAS_SMR);
        $codeDossier1 = iconv(mb_detect_encoding($codeDossier, mb_detect_order(), true), "UTF-8", $codeDossier);
        $motifEval1 = iconv(mb_detect_encoding($motifEval, mb_detect_order(), true), "UTF-8", $motifEval);
        $dateAvis1 = iconv(mb_detect_encoding($dateAvis, mb_detect_order(), true), "UTF-8", $dateAvis);
        $valeurSMR1 = iconv(mb_detect_encoding($valeurSMR, mb_detect_order(), true), "UTF-8", $valeurSMR);
        $libelle1 = iconv(mb_detect_encoding($libelle, mb_detect_order(), true), "UTF-8", $libelle);
        $sql = "INSERT INTO CIS_HAS_SMR_bdpm (codeCis_HAS_SMR, codeDossier, motifEval, dateAvis, valeurSMR, libelle) 
        VALUES (:codeCis_HAS_SMR, :codeDossier, :motifEval, :dateAvis, :valeurSMR, :libelle)";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('codeCis_HAS_SMR', $codeCis_HAS_SMR1);
        $searchStmt->bindParam('codeDossier', $codeDossier1);
        $searchStmt->bindParam('motifEval', $motifEval1);
        $searchStmt->bindParam('dateAvis', $dateAvis1);
        $searchStmt->bindParam('valeurSMR', $valeurSMR1);
        $searchStmt->bindParam('libelle', $libelle1);
        $searchStmt->execute();
        return $searchStmt;
    }

    public function insertCisInfo($pdo, $codeCis_INFO, $dateDebut, $dateFin, $texteLien) {
        $codeCis_INFO1 = iconv(mb_detect_encoding($codeCis_INFO, mb_detect_order(), true), "UTF-8", $codeCis_INFO);
        $dateDebut1 = iconv(mb_detect_encoding($dateDebut, mb_detect_order(), true), "UTF-8", $dateDebut);
        $dateFin1 = iconv(mb_detect_encoding($dateFin, mb_detect_order(), true), "UTF-8", $dateFin);
        $texteLien1 = iconv(mb_detect_encoding($texteLien, mb_detect_order(), true), "UTF-8", $texteLien);
        $sql = "INSERT INTO CIS_InfoImportantes_bdpm (codeCis_INFO, dateDebut, dateFin, texteLien) 
        VALUES (:codeCis_INFO, :dateDebut, :dateFin, :texteLien)";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('codeCis_INFO', $codeCis_INFO1);
        $searchStmt->bindParam('dateDebut', $dateDebut1);
        $searchStmt->bindParam('dateFin', $dateFin1);
        $searchStmt->bindParam('texteLien', $texteLien1);
        $searchStmt->execute();
        return $searchStmt;
    }

    public function insertCisHas($pdo, $codeHas, $liensPage) {
        $codeHas1 = iconv(mb_detect_encoding($codeHas, mb_detect_order(), true), "UTF-8", $codeHas);
        $liensPage1 = iconv(mb_detect_encoding($liensPage, mb_detect_order(), true), "UTF-8", $liensPage);
        $sql = "INSERT INTO HAS_LiensPageCT_bdpm (codeHas, liensPage) 
        VALUES (:codeHas, :liensPage)";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('codeHas', $codeHas1);
        $searchStmt->bindParam('liensPage', $liensPage1);
        $searchStmt->execute();
        return $searchStmt;
    }

    private static $defaultService;

    /**
    * @return mixed
    *  the default instance of ArticlesService used by controllers
    */
    public static function getDefaultService()
    {
        if (InsertFichierService::$defaultService == null) {
            InsertFichierService::$defaultService = new InsertFichierService();
        }
        return InsertFichierService::$defaultService;
    }
}