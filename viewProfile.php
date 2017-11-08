

<?php 
//attach user id with name search
	include 'db.php';
	
	$nameSearched = $_SERVER["QUERY_STRING"];
	$new = str_replace("%20", " ", $nameSearched);
	$nameArr = explode(" ", $new);
	$first = $nameArr[0];
	$last = $nameArr[1];
	$uid = $nameArr[2];
	
	$sql = "SELECT * FROM stats ORDER BY Id DESC";
	$query = $pdo->prepare($sql);
	$query->execute();
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="table.css" />
	</head>
	<body>
  		<div class="form">
          <h1><?= $first.' '.$last ?>'s Statistics</h1>
          
          <p>
          <?php 
     
          // Display message about account verification link only once
          if ( isset($_SESSION['message']) )
          {
              echo $_SESSION['message'];
              
              // Don't annoy the user with more messages upon page refresh
              unset( $_SESSION['message'] );
          }
           
          ?>
          </p>
          
          <p><?= 'User id: '.$uid ?></p>

  		</div>
  		<a href="searchMembers.php?<?php echo $uid;?>"><button class="searchBtn" name="search">Request as Friend</button></a>

	</body>
</html>

<?php
	echo "<table>";
	echo "<tr>";
	echo "<th>Golf Course</th>";
	echo "<th>Score</th>";
	echo "<th>Fairways</th>";
	echo "<th>GIR's</th>";
	echo "<th>Sand Saves</th>";
	echo "<th>Up & Downs</th>";
	echo "<th>Putts</th>";
	while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
	    if ($uid == $row['uid']) {
	      echo "<tr>";

	      echo "<td class=\"data\">"; ?><div class="golfcourse" id="golfcourse<?php echo $row["id"]; ?>"> <?php echo $row['golfcourse']; ?> </div> <?php echo "</td>";
	      echo "<td class=\"data\">"; ?><div class="score" id="score<?php echo $row["id"]; ?>"> <?php echo $row['score']; ?> </div> <?php echo "</td>";
	      echo "<td class=\"data\">"; ?><div class="fairways" id="fairways<?php echo $row["id"]; ?>"> <?php echo $row['fairways']; ?> </div> <?php echo "</td>";
	      echo "<td class=\"data\">"; ?><div class="gir" id="gir<?php echo $row["id"]; ?>"> <?php echo $row['gir']; ?> </div> <?php echo "</td>";
	      echo "<td class=\"data\">"; ?><div class="sandsaves" id="sandsaves<?php echo $row["id"]; ?>"> <?php echo $row['sandsaves']; ?> </div> <?php echo "</td>";
	      echo "<td class=\"data\">"; ?><div class="upanddowns" id="upanddowns<?php echo $row["id"]; ?>"> <?php echo $row['upanddowns']; ?> </div> <?php echo "</td>";
	      echo "<td class=\"data\">"; ?><div class="putts" id="putts<?php echo $row["id"]; ?>"> <?php echo $row['putts']; ?> <?php echo "</td>";
	      
	      echo "<td>"; ?> 

	      <?php echo "</td>";

	      echo "<tr>";
	    }
	} 
	echo "</table>";

?>


