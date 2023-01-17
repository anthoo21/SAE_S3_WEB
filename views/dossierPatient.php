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
					Docteur <?php echo $_SESSION['nom']." ".$_SESSION['prenom']; ?>
				</div>	
			</div>
			
			<div class="row paddingForm">
				<div class="row formPatient">
					<!--Titre "Dossier du patient"-->
					<div class="col-md-7 col-sm-12 col-xs-12 titreDossier">
						Dossier de : <?php echo $nom.' '.$prenom;?> 
					</div>
					<div class="col-md-2 hidden-sm hidden-xs">
					</div>
					
					<!-- Boutons de modification -->
					<div class="col-md-1 col-sm-12 col-xs-12 titreDossier">
						<form action="index.php" method="post">
							<input hidden name="noCV" value="<?php echo $noCV;?>">
							<input hidden name="controller" value="ModificationPatient">
							<input hidden name="action" value="index">
							<button type="submit" class="btn btn-success btn-circle btn-xl" name="modifPatient" value="true" title="Modifier ce patient"><span class="fas fa-pencil"></span></button>		
							
						</form>
					</div>
					<!-- Boutons de suppression TODO-->
					<div class="col-md-1 col-sm-12 col-xs-12 titreDossier">
						<form action="index.php" method="post">
							<input hidden name="noCV" value="<?php echo $noCV;?>">
							<input hidden name="controller" value="SuppressionPatient">
							<input hidden name="action" value="index">
							<button type="submit" class="btn btn-danger btn-circle btn-xl" name="supprimePatient" value="true" title="Supprimer ce patient"><span class="fas fa-trash"></span></button>
						</form>
					</div>
					<!-- Boutons de retour -->
					<div class="col-md-1 col-sm-12 col-xs-12 titreDossier">
						<form action="index.php" method="post">
							<input hidden name="controller" value="Medecins">
							<input hidden name="action" value="index">
							<button type="submit" class="btn btn-danger btn-circle btn-xxl" name="retour" value="true" title="Retour à l'accueil medecin"><span class="fas fa-arrow-left"></span></button>
						</form>
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
									echo '<p>Adresse : '.$adresse.'</p>';
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
											<th>Visite</th>
											<th>Date</th>
											<th>Médecin</th>
											<th>Motif</th>
											<th>Ordonnance liée</th>
										</tr>
                                        <?php
                                            while($ligne = $searchStmt->fetch()) {
                                                echo '<form action="index.php" method="post">';
                                                echo '<tr>';
                                                echo '<td><button type="submit" class="btn btn-secondary" title="Voir la visite"><span class="fas fa-eye"></span></button></td>';
                                                echo '<input hidden name="idVisite" value="'.$ligne['id_visite'].'">';
                                                echo '<input hidden name="controller" value="VisitePatient">';// a rajouter -> direction fiche visite
                                                echo '<input hidden name="action" value="index">';// a rajouter -> direction fiche visite
                                                echo '<td>'.$ligne['date_visite'].'</td>';
                                                echo '<td>'.$ligne['nom'].' '.$ligne['prenom'].'</td>';
                                                echo '<td>'.$ligne['motif'].'</td>';
                                                echo '</form>';
                                                echo '<form action="index.php" method="post">';
                                                echo '<td><button type="submit" class="btn btn-secondary" title="Voir l\'ordonnance"><span class="fas fa-eye"></span></button></td>';
                                                echo '<input hidden name="idVisite" value="'.$ligne['id_visite'].'">';
                                                echo '<input hidden name="controller" value="OrdoPatient">';// a rajouter -> direction ordonnance
                                                echo '</tr>';
                                                echo '</form>';
                                            }
                                        ?>
									</div>
								</table>
							</div>
						</div>
						<!--Bouton "Ajouter une visite"  TODO a modif mvc-->
						<div class="row divBtnA">
							<form action="index.php" method="post">
								<input hidden name="controller" value="Visite">
								<input hidden name="idP" value="<?php echo $noCV; ?>">
								<button type="submit" class="btn btn-success btn-circle btn-xl" name="ajouter" value="true"><span class="fas fa-plus"></button> Ajouter une visite
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
  </body>
</html>
