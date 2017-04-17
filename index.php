<?php 
/* Main page with two forms: sign up and log in */
require 'db.php';
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Sign Up / Log In</title>
	<link rel="stylesheet" type="text/css" href="mystyle.css">
</head>


<body>
<h1>Register</h1>
<div class="test"> 
  <form action="register.php" method="POST">
    <input type="text" name="first" placeholder="First Name" autocomplete="off"><br>
    <input type="text" name="last" placeholder="Last Name" autocomplete="off"><br>
    <input type="text" name="email" placeholder="Email" autocomplete="off"><br>
    <input type="text" name="uid" placeholder="Username" autocomplete="off"><br>
    <input type="password" name="pwd" placeholder="Password"><br>
    <button type="submit" name="register">Register</button>
  </form>
</div>

</body>
</html>