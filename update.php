<?php 

session_start();
include 'db.php';


$status = $_GET["status"];

if ($status == "disp") {
    $uid = $_SESSION['uid'];
	$sql = "SELECT * FROM stats ORDER BY Id DESC";
	$query = $pdo->prepare($sql);
	$query->execute();


	echo "<table style=\"border-collapse: collapse;\">";
	echo "<tr>";
	echo "<th style=\"text-align: left; background-color: #4CAF50; color: white; padding: 8px; border: 1px solid black;\">Golf Course</th>";
	echo "<th style=\"text-align: left; background-color: #4CAF50; color: white; padding: 8px; border: 1px solid black;\">Score</th>";
	echo "<th style=\"text-align: left; background-color: #4CAF50; color: white; padding: 8px; border: 1px solid black;\">Fairways</th>";
	echo "<th style=\"text-align: left; background-color: #4CAF50; color: white; padding: 8px; border: 1px solid black;\">GIR's</th>";
	echo "<th style=\"text-align: left; background-color: #4CAF50; color: white; padding: 8px; border: 1px solid black;\">Sand Saves</th>";
	echo "<th style=\"text-align: left; background-color: #4CAF50; color: white; padding: 8px; border: 1px solid black;\">Up & Downs</th>";
	echo "<th style=\"text-align: left; background-color: #4CAF50; color: white; padding: 8px; border: 1px solid black;\">Putts</th>";
	while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
	    if ($uid == $row['uid']) {
	      echo "<tr>";

	      echo "<td style=\"text-align: left; padding: 8px; border: 1px solid black;\">"; ?><div style="width: 158px" id="golfcourse<?php echo $row["id"]; ?>"> <?php echo $row['golfcourse']; ?> </div> <?php echo "</td>";
	      echo "<td style=\"text-align: left; padding: 8px; border: 1px solid black;\">"; ?><div style="width: 160px" id="score<?php echo $row["id"]; ?>"> <?php echo $row['score']; ?> </div> <?php echo "</td>";
	      echo "<td style=\"text-align: left; padding: 8px; border: 1px solid black;\">"; ?><div style="width: 160px" id="fairways<?php echo $row["id"]; ?>"> <?php echo $row['fairways']; ?> </div> <?php echo "</td>";
	      echo "<td style=\"text-align: left; padding: 8px; border: 1px solid black;\">"; ?><div style="width: 160px" id="gir<?php echo $row["id"]; ?>"> <?php echo $row['gir']; ?> </div> <?php echo "</td>";
	      echo "<td style=\"text-align: left; padding: 8px; border: 1px solid black;\">"; ?><div style="width: 160px" id="sandsaves<?php echo $row["id"]; ?>"> <?php echo $row['sandsaves']; ?> </div> <?php echo "</td>";
	      echo "<td style=\"text-align: left; padding: 8px; border: 1px solid black;\">"; ?><div style="width: 160px" id="upanddowns<?php echo $row["id"]; ?>"> <?php echo $row['upanddowns']; ?> </div> <?php echo "</td>";
	      echo "<td style=\"text-align: left; padding: 8px; border: 1px solid black;\">"; ?><div style="width: 111px" id="putts<?php echo $row["id"]; ?>"> <?php echo $row['putts']; ?> <?php echo "</td>";
	      

	      echo "<td>"; ?> 
	      <input type="button" id="edit<?php echo $row["id"]; ?>" name="<?php echo $row["id"]; ?>" value="edit" onclick="editRow(this.name)"> 

	      <input type="button" id="delete<?php echo $row["id"]; ?>" name="<?php echo $row["id"]; ?>" value="delete" onclick="deleteRow(this.name)">
	      
	      <?php echo "</td>";
	      echo "<td>"; ?> 
	      <input type="button" id="update<?php echo $row["id"]; ?>" name="<?php echo $row["id"]; ?>" value="update" style="visibility: hidden" onclick="updateRow(this.name)"> 



	      <?php echo "</td>";


	      echo "<tr>";
	    }
	} 

	echo "</table>";

}

if ($status == "update") {
	$id = $_GET["id"];
	$golfcourse = $_GET["golfcourse"];
	$score = $_GET["score"];
	$fairways = $_GET["fairways"];
	$gir = $_GET["gir"];
	$sandsaves = $_GET["sandsaves"];
	$upanddowns = $_GET["upanddowns"];
	$putts = $_GET["putts"];

	$golfcourse = trim($golfcourse);
	$score = trim($score);
	$fairways = trim($fairways);
	$gir = trim($gir);
	$sandsaves = trim($sandsaves);
	$upanddowns = trim($upanddowns);
	$putts = trim($putts);

	$sql = "UPDATE stats SET golfcourse=:golfcourse, score=:score, fairways=:fairways, gir=:gir, sandsaves=:sandsaves,
	upanddowns=:upanddowns, putts=:putts WHERE id=:id";
	$query = $pdo->prepare($sql);
	$query->bindParam(':golfcourse', $golfcourse);
	$query->bindParam(':score', $score);
	$query->bindParam(':fairways', $fairways);
	$query->bindParam(':gir', $gir);
	$query->bindParam(':sandsaves', $sandsaves);
	$query->bindParam(':upanddowns', $upanddowns);
	$query->bindParam(':putts', $putts);
	$query->bindParam(':id', $id);
	$query->execute();
}

if ($status == "delete") {
	$id = $_GET["id"];

	$sql = "DELETE FROM stats WHERE id=:id";
	$query = $pdo->prepare($sql);
	$query->bindParam(':id', $id);
	$query->execute();

}

if ($status == "insert") {
	$gc = $_GET["gc"];
	$score = $_GET["score"];
	$fairways = $_GET["fairways"];
	$gir = $_GET["gir"];
	$sandsaves = $_GET["sandsaves"];
	$upanddowns = $_GET["upanddowns"];
	$putts = $_GET["putts"];
	$uid = $_SESSION['uid'];

	//$sql = "INSERT INTO stats (golfcourse, score, fairways, gir, sandsaves, upanddowns, putts, uid) 
	//VALUES (:gc, :score, :fairways, :gir, :sandsaves, :upanddowns, :putts, :uid)";
	$sql = "INSERT INTO stats (golfcourse, score, fairways, gir, sandsaves, upanddowns, putts, uid) 
	VALUES (:gc, :score, :fairways, :gir, :sandsaves, :upanddowns, :putts, :uid)";
	$query = $pdo->prepare($sql);
	$query->bindParam(':gc', $gc);
	$query->bindParam(':score', $score);
	$query->bindParam(':fairways', $fairways);
	$query->bindParam(':gir', $gir);
	$query->bindParam(':sandsaves', $sandsaves);
	$query->bindParam(':upanddowns', $upanddowns);
	$query->bindParam(':putts', $putts);
	$query->bindParam(':uid', $uid);
	$query->execute();
}


?>