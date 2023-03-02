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
      #delete relationship between user and taget user to unfriend and return to add friend page
      $unfriend = "DELETE FROM friend_user WHERE friend_user.user_2 = $user_id AND friend_user.user_1 = $taget_id";
      $unfriends = "DELETE FROM friend_user WHERE friend_user.user_1 = $user_id AND friend_user.user_2 = $taget_id";
      $result_user = $conn->query($unfriend);
      $result_user = $conn->query($unfriends);
      header("Location: addfriend.php");
  }
?>