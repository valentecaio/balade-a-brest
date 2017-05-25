<?php
// Connexion à la base de données
session_start();

try
{
	$bdd = new PDO('mysql:host=localhost;dbname=s4-projet50;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
// Vérification de la validité des informations

// Hachage du mot de passe
$pass_hache = sha1($_POST['inscriptionPassword']);

$req = $bdd->prepare('SELECT id_usager FROM usagers WHERE email = :email');
$req->execute(array(
    'email' => $_POST['inscriptionEmail']));

$resultat = $req->fetch();

if ($resultat['id_usager']){
    $_SESSION['error'] = 'Usager déjà existant';
    header('Location: login_s4php.php');
    exit();
}
// Insertion du message à l'aide d'une requête préparée
$req = $bdd->prepare('INSERT INTO usagers (nom, prenom, mot_de_passe, email) VALUES (:nom, :prenom, :mot_de_passe, :email)');
$req->execute(array(
    'nom' => $_POST['inscriptionSurname'],
    'prenom' => $_POST['inscriptionName'],
    'mot_de_passe' => $pass_hache,
    'email' => $_POST['inscriptionEmail']));

$req = $bdd->prepare('SELECT id_usager, nom, prenom, permission, email,  FROM usagers WHERE email = :email AND mot_de_passe = :mot_de_passe');
$req->execute(array(
    'email' => $_POST['inscriptionEmail'],
    'mot_de_passe' => $pass_hache));

$resultat = $req->fetch();
    $_SESSION['nom'] = $resultat['nom'];
    $_SESSION['prenom'] = $resultat['prenom'];
    $_SESSION['permission'] = $resultat['permission'];
    $_SESSION['id_usager'] = $resultat['id_usager'];
    $_SESSION['email'] = $resultat['email'];
    //echo 'Vous êtes connecté !';
    //echo $_SESSION['id_usager'];
    header('Location: principal.php');
?>