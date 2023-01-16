<?php


namespace services;

use PDOException;

class MedecinsService
{
    
    /**
     * @param $pdo
     *  the pdo object used to connect to the database
     * @return $searchStmt
     *  to access to all patients
     */
    public function findAllPatients($pdo, $idMed) {
        $sql = "SELECT nom, prenom, sexe, tel, email, dateNai, date_visite FROM patients P JOIN genres G ON P.id_genre = G.id_genre JOIN visites ON id_patient = numeroCarteVitale 
        WHERE P.id_medecin = :id";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('id', $idMed);
        $searchStmt->execute();
        return $searchStmt;
    }

    /**
     * @param $pdo $Rnom $Rsecu
     *  the pdo object used to connect to the database, nom and secu are used to find the correct patients
     * @return $searchStmt
     *  to access to all categories
     */
    public function findSelectedPatients($pdo, $idMed, $Rnom, $Rsecu) {
        $searchStmt = null;
        if((isset($Rnom) && $Rnom != "" ) || (isset($Rsecu) && $Rsecu != "")) {
            $sql="WHERE P.id_medecin = :id ";
            $nom = "%".$Rnom."%";
            $secu = "%".$Rsecu."%";
            if(isset($Rnom) && $Rnom != "" && isset($Rsecu) && $Rsecu != "") {
                $sql="AND nom LIKE '".$nom."' AND numeroCarteVitale LIKE '".$secu."'";
            } else if(isset($Rnom) && $Rnom != "") {
                $sql="AND nom LIKE '".$nom."'";
            } else if (isset($Rsecu) && $Rsecu != "") {
                $sql="AND numeroCarteVitale LIKE '".$secu."'";
            }
            $searchStmt = $pdo->prepare("SELECT nom, prenom, sexe, tel, email, dateNai, date_visite FROM patients P JOIN genres G ON P.id_genre = G.id_genre JOIN visites ON id_patient = numeroCarteVitale ".$sql);
            $searchStmt->bindParam('id', $idMed);
            $searchStmt->bindParam('nom', $nom);
            $searchStmt->bindParam('secu', $secu);
            $searchStmt->execute();
        }
        return $searchStmt;
    }

    private static $defaultService;

    /**
     * @return mixed
     *  the default instance of ArticlesService used by controllers
     */
    public static function getDefaultService()
    {
        if (MedecinsService::$defaultService == null) {
            MedecinsService::$defaultService = new MedecinsService();
        }
        return MedecinsService::$defaultService;
    }
}