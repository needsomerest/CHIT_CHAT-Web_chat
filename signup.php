<?php
#open and read session
session_start();
#If can't read 'username' in session (when user do not logged in)
if (!isset($_SESSION['username'])) {
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<!-- header of sign up web page -->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Sign Up | CHIT CHAT</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
		<link rel="stylesheet" href="css/style.css">
		<link rel="icon" href="img/chit-chat-logo.png">
	</head>

	<style>
		body {
			background-color: #DFFFF4;
		}

		.form-label {
			border-radius: 100px;
		}
	</style>

	<!-- Sign Up form for validate and collecting user information To use to register 
	with your name, username, password, profile picture, Secret Question and answer 
	for question when you forget password. -->

	<!-- Design UI for signup. -->
	<body class="d-flex justify-content-center align-items-center vh-90">
		<div class="w-400 mt-5 mb-5 p-5 shadow rounded" style="background-color: #FFFFFF; border-radius: 1000px;">
			<form method="post" action="app/http/signup.php" enctype="multipart/form-data">
				<div class="d-flex justify-content-center align-items-center flex-column">
					<img src="img/chit-chat-logo.png" class="w-25">
					<h3 class="display-4 fs-1 text-center" style="font-size: 10px;"> Sign Up</h3>
				</div>
				<?php if (isset($_GET['error'])) { ?>
					<div class="alert alert-warning" role="alert">
						<?php echo htmlspecialchars($_GET['error']); ?>
					</div>
				<?php }
				#Insert the data filled in the form to Database.
				if (isset($_GET['name'])) {
					$name = $_GET['name'];
				} else $name = '';
				if (isset($_GET['username'])) {
					$username = $_GET['username'];
				} else $username = '';
				?>

				<!--Insert Name Form-->
				<div class="mb-3">
					<label class="form-label">Name</label>
					<input type="text" name="name" required="required" value="<?= $name ?>" class="form-control">
				</div>
				<!--Userame From-->
				<div class="mb-3">
					<label class="form-label">Username</label>
					<input type="text" required="required" class="form-control" value="<?= $username ?>" name="username">
				</div>
				<!--Password From-->
				<div class="mb-3">
					<label class="form-label"> Password</label>
					<input type="password" required="required" class="form-control" name="password">
				</div>
				<!--Profile Picture From-->
				<div class="mb-3">
					<label class="form-label"> Profile Picture</label>
					<input type="file" class="form-control" name="pp">
					<br></br>
					<b><strong>Security Question And Answer</strong></b>
				</div>
				<!--Secret Question From-->
				<div class="mb-3"><label class="form-label">Secret Question</label>
					<input type="text" required="required" class="form-control" name="question">
				</div>
				<!--Answer From-->
				<div class="mb-3">
					<label class="form-label">Answer</label>
					<input type="text" required="required" class="form-control" name="answer">
				</div>
				<!--Submit Botton-->
				<button type="submit" class="btn btn-dark" style="border-radius: 100px;">Sign Up</button>
				<a href="index.php" style="color: #0E8359; font-size: 18px;">Login</a>
			</form>
		</div>

	</body>

	</html>
<?php
} else { #If can read 'username' in session (when user logged in)
	header("Location: home.php");
	exit;
}
?>