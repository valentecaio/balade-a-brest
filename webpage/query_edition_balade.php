<?php 
//echo "modify settings";
session_start();

// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=web18_main;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}


$req = $bdd->prepare('UPDATE balade SET nom = :nom, description = :description, theme = :theme WHERE id_balade = :id_balade');
$req->execute(array(
	'id_balade' => $_POST['form_id'],
	'nom' => $_POST['form_name'],
	'theme' => $_POST['form_theme'],
	'description' => $_POST['form_comment']));
	
	header('Location: pageMain.php');
	exit();
?>