<?php
session_start(); //démarrage d'une session

	// Test si on est bien connecté (session existante et bon numéro de session
	if (!isset($_SESSION['login']) || !isset($_SESSION['id']) || $_SESSION['id']!=session_id()) {
		// Renvoi vers la page de connexion
  		header('Location: ../index.php');
  		exit();
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
  
  <body class="bleu">
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
								<th class="thAdm"><span class="fas fa-eye"></th>
							</tr>
							<?php 
							$selectAllMedecins = $pdo->query('SELECT * FROM medecins JOIN utilisateurs ON id_util = identifiant');
							while($ligne = $selectAllMedecins->fetch()) {
								echo '<form action="dossierMedecin.php" method="post">';
									echo '<tr class="ligneMed">';
										echo '<input type="hidden" name="idMed" value="'.$ligne['id_med'].'">';
										echo '<td>'.$ligne['nom'].'</td>';
										echo '<td>'.$ligne['prenom'].'</td>';
										echo '<td>'.$ligne['email'].'</td>';
										echo '<td>'.$ligne['id_util'].'</td>';
										echo '<td>'.$ligne['motDePasse'].'</td>';
										echo '<td><button type="submit" class="btn btn-secondary" title="Voir le dossier"><span class="fas fa-eye"></button>';
									echo '</tr>';
								echo '</form>';
							}
							?>
						</table>
					<!--Bouton "Ajouter un médecin" -->
					<div class="row divBtnA left">
						<a href="creationMedecin.php"><button type="button" class="btn btn-info btn-circle btn-xl" name="ajouter" value="true"><span class="fas fa-plus"></button> Ajouter un médecin</a>
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
					for($i = 1; $i <= 9; $i++) {
						$tabName = array('CIS_bdpm.txt','CIS_CIP_bdpm.txt','CIS_COMPO_bdpm.txt',
						'CIS_CPD_bdpm.txt', 'CIS_GENER_bdpm.txt','CIS_HAS_ASMR_bdpm.txt',
						'CIS_HAS_SMR_bdpm.txt','CIS_InfoImportantes_bdpm.txt','HAS_LiensPageCT_bdpm.txt');
						$target_dir = "../fichierImport/";
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
						//Si uploadOk = 0, c'est qu'il y a eu une erreur
						if ($uploadOk == 0) {
							echo "Le fichier n'a pas pu être traité.</br>";
						// Sinon, essaye d'upload le fichier
						} else {
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
			$verifFic = array();
			if(isset($_POST['ValidationImport'])) {
				try {
					$tabName = array('CIS_bdpm.txt','CIS_CIP_bdpm.txt','CIS_COMPO_bdpm.txt',
					'CIS_CPD_bdpm.txt', 'CIS_GENER_bdpm.txt','CIS_HAS_ASMR_bdpm.txt',
					'CIS_HAS_SMR_bdpm.txt','CIS_InfoImportantes_bdpm.txt','HAS_LiensPageCT_bdpm.txt');
					$target_dir = "../fichierImport/";
					for($i = 0; $i <= 8; $i++) {
						$file = $target_dir.$tabName[$i];
						$tabFichier = file($file,FILE_IGNORE_NEW_LINES);
						foreach($tabFichier as $ligne) { 
							$tab = explode(chr(9), $ligne);	
							if($i == 0) {
								// $codeCis = iconv(mb_detect_encoding($tab[0], mb_detect_order(), true), "UTF-8", $tab[0]);
								// $denom = iconv(mb_detect_encoding($tab[1], mb_detect_order(), true), "UTF-8", $tab[1]);
								// $forme = iconv(mb_detect_encoding($tab[2], mb_detect_order(), true), "UTF-8", $tab[2]);
								// $voie = iconv(mb_detect_encoding($tab[3], mb_detect_order(), true), "UTF-8", $tab[3]);
								// $statut = iconv(mb_detect_encoding($tab[4], mb_detect_order(), true), "UTF-8", $tab[4]);
								// $typeProced = iconv(mb_detect_encoding($tab[5], mb_detect_order(), true), "UTF-8", $tab[5]);
								// $etatCommerc = iconv(mb_detect_encoding($tab[6], mb_detect_order(), true), "UTF-8", $tab[6]);
								// $dateAMM = iconv(mb_detect_encoding($tab[7], mb_detect_order(), true), "UTF-8", $tab[7]);
								// $statutBdm = iconv(mb_detect_encoding($tab[8], mb_detect_order(), true), "UTF-8", $tab[8]);
								// $numeroAutoUE = iconv(mb_detect_encoding($tab[9], mb_detect_order(), true), "UTF-8", $tab[9]);
								// $titulaire = iconv(mb_detect_encoding($tab[10], mb_detect_order(), true), "UTF-8", $tab[10]);
								// $surveillance = iconv(mb_detect_encoding($tab[11], mb_detect_order(), true), "UTF-8", $tab[11]);
								// $insertMedic=$pdo->prepare('INSERT INTO CIS_bdpm (codeCis, denomination, forme, voieAdmin, statutAdmin, typeProcedure, etatCommerc, dateAMM, statutBdm, numeroAutoUE, titulaire, surveillance) VALUES (:codeCis , :denom, :forme, :voie, :statut, :typeProced, :etatCommerc, :dateAMM, :statutBdm, :numeroAutoUE, :titulaire, :surveillance)');
								// $insertMedic->bindParam('codeCis', $codeCis);
								// $insertMedic->bindParam('denom', $denom);
								// $insertMedic->bindParam('forme', $forme);
								// $insertMedic->bindParam('voie', $voie);
								// $insertMedic->bindParam('statut', $statut);
								// $insertMedic->bindParam('typeProced', $typeProced);
								// $insertMedic->bindParam('etatCommerc', $etatCommerc);
								// $insertMedic->bindParam('dateAMM', $dateAMM);
								// $insertMedic->bindParam('statutBdm', $statutBdm);
								// $insertMedic->bindParam('numeroAutoUE', $numeroAutoUE);
								// $insertMedic->bindParam('titulaire', $titulaire);
								// $insertMedic->bindParam('surveillance', $surveillance);
								// $insertMedic->execute();
							}
							if($i == 1) {
								// $codeCis_CIP = iconv(mb_detect_encoding($tab[0], mb_detect_order(), true), "UTF-8", $tab[0]);
								// $codeCip7 = iconv(mb_detect_encoding($tab[1], mb_detect_order(), true), "UTF-8", $tab[1]);
								// $libelle = iconv(mb_detect_encoding($tab[2], mb_detect_order(), true), "UTF-8", $tab[2]);
								// $statutAdmin = iconv(mb_detect_encoding($tab[3], mb_detect_order(), true), "UTF-8", $tab[3]);
								// $etatCommerc = iconv(mb_detect_encoding($tab[4], mb_detect_order(), true), "UTF-8", $tab[4]);
								// $dateDecla = iconv(mb_detect_encoding($tab[5], mb_detect_order(), true), "UTF-8", $tab[5]);
								// $codeCip13 = iconv(mb_detect_encoding($tab[6], mb_detect_order(), true), "UTF-8", $tab[6]);
								// $agrement = iconv(mb_detect_encoding($tab[7], mb_detect_order(), true), "UTF-8", $tab[7]);
								// $tauxRemboursement = iconv(mb_detect_encoding($tab[8], mb_detect_order(), true), "UTF-8", $tab[8]);
								// $prix = iconv(mb_detect_encoding($tab[10], mb_detect_order(), true), "UTF-8", $tab[10]);
								// $droitRemboursement = iconv(mb_detect_encoding($tab[12], mb_detect_order(), true), "UTF-8", $tab[12]);
								// $insertMedic=$pdo->prepare('INSERT INTO CIS_CIP_bdpm (codeCis_CIP, codeCip7, libelle, statutAdmin, etatCommerc, dateDecla, codeCip13, agrement, tauxRemboursement, prix, droitRemboursement) VALUES (:codeCis_CIP, :codeCip7, :libelle, :statutAdmin, :etatCommerc, :dateDecla, :codeCip13, :agrement, :tauxRemboursement, :prix, :droitRemboursement)');
								// $insertMedic->bindParam('codeCis_CIP', $codeCis_CIP);
								// $insertMedic->bindParam('codeCip7', $codeCip7);
								// $insertMedic->bindParam('libelle', $libelle);
								// $insertMedic->bindParam('statutAdmin', $statutAdmin);
								// $insertMedic->bindParam('etatCommerc', $etatCommerc);
								// $insertMedic->bindParam('dateDecla', $dateDecla);
								// $insertMedic->bindParam('codeCip13', $codeCip13);
								// $insertMedic->bindParam('agrement', $agrement);
								// $insertMedic->bindParam('tauxRemboursement', $tauxRemboursement);
								// $insertMedic->bindParam('prix', $prix);
								// $insertMedic->bindParam('droitRemboursement', $droitRemboursement);
								// $insertMedic->execute();
							}
							if($i == 2) {
								$codeCis_COMPO = iconv(mb_detect_encoding($tab[0], mb_detect_order(), true), "UTF-8", $tab[0]);
								$designation = iconv(mb_detect_encoding($tab[1], mb_detect_order(), true), "UTF-8", $tab[1]);
								$codeSubstance = iconv(mb_detect_encoding($tab[2], mb_detect_order(), true), "UTF-8", $tab[2]);
								$denomSubstance = iconv(mb_detect_encoding($tab[3], mb_detect_order(), true), "UTF-8", $tab[3]);
								$dosage = iconv(mb_detect_encoding($tab[4], mb_detect_order(), true), "UTF-8", $tab[4]);
								$refDosage = iconv(mb_detect_encoding($tab[5], mb_detect_order(), true), "UTF-8", $tab[5]);
								$natureCompo = iconv(mb_detect_encoding($tab[6], mb_detect_order(), true), "UTF-8", $tab[6]);
								$numeroLier = iconv(mb_detect_encoding($tab[7], mb_detect_order(), true), "UTF-8", $tab[7]);
								$insertMedic=$pdo->prepare('INSERT INTO CIS_COMPO_bdpm (codeCis_COMPO, designation, codeSubstance, denomSubstance, dosage, refDosage, natureCompo, numeroLier) VALUES (:codeCis_COMPO, :designation, :codeSubstance, :denomSubstance, :dosage, :refDosage, :natureCompo, :numeroLier)');
								$insertMedic->bindParam('codeCis_COMPO', $codeCis_COMPO);
								$insertMedic->bindParam('designation', $designation);
								$insertMedic->bindParam('codeSubstance', $codeSubstance);
								$insertMedic->bindParam('denomSubstance', $denomSubstance);
								$insertMedic->bindParam('dosage', $dosage);
								$insertMedic->bindParam('refDosage', $refDosage);
								$insertMedic->bindParam('natureCompo', $natureCompo);
								$insertMedic->bindParam('numeroLier', $numeroLier);
								$insertMedic->execute();
							}
							if($i == 3) {
								$codeCis_CPD = iconv(mb_detect_encoding($tab[0], mb_detect_order(), true), "UTF-8", $tab[0]);
								$conditionPrescri = iconv(mb_detect_encoding($tab[1], mb_detect_order(), true), "UTF-8", $tab[1]);
								$insertMedic=$pdo->prepare('INSERT INTO CIS_CPD_bdpm (codeCis_CPD, conditionPrescri) VALUES (:codeCis_CPD, :conditionPrescri)');
								$insertMedic->bindParam('codeCis_CPD', $codeCis_CPD);
								$insertMedic->bindParam('conditionPrescri', $conditionPrescri);
								$insertMedic->execute();
							}
							if($i == 4) {
								$idGroupe = iconv(mb_detect_encoding($tab[0], mb_detect_order(), true), "UTF-8", $tab[0]);
								$libelle = iconv(mb_detect_encoding($tab[1], mb_detect_order(), true), "UTF-8", $tab[1]);
								$codeCis_GENER = iconv(mb_detect_encoding($tab[2], mb_detect_order(), true), "UTF-8", $tab[2]);
								$typeGener = iconv(mb_detect_encoding($tab[3], mb_detect_order(), true), "UTF-8", $tab[3]);
								$numTri = iconv(mb_detect_encoding($tab[4], mb_detect_order(), true), "UTF-8", $tab[4]);
								$insertMedic=$pdo->prepare('INSERT INTO CIS_GENER_bdpm (idGroupe, libelle, codeCis_GENER, typeGener, numTri) VALUES (:idGroupe, :libelle, :codeCis_GENER, :typeGener, :numTri)');
								$insertMedic->bindParam('idGroupe', $idGroupe);
								$insertMedic->bindParam('libelle', $libelle);
								$insertMedic->bindParam('codeCis_GENER', $codeCis_GENER);
								$insertMedic->bindParam('typeGener', $typeGener);
								$insertMedic->bindParam('numTri', $numTri);
								$insertMedic->execute();
							}
							if($i == 5) {
								$codeCis_HAS_ASMR = iconv(mb_detect_encoding($tab[0], mb_detect_order(), true), "UTF-8", $tab[0]);
								$codeDossier = iconv(mb_detect_encoding($tab[1], mb_detect_order(), true), "UTF-8", $tab[1]);
								$motifEval = iconv(mb_detect_encoding($tab[2], mb_detect_order(), true), "UTF-8", $tab[2]);
								$dateAvis = iconv(mb_detect_encoding($tab[3], mb_detect_order(), true), "UTF-8", $tab[3]);
								$valeurASMR = iconv(mb_detect_encoding($tab[4], mb_detect_order(), true), "UTF-8", $tab[4]);
								$libelle = iconv(mb_detect_encoding($tab[5], mb_detect_order(), true), "UTF-8", $tab[5]);
								$insertMedic=$pdo->prepare('INSERT INTO CIS_HAS_ASMR_bdpm (codeCis_HAS_ASMR, codeDossier, motifEval, dateAvis, valeurASMR, libelle) VALUES (:codeCis_HAS_ASMR, :codeDossier, :motifEval, :dateAvis, :valeurASMR, :libelle)');
								$insertMedic->bindParam('codeCis_HAS_ASMR', $codeCis_HAS_ASMR);
								$insertMedic->bindParam('codeDossier', $codeDossier);
								$insertMedic->bindParam('motifEval', $motifEval);
								$insertMedic->bindParam('dateAvis', $dateAvis);
								$insertMedic->bindParam('valeurASMR', $valeurASMR);
								$insertMedic->bindParam('libelle', $libelle);
								$insertMedic->execute();
							}
							if($i == 6) {
								$codeCis_HAS_SMR = iconv(mb_detect_encoding($tab[0], mb_detect_order(), true), "UTF-8", $tab[0]);
								$codeDossier = iconv(mb_detect_encoding($tab[1], mb_detect_order(), true), "UTF-8", $tab[1]);
								$motifEval = iconv(mb_detect_encoding($tab[2], mb_detect_order(), true), "UTF-8", $tab[2]);
								$dateAvis = iconv(mb_detect_encoding($tab[3], mb_detect_order(), true), "UTF-8", $tab[3]);
								$valeurSMR = iconv(mb_detect_encoding($tab[4], mb_detect_order(), true), "UTF-8", $tab[4]);
								$libelle = iconv(mb_detect_encoding($tab[5], mb_detect_order(), true), "UTF-8", $tab[5]);
								$insertMedic=$pdo->prepare('INSERT INTO CIS_HAS_SMR_bdpm (codeCis_HAS_SMR, codeDossier, motifEval, dateAvis, valeurSMR, libelle) VALUES (:codeCis_HAS_SMR, :codeDossier, :motifEval, :dateAvis, :valeurSMR, :libelle)');
								$insertMedic->bindParam('codeCis_HAS_SMR', $codeCis_HAS_SMR);
								$insertMedic->bindParam('codeDossier', $codeDossier);
								$insertMedic->bindParam('motifEval', $motifEval);
								$insertMedic->bindParam('dateAvis', $dateAvis);
								$insertMedic->bindParam('valeurSMR', $valeurSMR);
								$insertMedic->bindParam('libelle', $libelle);
								$insertMedic->execute();
							}
							if($i == 7) {
								$codeCis_INFO = iconv(mb_detect_encoding($tab[0], mb_detect_order(), true), "UTF-8", $tab[0]);
								$dateDebut = iconv(mb_detect_encoding($tab[1], mb_detect_order(), true), "UTF-8", $tab[1]);
								$dateFin = iconv(mb_detect_encoding($tab[2], mb_detect_order(), true), "UTF-8", $tab[2]);
								$texteLien = iconv(mb_detect_encoding($tab[3], mb_detect_order(), true), "UTF-8", $tab[3]);
								$insertMedic=$pdo->prepare('INSERT INTO CIS_InfoImportantes_bdpm (codeCis_INFO, dateDebut, dateFin, texteLien) VALUES (:codeCis_INFO, :dateDebut, :dateFin, :texteLien)');
								$insertMedic->bindParam('codeCis_INFO', $codeCis_INFO);
								$insertMedic->bindParam('dateDebut', $dateDebut);
								$insertMedic->bindParam('dateFin', $dateFin);
								$insertMedic->bindParam('texteLien', $texteLien);
								$insertMedic->execute();
							}
							if($i == 8) {
								$codeHas = iconv(mb_detect_encoding($tab[0], mb_detect_order(), true), "UTF-8", $tab[0]);
								$liensPage = iconv(mb_detect_encoding($tab[1], mb_detect_order(), true), "UTF-8", $tab[1]);
								$insertMedic=$pdo->prepare('INSERT INTO HAS_LiensPageCT_bdpm (codeHas, liensPage) VALUES (:codeHas, :liensPage)');
								$insertMedic->bindParam('codeHas', $codeHas);
								$insertMedic->bindParam('liensPage', $liensPage);
								$insertMedic->execute();
							}

						}
						echo '<h3>Insert de '.$tabName[$i].' réussi.</h3>';
					}
				} catch(exception $e) {
					var_dump($ligne);
					var_dump($tab);
					echo "erreur : ".$e->getMessage();
				}
			}
			?>
			<div class="row">
				<form method="post" action="accueilAdmin.php" enctype="multipart/form-data">
					<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
					<div class="row">
						<div class="col-md-6 col-xs-6 col-sm-6">
							<input type="file" name="cis1" accept=".txt">
						</div>
						<div class="col-md-6 col-xs-6 col-sm-6">
							<label class="<?php
							if(!file_exists("../fichierImport/CIS_bdpm.txt")) {
								echo 'enRouge';
								array_push($verifFic, false);
							} else {
								echo 'enVert';
								array_push($verifFic, true);
							}
							?>">Fichier CIS_bdpm</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-xs-6 col-sm-6">
							<input type="file" name="cis2" accept=".txt">
						</div>
						<div class="col-md-6 col-xs-6 col-sm-6">
							<label class="<?php
							if(!file_exists("../fichierImport/CIS_CIP_bdpm.txt")) {
								echo 'enRouge';
								array_push($verifFic, false);
							} else {
								echo 'enVert';
								array_push($verifFic, true);
							}
							?>">Fichier CIS_CIP_bdpm</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-xs-6 col-sm-6">
							<input type="file" name="cis3" accept=".txt">
						</div>
						<div class="col-md-6 col-xs-6 col-sm-6">
							<label class="<?php
							if(!file_exists("../fichierImport/CIS_COMPO_bdpm.txt")) {
								echo 'enRouge';
								array_push($verifFic, false);
							} else {
								echo 'enVert';
								array_push($verifFic, true);
							}
							?>">Fichier CIS_COMPO_bdpm</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-xs-6 col-sm-6">
							<input type="file" name="cis4" accept=".txt">
						</div>
						<div class="col-md-6 col-xs-6 col-sm-6">
							<label class="<?php
							if(!file_exists("../fichierImport/CIS_CPD_bdpm.txt")) {
								echo 'enRouge';
								array_push($verifFic, false);
							} else {
								echo 'enVert';
								array_push($verifFic, true);
							}
							?>">Fichier CIS_CPD_bdpm</label>
						</div>
					</div>	
					<div class="row">
						<div class="col-md-6 col-xs-6 col-sm-6">
							<input type="file" name="cis5" accept=".txt">
						</div>
						<div class="col-md-6 col-xs-6 col-sm-6">
							<label class="<?php
							if(!file_exists("../fichierImport/CIS_GENER_bdpm.txt")) {
								echo 'enRouge';
								array_push($verifFic, false);
							} else {
								echo 'enVert';
								array_push($verifFic, true);
							}
							?>">Fichier CIS_GENER_bdpm</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-xs-6 col-sm-6">
							<input type="file" name="cis6" accept=".txt">
						</div>
						<div class="col-md-6 col-xs-6 col-sm-6">
							<label class="<?php
							if(!file_exists("../fichierImport/CIS_HAS_ASMR_bdpm.txt")) {
								echo 'enRouge';
								array_push($verifFic, false);
							} else {
								echo 'enVert';
								array_push($verifFic, true);
							}
							?>">Fichier CIS_HAS_ASMR_bdpm</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-xs-6 col-sm-6">
							<input type="file" name="cis7" accept=".txt">
						</div>
						<div class="col-md-3 col-xs-3 col-sm-3">
							<label class="<?php
							if(!file_exists("../fichierImport/CIS_HAS_SMR_bdpm.txt")) {
								echo 'enRouge';
								array_push($verifFic, false);
							} else {
								echo 'enVert';
								array_push($verifFic, true);
							}
							?>">Fichier CIS_HAS_SMR_bdpm</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-xs-6 col-sm-6">
							<input type="file" name="cis8" accept=".txt">
						</div>
						<div class="col-md-6 col-xs-6 col-sm-6">
							<label class="<?php
							if(!file_exists("../fichierImport/CIS_InfoImportantes_bdpm.txt")) {
								echo 'enRouge';
								array_push($verifFic, false);
							} else {
								echo 'enVert';
								array_push($verifFic, true);
							}
							?>">Fichier CIS_InfoImportantes_bdpm</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-xs-6 col-sm-6">
							<input type="file" name="cis9" accept=".txt">
						</div>
						<div class="col-md-6 col-xs-6 col-sm-6">
							<label class="<?php
							if(!file_exists("../fichierImport/HAS_LiensPageCT_bdpm.txt")) {
								echo 'enRouge';
								array_push($verifFic, false);
							} else {
								echo 'enVert';
								array_push($verifFic, true);
							}
							?>">Fichier HAS_LiensPageCT_bdpm</label>
						</div>
					</div>
					<div class="col-md-6 col-xs-6 col-sm-6">
						<input type="submit" value="Upload" name="btnImport" class="btnImport">
					</div>
					</form>	
					<?php
					$allVerifOk = true;
					for($i = 0; $i < count($verifFic); $i++) {
						if($verifFic[$i] == false) {
							$allVerifOk = false;
						}
					}
					if($allVerifOk) {
						?>
					<form action="accueilAdmin.php" method="post">
						<div class="col-md-6 col-xs-6 col-sm-6">
							<input hidden value="ValidationImport" name="ValidationImport">
							<input type="submit" value="Importer" name="btnImport2" class="btnImport">
						</div>
							<?php
						}
						?>
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

