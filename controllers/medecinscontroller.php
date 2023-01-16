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
            $view = new View('SAE_S3_WEB/views/accueil');
            return $view;
        }
        
        $searchStmt = $this->medecinsService->findAllPatients($pdo, $_SESSION['idMed']);
        $view = new View('SAE_S3_WEB/views/accueilMedecin');
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
        $view = new View('SAE_S3_WEB/views/accueilMedecin');
        $view->setVar('searchStmt', $searchStmt);
        return $view;
    }

    public function goToFichePatient($pdo) {
        $numSecu = HttpHelper::getParam('numCarte');
        $searchStmt = $this->medecinsService->findPatientFile($pdo, $numSecu);
        $searchStmtB = $this->medecinsService->findPatientVisit($pdo, $numSecu);
        $view = new View('SAE_S3_WEB/views/dossierPatient');
        while($ligne = $searchStmt->fetch()) {
            $view->setVar('nom', $ligne['nom']);
            $view->setVar('prenom', $ligne['prenom']);
            $view->setVar('adresse', $ligne['adresse']);
            $view->setVar('noCV', $ligne['numeroCarteVitale']);
            $view->setVar('tel', $ligne['tel']);
            $view->setVar('email', $ligne['email']);
            $view->setVar('date', $ligne['dateNai']);
            $view->setVar('poids', $ligne['poids']);
            $view->setVar('genre', $ligne['sexe']);
            $view->setVar('medecin', $ligne['nomMedecin']);
            $view->setVar('allergies', $ligne['allergies']);
            $view->setVar('commentaires', $ligne['commentaires']);
        }
        $view->setVar('searchStmt', $searchStmtB);
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


