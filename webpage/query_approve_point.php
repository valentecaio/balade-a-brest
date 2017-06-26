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


	$req = $bdd->prepare('UPDATE point SET status = \'accepte\' WHERE id_point = :id_point');
	$req->execute(array(
		'id_point' => $_POST['form_id']));
	
	header('Location: pageMain.php');
	exit();
?>