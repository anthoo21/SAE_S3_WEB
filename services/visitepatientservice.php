<?php


namespace services;

use PDOException;

class VisitePatientService
{

    public function getVisiteData($pdo, $idVisite) {
        try {
            $sql="SELECT patients.nom np, patients.prenom pp, patients.dateNai, patients.poids, 
                    patients.commentaires, visites.motif, visites.date_visite, medecins.nom nm,
                    medecins.prenom pm, visites.observations, patients.numeroCarteVitale
                    FROM patients 
                    JOIN visites ON patients.numeroCarteVitale = visites.id_patient
                    JOIN genres ON patients.id_genre = genres.id_genre
                    JOIN medecins ON visites.id_medecin = medecins.id_med
                    WHERE visites.id_visite = :idVisite";
            $searchStmt = $pdo->prepare($sql);
            $searchStmt->bindParam('idVisite', $idVisite);
            $searchStmt->execute();
        } catch (PDOException $e) {
			echo $e->getMessage();
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
        if (VisitePatientService::$defaultService == null) {
            VisitePatientService::$defaultService = new VisitePatientService();
        }
        return VisitePatientService::$defaultService;
    }

}