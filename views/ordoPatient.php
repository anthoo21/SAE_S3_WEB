<!DOCTYPE html>
<html lang="Fr">
  <head>
      <title>MEDSOFT - Accueil Medecin</title>
      <meta charset="utf-8">
	  <link rel="stylesheet" href="bootstrap\css\bootstrap.css">
		<link rel="stylesheet" href="fontawesome-free-5.10.2-web\css\all.css">
		<link rel="stylesheet" href="css\style.css"> 
	  <script>
	function imprimer(divName) {
      	var printContents = document.getElementById(divName).innerHTML;    
		var originalContents = document.body.innerHTML;      
		document.body.innerHTML = printContents;     
		window.print();     
		document.body.innerHTML = originalContents;
   }
</script>
	  </script>
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
			
			<div class="row paddingForm" id="divImprimer">
				<div class="row formPatient">
					<!--Titre "Dossier du patient"-->
					<div class="col-md-7 col-sm-12 col-xs-12 titreDossier">
						Ordonnance du : <?php echo $dateVisite;?> 
					</div>
					<div class="col-md-3 hidden-sm hidden-xs">
					</div>
					
					<div class="col-md-1 col-sm-12 col-xs-12 titreDossier">
						<a href="#"><button type="button" class="btn btn-info btn-circle btn-xxl" title="Imprimer l'ordonnance" onclick="imprimer('divImprimer')"><span class="fa-solid fa-print"></span></button></a>
					</div>

					<!-- Boutons de retour -->
					<div class="col-md-1 col-sm-12 col-xs-12 titreDossier">
						<form action="index.php" method="post">
							<input type="hidden" name="controller" value="Medecins">
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
								<h3 class="entete">Prescriptions</h3>
								<?php
								while($lignes = $getDonneesPrescri->fetch()) {
									echo '<ul>';
									echo '<li>'.$lignes['denomination'].' ('.$lignes['posologie'].')</li>';
									echo '</ul>';
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
  </body>
</html>
