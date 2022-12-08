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
		$host = 'localhost';
		$db = 'medsoft';
		$user = 'root';
		$pass = 'root';
		$charset = 'utf8mb4';
		$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
		$options = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false
		];
		try {
			$pdo = new PDO($dsn, $user, $pass, $options);
		} catch (PDOException $e) {
			echo $e->getMessage();
			//throw new PDOException($e->getMessage(), (int)$e->getCode());
		}

		//Récupération des données
		$ToutOK=true; //Savoir si toutes les données ont été rentrées
		
		//Récupération du nom
		if(isset($_POST['nom']) and $_POST['nom']!="") {
			$nom=htmlspecialchars($_POST['nom']);
		} else {
			$nom="";
			$ToutOK=false;
		}
		
		//Récupération du prenom
		if(isset($_POST['prenom']) and $_POST['prenom']!="") {
			$prenom=htmlspecialchars($_POST['prenom']);
		} else {
			$prenom="";
			$ToutOK=false;
		}
		
		//Récupération du genre
		if(isset($_POST['genre']) and $_POST['genre']=="Féminin") {
			$genre="01";
		} else if(isset($_POST['genre']) and $_POST['genre']=="Masculin") {
			$genre="02";
		} else {
			$genre="";
			$ToutOK=false;
		}
		
		//Récupération de l'adresse
		if(isset($_POST['adresse']) and $_POST['adresse']!="") {
			$adresse=htmlspecialchars($_POST['adresse']);
		} else {
			$adresse="";
			$ToutOK=false;
		}
		
		//Récupération du numéro de portable
		if(isset($_POST['portable']) and $_POST['portable']!="") {
			$portable=htmlspecialchars($_POST['portable']);
		} else {
			$portable="";
			$ToutOK=false;
		}
		
		//Récupération de l'email
		if(isset($_POST['mail']) and $_POST['mail']!="") {
			$mail=htmlspecialchars($_POST['mail']);
		} else {
			$mail="";
			$ToutOK=false;
		}
		
		//Récupération de la date de naissance
		if(isset($_POST['date']) and $_POST['date']!="") {
			$date=htmlspecialchars($_POST['date']);
		} else {
			$date="";
			$ToutOK=false;
		}
		
		//Récupération du poids
		if(isset($_POST['poids']) and $_POST['poids']!="") {
			$poids=htmlspecialchars($_POST['poids']);
		} else {
			$poids="";
			$ToutOK=false;
		}
		
		//Récupération du numero de carte vitale
		if(isset($_POST['noCV']) and $_POST['noCV']!="") {
			$noCV=htmlspecialchars($_POST['noCV']);
		} else {
			$noCV="";
			$ToutOK=false;
		}
		
		//Récupération des allergies
		if(isset($_POST['allergies']) and $_POST['allergies']=="Oui") {
			$allergies="Oui";
		} else if(isset($_POST['allergies']) and $_POST['allergies']=="Non") {
			$allergies="Non";
		} else {
			$allergies="";
			$ToutOK=false;
		}

		//Récupération des commentaires
		if(isset($_POST['commentaires'])) {
			$commentaires=htmlspecialchars($_POST['commentaires']);
		} else {
			$commentaires="";
			$ToutOK=false;
		}

		//Récupération de l'ID du médecin connecté => TODO
		$id_medecin="001";

		try {
			if($ToutOK) {
				$requete="INSERT INTO patients (numeroCarteVitale, nom, prenom, id_genre, tel, email, dateNai, poids, id_medecin, allergies, commentaires)
						VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
				$stmt = $pdo->prepare($requete);
				$stmt->execute([$noCV, $nom, $prenom, $genre, $portable, $mail, $date, $poids, $id_medecin, $allergies, $commentaires]);
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
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
					<form action="creationPatient.php" method="post">
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
										<div class="col-md-6 col-sm-6 col-xs-12 <?php if($nom=="") { echo "enRouge";}?>">
											<label for="nom">Nom : </label>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="nom" class="form-control" value="<?php echo $nom;?>">
										</div>
									</div>
									<div class="row">
										<!--Saisie du prénom-->
										<div class="col-md-6 col-sm-6 col-xs-12  <?php if($prenom=="") { echo "enRouge";}?>">
											<label for="prenom">Prénom : </label>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="prenom" class="form-control" value="<?php echo $prenom;?>">
										</div>
									</div>
									<div class="row">
										<!--Saisie du Genre-->
										<div class="col-md-6 col-sm-6 col-xs-12  <?php if($genre=="") { echo "enRouge";}?>">
											<label for="genre">Genre: </label>
										</div>
										<div class="col-md-3 col-sm-3 col-xs-6">
											<input type="radio" name="genre"  value="Féminin" class="form-control" <?php if($genre=="Féminin") { echo 'checked="checked"'; }?>>Féminin
										</div>
										<div class="col-md-3 col-sm-3 col-xs-6">
											<input type="radio" name="genre" value="Masculin" class="form-control" <?php if($genre=="Masculin") { echo 'checked="checked"'; }?>>Masculin
										</div>
									</div>
									<div class="row">
										<!--Saisie de l'adresse-->
										<div class="col-md-6 col-sm-6 col-xs-12  <?php if($adresse=="") { echo "enRouge";}?>">
											<label for="adresse">Adresse : </label>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="adresse" class="form-control" value="<?php echo $adresse;?>">
										</div>
									</div>
									<div class="row">
										<!--Saisie du téléphone-->
										<div class="col-md-6 col-sm-6 col-xs-12  <?php if($portable=="") { echo "enRouge";}?>">
											<label for="portable">Portable : </label>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="tel" name="portable" class="form-control" value="<?php echo $portable;?>">
										</div>
									</div>
									<div class="row">
										<!--Saisie du mail-->
										<div class="col-md-6 col-sm-6 col-xs-12  <?php if($mail=="") { echo "enRouge";}?>">
											<label for="mail">Email : </label>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="email" name="mail" class="form-control" value="<?php echo $mail;?>">
										</div>
									</div>
									<div class="row">
										<!--Saisie de la date de naissance-->
										<div class="col-md-6 col-sm-6 col-xs-12  <?php if($date=="") { echo "enRouge";}?>">
											<label for="date">Date de naissance : </label>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="date" name="date" class="form-control" value="<?php echo $date;?>">
										</div>
									</div>
									<div class="row">
										<!--Saisie du poids-->
										<div class="col-md-6 col-sm-6 col-xs-12  <?php if($poids=="") { echo "enRouge";}?>">
											<label for="poids">Poids: </label>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="poids" class="form-control" value="<?php echo $poids;?>">
										</div>
									</div>
								</div>
							
								<!--Partie Droite-->
								<div class="col-md-6 col-sm-12 col-xs-12">
									<div class="row">
										<!--Saisie du numéro de sécu-->
										<div class="col-md-6 col-sm-6 col-xs-12  <?php if($noCV=="") { echo "enRouge";}?>">
											<label for="noCV" >N° carte vitale: </label>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="noCV" class="form-control" value="<?php echo $noCV;?>">
										</div>
									</div>
									<div class="row">
										<!--Saisie de l'allergie-->
										<div class="col-md-6 col-sm-6 col-xs-12  <?php if($allergies=="") { echo "enRouge";}?>">
											<label for="allergies">Allergie: </label>
										</div>
										<div class="col-md-3 col-sm-3 col-xs-6">
											<input type="radio" name="allergies" value="Oui" class="form-control" <?php if($allergies=="Oui") { echo 'checked="checked"'; }?>>Oui
										</div>
										<div class="col-md-3 col-sm-3 col-xs-6">
											<input type="radio" name="allergies" value="Non" class="form-control" <?php if($allergies=="Non") { echo 'checked="checked"'; }?>>Non
										</div>
									</div>
									<div class="row">
										<!--Saisie de commentaires-->
										<div class="col-md-12 col-sm-7 col-xs-12  <?php if($commentaires=="") { echo "enRouge";}?>">
											<label for="commentaires">Commentaires: </label>
										</div>
										<div class="col-md-12 col-sm-6 col-xs-12">
											<textarea name="commentaires" rows="7" cols="45"><?php echo $commentaires;?></textarea>
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
					</form>
				</div>
			</div>
		</div>
	</div>
  </body>
</html>
