<?php 
  session_start();

  if (isset($_SESSION['username'])) {
  	# database connection file
  	include 'app/db.conn.php';

  	if (!isset($_GET['user'])) { # check if the user is not logged in
  		header("Location: home.php");
  		exit;
  	}
      # Getting User data data
      $taget_id = $_GET['user'];
      $user_id = $_SESSION['user_id'];
      #update friend request between user and taget user and return to add friend page
      $friend_query = "INSERT INTO friend_user (user_1,user_2,friend_user.status)VALUE ($user_id,$taget_id,0)";
      $result_friend = $conn->query($friend_query);
      header("Location: addfriend.php");
  }
?>