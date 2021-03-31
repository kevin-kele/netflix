<?php

session_start();
require('src/connexion.php');

if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_two'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];
	$password_confirm = $_POST['password_two'];
};

// Verification de l'email dans la base de donner
$req = $bdd->prepare("SELECT COUNT(*) as numberEmail FROM user where  email=?");
$req->execute(array($email));
while ($email_verif = $req->fetch()) {
	if ($email_verif['numberEmail'] != 0) {
		$check = false;
		header('location:./?error=true&message=l\'email entre est deja utiliser');
	}
}

?>


<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Netflix</title>
	<link rel="stylesheet" type="text/css" href="design/default.css">
	<link rel="icon" type="image/pngn" href="img/favicon.png">
</head>

<body>

	<?php include('src/header.php'); ?>

	<section>
		<div id="login-body">
			<h1>S'inscrire</h1>

			<form method="post" action="inscription.php">
				<input type="email" name="email" placeholder="Votre adresse email" required />
				<input type="password" name="password" placeholder="Mot de passe" required />
				<input type="password" name="password_two" placeholder="Retapez votre mot de passe" required />
				<button type="submit">S'inscrire</button>
			</form>

			<p class="grey">Déjà sur Netflix ? <a href="index.php">Connectez-vous</a>.</p>
		</div>
	</section>

	<?php include('src/footer.php'); ?>
</body>

</html>