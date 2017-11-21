<!DOCTYPE html>
<html>
	<head>
		<h1>Your Leaderboard Requests</h1>
		<link rel="stylesheet" type="text/css" href="onClickAddFriend.css" />

	</head>
	<body>
		<a href="leaderboards.php"><button class="leaderboardsBtn" name="leaderboards">Leaderboards</button></a>
		<a href="searchMembers.php"><button class="searchBtn" name="search">Search Members</button></a>
		<a href="profile.php"><button class="profileBtn" name="profile">My Profile</button></a>
		<a href="logout.php"><button class="logoutBtn" name="logout">Log Out</button></a>

		<div class="outgoingLeaderboardRequests">
			<h2>Outgoing Leaderboard Requests</h2>
			<?php 
				include 'db.php';
				session_start();

				if (isset($_SESSION['uid']) && isset($_SESSION['logged_in'])) {

					$uid = $_SESSION['uid'];

					$sql = "SELECT U.first, U.last, L.uid AS lUid, L.friendUid, L.leaderboardRequest FROM users U JOIN leaderboards L ON U.uid = L.friendUid";

					$query = $pdo->prepare($sql);

					$query->execute();
					// if there are results, then show results with accept and reject buttons on side
					// otherwise, print no results
					$count = 0;
					if ($query->rowCount() > 0) {
						
						$results = $query->fetchAll();

						foreach($results as $row) {
							//outgoing friend requests
							if ($uid == $row['lUid'] && $row['leaderboardRequest'] == 1) {
								$friendUid = $row['friendUid'];
								$friendFirst = $row['first'];
								$friendLast = $row['last'];
								echo $friendFirst.' '.$friendLast.' '.$friendUid.'<br>';
								$count++;
							}
						}
						if ($count == 0) {
							echo "No pending requests";
						}
					}
					else {
						echo "No pending requests";
					}
				}
				else {
					header("location: index.php");
				}
			?>
		</div>

		<div class="incomingLeaderboardRequests">
			<h2>Incoming Leaderboard Requests</h2>
			<div id="disp_data"></div>
		</div>


		<script type="text/javascript">
		  disp_data();
		  function disp_data() {
		    var xmlhttp = new XMLHttpRequest();
		    xmlhttp.open("GET", "updateLeaderboardRequests.php?status=disp",false);
		    xmlhttp.send(null);
		    document.getElementById("disp_data").innerHTML=xmlhttp.responseText;
		  }

		  function acceptRow(id) {
		  	var xmlhttp = new XMLHttpRequest();
		  	xmlhttp.open("GET", "updateLeaderboardRequests.php?id="+id+"&status=accept", false);
		  	xmlhttp.send(null);
		  	disp_data();
		  }

		  function declineRow(id) {
		    var xmlhttp = new XMLHttpRequest();
		    xmlhttp.open("GET", "updateLeaderboardRequests.php?id="+id+"&status=decline", false);
		    xmlhttp.send(null);
		    disp_data();
		  }

		</script>

	</body>
</html>