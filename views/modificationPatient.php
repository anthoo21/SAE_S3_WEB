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
							<input hidden name="controller" value="Recherche">		
							<input hidden bame="action" value="index">		
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
						<?php echo "Docteur ".$_SESSION['nom'].' '.$_SESSION['prenom']; ?>
					</div>	
				</div>
	<?php if ($check == true) { ?>
				<div class="row paddingForm">
					<div class="row formPatient">
						<!--Message-->
						<div class="col-md-12 col-sm-12 col-xs-12 titreOK">
							<h2>Enregistrement des modifications apportées au patient <?php echo $nom.' '.$prenom;?>.</h2>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12"></br></br></div>
						<!--Retour accueil-->
						<!-- Boutons de retour -->
						<div class="col-md-1 col-sm-12 col-xs-12 titreDossier">
							<form action="index.php" method="post">
								<input hidden name="controller" value="Medecins">
								<input hidden name="action" value="index">
								<button type="submit" class="btn btn-danger btn-circle btn-xxl" name="retour" value="true" title="Retour à l'accueil medecin"><span class="fas fa-arrow-left"></span></button>
							</form>
						</div>
					</div>
				</div>
			</div>
		<?php					
		} else if($check == false) {
			if(isset($erreur)) {
				echo "<h1 class='color'>Erreur PDO : </h1></br>";
				echo $erreur;
			}
		?>
				<div class="row paddingForm">
					<div class="row formPatient">
						<!--Titre "Création d'un patient"-->
						<div class="col-md-12 col-sm-12 col-xs-12 titre titreCreation">
							Modification du patient : <?php echo $nom.' '.$prenom;?>
						</div>
						<div class="row paddingForm">
							<!--Formulaire-->
							<form action="index.php" method="post">
								<div class="col-md-12 col-sm-12 col-xs-12 formPatient">
								
									<!--Partie Gauche-->
									<div class="col-md-6 col-sm-12 col-xs-12 formGD">
										<!--Saisie du nom-->
										<div class="row">
											<div class="col-md-6 col-sm-6 col-xs-12 <?php if(isset($nom) && $nom=="") { echo "enRouge";}?>">
												<label for="newNom">Nom : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="nom" class="form-control" value="<?php echo $nom;?>">
											</div>
										</div>
										<div class="row">
											<!--Saisie du prénom-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if(isset($prenom) && $prenom=="") { echo "enRouge";}?>">
												<label for="prenom">Prénom : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="prenom" class="form-control"  value="<?php echo $prenom;?>">
											</div>
										</div>
										<div class="row">
											<!--Saisie du Genre-->
											<div class="col-md-6 col-sm-6 col-xs-12 <?php if(isset($genre) && $genre==null) { echo "enRouge";}?>">
												<label for="genre">Genre: </label>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-6">
												<input type="radio" name="genre"  value="01" class="btnRadio form-control" <?php if($genre=="01") { echo 'checked="checked"'; }?>>Féminin
											</div>
											<div class="col-md-3 col-sm-3 col-xs-6">
												<input type="radio" name="genre" value="02" class="btnRadio form-control" <?php if($genre=="02") { echo 'checked="checked"'; }?>>Masculin
											</div>
										</div>
										<div class="row">
											<!--Saisie de l'adresse-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if(isset($adresse) && $adresse=="") { echo "enRouge";}?>">
												<label for="adresse">Adresse : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="adresse" class="form-control" value="<?php echo $adresse;?>">
											</div>
										</div>
										<div class="row">
											<!--Saisie du téléphone-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if(isset($portable) && $portable=="") { echo "enRouge";}?>">
												<label for="newPortable">Portable : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="tel" name="portable" class="form-control" pattern="[0][0-9]{1}[0-9]{8}" value="<?php echo $portable;?>">
											</div>
										</div>
										<div class="row">
											<!--Saisie du mail-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if(isset($mail) && $mail=="") { echo "enRouge";}?>">
												<label for="mail">Email : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="email" name="mail" class="form-control" value="<?php echo $mail;?>">
											</div>
										</div>
										<div class="row">
											<!--Saisie de la date de naissance-->
											<div class="col-md-6 col-sm-6 col-xs-12 <?php if(isset($date) && $date=="") { echo "enRouge";}?>">
												<label for="newDate">Date de naissance : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="date" name="date" class="form-control" value="<?php echo $date;?>">
											</div>
										</div>
									</div>
								
									<!--Partie Droite-->
									<div class="col-md-6 col-sm-12 col-xs-12 formGD">
										<div class="row">
											<!--Saisie du poids-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if(isset($poids) && $poids=="") { echo "enRouge";}?>">
												<label for="newPoids">Poids: </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="poids" class="form-control" placeholder="Ex : 112.500" value="<?php echo $poids;?>">
											</div>
										</div>
										<div class="row">
											<!--Saisie de l'allergie-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if(isset($allergies) && $allergies=="") { echo "enRouge";}?>">
												<label for="newAllergies">Allergie: </label>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-6">
												<input type="radio" name="allergies" value="oui" class="btnRadio form-control" <?php if($allergies=="oui") { echo 'checked="checked"'; }?>>Oui
											</div>
											<div class="col-md-3 col-sm-3 col-xs-6">
												<input type="radio" name="allergies" value="non" class="btnRadio form-control" <?php if($allergies=="non") { echo 'checked="checked"'; }?>>Non
											</div>
										</div>
										<div class="row">
											<!--Saisie de commentaires-->
											<div class="col-md-12 col-sm-7 col-xs-12">
												<label for="newCom">Commentaires: </label>
											</div>
											<div class="col-md-12 col-sm-6 col-xs-12">
												<textarea name="commentaires" rows="7" cols="45"><?php echo $commentaires;?></textarea>
											</div>
										</div>
										<div class="row">
											<!--Médecin traitant-->
											<div class="col-md-12 col-sm-12 col-xs-12">
												<label>Médecin traitant : </label>
												<?php echo $_SESSION['nom'].' '.$_SESSION['prenom']; ?>
											</div>
										</div>
									</div>
									
									<!--Bouton Valider-->
									<div class="col-md-12 col-sm-12 col-xs-12">
										<div class="row divBouton buttonVert">
											<input hidden name="controller" value="ModificationPatient">
											<input hidden name="action" value="updatePatient">
											<input hidden name="noCV" value="<?php echo $noCV ?>">
											<input type="submit" name="valider" value="VALIDER" class="buttonValid form-control">
										</div>
									</div>
									
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		<?php
			}
		?>
  </body>
</html>
