<?php 
	session_start();
	include 'js_pageBalade.php';
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Create Balade</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel='stylesheet' type='text/css' href="style_pageMain.css">
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

	<body onload="main();">
		<?php include 'navigationBar.php';	?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-4">
					<form class="form-horizontal" enctype="multipart/form-data" id="form_balade" action="" method="post">
  						<div class="form-group">
    						<label class="control-label col-sm-3" for="form_name" style="text-align: right;">Nom:</label>
    						<div class="col-sm-9">
      							<input type="text" class="form-control" name="form_name" id="form_name" placeholder="Entrez le nom de la nouvelle balade ">
							</div>
						</div>
  						<div class="form-group">
    						<label class="control-label col-sm-3" for="form_theme" style="text-align: right;">Thème:</label>
    						<div class="col-sm-9">
      							<input type="text" class="form-control" name="form_theme" id="form_theme" placeholder="Entrez le thème de la nouvelle balade ">
							</div>
						</div>
						<div class="form-group">
	  						<label class="control-label col-sm-3" for="form_comment" style="text-align: right;">Description:</label>
	  						<div class="col-sm-9">
	  							<textarea class="form-control" rows="5" name="form_comment" id="form_comment" placeholder="Donnez une description de la nouvelle balade"></textarea>
							</div>
						</div>
						<div class="form-group">
	  						<label class="control-label col-sm-3" for="form_list" style="text-align: right;"></label>
	  						<div class="col-sm-9">
	  							<input type="hidden" class="form-control" name="form_list" id="form_list">
							</div>
						</div>
						<div class="form-group" id="points_list"></div>
						<div class="row">
							<div class="container-fluid">
								<button id="delete_button" type="submit" class="btn btn-default" style="color: red" onclick="button_action('query_delete_balade.php')">Supprimer</button>
								<div class="pull-right">
									<button type="button" class="btn btn-default" onclick="location.href = 'pageMain.php';">Annuler</button>
									<button id="send_button" type="submit" class="btn" name="submit"></button>
								</div>
							</div>
						</div>
					</form>
			    		<!-- Modal -->
						<div class="modal fade" id="sendModal" role="dialog">
						    <div class="modal-dialog">
						    	<!-- Modal content-->
						      	<div class="modal-content">
							        <div class="modal-header">
							        	<button type="button" class="close" data-dismiss="modal">&times;</button>
							        	<h4 class="modal-title">Message enregistré</h4>
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
					<div class="col-sm-8">
						<div style="width:100%; height:550px" id='mapdiv'></div>
					</div>
			</div>
		</div>
	</body>
</html>