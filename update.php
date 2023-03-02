<?php

session_start();

# check if the user is logged in
if (isset($_SESSION['username'])) {

    include 'app/db.conn.php';
        $name = $_POST['name'];
        $username = $_SESSION['username'];
        $user_id = $_SESSION['user_id'];

    # Profile Picture Uploading
    if (isset($_FILES['pp'])) {
        # get data and store them in var
        $img_name  = $_FILES['pp']['name'];
        $tmp_name  = $_FILES['pp']['tmp_name'];
        $error  = $_FILES['pp']['error'];

        # if there is not error occurred while uploading
        if($error === 0){
         
         # get image extension store it in var
           $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);

          # convert the image extension into lower case and store it in var 
          $img_ex_lc = strtolower($img_ex);

          # crating array that stores allowed to upload image extension.
          $allowed_exs = array("jpg", "jpeg", "png");
 
          # check if the the image extension is present in $allowed_exs array
           if (in_array($img_ex_lc, $allowed_exs)) {
             
              # renaming the image with user's username like: username.$img_ex_lc
              $new_img_name = $username.$name. '.'.$img_ex_lc;

              # crating upload path on root directory
              $img_upload_path = 'uploads/'.$new_img_name;

              # move uploaded image to ./upload folder
              move_uploaded_file($tmp_name, $img_upload_path);
            }else {
                echo '<script>
                alert("You can not upload files of this type");
                window.location.href="home.php";
                </script>';
            exit;
          }
        }
    }

    # if the user upload Profile Picture
    if (isset($new_img_name)) {

        # update data into database
      $sql1 = "UPDATE users SET name=? , p_p=? WHERE user_id=?";
      $stmt = $conn->prepare($sql1);
      $stmt->execute([$name, $new_img_name,$user_id]);
    }else {
      # update data into database
      $sql = "UPDATE users SET name=? WHERE user_id=?";
      $stmt= $conn->prepare($sql);
      $stmt->execute([$name, $user_id]);
    }

    # success message
    echo '<script>
    alert("Account update successfully");
    window.location.href="home.php";
    </script>';
   exit;
}
?>