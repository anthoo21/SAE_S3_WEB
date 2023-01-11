<!DOCTYPE html>
<html lang="Fr">
  <head>
      <title>MEDSOFT - Accueil</title>
      <meta charset="utf-8">
	  <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
	  <link rel="stylesheet" href="fontawesome-free-5.10.2-web/css/all.css">
	  <link rel="stylesheet" href="css/style.css"> 
  </head>
  
  <body class="body">
  <?php

	spl_autoload_extensions(".php");
	spl_autoload_register();

	use yasmf\HttpHelper;

  ?>
	<div class="container 1">
		<!-- Nav-bar -->
		<div class="row nav">
			<div class="col-md-6 col-sm-12 col-xs-12">
				<img class="logo1" src="assets/logo_dessin.png" alt="nav bar">
				<img class="logo2" src="assets/logo_titre.png" alt="nav bar">
			</div>	
		</div>
		<!--Image accueil-->
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="home">
					Bienvenue sur le site </br>de notre cabinet MedSoft
				</div>
			</div>	
		</div>
		<!--Authentification-->
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
					<form action="index.php" method="post">
						<p class="titre">Connexion à mon compte : </p>
						<div class="row">
							<!--Identifiant correct (non vide): apparaît en vert sinon en rouge-->
							<div class="col-md-5 col-sm-12 col-xs-12 <?php if(isset($identifiant) and $identifiant=="") { echo "enRouge";}?>">
								<label>Identifiant : </label>				
							</div>
							<div class="col-md-7 col-sm-12 col-xs-12">
								<input type="text" name="login" class="form-control saisie fond" value="<?php if(isset($identifiant) and $identifiant!="") { echo $identifiant;}?>">
							</div>
						</div>
						<div class="row">
						<!--Mot de passe correct (non vide) : apparaît en vert sinon en rouge-->
							<div class="col-md-5 col-sm-12 col-xs-12 <?php if(isset($mdp) and $mdp=="") { echo "enRouge";}?>">
								<label>Mot de passe : </label>
							</div>
							<div class="col-md-7 col-sm-12 col-xs-12">
								<input type="password" name="password" class="form-control saisie fond">
							</div>
						</div>
						<?php if($erreurLog == true) { ?>
							<div class="row">
								<p>Identifiant ou Mot de passe incorrect </p>
							</div>
						<?php } ?>
						<div class="row divBouton">
							<!--Identifiant et mot de passe dans la BDD : affichage page d'accueil-->
							<input hidden name="controller" value="login">
							<input hidden name="action" value="connexion">
							<input type="submit" name="connexion" value="Me connecter" class="buttonConnect">
						</div>
					</form>
			</div>	
		</div>
	</div>
  </body>
</html>
