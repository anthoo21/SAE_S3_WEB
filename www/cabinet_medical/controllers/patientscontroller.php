<?php
namespace controllers;

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
     * @param $pdo
     *  the pdo object used to connect to the database
     * @return View
     *  the view in charge of displaying the form to add a patient
     */
    public function index($pdo) {
        $view = new View('cabinet_medical/views/creationPatient');
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
        if(isset($nom) and $nom!="" and preg_match("/^[[:alpha:]][[:alpha:][:space:]éèçàù'-]{0,33}[[:alpha:]éèçàù]$/", $nom)) {
			$nom=htmlspecialchars($nom);
		} else {
            $nom=htmlspecialchars($nom);
			$check=false;
		}

        //Check prenom
        if(isset($prenom) and $prenom!="" and preg_match("^[A-Z][A-Za-z\é\è\ê\-]+$^", $prenom)) {
			$prenom=htmlspecialchars($prenom);
		} else {
            $prenom=htmlspecialchars($prenom);
			$check=false;
		}

        //Check genre
		if(isset($genre) and $genre!="" and ($genre=="01" || $genre=="02")) {
			$genre=htmlspecialchars($genre);
		} else {
            $genre=htmlspecialchars($genre);
            $check=false;
        }

        //Check adresse
		if(isset($adresse) and $adresse!="" and preg_match("/\b(?!\d{5}\b)\d+\b(?:\s*\w\b)?(?=\D*\b\d{5}\b|\D*$)/", $adresse)) {
			$adresse=htmlspecialchars($adresse);
		} else {
            $adresse=htmlspecialchars($adresse);
			$check=false;
		}

        //Check portable
		if(isset($portable) and $portable!="" and preg_match("~(0){1}[0-9]{9}~", $portable)) {
			$portable=htmlspecialchars($portable);
		} else {
			$check=false;
		}

        //Check mail
		if(isset($mail) and $mail!="" and preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $mail)) {
			$mail=htmlspecialchars($mail);
		} else {
            $portable=htmlspecialchars($portable);
			$check=false;
		}

        //Check date naissance
		if(isset($date) and $date!="") {
			$date=htmlspecialchars($date);
		} else {
            $date=htmlspecialchars($date);
			$check=false;
		}

        //Check poid
		if(isset($poids) and $poids!="") {			//preg_match("~([1|2]?([0-9]{1,2}))(\.[0-9]{1,3})?~", $poids)
        $poids=htmlspecialchars($poids);
        } else {
            $poids=htmlspecialchars($poids);
            $check=false;
        }
        //TODO => regex

        //Check 
        if(isset($noCV) and $noCV!="" and preg_match("#^[12][0-9]{2}[0-1][0-9](2[AB]|[0-9]{2})[0-9]{3}[0-9]{3}[0-9]{2}$#", $noCV)) {
            $noCV=htmlspecialchars($noCV);
        } else {
            $noCV=htmlspecialchars($noCV);
            $check=false;
        }

        //Check allergies
        if(isset($allergies) and ($allergies=="oui" || $allergies=="non")) {
            $allergies=htmlspecialchars($allergies);
        } else {
            $allergies=htmlspecialchars($allergies);
            $check=false;
        }
         
        //Check id medecin
        if (isset($medecin) && ($medecin == "001")) { //mettre une regex pour verifier la validité de l'id medecin
            $medecin=htmlspecialchars($medecin);
        } else {
            $medecin=htmlspecialchars($medecin);
            $check = false;
        }

        $commentaires=htmlspecialchars($commentaires);

        //Appel de la fonction insert ou la vue form
        $view = new View('cabinet_medical/views/creationPatient');
        if ($check == false) {
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
            $view->setVar('check', false);
            return $view;
        } else if ($check == true){
            try {
                $this->patientsService->addPatient($pdo, $nom, $prenom, $genre, $adresse, $portable, $mail, $poids, $date, $noCV, $allergies, $commentaires, $medecin);
                $view->setVar('check', true);
                return $view;
            } catch (\PDOException $ex) {
                $view->setVar('check', false);
                $view->setVar('erreur', $ex);
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
        }
    }
}


