
<?php
$conn = mysqli_connect("localhost", "root", "", "testing2");

$info = json_decode(file_get_contents("php://input"));
$komentar = mysqli_real_escape_string($conn, $info->komentar);
session_start();
$user_id = $_SESSION['user_id'];
date_default_timezone_set('Asia/Jakarta');
$date = date("Y-m-d H:i:s");
$query = mysqli_query($conn, "INSERT INTO forum (user_id, komentar, waktu_komentar) VALUES ('$user_id','$komentar', '$date')");
if($query) {
echo "Insert Data Successfully";
}
else {
echo "Failed";
}
 


?>
