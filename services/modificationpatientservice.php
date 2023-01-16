<?php


namespace services;

use PDOException;

class ModificationPatientService
{

    public function getDataPatient($pdo, $idPatient) {
        try {
            $sql="SELECT patients.nom, patients.prenom, patients.numeroCarteVitale, genres.sexe, patients.adresse, patients.tel,
                patients.email, patients.dateNai, patients.poids, patients.allergies, patients.commentaires, medecins.nom nomMedecin, medecins.prenom prenomMedecin
                FROM patients JOIN medecins ON id_medecin = id_med JOIN genres ON patients.id_genre = genres.id_genre
                WHERE patients.numeroCarteVitale = :id";
                $searchStmt = $pdo->prepare($sql);
                $searchStmt->bindParam('id', $idPatient);
                $searchStmt->execute();
        } catch (PDOException $e) {
			echo $e->getMessage();
		}
        return $searchStmt;
    }

    public function updatePatient($pdo, $nom, $prenom, $genre, $adresse, $portable, $mail, $poids, $date, $allergies, $commentaires, $idPatient) {
        try {
            $requete="UPDATE patients 
                    SET nom = ?, prenom = ?, id_genre = ?, adresse = ?, tel = ?, email = ?, dateNai = ?, poids = ?, allergies = ?, commentaires = ?
                    WHERE numeroCarteVitale = ?";
            $stmt = $pdo->prepare($requete);
            $stmt->execute([$nom, $prenom, $genre, $adresse, $portable, $mail, $date, $poids, $allergies, $commentaires, $idPatient]);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private static $defaultService;

    /**
     * @return mixed
     *  the default instance of ArticlesService used by controllers
     */
    public static function getDefaultService()
    {
        if (ModificationPatientService::$defaultService == null) {
            ModificationPatientService::$defaultService = new ModificationPatientService();
        }
        return ModificationPatientService::$defaultService;
    }

}