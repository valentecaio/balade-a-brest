<?php
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=web18_main;charset=utf8', 'root', '');
    }catch(Exception $e){
        die('Erreur : '.$e->getMessage());
    }

    $req = $bdd->query('SELECT id_p, id_b FROM contenu_parcours');
    
    $list = array();
    while ($data = $req->fetch()) {
        $list[] = array(
		'id_p' => $data['id_p'], 
		'id_b' => $data['id_b']);
    }
    $req->closeCursor(); 
    echo json_encode($list);
?>
