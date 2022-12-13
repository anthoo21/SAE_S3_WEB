<?php 	
    $target_dir = "../css/";
    $target_file = $target_dir . basename($_FILES["fichier"]["name"]);
    $uploadOk = 1;
    $imageTxtType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));		
    
    // Regarder si le fichier existe déjà
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Accepter que les .txt
    if($imageTxtType != "txt") {
        echo "Désolé, seul les fichiers en .txt sont acceptés.";
        $uploadOk = 0;
    }

    // Si uploadOk = 0, c'est qu'il y a eu une erreur
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // Sinon, essaye d'upload le fichier
    } else {
        if (move_uploaded_file($_FILES["fichier"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars(basename( $_FILES["fichier"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
			
?>