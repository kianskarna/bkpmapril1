<?php
//fetch.php;
if(isset($_POST["view"]))
{
  $connect =mysqli_connect('localhost','root','','testing2');
 if($_POST["view"] != '')
 {
  $update_query = "UPDATE data_permasalahan SET status_pertanyaan='0' WHERE status_pertanyaan='1'";
  mysqli_query($connect, $update_query);
 }
 session_start();
 $query = "SELECT permasalahan ,DATE_FORMAT( waktu_permasalahan, '%W, %M %e %Y %H:%i:%s' ) FROM data_permasalahan   ORDER BY waktu_permasalahan DESC";
 $result = mysqli_query($connect, $query);
 $output = '';
 
 if(mysqli_num_rows($result) > 0)
 {
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
   <li>
    <a href="data_permasalahan_bantuan.php">
    <strong>'.$row["permasalahan"].'</strong><br />
     <small><em>'.$row["DATE_FORMAT( waktu_permasalahan, '%W, %M %e %Y %H:%i:%s' )"].'</em></small>
    </a>
   </li>
   <li class="divider"></li>
   ';
  }
 }
 else
 {
  $output .= '<li><a href="#" class="text-bold text-italic">Tidak Ada Pesan Baru </a></li>
  <li><a href="data_permasalahan_bantuan.php" class="text-bold text-italic">Masuk Ke Halaman Bantuan Data Permasalahan </a></li>';
 }
 
 $query_1 = "SELECT * FROM data_permasalahan WHERE status_pertanyaan='1'";
 $result_1 = mysqli_query($connect, $query_1);
 $count = mysqli_num_rows($result_1);
 $data = array(
  'notification'   => $output,
  'unseen_notification' => $count
 );
 echo json_encode($data);
}
?>