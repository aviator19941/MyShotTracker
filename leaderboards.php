<!DOCTYPE html>
<html>
	<head>
		<title>My Leaderboard</title>
		<h1>My Leaderboard</h1>
		<link rel="stylesheet" type="text/css" href="leaderboards.css" />
	</head>
	<body>
		<a href="searchMembers.php"><button class="searchBtn" name="search">Search Members</button></a>
		<a href="logout.php"><button class="logoutBtn" name="logout">Log Out</button></a>
		<a href="pendingRequests.php"><button class="pendingRequestsBtn" name="pendingRequests">Pending Requests</button></a>
		<a href="leaderboardRequests.php"><button class="leaderboardRequestsBtn" name="leaderboardRequests">Leaderboard Requests</button></a>

		<div class="addFriendsToLeaderboard">
			<h3>Add Friends to Leaderboard</h3>
			<?php
				session_start();
				include 'db.php';
				$uid = $_SESSION['uid'];

				$sql6 = "SELECT * FROM leaderboards WHERE friendUid = :friendUid AND uid = :uid";
		      	$query6 = $pdo->prepare($sql6);
		      	$query6->bindParam(':friendUid', $uid);
		      	$query6->bindParam(':uid', $uid);
		      	$query6->execute();

		      	if ($query6->rowCount() > 0) {
		      		$results6 = $query6->fetchAll();
		      		foreach ($results6 as $row6) {	      		
			      		if ($row6['leaderboardRequest'] == 2) {

			      		}
			      	}
			    }
			    else {
					$sql = "INSERT INTO leaderboards (friendUid, uid, avgScore, leaderboardRequest) VALUES (:friendUid, :uid, :avgScore, :leaderboardRequest)";

					$sql5 = "SELECT AVG(S.score) AS avgScore FROM users U JOIN stats S ON U.uid = S.uid WHERE S.uid = :uid";
			      	
			      	$query5 = $pdo->prepare($sql5);

			      	$query5->bindParam(':uid', $uid);
			      	$query5->execute();

			      	if ($query5->rowCount() > 0) {
			      		$results = $query5->fetchAll();

			      		foreach($results as $row5) {
			      			$avgScore = $row5['avgScore'];
			      			if (is_null($avgScore)) 
			      				$avgScore = 0;
		      			}
		      		}
					$query = $pdo->prepare($sql);
					$query->bindParam(':friendUid', $uid);
					$query->bindParam(':uid', $uid);
					$query->bindParam(':avgScore', $avgScore);
					$query->bindValue(':leaderboardRequest', 2);
					$query->execute();
				
				}

			?>
			<div id="disp_friends"></div>
		</div>

		<div class="leaderboards">
			<h2>Leaderboard (Average Score)</h2>
			<?php 
				include 'db.php';
				$uid = $_SESSION['uid'];

				$sql = "SELECT L.id, U.first, U.last, L.friendUid, L.uid, L.avgScore FROM users U JOIN leaderboards L ON U.uid = L.friendUid AND L.leaderboardRequest = 2 WHERE L.uid = ? ORDER BY L.avgScore";

				$query = $pdo->prepare($sql);
				$query->bindParam(1, $uid);
				$query->execute();

				if ($query->rowCount() > 1) {
					$results = $query->fetchAll();

					echo "<table>";
					echo "<tr>";
					echo "<th>First Name</th>";
					echo "<th>Last Name</th>";
					echo "<th>Average Score</th>";
					echo "</tr>";
					foreach($results as $row) {
						//echo $row['first'].' '.$row['last'].' '.$row['avgScore'].'<br>';
						echo "<tr>";
				      	echo "<td class=\"data\">"; ?><div id="first<?php echo $row["id"]; ?>"> <?php echo $row['first']; ?> </div> <?php echo "</td>";
				      	echo "<td class=\"data\">"; ?><div id="last<?php echo $row["id"]; ?>"> <?php echo $row['last']; ?> </div> <?php echo "</td>";
				      	echo "<td class=\"data\">"; ?><div id="avgScore<?php echo $row["id"]; ?>"> <?php echo $row['avgScore']; ?> </div> <?php echo "</td>";
						echo "<tr>";
					}
					echo "</table>";
					
				}
				else if ($query->rowCount() == 1) {
					$sql2 = "SELECT * FROM users U JOIN leaderboards L ON U.uid = L.friendUid AND L.leaderboardRequest = 2 WHERE L.uid = ? ORDER BY L.avgScore";
					$query2 = $pdo->prepare($sql2);
					$query2->bindParam(1, $uid);
					$query2->execute();

					$results2 = $query2->fetchAll();

					echo "<table>";
					echo "<tr>";
					echo "<th>First Name</th>";
					echo "<th>Last Name</th>";
					echo "<th>Average Score</th>";
					echo "</tr>";
					foreach($results2 as $row2) {
						//echo $row2['first'].' '.$row2['last'].' '.$row2['avgScore'].'<br>';
						echo "<tr>";
				      	echo "<td class=\"data\">"; ?><div id="first<?php echo $row2["id"]; ?>"> <?php echo $row2['first']; ?> </div> <?php echo "</td>";
				      	echo "<td class=\"data\">"; ?><div id="last<?php echo $row2["id"]; ?>"> <?php echo $row2['last']; ?> </div> <?php echo "</td>";
				      	echo "<td class=\"data\">"; ?><div id="avgScore<?php echo $row2["id"]; ?>"> <?php echo $row2['avgScore']; ?> </div> <?php echo "</td>";
						echo "<tr>";
					}
					echo '</table>';
				}
				else {
					echo 'Add friends to leaderboard';
				}
				
			?>
		</div>

		<script type="text/javascript">
		  disp_friends();
		  function disp_friends() {
		  	var xmlhttp = new XMLHttpRequest();
		    xmlhttp.open("GET", "updateLeaderboard.php?status=display",false);
		    xmlhttp.send(null);
		    document.getElementById("disp_friends").innerHTML=xmlhttp.responseText;
		  }

		  function addRow(id) {
		  	var xmlhttp = new XMLHttpRequest();
		  	xmlhttp.open("GET", "updateLeaderboard.php?id="+id+"&status=addToLeaderboard", false);
		  	xmlhttp.send(null);
		  	disp_friends();
		  }


		</script>

	</body>
</html>