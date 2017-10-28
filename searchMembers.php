<!DOCTYPE html>
<html>
	<head>
		<h2>Search Members</h2>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <style>  
           ul {  
                background-color: #eee;  
                cursor: pointer;  

           }
           li{  
                padding: 12px;
           }
           li:hover {
           		background-color: #eeee00;
           }
           span {
           		display: none;
           }
        </style>
	</head>
	<body>
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
 		</script>
	</body>
</html>

