<!DOCTYPE html>
<html lang="Fr">
  <head>
      <title>MEDSOFT - Accueil Medecin</title>
      <meta charset="utf-8">
	  <link rel="stylesheet" href="bootstrap\css\bootstrap.css">
	  <link rel="stylesheet" href="fontawesome-free-5.10.2-web\css\all.css">
	  <link rel="stylesheet" href="css\style.css"> 
  </head>
  
  <body>
  
	<?php
		spl_autoload_extensions(".php");
		spl_autoload_register();

		use yasmf\HttpHelper;
	?>
	<div class="container">
		<!-- Nav-bar -->
		<div class="row nav">
			<div class="col-md-4 col-sm-4 col-xs-4">
				<img class="logo1" src="assets\logo_dessin.png" alt="logo plus">
                <img class="logo2" src="assets\logo_titre.png" alt="logo medsoft">
			</div>	
			<div class="col-md-4 col-sm-4 col-xs-4">
			<!--Espace dans la navbar-->
			</div>
			<!-- Boutons -->
			<div class="col-md-4 col-sm-4 col-xs-4 logos">
				<form action="index.php" method="post">
                        <input hidden name="controller" value="Medecins">
                        <input hidden name="action" value="index">
						<button type="submit" class="btn btn-info btn-circle btn-xl" name="patient" value="true" title="Patients"><span class="fas fa-user"></button>				
				</form>
				<form action="index.php" method="post">
                        <input hidden name="controller" value="Medecins">
                        <input hidden name="action" value="deconnexion">
                        <button type="submit" class="btn btn-danger btn-circle btn-xxl" name="deconnexion" value="true" title="Déconnexion"><span class="fas fa-power-off"></button>
				</form>
			</div>	
		</div>
		<!--Nom du docteur-->
		<div class="row">
			</br>
			<div class="col-md-12 col-sm-12 col-xs-12 doctorName">
				<?php echo "Docteur ".$_SESSION['nom'].' '.$_SESSION['prenom']; ?>
			</div>	
		</div>

			<!--Suppression confirmer-->
			<?php if($erased == true) {?>
				<div class="row paddingForm">
					<!--Message-->
					<div class="col-md-12 col-sm-12 col-xs-12 titreOK">
						<div class="col-md-12 col-sm-12 col-xs-12 center">
							<span class="fas fa-check"></span>
							<h3>Le patient <?php echo $nom.' '.$prenom;?> a été supprimé de la base de données</h3>
						</div>
					</div>
				</div>
			<!-- Avertissement de suppression -->
			<?php } else {?>
				<div class="row paddingForm">
					<!--Message-->
					<div class="col-md-12 col-sm-12 col-xs-12 titreOK">
						<div class="col-md-12 col-sm-12 col-xs-12 center">
							<span class="fas fa-triangle-exclamation"></span>
							<h3>Lorsque vous supprimez un patient, les visites et ordonnances </br>qui lui sont associées seront également supprimé.</h3>
							<h3>Voulez-vous supprimer le patient <?php echo $nom.' '.$prenom;?> ?</h3>
						</div>
						<!--Bouton Supprimer-->
						<div class="col-md-6 col-sm-6 col-xs-6 center">
							<form action="index.php" method="post">
								<input hidden name="controller" value="SuppressionPatient">
								<input hidden name="action" value="suppressionPatient">
								<input hidden name="noCV" value="<?php echo $noCV ?>">
								<input hidden name="nom" value="<?php echo $nom ?>">
								<input hidden name="prenom" value="<?php echo $prenom;?>">
								<input type="submit" name="Supprimer" class="btn btn-success btn-xl" value="SUPPRIMER">
							</form>
						</div>
						<!--Bouton Annuler-->
						<div class="col-md-6 col-sm-6 col-xs-6 center">
							<form action="index.php" method="post">
								<input type="hidden" name="id" value="<?php echo $noCV;?>">
								<input type="submit" name="Annuler" class="btn btn-secondary btn-xl" value="ANNULER">
							</form>
						</div>
					</div>
				</div>
			<?php }?>
			</div>
		</div>
  	</body>
</html>
