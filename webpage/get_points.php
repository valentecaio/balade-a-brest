<?php
   
    // create example points
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=s4-projet50;charset=utf8', 'root', '');
    }catch(Exception $e){
        die('Erreur : '.$e->getMessage());
    }

    $req = $bdd->query('SELECT id_point, nom, latitude, longitude, description FROM point');
    
    $list = array();
    while ($data = $req->fetch()) {
        $list[] = array('id' => $data['id_point'], 'name' => $data['nom'], 'lon' => $data['longitude'], 'lat' => $data['latitude'], 'txt' => $data['description']);
        //echo array('id' => $data['id_point'], 'name' => $data['nom'], 'lon' => $data['longitude'], 'lat' => $data['latitude'], 'txt' => $data['description']);
        //echo $data['nom'] . ' appartient à ' . $data['id_point'] . '<br />';
    }
    $req->closeCursor(); 
    //echo json_encode($list);
    //return json_encode($list);
    echo json_encode($list); //$list;
    /*
// simulates loading balades from database
function get_all_balades() {
    // create example strolls (balades)
    var balades = [{
            name: 'balade1',
            points: [points[0], points[1], points[2], points[3]]
        }, {
            name: 'balade2',
            points: [points[0], points[1], points[4], points[5]]
        }, {
            name: 'balade3',
            points: [points[4], points[5], points[2], points[3]]
        }
    ]
    return balades;
}*/

//echo get_aceppted_points();

?>


