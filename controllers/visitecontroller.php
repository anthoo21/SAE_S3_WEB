<?php
namespace controllers;

session_start();
use services\VisiteService;
use yasmf\HttpHelper;
use yasmf\View;

class VisiteController {

    private $visiteService;

    /**
     * Create and initialize an AdminsController object
     */
    public function __construct() {

        $this->visiteService = VisiteService::getDefaultService();
    }

    /**
     * @param $pdo
     *  the pdo object used to connect to the database
     * @return View
     *  the view in charge of displaying the admin interface
     */
    public function index($pdo) {

        // Test si on est bien connecté (session existante et bon numéro de session
        if (!isset($_SESSION['login']) || !isset($_SESSION['id']) || $_SESSION['id']!=session_id()) {
            // Renvoi vers la page de connexion
            $view = new View('SAE_S3_WEB/views/accueil');
            return $view;
            exit();
        }
        $idP = HttpHelper::getParam('idP');
        $dateVisite = HttpHelper::getParam('dateVisite');
        $motif = HttpHelper::getParam('motif');
        $observation = HttpHelper::getParam('observation');
        $ToutOK=false;
        $searchStmt = $this->visiteService->findAllMedoc($pdo);
        $searchStmt2 = $this->visiteService->findAllTypes($pdo);
        $requeteInfoPatient = $this->visiteService->recupInfoPatient($pdo, $idP);
        $requeteOrdo = $this->visiteService->requeteOrdo($pdo);
        $view = new View('SAE_S3_WEB/views/creationVisite');
        $view->setVar('searchStmt', $searchStmt);
        $view->setVar('searchStmt2', $searchStmt2);
        $view->setVar('requeteInfoPatient', $requeteInfoPatient);
        $view->setVar('requeteOrdo', $requeteOrdo);
        $view->setVar('idP', $idP);
        $view->setVar('dateVisite', $dateVisite);
        $view->setVar('motif', $motif);
        $view->setVar('observation', $observation);
        $view->setVar('ToutOK', $ToutOK);
        $view->setVar('idMedecin', $_SESSION['idMed']);
        return $view;
    }

    public function rechercheCritere($pdo) {
        $designation = HttpHelper::getParam('designation');
        $type = HttpHelper::getParam('Type');
        $generiques = HttpHelper::getParam('generiques');
        $idP = HttpHelper::getParam('idP');
        $dateVisite = HttpHelper::getParam('dateVisite');
        $motif = HttpHelper::getParam('motif');
        $observation = HttpHelper::getParam('observation');
        $ToutOK=false;
        if((isset($designation) && $designation != "") || (isset($type) && $type != "")
        || (isset($generiques) && $generiques != "")) {
            $searchStmt = $this->visiteService->rechercheCritere($pdo, $designation, $type, $generiques);
        } else {
            $searchStmt = $this->visiteService->findAllMedoc($pdo);
        }
        $searchStmt2 = $this->visiteService->findAllTypes($pdo);
        $requeteInfoPatient = $this->visiteService->recupInfoPatient($pdo, $idP);
        $requeteOrdo = $this->visiteService->requeteOrdo($pdo);
        $view = new View('SAE_S3_WEB/views/creationVisite');
        $view->setVar('requeteInfoPatient', $requeteInfoPatient);
        $view->setVar('requeteOrdo', $requeteOrdo);
        $view->setVar('searchStmt', $searchStmt);
        $view->setVar('searchStmt2', $searchStmt2);
        $view->setVar('idP', $idP);
        $view->setVar('dateVisite', $dateVisite);
        $view->setVar('motif', $motif);
        $view->setVar('observation', $observation);
        $view->setVar('ToutOK', $ToutOK);
        return $view;
    }

