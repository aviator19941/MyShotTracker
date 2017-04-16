<?php

include 'db.php';

$first = $_POST['first'];
$last = $_POST['last'];
$email = $_POST['email'];
$uid = $_POST['uid'];
$pwd = $_POST['pwd'];
$hash = password_hash($pwd, PASSWORD_DEFAULT);


$stmt = $pdo->prepare("INSERT INTO users set first =?, last=?, email=?, uid=?, pwd=?, hash=?");
$stmt->execute([$first, $last, $email, $uid, $pwd, $hash]);

?>