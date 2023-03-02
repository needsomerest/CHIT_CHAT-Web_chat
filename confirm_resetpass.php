<?php
session_start();

    # database connection file
    include 'app/db.conn.php';

        # get data and store them in var
        $usernameforget  = $_SESSION['usernameforget'];
        $newpassword1  = $_POST['newpassword1'];
        $newpassword2  = $_POST['newpassword2'];
        $answer = $_POST['answer'];

        # Verify the accuracy of the information for reset password
        $sql = "SELECT * FROM users WHERE username=?";
		$stmt = $conn->prepare($sql);
		$stmt->execute([$usernameforget]);
        if ($stmt->rowCount() > 0) {
			$users = $stmt->fetchAll();
			foreach ($users as $user) {
                if($user['answer']==$answer){
                    if($newpassword1==$newpassword2){
                     $newpassword1 = password_hash($newpassword1, PASSWORD_DEFAULT);
                     
                     # update password into database
                     $sql = "UPDATE users SET password=? WHERE username=?";
                     $stmt= $conn->prepare($sql);
                     $stmt->execute([$newpassword1, $usernameforget]); 

                     #alert if success
                     echo '<script>
                     alert("Reset password successful");
                     window.location.href="index.php";
                     </script>';
                    }

                    # alert if fault
                    else{
                     echo '<script>
                     alert("Your new password not match");
                     window.location.href="index.php";
                     </script>';
                    }
                    }
                    else{
                     echo '<script>
                     alert("Your security answer incorrect");
                     window.location.href="index.php";
                     </script>';
                   }
			}
		}
?>