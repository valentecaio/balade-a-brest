<?php
	session_start();
	include 'createBaladeJS.php';
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Create Balade</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="jquery.min.js"></script>
  		<script src="bootstrap.min.js"></script>
		<link rel='stylesheet' type='text/css' href="principal.css">
		<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
		<script src="markersBalade.js"></script>
		<script src='database_simulator.js'></script>
	</head>
	
	<body onload="main();">
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
						        	<form class="form-horizontal" action="modSettings.php" method="POST">
							        	<div class="form-group">
										    <label class="control-label col-sm-4" for="email">Email:</label>
										    <label class="control-label col-sm-4" for="email"><?php echo $_SESSION['email']?></label>
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
										    <label class="control-label col-sm-4" for="password">Mot de passe:</label>
										    <div class="col-sm-7"> 
										      	<input type="password" class="form-control" id="password">
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
									</form>
						        <div class="modal-footer">
						        	<button type="button" class="btn btn-default" data-dismiss="modal">Submit</button>
						        </div>
					      </div>
					    </div>
					</div>
				</div>
			</nav>
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