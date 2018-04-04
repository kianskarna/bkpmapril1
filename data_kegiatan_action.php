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
		INSERT INTO data_kegiatan_dimulai (user_id, kegiatan_dimulai,waktu_kegiatan_dimulai, status) 
		VALUES (:user_id, :kegiatan_dimulai, :waktu_kegiatan_dimulai, :status)
		";	
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_id'						=>	$_SESSION["user_id"],
				':kegiatan_dimulai'				=>	$_POST["kegiatan_dimulai"],
				':waktu_kegiatan_dimulai'		=>	$date,
				':status'						=>	'inactive'
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Kegiatan Berhasil ditambahkan';
		}
	}
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * FROM data_kegiatan_dimulai WHERE kegiatan_dimulai_id = :kegiatan_dimulai_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':kegiatan_dimulai_id'	=>	$_POST["kegiatan_dimulai_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['kegiatan_dimulai'] = $row['kegiatan_dimulai'];

			if($row["foto_kegiatan_dimulai"] != '')
			{
				$output['user_image'] = '<img src="upload/'.$row["foto_kegiatan_dimulai"].'" class="img-thumbnail" width="50" height="35" /><input type="hidden" name="hidden_user_image" value="'.$row["foto_kegiatan_dimulai"].'" />';
			}
			else
			{
				$output['user_image'] = '<input type="hidden" name="hidden_user_image" value="" />';
			}
			
		}
		echo json_encode($output);
	}
	if($_POST['btn_action'] == 'Edit')
	{
		// if($_FILES["user_image"]["name"] != '')
		// {
		// 	$image = upload_image();
		// }

		$cek= "
		SELECT * FROM data_kegiatan_dimulai where kegiatan_dimulai_id = '".$_POST["kegiatan_dimulai_id"]."'
		";
		$statement= $connect->prepare($cek);
		$statement->execute();
		$count =$statement->rowCount();
		if ($count > 0 ) {
			$result = $statement->fetchAll();
			foreach($result as $row)
			{
				if($row['status'] == 'inactive')
				{
					date_default_timezone_set('Asia/Jakarta');
					$date = date("Y-m-d H:i:s");
					$query = "
					INSERT INTO data_kegiatan_selesai (kegiatan_dimulai_id ,user_id,waktu_kegiatan_selesai) VALUES ('".$_POST["kegiatan_dimulai_id"]."','".$_SESSION["user_id"]."','".$date."') 
					";
					$statement = $connect->prepare($query);
					$statement->execute();
					$result = $statement->fetchAll();
					if(isset($result))
						{
						echo 'Anda Berhasil  ';
						$update = "UPDATE data_kegiatan_dimulai SET status = 'active' WHERE kegiatan_dimulai_id ='".$_POST["kegiatan_dimulai_id"]."'";

						$statement = $connect->prepare($update);
						$statement->execute();
						$result = $statement->fetchAll();
						if(isset($result)){
							echo " Menyelesaikan Kegiatan";
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