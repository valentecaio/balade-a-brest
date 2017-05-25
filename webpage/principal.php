<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Balades</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel='stylesheet' type='text/css' href="principal.css">
		
		<script src="jquery.min.js"></script>
		<script src="bootstrap.min.js"></script>
		<script src="OpenLayers.js"></script>
		<script src='markers.js' style="padding-top: 20px" ></script>
		<script src='principal.js' style="padding-top: 20px" ></script>
	</head>
	
	<body>
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>                        
					</button>
					<a class="navbar-brand" href="initial.html">WB</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">
						<li class="active"><a href="#">Balades</a></li>
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Suggestions
							<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#">Parcours</a></li>
								<li><a href="#">Ajouts</a></li>
							</ul>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="contact.html"><span class="glyphicon glyphicon-earphone "></span> Contact</a></li>
						<?php 
						if(isset($_SESSION['id_usager'])){?>
							<li><a href="logout_script.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
							<?php echo isset($_SESSION['id_usager']);
						}else{ ?>
							<li><a href="login_s4.html"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
						<?php } ?>
					</ul>
				</div>
			</nav>
			
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-4">
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#point-interet" style="color: black"><b>Points d'interêt</b></a></li>
							<li><a data-toggle="tab" href="#balade" style="color: black"><b>Balades</b></a></li>
						</ul>
						
						<div class="tab-content">
							<div id="point-interet" class="tab-pane fade in active">
								<div class="container-fluid">
									<div class="row list-group" id="points_list"></div>
									<div class="btn-group" style="width:100%">
										<a href="createPoint.html"><button style="width:100%;height: 40px; text-align: left; color: black" class="btn btn-default"><b>Ajouter point d'interêt</b><span class="glyphicon glyphicon-plus pull-right" style="color: black"></span></button></a>
									</div>
									<!-- Modal -->
									<div class="modal fade" id="modalEdition" role="dialog">
									    <div class="modal-dialog">
									    	<!-- Modal content-->
									      	<div class="modal-content">
										        <div class="modal-header">
										        	<button type="button" class="close" data-dismiss="modal">&times;</button>
										        	<h4 class="modal-title">Édition</h4>
										        </div>
										        <div class="modal-body" id="modalText"></div>
										        <h3>paadlanfanfaf</h3>
										        <script type="text/javascript">	
													document.getElementById("modalText").innerHTML = sessionStorage.getItem("modalText");
												</script>
										        <div class="modal-footer">
										        	<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
										        </div>
									      </div>
									    </div>
									</div>		
								</div>
							</div>
							<div id="balade" class="tab-pane fade">
								<div class="container-fluid">
									<div class="row list-group" id="balades_list"></div>
									<div class="btn-group" style="width:100%">
										<button style="width:100%;height: 40px; text-align: left; color: black" class="btn btn-default"><b>Ajouter balade</b><span class="glyphicon glyphicon-plus pull-right" style="color: black"></span></button>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-sm-8">
						<div style="width:100%; height:550px" id='mapdiv' class="map"></div>
					</div>
				</div>
			</div>
			<script type="text/javascript">
				// global variables
				var map, points, balades;

				main();
			</script>
		</body>
	</html>