<!DOCTYPE html>
<html lang="Fr">
  <head>
      <title>MEDSOFT - Accueil Admin</title>
      <meta charset="utf-8">
	  <link rel="stylesheet" href="bootstrap\css\bootstrap.css">
	  <link rel="stylesheet" href="fontawesome-free-5.10.2-web\css\all.css">
	  <link rel="stylesheet" href="css\style.css"> 
  </head>
  
  <body>
  	<?php
		spl_autoload_extensions(".php");
		spl_autoload_register();

		use yasmf\HttpHelper;

	?>

	<div class="container">
		<!-- Nav-bar -->
		<div class="row nav">
			<div class="col-md-4 col-sm-4 col-xs-4">
				<img class="logo1" src="assets\logo_dessin.png" alt="logo plus">
				<img class="logo2" src="assets\logo_titre.png" alt="logo medsoft">
			</div>	
			<div class="col-md-4 col-sm-4 col-xs-4">
			<!--Espace dans la navbar-->
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4 logos">
				<img class="logo3" src="assets\profil_patients.png" alt="logo patient">
				<img class="logo4" src="assets\recherche_medicaments.png" alt="logo recherche">
				<img class="logo5" src="assets\deconnexion.png" alt="logo deconnexion">
			</div>	
		</div>
		<!--Nom du docteur-->
		<div class="row">
		</br>
			<div class="col-md-12 col-sm-12 col-xs-12 doctorName">
				Docteur <?php echo $_SESSION['nom']." ".$_SESSION['prenom']; ?>
			</div>	
		</div></br>
		<!--Recherche par critères-->
		<div class="row espaceB">
			<div class="row rechCri">
				<form class="rechercheCriteres" method="post" action="index.php"> <!--TODO : Modifier l'envoi pour appeler controller-->
					<input hidden name="action" value="index">
    				<input hidden name="controller" value="Medecins">
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
						<input hidden name="action" value="afficherSelectedPatients">
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
						<th class="thMed">Nom</th>
						<th class="thMed">Prénom</th>
						<th class="thMed">Genre</th>
						<th class="thMed">Téléphone</th>
						<th class="thMed">Email</th>
						<th class="thMed">Date de naissance</th>
						<th class="thMed">Dernière visite</th>
					</tr>
					<?php 
						while($ligne = $searchStmt->fetch()) {
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
			<form action="index.php" method="post">
				<input hidden name="controller" value="Patients">
				<input hidden name="action" value="index">
				<input type="submit" class="btnDeTest" value=""><label style="text-align: center">Ajouter un patient</label>
			</form>
		</div>
	</div>
  </body>
</html>
