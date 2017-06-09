<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
	<?php
	if (isset($_SESSION['id_usager'])){
		header('Location: principal.php');
		exit();
    }else if (!empty($_SESSION['error'])){
        echo '<script type="text/javascript">alert("'.$_SESSION['error'].'");</script>';
        //echo $_SESSION['error'];
        //unset($_SESSION['error']);
        session_destroy();
        session_start();
    } ?>

	<script type="text/javascript">
		function ValidateForm(){
		    if (document.getElementById("signup").inscriptionPassword.value != document.getElementById("signup").inscriptionPasswordCheck.value) {
		        alert("Les deux mots de passe doivent être égaux");
		        document.getElementById("signup").inscriptionPassword.focus();
		        return;
		    }
		    //alert("OK");
		    document.getElementById("signup").submit();
		}
	</script>

	<head>
		<title>Login</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel='stylesheet' type='text/css' href="login_s4.css">
		<script src="lib/jquery.min.js"></script>
		<script src="lib/bootstrap.min.js"></script>
	</head>
	<body>
		<?php include 'navigationBar.php';	?>
		<script type="text/javascript">
			document.getElementById("nav_login").setAttribute('class', "active");
		</script>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-6">
		
					<form class="form-signin" id="signin" action="login_script.php" method="post">
						<h2 class="form-signin-heading">Se connecter</h2>
						<label for="inputEmail" class="sr-only">Addresse e-mail</label>
						<input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="Addresse e-mail" required autofocus>
						<label for="inputPassword" class="sr-only">Mot de passe</label>
						<input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Mot de passe">
						<div class="checkbox">
							<label>
								<input type="checkbox" value="remember-me"><b>Se souvenir de moi</b>
							</label>
						</div>
						<button class="btn btn-lg btn-primary btn-block" type="submit">Connexion</button>
					</form>
				</div>
				

   				<div class="col-sm-6">
					<form class="form-signin" id="signup" action="signup_script.php" method="post">
						<h2 class="form-signin-heading">Inscription</h2>
						<label for="inscriptionName" class="sr-only">Prénom</label>
						<input type="text" name="inscriptionName" id="inscriptionName" class="form-control" placeholder="Prénom" required>
						<label for="inscriptionSurname" class="sr-only">Nom</label>
						<input type="text" name="inscriptionSurname" id="inscriptionSurname" class="form-control" placeholder="Nom" required>
						<label for="inscriptionEmail" class="sr-only">Addresse e-mail</label>
						<input type="email" name="inscriptionEmail" id="inscriptionEmail" class="form-control" placeholder="Addresse e-mail" required>
						<label for="inscriptionPassword" class="sr-only">Mot de passe</label>
						<input type="password" name="inscriptionPassword" id="inscriptionPassword" class="form-control" placeholder="Nouveau mot de passe" required>
						<label for="inscriptionPasswordCheck" class="sr-only">Vérifier Mot de passe</label>
						<input type="password" name="inscriptionPasswordCheck" id="inscriptionPasswordCheck" class="form-control" placeholder="Retapez le mot de passe" required>
						<button class="btn btn-lg btn-primary btn-block" type="button" onClick="ValidateForm()">Inscription</button>
					</form>
				</div>			
		</div>		
	</body>
</html>
