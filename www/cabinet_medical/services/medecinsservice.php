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
    public function findAllPatients($pdo) {
        $sql = "SELECT nom, prenom, sexe, tel, email, dateNai, date_visite FROM patients P JOIN genres G ON P.id_genre = G.id_genre JOIN visites ON id_patient = numeroCarteVitale";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->execute();
        return $searchStmt;
    }

    /**
     * @param $pdo $Rnom $Rsecu
     *  the pdo object used to connect to the database, nom and secu are used to find the correct patients
     * @return $searchStmt
     *  to access to all categories
     */
    public function findSelectedPatients($pdo, $Rnom, $Rsecu) {
        $searchStmt = null;
        if((isset($Rnom) && $Rnom != "" ) || (isset($Rsecu) && $Rsecu != "")) {
            $sql="";
            $nom = "%".$Rnom."%";
            $nsecu = "%".$Rsecu."%";
            if(isset($Rnom) && $Rnom != "" && isset($Rsecu) && $Rsecu != "") {
                $sql="WHERE nom LIKE '".$nom."' AND numeroCarteVitale LIKE '".$nsecu."'";
            } else if(isset($Rnom) && $Rnom != "") {
                $sql="WHERE nom LIKE '".$nom."'";
            } else if (isset($Rsecu) && $Rsecu != "") {
                $sql="WHERE numeroCarteVitale LIKE '".$nsecu."'";
            }
            $searchStmt = $pdo->prepare("SELECT nom, prenom, sexe, tel, email, dateNai, date_visite FROM patients P JOIN genres G ON P.id_genre = G.id_genre JOIN visites ON id_patient = numeroCarteVitale ".$sql);
            $searchStmt->bindParam('nom', $Rnom);
            $searchStmt->bindParam('nsecu', $Rsecu);
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