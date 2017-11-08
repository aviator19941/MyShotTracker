<!DOCTYPE html>
<html>
	<head>
		<h2>Search Members</h2>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="onClickAddFriend.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        
	</head>
	<body>
		<div id="toggleAlert" class="alert">
  			<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  			<strong>Friend request pending.</strong>
  		</div>

  		<a href="profile.php"><button class="profileBtn" name="profile">My Profile</button></a>
		<a href="pendingRequests.php"><button class="pendingRequestsBtn" name="pendingRequests"/>Pending Requests</button></a>

		<div class="container" style="width:500px;">  
            <label>Enter Member name</label>  
            <input type="text" name="member" id="member" class="form-control" placeholder="Enter Member Name" />  
            <div id="memberList"></div>
        </div>  

		<script>  
 			$(document).ready(function(){  
      			$('#member').keyup(function(){  
           			var query = $(this).val(); 
           			var value = document.getElementById('member').value;
           			if (value.length == 0) {
           				$('#memberList').fadeOut();
           			} 
           			if(query != '')  
           			{  
                		$.ajax({  
		                     url:"getMembers.php",  
		                     method:"POST",  
		                     data:{query:query},  
		                     success:function(data)  
		                     {  
		                          $('#memberList').fadeIn();  
		                          $('#memberList').html(data);
		                     }  
                		});  
           			}  
      			});  
      			$(document).on('click', 'li', function(){
           			var nameToAppend = $(this).text();
           			var viewProfileLink = "/myshottracker/viewProfile.php?" + nameToAppend;
           			$('#memberList').fadeOut();
           			$(location).attr('href', viewProfileLink);
           			document.getElementById("member").value = "";
      			});  
 			});

			var oldURL = document.referrer;
			if (oldURL != "" && oldURL != "http://localhost:1234/myshottracker/profile.php") {
				document.getElementById("toggleAlert").style.display = "block";
			}

 		</script>
	</body>
</html>

<?php
	include 'db.php';
	session_start();

	if (isset($_SESSION['uid']) && isset($_SESSION['logged_in'])) {

		$uid = $_SESSION['uid'];

		if (isset($_SERVER["QUERY_STRING"]) && $_SERVER["QUERY_STRING"] != '') {
			$friendUid = $_SERVER["QUERY_STRING"];

			$sql = "INSERT INTO friends (friendUid, uid) VALUES (:friendUid, :uid)";

			$query = $pdo->prepare($sql);
			$query->execute(array(
				':friendUid' => $friendUid,
				':uid' => $uid
			));
		}
	}
	else {
		header("location: index.php");
	}

	
?>
