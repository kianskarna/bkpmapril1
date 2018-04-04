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
		INSERT INTO data_permasalahan (user_id, permasalahan,waktu_permasalahan, status) 
		VALUES (:user_id, :permasalahan, :waktu_permasalahan, :status)
		";	
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_id'						=>	$_SESSION["user_id"],
				':permasalahan'					=>	$_POST["permasalahan"],
				':waktu_permasalahan'			=>	date("Y-m-d h:i:s"),
				':status'						=>	'takTerjawab'
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

		}
		echo json_encode($output);
	}
	if($_POST['btn_action'] == 'Edit')
	{

		$cek= "
		SELECT * FROM data_permasalahan where permasalahan_id = '".$_POST["permasalahan_id"]."'
		";
		$statement= $connect->prepare($cek);
		$statement->execute();
		$count =$statement->rowCount();
		if ($count > 0 ) {
			$result = $statement->fetchAll();
			foreach($result as $row)
			{
				if($row['status'] == 'takTerjawab')
				{
					date_default_timezone_set('Asia/Jakarta');
					$query = "
					INSERT INTO data_solusi (permasalahan_id, user_id, solusi, waktu_solusi) VALUES ('".$_POST["permasalahan_id"]."','".$_SESSION["user_id"]."','".$_POST["solusi"]."','".date("Y-m-d h:i:s")."') 
					";
					$statement = $connect->prepare($query);
					$statement->execute();
					$result = $statement->fetchAll();
					if(isset($result))
						{
						echo 'Anda Berhasil Menyelesaikan Kegiatan';
						$update = "UPDATE data_permasalahan SET status = 'terjawab' WHERE permasalahan_id ='".$_POST["permasalahan_id"]."'";

						$statement = $connect->prepare($update);
						$statement->execute();
						$result = $statement->fetchAll();
						if(isset($result)){
							echo " berhasil";
							}
					}
				
				}

				else
				{
					echo "Anda Sudah Menyelesaikan Kegiatan";
				}
			}
		}
	}



	






	if($_POST['btn_action'] == 'delete')
	{

		$query = "
		DELETE FROM data_kegiatan_dimulai 
		WHERE kegiatan_dimulai_id = :kegiatan_dimulai_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':kegiatan_dimulai_id'		=>	$_POST["kegiatan_dimulai_id"]
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