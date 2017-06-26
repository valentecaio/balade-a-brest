<?php
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=web18_main;charset=utf8', 'root', '');
    }catch(Exception $e){
        die('Erreur : '.$e->getMessage());
    }

    $req = $bdd->query('SELECT id_media, chemin, id_point_ref FROM media WHERE status = \'accepte\'');
    
    $list = array();
    while ($data = $req->fetch()) {
        $list[] = array(
		'id_media' => $data['id_media'], 
		'id_point_ref' => $data['id_point_ref'], 
		'filepath' => $data['chemin']);
    }
    $req->closeCursor(); 
    echo json_encode($list);
?>
