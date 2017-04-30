<?php

include 'db.php';
//session_start();

$_SESSION['first'] = $_POST['first'];
$_SESSION['last'] = $_POST['last'];
$_SESSION['email'] = $_POST['email'];
$_SESSION['uid'] = $_POST['uid'];

$first = $_POST['first'];
$last = $_POST['last'];
$email = $_POST['email'];
$uid = $_POST['uid'];
$pwd = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
$hash = hash('SHA512', $pwd);

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

		if ($query) {

	        $_SESSION['active'] = 0; //0 until user activates their account with verify.php
	        $_SESSION['logged_in'] = true; // So we know the user has logged in
	        $_SESSION['message'] =
	                
	                 "Confirmation link has been sent to $email, please verify
	                 your account by clicking on the link in the message!";

	        // Send registration confirmation link (verify.php)
	        $to      = $email;
	        $subject = 'Account Verification (MyShotTracker.com)';
	        $message_body = '
	        Hello '.$first.',

	        Thank you for signing up!

	        Please click this link to activate your account:

	        https://myshottracker.000webhostapp.com/verify.php?email='.$email.'&hash='.$hash;

	        $headers = "From: " . $email . "\n";
			$headers .= "Reply-To: " . $email . "\n";

			ini_set("sendmail_from", $email);

			$sent = mail($to, $subject, $message_body, $headers, "-f" .$email);

			if ($sent) {
				header("location: profile.php"); 

			}
			else {
				$_SESSION['error'] = 'Email failed to send!';
				header("location: error.php");
			}

	    }
	    else {
	        $_SESSION['error'] = 'Registration failed!';
	        header("location: error.php");
	    }

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