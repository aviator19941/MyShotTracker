<?php 
/* Reset your password form, sends reset.php password link */
require 'db.php';
session_start();

// Check if form submitted with method="post"
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) 
{   
    //$email = $mysqli->escape_string($_POST['email']);
    //$result = $mysqli->query("SELECT * FROM users WHERE email='$email'");
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
        echo "User exists!";
    }
    
   
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Reset Your Password</title>
</head>

<body>
    
  <div class="form">

    <h1>Reset Your Password</h1>

    <form action="forgot.php" method="post">
     <div class="field-wrap">
      <label>
        Email Address<span class="req">*</span>
      </label>
      <input type="email"required autocomplete="off" name="email"/>
    </div>
    <button class="button button-block"/>Reset</button>
    </form>
  </div>
          
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>
</body>

</html>
