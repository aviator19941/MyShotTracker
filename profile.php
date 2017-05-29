<?php
/* Displays user information and some useful messages */
include 'db.php';
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
    $uid = $_SESSION['uid'];

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
                //$_SESSION['error'] = "Account is unverified, please confirm your email by clicking on the email link!";
                //header("location: error.php");
                
            }
          
          ?>
          
          <h2><?php echo $first.' '.$last; ?></h2>
          <p><?= $email ?></p>

  </div>

<form name="form1" action="" method="post">
  <div id="disp_data"></div>

  <input type="text" id="txtgolfcourseins" placeholder="Golf Course">
  <input type="text" id="txtscoreins" placeholder="Score">
  <input type="button" id="but1" value="insert" onclick="insert();">
</form>

<a href="logout.php"><button class="button button-block" name="logout"/>Log Out</button></a>


<script type="text/javascript">
  disp_data();
  function disp_data() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "update.php?status=disp",false);
    xmlhttp.send(null);
    document.getElementById("disp_data").innerHTML=xmlhttp.responseText;
  }

  function toggle(up) {
    var x = document.getElementById(up);
    if (x.style.visibility === 'hidden') {
        x.style.visibility = 'visible';
    } else {
        x.style.visibility = 'hidden';
    }
  }

  function editRow(val) {

    golfcourseid = "golfcourse"+val;
    txtgolfcourseid = "txtgolfcourse"+val;
    var golfcourse = document.getElementById(golfcourseid).innerHTML;
    document.getElementById(golfcourseid).innerHTML="<input type='text' value='"+golfcourse+"' id='"+txtgolfcourseid+"'>";

    scoreid = "score"+val;
    txtscoreid = "txtscore"+val;
    var score = document.getElementById(scoreid).innerHTML;
    document.getElementById(scoreid).innerHTML="<input type='text' value='"+score+"' id='"+txtscoreid+"'>";


    updateid = "update"+val;
    editid = "edit"+val;
    deleteid = "delete"+val;
    toggle(editid);
    toggle(deleteid);
    toggle(updateid);
  }


  function updateRow(b) {
    var golfcourseid = "txtgolfcourse"+b;
    var golfcourse = document.getElementById(golfcourseid).value;

    var scoreid = "txtscore"+b;
    var score = document.getElementById(scoreid).value;


    update_value(b,golfcourse,score);

    updateid = "update"+b;
    editid = "edit"+b;
    deleteid = "delete"+b;
    toggle(editid);
    toggle(deleteid);
    toggle(updateid);

    document.getElementById("golfcourse"+b).innerHTML=golfcourse;
    document.getElementById("score"+b).innerHTML=score;

  }

  function update_value(id,golfcourse,score) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "update.php?id="+id+"&golfcourse="+golfcourse+"&score="+score+"&status=update",false);
    xmlhttp.send(null);
  }

  function deleteRow(id) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "update.php?id="+id+"&status=delete",false);
    xmlhttp.send(null);
    disp_data();
  }

  function insert() {
    var gc = document.getElementById("txtgolfcourseins").value;
    var score = document.getElementById("txtscoreins").value;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "update.php?gc="+gc+"&score="+score+"&status=insert",false);
    xmlhttp.send(null);
    disp_data();

    document.getElementById("txtgolfcourseins").value = "";
    document.getElementById("txtscoreins").value = "";
  }

</script>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>

</body>
</html>
