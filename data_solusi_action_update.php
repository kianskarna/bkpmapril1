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
		SELECT * FROM data_solusi WHERE solusi_id = :solusi_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':solusi_id'	=>	$_POST["solusi_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['solusi'] = $row['solusi'];

		}
		echo json_encode($output);
	}
	if($_POST['btn_action'] == 'Edit')
	{

	$update = "UPDATE data_solusi SET solusi='".$_POST['solusi']."' WHERE solusi_id ='".$_POST["solusi_id"]."'";

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
		DELETE FROM data_solusi 
		WHERE solusi_id = :solusi_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':solusi_id'		=>	$_POST["solusi_id"]
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