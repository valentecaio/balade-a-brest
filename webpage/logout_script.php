<?php 
session_start();

// Suppression des variables de session et de la session
$_SESSION = array();
session_destroy();
header ('Location: initial.html');

// Suppression des cookies de connexion automatique
//setcookie('login', '');
//setcookie('pass_hache', '');

?>