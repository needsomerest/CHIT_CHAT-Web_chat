<?php 
  session_start();
?>
<!-- Verify username for access account -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css">
	<link rel="icon" href="img/chit-chat-logo.png">
		 
</head>
<body class="d-flex
             justify-content-center
             align-items-center
             vh-100">
	 <div class="w-400 p-5 shadow rounded" style="background-color: #FFFFFF;">
	 	<form method="post" 
	 	      action="resetpassword.php">
	 		<div class="d-flex
	 		            justify-content-center
	 		            align-items-center
	 		            flex-column">

	 		<img src="img/chit-chat-logo.png" class="w-50">
	 		<h3 class="display-4 fs-1 text-center">
	 			       RESET PASSWORD</h3>   
	 	</div>
			
		 <!-- Userame form for reset password -->
            <div class="mb-3">
		    <label class="form-label">
		           User name</label>
		    <input type="text" required="required"
		           class="form-control"
		           name="usernameforget">
		  </div>

	     	<!-- submit -->
		  <button type="submit" 
		  class="btn btn-dark" style="border-radius: 100px;">
		          NEXT</button>
			<!-- back to Login page-->	  
          <a href="index.php" style="color: #0E8359; font-size: 18px;">Login</a>        
		</form>
	 </div>
</body>
<style>
body {
    background-color: #DFFFF4;
}


</style>
</html>
