<?php
// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=web18_main;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

// Insertion du message à l'aide d'une requête préparée
$req = $bdd->prepare('INSERT INTO usagers (nom, prenom, mot_de_passe, email) VALUES (?, ?, ?, ?)');
$req->execute(array($_POST['inscriptionName'], $_POST['inscriptionSurname'], $_POST['inscriptionPassword'], $_POST['inscriptionEmail']));

// Redirection du visiteur vers la page du formulaire
header('Location: form_affiche.php');
?>