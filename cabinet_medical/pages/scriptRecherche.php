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
                        <form class="rechercheCriteres" method="post" action="creationVisite.php#openModal">
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
                            </div>
                            
                            <!--Bouton rechercher -->
                            <div class="col-md-12 col-sm-12 col-xs-12 divBtn">
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
                Nombre de médicaments : <?php echo $resultatsAllMedic->rowCount(); ?>
            </div>
        </div>
    </div>
    </div>
</div>