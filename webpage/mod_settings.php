<?php 

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
// Hachage du mot de passe
$pass_hache = sha1($_POST['oldPassword']);

// Vérification des identifiants
$req = $bdd->prepare('SELECT mot_de_passe FROM usagers WHERE id_usager = :id_usager');
$req->execute(array(
    'id_usager' => $_SESSION['id_usager']));

$resultat = $req->fetch();

if (strcmp($resultat['mot_de_passe'], $pass_hache) != 0){
    $_SESSION['error'] = 'Mauvais mot de passe';
    //echo nl2br('Mauvais identifiant ou mot de passe !\n');
    echo "OK";
    //header('Location: #myModal');
    //exit();
    //exit('Mauvais identifiant ou mot de passe !');
}else{
	$req->closeCursor();

	$req = $bdd->prepare('UPDATE usagers SET nom = :nom, prenom = :prenom WHERE id_usager = :id_usager');
	$req->execute(array(
		'nom' => $_POST['surname'],
		'prenom' => $_POST['name'],
		'mot_de_passe' => $_POST['newPassword'],
		'id_usager' => $_SESSION['id_usager']));
	
	header('Location: #myModal');
}
?>