<?php


namespace services;

use PDOException;

class VisiteService
{

    public function findAllMedoc($pdo) {
        $sql = "SELECT codeCis, idGeneral, denomination, forme, titulaire, libelle 
        FROM cis_bdpm LEFT JOIN cis_gener_bdpm ON codeCis = codeCis_GENER 
        WHERE idGeneral BETWEEN 1 AND 100 ORDER BY denomination ASC";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->execute();
        return $searchStmt;
    }

    public function findAllTypes($pdo) {
        $sql = "SELECT DISTINCT(forme) 
        FROM cis_bdpm ORDER BY forme ASC";
        $searchStmt2 = $pdo->prepare($sql);
        $searchStmt2->execute();
        return $searchStmt2;
    }

    public function rechercheCritere($pdo, $designation, $type, $generiques) {
        $requete = "";
        if($designation != "") {
            $medicament = "%".$designation."%";
            $un = "WHERE denomination like :medicamentDes";
            $requete = $requete.$un;
            if($type != 'TOUS') {
                $deux = ' AND forme = "'.$type.'"';
                $requete = $requete.$deux;
            }
            if($generiques) {
                if($generiques == "Oui") {
                    $quatre = ' AND libelle IS NOT NULL';
                    $requete = $requete.$quatre;
                } else if($generiques == "Non") {
                    $quatre = ' AND libelle IS NULL';
                    $requete = $requete.$quatre;
                } 
            }
        } else if ($type != 'TOUS') {
            $deux = 'WHERE forme = "'.$type.'"';
            $requete = $requete.$deux;
            if($generiques) {
                if($generiques == "Oui") {
                    $quatre = ' AND libelle IS NOT NULL';
                    $requete = $requete.$quatre;
                } else if($generiques == "Non") {
                    $quatre = ' AND libelle IS NULL';
                    $requete = $requete.$quatre;
                } 
            }
        } else if($generiques) {
            if($generiques == "Oui") {
                $quatre = 'WHERE libelle IS NOT NULL';
                $requete = $requete.$quatre;
            } else if($generiques == "Non") {
                $quatre = ' WHERE libelle IS NULL';
                $requete = $requete.$quatre;
            } 
        }
        $sql = "SELECT codeCis, idGeneral, denomination, forme, titulaire, libelle 
        FROM cis_bdpm LEFT JOIN cis_gener_bdpm ON codeCis = codeCis_GENER 
        ".$requete." ORDER BY denomination ASC";
        $rechercheCritere = $pdo->prepare($sql);
        $rechercheCritere->bindParam("medicamentDes", $medicament);
        $rechercheCritere->execute();
        return $rechercheCritere;
    }

    public function requeteOrdo($pdo) {
        $sql = "SELECT C.denomination, P.posologie, P.id_medicaments
        FROM cis_bdpm C JOIN prescriptionsTemp P ON C.codeCis = P.id_medicaments";
        $requeteOrdo = $pdo->prepare($sql);
        $requeteOrdo->execute();
        return $requeteOrdo;
    }

    public function recupInfoPatient($pdo, $idP) {
        $sql = "SELECT patients.nom, patients.prenom, patients.numeroCarteVitale, patients.dateNai, patients.poids
        FROM patients 
        WHERE patients.numeroCarteVitale = :id";
        $requeteInfoPatient = $pdo->prepare($sql);
        $requeteInfoPatient->bindParam('id', $idP);
        $requeteInfoPatient->execute();
        return $requeteInfoPatient;
    }

    public function supprMedoc($pdo, $idMed) {
        $sql="DELETE FROM prescriptionsTemp
        WHERE id_medicaments = :idMed";
        $supprMedoc = $pdo->prepare($sql);
        $supprMedoc->bindParam('idMed',$idMed);
        $supprMedoc->execute();
        return $supprMedoc;
    }

    public function insertInVisite($pdo, $dateVisite, $idP, $idMedecin, $motif, $observation) {
        $sql="INSERT INTO visites (date_visite, id_patient, id_medecin, motif, observations)
				  VALUES (:dateVisite, :idP, :idMedecin, :motif, :observation);";
        $insertInVisite = $pdo->prepare($sql);
        $insertInVisite->bindParam('dateVisite', $dateVisite);
        $insertInVisite->bindParam('idP', $idP);
        $insertInVisite->bindParam('idMedecin', $idMedecin);
        $insertInVisite->bindParam('motif', $motif);
        $insertInVisite->bindParam('observation', $observation);
        $insertInVisite->execute();
        return $insertInVisite;
    }

    public function insertInOrdo($pdo) {
        $sql = "INSERT INTO ordonnances (id_visite) VALUES (:idVisite)";
        $reqMaxVis = "SELECT MAX(id_visite) FROM visites";
        $result=$pdo->query($reqMaxVis);
        $result = $result->fetchColumn();
        $insertInOrdo=$pdo->prepare($sql);
        $insertInOrdo->bindParam('idVisite', $result);
        $insertInOrdo->execute();
        return $insertInOrdo;
    }

    public function insertInPrescri($pdo) {
        $reqMaxOrdo="SELECT MAX(id_ordo) FROM ordonnances";
        $resultOrdo=$pdo->query($reqMaxOrdo);
        $resultOrdo = $resultOrdo->fetchColumn();
        $selectPrescri="SELECT * FROM prescriptionstemp";
        $result = $pdo->query($selectPrescri);
        while($ligne = $result->fetch()) {
            $sql = "INSERT INTO prescriptions (id_ordonnance, id_medicaments, posologie) VALUES(:idOrdo, :idMedoc, :posologie)";
            $insertInPrescri=$pdo->prepare($sql);
            $insertInPrescri->bindParam('idOrdo', $resultOrdo);
            $insertInPrescri->bindParam('idMedoc', $ligne['id_medicaments']);
            $insertInPrescri->bindParam('posologie', $ligne['posologie']);
            $insertInPrescri->execute();
            return $insertInPrescri;
        }
    }

    public function deletePrescriTemp($pdo) {
        $sql = "DELETE FROM prescriptionsTemp";
        $deletePrescriTemp=$pdo->prepare($sql);
        $deletePrescriTemp->execute();
        return $deletePrescriTemp;
    }

    public function searchPatientsAccueil($pdo, $idMed) {
        $sql = "SELECT nom, prenom, sexe, tel, email, dateNai, date_visite, numeroCarteVitale FROM patients P JOIN genres G ON P.id_genre = G.id_genre JOIN visites ON id_patient = numeroCarteVitale 
        WHERE P.id_medecin = :id";
        $searchPatients = $pdo->prepare($sql);
        $searchPatients->bindParam('id', $idMed);
        $searchPatients->execute();
        return $searchPatients;
    }

    private static $defaultService;

    /**
     * @return mixed
     *  the default instance of VisiteService used by controllers
     */
    public static function getDefaultService()
    {
        if (VisiteService::$defaultService == null) {
            VisiteService::$defaultService = new VisiteService();
        }
        return VisiteService::$defaultService;
    }
}