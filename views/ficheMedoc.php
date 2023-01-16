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
                        <!-- Assigne des variables aux informations générales d'un médicament-->
                        <?php while($ligne = $requeteMedGeneral->fetch()) {
                                echo $ligne['denomination'];
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
                        }  ?>
					</div>
					<div class="col-md-4 hidden-sm hidden-xs">
					</div>
					<div class="col-md-1 col-sm-12 col-xs-12 titreDossier">
						<form action="index.php" method="post">
                            <input hidden name="controller" value="Recherche">
							<button type="submit" class="btn btn-danger btn-circle btn-xxl" name="retour" value="true"><span class="fas fa-arrow-left"></span></button>
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
                            //vérifie chaque champ pour savoir si il est vide ou non
                            while($ligne = $requeteMedCIP->fetch()) {
                                if(!isset($ligne['libelle'])) {
                                    $ligne['libelle'] = "";
                                }
                                if(!isset($ligne['dateDecla'])) {
                                    $ligne['dateDecla'] = "";
                                }
                                if(!isset($ligne['agrement'])) {
                                    $ligne['agrement'] = "";
                                }
                                if(!isset($ligne['tauxRemboursement'])) {
                                    $ligne['tauxRemboursement'] = "";
                                }
                                if(!isset($ligne['prix'])) {
                                    $ligne['prix'] = "";
                                }
                                if(!isset($ligne['droitRemboursement'])) {
                                    $ligne['droitRemboursement'] = "";
                                }
                                if($ligne['prix'] != "") {
                                    $symb = "€";
                                } else {
                                    $symb = "";
                                }
                                echo '<p>Libellé : '.$ligne['libelle'].'</p>';
                                echo '<p>Date déclaration : '.$ligne['dateDecla'].'</p>';
                                echo '<p>Agrément : '.$ligne['agrement'].'</p>';
                                echo '<p>Taux de remboursement : '.$ligne['tauxRemboursement'].'</p>';
                                echo '<p>Prix : '.$ligne['prix'].$symb.'</p>';
                                echo '<p>Droit de remboursement : '.$ligne['droitRemboursement'].'</p>';
                            }
							?>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12 paddingFiche">
					<div class="col-md-12 col-sm-12 col-xs-12 bordureD">
						<div class="col-md-12 col-sm-12 col-xs-12 paddingForm">
							<h3><u>Composition :</u></h3>
							<?php
                            //affiche les infos concernant la composition d'un médicament
                            while($ligne = $requeteMedCOMPO->fetch()) {
                                echo '<p>Dénomination substance : '.$ligne['denomSubstance'].'</p>';
                                echo '<p>Dosage : '.$ligne['dosage'].'</p>';
                                echo '<p>Référence dosage : pour '.$ligne['refDosage'].'</p>';
                                echo '<p>Nature composition : '.$ligne['natureCompo'].' (SA : principe actif | FT : fraction thérapeutique)</p>';
                            }
							?>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12 paddingFiche">
					<div class="col-md-12 col-sm-12 col-xs-12 bordureD">
						<div class="col-md-12 col-sm-12 col-xs-12 paddingForm">
							<h3><u>Avis ASMR de la HAS :</u></h3>
							<?php
                            //affiche l'avis ASMR de la HAS
                            while($ligne = $requeteMedASMR->fetch()) {
                                if($requeteMedASMR->rowCount() != 0) {
                                    echo '<p>Motif d\'évaluation : '.$ligne['motifEval'].'</p>';
                                    echo '<p>Date de l\'avis : '.$ligne['dateAvis'].'</p>';
                                    echo '<p>Valeur de l\'ASMR : '.$ligne['valeurAsmr'].'</p>';
                                    echo '<p>Libellé de l\'ASMR : '.$ligne['libelle'].'</p>';
                                } else {
                                    echo '<p>Pas de données</p>';
                                }
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
                            //affiche l'avis SMR de la HAS
                            while($ligne = $requeteMedSMR->fetch()) {
                                if($requeteMedSMR->rowCount() != 0) {
                                    echo '<p>Motif d\'évaluation : '.$ligne['motifEval'].'</p>';
                                    echo '<p>Date de l\'avis : '.$ligne['dateAvis'].'</p>';
                                    echo '<p>Valeur de l\'ASMR : '.$ligne['valeurSmr'].'</p>';
                                    echo '<p>Libellé de l\'ASMR : '.$ligne['libelle'].'</p>';
                                } else {
                                    echo '<p>Pas de données</p>';
                                }
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
                            //affiche les infos importantes concernant un médicament
                            while($ligne = $requeteMedINFO->fetch()) {
                                if($requeteMedINFO->rowCount() != 0) {
                                    echo '<p>Date de début de l\'information : '.$ligne['dateDebut'].'</p>';
                                    echo '<p>Date de fin de l\'information : '.$ligne['dateFin'].'</p>';
                                    echo '<p>Lien vers l\'information : '.$ligne['texteLien'].'</p>';
                                } else {
                                    echo '<p>Pas de données</p>';
                                }
                            }
							?>
						</div>
					</div>
				</div>
            </div>
            
    </body>
</html>