<!DOCTYPE html>
<html>
<head>
	<title>Twitter academie - Connection</title>
    <script src="../Scripts/jquery.min.js" type="text/javascript"></script>
    <script src="../Scripts/fontawesome.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../Styles/style_connection_view.css">
	<?php include_once '../Backends/back_connection.php';
	$a = new user_connection; ?>
</head>
<body>
	<div id="connection_container" class="col-md-4 col-md-offset-4">
		<p>
			<h1>Se connecter à Twitter</h1>
		</p>
		<hr/>
		<form id="connexion_formulaire" method="post" action="">
			<p>
				<img src="../Miscs/twitter_logo_formulaire.png" alt="logo_twitter"/>
			</p>
			<p>
				<input class="input_for_width_100" type="text" name="connection_user_email" placeholder="email ou pseudo"/>
			</p>
			<p>
				<input class="input_for_width_100" type="password" name="connection_user_password" placeholder="Mot de passe"/>
			</p>
			<p>
				<input type="submit" value="Connexion"/>
			</p>
				<?php echo $a->message;?>
		</form>
		<hr/>
		<p>
			vous n'avez pas de compte ? <a href="../index.php">S'inscire</a>
		</p>
	</div>
</body>
</html>