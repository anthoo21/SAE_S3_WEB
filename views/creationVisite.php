<!DOCTYPE html>
<html lang="Fr">
  <head>
      <title>MEDSOFT - Création de visite</title>
      <meta charset="utf-8">
	  <link rel="stylesheet" href="bootstrap\css\bootstrap.css">
	  <link rel="stylesheet" href="fontawesome-free-5.10.2-web\css\all.css">
	  <link rel="stylesheet" href="css\style.css"> 
      <link rel="stylesheet" href="css\styleVisite.css"> 
  </head>
  
  <body>
	<?php
		//Récupération des données
		
		$idMedecin = $_SESSION['idMed'];
		// Toutes les données sont correctes
		if(isset($ToutOK) && $ToutOK) {
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
						<form action="accueilMedecin.php" method="post">
							<button type="button" class="btn btn-info btn-circle btn-xl" name="patient" value="true"><span class="fas fa-user"></button>				
							<button type="button" class="btn btn-info btn-circle btn-xl" name="recherche" value="true"><span class="fas fa-search"></button>
							<button type="submit" class="btn btn-danger btn-circle btn-xxl" name="deconnexion" value="true"><span class="fas fa-power-off"></button>
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
				<div class="row paddingForm">
					<div class="row formPatient">
						<!--Message-->
						<div class="col-md-12 col-sm-12 col-xs-12 titreOK">
							<h2>Enregistrement de la visite validé !</h2>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
						</div>
						<!--Retour accueil-->
						<div class="col-md-12 col-sm-12 col-xs-12">
							<form action="index.php" method="post">
								<input hidden name="controller" value="Medecins">
								<input hidden name="idMed" value="<?php echo $idMed ?>">
								<button type="submit"><span class="fas fa-home"></span></button> -- Retour à la liste des patients --
							</form>
						</div>
					</div>
				</div>
			</div>
		<?php					
		} else {
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
					<div class="col-md-1 col-sm-1 col-xs-1">
                        <form action="index.php" method="post">
                            <input hidden name="controller" value="Medecins">
                            <input hidden name="action" value="index">
                            <button type="submit" class="btn btn-info btn-circle btn-xl" name="patient" value="true" title="Patients"><span class="fas fa-user"></button>				
                        </form>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-1">
                        <form action="index.php" method="post">
                            <input hidden name="controller" value="Recherche">				
                            <button type="submit" class="btn btn-info btn-circle btn-xl" name="recherche" value="true" title="Recherche"><span class="fas fa-search"></button>
                        </form>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-1">
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
						<?
							echo "Docteur ".$_SESSION['nom'].' '.$_SESSION['prenom'];
						?>
					</div>	
				</div>
				<div class="row paddingForm">
					<div class="row formPatient">
						<!--Titre "Création d'un patient"-->
						<div class="col-md-12 col-sm-12 col-xs-12 titre titreCreation">
							Création d'une visite
						</div>
						<div class="row paddingForm">
							<!--Formulaire-->
							<form action="index.php" method="post">
								<div class="col-md-12 col-sm-12 col-xs-12 formPatient">
								
									<!--Partie Gauche-->
									<div class="col-md-6 col-sm-12 col-xs-12 formGD">
										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<h3 class="entete">Informations générales</h3>
											</div>
										</div>
										<!--Saisie de la date-->
										<div class="row">
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if($dateVisite=="") { echo "enRouge";}?>">
												<label for="dateVisite">Date : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="date" name="dateVisite" class="form-control" value="<?php echo $dateVisite; ?>">
											</div>
										</div>
                                        <?php 
                                        //Récupération des infos du patient
                                        while($ligne = $requeteInfoPatient->fetch()) {
                                        ?>
										<div class="row">
											<!-- Patient -->
											<div class="col-md-12 col-sm-12 col-xs-12">
												<label for="patient">Patient :  </label><?php echo ' '.$ligne['nom'].' '.$ligne['prenom'];?>
											</div>
					
										</div>
										<div class="row">
											<!--Saisie du motif de la visite-->
											<div class="col-md-6 col-sm-6 col-xs-12  <?php if($motif=="") { echo "enRouge";}?>">
												<label for="motif">Motif de la visite : </label>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="motif" class="form-control" placeholder="" value="<?php echo $motif;?>">
											</div>
										</div>
										<div class="row">
											<!--Saisie de commentaires-->
											<div class="col-md-12 col-sm-7 col-xs-12  <?php if($observation=="") { echo "enRouge";}?>">
												<label for="observation">Observations : </label>
											</div>
											<div class="col-md-12 col-sm-6 col-xs-12">
												<textarea name="observation" rows="7" cols="45"><?php echo $observation;?></textarea>
											</div>
										</div>
										<div class="row">
											<!--Saisie du téléphone-->
											<div class="col-md-12 col-sm-12 col-xs-12">
												<label for="medecin">Médecin traitant : </label><?php echo ' '.$_SESSION['nom'].' '.$_SESSION['prenom'];?>
											</div>
										</div>
										<div class="row">
											<!--Saisie de la date de naissance-->
											<div class="col-md-6 col-sm-6 col-xs-12">
												<label for="date">Date de naissance : </label><?php echo ' '.date("d/m/Y", strtotime($ligne['dateNai'])); ?>
											</div>
										</div>
										<div class="row">
											<!--Saisie du poids-->
											<div class="col-md-6 col-sm-6 col-xs-12">
												<label for="poids">Poids: </label><?php echo ' '.$ligne['poids'].' kg'; ?>
											</div>
										</div>
                                        <?php }?>
									</div>
									<!--Partie Droite-->
									<div class="col-md-6 col-sm-12 col-xs-12 formGD">
										<div class="row paddingForm">
											<div class="row formPatient">
												<div class="row paddingForm">
													<div class="row">
														<div class="col-md-12 col-sm-12 col-xs-12">
															<h3 class="entete">Prescriptions</h3>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12 col-sm-12 col-xs-12">
															<table>
																<tr>
																	<th>Désignation</th>
																	<th>Posologie</th>
                                                                    <th>Supprimer</th>
																</tr>
																<?php 
																while($ligne = $requeteOrdo->fetch()) {
                                                                    echo '<form action="index.php" method="post">';
                                                                        echo '<tr>';
                                                                            echo '<input type="hidden" name="recupId" value="'.$ligne['id_medicaments'].'">';
                                                                            echo '<td>'.$ligne['denomination'].'</td>';
                                                                            echo '<td>'.$ligne['posologie'].'</td>';
                                                                            echo '<input hidden name="controller" value="Visite">';
                                                                            echo '<input hidden name="action" value="supprMedoc">';
                                                                            echo '<input hidden name="idP" value="'.$idP.'">';
                                                                            echo '<td><button type="submit" class="btn btn-danger btn-circle" name="suppression" value="true" title="Supprimer un médicament"><span class="fas fa-trash"></button></td>';
                                                                        echo '</tr>';
                                                                    echo '</form>';
																}
																?>
															</table>
														</div>
													</div>
												</div>
											</div>
											
											<div class="row">
												<!--Médecin traitant-->
												<div class="col-md-12 col-sm-12 col-xs-12">
													<div class="row divBouton">
														<a href="#openModal"><button type="button" class="btn btn-info btn-circle btn-xl" name="rechercher" value="true" title="Rechercher un médicament"><span class="fas fa-search"></span></button>Rechercher un médicament</a>
													</div>
												</div>
											</div>
											<div id="openModal" class="modalDialog">
   												<div><a href="#close" title="Close" class="close">X</a>
                                                   <div class="container">
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
                                                                        <form class="rechercheCriteres" method="post" action="index.php">
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
                                                                                    while($ligne = $searchStmt2->fetch()) {
                                                                                        echo '<option';
                                                                                        if(isset($_POST['Type']) && $_POST['Type'] == $ligne['forme']) {
                                                                                            echo " selected";
                                                                                        } 
                                                                                        echo '>'.$ligne['forme'].'</option>';
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>		
                                                                            <!--Recherche par médicaments génériques -->
                                                                            <div class="col-md-6 col-sm-6 col-xs-12 inputCritere">
                                                                                <p class="text"><b>Génériques ?</b></p>

                                                                                <input type="radio" name="generiques" id="generiqueOui" value="Oui" 
                                                                                <?php if(isset($_POST['generiques']) && $_POST['generiques'] == "Oui") {
                                                                                        echo "checked";
                                                                                    }?>>
                                                                                <label for="generiqueOui">Oui</label>
                                                                                <input type="radio" name="generiques" id="generiqueNon" value="Non" 
                                                                                <?php if(isset($_POST['generiques']) && $_POST['generiques'] == "Non") {
                                                                                        echo "checked";
                                                                                    }?>>
                                                                                <label for="generiqueNon">Non</label>
                                                                                <input type="radio" name="generiques" id="generiqueNon" value="Both"
                                                                                <?php if(!isset($_POST['generiques']) || $_POST['generiques'] == "Both") {
                                                                                        echo "checked";
                                                                                    }?>>
                                                                                <label for="generiqueNon">Les deux</label> 
                                                                            </div>
                                                                            
                                                                            <!--Bouton rechercher -->
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divBtn">
                                                                                <input hidden name="controller" value="Visite">
                                                                                <input hidden name="action" value="rechercheCritere">
																				<input hidden name="idP" value="<?php echo $idP ?>">
                                                                                <button type="submit" name="rechercher" value="Rechercher" class="btn-secondary form-control" id="refresh-button"><span class="fas fa-search"> R E C H E R C H E R</button>
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
                                                                <?php if($searchStmt->rowCount() == 0) {
                                                                            echo '<div class="col-md-12 col-sm-12 col-xs-12 titre">';
                                                                                echo 'Aucun médicament trouvé.';
                                                                            echo '</div>';
                                                                    } else {?>
                                                                <table class="table table-bordered table-striped specialTable">
                                                                    <div class="col-md-12">
                                                                        <tr>
                                                                            <th>Désignation</th>
                                                                            <th>Types</th>
                                                                            <th>Laboratoire</th>
                                                                            <th>Génériques</th>
                                                                            <th><span class="fas fa-eye"></th>
                                                                            <th><span class="fa-solid fa-cart-plus"></th>
                                                                        </tr>
                                                                        <?php 
                                                                            while($ligne = $searchStmt->fetch()) {
                                                                                if($ligne['libelle'] != "") {
                                                                                    $gener = 'Oui';
                                                                                } else {
                                                                                    $gener = 'Non';
                                                                                }
                                                                                echo '<tr>';
                                                                                    echo '<td>'.$ligne['denomination'].'</td>';
                                                                                    echo '<td>'.$ligne['forme'].'</td>';
                                                                                    echo '<td>'.$ligne['titulaire'].'</td>';
                                                                                    echo '<td>'.$gener.'</td>';          
                                                                                    echo '<form action="index.php" method="post">';
                                                                                        echo '<input type="hidden" name="idMedoc" value="'.$ligne['idGeneral'].'">';
                                                                                        echo '<input type="hidden" name="OrdoToFiche" value="1">';
                                                                                        echo '<input hidden name="controller" value="FicheMedoc">';
																						echo '<input type="hidden" name="idP" value="'.$idP.'">';
																						echo '<input type="hidden" name="dateVisite" value="'.$dateVisite.'">';
																						echo '<input type="hidden" name="motif" value="'.$motif.'">';
																						echo '<input type="hidden" name="observation" value="'.$observation.'">';
                                                                                        echo '<td><button type="submit" class="btn btn-secondary" title="Voir la fiche médicament" name="voir"><span class="fas fa-eye"></button>';
                                                                                    echo '</form>';
                                                                                    echo '<form action="index.php" method="post">';
                                                                                        echo '<input hidden name="idMedoc" value="'.$ligne['codeCis'].'">';
                                                                                        echo '<input hidden name="controller" value="Posologie">';
                                                                                        echo '<input hidden name="idP" value="'.$idP.'">';
                                                                                        echo '<td><button type="submit" class="btn btn-secondary" title="Ajouter un médicament" name="ajouter"><span class="fa-solid fa-cart-plus"></button>';
                                                                                    echo '</form>';
                                                                                echo '</tr>';
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                </table>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 titre">
                                                                Nombre de médicaments : <?php echo $searchStmt->rowCount(); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>	
												</div>
											</div>		
									<!--Bouton Valider-->
									<div class="col-md-12 col-sm-12 col-xs-12 divBouton buttonVert">
										<div class="row divBouton">
											<input type="hidden" name="valideInsertion">
                                            <input hidden name="controller" value="Visite">
                                            <input hidden name="action" value="insertVisite">
                                            <input hidden name="idP" value="<?php echo $idP ?>">
											<input hidden name="idMedecin" value="<?php echo $idMedecin ?>">
											<input type="submit" name="valider" value="VALIDER" class="buttonValid form-control">
										</div>
									</div>
									
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		<?php
			}
		?>
  </body>
</html>