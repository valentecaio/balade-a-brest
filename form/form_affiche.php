<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Inscription</title>
    </head>
    <style>
    form
    {
        text-align:center;
    }
    </style>
    <body>
    
    <form action="inscription.php" method="post">
        <p>
        <label for="prenom">Prenom</label> : <input type="text" name="prenom" id="prenom" /><br />
        <label for="nom">Nom</label> :  <input type="text" name="nom" id="nom" /><br />
        <label for="mot_de_passe">Mot de Passe</label> :  <input type="password" name="mot_de_passe" id="mot_de_passe" /><br />
        <label for="email">E-mail</label> :  <input type="email" name="email" id="email" /><br />

        <input type="submit" value="Envoyer" />
	</p>
    </form>

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

// Récupération des 10 derniers messages
$reponse = $bdd->query('SELECT id_usager, nom, prenom, date_inscription, email, permission FROM usagers ORDER BY id_usager DESC LIMIT 0, 10');

    echo "
    <table class='table'>
    <thead>
        <tr>";
    /* Get field information for all columns */
    while ($finfo = $response->fetch_field()) {
        echo "
        <th>" . $finfo->name . "</th>";
    }
    echo "
        </tr>
    </thead>
    <tbody>";
while($row = $result->fetch_assoc()){
   echo "<tr class='info'>
    <td>" . $row['id_usager'] . "</td> 
                <td>" . $row['nom'] . "</td>
                <td>" . $row['prenom'] . "</td>
                <td>" . $row['date_inscription'] . "</td>
                <td>" . $row['email'] . "</td>
                <td>" . $row['permission'] . "</td>
                <td> <button class='btn' >Edit</button> </td>
 </tr>"; 
        } 
        echo "
        </tbody>
    </table>";
        ?>

/*
// Affichage de chaque message (toutes les données sont protégées par htmlspecialchars)
while ($donnees = $reponse->fetch())
{
	echo '<p><strong>' . htmlspecialchars($donnees['prenom']) . ' ' . htmlspecialchars($donnees['nom']) . '</strong> : ' . htmlspecialchars($donnees['email']) . '; ' . htmlspecialchars($donnees['date_inscription']) . '; ' . htmlspecialchars($donnees['permission']) . '</p>';
}
*/
$reponse->closeCursor();

?>
    </body>
</html>