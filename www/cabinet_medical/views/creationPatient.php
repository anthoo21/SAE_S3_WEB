<!DOCTYPE html>
<html lang="Fr">
  	<head>
		<title>MEDSOFT - Création d'un patient</title>
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
					<img class="logo1" src="../assets/logo_dessin.png" alt="logo plus">
					<img class="logo2" src="../assets/logo_titre.png" alt="logo medsoft">
				</div>	
				<div class="col-md-4 col-sm-4 col-xs-4">
				<!--Espace dans la navbar-->
				</div>
				<div class="col-md-4 col-sm-4 col-xs-4 logos">
					<a href="accueilMedecin.php"><img class="logo3" src="../assets/profil_patients.png" alt="logo patient"></a>
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
			</div>
			<div class="row paddingForm">
				<div class="row formPatient">
					<!--Titre "Création d'un patient"-->
					<div class="col-md-12 col-sm-12 col-xs-12 titre titreCreation">
						Création d'un patient
					</div>
				</div>
			</div>
			<?php
				//Récupération de l'ID du médecin connecté => TODO
				$id_medecin="001";
				if ($check == true) {
			?>
			<div class="row">
				<!--Message-->
				<div class="col-md-12 col-sm-12 col-xs-12 titreOK">
					<h2>Enregistrement du nouveau patient validé !</h2>
				</div>
				<!--Retour accueil-->
				<div class="col-md-12 col-sm-12 col-xs-12">
					<a href="">Retour à ma page d'accueil</a>
				</div>
			</div>
			<?php					
				} else if($check == false) {
			?>
			<!--Formulaire-->
			<form action="index.php" method="post">
				<div class="col-md-12 col-sm-12 col-xs-12 formPatient">
					<!--Partie Gauche-->
					<div class="col-md-6 col-sm-12 col-xs-12 formGD">
						<!--Saisie du nom-->
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-12 <?php if(isset($nom) && $nom=="") { echo "enRouge";}?>">
								<label for="nom">Nom : </label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" name="nom" class="form-control" value="<?php if(isset($nom) && $nom!="") { echo $nom;}?>">
							</div>
						</div>
						<div class="row">
							<!--Saisie du prénom-->
							<div class="col-md-6 col-sm-6 col-xs-12  <?php if(isset($prenom) && $prenom=="") { echo "enRouge";}?>">
								<label for="prenom">Prénom : </label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" name="prenom" class="form-control" value="<?php if(isset($prenom) && $prenom=="") { echo $prenom;}?>">
							</div>
						</div>
						<div class="row">
							<!--Saisie du Genre-->
							<div class="col-md-6 col-sm-6 col-xs-12  <?php if(isset($genre) && $genre=="null") { echo "enRouge";}?>">
								<label for="genre">Genre : </label>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-6">
								<input type="radio" name="genre"  value="01" class="btnRadio form-control" <?php if(isset($genre) && $genre=="01") { echo 'checked="checked"'; }?>>Féminin
							</div>
							<div class="col-md-3 col-sm-3 col-xs-6">
								<input type="radio" name="genre" value="02" class="btnRadio form-control" <?php if(isset($genre) && $genre=="02") { echo 'checked="checked"'; }?>>Masculin
							</div>
						</div>
						<div class="row">
							<!--Saisie de l'adresse-->
							<div class="col-md-6 col-sm-6 col-xs-12  <?php if(isset($adresse) && $adresse=="") { echo "enRouge";}?>">
								<label for="adresse">Adresse : </label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" name="adresse" class="form-control" placeholder="Ex : 4 rue de Jarlard 81000 Albi" value="<?php if(isset($adresse) && $adresse=="") {echo $adresse;}?>">
							</div>
						</div>
						<div class="row">
							<!--Saisie du téléphone-->
							<div class="col-md-6 col-sm-6 col-xs-12  <?php if(isset($portable) && $portable=="") { echo "enRouge";}?>">
								<label for="portable">Portable : </label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="tel" name="portable" class="form-control" placeholder="Ex : 0611223344" pattern="[0][0-9]{1}[0-9]{8}" value="<?php if(isset($portable) && $portable=="") {echo $portable;}?>">
							</div>
						</div>
						<div class="row">
							<!--Saisie du mail-->
							<div class="col-md-6 col-sm-6 col-xs-12  <?php if(isset($mail) && $mail=="") { echo "enRouge";}?>">
								<label for="mail">Email : </label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="email" name="mail" class="form-control" placeholder="Ex : prenom.nom@gmail.com" value="<?php if(isset($mail) && $mail=="") {echo $mail;}?>">
							</div>
						</div>
						<div class="row">
							<!--Saisie de la date de naissance-->
							<div class="col-md-6 col-sm-6 col-xs-12  <?php if(isset($date) && $date=="") { echo "enRouge";}?>">
								<label for="date">Date de naissance : </label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="date" name="date" class="form-control" value="<?php if(isset($date) && $date=="") {echo $date;}?>">
							</div>
						</div>
					</div>
				
					<!--Partie Droite-->
					<div class="col-md-6 col-sm-12 col-xs-12 formGD">
						<div class="row">
							<!--Saisie du poids-->
							<div class="col-md-6 col-sm-6 col-xs-12  <?php if(isset($poids) && $poids=="") { echo "enRouge";}?>">
								<label for="poids">Poids: </label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" name="poids" class="form-control" placeholder="Ex : 112.500" value="<?php if(isset($poids) && $poids=="") {echo $poids;}?>">
							</div>
						</div>
						<div class="row">
							<!--Saisie du numéro de sécu-->
							<div class="col-md-6 col-sm-6 col-xs-12  <?php if(isset($noCV) && $noCV=="") { echo "enRouge";}?>">
								<label for="noCV" >N° carte vitale: </label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" name="noCV" class="form-control" value="<?php if(isset($noCV) && $noCV=="") {echo $noCV;}?>">
							</div>
						</div>
						<div class="row">
							<!--Saisie de l'allergie-->
							<div class="col-md-6 col-sm-6 col-xs-12  <?php if(isset($allergies) && $allergies=="") { echo "enRouge";}?>">
								<label for="allergies">Allergie: </label>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-6">
								<input type="radio" name="allergies" value="oui" class="btnRadio form-control" <?php if(isset($allergies) && $allergies=="oui") { echo 'checked="checked"'; }?>>Oui
							</div>
							<div class="col-md-3 col-sm-3 col-xs-6">
								<input type="radio" name="allergies" value="non" class="btnRadio form-control" <?php if(isset($allergies) && $allergies=="non") { echo 'checked="checked"'; }?>>Non
							</div>
						</div>
						<div class="row">
							<!--Saisie de commentaires-->
							<div class="col-md-12 col-sm-7 col-xs-12  <?php if(isset($commentaires) && $commentaires=="") { echo "enRouge";}?>">
								<label for="commentaires">Commentaires: </label>
							</div>
							<div class="col-md-12 col-sm-6 col-xs-12">
								<textarea name="commentaires" rows="7" cols="45"><?php if(isset($commentaires) && $commentaires=="") {echo $commentaires;}?></textarea>
							</div>
						</div>
						<div class="row">
							<!--Médecin traitant-->
							<div class="col-md-6 col-sm-6 col-xs-6">
								<label>Médecin traitant : </label>
								TORGE Calin <!--TODO : automatisé depuis l'authentification-->
							</div>
						</div>
					</div>
					<!--Bouton Valider-->
					<div class="col-md-12 col-sm-12 col-xs-12 divBouton">
						<input type="submit" name="valider" value="VALIDER" class="buttonValid form-control">
					</div>
				</div>
				<!--Envoi de l'id du medecin-->
				<input hidden name="medecin" value="<?php echo $id_medecin; ?>">
				<input hidden name="controller" value="Patients">
				<input hidden name="action" value="addPatient">
			</form>
			<?php
				}
			?>
		</div>
  	</body>
</html>
