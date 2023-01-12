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

}