<?php
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=web18_main;charset=utf8', 'root', '');
    }catch(Exception $e){
        die('Erreur : '.$e->getMessage());
    }

    if (!isset($_GET['status'])) {
        $req = $bdd->query('SELECT id_point, nom, latitude, longitude, description FROM point WHERE status = \'accepte\'');
    } else {
        $req = $bdd->query('SELECT id_point, nom, latitude, longitude, description FROM point WHERE status = \'en_attente\'');   
    }
    
    $listpoints = array();
	// for each point
    while ($data_point = $req->fetch()) {
		// get array of medias
        $req_points = $bdd->prepare('SELECT m.id_media, m.chemin, m.id_point_ref FROM media as m, point as p WHERE p.status = \'accepte\' and p.id_point=m.id_point_ref and p.id_point = :id_point');
        $req_points->execute(array('id_point' => $data_point['id_point']));
	
		// fetch array of medias
        $listmedias = array();
        while ($data_media = $req_points->fetch()) {
            $listmedias[] = array('id_media' => $data_media['id_media'], 'chemin' => $data_media['chemin']);
        }
        $req_points->closeCursor();
		
		// generate new entry to array of points
		$listpoints[] = array(
		'id' => $data_point['id_point'], 
		'name' => $data_point['nom'], 
		'lon' => $data_point['longitude'], 
		'lat' => $data_point['latitude'], 
		'txt' => $data_point['description'],
		'medias' => $listmedias);
    }
    $req->closeCursor(); 
    echo json_encode($listpoints);
?>
