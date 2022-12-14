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
      <title>MEDSOFT - Accueil Medecin</title>
      <meta charset="utf-8">
	  <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
	  <link rel="stylesheet" href="../fontawesome-free-6.2.1-web/css/all.css">
	  <link rel="stylesheet" href="../css/style.css"> 
  </head>
  
  <body>
		<?php 

			$host='localhost';	// Serveur de BD
			$db='medsoft';		// Nom de la BD
			$user='root';		// User 
			$pass='root';		// Mot de passe
			$charset='utf8mb4';	// charset utilisé

			// Constitution variable DSN
			$dsn="mysql:host=$host;dbname=$db;charset=$charset";

			// Réglage des options
			$options=[
				PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES=>false];

			try {
				$pdo=new PDO($dsn,$user,$pass,$options);
			} catch(PDOException $e){
				//Il y a eu une erreur 
				echo "<h1>Erreur : ".$e->getMessage();
			}

		?>
	<div class="container bleu">
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
					<button type="submit" class="btn btn-danger btn-circle btn-xxl" name="deconnexion" value="true"><span class="fas fa-power-off"></button>
				</form>
			</div>	
		</div>
		<div class="row">
		</br>
			<div class="col-md-12 col-sm-12 col-xs-12 adminName">
				ADMINISTRATEUR 
			</div>	
		</div></br>
		<div class="row">
			<div class="col-md-4 col-xs-4 col-sm-4">
				<div class="bordure">
					<?php
					$requeteCabinet=$pdo->query('SELECT nom_cabinet FROM cabinet');
					$requeteAdresse=$pdo->query('SELECT adresse FROM cabinet');
					$requeteNbMed=$pdo->query('SELECT nom FROM medecins');
					$compteMed = $requeteNbMed->rowCount();
					$requeteNbPatients=$pdo->query('SELECT nom FROM patients');
					$comptePatients = $requeteNbMed->rowCount();
					?>
					<h4><u><b>Informations du cabinet</b></u></h4>
					<?php 
					while($ligne=$requeteCabinet->fetch()) {
						echo '<p>Nom : '.$ligne['nom_cabinet'].'</p>';
					}
					?>
					<?php 
					while($ligne=$requeteAdresse->fetch()) {
						echo '<p>Adresse : '.$ligne['adresse'].'</p>';
					}
					?>

					<p>Nombres de médecins : <?php echo $compteMed ?></p>
					<p>Nombres de patients : <?php echo $comptePatients ?></p>


				</div>
			</div>
			<div class="col-md-8 col-xs-8 col-sm-8">
				<div class="bordure">
					<h4><u><b>Gestion des médecins</b></u></h4>
						<table class="table table-bordered">
							<tr>
								<th class="thAdm">Nom</th>
								<th class="thAdm">Prénom</th>
								<th class="thAdm">Email</th>
								<th class="thAdm">Identifiant</th>
								<th class="thAdm">Mot de passe</th>
							</tr>
							<?php 
							$selectAllMedecins = $pdo->query('SELECT * FROM medecins JOIN utilisateurs ON id_util = identifiant');
							while($ligne = $selectAllMedecins->fetch()) {
								echo '<tr class="ligneMed">';
									echo '<td>'.$ligne['nom'].'</td>';
									echo '<td>'.$ligne['prenom'].'</td>';
									echo '<td>'.$ligne['email'].'</td>';
									echo '<td>'.$ligne['id_util'].'</td>';
									echo '<td>'.$ligne['motDePasse'].'</td>';
								echo '</tr>';
							}
							?>
						</table>
					<!--Bouton "Ajouter un médecin" -->
					<div class="row divBtnA left">
						<a href="#"><button type="button" class="btn btn-info btn-circle btn-xl" name="ajouter" value="true"><span class="fas fa-plus"></button> Ajouter un médecin</a>
					</div>
				</div>	
			</div>
		</div>
		<div class="row bordure">
			<div class="col-md-12 col-xs-12 col-sm-12">
				<h4><u><b>Mise à jour des données : </b></u></h4>
			</div>
			<div class="col-md-12 col-xs-12 col-sm-12">
				<p style="color: darkred">Importer les 9 fichiers de la base de données dans la bonne ligne</p>
			</div>
			<div class="col-md-12 col-xs-12 col-sm-12">
				<form method="post" action="accueilAdmin.php" class="aaa2">
					<div class="col-md-12 col-xs-12 col-sm-12">
						<input type="file" id="test"name="cis_bdpm" accept=".txt">
					</div>
					<div class="col-md-12 col-xs-12 col-sm-12">
						<input type="file" name="cis_cip_bdpm" accept=".txt">
					</div>
					<div class="col-md-12 col-xs-12 col-sm-12">
						<input type="file" name="cis_compo_bdpm" accept=".txt">
					</div>
					<div class="col-md-12 col-xs-12 col-sm-12">
						<input type="file" name="cis_cpd_bdpm" accept=".txt">
					</div>
					<div class="col-md-12 col-xs-12 col-sm-12">
						<input type="file" name="cis_gener_bdpm" accept=".txt">
					</div>
					<div class="col-md-12 col-xs-12 col-sm-12">
						<input type="file" name="cis_has_asmr_bdpm" accept=".txt">
					</div>
					<div class="col-md-12 col-xs-12 col-sm-12">
						<input type="file" name="cis_has_smr_bdpm" accept=".txt">
					</div>
					<div class="col-md-12 col-xs-12 col-sm-12">
						<input type="file" name="cis_infoimportantes_bdpm" accept=".txt">
					</div>
					<div class="col-md-12 col-xs-12 col-sm-12">
						<input type="file" name="has_lienspagect_bdpm" accept=".txt">
					</div>
				</form>	
			</div>
		</div>
	</div>
  </body>
</html>
