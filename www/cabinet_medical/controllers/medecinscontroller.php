<?php
namespace controllers;

session_start();
use services\MedecinsService;
use yasmf\HttpHelper;
use yasmf\View;

class MedecinsController {

    private $medecinsService;

    /**
    * Create and initialize an MedecinsController object
    */
    public function __construct()
    {
        $this->medecinsService = MedecinsService::getDefaultService();
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
        
        $searchStmt = $this->medecinsService->findAllPatients($pdo, $_SESSION['idMed']);
        $view = new View('cabinet_medical/views/accueilMedecin');
        $view->setVar('searchStmt', $searchStmt);
        return $view;
    }

    /**
     * @param $pdo $rechercheNom $rechercheNumSecu
     *  the pdo object used to connect to the database, the other two params are used in findSelectedPatients
     * @return View
     *  the view in charge of displaying the selected patients
     */
    public function afficherSelectedPatients($pdo) {
        $nom = HttpHelper::getParam('rechercheNom');
        $secu = HttpHelper::getParam('rechercheNSecu');
        if ((isset($nom) && $nom != "" ) || (isset($secu) && $secu != "")) {
            $searchStmt = $this->medecinsService->findSelectedPatients($pdo, $_SESSION['idMed'], $nom, $secu);
        } else {
            $searchStmt = $this->medecinsService->findAllPatients($pdo, $_SESSION['idMed']);
        }
        $view = new View('cabinet_medical/views/accueilMedecin');
        $view->setVar('searchStmt', $searchStmt);
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


