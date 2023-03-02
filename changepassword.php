<?php
session_start();
# Allows users to edit new passwords.
# check if the user is logged in
if (isset($_SESSION['username'])) {

    # database connection file
    include 'app/db.conn.php';

      # get data and store them in var
        $oldpassword  = $_POST['password2'];
        $newpassword1  = $_POST['newpassword1'];
        $newpassword2  = $_POST['newpassword2'];
        $username = $_SESSION['username'];
        $user_id = $_SESSION['user_id'];
        $password = $_SESSION['password'];
      
      # verify old password
      if(password_verify($oldpassword, $password)){
       if($newpassword1==$newpassword2){
         $newpassword1 = password_hash($newpassword1, PASSWORD_DEFAULT);
        
         # update password into database 
        $sql = "UPDATE users SET password=? WHERE user_id=?";
        $stmt= $conn->prepare($sql);
        $stmt->execute([$newpassword1, $user_id]); 
        #alert if success
        echo '<script>
        alert("Change password successful");
        window.location.href="home.php";
        </script>';
       }
       
       #alert if fault
       else{
        echo '<script>
        alert("your new password not match");
        window.location.href="home.php";
        </script>';
       }
      }
      else{
        echo '<script>
        alert("your password incorrect");
        window.location.href="home.php";
        </script>';
      }
}
?>