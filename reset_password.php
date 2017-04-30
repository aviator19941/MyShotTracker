<?php
/* Password reset process, updates database with new user password */
require 'db.php';
session_start();

// Make sure the form is being submitted with method="post"
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

    // Make sure the two passwords match
    if ( $_POST['newpassword'] == $_POST['confirmpassword'] ) { 

        $new_password = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
        
        // We get $_POST['email'] and $_POST['hash'] from the hidden input field of reset.php form
        $email = $_POST['email'];
        $hash = $_POST['hash'];

        $sql = "UPDATE users SET pwd = :new_password, hash = :hash WHERE email = :email";
        $query = $pdo->prepare($sql);
        $query->bindParam(':new_password', $new_password);
        $query->bindParam(':hash', $hash);
        $query->bindParam(':email', $email);
        $query->execute();

        if ($query->rowCount() > 0) {

            $_SESSION['message'] = "Your password has been reset successfully!";
            header("location: success.php");    

        }

    }
    else {
        $_SESSION['message'] = "Two passwords you entered don't match, try again!";
        header("location: error.php");    
    }

}
?>