<?php


namespace services;

use PDOException;

class AdminsService
{

    /**
     * @param $pdo
     *  the pdo object used to connect to the database
     * @return $searchStmt
     *  to access to all cabinets names
     */
    public function findAllCabinets($pdo) {
        $sql = "SELECT nom_cabinet, adresse FROM cabinet";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->execute();
        return $searchStmt;
    }

    /**
     * @param $pdo
     *  the pdo object used to connect to the database
     * @return $searchStmt
     *  to access to all medecins
     */
    public function findAllMedecins($pdo) {
        $sql = "SELECT * FROM medecins JOIN utilisateurs ON id_util = identifiant";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->execute();
        return $searchStmt;
    }

    /**
     * @param $pdo
     *  the pdo object used to connect to the database
     * @return $searchStmt
     *  to access to all patients
     */
    public function findAllPatients($pdo) {
        $sql = "SELECT nom, prenom, sexe, tel, email, dateNai, date_visite FROM patients P JOIN genres G ON P.id_genre = G.id_genre JOIN visites ON id_patient = numeroCarteVitale";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->execute();
        return $searchStmt;
    }

    /**
     * @param $pdo
     * the pdo object used to connect to the database
     * @param $idMed
     * Id of the selected doctor
     * @return $searchStmt
     * to get the info of the selected doctor
     */
    public function getInfoDoctor($pdo, $idMed) {
        $sql = "SELECT medecins.*, utilisateurs.identifiant, utilisateurs.motDePasse
        FROM medecins
        JOIN utilisateurs ON id_util = identifiant
        WHERE id_med = :id";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('id', $idMed);
        $searchStmt->execute();
        return $searchStmt;
    }

    public function insertCisBpdm($pdo, $codeCis, $denom, $forme, $voie, $statut, $typeProced, $etatCommerc, $dateAMM, $statutBdm, $numeroAutoEU, $titulaire, $surveillance) {
        $codeCis1 = iconv(mb_detect_encoding($codeCis, mb_detect_order(), true), "UTF-8", $tab[0]);
        $denom1 = iconv(mb_detect_encoding($denom, mb_detect_order(), true), "UTF-8", $denom);
        $forme1 = iconv(mb_detect_encoding($forme, mb_detect_order(), true), "UTF-8", $forme);
        $voie1 = iconv(mb_detect_encoding($voie, mb_detect_order(), true), "UTF-8", $voie);
        $statut1 = iconv(mb_detect_encoding($statut, mb_detect_order(), true), "UTF-8", $statut);
        $typeProced1 = iconv(mb_detect_encoding($typeProced, mb_detect_order(), true), "UTF-8", $typeProced);
        $etatCommerc1 = iconv(mb_detect_encoding($etatCommerc, mb_detect_order(), true), "UTF-8", $etatCommerc);
        $dateAMM1 = iconv(mb_detect_encoding($dateAMM, mb_detect_order(), true), "UTF-8", $dateAMM);
        $statutBdm1 = iconv(mb_detect_encoding($statutBdm, mb_detect_order(), true), "UTF-8", $statutBdm);
        $numeroAutoUE1 = iconv(mb_detect_encoding($numeroAutoEU, mb_detect_order(), true), "UTF-8", $numeroAutoEU);
        $titulaire1 = iconv(mb_detect_encoding($titulaire, mb_detect_order(), true), "UTF-8", $titulaire);
        $surveillance1 = iconv(mb_detect_encoding($surveillance, mb_detect_order(), true), "UTF-8", $surveillance);
        $sql = "INSERT INTO CIS_bdpm (codeCis, denomination, forme, voieAdmin, statutAdmin, typeProcedure, etatCommerc, dateAMM, statutBdm, numeroAutoUE, titulaire, surveillance)
        VALUES (:codeCis , :denom, :forme, :voie, :statut, :typeProced, :etatCommerc, :dateAMM, :statutBdm, :numeroAutoUE, :titulaire, :surveillance)";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->bindParam('codeCis', $codeCis1);
        $searchStmt->bindParam('denom', $denom1);
        $searchStmt->bindParam('forme', $forme1);
        $searchStmt->bindParam('voie', $voie1);
        $searchStmt->bindParam('statut', $statut1);
        $searchStmt->bindParam('typeProced', $typeProced1);
        $searchStmt->bindParam('etatCommerc', $etatCommerc1);
        $searchStmt->bindParam('dateAMM', $dateAMM1);
        $searchStmt->bindParam('statutBdm', $statutBdm1);
        $searchStmt->bindParam('numeroAutoUE', $numeroAutoUE1);
        $searchStmt->bindParam('titulaire', $titulaire1);
        $searchStmt->bindParam('surveillance', $surveillance1);
        $searchStmt->execute();
        return $searchStmt;
    }


    private static $defaultService;

    /**
     * @return mixed
     * the default instance of AdminsService used by controllers
     */
    public static function getDefaultService() {
        if (AdminsService::$defaultService == null) {
            AdminsService::$defaultService = new AdminsService();
        }
        return AdminsService::$defaultService;
    }
}