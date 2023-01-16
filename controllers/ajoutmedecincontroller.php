<?php
namespace controllers;

session_start();
use services\AjoutMedecinService;
use yasmf\HttpHelper;
use yasmf\View;

class AjoutMedecinController {

    private $ajoutMedecinService;

    /**
     * Create and initialize an AdminsController object
     */
    public function __construct() {
        $this->ajoutMedecinService = AjoutMedecinService::getDefaultService();
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
		
        $view = new View('SAE_S3_WEB/views/creationMedecin');
        $view->setVar('check', false);
        return $view;
    }

    /**
    * @param $pdo
    *  the pdo object used to connect to the database
    * @return View
    *  the view in charge of displaying the page to create a doctor
    */
    public function addMedecin($pdo) {
        $ToutOK = true;
        $nom = HttpHelper::getParam('nom');
        $prenom = HttpHelper::getParam('prenom');
        $adresse = HttpHelper::getParam('adresse');
        $portable = HttpHelper::getParam('portable');
        $mail = HttpHelper::getParam('mail');
        $date = HttpHelper::getParam('date');
        $identifiant = HttpHelper::getParam('identifiant');
        $motDePasse = HttpHelper::getParam('motDePasse');

        //Récupération du nom
		if(isset($nom) and $nom!="" and preg_match("/^[[:alpha:]][[:alpha:][:space:]éèçàù'-]{0,33}[[:alpha:]éèçàù]$/", $nom)) {
			$nom=htmlspecialchars($nom);
		} else {
			$nom="";
			$ToutOK=false;
		}
		// TODO => Attention aux caractères ' " ...
		
		//Récupération du prenom
		if(isset($prenom) and $prenom!="" and preg_match("^[A-Z][A-Za-z\é\è\ê\-]+$^", $prenom)) {
			$prenom=htmlspecialchars($prenom);
		} else {
			$prenom="";
			$ToutOK=false;
		}

		//Récupération de l'adresse
		if(isset($adresse) and $adresse!="" and preg_match("/\b(?!\d{5}\b)\d+\b(?:\s*\w\b)?(?=\D*\b\d{5}\b|\D*$)/", $adresse)) {
			$adresse=htmlspecialchars($adresse);
		} else {
			$adresse="";
			$ToutOK=false;
		}
		//Récupération du numéro de portable
		if(isset($portable) and $portable!="" and preg_match("~(0){1}[0-9]{9}~", $portable)) {
			$portable=htmlspecialchars($portable);
		} else {
			$portable="";
			$ToutOK=false;
		}
		//Récupération de l'email
		if(isset($mail) and $mail!="" and preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $mail)) {
			$mail=htmlspecialchars($mail);
		} else {
			$mail="";
			$ToutOK=false;
		}
		//Récupération de la date de naissance
		if(isset($date) and $date!="") {
			$date=htmlspecialchars($date);
		} else {
			$date="";
			$ToutOK=false;
		}

		//Récupération de l'identifiant
		if(isset($identifiant) and $identifiant!="") {
			$identifiant = htmlspecialchars($identifiant);
		} else {
			$identifiant ="";
			$ToutOK = false;
		}

		//Récupération du mot de passe
		if(isset($motDePasse) and $motDePasse!="") {
			$motDePasse = htmlspecialchars($motDePasse);
		} else {
			$motDePasse ="";
			$ToutOK = false;
		}

        $role = "MED";	
		$view = new View('SAE_S3_WEB/views/creationMedecin');
		if ($ToutOK == false) {
			$view->setVar('check', $ToutOK);
        } else if ($ToutOK == true){
            try {
                $this->ajoutMedecinService->addMedecin($pdo, $nom, $prenom, $adresse, $date, $portable, $mail, $identifiant, $motDePasse, $role);
                $view->setVar('check', $ToutOK);
            } catch (\PDOException $e) {
				echo $e;
				$view->setVar('check', false);
            }
        }
		$view->setVar('nom', $nom);
		$view->setVar('prenom', $prenom);
		$view->setVar('adresse', $adresse);
		$view->setVar('portable', $portable);
		$view->setVar('mail', $mail);
		$view->setVar('date', $date);
		$view->setVar('identifiant', $identifiant);
		$view->setVar('motDePasse', $motDePasse);
		var_dump($view);
		return $view;
    }
}