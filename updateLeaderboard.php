<?php
	session_start();
	include 'db.php';

	$status = $_GET['status'];
	$friendUid = "";
	$uid = $_SESSION['uid'];

	if ($status == "display") {
		
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

	      echo "<table>";

	      foreach($results as $row) {
	      	// CHECK IF IT SHOULD BE FRIENDUID OR JUST UID!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	      	$sql7 = "SELECT * FROM leaderboards WHERE friendUid = :friendUid AND uid = :uid";
	      	
	      	$query7 = $pdo->prepare($sql7);
	      	$query7->bindParam(':friendUid', $uid);
	      	$query7->bindParam(':uid', $row['uid']);
	      	$query7->execute();

	      	if ($query7->rowCount() > 0) {
	      		$results7 = $query7->fetchAll();

	      		foreach($results7 as $row7) {
	      			if ($row7['leaderboardRequest'] == 0) {
						echo "<tr>";
				      	echo "<td>"; ?><div id="first<?php echo $row["id"]; ?>"> <?php echo $row['first']; ?> </div> <?php echo "</td>";
				      	echo "<td>"; ?><div id="last<?php echo $row["id"]; ?>"> <?php echo $row['last']; ?> </div> <?php echo "</td>";
				      	echo "<td>"; ?><div id="uid<?php echo $row7["id"]; ?>"> <?php echo $row7['uid']; ?> </div> <?php echo "</td>";
				      	echo "<td>"; ?> 

							<input type="button" class="addBtn" id="add<?php echo $row7["id"]; ?>" name="<?php echo $row7["id"]; ?>" value="add" onclick="addRow(this.name)"> 

						<?php echo "</td>";
						
						echo "<tr>";
	      			}
	      		}
	      	}

	      	
	        //echo 'Query 1: '.$row['first'].' '.$row['last'].' '.$row['uid'].'<br>';
	      }
	    }
	    else if ($query2->rowCount() > 0) {
	      $results2 = $query2->fetchAll();

	      echo "<table>";

	      foreach($results2 as $row2) {

	      	$friendUid = $row2['friendUid'];

	      	$sql6 = "SELECT * FROM leaderboards WHERE friendUid = :friendUid AND uid = :uid";
	      	$query6 = $pdo->prepare($sql6);
	      	$query6->bindParam(':friendUid', $friendUid);
	      	$query6->bindParam(':uid', $uid);
	      	$query6->execute();

	      	if ($query6->rowCount() > 0) {
	      		$results6 = $query6->fetchAll();
	      		foreach ($results6 as $row6) {	      		
		      		if ($row6['leaderboardRequest'] == 0) {
			      		echo "<tr>";
				      	echo "<td>"; ?><div id="first<?php echo $row2["id"]; ?>"> <?php echo $row2['first']; ?> </div> <?php echo "</td>";
				      	echo "<td>"; ?><div id="last<?php echo $row2["id"]; ?>"> <?php echo $row2['last']; ?> </div> <?php echo "</td>";
				      	echo "<td>"; ?><div id="friendUid<?php echo $row6["id"]; ?>"> <?php echo $row6['friendUid']; ?> </div> <?php echo "</td>";
				      	echo "<td>"; ?> 

							<input type="button" class="addBtn" id="add<?php echo $row6["id"]; ?>" name="<?php echo $row6["id"]; ?>" value="add" onclick="addRow(this.name)"> 

						<?php echo "</td>";

					
						echo "<tr>";
					}
					else {
						break;
					}
				}

	      	}
	      	else {
	      		$avgScore = 0;

		      	$sql4 = "INSERT INTO leaderboards (friendUid, uid, avgScore) VALUES (:friendUid, :uid, :avgScore)";

		      	$sql5 = "SELECT AVG(S.score) AS avgScore FROM users U JOIN stats S ON U.uid = S.uid WHERE S.uid = :friendUid";
		      	
		      	$query5 = $pdo->prepare($sql5);

		      	$query5->bindParam(':friendUid', $friendUid);
		      	$query5->execute();

		      	if ($query5->rowCount() > 0) {
		      		$results = $query5->fetchAll();

		      		foreach($results as $row5) {
		      			$avgScore = $row5['avgScore'];
		      			if (is_null($avgScore)) 
		      				$avgScore = 0;
	      			}
	      		}

	      		$query4 = $pdo->prepare($sql4);
		      	$query4->bindParam(':friendUid', $friendUid);
		      	$query4->bindParam(':uid', $uid);
		      	$query4->bindParam(':avgScore', $avgScore);
		      	$query4->execute();


		      	echo "<tr>";
		      	echo "<td>"; ?><div id="first<?php echo $row2["id"]; ?>"> <?php echo $row2['first']; ?> </div> <?php echo "</td>";
		      	echo "<td>"; ?><div id="last<?php echo $row2["id"]; ?>"> <?php echo $row2['last']; ?> </div> <?php echo "</td>";
		      	echo "<td>"; ?><div id="friendUid<?php echo $row2["id"]; ?>"> <?php echo $row2['friendUid']; ?> </div> <?php echo "</td>";
		      	echo "<td>"; ?> 

					<input type="button" class="addBtn" id="add<?php echo $row2["id"]; ?>" name="<?php echo $row2["id"]; ?>" value="add" onclick="addRow(this.name)"> 

				<?php echo "</td>";

			
				echo "<tr>";
	      	}

	        //echo 'Query 2: '.$row2['first'].' '.$row2['last'].' '.$row2['friendUid'].'<br>';
	      }
	      echo "</table>";


	    }
	    else {
	      echo "No friends yet";
	    }
	}


	if ($status == "addToLeaderboard") {
		// update column to be 1
		$id = $_GET['id'];
		$sql = "UPDATE leaderboards SET leaderboardRequest = 1 WHERE id = :id";

		$query = $pdo->prepare($sql);
		$query->bindParam(':id', $id);
		$query->execute();
	}

	
?>