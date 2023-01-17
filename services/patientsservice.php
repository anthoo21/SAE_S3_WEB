<?php


namespace services;

use PDOException;

class PatientsService 
{
    
    /**
     * @param $pdo $(all the parameters to insert in the db)
     *  the pdo object used to connect to the database, the parameters are inserted in the db to create a new patient
     * @return $
     */
    public static function addPatient($pdo, $nom, $prenom, $genre, $adresse, $portable, $mail, $poids, $date, $noCV, $allergies, $commentaires, $medecin) {
        try {
            //Transaction pour éviter une insertion d'un patient déjà existant
            $pdo->beginTransaction();
            $sql="INSERT INTO patients (numeroCarteVitale, nom, prenom, id_genre, adresse, tel, email, dateNai, poids, id_medecin, allergies, commentaires)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$noCV, $nom, $prenom, $genre, $adresse, $portable, $mail, $date, $poids, $medecin, $allergies, $commentaires]);
            $pdo->commit();
        } catch (PDOException $e) {
            $erreur = $e->getMessage();
            $pdo->rollBack();
        }
        
    }


    private static $defaultService;

    /**
     * @return mixed
     *  the default instance of PatientsService used by controllers
     */
    public static function getDefaultService()
    {
        if (PatientsService::$defaultService == null) {
            PatientsService::$defaultService = new PatientsService();
        }
        return PatientsService::$defaultService;
    }
}