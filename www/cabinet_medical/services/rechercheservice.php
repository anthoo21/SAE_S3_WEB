<?php


namespace services;

use PDOException;

class RechercheService
{
    
    /**
     * @param $pdo
     *  the pdo object used to connect to the database
     * @return $searchStmt
     *  to access to all medoc
     */
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

    private static $defaultService;

    /**
     * @return mixed
     *  the default instance of RechercheService used by controllers
     */
    public static function getDefaultService()
    {
        if (RechercheService::$defaultService == null) {
            RechercheService::$defaultService = new RechercheService();
        }
        return RechercheService::$defaultService;
    }
}