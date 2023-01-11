<?php


namespace services;

use PDOException;

class LoginService {

    public static function getUser($pdo, $login, $password) {
        $sql = "SELECT * FROM utilisateurs WHERE identifiant = ? AND motDePasse = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$login, $password]);
        return $stmt;
    }

    public static function getMedecinInfo($pdo, $login, $password) {
        $sql = "SELECT medecins.id_med, medecins.nom, medecins.prenom, utilisateurs.code_role FROM utilisateurs JOIN medecins ON identifiant = id_util WHERE identifiant = :log AND motDePasse = :mdp";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':log', $login);
        $stmt->bindParam(':mdp', $password);
        $stmt->execute();
        return $stmt;
    }
    private static $defaultService;

    /**
     * @return mixed
     *  the default instance of PatientsService used by controllers
     */
    public static function getDefaultService()
    {
        if (LoginService::$defaultService == null) {
            LoginService::$defaultService = new LoginService();
        }
        return LoginService::$defaultService;
    }

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

    /**
     * @param $pdo
     * the pdo object used to connect to the database
     * @param $idMed
     * Id of the selected doctor
     * @return $searchStmt
     * to get the info of the selected doctor
     */
    public function getInfoDoctor($pdo, $idMed) {
        $sql = "SELECT medecins.*, utilisateurs.identifiant, utilisateurs.motDePasse
        FROM medecins
        JOIN utilisateurs ON id_util = identifiant
        WHERE id_med = :id";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('id', $idMed);
        $searchStmt->execute();
        return $searchStmt;
    }
}