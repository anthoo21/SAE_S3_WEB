<!DOCTYPE html>
<html lang="Fr">
  <head>
      <title>MEDSOFT - Accueil Medecin</title>
      <meta charset="utf-8">
	  <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
	  <link rel="stylesheet" href="../fontawesome-free-5.10.2-web/css/all.css">
	  <link rel="stylesheet" href="../css/style.css"> 
  </head>
  
  <body>
	<?php 

	$host='localhost';	// Serveur de BD
	$db='cabinetmedical';		// Nom de la BD
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
		$derniereVisite = "SELECT date_visite FROM visites WHERE id_visite = (SELECT MAX(id_visite) FROM visites)";
		$requeteSelectALL="SELECT nom, prenom, sexe, adresse, tel, email, dateNai FROM patients P JOIN genres G ON P.id_genre = G.id_genre"; 
		$resultats=$pdo->query($requeteSelectALL);
		$resultVisite=$pdo->query($derniereVisite);
	} catch(PDOException $e){
		//Il y a eu une erreur 
		echo "<h1>Erreur : Base de données non accessible";
	}
	
	?>
	<div class="container">
		<!-- Nav-bar -->
		<div class="row nav align-items-center">
			<div class="col-md-5 col-sm-5 col-xs-5">
				<img class="logo1" src="../assets/logo_dessin.png" alt="logo plus">
				<img class="logo2" src="../assets/logo_titre.png" alt="logo medsoft">
			</div>	
			<div class="col-md-2 col-sm-2 col-xs-2">
			</div>
			<div class="col-md-5 col-sm-5 col-xs-5">
				<img class="logo3" src="../assets/profil_patients.png" alt="logo patient">
				<img class="logo4" src="../assets/recherche_medicaments.png" alt="logo recherche">
				<img class="logo5" src="../assets/deconnexion.png" alt="logo deconnexion">
			</div>	
		</div>
		<!--Nom du docteur-->
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 doctorName">
				Docteur Calin TORGE <!--A générer depuis l'authentification-->
				<hr>
			</div>	
		</div>
		<!--Recherche par critères-->
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 cadre">
				<form>
					<div class="col-md-4 formulaire"><label>Recherche par critère : </label></div>
					<div class="col-md-4 formulaire"><input type="text" name="critere" placeholder="NOM Prénom" class="form-control"></div>
					<div class="col-md-4 formulaire"><input type="text" name="secu" placeholder="N° Sécurité sociale" class="form-control"></div>
					<!--TODO Recherche par nom-->
					<!--TODO Recherche par n° de sécu-->
					<!--TODO Bouton-->
				</form>
			</div>	
		</div>
		<!--Liste des patients-->
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<table class="table table-bordered">
					<tr class="testtest">
						<th>Nom</th>
						<th>Prénom</th>
						<th>Genre</th>
						<th>Adresse</th>
						<th>Téléphone</th>
						<th>Email</th>
						<th>Date de naissance</th>
						<th>Dernière visite</th>
					</tr>
					<tr>
					<?php 
						while($ligne = $resultats->fetch()) {
							echo '<td>'.$ligne['nom'].'</td>';
							echo '<td>'.$ligne['prenom'].'</td>';
							echo '<td>'.$ligne['nom'].'</td>';
							echo '<td>'.$ligne['nom'].'</td>';
							echo '<td>'.$ligne['nom'].'</td>';
							echo '<td>'.$ligne['nom'].'</td>';
							echo '<td>'.$ligne['nom'].'</td>';
							echo '<td>'.$ligne['nom'].'</td>';
						}
					?>
					</tr>
				</table>
			</div>	
		</div>
	</div>
  </body>
</html>