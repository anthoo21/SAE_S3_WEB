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
			spl_autoload_extensions(".php");
			spl_autoload_register();

			use yasmf\HttpHelper;

	?>
	<div class="container bleu">
		<!-- Nav-bar -->
		<div class="row nav">
			<div class="col-md-4 col-sm-4 col-xs-4">
				<img class="logo1" src="assets\logo_dessin.png" alt="logo plus">
				<img class="logo2" src="assets\logo_titre.png" alt="logo medsoft">
			</div>	
			<div class="col-md-4 col-sm-4 col-xs-4">
			<!--Espace dans la navbar-->
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4 logos">
				<form action="index.php" method="post">
					<input hidden name="controller" value="Admins">
					<input hidden name="action" value="deconnexion">
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
					<h4><u><b>Informations du cabinet</b></u></h4>
					<?php 
					while($ligne=$requeteCabinet->fetch()) {
						echo '<p>Nom : '.$ligne['nom_cabinet'].'</p>';
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
								//Affiche tous les médecins du cabinet
								while($ligne = $selectAllMedecins->fetch()) {
									echo '<tr class="ligneMed">';
										echo '<form action="index.php" method="post">';
										echo '<input hidden name="controller" value="Admins">';
										echo '<input hidden name="action" value="goDossMedecin">';
										echo '<input type="hidden" name="idMed" value="'.$ligne['id_med'].'">';
										echo '<td>'.$ligne['nom'].'</td>';
										echo '<td>'.$ligne['prenom'].'</td>';
										echo '<td>'.$ligne['email'].'</td>';
										echo '<td>'.$ligne['id_util'].'</td>';
										echo '<td>'.$ligne['motDePasse'].'</td>';
										echo '<td><button type="submit" class="btn btn-secondary" title="Voir le dossier"><span class="fas fa-eye"></button>';
										echo '</form>';
									echo '</tr>';
								}
								?>
							
						</table>
					<!--Bouton "Ajouter un médecin" -->
					<form action="index.php" method="post">
						<input hidden name="controller" value="AjoutMedecin">
						<input hidden name="action" value="index">
						<div class="row divBtnA left">
							<button type="submit" class="btn btn-secondary" title="Ajouter un médecin"><img class="logo7" src="assets\ajouterM.png" alt="logo ajouter"></button>
						</div>
					</form>
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
			<div class="row">
				<form method="post" action="index.php" enctype="multipart/form-data">
					<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
					<div class="row">
						<?php if (!file_exists("fichierImport\CIS_bdpm.txt")) {?>
							<div class="col-md-6 col-xs-6 col-sm-6">
								<input type="file" name="cis1" accept=".txt">
							</div>
						<?php } ?>
						<div class="col-md-6 col-xs-6 col-sm-6">
							<label class="<?php
							if(!file_exists("fichierImport\CIS_bdpm.txt")) {
								echo 'enRouge';								
							} else {
								echo 'enVert';								
							}
							?>">Fichier CIS_bdpm</label>
						</div>
					</div>
					<div class="row">
						<?php if (!file_exists("fichierImport\CIS_CIP_bdpm.txt")) {?>
							<div class="col-md-6 col-xs-6 col-sm-6">
								<input type="file" name="cis2" accept=".txt">
							</div>
						<?php } ?>
						<div class="col-md-6 col-xs-6 col-sm-6">
							<label class="<?php
							if(!file_exists("fichierImport\CIS_CIP_bdpm.txt")) {
								echo 'enRouge';								
							} else {
								echo 'enVert';								
							}
							?>">Fichier CIS_CIP_bdpm</label>
						</div>
					</div>
					<div class="row">
						<?php if (!file_exists("fichierImport\CIS_COMPO_bdpm.txt")) {?>
							<div class="col-md-6 col-xs-6 col-sm-6">
								<input type="file" name="cis3" accept=".txt">
							</div>
						<?php } ?>
						<div class="col-md-6 col-xs-6 col-sm-6">
							<label class="<?php
							if(!file_exists("fichierImport\CIS_COMPO_bdpm.txt")) {
								echo 'enRouge';								
							} else {
								echo 'enVert';								
							}
							?>">Fichier CIS_COMPO_bdpm</label>
						</div>
					</div>
					<div class="row">
						<?php if (!file_exists("fichierImport\CIS_CPD_bdpm.txt")) {?>
							<div class="col-md-6 col-xs-6 col-sm-6">
								<input type="file" name="cis4" accept=".txt">
							</div>
						<?php } ?>
						<div class="col-md-6 col-xs-6 col-sm-6">
							<label class="<?php
							if(!file_exists("fichierImport\CIS_CPD_bdpm.txt")) {
								echo 'enRouge';								
							} else {
								echo 'enVert';								
							}
							?>">Fichier CIS_CPD_bdpm</label>
						</div>
					</div>	
					<div class="row">
						<?php if (!file_exists("fichierImport\CIS_GENER_bdpm.txt")) {?>
							<div class="col-md-6 col-xs-6 col-sm-6">
								<input type="file" name="cis5" accept=".txt">
							</div>
						<?php } ?>
						<div class="col-md-6 col-xs-6 col-sm-6">
							<label class="<?php
							if(!file_exists("fichierImport\CIS_GENER_bdpm.txt")) {
								echo 'enRouge';								
							} else {
								echo 'enVert';								
							}
							?>">Fichier CIS_GENER_bdpm</label>
						</div>
					</div>
					<div class="row">
						<?php if (!file_exists("fichierImport\CIS_HAS_ASMR_bdpm.txt")) {?>
							<div class="col-md-6 col-xs-6 col-sm-6">
								<input type="file" name="cis6" accept=".txt">
							</div>
						<?php } ?>
						<div class="col-md-6 col-xs-6 col-sm-6">
							<label class="<?php
							if(!file_exists("fichierImport\CIS_HAS_ASMR_bdpm.txt")) {
								echo 'enRouge';								
							} else {
								echo 'enVert';								
							}
							?>">Fichier CIS_HAS_ASMR_bdpm</label>
						</div>
					</div>
					<div class="row">
						<?php if (!file_exists("fichierImport\CIS_HAS_SMR_bdpm.txt")) {?>
							<div class="col-md-6 col-xs-6 col-sm-6">
								<input type="file" name="cis7" accept=".txt">
							</div>
						<?php } ?>
						<div class="col-md-3 col-xs-3 col-sm-3">
							<label class="<?php
							if(!file_exists("fichierImport\CIS_HAS_SMR_bdpm.txt")) {
								echo 'enRouge';								
							} else {
								echo 'enVert';								
							}
							?>">Fichier CIS_HAS_SMR_bdpm</label>
						</div>
					</div>
					<div class="row">
						<?php if (!file_exists("fichierImport\CIS_InfoImportantes_bdpm.txt")) {?>
							<div class="col-md-6 col-xs-6 col-sm-6">
								<input type="file" name="cis8" accept=".txt">
							</div>
						<?php } ?>
						<div class="col-md-6 col-xs-6 col-sm-6">
							<label class="<?php
							if(!file_exists("fichierImport\CIS_InfoImportantes_bdpm.txt")) {
								echo 'enRouge';								
							} else {
								echo 'enVert';								
							}
							?>">Fichier CIS_InfoImportantes_bdpm</label>
						</div>
					</div>
					<div class="row">
						<?php if (!file_exists("fichierImport\HAS_LiensPageCT_bdpm.txt")) {?>
							<div class="col-md-6 col-xs-6 col-sm-6">
								<input type="file" name="cis9" accept=".txt">
							</div>
						<?php } ?>
						<div class="col-md-6 col-xs-6 col-sm-6">
							<label class="<?php
							if(!file_exists("fichierImport\HAS_LiensPageCT_bdpm.txt")) {
								echo 'enRouge';
							} else {
								echo 'enVert';
							}
							?>">Fichier HAS_LiensPageCT_bdpm</label>
						</div>
					</div>
					<div class="col-md-6 col-xs-6 col-sm-6">
						<input hidden name="controller" value="Admins">
						<input hidden name="action" value="areAllFichOK">
						<input type="submit" value="Upload" name="btnImport" class="btnImport">
					</div>
					</form>	
					<?php
					//si tous les fichiers ont été upload, alors le bouton "Importer" apparaît
						if($allVerifOk) {
					?>
						<form action="index.php" method="post">
							<div class="col-md-6 col-xs-6 col-sm-6">
								<input hidden name="controller" value="InsertFichier">
								<input hidden name="action" value="insertFich">
								<input hidden value="ValidationImport" name="ValidationImport">
								<input type="submit" value="Importer" name="btnImport2" class="btnImport">
							</div>
						</form>
					<?php
						}
					?>
			</div>
		</div> 
	</div>
  </body>
</html>

