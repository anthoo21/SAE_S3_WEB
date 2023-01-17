<?php


namespace services;

use PDOException;

class OrdoPatientService
{

    public function getDonneesPatient($pdo, $idVisite) {
        $sql="SELECT patients.nom np, patients.prenom pp, patients.dateNai, patients.poids, 
			  patients.commentaires, visites.motif, visites.date_visite, medecins.nom nm,
			  medecins.prenom pm, visites.observations
			  FROM patients 
			  JOIN visites ON patients.numeroCarteVitale = visites.id_patient
			  JOIN genres ON patients.id_genre = genres.id_genre
			  JOIN medecins ON visites.id_medecin = medecins.id_med
			  WHERE visites.id_visite = :idVisite";
	    $getDonneesPatient = $pdo->prepare($sql);
		$getDonneesPatient->bindParam('idVisite', $idVisite);
		$getDonneesPatient->execute();
        return $getDonneesPatient;
    }

    public function getDonneesPrescri($pdo, $idVisite) {
        $sql="SELECT cis_bdpm.*, prescriptions.posologie
			  FROM cis_bdpm
			  JOIN prescriptions ON prescriptions.id_medicaments = cis_bdpm.codeCis
			  JOIN ordonnances ON ordonnances.id_ordo = prescriptions.id_ordonnance
			  JOIN visites ON visites.id_visite = ordonnances.id_visite
			  WHERE visites.id_visite = :idVisite";
        $getDonneesPrescri = $pdo->prepare($sql);
        $getDonneesPrescri->bindParam('idVisite', $idVisite);
        $getDonneesPrescri->execute();
        return $getDonneesPrescri;
    }

    /**
     * @param $pdo
     *  the pdo object used to connect to the database
     * @return $searchStmt
     *  to access to all patients
     */
    public function findAllPatients($pdo, $idMed) {
        $sql = "SELECT nom, prenom, sexe, tel, email, dateNai, numeroCarteVitale FROM patients P JOIN genres G ON P.id_genre = G.id_genre 
        WHERE P.id_medecin = :id";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('id', $idMed);
        $searchStmt->execute();
        return $searchStmt;
    }

    private static $defaultService;

    /**
     * @return mixed
     *  the default instance of ArticlesService used by controllers
     */
    public static function getDefaultService()
    {
        if (OrdoPatientService::$defaultService == null) {
            OrdoPatientService::$defaultService = new OrdoPatientService();
        }
        return OrdoPatientService::$defaultService;
    }

}
?>