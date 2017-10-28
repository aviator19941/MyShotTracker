<?php

include 'db.php';
/* retrieve the search term that autocomplete sends */


if (isset($_POST["query"])) {

	$search = '%' . $_POST["query"] . '%';
	$query = "SELECT * FROM users WHERE first LIKE ? OR last LIKE ?";

	$data = $pdo->prepare($query);
	$data->bindParam(1, $search);
	$data->bindParam(2, $search);
	$data->execute();

	$output = '<ul class="list-unstyled">';

	while($row = $data->fetch(PDO::FETCH_ASSOC)) {
		// use span for user id so can use in viewProfile.php
		$output .= '<li>'.$row['first']." ".$row['last']." ".'<span>'.$row['uid'].'</span>'.'</li>';
	}

	$output .= '</ul>';
	echo $output;


}

?>