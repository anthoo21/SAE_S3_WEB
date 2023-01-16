<!DOCTYPE html>
<html lang="Fr">
  <head>
      <title>MEDSOFT - Création de visite</title>
      <meta charset="utf-8">
	  <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
	  <link rel="stylesheet" href="../fontawesome-free-6.2.1-web/css/all.css">
	  <link rel="stylesheet" href="../css/style.css"> 
  </head>
  
  <body>
	<?php
                                
        if(isset($_POST['recupId'])) {
            $idMed = $_POST['recupId'];
            $requete="DELETE FROM prescriptionsTemp WHERE id_medicaments = :idMed";
            $stmt=$pdo->prepare($requete);
            $stmt->bindParam('idMed',$idMed);
            $stmt->execute();
        }
  
		$idP = $_SESSION['idPatient'];
		
		//Récupération des infos du patient
		try {
			$requeteOrdo='SELECT C.denomination, P.posologie, P.id_medicaments FROM cis_bdpm C JOIN prescriptionsTemp P ON C.codeCis = P.id_medicaments';
			$resultatsOrdo = $pdo->query($requeteOrdo);
			$requeteP="SELECT patients.nom, patients.prenom, patients.numeroCarteVitale, patients.dateNai, patients.poids
			FROM patients 
			WHERE patients.numeroCarteVitale = :id";
			$resultats = $pdo->prepare($requeteP);
			$resultats->bindParam('id', $idP);
			$resultats->execute();
			while($ligne = $resultats->fetch()) {
				$nomP = $ligne['nom'];
				$prenomP = $ligne['prenom'];
				$dateNai = date("d/m/Y", strtotime($ligne['dateNai']));
				$poids = $ligne['poids'];
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		//Récupération des données
		$ToutOK=true; //Savoir si toutes les données ont été rentrées
		
		//Récupération de la date de la visite
		if(isset($_POST['dateVisite']) and $_POST['dateVisite']!="")  {
			$dateVisite=htmlspecialchars($_POST['dateVisite']);
		} else {
			$dateVisite="";
			$ToutOK=false;
		}
		
		//Récupération du motif de la visite
		if(isset($_POST['motif']) and $_POST['motif']!="") {
			$motif=htmlspecialchars($_POST['motif']);
		} else {
			$motif="";
			$ToutOK=false;
		}
		
		//Récupération des commentaires
		if(isset($_POST['observation']) and $_POST['observation']!="") {
			$observation=htmlspecialchars($_POST['observation']);
		} else {
			$observation="";
			$ToutOK=false;
		}
		
		// Toutes les données sont correctes
		if($ToutOK && isset($_POST['valideInsertion'])) {
			try {
				$requete="INSERT INTO visites (date_visite, id_patient, id_medecin, motif, observations)
					VALUES (?, ?, ?, ?, ?);";
				$stmt = $pdo->prepare($requete);
				$stmt->execute([$dateVisite, $idP, $_SESSION['idMed'], $motif, $observation]);
				//--------------------------------------------------------------------------
				$requeteInsertVisite="INSERT INTO ordonnances (id_visite) VALUES (:idVisite)";
				$reqMaxVis="SELECT MAX(id_visite) FROM visites";
				$result=$pdo->query($reqMaxVis);
				$result = $result->fetchColumn();
				$stmt=$pdo->prepare($requeteInsertVisite);
				$stmt->bindParam('idVisite', $result);
				$stmt->execute();
				//---------------------------------------------------------------------------
				$reqMaxOrdo="SELECT MAX(id_ordo) FROM ordonnances";
				$resultOrdo=$pdo->query($reqMaxOrdo);
				$resultOrdo = $resultOrdo->fetchColumn();
				$selectPrescri="SELECT * FROM prescriptionstemp";
				$result = $pdo->query($selectPrescri);
				while($ligne = $result->fetch()) {
					$requete="INSERT INTO prescriptions (id_ordonnance, id_medicaments, posologie) VALUES(:idOrdo, :idMedoc, :posologie)";
					$stmt=$pdo->prepare($requete);
					$stmt->bindParam('idOrdo', $resultOrdo);
					$stmt->bindParam('idMedoc', $ligne['id_medicaments']);
					$stmt->bindParam('posologie', $ligne['posologie']);
					$stmt->execute();
				}
				//----------------------------------------------------------------------------
				$reqDelete="DELETE FROM prescriptionsTemp";
				$stmt=$pdo->prepare($reqDelete);
				$stmt->execute();

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
							<a href="accueilMedecin.php"><span class="fas fa-home"></span> -- Retour à la liste des patients -- </a>
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
							<form action="creationVisite.php" method="post">
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
										<div class="row">
											<!-- Patient -->
											<div class="col-md-12 col-sm-12 col-xs-12">
												<label for="patient">Patient :  </label><?php echo ' '.$nomP.' '.$prenomP;?>
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
												<label for="date">Date de naissance : </label><?php echo ' '.$dateNai; ?>
											</div>
										</div>
										<div class="row">
											<!--Saisie du poids-->
											<div class="col-md-6 col-sm-6 col-xs-12">
												<label for="poids">Poids: </label><?php echo ' '.$poids.' kg'; ?>
											</div>
										</div>
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
																while($ligne = $resultatsOrdo->fetch()) {
                                                                    echo '<form action="creationVisite.php" method="post">';
                                                                        echo '<tr>';
                                                                            echo '<input type="hidden" name="recupId" value="'.$ligne['id_medicaments'].'">';
                                                                            echo '<td>'.$ligne['denomination'].'</td>';
                                                                            echo '<td>'.$ligne['posologie'].'</td>';
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
                                                                            
                                                                            <!--Recherche par principes actifs -->
                                                                            <!-- <div class="col-md-6 col-sm-6 col-xs-12 inputCritere">
                                                                                <p class="text"><b>Laboratoire :</b></p> -->
                                                                                <!-- Liste des principes actifs -->
                                                                                <!-- <select class="form-control" name="labo" id="labo">
                                                                                    <option value="TOUS">TOUS</option> -->
                                                                                    <?php
                                                                                    // while($ligne = $resultatsL->fetch()) {
                                                                                    // 	echo '<option';
                                                                                    // 	if(isset($_POST['labo']) && $_POST['labo'] == $ligne['titulaire']) {
                                                                                    // 		echo " selected";
                                                                                    // 	} 
                                                                                    // 	echo '>'.$ligne['titulaire'].'</option>';
                                                                                    // }
                                                                                    ?>
                                                                                <!-- </select>
                                                                            </div>
                                                                            -->
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
                                                                <?php if($resultatsAllMedic->rowCount() == 0) {
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
                                                                            while($ligne = $resultatsAllMedic->fetch()) {
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
                                                                                    echo '<form action="ficheMedicament.php" method="post">';
                                                                                        echo '<input type="hidden" name="idMedoc" value="'.$ligne['idGeneral'].'">';
                                                                                        echo '<input type="hidden" name="OrdoToFiche">';
                                                                                        echo '<input hidden name="controller" value="FicheMedoc">';
                                                                                        echo '<td><button type="submit" class="btn btn-secondary" title="Voir la fiche médicament" name="voir"><span class="fas fa-eye"></button>';
                                                                                    echo '</form>';
                                                                                    echo '<form action="insertMedicament.php" method="post">';
                                                                                        echo '<input hidden name="idMedoc" value="'.$ligne['codeCis'].'">';
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
                                                                Nombre de médicaments : <?php echo $resultatsAllMedic->rowCount(); ?>
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