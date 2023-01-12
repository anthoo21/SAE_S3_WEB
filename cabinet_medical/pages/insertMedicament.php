<?php
session_start(); //démarrage d'une session

	// Test si on est bien connecté (session existante et bon numéro de session
	if (!isset($_SESSION['login']) || !isset($_SESSION['id']) || $_SESSION['id']!=session_id()) {
		// Renvoi vers la page de connexion
  		header('Location: ../index.php');
  		exit();
	}
	
    // Déconnexion
    if(isset($_POST['deconnexion']) && $_POST['deconnexion']) {
        session_destroy();
        header('Location: ../index.php');
        exit();
    }

?>
<!DOCTYPE html>
<html lang="Fr">
    <head>
      <title>MEDSOFT - Accueil Medecin</title>
      <meta charset="utf-8">
	  <link rel="stylesheet" href="../css/style.css"> 
    </head>
    <body>
<?php 
if(isset($_POST['idMedoc'])) {
$idMedoc = $_POST['idMedoc']?>
<div class="row">
    <h2>Ajouter posologie :</h2>
    <form action="insertMedicament.php" method="post">
        <input type="text" name="posologie" value="" placeholder="Ex: 1 fois par jour.">
        <input type="hidden" name="idMedoc2" value="<?php echo $idMedoc?>">
        <input type="submit" class="btnInsert" value="Valider">
    </form>
</div>
<?php }?>
<?php
$host = '127.0.0.1';
$db = 'medsoft';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
PDO::ATTR_EMULATE_PREPARES => false
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    echo $e->getMessage();
    //throw new PDOException($e->getMessage(), (int)$e->getCode());
}
if(isset($_POST['posologie'])) {
    try {
    $maxIdOrdo = "SELECT MAX(id_ordo) FROM ordonnances";
    $maxIdOrdoResultat = $pdo->query($maxIdOrdo);
    $requeteInsert=$pdo->prepare('INSERT INTO prescriptionsTemp (id_medicaments, posologie) VALUES (:idMedoc, :posologie)');
    $result = $maxIdOrdoResultat->fetchColumn();
    $requeteInsert->bindParam('idMedoc', $_POST['idMedoc2']);
    $requeteInsert->bindParam('posologie', $_POST['posologie']);
    $requeteInsert->execute();
    header("location:creationVisite.php"); 
    } catch(Exception $e) {
        echo $e->getMessage();
    }
}
?>
</body>
</html>