
<?php

include('database_connection.php');
include('function.php');

if(isset($_POST['btn_action']))
{



if($_POST['btn_action'] == 'selesai')
	{
		$image = '';
		if($_FILES["user_image"]["name"] != '')
		{
			$image = upload_image();
		}
		date_default_timezone_set('Asia/Jakarta');
		$query = "
		INSERT INTO data_kegiatan_selesai (user_id, kegiatan_selesai,waktu_kegiatan_selesai,foto_kegiatan_selesai, kegiatan_dimulai_id) 
		VALUES (:user_id, :kegiatan_selesai, :waktu_kegiatan_selesai, :foto_kegiatan_selesai, :kegiatan_dimulai_id) WHERE kegiatan_dimulai_id= :kegiatan_dimulai_id
		";	
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_id'						=>	$_SESSION["user_id"],
				':kegiatan_selesai'				=>	$_POST["kegiatan_dimulai"],
				':waktu_kegiatan_selesai'		=>	date("Y-m-d h:i:s"),
				':foto_kegiatan_selesai'		=>	$image,
				
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'New User Added';
		}
	}

{

	?>