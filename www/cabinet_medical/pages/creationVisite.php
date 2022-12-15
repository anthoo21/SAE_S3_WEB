<?php
session_start(); //démarrage d'une session


//Vérification que les variables sessions de l'utilisateur existent
if(isset($_SESSION['login']) && isset($_SESSION['pwd'])) {
	$login = $_SESSION['login'];
	$pwd = $_SESSION['pwd'];
}

if(isset($_POST['deconnexion']) && $_POST['deconnexion']) {
	session_destroy();
	header('Location: ../index.php');
  	exit();
}
?>

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
  </body>
</html>