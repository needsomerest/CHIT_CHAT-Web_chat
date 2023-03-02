<?php 
  session_start();

  if (isset($_SESSION['username'])) {
  	# database connection file
  	include 'app/db.conn.php';

	# call another file
  	include 'app/helpers/user.php';
  	include 'app/helpers/chat.php';
  	include 'app/helpers/opened.php';
  	include 'app/helpers/timeAgo.php';

  	# Getting User data data
  	$chatWith = getUser($_GET['user'], $conn);

	# Getting chats history
  	$chats = getChats($_SESSION['user_id'], $chatWith['user_id'], $conn);

	#opened message
  	opened($chatWith['user_id'], $conn, $chats);
?>
<style>
.size {
	  max-width: 50%;
    height: auto;
    }
.wrapper {
 width: 200px;
 word-break: break-word;
}
.w-20 {
      width: 55px;
      height: 55px;
    }

	
</style>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $chatWith['name'];?> | CHIT CHAT</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<link rel="stylesheet" 
	      href="css/style.css">
		  <link rel="icon" href="img/chit-chat-logo.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="bootstrap-5.0.0-dist/bootstrap-5.0.0-dist/css/bootstrap.min.css">
</head>
	
<body class="d-flex justify-content-center align-items-center vh-100" style="background-color: #DFFFF4;"> 
    <div class="w-400 shadow p-4 rounded" style="background-color: #60B898;">
    	<a href="home.php" class="fs-4 link-dark">&#8592;</a>

		<!-- Show profile friend user your current chat -->
    	   <div class="d-flex align-items-center" style="background-color: #DFFFF4; border-radius: 5px;">
    	   	  <img src="uploads/<?=$chatWith['p_p']?>"
				 class="w-20 rounded-circle m-2">

               <h3 class="fs-sm m-2" >
               	  <?=$chatWith['name']?> <br>
               	  <div class="d-flex
               	              align-items-center" 
               	        title="online">
               	    <?php
                        if (last_seen($chatWith['last_seen']) == "Active") {
               	    ?>
               	        <div class="online"></div>
               	        <small class="d-block p-1">Online</small>
               	  	<?php }else{ ?>
               	         <small class="d-block p-1">
               	         	Last seen:
               	         	<?=last_seen($chatWith['last_seen'])?>
               	         </small>
               	  	<?php } ?>
               	  </div>
               </h3>
    	   </div>

		   <!-- Chat box : show chat history -->
    	   <div class="shadow p-4 rounded
    	               d-flex flex-column
    	               mt-2 chat-box" style="background-color: #FFFFFF;"
    	        id="chatBox"> 
    	        <?php 
				# getting all conversations
                     if (!empty($chats)) {
                     foreach($chats as $chat){
						# logged in user message
                     	if($chat['from_id'] == $_SESSION['user_id'])
                     	{ ?>
						 <p class=" rtext wrapper align-self-end
						        border rounded p-2 mb-1">
						    <?=$chat['message']?> 
						    <small class="d-block">
						    	<?=$chat['created_at']?>
						    </small>      	
						</p> 
                    <?php } 
					
					# logged in user's friend message
					else{ ?>
					<p class="ltext wrapper border 
					         rounded p-2 mb-1">
					    <?=$chat['message']?> 
					    <small class="d-block">
					    	<?=$chat['created_at']?>
					    </small>      	
					</p>
                    <?php } 
                     }	
    	        }
				
				# logged in user not yet start a conversation with friend
				else{ ?>
               <div class="alert alert-info 
    				            text-center">
				   <i class="fa fa-comments d-block fs-big"></i>
	               No messages yet, Start the conversation
			   </div>
    	   	<?php } ?>
    	   </div>

		   <!-- Text box for send message  -->
    	   <div class="input-group mb-3">
    	   	   <textarea cols="3"
    	   	             id="message"
    	   	             class="form-control"></textarea>
    	   	   <button class="btn btn-dark"
    	   	           id="sendBtn">
    	   	   	  <i class="fa fa-paper-plane"></i>
    	   	   </button>
    	   </div>

    </div>
 

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
	// scroll chat box
	var scrollDown = function(){
        let chatBox = document.getElementById('chatBox');
        chatBox.scrollTop = chatBox.scrollHeight;
	}

	scrollDown();

	$(document).ready(function(){
      
	  // send message data to insert.php file for insert chat into database
      $("#sendBtn").on('click', function(){
      	message = $("#message").val();
      	if (message == "") return;

      	$.post("app/ajax/insert.php",
      		   {
      		   	message: message,
      		   	to_id: <?=$chatWith['user_id']?>
      		   },
      		   function(data, status){
                  $("#message").val("");
                  $("#chatBox").append(data);
                  scrollDown();
      		   });
      });

      // auto update last seen for logged in user
      let lastSeenUpdate = function(){
      	$.get("app/ajax/update_last_seen.php");
      }
      lastSeenUpdate();

      //auto update last seen every 10 sec
	  setInterval(lastSeenUpdate, 10000);


      // auto refresh / reload
      let fechData = function(){
      	$.post("app/ajax/getMessage.php", 
      		   {
      		   	id_2: <?=$chatWith['user_id']?>
      		   },
      		   function(data, status){
                  $("#chatBox").append(data);
                  if (data != "") scrollDown();
      		    });
      }

      fechData();

      // auto update last seen every 0.5 sec
      setInterval(fechData, 500);
    
    });
</script>
<script src="bootstrap-5.0.0-dist/bootstrap-5.0.0-dist/js/bootstrap.min.js"></script>  
 </body>
 </html>
<?php
  }else{
  	header("Location: index.php");
   	exit;
  }
 ?>