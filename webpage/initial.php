<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<title>Initial</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel='stylesheet' type='text/css' href="initial.css">
		<script src="jquery.min.js"></script>
		<script src="bootstrap.min.js"></script>
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
<!--
	<script type="text/javascript">
		function ValidateFormModif(){
			var a = document.getElementById("modif").oldPassword.value;
			var b = document.getElementById("modif").newPassword.value;
			var c = document.getElementById("modif").confirmPassword.value;
		    if (b != c) {
		        alert("Les deux mots de passe doivent être égaux");
		        document.getElementById("modif").newPassword.focus();
		        return;
		    }else if((a == b) && (b != "")){
		    	alert("Le nouveau mot de passe doit être différent de l'actuel");
		        document.getElementById("modif").newPassword.focus();
		        return;
		    }
		    document.getElementById("modif").submit();
		}
	</script>
-->
	<body>
		
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>                        
					</button>
					<a class="navbar-brand" href="">WB</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
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
										    	<input type="text" class="form-control" name="name" id="name" value=<?php echo $_SESSION['prenom']?>>
										    </div>
										</div>
										<div class="form-group">
										    <label class="control-label col-sm-4" for="surname">Nom:</label>
										    <div class="col-sm-7"> 
										      	<input type="text" class="form-control" name="surname" id="surname" value=<?php echo $_SESSION['nom']?>>
										    </div>
										</div>
										<div class="form-group">
										    <label class="control-label col-sm-4" for="oldPassword">Mot de passe:</label>
										    <div class="col-sm-7"> 
										      	<input type="password" class="form-control" name="oldPassword" id="oldPassword">
										    </div>
										</div>
										<div class="form-group">
										    <label class="control-label col-sm-4" for="newPassword">Nouveau mot de passe:</label>
										    <div class="col-sm-7"> 
										      	<input type="password" class="form-control" name="newPassword" id="newPassword">
										    </div>
										</div>
										<div class="form-group">
										    <label class="control-label col-sm-4" for="confirmPassword">Confirmer mot de passe:</label>
										    <div class="col-sm-7"> 
									      		<input type="password" class="form-control" name="confirmPassword" id="confirmPassword">
										    </div>
										</div>
										<input type="hidden" name="url" id="url" value="initial.php">
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
				<div class="wb">
					<h1>Walk in Brest</h1>
					<p class="lead">L'objectif du projet est de fournir aux élèves du dispositif relais<br>un système qui leur permettra de s'impliquer dans un projet d'une<br> application de balade en réalité augmentée à Brest.</p>
					<p><a href="principal.php" class="btn btn-default" role="button">Essayer</a></p>
				</div>
			</div>
			
		</body>
	</html>