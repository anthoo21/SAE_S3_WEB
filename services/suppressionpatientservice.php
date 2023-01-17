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

    public function supprFromPrescri($pdo, $noCV) {
        $sql='DELETE FROM prescriptions WHERE id_ordonnance IN(
              SELECT id_ordo FROM ordonnances
              WHERE id_visite IN (
              SELECT id_visite FROM visites
              WHERE id_patient IN (
        	  SELECT numeroCarteVitale FROM patients
              WHERE numeroCarteVitale = :id)))';
        $supprFromPrescri = $pdo->prepare($sql);
        $supprFromPrescri->bindParam('id', $noCV);
        $supprFromPrescri->execute();
        return $supprFromPrescri;
    }

    public function supprFromOrdo($pdo, $noCV) {
        $sql='DELETE FROM ordonnances WHERE id_visite IN(
              SELECT id_visite FROM visites
              WHERE id_patient IN (
              SELECT numeroCarteVitale FROM patients
              WHERE numeroCarteVitale = :id))';
        $supprFromOrdo = $pdo->prepare($sql);
        $supprFromOrdo->bindParam('id', $noCV);
        $supprFromOrdo->execute();
        return $supprFromOrdo;
    }

    public function supprFromVisite($pdo, $noCV) {
        $sql='DELETE FROM visites WHERE id_patient IN (
              SELECT numeroCarteVitale FROM patients
              WHERE numeroCarteVitale = :id)';
        $supprFromVisite = $pdo->prepare($sql);
        $supprFromVisite->bindParam('id', $noCV);
        $supprFromVisite->execute();
        return $supprFromVisite;
    }

    public function supprPatient($pdo, $noCV) {
        $sql='DELETE FROM patients WHERE numeroCarteVitale = :id';
		$supprPatient = $pdo->prepare($sql);
        $supprPatient->bindParam('id', $noCV);
        $supprPatient->execute();
        return $supprPatient; 		
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