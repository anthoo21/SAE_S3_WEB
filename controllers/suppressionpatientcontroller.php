<?php
namespace controllers;

session_start();
use services\SuppressionPatientService;
use yasmf\HttpHelper;
use yasmf\View;

class SuppressionPatientController {

    private $suppressionPatientService;

    /**
    * Create and initialize an MedecinsController object
    */
    public function __construct()
    {
        $this->suppressionPatientService = SuppressionPatientService::getDefaultService();
    }

    public function index($pdo) {
        // Test si on est bien connecté (session existante et bon numéro de session
        if (!isset($_SESSION['login']) || !isset($_SESSION['id']) || $_SESSION['id']!=session_id()) {
            // Renvoi vers la page de connexion
            $view = new View('SAE_S3_WEB/views/accueil');
            return $view;
        }

        $idPatient = HttpHelper::getParam('noCV');
        $stmt = $this->suppressionPatientService->findPatientData($pdo, $idPatient);
        $view = new View("SAE_S3_WEB/views/suppressionPatient");
        while ($ligne = $stmt->fetch()) {
            $view->setVar('nom', $ligne['nom']);
            $view->setVar('prenom', $ligne['prenom']);
        }
        $view->setVar('noCV', $idPatient);
        return $view;
        

    }
}