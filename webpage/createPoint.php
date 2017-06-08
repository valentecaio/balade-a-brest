<?php session_start(); ?>
<!DOCTYPE HTML>
<html>

	<head>
		<title>Create Point</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel='stylesheet' type='text/css' href="principal.css">
		<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
		<script src="lib/jquery.min.js"></script>
  		<script src="lib/bootstrap.min.js"></script>
		<script src="validateFormModUser.js"></script>
		<script>
			var map,markers,point_clicked;
			var zoom = 16;
			var curpos = new Array();
			
			var tanguy_tower = [48.383410, -4.496798]
			
			var fromProjection = new OpenLayers.Projection("EPSG:4326");   // Transform from WGS 1984
			var toProjection   = new OpenLayers.Projection("EPSG:900913"); // to Spherical Mercator Projection
			
			var cntrposition = new OpenLayers.LonLat(tanguy_tower[1], tanguy_tower[0]).transform( fromProjection, toProjection);
			
			function init()
			{
				map = new OpenLayers.Map("Map");
				markers = new OpenLayers.Layer.Markers("Markers");
				
				var mapnik = new OpenLayers.Layer.OSM("MAP"); 
				
				map.addLayers([mapnik,markers]);
				map.setCenter(cntrposition, zoom);
				
				var click = new OpenLayers.Control.Click();
				map.addControl(click);
				click.activate();
			};
			
			
			OpenLayers.Control.Click = OpenLayers.Class(OpenLayers.Control, {               
				defaultHandlerOptions: {
					'single': true,
					'double': false,
					'pixelTolerance': 0,
					'stopSingle': false,
					'stopDouble': false
				},
				
				initialize: function(options) {
					this.handlerOptions = OpenLayers.Util.extend(
					{}, this.defaultHandlerOptions
					);
					OpenLayers.Control.prototype.initialize.apply(
					this, arguments
					);
					this.handler = new OpenLayers.Handler.Click(
					this, {
						'click': this.trigger
					}, this.handlerOptions
					);
				},
				
				trigger: function(e) {
					// get point values
					var lonlat = map.getLonLatFromPixel(e.xy);
					point_clicked = new OpenLayers.LonLat(lonlat.lon,lonlat.lat).transform(toProjection,fromProjection);
					
					// remove old markers
					if(map.layers[1]){
						map.layers[1].clearMarkers()
					}
					
					// add marker to map
					var new_position = new OpenLayers.LonLat(point_clicked.lon, point_clicked.lat).transform(fromProjection, toProjection);
					markers.addMarker(new OpenLayers.Marker(new_position));
					
					// add point data to form boxes
					document.getElementById("form_latitude").value = point_clicked.lat
					document.getElementById("form_longitude").value = point_clicked.lon
				}
				
			});
		</script>
	</head>

	<?php
	if (!empty($_SESSION['error'])){
        echo '<script type="text/javascript">alert("'.$_SESSION['error'].'");</script>';
        //echo $_SESSION['error'];
        unset($_SESSION['error']);
    }
    if(isset($_GET['modal']) && $_GET['modal']==2){ ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#sendModal').modal('show');
			});
		</script>
	<?php 
	} else if(isset($_GET['modal']) && $_GET['modal']==1){ ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#myModal').modal('show');
			});
		</script>
	<?php } ?>
	
	<body onload='init();'>
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>                        
					</button>
					<a class="navbar-brand" href="initial.php">WB</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">
						<li><a href="principal.php">Balades</a></li>
						<li class="active"><a href="">Paramètres</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="contact.php"><span class="glyphicon glyphicon-earphone "></span> Contact</a></li>
						<?php 
						if(isset($_SESSION['id_usager'])){?>
							<li class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $_SESSION['prenom']." ".$_SESSION['nom']."  "?><span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a data-target="#myModal" data-toggle="modal" class="MainNavText" id="MainNavHelp" href="#myModal"><span class="glyphicon glyphicon-cog"></span>  Paramètres</a></li>
									<li><a href="logout_script.php"><span class="glyphicon glyphicon-log-out"></span>  Logout</a></li>
								</ul>
							</li>
						<?php }else{ ?>
							<li><a href="login_s4php.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
						<?php } ?>
					</ul>
					<!-- Modal -->
					<div class="modal fade" id="myModal" role="dialog">
					    <div class="modal-dialog">
					    	<!-- Modal content-->
					      	<div class="modal-content">
						        <div class="modal-header">
						        	<button type="button" class="close" data-dismiss="modal">&times;</button>
						        	<h4 class="modal-title">Modifier paramètres du compte</h4>
						        </div>
						        <div class="modal-body" id="modalText"></div>
						        	<form class="form-horizontal" id="modif" action="mod_settings.php" method="POST">
							        	<!--<div class="form-group">
										    <label class="control-label col-sm-4" for="email">Email:</label>
										    <label class="control-label col-sm-4" for="email"><?php echo $_SESSION['email']?></label>
										</div>-->
										<div class="form-group">
										    <label class="control-label col-sm-4" for="email">Email:</label>
										    <div class="col-sm-7">
										    	<input type="text" class="form-control" name="email" id="email" value=<?php echo $_SESSION['email']?>>
										    </div>
										</div>
										<div class="form-group">
										    <label class="control-label col-sm-4" for="name">Prénom:</label>
										    <div class="col-sm-7">
										    	<input type="text" class="form-control" id="name" value=<?php echo $_SESSION['prenom']?>>
										    </div>
										</div>
										<div class="form-group">
										    <label class="control-label col-sm-4" for="surname">Nom:</label>
										    <div class="col-sm-7"> 
										      	<input type="text" class="form-control" id="surname" value=<?php echo $_SESSION['nom']?>>
										    </div>
										</div>
										<div class="form-group">
										    <label class="control-label col-sm-4" for="oldPassword">Mot de passe:</label>
										    <div class="col-sm-7"> 
										      	<input type="password" class="form-control" id="oldPassword">
										    </div>
										</div>
										<div class="form-group">
										    <label class="control-label col-sm-4" for="newPassword">Nouveau mot de passe:</label>
										    <div class="col-sm-7"> 
										      	<input type="password" class="form-control" id="newPassword">
										    </div>
										</div>
										<div class="form-group">
										    <label class="control-label col-sm-4" for="confirmPassword">Confirmer mot de passe:</label>
										    <div class="col-sm-7"> 
									      		<input type="password" class="form-control" id="confirmPassword">
										    </div>
										</div>
										<input type="hidden" name="url" id="url" value="createPoint.php">
									</form>
						        <div class="modal-footer">
						        	<button type="button" class="btn btn-default" onClick="validateFormModUser()">Submit</button>
						        </div>
					      </div>
					    </div>
					</div>
				</div>
			</nav>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-4">
					<form class="form-horizontal" enctype="multipart/form-data" id="createp" action="insert_point.php" method="post">

  						<div class="form-group">
    						<label class="control-label col-sm-3" for="form_name" style="text-align: right;">Nom:</label>
    						<div class="col-sm-9">
      							<input type="text" class="form-control" name="form_name" id="form_name" placeholder="Entrez le nom du nouveau point" required>
    						</div>
  						</div>
  						<div class="form-group">
    						<label class="control-label col-sm-3" for="form_latitude" style="text-align: right;">Latitude:</label>
    						<div class="col-sm-9">
      							<input type="text" class="form-control" name="form_latitude" id="form_latitude">
    						</div>
  						</div>
  						<div class="form-group">
    						<label class="control-label col-sm-3" for="form_longitude" style="text-align: right;">Longitude:</label>
    						<div class="col-sm-9">
      							<input type="text" class="form-control" name="form_longitude" id="form_longitude">
    						</div>
  						</div>
  						<div class="form-group">
	  						<label class="control-label col-sm-3" for="form_comment" style="text-align: right;">Description:</label>
	  						<div class="col-sm-9">
	  							<textarea class="form-control" rows="5" id="form_comment" placeholder="Donnez une description du point"></textarea>
	  						</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3" for="form_longitude" style="text-align: right;">Télécharger média:</label>
							<div class="col-sm-8">
   								<input id="fileupload" name="myfile" type="file" />
   							</div>
   						</div>
   						<div class="col-sm-6 pull-right">
			    			<button type="submit" class="btn btn-default">Annuler</button>
			    			<!--<button type="submit" class="btn" data-toggle="modal" data-target="#sendModal">Envoyer</button>-->
			    			<button type="submit" class="btn">Envoyer</button>
			    		</div>
  					</form>
					
			  		<div class="row"> 
			    		<!--<div class="col-sm-6 pull-right">
			    			<button type="submit" class="btn btn-default">Supprimer</button>
			    			<button type="submit" class="btn" data-toggle="modal" data-target="#sendModal">Envoyer</button>
			    		</div>-->
			    		<!-- Modal -->
						<div class="modal fade" id="sendModal" role="dialog">
						    <div class="modal-dialog">
						    	<!-- Modal content-->
						      	<div class="modal-content">
							        <div class="modal-header">
							        	<button type="button" class="close" data-dismiss="modal">&times;</button>
							        	<h4 class="modal-title">Message enregistrée</h4>
							        </div>
							        <div class="modal-body">
							        	<h4 >Votre message sera annalisé par le gestionnaire du site.</h4>
							        </div>
							        <div class="modal-footer">
							        	<button type="button" class="btn btn-default" onclick="location.href = 'principal.php';">OK</button>
							        </div>
						      </div>
						    </div>
						</div>									      	
			    	</div>
			  	</div>
				<div class="col-sm-8">
					<div style="width: 100%; height: 550px"  id="Map" ></div>
				</div>
			</div>
		</div>
		
	</body>
	
</html>