<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Create Balade</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel='stylesheet' type='text/css' href="principal.css">
		<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
		<script src="lib/jquery.min.js"></script>
  		<script src="lib/bootstrap.min.js"></script>
		<script src="markers.js"></script>
		<script src='database_simulator.js'></script>
		<script src='createBalade.js'></script>
	</head>
	
	<body onload="main();">
		<?php include 'navigationBar.html';	?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-4">
					<form class="form-horizontal">
  						<div class="form-group">
    						<label class="control-label col-sm-3" for="form_name" style="text-align: right;">Nom:</label>
    						<div class="col-sm-9">
      							<input type="text" class="form-control" id="form_name" placeholder="Entrez le nom de la nouvelle balade ">
							</div>
						</div>
  						<div class="form-group">
    						<label class="control-label col-sm-3" for="form_name" style="text-align: right;">Thème:</label>
    						<div class="col-sm-9">
      							<input type="text" class="form-control" id="form_theme" placeholder="Entrez le thème de la nouvelle balade ">
							</div>
						</div>
					</form>
  					<div class="form-group">
  						<label for="comment">Description:</label>
  						<textarea class="form-control" rows="5" id="comment" placeholder="Donnez une description de la nouvelle balade"></textarea>
					</div>
					<div class="form-group" id="points_list"></div>
			  		<div class="row"> 
			    		<div class="col-sm-6 pull-right">
			    			<button type="submit" class="btn btn-default">Supprimer</button>
			    			<button type="submit" class="btn" data-toggle="modal" data-target="#sendModal">Envoyer</button>
						</div>
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
							        	<h4 >Votre message sera annalisée par le gestionnaire du site.</h4>
									</div>
							        <div class="modal-footer">
							        	<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
									</div>
								</div>
							</div>
						</div>							      	
					</div>
				</div>
				<div class="col-sm-8">
					<div style="width:100%; height:550px" id='mapdiv'></div>
				</div>
			</div>
		</div>
	</body>
	
</html>