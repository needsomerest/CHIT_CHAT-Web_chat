<?php 
  session_start();
  	include 'app/db.conn.php';
    # Getting user data
    $id =$_GET["id"];
    #delete user account relationship with other user then logout and return to index page (login page) 
    $delete_user = "DELETE FROM users WHERE users.user_id = '$id'";
    $delete_chats = "DELETE FROM chats WHERE chats.from_id = '$id' OR chats.to_id = '$id'";
    $delete_block_user = "DELETE FROM block_user WHERE block_user.user_1 = '$id' OR block_user.user_2 = '$id'";
    $delete_friend_user = "DELETE FROM friend_user WHERE friend_user.user_1 = '$id' OR friend_user.user_2 = '$id'";
    $result_user = $conn->query($delete_user);
    $result_chats = $conn->query($delete_chats);
    $result_block_user = $conn->query($delete_block_user);
    $result_friend_user = $conn->query($delete_friend_user);
    echo '<script>
    alert("Delete account successfully");
    window.location.href="logout.php";
    </script>';
