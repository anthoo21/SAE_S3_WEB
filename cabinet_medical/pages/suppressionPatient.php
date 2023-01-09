<?php
session_start(); //démarrage d'une session


//Vérification que les variables sessions de l'utilisateur existent
if(isset($_SESSION['login']) && isset($_SESSION['pwd'])) {
	$login = $_SESSION['login'];
	$pwd = $_SESSION['pwd'];
	$nom = $_SESSION['nom'];
	$prenom = $_SESSION['prenom'];
}

// Déconnexion
if(isset($_POST['deconnexion']) && $_POST['deconnexion']) {
	session_destroy();
	header('Location: ../index.php');
  	exit();
}
?>
<!DOCTYPE html>
<html lang="Fr">
  <head>
      <title>MEDSOFT - Accueil Medecin</title>
      <meta charset="utf-8">
	  <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
	  <link rel="stylesheet" href="../fontawesome-free-6.2.1-web/css/all.css">
	  <link rel="stylesheet" href="../css/style.css"> 
  </head>
  
  <body>
  
	<?php
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
			//throw new PDOException($e->getMessage(), (int)$e->getCode());
		}

		?>
			<div class="container">
				<!-- Nav-bar -->
				<div class="row nav">
					<div class="col-md-4 col-sm-4 col-xs-4">
						<img class="logo1" src="../assets/logo_dessin.png" alt="logo plus">
						<img class="logo2" src="../assets/logo_titre.png" alt="logo medsoft">
					</div>	
					<div class="col-md-4 col-sm-4 col-xs-4">
					<!--Espace dans la navbar-->
					</div>
					<!-- Boutons -->
					<div class="col-md-4 col-sm-4 col-xs-4 logos">
						<form action="accueilMedecin.php" method="post">
							<button type="button" class="btn btn-info btn-circle btn-xl" name="patient" value="true"><span class="fas fa-user"></button>				
							<button type="button" class="btn btn-info btn-circle btn-xl" name="recherche" value="true"><span class="fas fa-search"></button>
							<button type="submit" class="btn btn-danger btn-circle btn-xxl" name="deconnexion" value="true"><span class="fas fa-power-off"></button>
						</form>
					</div>	
				</div>
				<!--Nom du docteur-->
				<div class="row">
					</br>
					<div class="col-md-12 col-sm-12 col-xs-12 doctorName">
						<?php echo "Docteur ".$_SESSION['nom'].' '.$_SESSION['prenom']; ?>
					</div>	
				</div>
				<div class="row paddingForm">
					<div class="row formPatient">
						<!--Message-->
						<div class="col-md-12 col-sm-12 col-xs-12 titreOK">
							<h2>Si vous supprimer ce patient, les visites et ordonnances qui lui sont associées seront également supprimer.</h2>
							<h2>Voulez-vous continuer ?</h2>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 titreOK">
							<!-- TODO : Bouton oui/non-->
						</div>
						<!--Retour-->
						<div class="col-md-12 col-sm-12 col-xs-12">
							<a href="dossierPatient.php"><span class="fas fa-home"></span> -- Retour au dossier patient</a>
						</div>
					</div>
				</div>
			</div>
  </body>
</html>
