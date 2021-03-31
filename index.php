<?php
session_start();

if (!empty($_POST['email']) && !empty($_POST['password'])) {
	require('src/connection.php');
	$email = $_POST['email'];
	$password = $_POST['password'];
	$check = false;


	$password = "kev" . sha1($password . "9875") . "2565";

	// Connexion
	$req = $bdd->prepare("SELECT * FROM user where  email=?");
	$req->execute(array($email));

	while ($user = $req->fetch()) {
		if ($user['email'] == $email && $user['password'] == $password) {
			$check = true;
			$_SESSION['connect'] = 1;
			$_SESSION['user'] = $user['email'];
			header('location:index.php?email=valide et password valide');
		}
	}
	if ($check == false) {
		header('location:./?error=1');
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
			<h1>S'identifier</h1>
			<?php if (isset($_GET['error'])) {
				echo '<p id="error"> Authentification echouer </p>';
			} ?>
			<form method="post" action="index.php">
				<input type="email" name="email" placeholder="Votre adresse email" required />
				<input type="password" name="password" placeholder="Mot de passe" required />
				<button type="submit">S'identifier</button>
				<label id="option"><input type="checkbox" name="auto" checked />Se souvenir de moi</label>
			</form>


			<p class="grey">Première visite sur Netflix ? <a href="inscription.php">Inscrivez-vous</a>.</p>
		</div>
	</section>

	<?php include('src/footer.php'); ?>
</body>

</html>