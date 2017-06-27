<?php
   
    // create example points
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=s4-projet50;charset=utf8', 'root', '');
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
        $req_points = $bdd->query('SELECT id_point, nom, latitude, longitude, description FROM point as p, balade as b, contenu_parcours as c WHERE p.status = \' accepte\' and p.id_point=c.id_p and b.id_balade=c.id_b and b.id_b='.$data['id_balade']);
        while ($data_1= $req_points->fetch()) {
            $listpoints[] = array('id' => $data_1['id_point'], 'name' => $data_1['nom'], 'latitude' => $data_1['latitude'], 'longitude' => $data_1['longitude']);
        }
        $req_points->closeCursor();
        $listbalades[] = array('id' => $data['id_balade'], 'name' => $data['nom'], 'theme' => $data['theme'], 'txt' => $data['description'], 'list' => $listpoints);
    }
    $req_balade->closeCursor(); 
    //echo json_encode($list);
    //return json_encode($list);


    echo json_encode($listbalades); //$list;
?>


