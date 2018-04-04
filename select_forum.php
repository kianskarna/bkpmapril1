<?php

$conn = mysqli_connect("localhost", "root", "", "testing2");

$output = array();
$query = mysqli_query($conn, "SELECT * FROM forum INNER JOIN user_details ON forum.user_id=user_details.user_id ORDER BY waktu_komentar DESC");
if (mysqli_num_rows($query) > 0 ) {
	while ($row = mysqli_fetch_array($query)) {
		$output[] = $row;
		
	}
	echo json_encode($output);
}


?>