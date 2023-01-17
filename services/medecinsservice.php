<?php


namespace services;

use PDOException;

class MedecinsService
{
    
    /**
     * @param $pdo
     *  the pdo object used to connect to the database
     * @return $searchStmt
     *  to access to all patients
     */
    public function findAllPatients($pdo, $idMed) {
        $sql = "SELECT DISTINCT nom, prenom, sexe, tel, email, dateNai, date_visite, numeroCarteVitale FROM patients P JOIN genres G ON P.id_genre = G.id_genre JOIN visites ON id_patient = numeroCarteVitale 
        WHERE P.id_medecin = :id";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('id', $idMed);
        $searchStmt->execute();
        return $searchStmt;
    }

    /**
     * @param $pdo $Rnom $Rsecu
     *  the pdo object used to connect to the database, nom and secu are used to find the correct patients
     * @return $searchStmt
     *  to access to all categories
     */
    public function findSelectedPatients($pdo, $idMed, $Rnom, $Rsecu) {
        $searchStmt = null;
        if((isset($Rnom) && $Rnom != "" ) || (isset($Rsecu) && $Rsecu != "")) {
            $sql="WHERE P.id_medecin = :id ";
            $nom = "%".$Rnom."%";
            $secu = "%".$Rsecu."%";
            if(isset($Rnom) && $Rnom != "" && isset($Rsecu) && $Rsecu != "") {
                $sql="AND nom LIKE '".$nom."' AND numeroCarteVitale LIKE '".$secu."'";
            } else if(isset($Rnom) && $Rnom != "") {
                $sql="AND nom LIKE '".$nom."'";
            } else if (isset($Rsecu) && $Rsecu != "") {
                $sql="AND numeroCarteVitale LIKE '".$secu."'";
            }
            $searchStmt = $pdo->prepare("SELECT nom, prenom, sexe, tel, email, dateNai, date_visite, numeroCarteVitale FROM patients P JOIN genres G ON P.id_genre = G.id_genre JOIN visites ON id_patient = numeroCarteVitale ".$sql);
            $searchStmt->bindParam('id', $idMed);
            $searchStmt->bindParam('nom', $nom);
            $searchStmt->bindParam('secu', $secu);
            $searchStmt->execute();
        }
        return $searchStmt;
    }

    public function findPatientFile($pdo, $numSecu) {
        try {
            $sql="SELECT patients.nom, patients.prenom, patients.numeroCarteVitale, genres.sexe, patients.adresse, patients.tel,
                patients.email, patients.dateNai, patients.poids, patients.allergies, patients.commentaires, medecins.nom nomMedecin, medecins.prenom prenomMedecin
                FROM patients JOIN medecins ON id_medecin = id_med JOIN genres ON patients.id_genre = genres.id_genre
                WHERE patients.numeroCarteVitale = :id";
            $searchStmt = $pdo->prepare($sql);
            $searchStmt->bindParam('id', $numSecu);
            $searchStmt->execute();
        } catch (PDOException $e) {
			echo $e->getMessage();
		}
        return $searchStmt;
    }

    public function findPatientVisit($pdo, $numSecu) {
        try {
            $sql = "SELECT visites.id_visite, visites.date_visite, medecins.nom, medecins.prenom, visites.motif, ordonnances.id_ordo
            FROM visites 
            JOIN ordonnances ON visites.id_visite = ordonnances.id_visite 
            JOIN patients ON numeroCarteVitale = id_patient
            JOIN medecins ON visites.id_medecin = medecins.id_med 
            WHERE id_patient = :patient
            ORDER BY visites.date_visite";
            $searchStmt = $pdo->prepare($sql);
            $searchStmt->bindParam('patient', $numSecu);
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
        if (MedecinsService::$defaultService == null) {
            MedecinsService::$defaultService = new MedecinsService();
        }
        return MedecinsService::$defaultService;
    }
}