<?php
namespace controllers;

use services\PatientsService;
use yasmf\HttpHelper;
use yasmf\View;

class PatientsController {

    // private $medecinsService;

    // /**
    //  * Create and initialize an ArticlesController object
    //  */
    // public function __construct()
    // {
    //     $this->medecinsService = MedecinsService::getDefaultService();
    // }

    /**
     * @param $pdo
     *  the pdo object used to connect to the database
     * @return View
     *  the view in charge of displaying the articles
     */
    public function creationPatient() {
        $view = new View('cabinet_medical/views/creationPatient');
        return $view;
    }



}


