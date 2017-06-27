<?php
// Connexion à la base de données
session_start();

try {
	$bdd = new PDO('mysql:host=localhost;dbname=web18_main;charset=utf8', 'root', '');
} catch(Exception $e) {
	die('Erreur : '.$e->getMessage());
}

if(strcmp($_SESSION['permission'], "admin") == 0 ){
    $req = $bdd->prepare('INSERT INTO point (nom, latitude, longitude, description, status) VALUES (:nom, :latitude, :longitude, :description, \'accepte\')');
    $req->execute(array(
        'nom' => $_POST['form_name'],
        'latitude' => $_POST['form_latitude'],
        'longitude' => $_POST['form_longitude'],
        'description' => $_POST['form_comment']));
} else {
    $req = $bdd->prepare('INSERT INTO point (nom, latitude, longitude, description) VALUES (:nom, :latitude, :longitude, :description)');
    $req->execute(array(
        'nom' => $_POST['form_name'],
        'latitude' => $_POST['form_latitude'],
        'longitude' => $_POST['form_longitude'],
        'description' => $_POST['form_comment']));
}

if ( !$_FILES["file_upload"]["name"] == ''){
    $id_point_ref = $bdd-> lastInsertId();
    $target_dir = 'uploads/';
-   $target_file = $target_dir . basename($_FILES["file_upload"]["name"]);
    $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
    echo "asfsf" . $fileType;
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'mp3', 'wma', 'mp4');
    if(in_array($fileType, $valid_extensions)){
        move_uploaded_file($_FILES["file_upload"]["tmp_name"], $target_file);
        $req = $bdd->prepare('INSERT INTO media (chemin, id_point_ref) VALUES (:chemin, :id_point_ref)');
        $req->execute(array(
            'chemin' => basename($_FILES["file_upload"]["name"]),
            'id_point_ref' => $id_point_ref));
    }
    else {
        echo "Sorry, there was an error uploading your file.";
    }
}

if (strcmp($_SESSION['permission'], "admin") == 0 ) {
    header('Location: pageMain.php');
}
else{
    header('Location: pagePoint.php?modal=2');
}

?>