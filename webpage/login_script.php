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
// Hachage du mot de passe
$pass_hache = sha1($_POST['inputPassword']);

// Vérification des identifiants
$req = $bdd->prepare('SELECT id_usager, permission FROM usagers WHERE email = :email AND mot_de_passe = :mot_de_passe');
$req->execute(array(
    'email' => $_POST['inputEmail'],
    'mot_de_passe' => $pass_hache));

$resultat = $req->fetch();

if (!$resultat)
{
    //echo nl2br('Mauvais identifiant ou mot de passe !\n');
    header('Location: principal.php');
    exit('Mauvais identifiant ou mot de passe !');
}
else
{
    session_start();
    if($resultat['permission'] == 'admin'){
        $_SESSION['permission'] = $resultat['permission'];
    }
    $_SESSION['id_usager'] = $resultat['id_usager'];
    $_SESSION['inputEmail'] = $_POST['inputEmail'];
    echo nl2br('Vous êtes connecté !\n');
    echo $_SESSION['id_usager'];
    header('Location: principal.php');
}
?>