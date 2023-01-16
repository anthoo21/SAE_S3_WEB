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

        $searchStmt = $this->visiteService->findAllMedoc($pdo);
        $searchStmt2 = $this->visiteService->findAllTypes($pdo);
        $view = new View('SAE_S3_WEB/views/creationVisite');
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
            $searchStmt = $this->visiteService->rechercheCritere($pdo, $designation, $type, $generiques);
        } else {
            $searchStmt = $this->visiteService->findAllMedoc($pdo);
        }
        $searchStmt2 = $this->visiteService->findAllTypes($pdo);
        $view = new View('SAE_S3_WEB/views/creationVisite');
        $view->setVar('searchStmt', $searchStmt);
        $view->setVar('searchStmt2', $searchStmt2);
        return $view;
    }

    public function requeteOrdo($pdo) {
        $sql = "SELECT C.denomination, P.posologie, P.id_medicaments
        FROM cis_bdpm C JOIN prescriptionsTemp P ON C.codeCis = P.id_medicaments";
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