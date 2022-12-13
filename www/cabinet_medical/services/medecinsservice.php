<?php


namespace services;

use PDOException;

class MedecinsService
{
    
    public function findAllPatients($pdo) {
        $sql = "SELECT nom, prenom, sexe, tel, email, dateNai, date_visite FROM patients P JOIN genres G ON P.id_genre = G.id_genre JOIN visites ON id_patient = numeroCarteVitale";
        $searchStmt = $pdo->prepare($sql);
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
        if (MedecinsService::$defaultService == null) {
            MedecinsService::$defaultService = new MedecinsService();
        }
        return MedecinsService::$defaultService;
    }
}