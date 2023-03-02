<?php
session_start();
?>

<!-- Verify user identity for reset password -->
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Chat App - Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css">
	<link rel="icon" href="img/chit-chat-logo.png">

</head>

<body class="d-flex
             justify-content-center
             align-items-center
             vh-100">
	<div class="w-400 p-5 shadow rounded" style="background-color: #FFFFFF;">
		<?php
		include 'app/db.conn.php';
		$usernameforget  = $_POST['usernameforget'];
		$_SESSION['usernameforget'] = $usernameforget;
		$sql = "SELECT * FROM users WHERE username=?";
		$stmt = $conn->prepare($sql);
		$stmt->execute([$usernameforget]);

		# found account
		if ($stmt->rowCount() > 0) {
			$users = $stmt->fetchAll();
			foreach ($users as $user) {
		?>
				<form method="post" action="confirm_resetpass.php">
					<div class="d-flex justify-content-center align-items-center flex-column">
						<img src="img/chit-chat-logo.png" class="w-50">
						<h3 class="display-4 fs-1 text-center">RESET PASSWORD</h3>
					</div>

					<!-- Security question form for Verify user identity -->
					<div class="mb-3">
						<b><strong>Question : <?php echo $user['question'] ?></strong></b>
						<br>
						<label class="form-label">Security answer</label>
						<input type="text" required="required" class="form-control" name="answer">
					</div>

					<div class="mb-3">
						<label class="form-label">New password</label>
						<input type="password" required="required" class="form-control" name="newpassword1">
					</div>

					<div class="mb-3">
						<label class="form-label">Input your new password again</label>
						<input type="password" required="required" class="form-control" name="newpassword2">
					</div>

					<button type="submit" class="btn btn-dark" style="border-radius: 100px;">SUBMIT</button>
					<a href="index.php" style="color: #0E8359; font-size: 18px;">Login</a>
				</form>
		<?php
			}
		}
		# not found account
		else {
			echo '<script>
			alert("Your username not found");
			window.location.href="index.php";
			</script>';
		}
		?>
	</div>
</body>
<style>
	body {
		background-color: #DFFFF4;
	}
</style>

</html>