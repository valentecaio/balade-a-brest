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
    header('Location: pageLogin.php');
    exit();
}
$req->closeCursor();

// Insertion du message à l'aide d'une requête préparée
$req = $bdd->prepare('INSERT INTO usagers (nom, prenom, mot_de_passe, email) VALUES (:nom, :prenom, :mot_de_passe, :email)');
$req->execute(array(
    'nom' => $_POST['inscriptionSurname'],
    'prenom' => $_POST['inscriptionName'],
    'mot_de_passe' => $pass_hache,
    'email' => $_POST['inscriptionEmail']));

$last_id = $bdd->lastInsertId();
//$req->closeCursor();

/*echo "OK";
$req = $bdd->prepare('SELECT id_usager, nom, prenom, permission, email,  FROM usagers WHERE email = :email AND mot_de_passe = :mot_de_passe');
$req->execute(array(
    'email' => $_POST['inscriptionEmail'],
    'mot_de_passe' => $pass_hache));

$resultat = $req->fetch();
    echo "OK2";*/
    echo $resultat['id_usager'];
    $_SESSION['nom'] = $_POST['inscriptionSurname'];
    $_SESSION['prenom'] = $_POST['inscriptionName'];
    $_SESSION['permission'] = 'user';
    $_SESSION['id_usager'] = $last_id;
    $_SESSION['email'] = $_POST['inscriptionEmail'];
    //$req->closeCursor();
    //echo 'Vous êtes connecté !';
    echo $_SESSION['id_usager'];
    header('Location: pageMain.php');
?>