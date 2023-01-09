<?php


namespace services;

use PDOException;

class AjoutMedecinService
{

    public function addMedecin($pdo, $nom, $prenom, $adresse, $date, $portable, $mail, $identifiant, $motDePasse) {
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
            $erreur = $e->getMessage();
            $pdo->rollBack();
        }
    }




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