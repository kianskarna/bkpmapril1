<?php
//profile.php

include('database_connection.php');
include('function.php');

if(!isset($_SESSION['type']))
{
	header("location:login.php");
}

$query = "
SELECT * FROM user_details 
WHERE user_id = '".$_SESSION["user_id"]."'
";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$name = '';
$email = '';
$user_id = '';
foreach($result as $row)
{
	$name = $row['user_name'];
	$email = $row['user_email'];
	$no_telepon = $row['no_telepon'];
	$nama_lengkap = $row['nama_lengkap'];
}

include('header.php');

?>
		<div class="panel panel-default">
			<div class="panel-heading">Edit Profile</div>
			<div class="panel-body">
				<form method="post" id="edit_profile_form">
					<span id="message"></span>
					<div class="form-group">
						<label>Nama Lengkap</label>
						<input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="<?php echo $nama_lengkap; ?>" required />
					</div>
					<div class="form-group">
						<label>Username</label>
						<input type="text" name="user_name" id="user_name" class="form-control" value="<?php echo $name; ?>" required />
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="user_email" id="user_email" class="form-control" required value="<?php echo $email; ?>" />
					</div>
					<div class="form-group">
							<label>Provinsi</label>
    						<select name="provinsi" id="provinsi" class="form-control" required>
								<option value="">Select Category</option>
								<?php echo fill_provinsi_list($connect); ?>
							</select>
    				</div>
    				<div class="form-group">
						<label>No Telepon</label>
						<input type="text" name="no_telepon" id="no_telepon" class="form-control" required value="<?php echo $no_telepon; ?>" onkeypress="return hanyaAngka(event)"/>
					</div>
					<hr />
					<label>Leave Password blank if you do not want to change</label>
					<div class="form-group">
						<label>New Password</label>
						<input type="password" name="user_new_password" id="user_new_password" class="form-control" />
					</div>
					<div class="form-group">
						<label>Re-enter Password</label>
						<input type="password" name="user_re_enter_password" id="user_re_enter_password" class="form-control" />
						<span id="error_password"></span>	
					</div>
					<div class="form-group">
						<input type="submit" name="edit_prfile" id="edit_prfile" value="Edit" class="btn btn-info" />
					</div>
				</form>
			</div>
		</div>

<script>
$(document).ready(function(){
	$('#edit_profile_form').on('submit', function(event){
		event.preventDefault();
		if($('#user_new_password').val() != '')
		{
			if($('#user_new_password').val() != $('#user_re_enter_password').val())
			{
				$('#error_password').html('<label class="text-danger">Password Not Match</label>');
				return false;
			}
			else
			{
				$('#error_password').html('');
			}
		}
		$('#edit_prfile').attr('disabled', 'disabled');
		var form_data = $(this).serialize();
		$('#user_re_enter_password').attr('required',false);
		$.ajax({
			url:"edit_profile.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#edit_prfile').attr('disabled', false);
				$('#user_new_password').val('');
				$('#user_re_enter_password').val('');
				$('#message').html(data);
			}
		})
	});
});


function hanyaAngka(evt) {
		  var charCode = (evt.which) ? evt.which : event.keyCode
		   if (charCode > 31 && (charCode < 48 || charCode > 57))
 
		    return false;
		  return true;
		}		
</script>


			
