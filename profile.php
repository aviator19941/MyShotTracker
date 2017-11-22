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
          <h1><?= $first.' '.$last ?>'s Statistics</h1>
          
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
          
          <p><?= $email ?></p>

  </div>

<form name="form1" action="" method="post">
  <div id="disp_data"></div>

  <input type="text" id="txtgolfcourseins" placeholder="Golf Course">
  <input type="text" id="txtscoreins" placeholder="Score">
  <input type="text" id="txtfairwaysins" placeholder="Fairways">
  <input type="text" id="txtgirins" placeholder="GIR's">
  <input type="text" id="txtsandsavesins" placeholder="Sand Saves">
  <input type="text" id="txtupanddownsins" placeholder="Up & Downs">
  <input type="text" id="txtputtsins" placeholder="Putts">

  <input type="button" class="insertBtn" id="but1" value="insert" onclick="insert();">
</form>

<a href="searchMembers.php"><button class="searchBtn" name="search">Search Members</button></a>
<a href="logout.php"><button class="logoutBtn" name="logout">Log Out</button></a>
<a href="pendingRequests.php"><button class="pendingRequestsBtn" name="pendingRequests">Pending Requests</button></a>
<a href="leaderboards.php"><button class="leaderboardsBtn" name="leaderboards">Leaderboards</button></a>

<div id="friendsList">
  <h3>Your Friends</h3>
  <?php 
    
    $sql = "SELECT * FROM users U JOIN friends F ON U.uid = F.uid AND F.friendRequest = 1 WHERE F.friendUid = :uid";

    $query = $pdo->prepare($sql);
    $query->bindParam(':uid', $uid);
    $query->execute();

    /*$sql = "SELECT * FROM users U JOIN friends F ON U.uid = F.friendUid AND F.friendRequest = 1 WHERE F.friendUid = ? OR F.uid = ?";

    $query = $pdo->prepare($sql);
    $query->bindParam(1, $uid);
    $query->bindParam(2, $uid);
    $query->execute();*/

    $sql2 = "SELECT * FROM users U JOIN friends F ON U.uid = F.friendUid AND F.friendRequest = 1 WHERE F.uid = :uid";

    $query2 = $pdo->prepare($sql2);
    $query2->bindParam(':uid', $uid);
    $query2->execute();

    if ($query->rowCount() > 0) {
      $results = $query->fetchAll();

      foreach($results as $row) {
        echo $row['first'].' '.$row['last'].' '.$row['uid'].'<br>';
      }
    }
    if ($query2->rowCount() > 0) {
      $results2 = $query2->fetchAll();

      foreach($results2 as $row2) {
        echo $row2['first'].' '.$row2['last'].' '.$row2['friendUid'].'<br>';
      }
    }
    else {
      echo "No friends yet";
    }
  ?>
</div>

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
    document.getElementById(golfcourseid).innerHTML="<input class='golfcourseedit' type='text' value='"+golfcourse+"' id='"+txtgolfcourseid+"'>";

    scoreid = "score"+val;
    txtscoreid = "txtscore"+val;
    var score = document.getElementById(scoreid).innerHTML;
    document.getElementById(scoreid).innerHTML="<input class='scoreedit' type='text' value='"+score+"' id='"+txtscoreid+"'>";

    fairwaysid = "fairways"+val;
    txtfairwaysid = "txtfairways"+val;
    var fairways = document.getElementById(fairwaysid).innerHTML;
    document.getElementById(fairwaysid).innerHTML="<input class='fairwaysedit' type='text' value='"+fairways+"' id='"+txtfairwaysid+"'>";

    girid = "gir"+val;
    txtgirid = "txtgir"+val;
    var gir = document.getElementById(girid).innerHTML;
    document.getElementById(girid).innerHTML="<input class='giredit' type='text' value='"+gir+"' id='"+txtgirid+"'>";

    sandsavesid = "sandsaves"+val;
    txtsandsavesid = "txtsandsaves"+val;
    var sandsaves = document.getElementById(sandsavesid).innerHTML;
    document.getElementById(sandsavesid).innerHTML="<input class='sandsavesedit' type='text' value='"+sandsaves+"' id='"+txtsandsavesid+"'>";

    upanddownsid = "upanddowns"+val;
    txtupanddownsid = "txtupanddowns"+val;
    var upanddowns = document.getElementById(upanddownsid).innerHTML;
    document.getElementById(upanddownsid).innerHTML="<input class='upanddownsedit' type='text' value='"+upanddowns+"' id='"+txtupanddownsid+"'>";

    puttsid = "putts"+val;
    txtputtsid = "txtputts"+val;
    var putts = document.getElementById(puttsid).innerHTML;
    document.getElementById(puttsid).innerHTML="<input class='puttsedit' type='text' value='"+putts+"' id='"+txtputtsid+"'>";

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

    var fairwaysid = "txtfairways"+b;
    var fairways = document.getElementById(fairwaysid).value;

    var girid = "txtgir"+b;
    var gir = document.getElementById(girid).value;

    var sandsavesid = "txtsandsaves"+b;
    var sandsaves = document.getElementById(sandsavesid).value;

    var upanddownsid = "txtupanddowns"+b;
    var upanddowns = document.getElementById(upanddownsid).value;

    var puttsid = "txtputts"+b;
    var putts = document.getElementById(puttsid).value;

    update_value(b,golfcourse,score,fairways,gir,sandsaves,upanddowns,putts);

    updateid = "update"+b;
    editid = "edit"+b;
    deleteid = "delete"+b;
    toggle(editid);
    toggle(deleteid);
    toggle(updateid);

    document.getElementById("golfcourse"+b).innerHTML=golfcourse;
    document.getElementById("score"+b).innerHTML=score;
    document.getElementById("fairways"+b).innerHTML=fairways;
    document.getElementById("gir"+b).innerHTML=gir;
    document.getElementById("sandsaves"+b).innerHTML=sandsaves;
    document.getElementById("upanddowns"+b).innerHTML=upanddowns;
    document.getElementById("putts"+b).innerHTML=putts;
  }

  function update_value(id,golfcourse,score,fairways,gir,sandsaves,upanddowns,putts) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "update.php?id="+id+"&golfcourse="+golfcourse+"&score="+score+"&fairways="+fairways+
      "&gir="+gir+"&sandsaves="+sandsaves+"&upanddowns="+upanddowns+"&putts="+putts+"&status=update",false);
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
    var fairways = document.getElementById("txtfairwaysins").value;
    var gir = document.getElementById("txtgirins").value;
    var sandsaves = document.getElementById("txtsandsavesins").value;
    var upanddowns = document.getElementById("txtupanddownsins").value;
    var putts = document.getElementById("txtputtsins").value;


    if (gc != "") {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.open("GET", "update.php?gc="+gc+"&score="+score+"&fairways="+fairways+"&gir="+gir+
        "&sandsaves="+sandsaves+"&upanddowns="+upanddowns+"&putts="+putts+"&status=insert",false);
      xmlhttp.send(null);
      disp_data();
    }
    else {
      alert("Must enter in golf course");
    }

    

    document.getElementById("txtgolfcourseins").value = "";
    document.getElementById("txtscoreins").value = "";
    document.getElementById("txtfairwaysins").value = "";
    document.getElementById("txtgirins").value = "";
    document.getElementById("txtsandsavesins").value = "";
    document.getElementById("txtupanddownsins").value = "";
    document.getElementById("txtputtsins").value = "";
  }

</script>

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

  <script src="js/index.js"></script>

</body>
</html>
