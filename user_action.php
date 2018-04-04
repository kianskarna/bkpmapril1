<?php

//user_action.php

include('database_connection.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO user_details (user_email, user_password, user_name, provinsi, no_telepon, user_type, user_status, nama_lengkap) 
		VALUES (:user_email, :user_password, :user_name,:provinsi, :no_telepon, :user_type, :user_status, :nama_lengkap)
		";	
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_email'		=>	$_POST["user_email"],
				':user_password'	=>	md5($_POST["user_password"]),
				':user_name'		=>	$_POST["user_name"],
				':provinsi'			=>  $_POST["provinsi"],
				':no_telepon'		=>  $_POST['no_telepon'],
				':user_type'		=>	'user',
				':nama_lengkap'		=>	$_POST['nama_lengkap'],
				':user_status'		=>	'active'
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
		SELECT * FROM user_details WHERE user_id = :user_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_id'	=>	$_POST["user_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['user_email'] = $row['user_email'];
			$output['user_name'] = $row['user_name'];
			$output['provinsi'] = $row['provinsi'];
			$output['no_telepon'] = $row['no_telepon'];
			$output['nama_lengkap'] = $row['nama_lengkap'];
		}
		echo json_encode($output);
	}
	if($_POST['btn_action'] == 'Edit')
	{
		if($_POST['user_password'] != '')
		{
			$query = "
			UPDATE user_details SET 
				user_name = '".$_POST["user_name"]."', 
				user_email = '".$_POST["user_email"]."',
				provinsi = '".$_POST["provinsi"]."', 
				no_telepon = '".$_POST["no_telepon"]."',
				nama_lengkap = '".$_POST["nama_lengkap"]."',
				user_password = '".md5($_POST["user_password"])."' 
				WHERE user_id = '".$_POST["user_id"]."'
			";
		}
		else
		{
			$query = "
			UPDATE user_details SET 
				user_name = '".$_POST["user_name"]."', 
				user_email = '".$_POST["user_email"]."',
				provinsi = '".$_POST["provinsi"]."', 
				no_telepon = '".$_POST["no_telepon"]."',
				nama_lengkap = '".$_POST["nama_lengkap"]."'
				WHERE user_id = '".$_POST["user_id"]."'
			";
		}
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'User Details Edited';
		}
	}
	if($_POST['btn_action'] == 'delete')
	{
		$status = 'Active';
		if($_POST['status'] == 'Active')
		{
			$status = 'Inactive';
		}
		$query = "
		UPDATE user_details 
		SET user_status = :user_status 
		WHERE user_id = :user_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_status'	=>	$status,
				':user_id'		=>	$_POST["user_id"]
			)
		);	
		$result = $statement->fetchAll();	
		if(isset($result))
		{
			echo 'User Status change to ' . $status;
		}
	}
}

?>