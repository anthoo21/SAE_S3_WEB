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
		$host = '127.0.0.1';
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
		$requeteT="SELECT DISTINCT(forme) FROM cis_bdpm ORDER BY forme ASC";	
		$resultatsT=$pdo->query($requeteT); 
		$requeteD="SELECT DISTINCT(denomSubstance) FROM cis_compo_bdpm ORDER BY denomSubstance ASC";	
		$resultatsD=$pdo->query($requeteD);  
		$requeteNatCompo="SELECT DISTINCT(natureCompo) FROM cis_compo_bdpm";
		$resultatsNatCompo=$pdo->query($requeteNatCompo);  
		$requete = "";
            if(isset($_POST['designation']) && isset($_POST['Type']) && isset($_POST['substance'])) {
                if($_POST['designation'] != "") {
                    $medicament = "%".$_POST['designation']."%";
                    $un = "WHERE denomination like :medicamentDes";
                    $requete = $requete.$un;
                    if($_POST['Type'] != 'TOUS') {
                        $deux = ' AND forme = "'.$_POST["Type"].'"';
                        $requete = $requete.$deux;
                    }
                    if($_POST['substance'] != 'TOUS') {
                        $trois = ' AND denomSubstance = "'.$_POST["substance"].'"';
                        $requete = $requete.$trois;
                    }
					// if($_POST['principes'] != 'TOUS') {
					// 	$quatre = ' AND natureCompo = "'.$_POST["principes"].'"';
					// 	$requete = $requete.$quatre;
					// }
                } else if ($_POST['Type'] != 'TOUS') {
                    $deux = 'WHERE forme = "'.$_POST["Type"].'"';
                    $requete = $requete.$deux;
                    if($_POST['substance'] != 'TOUS') {
                        $trois = ' AND denomSubstance = "'.$_POST["substance"].'"';
                        $requete = $requete.$trois;
                    }
					// if($_POST['principes'] != 'TOUS') {
					// 	$quatre = ' AND natureCompo = "'.$_POST["principes"].'"';
					// 	$requete = $requete.$quatre;
					// }
                } else if ($_POST['substance'] != 'TOUS') {
                    $trois = 'WHERE denomSubstance = "'.$_POST["substance"].'"';
                    $requete = $requete.$trois;
				}
                    $resultatsAllMedic = $pdo->prepare("SELECT idGeneral, denomination, forme, titulaire, libelle FROM cis_bdpm LEFT JOIN cis_gener_bdpm ON codeCis = codeCis_GENER ".$requete." ORDER BY denomination ASC");
                    $resultatsAllMedic->bindParam("medicamentDes", $medicament);
                    $resultatsAllMedic->execute();
                } else {
					$requeteAllMedic="SELECT idGeneral, denomination, forme, titulaire, libelle FROM cis_bdpm LEFT JOIN cis_gener_bdpm ON codeCis = codeCis_GENER ORDER BY denomination ASC";
					$resultatsAllMedic=$pdo->query($requeteAllMedic); 
            	}

		//Récupération des données
		$ToutOK=true; //Savoir si toutes les données ont été rentrées
		
		
		// Toutes les données sont correctes
		if($ToutOK) {
			try {
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
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
						<a href="accueilMedecin.php"><button type="button" class="btn btn-info btn-circle btn-xl" name="patient" value="true" title="Patients"><span class="fas fa-user"></button></a>				
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
				<div class="row">
					<!--Titre "Recherche de médicaments"-->
					<div class="col-md-12 col-sm-12 col-xs-12 titre titreCreation">
						Recherche de médicaments
					</div>
					<div class="row paddingForm">
						<!--Recherche par critères-->
						<div class="row espaceB">
							<div class="row rechCri">
								<form class="rechercheCriteres" method="post" action="recherche.php">
									<!--Recherche par désignation -->
									<div class="col-md-6 col-sm-6 col-xs-12 inputCritere">
										<p class="text"><b>Désignation :</b></p>
										<input type="texte" name="designation" class="form-control" placeholder="Tapez un mot à chercher" value="<?php 
										if(isset($_POST['designation'])) {
											echo $_POST['designation'];
										} else {
											echo '';
										}
										?>">
									</div>
									
									<!--Recherche par types -->
									<div class="col-md-6 col-sm-6 col-xs-12 inputCritere">
										<p class="text"><b>Types :</b></p>
										<!-- Liste type médicament -->
										<select class="form-control" name="Type" id="type">
											<option value="TOUS">TOUS</option>
											<?php
											while($ligne = $resultatsT->fetch()) {
												echo '<option';
												if(isset($_POST['Type']) && $_POST['Type'] == $ligne['forme']) {
													echo " selected";
												} 
												echo '>'.$ligne['forme'].'</option>';
											}
											?>
										</select>
									</div>
									
									<!--Recherche par substances -->
									<div class="col-md-6 col-sm-6 col-xs-12 inputCritere">
										<p class="text"><b>Substances :</b></p>
										<!-- Liste es substances -->
										<select class="form-control" name="substance" id="sub">
											<option value="TOUS">TOUTES</option>
											<?php
											while($ligne = $resultatsD->fetch()) {
												echo '<option';
												if(isset($_POST['substance']) && $_POST['substance'] == $ligne['denomSubstance']) {
													echo " selected";
												} 
												echo '>'.$ligne['denomSubstance'].'</option>';
											}
											?>
										</select>
									</div>
									
									<!--Recherche par principes actifs -->
									<div class="col-md-6 col-sm-6 col-xs-12 inputCritere">
										<p class="text"><b>Principes actifs :</b></p>
										<!-- Liste des principes actifs -->
										<select class="form-control" name="principes" id="pa">
											<option value="TOUS">TOUS</option>
											<option value="SA" name="SA" <?php if(isset($_POST['SA'])) echo 'selected';?>>SA</option>
											<option value="FT" name="FT" <?php if(isset($_POST['FT'])) echo 'selected';?>>FT</option>
										</select>
									</div>
									
									<!--Recherche par médicaments génériques -->
									<div class="col-md-12 col-sm-12 col-xs-12 inputCritere">
										<p class="text"><b>Génériques ?</b></p>

										<input type="radio" name="generiques" id="generiqueOui" value="Oui">
										<label for="generiqueOui">Oui</label>
										<input type="radio" name="generiques" id="generiqueNon" value="Non">
										<label for="generiqueNon">Non</label>
									</div>
									
									<!--Bouton rechercher -->
									<div class="col-md-12 col-sm-12 col-xs-12 divBtn">
										<button type="submit" name="rechercher" value="Rechercher" class="btn-secondary form-control"><span class="fas fa-search"> R E C H E R C H E R</button>
									</div>	
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 titre">
						Résultat de la recherche
					</div>
					<div class="row paddingForm">
						<table class="table table-bordered table-striped specialTable">
							<div class="col-md-12">
								<tr>
									<th>Désignation</th>
									<th>Types</th>
									<th>Laboratoire</th>
									<th>Génériques</th>
									<th><span class="fas fa-eye"></th>
								</tr>
								<?php 
									while($ligne = $resultatsAllMedic->fetch()) {
										echo '<form action="ficheMedicament.php" method="post">';
											echo '<tr>';
												echo '<input type="hidden" name="idMedoc" value="'.$ligne['idGeneral'].'">'; // Problème affichage recherche par critères
												echo '<td>'.$ligne['denomination'].'</td>';
												echo '<td>'.$ligne['forme'].'</td>';
												echo '<td>'.$ligne['titulaire'].'</td>';
												if($ligne['libelle'] != "") {
													$gener = 'Oui';
												} else {
													$gener = 'Non';
												}
												echo '<td>'.$gener.'</td>';
												echo '<td><button type="submit" class="btn btn-secondary" title="Voir la fiche médicament" onclick="myFunction()"><span class="fas fa-eye"></button>';
											echo '</tr>';
										echo '</form>';
									}
								?>
							</div>
						</table>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 titre">
						Nombre de médicaments : <?php echo $resultatsAllMedic->rowCount(); ?>
					</div>
				</div>
			</div>
		</div>
		<script>
			function myFunction() {
			window.open("http://localhost:81/SAE_S3_WEB/cabinet_medical/pages/ficheMedicament.php", "", "width=80%, height=80%");
			}
</script>
  </body>
</html>