    public function supprMedoc($pdo) {
        $idMed = HttpHelper::getParam('recupId');
        $idP = HttpHelper::getParam('idP');
        $dateVisite = HttpHelper::getParam('dateVisite');
        $motif = HttpHelper::getParam('motif');
        $observation = HttpHelper::getParam('observation');
        $idMedecin = HttpHelper::getParam('idMedecin');
        $ToutOK=false;
        $supprMedoc = $this->visiteService->supprMedoc($pdo, $idMed);
        $searchStmt = $this->visiteService->findAllMedoc($pdo);
        $searchStmt2 = $this->visiteService->findAllTypes($pdo);
        $requeteInfoPatient = $this->visiteService->recupInfoPatient($pdo, $idP);
        $requeteOrdo = $this->visiteService->requeteOrdo($pdo);
        $view = new View('SAE_S3_WEB/views/creationVisite');
        $view->setVar('dateVisite', $dateVisite);
        $view->setVar('motif', $motif);
        $view->setVar('observation', $observation);
        $view->setVar('ToutOK', $ToutOK);
        $view->setVar('searchStmt', $searchStmt);
        $view->setVar('searchStmt2', $searchStmt2);
        $view->setVar('requeteInfoPatient', $requeteInfoPatient);
        $view->setVar('requeteOrdo', $requeteOrdo);
        $view->setVar('idP', $idP);
        $view->setVar('idMedecin', $idMedecin);
        return $view;
    }

    public function insertVisite($pdo) {
        $dateVisite = HttpHelper::getParam('dateVisite');
        $motif = HttpHelper::getParam('motif');
        $observation = HttpHelper::getParam('observation');
        $idP = HttpHelper::getParam('idP');
        $idMedecin = HttpHelper::getParam('idMedecin');
        $view = new View('SAE_S3_WEB/views/creationVisite');
        $ToutOK=true; //Savoir si toutes les données ont été rentrées
		//Récupération de la date de la visite
		if(isset($_POST['dateVisite']) and $_POST['dateVisite']!="")  {
			$dateVisite=htmlspecialchars($_POST['dateVisite']);
		} else {
			$dateVisite="";
			$ToutOK=false;
		}	
		//Récupération du motif de la visite
		if(isset($_POST['motif']) and $_POST['motif']!="") {
			$motif=htmlspecialchars($_POST['motif']);
		} else {
			$motif="";
			$ToutOK=false;
		}	
		//Récupération des commentaires
		if(isset($_POST['observation']) and $_POST['observation']!="") {
			$observation=htmlspecialchars($_POST['observation']);
		} else {
			$observation="";
			$ToutOK=false;
		}

        if($ToutOK) {
            $insertInVisite = $this->visiteService->insertInVisite($pdo, $dateVisite, $idP, $idMedecin, $motif, $observation);
            $insertInOrdo = $this->visiteService->insertInOrdo($pdo);
            $insertInPrescri = $this->visiteService->insertInPrescri($pdo);
            $deletePrescriTemp = $this->visiteService->deletePrescriTemp($pdo);
            $view->setVar('ToutOK', $ToutOK);
        } else {
            $view->setVar('dateVisite', $dateVisite);
            $view->setVar('motif', $motif);
            $view->setVar('observation', $observation);
            $view->setVar('ToutOK', $ToutOK);
        }
        $searchStmt = $this->visiteService->findAllMedoc($pdo);
        $searchStmt2 = $this->visiteService->findAllTypes($pdo);
        $requeteInfoPatient = $this->visiteService->recupInfoPatient($pdo, $idP);
        $requeteOrdo = $this->visiteService->requeteOrdo($pdo);
        $requeteSearchPatients = $this->visiteService->searchPatientsAccueil($pdo, $idMedecin);
        $view->setVar('searchStmt', $searchStmt);
        $view->setVar('searchStmt2', $searchStmt2);
        $view->setVar('requeteInfoPatient', $requeteInfoPatient);
        $view->setVar('requeteOrdo', $requeteOrdo);
        $view->setVar('idP', $idP);
        $view->setVar('idMedecin', $idMedecin);
        return $view;
    }

    public function deconnexion() {
        session_destroy();
        $view = new View('SAE_S3_WEB/views/accueil');
        $view->setVar('erreurLog', false);
        return $view;
		exit();
    }
}

?>