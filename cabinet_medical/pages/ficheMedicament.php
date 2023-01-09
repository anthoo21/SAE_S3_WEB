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
                $libelle = $ligne['libelle'];
                $dateDecla = $ligne['dateDecla'];
				$agrement = $ligne['agrement'];
				$tauxRemboursement = $ligne['tauxRemboursement'];
				$prix = $ligne['prix'];
				$droitRemboursement = $ligne['droitRemboursement'];
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
					<div class="col-md-2 hidden-sm hidden-xs">
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
							if($prix != "") {
								$symb = "€";
							} else {
								$symb = "";
							}
							echo '<p>Libellée : '.$libelle.'</p>';
							echo '<p>Date déclaration : '.$dateDecla.'</p>';
							echo '<p>Agrément : '.$statutAdmin.'</p>';
							echo '<p>Taux de remboursement : '.$tauxRemboursement.'</p>';
							echo '<p>Prix : '.$prix.$symb.'</p>';
							echo '<p>Droit de remboursement : '.$droitRemboursement.'</p>';
							?>
						</div>
					</div>
				</div>
            </div>
            
    </body>
</html>