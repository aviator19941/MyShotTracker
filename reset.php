<?php
/* The password reset form, the link to this page is included
   from the forgot.php email message
*/
require 'db.php';
session_start();

// Make sure email and hash variables aren't empty
if( isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']) )
{
    // Make sure user email with matching hash exist
	$email = $_GET['email'];
	$hash = $_GET['hash'];

	$result = $pdo->prepare("SELECT * FROM users WHERE email = :email AND hash = :hash");
	$result->bindParam(':email', $email);
	$result->bindParam(':hash', $hash);
	$result->execute();

    if ( $result->rowCount() == 0 )
    { 
        $_SESSION['error'] = "You have entered invalid URL for password reset!";
        header("location: error.php");
    }
}
else {
    $_SESSION['error'] = "Sorry, verification failed, try again!";
    header("location: error.php");  
}
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Reset Your Password</title>
</head>

<body>
    <div class="form">

          <h1>Choose Your New Password</h1>
          
          <form action="reset_password.php" method="post">
              
          <div class="field-wrap">
            <label>
              New Password<span class="req">*</span>
            </label>
            <input type="password" required name="newpassword" id="newpassword" onkeyup="check()" autocomplete="off"/>
          </div>
              
          <div class="field-wrap">
            <label>
              Confirm New Password<span class="req">*</span>
            </label>
            <input type="password" required name="confirmpassword" id="confirmpassword" onkeyup="check()" autocomplete="off"/>
            <span id='message'></span>
          </div>
          
          <!-- This input field is needed, to get the email of the user -->
          <input type="hidden" name="email" value="<?= $email ?>">    
          <input type="hidden" name="hash" value="<?= $hash ?>">    
              
          <button class="button button-block" onclick="alertBox()">Apply</button>
          
          </form>

    </div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script>
var check = function() {
  if (document.getElementById('newpassword').value ==
    document.getElementById('confirmpassword').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = 'Matching';
  } 
  else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'Not matching, make sure passwords match!';
  }
}

</script>
</body>
</html>
