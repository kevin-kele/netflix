<?php

session_start();


if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_two'])) {
	require('src/connexion.php');
	// variables

	$email = htmlspecialchars($_POST['email']);
	$password = htmlspecialchars($_POST['password']);
	$password_confirm = htmlspecialchars($_POST['password_two']);
	$check = true;





	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header('location: inscription.php?error=1&message=Votre adresse email est invalide.');
		$check = false;
	}


	// Verification de l'email dans la base de donner
	$req = $bdd->prepare("SELECT COUNT(*) as numberEmail FROM user where  email=?");
	$req->execute(array($email));
	while ($email_verif = $req->fetch()) {
		if ($email_verif['numberEmail'] != 0) {
			$check = false;
			header('location:inscription.php?error=true&message=l\'email entre est deja utiliser');
		}
	}



	if ($check == true) {

		// Hash cle unique a chaque user (secret)
		$secret = sha1($email) . time();
		$secret = sha1($secret) . time() . time();

		// verification du password
		if ($password != $password_confirm) {
			header('location:inscription.php?error=true&message=Password non identique');
			exit();
		} else {

			// Cryptage du password Securisation du mot de passe
			$password = "kev" . sha1($password . "9875") . "2565";

			// envoie de la valeur 
			$req = $bdd->prepare("INSERT INTO user (email ,password,secret) VALUES (?,?,?)");
			$req->execute(array($email, $password, $secret));
			header('location:inscription.php?sucess=1&message=Inscription reussis !');
		}
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
			<?php
			if (isset($_GET['error'])) {
				if (isset($_GET['message'])) {
					echo '<div class="alert error">' . htmlspecialchars($_GET['message']) . '</div>';
				}
			} else if (isset($_GET['sucess'])) {
				if (isset($_GET['message'])) {
					echo '<div class="alert success">' . htmlspecialchars($_GET['message']) . '</div>';
				}
			} {
			}
			?>
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