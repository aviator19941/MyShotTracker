<?php
	session_start();
	include 'db.php';

	$status = $_GET['status'];
	$friendUid = "";
	$uid = $_SESSION['uid'];

	if ($status == "disp") {
		$sql = "SELECT L.id, U.first, U.last, L.uid AS lUid FROM users U JOIN leaderboards L ON U.uid = L.uid AND L.leaderboardRequest = 1 WHERE L.friendUid = :uid";
		
		$query = $pdo->prepare($sql);
		$query->bindParam(':uid', $uid);
		$query->execute();

		if ($query->rowCount() > 0) {
			$results = $query->fetchAll();

			echo '<table>';

			foreach ($results as $row) {
				echo "<tr>";
				echo "<td>"; ?><div id="first<?php echo $row["id"]; ?>"> <?php echo $row['first']; ?> </div> <?php echo "</td>";
				echo "<td>"; ?><div id="last<?php echo $row["id"]; ?>"> <?php echo $row['last']; ?> </div> <?php echo "</td>";
				echo "<td>"; ?><div id="lUid<?php echo $row["id"]; ?>"> <?php echo '('.$row['lUid'].') wants to invite you to their leaderboard!'; ?> </div> <?php echo "</td>";
				
				echo "<td>"; ?> 
					<input type="button" class="acceptBtn" id="accept<?php echo $row["id"]; ?>" name="<?php echo $row["id"]; ?>" value="accept" onclick="acceptRow(this.name)"> 
					<input type="button" class="declineBtn" id="decline<?php echo $row["id"]; ?>" name="<?php echo $row["id"]; ?>" value="decline" onclick="declineRow(this.name)"> 

				<?php echo "</td>";
				
				echo "<tr>";
			}
		}
		else {
			echo 'No leaderboard requests';
		}
	}

	if ($status == "accept") {
		$id = $_GET["id"];

		$sql = "UPDATE leaderboards SET leaderboardRequest = 2 WHERE id=:id";
		$query = $pdo->prepare($sql);
		$query->bindParam(':id', $id);
		$query->execute();

	}

	if ($status == "decline") {
		$id = $_GET["id"];
		
		$sql = "DELETE FROM leaderboards WHERE id=:id";
		$query = $pdo->prepare($sql);
		$query->bindParam(':id', $id);
		$query->execute();
	}
?>