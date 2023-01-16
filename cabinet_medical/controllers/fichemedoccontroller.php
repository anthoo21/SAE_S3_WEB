<?php
namespace controllers;

session_start();
use services\FicheMedocService;
use yasmf\HttpHelper;
use yasmf\View;

class FicheMedocController {

    private $ficheMedocService;

    /**
    * Create and initialize an RechercheController object
    */
    public function __construct()
    {
        $this->ficheMedocService = FicheMedocService::getDefaultService();
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
        $idMedoc = HttpHelper::getParam('idMedoc');
        $requeteMedGeneral = $this->ficheMedocService->requeteMedGeneral($pdo, $idMedoc);
        $requeteMedCIP = $this->ficheMedocService->requeteMedCIP($pdo, $idMedoc);
        $requeteMedCOMPO = $this->ficheMedocService->requeteMedCOMPO($pdo, $idMedoc);
        $requeteMedASMR = $this->ficheMedocService->requeteMedASMR($pdo, $idMedoc);
        $requeteMedSMR = $this->ficheMedocService->requeteMedSMR($pdo, $idMedoc);
        $requeteMedINFO = $this->ficheMedocService->requeteMedINFO($pdo, $idMedoc);
        $view = new View('cabinet_medical/views/ficheMedoc');
        $view->setVar('requeteMedGeneral', $requeteMedGeneral);
        $view->setVar('requeteMedCIP', $requeteMedCIP);
        $view->setVar('requeteMedCOMPO', $requeteMedCOMPO);
        $view->setVar('requeteMedASMR', $requeteMedASMR);
        $view->setVar('requeteMedSMR', $requeteMedSMR);
        $view->setVar('requeteMedINFO', $requeteMedINFO);
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


