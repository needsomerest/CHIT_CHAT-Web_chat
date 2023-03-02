<?php 

session_start();

# check if the user is logged in
if (isset($_SESSION['username'])) {

	if (isset($_POST['message']) &&
        isset($_POST['to_id'])) {
	
	# database connection file
	include '../db.conn.php';

	# get data from XHR request and store them in var
	$message = $_POST['message'];
	$to_id = $_POST['to_id'];

	# get the logged in user's userID from the SESSION
	$from_id = $_SESSION['user_id'];

	# Insert message to database
	$sql = "INSERT INTO 
	       chats (from_id, to_id, message) 
	       VALUES (?, ?, ?)";
	$stmt = $conn->prepare($sql);
	$res  = $stmt->execute([$from_id, $to_id, $message]);
    
    # if the message inserted
    if ($res) {
    	/**
       check if this is the first
       conversation between them
       **/
       $sql2 = "SELECT * FROM friend_user
               WHERE (user_1=? AND user_2=?)
               OR    (user_2=? AND user_1=?)";
       $stmt2 = $conn->prepare($sql2);
	   $stmt2->execute([$from_id, $to_id, $from_id, $to_id]);

	    // setting up the time Zone
		// It Depends on your location or your P.c settings
		define('TIMEZONE', 'Asia/Bangkok');
		date_default_timezone_set(TIMEZONE);
		$time  = date("Y-m-d G:i:s");

		if ($stmt2->rowCount() == 0 ) {
			# insert them into friend_user table 
			$sql3 = "INSERT INTO 
			         friend_user(user_1, user_2)
			         VALUES (?,?)";
			$stmt3 = $conn->prepare($sql3); 
			$stmt3->execute([$from_id, $to_id]);
		}
		?>

		<p class="rtext align-self-end
		          border rounded p-2 mb-1">
		    <?=$message?>  
		    <small class="d-block"><?=$time?>
			</small>  
			
		</p>

    <?php 
     }
  }
}else {
	header("Location: ../../index.php");
	exit;
}