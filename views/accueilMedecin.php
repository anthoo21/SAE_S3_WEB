<!DOCTYPE html>
<html lang="Fr">
  <head>
      <title>MEDSOFT - Accueil Medecin</title>
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
					<div class="col-md-4 col-sm-4 col-xs-4 ">
						<form action="index.php" method="post">
							<input hidden name="controller" value="Medecins">				
							<button type="submit" class="btn btn-info btn-circle btn-xl" name="recherche" value="true" title="Recherche"><span class="fas fa-search"></button>
						</form>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4 ">
						<form action="index.php" method="post">
							<input hidden name="controller" value="Medecins">
							<input hidden name="action" value="deconnexion">
							<button type="submit" class="btn btn-danger btn-circle btn-xxl" name="deconnexion" value="true" title="Déconnexion"><span class="fas fa-power-off"></button>
						</form>
					</div>
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
			
				<div class="col-md-12">
					<tr class="testtest">
						<th class="thMed">Nom</th>
						<th class="thMed">Prénom</th>
						<th class="thMed">Genre</th>
						<th class="thMed">Téléphone</th>
						<th class="thMed">Email</th>
						<th class="thMed">Date de naissance</th>
						<th class="thMed">Num Carte Vitale</th>
						<th class="thMed"><span class="fas fa-eye"></th>
					</tr>
					<?php 
						while($ligne = $searchStmt->fetch()) {
							echo '<form action="index.php" method="post">';
							echo '<tr>';
								echo '<td>'.$ligne['nom'].'</td>';
								echo '<td>'.$ligne['prenom'].'</td>';	
								echo '<td>'.$ligne['sexe'].'</td>';
								echo '<td>'.$ligne['tel'].'</td>';
								echo '<td>'.$ligne['email'].'</td>';
								echo '<td>'.$ligne['dateNai'].'</td>';
								echo '<td>'.$ligne['numeroCarteVitale'].'</td>';
								echo '<input hidden name="numCarte" value="'.$ligne['numeroCarteVitale'].'">';
								echo '<input hidden name="controller" value="Medecins">';
								echo '<input hidden name="action" value="goToFichePatient">';
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
			<form action="index.php" method="post">
				<input hidden name="controller" value="Patients">
				<input hidden name="action" value="index">
				<input type="submit" class="btnDeTest" value=""><label style="text-align: center">Ajouter un patient</label>
			</form>
		</div>
	</div>
  </body>
</html>
