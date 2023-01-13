<?php
session_start(); //démarrage d'une session

	// Test si on est bien connecté (session existante et bon numéro de session
	if (!isset($_SESSION['login']) || !isset($_SESSION['id']) || $_SESSION['id']!=session_id()) {
		// Renvoi vers la page de connexion
  		header('Location: ../index.php');
  		exit();
	}

// Déconnexion
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
		// Gestion de la connexion à la base de données
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
		
		// Récupération des données relatives au patient
		try {
			$requeteP="SELECT patients.nom, patients.prenom, patients.numeroCarteVitale, genres.sexe, patients.adresse, patients.tel,
			patients.email, patients.dateNai, patients.poids, patients.allergies, patients.commentaires, medecins.nom nomMedecin, medecins.prenom prenomMedecin
			FROM patients JOIN medecins ON id_medecin = id_med JOIN genres ON patients.id_genre = genres.id_genre
			WHERE patients.numeroCarteVitale = :id";
			$resultats = $pdo->prepare($requeteP);
			$resultats->bindParam('id', $_SESSION['idPatient']);
			$resultats->execute();
			while($ligne = $resultats->fetch()) {
				$nom = $ligne['nom'];
				$prenom = $ligne['prenom'];
				$adresse = $ligne['adresse'];
				$noCV = $ligne['numeroCarteVitale'];
				$tel = $ligne['tel'];
				$email = $ligne['email'];
				$date = $ligne['dateNai'];				// $date = date('d/m/Y', strtotime($ligne['dateNai']));
				$poids = $ligne['poids'];			
				$genreP = $ligne['sexe'];
				$medecin = $ligne['nomMedecin'].' '.$ligne['prenomMedecin'];
				$allergies = $ligne['allergies'];
				$commentaires = $ligne['commentaires'];
			}
			
			//Nombre de modification
			$modifPatient = 0;
			
			//Récupération du nom
			if(isset($_POST['newNom']) and $_POST['newNom']!="" and preg_match("/^[A-Z][A-Za-z\s'-]*[A-Za-z]$/", $_POST['newNom'])) {
				$newNom=htmlspecialchars($_POST['newNom']);
				if($_POST['newNom'] != $nom) {
					$modifPatient++;
				}
			} else {
				$newNom=$nom;
			}
			
			//Récupération du prenom
			if(isset($_POST['newPrenom']) and $_POST['newPrenom']!="" and preg_match("/^[A-Z][a-zA-Z'-]*$/", $_POST['newPrenom'])) {
				$newPrenom=htmlspecialchars($_POST['newPrenom']);
				if($_POST['newPrenom'] != $prenom) {
					$modifPatient++;
				}
			} else {
				$newPrenom=$prenom;
			}
			//Récupération du genre
			if(isset($_POST['genre']) and $_POST['genre']=="Féminin") {
				$nomGenre="Féminin";
				$genre="01";
				if($_POST['genre'] != $genreP) {
					$modifPatient++;
				}
			} else if(isset($_POST['genre']) and $_POST['genre']=="Masculin") {
				$nomGenre="Masculin";
				$genre="02";
				if($_POST['genre'] != $genreP) {
					$modifPatient++;
				}
			} else {
				$nomGenre=$genreP;
				if($nomGenre == "Féminin") {
					$genre="01";
				} else {
					$genre="02";
				}
			}
			//Récupération de l'adresse
			if(isset($_POST['newAdresse']) and $_POST['newAdresse']!="" and preg_match("/^([0-9]{1,4}[a-zA-Z]{0,1})?\s*[a-zA-Z'.-]+(\s[a-zA-Z'.-]+)*\s*[0-9]{5}\s*[a-zA-Z]+([\s-][a-zA-Z]+)*$/", $_POST['newAdresse'])) {
				$newAdresse=htmlspecialchars($_POST['newAdresse']);
				if($_POST['newAdresse'] != $adresse) {
					$modifPatient++;
				}
			} else {
				$newAdresse=$adresse;
			}
			//Récupération du numéro de portable
			if(isset($_POST['newPortable']) and $_POST['newPortable']!="" and preg_match("/^0[1-9][0-9]{8}$/", $_POST['newPortable'])) {
				$newPortable=htmlspecialchars($_POST['newPortable']);
				if($_POST['newPortable'] != $tel) {
					$modifPatient++;
				}
			} else {
				$newPortable=$tel;
			}
			//Récupération de l'email
			if(isset($_POST['mail']) and $_POST['mail']!="" and preg_match("/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/", $_POST['mail'])) {
				$mail=htmlspecialchars($_POST['mail']);
				if($_POST['mail'] != $email) {
					$modifPatient++;
				}
			} else {
				$mail=$email;
			}
			//Récupération de la date de naissance
			if(isset($_POST['newDate']) and $_POST['newDate']!="") {
				$newDate=htmlspecialchars($_POST['newDate']);
				if($_POST['newDate'] != $date) {
					$modifPatient++;
				}
			} else {
				$newDate=$date;
			}
			//Récupération du poids
			if(isset($_POST['newPoids']) and $_POST['newPoids']!="" and preg_match("/^[0-9]{1,3}([.,][0-9]{3})?$/", $_POST['newPoids'])) {
				$newPoids=htmlspecialchars($_POST['newPoids']);
				if($_POST['newPoids'] != $poids) {
					$modifPatient++;
				}
			} else {
				$newPoids=$poids;
			}
			//TODO => regex
			//Récupération du numero de carte vitale
			if(isset($_POST['newCV']) and $_POST['newCV']!="" and preg_match("/^(1[0-9]{14}|2[0-9]{14})$/", $_POST['newCV'])) {
				$newCV=htmlspecialchars($_POST['newCV']);
				if($_POST['newCV'] != $noCV) {
					$modifPatient++;
				}
			} else {
				$newCV=$noCV;
			}
			//Récupération des allergies
			if(isset($_POST['newAllergies']) and $_POST['newAllergies']=="oui") {
				$newAllergies="oui";
				if($_POST['newAllergies'] != $allergies) {
					$modifPatient++;
				}
			} else if(isset($_POST['newAllergies']) and $_POST['newAllergies']=="non") {
				$newAllergies="non";
				if($_POST['newAllergies'] != $allergies) {
					$modifPatient++;
				}
			} else {
				$newAllergies=$allergies;
			}
			//Récupération des commentaires
			if(isset($_POST['newCom'])) {
				$newCom=htmlspecialchars($_POST['newCom']);
				if($_POST['newCom'] != $commentaires) {
					$modifPatient++;
				}
			} else {
				$newCom=$commentaires;
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		//Récupération de l'ID du médecin connecté => TODO
		$id_medecin=$_SESSION['idMed'];

		// Toutes les données sont correctes
		if(isset($_POST['valider']) and $_POST['valider']) {
			try {
				$requete="UPDATE patients 
						  SET nom = ?, prenom = ?, id_genre = ?, adresse = ?, tel = ?, email = ?, dateNai = ?, poids = ?, allergies = ?, commentaires = ?
						  WHERE numeroCarteVitale = ?";
				$stmt = $pdo->prepare($requete);
				$stmt->execute([$newNom, $newPrenom, $genre, $newAdresse, $newPortable, $mail, $newDate, $newPoids, $newAllergies, $newCom, $_SESSION['idPatient']]);
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
					<!-- Boutons -->
					<div class="col-md-4 col-sm-4 col-xs-4 logos">
						<form action="accueilMedecin.php" method="post">
							<a href="accueilMedecin.php"><button type="button" class="btn btn-info btn-circle btn-xl" name="patient" value="true"><span class="fas fa-user"></button></a>				
							<a href="recherche.php"><button type="button" class="btn btn-info btn-circle btn-xl" name="recherche" value="true"><span class="fas fa-search"></button></a>
							<button type="submit" class="btn btn-danger btn-circle btn-xxl" name="deconnexion" value="true"><span class="fas fa-power-off"></button>
						</form>
					</div>	
				</div>
				<!--Nom du docteur-->
				<div class="row">
					</br>
					<div class="col-md-12 col-sm-12 col-xs-12 doctorName">
						<?php echo "Docteur ".$_SESSION['nom'].' '.$_SESSION['prenom']; ?>
					</div>	
				</div>
				<div class="row paddingForm">
					<div class="row formPatient">
						<!--Titre "Modification d'un medecin"-->
						<div class="col-md-12 col-sm-12 col-xs-12 titre titreCreation">
							Modification d'un patient
						</div>
						<!--Message-->
						<div class="col-md-12 col-sm-12 col-xs-12 titreOK">
							<h2>Enregistrement des modifications apportées au patient <?php echo $nom.' '.$prenom;?>. </br>Il y a eu <?php echo $modifPatient.' modifications effectuées';?></h2>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12"></br></br></div>
						<!--Retour accueil-->
						<div class="col-md-12 col-sm-12 col-xs-12 paddingForm">
							<a href="accueilMedecin.php"><span class="fas fa-arrow-left"></span> -- Retour à ma page d'accueil -- </a>
						</div>
					</div>
				</div>
			</div>
		<?php					
		} else {
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
				<div class="row paddingForm">
					<div class="row formPatient">
						<!--Titre "Création d'un patient"-->
						<div class="col-md-12 col-sm-12 col-xs-12 titre titreCreation">
							Modification du patient : <?php echo $nom.' '.$prenom;?>
						</div>
						<div class="row paddingForm">
							<!--Formulaire-->
							<form action="modificationPatient.php" method="post">
								<div class="col-md-12 col-sm-12 col-xs-12 formPatient">
								
									<!--Partie Gauche de la page-->
									<div class="col-md-6 col-sm-12 col-xs-12 formGD">
										<!--Nom-->
										<div class="row">
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if($newNom!=$nom) { echo "enBleu";}?>">
												<label for="newNom">Nom : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="newNom" class="form-control" placeholder="<?php echo $nom;?>" value="<?php echo $newNom;?>">
											</div>
										</div>
										<div class="row">
											<!--Prénom-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if($newPrenom!=$prenom) { echo "enBleu";}?>">
												<label for="prenom">Prénom : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="newPrenom" class="form-control" placeholder="<?php echo $prenom; ?>" value="<?php echo $newPrenom;?>">
											</div>
										</div>
										<div class="row">
											<!--Genre-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if($nomGenre != $genre) { echo "enBleu";}?>">
												<label for="genre">Genre: </label>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-6">
												<input type="radio" name="genre"  value="Féminin" class="btnRadio form-control" <?php if($nomGenre=="Féminin") { echo 'checked="checked"'; }?>>Féminin
											</div>
											<div class="col-md-3 col-sm-3 col-xs-6">
												<input type="radio" name="genre" value="Masculin" class="btnRadio form-control" <?php if($nomGenre=="Masculin") { echo 'checked="checked"'; }?>>Masculin
											</div>
										</div>
										<div class="row">
											<!--Adresse postale-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if($newAdresse != $adresse) { echo "enBleu";}?>">
												<label for="newAdresse">Adresse : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="newAdresse" class="form-control" placeholder="Ex : 4 rue de Jarlard 81000 Albi" value="<?php echo $newAdresse;?>">
											</div>
										</div>
										<div class="row">
											<!--Téléphone-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if($newPortable != $tel) { echo "enBleu";}?>">
												<label for="newPortable">Portable : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="tel" name="newPortable" class="form-control" placeholder="Ex : 0611223344" pattern="[0][0-9]{1}[0-9]{8}" value="<?php echo $newPortable;?>">
											</div>
										</div>
										<div class="row">
											<!--Adresse email-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if($mail!= $email) { echo "enBleu";}?>">
												<label for="mail">Email : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="email" name="mail" class="form-control" placeholder="Ex : prenom.nom@gmail.com" value="<?php echo $mail;?>">
											</div>
										</div>
										<div class="row">
											<!--Date de naissance-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if($newDate != $date) { echo "enBleu";}?>">
												<label for="newDate">Date de naissance : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="newDate" name="newDate" class="form-control" value="<?php echo $newDate;?>">
											</div>
										</div>
									</div>
								
									<!--Partie Droite de la page-->
									<div class="col-md-6 col-sm-12 col-xs-12 formGD">
										<div class="row">
											<!--Poids-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if($newPoids != $poids) { echo "enBleu";}?>">
												<label for="newPoids">Poids: </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="newPoids" class="form-control" placeholder="Ex : 112.500" value="<?php echo $newPoids;?>">
											</div>
										</div>
										<div class="row">
											<!--Numéro de sécu-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if($newCV != $noCV) { echo "enBleu";}?>">
												<label for="newCV" >N° carte vitale: </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="newCV" class="form-control" value="<?php echo $newCV;?>">
											</div>
										</div>
										<div class="row">
											<!--Allergie-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if($allergies=="") { echo "enRouge";}?>">
												<label for="newAllergies">Allergie: </label>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-6">
												<input type="radio" name="newAllergies" value="oui" class="btnRadio form-control" <?php if($newAllergies=="oui") { echo 'checked="checked"'; }?>>Oui
											</div>
											<div class="col-md-3 col-sm-3 col-xs-6">
												<input type="radio" name="newAllergies" value="non" class="btnRadio form-control" <?php if($newAllergies=="non") { echo 'checked="checked"'; }?>>Non
											</div>
										</div>
										<div class="row">
											<!--Commentaires-->
											<div class="col-md-12 col-sm-7 col-xs-12  <?php if($newCom=="") { echo "enRouge";}?>">
												<label for="newCom">Commentaires: </label>
											</div>
											<div class="col-md-12 col-sm-6 col-xs-12">
												<textarea name="newCom" rows="7" cols="45"><?php echo $newCom;?></textarea>
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
									
									<!--Bouton de validation du formulaire-->
									<div class="col-md-12 col-sm-12 col-xs-12 divBouton buttonVert">
										<div class="row divBouton buttonVert">
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
