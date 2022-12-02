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
		</div>
		<div class="row paddingForm">
			<div class="row formPatient">
				<!--Titre "Création d'un patient"-->
				<div class="col-md-12 col-sm-12 col-xs-12 titre titreCreation">
					Création d'un patient
				</div>
				<div class="row paddingForm">
					<!--Formulaire-->
					<div class="col-md-12 col-sm-12 col-xs-12 formPatient">
						<div class="row paddingForm">
							<!--Partie Gauche-->
							<div class="col-md-6 col-sm-12 col-xs-12">
								<div class="row">
									<!--Sous-titre-->
									<div class="col-md-12 col-sm-12 col-xs-12 titre">Informations générales</div>
								</div>
								<!--Saisie du nom-->
								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-12">
										<label>Nom : </label>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" name="nom" class="form-control">
									</div>
								</div>
								<div class="row">
									<!--Saisie du prénom-->
									<div class="col-md-6 col-sm-6 col-xs-12">
										<label>Prénom : </label>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" name="prenom" class="form-control">
									</div>
								</div>
								<div class="row">
									<!--Saisie du Genre-->
									<div class="col-md-6 col-sm-6 col-xs-12">
										<label>Genre: </label>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-6">
										<input type="radio" name="genreF" class="form-control">Féminin
									</div>
									<div class="col-md-3 col-sm-3 col-xs-6">
										<input type="radio" name="genreM" class="form-control">Masculin
									</div>
								</div>
								<div class="row">
									<!--Saisie de l'adresse-->
									<div class="col-md-6 col-sm-6 col-xs-12">
										<label>Adresse : </label>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" name="adresse" class="form-control">
									</div>
								</div>
								<div class="row">
									<!--Saisie du téléphone-->
									<div class="col-md-6 col-sm-6 col-xs-12">
										<label>Portable : </label>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="tel" name="portable" class="form-control">
									</div>
								</div>
								<div class="row">
									<!--Saisie du mail-->
									<div class="col-md-6 col-sm-6 col-xs-12">
										<label>Email : </label>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="email" name="mail" class="form-control">
									</div>
								</div>
								<div class="row">
									<!--Saisie de la date de naissance-->
									<div class="col-md-6 col-sm-6 col-xs-12">
										<label>Date de naissance : </label>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="date" name="date" class="form-control">
									</div>
								</div>
								<div class="row">
									<!--Saisie du poids-->
									<div class="col-md-6 col-sm-6 col-xs-12">
										<label>Poids: </label>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="number" name="poids" class="form-control">
									</div>
								</div>
							</div>
						
							<!--Partie Droite-->
							<div class="col-md-6 col-sm-12 col-xs-12">
								<div class="row">
									<!--Saisie du numéro de sécu-->
									<div class="col-md-6 col-sm-6 col-xs-12">
										<label>N° carte vitale: </label>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="number" name="poids" class="form-control">
									</div>
								</div>
								<div class="row">
									<!--Saisie de l'allergie-->
									<div class="col-md-12 col-sm-12 col-xs-12">
										<label>Allergie: </label>
									</div>
									<div class="col-md-12 col-sm-12 col-xs-12">
										<textarea name="allergies" rows="2" cols="45"></textarea>
									</div>
								</div>
								<div class="row">
									<!--Saisie de commentaires-->
									<div class="col-md-12 col-sm-7 col-xs-12">
										<label>Commentaires: </label>
									</div>
									<div class="col-md-12 col-sm-6 col-xs-12">
										<textarea name="commentaires" rows="7" cols="45"></textarea>
									</div>
								</div>
								<div class="row">
									<!--Médecin traitant-->
									<div class="col-md-6 col-sm-6 col-xs-12">
										<label>Médecin traitant : </label>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">
										TORGE Calin <!--TODO : automatisé depuis l'authentification-->
									</div>
								</div>
								<div class="row">
									<!--Bouton valider-->
									<div class="col-md-12 col-sm-12 col-xs-12 btnValid">
										<input type="submit" name="valider" value="Valider" class="buttonConnect">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
  </body>
</html>