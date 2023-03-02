<?php
session_start();

if (!isset($_SESSION['username'])) {
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Login | CHIT CHAT</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
		<link rel="stylesheet" href="css/style.css">
		<link rel="icon" href="img/chit-chat-logo.png">
	</head>
<!-- Login form for validate and collecting user information To use to login 
	with your username, password -->
	
	<!-- Design UI for login. -->
	<body class="d-flex justify-content-center align-items-center vh-100">
		<div class="w-400 p-5 shadow rounded" style="background-color: #FFFFFF;">
			<form method="post" action="app/http/auth.php">
				<div class="d-flex justify-content-center align-items-center flex-column">

					<img src="img/chit-chat-logo.png" class="w-50">
					<h3 class="display-4 fs-1 text-center">
						LOGIN</h3>


				</div>
				<?php if (isset($_GET['error'])) { ?>
					<div class="alert alert-warning" role="alert">
						<?php echo htmlspecialchars($_GET['error']); ?>
					</div>
				<?php } ?>

				<?php if (isset($_GET['success'])) { ?>
					<div class="alert alert-success" role="alert">
						<?php echo htmlspecialchars($_GET['success']); ?>
					</div>
				<?php } ?>
				<!--Userame Form-->
				<div class="mb-3">
					<label class="form-label">
						User name</label>
					<input type="text" class="form-control" name="username">
				</div>
				<!--Password Form-->
				<div class="mb-3">
					<label class="form-label">
						Password</label>
					<input type="password" class="form-control" name="password">
					<a href="userresetpass.php" style="color: #0E8359; font-size: 15px;">Forget password ?</a>
				</div>
				<!--Login Botton-->
				<button type="submit" class="btn btn-dark" style="border-radius: 100px;">
					LOGIN</button>
				<a href="signup.php" style="color: #0E8359; font-size: 15px;">Sign Up</a>
			</form>
		</div>
	</body>
	<style>
		body {
			background-color: #DFFFF4;
		}
	</style>

	</html>
<?php
} else {
	header("Location: home.php");
	exit;
}
?>