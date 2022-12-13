<?php
namespace controllers;

use services\MedecinsService;
use yasmf\HttpHelper;
use yasmf\View;

class MedecinsController {

    private $medecinsService;

    /**
    * Create and initialize an ArticlesController object
    */
    public function __construct()
    {
        $this->medecinsService = MedecinsService::getDefaultService();
    }

    /**
     * @param $pdo
     *  the pdo object used to connect to the database
     * @return View
     *  the view in charge of displaying the articles
     */
    public function index($pdo) {
        $searchStmt = $this->medecinsService->findAllPatients($pdo);
        $view = new View('cabinet_medical/views/accueilMedecin');
        $view->setVar('searchStmt', $searchStmt);
        return $view;
    }



}


