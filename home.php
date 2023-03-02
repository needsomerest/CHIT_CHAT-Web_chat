<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "chat_app_db") or die("Error");

if (isset($_SESSION['username'])) {
  # database connection file
  include 'app/db.conn.php';
  include 'app/helpers/user.php';
  include 'app/helpers/conversations.php';
  include 'app/helpers/timeAgo.php';
  include 'app/helpers/last_chat.php';

  # Getting User data data
  $user = getUser($_SESSION['username'], $conn);
  $conversations = getConversation($user['user_id'], $conn);
  $user_id = $user['user_id'];
?>
  <!DOCTYPE html>
  <html lang="en">
  <!-- header of home page-->

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | CHIT CHAT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/chit-chat-logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="bootstrap-5.0.0-dist/bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  </head>
  <style>
    html {
      height: 100%;
    }

    body {
      min-height: 100%;


    }

    .bg-nav-green {
      background: #0C4A34 !important;
    }

    .w-25 {
      width: 5%;
    }

    .w-26 {
      width: 50px;
      height: 50px;
    }

    .offline {
      width: 10px;
      height: 10px;
      background: #a2a2a3;
      border-radius: 50%;
      margin-right: 10px;
    }

    .online {
      width: 10px;
      height: 10px;
      background: green;
      border-radius: 50%;
      margin-right: 10px;
    }

    .mynav a {
      color: white !important;
    }

    .mynav a:hover {
      color: #0C4A34 !important;
      border-bottom: 3px solid #0C4A34;
    }

    .dropnav a {
      color: black !important;
    }

    .dropnav a:hover {
      color: black !important;
      background-color: #42BD94;
      border: none;
    }

    .size {
      max-width: 10%;
      height: auto;
    }

    section {
      padding: 60px 0;
    }

    #tabs {
      background: #60B898;
      color: #fff;
    }

    #tabs .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
      color: #f3f3f3;
      background-color: transparent;
      border-color: transparent transparent #f3f3f3;
      border-bottom: 4px solid !important;
      font-size: 20px;
      font-weight: bold;
    }

    #tabs .nav-tabs .nav-link {
      border: 1px solid transparent;
      border-top-left-radius: .25rem;
      border-top-right-radius: .25rem;
      color: red;
      font-size: 20px;
    }

    .w-400 {
      width: 780px;
    }

    .set-1 {
      width: 312px;
      height: auto;
      color: #0C4A34 !important;
      font-weight: bold;
      font-size: 20px;
      text-align: center;
    }
  </style>

  <body style="background: #DFFFF4;">
    <!-- start nav bar of home page -->
    <nav class="navbar fixed-top navbar-expand-md navbar-dark" style="background-color: #42BD94;">
      <div class="container">
        <!-- logo and name of website at nav bar link to home page -->
        <a href="home.php" class="navbar-brand">
          <img src="img/chit-chat-logo.png" alt="chitchat Logo" width="40" height="40" class="d-in-line-block align-top" />
          <span class="navbar-brand mb=0 h1" style="font-weight:bold; color:#0C4A34 ;"> CHITCHAT</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#toggleMobileMenu" aria-controls="toggleMobileMenu" aria-expanded="false" aria-lable="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mynav" id="toggleMobileMenu">
          <ul class="navbar-nav ms-auto text-center">
            <!-- home btn on navbar link to home page-->
            <li class="nav-item active">
              <a class="nav-link" href="home.php" style="margin-right: 20px;">HOME</a>
            </li>
            <!-- friends btn on navbar link to friend management page-->
            <li class="nav-item active">
              <a class="nav-link" href="addfriend.php" style="margin-right: 20px;">FRIENDS</a>
            </li>
            <!-- setting btn on navbar link to setting list -->
            <li class="nav-item active dropdown">
              <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="margin-right: 20px;" href="#">SETTING</a>
              <ul class="dropdown-menu dropnav" aria-labelledby="navbarDropdown">
                <!-- change password btn in setting list link to change password pop up -->
                <li><a data-toggle="modal" data-target="#change_password" class="dropdown-item">CHANGE PASSWORD</a></li>
                <!-- edit profile btn in setting list link to edit profile pop up -->
                <li><a data-toggle="modal" data-target="#edit_user" class="dropdown-item">EDIT PROFILE</a></li>
                <!-- blocked list btn in setting list link to access blocked management pop up -->
                <li><a data-toggle="modal" data-target="#block" class="dropdown-item">BLOCKED LIST</a></li>
                <!-- Delete account btn for delete account -->
                <li><a data-toggle="modal" data-target="#delete_user" class="dropdown-item">DELETE ACCOUNT</a></li>
                <!-- logout btn for log out -->
                <li><a href="logout.php" class="dropdown-item">LOGOUT</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <br></br>
    <br></br>
    <!-- Setting -->
    <?php
    $password = $user['password'];
    $_SESSION["password"] = $password;
    ?>
    <!-- The Modal change password -->
    <div class="modal" id="change_password">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header change password -->
          <div class="modal-header" style="background-color: #DFFFF4;">
            <h3 class="modal-title" style="font-weight: 600;">Change Password</h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body change password -->
          <div class="modal-body" style="background-color: #DFFFF4;">
            <div class="col-md-12 text-center">
              <!-- change password form -->
              <form method="post" action="changepassword.php" enctype="multipart/form-data">
                <?php if (isset($_GET['error'])) { ?>
                  <div class="alert alert-warning" role="alert">
                  <?php echo htmlspecialchars($_GET['error']);
                } ?>
                  </div>
                  <!-- insert current password form -->
                  <div class="mb-3">
                    <label class="form-label" style="font-weight: 600;">Your Password</label>
                    <input type="password" name="password2" required="required" class="form-control" placeholder="password">
                  </div>
                  <!-- insert new password form -->
                  <div class="mb-3">
                    <label class="form-label" style="font-weight: 600;">New Password</label>
                    <input type="password" name="newpassword1" required="required" class="form-control" placeholder="newpassword">
                  </div>
                  <!-- insert new password to comfirm form -->
                  <div class="mb-3">
                    <label class="form-label" style="font-weight: 600;">Input New Password Again</label>
                    <input type="password" name="newpassword2" required="required" class="form-control" placeholder="newpassword">
                  </div>
                  <button type="submit" class="btn btn-dark" style="border-radius: 100px;">Submit</button>
              </form>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal edit user -->
    <div class="modal" id="edit_user">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal header edit user -->
          <div class="modal-header" style="background-color: #DFFFF4;">
            <h3 class="modal-title" style="font-weight: 600;">Edit Profile</h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body edit user -->
          <?php
          $user_id = $user['user_id'];
          $edit = mysqli_query($con, "SELECT * FROM users where users.user_id=$user_id");
          $row = mysqli_fetch_array($edit);
          ?>
          <div class="modal-body" style="background-color: #DFFFF4;">
            <div class="col-md-12 text-center">
              <div class="col-sm">
                <!-- edit profile form -->
                <form method="post" action="update.php" enctype="multipart/form-data">
                  <?php if (isset($_GET['error'])) { ?>
                    <div class="alert alert-warning" role="alert">
                      <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                  <?php } #if isset have data (if user is logged in)
                  if (isset($_GET['name'])) {
                    $name = $_GET['name'];
                  } else $name = '';

                  if (isset($_GET['username'])) {
                    $username = $_GET['username'];
                  } else $username = '';
                  ?>
                  <!-- insert name that want to update form -->
                  <div class="mb-3">
                    <label class="form-label" style="font-weight: 600;">Name</label>
                    <input type="text" name="name" class="form-control" required="required" placeholder="name" value="<?= $row['name'] ?>">
                  </div>
                  <!-- insert picture that want to update form -->
                  <div class="mb-3">
                    <label class="form-label" style="font-weight: 600;">Profile Picture</label>
                    <input type="file" class="form-control" name="pp">
                  </div>

                  <button type="submit" class="btn btn-dark" style="border-radius: 100px;">Update</button>
                </form>
                <!-- Update user account info -->
                <?php
                $connection = mysqli_connect("localhost", "root", "");
                $db = mysqli_select_db($connection, 'chat_app_db');
                $id = $user['user_id'];
                if (isset($_POST['update'])) {
                  $update = "UPDATE users SET users.name = '$_POST[updatename]' ,users.username = '$_POST[updateusername]' where users.user_id= $id ";
                  $result_user = mysqli_query($connection, $update);
                } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- The Modal delete user -->
    <div class="modal" id="delete_user">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header delete user -->
          <div class="modal-header" style="background-color: #DFFFF4;">
            <h3 class="modal-title" style="font-weight: 600;">Delete Account</h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body delete user -->
          <div class="modal-body" style="background-color: #DFFFF4;">
            <div class="col-md-12 text-center">
              <!-- delete account warning -->
              <h5>
                <p class="text-center">Do you want to delete your account?</p>
              </h5>
              <!-- btn link to delete user precess in delete_user.php-->
              <a href="delete_user.php?id=<?php echo $user['user_id']; ?> "><button class="btn btn btn-danger pull-center" style="border-radius: 100px;">Delete</button></a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal blocked user -->
    <div class="modal fade bd-example-modal-lg" id="block" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color: #DFFFF4;">
            <h3 class="modal-title" style="font-weight: 600;">Blocked User</h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="container" style="background-color: #DFFFF4;">
            <div class="row">
              <div class="col">
                <tr>
                  <td>
                    <p class="text-center">
                    <h4 class="modal-title" style="font-weight: 600;">Block User</h4>
                    </p>
                  </td>
                  <td>
                    <!-- search name or username to block -->
                    <div class="input-group mb-3">
                      <input type="text" placeholder="Search name or username" id="searchText_block" class="form-control">
                      <button class="btn btn-dark" id="serachBtn_block">
                        <i class="fa fa-search"></i>
                      </button>
                    </div>
                  </td>
                  <td>
                    <ul id="List_block" class="list-group mvh-50 overflow-auto"></ul>
                  </td>
                </tr>
              </div>
              <br>
              <!--start edit form search block user here mk.1-->
              <p class="text-center">
              <h4 class="modal-title" style="font-weight: 600;">Unblock User</h4>
              </p>
              <!-- show all blocked user -->
              <div class="input-group mb-3 overflow-auto">
                <?php
                $block = "SELECT * FROM `block_user` RIGHT JOIN users ON block_user.user_2 = users.user_id WHERE user_1 = $user_id";
                $result_block = mysqli_query($con, $block);
                while ($record = mysqli_fetch_array($result_block)) { ?>
                  <table class="table">
                    <thead>
                      <tr>
                        <td><img src="uploads/<?php echo "" . $record['p_p']; ?>" class="w-26 rounded-circle"></td>
                        <td>
                          <h3 class="d-flex fs-xs m-2" style="color: #000000;"><?php echo "" . $record['name']; ?>
                        <td>
                          <!-- unblock btn to unblock each user by link to unblock process at unblockfriend.php -->
                        <td><a href="unblockfriend.php?id=<?php echo $record['user_2']; ?> "><button style="border-radius: 100px;" class="btn btn btn btn-dark pull-right">Unblock</button></a></td>
                      <?php } ?>
                      </tr>
                    </thead>
                  </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End setting -->

    <!-- main system -->
    <div class="p-2 rounded shadow mt-2" style="background-color: #60B898; margin-left: auto; margin-right: auto; width: 40em">
      <!-- show user profile -->
      <div class="d-flex mb-3 p-3 bg-light justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <img src="uploads/<?= $user['p_p'] ?>" class="size rounded-circle">
          <h3 class="fs-xs m-2"></h3>
          </h3><?= $user['name'] ?></h3>
        </div>
      </div>
      <div style="background-color: #60B898; margin-left: auto; margin-right: auto; width: 40m">
        <?php
        ?>
        <!-- search friend form to chat with friend -->
        <div class="input-group mb-3">
          <input type="text" placeholder="Search name or username" id="searchText" class="form-control">
          <button class="btn btn-dark" id="serachBtn">
            <i class="fa fa-search"></i>
          </button>
        </div>
        <ul id="chatList" class="list-group mvh-50 overflow-auto"></ul>
      </div>
      <!-- nav bar tab -->
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-link active set-1" id="nav-friends-tab" data-bs-toggle="tab" href="#friends" role="tab" aria-controls="nav-friends" aria-selected="true">Friends</a>
          <a class="nav-link set-1" id="nav-chat-tab" data-bs-toggle="tab" href="#chat" role="tab" aria-controls="nav-chat" aria-selected="true">Chat</a>
        </div>
      </nav>
      <!-- friends nav bar tab -->
      <div class="tab-content">
        <div class="tab-pane fade show active" id="friends" role="tabpanel" aria-labelledby="friends-tab">
          <?php
          $friend1 = "SELECT * FROM `friend_user` INNER JOIN users ON friend_user.user_2 = users.user_id WHERE friend_user.user_1 = $user_id AND friend_user.status = 1"; #friend_data
          $friend2 = "SELECT * FROM `friend_user` INNER JOIN users ON friend_user.user_1 = users.user_id WHERE friend_user.user_2 = $user_id AND friend_user.status = 1"; #friend_data
          #query friend list
          $result_friend1 = mysqli_query($con, $friend1);
          $result_friend2 = mysqli_query($con, $friend2);
          #show all friend user
          while ($record1 = mysqli_fetch_array($result_friend1)) {
            $friend = $record1['status'];
            $_SESSION['friend'] = $friend;
          ?>
            <li class="list-group-item">
              <a href="chat.php?user=<?= $record1['username'] ?>">
                <div class="d-flex">
                  <div class="d-flex flex-row">
                    <div class="d-flex align-items-center pb-1 p-2">
                      <?php if (last_seen($record1['last_seen']) == "Active") { ?>
                        <div title="online">
                          <div class="online"></div>
                        </div>
                    </div>
                  <?php } else { ?>
                    <div title="offline">
                      <div class="offline"></div>
                    </div>
                  </div>
                <?php } ?>
                <div class="d-flex align-items-center pb-1 p-2">
                  <img src="uploads/<?= $record1['p_p'] ?>" class="w-26 rounded-circle">
                  <div class="d-flex align-items-center pb-1">
                    <h3 class="fs-xs m-2" style="color: #000000;">
                      <?= $record1['name'] ?>
                      <br>
                    </h3>
                  </div>
                </div>
                </div>
                <div class="ml-auto p-2 p-2">
                  <!--block btn to block friend user-->
                  <a href="blockfriend.php?user=<?php echo $record1['user_2']; ?> "><button class="btn btn-dark " style="border-radius: 100px;">Block</button></a>
                  <!--delete btn to delete friend user-->
                  <a href="deletefriend.php?id=<?php echo $record1['user_2']; ?> "><button class="btn btn btn-danger" style="border-radius: 100px;">Delete</button></a>
                </div>
        </div>
      <?php } ?>
      </a>
      </li>
      <?php
      #show all friend user
      while ($record2 = mysqli_fetch_array($result_friend2)) {
      ?>
        <li class="list-group-item">
          <a href="chat.php?user=<?= $record2['username'] ?>">
            <div class="d-flex">
              <div class="d-flex flex-row">
                <!-- status friend user -->
                <div class="d-flex align-items-center pb-1 p-2">
                  <?php if (last_seen($record2['last_seen']) == "Active") { ?>
                    <div title="online">
                      <div class="online"></div>
                    </div>
                </div>
              <?php } else { ?>
                <div title="offline">
                  <div class="offline"></div>
                </div>
              </div>
            <?php } ?>
            <!--picture profile friends -->
            <div class="d-flex align-items-center pb-1 p-2">
              <img src="uploads/<?= $record2['p_p'] ?>" class="w-26 rounded-circle">
              <div class="d-flex align-items-center pb-1">
                <h3 class="fs-xs m-2" style="color: #000000;">
                <!--name friends -->
                  <?= $record2['name'] ?>
                  <br>
                </h3>
              </div>
            </div>
            </div>
            <div class="ml-auto p-2 p-2">
              <!--block btn to block friend user-->
              <a href="blockfriend.php?user=<?php echo $record2['user_1']; ?> "><button class="btn btn-dark " style="border-radius: 100px;">Block</button></a>
              <!--delete btn to delete friend user-->
              <a href="deletefriend.php?id=<?php echo $record2['user_1']; ?> "><button class="btn btn btn-danger" style="border-radius: 100px;">Delete</button></a>
            </div>
      </div>
    <?php } ?>
    </a>
    </li>
    </div>
    <!-- chat nav bar tab -->
    <div class="tab-pane fade" id="chat" role="tabpanel" aria-labelledby="chat-tab">
      <!-- show all conversation with friends -->
      <?php if (!empty($conversations)) {
        foreach ($conversations as $conversation) {
          $userid = $conversation['user_id'];
          $status = "SELECT * FROM `friend_user` WHERE (friend_user.user_1 = $user_id AND friend_user.status = 1) OR (friend_user.user_2 = $user_id AND friend_user.status = 1)";
          $result_status = mysqli_query($con, $status);
          while ($record = mysqli_fetch_array($result_status)) {
            if ($record['user_1'] == $conversation['user_id'] || $record['user_2'] == $conversation['user_id']) { ?>
            <!-- status friend user -->
              <li class="list-group-item">
                <a href="chat.php?user=<?= $conversation['username'] ?>" class="d-flex align-items-center pb-1">
                  <div class="d-flex align-items-center pb-1">
                    <?php if (last_seen($conversation['last_seen']) == "Active") { ?>
                      <div title="online">
                        <div class="online"></div>
                      </div>
                    <?php } else { ?>
                      <div title="offline"></div>
                      <div class="offline"></div>
                  </div>
                <?php } ?>
                <!--picture profile friends -->
                <div class="d-flex align-items-center pb-1">
                  <img src="uploads/<?= $conversation['p_p'] ?>" class="w-26 rounded-circle">
                  <h3 class="fs-xs m-2" style="color: #000000; text-align: left;">
                  <!--name friends -->
                    <?= $conversation['name'] ?>
                    <br>
                    <small>
                      <?php
                      if ($_SESSION['user_id'] != $conversation['user_id']) {
                        $last = lastChat($_SESSION['user_id'], $conversation['user_id'], $conn);
                        if (strlen($last) > 10) {
                          for ($i = 0; $i <= 10; $i++) {
                            echo $last[$i];
                          }
                        }
                       else echo $last;
                      } else {
                        $last = lastChat($conversation['user_id'], $_SESSION['user_id'],  $conn);
                        if (strlen($last) > 10) {
                          for ($i = 0; $i <= 10; $i++) {
                            echo $last[$i];
                          }
                        } 
                      else echo $last;
                      }
                      ?>
                    </small>
                  </h3>
                </div>
            <?php  }
          } 
            ?>

          <?php }
      } else { ?><!-- if don't have conversation and don't have friend -->
          <div class="alert alert-info text-center">
            <i class="fa fa-comments d-block fs-big"></i>
            No messages yet, Start the conversation
          </div>
        <?php } ?>
                </a>
              </li>
              </ul>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
      $(document).ready(function() {

        // Search
        $("#searchText").on("input", function() {
          var searchText = $(this).val();
          if (searchText == "") return;
          $.post('app/ajax/search.php', {
              key: searchText
            },
            function(data, status) {
              $("#chatList").html(data);
            });
        });

        // Search using the button
        $("#serachBtn").on("click", function() {
          var searchText = $("#searchText").val();
          if (searchText == "") return;
          //  $.post('app/ajax/search.php', {
          $.post('app/ajax/search.php', {
              key: searchText
            },
            function(data, status) {
              $("#chatList").html(data);
            });
        });

        // Search to block
        $("#searchText_block").on("input", function() {
          var searchText_block = $(this).val();
          if (searchText_block == "") return;
          $.post('app/ajax/search_to_block.php', {
            key: searchText_block
          });
        });

        // Search using the button
        $("#serachBtn_block").on("click", function() {
          var searchText_block = $("#searchText_block").val();
          if (searchText_block == "") return;
          $.post('app/ajax/search_to_block.php', {
              key: searchText_block
            },
            function(data, status) {
              $("#List_block").html(data);
            });
        });
        /** auto update last seen for logged in user **/
        let lastSeenUpdate = function() {
          $.get("app/ajax/update_last_seen.php");
        }
        lastSeenUpdate();
        /** auto update last seen every 10 sec **/
        setInterval(lastSeenUpdate, 10000);
      });
    </script>

    <script src="bootstrap-5.0.0-dist/bootstrap-5.0.0-dist/js/bootstrap.min.js"></script>

  <?php
} else { # if the user is not logged in 
  header("Location: index.php");
  exit;
}
  ?>
  </body>
  </html>