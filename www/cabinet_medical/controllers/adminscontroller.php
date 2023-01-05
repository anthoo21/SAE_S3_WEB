<?php
namespace controllers;

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

        $nomsCabinets = $this->adminsService->findAllCabinets($pdo); //renvoi tout les cabinets
        $medecins = $this->adminsService->findAllMedecins($pdo); //renvoi tout les medecins
        $nbMedecins = $medecins->rowCount(); //compte le nombre de medecins
        $patients = $this->adminsService->findAllPatients($pdo);
        $nbpatients = $patients->rowCount();
        $view = new View('cabinet_medical\views\accueilAdmin');
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
            // Regarder si le fichier existe déjà
            if (file_exists($target_file)) {
                $check = false;
            }
            // Accepter que les .txt
            if($ficType != "txt") {
                $check = false;
            }
            // Vérifie si le fichier est le bon
            if(htmlspecialchars(basename($fich["name"])) != $tabName[$i-1]) {
                $check = false;
            }
            //Si check == false, c'est qu'il y a eu une erreur
            if ($check == false) {
                echo "Le fichier n'a pas pu être traité.</br>";
            // Sinon, essaye d'upload le fichier
            } else {
                if (move_uploaded_file($fich["tmp_name"], $target_file)) {
                    echo "Le fichier ".basename($fich["name"])." a été correctement importé.</br>";
                } else {
                    echo "Le fichier ".basename($fich["name"])." provoque une erreur, merci d'importer le bon fichier.</br>";
                }
            }
        }


        $nomsCabinets = $this->adminsService->findAllCabinets($pdo); //renvoi tout les cabinets
        $medecins = $this->adminsService->findAllMedecins($pdo); //renvoi tout les medecins
        $nbMedecins = $medecins->rowCount(); //compte le nombre de medecins
        $patients = $this->adminsService->findAllPatients($pdo);
        $nbpatients = $patients->rowCount();
        $view = new View('cabinet_medical\views\accueilAdmin');
        $view->setVar('requeteCabinet', $nomsCabinets);
        $view->setVar('selectAllMedecins', $medecins);
        $view->setVar('compteMed', $nbMedecins);
        $view->setVar('comptePatients', $nbpatients);
        $view->setVar('allVerifOk', $check); 
        return $view;
    } 

}

?>