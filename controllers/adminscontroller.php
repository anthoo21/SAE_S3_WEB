<?php
namespace controllers;

session_start();
use services\AdminsService;
use yasmf\HttpHelper;
use yasmf\View;

class AdminsController {

    private $adminsService;

    /**
     * Create and initialize an AdminsController object
     */
    public function __construct() {

        $this->adminsService = AdminsService::getDefaultService();
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

        $nomsCabinets = $this->adminsService->findAllCabinets($pdo); //renvoi tout les cabinets
        $medecins = $this->adminsService->findAllMedecins($pdo); //renvoi tout les medecins
        $nbMedecins = $medecins->rowCount(); //compte le nombre de medecins
        $patients = $this->adminsService->findAllPatients($pdo);
        $nbpatients = $patients->rowCount();
        $view = new View('SAE_S3_WEB\views\accueilAdmin');
        $view->setVar('requeteCabinet', $nomsCabinets);
        $view->setVar('selectAllMedecins', $medecins);
        $view->setVar('compteMed', $nbMedecins);
        $view->setVar('comptePatients', $nbpatients);
        $view->setVar('allVerifOk', false);
        return $view;
    }

    /**
     * @param $pdo
     * the pdo object used to connect to the database
     * @return View
     *  the view in charge of displaying the admin interface with all the files uploaded 
     */
    public function areAllFichOK($pdo) {

        $check = true;
        $allVerifOk = true;
        $tabName = array('CIS_bdpm.txt','CIS_CIP_bdpm.txt','CIS_COMPO_bdpm.txt',
            'CIS_CPD_bdpm.txt', 'CIS_GENER_bdpm.txt','CIS_HAS_ASMR_bdpm.txt',
            'CIS_HAS_SMR_bdpm.txt','CIS_InfoImportantes_bdpm.txt','HAS_LiensPageCT_bdpm.txt');
        $target_dir = "fichierImport/";
        $cis1 = HttpHelper::getParam('cis1');
        $cis2 = HttpHelper::getParam('cis2');
        $cis3 = HttpHelper::getParam('cis3');
        $cis4 = HttpHelper::getParam('cis4');
        $cis5 = HttpHelper::getParam('cis5');
        $cis6 = HttpHelper::getParam('cis6');
        $cis7 = HttpHelper::getParam('cis7');
        $cis8 = HttpHelper::getParam('cis8');
        $cis9 = HttpHelper::getParam('cis9');

        $tabFich = [$cis1, $cis2, $cis3, $cis4, $cis5, $cis6, $cis7, $cis8, $cis9];

        for($i = 1; $i <= 9; $i++) {
            $fich = $tabFich[$i-1];
            $target_file = $target_dir.basename($fich["name"]);
            $ficType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));	
            $baseName = htmlspecialchars(basename($fich["name"]));
            // verif si $fich est set, si c'est un txt ou si son nom ne correspond pas au nom voulu
            if ($baseName != "" or $baseName != null) {
                if (isset($fich) and $ficType == "txt" and $baseName == $tabName[$i-1]) {
                    if (!file_exists($target_file)) {
                        AdminsController::uploadFich($fich, $target_file);
                    } else {
                        $check = false;
                    }
                } else {
                    $check = false;
                }
            } else {
                $check = false;
            }
            if(!file_exists($target_file)) {
                $allVerifOk = false;
            }
        }


        $nomsCabinets = $this->adminsService->findAllCabinets($pdo); //renvoi tout les cabinets
        $medecins = $this->adminsService->findAllMedecins($pdo); //renvoi tout les medecins
        $nbMedecins = $medecins->rowCount(); //compte le nombre de medecins
        $patients = $this->adminsService->findAllPatients($pdo);
        $nbpatients = $patients->rowCount();
        $view = new View('SAE_S3_WEB\views\accueilAdmin');
        $view->setVar('requeteCabinet', $nomsCabinets);
        $view->setVar('selectAllMedecins', $medecins);
        $view->setVar('compteMed', $nbMedecins);
        $view->setVar('comptePatients', $nbpatients);
        $view->setVar('allVerifOk', $allVerifOk); 
        return $view;
    } 

    /**
     * @param $pdo
     * the pdo object used to connect to the database
     * @return View
     * view that shows the infos of the selected doctor
     */
    public function goDossMedecin($pdo) {
        $idMed = HttpHelper::getParam('idMed');
        $dossMedecin = $this->adminsService->getInfoDoctor($pdo, $idMed);
        $view = new View('SAE_S3_WEB\views\dossierMedecin');
        while($ligne = $dossMedecin->fetch()) {
            $view->setVar('nom', $ligne['nom']);
            $view->setVar('prenom', $ligne['prenom']);
            $view->setVar('adresse', $ligne['adresse']);
            $view->setVar('tel', $ligne['tel']);
            $view->setVar('email', $ligne['email']);
            $view->setVar('date', $ligne['dateNai']);
            $view->setVar('identifiant', $ligne['identifiant']);
            $view->setVar('mdp', $ligne['motDePasse']);
        }
        return $view;
    }

    /**
     * @param $fich
     * fich is the file the user wants to upload in fichierImport/
     * @return boolean
     * true if the file was uploaded, false if not
     */
    public function uploadFich($fich, $target_file) {
        if (move_uploaded_file($fich["tmp_name"], $target_file)) {
            return true;
        } else {
            echo "Le fichier ".basename($fich["name"])." provoque une erreur, merci d'importer le bon fichier.</br>";
            return false;
        }
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