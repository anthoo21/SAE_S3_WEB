<?php


namespace services;

use PDOException;

class VisiteService
{

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

    public function rechercheCritere($pdo, $designation, $type, $generiques) {
        $requete = "";
        if($designation != "") {
            $medicament = "%".$designation."%";
            $un = "WHERE denomination like :medicamentDes";
            $requete = $requete.$un;
            if($type != 'TOUS') {
                $deux = ' AND forme = "'.$type.'"';
                $requete = $requete.$deux;
            }
            if($generiques) {
                if($generiques == "Oui") {
                    $quatre = ' AND libelle IS NOT NULL';
                    $requete = $requete.$quatre;
                } else if($generiques == "Non") {
                    $quatre = ' AND libelle IS NULL';
                    $requete = $requete.$quatre;
                } 
            }
        } else if ($type != 'TOUS') {
            $deux = 'WHERE forme = "'.$type.'"';
            $requete = $requete.$deux;
            if($generiques) {
                if($generiques == "Oui") {
                    $quatre = ' AND libelle IS NOT NULL';
                    $requete = $requete.$quatre;
                } else if($generiques == "Non") {
                    $quatre = ' AND libelle IS NULL';
                    $requete = $requete.$quatre;
                } 
            }
        } else if($generiques) {
            if($generiques == "Oui") {
                $quatre = 'WHERE libelle IS NOT NULL';
                $requete = $requete.$quatre;
            } else if($generiques == "Non") {
                $quatre = ' WHERE libelle IS NULL';
                $requete = $requete.$quatre;
            } 
        }
        $sql = "SELECT codeCis, idGeneral, denomination, forme, titulaire, libelle 
        FROM cis_bdpm LEFT JOIN cis_gener_bdpm ON codeCis = codeCis_GENER 
        ".$requete." ORDER BY denomination ASC";
        $rechercheCritere = $pdo->prepare($sql);
        $rechercheCritere->bindParam("medicamentDes", $medicament);
        $rechercheCritere->execute();
        return $rechercheCritere;
    }

    public function requeteOrdo($pdo) {
        $sql = "SELECT C.denomination, P.posologie, P.id_medicaments
        FROM cis_bdpm C JOIN prescriptionsTemp P ON C.codeCis = P.id_medicaments";
        $requeteOrdo = $pdo->prepare($sql);
        $requeteOrdo->bindParam("medicamentDes", $medicament);
        $requeteOrdo->execute();
        return $requeteOrdo;
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

    private static $defaultService;

    /**
     * @return mixed
     *  the default instance of VisiteService used by controllers
     */
    public static function getDefaultService()
    {
        if (VisiteService::$defaultService == null) {
            VisiteService::$defaultService = new VisiteService();
        }
        return VisiteService::$defaultService;
    }
}