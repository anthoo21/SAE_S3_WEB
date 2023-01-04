<?php
session_start(); //démarrage d'une session


//Vérification que les variables sessions de l'utilisateur existent
if(isset($_SESSION['login']) && isset($_SESSION['pwd'])) {
	$login = $_SESSION['login'];
	$pwd = $_SESSION['pwd'];
}

if(isset($_POST['deconnexion']) && $_POST['deconnexion']) {
	session_destroy();
	header('Location: ../index.php');
  	exit();
}
?>
<!DOCTYPE html>
<html lang="Fr">
  <head>
      <title>MEDSOFT - Création Médecin</title>
      <meta charset="utf-8">
	  <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
	  <link rel="stylesheet" href="../fontawesome-free-6.2.1-web/css/all.css">
	  <link rel="stylesheet" href="../css/style.css"> 
  </head>
  
  <body class="bleu">
  
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
		if(isset($_POST['nom']) and $_POST['nom']!="" and preg_match("/^[[:alpha:]][[:alpha:][:space:]éèçàù'-]{0,33}[[:alpha:]éèçàù]$/", $_POST['nom'])) {
			$nom=htmlspecialchars($_POST['nom']);
		} else {
			$nom="";
			$ToutOK=false;
		}
		// TODO => Attention aux caractères ' " ...
		
		//Récupération du prenom
		if(isset($_POST['prenom']) and $_POST['prenom']!="" and preg_match("^[A-Z][A-Za-z\é\è\ê\-]+$^", $_POST['prenom'])) {
			$prenom=htmlspecialchars($_POST['prenom']);
		} else {
			$prenom="";
			$ToutOK=false;
		}

		//Récupération de l'adresse
		if(isset($_POST['adresse']) and $_POST['adresse']!="" and preg_match("/\b(?!\d{5}\b)\d+\b(?:\s*\w\b)?(?=\D*\b\d{5}\b|\D*$)/", $_POST['adresse'])) {
			$adresse=htmlspecialchars($_POST['adresse']);
		} else {
			$adresse="";
			$ToutOK=false;
		}
		//Récupération du numéro de portable
		if(isset($_POST['portable']) and $_POST['portable']!="" and preg_match("~(0){1}[0-9]{9}~", $_POST['portable'])) {
			$portable=htmlspecialchars($_POST['portable']);
		} else {
			$portable="";
			$ToutOK=false;
		}
		//Récupération de l'email
		if(isset($_POST['mail']) and $_POST['mail']!="" and preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $_POST['mail'])) {
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

		//Récupération de l'identifiant
		if(isset($_POST['identifiant']) and $_POST['identifiant']!="") {
			$identifiant = htmlspecialchars($_POST['identifiant']);
		} else {
			$identifiant ="";
			$ToutOK = false;
		}

		//Récupération du mot de passe
		if(isset($_POST['motDePasse']) and $_POST['motDePasse']!="") {
			$motDePasse = htmlspecialchars($_POST['motDePasse']);
		} else {
			$motDePasse ="";
			$ToutOK = false;
		}

		$role = 'ADM';		
		$erreur = '';

		if($ToutOK) {
			try {
				$pdo->beginTransaction(); // N'exécute pas si problème dans une des deux insersions

				$requete = "INSERT INTO utilisateurs (identifiant, motDePasse, code_role) VALUES (?, ?, ?);";
				$stmt = $pdo->prepare($requete);
				$stmt->execute([$identifiant, $motDePasse, $role]);

				$requete2 = "INSERT INTO medecins (nom, prenom, dateNai, adresse, tel, email, id_util) VALUES (?, ?, ?, ?, ?, ?, ?);";
				$stmt2 = $pdo->prepare($requete2);
				$stmt2->execute([$nom, $prenom, $date, $adresse, $portable, $mail, $identifiant]);

				$pdo->commit();
			} catch (PDOException $e) {
				$erreur = $e->getMessage();
				$pdo->rollBack();
			}
		}

		if ($ToutOK && $erreur == '') {
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
						<!--Titre "Création d'un medecin"-->
						<div class="col-md-12 col-sm-12 col-xs-12 titre titreCreation">
							Création d'un médecin
						</div>
						<!--Message-->
						<div class="col-md-12 col-sm-12 col-xs-12 titreOK">
							<h2>Enregistrement du nouveau medecin validé !</h2>
						</div>
					</div>
				</div>
			</div>
		<?php					
		} elseif ($ToutOK && $erreur != '') {
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
							<button type="button" class="btn btn-info btn-circle btn-xl" name="recherche" value="true"><span class="fas fa-search"></button>
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
						<!--Titre "Création d'un medecin"-->
						<div class="col-md-12 col-sm-12 col-xs-12 titre titreCreation">
							Création d'un médecin
						</div>
						<!--Message-->
						<div class="col-md-12 col-sm-12 col-xs-12 titreOK">
							<h2>Erreur lors de l'enregistrement ! </br> <?php echo $erreur ?></h2>
						</div>
						<!--Retour création-->
						<div class="col-md-12 col-sm-12 col-xs-12">
							</br> </br> </br>
							<a href="creationMedecin.php">Retour à la création</a>
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
							Création d'un medecin
						</div>
						<div class="row paddingForm">
							<!--Formulaire-->
							<form action="creationMedecin.php" method="post">
								<div class="col-md-12 col-sm-12 col-xs-12 formPatient">
								
									<!--Partie Gauche-->
									<div class="col-md-6 col-sm-12 col-xs-12">
										<!--Saisie du nom-->
										</br>
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
											<!--Saisie de l'adresse-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if($adresse=="") { echo "enRouge";}?>">
												<label for="adresse">Adresse : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="adresse" class="form-control" placeholder="Ex : 4 rue de Jarlard 81000 Albi" value="<?php echo $adresse;?>">
											</div>
										</div>
										<div class="row">
											<!--Saisie du téléphone-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if($portable=="") { echo "enRouge";}?>">
												<label for="portable">Portable : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="tel" name="portable" class="form-control" placeholder="Ex : 0611223344" pattern="[0][0-9]{1}[0-9]{8}" value="<?php echo $portable;?>">
											</div>
										</div>
										<div class="row">
											<!--Saisie du mail-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if($mail=="") { echo "enRouge";}?>">
												<label for="mail">Email : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="email" name="mail" class="form-control" placeholder="Ex : prenom.nom@gmail.com" value="<?php echo $mail;?>">
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
									</div>
								
									<!--Partie Droite-->
									<div class="col-md-6 col-sm-12 col-xs-12 formGD">
										<div class="row paddingForm center">
											<h3 class="entete">Coordonnées de connexion :</h3>
										</div>
										<div class="row paddingForm">
											<!--Saisie de l'identifiant -->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if($identifiant=="") { echo "enRouge";}?>">
												<label for="identifiant">Identifiant : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="identifiant" class="form-control" value="<?php echo $identifiant;?>">
											</div>
										</div>
										<div class="row paddingForm">
											<!--Saisie du mot de passe -->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if($motDePasse=="") { echo "enRouge";}?>">
												<label for="motDePasse" >Mot de passe : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="motDePasse" class="form-control" value="<?php echo $motDePasse;?>">
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
