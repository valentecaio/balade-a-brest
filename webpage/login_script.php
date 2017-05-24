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
$req = $bdd->prepare('SELECT id_usager FROM usagers WHERE email = :email AND mot_de_passe = :mot_de_passe');
$req->execute(array(
    'email' => $_POST['inputEmail'],
    'mot_de_passe' => $_POST['inputPassword']));

$resultat = $req->fetch();

if (!$resultat)
{
    echo 'Mauvais identifiant ou mot de passe !';
    echo $_POST['inputEmail'];
    echo $_POST['inputPassword'];
    echo "OK";
}
else
{
    session_start();
    $_SESSION['id_usager'] = $resultat['id_usager'];
    $_SESSION['inputEmail'] = $_POST['inputEmail'];
    echo 'Vous êtes connecté !';
    //  echo isset($_SESSION['id_usager']);
header('Location: principal.php');
}
?>