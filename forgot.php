<?php 
/* Reset your password form, sends reset.php password link */
require 'db.php';
session_start();

// Check if form submitted with method="post"
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) 
{   
    $email = $_POST['email'];
    $sql = "SELECT * FROM users WHERE email = :email";
    $result = $pdo->prepare($sql);
    $result->bindParam(':email', $_POST['email']);
    $result->execute();

    if ($result->rowCount() == 0) { // User doesn't exist!
        $_SESSION['error'] = "User with that email doesn't exist!";
        header("location: error.php"); 
    }
    else { // User exists
        $user = $result->fetchAll(); // $user becomes array with user data
        
        $email = $user[0]['email'];
        $hash = $user[0]['hash'];
        $first = $user[0]['first'];

        // Session message to display on success.php
        $_SESSION['message'] = "<p>Please check your email <span>$email</span>"
        . " for a confirmation link to complete your password reset!</p>";

        // Send registration confirmation link (reset.php)
        $to      = $email;
        $subject = 'Password Reset Link (MyShotTracker.com)';
        $message_body = '
        Hello '.$first.',

        You have requested password reset!

        Please click this link to reset your password:

        https://myshottracker.000webhostapp.com/reset.php?email='.$email.'&hash='.$hash;

        $headers = "From: " . $email . "\n";
        $headers .= "Reply-To: " . $email . "\n";

        ini_set("sendmail_from", $email);

        $sent = mail($to, $subject, $message_body, $headers, "-f" .$email);

        if ($sent) {
          header("location: success.php"); 

        }
        else {
          $_SESSION['error'] = 'Email failed to send!';
          header("location: error.php");
        }
    }
    
   
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Reset Your Password</title>
  <link rel="stylesheet" type="text/css" href="table.css" />
</head>

<body>
    
  <div class="form">

    <h1>Reset Your Password</h1>

    <form action="forgot.php" method="post">
     <div class="field-wrap">
      <label>
        Email Address<span class="req">*</span>
      </label>
      <input type="text" required autocomplete="off" name="email"/>
    </div>
    <button class="resetBtn"/>Reset</button>
    </form>
  </div>
          
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>
</body>

</html>
