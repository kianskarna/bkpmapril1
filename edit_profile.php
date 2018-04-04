<?php

//edit_profile.php

include('database_connection.php');

if(isset($_POST['user_name']))
{
	if($_POST["user_new_password"] != '')
	{
		$query = "
		UPDATE user_details SET 
			user_name = '".$_POST["user_name"]."', 
			user_email = '".$_POST["user_email"]."',
			provinsi = '".$_POST["provinsi"]."',
			no_telepon = '".$_POST["no_telepon"]."' ,
			nama_lengkap = '".$_POST["nama_lengkap"]."' ,
			user_password = '".md5($_POST["user_new_password"])."' 
			WHERE user_id = '".$_SESSION["user_id"]."'
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
			WHERE user_id = '".$_SESSION["user_id"]."'
		";
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	if(isset($result))
	{
		echo '<div class="alert alert-success">Profile Edited</div>';
	}
}

?>