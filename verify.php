<?php 
/* Verifies registered user email, the link to this page
   is included in the register.php email message 
*/
require 'db.php';
session_start();


// Make sure email and hash variables aren't empty
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
	$email = $_GET['email'];
	$hash = $_GET['hash'];

	// Select user with matching email and hash, who hasn't verified their account yet (active = 0)
	$query = $pdo->prepare("SELECT * FROM users WHERE email = :email AND hash = :hash AND active='0'");
	$query->bindParam(':email', $email);
	$query->bindParam(':hash', $hash);

	if ( $query->num_rows == 0 ) { 
        $_SESSION['error'] = "Account has already been activated or the URL is invalid!";

        header("location: error.php");
    }
    else {
        $_SESSION['message'] = "Your account has been activated!";
        
        // Set the user status to active (active = 1)
        $updatequery = $pdo->prepare("UPDATE users SET active='1' WHERE email = :email");
        $updatequery->bindParam(':email', $email);
        $updatequery->execute();
        $_SESSION['active'] = 1;
        
        header("location: success.php");
    }
}
else {
    $_SESSION['error'] = "Invalid parameters provided for account verification!";
    header("location: error.php");
}     


?>