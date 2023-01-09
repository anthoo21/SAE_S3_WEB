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
		spl_autoload_extensions(".php");
		spl_autoload_register();

		use yasmf\HttpHelper;
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
		<?php
			if ($check) {
		?>	
		<!--Message-->
		<div class="col-md-12 col-sm-12 col-xs-12 titreOK">
			<h2>Enregistrement du nouveau medecin validé !</h2>
		</div>
		<?php					
			} else (!$check) {
		?>
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
								<input hidden name="controller" value="AjoutMedecin">
								<input hidden name="action" value="addMedecin">
								<input type="submit" name="valider" value="VALIDER" class="buttonValid form-control">
							</div>
						</div>
					</div>
				</form>
			</div>
		<?php
			}
		?>
				</div>
			</div>
		</div>
  </body>
</html>
