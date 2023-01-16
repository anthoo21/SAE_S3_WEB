<?php


namespace services;

use PDOException;

class FicheMedocService
{
    
    /**
     * @param $pdo
     *  the pdo object used to connect to the database
     * @return $searchStmt
     *  to access to all medoc
     */
    public function requeteMedGeneral($pdo, $idMedoc) {
        $sql = "SELECT denomination, forme, voieAdmin, statutAdmin, typeProcedure, etatCommerc, dateAMM, statutBdm, numeroAutoUE, titulaire, surveillance
        FROM cis_bdpm
        WHERE idGeneral = :idGeneral";
        $requeteMedocGeneral = $pdo->prepare($sql);
        $requeteMedocGeneral->bindParam('idGeneral', $idMedoc);
        $requeteMedocGeneral->execute();
        return $requeteMedocGeneral;
    }
    
    public function requeteMedCIP($pdo, $idMedoc) {
        $sql = "SELECT libelle, dateDecla, agrement, tauxRemboursement, prix, droitRemboursement
        FROM cis_bdpm JOIN cis_cip_bdpm ON codeCis = codeCis_CIP
        WHERE idGeneral = :idGeneral";
        $requeteMedCIP = $pdo->prepare($sql);
        $requeteMedCIP->bindParam('idGeneral', $idMedoc);
        $requeteMedCIP->execute();
        return $requeteMedCIP;
    }

    public function requeteMedCOMPO($pdo, $idMedoc) {
        $sql = "SELECT denomSubstance, dosage, refDosage, natureCompo
        FROM cis_bdpm JOIN cis_compo_bdpm ON codeCis = codeCis_COMPO
        WHERE idGeneral = :idGeneral";
        $requeteMedCOMPO = $pdo->prepare($sql);
        $requeteMedCOMPO->bindParam('idGeneral', $idMedoc);
        $requeteMedCOMPO->execute();
        return $requeteMedCOMPO;
    }

    public function requeteMedASMR($pdo, $idMedoc) {
        $sql = "SELECT motifEval, dateAvis, valeurAsmr, libelle
        FROM cis_bdpm JOIN cis_has_asmr_bdpm ON codeCis = codeCis_HAS_ASMR
        WHERE idGeneral = :idGeneral";
        $requeteMedASMR = $pdo->prepare($sql);
        $requeteMedASMR->bindParam('idGeneral', $idMedoc);
        $requeteMedASMR->execute();
        return $requeteMedASMR;
    }

    public function requeteMedSMR($pdo, $idMedoc) {
        $sql = "SELECT motifEval, dateAvis, valeurSmr, libelle
        FROM cis_bdpm JOIN cis_has_smr_bdpm ON codeCis = codeCis_HAS_SMR
        WHERE idGeneral = :idGeneral";
        $requeteMedSMR = $pdo->prepare($sql);
        $requeteMedSMR->bindParam('idGeneral', $idMedoc);
        $requeteMedSMR->execute();
        return $requeteMedSMR;
    }

    public function requeteMedINFO($pdo, $idMedoc) {
        $sql = "SELECT dateDebut, dateFin, texteLien
        FROM cis_bdpm JOIN cis_infoimportantes_bdpm ON codeCis = codeCis_INFO
        WHERE idGeneral = :idGeneral";
        $requeteMedINFO = $pdo->prepare($sql);
        $requeteMedINFO->bindParam('idGeneral', $idMedoc);
        $requeteMedINFO->execute();
        return $requeteMedINFO;
    }

    private static $defaultService;

    /**
     * @return mixed
     *  the default instance of FicheMedocService used by controllers
     */
    public static function getDefaultService()
    {
        if (FicheMedocService::$defaultService == null) {
            FicheMedocService::$defaultService = new FicheMedocService();
        }
        return FicheMedocService::$defaultService;
    }
}