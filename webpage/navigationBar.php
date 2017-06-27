<script src="js_navigationBar.js"></script>
<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>                        
			</button>
			<a class="navbar-brand" href="pageInitial.php"><img src="./images/blue_marker2.png" height=100% width="30"></a>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
				<li id="nav_balades" class=""><a href="pageMain.php">Balades</a></li>
				<?php
					if(isset($_SESSION["id_usager"]) && (strcmp($_SESSION["permission"], "admin") == 0 )){ //if permission == "admin" the dropdown is shown ?>
					<li id="nav_suggestions" class=""><a href="pageSuggestions.php">Suggestions</a></li>
				<?php } ?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li id="nav_contact" class=""><a href="pageContact.php"><span class="glyphicon glyphicon-earphone "></span> Contact</a></li>
				<?php 
					if(isset($_SESSION["id_usager"])){?>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $_SESSION["prenom"]." ".$_SESSION["nom"]."  "?><span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a data-target="#myModal" data-toggle="modal" class="MainNavText" id="MainNavHelp" href="#myModal"><span class="glyphicon glyphicon-cog"></span>  Paramètres</a></li>
							<li><a href="session_logout.php"><span class="glyphicon glyphicon-log-out"></span>  Logout</a></li>
						</ul>
					</li>
					<?php }else{ ?>
					<li id="nav_login" class=""><a href="pageLogin.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
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
						<form class="form-horizontal" id="modif" action="query_edit_logged_user.php" method="post">
							<!--<div class="form-group">
								<label class="control-label col-sm-4" for="email">Email:</label>
								<label class="control-label col-sm-4" for="email"><?php echo $_SESSION["email"]?></label>
							</div>-->
							<div class="form-group">
								<label class="control-label col-sm-4" for="email">Email:</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" name="email" id="email" value=<?php echo $_SESSION["email"]?>>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4" for="name">Prénom:</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" name="name" id="name" value=<?php echo $_SESSION["prenom"]?>>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4" for="surname">Nom:</label>
								<div class="col-sm-7"> 
									<input type="text" class="form-control" name="surname" id="surname" value=<?php echo $_SESSION["nom"]?>>
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
							<input type="hidden" name="url" id="url" value="pageMain.php">
						</form>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" onClick="validateFormModUser()">Submit</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</nav>