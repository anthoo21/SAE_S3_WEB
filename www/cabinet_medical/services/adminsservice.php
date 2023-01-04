<?php


namespace services;

use PDOException;

class AdminsService
{

    /**
     * @param $pdo
     *  the pdo object used to connect to the database
     * @return $searchStmt
     *  to access to all cabinets names
     */
    public function findAllCabinets($pdo) {
        $sql = "SELECT nom_cabinet, adresse FROM cabinet";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->execute();
        return $searchStmt;
    }

    /**
     * @param $pdo
     *  the pdo object used to connect to the database
     * @return $searchStmt
     *  to access to all medecins
     */
    public function findAllMedecins($pdo) {
        $sql = "SELECT * FROM medecins JOIN utilisateurs ON id_util = identifiant";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->execute();
        return $searchStmt;
    }

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


    private static $defaultService;

    /**
     * @return mixed
     * the default instance of AdminsService used by controllers
     */
    public static function getDefaultService() {
        if (AdminsService::$defaultService == null) {
            AdminsService::$defaultService = new AdminsService();
        }
        return AdminsService::$defaultService;
    }
}