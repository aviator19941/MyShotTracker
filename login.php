<?php 
/* User login process, checks if user exists and password is correct */

include 'db.php';

$sql = "SELECT * FROM users WHERE uid = :uid";
$usercheck = $pdo->prepare($sql);
$usercheck->bindParam(':uid', $_POST['uid']);
$usercheck->execute();

if ($usercheck->rowCount() == 0) {
	// User doesn't exist
	echo "User doesn't exist!";
}
else {
	// User exists
	echo "User exists!<br \>";
	$result = $usercheck->fetchAll();

	foreach( $result as $row ) {
    	echo $row['first']."<br \>";
    	echo $row['last']."<br \>";
	}

}

/*if ($usercheck->rowCount() == 0) {
	// User doesn't exist
	$_SESSION['error'] = "User with that username doesn't exist!";
	header('location: error.php');
}
else {
	// User exists
	$pwdhash = $usercheck->fetchAll();
	if ( password_verify($_POST['pwd'], $pwdhash) ) {
        
        $_SESSION['email'] = $user['email'];
        $_SESSION['first'] = $user['first'];
        $_SESSION['last'] = $user['last'];
        $_SESSION['active'] = $user['active'];
        
        // This is how we'll know the user is logged in
        $_SESSION['logged_in'] = true;

        header("location: profile.php");
    }
    else {
        $_SESSION['error'] = "You have entered wrong password, try again!";
        header("location: error.php");
    }
}*/


?>