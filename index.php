<!DOCTYPE html>
<html>
<head>
	<title>S'inscrire sur Twitter</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="Styles/style_inscription_view.css">
	<?php 
	include("Backends/back_inscription.php");
	$user = new user_inscription;
	?>
	</head>
<body>
<div id="nav_inscription">
		<p><img src="Miscs/twitter_logo_inscription.png" alt="logo_twitter"></p>
		<p>Vous avez déjà un compte ?<a href="Views/connection_view.php""> Connexion</a></p>
</div>

<div style="display: flex;">	
	<div id="inscription_container" class="col-md-4 col-md-offset-4">
		<p>
			<h1>Rejoignez Twitter <br/> aujourd'hui.</h1>
		</p>
			<form id="inscription_formulaire" method="post" action="">
			<p>
       			 <input type="text" name="nom_inscription" class="form-control" placeholder="Nom complet" required="">
			</p>
			<p>
       			 <input type="email" name="email_inscription" class="form-control" placeholder="Email" required="">
			</p>
			<p>
       			<input type="password" name="password_inscription" class="form-control" placeholder="Mot de passe" required="">
			</p>
			<?php echo $user->message;?>
			<p>
				<input type="submit" value="S'inscrire"/>
			</p>
			</form>
		<p class="condition_utilisation">
			En vous inscrivant, vous acceptez les Conditions d'utilisation et la Politique de confidentialité, notamment l'utilisation de cookies. D'autres utilisateurs pourront vous trouver grâce à votre email ou votre numéro de téléphone s'ils sont renseignés.
		</p>
	</div>
</div>
</body>
</html>
