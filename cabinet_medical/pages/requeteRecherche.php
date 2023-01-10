<?php 
$requeteT="SELECT DISTINCT(forme) FROM cis_bdpm ORDER BY forme ASC";	
$resultatsT=$pdo->query($requeteT); 
$requeteL="SELECT DISTINCT(titulaire) FROM cis_bdpm";
$resultatsL=$pdo->query($requeteL);  
$requete = "";
    if(isset($_POST['designation']) && isset($_POST['Type']) && isset($_POST['generiques'])) {
        if($_POST['designation'] != "") {
            $medicament = "%".$_POST['designation']."%";
            $un = "WHERE denomination like :medicamentDes";
            $requete = $requete.$un;
            if($_POST['Type'] != 'TOUS') {
                $deux = ' AND forme = "'.$_POST["Type"].'"';
                $requete = $requete.$deux;
            }
            // if($_POST['labo'] != 'TOUS') {
            // 	$trois = ' AND titulaire = "'.$_POST["labo"].'"';
            // 	$requete = $requete.$trois;
            // }
            if($_POST['generiques']) {
                if($_POST['generiques'] == "Oui") {
                    $quatre = ' AND libelle IS NOT NULL';
                    $requete = $requete.$quatre;
                } else {
                    $quatre = ' AND libelle IS NULL';
                    $requete = $requete.$quatre;
                }
            }
        } else if ($_POST['Type'] != 'TOUS') {
            $deux = 'WHERE forme = "'.$_POST["Type"].'"';
            $requete = $requete.$deux;
            // if($_POST['labo'] != 'TOUS') {
            // 	$trois = ' AND titulaire = "'.$_POST["labo"].'"';
            // 	$requete = $requete.$trois;
            // }
            if($_POST['generiques']) {
                if($_POST['generiques'] == "Oui") {
                    $quatre = ' AND libelle IS NOT NULL';
                    $requete = $requete.$quatre;
                } else {
                    $quatre = ' AND libelle IS NULL';
                    $requete = $requete.$quatre;
                }
            }
        // } else if($_POST['labo'] != 'TOUS') {
        // 	$trois = 'WHERE titulaire = "'.$_POST["labo"].'"';
        // 	$requete = $requete.$trois;
        // 	if($_POST['generiques']) {
        // 		if($_POST['generiques'] == "Oui") {
        // 			$quatre = ' AND libelle IS NOT NULL';
        // 			$requete = $requete.$quatre;
        // 		} else {
        // 			$quatre = ' AND libelle IS NULL';
        // 			$requete = $requete.$quatre;
        // 		}
        // 	}
        } else if($_POST['generiques']) {
            if($_POST['generiques'] == "Oui") {
                $quatre = 'WHERE libelle IS NOT NULL';
                $requete = $requete.$quatre;
            } else {
                $quatre = 'WHERE libelle IS NULL';
                $requete = $requete.$quatre;
            }
        }
        $resultatsAllMedic = $pdo->prepare("SELECT idGeneral, denomination, forme, titulaire, libelle FROM cis_bdpm LEFT JOIN cis_gener_bdpm ON codeCis = codeCis_GENER ".$requete." ORDER BY denomination ASC");
        $resultatsAllMedic->bindParam("medicamentDes", $medicament);
        $resultatsAllMedic->execute();
    } else {
        $requeteAllMedic="SELECT idGeneral, denomination, forme, titulaire, libelle FROM cis_bdpm LEFT JOIN cis_gener_bdpm ON codeCis = codeCis_GENER WHERE idGeneral IN (1,2,3,4,5,6,7,8,9,10) ORDER BY denomination ASC";
        $resultatsAllMedic=$pdo->query($requeteAllMedic); 
    }
?>