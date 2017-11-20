<!DOCTYPE html>
<html>
	<head>
		<title>My Leaderboards</title>
		<h1>My Leaderboards</h1>
		<link rel="stylesheet" type="text/css" href="leaderboards.css" />
	</head>
	<body>
		<a href="searchMembers.php"><button class="searchBtn" name="search">Search Members</button></a>
		<a href="logout.php"><button class="logoutBtn" name="logout">Log Out</button></a>
		<a href="pendingRequests.php"><button class="pendingRequestsBtn" name="pendingRequests">Pending Requests</button></a>
		<a href="leaderboardRequests.php"><button class="leaderboardRequestsBtn" name="leaderboardRequests">Leaderboard Requests</button></a>

		<div class="addFriendsToLeaderboard">
			<h3>Add Friends to Leaderboard</h3>
			<div id="disp_friends"></div>
		</div>

		<div class="leaderboards">
			<h2>Leaderboard (Average Score)</h2>
			
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