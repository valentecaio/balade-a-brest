<?php 
	session_start();
	include 'pagePointJS.php';
?>
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
		<script src="markers.js"></script>
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
	
	<body onload='main();'>
		<?php include 'navigationBar.html';	?>
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
					<div style="width: 100%; height: 550px"  id="mapdiv" ></div>
				</div>
			</div>
		</div>
		
	</body>
	
</html>