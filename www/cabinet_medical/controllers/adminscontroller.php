<?php
namespace controller;

use services\AdminsService;
use yasmf\HttpHelper;
use yasmf\View;

class AdminsController {

    private $adminsService;

    /**
     * Create and initialize an AdminsController object
     */
    public function __contruct() {
        $this->adminsService = AdminsService::getDefaultService();
    }

    /**
     * @param $pdo
     *  the pdo object used to connect to the database
     * @return View
     *  the view in charge of displaying the admin interface
     */
    public function index($pdo) {
        $nomsCabinets = $this->adminsService->findAllCabinets($pdo); //renvoi tout les cabinets
        $medecins = $this->adminsService->findAllMedecins($pdo); //renvoi tout les medecins
        $nbMedecins = $medecins->rowCount(); //compte le nombre de medecins
        $patients = $adminsService->findAllPatients($pdo);
        $nbpatients = $patients->rowCount();
        $view = new View('cabinet_medical/views/acceuilAdmin');
        $view->setVar('requeteCabinet', $nomsCabinets);
        $view->setVar('selectAllMedecins', $medecins);
        $view->setVar('compteMed', $nbMedecins);
        $view->setVar('comptePatients', $nbpatients);
        return $view;
    }

}

?>