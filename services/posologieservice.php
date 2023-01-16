<?php

namespace services;

use PDOException;

class PosologieService
{

    public function insertPrescri($pdo, $idMedoc, $posologie) {
        $sql = "INSERT INTO prescriptionsTemp (id_medicaments, posologie) 
        VALUES (:idMedoc, :posologie)";
        $requeteInsert=$pdo->prepare($sql);
        $requeteInsert->bindParam('idMedoc', $idMedoc);
        $requeteInsert->bindParam('posologie', $posologie);
        $requeteInsert->execute();
        return $requeteInsert;
    }

    public function findAllMedoc($pdo) {
        $sql = "SELECT codeCis, idGeneral, denomination, forme, titulaire, libelle 
        FROM cis_bdpm LEFT JOIN cis_gener_bdpm ON codeCis = codeCis_GENER 
        WHERE idGeneral BETWEEN 1 AND 100 ORDER BY denomination ASC";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->execute();
        return $searchStmt;
    }

    public function findAllTypes($pdo) {
        $sql = "SELECT DISTINCT(forme) 
        FROM cis_bdpm ORDER BY forme ASC";
        $searchStmt2 = $pdo->prepare($sql);
        $searchStmt2->execute();
        return $searchStmt2;
    }

    public function recupInfoPatient($pdo, $idP) {
        $sql = "SELECT patients.nom, patients.prenom, patients.numeroCarteVitale, patients.dateNai, patients.poids
        FROM patients 
        WHERE patients.numeroCarteVitale = :id";
        $requeteInfoPatient = $pdo->prepare($sql);
        $requeteInfoPatient->bindParam('id', $idP);
        $requeteInfoPatient->execute();
        return $requeteInfoPatient;
    }

    public function requeteOrdo($pdo) {
        $sql = "SELECT C.denomination, P.posologie, P.id_medicaments
        FROM cis_bdpm C JOIN prescriptionsTemp P ON C.codeCis = P.id_medicaments";
        $requeteOrdo = $pdo->prepare($sql);
        $requeteOrdo->execute();
        return $requeteOrdo;
    }

    private static $defaultService;

    /**
     * @return mixed
     *  the default instance of PosologieService used by controllers
     */
    public static function getDefaultService()
    {
        if (PosologieService::$defaultService == null) {
            PosologieService::$defaultService = new PosologieService();
        }
        return PosologieService::$defaultService;
    }
}