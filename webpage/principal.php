<?php 
	session_start();
	include 'principalJS.php';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Balades</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel='stylesheet' type='text/css' href="principal.css">
		<script src="lib/jquery.min.js"></script>
		<script src="lib/bootstrap.min.js"></script>
		<script src="lib/OpenLayers.js"></script>
		<script src='markers.js'></script>
		<script src="validateFormModUser.js"></script>
	</head>
	
	<?php
	if (!empty($_SESSION['error'])){
        echo '<script type="text/javascript">alert("'.$_SESSION['error'].'");</script>';
        //echo $_SESSION['error'];
        unset($_SESSION['error']);
    }
    if(isset($_GET['modal'])){ ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#myModal').modal('show');
			});
		</script>
	<?php } ?>
	<body onload="main();">
		<?php include 'navigationBar.html';	?>
		<link rel="import" href="navigationBar.html">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-4">
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#balade" style="color: black"><b>Balades</b></a></li>
							<li><a data-toggle="tab" href="#point-interet" style="color: black"><b>Points d'interêt</b></a></li>
						</ul>
						
						<div class="tab-content">
							<div id="balade" class="tab-pane fade in active">
								<div class="container-fluid">
									<div class="row list-group" id="balades_list"></div>

									<?php
										if(isset($_SESSION['id_usager'])){ ?>
											<div class="btn-group" style="width:100%">
												<a href="createBalade.php"><button style="width:100%;height: 40px; text-align: left; color: black" class="btn btn-default"><b>Ajouter balade</b><span class="glyphicon glyphicon-plus pull-right" style="color: black"></span></button></a>
											</div>
									<?php } ?>

								</div>
							</div>
							<div id="point-interet" class="tab-pane fade">
								<div class="container-fluid">
									<div class="row list-group" id="points_list"></div>
									
									<?php
										if(isset($_SESSION['id_usager'])){ ?>
											<div class="btn-group" style="width:100%">
												<a href="createPoint.php"><button style="width:100%;height: 40px; text-align: left; color: black" class="btn btn-default"><b>Ajouter point d'interêt</b><span class="glyphicon glyphicon-plus pull-right" style="color: black"></span></button></a>
											</div>		
									<?php } ?>

								</div>
							</div>
						</div>
					</div>
					
					<div class="col-sm-8">
						<div style="width:100%; height:550px" id='mapdiv' class="map"></div>
					</div>
				</div>
			</div>
		</body>
	</html>
