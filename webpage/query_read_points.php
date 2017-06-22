<?php
   
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=web18_main;charset=utf8', 'root', '');
    }catch(Exception $e){
        die('Erreur : '.$e->getMessage());
    }

    if (!isset($_GET['status'])) {
        $req = $bdd->query('SELECT id_point, nom, latitude, longitude, description FROM point WHERE status = \'accepte\'');
    }
    else{
        $req = $bdd->query('SELECT id_point, nom, latitude, longitude, description FROM point WHERE status = \'en_attente\'');   
    }
    
    $list = array();
    while ($data = $req->fetch()) {
        $list[] = array(
		'id' => $data['id_point'], 
		'name' => $data['nom'], 
		'lon' => $data['longitude'], 
		'lat' => $data['latitude'], 
		'txt' => $data['description']);
    }
    $req->closeCursor(); 
    echo json_encode($list);

?>


