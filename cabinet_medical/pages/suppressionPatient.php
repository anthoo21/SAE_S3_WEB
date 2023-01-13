<?php
session_start(); //démarrage d'une session


//Vérification que les variables sessions de l'utilisateur existent
if(isset($_SESSION['login']) && isset($_SESSION['pwd'])) {
	$login = $_SESSION['login'];
	$pwd = $_SESSION['pwd'];
	$nom = $_SESSION['nom'];
	$prenom = $_SESSION['prenom'];
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
		
		$_SESSION['idPatient'];
		
		// Récupération du nom et prénom du patient
		try {
			$requeteP="SELECT patients.nom, patients.prenom
			FROM patients
			WHERE patients.numeroCarteVitale = :id";
			$resultats = $pdo->prepare($requeteP);
			$resultats->bindParam('id', $_SESSION['idPatient']);
			$resultats->execute();
			while($ligne = $resultats->fetch()) {
				$nom = $ligne['nom'];
				$prenom = $ligne['prenom'];
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		// Suppression du patient
		if(isset($_POST['Supprimer']) and $_POST['Supprimer']) {
			try {
				// Suppression des prescriptions
				$requetePres='DELETE FROM prescriptions WHERE id_ordonnance IN(
								SELECT id_ordo FROM ordonnances
								WHERE id_visite IN (
									SELECT id_visite FROM visites
									WHERE id_patient IN (
										SELECT numeroCarteVitale FROM patients
										WHERE numeroCarteVitale = :id
									)
								)
							)';
				$stmt = $pdo->prepare($requetePres);
				$stmt->bindParam('id', $_SESSION['idPatient']);

				// Suppression des ordonnances 
				$requeteOrd='DELETE FROM ordonnances WHERE id_visite IN(
								SELECT id_visite FROM visites
								WHERE id_patient IN (
									SELECT numeroCarteVitale FROM patients
									WHERE numeroCarteVitale = :id
								)
							)';
				$stmt2 = $pdo->prepare($requeteOrd);
				$stmt2->bindParam('id', $_SESSION['idPatient']);

				// Suppression des visites
				$requeteVis='DELETE FROM visites WHERE id_patient IN (
								SELECT numeroCarteVitale FROM patients
								WHERE numeroCarteVitale = :id
							)';
				$stmt3 = $pdo->prepare($requeteVis);
				$stmt3->bindParam('id', $_SESSION['idPatient']);

				// Suppression du patient
				$requetePat='DELETE FROM patients WHERE numeroCarteVitale = :id';
				$stmt4 = $pdo->prepare($requetePat);
				$stmt4->bindParam('id', $_SESSION['idPatient']);
				
				$stmt->execute();	
				$stmt2->execute();
				$stmt3->execute();
				$stmt4->execute();			
				
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		}
		if(isset($_POST['Annuler']) and $_POST['Annuler']) {
			header('Location: dossierPatient.php');
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
			<?php if(isset($_POST['Supprimer']) and $_POST['Supprimer']) {?>
			<div class="row paddingForm">
				<!--Message-->
				<div class="col-md-12 col-sm-12 col-xs-12 titreOK">
					<div class="col-md-12 col-sm-12 col-xs-12 center">
						<span class="fas fa-check"></span>
						<h3>Le patient <?php echo $nom.' '.$prenom;?> a été supprimé de la base de données</h3>
					</div>
				</div>
			</div>
			<?php } else {?>
			<div class="row paddingForm">
				<!--Message-->
				<div class="col-md-12 col-sm-12 col-xs-12 titreOK">
					<div class="col-md-12 col-sm-12 col-xs-12 center">
						<span class="fas fa-triangle-exclamation"></span>
						<h3>Lorsque vous supprimez un patient, les visites et ordonnances </br>qui lui sont associées seront également supprimé.</h3>
						<h3>Voulez-vous supprimer le patient <?php echo $nom.' '.$prenom;?> ?</h3>
					</div>
					<!--Bouton Supprimer-->
					<div class="col-md-6 col-sm-6 col-xs-6 center">
						<form action="suppressionPatient.php" method="post">
							<input type="submit" name="Supprimer" class="btn btn-success btn-xl" value="SUPPRIMER">
						</form>
					</div>
					<!--Bouton Annuler-->
					<div class="col-md-6 col-sm-6 col-xs-6 center">
						<form action="dossierPatient.php" method="post">
							<input type="hidden" name="id" value="<?php echo $_SESSION['idPatient'];?>">
							<input type="submit" name="Annuler" class="btn btn-secondary btn-xl" value="ANNULER">
						</form>
					</div>
				</div>
			</div>
			<?php }?>
		</div>
  </body>
</html>
