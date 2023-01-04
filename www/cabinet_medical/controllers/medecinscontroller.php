<?php
namespace controllers;

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
        var_dump($pdo);
        $searchStmt = $this->medecinsService->findAllPatients($pdo);
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
            $searchStmt = $this->medecinsService->findSelectedPatients($pdo, $nom, $secu);
        } else {
            $searchStmt = $this->medecinsService->findAllPatients($pdo);
        }
        $view = new View('cabinet_medical/views/accueilMedecin');
        $view->setVar('searchStmt', $searchStmt);
        return $view;
    }


}


