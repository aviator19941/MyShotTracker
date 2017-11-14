<!DOCTYPE html>
<html>
	<head>
		<title>My Leaderboards</title>
		<h1>My Leaderboards</h1>
		<link rel="stylesheet" type="text/css" href="leaderboards.css" />
	</head>
	<body>
		<button class="createLeaderboard" name="createLeaderboard">Create Leaderboard</button>
		<div class="addFriendsToLeaderboard">
			<h3>Your Friends</h3>
			<?php 
				include 'db.php';
				session_start();
				$uid = $_SESSION['uid'];

				$sql = "SELECT * FROM friends WHERE friendRequest = 1 AND (friendUid = ? OR uid = ?)";

			    $query2 = $pdo->prepare($sql);
			    $query2->bindParam(1, $uid);
			    $query2->bindParam(2, $uid);
			    $query2->execute();

			    if ($query2->rowCount() > 0) {
			      $results = $query2->fetchAll();

			      foreach($results as $row) {
			        echo $row['uid'].'<br>';
			      }
			    }
			    else {
			      echo "No friends yet";
			    }
			?>

		</div>

		<div id="disp_data"></div>

	</body>
</html>