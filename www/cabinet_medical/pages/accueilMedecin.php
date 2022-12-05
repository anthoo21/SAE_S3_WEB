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

			$host='localhost';	// Serveur de BD
			$db='medsoft';		// Nom de la BD
			$user='root';		// User 
			$pass='root';		// Mot de passe
			$charset='utf8mb4';	// charset utilisé

			// Constitution variable DSN
			$dsn="mysql:host=$host;dbname=$db;charset=$charset";

			// Réglage des options
			$options=[
				PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES=>false];

			try {
				$pdo=new PDO($dsn,$user,$pass,$options);
			} catch(PDOException $e){
				//Il y a eu une erreur 
				echo "<h1>Erreur : ".$e->getMessage();
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
				<img class="logo3" src="../assets/profil_patients.png" alt="logo patient">
				<img class="logo4" src="../assets/recherche_medicaments.png" alt="logo recherche">
				<img class="logo5" src="../assets/deconnexion.png" alt="logo deconnexion">
			</div>	
		</div>
		<!--Nom du docteur-->
		<div class="row">
		</br>
			<div class="col-md-12 col-sm-12 col-xs-12 doctorName">
				Docteur Calin TORGE <!--A générer depuis l'authentification-->
			</div>	
		</div></br>
		<!--Recherche par critères-->
		<div class="row espaceB">
			<div class="row rechCri">
				<form class="rechercheCriteres" method="post" action="accueilMedecin.php"> <!--TODO : PHP-->
					<div class="col-md-3 col-sm-12 col-xs-12">
						<h3>Recherche par critère :</h3>
					</div>
					<!--Recherche par nom prénom -->
					<div class="col-md-3 col-sm-4 col-xs-12 inputCritere">
						<input type="texte" name="rechercheNom" class="form-control" placeholder="NOM" value="<?php 
						if(isset($_POST['rechercheNom'])) {
							echo $_POST['rechercheNom'];
						} else {
							echo '';
						}
						?>">
					</div>
					<!--Recherche par numéro de sécurité sociale -->
					<div class="col-md-3 col-sm-4 col-xs-12 inputCritere">
						<input type="texte" name="rechercheNSecu" class="form-control" placeholder="N° Sécurité Sociale" value="<?php 
						if(isset($_POST['rechercheNSecu'])) {
							echo $_POST['rechercheNSecu'];
						} else {
							echo '';
						}
						?>">
					</div>
					<!--Bouton rechercher -->
					<div class="col-md-3 col-sm-4 col-xs-12 divBtn">
						<input type="submit" name="rechercher" value="Rechercher" class="buttonRechercher">
					</div>	
				</form>
			</div>
		</div>
		<!--Liste des patients-->
		<div class="row divTable">
			<table class="table table-bordered table-striped">
			<!--TODO : pb d'affichage -> 8 colonnes en ordi / 4 colonnes en tablette / 3 colonnes en smartphone-->
				<div class="col-md-12">
					<tr class="testtest">
							<th>Nom</th>
							<th>Prénom</th>
							<th>Genre</th>
							<th>Téléphone</th>
							<th>Email</th>
							<th>Date de naissance</th>
							<th>Dernière visite</th>
						</tr>
					<?php 
						if((isset($_POST['rechercheNom']) && $_POST['rechercheNom'] != "" ) || (isset($_POST['rechercheNSecu']) && $_POST['rechercheNSecu'] != "")) {
							$requeteSelect="";
							$nom = "%".$_POST['rechercheNom']."%";
							$nsecu = "%".$_POST['rechercheNSecu']."%";
							if(isset($_POST['rechercheNom']) && $_POST['rechercheNom'] != "" && isset($_POST['rechercheNSecu']) && $_POST['rechercheNSecu'] != "") {
								$requeteSelect="WHERE nom LIKE '".$nom."' AND numeroCarteVitale LIKE '".$nsecu."'";
							} else if(isset($_POST['rechercheNom']) && $_POST['rechercheNom'] != "") {
								$requeteSelect="WHERE nom LIKE '".$nom."'";
							} else if (isset($_POST['rechercheNSecu']) && $_POST['rechercheNSecu'] != "") {
								$requeteSelect="WHERE numeroCarteVitale LIKE '".$nsecu."'";
							}
							$resultats = $pdo->prepare("SELECT nom, prenom, sexe, tel, email, dateNai, date_visite FROM patients P JOIN genres G ON P.id_genre = G.id_genre JOIN visites ON id_patient = numeroCarteVitale ".$requeteSelect);
							$resultats->bindParam('nom', $_POST['rechercheNom']);
							$resultats->bindParam('nsecu', $_POST['rechercheNSecu']);
							$resultats->execute();

						} else {
							$requeteSelectALL="SELECT nom, prenom, sexe, tel, email, dateNai, date_visite FROM patients P JOIN genres G ON P.id_genre = G.id_genre JOIN visites ON id_patient = numeroCarteVitale"; 
							$resultats=$pdo->query($requeteSelectALL);
						}
						while($ligne = $resultats->fetch()) {
							echo '<tr>';
								echo '<td>'.$ligne['nom'].'</td>';
								echo '<td>'.$ligne['prenom'].'</td>';
								echo '<td>'.$ligne['sexe'].'</td>';
								echo '<td>'.$ligne['tel'].'</td>';
								echo '<td>'.$ligne['email'].'</td>';
								echo '<td>'.$ligne['dateNai'].'</td>';
								echo '<td>'.$ligne['date_visite'].'</td>'; //affiche seulement une des visites qu'ils ont
							echo '</tr>';
						}
					?>
				</div>
			</table>	
		</div>
		<!--Bouton "Ajouter un patient" -->
		<div class="row divBtnA">
			<a href="creationPatient.php"><img class="logo6" src="../assets/ajouter.png" alt="logo ajouter">  Ajouter un patient  </a>
		</div>
	</div>
  </body>
</html>