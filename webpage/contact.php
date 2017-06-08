<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Contact</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel='stylesheet' type='text/css' href="contact.css">
		<script src="lib/jquery.min.js"></script>
		<script src="lib/bootstrap.min.js"></script>
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
					<a class="navbar-brand" href="initial.php">WB</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">
						<li><a href="principal.php">Balades</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="active"><a href=""><span class="glyphicon glyphicon-earphone "></span> Contact</a></li>
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
			</div>
		</nav>
		
		<div class="container-fluid">
			
			
		</div>
	</body>
</html>