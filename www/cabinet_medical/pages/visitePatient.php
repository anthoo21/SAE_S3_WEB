<?php
session_start(); //démarrage d'une session

	// Test si on est bien connecté (session existante et bon numéro de session
	if (!isset($_SESSION['login']) || !isset($_SESSION['id']) || $_SESSION['id']!=session_id()) {
		// Renvoi vers la page de connexion
  		header('Location: ../index.php');
  		exit();
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

		// $_SESSION['idPatient'] = $_POST['id'];
		$_SESSION['idVisite'] = $_POST['idVisite'];
		
		// Récupération des données relatives au patient
		try {
			$requeteV="SELECT patients.nom np, patients.prenom pp, patients.dateNai, patients.poids, 
			patients.commentaires, visites.motif, visites.date_visite, medecins.nom nm,
			medecins.prenom pm, visites.observations
			FROM patients 
			JOIN visites ON patients.numeroCarteVitale = visites.id_patient
			JOIN genres ON patients.id_genre = genres.id_genre
			JOIN medecins ON visites.id_medecin = medecins.id_med
			WHERE visites.id_visite = :idVisite";
			$resultats = $pdo->prepare($requeteV);
			$resultats->bindParam('idVisite', $_SESSION['idVisite']);
			$resultats->execute();
			while($ligne = $resultats->fetch()) {
				$nomPrenomPatient = $ligne['np'].$ligne['pp'];
				$nomPrenomMedecin = $ligne['nm']." ".$ligne['pm'];
				$dateVisite = $ligne['date_visite'];
				$poids = $ligne['poids'];
				$commentaires = $ligne['commentaires'];
				$dateNaissance = $ligne['dateNai'];
				$motif = $ligne['motif'];
				$observations = $ligne['observations'];
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		// Si le bouton "Voir la visite" depuis "dossierPatient.php" n'est pas activé
		if(!isset($_SESSION['idVisite']) and !$_SESSION['idVisite']) {
			header('Location: dossierPatient.php');
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
				<div class="col-md-4 col-sm-4 col-xs-4 logos">
					<form action="accueilMedecin.php" method="post">
						<a href="accueilMedecin.php"><button type="button" class="btn btn-info btn-circle btn-xl" name="patient" value="true" title="Patients"><span class="fas fa-user"></button></a>				
						<a href="recherche.php"><button type="button" class="btn btn-info btn-circle btn-xl" name="recherche" value="true" title="Recherche"><span class="fas fa-search"></button></a>
						<button type="submit" class="btn btn-danger btn-circle btn-xxl" name="deconnexion" value="true" title="Déconnexion"><span class="fas fa-power-off"></button>
					</form>
				</div>	
			</div>
			
			<!--Nom du docteur-->
			<div class="row">
				</br>
				<div class="col-md-12 col-sm-12 col-xs-12 doctorName">
					<?
						echo "Docteur ".$_SESSION['nom'].' '.$_SESSION['prenom'];
					?>
				</div>	
			</div>
			
			<div class="row paddingForm">
				<div class="row formPatient">
					<!--Titre "Dossier du patient"-->
					<div class="col-md-7 col-sm-12 col-xs-12 titreDossier">
						Visite du : <?php echo $dateVisite;?> 
					</div>
					<div class="col-md-2 hidden-sm hidden-xs">
					</div>
					
					<!-- Boutons de retour -->
					<div class="col-md-1 col-sm-12 col-xs-12 titreDossier">
						<form action="dossierPatient.php" method="post">
							<button type="submit" class="btn btn-danger btn-circle btn-xxl" name="retour" value="true" title="Retour à la liste des patients"><span class="fas fa-arrow-left"></span></button>
						</form>
					</div>
					
					<!-- Affichage des informations de la visites-->
					<div class="col-md-7 col-sm-12 col-xs-12 paddingDossier">
						<div class="col-md-12 col-sm-12 col-xs-12 bordureD">
							<div class="col-md-12 col-sm-12 col-xs-12 paddingForm">
								<?php
									echo '<h3 class="entete">Patients : '.$nomPrenomPatient.'</h3>';
									echo '<p>Date naissance : '.$dateNaissance.'</p>';
									echo '<p>Poids : '.$poids.'</p>';
									echo '<p>Commentaires : '.$commentaires.'</p>';
									echo '<p>Motif de la visite : '.$motif.'</p>';
									echo '<p>Médecin traitant : '.$nomPrenomMedecin.'</p>';
								?>
							</div>
						</div>
					</div>
					<!-- Affichage des observations sur le patient -->
					<div class="col-md-5 col-sm-12 col-xs-12 paddingForm">
						<div class="col-md-12 col-sm-12 col-xs-12 bordureD">
							<div class="col-md-12 col-sm-12 col-xs-12 paddingForm">
								<h3 class="entete">Observation</h3>
								<?php echo $observations;?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
  </body>
</html>
