<?php
// Connexion à la base de données
session_start();

try
{
	$bdd = new PDO('mysql:host=localhost;dbname=web18_main;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
// Vérification de la validité des informations

/*$req = $bdd->prepare('SELECT id_point FROM point WHERE nom = :nom');
$req->execute(array(
    'nom' => $_POST['form_name']));

$resultat = $req->fetch();

if ($resultat['id_point']){
    $_SESSION['error'] = 'Point déjà existant';
    header('Location: pagePoint.php');
    exit();
}
$req->closeCursor();*/

if(strcmp($_SESSION['permission'], "admin") == 0 ){

// Insertion du message à l'aide d'une requête préparée
    $req = $bdd->prepare('INSERT INTO point (nom, latitude, longitude, description, status) VALUES (:nom, :latitude, :longitude, :description, \'accepte\')');
    $req->execute(array(
        'nom' => $_POST['form_name'],
        'latitude' => $_POST['form_latitude'],
        'longitude' => $_POST['form_longitude'],
        'description' => $_POST['form_comment']));
}else{

    $req = $bdd->prepare('INSERT INTO point (nom, latitude, longitude, description) VALUES (:nom, :latitude, :longitude, :description)');
    $req->execute(array(
        'nom' => $_POST['form_name'],
        'latitude' => $_POST['form_latitude'],
        'longitude' => $_POST['form_longitude'],
        'description' => $_POST['form_comment']));
}
$id_point_ref = $bdd-> lastInsertId();

$target_dir = 'uploads/';
$target_file = $target_dir . basename($_FILES["file_upload"]["name"]);
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'mp3', 'wma', 'mp4');
if(in_array($fileType, $valid_extensions)){
    move_uploaded_file($_FILES["file_upload"]["tmp_name"], $target_file);
}
else {
    echo "Sorry, there was an error uploading your file.";
}

$image_extensions = array('jpeg', 'jpg', 'png');
$audio_extensions = array('mp3', 'mp4', 'wma');
$video_extensions = array('mp3', 'mp4', 'wma');
if(in_array($fileType, $image_extensions)){
    $type = 'image';
}else if(in_array($fileType, $audio_extensions)){
    $type = 'audio';
}else if(in_array($fileType, $video_extensions)){
    $type = 'video';
}else{
    echo "File doesn't have a compatible extension";
} 
$req = $bdd->prepare('INSERT INTO media (type, chemin, id_point_ref) VALUES (:type, :chemin, :id_point_ref)');
$req->execute(array(
    'type' => $type,
    'chemin' => $target_file,
    'id_point_ref' => $id_point_ref));
    //$req->closeCursor();
    if (strcmp($_SESSION['permission'], "admin") == 0 ) {
        header('Location: pageMain.php');
    }
    else{
        header('Location: pagePoint.php?modal=2');
    }
?>