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

		// Récupération des données relatives au patient
		try {
			$requeteP="SELECT patients.nom, patients.prenom, patients.numeroCarteVitale, genres.sexe, patients.tel,
			patients.email, patients.dateNai, patients.poids, patients.allergies, patients.commentaires, medecins.nom nomMedecin, medecins.prenom prenomMedecin
			FROM patients JOIN medecins ON id_medecin = id_med JOIN genres ON patients.id_genre = genres.id_genre
			WHERE patients.numeroCarteVitale = :id";
			$resultats = $pdo->prepare($requeteP);
			$resultats->bindParam('id', $_POST['id']);
			$resultats->execute();
			while($ligne = $resultats->fetch()) {
				$nom = $ligne['nom'];
				$prenom = $ligne['prenom'];
				$noCV = $ligne['numeroCarteVitale'];
				$tel = $ligne['tel'];
				$email = $ligne['email'];
				$date = $ligne['dateNai'];
				$poids = $ligne['poids'];
				$genre = $ligne['sexe'];
				$medecin = $ligne['nomMedecin'].' '.$ligne['prenomMedecin'];
				$allergies = $ligne['allergies'];
				$commentaires = $ligne['commentaires'];
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		if(!isset($_POST['id'])) {
			header('Location: accueilMedecin.php');
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
						Dossier de : <?php echo $nom.' '.$prenom;?> 
					</div>
					<div class="col-md-3 hidden-sm hidden-xs">
					</div>
					
					<!-- Boutons de modification, suppression et retour -->
					<div class="col-md-2 col-sm-12 col-xs-12 titreDossier">
							<button type="button" class="btn btn-success btn-circle btn-xl" name="modifPatient" value="true" title="Modifier ce patient"><span class="fas fa-pencil"></span></button></a>				
							<button type="button" class="btn btn-success btn-circle btn-xl" name="supprimePatient" value="true" title="Supprimer ce patient"><span class="fas fa-trash"></span></button></a>
							<a href="accueilMedecin.php"><button type="submit" class="btn btn-danger btn-circle btn-xxl" name="retour" value="true" title="Retour à la liste des patients"><span class="fas fa-arrow-left"></span></button></a>
					</div>
					
					<!-- Affichage des informations générales du patient-->
					<div class="col-md-7 col-sm-12 col-xs-12 paddingDossier">
						<div class="col-md-12 col-sm-12 col-xs-12 bordureD">
							<div class="col-md-12 col-sm-12 col-xs-12 paddingForm">
								<?php
									echo '<h3 class="entete">Informations générales</h3>';
									echo '<p>Nom : '.$nom.'</p>';
									echo '<p>Prénom : '.$prenom.'</p>';
									echo '<p>Genre : '.$genre.'</p>';
									echo '<p>Portable : '.$tel.'</p>';
									echo '<p>Email : '.$email.'</p>';
									echo '<p>Date de naissance : '.$date.'</p>';
									echo '<p>Poids : '.$poids.'kg </p>';
									echo '<p>N° Carte vitale : '.$noCV.'</p>';
									echo '<p>Médecin traitant : '.$medecin.'</p>';
									echo '<p>Allergies : '.$allergies.'</p>';
								?>
							</div>
						</div>
					</div>
					
					<!-- Affichage des commentaires sur le patient -->
					<div class="col-md-5 col-sm-12 col-xs-12 paddingForm">
						<div class="col-md-12 col-sm-12 col-xs-12 bordureD">
							<div class="col-md-12 col-sm-12 col-xs-12 paddingForm">
								<h3 class="entete">Commentaires</h3>
								<?php echo $commentaires;?>
							</div>
						</div>
					</div>
					
					<!-- Affichage des visites de ce patient -->
					<div class="col-md-12 col-sm-12 col-xs-12 paddingForm">
						<div class="col-md-12 col-sm-12 col-xs-12 bordureD">
							<div class="col-md-12 col-sm-12 col-xs-12 paddingForm">
								<h3 class="entete">Historique des visites</h3> 
								<table class="table table-bordered table-striped">
									<div class="col-md-12">
										<tr>
											<th><span class="fas fa-eye"></th>
											<th>Date</th>
											<th>Médecin</th>
											<th>Motif</th>
											<th>Ordonnance liée</th>
										</tr>
										<?php 		
											// Récupération des données relatives aux visites du patient
											try {
												$requeteV="SELECT visites.date_visite, medecins.nom, medecins.prenom, visites.motif, ordonnances.id_ordo
												FROM visites 
												JOIN ordonnances ON visites.id_visite = ordonnances.id_visite 
												JOIN patients ON numeroCarteVitale = id_patient
												JOIN medecins ON visites.id_medecin = medecins.id_med 
												WHERE id_patient = :patient
												ORDER BY visites.date_visite";
												$resultatV = $pdo->prepare($requeteV);
												$resultatV->bindParam('patient', $noCV);
												$resultatV->execute();
												while($visite = $resultatV->fetch()) {
													echo '<tr>';
													echo '<td><button type="submit" class="btn btn-secondary" title="Voir la visite"><span class="fas fa-eye"></button>';
													echo '<td>'.$visite['date_visite'].'</td>';
													echo '<td>'.$visite['nom'].' '.$visite['prenom'].'</td>';
													echo '<td>'.$visite['motif'].'</td>';
													echo '<td>'.$visite['id_ordo'].'</td>';
													echo '</tr>';
												}
											} catch (PDOException $e) {
												echo $e->getMessage();
											}
										?>
									</div>
								</table>
							</div>
						</div>
						<!--Bouton "Ajouter une visite" -->
						<div class="row divBtnA">
							<a href="creationVisite.php"><button type="button" class="btn btn-success btn-circle btn-xl" name="ajouter" value="true"><span class="fas fa-plus"></button> Ajouter une visite  </a>
						</div>
					</div>
				</div>
			</div>
		</div>
  </body>
</html>
