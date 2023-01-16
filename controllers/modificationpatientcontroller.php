<?php
namespace controllers;

session_start();
use services\ModificationPatientService;
use yasmf\HttpHelper;
use yasmf\View;

class ModificationPatientController {

    private $modificationPatientService;

    /**
    * Create and initialize an MedecinsController object
    */
    public function __construct()
    {
        $this->modificationPatientService = ModificationPatientService::getDefaultService();
    }

    public function index($pdo) {
        // Test si on est bien connecté (session existante et bon numéro de session
        if (!isset($_SESSION['login']) || !isset($_SESSION['id']) || $_SESSION['id']!=session_id()) {
            // Renvoi vers la page de connexion
            $view = new View('SAE_S3_WEB/views/accueil');
            return $view;
        }

        $idPatient = HttpHelper::getParam('noCV');
        $stmt = $this->modificationPatientService->getDataPatient($pdo, $idPatient);
        $view = new View('SAE_S3_WEB\views\modificationPatient');
        while($ligne = $stmt->fetch()) {
            $view->setVar('nom', $ligne['nom']);
            $view->setVar('prenom', $ligne['prenom']);
            $view->setVar('adresse', $ligne['adresse']);
            $view->setVar('noCV', $ligne['numeroCarteVitale']);
            $view->setVar('portable', $ligne['tel']);
            $view->setVar('mail', $ligne['email']);
            $view->setVar('date', date("d/m/Y", strtotime($ligne['dateNai'])));				
            $view->setVar('poids', $ligne['poids']);			
            $view->setVar('genre', $ligne['sexe']);
            $view->setVar('medecin', $ligne['nomMedecin'].' '.$ligne['prenomMedecin']);
            $view->setvar('allergies', $ligne['allergies']);
            $view->setVar('commentaires', $ligne['commentaires']);
        }
        $view->setVar('check', false);
        return $view;
    }

    public function updatePatient($pdo) {
        $idPatient = HttpHelper::getParam('noCV');
        $check = true;
        $nom = HttpHelper::getParam('nom');
        $prenom = HttpHelper::getParam('prenom');
        $genre = HttpHelper::getParam('genre');
        $adresse = HttpHelper::getParam('adresse');
        $portable = HttpHelper::getParam('portable');
        $mail = HttpHelper::getParam('mail');
        $date = HttpHelper::getParam('date');
        $poids = HttpHelper::getParam('poids');
        $allergies = HttpHelper::getParam('allergies');
        $commentaires = HttpHelper::getParam('commentaires');

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

        //Check allergies
        if(isset($allergies) and ($allergies=="oui" || $allergies=="non")) {
            $allergies=htmlspecialchars($allergies);
        } else {
            $allergies=htmlspecialchars($allergies);
            $check=false;
        }

        $commentaires=htmlspecialchars($commentaires);

        //Appel de la fonction insert ou la vue form
        $view = new View('SAE_S3_WEB/views/modificationpatient');
        if ($check == false) {
            $view->setVar('nom',$nom);
            $view->setVar('prenom',$prenom);
            $view->setVar('genre',$genre);
            $view->setVar('adresse',$adresse);
            $view->setVar('portable',$portable);
            $view->setVar('mail',$mail);
            $view->setVar('date',$date);
            $view->setVar('poids',$poids);
            $view->setVar('allergies',$allergies);
            $view->setVar('commentaires',$commentaires);
            $view->setVar('check', false);
            $view->setVar('noCV', $idPatient);
            return $view;
        } else if ($check == true){
            try {
                $this->modificationPatientService->updatePatient($pdo, $nom, $prenom, $genre, $adresse, $portable, $mail, $poids, $date, $allergies, $commentaires, $idPatient);
                $view->setVar('check', true);
                $view->setVar('nom', $nom);
                $view->setVar('prenom',$prenom);
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
                $view->setVar('allergies',$allergies);
                $view->setVar('commentaires',$commentaires);
                $view->setVar('noCV', $idPatient);
                return $view;
            }
        }

    }


}
