<?php
namespace controllers;

session_start();
use services\PosologieService;
use yasmf\HttpHelper;
use yasmf\View;

class PosologieController {

    private $posologieService;

    /**
     * Create and initialize an AdminsController object
     */
    public function __construct() {
        $this->posologieService = PosologieService::getDefaultService();
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
        $idMedoc = HttpHelper::getParam('idMedoc');
        $view = new View('SAE_S3_WEB/views/ajoutPosologie');
        $view->setVar('idMedoc', $idMedoc);
        $view->setVar('idP', $idP);
        return $view;
    }

    public function insertPrescri($pdo) {
        $idMedoc = HttpHelper::getParam('idMedoc');
        $posologie = HttpHelper::getParam('posologie');
        $idP = HttpHelper::getParam('idP');
        $insertPrescri = $this->posologieService->insertPrescri($pdo, $idMedoc, $posologie);
        $searchStmt = $this->posologieService->findAllMedoc($pdo);
        $searchStmt2 = $this->posologieService->findAllTypes($pdo);
        $requeteInfoPatient = $this->posologieService->recupInfoPatient($pdo, $idP);
        $requeteOrdo = $this->posologieService->requeteOrdo($pdo);
        $view = new View('SAE_S3_WEB/views/creationVisite');
        $view->setVar('searchStmt', $searchStmt);
        $view->setVar('searchStmt2', $searchStmt2);
        $view->setVar('requeteInfoPatient', $requeteInfoPatient);
        $view->setVar('requeteOrdo', $requeteOrdo);
        $view->setVar('idP', $idP);
        return $view;
    }

    
}