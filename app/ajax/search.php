<?php
#searchText_block
session_start();

# check if the user is logged in
if (isset($_SESSION['username'])) {
	# check if the key is submitted
	if (isset($_POST['key'])) {
		# database connection file
		include '../db.conn.php';

		$user_id = $_SESSION['user_id'];
		$con = mysqli_connect("localhost", "root", "", "chat_app_db") or die("Error");

		#query for search without blocked users
		$block = "SELECT * FROM `block_user` WHERE block_user.user_1 = $user_id OR block_user.user_2 = $user_id";
		$result_block = mysqli_query($con, $block);

		#query to search for friends only
		$friends = "SELECT * FROM `friend_user` WHERE (friend_user.user_1 = $user_id AND friend_user.status = 1) OR (friend_user.user_2 = $user_id AND friend_user.status = 1)";
		$result_friends = mysqli_query($con, $friends);

		#Keyword name or username to search
		$key = "{$_POST['key']}";
		#query search user from keyword
		$sql = "SELECT * FROM users WHERE username LIKE ? OR name LIKE ?";
		$stmt = $conn->prepare($sql);
		$stmt->execute([$key, $key]);
		if ($stmt->rowCount() > 0) {
			$users = $stmt->fetchAll();
			#loop search user results 
			foreach ($users as $user) {
				$blocked = 0;
				$friend = 0;
				#if found taget id is same user id (find yourself) then do not choose this taget user to show 
				if ($user['user_id'] == $_SESSION['user_id']) continue;
				#loop to check user results  doesn't blocked
				while ($record1 = mysqli_fetch_array($result_block)) {
					if ($user['user_id'] == $record1['user_1'] || $user['user_id'] == $record1['user_2']) {
						$blocked = $blocked + 1;
					}
				}
				#loop to check user and taget user are with friend
				while ($record2 = mysqli_fetch_array($result_friends)) {
					if ($user['user_id'] == $record2['user_1'] || $user['user_id'] == $record2['user_2']) {
						$friend = $friend + 1;
					}
				}
				#if wrong condition then do not choose this taget user to show 
				if ($blocked > 0 || $friend == 0) continue;
?>
				<!-- show all friend users result after analyze-->
				<li class="list-group-item">
					<a href="chat.php?user=<?= $user['username'] ?>" class="d-flex  justify-content-between align-items-center p-2">
						<div class="d-flex
			            align-items-center">
							<img src="uploads/<?= $user['p_p'] ?>" class="w-26 rounded-circle">
							<h3 class="fs-xs m-2" style="color: #000000;">
								<?= $user['name'] ?>
							</h3>
						</div>
					</a>
				</li>
			<?php }
		} else { ?>
			<!-- if can not find taget user -->
			<div class="alert alert-info text-center">
				<i class="fa fa-user-times d-block fs-big"></i>
				The user "<?= htmlspecialchars($_POST['key']) ?>"is not found.
			</div>
<?php }
	}
} else { # check if the user is not logged in
	header("Location: ../../index.php");
	exit;
}
