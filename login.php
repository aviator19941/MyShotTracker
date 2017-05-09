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
	$result = $usercheck->fetchAll();
	//print_r($result[0]['first']);
	$verify = password_verify($_POST['pwd'], $result[0]['pwd']);

	if($verify) {
	    $_SESSION['email'] = $result[0]['email'];
        $_SESSION['uid'] = $result[0]['uid'];
        $_SESSION['first'] = $result[0]['first'];
        $_SESSION['last'] = $result[0]['last'];
        $_SESSION['active'] = $result[0]['active'];
        
        // This is how we'll know the user is logged in
        $_SESSION['logged_in'] = true;

        header("location: profile.php");
	}
	else {
	    $_SESSION['error'] = "You have entered wrong password, try again!";
        header("location: error.php");
	}

}


?>