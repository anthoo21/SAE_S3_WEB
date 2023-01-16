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
					<div class="col-md-4 col-sm-4 col-xs-4 ">
						<form action="index.php" method="post">
							<input hidden name="controller" value="Medecins">
							<input hidden name="action" value="index">
							<button type="submit" class="btn btn-info= btn-circle btn-xxl" name="deconnexion" value="true" title="Patients"><span class="fas fa-user"></button>
						</form>
					</div>
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
					<div class="col-md-4 hidden-sm hidden-xs">
					</div>
					
					<!-- Boutons de retour -->
					<div class="col-md-1 col-sm-12 col-xs-12 titreDossier">
						<form action="index.php" method="post">
							<input hidden name="controller" value="Medecins">
							<input hidden name="action" value="goToFichePatient">
							<input hidden name="numCarte" value="<?php echo $numeroCarteVitale;?>">
							<button type="submit" class="btn btn-danger btn-circle btn-xxl" name="retour" value="true" title="Retour à la fiche du patient	"><span class="fas fa-arrow-left"></span></button>
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
