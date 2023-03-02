<?php 
  session_start();

  if (isset($_SESSION['username'])) {
  	# database connection file
  	include 'app/db.conn.php';
    #if do not have unblock id from origin taget return to home page
  	if (!isset($_GET['id'])) {
  		header("Location: home.php");
  		exit;
  	}
      # Getting user data and taget data
      $taget_id = $_GET["id"];
      $user_id = $_SESSION['user_id'];
      #update relationship between user and taget user to unblock and return to home page
      $unblock = "DELETE FROM block_user WHERE block_user.user_1 = $user_id AND block_user.user_2 = $taget_id";
      $result_user = $conn->query($unblock);
      header("Location: home.php");
  }
?>