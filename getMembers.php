<?php

include 'db.php';
/* retrieve the search term that autocomplete sends */
session_start();

$uid = $_SESSION['uid'];

if (isset($_POST["query"])) {

	$search = '%' . $_POST["query"] . '%';
	$sql = "SELECT * FROM users WHERE first LIKE ? OR last LIKE ? OR uid LIKE ?";

	$data = $pdo->prepare($sql);
	$data->bindParam(1, $search);
	$data->bindParam(2, $search);
	$data->bindParam(3, $search);
	$data->execute();

	$output = '<ul class="list-unstyled">';

	while($row = $data->fetch(PDO::FETCH_ASSOC)) {
		// use span for user id so can use in viewProfile.php

		if ($row['uid'] != $uid) {
			$output .= '<li>'.$row['first']." ".$row['last']." ".'<span id="uid">'.$row['uid'].'</span>'.'</li>';
		}
	}

	$output .= '</ul>';
	echo $output;


}

?>