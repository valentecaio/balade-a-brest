<?php
/*
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

 */  
    // create example points
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=web18_main;charset=utf8', 'root', '');
    }catch(Exception $e){
        die('Erreur : '.$e->getMessage());
    }

    if (!isset($_GET['status'])) {
        $req_balade = $bdd->query('SELECT id_balade, nom, theme, description FROM balade WHERE status = \'accepte\'');
    }
    else{
        $req_balade = $bdd->query('SELECT id_balade, nom, theme, description FROM balade WHERE status = \'en_attente\'');   
    }
    
    $listpoints = array();
    while ($data = $req_balade->fetch()) {
        $req_points = $bdd->prepare('SELECT id_point, p.nom, latitude, longitude, p.description FROM point as p, balade as b, contenu_parcours as c WHERE/* b.status = \' accepte\' and*/ p.id_point=c.id_p and b.id_balade=c.id_b and b.id_balade = :id_balade');
        $req_points->execute(array(
            'id_balade' => $data['id_balade']));
        while ($data_1 = $req_points->fetch()) {
            $listpoints[] = array('id' => $data_1['id_point'], 'name' => $data_1['nom'], 'lat' => $data_1['latitude'], 'lon' => $data_1['longitude']);
        }
        $req_points->closeCursor();
        $listbalades[] = array('id' => $data['id_balade'], 'name' => $data['nom'], 'theme' => $data['theme'], 'txt' => $data['description'], 'points' => $listpoints);
    }
    $req_balade->closeCursor(); 
    //echo json_encode($list);
    //return json_encode($list);


    echo json_encode($listbalades); //$list;
?>
