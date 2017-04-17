<?php

include 'db.php';
session_start();

$_SESSION['first'] = $_POST['first'];
$_SESSION['last'] = $_POST['last'];
$_SESSION['email'] = $_POST['email'];

$first = $_POST['first'];
$last = $_POST['last'];
$email = $_POST['email'];
$uid = $_POST['uid'];
$pwd = $_POST['pwd'];
$hash = password_hash($pwd, PASSWORD_DEFAULT);

// Require all fields to register
if (empty($first) || empty($last) || empty($email) || empty($uid) || empty($pwd) || empty($hash)) {
	$error = "Please complete all fields!";
	$_SESSION['error'] = "Please complete all fields to register!"."<br \>";
	header('location: error.php');
}
else {
	// Validify email
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error = "Please enter valid email!";
		$_SESSION['error'] = "Please enter valid email!"."<br \>";
	}

	$emailcheck = $pdo->prepare("SELECT * FROM users WHERE email = :email");
	$emailcheck->bindParam(':email', $email);
	$emailcheck->execute();
	$usercheck = $pdo->prepare("SELECT * FROM users WHERE uid = :uid");
	$usercheck->bindParam(':uid', $uid);
	$usercheck->execute();
	if ($emailcheck->rowCount() > 0) {
		$error = "User with this email already exists!";
		$_SESSION['error'] = "User with this email already exists!"."<br \>";
	}
	if ($usercheck->rowCount() > 0) {
		$error = "User with this username already exists!";
		$_SESSION['error'] .= "User with this username already exists!"."<br \>";
	}


	// Password length
	if (!strlen($pwd <= 6)) {
		$error = "Please enter password longer than 6 characters!";
		$_SESSION['error'] .= "Please enter password longer than 6 characters!"."<br \>";
	}
	if (isset($error)) {
		header('location: error.php');
	}
	else {
		//change to verify.php 
		header('location: index.php');
	}

}
// No error

if (!isset($error)) {
	// check if user exists with username and email
	$emailcheck = $pdo->prepare("SELECT * FROM users WHERE email = :email");
	$usercheck = $pdo->prepare("SELECT * FROM users WHERE uid = :uid");
	$emailcheck->bindParam(':email', $email);
	$usercheck->bindParam(':uid', $uid);
	$emailcheck->execute();
	$usercheck->execute();
	if ($emailcheck->rowCount() == 0 && $usercheck->rowCount() == 0) {
		// Securely insert into table
		$sql = "INSERT INTO users (first, last, email, uid, pwd, hash) VALUES (:first,:last,:email,:uid,:pwd,:hash)";
		$query = $pdo->prepare($sql);

		$query->execute(array(
			':first' => $first,
			':last' => $last,
			':email' => $email,
			':uid' => $uid,
			':pwd' => $pwd,
			':hash' => $hash
			));
	}
}


?>