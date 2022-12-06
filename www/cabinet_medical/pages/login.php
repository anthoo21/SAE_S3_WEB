<!DOCTYPE html>
<html lang="Fr">
  <head>
      <title>MEDSOFT - Login</title>
      <meta charset="utf-8">
	  <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
	  <link rel="stylesheet" href="../fontawesome-free-6.2.1-web/css/all.css">
	  <link rel="stylesheet" href="../css/style.css"> 
  </head>
  
  <body>
  <p> test </p>


    <?php
    session_start();

    //PDO
    $host = 'localhost';
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

    try {
        if (isset($_POST['submit'])) {
            $identifiant = $_POST['identifiant'];
            $mdp = $_POST['passwd'];
    
            $stmt = "SELECT * FROM utilisateurs WHERE identifiant = '$identifiant' ";
            $resultats = $pdo->prepare($stmt);
            $resultats->execute();
    
            if ($resultats->rowCount() > 0) {
                $data = $resultats->fetchAll();
                if (password_verify($mdp, $data[0]["motDePasse"])) {
                    $_SESSION["identifiant"] = $identifiant;
                    echo "<h1>Connexion effectué</h1>";
                }
    
            } else {
                echo "<h1>Utilisateur invalide</h1>";
            }
        }
    } catch (PDOEXCEPTION $e) {
        echo $e;
    }
    

    ?>
    </body>
</html>