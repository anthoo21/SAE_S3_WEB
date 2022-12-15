<?php


namespace services;

use PDOException;

class PatientsService 
{
    
    /**
     * @param $pdo $(all the parameters to insert in the db)
     *  the pdo object used to connect to the database, the parameters are inserted in the db to create a new patient
     * @return $
     *  to access to all categories
     */
    public static function addPatient($pdo, $nom, $prenom, $genre, $adresse, $portable, $mail, $poids, $noCV, $allergies, $commentaires, $medecin) {
        try {
            $sql = "INSERT INTO patients(numeroCarteVitale, nom, prenom, id_genre, tel, email, dateNai, poids, id_medecin, allergies, commentaires) 
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $insertStmt = $pdo->prepare($sql);
            $insertStmt->execute([$noCV, $nom, $prenom]) //Completer
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