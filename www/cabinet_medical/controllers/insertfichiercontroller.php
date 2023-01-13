<?php
namespace controllers;

session_start();
use services\InsertFichierService;
use yasmf\HttpHelper;
use yasmf\View;

class InsertFichierController {

    private $insertFichierService;

    /**
     * Create and initialize an AdminsController object
     */
    public function __construct() {
        $this->insertFichierService = InsertFichierService::getDefaultService();
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
            $view = new View('cabinet_medical/views/accueil');
            return $view;
            exit();
        }
		
        $view = new View('cabinet_medical/views/accueilAdmin');
        $view->setVar('check', false);
        return $view;
    }

    public function insertFich($pdo) {
        $tabName = array('CIS_bdpm.txt','CIS_CIP_bdpm.txt','CIS_COMPO_bdpm.txt',
					'CIS_CPD_bdpm.txt', 'CIS_GENER_bdpm.txt','CIS_HAS_ASMR_bdpm.txt',
					'CIS_HAS_SMR_bdpm.txt','CIS_InfoImportantes_bdpm.txt','HAS_LiensPageCT_bdpm.txt');
        $target_dir = "fichierImport/";
        $view = new View('cabinet_medical/views/accueilAdmin');
        for($i = 0; $i <= 8; $i++) {
            $file = $target_dir.$tabName[$i];
            $tabFichier = file($file,FILE_IGNORE_NEW_LINES);
            foreach($tabFichier as $ligne) { 
                $tab = explode(chr(9), $ligne);	
                // if($i == 0) {
                //     $this->insertFichierService->insertCisBdpm($pdo, $tab[0], $tab[1], $tab[2], $tab[3], $tab[4], $tab[5], $tab[6], $tab[7], $tab[8], $tab[9], $tab[10], $tab[11]);
                // }
                // if($i == 1) {
                //     $this->insertFichierService->insertCisCip($pdo, $tab[0], $tab[1], $tab[2], $tab[3], $tab[4], $tab[5], $tab[6], $tab[7], $tab[8], $tab[10], $tab[12]);
                // }
                // if($i == 2) {
                //     $this->insertFichierService->insertCisCompo($pdo, $tab[0], $tab[1], $tab[2], $tab[3], $tab[4], $tab[5], $tab[6], $tab[7]);
                // }
                // if($i == 3) {
                //     $this->insertFichierService->insertCisCpd($pdo, $tab[0], $tab[1]);
                // }
                // if($i == 4) {
                //     $this->insertFichierService->insertCisGener($pdo, $tab[0], $tab[1], $tab[2], $tab[3], $tab[4]);
                // }
                // if($i == 5) {
                //     $this->insertFichierService->insertCisHasAsmr($pdo, $tab[0], $tab[1], $tab[2], $tab[3], $tab[4], $tab[5]);
                // }
                // if($i == 6) {
                //     $this->insertFichierService->insertCisHasSmr($pdo, $tab[0], $tab[1], $tab[2], $tab[3], $tab[4], $tab[5]);
                // }
                if($i == 7) {
                    $this->insertFichierService->insertCisInfo($pdo, $tab[0], $tab[1], $tab[2], $tab[3]);
                }
                if($i == 8) {
                    $this->insertFichierService->insertCisHas($pdo, $tab[0], $tab[1]);
                }

            }
        }
        return $view;
    } 
}
?>