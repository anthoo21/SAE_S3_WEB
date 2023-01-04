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

		$_SESSION['idMed'] = $_POST['idMed'];
		
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
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		// Si le bouton "Voir le dossier" depuis "accueilAdmin.php" n'est pas activé
		if(!isset($_SESSION['idMed'])) {
			header('Location: accueilAdmin.php');
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
					<form action="accueilAdmin.php" method="post">
						<button type="submit" class="btn btn-danger btn-circle btn-xxl" name="deconnexion" value="true" title="Déconnexion"><span class="fas fa-power-off"></button>
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
					<!--Titre "Dossier du patient"-->
					<div class="col-md-9 col-sm-12 col-xs-12 titreDossier">
						Dossier du médecin : <?php echo $nom.' '.$prenom;?> 
					</div>
					<div class="col-md-2 hidden-sm hidden-xs">
					</div>
					
					<!-- Boutons de modification -->
					<!--<div class="col-md-1 col-sm-12 col-xs-12 titreDossier">
						<form action="modificationPatient.php" method="post">
							<button type="submit" class="btn btn-success btn-circle btn-xl" name="modifPatient" value="true" title="Modifier ce patient"><span class="fas fa-pencil"></span></button>		
							<input type="hidden" name="idCV" value="<?php echo $noCV;?>">
						</form>
					</div>-->

					<!-- Boutons de retour -->
					<div class="col-md-1 col-sm-12 col-xs-12 titreDossier">
						<form action="accueilAdmin.php" method="post">
							<button type="submit" class="btn btn-danger btn-circle btn-xxl" name="retour" value="true" title="Retour à l'accueil administrateur"><span class="fas fa-arrow-left"></span></button>
						</form>
					</div>
					
					<!-- Affichage des informations générales du medecin-->
					<div class="col-md-7 col-sm-12 col-xs-12 paddingDossier">
						<div class="col-md-12 col-sm-12 col-xs-12 bordureD">
							<div class="col-md-12 col-sm-12 col-xs-12 paddingForm">
								<?php
									echo '<h3 class="entete">Informations générales</h3>';
									echo '<p>Nom : '.$nom.'</p>';
									echo '<p>Prénom : '.$prenom.'</p>';
									echo '<p>Date de naissance : '.$date.'</p>';
									echo '<p>Adresse : '.$adresse.'</p>';
									echo '<p>Telephone : '.$tel.'</p>';
									echo '<p>Email : '.$email.'</p>';
									echo '<p>Identifiant : '.$identifiant.'</p>';
									echo '<p>Mot de passe : '.$mdp.'</p>';
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
  </body>
</html>
