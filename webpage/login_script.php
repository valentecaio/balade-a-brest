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
$pass_hache = sha1($_POST['inputPassword']);

// Vérification des identifiants
$req = $bdd->prepare('SELECT id_usager, nom, prenom, email, permission FROM usagers WHERE email = :email AND mot_de_passe = :mot_de_passe');
$req->execute(array(
    'email' => $_POST['inputEmail'],
    'mot_de_passe' => $pass_hache));

$resultat = $req->fetch();

if (!$resultat)
{
    $_SESSION['error'] = 'Mauvais identifiant ou mot de passe';
    //echo nl2br('Mauvais identifiant ou mot de passe !\n');
    header('Location: login_s4php.php');
    exit();
    //exit('Mauvais identifiant ou mot de passe !');
}
else
{
    $_SESSION['nom'] = $resultat['nom'];
    $_SESSION['prenom'] = $resultat['prenom'];
    $_SESSION['permission'] = $resultat['permission'];
    $_SESSION['id_usager'] = $resultat['id_usager'];
    $_SESSION['email'] = $resultat['email'];
    echo nl2br('Vous êtes connecté !\n');
    echo $_SESSION['id_usager'];
    header('Location: principal.php');
}

$req->closeCursor();
?>