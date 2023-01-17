<?php


namespace services;

use PDOException;

class SuppressionPatientService
{

    public function findPatientData($pdo, $noCV) {
        // Récupération du nom et prénom du patient
		try {
			$sql="SELECT patients.nom, patients.prenom
			FROM patients
			WHERE patients.numeroCarteVitale = :id";
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam('id', $noCV);
			$stmt->execute();
        } catch (PDOException $e) {
			echo $e->getMessage();
		}
        return $stmt;
    }


    private static $defaultService;

    /**
     * @return mixed
     *  the default instance of ArticlesService used by controllers
     */
    public static function getDefaultService()
    {
        if (SuppressionPatientService::$defaultService == null) {
            SuppressionPatientService::$defaultService = new SuppressionPatientService();
        }
        return SuppressionPatientService::$defaultService;
    }

}