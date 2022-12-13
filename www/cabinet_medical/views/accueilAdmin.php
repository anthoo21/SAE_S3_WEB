<!DOCTYPE html>
<html lang="Fr">
  <head>
      <title>MEDSOFT - Accueil Medecin</title>
      <meta charset="utf-8">
	  <link rel="stylesheet" href="css\style.css"> 
	  <link rel="stylesheet" href="bootstrap\css\bootstrap.css">
	  <link rel="stylesheet" href="fontawesome-free-5.10.2-web\css\all.css">
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
				<img class="logo5" src="../assets/deconnexion.png" alt="logo deconnexion">
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
						<a href="#"><img class="logo7" src="../assets/ajouterM.png" alt="logo ajouter">Ajouter un médecin</a>
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
			<?php 
			// && $_POST['cis1'] != "" && $_POST['cis2'] != "" && $_POST['cis3'] != "" && $_POST['cis4'] != "" 
			//	&& $_POST['cis5'] != "" && $_POST['cis6'] != "" && $_POST['cis7'] != "" && $_POST['cis8'] != ""
			if(isset($_FILES['cis1'])) {
				try {
					$tabName = array('Part1.txt','CIS_CIP_bdpm.txt', 'CIS_COMPO_bdpm.txt', 'CIS_CPD_bdpm.txt', 'CIS_GENER_bdpm.txt','CIS_HAS_ASMR_bdpm','CIS_HAS_SMR_bdpm','CIS_InfoImportantes_bdpm','HAS_LiensPageCT_bdpm');
					$target_dir = "../fichierImport/";
					for($i = 1; $i <= 9; $i++) {
						$uploadOk = 1;
						$target_file = $target_dir.basename($_FILES["cis".strval($i)]["name"]);
						$ficType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));			
						// Regarder si le fichier existe déjà
						if (file_exists($target_file)) {
							$uploadOk = 0;
						}
						// Accepter que les .txt
						if($ficType != "txt") {
							$uploadOk = 0;
						}
						// Vérifie si le fichier est le bon
						if(htmlspecialchars(basename($_FILES["cis".strval($i)]["name"])) != $tabName[$i-1]) {
							$uploadOk = 0;
						}
						// $listeMedic = basename($_FILES["cis".strval($i)]["name"]);
						// $tabMedic = file($listeMedic,FILE_IGNORE_NEW_LINES);
						// foreach ($tabMedic as $listeMedoc) {
						// 	$tab = explode('	',$listeMedoc);
						// 	echo $tab[0];
						// }
						//Si uploadOk = 0, c'est qu'il y a eu une erreur
						if ($uploadOk == 0) {
							echo "Le fichier n'a pas pu être traité.</br>";
						// Sinon, essaye d'upload le fichier
						} else {
							echo $_FILES["cis1"]["size"];
							if (move_uploaded_file($_FILES["cis".strval($i)]["tmp_name"], $target_file)) {
								echo "Le fichier ".basename( $_FILES["cis".strval($i)]["name"])." a été correctement importé.</br>";
							} else {
								echo "Le fichier ".basename( $_FILES["cis".strval($i)]["name"])." provoque une erreur, merci d'importer le bon fichier.</br>";
							}
						}
					}
					/* if($allVerif) {
						echo 'Tous les fichiers sont OK';
					} else {
						echo 'Au moins 1 des fichiers n\'est pas bon';
					} */
				} catch (exception $e) {
					echo "erreur : ".$e->getMessage();
				}
			} 
			
			?>
			<div class="col-md-12 col-xs-12 col-sm-12">
				<form method="post" action="accueilAdmin.php" class="aaa2" enctype="multipart/form-data">
					<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
					<div class="col-md-12 col-xs-12 col-sm-12">
						<input type="file" name="cis1" accept=".txt">
					</div>
					<div class="col-md-12 col-xs-12 col-sm-12">
						<input type="file" name="cis2" accept=".txt">
					</div>
					<div class="col-md-12 col-xs-12 col-sm-12">
						<input type="file" name="cis3" accept=".txt">
					</div>
					<div class="col-md-12 col-xs-12 col-sm-12">
						<input type="file" name="cis4" accept=".txt">
					</div>
					<div class="col-md-12 col-xs-12 col-sm-12">
						<input type="file" name="cis5" accept=".txt">
					</div>
					<div class="col-md-12 col-xs-12 col-sm-12">
						<input type="file" name="cis6" accept=".txt">
					</div>
					<div class="col-md-12 col-xs-12 col-sm-12">
						<input type="file" name="cis7" accept=".txt">
					</div>
					<div class="col-md-12 col-xs-12 col-sm-12">
						<input type="file" name="cis8" accept=".txt">
					</div>
					<div class="col-md-12 col-xs-12 col-sm-12">
						<input type="file" name="cis9" accept=".txt">
					</div>
					<div class="col-md-12 col-xs-12 col-sm-12">
						<input type="submit" value="Importer" name="btnImport" class="btnImport">
					</div>
				</form>	
			</div>
		</div>
	</div>
  </body>
</html>

<?php 
// if(isset($_FILES['fichierUpload']))
// {
// 	$dossier = '../images/Produits/';
// 	var_dump($_FILES);
// 	$fichier = basename($_FILES['fichierUpload']['name']);

// 	$extensions = array('.PNG', '.GIF', '.JPG', '.JPEG');
// 	// récupère la partie de la chaine à partir du dernier . pour connaître l'extension.
// 	$extension = strtoupper(strrchr($_FILES['fichierUpload']['name'], '.'));
// 	//Test si l'extension est prise en charge
// 	if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
// 	{
// 		$OKfichier=false ;
// 		$messageFichier="(Vous devez uploader un fichier de type png, gif, jpg, jpeg)" ;
// 	} else {
// 		$nouveauNomImage="img_".time().$extension ; // Renommage du fichier pour qu'il soit unique

// 		if(move_uploaded_file($_FILES['fichierUpload']['tmp_name'], $dossier . $nouveauNomImage)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
// 		{
// 			echo 'Upload effectué avec succès !';
// 		}
// 		else //Sinon (la fonction renvoie FALSE).
// 		{
// 			echo 'Echec de l\'upload !';
// 			$OKfichier=false ;
// 			$messageFichier="(Probleme chargement fichier)" ;
// 		}
// 	}
// }
?>
