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
                    <div class="col-md-4 col-sm-4 col-xs-4 ">
						<form action="index.php" method="post">
							<input hidden name="controller" value="Medecins">
							<input hidden name="action" value="index">
							<button type="submit" class="btn btn-info= btn-circle btn-xxl" name="deconnexion" value="true" title="Patients"><span class="fas fa-user"></button>
						</form>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4 ">
						<form action="index.php" method="post">
							<input hidden name="controller" value="Medecins">
							<input hidden name="action" value="deconnexion">
							<button type="submit" class="btn btn-danger btn-circle btn-xxl" name="deconnexion" value="true" title="Déconnexion"><span class="fas fa-power-off"></button>
						</form>
					</div>
				</div>	
			</div>
			
			<!--Nom du docteur-->
			<div class="row">
				</br>
				<div class="col-md-12 col-sm-12 col-xs-12 doctorName">
					<?
                        //affiche le Nom et Prénom du Docteur connecté
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
                        <form class="rechercheCriteres" method="post" action="index.php">
                            <!--Recherche par désignation -->
                            <div class="col-md-6 col-sm-6 col-xs-12 inputCritere">
                                <p class="text"><b>Désignation :</b></p>
                                <input type="texte" name="designation" class="form-control" placeholder="Tapez un mot à chercher" value="<?php 
                                //vérifie si l'utilisateur avait déjà rempli ce champ lors de l'envoi du formulaire
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
                                    //boucle pour afficher tous les types de médicaments
                                    while($ligne = $searchStmt2->fetch()) {
                                        echo '<option';
                                        //vérifie si l'utilisateur avait déjà rempli ce champ lors de l'envoi du formulaire
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
                                <!-- Si l'un des champs a déjà été rempli, le remettre lors de l'envoi du formulaire-->
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
                                <input hidden name="controller" value="Recherche">
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
                        </tr>
                        <?php 
                            while($ligne = $searchStmt->fetch()) {
                                //affiche Oui si il y a des génériques, Non sinon
                                if($ligne['libelle'] != "") {
                                    $gener = 'Oui';
                                } else {
                                    $gener = 'Non';
                                }
                                //Permet d'afficher les médicaments selon la recherche de l'utilisateur
                                echo '<form action="index.php" method="post">';
                                    echo '<tr>';
                                        echo '<input type="hidden" name="idMedoc" value="'.$ligne['idGeneral'].'">';
                                        echo '<td>'.$ligne['denomination'].'</td>';
                                        echo '<td>'.$ligne['forme'].'</td>';
                                        echo '<td>'.$ligne['titulaire'].'</td>';
                                        echo '<td>'.$gener.'</td>';
                                        echo '<input hidden name="controller" value="FicheMedoc">';
                                        echo '<td><button type="submit" class="btn btn-secondary" title="Voir la fiche médicament"><span class="fas fa-eye"></button>';
                                    echo '</tr>';
                                echo '</form>';
                            }
                        ?>
                    </div>
                </table>
                <?php } ?>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 titre">
                <!-- Affiche le nombre de médicaments trouvés. -->
                Nombre de médicaments : <?php echo $searchStmt->rowCount(); ?>
            </div>
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
