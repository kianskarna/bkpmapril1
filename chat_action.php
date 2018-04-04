<?php
//insert.php
if(isset($_POST["subject"]))
{
	session_start();
 $db =mysqli_connect('localhost','root','','testing2');
 $subject = mysqli_real_escape_string($db, $_POST["subject"]);
 $comment = mysqli_real_escape_string($db, $_POST["comment"]);
 date_default_timezone_set('Asia/Jakarta');
$date = date("Y-m-d H:i:s");
 $user_id = $_SESSION['user_id'];
 $status = 'takTerjawab';
 $status_pertanyaan = '1';
 $query = "
 INSERT INTO data_permasalahan (permasalahan, waktu_permasalahan,kategori, status, user_id, status_pertanyaan) VALUES ('$subject', '$date' ,'$comment','$status', '$user_id','$status_pertanyaan')
 ";
 mysqli_query($db, $query);

 if($query) {
 	echo "Permasalahan Anda Sedang di Proses";
 }
 else
 {
 	echo "Permasalahan anda belum di Proses";
 }
}
?>


