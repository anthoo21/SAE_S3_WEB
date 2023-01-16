<?php
namespace controllers;

session_start();
use services\VisitePatientService;
use yasmf\HttpHelper;
use yasmf\View;

class VisitePatientController {

    private $visitePatientService;

    /**
    * Create and initialize an MedecinsController object
    */
    public function __construct()
    {
        $this->visitePatientService = VisitePatientService::getDefaultService();
    }

    public function index($pdo) {
        // Test si on est bien connecté (session existante et bon numéro de session
        if (!isset($_SESSION['login']) || !isset($_SESSION['id']) || $_SESSION['id']!=session_id()) {
            // Renvoi vers la page de connexion
            $view = new View('SAE_S3_WEB/views/accueil');
            return $view;
        }
        $idVisite = HttpHelper::getParam('idVisite');
        $stmt = $this->visitePatientService->getVisiteData($pdo, $idVisite);
        
        $view = new View("SAE_S3_WEB/views/visitePatient");

        while($ligne = $stmt->fetch()) {
			$view->setVar('nomPrenomPatient', $ligne['np'].' '.$ligne['pp']);
			$view->setVar('nomPrenomMedecin', $ligne['nm']." ".$ligne['pm']);
			$view->setVar('dateVisite', date("d/m/Y", strtotime($ligne['date_visite'])));
			$view->setVar('poids', $ligne['poids']);
			$view->setVar('commentaires', $ligne['commentaires']);
			$view->setVar('dateNaissance', date("d/m/Y", strtotime($ligne['dateNai'])));
			$view->setVar('motif', $ligne['motif']);
			$view->setVar('observations', $ligne['observations']);
            $view->setvar('numeroCarteVitale', $ligne['numeroCarteVitale']);
		}

        return $view;
    }




}