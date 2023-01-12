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
		
        $idMedoc = $_POST['idMedoc'];

        try {
            $requeteMedGeneral="SELECT denomination, forme, voieAdmin, statutAdmin, typeProcedure, etatCommerc, dateAMM, statutBdm, numeroAutoUE, titulaire, surveillance FROM cis_bdpm WHERE idGeneral = :idGeneral";
            $resultats=$pdo->prepare($requeteMedGeneral);
            $resultats->bindParam('idGeneral', $idMedoc);
            $resultats->execute();
            while($ligne = $resultats->fetch()) {
                $denomination = $ligne['denomination'];
                $forme = $ligne['forme'];
				$voieAdmin = $ligne['voieAdmin'];
				$statutAdmin = $ligne['statutAdmin'];
				$typeProcedure = $ligne['typeProcedure'];
				$etatCommerc = $ligne['etatCommerc'];
				$dateAMM = $ligne['dateAMM'];
				$statutBdm = $ligne['statutBdm'];
				$numeroAutoUE = $ligne['numeroAutoUE'];
				$titulaire = $ligne['titulaire'];
				$surveillance = $ligne['surveillance'];
            }
			$requeteMedCIP="SELECT libelle, dateDecla, agrement, tauxRemboursement, prix, droitRemboursement FROM cis_bdpm JOIN cis_cip_bdpm ON codeCis = codeCis_CIP WHERE idGeneral = :idGeneral";
			$resultats=$pdo->prepare($requeteMedCIP);
            $resultats->bindParam('idGeneral', $idMedoc);
            $resultats->execute();
			while($ligne = $resultats->fetch()) {
                $libelleCIP = $ligne['libelle'];
                $dateDecla = $ligne['dateDecla'];
				$agrement = $ligne['agrement'];
				$tauxRemboursement = $ligne['tauxRemboursement'];
				$prix = $ligne['prix'];
				$droitRemboursement = $ligne['droitRemboursement'];
            }
			$requeteMedCOMPO="SELECT denomSubstance, dosage, refDosage, natureCompo FROM cis_bdpm JOIN cis_compo_bdpm ON codeCis = codeCis_COMPO WHERE idGeneral = :idGeneral";
			$resultats=$pdo->prepare($requeteMedCOMPO);
            $resultats->bindParam('idGeneral', $idMedoc);
            $resultats->execute();
			while($ligne = $resultats->fetch()) {
                $denomSubstance = $ligne['denomSubstance'];
                $dosage = $ligne['dosage'];
				$refDosage = $ligne['refDosage'];
				$natureCompo = $ligne['natureCompo'];
            }
			$requeteMedHASASMR="SELECT motifEval, dateAvis, valeurAsmr, libelle FROM cis_bdpm JOIN cis_has_asmr_bdpm ON codeCis = codeCis_HAS_ASMR WHERE idGeneral = :idGeneral";
			$resultatsASMR=$pdo->prepare($requeteMedHASASMR);
            $resultatsASMR->bindParam('idGeneral', $idMedoc);
            $resultatsASMR->execute();
			while($ligne = $resultatsASMR->fetch()) {
                $motifEval = $ligne['motifEval'];
                $dateAvis = $ligne['dateAvis'];
				$valeurAsmr = $ligne['valeurAsmr'];
				$libelleASMR = $ligne['libelle'];
            }
			$requeteMedHASSMR="SELECT motifEval, dateAvis, valeurSmr, libelle FROM cis_bdpm JOIN cis_has_smr_bdpm ON codeCis = codeCis_HAS_SMR WHERE idGeneral = :idGeneral";
			$resultatsSMR=$pdo->prepare($requeteMedHASSMR);
            $resultatsSMR->bindParam('idGeneral', $idMedoc);
            $resultatsSMR->execute();
			while($ligne = $resultatsSMR->fetch()) {
                $motifEval = $ligne['motifEval'];
                $dateAvis = $ligne['dateAvis'];
				$valeurSmr = $ligne['valeurSmr'];
				$libelleSMR = $ligne['libelle'];
            }
			$requeteMedINFO="SELECT dateDebut, dateFin, texteLien FROM cis_bdpm JOIN cis_infoimportantes_bdpm ON codeCis = codeCis_INFO WHERE idGeneral = :idGeneral";
			$resultatsINFO=$pdo->prepare($requeteMedINFO);
            $resultatsINFO->bindParam('idGeneral', $idMedoc);
            $resultatsINFO->execute();
			while($ligne = $resultatsINFO->fetch()) {
                $dateDebut = $ligne['dateDebut'];
                $dateFin = $ligne['dateFin'];
				$texteLien = $ligne['texteLien'];
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
					<form action="accueilMedecin.php" method="post">
						<a href="accueilMedecin.php"><button type="button" class="btn btn-info btn-circle btn-xl" name="patient" value="true" title="Patients"><span class="fas fa-user"></button></a>				
						<a href="recherche.php"><button type="button" class="btn btn-info btn-circle btn-xl" name="recherche" value="true" title="Recherche"><span class="fas fa-search"></button></a>
						<button type="submit" class="btn btn-danger btn-circle btn-xxl" name="deconnexion" value="true" title="Déconnexion"><span class="fas fa-power-off"></button>
					</form>
				</div>	
			</div>
            <div class="row paddingForm">
				<div class="row formPatient">
					<div class="col-md-7 col-sm-12 col-xs-12 titreMedoc">
						<?php echo $denomination ?>
					</div>
					<div class="col-md-4 hidden-sm hidden-xs">
					</div>
					<div class="col-md-1 col-sm-12 col-xs-12 titreDossier">
						<form action="<?php 
						if(isset($_POST['OrdoToFiche'])) {
							echo 'creationVisite.php';
							$title = "création de visite";
						} else {
							echo 'recherche.php';
							$title = "recherche";
						}
						?>" method="post">
							<button type="submit" class="btn btn-danger btn-circle btn-xxl" name="retour" value="true" title="<?php 
							echo 'Retour à la page de '.$title;
							?>"><span class="fas fa-arrow-left"></span></button>
						</form>
					</div>
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12 paddingFiche">
					<div class="col-md-12 col-sm-12 col-xs-12 bordureD">
						<div class="col-md-12 col-sm-12 col-xs-12 paddingForm">
							<h3><u>Informations générales :</u></h3>
							<?php
							echo '<p>Forme : '.$forme.'</p>';
							echo '<p>Voie d\'administration : '.$voieAdmin.'</p>';
							echo '<p>Statut d\'administration : '.$statutAdmin.'</p>';
							echo '<p>Type de procédure : '.$typeProcedure.'</p>';
							echo '<p>État commercialisation : '.$etatCommerc.'</p>';
							echo '<p>Date d\'AMM : '.$dateAMM.'</p>';
							echo '<p>StatutBDM : '.$statutBdm.'</p>';
							echo '<p>Numéro de l\'autorisation UE : '.$numeroAutoUE.'</p>';
							echo '<p>Titulaire : '.$titulaire.'</p>';
							echo '<p>Surveillance renforcée : '.$surveillance.'</p>';
							?>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12 paddingFiche">
					<div class="col-md-12 col-sm-12 col-xs-12 bordureD">
						<div class="col-md-12 col-sm-12 col-xs-12 paddingForm">
							<h3><u>Présentation(boîte de médicaments) :</u></h3>
							<?php
							if(!isset($libelleCIP)) {
								$libelleCIP = "";
							}
							if(!isset($dateDecla)) {
								$dateDecla = "";
							}
							if(!isset($statutAdmin)) {
								$statutAdmin = "";
							}
							if(!isset($tauxRemboursement)) {
								$tauxRemboursement = "";
							}
							if(!isset($prix)) {
								$prix = "";
							}
							if(!isset($droitRemboursement)) {
								$droitRemboursement = "";
							}
							if($prix != "") {
								$symb = "€";
							} else {
								$symb = "";
							}
							echo '<p>Libellé : '.$libelleCIP.'</p>';
							echo '<p>Date déclaration : '.$dateDecla.'</p>';
							echo '<p>Agrément : '.$statutAdmin.'</p>';
							echo '<p>Taux de remboursement : '.$tauxRemboursement.'</p>';
							echo '<p>Prix : '.$prix.$symb.'</p>';
							echo '<p>Droit de remboursement : '.$droitRemboursement.'</p>';
							?>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12 paddingFiche">
					<div class="col-md-12 col-sm-12 col-xs-12 bordureD">
						<div class="col-md-12 col-sm-12 col-xs-12 paddingForm">
							<h3><u>Composition :</u></h3>
							<?php
							echo '<p>Dénomination substance : '.$denomSubstance.'</p>';
							echo '<p>Dosage : '.$dosage.'</p>';
							echo '<p>Référence dosage : pour '.$refDosage.'</p>';
							echo '<p>Nature composition : '.$natureCompo.' (SA : principe actif | FT : fraction thérapeutique)</p>';
							?>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12 paddingFiche">
					<div class="col-md-12 col-sm-12 col-xs-12 bordureD">
						<div class="col-md-12 col-sm-12 col-xs-12 paddingForm">
							<h3><u>Avis ASMR de la HAS :</u></h3>
							<?php
							if($resultatsASMR->rowCount() != 0) {
								echo '<p>Motif d\'évaluation : '.$motifEval.'</p>';
								echo '<p>Date de l\'avis : '.$dateAvis.'</p>';
								echo '<p>Valeur de l\'ASMR : '.$valeurAsmr.'</p>';
								echo '<p>Libellé de l\'ASMR : '.$libelleASMR.'</p>';
							} else {
								echo '<p>Pas de données</p>';
							}
							?>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12 paddingFiche">
					<div class="col-md-12 col-sm-12 col-xs-12 bordureD">
						<div class="col-md-12 col-sm-12 col-xs-12 paddingForm">
							<h3><u>Avis SMR de la HAS :</u></h3>
							<?php
							if($resultatsSMR->rowCount() != 0) {
								echo '<p>Motif d\'évaluation : '.$motifEval.'</p>';
								echo '<p>Date de l\'avis : '.$dateAvis.'</p>';
								echo '<p>Valeur de l\'ASMR : '.$valeurSmr.'</p>';
								echo '<p>Libellé de l\'ASMR : '.$libelleSMR.'</p>';
							} else {
								echo '<p>Pas de données</p>';
							}
							?>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12 paddingFiche">
					<div class="col-md-12 col-sm-12 col-xs-12 bordureD">
						<div class="col-md-12 col-sm-12 col-xs-12 paddingForm">
							<h3><u>Informations importantes :</u></h3>
							<?php
							if($resultatsINFO->rowCount() != 0) {
								echo '<p>Date de début de l\'information : '.$dateDebut.'</p>';
								echo '<p>Date de fin de l\'information : '.$dateFin.'</p>';
								echo '<p>Lien vers l\'information : '.$texteLien.'</p>';
							} else {
								echo '<p>Pas de données</p>';
							}
							?>
						</div>
					</div>
				</div>
            </div>
            
    </body>
</html>