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
        $erased = false;
        $idPatient = HttpHelper::getParam('noCV');
        $stmt = $this->suppressionPatientService->findPatientData($pdo, $idPatient);
        $view = new View("SAE_S3_WEB/views/suppressionPatient");
        while ($ligne = $stmt->fetch()) {
            $view->setVar('nom', $ligne['nom']);
            $view->setVar('prenom', $ligne['prenom']);
        }
        $view->setVar('noCV', $idPatient);
        $view->setVar('erased', $erased);
        return $view;
        
    }

    public function suppressionPatient($pdo) {
        $noCV = HttpHelper::getParam('noCV');
        $nom = HttpHelper::getParam('nom');
        $prenom = HttpHelper::getParam('prenom');
        $supprFromPrescri = $this->suppressionPatientService->supprFromPrescri($pdo, $noCV);
        $supprFromOrdo = $this->suppressionPatientService->supprFromOrdo($pdo, $noCV);
        $supprFromVisite = $this->suppressionPatientService->supprFromVisite($pdo, $noCV);
        $supprPatient = $this->suppressionPatientService->supprPatient($pdo, $noCV);
        $erased = true;
        $view = new View("SAE_S3_WEB/views/suppressionPatient");
        $view->setVar('idPatient', $noCV);
        $view->setVar('erased', $erased);
        $view->setVar('nom', $nom);
        $view->setVar('prenom', $prenom);
        $view->setVar('supprFromPrescri', $supprFromPrescri);
        $view->setVar('supprFromOrdo', $supprFromOrdo);
        $view->setVar('supprFromVisite', $supprFromVisite);
        $view->setVar('supprPatient', $supprPatient);
        return $view;
    }
}