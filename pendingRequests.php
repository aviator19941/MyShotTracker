<!DOCTYPE html>
<html>
	<head>
		<h1>Your Pending Friend Requests</h1>
		<link rel="stylesheet" type="text/css" href="onClickAddFriend.css" />

	</head>
	<body>
		<a href="profile.php"><button class="profileBtn" name="profile">My Profile</button></a>

		<div class="outgoingRequests">
			<h3>Outgoing Friend Requests</h3>
			<?php 
				include 'db.php';
				session_start();

				if (isset($_SESSION['uid']) && isset($_SESSION['logged_in'])) {

					$uid = $_SESSION['uid'];

					$sql = "SELECT U.first, U.last, F.uid AS fUid, F.friendUid FROM users U JOIN friends F ON U.uid = F.friendUid";

					$query = $pdo->prepare($sql);

					$query->execute();
					// if there are results, then show results with accept and reject buttons on side
					// otherwise, print no results
					$count = 0;
					if ($query->rowCount() > 0) {
						
						$results = $query->fetchAll();

						foreach($results as $row) {
							//outgoing friend requests

							if ($uid == $row['fUid']) {
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

		<div class="incomingRequests">
			<h3>Incoming Friend Requests</h3>
			<div id="disp_data"></div>
		</div>


		<script type="text/javascript">
		  disp_data();
		  function disp_data() {
		    var xmlhttp = new XMLHttpRequest();
		    xmlhttp.open("GET", "updateRequests.php?status=disp",false);
		    xmlhttp.send(null);
		    document.getElementById("disp_data").innerHTML=xmlhttp.responseText;
		  }

		  function acceptRow(id) {
		  	var xmlhttp = new XMLHttpRequest();
		  	xmlhttp.open("GET", "updateRequests.php?id="+id+"&status=accept", false);
		  	xmlhttp.send(null);
		  	disp_data();
		  }

		  function declineRow(id) {
		    var xmlhttp = new XMLHttpRequest();
		    xmlhttp.open("GET", "updateRequests.php?id="+id+"&status=decline", false);
		    xmlhttp.send(null);
		    disp_data();
		  }

		</script>

	</body>
</html>

