<?php 
	session_start();
	include 'js_pageSuggestions.php';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Balades</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel='stylesheet' type='text/css' href="principal.css">
	</head>
	
	<?php
		if (!empty($_SESSION['error'])){
			echo '<script type="text/javascript">alert("'.$_SESSION['error'].'");</script>';
			//echo $_SESSION['error'];
			unset($_SESSION['error']);
		} ?>
	<body onload='main();'>
		<?php include 'navigationBar.php';	?>
		<script type="text/javascript">
			document.getElementById("nav_suggestions").setAttribute('class', "active");
		</script>
		<div class="container-fluid">
			<div class="row">
				<div class="container-fluid">
					<div class="col-sm-6">
						<h4><b>Points d'interêt en attente d'approvation</b></h4>
						<div class="col-sm-10">
							<div class="row list-group" id="list_points"></div>
						</div>
					</div>
					<div class="col-sm-6">
						<h4><b>Balades en attente d'approvation</b></h4>
						<div class="row list-group" id="list_balades"></div>
					</div>
				</div>
	</body>
	
</html>