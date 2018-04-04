<?php
//user.php

include('database_connection.php');
include('function.php');

if(!isset($_SESSION["type"]))
{
	header('location:login.php');
}

if($_SESSION["type"] != 'master')
{
	header("location:index.php");
}

include('header.php');


?>
		<span id="alert_action"></span>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
                    <div class="panel-heading">
                    	<div class="row">
                        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                            	<h3 class="panel-title">User List</h3>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
                            	<button type="button" name="add" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-success btn-xs">Add</button>
                        	</div>
                        </div>
                       
                        <div class="clear:both"></div>
                   	</div>
                   	<div class="panel-body">
                   		<div class="row"><div class="col-sm-12 table-responsive">
                   			<table id="user_data" class="table table-bordered table-striped">
                   				<thead>
									<tr>
										<th>ID</th>
										<th>Nama Lengkap</th>
										<th>Username</th>
										<th>Email</th>
										<th>Provinsi</th>
										<th>No Telepon</th>
										<th>Status</th>
										<th>Edit</th>
										<th>Delete</th>
									</tr>
								</thead>
                   			</table>
                   		</div>
                   	</div>
               	</div>
           	</div>
        </div>
        <div id="userModal" class="modal fade">
        	<div class="modal-dialog">
        		<form method="post" id="user_form">
        			<div class="modal-content">
        			<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add User</h4>
        			</div>
        			<div class="modal-body">
        				<div class="form-group">
							<label>Nama Lengkap </label>
							<input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required />
						</div>
        				<div class="form-group">
							<label>Username</label>
							<input type="text" name="user_name" id="user_name" class="form-control" required />
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="user_email" id="user_email" class="form-control" required />
						</div>
						<div class="form-group">
							<label>Enter User Password</label>
							<input type="password" name="user_password" id="user_password" class="form-control" required />
						</div>
						<div class="form-group">
							<label>Provinsi</label>
    						<select name="provinsi" id="provinsi" class="form-control" required>
								<option value="">Select Category</option>
								<?php echo fill_provinsi_list($connect); ?>
							</select>
    					</div>
			            <div class="form-group">
			            	<label>No telepon</label>
			            	<input type="text" name="no_telepon" id="no_telepon" class="form-control" required="" onkeypress="return hanyaAngka(event)">
			            </div>
        			</div>
        			<div class="modal-footer">
        				<input type="hidden" name="user_id" id="user_id" />
        				<input type="hidden" name="btn_action" id="btn_action" />
        				<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
        				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        			</div>
        		</div>
        		</form>

        	</div>
        </div>
<script>
$(document).ready(function(){

	$('#add_button').click(function(){
		$('#user_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add User");
		$('#action').val("Add");
		$('#btn_action').val("Add");
	});

	

	var userdataTable = $('#user_data').DataTable({
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax":{
			url:"user_fetch_helpdesk.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"target":[4,5],
				"orderable":false
			}
		],
		"pageLength": 25
	});

	$(document).on('submit', '#user_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url:"user_action_helpdesk.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#user_form')[0].reset();
				$('#userModal').modal('hide');
				$('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
				$('#action').attr('disabled', false);
				userdataTable.ajax.reload();
			}
		})
	});

	$(document).on('click', '.update', function(){
		var user_id = $(this).attr("id");
		var btn_action = 'fetch_single';
		$.ajax({
			url:"user_action_helpdesk.php",
			method:"POST",
			data:{user_id:user_id, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				$('#userModal').modal('show');
				$('#user_name').val(data.user_name);
				$('#nama_lengkap').val(data.nama_lengkap);
				$('#user_email').val(data.user_email);
				$('#provinsi').val(data.provinsi);
				$('#no_telepon').val(data.no_telepon);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit User");
				$('#user_id').val(user_id);
				$('#action').val('Edit');
				$('#btn_action').val('Edit');
				$('#user_password').attr('required', false);
			}
		})
	});

	$(document).on('click', '.delete', function(){
		var user_id = $(this).attr("id");
		var status = $(this).data('status');
		var btn_action = "delete";
		if(confirm("Are you sure you want to change status?"))
		{
			$.ajax({
				url:"user_action_helpdesk.php",
				method:"POST",
				data:{user_id:user_id, status:status, btn_action:btn_action},
				success:function(data)
				{
					$('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
					userdataTable.ajax.reload();
				}
			})
		}
		else
		{
			return false;
		}
	});

});




	function hanyaAngka(evt) {
		  var charCode = (evt.which) ? evt.which : event.keyCode
		   if (charCode > 31 && (charCode < 48 || charCode > 57))
 
		    return false;
		  return true;
		}		
</script>

<?php
include('footer.php');
?>
