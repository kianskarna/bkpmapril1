<?php

//user_action.php

include('database_connection.php');
include('function.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		date_default_timezone_set('Asia/Jakarta');
		$query = "
		INSERT INTO data_permasalahan (user_id, permasalahan,waktu_permasalahan, status, status_pertanyaan) 
		VALUES (:user_id, :permasalahan, :waktu_permasalahan, :status, :status_pertanyaan)
		";	
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_id'						=>	$_SESSION["user_id"],
				':permasalahan'					=>	$_POST["permasalahan"],
				':waktu_permasalahan'			=>	date("Y-m-d h:i:s"),
				':status'						=>	'takTerjawab',
				':status_pertanyaan'			=> '0',
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'New User Added';
		}
	}
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * FROM data_permasalahan WHERE permasalahan_id = :permasalahan_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':permasalahan_id'	=>	$_POST["permasalahan_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['permasalahan'] = $row['permasalahan'];
			$output['kategori'] = $row['kategori'];

		}
		echo json_encode($output);
	}
	if($_POST['btn_action'] == 'Edit')
	{

	$update = "UPDATE data_permasalahan SET permasalahan='".$_POST['permasalahan']."', kategori='".$_POST['kategori']."' WHERE permasalahan_id ='".$_POST["permasalahan_id"]."'";

		$statement = $connect->prepare($update);
		$statement->execute();
		$result = $statement->fetchAll();
		if(isset($result)){
			echo " berhasil";
			}
	}


	if($_POST['btn_action'] == 'delete')
	{

		$query = "
		DELETE FROM data_permasalahan 
		WHERE permasalahan_id = :permasalahan_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':permasalahan_id'		=>	$_POST["permasalahan_id"]
			)
		);	
		$result = $statement->fetchAll();	
		if(isset($result))
		{
			echo 'Data Deleted  ';
		}
	}
}

?>