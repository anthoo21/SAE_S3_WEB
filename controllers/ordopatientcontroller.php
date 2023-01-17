<?php
namespace controllers;

session_start();
use services\OrdoPatientService;
use yasmf\HttpHelper;
use yasmf\View;

class OrdoPatientController {

    private $ordoPatientService;

    /**
    * Create and initialize an MedecinsController object
    */
    public function __construct()
    {
        $this->ordoPatientService = OrdoPatientService::getDefaultService();
    }

    public function index($pdo) {
        // Test si on est bien connecté (session existante et bon numéro de session
        if (!isset($_SESSION['login']) || !isset($_SESSION['id']) || $_SESSION['id']!=session_id()) {
            // Renvoi vers la page de connexion
            $view = new View('SAE_S3_WEB/views/accueil');
            return $view;
        }
        $idVisite = HttpHelper::getParam('idVisite');
        $getDonneesPatient = $this->ordoPatientService->getDonneesPatient($pdo, $idVisite);
        $getDonneesPrescri = $this->ordoPatientService->getDonneesPrescri($pdo, $idVisite);
        while($ligne = $getDonneesPatient->fetch()) {
            $nomPrenomPatient = $ligne['np'].' '.$ligne['pp'];
            $nomPrenomMedecin = $ligne['nm']." ".$ligne['pm'];
            $dateVisite = date("d/m/Y", strtotime($ligne['date_visite']));
            $poids = $ligne['poids'];
            $commentaires = $ligne['commentaires'];
            $dateNaissance = date("d/m/Y", strtotime($ligne['dateNai']));
            $motif = $ligne['motif'];
        }
        $view = new View("SAE_S3_WEB/views/ordoPatient");
        $view->setVar('nomPrenomPatient',$nomPrenomPatient);
        $view->setVar('nomPrenomMedecin',$nomPrenomMedecin);
        $view->setVar('dateVisite',$dateVisite);
        $view->setVar('poids',$poids);
        $view->setVar('commentaires',$commentaires);
        $view->setVar('dateNaissance',$dateNaissance);
        $view->setVar('motif',$motif);
        $view->setVar('getDonneesPrescri', $getDonneesPrescri);
        return $view;
    }
}