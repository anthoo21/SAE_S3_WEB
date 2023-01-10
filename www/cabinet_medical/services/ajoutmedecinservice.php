<?php


namespace services;

use PDOException;

class AjoutMedecinService
{

    public static function addMedecin($pdo, $nom, $prenom, $adresse, $date, $portable, $mail, $identifiant, $motDePasse, $role) {
        try {
            $pdo->beginTransaction(); // N'exécute pas si problème dans une des deux insersions

            $requete = "INSERT INTO utilisateurs (identifiant, motDePasse, code_role) VALUES (?, ?, ?);";
            $stmt = $pdo->prepare($requete);
            $stmt->execute([$identifiant, $motDePasse, $role]);

            $requete2 = "INSERT INTO medecins (nom, prenom, dateNai, adresse, tel, email, id_util) VALUES (?, ?, ?, ?, ?, ?, ?);";
            $stmt2 = $pdo->prepare($requete2);
            $stmt2->execute([$nom, $prenom, $date, $adresse, $portable, $mail, $identifiant]);

            $pdo->commit();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
            $pdo->rollBack();
        }
    }


    private static $defaultService;

    /**
    * @return mixed
    *  the default instance of ArticlesService used by controllers
    */
    public static function getDefaultService()
    {
        if (AjoutMedecinService::$defaultService == null) {
            AjoutMedecinService::$defaultService = new AjoutMedecinService();
        }
        return AjoutMedecinService::$defaultService;
    }
}