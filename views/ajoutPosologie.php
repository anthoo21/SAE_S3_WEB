<!DOCTYPE html>
<html lang="Fr">
    <head>
      <title>MEDSOFT - Accueil Medecin</title>
      <meta charset="utf-8">
	  <link rel="stylesheet" href="../css/style.css"> 
    </head>
    <body>
<?php 

if(isset($idMedoc)) { ?>
<div class="row">
    <h2>Ajouter posologie :</h2>
    <form action="index.php" method="post">
        <input type="text" name="posologie" value="" placeholder="Ex: 1 fois par jour.">
        <input type="hidden" name="idMedoc" value="<?php echo $idMedoc?>">
        <input hidden name="idP" value="<?php echo $idP ?>">
        <input hidden name="controller" value="Posologie">
        <input hidden name="action" value="insertPrescri">
        <input hidden name="dateVisite" value="<?php echo $dateVisite?>">
        <input hidden name="motif" value="<?php echo $motif?>">
        <input hidden name="observation" value="<?php echo $observation?>">
        <input type="submit" class="btnInsert" value="Valider">
    </form>
</div>
<?php }?>
</body>
</html>