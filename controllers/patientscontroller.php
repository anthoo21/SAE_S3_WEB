<?php
namespace controllers;

session_start();
use services\PatientsService;
use yasmf\HttpHelper;
use yasmf\View;

class PatientsController {

    private $patientsService;

    /**
     * Create and initialize an PatientsController object
     */
    public function __construct()
    {
        $this->patientsService = PatientsService::getDefaultService();
    }

    /**
     * @return View
     *  the view in charge of displaying the form to add a patient
     */
    public function index() {
        // Test si on est bien connecté (session existante et bon numéro de session
        if (!isset($_SESSION['login']) || !isset($_SESSION['id']) || $_SESSION['id']!=session_id()) {
            // Renvoi vers la page de connexion
            $view = new View('SAE_S3_WEB/views/accueil');
            return $view;
            exit();
        }
        
        $view = new View('SAE_S3_WEB/views/creationPatient');
        $view->setVar('check', false);
        return $view;
    }

    /**
     * @param $pdo
     *  the pdo object used to connect to the database
     * @return View
     *  the view in charge of displaying the form to add a patient
     */
    public function addPatient($pdo) {
        $check = true;
        $nom = HttpHelper::getParam('nom');
        $prenom = HttpHelper::getParam('prenom');
        $genre = HttpHelper::getParam('genre');
        $adresse = HttpHelper::getParam('adresse');
        $portable = HttpHelper::getParam('portable');
        $mail = HttpHelper::getParam('mail');
        $date = HttpHelper::getParam('date');
        $poids = HttpHelper::getParam('poids');
        $noCV = HttpHelper::getParam('noCV');
        $allergies = HttpHelper::getParam('allergies');
        $commentaires = HttpHelper::getParam('commentaires');
        $medecin = HttpHelper::getParam('medecin');

        //Check nom
        if(isset($nom) and $nom!="") {
			$nom=htmlspecialchars($nom);
		} else {
            $nom="";
			$check=false;
		}

        //Check prenom
        if(isset($prenom) and $prenom!="") {
			$prenom=htmlspecialchars($prenom);
		} else {
            $prenom="";
			$check=false;
		}

        //Check genre
		if(isset($genre) and $genre!="" and ($genre=="01" || $genre=="02")) {
			$genre=htmlspecialchars($genre);
		} else {
            $genre="";
            $check=false;
        }

        //Check adresse
		if(isset($adresse) and $adresse!="" and preg_match("/^([0-9]{1,4}[a-zA-Z]{0,1})?\s*[a-zA-Z'.-]+(\s[a-zA-Z'.-]+)*\s*[0-9]{5}\s*[a-zA-Z]+([\s-][a-zA-Z]+)*$/", $adresse)) {
			$adresse=htmlspecialchars($adresse);
		} else {
            $adresse="";
			$check=false;
		}

        //Check portable
		if(isset($portable) and $portable!="" and preg_match("/^0[1-9][0-9]{8}$/", $portable)) {
			$portable=htmlspecialchars($portable);
		} else {
            $portable="";
			$check=false;
		}

        //Check mail
		if(isset($mail) and $mail!="" and preg_match("/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/", $mail)) {
			$mail=htmlspecialchars($mail);
		} else {
            $mail="";
			$check=false;
		}

        //Check date naissance
		if(isset($date) and $date!="") {
			$date=htmlspecialchars($date);
		} else {
            $date="";
			$check=false;
		}

        //Check poid
		if(isset($poids) and $poids!="" and preg_match("/^[0-9]{1,3}([.,][0-9]{3})?$/", $poids)) {		
            $poids=htmlspecialchars($poids);
        } else {
            $poids="";
            $check=false;
        }
        //TODO => regex

        //Check 
        if(isset($noCV) and $noCV!="" and preg_match("/^(1[0-9]{14}|2[0-9]{14})$/", $noCV)) {
            $noCV=htmlspecialchars($noCV);
        } else {
            $noCV="";
            $check=false;
        }

        //Check allergies
        if(isset($allergies) and ($allergies=="oui" || $allergies=="non")) {
            $allergies=htmlspecialchars($allergies);
        } else {
            $allergies="";
            $check=false;
        }

        $commentaires=htmlspecialchars($commentaires);

        //Appel de la fonction insert ou la vue form
        $view = new View('SAE_S3_WEB/views/creationPatient');
        if ($check == false) {
			$view->setVar('check', $check);
        } else if ($check == true){
            try {
                $this->patientsService->addPatient($pdo, $nom, $prenom, $genre, $adresse, $portable, $mail, $poids, $date, $noCV, $allergies, $commentaires, $medecin);
                $view->setVar('check', $check);
            } catch (\PDOException $e) {
				echo $e;
				$view->setVar('check', false);
            }
        }
		$view->setVar('nom',$nom);
        $view->setVar('prenom',$prenom);
        $view->setVar('genre',$genre);
        $view->setVar('adresse',$adresse);
        $view->setVar('portable',$portable);
        $view->setVar('mail',$mail);
        $view->setVar('date',$date);
        $view->setVar('poids',$poids);
        $view->setVar('noCV',$noCV);
        $view->setVar('allergies',$allergies);
        $view->setVar('commentaires',$commentaires);
        $view->setVar('id_medecin', $medecin);
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


