<?php 
//echo "modify settings";
session_start();

// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=s4-projet50;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}


	$req = $bdd->prepare('UPDATE point SET nom = :nom, latitude = :latitude, longitude = :longitude, description = :description WHERE id_point = :id_point');
	$req->execute(array(
		'id_point' => $_POST['form_id'],
		'nom' => $_POST['form_name'],
		'latitude' => $_POST['form_latitude'],
		'longitude' => $_POST['form_longitude'],
		'description' => $_POST['form_comment']));

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

	
	header('Location: pageMain.php');
	exit();
?>