<?php
session_start(); //démarrage d'une session

	// Test si on est bien connecté (session existante et bon numéro de session
	if (!isset($_SESSION['login']) || !isset($_SESSION['id']) || $_SESSION['id']!=session_id()) {
		// Renvoi vers la page de connexion
  		header('Location: ../index.php');
  		exit();
	}

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
				<form action="accueilMedecin.php" method="post">				
					<a href="recherche.php"><button type="button" class="btn btn-info btn-circle btn-xl" name="recherche" value="true" title="Recherche"><span class="fas fa-search"></button></a>
					<button type="submit" class="btn btn-danger btn-circle btn-xxl" name="deconnexion" value="true" title="Déconnexion"><span class="fas fa-power-off"></button>
				</form>
			</div>	
		</div>
		
		<!--NOM DU DOCTEUR-->
		<div class="row">
		</br>
			<div class="col-md-12 col-sm-12 col-xs-12 doctorName">
			<?php 
					echo "Docteur ".$_SESSION['nom'].' '.$_SESSION['prenom'];
			?>
			</div>	
		</div></br>
		
		<!--Recherche par critères-->
		<div class="row espaceB">
			<div class="row rechCri">
				<form class="rechercheCriteres" method="post" action="accueilMedecin.php">
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
				<div class="col-md-12">
					<tr class="testtest">
							<th class="thMed">Nom</th>
							<th class="thMed">Prénom</th>
							<th class="thMed">Genre</th>
							<th class="thMed">Téléphone</th>
							<th class="thMed">Email</th>
							<th class="thMed">Date de naissance</th>
							<th class="thMed">N° Sécu sociale</th>
							<th class="thMed"><span class="fas fa-eye"></th>
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
							$resultats = $pdo->prepare("SELECT numeroCarteVitale, nom, prenom, sexe, tel, email, dateNai, date_visite FROM patients P JOIN genres G ON P.id_genre = G.id_genre JOIN visites ON id_patient = numeroCarteVitale ".$requeteSelect." ORDER BY nom");
							$resultats->bindParam('nom', $_POST['rechercheNom']);
							$resultats->bindParam('nsecu', $_POST['rechercheNSecu']);
							$resultats->execute();

						} else {
							$requeteSelectALL="SELECT numeroCarteVitale, nom, prenom, sexe, tel, email, dateNai FROM patients P JOIN genres G ON P.id_genre = G.id_genre ORDER BY nom"; 
							$resultats=$pdo->query($requeteSelectALL);
						}
						while($ligne = $resultats->fetch()) {
							echo '<form action="dossierPatient.php" method="post">';
							echo '<tr>';
								echo '<input type="hidden" name="id" value="'.$ligne['numeroCarteVitale'].'">'; // Problème affichage recherche par critères
								echo '<td>'.$ligne['nom'].'</td>';
								echo '<td>'.$ligne['prenom'].'</td>';
								echo '<td>'.$ligne['sexe'].'</td>';
								echo '<td>'.$ligne['tel'].'</td>';
								echo '<td>'.$ligne['email'].'</td>';
								echo '<td>'.$ligne['dateNai'].'</td>';
								echo '<td>'.$ligne['numeroCarteVitale'].'</td>';
								echo '<td><button type="submit" class="btn btn-secondary" title="Voir le dossier"><span class="fas fa-eye"></button>';
							echo '</tr>';
							echo '</form>';
						}
					?>
				</div>
			</table>	
		</div>
		<!--Bouton "Ajouter un patient" -->
		<div class="row divBtnA">
			<a href="creationPatient.php"><button type="button" class="btn btn-success btn-circle btn-xl" name="ajouter" value="true"><span class="fas fa-plus"></button> Ajouter un patient  </a>
		</div>
	</div>
  </body>
</html>
