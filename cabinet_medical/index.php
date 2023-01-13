<?php
session_start();	// démarrage d'une session

$erreur = false;	// Vérifie s'il y a des erreur lors de l'authentification
// Vérification des données entrées dans le formulaire
if (isset($_POST['login']) && isset($_POST['password'])) {

	$login = htmlspecialchars($_POST['login']);
	$pwd = htmlspecialchars($_POST['password']);
	
	// Gestion de la connexion à la base de données
	$host = 'localhost';
	$db = 'medsoft';
	$user = 'root';
	$pass = 'root';
	$charset = 'utf8mb4';
	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
	$options = [
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES => false
	];
	try {
		$pdo = new PDO($dsn, $user, $pass, $options);
	} catch (PDOException $e) {
		echo $e->getMessage();
	}
	
	// Récupération de l'utilisateur depuis la BDD
	$requete  = "SELECT * FROM utilisateurs WHERE identifiant = :log AND motDePasse = :mdp";
	$stmt = $pdo->prepare($requete);
	$stmt->bindParam('log', $login);
	$stmt->bindParam('mdp', $pwd);
	$stmt->execute();
	if($stmt->rowCount() == 1) {
		// L'utilisateur existe dans la table
		// On ajoute ses infos en tant que variables de session
		while($donneesUtil = $stmt->fetch()) {
			$role = $donneesUtil['code_role'];
			$_SESSION['role'] = $role;
		}
		// Il s'agit d'un medecin
		if($_SESSION['role'] == 'MED') {
			$requeteMedecin  = "SELECT medecins.id_med, medecins.nom, medecins.prenom, utilisateurs.code_role FROM utilisateurs JOIN medecins ON identifiant = id_util WHERE identifiant = :log AND motDePasse = :mdp";
			$stmt1= $pdo->prepare($requeteMedecin);
			$stmt1->bindParam('log', $login);
			$stmt1->bindParam('mdp', $pwd);
			$stmt1->execute();
			while($donnees = $stmt1->fetch()) {
				$nom = $donnees['nom'];
				$prenom = $donnees['prenom'];
				$role = $donnees['code_role'];
				$_SESSION['nom'] = $nom;
				$_SESSION['prenom'] = $prenom;
				$_SESSION['role'] = $role;
				$_SESSION['login'] = $login;
				$_SESSION['pwd'] = $pwd;
				$_SESSION['id'] = session_id();
				$_SESSION['idMed'] = $donnees['id_med'];
			}
		// Il s'agit d'un administrateur
		} else {
			$_SESSION['role'] = $role;
			$_SESSION['login'] = $login;
			$_SESSION['pwd'] = $pwd;
			$_SESSION['id'] = session_id();
		}
		// Variable indiquant que l'authentification a réussi
		$authOK = true;
	} else {
		$erreur = true;
	}
}
?>
<!DOCTYPE html>
<html lang="Fr">
  <head>
      <title>MEDSOFT - Accueil</title>
      <meta charset="utf-8">
	  <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
	  <link rel="stylesheet" href="fontawesome-free-5.10.2-web/css/all.css">
	  <link rel="stylesheet" href="css/style.css"> 
  </head>
  
  <body class="body">
	<div class="container 1">
		<!-- Nav-bar -->
		<div class="row nav">
			<div class="col-md-6 col-sm-12 col-xs-12">
				<img class="logo1" src="assets/logo_dessin.png" alt="nav bar">
				<img class="logo2" src="assets/logo_titre.png" alt="nav bar">
			</div>	
		</div>
		<!--Image accueil-->
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="home">
					Bienvenue sur le site </br>de notre cabinet MedSoft
				</div>
			</div>	
		</div>
		<!--Authentification-->
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<?php if($erreur == true) { ?>
						<div class="row">
							<h3 class="enRouge center">Identifiant ou mot de passe incorrect !</h3>
							<h4 class="enRouge center"><i>Merci de saisir correctement vos coordonnées de connexion !</i></h4>
						</div>
				<?php ;} ?>
					<form action="index.php" method="post">
						<p class="titre">Connexion à mon compte : </p>
						<div class="row">
							<!--Identifiant correct (non vide): apparaît en vert sinon en rouge-->
							<div class="col-md-5 col-sm-12 col-xs-12">
								<label>Identifiant : </label>				
							</div>
							<div class="col-md-7 col-sm-12 col-xs-12">
								<input type="text" name="login" class="form-control saisie fond">
							</div>
						</div>
						<div class="row">
						<!--Mot de passe correct (non vide) : apparaît en vert sinon en rouge-->
							<div class="col-md-5 col-sm-12 col-xs-12">
								<label>Mot de passe : </label>
							</div>
							<div class="col-md-7 col-sm-12 col-xs-12">
								<input type="password" name="password" class="form-control saisie fond">
							</div>
						</div>
						<div class="row divBouton">
							<!--Identifiant et mot de passe dans la BDD : affichage page d'accueil-->
							<input type="submit" name="connexion" value="Me connecter" class="buttonConnect">
						</div>
					</form>
					<?php
					if(isset($authOK)) {
						if($_SESSION['role']=='MED') {
							header ('Location: pages/accueilMedecin.php');
						} else {
							header ('Location: pages/accueilAdmin.php');
						}
					}
					?>
			</div>	
		</div>
	</div>
  </body>
</html>
