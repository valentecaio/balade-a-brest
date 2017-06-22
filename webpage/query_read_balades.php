<?php
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=web18_main;charset=utf8', 'root', '');
    }catch(Exception $e){
        die('Erreur : '.$e->getMessage());
    }

    if (!isset($_GET['status'])) {
        $req = $bdd->query('SELECT id_balade, nom, theme, description FROM balade WHERE status = \'accepte\'');
    } else {
        $req = $bdd->query('SELECT id_balade, nom, theme, description FROM balade WHERE status = \'en_attente\'');   
    }
    
    $list = array();
    while ($data = $req->fetch()) {
        $list[] = array(
		'id' => $data['id_balade'], 
		'name' => $data['nom'],
		'description' => $data['description'],
		'theme' => $data['theme']);
    }
    $req->closeCursor(); 
    echo json_encode($list);
?>
