<?php

$servername = "localhost"; //change when testing!!!!
$username = "root";
$password = "kingdomhearts";
$dbname = "accounts";


try {
	$pdo = new PDO("mysql:host=$servername;dbname=accounts;charset=utf8", $username, $password);
	//set the PDO error mode to exception
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	//echo "Connected successfully";
}
catch (PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}

?>