<?php
namespace controllers;

session_start();
use services\RechercheService;
use yasmf\HttpHelper;
use yasmf\View;

class RechercheController {

    private $rechercheService;

    /**
    * Create and initialize an RechercheController object
    */
    public function __construct()
    {
        $this->rechercheService = RechercheService::getDefaultService();
    }

    /**
     * @param $pdo
     *  the pdo object used to connect to the database
     * @return View
     *  the view in charge of displaying the patients
     */
    public function index($pdo) {
        // Test si on est bien connecté (session existante et bon numéro de session
        if (!isset($_SESSION['login']) || !isset($_SESSION['id']) || $_SESSION['id']!=session_id()) {
            // Renvoi vers la page de connexion
            $view = new View('cabinet_medical/views/accueil');
            return $view;
        }
        
        $searchStmt = $this->rechercheService->findAllMedoc($pdo);
        $searchStmt2 = $this->rechercheService->findAllTypes($pdo);
        $view = new View('cabinet_medical/views/recherche');
        $view->setVar('searchStmt', $searchStmt);
        $view->setVar('searchStmt2', $searchStmt2);
        return $view;
    }

    public function rechercheCritere($pdo) {
        $designation = HttpHelper::getParam('designation');
        $type = HttpHelper::getParam('Type');
        $generiques = HttpHelper::getParam('generiques');
        if((isset($designation) && $designation != "") || (isset($type) && $type != "")
        || (isset($generiques) && $generiques != "")) {
            $searchStmt = $this->rechercheService->rechercheCritere($pdo, $designation, $type, $generiques);
        } else {
            $searchStmt = $this->rechercheService->findAllMedoc($pdo);
        }
        $searchStmt2 = $this->rechercheService->findAllTypes($pdo);
        $view = new View('cabinet_medical/views/recherche');
        $view->setVar('searchStmt', $searchStmt);
        $view->setVar('searchStmt2', $searchStmt2);
        return $view;
    }

    public function deconnexion() {
        session_destroy();
        $view = new View('cabinet_medical/views/accueil');
        $view->setVar('erreurLog', false);
        return $view;
		exit();
    }
}


