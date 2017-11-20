<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="onClickAddFriend.css"/>
	</head>
</html>

<?php
	session_start();
	include 'db.php';

	$status = $_GET["status"];

	if ($status == "disp") {
		$uid = $_SESSION['uid'];
		$sql = "SELECT U.first, U.last, F.id AS id, F.uid AS fUid, F.friendUid, F.friendRequest FROM users U JOIN friends F ON U.uid = F.uid";
		$query = $pdo->prepare($sql);
		$query->execute();

		$count = 0;
		// if there are results, then show results with accept and reject buttons on side
		// otherwise, print no results
		if ($query->rowCount() > 0) {
			
			$results = $query->fetchAll();
			echo "<table>";
			foreach($results as $row) {
				if ($uid == $row['friendUid'] && $row['friendRequest'] == 0) {
					echo "<tr>";
					echo "<td>"; ?><div id="first<?php echo $row["id"]; ?>"> <?php echo $row['first']; ?> </div> <?php echo "</td>";
					echo "<td>"; ?><div id="last<?php echo $row["id"]; ?>"> <?php echo $row['last']; ?> </div> <?php echo "</td>";
					echo "<td>"; ?><div id="fUid<?php echo $row["id"]; ?>"> <?php echo '('.$row['fUid'].') wants to friend you!'; ?> </div> <?php echo "</td>";
					
					echo "<td>"; ?> 
						<input type="button" class="acceptBtn" id="accept<?php echo $row["id"]; ?>" name="<?php echo $row["id"]; ?>" value="accept" onclick="acceptRow(this.name)"> 
						<input type="button" class="declineBtn" id="decline<?php echo $row["id"]; ?>" name="<?php echo $row["id"]; ?>" value="decline" onclick="declineRow(this.name)"> 

					<?php echo "</td>";
					
					echo "<tr>";
					$count++;
				}
			}
			echo "</table>";
			if ($count == 0) {
				echo "No pending requests";
			}
		}
		else {
			echo "No pending requests";
		}
	}

	if ($status == "accept") {
		$id = $_GET["id"];

		$sql = "UPDATE friends SET friendRequest = 1 WHERE id=:id";
		$query = $pdo->prepare($sql);
		$query->bindParam(':id', $id);
		$query->execute();

	}

	if ($status == "decline") {
		$id = $_GET["id"];
		
		$sql = "DELETE FROM friends WHERE id=:id";
		$query = $pdo->prepare($sql);
		$query->bindParam(':id', $id);
		$query->execute();
	}

?>