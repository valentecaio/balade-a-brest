<?php 
	session_start();
	include 'js_pagePoint.php';
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Balade à Brest</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel='stylesheet' type='text/css' href="style_pageMain.css">
		<link rel="shortcut icon" type="image/x-icon" href="./images/blue_marker2.png">
	</head>
	
	<?php
		if (!empty($_SESSION['error'])){
			echo '<script type="text/javascript">alert("'.$_SESSION['error'].'");</script>';
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
		<?php include 'navigationBar.php';	?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-4">
					<form class="form-horizontal" enctype="multipart/form-data" id="form_point" action="" method="post">
						<div class="form-group">
    						<div class="col-sm-9">
      							<input type="hidden" class="form-control" name="form_id" id="form_id">
							</div>
						</div>
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
	  							<textarea type="text" class="form-control" rows="5" name="form_comment" id="form_comment" placeholder="Donnez une description du point"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3" for="form_media" style="text-align: right;">Télécharger média:</label>
							<div class="col-sm-8">
   								<input id="file_upload" name="file_upload" type="file">
							</div>
						</div>
						<div class="container-fluid">
							<p><b>Medias :</b></p>
							<div class="row list-group" id="points_list"></div>
						</div>
						
						<div class="row">
							<div class="container-fluid">
								<button id="delete_button" type="submit" class="btn btn-default" style="color: red" onclick="onClickSendButton('query_delete_point.php')">Supprimer</button>
								<div class="pull-right">
			    					<button type="button" class="btn btn-default" onclick="location.href = 'pageMain.php';">Annuler</button>
				    				<button id="send_button" type="submit" class="btn" name="submit"></button>
			    				</div>	
							</div>
						</div>
					</form>
					
			  		<div class="row"> 
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
							        	<h4 >Votre message sera analisé par le gestionnaire du site.</h4>
									</div>
							        <div class="modal-footer">
							        	<button type="button" class="btn btn-default" onclick="location.href = 'pageMain.php';">OK</button>
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