<?php
// Connexion à la base de données
session_start();

try
{
	$bdd = new PDO('mysql:host=localhost;dbname=web18_main;charset=utf8', 'root', '');
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
    header('Location: pagePoint.php');
    exit();
}
$req->closeCursor();*/
echo $_POST['form_name'];
if(strcmp($_SESSION['permission'], "admin") == 0 ){

// Insertion du message à l'aide d'une requête préparée
    $req = $bdd->prepare('INSERT INTO balade (nom, theme, description, status) VALUES (:nom, :theme, :description, \'accepte\')');
    $req->execute(array(
        'nom' => $_POST['form_name'],
        'theme' => $_POST['form_theme'],
        'description' => $_POST['form_comment']));

}else{

   // Insertion du message à l'aide d'une requête préparée
    $req = $bdd->prepare('INSERT INTO balade (nom, theme, description) VALUES (:nom, :theme, :description)');
    $req->execute(array(
        'nom' => $_POST['form_name'],
        'theme' => $_POST['form_theme'],
        'description' => $_POST['form_comment']));
}
$points = json_decode($_POST['form_list']);

$id_balade = $bdd->lastInsertId();
echo $id_balade;
foreach ($points as $value) {
    $id_point = $value->id;
    //$ordre =
    $req = $bdd->prepare('INSERT INTO contenu_parcours (id_p, id_b) VALUES (:id_p, :id_b)');
        $req->execute(array(
            'id_p' => $id_point,
            'id_b' => $id_balade ));
}

    //$req->closeCursor();
   
if(strcmp($_SESSION['permission'], "admin") == 0 ){
	header('Location: pageMain.php');
}else{
	header('Location: pagePoint.php?modal=2');
}
?>