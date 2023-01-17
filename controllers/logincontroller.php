<?php 
namespace controllers;

session_start();
use services\LoginService;
use services\MedecinsService;
use services\AdminsService;
use yasmf\HttpHelper;
use yasmf\View;

class LoginController {

    private $loginService;
    private $medecinsService;
    private $adminsService;

    /**
     * Create and initialize an LoginController object
     */
    public function __construct()
    {
        $this->loginService = LoginService::getDefaultService();
        $this->medecinsService = MedecinsService::getDefaultService();
        $this->adminsService = AdminsService::getDefaultService();
    }

    /**
     * @return View
     *  the view in charge of displaying the form to log in 
     */
    public function index() {
        // Test si on est bien connecté (session existante et bon numéro de session
        if (!isset($_SESSION['login']) || !isset($_SESSION['id']) || $_SESSION['id']!=session_id()) {
            // Renvoi vers la page de connexion
            $view = new View('SAE_S3_WEB/views/accueil');
            return $view;
            exit();
        }

        $view = new View('SAE_S3_WEB/views/acceuil');
        $view->setVar('erreurLog', false);
        return $view;
    }

    public function connexion($pdo) {
        if (isset($_POST['login']) && isset($_POST['password'])) {
            $login = htmlspecialchars(HttpHelper::getParam('login'));
            $mdp = md5(htmlspecialchars(HttpHelper::getParam('password')));
            $user = $this->loginService->getUser($pdo, $login, $mdp);

            if($user->rowCount() == 1) {
                // L'utilisateur existe dans la table
                // On ajoute ses infos en tant que variables de session
                while($donneesUtil = $user->fetch()) {
                    $role = $donneesUtil['code_role'];
                    $_SESSION['role'] = $role;
                }
                // Il s'agit d'un medecin
                if($_SESSION['role'] == 'MED') {
                    $medInfo = $this->loginService->getMedecinInfo($pdo, $login, $mdp);
                    while($donnees = $medInfo->fetch()) {
                        $_SESSION['nom'] = $donnees['nom'];
                        $_SESSION['prenom'] = $donnees['prenom'];
                        $_SESSION['role'] = $donnees['code_role'];
                        $_SESSION['login'] = $login;
                        $_SESSION['pwd'] = $mdp;
                        $_SESSION['id'] = session_id();
                        $_SESSION['idMed'] = $donnees['id_med'];
                    }
                    return $this->goToMedecinAccueil($pdo);
                } else { // Il s'agit d'un administrateur
                    $_SESSION['role'] = $role;
                    $_SESSION['login'] = $login;
                    $_SESSION['pwd'] = $mdp;
                    $_SESSION['id'] = session_id();
                    return $this->goToAdminAccueil($pdo);
                }
            } else {
                $view = new View('SAE_S3_WEB/views/accueil');
                $view->setVar('identifiant', $login);
                $view->setVar('erreurLog', true);
                return $view;
            }
        } 
    }

    public function goToMedecinAccueil($pdo) {
        $searchStmt = $this->medecinsService->findAllPatients($pdo, $_SESSION["idMed"]);
        $view = new View('SAE_S3_WEB/views/accueilMedecin');
        $view->setVar('searchStmt', $searchStmt);
        return $view;
    }

    public function goToAdminAccueil($pdo) {
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
}