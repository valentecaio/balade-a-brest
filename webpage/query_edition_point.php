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

	
	header('Location: pageMain.php');
	exit();
?>