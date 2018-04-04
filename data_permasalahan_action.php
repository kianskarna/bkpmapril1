<?php

//user_action.php

include('database_connection.php');
include('function.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		date_default_timezone_set('Asia/Jakarta');
		$date = date("Y-m-d H:i:s");
		$query = "
		INSERT INTO data_permasalahan (user_id, permasalahan,waktu_permasalahan, status, status_pertanyaan, kategori) 
		VALUES (:user_id, :permasalahan, :waktu_permasalahan, :status, :status_pertanyaan, :kategori)
		";	
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_id'						=>	$_SESSION["user_id"],
				':permasalahan'					=>	$_POST["permasalahan"],
				':waktu_permasalahan'			=>	$date,
				':status'						=>	'takTerjawab',
				':status_pertanyaan'			=> '0',
				':kategori'			=> $_POST['kategori'],
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Anda Berhasil Menambahkan Permasalahan';
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
					$date = date("Y-m-d H:i:s");
					$query = "
					INSERT INTO data_solusi (permasalahan_id, user_id, solusi, waktu_solusi) VALUES ('".$_POST["permasalahan_id"]."','".$_SESSION["user_id"]."','".$_POST["solusi"]."','".$date."') 
					";
					$statement = $connect->prepare($query);
					$statement->execute();
					$result = $statement->fetchAll();
					if(isset($result))
						{
						echo 'Anda Berhasil ';
						$update = "UPDATE data_permasalahan SET status = 'terjawab' WHERE permasalahan_id ='".$_POST["permasalahan_id"]."'";

						$statement = $connect->prepare($update);
						$statement->execute();
						$result = $statement->fetchAll();
						if(isset($result)){
							echo "  Menyelesaikan Permasalahan";
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