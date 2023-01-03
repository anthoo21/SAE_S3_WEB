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

		//Récupération des données
		$ToutOK=true; //Savoir si toutes les données ont été rentrées
		
		
		// Toutes les données sont correctes
		if($ToutOK) {
			try {
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
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
						<a href="accueilMedecin.php"><button type="button" class="btn btn-info btn-circle btn-xl" name="patient" value="true" title="Patients"><span class="fas fa-user"></button></a>				
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
				<div class="row">
					<!--Titre "Recherche de médicaments"-->
					<div class="col-md-12 col-sm-12 col-xs-12 titre titreCreation">
						Recherche de médicaments
					</div>
					<div class="row paddingForm">
						<!--Recherche par critères-->
						<div class="row espaceB">
							<div class="row rechCri">
								<form class="rechercheCriteres" method="post" action="accueilMedecin.php">
									<!--Recherche par désignation -->
									<div class="col-md-6 col-sm-6 col-xs-12 inputCritere">
										<p class="text"><b>Désignation :</b></p>
										<input type="texte" name="designation" class="form-control" placeholder="Tapez un mot à chercher" value="<?php 
										if(isset($_POST['designation'])) {
											echo $_POST['designation'];
										} else {
											echo '';
										}
										?>">
									</div>
									
									<!--Recherche par types -->
									<div class="col-md-6 col-sm-6 col-xs-12 inputCritere">
										<p class="text"><b>Types :</b></p>
										<!-- Liste type médicament -->
										<select class="form-control" name="Type" id="type">
											<option value="TOUS">TOUS</option>
										</select>
									</div>
									
									<!--Recherche par substances -->
									<div class="col-md-6 col-sm-6 col-xs-12 inputCritere">
										<p class="text"><b>Substances :</b></p>
										<!-- Liste es substances -->
										<select class="form-control" name="substance" id="sub">
											<option value="TOUS">TOUTES</option>
										</select>
									</div>
									
									<!--Recherche par principes actifs -->
									<div class="col-md-6 col-sm-6 col-xs-12 inputCritere">
										<p class="text"><b>Principes actifs :</b></p>
										<!-- Liste des principes actifs -->
										<select class="form-control" name="principes" id="pa">
											<option value="TOUS">TOUS</option>
										</select>
									</div>
									
									<!--Recherche par médicaments génériques -->
									<div class="col-md-12 col-sm-12 col-xs-12 inputCritere">
										<p class="text"><b>Génériques ?</b></p>
										<input type="radio" name="generiques" id="generiqueOui" value="Oui">
										<label for="generiqueOui">Oui</label>
										<input type="radio" name="generiques" id="generiqueNon" value="Non">
										<label for="generiqueNon">Non</label>
									</div>
									
									<!--Bouton rechercher -->
									<div class="col-md-12 col-sm-12 col-xs-12 divBtn">
										<button type="submit" name="rechercher" value="Rechercher" class="btn-secondary form-control"><span class="fas fa-search"> R E C H E R C H E R</button>
									</div>	
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 titre">
						Résultat de la recherche
					</div>
					<div class="row divTable">
						<table class="table table-bordered table-striped">
							<div class="col-md-12">
								<tr>
									<th>Désignation</th>
									<th>Types</th>
									<th>Laboratoire</th>
									<th>Principes actifs</th>
									<th>Substances</th>
									<th>Génériques</th>
								</tr>
								<!-- TODO : médicaments -->
							</div>
						</table>
					</div>
				</div>
			</div>
		</div>
  </body>
</html>
