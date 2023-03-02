<?php 
  session_start();

  if (isset($_SESSION['username'])) {
  	# database connection file
  	include 'app/db.conn.php';
    #if do not have friend id from origin taget return to home page
  	if (!isset($_GET['user'])) {
  		header("Location: home.php");
  		exit;
  	}
      # Getting user data and taget data
      $taget_id = $_GET['user'];
      $user_id = $_SESSION['user_id'];
      #update relationship between user and taget user to block and delete chats then return to home page
      $block_query = "INSERT INTO block_user (user_1,user_2)VALUE ($user_id,$taget_id)"; $delete= "DELETE FROM friend_user WHERE (friend_user.user_1 = $taget_id AND friend_user.user_2 = $user_id) OR (friend_user.user_2 = $taget_id AND friend_user.user_1 = $user_id)";
      $delete_chat = "DELETE FROM chats WHERE (chats.from_id = $user_id AND chats.to_id = $taget_id) OR (chats.from_id = $taget_id AND chats.to_id = $user_id)";
      $result_chat = $conn->query($delete_chat);
      $result1 = $conn->query($delete);
      $result_block = $conn->query($block_query);
      header("Location: home.php");
  }
?>