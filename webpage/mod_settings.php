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
// Hachage du mot de passe
$pass_hache = sha1($_POST['oldPassword']);

if(strcmp($_SESSION['email'], $_POST['email']) != 0){
	$req = $bdd->prepare('SELECT id_usager FROM usagers WHERE email = :email');
	$req->execute(array(
	    'email' => $_POST['email']));

	$resultat = $req->fetch();

	if ($resultat['id_usager']){
	    $_SESSION['error'] = 'Usager déjà existant';
	    header('Location: ' . $_POST['url'] . '?modal=1');
    	exit();
	}
	$req->closeCursor();
}

// Vérification des identifiants
$req = $bdd->prepare('SELECT mot_de_passe FROM usagers WHERE id_usager = :id_usager');
$req->execute(array(
    'id_usager' => $_SESSION['id_usager']));

$resultat = $req->fetch();

if (strcmp($resultat['mot_de_passe'], $pass_hache) != 0){
	$_SESSION['modify'] = 1;
    $_SESSION['error'] = 'Mauvais mot de passe';
    //echo nl2br('Mauvais identifiant ou mot de passe !\n');
    //echo "OK";
    header('Location: ' . $_POST['url'] . '?modal=1');
    exit();
    //exit('Mauvais identifiant ou mot de passe !');

}else if(!empty($_POST['newPassword'])){
	$req->closeCursor();
	//echo "OK2";

	$new_pass_hache = sha1($_POST['newPassword']);
	$req = $bdd->prepare('UPDATE usagers SET nom = :nom, prenom = :prenom, email = :email, mot_de_passe = :mot_de_passe WHERE id_usager = :id_usager');
	$req->execute(array(
		'nom' => $_POST['surname'],
		'prenom' => $_POST['name'],
		'email' => $_POST['email'],
		'mot_de_passe' => $new_pass_hache,
		'id_usager' => $_SESSION['id_usager']));

	$_SESSION['email'] = $_POST['email'];
	$_SESSION['nom'] = $_POST['surname'];
    $_SESSION['prenom'] = $_POST['name'];
	
	header('Location: ' . $_POST['url']);

}else{
	
	$req->closeCursor();
	//echo "OK2";

	$req = $bdd->prepare('UPDATE usagers SET nom = :nom, prenom = :prenom, email = :email WHERE id_usager = :id_usager');
	$req->execute(array(
		'nom' => $_POST['surname'],
		'prenom' => $_POST['name'],
		'email' => $_POST['email'],
		'id_usager' => $_SESSION['id_usager']));

	$_SESSION['email'] = $_POST['email'];
	$_SESSION['nom'] = $_POST['surname'];
    $_SESSION['prenom'] = $_POST['name'];
	//echo $_POST['email'];
	header('Location: ' . $_POST['url']);
	exit();
}
?>