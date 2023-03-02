<?php 
  session_start();

  if (isset($_SESSION['username'])) {
  	# database connection file
  	include 'app/db.conn.php';
    #if do not have friend id from origin taget return to home page
  	if (!isset($_GET['id'])) { 
  		header("Location: home.php");
  		exit;
  	}
      # Getting user data and taget data
      $taget_id = $_GET["id"];
      $user_id = $_SESSION['user_id'];
      #update relationship between user and taget user to be friend and return to add friend page
      $submit_friend = "UPDATE friend_user SET friend_user.status = 1 WHERE friend_user.user_2 = $user_id AND friend_user.user_1 = $taget_id";
      $result_user = $conn->query($submit_friend);
      header("Location: addfriend.php");
  }
