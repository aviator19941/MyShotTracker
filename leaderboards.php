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
				$first = $_SESSION['first'];
				$last = $_SESSION['last'];

    			$sql = "SELECT * FROM users U JOIN friends F ON U.uid = F.uid AND F.friendRequest = 1 WHERE F.friendUid = :uid";

			    $query = $pdo->prepare($sql);
			    $query->bindParam(':uid', $uid);
			    $query->execute();

			    $sql2 = "SELECT * FROM users U JOIN friends F ON U.uid = F.friendUid AND F.friendRequest = 1 WHERE F.uid = :uid";

			    $query2 = $pdo->prepare($sql2);
			    $query2->bindParam(':uid', $uid);
			    $query2->execute();

			    if ($query->rowCount() > 0) {
			      $results = $query->fetchAll();

			      foreach($results as $row) {
			        echo 'Query 1: '.$row['first'].' '.$row['last'].' '.$row['uid'].'<br>';
			      }
			    }
			    else if ($query2->rowCount() > 0) {
			      $results2 = $query2->fetchAll();

			      foreach($results2 as $row2) {
			        echo 'Query 2: '.$row2['first'].' '.$row2['last'].' '.$row2['friendUid'].'<br>';
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