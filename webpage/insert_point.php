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

/*$req = $bdd->prepare('SELECT id_point FROM point WHERE nom = :nom');
$req->execute(array(
    'nom' => $_POST['form_name']));

$resultat = $req->fetch();

if ($resultat['id_point']){
    $_SESSION['error'] = 'Point déjà existant';
    header('Location: createPoint.php');
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
        'description' => $_POST['comment']));

}else{

    $req = $bdd->prepare('INSERT INTO point (nom, latitude, longitude, description) VALUES (:nom, :latitude, :longitude, :description)');
    $req->execute(array(
        'nom' => $_POST['form_name'],
        'latitude' => $_POST['form_latitude'],
        'longitude' => $_POST['form_longitude'],
        'description' => $_POST['comment']));
}
    //$req->closeCursor();
    header('Location: createPoint.php?modal=2');
?>