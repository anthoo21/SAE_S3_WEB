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
  
  <body class="bleu">
  
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
			$requeteP="SELECT medecins.*, utilisateurs.identifiant, utilisateurs.motDePasse
			FROM medecins
			JOIN utilisateurs ON id_util = identifiant
			WHERE id_med = :id";
			$resultats = $pdo->prepare($requeteP);
			$resultats->bindParam('id', $_SESSION['idMed']);
			$resultats->execute();
			while($ligne = $resultats->fetch()) {
				$nom = $ligne['nom'];
				$prenom = $ligne['prenom'];
				$adresse = $ligne['adresse'];
				$tel = $ligne['tel'];
				$email = $ligne['email'];
				$date = $ligne['dateNai'];
				$identifiant = $ligne['identifiant'];
				$mdp = $ligne['motDePasse'];
			}

			//Nombre de modification
			$modifMed = 0;
		
			//Récupération du nom
			if(isset($_POST['newNom']) and $_POST['newNom']!="" and preg_match("/^[A-Z][A-Za-z\s'-]*[A-Za-z]$/", $_POST['newNom'])) {
				$newNom=htmlspecialchars($_POST['newNom']);
				if($_POST['newNom'] != $nom) {
					$modifMed++;
				}
			} else {
				$newNom=$nom;
			}
			
			//Récupération du prenom
			if(isset($_POST['newPrenom']) and $_POST['newPrenom']!="" and preg_match("/^[A-Z][a-zA-Z'-]*$/", $_POST['newPrenom'])) {
				$newPrenom=htmlspecialchars($_POST['newPrenom']);
				if($_POST['newPrenom'] != $prenom) {
					$modifMed++;
				}
			} else {
				$newPrenom=$prenom;
			}

			//Récupération de l'adresse											// La regex ne prend pas en compte la modification 
			if(isset($_POST['newAdresse']) and $_POST['newAdresse']!=""){		// and preg_match("/^([0-9]{1,4}[a-zA-Z]{0,1})?\s*[a-zA-Z'.-]+(\s[a-zA-Z'.-]+)*\s*[0-9]{5}\s*[a-zA-Z]+([\s-][a-zA-Z]+)*$/", $_POST['newAdresse'])) {
				$newAdresse=htmlspecialchars($_POST['newAdresse']);
				if($_POST['newAdresse'] != $adresse) {
					$modifMed++;
				}
			} else {
				$newAdresse=$adresse;
			}
			//Récupération du numéro de portable
			if(isset($_POST['newPortable']) and $_POST['newPortable']!="" and preg_match("/^0[1-9][0-9]{8}$/", $_POST['newPortable'])) {
				$newPortable=htmlspecialchars($_POST['newPortable']);
				if($_POST['newPortable'] != $tel) {
					$modifMed++;
				}
			} else {
				$newPortable=$tel;
			}
			//Récupération de l'email
			if(isset($_POST['mail']) and $_POST['mail']!="" and preg_match("/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/", $_POST['mail'])) {
				$mail=htmlspecialchars($_POST['mail']);
				if($_POST['mail'] != $email) {
					$modifMed++;
				}
			} else {
				$mail=$email;
			}
			//Récupération de la date de naissance
			if(isset($_POST['newDate']) and $_POST['newDate']!="") {
				$newDate=htmlspecialchars($_POST['newDate']);
				if($_POST['newDate'] != $date) {
					$modifMed++;
				}
			} else {
				$newDate=$date;
			}
			
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		$erreur = '';

		// Toutes les données sont correctes
		if(isset($_POST['valider']) and $_POST['valider']) {
			try {

				$requete2 = "UPDATE medecins 
							SET nom = ?, prenom = ?, dateNai = ?, adresse = ?, tel = ?, email = ? 
							WHERE id_med = ?;";
				$stmt2 = $pdo->prepare($requete2);
				$stmt2->execute([$newNom, $newPrenom, $newDate, $newAdresse, $newPortable, $mail, $_SESSION['idMed']]);
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
						<form action="creationMedecin.php" method="post">
							<a href="accueilAdmin.php"><button type="button" class="btn btn-info btn-circle btn-xl" name="medecin" value="true"><span class="fas fa-user"></button></a>
							<button type="submit" class="btn btn-danger btn-circle btn-xxl" name="deconnexion" value="true"><span class="fas fa-power-off"></button>
						</form>
					</div>	
				</div>
				<!-- Titre administrateur -->
				<div class="row">
					</br>
					<div class="col-md-12 col-sm-12 col-xs-12 adminName">
						ADMINISTRATEUR 
					</div>	
				</div>
				<div class="row paddingForm">
					<div class="row formPatient">
						<!--Titre "Modification d'un medecin"-->
						<div class="col-md-12 col-sm-12 col-xs-12 titre titreCreation">
							Modification d'un médecin
						</div>
						<!--Message-->
						<div class="col-md-12 col-sm-12 col-xs-12 titreOK">
							<h2 class="enBleu">Enregistrement des modifications apportées au médecin <?php echo $nom.' '.$prenom;?>. </br>Il y a eu <?php echo $modifMed.' modifications effectuées';?></h2>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 titreOK">
						</div>
						<!--Retour accueil-->
						<div class="col-md-12 col-sm-12 col-xs-12 paddingForm">
							<a href="accueilAdmin.php"><span class="fas fa-arrow-left"></span>  Retour à l'accueil administrateur </a>
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
						<form action="creationMedecin.php" method="post">
							<a href="accueilAdmin.php"><button type="button" class="btn btn-info btn-circle btn-xl" title="Revenir à l'accueil" name="medecin" value="true"><span class="fas fa-user"></button></a>
							<button type="submit" class="btn btn-danger btn-circle btn-xxl" title="Déconnexion" name="deconnexion" value="true"><span class="fas fa-power-off"></button>
						</form>
					</div>	
				</div>
				<!--Nom du docteur-->
				<div class="row">
					</br>
					<div class="col-md-12 col-sm-12 col-xs-12 adminName">
						ADMINISTRATEUR 
					</div>
				</div>
				<div class="row paddingForm">
					<div class="row formPatient">
						<!--Titre "Création d'un medecin"-->
						<div class="col-md-12 col-sm-12 col-xs-12 titre titreCreation">
							Modification d'un medecin
						</div>
						<div class="row paddingForm">
							<!--Formulaire-->
							<form action="modificationMedecin.php" method="post">
								<div class="col-md-12 col-sm-12 col-xs-12 formPatient">
								
									<!--Partie Gauche-->
									<div class="col-md-6 col-sm-12 col-xs-12">
										<!--Saisie du nom-->
										</br>
										<div class="row">
											<div class="col-md-6 col-sm-6 col-xs-12 <?php if($newNom!=$nom) { echo 'enBleu';}?>">
												<label for="newNom">Nom : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="newNom" class="form-control" placeholder="<?php echo $nom;?>" value="<?php echo $newNom;?>">
											</div>
										</div>
										<div class="row">
											<!--Saisie du prénom-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if($newPrenom!=$prenom) { echo 'enBleu';}?>">
												<label for="newPrenom">Prénom : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="newPrenom" class="form-control" placeholder="<?php echo $prenom; ?>" value="<?php echo $newPrenom;?>">
											</div>
										</div>
										<div class="row">
											<!--Saisie de l'adresse-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if($newAdresse != $adresse) { echo 'enBleu';}?>">
												<label for="newAdresse">Adresse : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="newAdresse" class="form-control" placeholder="<?php echo $adresse;?>" value="<?php echo $newAdresse;?>">
											</div>
										</div>
										<div class="row">
											<!--Saisie du téléphone-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if($newPortable != $tel) { echo 'enBleu';}?>">
												<label for="newPortable">Portable : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="tel" name="newPortable" class="form-control" placeholder="Ex : 0611223344" pattern="[0][0-9]{1}[0-9]{8}" value="<?php echo $newPortable;?>">
											</div>
										</div>
										<div class="row">
											<!--Saisie du mail-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if($mail != $email) { echo 'enBleu';}?>">
												<label for="mail">Email : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="mail" class="form-control" placeholder="Ex : prenom.nom@gmail.com" value="<?php echo $mail;?>">
											</div>
										</div>
										<div class="row">
											<!--Saisie de la date de naissance-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if($newDate != $date) { echo 'enBleu';}?>">
												<label for="newDate">Date de naissance : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="date" name="newDate" class="form-control" value="<?php echo $newDate;?>">
											</div>
										</div>
									</div>
								
									<!--Partie Droite-->
									<div class="col-md-6 col-sm-12 col-xs-12 formGD">
										<div class="row paddingForm center">
											<h3 class="entete">Coordonnées de connexion :</h3>
										</div>
										<div class="row paddingForm">
											<!--Identifiant -->
											<div class="col-md-6 col-sm-6 col-xs-12">
												<label for="identifiant">Identifiant : </label><?php echo '  '.$identifiant;?>
											</div>
										</div>
										<div class="row paddingForm">
											<!--Mot de passe -->
											<div class="col-md-6 col-sm-6 col-xs-12">
												<label for="newMDP" >Mot de passe : </label><?php echo '  '.$mdp;?>
											</div>
											<div class="row paddingForm">
											<!--Message -->
											<div class="col-md-12 col-sm-12 col-xs-12 center">
												<h3 class="enRouge"><i>Pour modifier le mot de passe d'un médecin, il suffit de le réinitialisé </br>directement dans la base de données !</i></h3>
											</div>
										</div>
										</div>
									</div>
									
									<!--Bouton Valider-->
									<div class="col-md-12 col-sm-12 col-xs-12 divBouton center">
										<div class="row divBouton">
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
