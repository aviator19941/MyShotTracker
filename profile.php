<?php
/* Displays user information and some useful messages */
require 'db.php';
session_start();

// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['error'] = "You must log in before viewing your profile page!";
  header("location: error.php");    
}
else {
    // Makes it easier to read
    $first = $_SESSION['first'];
    $last = $_SESSION['last'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
    $sql = "SELECT * FROM stats";

}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Welcome <?= $first.' '.$last ?></title>
</head>

<body>
  <div class="form">

          <h1>Welcome</h1>
          
          <p>
          <?php 
     
          // Display message about account verification link only once
          if ( isset($_SESSION['message']) )
          {
              echo $_SESSION['message'];
              
              // Don't annoy the user with more messages upon page refresh
              unset( $_SESSION['message'] );
          }
           
          ?>
          </p>
          
          <?php
          
            // Keep reminding the user this account is not active, until they activate
            if ( !$active ){
                echo
                '<div class="info">
                Account is unverified, please confirm your email by clicking
                on the email link!
                </div>';
            }
          
          ?>
          
          <h2><?php echo $first.' '.$last; ?></h2>
          <p><?= $email ?></p>

          <table width="100%" border="1" cellpadding="1" cellspacing="1">
            <tr>
              
              <th>Golf Course</th>
              <th>Score</th>
              <th>Fairways</th>
              <th>GIRs</th>
              <th>Sand Saves</th>
              <th>Up & Downs</th>
              <th>Putts</th>

            </tr>

          </table>
          
          <a href="logout.php"><button class="button button-block" name="logout"/>Log Out</button></a>

    </div>
    
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>

</body>
</html>
