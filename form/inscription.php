<?php
// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=s4-projet50;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

// Insertion du message à l'aide d'une requête préparée
$req = $bdd->prepare('INSERT INTO usagers (nom, prenom, mot_de_passe, email) VALUES (?, ?, ?, ?)');
$req->execute(array($_POST['nom'], $_POST['prenom'], $_POST['mot_de_passe'], $_POST['email']));

// Redirection du visiteur vers la page du formulaire
header('Location: form_affiche.php');
?>